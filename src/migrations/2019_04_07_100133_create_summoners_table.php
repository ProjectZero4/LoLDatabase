<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSummonersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('summoners', function (Blueprint $table) {
            $table->increments('key_id');
            $table->timestamps();
            $table->string('name');
            $table->string('puuid');
            $table->integer('summonerLevel');
            $table->integer('profileIconId');
            $table->bigInteger('revisionDate');
            $table->string('accountId');
            $table->string('id');
            $table->string('name_key');

            $table->index(['id']);
            $table->index(['name_key']);
            $table->index(['accountId']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('summoners');
    }
}
