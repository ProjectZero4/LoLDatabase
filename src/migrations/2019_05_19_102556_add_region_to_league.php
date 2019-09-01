<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegionToLeague extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('league', function (Blueprint $table) {
            //
            $table->string('region', 5)->index()->default('euw');
            $table->unique(['region', 'queueType', 'summonerId']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('league', function (Blueprint $table) {
            //
        });
    }
}
