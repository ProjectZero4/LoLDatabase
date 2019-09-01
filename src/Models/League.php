<?php

namespace ProjectZero\LoLDatabase\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class League
 * @package App\Models
 * @property-read int id
 * @property string created_at
 * @property string updated_at
 * @property string queueType
 * @property string summonerName
 * @property bool hotStreak
 * @property int mini_series_id
 * @property MiniSeries miniSeries
 * @property int wins
 * @property bool veteran
 * @property int losses
 * @property bool freshBlood
 * @property bool inactive
 * @property string rank
 * @property string summonerId
 * @property int leaguePoints
 * @property string tier
 */
class League extends Base
{
    /**
     * @var string
     */
    protected $table = "league";
    /**
     * @var array
     */
    protected $fillable = [
        'queueType',
        'summonerName',
        'hotStreak',
        'wins',
        'veteran',
        'losses',
        'freshBlood',
        'inactive',
        'rank',
        'summonerId',
        'leaguePoints',
        'tier',
    ];
    /**
     * @var int
     */
    protected $expires_after = 1800;

    /**
     * @return HasOne
     */
    public function miniSeries()
    {
        return $this->hasOne(MiniSeries::class);
    }

    /**
     * @return Queue
     */
    public function queue()
    {
        return Queue::where(['queue_type' => $this->queueType])->orderBy('id', 'desc')->first();
    }
}
