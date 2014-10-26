<?php
/**
 * Created by PhpStorm.
 * User: kaustubh.joshi
 * Date: 6/8/14
 * Time: 9:59 AM
 */

class Friend
{


	//A function to determine if the logged in user is friends with given user

	public static function isFriend($id)
	{
		$userid=$id;
		$friends1=DB::table('friends')->where('friend1','=',$userid)->where('friend2','=',Auth::user()->id)->where('status','=','accepted')->lists('friend2');
		$friends2=DB::table('friends')->where('friend2','=',$userid)->where('friend1','=',Auth::user()->id)->where('status','=','accepted')->lists('friend1');
		$friends = array_merge($friends1, $friends2);
		if(count($friends)>0)
			return true;
		else
			return false;
	}

    public static function isSubscriber($id)
    {
        $userid=$id;
        $subscriber=DB::table('subscriptions')->where('subscribed_to_id','=',$userid)->where('subscriber_id','=',Auth::user()->id)->first();

        if(count($subscriber)>0)
            return true;
        else
            return false;
    }

	//this is the function which returns the total number of friends of a given user
	public static function friendsCount($id)
	{
		$userid=$id;
		$friends1=DB::table('friends')->where('friend1','=',$userid)->where('status','=','accepted')->lists('friend2');
		$friends2=DB::table('friends')->where('friend2','=',$userid)->where('status','=','accepted')->lists('friend1');
		$friends = array_merge($friends1, $friends2);
		return count($friends);
	}

    //This is the function to get all friends of a given userid
    public static function getFriends($id)
    {
        $userid=$id;
        $friends1=DB::table('friends')->where('friend1','=',$userid)->where('status','=','accepted')->lists('friend2');
        $friends2=DB::table('friends')->where('friend2','=',$userid)->where('status','=','accepted')->lists('friend1');
        $friends = array_merge($friends1, $friends2);
        return $friends;
    }

    //Function to check if the request is sent by Auth user to userid and is pending
    public static function requestSent($id)
    {
        $userid=$id;
        $friends=DB::table('friends')->where('friend2','=',$userid)->where('friend1','=',Auth::user()->id)->where('status','=','sent')->first();
        if(count($friends)>0)
            return true;
        else
            return false;
    }

    //Function to check if request is sent to auth user by userid and is pending
    public static function requestNotYetAccepted($id)
    {
        $userid=$id;
        $friends=DB::table('friends')->where('friend1','=',$userid)->where('friend2','=',Auth::user()->id)->where('status','=','sent')->first();
        if(count($friends)>0)
            return true;
        else
            return false;
    }
} 