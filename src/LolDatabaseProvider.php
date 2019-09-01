<?php

namespace App\Providers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use ProjectZero\LoLDatabase\YourOrange;
use ProjectZero\LoLDatabase\YourRateLimit;
use ProjectZero\LoLDatabase\YourRegion;
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
        $this->loadRoutesFrom(__DIR__ . "/routes.php");
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(YourOrange::class, function () {
            $api_provider = new LeagueAPI([
                LeagueAPI::SET_KEY => env('RIOT_API_KEY'),
                LeagueAPI::SET_REGION => YourRegion::EUROPE_WEST
            ]);
            $request = app(Request::class);
            $region = $request->route('region') ?: YourRegion::EUROPE_WEST;
            try {
                $api = new YourOrange($api_provider, $region);
                if (env('RIOT_API_USE_INTERNAL_RATE_LIMIT')) {
                    $api->addRateLimitProvider(new YourRateLimit([
                        'max' => env('RIOT_API_RATE_LIMIT'),
                        'duration' => env('RIOT_API_RATE_LIMIT_DURATION'),
                        'buffer' => env('RIOT_API_RATE_LIMIT_BUFFER'),
                        'wait' => env('RIOT_API_RATE_LIMIT_AUTO_WAIT'),
                        'autoCount' => env('RIOT_API_RATE_LIMIT_AUTO_COUNT'),
                        'verbose' => env('RIOT_API_RATE_LIMIT_VERBOSE', false),
                    ]));
                }
            } catch (Exception $e) {
                abort(500, 'The region you specified (' . $region . ') is not valid.');
            }
            $request->request->remove('region');
            return $api;
        });
    }
}
