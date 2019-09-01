<?php
/**
 * Created by PhpStorm.
 * User: josh
 * Date: 07/04/2019
 * Time: 11:58
 */

namespace ProjectZero\LoLDatabase\Models;


use Illuminate\Database\Eloquent\Model;

abstract class Base extends Model
{
    /**
     * You can define the settings for this in config/loldatabase.php
     *
     * @var string
     */
    protected $connection = "loldatabase";

    /**
     * Amount of seconds that need to pass for the cache to be updated
     *
     * @var int
     */
    protected $expires_after = 0;

    /**
     * Will return true if $expires_after seconds have passed since the row was last updated
     *
     * @return bool
     */
    public function expired()
    {
        if ($this->expires_after === 0) {
            return false;
        }
        if (!isset($this->updated_at)) {
            return true;
        }
        $time = time();
        return $this->updated_at->timestamp < ($time - $this->expires_after);
    }
}
