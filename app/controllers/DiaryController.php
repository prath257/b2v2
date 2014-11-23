<?php

class DiaryController extends \BaseController {

    public static $date=null;

    public function getDiary($username)
    {
        $u2 = User::where('username','=',$username)->first();
        if (Auth::user()->username == $username || $u2->settings->diaryAccess == 'public')
        {
            $posts = Diary::where('userid','=',$u2->id)->get();
            $currentDateTime = new DateTime();
            DiaryController::$date = $currentDateTime->format('Y-m-d');
            $send = $posts->filter(function($post)
            {
                $postDateTime = $post->created_at;
                $postDate = $postDateTime->format('Y-m-d');
                if ($postDate == DiaryController::$date)
                    return true;
            });
            return View::make('diary')->with('user',$u2)->with('posts',$send);
        }
        else
        {
            $user = User::where('username','=',$username)->first();
            $susers=Diaryshare::where('duserid','=',$user->id)->where('suserid','=',Auth::user()->id)->first();
            $posts = Diary::where('userid','=',$user->id)->get();
            $currentDateTime = new DateTime();
            DiaryController::$date = $currentDateTime->format('Y-m-d');
            $send = $posts->filter(function($post)
            {
                $postDateTime = $post->created_at;
                $postDate = $postDateTime->format('Y-m-d');
                if ($postDate == DiaryController::$date)
                    return true;
            });
            if (count($susers) > 0 && $user->settings->diaryAccess == 'semi')
                return View::make('diary')->with('user',User::where('username','=',$username)->first())->with('posts',$send);
            else
                return "Sorry, you don't have access to this page";
        }
    }

    public function getCalendar()
    {
        return View::make('calendar')->with('userid',Input::get('userid'));
    }

    public function setDiaryAccess()
    {
        if(Auth::check())
        {
            $type=Input::get('type');
            Auth::user()->settings->diaryAccess=$type;
            Auth::user()->settings->save();
            return 'success';

        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getUsers()
    {
        if(Auth::check())
        {
            $userid = Auth::user()->id;
            $friends1 = DB::table('friends')->where('friend1', '=', $userid)->where('status', '=', 'accepted')->lists('friend2');
            $friends2 = DB::table('friends')->where('friend2', '=', $userid)->where('status', '=', 'accepted')->lists('friend1');
            $friends = array_merge($friends1, $friends2);
            $users1 = new \Illuminate\Database\Eloquent\Collection();
            $susers=Diaryshare::where('duserid','=',$userid)->lists('suserid');

            foreach ($friends as $f)
            {
                $flag=0;
                foreach ($susers as $sid)
                {
                    if ($f == $sid)
                    {
                        $flag=1;
                        break;
                    }
                }
                if($flag == 0)
                    $users1->add(User::find($f));
            }

            return View::make('semiPublic')->with('friends', $users1);
        }
        else
            return 'wH@tS!nTheB0x';
    }


    public function addSuser()
    {
        if(Auth::check())
        {
            $suser=User::find(Input::get('suserid'));
            $share=new Diaryshare();
            $share->duserid=Auth::user()->id;
            $share->suserid=$suser->id;
            $share->save();
            return View::make('susers')->with('suser',$suser);
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function delSuser()
    {
        if(Auth::check())
        {
            $type= Input::get('type');
            if($type=='all')
            {
                Diaryshare::where('duserid','=',Auth::user()->id)->delete();
            }
            else
            {
                $share=Diaryshare::where('duserid','=',Auth::user()->id)->where('suserid','=',Input::get('id'))->first();
                $share->delete();
            }
            return Input::get('id');

        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getSusers()
    {
        if(Auth::check())
        {
            $susers=Diaryshare::where('duserid','=',Auth::user()->id)->lists('suserid');
            $users= new \Illuminate\Database\Eloquent\Collection();
            foreach($susers as $s)
            {
                $users->add(User::find($s));
            }
            return View::make('susers')->with('susers',$users);
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function saveDiary()
    {
        if(Auth::check())
        {
            $message=Input::get('message');
            $access=Input::get('access');
            $type=Input::get('type');

            if($type=='edit')
                $diary=Diary::find(Input::get('id'));  //id is the primary key id of the diary table
            else
                $diary=new Diary();


            $diary->userid=Auth::user()->id;
            $diary->text=$message;
            if ($access == 'public')
                $diary->ispublic = true;
            else
                $diary->ispublic = false;
            $diary->save();

            if ($type!='edit' && (Auth::user()->settings->diaryAccess == 'public' || Auth::user()->settings->diaryAccess == 'semi'))
                Action::postAction('Diary new',Auth::user()->id,null,null);

        }
        else
            return 'wH@tS!nTheB0x';
    }


    public function createDiary()
    {
        if(Auth::check())
        {
            $type=Input::get('type');

            if($type!='single')
            {
                $posts = Diary::where('userid','=',Input::get('userid'))->get();
                DiaryController::$date = new DateTime(Input::get('date'));
                DiaryController::$date = DiaryController::$date->format('Y-m-d');
                $send = $posts->filter(function($post)
                {
                    $postDateTime = $post->created_at;
                    $postDate = $postDateTime->format('Y-m-d');
                    if ($postDate == DiaryController::$date)
                        return true;
                });
                //$diary=DB::table('diary')->where('created_at','=',$date)->get()->where('userid','=',Auth::user()->id);
                //or some other query which will retrive all the entry from the table , for a specific date, for a specific user
            }

            if($type=='single')
                return View::make('diarySingle')->with('type',$type);
            else
                return View::make('diarySingle')->with('type',$type)->with('diaries',$send);

        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function deleteDiaryPost()
    {
        if(Auth::check())
        {
        Diary::find(Input::get('id'))->delete();
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function updateDiaryTitle()
    {
        if(Auth::check())
        {
        Auth::user()->settings->diaryTitle = Input::get('title');
        Auth::user()->settings->save();
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getMonthlyDates()
    {
        if(Auth::check())
        {
            $year=Input::get('year');
            $month=Input::get('month');
            $userid = Input::get('userid');

            //Now is the code to get all the entries for the month year for auth user
            $posts=DB::select('select DATE(created_at) as postday from diary where userid ='.$userid.' and YEAR(DATE(created_at))='.$year.' and MONTH(DATE(created_at))='.$month);

            $result=array();
            $i=0;
            foreach ($posts as $key => $value)
            {
                $result[$i] = $value->postday;
                $i++;
            }
            return $result;
        }
        else
            return 'wH@tS!nTheB0x';
    }
}
