<?php

class BaseController extends Controller
{

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    public static $mail = null;

    public function getReportBug()
    {
        return View::make('reportBug');
    }

    public function postReportBug()
    {
        if(Auth::check())
        {
        DB::table('reportbug')->insert(array('userid' => Auth::user()->id, 'text' => Input::get('content')));
        $bug = DB::table('reportbug')->where('userid', Auth::user()->id)->where('text', Input::get('content'))->first();

        Mail::send('mailers', array('bug' => $bug, 'page' => 'bugMailer'), function ($message) {
            $message->to('ksjoshi88@gmail.com')->subject('New Bug');
        });
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getRespondToBug($bugId)
    {
        if(Auth::check())
        {
            return View::make('respondToBug')->with('bug', $bugId);
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function postRespondToBug()
    {
        $bug = DB::table('reportbug')->where('id', Input::get('id'))->first();
        $user = User::find($bug->userid);
        $user->profile->ifc += Input::get('ifc');
        $user->profile->save();
        BaseController::$mail = $user->email;

        TransactionController::insertToManager($user->id, "+" . Input::get('ifc'), "IFCs awarded for reporting bug/suggestion", "nope", "nope", "nope");

        Mail::send('mailers', array('ifc' => Input::get('ifc'), 'response' => Input::get('response'), 'page' => 'bugResponseMailer'), function ($message) {
            $message->to(BaseController::$mail)->subject('Response to Bug Report');
        });
    }

    public function addInterestsToWallpics()
    {
        try {
            $wallpic = Wallpic::all();
            foreach ($wallpic as $w) {
                if (Str::contains($w->wallpic, 'Sports')) {
                    $w->interest = 'Sports';
                    $w->save();
                } else if (Str::contains($w->wallpic, 'Technology')) {
                    $w->interest = 'Technology';
                    $w->save();
                } else if (Str::contains($w->wallpic, 'Movies and Television')) {
                    $w->interest = 'MoviesTelevision';
                    $w->save();
                } else if (Str::contains($w->wallpic, 'Music')) {
                    $w->interest = 'Music';
                    $w->save();
                } else if (Str::contains($w->wallpic, 'Gaming')) {
                    $w->interest = 'Gaming';
                    $w->save();
                } else if (Str::contains($w->wallpic, 'Automobiles')) {
                    $w->interest = 'Automobile';
                    $w->save();
                } else if (Str::contains($w->wallpic, 'Politics')) {
                    $w->interest = 'Politics';
                    $w->save();
                } else if (Str::contains($w->wallpic, 'Fashion')) {
                    $w->interest = 'Fashion';
                    $w->save();
                } else if (Str::contains($w->wallpic, 'Travel')) {
                    $w->interest = 'Travel';
                    $w->save();
                } else if (Str::contains($w->wallpic, 'Literature')) {
                    $w->interest = 'Literature';
                    $w->save();
                }
            }
            return 'Success Admin!';
        } catch (Exception $e) {
            return $e;
        }
    }

    public function saveDefaultInterests()
    {
        try {
            $interest1 = new Interest();
            $interest1->interest = 'music';
            $interest1->interest_name = 'Music';
            $interest1->save();

            $interest1 = new Interest();
            $interest1->interest = 'moviesTelevision';
            $interest1->interest_name = 'MoviesTelevision';
            $interest1->save();

            $interest1 = new Interest();
            $interest1->interest = 'politics';
            $interest1->interest_name = 'Politics';
            $interest1->save();

            $interest1 = new Interest();
            $interest1->interest = 'sports';
            $interest1->interest_name = 'Sports';
            $interest1->save();

            $interest1 = new Interest();
            $interest1->interest = 'gaming';
            $interest1->interest_name = 'Gaming';
            $interest1->save();

            $interest1 = new Interest();
            $interest1->interest = 'travel';
            $interest1->interest_name = 'Travel';
            $interest1->save();

            $interest1 = new Interest();
            $interest1->interest = 'fashion';
            $interest1->interest_name = 'Fashion';
            $interest1->save();

            $interest1 = new Interest();
            $interest1->interest = 'literature';
            $interest1->interest_name = 'Literature';
            $interest1->save();

            $interest1 = new Interest();
            $interest1->interest = 'technology';
            $interest1->interest_name = 'Technology';
            $interest1->save();

            $interest1 = new Interest();
            $interest1->interest = 'automobile';
            $interest1->interest_name = 'Automobile';
            $interest1->save();

            $interest1 = new Interest();
            $interest1->interest = 'cooking';
            $interest1->interest_name = 'Cooking';
            $interest1->save();

            return 'Success Admin!';
        } catch (Exception $e) {
            return $e;
        }
    }

    public function getIFCDeficit()
    {
        $contentIFC = null;
        $userIFC = null;
        $categories=Auth::user()->interestedIn()->get();
        return View::make('ifcDeficit')->with('contentIFC', $contentIFC)->with('userIFC', $userIFC)->with('categories', $categories);
    }

    public function hathwayStopIt()
    {
        return View::make('hathwayStopIt');
    }

    public function submitProblemOnException()
    {
        Mail::send('mailers', array('past' => Input::get('past'), 'future' => Input::get('future'), 'present' => Input::get('present'), 'page' => 'submitProblemOnException'), function ($message) {
            $message->to('ksjoshi88@gmail.com')->subject('Problem on exception');
        });
    }

    public function getReportException()
    {
        return View::make('reportException');
    }

    public function respondToProblem($userid)
    {
        if (Auth::user()->username == 'ksjoshi88')
            return View::make('respondToProblem')->with('userid',$userid);
    }

    public function postResponceToProblem()
    {
        if(Auth::check())
        {
        $user = User::find(Input::get('id'));
        $user->profile->ifc += Input::get('ifc');
        $user->profile->save();

        TransactionController::insertToManager(Input::get('id'),"+".Input::get('ifc'),"IFCs awarded for reporting problem","nope","nope","nope");

        BaseController::$mail = $user->email;
        Mail::send('mailers', array('ifc'=>Input::get('ifc'),'response'=>Input::get('response'),'user' => $user, 'page'=>'responseToProblem'), function($message)
        {
            $message->to(BaseController::$mail)->subject('Response to your problem');
        });
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function accidentialLogout()
    {
        return Redirect::route('index')->with('error','You have been logged out. Visit tomorrow to earn <b>50 ifcs</b>.');
    }

    public function forgotUsername()
    {
        $user = User::where('email','=',Input::get('email'))->first();
        if (count($user) != 0)
        {
            Mail::send('mailers', array('user' => $user, 'page' => 'forgotUsernameMailer'), function ($message) {
                $message->to(Input::get('email'))->subject('Forgot Username');
            });
            return 'Success';
        }
        else
            return 'no-user';
    }
}