<?php
/**
 * Created by PhpStorm.
 * User: ParthVaidya
 * Date: 8/6/14
 * Time: 7:07 PM
 */

class Subscribe
{
    public static function isBlocked($id)
    {
        $subscribe=DB::table('subscriptions')->where('subscriber_id',$id)->where('subscribed_to_id',Auth::user()->id)->first();

        if ($subscribe)
        {
            if($subscribe->blocked==true)
                return true;
            else
                return false;
        }
    }
} 