<?php


namespace ProjectZero\LoLDatabase\Models\Match;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Team
 * @package App\Models\Match
 * @property integer id
 * @property boolean firstDragon
 * @property boolean firstInhibitor
 * @property integer bansId
 * @property integer baronKills
 * @property boolean firstRiftHerald
 * @property integer riftHeraldKills
 * @property integer teamId
 * @property boolean firstTower
 * @property integer vilemawKills
 * @property integer inhibitorKills
 * @property integer towerKills
 * @property integer dominationVictoryScore
 * @property string win
 * @property integer dragonKills
 * @property Match match
 */
class Team extends Model
{
    /**
     * @var string
     */
    protected $table = "teams";
    protected $guarded = ['id', 'bans'];

    /**
     * @return BelongsTo
     */
    public function match()
    {
        return $this->belongsTo(Match::class, 'gameId', 'gameId');
    }

    /**
     * @return HasMany
     */
    public function bans()
    {
        return $this->hasMany(Ban::class);
    }
}
