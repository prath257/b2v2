<?php

class FriendsController extends \BaseController
{

	public static $user=null;

	//this is the function to Add friend
/*   public function searchFriends()
   {

       $friends1=DB::table('friends')->where('friend1','=',Auth::user()->id)->where('status','=','accepted')->lists('friend2');
       $friends2=DB::table('friends')->where('friend2','=',Auth::user()->id)->where('status','=','accepted')->lists('friend1');
       $friends = array_merge($friends1, $friends2);
       $friendCount=count($friends);

       $requests=DB::table('friends')->where('friend2','=',Auth::user()->id)->where('status','=','sent')->lists('friend1');
       $prequests=DB::table('friends')->where('friend1','=',Auth::user()->id)->where('status','=','sent')->lists('friend2');

       $newFriendRequests=count($requests);
       $pendingSentRequests=count($prequests);
       return View::make('friendList')->with('allFriends',$friends)->with('allRequests',$requests)->with('allPendingRequests',$prequests)->with('friends',$friendCount)->with('newFriendRequests',$newFriendRequests)->with('pendingSentRequests',$pendingSentRequests);

   }*/



    public function searchFriends()
    {
        if(Auth::check())
        {

        $keyword=Input::get('searchWord');
        $search=Input::get('search');

        $searchFrnd=new \Illuminate\Database\Eloquent\Collection();


        $friends1=DB::table('friends')->where('friend1','=',Auth::user()->id)->where('status','=','accepted')->lists('friend2');
        $friends2=DB::table('friends')->where('friend2','=',Auth::user()->id)->where('status','=','accepted')->lists('friend1');
        $friends = array_merge($friends1, $friends2);

        foreach ($friends as $friend)
        {
            $fname=User::find($friend)->first_name;
            $lname=User::find($friend)->last_name;
            $fname=$fname." ".$lname;

            if(Str::contains(Str::lower($fname),Str::lower($keyword)))
            {
                $searchFrnd->add($friend);
            }
        }

       // return View::make('searchedFriends')->with('friends',$searchFrnd);

     $totalResult="";
     $divStart="<div class='col-lg-12 friend-row'>";
     $divEnd="</div>";
      $i=0;
      $res="";
     $tot=count($searchFrnd);

        foreach ($searchFrnd as $aF)
        {
            $i++;

              $res=$res.'<div class="col-lg-2 noPadding userDiv" id="allFriends'.$aF.'"><img class="col-lg-12 socialImages" src="'.User::find($aF)->profile->profilePic.'" height="50px" style="border-radius: 50%; box-shadow: 0px 0px 10px silver">
              <div class="col-lg-2 col-lg-offset-5 noPadding" title="Unfriend" style="text-align: center; cursor: pointer; background-color: #222; border-radius: 50%; color: #ffffff; position: absolute; margin-top: 60px; box-shadow: 0px 0px 10px white"  onclick="deleteFriend('.$aF.')">
              <span class="glyphicon glyphicon-minus"></span></div>
              <div class="col-lg-12">&nbsp;</div><div class="col-lg-12 noPadding">
              <p class="col-lg-12 noPadding relationName">'.User::find($aF)->first_name.' '.User::find($aF)->last_name.'</p>
              <a href="'.route('user',User::find($aF)->username).'" class="col-lg-12 noPadding userName">'.'@'.User::find($aF)->username.'</a></div></div>';

            if($i%6==0&&$i!=0)
            {
                $totalResult= $totalResult.$divStart.$res.$divEnd;
                $res="";
            }


            if($i==$tot&&$i%6!=0)
            {
                $totalResult=$totalResult.$divStart.$res.$divEnd;
            }

        }

     //   if($tot%6!=0&&$tot>0)


        if(Str::length($totalResult)!=0)
           return $totalResult;
        else
           return "<p>NO Result Found</p>";
    }
        else
            return 'wH@tS!nTheB0x';
    }



	public function addFriend($id)
	{
        if(Auth::check())
        {
		$date=new DateTime();
        if (Input::get('reason') != '')
		    DB::table('friends')->insert(array('friend1' => Auth::user()->id, 'friend2' => $id,'status'=>'sent','reason'=>Input::get('reason'),'created_at'=>$date,'updated_at'=>$date));
        else
            DB::table('friends')->insert(array('friend1' => Auth::user()->id, 'friend2' => $id,'status'=>'sent','created_at'=>$date,'updated_at'=>$date));

		//$rid=DB::table('friends')->where('friend1','=',Auth::user()->id)->where('friend2','=',$id)->lists('id');
		$rid = DB::table('friends')->where('friend1', Auth::user()->id)->where('friend2',$id)->pluck('id');

        AjaxController::insertToNotification($id,Auth::user()->id,"friendR"," sent you a Friend Request ",'http://b2.com/user/'.User::find(Auth::user()->id)->username);

		FriendsController::$user = User::find($id);

        if (FriendsController::$user->settings->notifications)
        {
            Mail::send('mailers', array('user'=>Auth::user(), 'receiver'=>FriendsController::$user,'page'=>'newFriendRequestMailer'), function($message)
            {
                $message->to(FriendsController::$user->email,FriendsController::$user->first_name)->subject('New Friend Request!');
            });
        }
	}
        else
            return 'wH@tS!nTheB0x';
    }

    //this is the function to accept the friend request

    public function acceptFriend($id)
    {
        if(Auth::check())
        {
            $date=new DateTime();
            DB::table('friends')->where('friend1','=',$id)->where('friend2','=',Auth::user()->id)->update(array('status' => 'accepted','updated_at'=>$date));

            $friendid = DB::table('friends')->where('friend1','=',$id)->where('friend2','=',Auth::user()->id)->pluck('id');


            /*Action::postAction('F new',$id,Auth::user()->id,null);*/

            Auth::user()->profile->ifc += Auth::user()->settings->friendcost;
            Auth::user()->profile->save();
            $user = User::find($id);
            $user->profile->ifc -= Auth::user()->settings->friendcost;
            $user->profile->save();

            DB::table('notification')->where('userid','=',Auth::user()->id)->where('cuserid','=',$id)->where('type','=','friendR')->update(array('type' =>'friendRR'));

            TransactionController::insertToManager(Auth::user()->id,"+".Auth::user()->settings->friendcost,"Accepted friend request by",'http://b2.com/user/'.$user->username,$user->first_name.' '.$user->last_name,"content");

            TransactionController::insertToManager($user->id,"-".Auth::user()->settings->friendcost,"Friend request accepted by",'http://b2.com/user/'.Auth::user()->username,Auth::user()->first_name.' '.Auth::user()->last_name,"profile");

            AjaxController::insertToNotification($id,Auth::user()->id,"friendRR","Accepted your Friend Request ",'http://b2.com/user/'.User::find(Auth::user()->id)->username);

            FriendsController::$user = $user;

            if (FriendsController::$user->settings->notifications)
            {
                Mail::send('mailers', array('user'=>Auth::user(), 'receiver'=>FriendsController::$user,'page'=>'friendRequestAcceptedMailer'), function($message)
                {
                    $message->to(FriendsController::$user->email,FriendsController::$user->first_name)->subject('Friend Request Accepted!');
                });
            }
        }
        else
            return 'wH@tS!nTheB0x';
    }


    //this is the function to suspend the friend request
	public function declineFriend($id)
	{
        if(Auth::check())
        {
        $nid = DB::table('friends')->where('friend1','=',$id)->where('friend2','=',Auth::user()->id)->pluck('id');

        DB::table('notification')->where('userid','=',Auth::user()->id)->where('cuserid','=',$id)->where('type','=','friendR')->update(array('type' =>'friendRR'));

		DB::table('friends')->where('friend1','=',$id)->where('friend2','=',Auth::user()->id)->delete();
	}
        else
            return 'wH@tS!nTheB0x';
    }

    //this is the function to suspend the friend request
    public function cancelRequest($id)
    {
        if(Auth::check())
        {
        $nid = DB::table('friends')->where('friend2','=',$id)->where('friend1','=',Auth::user()->id)->pluck('id');

        Notifications::where('userid','=',$id)->where('cuserid','=',Auth::user()->id)->where('type','=','FriendR')->delete();

        DB::table('friends')->where('friend2','=',$id)->where('friend1','=',Auth::user()->id)->delete();
    }
        else
            return 'wH@tS!nTheB0x';
    }

	//this is the function to delete friends
	public function deleteFriend($id)
	{
        if(Auth::check())
        {
            $friend = DB::table('friends')->where('friend1','=',$id)->where('friend2','=',Auth::user()->id)->first();
            $friend2 = DB::table('friends')->where('friend2','=',$id)->where('friend1','=',Auth::user()->id)->first();

            if ($friend)
            {
                $nid = $friend = DB::table('friends')->where('friend1','=',$id)->where('friend2','=',Auth::user()->id)->pluck('id');
                DB::table('friends')->where('friend1','=',$id)->where('friend2','=',Auth::user()->id)->delete();
            }
            else if ($friend2)
            {
                $nid = $friend2 = DB::table('friends')->where('friend2','=',$id)->where('friend1','=',Auth::user()->id)->pluck('id');
                DB::table('friends')->where('friend2','=',$id)->where('friend1','=',Auth::user()->id)->delete();
            }

        }
        else
            return 'wH@tS!nTheB0x';
    }
	//this is the method to showcase all the friends

	public function getFriends()
	{
		$userid=Auth::user()->id;
	    $friends1=DB::table('friends')->where('friend1','=',$userid)->where('status','=','accepted')->lists('friend2');
		$friends2=DB::table('friends')->where('friend2','=',$userid)->where('status','=','accepted')->lists('friend1');
		$friends = array_merge($friends1, $friends2);
		$requests=DB::table('friends')->where('friend2','=',$userid)->where('status','=','sent')->lists('friend1');
		$prequests=DB::table('friends')->where('friend1','=',$userid)->where('status','=','sent')->lists('friend2');

		$users1=new \Illuminate\Database\Eloquent\Collection();
		$users2=new \Illuminate\Database\Eloquent\Collection();
		$users3=new \Illuminate\Database\Eloquent\Collection();
		foreach($friends as $f)
		{
			$users1->add(User::find($f));
		}
		foreach($requests as $f)
		{
			$users2->add(User::find($f));
		}
		foreach($prequests as $f)
		{
			$users3->add(User::find($f));
		}

		return View::make('showFriends')->with('friends',$users1)->with('requests',$users2)->with('prequests',$users3);
	}


    public function loadMoreFriends()
    {
        if(Auth::check())
        {
        $friends1=DB::table('friends')->where('friend1','=',Auth::user()->id)->where('status','=','accepted')->lists('friend2');
        $friends2=DB::table('friends')->where('friend2','=',Auth::user()->id)->where('status','=','accepted')->lists('friend1');
        $friends = array_merge($friends1, $friends2);
        $moreFriends = array_slice($friends, Input::get('friendsCount')+6, 6);
        $moreFriends = count($moreFriends);
        $friends = array_slice($friends, Input::get('friendsCount'), 6);

        return View::make('loadmorefriends')->with('friends',$friends)->with('remaining',$moreFriends)->with('friendsCount',Input::get('friendsCount'));
    }
        else
            return 'wH@tS!nTheB0x';
    }
    public function loadMoreSubscribers()
    {
        if(Auth::check())
        {
        $allSubscribers=DB::table('subscriptions')->where('subscribed_to_id','=',Auth::user()->id)->lists('subscriber_id');
        $moreSubscribers = array_slice($allSubscribers, Input::get('subscribersCount')+6, 6);
        $moreSubscribers = count($moreSubscribers);
        $subscribers = array_slice($allSubscribers, Input::get('subscribersCount'), 6);

        return View::make('loadmoresubscribers')->with('subscribers',$subscribers)->with('remaining',$moreSubscribers)->with('subscribersCount',Input::get('subscribersCount'));
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function loadMoreSubscriptions()
    {
        if(Auth::check())
        {
        $allSubscriptions=DB::table('subscriptions')->where('subscriber_id','=',Auth::user()->id)->lists('subscribed_to_id');
        $moreSubscriptions = array_slice($allSubscriptions, Input::get('subscriptionsCount')+6, 6);
        $moreSubscriptions = count($moreSubscriptions);
        $subscriptions = array_slice($allSubscriptions, Input::get('subscriptionsCount'), 6);

        return View::make('loadmoresubscriptions')->with('subscriptions',$subscriptions)->with('remaining',$moreSubscriptions)->with('subscriptionsCount',Input::get('subscriptionsCount'));
    }
        else
            return 'wH@tS!nTheB0x';
    }
}
