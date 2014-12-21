<?php

class MobileAuthController extends \BaseController {


    public function login()
    {
        try
        {
            $credentials = array('username' => Input::get('uname'),'password' => Input::get('pwd'));

            // Try to authenticate the user, remember me is set to false

            // $user = Sentry::authenticate($credentials, false);

            Auth::attempt($credentials);

            if(Auth::check())
            {
                if(Auth::user()->activated)
                {
                    $user = Auth::user();

                    $arr=Array("ok"=>"true","id"=>$user->id,"first_name"=>$user->first_name,"last_name"=>$user->last_name);

                    return json_encode($arr);


                }
                else
                {
                    $arr=Array("ok"=>"not activated");

                    return json_encode($arr);

                }
            }
            //if everything went okay, we redirect to index route with success message
            else
            {
                $arr=Array("ok"=>"Invalid Username or Password");
                return $arr;
            }
        } catch(Excecption $e)
        {
            $arr=Array("ok"=>$e);
            return json_encode($arr);
        }

    }








    public function fblogin()
    {

        try
        {
            $users = User::all();
            foreach($users as $user)
            {
                if($user->email == Input::get('email'))
                {

                    $credentials = array('ok'=>'true','id'=>$user->id,'first_name' => $user->first_name,'last_name' => $user->last_name);
                    return json_encode($credentials);
                }
            }

            $credentials = array('ok'=>'invalid username and password');
            return json_encode($credentials);
        }

        catch(Exception $e)
        {
            $arr=Array("ok"=>$e);
            return json_encode($arr);
        }



    }



    public function tlogin()
    {
        $users = User::all();
        foreach($users as $user)
        {
            if($user->twitterid == Input::get('tid'))
            {

                $credentials = array('ok'=>'true','id'=>$user->id,'first_name' => $user->first_name,'last_name' => $user->last_name);
                return json_encode($credentials);
            }
        }
        $credentials = array('ok'=>'Invalid Credentials','id'=>null,'first_name' => null,'last_name' => null);
        return json_encode($credentials);

    }


    public function glogin()
    {
        $users = User::all();
        foreach($users as $user)
        {
            if($user->gid == Input::get('gid'))
            {

                $credentials = array('ok'=>'true','id'=>$user->id,'first_name' => $user->first_name,'last_name' => $user->last_name);
                return json_encode($credentials);
            }
        }
        $credentials = array('ok'=>'Invalid Credentials','id'=>null,'first_name' => null,'last_name' => null);
        return json_encode($credentials);

    }


    /*    public function getActionData()
        {

            $action=DB::table('actions')->orderBy('created_at','DESC')->take(6)->get();

            return json_encode($action);

        }
    */

    public function logout()
    {
        $user = User::find(Input::get('id'));

        if($user->fbid!=null)
        {
            $fauth = new Hybrid_Auth(app_path(). '/config/fb_auth.php');
            $fauth->logoutAllProviders();
        }
        if($user->twitterid!=null)
        {
            $tauth = new Hybrid_Auth(app_path(). '/config/tw_auth.php');
            $tauth->logoutAllProviders();
        }
        if($user->gid!=null)
        {
            $gauth = new Hybrid_Auth(app_path(). '/config/Google_auth.php');
            $gauth->logoutAllProviders();
        }


        return 'success';

    }


    public static function getContent($id,$type)
    {
        if($type == 'blogbook')
        {
            $content = BlogBook::find($id);

        }
        else if($type == 'article')
        {
            $content = Article::find($id);
        }
        else if($type == 'collaboration')
        {
            $content = Collaboration::find($id);

        }

        else if($type == 'media')
        {
            $content = Media::find($id);

        }
        else if($type == 'quiz')
        {
            $content = Quiz::find($id);

        }

        else if($type == 'event')
        {
            $content = BEvent::find($id);
        }

        else if($type == 'resource')
        {
            $content = Resource::find($id);
        }

        else if($type == 'poll')
        {
            $content = Poll::find($id);
        }

        else if($type == 'recco')
        {
            $content = Recco::find($id);
        }

        else if($type == 'diary')
        {
            $content = Diary::find($id);
        }

        else if($type == 'notification')
        {
            $content = Notification::find($id);
        }

        return $content;
    }

    public static function getFriends($userid)
    {

        $friends1 = DB::table('friends')->where('friend1', '=', $userid)->where('status', '=', 'accepted')->lists('friend2');
        $friends2 = DB::table('friends')->where('friend2', '=', $userid)->where('status', '=', 'accepted')->lists('friend1');
        $friends = array_merge($friends1, $friends2);
        $users = new \Illuminate\Database\Eloquent\Collection();

        foreach ($friends as $f)
        {
            $users->add(User::find($f));

        }

        return $users;

    }

    public function addFriend()
    {
        $userid = Input::get('userid');
        $authid = Input::get('authid');
        $date=new DateTime();
        if (Input::get('reason') != '')
            DB::table('friends')->insert(array('friend1' => $authid, 'friend2' => $userid,'status'=>'sent','reason'=>Input::get('reason'),'created_at'=>$date,'updated_at'=>$date));
        else
            DB::table('friends')->insert(array('friend1' => $authid, 'friend2' => $userid,'status'=>'sent','created_at'=>$date,'updated_at'=>$date));

        //$rid=DB::table('friends')->where('friend1','=',Auth::user()->id)->where('friend2','=',$id)->lists('id');
       // $rid = DB::table('friends')->where('friend1', Auth::user()->id)->where('friend2',$id)->pluck('id');

        AjaxController::insertToNotification($userid,$authid,"friendR"," sent you a Friend Request ",'http://www.b2.com/user/'.User::find($authid)->username);

        FriendsController::$user = User::find($userid);

        if (FriendsController::$user->settings->notifications)
        {
            Mail::send('mailers', array('user'=>$authid, 'receiver'=>FriendsController::$user,'page'=>'newFriendRequestMailer'), function($message)
            {
                $message->to(FriendsController::$user->email,FriendsController::$user->first_name)->subject('New Friend Request!');
            });
        }
    }
    public function acceptFriend()
    {
       try{
        $userid = Input::get('userid');
        $authid = Input::get('authid');
        
        $authuser = User::find($authid);
       $friends1=DB::table('friends')->where('friend1','=',$userid)->where('friend2','=',$authid)->where('status','=','accepted')->lists('friend2');
       $friends2=DB::table('friends')->where('friend2','=',$userid)->where('friend1','=',$authid)->where('status','=','accepted')->lists('friend1');
       $friends = array_merge($friends1, $friends2);
       if(count($friends)>0)
       {
           $friend = DB::table('friends')->where('friend1','=',$userid)->where('friend2','=',$authid)->first();
           $friend2 = DB::table('friends')->where('friend2','=',$userid)->where('friend1','=',$authid)->first();

           if ($friend)
           {
               //$nid = $friend = DB::table('friends')->where('friend1','=',$id)->where('friend2','=',Auth::user()->id)->pluck('id');
               DB::table('friends')->where('friend1','=',$userid)->where('friend2','=',$authid)->delete();
           }
           else if ($friend2)
           {
               //$nid = $friend2 = DB::table('friends')->where('friend2','=',$id)->where('friend1','=',Auth::user()->id)->pluck('id');
               DB::table('friends')->where('friend2','=',$userid)->where('friend1','=',$authid)->delete();
           }
           return "deleted";
       }
           else
           {
        $date=new DateTime();
        DB::table('friends')->where('friend1','=',$userid)->where('friend2','=',$authid)->update(array('status' => 'accepted','updated_at'=>$date));

        /*Action::postAction('F new',$id,Auth::user()->id,null);*/

        $authuser->profile->ifc += $authuser->settings->friendcost;
        $authuser->profile->save();
        $user = User::find($userid);
        $user->profile->ifc -= $authuser->settings->friendcost;
        $user->profile->save();

        DB::table('notification')->where('userid','=',$authuser->id)->where('cuserid','=',$userid)->where('type','=','friendR')->update(array('type' =>'friendRR'));

        TransactionController::insertToManager($authuser->id,"+".$authuser->settings->friendcost,"Accepted friend request by",'http://www.b2.com/user/'.$user->username,$user->first_name.' '.$user->last_name,"content");

        TransactionController::insertToManager($user->id,"-".$authuser->settings->friendcost,"Friend request accepted by",'http://www.b2.com/user/'.$authuser->username,$authuser->first_name.' '.$authuser->last_name,"profile");

        AjaxController::insertToNotification($userid,$authuser->id,"friendRR","Accepted your Friend Request ",'http://www.b2.com/user/'.$authuser->username);

        FriendsController::$user = $user;

        if (FriendsController::$user->settings->notifications)
        {
            Mail::send('mailers', array('user'=>$authuser, 'receiver'=>FriendsController::$user,'page'=>'friendRequestAcceptedMailer'), function($message)
            {
                $message->to(FriendsController::$user->email,FriendsController::$user->first_name)->subject('Friend Request Accepted!');
            });
        }
           return "added successfully";
       }
       }
           catch(Exception $e)
           {
               return $e."";
           }
}






}
