<?php

class HomeController extends BaseController
{

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

    public static $user=null;

	public function getHome()
	{
        try
        {
            $userid=Auth::user()->id;
            $friends1=DB::table('friends')->where('friend1','=',$userid)->where('status','=','accepted')->lists('friend2');
            $friends2=DB::table('friends')->where('friend2','=',$userid)->where('status','=','accepted')->lists('friend1');
            $friends = array_merge($friends1, $friends2);
            $users1=new \Illuminate\Database\Eloquent\Collection();
            foreach($friends as $f)
            {
                $users1->add(User::find($f));
            }
            Auth::user()->updateActivity();

            $events = BEvent::orderBy('datetime','DESC')->get();
            $moreEvents = BEvent::orderBy('datetime','DESC')->skip(4)->take(4)->get();
            $count = count($moreEvents);

            $send = $events->filter(function($eve)
            {
                $currentTime = new DateTime();
                $eventTime = new DateTime($eve->datetime);
                if ($eventTime > $currentTime)
                    return true;
            });

            $send = $send->sortByDesc('datetime')->slice(0,4);

            $interests = Auth::user()->interestedIn()->get();

            $moreAction=Action::orderBy('created_at','DESC')->skip(6)->take(1)->get();

            return View::make('home')->with('friends',$users1)->with('events',$send)->with('count',$count)->with('interests',$interests)->with('moreAction',count($moreAction));
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function postInvite()
    {
        if(Auth::check())
        {

            $validation = Validator::make(Input::all(),Invite::$invite_rules,Invite::$invite_messages);

            if($validation->passes())
            {
                $invite= new Invite();
                $invite->userid=Auth::user()->id;
                $invite->name=Input::get('name');
                $invite->email=Input::get('email');
                $invite->link_id=str_random(8);
                $invite->save();
                return "Share the following link with your friend and urge him/her to join. If he/she clicks on the link and signs up, you earn 300 i. <b>Link: http://localhost/b2v2/signup/".$invite->link_id."</b><button class=' btn btn-primary pull-right' type='button' onclick='inviteAnother()'>Invite one more</button>";
            }
            else
            {
                return $validation->errors()->first();
            }
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getInviteeSignup($id)
    {
        $invite=Invite::where('link_id','=',$id)->first();
        $invite->activated=true;
        $invite->save();
        return Redirect::route('index')->with('redirected','signup');
    }

    public function getFriends()
    {
        $users=User::all();
        return View::make('friends')->with('users',$users);
    }


    public function getUser($username)
    {
        if (Auth::user())
        {
            $user=User::where('username','=',$username)->first();
            $userid=Auth::user()->id;
            $userProfile=$user->profile()->first();
            $interests=$user->interestedIn()->get();
            $oldpics=$user->getTrivia()->get();
            $subscribers=$user->getSubscribers()->get();
            $subsCount=count($subscribers);
            $subscriptions=$user->getSubscribedTo()->get();
            $subscripCount=count($subscriptions);
            $follower=DB::table('subscriptions')->where('subscribed_to_id',$user->id)->where('subscriber_id',Auth::user()->id)->first();
            $aboutHim=$user->about()->get();
            $newQues = Auth::user()->questionsAskedToUser()->where('answer','=','')->get();
            $numQues = sizeof($newQues);
            $newAbout = Auth::user()->about()->where('status','=','new')->get();
            $numAbout = sizeof($newAbout);
            $questions=$user->questionsAskedToUser()->where('answer','!=','null')->orderBy('updated_at','DESC')->paginate(2);
            $currentTime = new DateTime();
            $lastSeen = $user->updated_at;
            $form = $currentTime->diff($lastSeen);
            if($form->i>4 || $form->h>0 || $form->d>0 || $form->m>0 || $form->y>0)
            {
                $user->isOnline=false;
                $user->save();
            }
            $friends1=DB::table('friends')->where('friend1','=',$user->id)->where('status','=','accepted')->lists('friend2');
            $friends2=DB::table('friends')->where('friend2','=',$user->id)->where('status','=','accepted')->lists('friend1');
            $friends = array_merge($friends1, $friends2);
            $friendCount=count($friends);
            $data=array('profile'=>$userProfile,'interests'=>$interests,'trivia'=>$oldpics,'user'=>$user,'sCount'=>$subsCount,'scCount'=>$subscripCount,'fCount'=>$friendCount,'follower'=>$follower,'numQues'=>$numQues,'numAbout'=>$numAbout,'about'=>$aboutHim,'questions'=>$questions);
            return View::make('profile',$data);
        }
        else
        {
            $user=User::where('username','=',$username)->first();
            $userProfile=$user->profile()->first();
            $interests=$user->interestedIn()->get();
            $oldpics=$user->getTrivia()->get();
            $aboutHim=$user->about()->get();
            $questions=$user->questionsAskedToUser()->where('answer','!=','null')->orderBy('updated_at','DESC')->paginate(2);
            $currentTime = new DateTime();
            $lastSeen = $user->updated_at;
            $form = $currentTime->diff($lastSeen);
            if($form->i>4)
            {
                $user->isOnline=false;
                $user->save();
            }
            $data=array('profile'=>$userProfile,'interests'=>$interests,'trivia'=>$oldpics,'user'=>$user,'about'=>$aboutHim,'questions'=>$questions);
            return View::make('dummyProfile',$data);
        }
    }

    public function addSubscribe()
    {
        if(Auth::check())
        {
        DB::table('subscriptions')->insert(
            array('subscribed_to_id' => Input::get('id'),
                'subscriber_id' => Auth::user()->id)
        );

        $user = User::find(Input::get('id'));
        $user->profile->ifc += $user->settings->subcost;
        $user->profile->save();

        Auth::user()->profile->ifc -= $user->settings->subcost;
        Auth::user()->profile->save();

        $subscriptionid = DB::table('subscriptions')->where('subscribed_to_id',Input::get('id'))->where('subscriber_id',Auth::user()->id)->pluck('id');

        TransactionController::insertToManager(Auth::user()->id,"-".$user->settings->subcost,"Subscribed to",'http://localhost/b2v2/user/'.$user->username,$user->first_name.' '.$user->last_name,"profile");

        TransactionController::insertToManager($user->id,"+".$user->settings->subcost,"New subscriber:",'http://localhost/b2v2/user/'.Auth::user()->username,Auth::user()->first_name.' '.Auth::user()->last_name,"profile");

        AjaxController::insertToNotification($user->id,Auth::user()->id,"subscription"," subscribed to you ",'http://localhost/b2v2/user/'.$user->username);

        HomeController::$user = $user;

        if (HomeController::$user->settings->notifications)
        {
            Mail::send('mailers', array('user'=>Auth::user(), 'receiver'=>$user,'page'=>'newSubscriber'), function($message)
            {
                $message->to(HomeController::$user->email)->subject('New Subscriber!');
            });
        }
        /*Action::postAction('S new',Auth::user()->id,Input::get('id'),null);*/
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function unSubscribe()
    {
        if(Auth::check())
        {
        $id = DB::table('subscriptions')->where('subscribed_to_id',Input::get('id'))->where('subscriber_id',Auth::user()->id)->pluck('id');
        DB::table('subscriptions')->where('subscribed_to_id',Input::get('id'))->where('subscriber_id',Auth::user()->id)->delete();

        Notifications::where('userid','=',Input::get('id'))->where('cuserid','=',Auth::user()->id)->where('type','=','subscription')->delete();
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function blockUnblockSubscriber()
    {
        if(Auth::check())
        {
        $blocked=DB::table('subscriptions')->where('subscribed_to_id',Auth::user()->id)->where('subscriber_id',Input::get('id'))->first();
        if ($blocked->blocked==0)
        {
            DB::table('subscriptions')->where('subscribed_to_id',Auth::user()->id)->where('subscriber_id',Input::get('id'))->update(array('blocked' => 1));
        }
        else
        {
            DB::table('subscriptions')->where('subscribed_to_id',Auth::user()->id)->where('subscriber_id',Input::get('id'))->update(array('blocked' => 0));
        }
    }
        else
            return 'wH@tS!nTheB0x';
    }

	//this is the code to transfer the IFCs

    public function postTransfer()
    {
        if(Auth::check())
        {
            $ifc = Input::get('ifc');
            if ($ifc <= Auth::user()->profile->ifc)
            {
                $receiverid = Input::get('userid');
                $receiverprofile = Profile::where('userid','=',$receiverid)->first();
                $senderid = Auth::user()->id;
                $senderprofile = Profile::where('userid','=',$senderid)->first();

                $receiverprofile->ifc+=$ifc;
                $receiverprofile->save();
                $senderprofile->ifc-=$ifc;
                $senderprofile->save();

                TransactionController::insertToManager(Auth::user()->id,"-".$ifc,"IFCs transferred to","http://localhost/b2v2/user/".User::find(Input::get('userid'))->username,User::find(Input::get('userid'))->first_name." ".User::find(Input::get('userid'))->last_name,"profile");
                TransactionController::insertToManager($receiverid,"+".$ifc,"IFCs transferred by","http://localhost/b2v2/user/".Auth::user()->username,Auth::user()->first_name." ".Auth::user()->last_name,"profile");

                AjaxController::insertToNotification(Input::get('userid'),Auth::user()->id,"transfered"," Transfered ".Input::get('ifc')." ifc to your account",'http://localhost/b2v2/user/'.Auth::user()->username);

                QAController::$user = User::find($receiverid);
                $sender = User::find($senderid);

                Mail::send('mailers', array('user'=>$sender, 'receiver'=>QAController::$user, 'ifc'=>Input::get('ifc'),'page'=>'newTransferMailer'), function($message)
                {
                    $message->to(QAController::$user->email,QAController::$user->first_name)->subject('IFCs credited!');
                });
                return "Success";
            }
            else
            {
                return Auth::user()->profile->ifc;
            }
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function showNotification()
    {
        try
        {


        $notifics = Auth::user()->getNotifications()->where('checked','=',false)->first();
        $notifics->checked = true;
        $notifics->save();

        return View::make('notify')->with('notific',$notifics);
        }
        catch(Exception $e)
        {
            return "TheMonumentsMenGeorgeClooneyMattDamon";
        }
    }

    public function showChatNotifications()
    {
        if(Auth::check())
        {
        try
        {
        $user = Auth::user();
        $user->isOnline = true;
        $user->save();

        $notifics = Auth::user()->getNotifications()->where('checked','=',false)->where(function($query)
        {
            $query->where('ntype', '=', 'chatrequest')
                ->orWhere('ntype', '=', 'chataccepted');
        })->first();
        $notifics->checked = true;
        $notifics->save();

        return View::make('notify')->with('notific',$notifics);
        }
        catch(Exception $e)
        {
            return "TheMonumentsMenGeorgeClooneyMattDamon";
        }
    }
        else
            return 'wH@tS!nTheB0x';
    }
       //Review
    public function getReviewArticle($articleId)
    {
        $article = Article::find($articleId);
        $review = Review::where('type','=','article')->where('contentid','=',$articleId)->first();
        return View::make('reviewArticle')->with('article',$article)->with('review',$review);
    }

    public function getReviewBlogBook($blogBookId)
    {
        if(Auth::check())
        {
            $blogBook = BlogBook::find($blogBookId);
            $chapters=$blogBook->getChapters()->get();
            $review = Review::where('type','=','book')->where('contentid','=',$blogBookId)->first();
            return View::make('reviewBlogBook')->with('book',$blogBook)->with('review',$review)->with('chapters',$chapters);
        }else
            return 'wH@tS!nTheB0x';
    }

    public function getReview($reviewId)
    {
        $review = Review::find($reviewId);
        $blogBook = BlogBook::find($review->contentid);
        return View::make('review')->with('review',$review)->with('blogBook',$blogBook);
    }

    public function postArticleReview()
    {
        if(Auth::check())
        {
        $review = Review::find(Input::get('reviewId'));
        $review->ifc = Input::get('ifc');
        $review->suggestions = Input::get('suggestions');
        $review->save();

        $article = Article::find(Input::get('articleId'));

        HomeController::$user = User::find($article->userid);

        Mail::send('mailers', array('user'=>HomeController::$user, 'article'=>$article, 'review'=>$review,'page'=>'articleReviewed'), function($message)
        {
            $message->to(HomeController::$user->email)->subject('Article Reviewed!');
        });

        $article->review = 'passed';

        if (Input::get('zero')=="True")
            $article->delete();
        else
        {
            $user = User::find($article->userid);
            $user->profile->ifc += Input::get('ifc');
            $user->profile->save();
            $article->save();

            TransactionController::insertToManager($user->id,"+".Input::get('ifc'),"IFCs awarded after reviewing the article","http://localhost/b2v2/readArticle/".$article->id,$article->title,"content");
        }
    }
        else
            return 'wH@tS!nTheB0x';
    }
    public function postBlogBookReview()
    {
        if(Auth::check())
        {
        $review = Review::find(Input::get('reviewId'));
        $review->ifc = Input::get('ifc');
        $review->suggestions = Input::get('suggestions');
        $review->save();

        $blogBook = BlogBook::find(Input::get('blogBookId'));

        HomeController::$user = User::find($blogBook->userid);

        Mail::send('mailers', array('user'=>HomeController::$user, 'blogBook'=>$blogBook, 'review'=>$review,'page'=>'blogBookReviewed'), function($message)
        {
            $message->to(HomeController::$user->email)->subject('BlogBook Reviewed!');
        });

        $blogBook->review = 'reviewed';
        if (Input::get('zero')=="True")
            $blogBook->delete();
        else
        {
            $user = User::find($blogBook->userid);
            $user->profile->ifc += Input::get('ifc');
            $user->profile->save();
            $blogBook->save();

            TransactionController::insertToManager($user->id,"+".Input::get('ifc'),"IFCs awarded after reviewing the BlogBook","http://localhost/b2v2/blogBook/".$blogBook->id,$blogBook->title,"content");
        }
    }
        else
            return 'wH@tS!nTheB0x';
    }
    public function reviewBlogBook()
    {
        $blogBook = BlogBook::find(Input::get('id'));
        $blogBook->review = 'toreview';
        $blogBook->save();

        $review = new Review();
        $review->type = 'book';
        $review->contentid = $blogBook->id;
        $review->save();

        Mail::send('mailers', array('user'=>Auth::user(), 'review'=>$review, 'content'=>$blogBook,'page'=>'newSubmissionRequest'), function($message)
        {
            $message->to('prath257@gmail.com')->cc('ksjoshi88@gmail.com')->subject('New Review Request!');
        });
    }

	//this is the function to get users readings
	public function getMyReadings()
	{
		$user=Auth::user();
		return View::make('readings')->with('user',$user);

	}

    //these are chat related
    public function getOngoingChats()
    {
/*        $ongoingChats = Chat::where('status','=','ongoing')
            ->where(function($query)
            {
                $query->where('user1', '=', Auth::user()->id)
                    ->orWhere('user2', '=', Auth::user()->id);
            })->get();*/
        $chat = null;

        return View::make('ongoingChats')->with('chat',$chat);
        /*->with('ongoingChats',$ongoingChats)*/
    }

    public function getOngoingChatsLink($link)
    {
/*        $ongoingChats = Chat::where('status','=','ongoing')
            ->where(function($query)
            {
                $query->where('user1', '=', Auth::user()->id)
                    ->orWhere('user2', '=', Auth::user()->id);
            })->get();*/

        $chat = Chat::where('link_id','=',$link)->first();

        return View::make('ongoingChats')->with('chat',$chat);
        /*->with('ongoingChats',$ongoingChats)*/
    }

    public function earnIFCs()
    {
        return View::make('ifcDeficit')->with('contentIFC',null)->with('userIFC',null);
    }

}