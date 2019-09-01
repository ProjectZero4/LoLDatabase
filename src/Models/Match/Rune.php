<?php


namespace ProjectZero\LoLDatabase\Models\Match;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Rune
 * @package App\Models\Match
 * @property-read integer id
 * @property integer runeId
 * @property integer rank
 * @property integer participant_id
 * @property Participant participant
 */
class Rune extends Model
{
    /**
     * @var string
     */
    protected $table = "runes";
    /**
     * @var array
     */
    protected $fillable = ['runeId', 'rank'];

    /**
     * @return BelongsTo
     */
    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
