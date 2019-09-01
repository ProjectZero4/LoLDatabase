<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeagueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('queueType');
            $table->string('summonerName');
            $table->boolean('hotStreak');
            $table->integer('mini_series_id')->nullable(true);
            $table->integer('wins');
            $table->boolean('veteran');
            $table->integer('losses');
            $table->boolean('freshBlood');
            $table->boolean('inactive');
            $table->string('rank');
            $table->string('summonerId');
            $table->integer('leaguePoints');
            $table->string('tier');

            $table->index(['summonerName']);
            $table->index(['summonerId']);
            $table->index(['queueType']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('league');
    }
}
