<?php


namespace ProjectZero\LoLDatabase\Models\Match;


use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class ChampionStats
 * @package App\Models\Match
 * @property-read integer kills
 * @property-read integer deaths
 * @property-read integer assists
 * @property-read integer wins
 * @property-read integer cs
 * @property-read integer doubleKills
 * @property-read integer tripleKills
 * @property-read integer quadraKills
 * @property-read integer pentaKills
 * @property-read integer unrealKills
 * @property-read integer visionScore
 * @property-read integer firstBloods
 * @property-read integer wardsPlaced
 * @property-read CarbonInterval playtime
 * @property-read integer totalGames
 * @property-read Carbon oldestGame
 * @property-read integer championId
 */
class ChampionStats extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];
    /**
     * @var array
     */
    protected $casts = [
        'kills',
        'deaths',
        'assists',
        'wins',
        'cs',
        'doubleKills',
        'tripleKills',
        'quadraKills',
        'pentaKills',
        'unrealKills',
        'visionScore',
        'firstBloods',
        'wardsPlaced',
        'totalGames',
    ];
    /**
     * @var bool
     */
    protected $isAverage = false;
    /**
     * @var array
     */
    protected $canAverage = [
        'kills',
        'deaths',
        'assists',
        'wins',
        'cs',
        'doubleKills',
        'tripleKills',
        'quadraKills',
        'pentaKills',
        'unrealKills',
        'visionScore',
        'firstBloods',
        'wardsPlaced',
        'playtime',
    ];
    /**
     * @var array
     */
    protected $percents = [
        'firstBloods',
        'wins',
    ];

    /**
     * @param $oldestGame
     * @return Carbon
     */
    public function getOldestGameAttribute($oldestGame)
    {
        return Carbon::createFromTimestampUTC(round($oldestGame / 1000));
    }

    /**
     * @param $playtime
     * @return CarbonInterval
     */
    public function getPlaytimeAttribute($playtime)
    {
        return CarbonInterval::seconds(round($playtime))->cascade();
    }

    public function convertToAverage()
    {
        if ($this->isAverage) {
            return;
        }
        $divisor = $this->totalGames;
        if ($divisor === 0) {
            $this->isAverage = true;
            return;
        }
        foreach ($this->canAverage as $key) {
            $numerator = $this->$key;
            if ($numerator instanceof CarbonInterval) {
                $numerator = $numerator->totalSeconds;
            }
            $fraction = $numerator / $divisor;
            if (in_array($key, $this->percents)) {
                $fraction *= 100;
            }
            $this->$key = round($fraction, 2);
        }
        $this->isAverage = true;
    }
}
