<?php

class GraphicsController extends \BaseController
{

	public function getArticleChartData()
    {
        if(Auth::check())
        {
        $days = Input::get('days', 7);
        $range=\Carbon\Carbon::now()->subDays($days);
        $articles=Auth::user()->getArticles()->where('created_at', '>=', $range)->groupBy('users')->orderBy('users', 'DESC')->take(5)->get([DB::raw('title as article'),DB::raw('users as value')]);
        $stats= array();
        $i=0;

        foreach($articles as $article)
        {
            $data=array('label'=>$article->article,'value'=>$article->value);
            $stats[$i]=$data;
            $i++;
        }
        return $stats;

    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getBooksChartData()
    {
        if(Auth::check())
        {
        $days = Input::get('days', 7);
        $range=\Carbon\Carbon::now()->subDays($days);
        $books=Auth::user()->getBlogBooks()->where('created_at', '>=', $range)->groupBy('users')->orderBy('users', 'DESC')->take(5)->get([DB::raw('title as book'),DB::raw('users as value')]);
        $stats= array();
        $i=0;

        foreach($books as $book)
        {
            $data=array('label'=>$book->book,'value'=>$book->value);
            $stats[$i]=$data;
            $i++;
        }
        return $stats;
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getCollaborationsChartData()
    {
        if(Auth::check())
        {
        $days = Input::get('days', 7);
        $range=\Carbon\Carbon::now()->subDays($days);
        $collabs=Auth::user()->getOwnedCollaborations()->where('created_at', '>=', $range)->groupBy('users')->orderBy('users', 'DESC')->take(5)->get([DB::raw('title as book'),DB::raw('users as value')]);
        $stats= array();
        $i=0;

        foreach($collabs as $book)
        {
            $data=array('label'=>$book->book,'value'=>$book->value);
            $stats[$i]=$data;
            $i++;
        }
        return $stats;

    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getResourcesChartData()
    {
        if(Auth::check())
        {
        $days = Input::get('days', 7);
        $range=\Carbon\Carbon::now()->subDays($days);
        $stats =Auth::user()->getResources()->where('created_at', '>=', $range)->groupBy('users')->orderBy('users', 'ASC')->take(5)->get([DB::raw('title as resource'),DB::raw('users as value')]);
        return $stats;

    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getQuizChartData()
    {
        if(Auth::check())
        {
        $stats=array();
        $stats5=array();
        $days = Input::get('days', 7);
        $range=\Carbon\Carbon::now()->subDays($days);
        $quizes =Auth::user()->getQuizes()->where('created_at', '>=', $range)->get();
        $i=0;
        foreach($quizes as $quiz)
        {
            //Find number of quiztakers
            $takers= DB::table('quiztakers')->where('quiz_id',$quiz->id)->orderBy('ifc','desc')->get();
            $takersCount=count($takers);

            //Get total IFCs earned by the Quiz admin and the people who took the quiz.
            $totalIFC = $quiz->ifc*$takersCount;
            $earnedByQuizzers = DB::table('quiztakers')->where('quiz_id',$quiz->id)->sum('ifc');
            $earnedByAdmin = $totalIFC-$earnedByQuizzers;
            $stats[$i]=array('Quiz'=>$quiz->title,'value'=>$earnedByAdmin);

            $i++;
        }
        usort($stats, function($a, $b) {
            return $a['value'] - $b['value'];
        });
        $count=count($stats);
        if($count>5)
        {
            $count=5;
        }
        for($i=0;$i<$count;$i++)
        {
            $stats5[$i]=$stats[$i];
        }
        return $stats5;

    }
        else
            return 'wH@tS!nTheB0x';
    }




    public function getUserData()
    {
        if(Auth::check())
        {
        $user=Auth::user();
        //get the users friends
        $friends=Friend::friendsCount($user->id);
        //get number of subscribers
        $subscribers=Auth::user()->getSubscribers()->get();
        $subs=sizeof($subscribers);
        //questions
        $questions=$user->questionsAskedToUser()->get();
        $ques=sizeof($questions);
        $stats=array(array('label'=>'Friends','value'=>$friends),array('label'=>'Subscribers','value'=>$subs),array('label'=>'Questions','value'=>$ques));
        return $stats;

    }
        else
            return 'wH@tS!nTheB0x';
    }

    //these two are for chat stats
    public function getChatAuditData()
    {
        if(Auth::check())
        {
        $chatExpense=DB::table('chataudit')->where('userid','=',Auth::user()->id)->first();
        $stats=array();
        $stats[0]=array('label'=>'Chat Expenditure','value'=>$chatExpense->expenditure);
        $stats[1]=array('label'=>'Chat Earnings','value'=>$chatExpense->earning);
        return $stats;

    }
        else
            return 'wH@tS!nTheB0x';
    }
    public function getChatData()
    {
        if(Auth::check())
        {
        $stats=array();
        $stats5=array();
        $days = Input::get('days', 7);
        $range=\Carbon\Carbon::now()->subDays($days);
        $chats=DB::table('chats')->where('user1','=',Auth::user()->id)->orWhere('user2','=',Auth::user()->id)->where('created_at', '>=', $range)->groupBy('date')->get([DB::raw('sum(TIMESTAMPDIFF(MINUTE,created_at, updated_at)) as duration'),DB::raw('DATE(created_at) as date')]);
        $i=0;
        foreach($chats as $chat)
        {
            $stats[$i]=array('date'=>$chat->date,'days'=>$i+1,'duration'=>intval($chat->duration));
            $i++;

        }
        return $stats;

    }
        else
            return 'wH@tS!nTheB0x';
    }
}