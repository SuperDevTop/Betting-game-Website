<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordEmail;
use App\User;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function sendResetLinkEmail(Request $request)
    {
        $user = User::where("email", $request['email'])->first();
        
        
        
        if ($user)
        {
            $user->email_token = csrf_token();
            $user->save();

            Mail::to($request['email'])->send(new ForgotPasswordEmail($user->email_token, "Redefinir senha", "no-reply@millionrocket.com", "MillionRocket"));

            return redirect()->back()->withErrors(["success"=>"Enviamos o link de redefinição de senha para o seu e-mail.<br/>Por favor, verifique sua conta de e-mail.<br/>Se você não conseguir encontrar o e-mail na caixa de entrada, verifique sua pasta de spam."]);
        }
        else
        {
            return redirect()->back()->withErrors(["email"=>"Não conseguimos encontrar um usuário com esse endereço de e-mail."]);
        }
    }
}
