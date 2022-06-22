<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\User;
use App\Transaction;
use App\Withdraw;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function deposit()
    {
        return view("transaction.deposit");
    }
    public function deposit_status()
    {
        $dados = \Session::get('dados');

        return view("transaction.deposit_status")->with("dados", $dados);
    }
    public function deposit_status_post(Request $request)
    {

        $order_id = $request['order_id'];

        $curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => "https://api.iugu.com/v1/invoices/$order_id?api_token=6297E4F97C50820D9BFA12DC87B70E4055626EB6AF889F1177CA758D55726B1D",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => [
            "Accept: application/json"
          ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) 
        {
          
        } 
        else 
        {
            $dados = json_decode($response,true);

            if($dados['status'] == 'paid')
            {

                $transaction = Transaction::where("transaction_id", $request['order_id'])->first();
                if ($transaction && $transaction->status != "complete")
                {
                    $transaction->status = "complete";
                    $transaction->save();

                    $amount = $transaction->amount;

                    $user = Auth::user();
                    $user->balance += $amount;
                    $user->save();

                /*  adding money to affiliate user(advertiser)  */

                
                    $advertiser = User::where("id", Auth::user()->affiliate_id)->first();
                    if ($advertiser)
                    {
                        $affi_transaction = Transaction::where("type", "affiliate")
                                                       ->where("transaction_id", $transaction->id)
                                                       ->first();
                                                       
                        $affi_transaction->status = "complete";
                        $affi_transaction->save();

                        $advertiser->balance += $affi_transaction->amount;
                        $advertiser->referral_earning += $affi_transaction->amount;
                        $advertiser->save();
                    }
                    return "paid";
                }
            }
        }
        return "pending";
    }
    public function deposit_post(Request $request)
    {
        $return_url = url('/deposit_success_view');
        $notification_url = url('/deposit_success_view');

        $amount = $request['amount']."00";
        $cpf = $request['cpf'];
        $name = $request['name'];
        $time_now = date("Y-m-d");
        $email = Auth::user()->email;

        $transaction = new Transaction();
        $transaction->type = "deposit";
        $transaction->from = "iugu";
        $transaction->to = Auth::user()->id;
        $transaction->amount = $request['amount'];
        $transaction->transaction_id = "anyonimousxxx-xxxx";
        $transaction->status = "pending";
        $transaction->save();


        $advertiser = User::where("id", Auth::user()->affiliate_id)->first();
        if ($advertiser)
        {
            $percent = $advertiser->referral_rate;
            $referral_bonus = $amount * $percent / 100;

            $affi_transaction = new Transaction();
            $affi_transaction->type = "affiliate";
            $affi_transaction->from = Auth::user()->id;
            $affi_transaction->to = Auth::user()->affiliate_id;
            $affi_transaction->amount = round($referral_bonus, 2);
            $affi_transaction->transaction_id = $transaction->id;
            $affi_transaction->status = "pending";
            $affi_transaction->save();
        }



        $order_id = md5(Auth::user()->id."_".strtotime(date("Y-m-d h:i:s")));

        $ch = curl_init();

        curl_setopt_array($ch, [
          CURLOPT_URL => "https://api.iugu.com/v1/invoices?api_token=6297E4F97C50820D9BFA12DC87B70E4055626EB6AF889F1177CA758D55726B1D",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "{\"ensure_workday_due_date\":false,\"items\":[{\"description\":\"Deposito\",\"quantity\":1,\"price_cents\":$amount}],\"payable_with\":[\"pix\"],\"payer\":{\"cpf_cnpj\":\"$cpf\",\"name\":\"$name\"},\"email\":\"$email\",\"due_date\":\"$time_now\",\"return_url\":\"$return_url\",\"notification_url\":\"$notification_url\",\"order_id\":\"$order_id\"}",
          CURLOPT_HTTPHEADER => [
            "Accept: application/json",
            "Content-Type: application/json"
          ],
        ]);
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if($err){
            return redirect("deposit_error_view");
        }else{  
            $dados = json_decode($response,true);
            //dd($dados);
            if($dados != null){
                $transaction_obj = Transaction::where("id", $transaction->id)->first();
                $transaction_obj->transaction_id = $dados['id'];
                $transaction_obj->save();

                \Session::put("dados", $dados);

                return redirect("deposit_status");
            }
        }

        return redirect("deposit");

        //return redirect("deposit_success_view");
    }
    public function deposit_success_view()
    {
        return view("success.deposit");
    }
    public function deposit_error_view()
    {
        return view("error.deposit");
    }
    public function transaction_history()
    {
        $transactions = Transaction::where("type", "deposit")
                                   ->where("to", Auth::user()->id)
                                   ->orderBy("created_at", "desc")
                                   ->get();

        $total_deposit_amount = Transaction::where("type", "deposit")
                                   ->where("to", Auth::user()->id)
                                   ->where("status", "complete")
                                   ->sum("amount");

        return view("transaction.history")->with("transactions", $transactions)
                                          ->with("total_deposit_amount", $total_deposit_amount);
    }
    public function withdraw()
    {
        return view("transaction.withdraw");
    }
    public function withdraw_request_post(Request $request)
    {
        $rules = array(
            'name'      => 'required',
            'cpf'      => 'required',
            'bank'      => 'required',
            'agency'      => 'required',
            'account_type'      => 'required',
            'account'      => 'required',
            'amount'      => 'required|numeric|min:20'
        );

        $messsages = array(
            'name.required'=>'O campo nome completo é obrigatório.',
            'cpf.required'=>'campo cpf é obrigatório.',
            'bank.required'=>'campo do banco é obrigatório.',
            'agency.required'=>'campo agência é obrigatório.',
            'account_type.required'=>'campo tipo de conta é obrigatório.',
            'account.required'=>'campo conta é obrigatório.',
            'amount.required'=>'campo valor é obrigatório.',
            'amount.numeric'=>'campo de valor deve ser numérico',
            'amount.min'=>'valor deve ser superior a R$ 20.'
        );

        $validator = Validator::make($request->all(), $rules, $messsages)->validate();      

        if (Auth::user()->balance < $request['amount'])
            return redirect()->back()->withErrors(["amount"=>"Você não tem saldo suficiente para sacar."]);

        $withdraw = new Withdraw();
        $withdraw->user_id = Auth::user()->id;
        $withdraw->full_name = $request['name'];
        $withdraw->cpf = $request['cpf'];
        $withdraw->bank = $request['bank'];
        $withdraw->agency = $request['agency'];
        $withdraw->account_type = $request['account_type'];
        $withdraw->account = $request['account'];
        $withdraw->requested_amount = $request['amount'];
        $withdraw->status = "pending";
        $withdraw->save();

        $user = Auth::user();
        $user->balance = $user->balance - $withdraw->requested_amount;
        $user->save();

        return redirect("withdraw_pending_history");
    }
    public function withdraw_pending_history()
    {
        $withdraws = Withdraw::leftJoin("admins", "withdraws.proceed_by", "=", "admins.id")
                             ->where("withdraws.status", "pending")
                             ->where("withdraws.user_id", Auth::user()->id)
                             ->select("withdraws.*", "admins.name")
                             ->orderBy("withdraws.created_at", "desc")
                             ->get();

        return view("transaction.withdraw_pending_history")->with("withdraws", $withdraws);
    }
    public function withdraw_success_history()
    {
        $withdraws = Withdraw::leftJoin("admins", "withdraws.proceed_by", "=", "admins.id")
                             ->where("withdraws.status", "success")
                             ->where("withdraws.user_id", Auth::user()->id)
                             ->select("withdraws.*", "admins.name")
                             ->orderBy("withdraws.created_at", "desc")
                             ->get();

        return view("transaction.withdraw_success_history")->with("withdraws", $withdraws);
    }
    public function cancel_withdraw($id)
    {
        $withdraw = Withdraw::where("id", $id)->where("user_id", Auth::user()->id)
                                              ->first();

        if ($withdraw)
        {
            $user = Auth::user();
            $user->balance += (float)$withdraw->requested_amount;
            $user->save();

            Withdraw::where("id", $id)->delete();
        }

        return redirect()->back();
    }
}
