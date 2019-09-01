<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participant_stats', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('firstBloodAssist')->nullable();
            $table->integer('visionScore');
            $table->integer('magicDamageDealtToChampions');
            $table->integer('damageDealtToObjectives');
            $table->integer('totalTimeCrowdControlDealt');
            $table->integer('longestTimeSpentLiving');
            $table->integer('perk1Var1');
            $table->integer('perk1Var3');
            $table->integer('perk1Var2');
            $table->integer('tripleKills');
            $table->integer('perk3Var3');
            $table->integer('perk3Var2');
            $table->integer('playerScore9');
            $table->integer('playerScore8');
            $table->integer('kills');
            $table->integer('playerScore1');
            $table->integer('playerScore0');
            $table->integer('playerScore3');
            $table->integer('playerScore2');
            $table->integer('playerScore5');
            $table->integer('playerScore4');
            $table->integer('playerScore7');
            $table->integer('playerScore6');
            $table->integer('perk5Var1');
            $table->integer('perk5Var3');
            $table->integer('perk5Var2');
            $table->integer('totalScoreRank');
            $table->integer('neutralMinionsKilled')->default(0);
            $table->integer('damageDealtToTurrets');
            $table->integer('physicalDamageDealtToChampions');
            $table->integer('nodeCapture')->nullable();
            $table->integer('largestMultiKill');
            $table->integer('perk2Var2');
            $table->integer('totalUnitsHealed');
            $table->integer('perk2Var1');
            $table->integer('perk2Var3');
            $table->integer('perk4Var1');
            $table->integer('perk4Var2');
            $table->integer('perk4Var3');
            $table->integer('wardsKilled')->default(0);
            $table->integer('largestCriticalStrike');
            $table->integer('largestKillingSpree');
            $table->integer('quadraKills');
            $table->integer('teamObjective')->nullable();
            $table->integer('magicDamageDealt');
            $table->integer('item2');
            $table->integer('item3');
            $table->integer('item0');
            $table->integer('neutralMinionsKilledTeamJungle')->default(0);
            $table->integer('item6');
            $table->integer('item4');
            $table->integer('item5');
            $table->integer('perk1');
            $table->integer('perk0');
            $table->integer('perk3');
            $table->integer('perk2');
            $table->integer('perk5');
            $table->integer('perk4');
            $table->integer('perk3Var1');
            $table->integer('damageSelfMitigated');
            $table->integer('magicalDamageTaken');
            $table->boolean('firstInhibitorKill')->nullable();
            $table->integer('trueDamageTaken');
            $table->integer('nodeNeutralize')->nullable();
            $table->integer('assists');
            $table->integer('combatPlayerScore');
            $table->integer('perkPrimaryStyle')->nullable();
            $table->integer('goldSpent');
            $table->integer('trueDamageDealt');
            $table->integer('participantId');
            $table->integer('participant_id')->index();
            $table->integer('totalDamageTaken');
            $table->integer('physicalDamageDealt');
            $table->integer('sightWardsBoughtInGame');
            $table->integer('totalDamageDealtToChampions');
            $table->integer('physicalDamageTaken');
            $table->integer('totalPlayerScore');
            $table->boolean('win');
            $table->integer('objectivePlayerScore');
            $table->integer('totalDamageDealt');
            $table->integer('item1');
            $table->integer('neutralMinionsKilledEnemyJungle')->default(0);
            $table->integer('deaths');
            $table->integer('wardsPlaced')->default(0);
            $table->integer('perkSubStyle')->nullable();
            $table->integer('turretKills');
            $table->boolean('firstBloodKill')->nullable();
            $table->integer('trueDamageDealtToChampions');
            $table->integer('goldEarned');
            $table->integer('killingSprees');
            $table->integer('unrealKills');
            $table->integer('altarsCaptured')->nullable();
            $table->boolean('firstTowerAssist')->nullable();
            $table->boolean('firstTowerKill')->nullable();
            $table->integer('champLevel');
            $table->integer('doubleKills');
            $table->integer('nodeCaptureAssist')->nullable();
            $table->integer('inhibitorKills');
            $table->boolean('firstInhibitorAssist')->nullable();
            $table->integer('perk0Var1');
            $table->integer('perk0Var2');
            $table->integer('perk0Var3');
            $table->integer('visionWardsBoughtInGame');
            $table->integer('altarsNeutralized')->nullable();
            $table->integer('pentaKills');
            $table->integer('totalHeal');
            $table->integer('totalMinionsKilled')->default(0);
            $table->integer('timeCCingOthers');
            $table->integer('statPerk0');
            $table->integer('statPerk1');
            $table->integer('statPerk2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participant_stats');
    }
}
