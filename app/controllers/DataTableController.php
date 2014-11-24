<?php

class DataTableController extends \BaseController {


	public static $uid=null;
    public static $iid=null;
    public static $range=null;
	//this is demo datatable function
	public function getArticleDatatable()
	{
		return Datatable::query(Auth::user()->getArticles())
			->searchColumns('title')
			->orderColumns('title')
			->addColumn('title',function($model)
			{
				return "<a href='http://b2.com/articlePreview/".$model->id."' style='text-decoration: none'>".$model->title."</a>";
			})
			->addColumn('category',function($model)
			{
				$interest=Interest::find($model->category);
				return $interest->interest_name;
			})
			->addColumn('ifc',function($model)
			{
				return $model->ifc."i";
			})
			->addColumn('users',function($model)
			{
				return $model->users;
			})
			->addColumn('edit',function($model)
			{
				return "<a href='editArticle/".$model->id."'class='btn btn-primary'>Edit</a> <button type='button' onclick='deleteArticle(this,".$model->id.")'class='btn btn-danger'>Delete</button>";
			})
			->make();
	}

	//this is demo datatable function
	public function getMediaDatatable()
	{
		return Datatable::query(Auth::user()->getMedia())
			->searchColumns('title')
			->orderColumns('title','created_at')
            ->addColumn('title',function($model)
            {
                return "<a href='http://b2.com/mediaPreview/".$model->id."' style='text-decoration: none'>".$model->title."</a>";
            })
            ->addColumn('created_at',function($model)
            {
                return $model->created_at;
            })
            ->addColumn('access',function($model)
            {
                if ($model->ispublic)
                    return 'PUBLIC';
                else
                    return 'PRIVATE';
            })
			->addColumn('edit',function($model)
			{
                if ($model->ispublic)
                    return "<a id='".$model->path."' name='".$model->title."' href='http://b2.com/playMedia/".Crypt::encrypt($model->id)."' class='btn btn-success'>Preview</a> <button type='button' onclick='deleteMedia(this,".$model->id.")'class='btn btn-danger'>Delete</button> <button class='btn btn-primary' onclick='editDetails(".$model->id.")'>Edit Details</button> ";
                else
                    return "<a id='".$model->path."' name='".$model->title."' href='http://b2.com/playMedia/".Crypt::encrypt($model->id)."' class='btn btn-success'>Preview</a> <button type='button' onclick='deleteMedia(this,".$model->id.")'class='btn btn-danger'>Delete</button>";
			})
			->make();
	}

	//this is demo datatable function
	public function getResourceDatatable()
	{
		return Datatable::query(Auth::user()->getResources())
			->searchColumns('title')
			->orderColumns('title')
            ->addColumn('title',function($model)
            {
                return "<a href='http://b2.com/resource/".$model->id."' style='text-decoration: none'>".$model->title."</a>";
            })
			->addColumn('category',function($model)
			{
				$interest=Interest::find($model->category);
				return $interest->interest_name;
			})
			->addColumn('ifc',function($model)
			{
				return $model->ifc."i";
			})
			->addColumn('users',function($model)
			{
				return $model->users;
			})
			->addColumn('edit',function($model)
			{
				return "<a href='downloadResource/".Crypt::encrypt($model->id)."'class='btn btn-primary'>Download</a> <button type='button' onclick='deleteResource(this,".$model->id.")'class='btn btn-danger'>Delete</button>";
			})
			->make();
	}
	//this is demo datatable function
	public function getBookDatatable()
	{
		return Datatable::query(Auth::user()->getBlogBooks())
			->searchColumns('title')
			->orderColumns('title')
			->addColumn('title',function($model)
			{
				return "<a href='http://b2.com/blogBookPreview/".$model->id."' style='text-decoration: none'>".$model->title."</a>";
			})
			->addColumn('category',function($model)
			{
				$interest=Interest::find($model->category);
				return $interest->interest_name;
			})
			->addColumn('chapters',function($model)
			{
				return $model->chapters;
			})
			->addColumn('users',function($model)
			{
				return $model->users;
			})
			->addColumn('ifc',function($model)
			{
				return $model->ifc."i";
			})

			->addColumn('edit',function($model)
			{
				if ($model->review == 'passed')
					return "<a href='newChapter/".$model->id."'class='btn btn-primary'>Add Chapter</a> <a href='editBlogBook/".$model->id."'class='btn btn-primary'>Edit</a> <button type='button' onclick='deleteBlogBook(this,".$model->id.")'class='btn btn-danger'>Delete</button> <button id='ReviewBlogBook".$model->id."' type='button' class='btn btn-primary' onclick='reviewBlogBook(".$model->id.")'>Submit for Review</button> <img id='waitingPic".$model->id."' src='http://b2.com/Images/icons/waiting.gif' style='display: none' height='35px' width='35px'>";
				else
					return "<a href='newChapter/".$model->id."'class='btn btn-primary'>Add Chapter</a> <a href='editBlogBook/".$model->id."'class='btn btn-primary'>Edit</a> <button type='button' onclick='deleteBlogBook(this,".$model->id.")'class='btn btn-danger'>Delete</button> ";
			})
			->make();
	}
	//this is demo datatable function
	public function getChapterDatatable($bid)
	{
		$blogBook = BlogBook::find($bid);
		return Datatable::query($blogBook->getChapters())
			->showColumns('title')
			->searchColumns('title')
			->orderColumns('title')
			->addColumn('edit',function($model)
			{
				return "<a href='http://b2.com/editChapter/".$model->id."'class='btn btn-primary'>Edit</a> <button type='button' onclick='deleteChapter(this,".$model->id.")'class='btn btn-danger'>Delete</button>";
			})
			->make();
	}

	public function getMyArticlesDatatable()
	{
		return Datatable::query(Auth::user()->readArticles())
			->searchColumns('title')
			->orderColumns('title','category')
			->addColumn('title',function($model)
			{
				return "<a href='http://b2.com/articlePreview/".$model->article_id."' target='_blank' style='text-decoration: none'>".$model->title."</a>";
			})
			->addColumn('category',function($model)
			{
				$interest=Interest::find($model->category);
				return $interest->interest_name;
			})
                 	->make();
	}

	public function getMyBooksDatatable()
	{

		return Datatable::query(Auth::user()->readBooks())
			->searchColumns('title')
			->orderColumns('title','category')
			->addColumn('title',function($model)
			{
				return "<a href='http://b2.com/blogBookPreview/".$model->blog_book_id."' target='_blank' style='text-decoration: none'>".$model->title."</a>";
			})
			->addColumn('category',function($model)
			{
				$interest=Interest::find($model->category);
				return $interest->interest_name;
			})
                        ->make();

	}

    public function getMyCollaborationsDatatable()
    {

        return Datatable::query(Auth::user()->readCollaborations())
            ->searchColumns('title')
            ->orderColumns('title','category')
            ->addColumn('title',function($model)
            {
                return Collaboration::find($model->collaboration_id)->title;
            })
            ->addColumn('category',function($model)
            {
                $interest=Interest::find(Collaboration::find($model->collaboration_id)->category);
                return $interest->interest_name;
            })
            ->addColumn('actions',function($model)
            {
                $requestAlreadySent = DB::table('requestcontribution')->where('collaboration_id',$model->collaboration_id)->where('user_id',Auth::user()->id)->first();
                $alreadyInvited = DB::table('invite_contributors')->where('collaborationid',$model->collaboration_id)->where('useremail',Auth::user()->email)->first();
                if (Collaboration::find($model->collaboration_id)->isContributor() || $requestAlreadySent != null || $alreadyInvited != null)
                {
                        return "<a href='http://b2.com/collaborationPreview/".$model->collaboration_id."' class='btn btn-primary' target='_blank'>Read</a>";
                }

                else
                    return "<a href='http://b2.com/collaborationPreview/".$model->collaboration_id."' class='btn btn-primary' target='_blank'>Read</a>&nbsp;&nbsp;<button type='button' id='PlusContribute".$model->collaboration_id."' class='btn btn-info' onclick='plusContribute(".$model->collaboration_id.")'>+ Contribute</button>";
            })
            ->make();
    }

	public function getHisBooksDatatable($userId,$interestId)
	{
		DataTableController::$uid=$userId;
		$books = BlogBook::where('userid','=',$userId)->where('category','=',$interestId)->where(function($query)
        {
            $query->where('review', '=', 'passed')
                ->orWhere('review', '=', 'reviewed');
        });

        if(Auth::user())
        {
            return Datatable::query($books)
                ->searchColumns('title')
                ->orderColumns('title','category')
                ->addColumn('title',function($model)
                {
                    return $model->title;
                })
                ->addColumn('description',function($model)
                {
                    return $model->description;
                })
                ->addColumn('chapters',function($model)
                {
                    return $model->chapters;
                })
                ->addColumn('ifc',function($model)
                {
                    return $model->ifc;
                })
                ->addColumn('actions',function($model)
                {
                    if (DataTableController::$uid == Auth::user()->id || $model->isReader() || (User::find($model->userid)->settings->freeforfriends == true && Friend::isFriend($model->userid)))
                        return "<a href='http://b2.com/blogBook/".$model->id."' class='btn btn-primary' role='button'>Read</a>";
                    else
                        return "<a href='#' class='btn btn-default' role='button' onclick='showPreview(".$model->id.")'>Show Preview</a> <a href='#' class='btn btn-default' role='button' id='".$model->title."' name='book' onclick='showPurchase(this,".$model->ifc.",".Auth::user()->profile->ifc.",".$model->id.")'>Read</a>";
                })
                ->make();
        }
		else
        {
            return Datatable::query($books)
                ->searchColumns('title')
                ->orderColumns('title','category')
                ->addColumn('title',function($model)
                {
                    return $model->title;
                })
                ->addColumn('description',function($model)
                {
                    return $model->description;
                })
                ->addColumn('chapters',function($model)
                {
                    return $model->chapters;
                })
                ->addColumn('actions',function($model)
                {
                    return "<a href='#' class='btn btn-default' role='button' onclick='showPreview(".$model->id.")'>Show Preview</a>";
                })
                ->make();
        }
	}

	public function getHisArticlesDatatable($userId, $interestId)
	{
		DataTableController::$uid=$userId;
		$articles = Article::where('userid','=',$userId)->where('category','=',$interestId)->where('review','=','passed');

        if(Auth::user())
        {
            return Datatable::query($articles)
                ->searchColumns('title')
                ->orderColumns('title','category')
                ->addColumn('title',function($model)
                {
                    return "<a href='#' onclick='showArticlePreview(".$model->id.")' style='text-decoration: none'>".$model->title."</a>";
                })
                ->addColumn('ifc',function($model)
                {
                    return $model->ifc;
                })
                ->addColumn('actions',function($model)
                {
                    if (DataTableController::$uid== Auth::user()->id || $model->isReader() || (User::find($model->userid)->settings->freeforfriends == true && Friend::isFriend($model->userid)))
                        return "<a href='http://b2.com/readArticle/".$model->id."' class='btn btn-primary' role='button'>Read</a>";
                    else
                        return "<a href='#' class='btn btn-default' role='button' id='".$model->title."' name='article' onclick='showPurchase(this,".$model->ifc.",".Auth::user()->profile->ifc.",".$model->id.")'>Read</a>";
                })
                ->make();
        }
        else
        {
            return Datatable::query($articles)
                ->searchColumns('title')
                ->orderColumns('title','category')
                ->addColumn('title',function($model)
                {
                    return "<a href='#' onclick='showArticlePreview(".$model->id.")' style='text-decoration: none'>".$model->title."</a>";
                })
                ->make();
        }
	}

	public function getHisResourcesDatatable($userId, $interestId)
	{
		DataTableController::$uid=$userId;
		$resources = Resource::where('userid','=',$userId)->where('category','=',$interestId);

        if(Auth::user())
        {
            return Datatable::query($resources)
                ->searchColumns('title')
                ->orderColumns('title','category')
                ->addColumn('title',function($model)
                {
                    return "<a href='#' onclick='showResourcePreview(".$model->id.")' style='text-decoration: none'>".$model->title."</a>";
                })
                ->addColumn('ifc',function($model)
                {
                    return $model->ifc;
                })
                ->addColumn('actions',function($model)
                {
                    if (DataTableController::$uid == Auth::user()->id)
                        return "<a href='http://b2.com/sym140Nb971wzb4284/".$model->id."' class='btn btn-primary' role='button'>Download</a>";
                    else
                        return "<a href='#' class='btn btn-default' role='button' id='".$model->title."' name='resource' onclick='showPurchase(this,".$model->ifc.",".Auth::user()->profile->ifc.",".$model->id.")'>Read</a>";
                })
                ->make();
        }
		else
        {
            return Datatable::query($resources)
                ->searchColumns('title')
                ->orderColumns('title','category')
                ->addColumn('title',function($model)
                {
                    return "<a href='#' onclick='showResourcePreview(".$model->id.")' style='text-decoration: none'>".$model->title."</a>";
                })
                ->make();
        }
	}


    //these are collaborations data controllers
    public function getHisCollaborationDatatable($userId, $interestId)
    {
        DataTableController::$uid=$userId;
        $collaborations = Collaboration::where('userid','=',$userId)->where('category','=',$interestId);

        if(Auth::user())
        {
            return Datatable::query($collaborations)
                ->searchColumns('title')
                ->orderColumns('title','category')
                ->addColumn('title',function($model)
                {
                    return $model->title;
                })
                ->addColumn('description',function($model)
                {
                    return $model->description;
                })
                ->addColumn('chapters',function($model)
                {
                    return $model->chapters;
                })
                ->addColumn('ifc',function($model)
                {
                    return $model->ifc;
                })
                ->addColumn('readers',function($model)
                {
                    return $model->users;
                })
                ->addColumn('actions',function($model)
                {
                    if (DataTableController::$uid == Auth::user()->id || $model->isReader() || $model->isContributor() || (User::find($model->userid)->settings->freeforfriends == true && Friend::isFriend($model->userid)))
                        return "<a href='http://b2.com/collaboration/".$model->id."' class='btn btn-primary' role='button'>Read</a>";
                    else
                        return "<a href='#' class='btn btn-default' role='button' onclick='showCollaborationPreview(".$model->id.")'>Show Preview</a> <a href='#' class='btn btn-default' role='button' id='".$model->title."' name='collaboration' onclick='showPurchase(this,".$model->ifc.",".Auth::user()->profile->ifc.",".$model->id.")'>Read</a>";
                })
                ->make();
        }
        else
        {
            return Datatable::query($collaborations)
                ->searchColumns('title')
                ->orderColumns('title','category')
                ->addColumn('title',function($model)
                {
                    return $model->title;
                })
                ->addColumn('description',function($model)
                {
                    return $model->description;
                })
                ->addColumn('chapters',function($model)
                {
                    return $model->chapters;
                })
                ->addColumn('readers',function($model)
                {
                    return $model->users;
                })
                ->addColumn('actions',function($model)
                {
                    return "<a href='#' class='btn btn-default' role='button' onclick='showCollaborationPreview(".$model->id.")'>Show Preview</a>";
                })
                ->make();
        }
    }

    public function getHisContributionDatatable($userId, $interestId)
    {

        DataTableController::$uid=$userId;
        DataTableController::$iid=$interestId;
        $user = User::find($userId);
        $contributions = $user->getContributions()->get();
        $send = $contributions->filter(function($contri)
        {
            if ($contri->category == DataTableController::$iid) {
                return true;
            }
        });

        if(Auth::user())
        {
            return Datatable::collection($send)
                ->searchColumns('title')
                ->orderColumns('title','category')
                ->addColumn('title',function($model)
                {
                    return $model->title;
                })
                ->addColumn('description',function($model)
                {
                    return $model->description;
                })
                ->addColumn('chapters',function($model)
                {
                    return $model->chapters;
                })
                ->addColumn('ifc',function($model)
                {
                    return $model->ifc;
                })
                ->addColumn('readers',function($model)
                {
                    return $model->users;
                })
                ->addColumn('actions',function($model)
                {
                    if (DataTableController::$uid == Auth::user()->id || $model->isReader() || $model->isContributor() || $model->userid==Auth::user()->id)
                        return "<a href='http://b2.com/collaboration/".$model->id."' class='btn btn-primary' role='button'>Read</a>";
                    else
                        return "<a href='#' class='btn btn-default' role='button' onclick='showCollaborationPreview(".$model->id.")'>Show Preview</a> <a href='#' class='btn btn-default' role='button' id='".$model->title."' name='collaboration' onclick='showPurchase(this,".$model->ifc.",".Auth::user()->profile->ifc.",".$model->id.")'>Read</a>";
                })
                ->make();
        }
        else
        {
            return Datatable::collection($send)
                ->searchColumns('title')
                ->orderColumns('title','category')
                ->addColumn('title',function($model)
                {
                    return $model->title;
                })
                ->addColumn('description',function($model)
                {
                    return $model->description;
                })
                ->addColumn('chapters',function($model)
                {
                    return $model->chapters;
                })
                ->addColumn('readers',function($model)
                {
                    return $model->users;
                })
                ->addColumn('actions',function($model)
                {
                    return "<a href='#' class='btn btn-default' role='button' onclick='showCollaborationPreview(".$model->id.")'>Show Preview</a>";
                })
                ->make();
        }
    }

    public function getCollaborationDatatable()
    {
        return Datatable::query(Auth::user()->getOwnedCollaborations())
            ->searchColumns('title')
            ->orderColumns('title')
            ->addColumn('title',function($model)
            {
                return "<a href='http://b2.com/collaborationPreview/".$model->id."' style='text-decoration: none'>".$model->title."</a>";
            })
            ->addColumn('category',function($model)
            {
                $interest=Interest::find($model->category);
                return $interest->interest_name;
            })
            ->addColumn('chapters',function($model)
            {
                return $model->chapters;
            })
            ->addColumn('users',function($model)
            {
                return $model->users;
            })
            ->addColumn('ifc',function($model)
            {
                return $model->ifc."i";
            })

            ->addColumn('edit',function($model)
            {
                if ($model->chapters > 0)
                    return "<a href='collaborationNewChapter/".$model->id."'class='btn btn-primary'>Add Chapter</a> <a href='collaborationSettings/".$model->id."'class='btn btn-primary'>Edit</a> <button type='button' onclick='deleteCollaboration(this,".$model->id.")'class='btn btn-danger'>Delete</button> <button type='button' class='btn btn-primary' onclick='inviteContributors(".$model->id.")'>Invite Contributors</button>";
                else
                    return "<a href='collaborationNewChapter/".$model->id."'class='btn btn-primary'>Add Chapter</a> <a href='collaborationSettings/".$model->id."'class='btn btn-primary'>Edit</a> <button type='button' onclick='deleteCollaboration(this,".$model->id.")'class='btn btn-danger'>Delete</button> ";
            })
            ->make();
    }

    public function getContributionDatatable()
    {
        $contributions = Auth::user()->getContributions()->get();

        return Datatable::collection($contributions)
            ->searchColumns('title')
            ->orderColumns('title')
            ->addColumn('title',function($model)
            {
                return "<a href='http://b2.com/collaborationPreview/".$model->id."' style='text-decoration: none'>".$model->title."</a>";
            })
            ->addColumn('category',function($model)
            {
                $interest=Interest::find($model->category);
                return $interest->interest_name;
            })
            ->addColumn('chapters',function($model)
            {
                return $model->chapters;
            })
            ->addColumn('users',function($model)
            {
                return $model->users;
            })
            ->addColumn('ifc',function($model)
            {
                return $model->ifc."i";
            })

            ->addColumn('edit',function($model)
            {
                return "<a href='collaborationNewChapter/".$model->id."'class='btn btn-primary'>Add Chapter</a> <a href='editCollaborationChapters/".$model->id."'class='btn btn-primary'>Edit Chapters</a> <button type='button' onclick='stopContributing(this,".$model->id.")'class='btn btn-danger'>Stop Contributing</button>";
            })
            ->make();
    }

    public function getCollaborationChapterDatatable($cid)
    {
        $collaboration = Collaboration::find($cid);
        return Datatable::query($collaboration->getChapters())
            ->showColumns('title')
            ->searchColumns('title')
            ->orderColumns('title')
            ->addColumn('writer',function($model)
            {
                return "<a href='http://b2.com/user/".User::find($model->userid)->username."' style='text-decoration: none' target='_blank'>".User::find($model->userid)->first_name." ".User::find($model->userid)->last_name."</a>";
            })
            ->addColumn('edit',function($model)
            {
                if (Auth::user()->id == Collaboration::find($model->collaborationid)->userid)
                    return "<a href='http://b2.com/editCollaborationChapter/".$model->id."'class='btn btn-primary'>Edit</a> <button type='button' onclick='deleteChapter(this,".$model->id.")'class='btn btn-danger'>Delete</button>";
                else
                    return "<a href='http://b2.com/editCollaborationChapter/".$model->id."'class='btn btn-primary'>Edit</a>";
            })
            ->make();
    }

    public function getCollaborationContributorDatatable($cid)
    {
        $collaboration = Collaboration::find($cid);
        return Datatable::query($collaboration->getContributors())
            ->searchColumns('name')
            ->orderColumns('name')
            ->addColumn('name',function($model)
            {
                return "<a href='http://b2.com/user/".$model->username."' style='text-decoration: none' target='_blank'>".$model->first_name." ".$model->last_name."</a>";
            })
            ->addColumn('actions',function($model)
            {
                return "<button type='button' onclick='deleteUser(this,".$model->user_id.")'class='btn btn-danger'>Remove User</button>";
            })
            ->make();
    }


    //this function is to create friends content notification
    public function friendsNotificationData()
    {
        if(Auth::check())
        {
        $userid=Auth::user()->id;
        $friends1=DB::table('friends')->where('friend1','=',$userid)->where('status','=','accepted')->lists('friend2');
        $friends2=DB::table('friends')->where('friend2','=',$userid)->where('status','=','accepted')->lists('friend1');
        $friends3 = array_merge($friends1, $friends2);
        $subs=DB::table('subscriptions')->where('subscriber_id',$userid)->lists('subscribed_to_id');
        $friends4=array_merge($subs,$friends3);
        $friends=array_unique($friends4);

        $users=new \Illuminate\Database\Eloquent\Collection();
        $blogbooks=new \Illuminate\Database\Eloquent\Collection();
        $articles=new \Illuminate\Database\Eloquent\Collection();
        $resources=new \Illuminate\Database\Eloquent\Collection();
        $collaborations=new \Illuminate\Database\Eloquent\Collection();
        $media=new \Illuminate\Database\Eloquent\Collection();
        $contributions=new \Illuminate\Database\Eloquent\Collection();
        $polls=new \Illuminate\Database\Eloquent\Collection();
        $quizes=new \Illuminate\Database\Eloquent\Collection();
        $contributors=array();
        $cci=0;

        foreach($friends as $f)
        {
            $users->add(User::find($f));
        }
        $inputDays = Input::get('days');
        $days=intval($inputDays);
        $range=\Carbon\Carbon::now()->subDays($days);
        DataTableController::$range = $range;
        foreach($users as $user)
        {

            $bb=$user->getBlogBooks()->where('created_at', '>=', $range)->get();
            foreach($bb as $b)
            {
                $blogbooks->add($b);
            }
            $aa=$user->getArticles()->where('created_at', '>=', $range)->get();
            foreach($aa as $a)
            {
                $articles->add($a);
            }
            $rr=$user->getResources()->where('created_at', '>=', $range)->get();
            foreach($rr as $r)
            {
                $resources->add($r);
            }
            $cc=$user->getOwnedCollaborations()->where('created_at', '>=', $range)->get();
            foreach($cc as $c)
            {
                $collaborations->add($c);
            }
            $contri=$user->getContributions()->get();
            $send = $contri->filter(function($cont)
            {
                if ($cont->created_at >= DataTableController::$range) {
                    return true;
                }
            });
            foreach($send as $sen)
            {
                $contributions->add($sen);
                $contributors[$cci]=$user->id;
                $cci++;
            }
            $pp=$user->getPolls()->where('created_at', '>=', $range)->get();
            foreach($pp as $p)
            {
                $polls->add($p);
            }
            $qq=$user->getQuizes()->where('created_at', '>=', $range)->get();
            foreach($qq as $q)
            {
                $quizes->add($q);
            }
            $med=$user->getMedia()->where('ispublic','=',true)->where('created_at', '>=', $range)->get();
            foreach($med as $m)
            {
                $media->add($m);
            }
        }
        $pollsnquizes = $polls->merge($quizes);

        $blogbooks=$blogbooks->sortByDesc('created_at')->take(4);
        $articles=$articles->sortByDesc('created_at')->take(4);
        $resources=$resources->sortByDesc('created_at')->take(4);
        $collaborations=$collaborations->sortByDesc('created_at')->take(2);
        $contributions=$contributions->sortByDesc('created_at')->take(2);
        $media=$media->sortByDesc('created_at')->take(4);
        $pollsnquizes=$pollsnquizes->sortByDesc('created_at')->take(4);

        if (count($blogbooks) == 0 && count($articles) == 0 && count($resources) == 0 && count($collaborations) == 0 && count($contributions) == 0 && count($pollsnquizes) == 0 && count($media) == 0)
            return "ZeroData";
        return View::make('notifyFriendsContent')->with('blogbooks',$blogbooks)->with('articles',$articles)->with('resources',$resources)->with('collaborations',$collaborations)->with('contributions',$contributions)->with('contributors',$contributors)->with('pollsnquizes',$pollsnquizes)->with('media',$media);
    }
        else
            return 'wH@tS!nTheB0x';
    }

    //this function is to create friends content notification
    public function categoryNotificationData($id,$type)
    {
        if(Auth::check())
        {
        $blogbooks=new \Illuminate\Database\Eloquent\Collection();
        $articles=new \Illuminate\Database\Eloquent\Collection();
        $resources=new \Illuminate\Database\Eloquent\Collection();

        if($type='Latest')
        {
            $range=\Carbon\Carbon::now()->subDays(7);
            if($id=="0")
            {

                $category=Interest::all();
                foreach($category as $cat)
                {
                    foreach($cat->getBlogBooks()->where('created_at', '>=', $range)->get() as $book)
                    {
                        $blogbooks->add($book);
                    }
                    foreach($cat->getArticles()->where('created_at', '>=', $range)->get() as $article)
                    {
                        $articles->add($article);
                    }
                    foreach($cat->getResources()->where('created_at', '>=', $range)->get() as $resource)
                    {
                        $resources->add($resource);
                    }
                }

            }
            else
            {
                $category=Interest::find($id);
                $blogbooks=$category->getBlogBooks()->where('created_at', '>=', $range)->get();
                $articles=$category->getArticles()->where('created_at', '>=', $range)->get();
                $resources=$category->getResources()->where('created_at', '>=', $range)->get();
            }
        }
        else
        {
            if($id==0)
            {
                $category=Interest::all();
                foreach($category as $cat)
                {
                    foreach($cat->getBlogBooks()->orderBy('users','DESC')->get() as $book)
                    {
                        $blogbooks->add($book);
                    }
                    foreach($cat->getArticles()->orderBy('users','DESC')->get() as $article)
                    {
                        $articles->add($article);
                    }
                    foreach($cat->getResources()->orderBy('users','DESC')->get() as $resource)
                    {
                        $resources->add($resource);
                    }
                }
            }
            else
            {
                $category=Interest::find($id);
                $blogbooks=$category->getBlogBooks()->orderBy('users','DESC')->get();
                $articles=$category->getArticles()->orderBy('users','DESC')->get();
                $resources=$category->getResources()->orderBy('users','DESC')->get();

            }

        }
        return View::make('notifyCategoryContent')->with('blogbooks',$blogbooks)->with('articles',$articles)->with('resources',$resources);
    }
        else
            return 'wH@tS!nTheB0x';
    }

    //this is for poll datatable
    public function getMyPollsDatatable()
    {
        return Datatable::query(Auth::user()->getPolls())
            ->searchColumns('question','category')
            ->orderColumns('question')
            ->addColumn('question',function($model)
            {
                return "<a href='http://b2.com/poll/".$model->id."' style='text-decoration: none'>".Str::limit($model->question,60)."</a>";
            })
            ->addColumn('category',function($model)
            {
                $interest=Interest::find($model->category);
                return $interest->interest_name;
            })
            ->addColumn('ifc',function($model)
            {
                return $model->ifc."i";
            })
            ->addColumn('actions',function($model)
            {
                $status=$model->active;
                if($status==0)
                {
                return "<button type='button' onclick='showResult(".$model->id.")'class='btn btn-success'>Show Result</button> <button type='button' onclick='closePoll(this,".$model->id.")'class='btn btn-danger'>Open</button> <button type='button' onclick='deletePoll(this,".$model->id.")'class='btn btn-danger'>Delete</button>";
                }
                else
                {
                    return "<button type='button' onclick='showResult(".$model->id.")'class='btn btn-success'>Show Result</button> <button type='button' onclick='closePoll(this,".$model->id.")'class='btn btn-danger'>Close</button> <button type='button' onclick='deletePoll(this,".$model->id.")'class='btn btn-danger'>Delete</button>";
                }
            })
            ->make();
    }

    public function getPublicPollsDatatable()
    {
        return Datatable::query(Poll::where('ispublic',true))
            ->searchColumns('question','category')
            ->orderColumns('question')
            ->addColumn('question',function($model)
            {
                return "<a href='http://b2.com/poll/".$model->id."' style='text-decoration: none'>".Str::limit($model->question,60)."</a>";
            })
            ->addColumn('category',function($model)
            {
                $interest=Interest::find($model->category);
                return $interest->interest_name;
            })
            ->addColumn('ifc',function($model)
            {
                return $model->ifc."i";
            })
            ->make();
    }

    public function getFriendsPollsDatatable()
    {
        $uid=Auth::user()->id;
        $friends=Friend::getFriends($uid);
        $fpolls=new \Illuminate\Database\Eloquent\Collection();

        foreach($friends as $friend)
        {
            $polls=User::find($friend)->getPolls()->get();
            foreach($polls as $p)
            {
                $fpolls->add($p);
            }
        }
        return Datatable::collection($fpolls)
            ->searchColumns('question','category')
            ->orderColumns('question')
            ->addColumn('question',function($model)
            {
                return "<a href='http://b2.com/poll/".$model->id."' style='text-decoration: none'>".Str::limit($model->question,60)."</a>";
            })
            ->addColumn('category',function($model)
            {
                $interest=Interest::find($model->category);
                return $interest->interest_name;
            })
            ->addColumn('ifc',function($model)
            {
                return $model->ifc."i";
            })
            ->make();
    }

    public function getSubscriptionPollsDatatable()
    {
        $subscriptions =Auth::user()->getSubscribedTo()->get();
        $spolls=new \Illuminate\Database\Eloquent\Collection();
        foreach($subscriptions as $subs)
        {
            $polls=$subs->getPolls()->get();
            foreach($polls as $p)
            {
                $spolls->add($p);
            }
        }

        return Datatable::collection($spolls)
            ->searchColumns('question','category')
            ->orderColumns('question')
            ->addColumn('question',function($model)
            {
                return "<a href='http://b2.com/poll/".$model->id."' style='text-decoration: none'>".Str::limit($model->question,60)."</a>";
            })
            ->addColumn('category',function($model)
            {
                $interest=Interest::find($model->category);
                return $interest->interest_name;
            })
            ->addColumn('ifc',function($model)
            {
                return $model->ifc."i";
            })
            ->make();
    }

    //this is for Quiz datatable
    //this is for Quiz datatable
    public function getMyQuizDatatable()
    {
        return Datatable::query(Auth::user()->getQuizes())
            ->searchColumns('title','category')
            ->orderColumns('title','ifc')
            ->addColumn('title',function($model)
            {
                return "<a href='http://b2.com/quizPreview/".$model->id."' style='text-decoration: none'>".Str::limit($model->title,60)."</a>";
            })
            ->addColumn('category',function($model)
            {
                $interest=Interest::find($model->category);
                return $interest->interest_name;
            })
            ->addColumn('ifc',function($model)
            {
                return $model->ifc."i";
            })
            ->addColumn('actions',function($model)
            {
                $status=$model->ispublic;
                if($status==0)
                {
                    return "<a href='http://b2.com/editQuiz/".$model->id."' class='btn btn-primary'>Edit Quiz</a> <button type='button' onclick='showStats(".$model->id.")'class='btn btn-success'>Stats</button> <button type='button' onclick='closeQuiz(this,".$model->id.")'class='btn btn-danger'>Open</button> <button type='button' onclick='deleteQuiz(this,".$model->id.")'class='btn btn-danger'>Delete</button>";
                }
                else
                {
                    return "<a href='http://b2.com/editQuiz/".$model->id."' class='btn btn-primary'>Edit Quiz</a> <button type='button' onclick='showStats(".$model->id.")'class='btn btn-success'>Stats</button> <button type='button' onclick='closeQuiz(this,".$model->id.")'class='btn btn-danger'>Close</button> <button type='button' onclick='deleteQuiz(this,".$model->id.")'class='btn btn-danger'>Delete</button>";
                }
            })
            ->make();
    }

    public function getPublicQuizDatatable()
    {
        return Datatable::query(Quiz::where('ispublic',true))
            ->searchColumns('title','category')
            ->orderColumns('title')
            ->addColumn('title',function($model)
            {
                return "<a href='http://b2.com/quizPreview/".$model->id."' style='text-decoration: none'>".Str::limit($model->title,60)."</a>";
            })
            ->addColumn('category',function($model)
            {
                $interest=Interest::find($model->category);
                return $interest->interest_name;
            })
            ->addColumn('ifc',function($model)
            {
                return $model->ifc."i";
            })
            ->addColumn('owner',function($model)
            {
                return "<a href='http://b2.com/user/".User::find($model->ownerid)->username."' style='text-decoration: none' target='_blank'>".User::find($model->ownerid)->first_name." ".User::find($model->ownerid)->last_name."</a>";
            })
            ->make();
    }

    public function getFriendsQuizDatatable()
    {
        $uid=Auth::user()->id;
        $friends=Friend::getFriends($uid);
        $fpolls=new \Illuminate\Database\Eloquent\Collection();

        foreach($friends as $friend)
        {
            $polls=User::find($friend)->getQuizes()->get();
            foreach($polls as $p)
            {
                $fpolls->add($p);
            }
        }
        return Datatable::collection($fpolls)
            ->searchColumns('title','category')
            ->orderColumns('title')
            ->addColumn('title',function($model)
            {
                return "<a href='http://b2.com/quizPreview/".$model->id."' style='text-decoration: none'>".Str::limit($model->title,60)."</a>";
            })
            ->addColumn('category',function($model)
            {
                $interest=Interest::find($model->category);
                return $interest->interest_name;
            })
            ->addColumn('ifc',function($model)
            {
                return $model->ifc."i";
            })
            ->addColumn('owner',function($model)
            {
                return "<a href='http://b2.com/user/".User::find($model->ownerid)->username."' style='text-decoration: none' target='_blank'>".User::find($model->ownerid)->first_name." ".User::find($model->ownerid)->last_name."</a>";
            })
            ->make();
    }

    public function getSubscriptionQuizDatatable()
    {
        $subscriptions =Auth::user()->getSubscribedTo()->get();
        $spolls=new \Illuminate\Database\Eloquent\Collection();
        foreach($subscriptions as $subs)
        {
            $polls=$subs->getQuizes()->get();
            foreach($polls as $p)
            {
                $spolls->add($p);
            }
        }

        return Datatable::collection($spolls)
            ->searchColumns('title','category')
            ->orderColumns('title')
            ->addColumn('title',function($model)
            {
                return "<a href='http://b2.com/quizPreview/".$model->id."' style='text-decoration: none'>".Str::limit($model->title,60)."</a>";
            })
            ->addColumn('category',function($model)
            {
                $interest=Interest::find($model->category);
                return $interest->interest_name;
            })
            ->addColumn('ifc',function($model)
            {
                return $model->ifc."i";
            })
            ->addColumn('owner',function($model)
            {
                return "<a href='http://b2.com/user/".User::find($model->ownerid)->username."' style='text-decoration: none' target='_blank'>".User::find($model->ownerid)->first_name." ".User::find($model->ownerid)->last_name."</a>";
            })
            ->make();
    }

    public function getQuizTakersDatatable($qid)
    {
        //$quizTakers = DB::table('quiztakers')->where('quiz_id',$qid)->orderBy('ifc','desc');
        return Datatable::query(DB::table('quiztakers')->where('quiz_id',$qid)->orderBy('ifc','desc'))
            ->searchColumns('Name')
            ->orderColumns('Name','ifc')
            ->addColumn('Name',function($model)
            {
                return "<a href='http://b2.com/user/".User::find($model->user_id)->username."' style='text-decoration: none'>".User::find($model->user_id)->first_name." ".User::find($model->user_id)->last_name."</a>";
            })
            ->addColumn('ifc',function($model)
            {
                return $model->ifc."i";
            })
            ->make();
    }

    public function getExistingQuizQuestionsDatatable($qid)
    {
        //$quizTakers = DB::table('quiztakers')->where('quiz_id',$qid)->orderBy('ifc','desc');
        return Datatable::query(Quiz::find($qid)->getOptions())
            ->searchColumns('question')
            ->orderColumns('question')
            ->addColumn('title',function($model)
            {
                return $model->question;
            })
            ->addColumn('option1',function($model)
            {
                if ($model->correct1 == true)
                    return "<b>".$model->option1."</b>";
                else
                    return $model->option1;
            })
            ->addColumn('option2',function($model)
            {
                if ($model->correct2 == true)
                    return "<b>".$model->option2."</b>";
                else
                    return $model->option2;
            })
            ->addColumn('option3',function($model)
            {
                if ($model->option3 != null)
                {
                    if ($model->correct3 == true)
                        return "<b>".$model->option3."</b>";
                    else
                        return $model->option3;
                }
                else
                    return "NULL";
            })
            ->addColumn('option4',function($model)
            {
                if ($model->option3 != null)
                {
                    if ($model->correct4 == true)
                        return "<b>".$model->option4."</b>";
                    else
                        return $model->option4;
                }
                else
                    return "NULL";
            })
            ->addColumn('action',function($model)
            {
                return "<button type='button' class='btn btn-default' onclick='editExistingQuestion(".$model->id.")'>Edit</button> <button type='button' class='btn btn-danger' onclick='removeExistingQuestion(this,".$model->id.")'>Drop</button>";
            })
            ->make();
    }

    //these functions are for showing lists of friends/subscribers on profile page
    public function getFriendListDatatable()
    {
        $userid=Auth::user()->id;
        $friends1=DB::table('friends')->where('friend1','=',$userid)->where('status','=','accepted')->lists('friend2');
        $friends2=DB::table('friends')->where('friend2','=',$userid)->where('status','=','accepted')->lists('friend1');
        $friends = array_merge($friends1, $friends2);
        $friendList=new \Illuminate\Database\Eloquent\Collection();
        foreach($friends as $f)
        {
            $user=User::find($f);
            $friendList->add($user);
        }
        return Datatable::collection($friendList)
            ->searchColumns('Name')
            ->orderColumns('Name')
            ->addColumn('picture',function($model)
            {
                $profile=Profile::where('userid','=',$model->id)->first();
                $pic=$profile->profilePic;
                return "<img src='$pic' height='50px' width='50px'>";
            })
            ->addColumn('Name',function($model)
            {
               return "<a href='http://b2.com/user/".$model->username."'>$model->first_name $model->last_name</a>";
            })
            ->addColumn('unfriend',function($model)
            {
                return "<button id='friendsModalUnfriendButton' class='btn btn-primary pull-right' onclick='friendsModalUnfriend( this,$model->id)'>UnFriend</button>";
            })
            ->make();
    }
    public function getRequestListDatatable()
    {
        $userid=Auth::user()->id;
        $requests=DB::table('friends')->where('friend2','=',$userid)->where('status','=','sent')->get();
        $users2=new \Illuminate\Database\Eloquent\Collection();
        foreach($requests as $f)
        {

             $users2->add(User::find($f->friend1));

        }
        return Datatable::collection($users2)
            ->searchColumns('Name')
            ->orderColumns('Name')
            ->addColumn('picture',function($model)
            {
                $profile=Profile::where('userid','=',$model->id)->first();
                $pic=$profile->profilePic;
                return "<img src='$pic' height='50px' width='50px'>";
            })
            ->addColumn('Name',function($model)
            {
                return "<a href='http://b2.com/user/".$model->username."'>$model->first_name $model->last_name</a>";
            })
            ->addColumn('decision',function($model)
            {
                return "<button id='acceptButton' class='btn btn-success' onclick='acceptRequest( this,$model->id)'>Accept</button> <button id='declineButton' class='btn btn-alert' onclick='declineRequest( this,$model->id)'>Decline</button>";
            })
            ->make();
    }

    public function getPendingListDatatable()
    {
        $userid=Auth::user()->id;
        $prequests=DB::table('friends')->where('friend1','=',$userid)->where('status','=','sent')->lists('friend2');
        $users3=new \Illuminate\Database\Eloquent\Collection();
        foreach($prequests as $f)
        {
            $users3->add(User::find($f));
        }

        return Datatable::collection($users3)
            ->searchColumns('Name')
            ->orderColumns('Name')
            ->addColumn('picture',function($model)
            {
                $profile=Profile::where('userid','=',$model->id)->first();
                $pic=$profile->profilePic;
                return "<img src='$pic' height='50px' width='50px'>";
            })
            ->addColumn('Name',function($model)
            {
                return "<a href='http://b2.com/user/".$model->username."'>$model->first_name $model->last_name</a>";
            })
            ->addColumn('cancel',function($model)
            {
                return "<button id='cancelButton' class='btn btn-warning' onclick='cancelRequest(this,$model->id)'>Cancel</button>";
            })
            ->make();
    }

    public function getSubscribersListDatatable()
    {
        $list=Auth::user()->getSubscribers()->get();
        return Datatable::collection($list)
            ->searchColumns('Name')
            ->orderColumns('Name')
            ->addColumn('picture',function($model)
            {
                $profile=Profile::where('userid','=',$model->id)->first();
                $pic=$profile->profilePic;
                return "<img src='$pic' height='50px' width='50px'>";
            })
            ->addColumn('Name',function($model)
            {
                return "<a href='http://b2.com/user/".$model->username."'>$model->first_name $model->last_name</a>";
            })
            ->addColumn('block',function($model)
            {
                if(Subscribe::isBlocked($model->id))
                    return "<button class='btn btn-primary' onclick='block_unblock(this,$model->id)'>Unblock</button>";
                else
                    return "<button class='btn btn-primary' onclick='block_unblock(this,$model->id)'>Block</button>";

            })
            ->make();
    }

    public function getSubscriptionsListDatatable()
    {
        $subscriptions=Auth::user()->getSubscribedTo()->get();
        return Datatable::collection($subscriptions)
            ->searchColumns('Name')
            ->orderColumns('Name')
            ->addColumn('picture',function($model)
            {
                $profile=Profile::where('userid','=',$model->id)->first();
                $pic=$profile->profilePic;
                return "<img src='$pic' height='50px' width='50px'>";
            })
            ->addColumn('Name',function($model)
            {
                return "<a href='http://b2.com/user/".$model->username."'>$model->first_name $model->last_name</a>";
            })
            ->addColumn('unfollow',function($model)
            {
                return "<button class='btn btn-alert' onclick='unfollow(this,$model->id)'>Unsubscribe</button>";

            })
            ->make();
    }


    public function getUnansweredQuestions($userId)
    {
        $questions = User::find($userId)->questionsAskedToUser()->where('answer','=','')->get();
        return Datatable::collection($questions)
            ->searchColumns('question')
            ->orderColumns('question')
            ->addColumn('question',function($model)
            {
                return $model->question;
            })
            ->addColumn('description',function($model)
            {
                if ($model->description != null)
                    return "<a href='#' onclick='showDescription(".$model->id."); return false;' style='text-decoration: none'>Show Description..</a>";
                else
                    return "None.";
            })
            ->addColumn('ifc',function($model)
            {
                return $model->ifc;
            })
            ->addColumn('access',function($model)
            {
                if ($model->private)
                    return "PRIVATE";
                else
                    return "PUBLIC";
            })
            ->addColumn('askedBy',function($model)
            {
                return User::find($model->askedBy_id)->first_name." ".User::find($model->askedBy_id)->last_name;
            })
            ->addColumn('actions',function($model)
            {
                $question = $model->question;
                $question = str_replace('\'',' ', $question);
                $question = str_replace('"',' ', $question);
                return "<button type='button' id='Button".$model->id."' class='btn btn-success' onclick='writeAnswer(".$model->id.",\"".$question."\")'>Answer</button>&nbsp;&nbsp;<button type='button' class='btn btn-danger' onclick='declineAnswer(this,".$model->id.")'>Decline</button>";
            })
            ->make();
    }

    public function getAnsweredQuestions($userId)
    {
        if (Auth::user()->id == $userId)
            $questions = User::find($userId)->questionsAskedToUser()->where('answer','!=','')->get();
        else
            $questions = User::find($userId)->questionsAskedToUser()->where('answer','!=','')->where('private','=',false)->get();
        return Datatable::collection($questions)
            ->searchColumns('question')
            ->orderColumns('question')
            ->addColumn('question',function($model)
            {
                return $model->question;
            })
            ->addColumn('description',function($model)
            {
                if ($model->description != null)
                    return "<a href='#' onclick='showDescription(".$model->id."); return false;' style='text-decoration: none'>Show Description..</a>";
                else
                    return "<i>NULL</i>";
            })
            ->addColumn('answer',function($model)
            {
                return "<a href='#' onclick='showAnswer(".$model->id."); return false;' style='text-decoration: none'>Show Answer..</a>";
            })
            ->addColumn('askedBy',function($model)
            {
                return User::find($model->askedBy_id)->first_name." ".User::find($model->askedBy_id)->last_name;
            })
            ->make();
    }

    public function getAskedQuestions($userId)
    {
        $questions = User::find($userId)->questionsAskedByUser()->where('answer','!=','')->get();
        return Datatable::collection($questions)
            ->searchColumns('question')
            ->orderColumns('question')
            ->addColumn('question',function($model)
            {
                return $model->question;
            })
            ->addColumn('description',function($model)
            {
                if ($model->description != null)
                    return "<a href='#' onclick='showDescription(".$model->id."); return false;' style='text-decoration: none'>Show Description..</a>";
                else
                    return "<i>NULL</i>";
            })
            ->addColumn('answer',function($model)
            {
                return "<a href='#' onclick='showAnswer(".$model->id."); return false;' style='text-decoration: none'>Show Answer..</a>";
            })
            ->make();
    }

//DataTables for Resources and Media (Writing)
    public function getResourceWritingDatatable()
    {
        return Datatable::query(Auth::user()->getResources())
            ->showColumns('title')
            ->searchColumns('title')
            ->orderColumns('title')
            ->addColumn('created_at',function($model)
            {
                return $model->created_at;
            })
            ->addColumn('use',function($model)
            {
                return "<button class='btn btn-primary' onclick='useResource(".$model->id.",\"".$model->title."\")'>Add</button>";
            })
            ->make();
    }

    public function getMediaWritingDatatable()
    {
        return Datatable::query(Auth::user()->getMedia())
            ->searchColumns('title')
            ->orderColumns('title')
            ->addColumn('title',function($model)
            {
                return $model->title;
            })
            ->addColumn('created_at',function($model)
            {
                return $model->created_at;
            })
            ->addColumn('use',function($model)
            {
                return "<button class='btn btn-primary' onclick='useMedia(\"".$model->path."\",\"".$model->title."\")'>Use</button>";
            })
            ->make();
    }

    /*//Events Datatables
    public function getHostedEvents()
    {
        return Datatable::query(Auth::user()->getHostedEvents())
            ->searchColumns('name','venue')
            ->orderColumns('name')
            ->addColumn('name',function($model)
            {
                return "<a href='http://b2.com/event/".$model->id."'>".$model->name."</a>";
            })
            ->addColumn('venue',function($model)
            {
                return $model->venue;
            })
            ->addColumn('actions',function($model)
            {
                if ($model->open)
                    return "<button class='btn btn-primary' onclick='updateEvent(".$model->id.")'>Update</button> <button class='btn btn-info' onclick='toggleQuiz(".$model->id.")'>Close</button> <button class='btn btn-success' onclick='viewGuestList(".$model->id.")'>Show Guest-List</button> <button class='btn btn-danger' onclick='deleteEvent(".$model->id.")'>Delete</button>";
                else
                    return "<button class='btn btn-primary' onclick='updateEvent(".$model->id.")'>Update</button> <button class='btn btn-info' onclick='toggleQuiz(".$model->id.")'>Open</button> <button class='btn btn-success' onclick='viewGuestList(".$model->id.")'>Show Guest-List</button> <button class='btn btn-danger' onclick='deleteEvent(".$model->id.")'>Delete</button>";
            })
            ->make();
    }

    public function getRegisteredEvents()
    {
        return Datatable::query(Auth::user()->getAttendedEvents())
            ->searchColumns('name','venue')
            ->orderColumns('name')
            ->addColumn('name',function($model)
            {
                return "<a href='http://b2.com/event/".$model->id."'>".$model->name."</a>";
            })
            ->addColumn('venue',function($model)
            {
                return $model->venue;
            })
            ->addColumn('actions',function($model)
            {
                    return "<button class='btn btn-danger' onclick='quitEvent(".$model->id.")'>Cancel Registration</button>";
            })
            ->make();
    }*/

    public function getIFCManagerData()
    {
        $transactions = Auth::user()->getTransactions()->orderBy('updated_at','DESC')->get();
        return Datatable::collection($transactions)
            ->searchColumns('narration')
            ->addColumn('datetime',function($model)
            {
                $dates=$model->created_at->format('M-d-Y');
                return $dates;
            })
            ->addColumn('narration',function($model)
            {
                if($model->type=='profile')
                    return $model->message.' <a href="'.$model->link.'"> '.$model->linkname.'</a>';
                elseif ($model->type=='content')
                    return '<p> '.$model->message.' <a href="'.$model->link.'"> '.$model->linkname.'</a></p>';
                else
                    return '<p> '.$model->message.'</p>';
            })
            ->addColumn('amount',function($model)
            {
                return $model->ifc;
            })
            ->make();
    }
}
