<?php

class CollaborationsController extends \BaseController
{
    public static $count = null;
    public static $collaborationAdmin = null;
    public static $email=null;

    public function getDashboard()
    {
        $userid=Auth::user()->id;
        $friends1=DB::table('friends')->where('friend1','=',$userid)->where('status','=','accepted')->lists('friend2');
        $friends2=DB::table('friends')->where('friend2','=',$userid)->where('status','=','accepted')->lists('friend1');
        $friends = array_merge($friends1, $friends2);

        $users=new \Illuminate\Database\Eloquent\Collection();
        foreach($friends as $f)
        {
            $users->add(User::find($f));
        }
        $sendFriends = $users->sortBy('first_name');
        $categories = Auth::user()->interestedIn()->get();

        $data = array('categories'=>$categories,'friends'=>$sendFriends);
        return View::make('collaborationsDashboard',$data);
    }

    public function postNewCollaboration()
    {
        $collaboration = new Collaboration();
        $collaboration->title = Input::get('title');
        $collaboration->description = Input::get('shortDescription');
        $collaboration->category = Input::get('category');
        $collaboration->ifc = Input::get('ifc');
        $collaboration->userid = Auth::user()->id;
        $collaboration->save();

        Action::postAction('C new',Auth::user()->id,null,$collaboration->id);
        $subscribers = DB::table('subscriptions')->where('subscribed_to_id','=',Auth::user()->id)->lists('subscriber_id');
        foreach($subscribers as $s)
        {
            CollaborationsController::$email=User::find($s)->email;
            Mail::send('mailers',array('user' => User::find($s),'content' => $collaboration,'type' => 'C new','writer' => Auth::user(),'page'=>'readerMailer'),function($message)
            {
                $message->to(CollaborationsController::$email)->subject('New Collaboration');
            });
        }

        $cover = Input::file('uploadCollabCover');
        if ($cover != null)
        {
            $directory = File::makeDirectory('Users/'.Auth::user()->username."/Collaborations/".$collaboration->id);
            if ($directory)
            {
                $coverDirectory = File::makeDirectory('Users/'.Auth::user()->username."/Collaborations/".$collaboration->id."/Cover");
            }
            $random_name = str_random(8);
            $destinationPath = "Users/".Auth::user()->username."/Collaborations/".$collaboration->id."/Cover/";
            $extension = $cover->getClientOriginalExtension();
            $filename=$random_name.'.'.$extension;
            Input::file('uploadCollabCover')->move($destinationPath, $filename);
            $collaboration->cover = $destinationPath.$filename;
            $collaboration->save();
        }


        return Redirect::route('collaborationNewChapter',$collaboration->id);
    }

    public function getNewChapter($collaborationId)
    {
        $collaboration = Collaboration::find($collaborationId);
        $contributors = $collaboration->getContributors()->get();
        $send = $contributors->filter(function($contri)
        {
            if ($contri->id == Auth::user()->id) {
                return true;
            }
        });
        if ($collaboration->userid == Auth::user()->id || $send)
        {
            $medias=Auth::user()->getMedia()->orderBy('updated_at','DESC')->paginate(5);
            $resources=Auth::user()->getResources()->orderBy('updated_at','DESC')->paginate(5);
            return View::make('collaborationNewChapter')->with('collaboration',$collaboration)->with('medias',$medias)->with('resources',$resources);
        }
        else
            return "You've no access to this page";
    }

    public function postChapter()
    {
        if(Auth::check())
        {
        $cChapter = new CollaborationChapter();
        $cChapter->title = Input::get('title');
        $cChapter->text = Input::get('content');
        $cChapter->collaborationid = Input::get('collaborationid');
        $cChapter->userid = Auth::user()->id;
        $collaboration = Collaboration::find(Input::get('collaborationid'));
        if($collaboration->userid == Auth::user()->id)
        {
            Action::postAction('C new chapter',Auth::user()->id,null,$collaboration->id);
            $cChapter->approved=1;
        }
        $cChapter->save();

        $date = new DateTime();

        $collaboration = Collaboration::find(Input::get('collaborationid'));
        $collaboration->chapters += 1;
        $collaboration->updated_at = $date;
        $collaboration->save();
        CollaborationsController::$email=User::find($collaboration->userid)->email;
        $collaborator=User::find($collaboration->userid);
        if($collaboration->userid != Auth::user()->id)
        {
            Mail::send('mailers', array('collaborator'=>$collaborator,'chapter'=>$cChapter, 'collaboration' => $collaboration,'page'=>'approveContributionMailer'), function($message)
            {
                $message->to(CollaborationsController::$email)->subject('Approve Contribution');
            });
        }
        else
        {
            $readers=DB::table('collaborationreaders')->where('collaboration_id','=',$collaboration->id)->get();
            foreach($readers as $reader)
            {
                $user=User::find($reader->user_id);
                CollaborationsController::$email=$user->email;
                $data=array('user'=>$user,'content' => $collaboration,'type' => 'C','writer' => Auth::user());
                Mail::send('mailers',array('user'=>$user,'content' => $collaboration,'type' => 'C','writer' => Auth::user(),'page'=>'readerMailer') , function($message)
                {
                    $message->to(CollaborationsController::$email)->subject('New Chapter');
                });
            }
        }
        return "success";
    }
        else
            return 'wH@tS!nTheB0x';
    }
    public function getCollaboration($collaborationId)
    {
        $newUser=false;

        CollaborationsController::$count = 0;
        $collaboration = Collaboration::find($collaborationId);
        $book = $collaboration;
        $owner = User::find($collaboration->userid);
        $contributors = $collaboration->getContributors()->get();
        $send = $contributors->filter(function($contri)
        {
            if ($contri->id == Auth::user()->id) {
                CollaborationsController::$count ++;
                return true;
            }
        });

        $articles = Article::where('category','=',$book->category)->orderBy('users','DESC')->get();
        $blogBooks = BlogBook::where('category','=',$book->category)->orderBy('users','DESC')->get();
        $collaborations = Collaboration::where('category','=',$book->category)->orderBy('users','DESC')->get();


        $content = $articles->merge($blogBooks);
        $content = $content->merge($collaborations);

        $content = $content->sortByDesc('users')->take(3);

        if (count($content) < 3)
        {
            $articles = $owner->getArticles()->orderBy('users','DESC')->get();
            $blogBooks = $owner->getBlogBooks()->orderBy('users','DESC')->get();
            $collaborations = $owner->getOwnedCollaborations()->orderBy('users','DESC')->get();
            $contributions = $owner->getContributions()->orderBy('users','DESC')->get();

            $content = $content->merge($articles);
            $content = $content->merge($blogBooks);
            $content = $content->merge($collaborations);
            $content = $content->merge($contributions);

            $content = $content->sortByDesc('users')->take(3);

            if (count($content) < 3)
            {
                $ksj = User::where('username','=','ksjoshi88')->first();
                $articles = $ksj->getArticles()->orderBy('users','DESC')->get();
                $blogBooks = $ksj->getBlogBooks()->orderBy('users','DESC')->get();
                $collaborations = $ksj->getOwnedCollaborations()->orderBy('users','DESC')->get();
                $contributions = $ksj->getContributions()->orderBy('users','DESC')->get();

                $content = $content->merge($articles);
                $content = $content->merge($blogBooks);
                $content = $content->merge($collaborations);
                $content = $content->merge($contributions);

                $content = $content->sortByDesc('users')->take(3);
            }
        }

        if($collaboration->userid!=Auth::user()->id && CollaborationsController::$count==0)
        {

            if($collaboration->isReader()==false)
            {
                $ifc = $collaboration->ifc;

                if (Friend::isFriend($owner->id) && $owner->settings->freeforfriends)
                {
                    $chapters=$collaboration->getChapters()->where('approved','=',true)->get();
                    return View::make('collaboration')->with('collaboration',$collaboration)->with('chapters',$chapters)->with('contributors',$contributors)->with('newUser',$newUser)->with('content',$content);
                }

                if(Friend::isSubscriber($owner->id) && $owner->settings->discountforfollowers > 0)
                {
                    $discount = ($ifc*$owner->settings->discountforfollowers)/100;
                    $ifc = $ifc-$discount;
                }

                if (Auth::user()->profile->ifc >= $ifc)
                {
                    Auth::user()->profile->ifc-=$ifc;
                    Auth::user()->profile->save();

                    $numberOfContributors = count($contributors) + 1;
                    foreach ($contributors as $contributor)
                    {
                        $contributor->profile->ifc += $ifc/$numberOfContributors;
                        $contributor->profile->save();

                        TransactionController::insertToManager($contributor->id,"+".$ifc/$numberOfContributors,"Sold the collaboration '".$collaboration->title."' to",'http://b2.com/user/'.Auth::user()->username,Auth::user()->first_name.' '.Auth::user()->last_name,"profile");
                    }
                    $collaboration->getAdmin->profile->ifc += $ifc/$numberOfContributors;
                    $collaboration->getAdmin->profile->save();

                    Auth::user()->readCollaborations()->attach($collaboration->id);
                    $collaboration->users ++;
                    $collaboration->save();
                    $newUser=true;

                    TransactionController::insertToManager(Auth::user()->id,"-".$ifc,"Bought collaboration:",'http://b2.com/collaborationPreview/'.$collaboration->id,$collaboration->title,"content");

                    TransactionController::insertToManager($collaboration->getAdmin->id,"+".$ifc/$numberOfContributors,"Sold the collaboration '".$collaboration->title."' to",'http://b2.com/user/'.Auth::user()->username,Auth::user()->first_name.' '.Auth::user()->last_name,"profile");

                    AjaxController::insertToNotification($collaboration->getAdmin->id,Auth::user()->id,"purchased","purchased your collaboration ".$collaboration->title,'http://b2.com/collaborationPreview/'.$collaboration->id);
                }
                else
                {
                    return View::make('ifcDeficit')->with('contentIFC',$ifc)->with('userIFC',Auth::user()->profile->ifc);
                }
            }
        }
        $chapters=$collaboration->getChapters()->where('approved','=',true)->get();
        return View::make('collaboration')->with('collaboration',$collaboration)->with('chapters',$chapters)->with('contributors',$contributors)->with('newUser',$newUser)->with('content',$content);
    }

    public function deleteCollaboration()
    {
        if(Auth::check())
        {
        $collaboration = Collaboration::find(Input::get('id'));
        File::deleteDirectory('Users/'.Auth::user()->username.'/Collaborations/'.$collaboration->id);
        Action::delAction($collaboration->id);
        $collaboration->delete();
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function inviteContributor()
    {
        if(Auth::check())
        {
            $exist = DB::table('invite_contributors')->where('collaborationid',Input::get('colId'))->where('useremail',Input::get('email'))->first();

            if ($exist)
                return "Sorry, If you remember well, you already invited this one";
            else
            {
                $user = User::where('email','=',Input::get('email'))->first();

                if ($user == Auth::user())
                    return "Come on! We already thought about that while coding!";
                else
                {
                    $randomString = str_random(8);
                    DB::table('invite_contributors')->insert(array('collaborationid'=>Input::get('colId'), 'useremail'=>Input::get('email'), 'link'=>$randomString));
                    $invite = DB::table('invite_contributors')->where('collaborationid',Input::get('colId'))->where('useremail',Input::get('email'))->where('link',$randomString)->first();
                    if ($user)
                    {
                        if ($user->settings->notifications)
                        {
                            Mail::send('mailers', array('collaboration'=>Collaboration::find(Input::get('colId')), 'invite'=>$invite,'page'=>'collaborationInviteMailer'), function($message)
                            {
                                $message->to(Input::get('email'))->subject('New Collaboration Request');
                            });
                        }


                        AjaxController::insertToNotification($user->id,Auth::user()->id,"iContri",'invited you to contribute for \''.Collaboration::find(Input::get('colId'))->title.'\'','http://b2.com/collaborationPreview/'.Input::get('colId'));
                        AjaxController::insertNidInvite(Input::get('colId'),$user->id);


                        return "Success!";
                    }
                    else
                    {
                        Mail::send('mailers', array('collaboration'=>Collaboration::find(Input::get('colId')), 'invite'=>$invite,'page'=>'joinAndCollaborateMailer'), function($message)
                        {
                            $message->to(Input::get('email'))->subject(Auth::user()->first_name.' '.Auth::user()->last_name.' invited you to collaborate on BBarters');
                        });
                        return "Success!";
                    }
                }
            }
        }
        else
            return 'wH@tS!nTheB0x';
    }


    public function acceptCollaboration($link, $collaborationId)
    {
        $exists = DB::table('contributors')->where('user_id',Auth::user()->id)->where('collaboration_id',$collaborationId)->first();

        if ($exists)
            return "You're already a contributor to this collaboration!";
        else
        {
            $true = DB::table('invite_contributors')->where('collaborationid',$collaborationId)->where('useremail',Auth::user()->email)->where('link',$link)->first();
            if ($true)
            {
                if (Collaboration::find($collaborationId)->isReader()==false)
                    Auth::user()->readCollaborations()->attach($collaborationId);
                DB::table('contributors')->insert(array('collaboration_id'=>$collaborationId, 'user_id'=>Auth::user()->id));

                Action::postAction('C req',Auth::user()->id,null,$collaborationId);

                DB::table('notification')->where('userid',Auth::user()->id)->where('chid',$collaborationId)->where('type','iContri')->update(array('type'=>'iContry'));

                return Redirect::route('collaborationsDashboard');
            }
            else
                return "Invalid Request";
        }
    }

    public function deleteContribution()
    {
        if(Auth::check())
        {
        $id = Input::get('id');
        $contribution = Contributor::where('collaboration_id','=',$id)->where('user_id',Auth::user()->id)->first();
        $collaboration = $contribution->collaboration_id;
        $contribution->delete();
        DB::table('invite_contributors')->where('collaborationid',$collaboration)->where('useremail',Auth::user()->email)->delete();
        DB::table('requestcontribution')->where('collaboration_id',$collaboration)->where('user_id',Auth::user()->id)->delete();
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getCollaborationSettings($collaborationId)
    {
        $collaboration = Collaboration::find($collaborationId);
        if ($collaboration->userid == Auth::user()->id)
        {
            $categories=Auth::user()->interestedIn()->get();
            return View::make('collaborationSettings')->with('collaboration',$collaboration)->with('categories',$categories);
        }
        else
            return "Sorry, you don't have access to this page.";
    }

    public function postEditCollaboration()
    {
        if(Auth::check())
        {
        $collaboration = Collaboration::find(Input::get('id'));
        $collaboration->title = Input::get('title');
        $collaboration->description = Input::get('description');
        $collaboration->category = Input::get('category');
        $collaboration->ifc = Input::get('ifc');
        $collaboration->save();

        if ($cover = Input::file('cover'))
        {
            $random_name = str_random(8);
            $destinationPath = "Users/".Auth::user()->username."/Collaborations/".$collaboration->id."/Cover/";
            $extension = $cover->getClientOriginalExtension();
            $filename=$random_name.'.'.$extension;
            Input::file('cover')->move($destinationPath, $filename);
            $collaboration->cover = $destinationPath.$filename;
            $collaboration->save();
        }
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function deleteContributor()
    {
        $cid = Input::get('cid');
        $uid = Input::get('uid');
        $contributor = Contributor::where('collaboration_id','=',$cid)->where('user_id','=',$uid)->first();
        $contributor->delete();
        DB::table('invite_contributors')->where('collaborationid',$cid)->where('useremail',User::find($uid)->email)->delete();
        DB::table('requestcontribution')->where('collaboration_id',$cid)->where('user_id',$uid)->delete();
    }

    public function deleteCollaborationChapter()
    {
        if(Auth::check())
        {
        $chapter = CollaborationChapter::find(Input::get('id'));
        $collaboration = Collaboration::find($chapter->collaborationid);
        $chapter->delete();
        $collaboration->chapters -= 1;
        $collaboration->save();
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getEditCollaborationChapter($chapterId)
    {
        $chapter = CollaborationChapter::find($chapterId);
        $collaboration = $chapter->getCollaboration;

        if ($collaboration->userid == Auth::user()->id || $collaboration->isContributor())
            return View::make('editCollaborationChapter')->with('chapter',$chapter)->with('collaboration',$collaboration);
        else
            return View::make('errorPage')->with('error','you don\'t have enough privileges to edit this chapter.')->with('link','http://b2.com/home');
    }

    public function postUpdateCollaborationChapter()
    {
        if(Auth::check())
        {
        $chapter = CollaborationChapter::find(Input::get('id'));
        if (Auth::user()->id==Input::get('userid'))
        {
            $chapter->title = Input::get('title');
            $chapter->text = Input::get('content');
            $chapter->save();
        }
        else
        {
            $collaboration = $chapter->getCollaboration;
            $CollaborationChapterBuffer=new CollaborationChapterBuffer();
            $CollaborationChapterBuffer->text=Input::get('content');
            $CollaborationChapterBuffer->chapterId=Input::get('id');
            $CollaborationChapterBuffer->contributorId=Auth::user()->id;
            $CollaborationChapterBuffer->save();
            CollaborationsController::$email=User::find($collaboration->userid)->email;
            Mail::send('mailers', array('collaborator'=>User::find(Input::get('userid')),'chapter'=>$chapter, 'collaboration' => $collaboration,'buffer'=>$CollaborationChapterBuffer,'page'=>'approveEditContributionMailer'), function($message)
            {
                $message->to(CollaborationsController::$email)->subject('Approve Contribution');
            });
        }
        return "success";
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getEditCollaborationChapters($collaborationId)
    {
        $collaboration = Collaboration::find($collaborationId);
        return View::make('editCollaborationChapters')->with('collaboration',$collaboration);
    }

    public function getPreviewCollaboration($bid)
    {
        $collaboration = Collaboration::find($bid);
        $chapters = $collaboration->getChapters()->get();
        $contributors = $collaboration->getContributors()->get();
        return View::make('previewCollaboration')->with('collaboration',$collaboration)->with('chapters',$chapters)->with('contributors',$contributors);
    }

    public function getCollaborationPreview($cid)
    {
        $collaboration=Collaboration::find($cid);
        $chapters=$collaboration->getChapters()->get();
        $author = $collaboration->getAdmin->first_name.' '.$collaboration->getAdmin->last_name;
        return View::make('collaborationPreview')->with('collaboration',$collaboration)->with('chapters',$chapters)->with('author',$author);
    }

    public function request2contribute()
    {
        if(Auth::check())
        {
        $link = Str::random(8);
        DB::table('requestcontribution')->insert(
            array('collaboration_id' => Input::get('id'), 'reason' => Input::get('reason'), 'link' => $link, 'user_id' => Auth::user()->id)
        );

            $adminnn = User::find(Collaboration::find(Input::get('id'))->userid);
        CollaborationsController::$collaborationAdmin = $adminnn->email;
        if ($adminnn->settings->notifications)
        {
            Mail::send('mailers', array('collaborationId' => Input::get('id'), 'userId'=>Auth::user()->id, 'reason' => Input::get('reason'), 'link' => $link,'page'=>'newContributionRequestMailer'), function($message)
            {
                $message->to(CollaborationsController::$collaborationAdmin)->subject('New Contribution Request!');
            });
        }

            AjaxController::insertToNotification(Collaboration::find(Input::get('id'))->userid,Auth::user()->id,"reqContri",'requested you to start contributing for \''.Collaboration::find(Input::get('id'))->title.'\'','http://b2.com/user/'.Auth::user()->username);
            AjaxController::insertNidReqContri(Input::get('id'),Collaboration::find(Input::get('id'))->userid);

        return 'success';
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function acceptContributionRequest($link)
    {
        $request = DB::table('requestcontribution')->where('link',$link)->first();
        if (User::find(Collaboration::find($request->collaboration_id)->userid)->id == Auth::user()->id)
        {
            DB::table('contributors')->insert(
                array('collaboration_id' => $request->collaboration_id, 'user_id' => $request->user_id)
            );
            Action::postAction('C req',$request->user_id,null,$request->collaboration_id);

            DB::table('notification')->where('userid',Auth::user()->id)->where('chid',$request->collaboration_id)->where('type','reqContri')->update(array('type'=>'reqContry'));

            return Redirect::route('collaborationSettings',$request->collaboration_id);
        }
    }

    public function doneEditing()
    {
        if(Auth::check())
        {
        $chapter = CollaborationChapter::find(Input::get('id'));
        $chapter->beingEdited = false;
        $chapter->save();
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getCollaborationContent()
    {
        if(Auth::check())
        {
        $cid=intval(Input::get('id'));
        if($cid==-1)
        {
             $collabId=intval(Input::get('colid'));
             $collaboration = Collaboration::find($collabId);
             $contributors = $collaboration->getContributors()->get();
             return View::make('collabFront')->with('collaboration',$collaboration)->with('contributors',$contributors);
        }
        else
        {
            $chapter=CollaborationChapter::find(Input::get('id'));
            if($chapter==null)
                return 'wH@tS!nTheB0x';
            else
                return  $chapter->text;
        }
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getCollabChapterList()
    {
        if(Auth::check())
        {
        $chapterNos=array();
        $CollabId=intval(Input::get('cid'));
        $Collab = Collaboration::find($CollabId);
        $chapters=$Collab->getChapters()->where('approved','=',true)->get();
        $i=0;
        foreach($chapters as $ch)
        {
            $chapterNos[$i]=$ch->id;
            $i++;
        }
        return $chapterNos;
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function contributionApprove($id)
    {

        $contribution = CollaborationChapter::find($id);
        if (count($contribution) > 0 && $contribution->approved == 0)
        {
            $collaboration=Collaboration::find($contribution->collaborationid);
            /*$collid=CollaborationsChapter::find($id)->collaborationid;*/
            if (Auth::user()->id == $collaboration->userid)
                return View::make('approveContribution')->with('contribution',$contribution)->with('collaboration',$collaboration);
        }
        else
            return 'You have already submitted your verdict for this chapter.';
    }

    public function approveVerdict()
    {
        if(Auth::check())
        {
        $chapter=CollaborationChapter::find(Input::get('id'));
        $collaboration=$chapter->getCollaboration;
        if(Input::get('res')=="true")
        {
            $chapter->approved=1;
            $chapter->save();

            Action::postAction('C new chapter',$chapter->userid,null,$chapter->collaborationid);

            $readers=DB::table('collaborationreaders')->where('collaboration_id','=',$collaboration->id)->get();
            foreach($readers as $reader)
            {
                $user=User::find($reader->user_id);
                $writer=User::find($chapter->userid);
                CollaborationsController::$email=$user->email;
                /*$data=array('user'=>$user,'content' => $collaboration,'type' => 'C','writer' => $writer);*/
                Mail::send('mailers',array('user'=>$user,'content' => $collaboration,'type' => 'C','writer' => $writer,'page'=>'readerMailer'),function($message)
                {
                    $message->to(CollaborationsController::$email)->subject('New Chapter');
                });
            }
        }
        else
            $chapter->delete();
    }
        else
            return 'wH@tS!nTheB0x';
    }

    //edit chapter approval
    public function contributionEditApprove($id)
    {
        $buffer= CollaborationChapterBuffer::find($id);
        if ($buffer != null)
        {
            $collaboration=Collaboration::find(CollaborationChapter::find($buffer->chapterId)->collaborationid);
            $chapter=CollaborationChapter::find($buffer->chapterId);
            if (Auth::user()->id == $collaboration->userid)
                return View::make('approveEditContribution')->with('buffer',$buffer)->with('collaboration',$collaboration)->with('chapter',$chapter);
        }
        else
            return 'You have already submitted your verdict for this chapter.';

    }

    public function approveEditVerdict()
    {
        if(Auth::check())
        {
        $buffer=CollaborationChapterBuffer::find(Input::get('id'));
        $chapter=CollaborationChapter::find($buffer->chapterId);
        if(Input::get('res')=="true")
        {
            $chapter->text=$buffer->text;
            $chapter->save();
        }

        $buffer->delete();
    }
        else
            return 'wH@tS!nTheB0x';
    }
}
