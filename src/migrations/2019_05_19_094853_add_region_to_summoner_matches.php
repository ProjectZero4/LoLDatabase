<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegionToSummonerMatches extends Migration
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
            $table->dropUnique(['accountId', 'gameId']);
            $table->string('region', 5)->index()->default('euw');
            $table->unique(['accountId', 'gameId', 'region']);
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
