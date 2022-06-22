<?php

namespace App\Http\Controllers\CrashGame;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\CrashGame;
use App\CrashBetting;
use App\Events\CrashGamePlace;

class HistoryController extends Controller
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
    public function crash_game_history()
    {
        $games = CrashBetting::leftJoin("crash_games", "crash_bettings.game_id", "=", "crash_games.id")
                             ->where("crash_bettings.user_id", Auth::user()->id)
                             ->orderBy("updated_at","desc")
                             ->select("crash_bettings.game_id", "crash_games.crash_point", "crash_games.crash_time", "crash_bettings.user_bet_amount", "crash_bettings.user_betting_point", "crash_bettings.user_earning", "crash_bettings.updated_at")
                             ->get();

        $total_bet_amount = CrashBetting::where("user_id", Auth::user()->id)->sum("user_bet_amount");
        $total_earning = CrashBetting::where("user_id", Auth::user()->id)->sum("user_earning");
        $total_bet_count = CrashBetting::where("user_id", Auth::user()->id)->count();
        $total_bet_win = CrashBetting::where("user_id", Auth::user()->id)->
                         where("user_earning", "!=", 0)->count();


        return view("crash_game.history")->with("games", $games)
                                         ->with("total_bet_amount", $total_bet_amount)
                                         ->with("total_earning", $total_earning)
                                         ->with("total_bet_count", $total_bet_count)
                                         ->with("total_bet_win", $total_bet_win);
    }
}
