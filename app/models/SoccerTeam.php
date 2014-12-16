<?php
/**
 * Created by PhpStorm.
 * User: bbarters
 * Date: 29-11-2014
 * Time: 17:40
 */

class SoccerTeam extends Eloquent
{

    protected $table='soccerteam';

    public $timestamps=false;

    //relationships
    public function getPlayers()
    {
        return $this->hasMany('SoccerPlayer','team');
    }

    public function getHomeSchedule()
    {
        return $this->hasMany('SoccerSchedule','hometeam');
    }
    public function getAwaySchedule()
    {
        return $this->hasMany('SoccerSchedule','awayteam');
    }


} 