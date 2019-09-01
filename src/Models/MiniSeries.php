<?php
/**
 * Created by PhpStorm.
 * User: josh
 * Date: 07/04/2019
 * Time: 17:54
 */

namespace ProjectZero\LoLDatabase\Models;

/**
 * Class MiniSeries
 * @package App\Models
 * @property-read int id
 * @property string created_at
 * @property string updated_at
 * @property string progress
 * @property int losses
 * @property int target
 * @property int wins
 */
class MiniSeries extends Base
{
    protected $table = "mini_series";

    protected $fillable = [
        'progress',
        'losses',
        'target',
        'wins'
    ];

}
