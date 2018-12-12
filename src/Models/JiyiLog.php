<?php

namespace Onmpw\JiyiLog\Models;

use Illuminate\Database\Eloquent\Model;

class JiyiLog extends Model
{
    protected $table = "jiyilog_api";

    protected $dateFormat = "Y-m-d H:i:s";

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'update_at';

    protected $fillable = ['api_name','access_param','client_ip','access_time'];


    public static function store($data)
    {
        $flag = true;
        foreach($data as $insert) {
            if(!self::create($insert)){
                $flag = false;
            }
        }
        return $flag;
    }

    /**
     * Get the relationships for the entity.
     *
     * @return array
     */
    public function getQueueableRelations()
    {
        // TODO: Implement getQueueableRelations() method.
    }

    /**
     * Get the connection of the entity.
     *
     * @return string|null
     */
    public function getQueueableConnection()
    {
        // TODO: Implement getQueueableConnection() method.
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value)
    {
        // TODO: Implement resolveRouteBinding() method.
    }
}
