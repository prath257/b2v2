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

    //this is the function for expensedonut on IFC manager page
    public function getExpenseChartData()
    {
        if(Auth::check())
        {
            $transactions=Manager::Where('userid','=',Auth::user()->id)->get();
            $expenses=0;
            $income=0;
            foreach($transactions as $trans)
            {
                $sign=$trans->ifc[0];
                if($sign=='+')
                {
                    $income+= intval(substr($trans->ifc, 1));
                }
                else
                {
                    $expenses+= intval(substr($trans->ifc, 1));
                }
            }

            $stats=array();
            $stats[0]=array('label'=>'Expenditure','value'=>$expenses);
            $stats[1]=array('label'=>'Earnings','value'=>$income);
            return $stats;

        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getIEChartData()
    {
        if(Auth::check())
        {
            $months=array();
            $income=array(0,0,0,0,0);
            $expense=array(0,0,0,0,0);
            $finalData=array();
            $monthIndex=0;
            $i=0;
            $match=0;
            $query='select * from manager where userid='.Auth::user()->id.' and created_at >= date_add(created_at,INTERVAL -5 MONTH) order by created_at desc';
            $transactions=DB::select($query);
            foreach($transactions as $trans)
            {
                $cdate=new DateTime($trans->created_at);
                $month=$cdate->format('M');
                for($i=0;$i<count($months);$i++)
                {
                    if($month==$months[$i])
                    {
                        $match=1;
                        break;
                    }
                }
                if($match==false)
                {
                    $months[$monthIndex] = $month;

                    $sign=$trans->ifc[0];
                    if($sign=='+')
                    {
                             $income[$monthIndex]= intval(substr($trans->ifc, 1));
                    }
                    else
                    {
                            $expense[$monthIndex]= intval(substr($trans->ifc, 1));
                    }
                    $monthIndex++;
                }
                else
                {
                    $sign=$trans->ifc[0];
                    if($sign=='+')
                    {
                       $income[$i]+= intval(substr($trans->ifc, 1));
                    }
                    else
                    {
                       $expense[$i]+= intval(substr($trans->ifc, 1));
                    }
                }
                $match=0;
            }
            $cm=count($months);
            for($i=0;$i<$cm;$i++)
            {
               $finalData[$i] = array('month' => $months[$i], 'income' => $income[$i],'expense'=>$expense[$i]);
            }
            return $finalData;

        }
        else
            return 'wH@tS!nTheB0x';
    }

}