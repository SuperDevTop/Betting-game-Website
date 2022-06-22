<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function reset(Request $request){

        $rules = array(
            'password'      => 'required|confirmed|min:6',
            'email'         => 'required|email',
        );

        $messsages = array(
            'email.email'=>'campo de e-mail deve ser um endereço válido.',
            'email.required' => 'campo de e-mail é obrigatório',
            'password.required' => 'campo de senha é obrigatório',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
        );

        $validator = Validator::make($request->all(), $rules, $messsages)->validate();

        $user_obj = User::where("email", $request['email'])->first();
        if (!$user_obj)
            return redirect()->back()->withErrors(["email"=>"Não conseguimos encontrar um usuário com esse endereço de e-mail."]);

        $user_obj = User::where("email_token", $request['token'])->first();
        if (!$user_obj || ($user_obj && $user_obj->email != $request['email']))
            return redirect()->back()->withErrors(["email"=>"Este token de redefinição de senha é inválido."]);

        $user_obj->password = md5($request['password']);
        $user_obj->save();

        return redirect("login");
    }
}
