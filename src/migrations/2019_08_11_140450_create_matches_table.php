<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('seasonId');
            $table->integer('queueId');
            $table->bigInteger('gameId');
            $table->string('gameVersion');
            $table->string('platformId');
            $table->string('gameMode');
            $table->integer('mapId');
            $table->string('gameType');
            $table->integer('gameDuration');
            $table->bigInteger('gameCreation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
