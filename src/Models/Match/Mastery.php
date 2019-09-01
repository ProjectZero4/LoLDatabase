<?php


namespace ProjectZero\LoLDatabase\Models\Match;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Rune
 * @package App\Models\Match
 * @property int id
 * @property int masteryId
 * @property int rank
 * @property int participant_id
 * @property Participant participant
 */
class Mastery extends Model
{
    /**
     * @var string
     */
    protected $table = "masteries";

    protected $fillable = ['masteryId', 'rank', 'participant_id'];

    /**
     * @return BelongsTo
     */
    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
