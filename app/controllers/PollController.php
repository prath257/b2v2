<?php

class PollController extends \BaseController {

    public static $email=null;
	public function getPollDashboard()
    {
        $categories=Auth::user()->interestedIn()->get();
        return View::make('pollDashboard')->with('categories',$categories);
    }

    public function createPoll()
    {
        $pquestion=Input::get('question');
        $message=Input::get('message');
        $category=Input::get('category');
        $isPublic=Input::get('access');

        $poll=new Poll();
        $poll->question=$pquestion;
        $poll->message=$message;
        $poll->active=true;
        $poll->category=$category;
        if($isPublic==null)
            $poll->ispublic=false;
        else
            $poll->ispublic=true;
        $poll->ownerid=Auth::user()->id;
        $poll->save();

        //Now is the code to add the options
        $ocount=intval(Input::get('numop'));
        for($i=1;$i<=$ocount;$i++)
        {
            $option=new Polloption();
            $option->option=Input::get('op'.$i);
            $option->pollid=$poll->id;
            $option->save();
        }

        Action::postAction('P new',Auth::user()->id,null,$poll->id);
        $subscribers = DB::table('subscriptions')->where('subscribed_to_id','=',Auth::user()->id)->lists('subscriber_id');
        foreach($subscribers as $s)
        {
            PollController::$email=User::find($s)->email;
            Mail::send('mailers',array('user' => User::find($s),'content' => $poll,'type' => 'P','writer' => Auth::user(),'page'=>'readerMailer'),function($message)
            {
                $message->to(PollController::$email)->subject('New Poll');
            });
        }

        Auth::user()->profile->ifc += 20;
        Auth::user()->profile->save();
        TransactionController::insertToManager(Auth::user()->id,"+20","Created new poll (".$poll->question.")","nope","nope","nope");

        //Now redirect the user to the Poll page
        return Redirect::to('/poll/'.$poll->id);
    }

    public function showPoll($pid)
    {
        $book=Poll::find($pid);
        $owner = User::find($book->ownerid);
        $articles = Article::where('category','=',$book->category)->orderBy('users','DESC')->get();
        $blogBooks = BlogBook::where('category','=',$book->category)->orderBy('users','DESC')->get();
        $collaborations = Collaboration::where('category','=',$book->category)->orderBy('users','DESC')->get();


        $content = $articles->merge($blogBooks);
        $content = $content->merge($collaborations);

        $content = $content->sortByDesc('users')->take(6);

        if (count($content) < 6)
        {
            $articles = $owner->getArticles()->orderBy('users','DESC')->get();
            $blogBooks = $owner->getBlogBooks()->orderBy('users','DESC')->get();
            $collaborations = $owner->getOwnedCollaborations()->orderBy('users','DESC')->get();
            $contributions = $owner->getContributions()->orderBy('users','DESC')->get();

            $content = $content->merge($articles);
            $content = $content->merge($blogBooks);
            $content = $content->merge($collaborations);
            $content = $content->merge($contributions);

            $content = $content->sortByDesc('users')->take(6);

            if (count($content) < 6)
            {
                $ksj = User::where('username','=','ksjoshi88')->first();
                $articles = $ksj->getArticles()->orderBy('users','DESC')->get();
                $blogBooks = $ksj->getBlogBooks()->orderBy('users','DESC')->get();
                $collaborations = $ksj->getOwnedCollaborations()->orderBy('users','DESC')->get();
                $contributions = $ksj->getContributions()->orderBy('users','DESC')->get();

                $content = $content->merge($articles);
                $content = $content->merge($blogBooks);
                $content = $content->merge($collaborations);
                $content = $content->merge($contributions);

                $content = $content->sortByDesc('users')->take(6);
            }
        }

        return View::make('poll')->with('poll',$book)->with('content',$content);
    }

    public function submitPoll()
    {
        $pid=Input::get('pollId');
        $poll=Poll::find($pid);

        $rid=Input::get('response');
        $response=Polloption::find($rid);
        $response->responses+=1;
        $response->save();

        //Deduct IFCs of the answerer and increase the IFC count of the poll's owner.
        /*Auth::user()->profile->ifc -= $poll->ifc;
        Auth::user()->profile->save();
        $user = User::find($poll->ownerid);
        $user->profile->ifc += $poll->ifc;
        $user->profile->save();*/

        $responses=$poll->getOptions()->get();
        $tr=0;
        foreach($responses as $r)
        {
            $tr+=$r->responses;
        }

        if ($tr == 100 || $tr == 300 || $tr == 500 || $tr == 1000)
        {
            $user = User::find($poll->ownerid);
            TransactionController::insertToManager($user->id,"+".$tr,"Milestone of ".$tr." votes achieved for poll (".$poll->question.")","nope","nope","nope");
            $user->profile->ifc += $tr;
            $user->profile->save();
        }

        /*TransactionController::insertToManager(Auth::user()->id,"-".$poll->ifc,"Took poll:",'http://b2.com/poll/'.$poll->id,$poll->question,"content");*/


        return View::make('pollResult')->with('responses',$responses)->with('total',$tr);
    }


    public function deletePoll($pid)
    {
        if(Auth::check())
        {
            $poll=Poll::find($pid);
            $poll->delete();
            Action::delAction($pid);
            return "Success";
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function closePoll($pid)
    {
        if(Auth::check())
        {
        $poll=Poll::find($pid);
        if($poll->active==0)
        {
            $poll->active=true;
            $poll->save();
            return "Close";
        }
        else
        {
            $poll->active=false;
            $poll->save();
            return "Open";
        }

    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getPollResult($pid)
    {
        if(Auth::check())
        {
        try
        {
        $poll=Poll::find($pid);
        $responses=$poll->getOptions()->get();
        $tr=0;
        foreach($responses as $r)
        {
            $tr+=$r->responses;
        }
        return View::make('pollResult')->with('responses',$responses)->with('total',$tr);
        }
        catch(Exception $e)
        {
            return "No Votes yet!";
        }
    }
        else
            return 'wH@tS!nTheB0x';
    }
}