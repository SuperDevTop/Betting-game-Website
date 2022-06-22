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

class UserController extends Controller
{
    public function UserListView(){

        $users = User::where("status", "active")->get();
        return view("admin.user.list")->with("users", $users);
    }
    public function BlockUser($id)
    {
        $user = User::where("id", $id)->first();
        $user->status = "blocked";
        $user->save();

        return redirect()->back();
    }

    public function SpamListView(){

        $users = User::where("status", "blocked")->get();
        return view("admin.user.spamlist")->with("users", $users);
    }
    public function ActiveUser($id)
    {
        $user = User::where("id", $id)->first();
        $user->status = "active";
        $user->save();

        return redirect()->back();
    }

    public function UserCrashGames($id)
    {
        $user_crash_games = CrashBetting::leftJoin("crash_games", "crash_bettings.game_id", "=", "crash_games.id")
                                        ->where("crash_bettings.user_id", $id)
                                        ->orderBy("crash_games.id", "desc")
                                        ->select("crash_bettings.*", "crash_games.crash_point", "crash_games.crash_time")
                                        ->get();

        

        $user_crash_game_cnt = CrashBetting::leftJoin("crash_games", "crash_bettings.game_id", "=", "crash_games.id")
                                           ->where("crash_bettings.user_id", $id)
                                           ->count();

        $user_crash_game_win_cnt = CrashBetting::leftJoin("crash_games", "crash_bettings.game_id", "=", "crash_games.id")
                                               ->where("crash_bettings.user_id", $id)
                                               ->where("crash_bettings.user_earning", "!=", 0)
                                               ->count();

        $user_crash_game_total_amount = CrashBetting::leftJoin("crash_games", "crash_bettings.game_id", "=", "crash_games.id")
                                                    ->where("crash_bettings.user_id", $id)
                                                    ->sum("crash_bettings.user_bet_amount");
        $user_crash_game_total_win_amount = CrashBetting::leftJoin("crash_games", "crash_bettings.game_id", "=", "crash_games.id")
                                                        ->where("crash_bettings.user_id", $id)->where("crash_bettings.user_earning", "!=", 0)
                                                        ->sum("crash_bettings.user_earning");


        $user = User::where("id", $id)->first();


        return view("admin.user.games")->with("games", $user_crash_games)
                                       ->with("user_crash_game_cnt", $user_crash_game_cnt)
                                       ->with("user_crash_game_win_cnt", $user_crash_game_win_cnt)
                                       ->with("user_crash_game_total_amount", $user_crash_game_total_amount)
                                       ->with("user_crash_game_total_win_amount", $user_crash_game_total_win_amount)
                                       ->with("user_name", $user->full_name);
    }
    public function SetReferralRate(Request $request)
    {
        $user = User::where("id", $request['id'])->first();
        $user->referral_rate = $request['referral_rate'];
        $user->save();

        return json_encode(array("message"=>"sucesss"));
    }
    public function ReferralUserListView($id)
    {
        $user_obj = User::where("id", $id)->first();
        $users = User::where("affiliate_id", $id)->orderBy("created_at", "desc")->get();
        return view("admin.user.referral_users_list")->with("users", $users)
                                                     ->with("advertiser_name", $user_obj->full_name);
    }
    public function EditUserBalance(Request $request)
    {
        $user = User::where("id", $request['id'])->first();
        $user->balance = $request['balance'];
        $user->save();

        return json_encode(array("message"=>"sucesss"));
    }
    public function LoginUser($id)
    {
        $auth = Auth::guard('web');
        $auth->logout();
        \Session::flush();

        $auth->loginUsingId($id);

        return redirect("/crash_game_play");
    }
}
