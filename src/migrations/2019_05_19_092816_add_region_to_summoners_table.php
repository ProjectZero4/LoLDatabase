<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegionToSummonersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('summoners', function (Blueprint $table) {
            //
            $table->string('region', 5)->index()->default('euw');
            $table->unique(['region', 'id']);
            $table->unique(['region', 'accountId']);
            $table->unique(['region', 'name_key']);
            $table->unique(['puuid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('summoners', function (Blueprint $table) {
            //
        });
    }
}
