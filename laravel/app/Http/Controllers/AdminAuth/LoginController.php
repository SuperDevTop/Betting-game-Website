<?php

namespace App\Http\Controllers\AdminAuth;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;

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

    use AuthenticatesUsers, LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Check admin user credential with active state (Overriding credential function)
     *
     *  @param  Request $request [description]
     *  @return array
     */
    protected function credentials(Request $request)
    {
        return array_merge(
            $request->only($this->username(), 'password'),
            ['status' => Admin::STATE_ACTIVE]
        );
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

        if ( Auth::guard('admin')->attempt(["email"=>$request['email'],"password"=>$request['password']], $request['remember']) || 
                Auth::attempt(["email"=>$request['email'],"password"=>$request['password']], $request['remember']) ) {
            
            return redirect()->intended('admin/home');
        }

        return redirect()->back()->withErrors(["email"=>"Esta credencial não corresponde em nossos registros."]);
    }
}
