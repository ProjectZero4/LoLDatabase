<?php


namespace ProjectZero\LolDatabase;


interface RateLimitInterface
{

    public function addCount(): void;

    public function canQuery(): bool;

    public function getCount(): int;
}
