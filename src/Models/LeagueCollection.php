<?php


namespace ProjectZero\LoLDatabase\Models;


use Illuminate\Support\Collection;

class LeagueCollection extends Collection
{
    private $leagueOrder = [
        'IRON' => 0,
        'BRONZE' => 1,
        'SILVER' => 2,
        'GOLD' => 3,
        'PLATINUM' => 4,
        'DIAMOND' => 5,
        'MASTER' => 6,
        'GRANDMASTER' => 7,
        'CHALLENGER' => 8,
    ];

    /**
     * @return League
     */
    public function getHighestLeague()
    {
        $highestLeague = null;
        foreach ($this as $league) {
            /**
             * @var League $league
             */
            if (!isset($highestLeague)) {
                $highestLeague = $league;
                continue;
            }

            if ($this->leagueOrder[$league->tier] >= $this->leagueOrder[$highestLeague->tier] && $league->leaguePoints > $highestLeague->leaguePoints) {
                $highestLeague = $league;
            }
        }
        return $highestLeague;
    }
}
