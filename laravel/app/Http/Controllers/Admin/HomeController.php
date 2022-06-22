<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Role;
use App\Admin;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\CrashBetting;
use App\CrashGame;
use App\Commission;
use App\Transaction;

class HomeController extends Controller
{
    public function index()
    {
        $user_cnt = User::count();
        $game_cnt = CrashGame::count();
        $total_betting_amount = CrashGame::sum("total_amount");
        $total_win_amount = CrashGame::sum("total_win_amount");
        $total_deposit_amount = Transaction::where("type", "deposit")->where("status","complete")->sum("amount");
        $affiliate_amount = Transaction::where("type", "affiliate")->where("status","complete")->sum("amount");
        

        return view('admin.home')->with("user_cnt", $user_cnt)
                                 ->with("game_cnt", $game_cnt)
                                 ->with("total_betting_amount", $total_betting_amount)
                                 ->with("total_win_amount", $total_win_amount)
                                 ->with("total_deposit_amount", $total_deposit_amount)
                                 ->with("affiliate_amount", $affiliate_amount);
    }
    public function logout(){
        Auth::logout();
        \Session::flush();
        return redirect("admin/");
    }
    public function ProfileView()
    {
        return view("admin.profile.viewprofile");
    }
    public function EditProfileView()
    {
        return view("admin.profile.editprofile");
    }
    public function EditProfilePost(Request $request)
    {
        $rules = array(
            'name'     => 'required',
            'password'      => 'required|confirmed|min:6',
            'email'         => 'required|email|unique:admins,email,'.Auth::user()->id,
        );

        $messsages = array(
            'name.required'=>'campo nome completo é obrigatório.',
            'email.email'=>'campo de e-mail deve ser um endereço válido.',
            'email.unique' => 'este e-mail já é usado.',
            'email.required' => 'campo de e-mail é obrigatório',
            'password.required' => 'campo de senha é obrigatório',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
        );
        
        

        $validator = Validator::make($request->all(), $rules, $messsages)->validate();

        $admin = Auth::user();
        $admin->name = $request['name'];
        $admin->email = $request['email'];
        $admin->phone = $request['phone'];
        if ($request['password'] != "******")
            $admin->password = bcrypt($request['password']);
        $admin->save();

        return redirect("admin/ProfileView");
    }
    public function CommissionSettingView()
    {
        $division_comm = Commission::where("type", "division")->first();
        $affiliate_comm = Commission::where("type", "affiliate")->first();

        return view("admin.commission.edit")->with("d_c", $division_comm->percentage)
                                            ->with("a_c", $affiliate_comm->percentage);
    }
    public function SetCommission(Request $request)
    {
        $division_comm = Commission::where("type", "division")->first();
        $division_comm->percentage = $request['division_percentage_admin'];
        $division_comm->save();

        $affiliate_comm = Commission::where("type", "affiliate")->first();
        $affiliate_comm->percentage = $request['affiliate_percentage_admin'];
        $affiliate_comm->save();

        return redirect()->back();
    }
}
