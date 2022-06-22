<?php

namespace App\Http\Controllers\Admin\Main;

use App\User;
use App\Role;
use App\Admin;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\CrashBetting;
use App\CrashGame;
use App\Transaction;
use App\Withdraw;

class TransactionController extends Controller
{
    public function DepositHistory(){

        $transactions = Transaction::leftJoin("users", "transactions.to", "=", "users.id")
                                   ->where("transactions.type", "deposit")
                                   ->orderBy("transactions.created_at", "desc")
                                   ->select("transactions.*", "users.full_name")
                                   ->get();
        $total_transaction = Transaction::where("type", "deposit")->sum("amount");

        return view("admin.transaction.deposit_history")->with("transactions", $transactions)
                                                        ->with("total_transaction", $total_transaction);
    }
    public function PendingWithdrawHistory()
    {
        $withdraws = Withdraw::where("status", "pending")->get();
        return view("admin.transaction.pending_withdraw_list")->with("withdraws", $withdraws);
    }
    public function PaidWithdrawHistory()
    {
        $withdraws = Withdraw::where("status", "success")->get();
        return view("admin.transaction.success_withdraw_list")->with("withdraws", $withdraws);
    }
    public function PayWithdrawPost(Request $request)
    {
        $withdraw = Withdraw::where("id", $request['id'])->first();
        $withdraw->status = "success";
        $withdraw->paid_amount = $request['amount'];
        $withdraw->fee = $withdraw->requested_amount - $request['amount'];
        $withdraw->proceed_by = 1;
        $withdraw->save();

        return redirect("admin/PaidWithdrawHistory");
    }
    public function delete_withdraw_request(Request $request)
    {
        Withdraw::whereIn("id", $request['ids'])->delete();
        return json_encode("success");
    }
}
