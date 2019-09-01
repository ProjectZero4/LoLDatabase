<?php


namespace ProjectZero\LoLDatabase\Models\Match;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Stats
 * @package App\Models\Match
 * @property integer id
 * @property boolean firstBloodAssist
 * @property integer visionScore
 * @property integer magicDamageDealtToChampions
 * @property integer damageDealtToObjectives
 * @property integer totalTimeCrowdControlDealt
 * @property integer longestTimeSpendLiving
 * @property integer perk1Var1
 * @property integer perk1Var3
 * @property integer perk1Var2
 * @property integer tripleKills
 * @property integer perk3Var3
 * @property integer perk3Var2
 * @property integer playerScore9
 * @property integer playerScore8
 * @property integer kills
 * @property integer playerScore1
 * @property integer playerScore0
 * @property integer playerScore3
 * @property integer playerScore2
 * @property integer playerScore5
 * @property integer playerScore4
 * @property integer playerScore7
 * @property integer playerScore6
 * @property integer perk5Var1
 * @property integer perk5Var3
 * @property integer perk5Var2
 * @property integer totalScoreRank
 * @property integer neutralMinionsKilled
 * @property integer damageDealtToTurrets
 * @property integer physicalDamageDealtToChampions
 * @property integer nodeCapture
 * @property integer largestMultiKill
 * @property integer perk2Var2
 * @property integer totalUnitsHealed
 * @property integer perk2Var1
 * @property integer perk4Var1
 * @property integer perk4Var2
 * @property integer perk4Var3
 * @property integer wardsKilled
 * @property integer largestCriticalStrike
 * @property integer largestKillingSpree
 * @property integer quadraKills
 * @property integer teamObjective
 * @property integer magicDamageDealt
 * @property integer item2
 * @property integer item3
 * @property integer item0
 * @property integer neutralMinionsKilledTeamJungle
 * @property integer item6
 * @property integer item4
 * @property integer item5
 * @property integer perk1
 * @property integer perk0
 * @property integer perk3
 * @property integer perk2
 * @property integer perk5
 * @property integer perk4
 * @property integer perk3Var1
 * @property integer damageSelfMitigated
 * @property integer magicalDamageTaken
 * @property boolean firstInhibitorKill
 * @property integer trueDamageTaken
 * @property integer nodeNeutralize
 * @property integer assists
 * @property integer combatPlayerScore
 * @property integer perkPrimaryStyle
 * @property integer goldSpent
 * @property integer trueDamageDealt
 * @property integer participantId
 * @property integer totalDamageTaken
 * @property integer physicalDamageDealt
 * @property integer sightWardsBoughtInGame
 * @property integer totalDamageDealtToChampions
 * @property integer physicalDamageTaken
 * @property integer totalPlayerScore
 * @property boolean win
 * @property integer objectivePlayerScore
 * @property integer totalDamageDealt
 * @property integer item1
 * @property integer neutralMinionsKilledEnemyJungle
 * @property integer deaths
 * @property integer wardsPlaced
 * @property integer perkSubStyle
 * @property integer turretKills
 * @property boolean firstBloodKill
 * @property integer trueDamageDealtToChampions
 * @property integer goldEarned
 * @property integer killingSprees
 * @property integer unrealKills
 * @property integer altarsCaptured
 * @property boolean firstTowerAssist
 * @property boolean firstTowerKill
 * @property integer champLevel
 * @property integer doubleKills
 * @property integer nodeCaptureAssist
 * @property integer inhibitorKills
 * @property boolean firstInhibitorAssist
 * @property integer perk0Var1
 * @property integer perk0Var2
 * @property integer perk0Var3
 * @property integer visionWardsBoughtInGame
 * @property integer altarsNeutralized
 * @property integer pentaKills
 * @property integer totalHeal
 * @property integer totalMinionsKilled
 * @property integer timeCCingOthers
 * @property integer player_id
 * @property Participant participant
 */
class Stats extends Model
{
    /**
     * @var string
     */
    protected $table = "participant_stats";
    protected $guarded = ['id'];

    /**
     * @return BelongsTo
     */
    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
