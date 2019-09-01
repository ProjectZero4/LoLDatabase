<?php


namespace ProjectZero\LoLDatabase\Models;

/**
 * Class Queue
 * @package App\Models
 * @property-read int id
 * @property int map_id
 * @property string description
 * @property string notes
 * @property string name
 * @property string queue_type
 */
class Queue extends Base
{
    protected $table = "queues";

    public function map()
    {
        return $this->belongsTo(Map::class);
    }
}
