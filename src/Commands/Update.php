<?php

namespace ProjectZero\LoLDatabase\Commands;

use Illuminate\Console\Command;
use ProjectZero\LolDatabase\LoLDatabase;
use ProjectZero\LoLDatabase\Models\Summoner;
use ProjectZero\LoLDatabase\Models\SummonerRegistry;
use Throwable;

class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'LoLDatabase:update {--registered=false} {--season=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processes summoner data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param LoLDatabase $api
     * @throws Throwable
     */
    public function handle(LoLDatabase $api)
    {
        switch ($registeredOnly = $this->option('registered')) {
            case "true":
                $summoners = [];
                foreach (SummonerRegistry::all() as $summonerRegistry) {
                    $api->setRegion($summonerRegistry->region);
                    $summoners[] = $api->summoner($summonerRegistry->summonerId);
                };
                break;
            default:
                $summoners = Summoner::all();
                break;
        }
        $this->info('Starting YourOrange:Update');
        $summonerCount = is_array($summoners) ? count($summoners) : $summoners->count();
        $this->info('Summoner Count = ' . $summonerCount);
        $season = $this->option('season');
        foreach ($summoners as $k => $summoner) {
            $this->info("Now Processing {$summoner->name} (" . ($k + 1) . " / $summonerCount)");
            $api->setRegion($summoner->region);
            $start = time();
            // Get/Store all match data for a summoner
            $api->processMatchesBySummoner($summoner, $season);
            // Update league info (ranked)
            $api->leagueBySummonerAll($summoner);
            $registry = SummonerRegistry::firstOrNew(['summonerId' => $summoner->id]);
            $registry->processed = true;
            $registry->save();
            $totalTime = time() - $start;
            $this->info("Processing Took {$totalTime} seconds");
        }
        $this->info('Ending YourOrange:Update');
    }
}
