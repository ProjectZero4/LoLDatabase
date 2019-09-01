<?php


namespace ProjectZero\LoLDatabase\Models\Match;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class DamageTakenDiffDelta
 * @package App\Models\Match
 * @property integer id
 * @property string period
 * @property integer value
 */
class DamageTakenDiffDelta extends Model
{
    /**
     * @var string
     */
    protected $table = "damage_taken_diff_deltas";
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
