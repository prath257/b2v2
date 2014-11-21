<?php

class MobileController extends \BaseController
{
    public function getid()
    {
        try

        {
            if(Auth::check())
                $name=Auth::user()->id;
            else
                return "nothing";

        }
        catch(Exception $e)
        {
            return $e;

        }
        return $name;


    }


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
                    // $user->isOnline = true;
                    $user->save();

                    $arr=Array("ok"=>"true","id"=>Auth::user()->id,"first_name"=>Auth::user()->first_name,"last_name"=>Auth::user()->last_name);

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



    public function create()
    {
        try
        {

            $user=Input::get('userid');
            $title=Input::get('title');
            $content=Input::get('content');

            $mobile =new Mobile();
            $mobile->userid=$user;
            $mobile->title=$title;
            $mobile->text=$content;
            $mobile->save();

            return "true";
        }
        catch(Exception $e)
        {
            return $e;
        }

    }



    public function delete()
    {

        try
        {
            $id=Input::get('id');

            $content=Mobile::find($id);

//    $content =DB::table('mobilea')->where('id','=',Input::get('id'))->first();

            $content->delete();

            return "true";

        }
        catch(Exception $e)
        {
            return $e;
        }

    }

    public function getAll()
    {
        $titles=DB::table('mobilea')->get();

        return $titles;
    }


    public function getContent()
    {
        $content =DB::table('mobilea')->where('id','=',Input::get('id'))->first();

        return json_encode($content);

    }


    public function fblogin()
    {

        try
        {
            $users = User::all();
            foreach($users as $user)
            {
                if($user->fbid == Input::get('fbid'))
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
            if($user->gid == Input::get('tid'))
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

        if ($user)
        {
            $user->isOnline = false;
            $user->save();
        }
        return 'success';

    }

    public function getActionData()
    {

        try
        {
            $actions=DB::table('actions')->orderBy('created_at','DESC')->take(30)->get();

            $content = new \Illuminate\Database\Eloquent\Collection();
            $author = new \Illuminate\Database\Eloquent\Collection();
            $pic = new \Illuminate\Database\Eloquent\Collection();

            foreach($actions as $action)
            {
                if($action->type == 'A new')
                    $content->add(DB::table('articles')->where('id','=',$action->contentid)->first());

                elseif($action->type == 'BB new')
                    $content->add(DB::table('blogbooks')->where('id','=',$action->contentid)->first());

                elseif($action->type == 'BB new chapter')
                    $content->add( DB::table('blogbooks')->where('id','=',$action->contentid)->first());

                elseif($action->type == 'E new')
                    $content->add( DB::table('events')->where('id','=',$action->contentid)->first());

                elseif($action->type == 'M new')
                    $content->add( DB::table('media')->where('id','=',$action->contentid)->first());

                elseif($action->type == 'R new')
                    $content->add( DB::table('resources')->where('id','=',$action->contentid)->first());

                elseif($action->type == 'C new'||$action->type=='C req'||$action->type=='C new chapter')
                    $content->add( DB::table('collaborations')->where('id','=',$action->contentid)->first());

                elseif($action->type == 'Diary new')
                    $content->add(DB::table('diary')->where('userid','=',$action->user1id)->first());

                elseif($action->type == 'Recco new')
                    $content->add(DB::table('recco')->where('id','=',$action->contentid)->first());

                elseif($action->type == 'P new')
                    $content->add(DB::table('polls')->where('id','=',$action->contentid)->first());

                elseif($action->type == 'Q new')
                    $content->add(DB::table('quiz')->where('id','=',$action->contentid)->first());

                elseif($action->type == 'Q score')
                    $content->add(DB::table('quiz')->where('id','=',$action->contentid)->first());

                $author->add( DB::table('users')->where('id','=',$action->user1id)->first());
                $pic->add (User::find($action->user1id)->profile->profilePic);

            }

            $result = array('ok'=>'true','pic'=>$pic->toJson(),'content'=>$content->toJson(),'action'=>$actions,'author'=>$author->toJson());

            return json_encode($result);

        }
        catch(Exception $e)
        {
            $result=array('ok'=>$e);
            return json_encode($result);
        }

    }
    public function showProfile()
    {

        try
        {

            // $user=DB::table('users')->where('id','=',Input::get('id'))->first();

            $user = User::find(Input::get('id'));

            $data = array('ok'=>'true','profile_pic'=>$user->profile->profilePic,
                'first_name'=>$user->first_name,'last_name'=>$user->last_name,
                'cover_pic'=>$user->profile->coverPic);

            return json_encode($data);

        }
        catch(Exception $e)
        {
            $data = array('ok'=>$e);
            return json_encode($data);
        }


    }



    public function getIdFromUserName()
    {


        $row=DB::table('users')->where('username','=',Input::get('name'))->first();


        return $row->id."";

    }




    public function getNotification()
    {


        try
        {

            $unreadNotifications = DB::table('notification')->where('userid','=',Input::get('id'))->where('checked','=',false)->orderBy('created_at','DESC')->get();

            if (count($unreadNotifications) > 10)
                $sendNotifications = $unreadNotifications;
            else
                $sendNotifications = DB::table('notification')->where('userid','=',Input::get('id'))->orderBy('created_at','DESC')->take(10)->get();

            DB::table('notification')->where('userid','=',Input::get('id'))->where('checked','=',false)->update(array('checked' =>true));

            $picUrl = new \Illuminate\Database\Eloquent\Collection();
            $name = new \Illuminate\Database\Eloquent\Collection();


            foreach($sendNotifications as $notification)
            {
                $user=User::find($notification->cuserid);
                // $user=DB::table('users')->where('id','=',$notification->cuserid);
                $picUrl->add ($user->profile->profilePic);
                $name->add($user->first_name." ".$user->last_name);

            }


            if(count($sendNotifications)!=0)
            {
                $data = array('ok'=>'true',
                    'number'=>count($sendNotifications),
                    'data'=>json_encode($sendNotifications),
                    'pic_url'=>$picUrl->toJson(),
                    'names'=>$name->toJson()
                );

                return json_encode($data);
            }
            else
            {
                $data = array('number'=>0,'ok'=>'true');
                return json_encode($data);
            }
        }
        catch(Exception $e)
        {
            $data = array('ok'=>$e);
            return json_encode($data);
        }

    }


    public function previewModel()
    {

        try {
            $type = Input::get('type');
            $contentid = Input::get('contentid');
            if($type == 'blogbook')
            {
                $content = BlogBook::find($contentid);
                $readers = $content->getReaders();
                $author = User::find($content->userid);
            }
            else if($type == 'article')
            {
                $content = Article::find($contentid);
                $readers = $content->getReaders();
                $author = User::find($content->userid);
            }
            else if($type == 'collaboration')
            {
                $content = Collaboration::find($contentid);
                $readers = $content->getReaders();
                $author = User::find($content->userid);
            }
            else if($type == 'media')
            {
                $content = Media::find($contentid);
                $readers = $content->getViewers();
                $author = User::find($content->userid);
            }
            else if($type == 'quiz')
            {
                $content = Quiz::find($contentid);
                $author = User::find($content->ownerid);
            }



            if($type != 'media')
                $data = array('ok'=>'true','title' => $content->title, 'desc' => $content->description,'ifc'=>$content->ifc,'no_readers'=>count($readers),'author_name'=>$author->first_name." ".$author->last_name,'content_pic_url'=>$content->cover,'author_id'=>$author->id,'author_pic_url'=>$author->profile->profilePic);


            //  $data = array('ok'=>'true','title' => $content->title, 'desc' => $content->description,'ifc'=>$content->ifc,'no_readers'=>count($readers),'author_name'=>$author->first_name." ".$author->last_name,'author_id'=>$author->id,'author_pic_url'=>$author->profile->profilePic,'content_pic_url'=>$content->cover);

            else
                $data = array('ok'=>'true','title' => $content->title,'ifc'=>$content->ifc,'no_readers'=>count($readers),'author_name'=>$author->first_name." ".$author->last_name,'content_pic_url'=>$content->cover);



            //      $data = array('ok'=>'true','title' => $content->title,'ifc'=>$content->ifc,'no_readers'=>count($readers),'author_name'=>$author->first_name." ".$author->last_name,'author_id'=>$author->id,'author_pic_url'=>$author->profile->profilePic,'content_pic_url'=>$content->cover);

            return json_encode($data);

        }
        catch(Exception $e)
        {
            return json_encode(array('ok'=>$e));
        }





    }

    public function getFriendList()
    {
        $userid =Input::get('id');
        $friends1 = DB::table('friends')->where('friend1', '=', $userid)->where('status', '=', 'accepted')->lists('friend2');
        $friends2 = DB::table('friends')->where('friend2', '=', $userid)->where('status', '=', 'accepted')->lists('friend1');
        $friends = array_merge($friends1, $friends2);
        $users1 = new \Illuminate\Database\Eloquent\Collection();

        foreach ($friends as $f) {
            $users1->add(User::find($f));
        }

        $users=Manager::where('userid','=',Auth::user()->id)->get();

        $data = array('ifc'=>User::find($userid)->profile->ifc,'friends'=> $users1->toJson(),'entries',$users);

        return json_encode($data);
    }



    public function transferIfc()
    {

        $ifc = Input::get('ifc');
        $userid = Input::get('id');
        $receiverid = Input::get('userid');
        $receiverprofile = Profile::where('userid','=',$receiverid)->first();
        $senderprofile = Profile::where('userid','=',$userid)->first();

        $receiverprofile->ifc+=$ifc;
        $receiverprofile->save();
        $senderprofile->ifc-=$ifc;
        $senderprofile->save();

        TransactionController::insertToManager($userid,"-".$ifc,"IFCs transferred to","http://b2.com/user/".User::find(Input::get('userid'))->username,User::find(Input::get('userid'))->first_name." ".User::find(Input::get('userid'))->last_name,"profile");
        TransactionController::insertToManager($receiverid,"+".$ifc,"IFCs transferred by","http://b2.com/user/".User::find($userid)->username,User::find($userid)->first_name." ".User::find($userid)->last_name,"profile");

        AjaxController::insertToNotification(Input::get('userid'),Auth::user()->id,"transfered"," Transfered ".Input::get('ifc')." ifc to your account",'http://b2.com/user/'.Auth::user()->username);

        MobileController::$user = User::find($receiverid);
        $sender = User::find($userid);

        Mail::send('mailers', array('user'=>$sender, 'receiver'=>MobileController::$user, 'ifc'=>Input::get('ifc'),'page'=>'newTransferMailer'), function($message)
        {
            $message->to(MobileController::$user->first_name)->subject('IFCs credited!');
        });
        return "Success";

    }

    public function getIfcManager()
    {
        $userid =Input::get('id');
        $friends1 = DB::table('friends')->where('friend1', '=', $userid)->where('status', '=', 'accepted')->lists('friend2');
        $friends2 = DB::table('friends')->where('friend2', '=', $userid)->where('status', '=', 'accepted')->lists('friend1');
        $friends = array_merge($friends1, $friends2);
        $users1 = new \Illuminate\Database\Eloquent\Collection();

        foreach ($friends as $f) {
            $users1->add(User::find($f));
        }

        $users=Manager::where('userid','=',Auth::user()->id)->get();

        $data = array('ifc'=>User::find($userid)->profile->ifc,'friends'=> $users1->toJson(),'entries',$users);

        return json_encode($data);
    }

    public function previewChecking()
    {
        $contentid = Input::get('contentid');
        $id = Input::get('authid');  //same as Auth::user()->id
        $type  = Input::get('type'); //blogbook,article etc
        $content = Mobile::getContent($contentid,$type);
        $user = User::find($id);
        $cost = $content->ifc;

        $newuser = 'true';
        if($type=='quiz')
            $authorid = $content->ownerid;

        else
            $authorid = $content->userid;
        $author = User::find($authorid);

        if($type!='quiz')
        {
            if($id==$authorid)
            {
                $newuser = 'false';
            }
            else
            {
                if($type == 'blogbook')
                {
                    $readers=DB::table('bookreaders')->where('blog_book_id','=',$content->id)->where('user_id','=',$id)->get();

                }
                else if($type == 'article')
                {
                    $readers=DB::table('articlereaders')->where('article_id','=',$content->id)->where('user_id','=',$id)->get();
                }
                else if($type == 'collaboration')
                {
                    $readers=DB::table('collaborationreaders')->where('collaboration_id','=',$content->id)->where('user_id','=',$id)->get();

                }

                else if($type == 'media')
                {
                    $readers=DB::table('mediaviewers')->where('media_id','=',$content->id)->where('user_id','=',$id)->get();

                }

                if(count($readers)>0)
                    $newuser = 'false';
            }
            if($newuser=='false')
                $data = array('ok'=>'free','cost'=>$cost,'userifc'=>$user->profile->ifc);
            else
            {
                $subscribers = DB::table('subscriptions')->where('subscribed_to_id','=',$authorid)->where('subscriber_id','=',$id)->get();
                if(count($subscribers)>0)
                {
                    if($author->settings->discountforfollowers > 0)
                    {
                        $discount = ($cost*$author->settings->discountforfollowers)/100;
                        $cost = $cost - $discount;
                    }
                }

                if($user->profile->ifc>$cost)
                    $data = array('ok'=>'true','cost'=>$cost,'userifc'=>$user->profile->ifc);
                else
                    $data = array('ok'=>'Sorry! You don"t have enough IFCs','cost'=>$cost,'userifc'=>$user->profile->ifc);
            }

        }
        else                    //if type is quiz
        {
            if($authorid == $id)
                $data = array('ok'=>'You can"t take the quiz because you are the owner!.','cost'=>$cost,'userifc'=>$user->profile->ifc);
            else
            {
                $takers = DB::table('quiztakers')->where('quiz_id','=',$contentid)->where('user_id','=',$id)->get();
                if(count($takers) > 0)
                    $data = array('ok'=>'Sorry!.Looks like you already took this Quiz','cost'=>$cost,'userifc'=>$user->profile->ifc);
                else
                {
                    $data = array('ok'=>'true','cost'=>$cost,'userifc'=>$user->profile->ifc);
                }
            }
        }
        return json_encode($data);
    }















}