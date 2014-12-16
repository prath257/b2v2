<?php
/**
 * Created by PhpStorm.
 * User: bbarters
 * Date: 30-11-2014
 * Time: 13:10
 */

class SoccerScorePredictions extends Eloquent
{

    protected $table='soccerscorepredictions';

    public $timestamps=false;



    //relationships

    public function getScoreUsers()
    {
        return $this->hasMany('User','user_id');
    }

    public function getScorersUsers()
    {
        return $this->hasMany('User','user_id');
    }
} 