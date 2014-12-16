<?php
/**
 * Created by PhpStorm.
 * User: bbarters
 * Date: 29-11-2014
 * Time: 17:41
 */

class SoccerPlayer extends Eloquent
{

    protected $table='soccerplayer';

    public $timestamps=false;

    //relationships

    public function getTeam()
    {
        return $this->belongsTo('SoccerTeam','team');
    }

    public function getGoals()
    {
        return $this->hasMany('SoccerScorer','player_id');
    }



} 