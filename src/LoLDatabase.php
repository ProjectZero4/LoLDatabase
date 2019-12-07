<?php
/**
 * Created by PhpStorm.
 * User: josh
 * Date: 07/04/2019
 * Time: 10:38
 */

namespace ProjectZero\LoLDatabase;


use Carbon\Carbon;
use Exception as Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use ProjectZero\LoLDatabase\Models\League;
use ProjectZero\LoLDatabase\Models\LeagueCollection;
use ProjectZero\LoLDatabase\Models\Match\Ban;
use ProjectZero\LoLDatabase\Models\Match\ChampionStats;
use ProjectZero\LoLDatabase\Models\Match\CsDelta;
use ProjectZero\LoLDatabase\Models\Match\CsDiffDelta;
use ProjectZero\LoLDatabase\Models\Match\DamageTakenDelta;
use ProjectZero\LoLDatabase\Models\Match\DamageTakenDiffDelta;
use ProjectZero\LoLDatabase\Models\Match\GoldDelta;
use ProjectZero\LoLDatabase\Models\Match\Mastery;
use ProjectZero\LoLDatabase\Models\Match\Match;
use ProjectZero\LoLDatabase\Models\Match\Participant;
use ProjectZero\LoLDatabase\Models\Match\ParticipantIdentity;
use ProjectZero\LoLDatabase\Models\Match\Player;
use ProjectZero\LoLDatabase\Models\Match\Rune;
use ProjectZero\LoLDatabase\Models\Match\Stats;
use ProjectZero\LoLDatabase\Models\Match\Team;
use ProjectZero\LoLDatabase\Models\Match\Timeline;
use ProjectZero\LoLDatabase\Models\Match\XpDelta;
use ProjectZero\LoLDatabase\Models\Match\XpDiffDelta;
use ProjectZero\LoLDatabase\Models\MiniSeries;
use ProjectZero\LoLDatabase\Models\Queue;
use ProjectZero\LoLDatabase\Models\Summoner;
use RiotAPI\DataDragonAPI\DataDragonAPI;
use RiotAPI\DataDragonAPI\Exceptions\ArgumentException;
use RiotAPI\LeagueAPI\Exceptions\GeneralException;
use RiotAPI\LeagueAPI\Exceptions\RequestException;
use RiotAPI\LeagueAPI\Exceptions\ServerException;
use RiotAPI\LeagueAPI\Exceptions\SettingsException;
use RiotAPI\LeagueAPI\LeagueAPI;
use RiotAPI\LeagueAPI\Objects\CurrentGameInfo;
use RiotAPI\LeagueAPI\Objects\LeaguePositionDto;
use RiotAPI\LeagueAPI\Objects\MatchDto;
use RiotAPI\LeagueAPI\Objects\StaticData\StaticChampionListDto;
use stdClass;
use Throwable;

/**
 * Class YourOrange
 * @package App
 */
class LoLDatabase
{
    /**
     *
     */
    const RANKED_SOLO_5x5 = "RANKED_SOLO_5x5";
    /**
     *
     */
    const RANKED_FLEX_SR = "RANKED_FLEX_SR";
    /**
     *
     */
    const RANKED_FLEX_TT = "RANKED_FLEX_TT";


    /**
     * @var LeagueAPI
     */
    protected $api;
    /**
     * @var string
     */
    protected $region;
    /**
     * @var YourRegion
     */
    protected $yourRegion;

    /**
     * @var RateLimitInterface $rateLimitProvider
     */
    protected $rateLimitProvider;

    /**
     * YourOrange constructor.
     * @param $api_provider
     * @param string $region
     * @throws ArgumentException
     * @throws Exception
     */
    public function __construct($api_provider, $region = YourRegion::EUROPE_WEST)
    {
        $this->api = $api_provider;
        $this->yourRegion = new YourRegion;
        $this->setRegion($region);
        DataDragonAPI::initByVersion($this->latestPatch()->name . ".1");
        DataDragonAPI::$ssl = true;
    }


    /**
     * =========================================
     * Summoner Endpoint Methods
     * Current Version Supported: v4
     * =========================================
     */

    /**
     * @return object
     */
    public function latestPatch()
    {
        return Arr::last($this->getPatches()->patches);
    }

    /**
     * @return stdClass
     */
    public function getPatches()
    {
        $filePath = storage_path('patches');
        if (!file_exists($filePath) || time() - filemtime($filePath) > 3600) {
            $patches = file_get_contents('https://raw.githubusercontent.com/CommunityDragon/Data/master/patches.json');
            file_put_contents($filePath, $patches);
        } else {
            $patches = file_get_contents($filePath);
        }
        return json_decode($patches);
    }

    /**
     * @param string $encrypted_id
     * @return Summoner
     */
    public function summoner(string $encrypted_id): Summoner
    {
        /**
         * @var Summoner $summoner
         */
        $summoner = Summoner::firstOrNew(['id' => $encrypted_id, 'region' => $this->region]);
        if (!$summoner->expired()) {
            return $summoner;
        }
        $dto = $this->queryApi('getSummoner', $encrypted_id);
        $summoner->fill($dto->getData());
        $summoner->region = $this->region;
        $summoner->save();
        return $summoner;
    }

    /**
     * @param $method
     * @param mixed ...$params
     * @return mixed
     */
    protected function queryApi($method, ...$params)
    {
        if (isset($this->rateLimitProvider)) {
            $this->rateLimitProvider->canQuery();
        }
        return $this->api->$method(...$params);
    }


    /**
     * =========================================
     * League Endpoint Methods
     * Current Version Supported: v4
     * =========================================
     */

    /**
     * @param string $account_id
     * @return Summoner
     */
    public function summonerByAccount(string $account_id): Summoner
    {
        /**
         * @var Summoner $summoner
         */
        $summoner = Summoner::firstOrNew(['accountId' => $account_id, 'region' => $this->region]);
        if (!$summoner->expired()) {
            return $summoner;
        }
        $dto = $this->queryApi('getSummonerByAccount', $account_id);
        $summoner->fill($dto->getData());
        $summoner->region = $this->region;
        $summoner->save();
        return $summoner;
    }

    /**
     * @param Summoner $summoner
     * @return string
     * @throws \RiotAPI\DataDragonAPI\Exceptions\SettingsException
     */
    public function summonerProfileIcon(Summoner $summoner)
    {
        return DataDragonAPI::getProfileIconUrl($summoner->profileIconId);
    }

    /**
     * @param Summoner $summoner
     * @return LeagueCollection
     */
    public function leagueBySummonerAll(Summoner $summoner): LeagueCollection
    {
        $collection = new LeagueCollection;
        $solo = $this->leagueBySummoner($summoner, LoLDatabase::RANKED_SOLO_5x5);
        $flexSR = $this->leagueBySummoner($summoner, LoLDatabase::RANKED_FLEX_SR);
        $flexTT = $this->leagueBySummoner($summoner, LoLDatabase::RANKED_FLEX_TT);
        if ($solo) {
            $collection->push($solo);
        }
        if ($flexSR) {
            $collection->push($flexSR);
        }
        if ($flexTT) {
            $collection->push($flexTT);
        }
        return $collection;
    }
    /**
     * =========================================
     * Match Endpoint Methods
     * Current Version Supported: v4
     * =========================================
     */

    /**
     * @param Summoner $summoner
     * @param string $type
     * @return League
     */
    public function leagueBySummoner(Summoner $summoner, $type = LoLDatabase::RANKED_SOLO_5x5)
    {
        /**
         * @var League $league
         */
        $league = League::firstOrNew([
            'summonerId' => $summoner->id,
            'region' => $this->region,
            'queueType' => $type
        ]);
        if (!$league->expired()) {
            return $league;
        }
        /**
         * @var LeaguePositionDto[] $dtos
         */
        $dtos = $this->queryApi('getLeagueEntriesForSummoner', $summoner->id);
        foreach ($dtos as $dto) {
            $league = League::where([
                'summonerId' => $summoner->id,
                'region' => $this->region,
                'queueType' => $dto->queueType
            ])->first();

            if (!$league) {
                $league = new League;
            }
            $league->fill($dto->getData());
            $league->region = $this->region;
            $league->save();
            if ($miniSeries = $dto->miniSeries) {
                $series = new MiniSeries;
                $series->fill($miniSeries->getdata());
                $series->save();
                $league->mini_series_id = $series->fresh()->id;
            }
        }
        $league = League::where([
            'summonerId' => $summoner->id,
            'region' => $this->region,
            'queueType' => $type
        ])->first();
        return $league;
    }

    /**
     * @param League|null $league
     * @return string
     */
    public function getTierIcon(League $league = null)
    {
        return asset('storage' . DIRECTORY_SEPARATOR . "league" . DIRECTORY_SEPARATOR . "tiers" . DIRECTORY_SEPARATOR . "Emblem_" . ucfirst(strtolower($league->tier ?? 'iron')) . ".png");
    }

    /**
     * @param Summoner $summoner
     * @param $champion
     * @param null $queue
     * @param null $date
     * @return Model|Builder|object|null
     */
    public function summonerMatchesByChampion(Summoner $summoner, $champion, $queue = null, $date = null)
    {
        $data = DB::table('summoner_matches')
            ->where('accountId', $summoner->accountId)
            ->where('championKey', $champion->key)
            ->select([
                DB::raw('sum(kills) as kills'),
                DB::raw('sum(deaths) as deaths'),
                DB::raw('sum(assists) as assists'),
                DB::raw('sum(win) as wins'),
                DB::raw('sum(cs) as cs'),
                DB::raw('sum(doubleKills) as doubleKills'),
                DB::raw('sum(tripleKills) as tripleKills'),
                DB::raw('sum(quadraKills) as quadraKills'),
                DB::raw('sum(pentaKills) as pentaKills'),
                DB::raw('sum(visionScore) as visionScore'),
                DB::raw('sum(turretsDestroyed) as turretsDestroyed'),
                DB::raw('sum(firstBlood) as firstBloods'),
                DB::raw('sum(wards) as wards'),
                DB::raw('sum(gameDuration) as playtime'),
                DB::raw('count(id) as totalGames'),
            ]);
        if ($queue) {
            $data = $data->where('queue', $queue);
        }
        if ($date) {
            $data = $data->whereBetween('gameStart', [$date[0], $date[1]]);
        }
        return $data->first();
    }

    /**
     * @param Summoner $summoner
     * @param null $championKey
     * @return Player
     */
    public function getLastGame(Summoner $summoner, $championKey = null): Player
    {
        return $this->getLastXGames($summoner, 1, null, $championKey)->first() ?: new Player;
    }

    /**
     * @param Summoner $summoner
     * @param int $numberOfGames
     * @param Queue|null $queue
     * @param int|null $championKey
     * @return Player[]
     * @throws Exception
     */
    public function getLastXGames(Summoner $summoner, int $numberOfGames, Queue $queue = null, int $championKey = null)
    {
        $data = [
            'accountId' => $summoner->accountId,
            'm.platformId' => $this->yourRegion->convertToRiotRegion($summoner->region)
        ];
        if ($championKey !== null) {
            $data['championId'] = $championKey;
        }
        if ($queue !== null) {
            $data['queue'] = $queue->id;
        }

        return Player::join('participant_identities as pi', 'pi.id', '=', 'players.participant_identity_id')
            ->join('participants as p', function ($join) {
                $join->on('p.match_id', '=', 'pi.match_id')
                    ->on('p.participantId', '=', 'pi.participantId');
            })
            ->join('matches as m', 'm.id', '=', 'pi.match_id')
            ->where($data)
            ->orderBy('m.gameCreation', 'desc')
            ->limit($numberOfGames)
            ->get();
    }

    /**
     * @return bool|CurrentGameInfo
     */
    public function randomLiveGame()
    {
        foreach ($this->queryApi('getFeaturedGames')->gameList as $game) {
            foreach ($game->participants as $participant) {
                return $this->liveGameBySummoner($this->summonerByName($participant->summonerName));
            }
        }
        return false;
    }



    // CHAMPION DATA

    /**
     * @param Summoner $summoner
     * @return CurrentGameInfo
     */
    public function liveGameBySummoner(Summoner $summoner)
    {
        return $this->queryApi('getCurrentGameInfo', $summoner->id);
    }

    /**
     * @param string $name
     * @return Summoner
     */
    public function summonerByName(string $name): Summoner
    {
        /**
         * @var Summoner $summoner
         */
        $summoner = Summoner::firstOrNew([
            'name_key' => str_replace(' ', '', $name),
            'region' => $this->region,
        ]);
        if (!$summoner->expired()) {
            return $summoner;
        }
        try {
            $dto = $this->queryApi('getSummonerByName', $name);
        } catch (RequestException $e) {
            return abort($e->getCode());
        }
        $summoner->fill($dto->getData());
        $summoner->region = $this->region;
        $summoner->save();
        return $summoner;
    }

    /**
     * @return StaticChampionListDto
     * @throws RequestException
     * @throws ServerException
     * @throws SettingsException
     */
    public function getChampions()
    {
        return $this->api->getStaticChampions();
    }

    /**
     * @param $championKey
     * @return string
     * @throws ArgumentException
     * @throws \RiotAPI\DataDragonAPI\Exceptions\SettingsException
     * @deprecated
     */
    public function imageByChampionKey($championKey)
    {
        return DataDragonAPI::getChampionIconUrl($this->championByKey($championKey)->id);
    }

    /**
     * @param $championKey
     * @return object
     * @throws ArgumentException
     * @throws \RiotAPI\DataDragonAPI\Exceptions\SettingsException
     */
    public function championByKey($championKey)
    {
        return (object)DataDragonAPI::getStaticChampionByKey($championKey);
    }

    /**
     * @param $championKey
     * @return string
     * @throws ArgumentException
     * @throws \RiotAPI\DataDragonAPI\Exceptions\SettingsException
     */
    public function iconByChampion($championKey)
    {
        return DataDragonAPI::getChampionIconUrl($this->championByKey($championKey)->id);
    }

    /**
     * @param $championKey
     * @return string
     * @throws ArgumentException
     * @throws \RiotAPI\DataDragonAPI\Exceptions\SettingsException
     */
    public function splashByChampion($championKey)
    {
        return DataDragonAPI::getChampionSplashUrl($this->championByKey($championKey)->id);
    }

    /**
     * @param $championKey
     * @return string
     * @throws ArgumentException
     * @throws \RiotAPI\DataDragonAPI\Exceptions\SettingsException
     */
    public function loadingByChampion($championKey)
    {
        return DataDragonAPI::getChampionLoadingUrl($this->championByKey($championKey)->id);
    }

    /**
     * @param $championKey
     * @return string
     * @throws ArgumentException
     * @throws \RiotAPI\DataDragonAPI\Exceptions\SettingsException
     * @deprecated
     */
    public function splashByChampionKey($championKey)
    {
        return DataDragonApi::getChampionSplashUrl($this->championByKey($championKey)->id);
    }

    /**
     * @param $id
     * @return string
     * @throws ArgumentException
     * @throws \RiotAPI\DataDragonAPI\Exceptions\SettingsException
     */
    public function summonerSpellIcon($id)
    {
        return DataDragonAPI::getSpellIconUrl($this->summonerSpell($id)->id);
    }

    /**
     * @param $id
     * @return object
     * @throws ArgumentException
     * @throws \RiotAPI\DataDragonAPI\Exceptions\SettingsException
     */
    public function summonerSpell($id)
    {
        return (object)DataDragonAPI::getStaticSummonerSpellById($id);
    }

    /**
     * @param $id
     * @return string
     * @throws \RiotAPI\DataDragonAPI\Exceptions\SettingsException
     */
    public function itemIcon($id)
    {
        return $id == 0 ? 'http://raw.communitydragon.org/latest/game/data/images/emptyicon.png' : DataDragonAPI::getItemIconUrl($id);
    }

    /**
     * @return string
     * @throws ArgumentException
     */
    public function latestVersion()
    {
        return array_first($this->getVersions());
    }

    /**
     * @return array
     * @throws ArgumentException
     */
    public function getVersions()
    {
        $filePath = storage_path('lolversions');
        if (!file_exists($filePath) || time() - filemtime($filePath) > 3600) { // 1 hour
            $versions = DataDragonAPI::getStaticVersions();
            file_put_contents($filePath, json_encode($versions));
        } else {
            $versions = json_decode(file_get_contents($filePath));
        }
        return $versions;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param $region
     * @throws Exception
     */
    public function setRegion($region = YourRegion::EUROPE_WEST)
    {
        $this->region = $this->yourRegion->getRegionName($region);
        $this->queryApi('setRegion', $this->region);
    }

    /**
     * @param Summoner $summoner
     * @param $seasonInt
     * @return bool
     * @throws Throwable
     */
    public function processMatchesBySummoner(Summoner $summoner, $seasonInt)
    {
        $season = $this->getSeason($seasonInt ?? $this->latestPatch()->season);
        $end = Carbon::createFromTimestampUTC($seasonInt ? $season->end : Carbon::now()->timestamp);
        $endDay = Carbon::parse($end->format('Y-m-d'));
        $start = Carbon::createFromTimestampUTC($season->start);
        $current = Carbon::parse($start->format('Y-m-d'))->addWeek();
        do {
            $processedMatchList = false;
            $mLFailedCount = 0;
            while (!$processedMatchList) {
                try {
                    foreach ($this->matchlistBySummoner($summoner, [
                        'beginTime' => $start->timestamp * 1000,
                        'endTime' => $current->timestamp * 1000,
                    ])->matches as $key => $match) {
                        $processedMatch = false;
                        $mFailedCount = 0;
                        while (!$processedMatch) {
                            try {
                                $this->processMatch($match->gameId);
                                $processedMatch = true;
                            } catch (Exception $e) {
                                if ($mFailedCount++ === 10) {
                                    throw $e;
                                }
                            }
                        }
                    }
                    $processedMatchList = true;
                } catch (RequestException | SettingsException | GeneralException $e) {
                    if ($e->getCode() !== 404) {
                        dd($e->getMessage(), 353, [
                            'beginTime' => $start->valueOf(),
                            'endTime' => $current->valueOf()
                        ]);
                    }
                } catch (Exception $e) {
                    if ($mLFailedCount++ === 10) {
                        throw $e;
                    }
                    continue; // Try again
                }
                $currentTmp = Carbon::parse($current->format('Y-m-d'));
                $start->addWeek();
                if ($currentTmp->diff($endDay, true)->days < 7) {
                    $current = $end;
                } else {
                    $current->addWeek();
                }
                if ($start->greaterThanOrEqualTo(Carbon::now())) {
                    break;
                }
                if ($start->greaterThanOrEqualTo($current)) {
                    break;
                }
            }
        } while ($start->lessThanOrEqualTo($end));
        return true;
    }

    /**
     * @param null $season
     * @return object | bool
     */
    public function getSeason($season = null)
    {
        $data = false;
        $end = false;
        $patches = $this->getPatches()->patches;
        if ($season === null) {
            return end($patches);
        }
        foreach ($patches as $patch) {


            if ((int)$patch->season === (int)$season) {

                if (!$data) {
                    $data = $patch;
                }
                $end = $patch;
            }
            if ((int)$patch->season > (int)$season) {
                break;
            }
        }
        if ($data) {
            $data->end = $end->start;
        }
        return $data;
    }

    /**
     * @param Summoner $summoner
     * @param array $options
     * @return mixed
     */
    public function matchlistBySummoner(Summoner $summoner, $options = [])
    {
        foreach ($options as $key => $option) {
            if ($key === "summoner") {
                continue; // Protect from accidentally overwriting the summoner variable
            }
            $$key = $option;
        }
        return $this->queryApi('getMatchlistByAccount',
            $summoner->accountId,
            $queue ?? null,
            $season ?? null,
            $champion ?? null,
            $beginTime ?? null,
            $endTime ?? null,
            $beginIndex ?? null,
            $endIndex ?? null
        );
    }

    /**
     * @param int $gameId
     * @throws Throwable
     */
    public function processMatch(int $gameId)
    {
        DB::transaction(function () use ($gameId) {
            /**
             * @var Match $match
             */
            $match = Match::where('gameId', $gameId)->first();
            if ($match) {
                return;
            }
            $match = new Match;
            /**
             * @var MatchDto $game
             */
            $game = $this->queryApi('getMatch', $gameId);
            $match->fill($game->getData());
            $match->save();
            foreach ($game->participantIdentities as $pi) {
                $participantIdentity = new ParticipantIdentity;
                $participantIdentity->fill($pi->getData());
                $match->participantIdentities()->save($participantIdentity);
                if (!$pi->player) {
                    continue;
                }
                $player = new Player;
                $player->fill($pi->player->getData());
                if ($pi->player->accountId === "0") {
                    // it's a bot!
                    $player->accountId = "BOT-{$game->gameId}-{$pi->participantId}";
                    $player->summonerId = "BOT-{$game->gameId}-{$pi->participantId}";
                }
                $participantIdentity->player()->save($player);
            }
            foreach ($game->teams as $t) {
                $team = new Team;
                $team->fill($t->getData());
                $match->teams()->save($team);
                if ($t->bans) {
                    foreach ($t->bans as $b) {
                        $ban = new Ban;
                        $ban->fill($b->getData());
                        $team->bans()->save($ban);
                    }
                }
            }

            foreach ($game->participants as $p) {
                /**
                 * @var Participant $participant
                 */
                $participant = new Participant;
                $participant->fill($p->getData());
                $participant = $match->participants()->save($participant);
                if ($p->stats) {
                    $stats = new Stats;
                    $stats->fill($p->stats->getData());
                    $participant->stats()->save($stats);
                }
                if ($p->timeline) {
                    $timeline = new Timeline;
                    $timeline->fill($p->timeline->getData());
                    $participant->timeline()->save($timeline);
                    if ($p->timeline->creepsPerMinDeltas) {
                        foreach ($p->timeline->creepsPerMinDeltas as $key => $delta) {
                            $d = new CsDelta;
                            $d->value = $delta;
                            $d->period = $key;
                            $timeline->cs()->save($d);
                        }
                    }
                    if ($p->timeline->csDiffPerMinDeltas) {
                        foreach ($p->timeline->csDiffPerMinDeltas as $key => $delta) {
                            $d = new CsDiffDelta;
                            $d->value = $delta;
                            $d->period = $key;
                            $timeline->csDiff()->save($d);
                        }
                    }
                    if ($p->timeline->damageTakenDiffPerMinDeltas) {
                        foreach ($p->timeline->damageTakenDiffPerMinDeltas as $key => $delta) {
                            $d = new DamageTakenDiffDelta;
                            $d->value = $delta;
                            $d->period = $key;
                            $timeline->damageTakenDiff()->save($d);
                        }
                    }
                    if ($p->timeline->damageTakenPerMinDeltas) {
                        foreach ($p->timeline->damageTakenPerMinDeltas as $key => $delta) {
                            $d = new DamageTakenDelta;
                            $d->value = $delta;
                            $d->period = $key;
                            $timeline->damageTaken()->save($d);
                        }
                    }
                    if ($p->timeline->goldPerMinDeltas) {
                        foreach ($p->timeline->goldPerMinDeltas as $key => $delta) {
                            $d = new GoldDelta;
                            $d->value = $delta;
                            $d->period = $key;
                            $timeline->gold()->save($d);
                        }
                    }
                    if ($p->timeline->xpDiffPerMinDeltas) {
                        foreach ($p->timeline->xpDiffPerMinDeltas as $key => $delta) {
                            $d = new XpDiffDelta;
                            $d->value = $delta;
                            $d->period = $key;
                            $timeline->xpDiff()->save($d);
                        }
                    }
                    if ($p->timeline->xpPerMinDeltas) {
                        foreach ($p->timeline->xpPerMinDeltas as $key => $delta) {
                            $d = new XpDelta;
                            $d->value = $delta;
                            $d->period = $key;
                            $timeline->xp()->save($d);
                        }
                    }
                }

                if ($p->runes) {
                    foreach ($p->runes as $r) {
                        $rune = new Rune;
                        $rune->fill($r->getData());
                        $participant->runes()->save($rune);
                    }
                }
                if ($p->masteries) {
                    foreach ($p->masteries as $m) {
                        $mastery = new Mastery;
                        $mastery->fill($m->getData());
                        $participant->masteries()->save($mastery);
                    }
                }
            }

        });
    }

    /**
     * @param Summoner $summoner
     * @param $champion
     * @param null $queue
     * @param Carbon|null $start
     * @param Carbon|null $end
     * @return ChampionStats
     */
    public function summonerChampionStats(
        Summoner $summoner,
        $champion,
        $queue = null,
        Carbon $start = null,
        Carbon $end = null
    ) {
        return $this->summonerStatsAll($summoner, $queue, $champion, $start, $end)->first();
    }

    /**
     * @param Summoner $summoner
     * @param null $queue
     * @param null $champion
     * @param Carbon|null $start
     * @param Carbon|null $end
     * @param null $season
     * @return ChampionStats[]
     */
    public function summonerStatsAll(
        Summoner $summoner,
        $queue = null,
        $champion = null,
        Carbon $start = null,
        Carbon $end = null,
        $season = null
    ) {
        $select = [
            DB::raw('sum(kills) as kills'),
            DB::raw('sum(deaths) as deaths'),
            DB::raw('sum(assists) as assists'),
            DB::raw('sum(win) as wins'),
            DB::raw('sum(totalMinionsKilled + neutralMinionsKilled) as cs'),
            DB::raw('sum(doubleKills) as doubleKills'),
            DB::raw('sum(tripleKills) as tripleKills'),
            DB::raw('sum(quadraKills) as quadraKills'),
            DB::raw('sum(pentaKills) as pentaKills'),
            DB::raw('sum(unrealKills) as unrealKills'),
            DB::raw('sum(visionScore) as visionScore'),
            DB::raw('sum(firstBloodKill + firstBloodAssist) as firstBloods'),
            DB::raw('sum(wardsPlaced) as wards'),
            DB::raw('sum(gameDuration) as playtime'),
            DB::raw('count(m.id) as totalGames'),
            DB::raw('min(gameCreation) as oldestGame'),
        ];
        $data = DB::table('players as p')
            ->join('participant_identities as pi', 'p.participant_identity_id', '=', 'pi.id')
            ->join('matches as m', 'pi.match_id', '=', 'm.id')
            ->join('participants as part', function ($join) {
                $join->on('part.match_id', '=', 'm.id')
                    ->on('pi.participantId', '=', 'part.participantId');
            })
            ->join('participant_stats as ps', function ($join) {
                $join->on('part.id', '=', 'ps.participant_id')
                    ->on('ps.participantId', '=', 'pi.participantId');
            })
            ->where('accountId', $summoner->accountId);

        if ($champion) {
            $data = $data->where('championId', $champion->key);
        } else {
            $data = $data->groupBy('championId');
            $select[] = 'championId';
        }
        if ($queue) {
            $data = $data->where('queueId', $queue);
        }
        if ($season) {
            $data = $data->where('seasonId', $season);
        }
        if ($start && $end) {
            $data = $data->whereBetween('gameCreation', [$start->valueOf(), $end->valueOf()]);
        }
        $championStats = collect();
        foreach ($data->select($select)->orderBy('totalGames', 'desc')->get() as $cs) {
            $championStats->push(new ChampionStats((array)$cs));
        }
        return $championStats;
    }
}
