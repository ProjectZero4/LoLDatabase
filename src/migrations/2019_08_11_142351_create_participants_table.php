<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('participantId');
            $table->integer('teamId');
            $table->integer('spell2Id')->index();
            $table->string('highestAchievedSeasonTier')->nullable();
            $table->integer('spell1Id')->index();
            $table->integer('championId')->index();
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
        Schema::dropIfExists('participants');
    }
}
