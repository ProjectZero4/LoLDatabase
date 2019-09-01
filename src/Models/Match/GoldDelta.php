<?php


namespace ProjectZero\LoLDatabase\Models\Match;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class GoldDelta
 * @package App\Models\Match
 * @property integer id
 * @property string period
 * @property integer value
 */
class GoldDelta extends Model
{
    /**
     * @var string
     */
    protected $table = "gold_deltas";
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
