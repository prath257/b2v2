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
            elseif($type == 'article')
            {
                $content = Article::find($contentid);
                $readers = DB::table('articlereaders')->where('article_id','=',$contentid)->get();
                $author = User::find($content->userid);
            }
            elseif($type == 'collaboration')
            {
                $content = Collaboration::find($contentid);
                $readers = DB::table('collaborationreaders')->where('collaboration_id','=',$contentid)->get();
                $author = User::find($content->userid);
            }
            elseif($type == 'media')
            {
                $content = Media::find($contentid);
                $readers = DB::table('mediaviewers')->where('media_id','=',$contentid)->get();
                $author = User::find($content->userid);
            }
            elseif($type == 'quiz')
            {
                $content = Quiz::find($contentid);
                $readers = DB::table('quiztakers')->where('quiz_id','=',$contentid)->get();
                $author = User::find($content->ownerid);
            }

            elseif($type == 'resource')
            {
                $content = Resource::find($contentid);

                $author = User::find($content->userid);
            }





            if($type=='resource')
            {
                $data = array('ok'=>'true','title' => $content->title, 'desc' => $content->description,'ifc'=>$content->ifc,'no_readers'=>$content->users,'author_name'=>$author->first_name." ".$author->last_name,'author_id'=>$author->id,'author_pic_url'=>$author->profile->profilePic);
            }

            elseif($type != 'media')
                $data = array('ok'=>'true','title' => $content->title, 'desc' => $content->description,'ifc'=>$content->ifc,'no_readers'=>count($readers),'author_name'=>$author->first_name." ".$author->last_name,'content_pic_url'=>$content->cover,'author_id'=>$author->id,'author_pic_url'=>$author->profile->profilePic);

            else
                $data = array('ok'=>'true','title' => $content->title,'ifc'=>$content->ifc,'no_readers'=>count($readers),'author_name'=>$author->first_name." ".$author->last_name,'content_pic_url'=>$content->cover,'author_id'=>$author->id,'author_pic_url'=>$author->profile->profilePic);



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

        TransactionController::insertToManager($userid,"-".$ifc,"IFCs transferred to","http://www.bbarters.com/user/".User::find(Input::get('userid'))->username,User::find(Input::get('userid'))->first_name." ".User::find(Input::get('userid'))->last_name,"profile");
        TransactionController::insertToManager($receiverid,"+".$ifc,"IFCs transferred by","http://www.bbarters.com/user/".User::find($userid)->username,User::find($userid)->first_name." ".User::find($userid)->last_name,"profile");

        AjaxController::insertToNotification(Input::get('userid'),Auth::user()->id,"transfered"," Transfered ".Input::get('ifc')." ifc to your account",'http://www.bbarters.com/user/'.Auth::user()->username);

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
        try
        {
            $contentid = Input::get('contentid');
            $id = Input::get('authid');  //same as Auth::user()->id
            $type  = Input::get('type'); //blogbook,article etc
            $content = MobileAuthController::getContent($contentid,$type);
           //$content = Resource::find($contentid);
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
                    $readers = null;
                    if($type == 'blogbook')
                    {
                        $readers=DB::table('bookreaders')->where('blog_book_id','=',$content->id)->where('user_id','=',$id)->get();

                    }
                    elseif($type == 'article')
                    {
                        $readers=DB::table('articlereaders')->where('article_id','=',$content->id)->where('user_id','=',$id)->get();
                    }
                    elseif($type == 'collaboration')
                    {
                        $readers=DB::table('collaborationreaders')->where('collaboration_id','=',$content->id)->where('user_id','=',$id)->get();

                    }

                    elseif($type == 'media')
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
                    $friends1=DB::table('friends')->where('friend1','=',$id)->where('friend2','=',$authorid)->where('status','=','accepted')->lists('friend2');
                    $friends2=DB::table('friends')->where('friend2','=',$id)->where('friend1','=',$authorid)->where('status','=','accepted')->lists('friend1');
                    $friends = array_merge($friends1, $friends2);
                    if(count($friends)>0)
                    {
                        if($author->settings->freeforfriends)
                        {
                            $cost = 0;
                        }
                    }
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
                    }

                    if($user->profile->ifc>=$cost)
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

        catch(Exception $e)
        {
            $data = array('ok'=>$e);
            return json_encode($data);
        }
    }

    public function ifcReduce()
    {
        try{
            $contentid = Input::get('contentid');
            $id = Input::get('authid');
            $authorid = Input::get('authorid');
            $type = Input::get('type');
            $cost = (integer)Input::get('cost');

            $content = MobileAuthController::getContent($contentid,$type);
            $user = User::find($id);
            $author = User::find($authorid);

            $user->profile->ifc -= $cost;
            $user->profile->save();
            $author->profile->ifc += $cost;
            $author->profile->save();
            switch($type)
            {
                case 'article' : $user->readArticles()->attach($contentid);
                    $content->users ++;
                    $content->save();
                    TransactionController::insertToManager($id,"-".$cost,"Bought article:",'http://www.bbarters.com/articlePreview/'.$content->id,$content->title,"content");

                    TransactionController::insertToManager($authorid,"+".$cost,"Sold article '".$content->title."' to",'http://www.bbarters.com/user/'.$user->username,$user->first_name." ".$user->last_name,"profile");

                    AjaxController::insertToNotification($authorid,$id,"purchased","purchased your article ".$content->title,'http://www.bbarters.com/articlePreview/'.$contentid);

                    break;
                case 'blogbook' : $user->readBooks()->attach($contentid);
                    $content->users ++;
                    $content->save();
                    TransactionController::insertToManager($id,"-".$cost,"Bought blogBook:",'http://www.bbarters.com/blogBookPreview/'.$content->id,$content->title,"content");

                    TransactionController::insertToManager($authorid,"+".$cost,"Sold the Blogbook '".$content->title."' to",'http://www.bbarters.com/user/'.$user->username,$user->first_name.' '.$user->last_name,"profile");

                    AjaxController::insertToNotification($authorid,$id,"purchased","purchased your blogBook ".$content->title,'http://www.bbarters.com/blogBookPreview/'.$contentid);

                    break;

                case 'media' : $user->viewedMedia()->attach($contentid);
                    AjaxController::insertToNotification($authorid,$id,"purchased","purchased your media ".$content->title,'http://www.bbarters.com/mediaPreview/'.$contentid);

                    TransactionController::insertToManager($id,"-".$cost,"Bought media",'http://www.bbarters.com/mediaPreview/'.$content->id,$content->title,"content");
                    TransactionController::insertToManager($authorid,"+".$cost,"Sold media '".$content->title."' to",'http://www.bbarters.com/user/'.$user->username, $user->first_name.' '.$user->last_name,"profile");
                    $content->users ++;
                    $content->save();

                    break;

                case 'resource' : $content->users ++;
                    $content->save();

                    AjaxController::insertToNotification($authorid,Auth::user()->id,"purchased","purchased your resource ".$content->title,'http://www.bbarters.com/resource/'.$contentid);

                    TransactionController::insertToManager($id,"-".$cost,"Purchased resource",'http://www.bbarters.com/resource/'.$content->id,$content->title,"content");
                    TransactionController::insertToManager($authorid,"+".$cost,"Resource '".$content->title."' purchased by",'http://www.bbarters.com/user/'.$user->username,$user->first_name.' '.$user->last_name,"profile");

                    break;

                case 'collaboration' :
                    $contributors =$content->getContributors()->get();
                    $author->profile->ifc -= $cost;  //to cancel out the effect of common addition of ifc to author done above
                    $author->profile->save();
                    $noc = count($contributors) + 1;
                    foreach($contributors as $contributor)
                    {
                        $contributor->profile->ifc += $cost/$noc;
                        $contributor->profile->save();

                        TransactionController::insertToManager($contributor->id,"+".$cost/$noc,"Sold the collaboration '".$content->title."' to",'http://www.bbarters.com/user/'.$user->username,$user->first_name.' '.$user->last_name,"profile");
                    }
                    $author->profile->ifc += $cost/$noc;
                    $author->profile->save();

                    $user->readCollaborations()->attach($contentid);
                    $content->users ++;
                    $content->save();

                    TransactionController::insertToManager($id,"-".$cost,"Bought collaboration:",'http://www.bbarters.com/collaborationPreview/'.$contentid,$content->title,"content");

                    TransactionController::insertToManager($authorid,"+".$cost/$noc,"Sold the collaboration '".$content->title."' to",'http://www.bbarters.com/user/'.$user->username,$user->first_name.' '.$user->last_name,"profile");

                    AjaxController::insertToNotification($authorid,$user->id,"purchased","purchased your collaboration ".$content->title,'http://www.bbarters.com/collaborationPreview/'.$contentid);

                    break;

                default: return "Wrong type of content!!!";

            }
            return "success";

        }

        catch(Exception $e)
        {
            return $e."";

        }

    }

    public function getMyReadings()
    {

        try {
            $user =User::find(Input::get('id'));
            $articles = $user->readArticles;
            $bb = $user->readBooks;
            $collab = $user->readCollaborations;

            //$readings = array_merge($articles,$bb,$collab);
            $reads = new \Illuminate\Database\Eloquent\Collection();
            $title = new \Illuminate\Database\Eloquent\Collection();
            $by = new \Illuminate\Database\Eloquent\Collection();
            $category = new \Illuminate\Database\Eloquent\Collection();
            $pic = new \Illuminate\Database\Eloquent\Collection();
            foreach($articles as $reading)
            {
                $reads->add($reading->users);
                $title->add($reading->title);
                $by->add(User::find($reading->userid));
                $category->add($reading->category);
                $pic->add($reading->cover);

            }
            foreach($bb as $reading)
            {
                $reads->add($reading->users);
                $title->add($reading->title);
                $by->add(User::find($reading->userid));
                $category->add($reading->category);
                $pic->add($reading->cover);

            }
            foreach($collab as $reading)
            {
                $reads->add($reading->users);
                $title->add($reading->title);
                $by->add(User::find($reading->userid));
                $category->add($reading->category);
                $pic->add($reading->cover);

            }

            $data = array('ok'=>'true','reads'=> $reads->toJson(),'title'=>$title->toJson(),'by'=>$by->toJson(),'category'=>$category->toJson(),'pic'=>$pic->toJson());

            return json_encode($data);
        }

        catch(Exception $e)
        {

            return $e."";
        }


    }

public function displayContent()
{
    $type = Input::get('type');
    $content = MobileAuthController::getContent(Input::get('contentid'),$type);

    switch($type)
    {
        case 'article':

    }
}

    public function getArticle($articleId)
    {
        $article = Article::find($articleId);
        return View::make('readArticle')->with('article',$article)->with('newUser','false');
    }







}