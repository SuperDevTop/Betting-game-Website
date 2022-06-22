<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\StartCrashGame;
use App\Events\CrashGamePlace;
use App\Events\EndCrashGame;
use App\CrashGame;


class CrashGameThread extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:crashgame';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'start crash game';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function create_random()
    {
        $third = 0; 
        $second = 0; 
        $first = 1; 
        $m_first = rand(0,10000000) % 10; 
        $m_second = rand(0,10000000) % 10;

        // setting first value
        for ($i = 1; $i < 10; $i ++)
            if (rand(0,10000000) % (pow($i, 2) + 1) == 0){
                $first = $i % 10; break;
            }

        // setting second value
        for ($j = 1; $j <= 10; $j ++)
            if (rand(0,10000000) % (pow($j + 10, 3)) == 0){
                $second = $j % 10; break;
            }

        // setting second value
        for ($k = 1; $k <= 5; $k ++)
            if (rand(0,10000000) % (pow($k + 100, 4)) == 0){
                $third = $k % 10; break;
            }


        if ($third == 0 && $second == 0 && $i == 0) $first = 1;

        return $third * 100 + $second * 10 + $first + $m_first * 0.1 + $m_second * 0.01;
    }
    public function handle()
    {
        while(true){
            
            $crash_point = $this->create_random();

            $crash_time = (sqrt(sqrt(sqrt($crash_point))) - 1) * 100;
            $m_second = round($crash_time, 2) * 1000000;

            var_dump($crash_point."   ".$crash_time);

            $past_games = CrashGame::orderBy("id", "desc")->take(15)->select("crash_point")->get();

            $game = new CrashGame();
            $game->crash_point = $crash_point;
            $game->crash_time = $crash_time;
            $game->status = "pending";
            $game->total_win = 0;
            $game->total_win_amount = 0;
            $game->total_user = 0;
            $game->total_amount = 0;
            $game->save();

            try {
                event( new StartCrashGame(array("lastgames"=>$past_games)) );
            }catch (\Exception $e) {
                var_dump($e);
            }

            usleep(4500000);
            

            $game = CrashGame::orderBy("id", "desc")->first();
            $game->status = "playing";
            $game->save();

            usleep($m_second);

            try {
                event( new EndCrashGame(array("crash_point" => $crash_point)) );
            } catch (\Exception $e) {
                var_dump($e);
            }

            
            $game = CrashGame::orderBy("id", "desc")->first();
            $game->status = "finish";

            // fill the other field in row.

            $game->save();  

            usleep(2000000);  
        }
    }
}