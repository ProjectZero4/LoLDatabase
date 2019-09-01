<?php


namespace ProjectZero\LoLDatabase;


use Exception;

class YourRegion
{
    /**
     * Your Orange's names for regions
     */
    const BRAZIL = 'br';
    const EUROPE_EAST = 'eune';
    const EUROPE_WEST = 'euw';
    const JAPAN = 'jp';
    const KOREA = 'kr';
    const LATIN_AMERICA_NORTH = 'lan';
    const LATIN_AMERICA_SOUTH = 'las';
    const NORTH_AMERICA = 'na';
    const OCEANIA = 'oce';
    const RUSSIA = 'ru';
    const TURKEY = 'tr';
    /**
     * Riot's names for regions
     */
    const BRAZIL_RIOT = 'br1';
    const EUROPE_EAST_RIOT = 'eun1';
    const EUROPE_WEST_RIOT = 'euw1';
    const JAPAN_RIOT = 'jp1';
    const KOREA_RIOT = 'kr';
    const LATIN_AMERICA_NORTH_RIOT = 'la1';
    const LATIN_AMERICA_SOUTH_RIOT = 'la2';
    const NORTH_AMERICA_RIOT = 'na1';
    const OCEANIA_RIOT = 'oc1';
    const RUSSIA_RIOT = 'ru';
    const TURKEY_RIOT = 'tr1';
    /**
     * @var array
     */
    public static $list = array(
        self::BRAZIL => self::BRAZIL,
        self::EUROPE_EAST => self::EUROPE_EAST,
        self::EUROPE_WEST => self::EUROPE_WEST,
        self::JAPAN => self::JAPAN,
        self::KOREA => self::KOREA,
        self::LATIN_AMERICA_NORTH => self::LATIN_AMERICA_NORTH,
        self::LATIN_AMERICA_SOUTH => self::LATIN_AMERICA_SOUTH,
        self::NORTH_AMERICA => self::NORTH_AMERICA,
        self::OCEANIA => self::OCEANIA,
        self::RUSSIA => self::RUSSIA,
        self::TURKEY => self::TURKEY,
    );

    public static $riotConversion = array(
        self::BRAZIL => self::BRAZIL_RIOT,
        self::EUROPE_EAST => self::EUROPE_EAST_RIOT,
        self::EUROPE_WEST => self::EUROPE_WEST_RIOT,
        self::JAPAN => self::JAPAN_RIOT,
        self::KOREA => self::KOREA_RIOT,
        self::LATIN_AMERICA_NORTH => self::LATIN_AMERICA_NORTH_RIOT,
        self::LATIN_AMERICA_SOUTH => self::LATIN_AMERICA_SOUTH_RIOT,
        self::NORTH_AMERICA => self::NORTH_AMERICA_RIOT,
        self::OCEANIA => self::OCEANIA_RIOT,
        self::RUSSIA => self::RUSSIA_RIOT,
        self::TURKEY => self::TURKEY_RIOT,
    );

    /**
     * @param string $region
     * @return string
     * @throws Exception
     */
    public function getRegionName(string $region): string
    {
        $region = strtolower($region);
        if (!isset(static::$list[$region])) {
            throw new Exception("The region: {$region} is not supported. Please try a different region.");
        }

        return static::$list[$region];
    }

    public function convertToRiotRegion(string $region): string
    {
        $region = strtolower($region);
        if (!isset(static::$riotConversion[$region])) {
            throw new Exception("The region: {$region} is not supported. Please try a different region.");
        }
        return static::$riotConversion[$region];
    }
}
