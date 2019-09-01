<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('currentPlatformId');
            $table->string('summonerName');
            $table->string('matchHistoryUri');
            $table->string('platformId');
            $table->string('currentAccountId');
            $table->integer('profileIcon');
            $table->string('summonerId')->index();
            $table->string('accountId');
            $table->integer('participant_identity_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
}
