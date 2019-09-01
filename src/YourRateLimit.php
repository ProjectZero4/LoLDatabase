<?php


namespace ProjectZero\LolDatabase;


use BadMethodCallException;

class YourRateLimit implements RateLimitInterface
{
    /**
     * @var int
     */
    protected $count = 0;
    /**
     * @var int
     */
    protected $max;
    /**
     * @var int
     */
    protected $buffer = 0;
    /**
     * @var int
     */
    protected $start;
    /**
     * @var int
     */
    protected $duration;
    /**
     * @var bool
     */
    protected $autoCount;
    /**
     * @var Callable
     */
    protected $callback;
    /**
     * @var bool
     */
    protected $wait;
    /**
     * @var bool
     */
    protected $verbose = false;
    /**
     * @var array
     */
    protected $configurable = [
        'max',
        'buffer',
        'duration',
        'autoCount',
        'callback',
        'wait',
        'verbose',
    ];
    /**
     * @var array
     */
    protected $required = [
        'max',
        'duration',
    ];

    /**
     * YourRateLimit constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        foreach ($options as $k => $v) {
            if ($this->isValid($k)) {
                $this->$k = $v;
            }
        }

        foreach ($this->required as $key) {
            if (!isset($this->$key)) {
                throw new BadMethodCallException('You have not specified a required option! Please specify ' . ucfirst($key));
            }
        }
    }

    /**
     * @param $key
     * @return bool
     */
    protected function isValid($key)
    {
        return in_array($key, $this->configurable);
    }

    /**
     * @return bool
     */
    public function canQuery(): bool
    {
        if ($queryable = $this->queryable()) {
            if ($this->autoCount) {
                $this->addCount();
            }
        }
        return $queryable;
    }

    /**
     * @return bool
     */
    protected function queryable()
    {
        $now = time();
        $refreshTime = $this->start + $this->duration;
        if ($refreshTime < $now) {
            $this->start = $now;
            $this->count = 0;
            if ($this->verbose) {
                $this->echo("RefreshTime is " . abs($refreshTime - $now) . " behind!");
                $this->echo("Resetting Rate Limit!");
            }
            return true; // Rate limit has refreshed - auto success
        }
        if ($this->count + $this->buffer >= $this->max) {
            if ($this->wait) {
                $sleep = $refreshTime - $now;
                if ($this->verbose) {
                    $this->echo("Sleeping For: " . abs($sleep) . " behind!");
                }
                sleep($sleep);
                return true;
            }
            if (isset($this->callback)) {
                $callback = $this->callback;
                $this->echo("Running Callback!");
                return (bool)$callback($refreshTime, $this->count);
            }

            return false;
        }
        return true;
    }

    protected function echo($message)
    {
        echo "{$message}" . PHP_EOL;
    }

    /**
     * Increments Count
     */
    public function addCount(): void
    {
        $this->count++;
        if ($this->verbose) {
            $this->echo("Rate Limit Count: {$this->count}");
        }
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }
}
