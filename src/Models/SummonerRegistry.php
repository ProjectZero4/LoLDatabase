<?php


namespace ProjectZero\LoLDatabase\Models;


/**
 * Class SummonerRegistry
 * @package App\Models
 * @property-read int id
 * @property string created_at
 * @property string updated_at
 * @property string summonerId
 * @property bool processed
 * @property string region
 */
class SummonerRegistry extends Base
{
    protected $table = "summoner_registry";

    protected $fillable = ['summonerId'];
}
