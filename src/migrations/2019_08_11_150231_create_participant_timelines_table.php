<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantTimelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participant_timelines', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('lane')->index();
            $table->integer('participantId');
            $table->string('role')->index();
            $table->integer('participant_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participant_timelines');
    }
}
