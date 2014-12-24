<?php

class ProfileController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */


	public function buildProfile()
	{
        if (Auth::user()->pset==0)
        {
            if ($interests = DB::table('user_interests')->where('user_id',Auth::user()->id)->get())
            {
                DB::table('user_interests')->where('user_id',Auth::user()->id)->delete();
            }
            $interests = DB::table('user_interests')->select(DB::raw('count(interest_id) as votes, interest_id'))->groupBy('interest_id')->orderBy('votes','DESC')->take(10)->lists('interest_id');
            return View::make('profileBuilder')->with('TOPinterests',$interests);
        }
        else
        {
            return Redirect::route('home');
        }
	}

    public function getProfile()
    {
        $user=Auth::user();
        $interests=Auth::user()->interestedIn()->get();
        $oldpics=Auth::user()->getTrivia()->get();
        $subscribers=Auth::user()->getSubscribers()->get();
        $subscriptions=Auth::user()->getSubscribedTo()->get();
        $subsCount=count($subscribers);
        $subscripCount=count($subscriptions);
        $aboutHim=Auth::user()->about()->get();
        $questions=Auth::user()->questionsAskedToUser()->orderBy('updated_at','DESC')->paginate(2);
        $newQues = Auth::user()->questionsAskedToUser()->where('answer','=','')->get();
        $numQues = sizeof($newQues);
        $newAbout = Auth::user()->about()->where('status','=','new')->get();
        $numAbout = sizeof($newAbout);
        $follower=DB::table('subscriptions')->where('subscribed_to_id',$user->id)->where('subscriber_id',Auth::user()->id)->first();
        $friends1=DB::table('friends')->where('friend1','=',Auth::user()->id)->where('status','=','accepted')->lists('friend2');
        $friends2=DB::table('friends')->where('friend2','=',Auth::user()->id)->where('status','=','accepted')->lists('friend1');
        $friends = array_merge($friends1, $friends2);
        $friendCount=count($friends);
        $data=array('profile'=>Auth::user()->profile,'interests'=>$interests,'trivia'=>$oldpics,'user'=>$user,'sCount'=>$subsCount,'scCount'=>$subscripCount,'fCount'=>$friendCount,'about'=>$aboutHim,'questions'=>$questions,'follower'=>$follower,'numQues'=>$numQues,'numAbout'=>$numAbout);
        return View::make('profile',$data);
    }


    public function createProfile()
    {
        if(Auth::check())
        {
        //This is the time to create a user profile
        $profile=Profile::where('userid','=',Auth::user()->id)->first();
        $username=Auth::user()->username;
        //this is the code for storing the profile Picture
        $file = Input::file('profilePic');
        $file_name = $file->getClientOriginalName();
        $extension=Input::file('profilePic')->getClientOriginalExtension();
        $name=$username.'.'.$extension;
        //add this to trivia table too
        $tname=str_random(8).$name;
        $new_path='Users/'.$username.'/triviaPics/'.$tname;
        Image::make(Input::file('profilePic'))->resize(180, 200)->save($new_path);
        $trivia=new Trivia();
        $trivia->oldpic=asset($new_path);
        $trivia->userid=Auth::user()->id;
        $trivia->save();
        if (Input::file('profilePic')->move('Users/'.$username.'/Wallpics/',$name))
        {
            $quality = 90;
            $src  = 'Users/'.$username.'/Wallpics/'.$name;
            $img  = imagecreatefromjpeg($src);
            $width=(int)Input::get('w');
            $height=(int)Input::get('h');
            $x=(int)Input::get('x');
            $y=(int)Input::get('y');
            if($height==0 && $width==0)
            {
                if($x==0 && $y==0)
                {
                    $savedPath='Users/'.$username.'/Wallpics/'.$name;
                    Image::make($savedPath)->resize(180, 200)->save('Users/'.$username.'/profilePic/'.$name);
                }
            }
            else
            {
                $dest = ImageCreateTrueColor($width, $height);
                imagecopyresampled($dest, $img, 0, 0,$x,$y, $width, $height,$width,$height);
                imagejpeg($dest, 'Users/'.$username.'/profilePic/'.$name, $quality);
            }
            //Set the path in database and allocate IFCs
            $profile->profilePic=asset('Users/'.$username.'/profilePic/'.$name);
            $profile->coverPic=asset('Users/'.$username.'/Wallpics/'.$name);

        }
        else
        {
            return "Error uploading file";
        }

        $profile->save();
        return 'true';

    }
        else
            return 'wH@tS!nTheB0x';
    }

    //this will build the profile wall
	public function primaryBuilder()
	{
        if(Auth::check())
        {
		/*$i=Input::get("i");*/

		$primes=Input::get('prime');
        foreach($primes as $p)
        {
            $pid=DB::table('interests')->where('interest_name','=',$p)->first();
            $pinter=DB::table('user_interests')->where('user_id','=',Auth::user()->id)->where('interest_id','=',$pid->id)->update(array('type' => 'primary'));

        }
    	//Now at the end of the day, make sure his profile set flag is set to True
        $user=Auth::user();
		$user->pset=true;
		$user->save();

        $user->profile->ifc += 310;
        $user->profile->save();

        TransactionController::insertToManager($user->id,"+310","Profile Built","nope","nope","nope");

	    return "http://b2.com/profile";

	}
        else
            return 'wH@tS!nTheB0x';
    }
	//this function will save the about me part of the profile

	public function saveAbout()
	{
        if(Auth::check())
        {
		$profile=Auth::user()->profile()->first();
		$profile->aboutMe=Input::get('about');
		$profile->save();
		return "Saved";
	}
        else
            return 'wH@tS!nTheB0x';
    }

	//this is the function which will save the interests of the user
	public function saveInterests()
	{
        if(Auth::check())
        {
			/*$i=Input::get("i");*/
		/*	$irules = array('otheri' => 'required|unique:interests,interest');
			$validation =Validator::make(Input::only('otheri'),$irules);
			//if the validation fails, return to the index page with first error message
			if($validation->fails())
			{
				//find out this other interest in database and put it into pivot table
				$ointer=Interest::where('interest','=',Input::get('otheri'))->first();
				Auth::user()->interestedIn()->attach($ointer->id);
			}
			else
			{
				//put the new other interest into database and pivot
				$inter = new Interest();
				$inter->interest=Input::get('otheri');
				$inter->interest_name=Str::title(Input::get('otheri'));
				$inter->save();
				Auth::user()->interestedIn()->attach($inter->id);
			}*/

		//Now put all the interests into pivot table
		$iarray=Input::get('interests');
		foreach($iarray as $userInterest)
		{
			$finter=Interest::where('interest_name','=',$userInterest)->first();
            if(count($finter)==0)
            {
                $inter = new Interest();
                $inter->interest_name=$userInterest;
                $inter->save();
                Auth::user()->interestedIn()->attach($inter->id);

            }
            else
                Auth::user()->interestedIn()->attach($finter->id);
		}
		return "Success";

		}
        else
            return 'wH@tS!nTheB0x';
    }

	 //this is the code to edit the user profile

	public function getSettings($mode)
	{
        if(Auth::check())
        {
		$flag=0;
		$user = Auth::user();
		//$wallpics=Auth::user()->wall()->get();
		$oldInterests=$user->interestedIn()->get();
		$allInterests=Interest::all();
		/*$newInterests=new \Illuminate\Database\Eloquent\Collection();
		foreach($allInterests as $all)
		{
			$flag=0;
			foreach($oldInterests as $old)
			{
				if($all->id!=$old->id)
				{

				}
				else
					$flag=1;
			}
			if($flag==0)
			{
				$newInterests->add($all);
			}

		}*/
        /*$newInterests = DB::table('user_interests')->select(DB::raw('count(interest_id) as votes, interest_id'))->where('user_id','!=',Auth::user()->id)->groupBy('interest_id')->orderBy('votes','DESC')->take(5)->lists('interest_id');*/
		$settings = $user->settings;
		$data=array('user'=>$user,'oldInterests'=>$oldInterests, 'settings'=>$settings, 'mode'=>$mode);
		return View::make('settings',$data);
	    }
        else
        {
            if ($mode == 'ajax')
                return 'wH@tS!nTheB0x';
            else
                return Redirect::guest('/')->with('redirected','true');
        }
    }
	//this is the function to edit the profile Pic of the user

    public function postEditProfilePic()
    {
        if(Auth::check())
        {
        $profile=Auth::user()->profile()->first();
        $username=Auth::user()->username;
        $file = Input::file('profilePicChange');
        $file_name = $file->getClientOriginalName();
        $extension=Input::file('profilePicChange')->getClientOriginalExtension();
        $name=$username.'.'.$extension;

        if (Str::contains($profile->profilePic,'.jpg'))
            $ext = '.jpg';
        else if (Str::contains($profile->profilePic,'.jpeg'))
            $ext = '.jpeg';
        else if (Str::contains($profile->profilePic,'.png'))
            $ext = '.png';
        else if (Str::contains($profile->profilePic,'.gif'))
            $ext = '.gif';
        //this is the code to add to the trivia
        $new_path='Users/'.$username.'/triviaPics/'.str_random(8).$name;
        File::copy('Users/'.$username.'/profilePic/'.$username.$ext,$new_path);
        //put it into trivia table
        $trivia=new Trivia();
        $trivia->oldpic=asset($new_path);
        $trivia->userid=Auth::user()->id;
        $trivia->save();


        if (Input::file('profilePicChange')->move('Users/'.$username.'/Wallpics/',$name))
        {
            $quality = 90;
            $src  = 'Users/'.$username.'/Wallpics/'.$name;
            $img  = imagecreatefromjpeg($src);
            $width=(int)Input::get('w');
            $height=(int)Input::get('h');
            $x=(int)Input::get('x');
            $y=(int)Input::get('y');
            if($height==0 && $width==0)
            {

                    $savedPath='Users/'.$username.'/Wallpics/'.$name;
                    Image::make($savedPath)->resize(180, 200)->save('Users/'.$username.'/profilePic/'.$name);

            }
            else
            {
                $dest = ImageCreateTrueColor($width, $height);
                imagecopyresampled($dest, $img, 0, 0,$x,$y, $width, $height,$width,$height);
                imagejpeg($dest, 'Users/'.$username.'/profilePic/'.$name, $quality);
            }
            //Set the path in database and allocate IFCs
            $profile->profilePic=asset('Users/'.$username.'/profilePic/'.$name);
            $profile->coverPic=asset('Users/'.$username.'/Wallpics/'.$name);
            $profile->ifc+=50;

            TransactionController::insertToManager(Auth::user()->id,"+50","Changed profile picture","nope","nope","nope");
        }
        else
        {
            return "Error uploading file";
        }

        /*$destinationPath = "Users/".$username."/profilePic/";
        Image::make(Input::file('profilePic'))->resize(500, 500)->save($destinationPath.$name);
        $profile->profilePic=asset('Users/'.$username.'/profilePic/'.$name);*/

        $profile->save();
        return 'Users/'.$username.'/profilePic/'.$name;
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function postEditProfileTune()
	{
        if(Auth::check())
        {

		$profile=Auth::user()->profile()->first();
		$name = Input::file('profileTune')->getClientOriginalName();
		$extension=Input::file('profileTune')->getClientOriginalExtension();
		$username=Auth::user()->username;
		$name=$username.'.'.$extension;
		Input::file('profileTune')->move('Users/'.$username.'/profileTune/', $name);
		//Give him 50 bucks for doing it
		$profile->profileTune=asset('Users/'.$username.'/profileTune/'.$name);
		$profile->ifc+=50;
		$profile->save();

        TransactionController::insertToManager(Auth::user()->id,"+50","Changed profile tune","nope","nope","nope");

		return 'Users/'.$username.'/profileTune/'.$name;
	}
        else
            return 'wH@tS!nTheB0x';
    }
    //this is the code to update the about you in profile

	public function postEditAboutYou()
	{
        if(Auth::check())
        {
		$profile=Auth::user()->profile()->first();
		$profile->aboutMe=Input::get('about');
		$profile->save();
		return "Saved";
	}
        else
            return 'wH@tS!nTheB0x';
    }
    //this is the function which will update the user interests
    public function postEditInterests()
    {
        if(Auth::check())
        {
            $iarray=Input::get('newInterests');
            if($iarray!=null)
            {
                foreach($iarray as $userInterest)
                {
                    $finter=Interest::where('interest_name','=',$userInterest)->first();
                    if(count($finter)==0)
                    {
                        $inter = new Interest();
                        $inter->interest_name=$userInterest;
                        $inter->save();
                        Auth::user()->interestedIn()->attach($inter->id);

                    }
                    else
                        Auth::user()->interestedIn()->attach($finter->id);

                }
            }
            $oarray=Input::get('oldInterests');
            if($oarray!=null)
            {
                foreach($oarray as $userInterest)
                {
                    $finter=Interest::where('interest_name','=',$userInterest)->first();
                    Auth::user()->interestedIn()->detach($finter->id);
                }
            }

            $oldInterests=Auth::user()->interestedIn()->get();
            $allInterests=Interest::all();

            return View::make('interests')->with('oldInterests',$oldInterests);
    }

        else
            return 'wH@tS!nTheB0x';
    }
	public function getStatus()
	{
		$user = User::find(Input::get('id'));
		if ($user->isOnline==true)
			return "yesBwoy";
		else if ($user->isOnline==false)
			return "nopeBwoy";
	}

	public  function showContent($iid,$uid)
	{
		$interest = Interest::find($iid);
		$user = User::find($uid);

        if (Auth::user())
		    return View::make('content')->with('interest',$interest)->with('user',$user);
        else
            return View::make('dummyContent')->with('interest',$interest)->with('user',$user);
    }

	public function getIFCs()
	{
        if(Auth::check())
        {
		return Auth::user()->profile->ifc;
	}
        else
            return 'wH@tS!nTheB0x';
    }

    public function saveNewWallPic()
    {
        $cover = Input::file('cover');
        $random_name = str_random(8);
        $destinationPath = "Users/".Auth::user()->username."/Wallpics/";
        $extension = $cover->getClientOriginalExtension();
        $filename=$random_name.'.'.$extension;
        Input::file('cover')->move($destinationPath, $filename);

        $wallpic = new Wallpic();
        $wallpic->userid = Auth::user()->id;
        $wallpic->wallpic = $destinationPath.$filename;
        $wallpic->interest = Input::get('interest');
        $wallpic->save();
    }

    public function getFriendList($mode)
    {
        if(Auth::check())
        {
        $friends1=DB::table('friends')->where('friend1','=',Auth::user()->id)->where('status','=','accepted')->lists('friend2');
        $friends2=DB::table('friends')->where('friend2','=',Auth::user()->id)->where('status','=','accepted')->lists('friend1');
        $friends = array_merge($friends1, $friends2);
        $friendCount=count($friends);

        $requests=DB::table('friends')->where('friend2','=',Auth::user()->id)->where('status','=','sent')->lists('friend1');
        $prequests=DB::table('friends')->where('friend1','=',Auth::user()->id)->where('status','=','sent')->lists('friend2');

        $newFriendRequests=count($requests);
        $pendingSentRequests=count($prequests);
        return View::make('friendList')->with('allFriends',$friends)->with('allRequests',$requests)->with('allPendingRequests',$prequests)->with('friends',$friendCount)->with('newFriendRequests',$newFriendRequests)->with('pendingSentRequests',$pendingSentRequests)->with('mode',$mode);
        }
        else
        {
            if ($mode == 'ajax')
                return 'wH@tS!nTheB0x';
            else
                return Redirect::guest('/')->with('redirected','true');
        }
    }
    public function getSubscribersList($mode)
    {
        if(Auth::check())
        {
        $allSubscribers=DB::table('subscriptions')->where('subscribed_to_id','=',Auth::user()->id)->lists('subscriber_id');
        $subscribers=count($allSubscribers);

        $allSubscriptions=DB::table('subscriptions')->where('subscriber_id','=',Auth::user()->id)->lists('subscribed_to_id');
        $subscriptions=count($allSubscriptions);

        return View::make('subscribersList')->with('subscribers',$subscribers)->with('subscriptions',$subscriptions)->with('allSubscribers',$allSubscribers)->with('allSubscriptions',$allSubscriptions)->with('mode',$mode);
        }
        else
        {
            if ($mode == 'ajax')
                return 'wH@tS!nTheB0x';
            else
                return Redirect::guest('/')->with('redirected','true');
        }
    }

    public function manageInterests()
    {
        if(Auth::check())
        {
        $interests = Auth::user()->interestedIn()->get();
        foreach($interests as $i)
        {
            DB::table('user_interests')
                ->where('interest_id', $i->id)
                ->where('user_id', Auth::user()->id)
                ->update(array('type' => 'secondary'));
        }

        $primes=Input::get('prime');
        foreach($primes as $p)
        {
            DB::table('user_interests')
                ->where('interest_id', $p)
                ->where('user_id', Auth::user()->id)
                ->update(array('type' => 'primary'));

        }
        return 'Success!';
    }
        else
            return 'wH@tS!nTheB0x';
    }


}