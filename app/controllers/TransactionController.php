<?php

class TransactionController extends \BaseController
{

    public static function insertToManager($userid,$ifc,$message,$link,$linkname,$type)
    {
        $manager=new Manager();
        $manager->userid=$userid;
        $manager->ifc=$ifc;
        $manager->ifctotal=User::find($userid)->profile->ifc;
        $manager->message=$message;
        $manager->link=$link;
        $manager->linkname=$linkname;
        $manager->type=$type;
        $manager->save();
    }

    public function getIfcModal($ifcReq)
    {
        if(Auth::check())
        {
            $link = Input::get('link');
            $content = Input::get('content');
            $ifcAval = Auth::user()->profile->ifc;
            $ifcRem = $ifcAval - $ifcReq;


            return View::make('ifcModal')->with('ifcRem', $ifcRem)->with('ifcAval', $ifcAval)->with('ifcReq', $ifcReq)->with('link', $link)->with('content', $content);
        }
        else
            return 'wH@tS!nTheB0x';
    }


    function getIfcManager()
    {
            $userid = Auth::user()->id;
            $friends1 = DB::table('friends')->where('friend1', '=', $userid)->where('status', '=', 'accepted')->lists('friend2');
            $friends2 = DB::table('friends')->where('friend2', '=', $userid)->where('status', '=', 'accepted')->lists('friend1');
            $friends = array_merge($friends1, $friends2);
            $users1 = new \Illuminate\Database\Eloquent\Collection();

            foreach ($friends as $f) {
                $users1->add(User::find($f));
            }

            $users=Manager::where('userid','=',Auth::user()->id)->get();

            return View::make('ifcManager')->with('friends', $users1)->with('users',$users);
    }

}