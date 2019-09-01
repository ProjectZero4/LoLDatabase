<?php


namespace ProjectZero\LoLDatabase\Models\Match;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CsDiffDelta
 * @package App\Models\Match
 * @property integer id
 * @property string period
 * @property integer value
 */
class CsDiffDelta extends Model
{
    /**
     * @var string
     */
    protected $table = "cs_diff_deltas";
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
