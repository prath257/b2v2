<?php

class QAController extends \BaseController
{
	public static $user=null;

    public function getQnA($userId)
    {
        if(Auth::check())
        {
               return View::make('QnA')->with('user',User::find($userId));
        }
        else
            return 'wH@tS!nTheB0x';
    }
	public function postQuestion()
	{
        if(Auth::check())
        {
		$question= new Question();
		$question->askedBy_id = Auth::user()->id;
		$question->askedTo_id = Input::get('userid');
		$question->question = Input::get('question');
        $des=Input::get('description');
        if($des!='null')
        $question->description = $des;
		$question->ifc = Input::get('questionIFC');
        if (Input::get('access') == 'private')
            $question->private = true;
        else
            $question->private = false;
		$question->save();

        AjaxController::insertToNotification(Input::get('userid'),Auth::user()->id,"question","asked you a question for ".Input::get('questionIFC'),'http://b2.com/user/'.Auth::user()->username);

		QAController::$user = User::find(Input::get('userid'));

        if (QAController::$user->settings->notifications)
        {
            Mail::send('mailers', array('user'=>Auth::user(), 'receiver'=>QAController::$user, 'question'=>Input::get('question'), 'questionIFC'=>Input::get('questionIFC'),'page'=>'newQuestionMailer'), function($message)
            {
                $message->to(QAController::$user->email,QAController::$user->first_name)->subject('New Question!');
            });
        }
	}
        else
            return 'wH@tS!nTheB0x';
    }

	public function postAnswer()
	{
        if(Auth::check())
        {
		$questionid=Input::get('id');
		$date=new DateTime();

		$question= Question::find($questionid);
		$question->answer = Input::get('answer');
		$question->updated_at = $date;
		$question->save();

		$user=Auth::user();
		$user->profile->ifc+=$question->ifc;
		$user->profile->save();

        AjaxController::insertToNotification($question->askedBy_id,Auth::user()->id,"question","answered your question",'http://b2.com/user/'.Auth::user()->username);

		$userid=$question->askedBy_id;
		QAController::$user = User::find($userid);
		QAController::$user->profile->ifc-=$question->ifc;
		QAController::$user->profile->save();

        TransactionController::insertToManager($user->id,"+".$question->ifc,"Answered a question by",'http://b2.com/user/'.User::find($userid)->username,User::find($userid)->first_name.' '.User::find($userid)->last_name,"profile");

        TransactionController::insertToManager(User::find($userid)->id,"-".$question->ifc,"Your question was answered by",'http://b2.com/user/'.$user->username,$user->first_name.' '.$user->last_name,"profile");

        if (QAController::$user->settings->notifications)
        {
            Mail::send('mailers', array('user'=>$user, 'receiver'=>QAController::$user, 'answer'=>Input::get('answer'),'page'=>'newAnswerMailer'), function($message)
            {
                $message->to(QAController::$user->email,QAController::$user->first_name)->subject('New Answer!');
            });
        }
        return Auth::user()->id;
	}
        else
            return 'wH@tS!nTheB0x';
    }

	public function declineAnswer()
	{
        if(Auth::check())
        {
		$id = Input::get('id');
		$question = Question::find($id);
		$question->delete();
	}
        else
            return 'wH@tS!nTheB0x';
    }

	//this is the function to post the about him/her content

	public function postAboutText()
	{
        if(Auth::check())
        {
		$about=new About();
		$about->writtenby=Auth::user()->id;
		$about->writtenfor=Input::get('wfor');
		$about->content=Input::get('aboutText');
		$about->ifc=Input::get('aboutIFC');
		$about->status='new';
		$about->save();

		QAController::$user = User::where('id','=',Input::get('wfor'))->first();

        AjaxController::insertToNotification(Input::get('wfor'),Auth::user()->id,"about"," wrote about you ",'http://b2.com/user/'.Auth::user()->username);

        if (QAController::$user->settings->notifications)
        {
            Mail::send('mailers', array('user'=>Auth::user(), 'receiver'=>QAController::$user,'page'=>'aboutMailer'), function($message)
            {
                $message->to(QAController::$user->email,QAController::$user->first_name)->subject('New content About You');
            });
        }

		return "Success";
	}
        else
            return 'wH@tS!nTheB0x';
    }


	public function postAcceptAbout()
	{
        if(Auth::check())
        {
		$about=About::find(Input::get('aid'));
		$about->status='accepted';
		$about->save();

        AjaxController::insertToNotification($about->writtenby,Auth::user()->id,"aboutR","accepted your Statement",'http://b2.com/user/'.Auth::user()->username);


        $user=Auth::user();
        $user->profile->ifc+=$about->ifc;
        $user->profile->save();
        TransactionController::insertToManager($user->id,"+".$about->ifc,"Accepted 'about you' written by",'http://b2.com/user/'.Auth::user()->username,Auth::user()->first_name.' '.Auth::user()->first_name,"profile");


        $user=User::find($about->writtenby);
        $user->profile->ifc-=$about->ifc;
        $user->profile->save();
        TransactionController::insertToManager($user->id,"-".$about->ifc,"You wrote about",'http://b2.com/user/'.User::find($about->writtenfor)->username,User::find($about->writtenfor)->first_name.' '.User::find($about->writtenfor)->last_name,"profile");



        return "Success";
	}
        else
            return 'wH@tS!nTheB0x';
    }

	public function postDeclineAbout()
	{
        if(Auth::check())
        {
		$about=About::find(Input::get('aid'));
		$about->delete();
		return "Success";
	}
        else
            return 'wH@tS!nTheB0x';
    }

    public function getDescription()
    {
        if(Auth::check())
        {
        $question = Question::find(Input::get('id'));
        return $question->description;
    }
        else
            return 'wH@tS!nTheB0x';
    }
    public function getAnswer()
    {
        if(Auth::check())
        {
        $question = Question::find(Input::get('id'));
        return $question->answer;
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getAnswerBox()
    {
        if(Auth::check())
        {
            return View::make('answerBox')->with('id',Input::get('id'));
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getAbout($id)
    {
        if(Auth::check())
        {
            $approved = User::find($id)->about()->where('status','=','accepted')->get();
            $unapproved = User::find($id)->about()->where('status','=','new')->get();
            return View::make('about')->with('Aboutuser',User::find($id))->with('trivia',User::find($id)->getTrivia()->get())->with('approved',$approved)->with('unapproved',$unapproved);
        }
        else
            return 'wH@tS!nTheB0x';
    }

}
