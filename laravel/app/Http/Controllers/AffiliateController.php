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


class AffiliateController extends Controller
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

    public function affiliate_link()
    {
        $affiliate_link = url('')."/affiliate/".$this->getEncryptionValue(Auth::user()->id);
        return view("affiliate.link")->with("affiliate_link", $affiliate_link);
    }
    public function affiliate_user_list_view()
    {
        $referral_users = User::where("affiliate_id", Auth::user()->id)
                              ->orderBy("created_at", "desc")
                              ->get();
        return view("affiliate.referral_user_list")->with("referral_users", $referral_users);
    }
    public function affiliate_earning()
    {
        $affi_earnings = Transaction::leftJoin("users", "transactions.from", "=", "users.id")
                                   ->where("transactions.type", "affiliate")
                                   ->where("transactions.to", Auth::user()->id)
                                   ->orderBy("transactions.created_at", "desc")
                                   ->select("transactions.*", "users.full_name")
                                   ->get();

        $affi_earning_total = Transaction::where("type", "affiliate")
                                   ->where("to", Auth::user()->id)
                                   ->sum('amount');

        return view("affiliate.affiliate_earning")->with("affi_earnings", $affi_earnings)
                                                  ->with("affi_earning_total", $affi_earning_total);
    }
}
