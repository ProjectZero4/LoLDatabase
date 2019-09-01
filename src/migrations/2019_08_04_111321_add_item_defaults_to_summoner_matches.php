<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemDefaultsToSummonerMatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('summoner_matches', function (Blueprint $table) {
            //
            $table->integer('item0')->nullable()->change();
            $table->integer('item1')->nullable()->change();
            $table->integer('item2')->nullable()->change();
            $table->integer('item3')->nullable()->change();
            $table->integer('item4')->nullable()->change();
            $table->integer('item5')->nullable()->change();
            $table->integer('item6')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('summoner_matches', function (Blueprint $table) {
            //
        });
    }
}
