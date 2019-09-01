<?php


namespace ProjectZero\LoLDatabase\Models\Match;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class ParticipantIdentity
 * @package App\Models\Match
 * @property integer id
 * @property integer player_id
 * @property integer participantId
 * @property integer matchId
 * @property Match match
 * @property Participant participant
 */
class ParticipantIdentity extends Model
{
    /**
     * @var string
     */
    protected $table = "participant_identities";
    /**
     * @var array
     */
    protected $fillable = ['participantId', 'matchId'];

    /**
     * @return HasOne
     */
    public function player()
    {
        return $this->hasOne(Player::class, 'participant_identity_id');
    }

    /**
     * @return HasOne
     */
    public function participant()
    {
        return $this->hasOne(Participant::class, 'match_id', 'match_id')
            ->where('participantId', $this->participantId);
    }

    /**
     * @return BelongsTo
     */
    protected function match()
    {
        return $this->belongsTo(Match::class);
    }
}
