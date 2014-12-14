<?php
/**
 * Created by PhpStorm.
 * User: bbarters
 * Date: 30-11-2014
 * Time: 12:12
 */

class SoccerLeague extends Eloquent
{

    protected $table='soccerleague';

    public $timestamps=false;

    //Relationships

    public function getTeams()
    {
        return $this->hasMany('SoccerTeam','league');
    }

    public function getSchedule()
    {
        return $this->hasMany('SoccerSchedule','league');
    }

} 