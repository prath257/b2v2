<?php

class BlogController extends \BaseController
{
    public static $email=null;
	public function postArticle()
    {
        if(Auth::check())
        {
            $article = new Article();
            $article->title = Input::get('title');
            /*$article->cover = Input::get('cover');*/
            $article->description = Input::get('description');
            $article->text = Input::get('content');
            $article->ifc = Input::get('ifc');
            $article->userid = Auth::user()->id;
            $article->category = Input::get('category');
            $article->type = Input::get('type');
            $article->review = Input::get('review');
            $article->save();

            if (Input::get('cPic') == 'yes')
            {
                $directory = File::makeDirectory('Users/'.Auth::user()->username."/Articles/".$article->id);
                if ($directory)
                {
                    File::move("Users/".Auth::user()->username."/Articles/Cover.".Input::get('extension'),'Users/'.Auth::user()->username."/Articles/".$article->id."/Cover.".Input::get('extension'));
                    $article->cover = 'Users/'.Auth::user()->username."/Articles/".$article->id.'/Cover.'.Input::get('extension');
                    $article->save();
                }
            }


            if ($article->review == "toreview")
            {
                $review = new Review();
                $review->type = 'article';
                $review->contentid = $article->id;
                $review->save();

                Mail::send('mailers', array('user'=>Auth::user(), 'review'=>$review, 'content'=>$article,'page'=>'newSubmissionRequest'), function($message)
                {
                    $message->to('ksjoshi88@gmail.com')->subject('New Review Request!');
                });
            }
            Action::postAction('A new',Auth::user()->id,null,$article->id);
            $subscribers = DB::table('subscriptions')->where('subscribed_to_id','=',Auth::user()->id)->lists('subscriber_id');
            foreach($subscribers as $s)
            {
                BlogController::$email=User::find($s)->email;
                Mail::send('mailers',array('user' => User::find($s),'content' => $article,'type' => 'A','writer' => Auth::user(),'page'=>'readerMailer'),function($message)
                {
                    $message->to(BlogController::$email)->subject('New Article');
                });
            }
            return "success";
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getDashboard()
	{
		$categories=Auth::user()->interestedIn()->get();
		return View::make('articleDashboard')->with('categories',$categories);
	}

	public function getArticle($articleId)
	{
		$article = Article::find($articleId);
                $newUser='false';
		if($article->userid!=Auth::user()->id)
		{
			if($article->isReader()==false)
			{
                $ifc = $article->ifc;
                $owner = User::find($article->userid);
                if (Friend::isFriend($owner->id) && $owner->settings->freeforfriends)
                    return View::make('readArticle')->with('article',$article)->with('newUser',$newUser);

                if(Friend::isSubscriber($owner->id) && $owner->settings->discountforfollowers > 0)
                {
                    $discount = ($ifc*$owner->settings->discountforfollowers)/100;
                    $ifc = $ifc-$discount;
                }

                if (Auth::user()->profile->ifc >= $ifc)
                {
                    Auth::user()->profile->ifc-=$ifc;
                    Auth::user()->profile->save();
                    $article->getAuthor->profile->ifc+=$ifc;
                    $article->getAuthor->profile->save();
                    Auth::user()->readArticles()->attach($article->id);
                    $article->users ++;
                    $article->save();
                    $newUser = 'true';

                    TransactionController::insertToManager(Auth::user()->id,"-".$ifc,"Bought article:",'http://b2.com/articlePreview/'.$article->id,$article->title,"content");

                    TransactionController::insertToManager($article->getAuthor->id,"+".$ifc,"Sold article '".$article->title."' to",'http://b2.com/user/'.Auth::user()->username,Auth::user()->first_name." ".Auth::user()->last_name,"profile");

                    AjaxController::insertToNotification($article->getAuthor->id,Auth::user()->id,"purchased","purchased your article ".$article->title,'http://b2.com/articlePreview/'.$article->id);
                }
                else
                {
                    return View::make('ifcDeficit')->with('contentIFC',$ifc)->with('userIFC',Auth::user()->profile->ifc);
                }
			}

		}
		return View::make('readArticle')->with('article',$article)->with('newUser',$newUser);
	}

    public function getArticlePreview($articleId)
    {
        $book = Article::find($articleId);
        $owner = $book->getAuthor->first_name.' '.$book->getAuthor->last_name;

        $articles = Article::where('category','=',$book->category)->orderBy('users','DESC')->get();
        $blogBooks = BlogBook::where('category','=',$book->category)->orderBy('users','DESC')->get();
        $collaborations = Collaboration::where('category','=',$book->category)->orderBy('users','DESC')->get();


        $content = $articles->merge($blogBooks);
        $content = $content->merge($collaborations);

        $content = $content->sortByDesc('users')->take(6);

        if (count($content) < 6)
        {
            $articles = $owner->getArticles()->orderBy('users','DESC')->get();
            $blogBooks = $owner->getBlogBooks()->orderBy('users','DESC')->get();
            $collaborations = $owner->getOwnedCollaborations()->orderBy('users','DESC')->get();
            $contributions = $owner->getContributions()->orderBy('users','DESC')->get();

            $content = $content->merge($articles);
            $content = $content->merge($blogBooks);
            $content = $content->merge($collaborations);
            $content = $content->merge($contributions);

            $content = $content->sortByDesc('users')->take(6);

            if (count($content) < 6)
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

                $content = $content->sortByDesc('users')->take(6);
            }
        }

        return View::make('articlePreview')->with('article',$book)->with('author',$owner)->with('content',$content);
    }

    public function getArticlePreviewIframe($articleId)
    {
        $article = Article::find($articleId);
        return View::make('articlePreviewIframe')->with('article',$article);
    }

	public function deleteArticle($id)
	{
        if(Auth::check())
        {
		$article = Article::find($id);
        File::deleteDirectory('Users/'.Auth::user()->username.'/Articles/'.$article->id);
		$article->delete();
        Action::delAction($id);
        Review::where('type','=','article')->where('contentid','=',$id)->delete();
	}
        else
            return 'wH@tS!nTheB0x';
    }

	public function getEditArticle($articleId)
	{
		$article = Article::find($articleId);
        if ($article->userid == Auth::user()->id)
        {
            $categories=Auth::user()->interestedIn()->get();
            $medias=Auth::user()->getMedia()->orderBy('updated_at','DESC')->paginate(5);
            $resources=Auth::user()->getResources()->orderBy('updated_at','DESC')->paginate(5);
            return View::make('editArticle')->with('categories',$categories)->with('article',$article)->with('medias',$medias)->with('resources',$resources);
        }
        else
            return "Sorry, you don't have access to this page";

	}

	public function editArticle()
	{
        if(Auth::check())
        {
		$article = Article::find(Input::get('id'));
		$article->title = Input::get('title');
		$article->text = Input::get('content');
		$article->ifc = Input::get('ifc');
        $article->description = Input::get('description');
		$article->userid = Auth::user()->id;
		$article->category = Input::get('category');
		$article->save();
		return "success";
	}
        else
            return 'wH@tS!nTheB0x';
    }

	public function postArticleDashboard()
	{
		$title = Input::get('title');
        $description = Input::get('shortDescription');
		$category = Input::get('Artcategory');
        $type = Input::get('articleType');
		$ifc = Input::get('ifc');

        $cPic = 'no';
        $extension = 'nothing';
        $cover = Input::file('uploadArtCover');
        if ($cover != null)
        {
            $destinationPath = "Users/".Auth::user()->username."/Articles/";
            $extension = $cover->getClientOriginalExtension();
            $filename='Cover.'.$extension;
            //Input::file('uploadCover')->move($destinationPath, $filename);
            Image::make(Input::file('uploadArtCover'))->resize(500, 500)->save($destinationPath.$filename);
            $cPic = 'yes';
        }

		$medias=Auth::user()->getMedia()->orderBy('updated_at','DESC')->paginate(5);
        $resources=Auth::user()->getResources()->orderBy('updated_at','DESC')->paginate(5);

		$data=array('title'=>$title,'extension'=>$extension,'description'=>$description,'category'=>$category,'ifc'=>$ifc,'medias'=>$medias,'resources'=>$resources,'type'=>$type,'cPic'=>$cPic);
        return View::make('article',$data);
	}

    public function getTypes()
    {
        if(Auth::check())
        {
            return View::make('templateOptions')->with('interest',Input::get('interestName'))->with('device',Input::get('device'));
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getArticleTemplate()
    {
        if(Auth::check())
        {
        $type = Input::get('type');
        $count = Input::get('count');
        return View::make('articleTemplates')->with('type',$type)->with('count',$count);
    }
        else
            return 'wH@tS!nTheB0x';
    }
}