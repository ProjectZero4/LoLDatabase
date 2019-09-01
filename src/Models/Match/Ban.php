<?php


namespace ProjectZero\LoLDatabase\Models\Match;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Ban
 * @package App\Models\Match
 * @property integer id
 * @property integer pickTurn
 * @property integer championId
 * @property integer team_id
 * @property Team team
 */
class Ban extends Model
{
    /**
     * @var string
     */
    protected $table = "team_bans";

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
