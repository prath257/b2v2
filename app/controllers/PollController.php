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
        $ifc=Input::get('ifc');
        $isPublic=Input::get('access');

        $poll=new Poll();
        $poll->question=$pquestion;
        $poll->message=$message;
        $poll->active=true;
        $poll->ifc=$ifc;
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

        //Now redirect the user to the Poll page
        return Redirect::to('/poll/'.$poll->id);
    }

    public function showPoll($pid)
    {
        $poll=Poll::find($pid);
        return View::make('poll')->with('poll',$poll);
    }

    public function submitPoll()
    {
        if(Auth::check())
        {
        $pid=Input::get('pollId');
        $poll=Poll::find($pid);

        if (Auth::user()->profile->ifc >= $poll->ifc)
        {
            $rid=Input::get('response');
            $response=Polloption::find($rid);
            $response->responses+=1;
            $response->save();

            //Deduct IFCs of the answerer and increase the IFC count of the poll's owner.
            Auth::user()->profile->ifc -= $poll->ifc;
            Auth::user()->profile->save();
            $user = User::find($poll->ownerid);
            $user->profile->ifc += $poll->ifc;
            $user->profile->save();

            $responses=$poll->getOptions()->get();
            $tr=0;
            foreach($responses as $r)
            {
                $tr+=$r->responses;
            }

            TransactionController::insertToManager(Auth::user()->id,"-".$poll->ifc,"Took poll:",'http://b2.com/poll/'.$poll->id,$poll->question,"content");

            TransactionController::insertToManager($user->id,"+".$poll->ifc,"New vote to poll (".$poll->question.") by",'http://b2.com/user/'.Auth::user()->username,Auth::user()->first_name.' '.Auth::user()->last_name,"profile");

            return View::make('pollResult')->with('responses',$responses)->with('total',$tr);
        }
        else
        {
            return '<br>Sorry, you need '.$poll->ifc.' IFCs to submit this Poll and as of now, you\'ve got '.Auth::user()->profile->ifc.' IFCs left. Learn more about earning IFCs <a href="http://b2.com/earnIFCs" style="text-decoration: none"><b>HERE.</b></a>';
        }
    }
        else
            return 'wH@tS!nTheB0x';
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