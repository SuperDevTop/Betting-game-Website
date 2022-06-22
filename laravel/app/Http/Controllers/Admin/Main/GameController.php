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

class GameController extends Controller
{
    public function GameListView(){
        $games = CrashGame::orderBy("created_at", "desc")->get();
        $game_cnt = CrashGame::count();
        $game_total_amount = CrashGame::sum("total_amount");
        $game_total_win_amount = CrashGame::sum("total_win_amount");
        
        
        return view("admin.game.list")->with("games", $games)
                                      ->with("game_cnt", $game_cnt)
                                      ->with("game_total_amount", $game_total_amount)
                                      ->with("game_total_win_amount", $game_total_win_amount);
    }
    public function GameBettingsList($id)
    {

        $game_obj = CrashGame::where("id", $id)->first();

        $bettings = CrashBetting::leftJoin("users","crash_bettings.user_id","=","users.id")
                                ->where("crash_bettings.game_id", $id)
                                ->select("crash_bettings.*", "users.full_name")
                                ->get();

        return view("admin.game.bettinglist")->with("game", $game_obj)
                                             ->with("bettings", $bettings);
    }
}
