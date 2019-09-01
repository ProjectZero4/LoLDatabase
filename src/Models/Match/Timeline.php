<?php


namespace ProjectZero\LoLDatabase\Models\Match;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Timeline
 * @package App\Models\Match
 * @property integer id
 * @property string lane
 * @property integer participantId
 * @property string role
 * @property CsDelta[] cs
 * @property CsDiffDelta[] csDiff
 * @property DamageTakenDelta[] damageTaken
 * @property DamageTakenDiffDelta[] damageTakenDiff
 * @property GoldDelta[] gold
 * @property XpDelta[] xp
 * @property XpDiffDelta[] xpDiff
 */
class Timeline extends Model
{
    /**
     * @var string
     */
    protected $table = "participant_timelines";
    /**
     * @var array
     */
    protected $fillable = ['lane', 'participantId', 'role'];

    /**
     * @return HasMany
     */
    public function cs()
    {
        return $this->hasMany(CsDelta::class);
    }

    /**
     * @return HasMany
     */
    public function csDiff()
    {
        return $this->hasMany(CsDiffDelta::class);
    }

    /**
     * @return HasMany
     */
    public function damageTaken()
    {
        return $this->hasMany(DamageTakenDelta::class);
    }

    /**
     * @return HasMany
     */
    public function damageTakenDiff()
    {
        return $this->hasMany(DamageTakenDiffDelta::class);
    }

    /**
     * @return HasMany
     */
    public function gold()
    {
        return $this->hasMany(GoldDelta::class);
    }

    /**
     * @return HasMany
     */
    public function xp()
    {
        return $this->hasMany(XpDelta::class);
    }

    /**
     * @return HasMany
     */
    public function xpDiff()
    {
        return $this->hasMany(XpDiffDelta::class);
    }
}
