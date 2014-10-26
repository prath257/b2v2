<?php
/**
 * Created by PhpStorm.
 * User: ParthVaidya
 * Date: 28/8/14
 * Time: 4:55 PM
 */

class BEvent extends Eloquent
{
    protected $table='events';

    public function getHost()
    {
        return $this->belongsTo('User','userid');
    }

    public function getGuestList()
    {
        return $this->belongsToMany('User','guest_list','event_id','user_id');
    }

    public function isAttending()
    {
        $attending=DB::table('guest_list')->where('event_id','=',$this->id)->where('user_id','=',Auth::user()->id)->get();
        if(count($attending)>0)
            return true;
        else
            return false;
    }
} 