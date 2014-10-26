<?php

class AjaxController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function checkUsername()
	{

		$uname=Input::get('username');

		$users=User::all();

		foreach($users as $user)
		{
			if($user->username==$uname)
			{
				return "username already taken";
			}
		}
		return "good";

    }

    public function checkEmail()
    {

        $email=Input::get('mail');

        $users=User::all();

        foreach($users as $user)
        {
            if($user->email==$email)
            {
                return "email already registered";
            }
        }
        return "good";

    }

    public function saveNewName()
	{
        if(Auth::check())
        {
		$user = Auth::user();
		$user->first_name = Str::title(Input::get('firstname'));
		$user->last_name = Str::title(Input::get('lastname'));
		$user->save();
	}
        else
            return 'wH@tS!nTheB0x';
    }

    public function getSuggestions()
    {
        if(Auth::check())
        {
        $search = Input::get('search');
        $keywords = Input::get('keywords');
        $constraint = Input::get('constraint');
        $request = Input::get('request');

        if ($search == 'people')
        {
            $users = User::all();
            $searchUsers=new \Illuminate\Database\Eloquent\Collection();
            foreach ($users as $user)
            {
                $fullname = $user->first_name.' '.$user->last_name;
                if(Str::contains(Str::lower($fullname),Str::lower($keywords)))
                {
                    if ($constraint == 'all')
                    {
                        if ($user->activated==true)
                            $searchUsers->add($user);
                    }
                    else if ($constraint == 'online')
                    {
                        if ($user->isOnline==true && $user->activated==true)
                            $searchUsers->add($user);
                    }
                    else if ($constraint == 'friends')
                    {
                        if ($user->activated==true && Friend::isFriend($user->id))
                            $searchUsers->add($user);
                    }
                }
            }
            if ($searchUsers)
                return View::make('searchUsers')->with('searchUsers',$searchUsers)->with('request',$request);
        }
        else if ($search == 'content')
        {
            $articles = Article::all();
            $blogBooks = BlogBook::all();
            $resources = Resource::all();
            $collaborations = Collaboration::all();
            $quizes = Quiz::all();
            $media = Media::where('ispublic','=',true)->get();
            $events=BEvent::all();

            $searchContent=new \Illuminate\Database\Eloquent\Collection();

            foreach ($articles as $article)
            {
                if (Str::contains(Str::lower($article->title),Str::lower($keywords)))
                {
                    $searchContent->add($article);
                }
            }
            foreach ($quizes as $quiz)
            {
                if (Str::contains(Str::lower($quiz->title),Str::lower($keywords)))
                {

                    $searchContent->add($quiz);
                }
            }
            foreach ($blogBooks as $blogBook)
            {
                if (Str::contains(Str::lower($blogBook->title),Str::lower($keywords)))
                {
                    $chapters = $blogBook->getChapters()->get();
                    if (count($chapters) > 0)
                        $searchContent->add($blogBook);
                }
            }
            foreach ($resources as $resource)
            {
                if (Str::contains(Str::lower($resource->title),Str::lower($keywords)))
                {
                    $searchContent->add($resource);
                }
            }
            foreach ($collaborations as $collaboration)
            {
                if (Str::contains(Str::lower($collaboration->title),Str::lower($keywords)))
                {
                    $chapters = $collaboration->getChapters()->get();
                    if (count($chapters) > 0)
                        $searchContent->add($collaboration);
                }
            }
            foreach ($media as $med)
            {
                if (Str::contains(Str::lower($med->title),Str::lower($keywords)))
                {
                    $searchContent->add($med);
                }
            }
            foreach ($events as $bevent)
            {
                if (Str::contains(Str::lower($bevent->name),Str::lower($keywords)))
                {
                    $searchContent->add($bevent);
                }
            }

            if ($searchContent)
                return View::make('searchContent')->with('searchContent',$searchContent);

        }
    }
        else
            return 'wH@tS!nTheB0x';
    }
    public function getContentArticles()
    {
        if(Auth::check())
        {
        $articles = User::find(Input::get('userId'))->getArticles()->where('category','=',Input::get('interestId'))->orderBy('created_at','DESC')->skip(Input::get('articleCount'))->take(4)->get();
        $remainingArticles = User::find(Input::get('userId'))->getArticles()->where('category','=',Input::get('interestId'))->orderBy('created_at','DESC')->skip(Input::get('articleCount')+4)->take(4)->get();
        $remainingArticles = count($remainingArticles);
        return View::make('contentData')->with('articles',$articles)->with('type','articles')->with('remainingArticles',$remainingArticles)->with('articleCount',Input::get('articleCount'));
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getContentBooks()
    {
        if(Auth::check())
        {
        $blogBooks = User::find(Input::get('userId'))->getBlogBooks()->where('category','=',Input::get('interestId'))->orderBy('created_at','DESC')->get();
        $collaborations = User::find(Input::get('userId'))->getOwnedCollaborations()->where('category','=',Input::get('interestId'))->orderBy('created_at','DESC')->get();
        $contributions = User::find(Input::get('userId'))->getContributions()->where('category','=',Input::get('interestId'))->orderBy('created_at','DESC')->get();
        $books = $blogBooks->merge($collaborations);
        $books = $books->merge($contributions);
        $remainingBooks = $books->sortByDesc('created_at')->slice(Input::get('bookCount')+4,4);
        $books = $books->sortByDesc('created_at')->slice(Input::get('bookCount'),4);
        $remainingBooks = count($remainingBooks);
        return View::make('contentData')->with('books',$books)->with('type','books')->with('remainingBooks',$remainingBooks)->with('bookCount',Input::get('bookCount'));
    }
        else
            return 'wH@tS!nTheB0x';
    }
    public function getContentResources()
    {
        if(Auth::check())
        {
        $resources = User::find(Input::get('userId'))->getResources()->where('category','=',Input::get('interestId'))->orderBy('created_at','DESC')->skip(Input::get('resourceCount'))->take(4)->get();
        $remainingResources = User::find(Input::get('userId'))->getResources()->where('category','=',Input::get('interestId'))->orderBy('created_at','DESC')->skip(Input::get('resourceCount')+4)->take(4)->get();
        $remainingResources = count($remainingResources);
        return View::make('contentData')->with('resources',$resources)->with('type','resources')->with('remainingResources',$remainingResources)->with('resourceCount',Input::get('resourceCount'));
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getContentPollsNQuizes()
    {
        if(Auth::check())
        {
        $polls = User::find(Input::get('userId'))->getPolls()->where('category','=',Input::get('interestId'))->orderBy('created_at','DESC')->get();
        $quizes = User::find(Input::get('userId'))->getQuizes()->where('category','=',Input::get('interestId'))->orderBy('created_at','DESC')->get();
        $pollsNQuizes = $polls->merge($quizes);
        $remainingPollsNQuizes = $pollsNQuizes->sortByDesc('created_at')->slice(Input::get('pollQuizCount')+4,4);
        $pollsNQuizes = $pollsNQuizes->sortByDesc('created_at')->slice(Input::get('pollQuizCount'),4);
        $remainingPollsNQuizes = count($remainingPollsNQuizes);
        return View::make('contentData')->with('pollsNQuizes',$pollsNQuizes)->with('type','pollsNQuizes')->with('remainingPollsNQuizes',$remainingPollsNQuizes)->with('pollQuizCount',Input::get('pollQuizCount'));
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function loadMoreEvents()
    {
        if(Auth::check())
        {
        if (Input::get('interest') == 'all')
        {
            $events = BEvent::orderBy('datetime','DESC')->skip(Input::get('eventsCount'))->take(100)->get();
            $moreEvents = BEvent::orderBy('datetime','DESC')->skip(Input::get('eventsCount')+4)->take(4)->get();
        }
        else
        {
            $events = BEvent::orderBy('datetime','DESC')->where('category','=',Input::get('interest'))->skip(Input::get('eventsCount'))->take(100)->get();
            $moreEvents = BEvent::orderBy('datetime','DESC')->where('category','=',Input::get('interest'))->skip(Input::get('eventsCount')+4)->take(4)->get();
        }
        $count = count($moreEvents);

        $send = $events->filter(function($eve)
        {
            $currentTime = new DateTime();
            $eventTime = new DateTime($eve->datetime);
            if ($eventTime > $currentTime)
                return true;
        });

        $send = $send->sortByDesc('datetime')->slice(0,4);

        return View::make('loadMoreEvents')->with('events',$send)->with('count',$count)->with('eventsCount',Input::get('eventsCount'))->with('interest',Input::get('interest'));
    }
        else
            return 'wH@tS!nTheB0x';
    }
    public function getActionData()
    {
        if(Auth::check())
        {
            $action=Action::orderBy('created_at','DESC')->take(6)->get();

            if (count($action)>0)
                return View::make('ActionCentre')->with('actions',$action)->with('count',null)->with('moreActions',null);

        }
        else
            return 'wH@tS!nTheB0x';
    }

    //notifications
    public static function insertNid($nid,$id)
    {
        $noti =Notifications::where('userid','=',$id)->where('type','=','chat')->orderBy('created_at','DESC')->first();
        $noti->chid=$nid;
        $noti->save();
    }

    public static function insertNidAcc($nid,$id)
    {
        $noti =Notifications::where('userid','=',$id)->where('type','=','chatAcc')->orderBy('created_at','DESC')->first();
        $noti->chid=$nid;
        $noti->save();
    }

    public static function insertToNotification($userid,$cuserid,$type,$message,$link)
    {
        $noti =new Notifications();
        $noti->userid=$userid;
        $noti->cuserid=$cuserid;
        $noti->type=$type;
        $noti->message=$message;
        $noti->link=$link;
        $noti->save();
    }

    public function getNumberOfNotification()
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user->isOnline = true;
            $user->save();
            Auth::user()->updateActivity();

            $notify=Notifications::where('userid','=',Auth::user()->id)->where('checked','=',false)->get();


            return count($notify);
        }
        else
            return 'wH@tS!nTheB0x';
     }

    public function getNotification()
    {

        if(Auth::check())
        {

            $unreadNotifications = Notifications::where('userid','=',Auth::user()->id)->where('checked','=',false)->orderBy('created_at','DESC')->get();
            if (count($unreadNotifications) > 10)
                $sendNotifications = $unreadNotifications;
            else
            $sendNotifications = Notifications::where('userid','=',Auth::user()->id)->orderBy('created_at','DESC')->take(10)->get();

            DB::table('notification')->where('userid','=',Auth::user()->id)->where('checked','=',false)->update(array('checked' =>true));

            if(count($sendNotifications)!=0)
                return View::make('notificationList')->with('notify',$sendNotifications);
            else
                return "No New Notifications";
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function loadMoreActions()
    {
        if(Auth::check())
        {
        $action=Action::orderBy('created_at','DESC')->skip(Input::get('count'))->take(10)->get();
        $moreActions=Action::orderBy('created_at','DESC')->skip(Input::get('count')+10)->take(1)->get();
        $moreActions = count($moreActions);
        return View::make('ActionCentre')->with('actions',$action)->with('moreActions',$moreActions)->with('count',Input::get('count'));
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getSearchResults()
    {
        if(Auth::check())
        {
            try
            {
                $keywords = Input::get('keywords');
                $constraint = Input::get('constraint');
                $request = Input::get('request');


                $users = User::all();
                $searchUsers=new \Illuminate\Database\Eloquent\Collection();
                foreach ($users as $user)
                {
                    $fullname = $user->first_name.' '.$user->last_name;
                    if(Str::contains(Str::lower($fullname),Str::lower($keywords)))
                    {
                        if ($constraint == 'all')
                        {
                            if ($user->activated==true)
                                $searchUsers->add($user);
                        }
                        else if ($constraint == 'online')
                        {
                            if ($user->isOnline==true && $user->activated==true)
                                $searchUsers->add($user);
                        }
                        else if ($constraint == 'friends')
                        {
                            if ($user->activated==true && Friend::isFriend($user->id))
                                $searchUsers->add($user);
                        }
                    }
                }

                /*    if ($searchUsers)
                        return View::make('searchUsers')->with('searchUsers',$searchUsers)->with('request',$request);*/


                if (Input::get('IN') == 0)
                {
                    $articles = Article::all();
                    $blogBooks = BlogBook::all();
                    $resources = Resource::all();
                    $collaborations = Collaboration::all();
                    $quizes = Quiz::all();
                    $media = Media::where('ispublic','=',true)->get();
                    $events=BEvent::all();
                }
                else
                {
                    $articles = Article::where('category','=',Input::get('IN'))->get();
                    $blogBooks = BlogBook::where('category','=',Input::get('IN'))->get();
                    $resources = Resource::where('category','=',Input::get('IN'))->get();
                    $collaborations = Collaboration::where('category','=',Input::get('IN'))->get();
                    $quizes = Quiz::where('category','=',Input::get('IN'))->get();
                    $media = Media::where('ispublic','=',true)->where('category','=',Input::get('IN'))->get();
                    $events=BEvent::where('category','=',Input::get('IN'))->get();
                }


                $searchContent=new \Illuminate\Database\Eloquent\Collection();

                foreach ($articles as $article)
                {
                    if (Str::contains(Str::lower($article->title),Str::lower($keywords)))
                    {
                        $searchContent->add($article);
                    }
                }
                foreach ($quizes as $quiz)
                {
                    if (Str::contains(Str::lower($quiz->title),Str::lower($keywords)))
                    {

                        $searchContent->add($quiz);
                    }
                }
                foreach ($blogBooks as $blogBook)
                {
                    if (Str::contains(Str::lower($blogBook->title),Str::lower($keywords)))
                    {
                        $chapters = $blogBook->getChapters()->get();
                        if (count($chapters) > 0)
                            $searchContent->add($blogBook);
                    }
                }
                foreach ($resources as $resource)
                {
                    if (Str::contains(Str::lower($resource->title),Str::lower($keywords)))
                    {
                        $searchContent->add($resource);
                    }
                }
                foreach ($collaborations as $collaboration)
                {
                    if (Str::contains(Str::lower($collaboration->title),Str::lower($keywords)))
                    {
                        $chapters = $collaboration->getChapters()->get();
                        if (count($chapters) > 0)
                            $searchContent->add($collaboration);
                    }
                }
                foreach ($media as $med)
                {
                    if (Str::contains(Str::lower($med->title),Str::lower($keywords)))
                    {
                        $searchContent->add($med);
                    }
                }
                foreach ($events as $bevent)
                {
                    if (Str::contains(Str::lower($bevent->name),Str::lower($keywords)))
                    {
                        $searchContent->add($bevent);
                    }
                }

                if(Input::get('FILTER') == 'latest')
                {
                    $searchContent = $searchContent->sortByDesc('created_at');
                }
                else
                {
                    $searchContent = $searchContent->sortByDesc('users');
                }

                if ($searchContent||$searchUsers)
                    return View::make('searchContentAndPeople')->with('searchContent',$searchContent)->with('searchUsers',$searchUsers)->with('request',$request);

            }
            catch(Exception $e)
            {
                return 'error_occurred';
            }

        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function failedSearch()
    {
        if(Auth::check())
        {
        Mail::send('mailers', array('user'=>Auth::user(),'keywords'=>Input::get('keywords'),'page'=>'failedSearch'), function($message)
        {
            $message->to('prath257@live.com')->subject('Failed search');
        });
    }
        else
            return 'wH@tS!nTheB0x';
    }
}