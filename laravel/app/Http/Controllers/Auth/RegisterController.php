<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function register(Request $request){
        $rules = array(
            'full_name'      => 'required',
            'phone'      => 'required',
            'password'      => 'required|confirmed|min:6',
            'email'         => 'required|email|unique:users',
            'terms'      => 'required'
        );

        $messsages = array(
            'full_name.required'=>'campo nome completo é obrigatório.',
            'phone.required'=>'campo telefone é obrigatório.',
            'email.email'=>'campo de e-mail deve ser um endereço válido.',
            'email.unique' => 'este e-mail já é usado.',
            'email.required' => 'campo de e-mail é obrigatório',
            'password.required' => 'campo de senha é obrigatório',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'terms.required' => 'campo termos é obrigatório.'
        );

        $validator = Validator::make($request->all(), $rules, $messsages)->validate();

        $user = new User();
        $user->full_name = $request['full_name'];
        $user->phone = $request['phone'];
        $user->email = $request['email'];
        $user->password = md5($request['password']);
        $user->email_token = csrf_token();
        $user->balance = 0;
        $user->affiliate_id = $this->getDecryptionValue($request['id']);
        $user->referral_rate = 0;
        $user->referral_users = 0;
        $user->referral_earning = 0;
        $user->status = "active";
        $user->save();

        $advertiser = User::where("id", $this->getDecryptionValue($request['id']))->first();
        if ($advertiser)
        {
            $advertiser->referral_users += 1;
            $advertiser->save();
        } 

        //Mail::to($user->email)->send(new EmailVerifyMail($user->email_token, "Email verify", "Craadmin@gmail.com", "Cannabis review au")); 
        
    
        
        return redirect("login");
    }
}
