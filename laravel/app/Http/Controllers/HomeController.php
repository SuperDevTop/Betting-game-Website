<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\LoginIp;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect("crash_game_play");
    }

    public function logout(){
        Auth::logout();
        \Session::flush();
        return redirect("/");
    }

    public function profile()
    {
        return view("profile.edit");
    }

    public function profile_edit(Request $request)
    {
        $rules = array(
            'full_name'      => 'required',
            'phone'      => 'required',
            'password'      => 'required|confirmed|min:6',
            'email'         => 'required|email|unique:users,email,'.Auth::user()->id,
        );

        $messsages = array(
            'full_name.required'=>'campo nome completo é obrigatório.',
            'phone.required'=>'campo telefone é obrigatório.',
            'email.email'=>'campo de e-mail deve ser um endereço válido.',
            'email.unique' => 'este e-mail já é usado.',
            'email.required' => 'campo de e-mail é obrigatório',
            'password.required' => 'campo de senha é obrigatório',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.'
        );

        $validator = Validator::make($request->all(), $rules, $messsages)->validate();

        $user = Auth::user();
        $user->full_name = $request['full_name'];
        $user->email = $request['email'];
        $user->phone = $request['phone'];
        $user->password = md5($request['password']);
        $user->save();

        return redirect("/profile");

    }
    public function blocked_page()
    {
        if (Auth::user()->status == 'active') return redirect("crash_game_play");
        return view("block");
    }
    public function login_ip_history()
    {
        $ips = LoginIp::where("user_id", Auth::user()->id)->orderBy("created_at", "desc")->get();
        return view("ip.login_ip")->with("ips", $ips);
    }
}
