<?php

class MobileController extends \BaseController
{




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