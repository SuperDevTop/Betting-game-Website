<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrashGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crash_games', function (Blueprint $table) {
            $table->increments('id');
            $table->float("crash_point");
            $table->float("crash_time");
            $table->integer("total_user");
            $table->integer("total_amount");
            $table->integer("total_win");
            $table->integer("total_win_amount");
            $table->string("status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crash_games');
    }
}
