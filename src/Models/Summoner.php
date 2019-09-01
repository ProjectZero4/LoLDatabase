<?php
/**
 * Created by PhpStorm.
 * User: josh
 * Date: 07/04/2019
 * Time: 10:59
 */

namespace ProjectZero\LoLDatabase\Models;

use App\YourOrange;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

/**
 * Class Summoner
 * @package App\Models
 * @property-read int key_id
 * @property string created_at
 * @property string updated_at
 * @property string name
 * @property string puuid
 * @property int summonerLevel
 * @property int profileIconId
 * @property int revisionDate
 * @property string accountId
 * @property string id
 * @property string name_key
 * @property string region
 */
class Summoner extends Base
{
    /**
     * @var string
     */
    protected $table = "summoners";
    /**
     * @var string
     */
    protected $primaryKey = "key_id";
    /**
     * @var array
     */
    protected $guarded = ['key_id'];
    /**
     * @var float|int
     */
    protected $expires_after = 60 * 30;

    public static function boot()
    {
        parent::boot();
        static::saving(function ($summoner) {
            $summoner->name_key = str_replace(' ', '', $summoner->name);
        });
    }

    /**
     * @return HasOne
     */
    public function register()
    {
        return $this->hasOne(SummonerRegistry::class, 'summonerId', 'id');
    }

    /**
     * @param YourOrange $api
     * @return League
     */
    public function highestLeague(YourOrange $api)
    {
        return $api->leagueBySummonerAll($this)->getHighestLeague();
    }

    /**
     * @return HasMany
     */
    public function soloMatches()
    {
        return $this->hasMany(SummonerMatch::class, 'accountId', 'accountId')->where('queue', DB::raw(420));
    }

    /**
     * @return HasMany
     */
    public function flexSRMatches()
    {
        return $this->hasMany(SummonerMatch::class, 'accountId', 'accountId')->where('queue', DB::raw(440));
    }

    /**
     * @return HasMany
     */
    public function flexTTMatches()
    {
        return $this->hasMany(SummonerMatch::class, 'accountId', 'accountId')->where('queue', DB::raw(470));
    }

    /**
     * @return HasMany
     */
    public function normalDraftMatches()
    {
        return $this->hasMany(SummonerMatch::class, 'accountId', 'accountId')->where('queue', DB::raw(400));
    }

    /**
     * @return HasMany
     */
    public function normalBlindMatches()
    {
        return $this->hasMany(SummonerMatch::class, 'accountId', 'accountId')->where('queue', DB::raw(430));
    }

    /**
     * @return HasMany
     */
    public function aramMatches()
    {
        return $this->hasMany(SummonerMatch::class, 'accountId', 'accountId')->where('queue', DB::raw(450));
    }
}
