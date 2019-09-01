<?php


namespace ProjectZero\LoLDatabase\Models\Match;


use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class Match
 * @package App\Models\Match
 * @property integer id
 * @property integer seasonId
 * @property integer queueId
 * @property integer gameId
 * @property integer participantIdentitiesId
 * @property string gameVersion
 * @property string platformId
 * @property string gameMode
 * @property integer mapId
 * @property string gameType
 * @property integer teamsId
 * @property integer participantsId
 * @property CarbonInterval gameDuration
 * @property Carbon gameCreation
 * @property Team[] teams
 * @property ParticipantIdentity[] participantIdentities
 * @property Participant[] participants
 */
class Match extends Model
{
    /**
     * @var string
     */
    protected $table = "matches";

    /**
     * @var array
     */
    protected $guarded = [
        'id',
        'teams',
        'participantIdentities',
        'participants'
    ];

    /**
     * @return HasMany
     */
    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    /**
     * @return HasMany
     */
    public function participantIdentities()
    {
        return $this->hasMany(ParticipantIdentity::class);
    }

    /**
     * @return HasMany
     */
    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    /**
     * @param $gameCreation
     * @return Carbon
     */
    public function getGameCreationAttribute($gameCreation)
    {
        return Carbon::createFromTimestampUTC(round($gameCreation / 1000));
    }

    /**
     * @param $gameDuration
     * @return CarbonInterval
     */
    public function getGameDurationAttribute($gameDuration)
    {
        return CarbonInterval::milliseconds($gameDuration)->cascade();
    }
}
