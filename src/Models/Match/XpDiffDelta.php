<?php


namespace ProjectZero\LoLDatabase\Models\Match;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class XpDiffDelta
 * @package App\Models\Match
 * @property integer id
 * @property string period
 * @property integer value
 */
class XpDiffDelta extends Model
{
    /**
     * @var string
     */
    protected $table = "xp_diff_deltas";
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
