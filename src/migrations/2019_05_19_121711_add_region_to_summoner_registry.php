<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegionToSummonerRegistry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('summoner_registry', function (Blueprint $table) {
            //
            $table->string('region', 5)->index()->default('euw');
            $table->unique(['region', 'summonerId']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('summoner_registry', function (Blueprint $table) {
            //
        });
    }
}
