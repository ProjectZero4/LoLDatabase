<?php

namespace ProjectZero\LoLDatabase;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use ProjectZero\LoLDatabase\Commands\Update;
use RiotAPI\LeagueAPI\LeagueAPI;

class LoLDatabaseProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->loadRoutesFrom(__DIR__ . "/web.php");
        $this->loadMigrationsFrom(__DIR__ . "migrations");
        $this->commands([Update::class]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LoLDatabase::class, function () {
            $api_provider = new LeagueAPI([
                LeagueAPI::SET_KEY => env('RIOT_API_KEY'),
                LeagueAPI::SET_REGION => YourRegion::EUROPE_WEST
            ]);
            $request = app(Request::class);
            $region = $request->route('region') ?: YourRegion::EUROPE_WEST;
            try {
                $api = new LoLDatabase($api_provider, $region);
            } catch (Exception $e) {
                abort(500, 'The region you specified (' . $region . ') is not valid.');
            }
            $request->request->remove('region');
            return $api;
        });
    }
}
