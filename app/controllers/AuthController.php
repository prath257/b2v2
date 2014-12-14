<?php

class AuthController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public static $user=null;

    public function getIndex()
    {
        $captcha = new Captcha;
        $cap = $captcha->make();

        $trending = new \Illuminate\Database\Eloquent\Collection();
        $recommended = new \Illuminate\Database\Eloquent\Collection();

        $trendingBlogBooks = BlogBook::where('review','=','passed')->orWhere('review','=','reviewed')->orderBy('users','DESC')->take(5)->get();
        foreach ($trendingBlogBooks as $trendingBlogBook)
        {
            $chapters = $trendingBlogBook->getChapters()->get();
            if (count($chapters) > 0)
                $trending->add($trendingBlogBook);
        }
        $trendingArticles = Article::where('review','=','passed')->orderBy('users','DESC')->take(5)->get();
        foreach ($trendingArticles as $trendingArticle)
        {
            $trending->add($trendingArticle);
        }
        $trendingResources = Resource::orderBy('users','DESC')->take(5)->get();
        foreach ($trendingResources as $trendingResource)
        {
            $trending->add($trendingResource);
        }
        $trendingCollaborations = Collaboration::orderBy('users','DESC')->take(5)->get();
        foreach ($trendingCollaborations as $trendingCollaboration)
        {
            $chapters = $trendingCollaboration->getChapters()->get();
            if (count($chapters) > 0)
                $trending->add($trendingCollaboration);
        }
        $trendingMedia = Media::where('ispublic','=',true)->orderBy('users','DESC')->take(5)->get();
        foreach ($trendingMedia as $trendingMed)
        {
                $trending->add($trendingMed);
        }
        $trendingSend = $trending->sortByDesc('users')->take(5);


        $review = Review::orderBy('ifc','DESC')->take(5)->get();
        foreach ($review as $r)
        {
            if ($r->type == 'book')
            {
                $chapters = BlogBook::find($r->contentid)->getChapters()->get();
                if (count($chapters) > 0 && (BlogBook::find($r->contentid)->review == 'reviewed'))
                    $recommended->add(BlogBook::find($r->contentid));
            }
            else if ($r->type == 'article')
            {
                if (Article::find($r->contentid)->review == 'passed')
                    $recommended->add(Article::find($r->contentid));
            }
        }

        if (Auth::user())
        {
            return View::make('index')->with('trending',$trendingSend)->with('recommended',$recommended);
        }
        else
        {
            return View::make('index')->with('cap', $cap)->with('trending',$trendingSend)->with('recommended',$recommended);
        }
    }


	public function postLogin()
	{
		//let's first validate the form:
		$validation =Validator::make(Input::all(),User::$login_rules);
		//if the validation fails, return to the index page with first error message
		if($validation->fails())
		{
			return Redirect::route('index')->withInput(Input::except('password'))->with('error',$validation->errors()->first());

		}
		else
		{
			//if everything looks okay, we try to authenticate the user
			// Set login credentials
			$credentials = array('username' => Input::get('uname'),'password' => Input::get('pwd'));
			// Try to authenticate the user, remember me is set to false
			Auth::attempt($credentials);
			if(Auth::check())
			{
				if(Auth::user()->activated)
				{
                    $user = Auth::user();
                    $ifcAdded = 'no';
                    $currentTime = new DateTime();
                    $lastSeen = $user->updated_at;
                    $diff=date_diff($lastSeen,$currentTime);
                    $d=intval($diff->format("%R%a"));
                    if($d>0)
                    {
                        if ($user->activated == true && $user->pset == true)
                        {
                            $profile = Profile::where('userid','=',$user->id)->first();
                            if (count($profile) > 0)
                            {
                                $profile->ifc += 50;
                                $profile->save();
                                $ifcAdded = 'yes';

                                $user->updated_at = $currentTime;

                                TransactionController::insertToManager($user->id,"+50","Bonus for visiting BBarters on ".$currentTime->format('d-m-Y'),"nope","nope","nope");
                            }
                        }
                    }

                    $user->isOnline = true;
                    $user->save();
					return Redirect::intended('home')->with('ifcAdded',$ifcAdded);

				}
				else
				{
                    Auth::logout();
					return Redirect::route('index')->with('error','Account Not Activated');
				}
			}
			//if everything went okay, we redirect to index route with success message
			else
			{
				return Redirect::route('index')-> withInput()->with('error','Login Failed - Invalid Credentials');
			}
		}
	}

	public function postSignup()
	{
		if (Session::get('my_captcha') !==Input::get('captcha'))
		{
			Session::flash('error', 'Captcha didn\'t Match.');
			return Redirect::route('index');
		}
		else
		{
                        
			$validation = Validator::make(Input::all(),User::$signup_rules);

			if($validation->passes())
			{
				$user= new User();
				$user->first_name=Str::title(Input::get('firstname'));
				$user->last_name=Str::title(Input::get('lastname'));
				$user->email = Input::get('email');
				$user->username = Input::get('username');
				$user->password = Hash::make(Input::get('password'));
				$user->country = Input::get('country');
				$user->gender=Input::get('gender');
				$user->save();
                try
				{

				if(	Mail::send('mailers', array('user'=>$user,'page'=>'activationMailer'), function($message)
					{
						$message->to(Input::get('email'),Input::get('firstname'))->subject('Welcome to BBarters!');
					}))
				{
                return View::make('checkMail');
				}
				else
				{
					$user->delete();
					return "<h2>Activation mail sending failure! Please try <a href='/'>here</a>again</h2>";

				}
				}
				catch(Exception $e)
				{
					$user->delete();
					return Redirect::route('index')->with('error','Email couldn\'t be sent, please try again!');
				}

			}
			else
			{
				return Redirect::route('index')->withInput(Input::except('password','cpassword'))->with('error',$validation->errors()->first());
			}
		}
	}

    //perform the activation

    public function getActivation($uid)
    {
        //this is how I encrypt and decrypt links, parameter parts of link
        $id=Crypt::decrypt($uid);
        $user=User::find($id);
        $user->activated=true;
        $user->save();
        //Here we create all the necessary directories for user
        $result = File::makeDirectory('Users/'.$user->username);
        if($result)
        {
            $result=File::makeDirectory('Users/'.$user->username.'/profilePic');
            $result=File::makeDirectory('Users/'.$user->username.'/profileTune');
            $result=File::makeDirectory('Users/'.$user->username.'/Wallpics');
            $result=File::makeDirectory('Users/'.$user->username.'/Books');
            $result=File::makeDirectory('Users/'.$user->username.'/Articles');
            $result=File::makeDirectory('Users/'.$user->username.'/Media');
            $result=File::makeDirectory('Users/'.$user->username.'/Resources');
            $result=File::makeDirectory('Users/'.$user->username.'/triviaPics');
            $result=File::makeDirectory('Users/'.$user->username.'/Collaborations');

            $invite=Invite::where('email','=',$user->email)->first();
            if ($invite)
            {
                if($invite->activated==1)
                {
                    $id=$invite->userid;
                    //this is the code where we give IFCs to people who sent the invitations
                    $benefactor=Profile::where('userid','=',$id)->first();
                    $benefactor->ifc += 300;
                    $benefactor->save();

                    TransactionController::insertToManager($id,"+300",$user->first_name." joined BBarters on your invitation","nope","nope","nope");

                    DB::table('friends')->insert(array('friend1'=>$id, 'friend2'=>$user->id, 'status'=>'accepted'));
                }
            }
            //this is the code to set the default user settings
            $uset=new UserSetting();
            $uset->userid=$user->id;
            $uset->save();

            $chatAudit=new Chataudit();
            $chatAudit->userid=$user->id;
            $chatAudit->save();

            //create a default profile
            $profile=new Profile();
            $profile->userid=$user->id;
            $profile->ifc=200;
            $profile->save();

            TransactionController::insertToManager($user->id,"+200","Start up ifc.","nope","nope","nope");

            $prath = User::where('username','=','prath257')->first();
            if ($prath)
                DB::table('friends')->insert(array('friend1'=>$prath->id, 'friend2'=>$user->id, 'status'=>'accepted'));
            $kastya = User::where('username','=','ksjoshi88')->first();
            if ($kastya)
                DB::table('friends')->insert(array('friend1'=>$kastya->id, 'friend2'=>$user->id, 'status'=>'accepted'));
            Auth::login($user);
            return Redirect::intended('home');
        }
        else
        {
            $user->delete();
            return Redirect::route('index')->with('error','Account is Not Activated! Signup Again!');
        }

    }



    public function getLogout()
    {
        //we simply log out the user
        $user = Auth::user();
        if($user)
        {
            $chats = Chat::where('status','=','ongoing')->where(function($query)
            {
                $query->where('user1', '=', Auth::user()->id)->orWhere('user2', '=', Auth::user()->id);
            })->get();

            if ($chats)
            {
                foreach ($chats as $chat)
                {
                    $chat->status = 'completed';
                    $chat->save();

                    $chatData = new ChatData();
                    $chatData->chatid = $chat->id;
                    $chatData->senderid = Auth::user()->id;
                    $chatData->text = 'Attention! The chat is over. '.Auth::user()->first_name.' left the chat.';
                    $chatData->save();
                }
            }

            if($user->fbid!=null)
            {
                $fauth = new Hybrid_Auth(app_path(). '/config/fb_auth.php');
                $fauth->logoutAllProviders();
            }
            if($user->twitterid!=null)
            {
                $tauth = new Hybrid_Auth(app_path(). '/config/tw_auth.php');
                $tauth->logoutAllProviders();
            }
            if($user->gid!=null)
            {
                $gauth = new Hybrid_Auth(app_path(). '/config/Google_auth.php');
                $gauth->logoutAllProviders();
            }
            Auth::logout();
            if ($user)
            {
                $user->isOnline = false;
                $user->save();
            }
            //then, we return to the index route with a success message
            return Redirect::to('/')->with('error','You have been logged out. Visit tomorrow to earn <b>50 ifcs</b>.');
        }
        else
        {
            return Redirect::to('/');
        }

    }

	//this is for fb login

	public function postFbLogin($auth = NULL)
	{


            if ($auth == 'auth')
            {
                try
                {
                    Hybrid_Endpoint::process();
                }
                catch (Exception $e)
                {
                    return Redirect::to('fbauth');
                }
                return;
            }
            try
            {
                $oauth = new Hybrid_Auth(app_path(). '/config/fb_auth.php');
                $provider = $oauth->authenticate('Facebook');
                $profile = $provider->getUserProfile();
            }
            catch(Exception $e)
            {
                return $e->getMessage();
            }
           //first thing is to check whether user exists in database or not
            $user=User::where('fbid','=',$profile->identifier)->first();
            if($user)
            {
                //this means user isn't logging in for the first time
                //So log him in with fixed facebook password
                Auth::attempt(array('username'=>$user->username,'password'=>'kastya_88fbadvait_b2'));
                if(Auth::check())
                {
                    //send him to home page, else login page

                    $ifcAdded = 'no';
                    $currentTime = new DateTime();
                    $lastSeen = $user->updated_at;
                    $diff=date_diff($lastSeen,$currentTime);
                    $d=intval($diff->format("%R%a"));
                    if($d>0)
                    {
                        if ($user->activated == true && $user->pset == true)
                        {
                            $profile = Profile::where('userid','=',$user->id)->first();
                            if (count($profile) > 0)
                            {
                                $profile->ifc += 50;
                                $profile->save();
                                $ifcAdded = 'yes';

                                $user->updated_at = $currentTime;
                                $user->save();

                                TransactionController::insertToManager($user->id,"+50","Bonus for visiting BBarters on ".$currentTime->format('d-m-Y'),"nope","nope","nope");
                            }
                        }
                    }

                    return Redirect::intended('http://b2.com/home')->with('ifcAdded',$ifcAdded);
                }
                else
                {
                    return View::make('errorPage')->with('error','there seems some problem in Facebook Login, please try again later!')->with('link','http://b2.com');
                }
            }
            else
            {
                    //this means this is first time facebook login
                    $users=User::all();

                    foreach($users as $user)
                    {
                        if($user->email==$profile->email)
                        {
                            return $user->email.' '.$profile->email;
                            return View::make('errorPage')->with('error','this email has already been registered!')->with('link','http://b2.com');
                        }
                    }
                    $user=new User();
                    $user->fbid=$profile->identifier;
                    $user->first_name=Str::title($profile->firstName);
                    $user->last_name=Str::title($profile->lastName);
                    $user->gender=$profile->gender;
                    $user->email=$profile->email;
                    $user->password=Hash::make('kastya_88fbadvait_b2');
                    $user->username='fbtemp'.$profile->identifier;
                    $user->country="Global";
                    $user->save();
                    //this is the code to set the default user settings
                    $uset=new UserSetting();
                    $uset->userid=$user->id;
                    $uset->save();
                    //setting  up his chatAudit
                    $chatAudit=new Chataudit();
                    $chatAudit->userid=$user->id;
                    $chatAudit->save();
                    //create a default profile
                    $uprofile=new Profile();
                    $uprofile->userid=$user->id;
                    $uprofile->ifc=200;
                    $uprofile->save();
                    TransactionController::insertToManager($user->id,"+200","Start up ifc.","nope","nope","nope");
                    return Redirect::to('firstFacebook/'.$profile->identifier);


            }

	}

    public function getFirstFacebook($fid)
    {
        $user = User::where('username','=','fbtemp'.$fid)->first();
        if ($user->activated == false)
            return View::make('getFirstFacebook')->with('facebookId',$fid);
        else
            return Redirect::route('home');
    }
    //performing the first time fbsignup activity
    public function postFacebookSignup()
    {

        $user=User::where('fbid','=',Input::get('fbid'))->first();

        if($user)
        {

            $user->username = Input::get('username');
            $user->country = Input::get('country');
            $user->activated=true;
            $user->save();
            $result = File::makeDirectory('Users/'.$user->username);
            if($result)
            {
                $result=File::makeDirectory('Users/'.$user->username.'/profilePic');
                $result=File::makeDirectory('Users/'.$user->username.'/profileTune');
                $result=File::makeDirectory('Users/'.$user->username.'/Wallpics');
                $result=File::makeDirectory('Users/'.$user->username.'/Books');
                $result=File::makeDirectory('Users/'.$user->username.'/Articles');
                $result=File::makeDirectory('Users/'.$user->username.'/Media');
                $result=File::makeDirectory('Users/'.$user->username.'/Resources');
                $result=File::makeDirectory('Users/'.$user->username.'/triviaPics');
                $result=File::makeDirectory('Users/'.$user->username.'/Collaborations');
                Auth::attempt(array('username'=>$user->username,'password'=>'kastya_88fbadvait_b2'));
                if(Auth::check())
                {
                    $invite=Invite::where('email','=',$user->email)->first();
                    if ($invite)
                    {
                        if($invite->activated==1)
                        {
                            $id=$invite->userid;
                            $benefactor=Profile::where('userid','=',$id)->first();
                            $benefactor->ifc += 300;
                            $benefactor->save();

                            TransactionController::insertToManager($id,"+300",$user->first_name." joined BBarters on your invitation","nope","nope","nope");

                            DB::table('friends')->insert(array('friend1'=>$id, 'friend2'=>$user->id, 'status'=>'accepted'));
                        }
                    }

                    $prath = User::where('username','=','prath257')->first();
                    if ($prath)
                        DB::table('friends')->insert(array('friend1'=>$prath->id, 'friend2'=>$user->id, 'status'=>'accepted'));
                    $kastya = User::where('username','=','ksjoshi88')->first();
                    if ($kastya)
                        DB::table('friends')->insert(array('friend1'=>$kastya->id, 'friend2'=>$user->id, 'status'=>'accepted'));

                    return Redirect::intended('home');
                }
                else
                {
                    $user->delete();
                    return Redirect::route('index')->with('error','couldn\'t log in');
                }
            }
            else
            {
                $user->delete();
                return Redirect::route('index')->with('error','Account is Not Activated! Try Again!');
            }
        }
    }

    //this is for twitter login

    public function postTwitterLogin($auth = NULL)
    {
        if ($auth == 'auth')
        {
            try
            {
                Hybrid_Endpoint::process();
            }
            catch (Exception $e){ }
            return;
        }
        try
        {
            $oauth = new Hybrid_Auth(app_path(). '/config/tw_auth.php');
            $provider = $oauth->authenticate('Twitter');
            $profile = $provider->getUserProfile();
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
        //first thing is to check whether user exists in database or not
        $user=User::where('twitterid','=',$profile->identifier)->first();
        if($user)
        {
            //this means user isn't logging in for the first time
            //So log him in with fixed facebook password
            Auth::attempt(array('username'=>$user->username,'password'=>'kastya_88twadvait_b2'));
            if(Auth::check())
            {
                //send him to home page, else login page

                $ifcAdded = 'no';
                $currentTime = new DateTime();
                $lastSeen = $user->updated_at;
                $diff=date_diff($lastSeen,$currentTime);
                $d=intval($diff->format("%R%a"));
                if($d>0)
                {
                    if ($user->activated == true && $user->pset == true)
                    {
                        $profile = Profile::where('userid','=',$user->id)->first();
                        if (count($profile) > 0)
                        {
                            $profile->ifc += 50;
                            $profile->save();
                            $ifcAdded = 'yes';

                            $user->updated_at = $currentTime;
                            $user->save();

                            TransactionController::insertToManager($user->id,"+50","Bonus for visiting BBarters on ".$currentTime->format('d-m-Y'),"nope","nope","nope");
                        }
                    }
                }

                return Redirect::intended('http://b2.com/home')->with('ifcAdded',$ifcAdded);
            }
            else
            {
                return View::make('errorPage')->with('error','there seems some problem in Twitter Login, please try again later!')->with('link','http://b2.com');
            }

        }
        else
        {
            //this means this is first time facebook login
                $user=new User();
                $user->twitterid=$profile->identifier;
                $user->first_name=Str::title($profile->firstName);
                $user->gender='other';
                $user->password=Hash::make('kastya_88twadvait_b2');
                $user->username='tweeple'.$profile->identifier;
                $user->country="Global";
                $user->email='teamb2@b2.com';
                $user->save();
                //this is the code to set the default user settings
                $uset=new UserSetting();
                $uset->userid=$user->id;
                $uset->save();
                //setting  up his chatAudit
                $chatAudit=new Chataudit();
                $chatAudit->userid=$user->id;
                $chatAudit->save();

                 //create a default profile
                $uprofile=new Profile();
                $uprofile->userid=$user->id;
                $uprofile->ifc=200;
                $uprofile->save();

            TransactionController::insertToManager($user->id,"+200","Start up ifc.","nope","nope","nope");

                return Redirect::to('/firstTweeple/'.$profile->identifier);

        }



    }

    public function getTweeple($tid)
    {
        $user = User::where('username','=','tweeple'.$tid)->first();
        if ($user->activated == false)
            return View::make('getTweeple')->with('twitterId',$tid);
        else
            return Redirect::route('home');
    }
    //performing the first time fbsignup activity
    public function postTweepleSignup()
    {
        $user=User::where('twitterid','=',Input::get('twid'))->first();
        if($user)
        {
            $user->username = Input::get('username');
            $user->country = Input::get('country');
            $user->email=Input::get('email');
            $user->gender=Input::get('gender');
            $user->activated=true;
            $user->save();
            $result = File::makeDirectory('Users/'.$user->username);
            if($result)
            {
                $result=File::makeDirectory('Users/'.$user->username.'/profilePic');
                $result=File::makeDirectory('Users/'.$user->username.'/profileTune');
                $result=File::makeDirectory('Users/'.$user->username.'/Wallpics');
                $result=File::makeDirectory('Users/'.$user->username.'/Books');
                $result=File::makeDirectory('Users/'.$user->username.'/Articles');
                $result=File::makeDirectory('Users/'.$user->username.'/Media');
                $result=File::makeDirectory('Users/'.$user->username.'/Resources');
                $result=File::makeDirectory('Users/'.$user->username.'/triviaPics');
                $result=File::makeDirectory('Users/'.$user->username.'/Collaborations');
                Auth::attempt(array('username'=>$user->username,'password'=>'kastya_88twadvait_b2'));
                if(Auth::check())
                {
                    $invite=Invite::where('email','=',$user->email)->first();
                    if ($invite)
                    {
                        if($invite->activated==1)
                        {
                            $id=$invite->userid;
                            $benefactor=Profile::where('userid','=',$id)->first();
                            $benefactor->ifc += 300;
                            $benefactor->save();

                            TransactionController::insertToManager($id,"+300",$user->first_name." joined BBarters on your invitation","nope","nope","nope");

                            DB::table('friends')->insert(array('friend1'=>$id, 'friend2'=>$user->id, 'status'=>'accepted'));
                        }
                    }

                    $prath = User::where('username','=','prath257')->first();
                    if ($prath)
                        DB::table('friends')->insert(array('friend1'=>$prath->id, 'friend2'=>$user->id, 'status'=>'accepted'));
                    $kastya = User::where('username','=','ksjoshi88')->first();
                    if ($kastya)
                        DB::table('friends')->insert(array('friend1'=>$kastya->id, 'friend2'=>$user->id, 'status'=>'accepted'));

                    return Redirect::intended('home');
                }
                else
                {
                    $user->delete();
                    return Redirect::route('index')->with('error','couldn\'t log in');
                }
            }
            else
            {
                $user->delete();
                return Redirect::route('index')->with('error','Account is Not Activated! Try Again!');
            }
        }
    }

    public function removeIsOnline()
    {
        if(Auth::check())
        {
        $user = Auth::user();
        $user->isOnline = false;
        $user->save();
    }
        else
            return 'wH@tS!nTheB0x';
    }
	public function forgotPassword()
	{

            $user = User::where('username','=',Input::get('username'))->where('email','=',Input::get('email'))->first();

            if ($user)
            {
                if ($user->fbid == null && $user->twitterid == null && $user->gid == null)
                {
                    $link = str_random(8);

                    DB::table('forgotpassword')->insert(array('username' => Input::get('username'), 'email' => Input::get('email'),'link'=>$link));


                    AuthController::$user = $user->email;

                    Mail::send('mailers', array('link'=>$link,'page'=>'forgotPasswordMailer'), function($message)
                    {
                        $message->to(AuthController::$user)->subject('Forgot Password');
                    });
                    return "Success";
                }
                else
                {
                    if ($user->twitterid == null && $user->gid == null)
                        return "Hey, you have been logging in using your Facebook account. So you haven't got a password to forget!";
                    elseif ($user->fbid == null && $user->gid == null)
                        return "Hey, you have been logging in using your Twitter account. So you haven't got a password to forget!";
                    else
                        return "Hey, you have been logging in using your Google account. So you haven't got a password to forget!";
                }
            }
            else
                return "No such user found.";


    }

	public function postResetPassword()
	{
        if(Auth::check())
        {
		$user = User::where('username','=',Input::get('username'))->first();
		$user->password = Hash::make(Input::get('password'));
		$user->save();

		Auth::login($user);
	}
        else
            return 'wH@tS!nTheB0x';
    }

	public function checkFpLink()
	{
        if(Auth::check())
        {
		$entry = DB::table('forgotpassword')->where('link', Input::get('link'))->where('email',Input::get('email'))->first();
		if ($entry)
		{
            if ($entry->used == 0)
            {
                DB::table('forgotpassword')->where('link', Input::get('link'))->where('email',Input::get('email'))->update(array('used' => 1));
                return "true";
            }
		}
		else
			return "false";
	}
        else
            return 'wH@tS!nTheB0x';
    }
    public function clearSessionData()
    {
        DB::table('sessions')->delete();
    }

    //google auth
    public function getFirstGoogle($gid)
    {
        $user = User::where('username','=','gtemp'.$gid)->first();
        if ($user->activated == false)
            return View::make('getFirstGoogle')->with('googleId',$gid);
        else
            return Redirect::route('home');
    }

    public function postGoogleLogin($auth = NULL)
    {
        if ($auth == 'auth')
        {
            try
            {
                Hybrid_Endpoint::process();
            }
            catch (Exception $e){ }
            return;
        }
        try
        {
            $oauth = new Hybrid_Auth(app_path(). '/config/Google_auth.php');
            $provider = $oauth->authenticate('Google');
            $profile = $provider->getUserProfile();

        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
        //first thing is to check whether user exists in database or not
        $user=User::where('gid','=',$profile->identifier)->first();
        if($user)
        {
            //this means user isn't logging in for the first time
            //So log him in with fixed facebook password
            Auth::attempt(array('username'=>$user->username,'password'=>'kastya_88gadvait_b2'));
            if(Auth::check())
            {
                //send him to home page, else login page

                $ifcAdded = 'no';
                $currentTime = new DateTime();
                $lastSeen = $user->updated_at;
                $diff=date_diff($lastSeen,$currentTime);
                $d=intval($diff->format("%R%a"));
                if($d>0)
                {
                    if ($user->activated == true && $user->pset == true)
                    {
                        $profile = Profile::where('userid','=',$user->id)->first();
                        if (count($profile) > 0)
                        {
                            $profile->ifc += 50;
                            $profile->save();
                            $ifcAdded = 'yes';

                            $user->updated_at = $currentTime;
                            $user->save();

                            TransactionController::insertToManager($user->id,"+50","Bonus for visiting BBarters on ".$currentTime->format('d-m-Y'),"nope","nope","nope");
                        }
                    }
                }

                return Redirect::intended('http://b2.com/home')->with('ifcAdded',$ifcAdded);
            }
            else
            {
                return View::make('errorPage')->with('error','there seems some problem in Facebook Login, please try again later!')->with('link','http://b2.com');
            }
        }
        else
        {
            //this means this is first time facebook login


            $users=User::all();

            foreach($users as $user)
            {
                if($user->email==$profile->email)
                {
                    $oauth->logoutAllProviders();
                    return View::make('errorPage')->with('error','this email has already been registered!')->with('link','http://b2.com');
                }
            }


            $user=new User();
            $user->gid=$profile->identifier;
            $user->first_name=Str::title($profile->firstName);
            $user->last_name=Str::title($profile->lastName);
            $user->gender=$profile->gender;
            $user->email=$profile->email;
            $user->password=Hash::make('kastya_88gadvait_b2');
            $user->username='gtemp'.$profile->identifier;
            $user->country="Global";
            $user->save();
            //this is the code to set the default user settings
            $uset=new UserSetting();
            $uset->userid=$user->id;
            $uset->save();
            //setting  up his chatAudit
            $chatAudit=new Chataudit();
            $chatAudit->userid=$user->id;
            $chatAudit->save();

            //create a default profile
            $uprofile=new Profile();
            $uprofile->userid=$user->id;
            $uprofile->ifc=200;
            $uprofile->save();

            TransactionController::insertToManager($user->id,"+200","Start up ifc.","nope","nope","nope");

            return Redirect::to('firstGoogle/'.$profile->identifier);


        }

    }

    public function postGoogleSignup()
    {

        $user=User::where('gid','=',Input::get('gid'))->first();

        if($user)
        {

            $user->username = Input::get('username');
            $user->country = Input::get('country');
            $user->activated=true;
            $user->save();
            $result = File::makeDirectory('Users/'.$user->username);
            if($result)
            {
                $result=File::makeDirectory('Users/'.$user->username.'/profilePic');
                $result=File::makeDirectory('Users/'.$user->username.'/profileTune');
                $result=File::makeDirectory('Users/'.$user->username.'/Wallpics');
                $result=File::makeDirectory('Users/'.$user->username.'/Books');
                $result=File::makeDirectory('Users/'.$user->username.'/Articles');
                $result=File::makeDirectory('Users/'.$user->username.'/Media');
                $result=File::makeDirectory('Users/'.$user->username.'/Resources');
                $result=File::makeDirectory('Users/'.$user->username.'/triviaPics');
                $result=File::makeDirectory('Users/'.$user->username.'/Collaborations');
                Auth::attempt(array('username'=>$user->username,'password'=>'kastya_88gadvait_b2'));
                if(Auth::check())
                {
                    $invite=Invite::where('email','=',$user->email)->first();
                    if ($invite)
                    {
                        if($invite->activated==1)
                        {
                            $id=$invite->userid;
                            $benefactor=Profile::where('userid','=',$id)->first();
                            $benefactor->ifc += 300;
                            $benefactor->save();

                            TransactionController::insertToManager($id,"+300",$user->first_name." joined BBarters on your invitation","nope","nope","nope");

                            DB::table('friends')->insert(array('friend1'=>$id, 'friend2'=>$user->id, 'status'=>'accepted'));
                        }
                    }

                    $prath = User::where('username','=','prath257')->first();
                    if ($prath)
                        DB::table('friends')->insert(array('friend1'=>$prath->id, 'friend2'=>$user->id, 'status'=>'accepted'));
                    $kastya = User::where('username','=','ksjoshi88')->first();
                    if ($kastya)
                        DB::table('friends')->insert(array('friend1'=>$kastya->id, 'friend2'=>$user->id, 'status'=>'accepted'));

                    return Redirect::intended('home');
                }
                else
                {
                    $user->delete();
                    return Redirect::route('index')->with('error','couldn\'t log in');
                }
            }
            else
            {
                $user->delete();
                return Redirect::route('index')->with('error','Account is Not Activated! Try Again!');
            }
        }
    }
}
