<?php

namespace App\Http\Controllers\CrashGame;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\CrashGame;
use App\CrashBetting;
use App\Events\CrashGamePlace;
use App\Transaction;

class GameController extends Controller
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

    public function crash_game_play()
    {
        return view("crash_game.play_game");

    }
    public function get_crash_game_status()
    {

        $current_game = CrashGame::orderBy("id", "desc")->first();
        $past_games = CrashGame::orderBy("id", "desc")->where("status","finish")->take(15)->select("crash_point")->get();
        $array = ["time"=>"0", "status"=>"nothing", "lastgames"=>$past_games];

        if ($current_game)
        {
            $time = strtotime(date("Y-m-d H:i:s")) - strtotime($current_game->created_at);

            $array = ["time"=>$time, "status"=>$current_game->status, "lastgames"=>$past_games];
        }

        return json_encode($array);
    }
    public function sendBettingList($game_obj)
    {
        $placed_list = CrashBetting::leftJoin("users", "crash_bettings.user_id","=","users.id")
                    ->where("game_id", $game_obj->id)
                    ->orderBy("user_bet_amount","desc")
                    ->select("users.full_name", "crash_bettings.user_bet_amount", "crash_bettings.user_betting_point", "crash_bettings.user_earning")
                    ->take(10)
                    ->get();
        $count_placed = CrashBetting::where("game_id", $game_obj->id)->count();
        $total_amount_placed = CrashBetting::where("game_id", $game_obj->id)->sum("user_bet_amount");

        event( new CrashGamePlace(array("place_list"=>$placed_list, "count"=>$count_placed, "total_amount"=>$total_amount_placed) ) );
    }
    public function place_crash_game(Request $request)
    {
        $response = [];
        $current_game_obj = CrashGame::orderBy("id", "desc")->first();

        $is_alrady_bet = CrashBetting::where("game_id", $current_game_obj->id)
                                     ->where("user_id", Auth::user()->id)
                                     ->first();
        if ($is_alrady_bet)
        {
            return json_encode(array("message"=>"already placed", "balance"=>Auth::user()->balance));
        }

        if (Auth::user()->balance - $request['amount'] < 0)
        {
            return json_encode(array("message"=>"no enough money", "balance"=>Auth::user()->balance));
        }

        $betting = new CrashBetting();
        $betting->game_id = $current_game_obj->id;
        $betting->user_id = Auth::user()->id;
        $betting->user_betting_point = 0;
        $betting->user_bet_amount = $request['amount'];
        $betting->user_earning = 0;
        $betting->save();

        $current_game_obj->total_user += 1;
        $current_game_obj->total_amount += $request['amount'];
        $current_game_obj->save();

        $transaction = new Transaction();
        $transaction->type = "game";
        $transaction->from = "crash";
        $transaction->to = Auth::user()->id;
        $transaction->amount = (-1) * $request['amount'];
        $transaction->transaction_id = $current_game_obj->id;
        $transaction->status = "complete";
        $transaction->save();

        $user = Auth::user();
        $user->balance -= $request['amount'];
        $user->save();

        //// getting list and total amount and user count

        $this->sendBettingList($current_game_obj);

        /////
        

        $response = array("message"=>"success", "balance"=>Auth::user()->balance);
        
        return json_encode(array("message"=>"success", "balance"=>Auth::user()->balance));
    }
    public function bet_crash_game(Request $request)
    {

        $current_game_obj = CrashGame::orderBy("id", "desc")->first();

        

        $betting = CrashBetting::where("game_id", $current_game_obj->id)
                              ->where("user_id", Auth::user()->id)
                              ->first();

        if ($betting && $betting->user_earning != 0)
        {
            return json_encode(array("message" => "already betted", "earning" => $betting->user_earning, "balance"=>Auth::user()->balance));
        }

        $earning = round($request['betting_point'] * $betting->user_bet_amount , 2);

        $betting->user_betting_point = $request['betting_point'];
        $betting->user_earning = $earning;
        $betting->save();

        $current_game_obj->total_win += 1;
        $current_game_obj->total_win_amount += $earning;

        $current_game_obj->save();


        $transaction = new Transaction();
        $transaction->type = "game";
        $transaction->from = "crash";
        $transaction->to = Auth::user()->id;
        $transaction->amount = $earning;
        $transaction->transaction_id = $current_game_obj->id;
        $transaction->status = "complete";
        $transaction->save();


        $user = Auth::user();
        $user->balance += $earning;
        $user->save();

        //// getting list and total amount and user count

        $this->sendBettingList($current_game_obj);

        /////

        return json_encode(array("message" => "Success", "earning" => $earning, "balance"=>Auth::user()->balance));
    }
}
