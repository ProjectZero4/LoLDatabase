<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultsToParticipantStats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participant_stats', function (Blueprint $table) {
            $table->integer('perk1Var1')->default(0)->change();
            $table->integer('perk1Var3')->default(0)->change();
            $table->integer('perk1Var2')->default(0)->change();
            $table->integer('perk3Var3')->default(0)->change();
            $table->integer('perk3Var2')->default(0)->change();
            $table->integer('perk5Var1')->default(0)->change();
            $table->integer('perk5Var3')->default(0)->change();
            $table->integer('perk5Var2')->default(0)->change();
            $table->integer('perk2Var2')->default(0)->change();
            $table->integer('perk2Var1')->default(0)->change();
            $table->integer('perk2Var3')->default(0)->change();
            $table->integer('perk4Var1')->default(0)->change();
            $table->integer('perk4Var2')->default(0)->change();
            $table->integer('perk4Var3')->default(0)->change();
            $table->integer('perk1')->default(0)->change();
            $table->integer('perk0')->default(0)->change();
            $table->integer('perk3')->default(0)->change();
            $table->integer('perk2')->default(0)->change();
            $table->integer('perk5')->default(0)->change();
            $table->integer('perk4')->default(0)->change();
            $table->integer('perk3Var1')->default(0)->change();
            $table->integer('perk0Var1')->default(0)->change();
            $table->integer('perk0Var2')->default(0)->change();
            $table->integer('perk0Var3')->default(0)->change();
            $table->integer('statPerk0')->default(0)->change();
            $table->integer('statPerk1')->default(0)->change();
            $table->integer('statPerk2')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participant_stats', function (Blueprint $table) {
            $table->integer('perk1Var1')->default(null)->change();
            $table->integer('perk1Var3')->default(null)->change();
            $table->integer('perk1Var2')->default(null)->change();
            $table->integer('perk3Var3')->default(null)->change();
            $table->integer('perk3Var2')->default(null)->change();
            $table->integer('perk5Var1')->default(null)->change();
            $table->integer('perk5Var3')->default(null)->change();
            $table->integer('perk5Var2')->default(null)->change();
            $table->integer('perk2Var2')->default(null)->change();
            $table->integer('perk2Var1')->default(null)->change();
            $table->integer('perk2Var3')->default(null)->change();
            $table->integer('perk4Var1')->default(null)->change();
            $table->integer('perk4Var2')->default(null)->change();
            $table->integer('perk4Var3')->default(null)->change();
            $table->integer('perk1')->default(null)->change();
            $table->integer('perk0')->default(null)->change();
            $table->integer('perk3')->default(null)->change();
            $table->integer('perk2')->default(null)->change();
            $table->integer('perk5')->default(null)->change();
            $table->integer('perk4')->default(null)->change();
            $table->integer('perk3Var1')->default(null)->change();
            $table->integer('perk0Var1')->default(null)->change();
            $table->integer('perk0Var2')->default(null)->change();
            $table->integer('perk0Var3')->default(null)->change();
            $table->integer('statPerk0')->default(null)->change();
            $table->integer('statPerk1')->default(null)->change();
            $table->integer('statPerk2')->default(null)->change();
        });
    }
}
