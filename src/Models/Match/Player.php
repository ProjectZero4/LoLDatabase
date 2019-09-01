<?php


namespace ProjectZero\LoLDatabase\Models\Match;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Player
 * @package App\Models\Match
 * @property integer id
 * @property string currentPlatformId
 * @property string summonerName
 * @property string matchHistoryUri
 * @property string platformId
 * @property string currentAccountId
 * @property integer profileIconId
 * @property string summonerId
 * @property string accountId
 * @property integer matchId
 * @property ParticipantIdentity participantIdentity
 */
class Player extends Model
{
    /**
     * @var string
     */
    protected $table = "players";

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return BelongsTo
     */
    public function participantIdentity()
    {
        return $this->belongsTo(ParticipantIdentity::class);
    }
}
