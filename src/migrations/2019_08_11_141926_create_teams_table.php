<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('firstDragon');
            $table->boolean('firstInhibitor');
            $table->integer('baronKills');
            $table->boolean('firstRiftHerald');
            $table->boolean('firstBaron');
            $table->integer('riftHeraldKills');
            $table->boolean('firstBlood');
            $table->integer('teamId');
            $table->boolean('firstTower');
            $table->integer('vilemawKills');
            $table->integer('inhibitorKills');
            $table->integer('towerKills');
            $table->integer('dominionVictoryScore');
            $table->string('win'); // Fail/Win
            $table->integer('dragonKills');
            $table->integer('match_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
