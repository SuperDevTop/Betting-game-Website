<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\LoginIp;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }


    public function login(Request $request){

        $rules = array(
            'email'     => 'required|email',
            'password'      => 'required|min:6'
        );

        $messsages = array(
            'email.email'=>'campo de e-mail deve ser um endereço válido.',
            'email.required' => 'campo de e-mail é obrigatório',
            'password.required' => 'campo de senha é obrigatório',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.'
        );


        $validator = Validator::make($request->all(), $rules, $messsages)->validate();

        $user = User::where("email", $request['email'])->first();

        if (!$user) 
            return redirect()->back()->withErrors(["email"=>"Esta credencial não corresponde em nossos registros."]);

        if ($user->password == md5($request['password']))
        {
            Auth::login($user, $request['remember']);
            $ip = new LoginIp();
            $ip->user_id = $user->id;
            $ip->ip = request()->ip();
            $ip->save();
            return redirect()->intended('home');
        }
        
        

        return redirect()->back()->withErrors(["email"=>"Esta credencial não corresponde em nossos registros."]);
    }
}
