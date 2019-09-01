<?php


namespace ProjectZero\LoLDatabase\Models\Match;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Participant
 * @package App\Models\Match
 * @property integer id
 * @property integer participantStatsId
 * @property integer participantId
 * @property integer runesId
 * @property integer timelineId
 * @property integer teamId
 * @property integer spell2Id
 * @property integer masteriesId
 * @property string highestAchievedSeasonTier
 * @property integer spell1Id
 * @property integer championId
 * @property integer matchId
 * @property Match match
 * @property Stats stats
 * @property Timeline timeline
 * @property Rune[] runes
 * @property Mastery[] masteries
 */
class Participant extends Model
{
    /**
     * @var string
     */
    protected $table = "participants";
    /**
     * @var array
     */
    protected $guarded = ['id', 'match', 'stats', 'timeline', 'runes', 'masteries'];

    /**
     * @return BelongsTo
     */
    public function match()
    {
        return $this->belongsTo(Match::class);
    }

    /**
     * @return HasOne
     */
    public function stats()
    {
        return $this->hasOne(Stats::class);
    }

    /**
     * @return HasOne
     */
    public function timeline()
    {
        return $this->hasOne(Timeline::class);
    }

    /**
     * @return HasMany
     */
    public function runes()
    {
        return $this->hasMany(Rune::class);
    }

    /**
     * @return HasMany
     */
    public function masteries()
    {
        return $this->hasMany(Mastery::class);
    }
}
