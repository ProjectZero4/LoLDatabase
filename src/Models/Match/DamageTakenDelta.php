<?php


namespace ProjectZero\LoLDatabase\Models\Match;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class DamageTakenDelta
 * @package App\Models\Match
 * @property integer id
 * @property string period
 * @property integer value
 */
class DamageTakenDelta extends Model
{
    /**
     * @var string
     */
    protected $table = "damage_taken_deltas";
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return BelongsTo
     */
    public function timeline()
    {
        return $this->belongsTo(Timeline::class);
    }
}
