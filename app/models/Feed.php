<?php
/**
 * Created by PhpStorm.
 * User: bbarters
 * Date: 12-12-2014
 * Time: 20:08
 */

class Feed extends Eloquent
{
    protected $table='feeds';

    //relationships

    public function getFeeds()
    {
        return $this->hasMany('FeedData','feed');
    }

    public function getMatch()
    {
        return $this->belongsTo('SoccerSchedule','match_id');
    }

}