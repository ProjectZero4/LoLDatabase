<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDamageTakenDiffDeltasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('damage_taken_diff_deltas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('period');
            $table->integer('value');
            $table->integer('timeline_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('damage_taken_diff_deltas');
    }
}
