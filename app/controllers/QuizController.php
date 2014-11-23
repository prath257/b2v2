<?php

class QuizController extends \BaseController {

    public static $email = null;
    public function getQuizDashboard()
    {
        $categories=Auth::user()->interestedIn()->get();
        return View::make('quizDashboard')->with('categories',$categories);
    }

    public function postNewQuiz()
    {
        $access=Input::get('access');
        if($access==null)
            $ispublic='false';
        else
            $ispublic='true';

        $data=array('title'=>Input::get('title'),
            'description'=>Input::get('description'),
            'category'=>Input::get('category'),
            'ifc'=>Input::get('ifc'),
            'time'=>Input::get('time'),
            'access'=>$ispublic
        );

        return View::make('createQuiz',$data);
    }

    public function getNewQuiz()
    {
        $error = 'you aren\'t allowed to do that! You have to first create a quiz from the Quiz Dashboard.';
        return View::make('errorPage')->with('error',$error)->with('link','http://b2.com/quizDashboard');
    }

    //this is the function to create a new quiz in database
    public function postCreateQuiz()
    {
        if(Auth::check())
        {
        $access = Input::get('access');

        if (Input::get('id') == 0)
        {
            $quiz = new Quiz();
            $quiz->title = Input::get('title');
            $quiz->description = Input::get('description');
            $quiz->category = Input::get('category');
            $quiz->ifc = Input::get('ifc');
            $quiz->time = Input::get('time');
            if ($access == 'true')
                $quiz->ispublic = true;
            else
                $quiz->ispublic = false;
            $quiz->ownerid = Auth::user()->id;
            $quiz->save();

            Action::postAction('Q new',Auth::user()->id,null,$quiz->id);
            $subscribers = DB::table('subscriptions')->where('subscribed_to_id','=',Auth::user()->id)->lists('subscriber_id');
            foreach($subscribers as $s)
            {
                QuizController::$email=User::find($s)->email;
                Mail::send('mailers',array('user' => User::find($s),'content' => $quiz,'type' => 'Q','writer' => Auth::user(),'page'=>'readerMailer'),function($message)
                {
                    $message->to(QuizController::$email)->subject('New Quiz');
                });
            }
        }
        else
        {
            $quiz = Quiz::find(Input::get('id'));
        }



        $qCount=Input::get('count');
        $qId=$quiz->id;

        //get all the arrays
        $questions=Input::get('questions');
        $option1=Input::get('option1');
        $option2=Input::get('option2');
        $option3=Input::get('option3');
        $option4=Input::get('option4');
        $correct1=Input::get('correct1');
        $correct2=Input::get('correct2');
        $correct3=Input::get('correct3');
        $correct4=Input::get('correct4');
        for($i=0;$i<$qCount;$i++)
        {
            $quizOption=new Quizoption();
            $quizOption->quizid=$qId;
            $quizOption->question=$questions[$i];
            $quizOption->option1=$option1[$i];
            $quizOption->option2=$option2[$i];
            if($option3[$i]=="TheMonumentsMenGeorgeClooneyMattDamon")
                $quizOption->option3=NULL;
            else
                $quizOption->option3=$option3[$i];
            if($option4[$i]=="TheMonumentsMenGeorgeClooneyMattDamon")
                $quizOption->option4=NULL;
            else
                $quizOption->option4=$option4[$i];

            if ($correct1[$i]=='true')
                $quizOption->correct1=true;
            else if ($correct1[$i]=='false')
                $quizOption->correct1=false;
            if ($correct2[$i]=='true')
                $quizOption->correct2=true;
            else if ($correct2[$i]=='false')
                $quizOption->correct2=false;
            if ($correct3[$i]=='true')
                $quizOption->correct3=true;
            else if ($correct3[$i]=='false')
                $quizOption->correct3=false;
            if ($correct4[$i]=='true')
                $quizOption->correct4=true;
            else if ($correct4[$i]=='false')
                $quizOption->correct4=false;
            $quizOption->save();
        }

        return "Success";
    }
        else
            return 'wH@tS!nTheB0x';
    }
    public function getQuiz($id)
    {
        $quiz = Quiz::find($id);


        $flag = 0;
        if(Auth::user()->id==$quiz->ownerid)
        {
           return View::make('errorPage')->with('error','quiz owner can\'t take the quiz')->with('link','http://b2.com/quizDashboard');
        }
        $quiztakers = $quiz->getTakers()->get();
        foreach ($quiztakers as $quiztaker)
        {
            if ($quiztaker->id == Auth::user()->id)
            {
                $flag = 1;
                break;
            }
        }
        if ($flag==0)
        {
            Auth::user()->takenQuizzes()->attach($quiz->id);
            $quiz->users ++;
            $quiz->save();
            $quizOptions = $quiz->getOptions()->get();
            return View::make('quiz')->with('quiz',$quiz)->with('quizOptions',$quizOptions);
        }

        else if ($flag==1)
            return View::make('errorPage')->with('error','seems like you have already taken this quiz')->with('link','http://b2.com/quizDashboard');
    }

    public function checkAns()
    {
        if(Auth::check())
        {
        $type = Input::get('type');
        if ($type=='maq')
        {
            $question = Quizoption::find(Input::get('id'));
            $answer = Input::get('answer');
            $count = 0;

            $correctAnswers=new \Illuminate\Database\Eloquent\Collection();
            if ($question->correct1==true)
                $correctAnswers->add($question->option1);
            if ($question->correct2==true)
                $correctAnswers->add($question->option2);
            if ($question->correct3==true)
                $correctAnswers->add($question->option3);
            if ($question->correct4==true)
                $correctAnswers->add($question->option4);

            $noOfAns = $correctAnswers->count();
            $noOfSentAns = sizeof($answer);
            if ($noOfAns==$noOfSentAns)
            {
                for ($i=0; $i<$noOfAns; $i++)
                {
                    for ($j=0; $j<$noOfSentAns; $j++)
                    {
                        if ($correctAnswers[$i]==$answer[$j])
                            $count++;
                    }
                }
                if ($count==$noOfAns)
                    return "true";
                else
                    return "false";

            }
            else
                return "false";
        }
        else if ($type=='saq')
        {
            $question = Quizoption::find(Input::get('id'));
            $answer = Input::get('answer');

            if ($question->correct1==true)
                $correctAnswer=$question->option1;
            else if ($question->correct2==true)
                $correctAnswer=$question->option2;
            else if ($question->correct3==true)
                $correctAnswer=$question->option3;
            else if ($question->correct4==true)
                $correctAnswer=$question->option4;

            if ($answer==$correctAnswer)
                return "true";
            else
                return "false";
        }
        else if ($type=='tfq')
        {
            $question = Quizoption::find(Input::get('id'));
            $answer = Input::get('answer');

            if ($question->correct1==true)
                $correctAnswer=$question->option1;
            else if ($question->correct2==true)
                $correctAnswer=$question->option2;

            if ($answer==$correctAnswer)
                return "true";
            else
                return "false";
        }
    }
        else
            return 'wH@tS!nTheB0x';
    }
    public function postQuizResults()
    {
        if(Auth::check())
        {
        $quiz = Quiz::find(Input::get('id'));
        $correctAnswers = Input::get('correct');
        $quizQuestionsCount = count($quiz->getOptions()->get());
        $percentage = ($correctAnswers/$quizQuestionsCount)*100;
        $ifcQuizzer = $quiz->ifc*($percentage/100);
        $ifcQuizzer = round($ifcQuizzer);
        Auth::user()->profile->ifc += $ifcQuizzer;
        Auth::user()->profile->save();
        $ifcQuizMaker = $quiz->ifc - $ifcQuizzer;
        $ifcQuizMaker = round($ifcQuizMaker);
        $user = User::find($quiz->ownerid);
        $user->profile->ifc += $ifcQuizMaker;
        $user->profile->save();

        Action::postAction('Q score',Auth::user()->id,$ifcQuizzer,$quiz->id);

        TransactionController::insertToManager(Auth::user()->id,"+".$ifcQuizzer,"Earned from quiz",'http://b2.com/quizPreview/'.$quiz->id,$quiz->title,"content");

        TransactionController::insertToManager($user->id,"+".$ifcQuizMaker,"Earned from quiz",'http://b2.com/quizPreview/'.$quiz->id,$quiz->title,"content");

        AjaxController::insertToNotification($quiz->ownerid,Auth::user()->id,"purchased","Took your Quiz ".$quiz->title,'http://b2.com/quizPreview/'.$quiz->id);

        DB::table('quiztakers')->where('quiz_id',$quiz->id)->where('user_id',Auth::user()->id)->update(array('ifc' => $ifcQuizzer));

        return View::make('quizResult')->with('ca',$correctAnswers)->with('ue',$ifcQuizzer)->with('oe',$ifcQuizMaker);
    }
        else
            return 'wH@tS!nTheB0x';
    }
    public function deleteQuiz($pid)
    {
        if(Auth::check())
        {
        $quiz=Quiz::find($pid);
        $quiz->delete();
        Action::delAction($pid);


        return "Success";
    }
        else
            return 'wH@tS!nTheB0x';
    }
    public function closeQuiz($pid)
    {
        if(Auth::check())
        {
        $quiz=Quiz::find($pid);
        if($quiz->ispublic==0)
        {
            $quiz->ispublic=true;
            $quiz->save();
            return "Close";
        }
        else
        {
            $quiz->ispublic=false;
            $quiz->save();
            return "Open";
        }

    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getQuizStats($pid)
    {
        if(Auth::check())
        {
        //Find the quiz
        $quiz=Quiz::find($pid);
        //Find number of quiztakers
        $takers= DB::table('quiztakers')->where('quiz_id',$pid)->orderBy('ifc','desc')->get();
        $takersCount=count($takers);

        //Get total IFCs earned by the Quiz admin and the people who took the quiz.
        $totalIFC = $quiz->ifc*$takersCount;
        $earnedByQuizzers = DB::table('quiztakers')->where('quiz_id',$pid)->sum('ifc');
        $earnedByAdmin = $totalIFC-$earnedByQuizzers;


        return View::make('quizStats')->with('tcount',$takersCount)->with('earnings',$earnedByAdmin);

    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function quizPreview($id)
    {
        $quiz=Quiz::find($id);
        $author = User::find($quiz->ownerid)->first_name.' '.User::find($quiz->ownerid)->last_name;
        return View::make('quizPreview')->with('quiz',$quiz)->with('author',$author);
    }

    public function editQuiz($id)
    {
        $quiz = Quiz::find($id);

        if (Auth::user()->id == $quiz->ownerid)
            return View::make('editQuiz')->with('quiz',$quiz);
        else
            return View::make('errorPage')->with('error','the quiz owner is the only person authorized to edit the Quiz.')->with('link','http://b2.com/quizDashboard');
    }

    public function removeExistingQuestion()
    {
        if(Auth::check())
        {
        $option = Quizoption::find(Input::get('id'));
        $option->delete();
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function editExistingQuestion()
    {
        if(Auth::check())
        {
        $option = Quizoption::find(Input::get('id'));
        return View::make('editQuizQuestion')->with('question',$option);
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function updateQuizQuestion()
    {
        if(Auth::check())
        {
        $option1=Input::get('option1');
        $option2=Input::get('option2');
        $option3=Input::get('option3');
        $option4=Input::get('option4');
        $answer=Input::get('answer');

        $option = Quizoption::find(Input::get('id'));
        $option->question = Input::get('question');

        if ($option1 != null && $option2 != null && $option3 != null && $option4 != null)
        {
            $option->option1 = $option1;
            $option->option2 = $option2;
            $option->option3 = $option3;
            $option->option4 = $option4;
        }

        $count = count($answer);
        if ($count > 1)
        {
            $option->correct1 = false;
            $option->correct2 = false;
            $option->correct3 = false;
            $option->correct4 = false;
            $option->save();
            foreach($answer as $ans)
            {
                if ($ans == 'A')
                {
                    $option->correct1 = true;
                }
                elseif ($ans == 'B')
                {
                    $option->correct2 = true;
                }
                elseif ($ans == 'C')
                {
                    $option->correct3 = true;
                }
                elseif ($ans == 'D')
                {
                    $option->correct4 = true;
                }
            }
            $option->save();
        }
        else
        {
            if ($option->option3 == null && $option->option4 == null)
            {
                if ($answer == 'A')
                {
                    $option->correct1 = true;
                    $option->correct2 = false;
                    $option->save();
                }
                elseif ($answer == 'B')
                {
                    $option->correct1 = false;
                    $option->correct2 = true;
                    $option->save();
                }
            }
            else
            {
                $option->correct1 = false;
                $option->correct2 = false;
                $option->correct3 = false;
                $option->correct4 = false;
                $option->save();
                if ($answer == 'A')
                {
                    $option->correct1 = true;
                    $option->save();
                }
                elseif ($answer == 'B')
                {
                    $option->correct2 = true;
                    $option->save();
                }
                elseif ($answer == 'C')
                {
                    $option->correct3 = true;
                    $option->save();
                }
                elseif ($answer == 'D')
                {
                    $option->correct4 = true;
                    $option->save();
                }
            }
        }
    }
        else
            return 'wH@tS!nTheB0x';
    }
}
