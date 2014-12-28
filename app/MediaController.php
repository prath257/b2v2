<?php

class MediaController extends \BaseController
{
    public static $email = null;

	public function uploadMedia()
	{
        if(Auth::check())
        {
		//This is the time to create a user profile
		$media=new Media();
		$media->userid=Auth::user()->id;
		//This is the code for storing the profile Tune
		//$name = Input::file('userMedia')->getClientOriginalName();
		$extension=Input::get('ext');
		$fname=Str::words(Input::get('mediaTitle'),1,'');
		$dt=new DateTime();
		$stamp=$dt->getTimestamp();
		$name=$stamp.$fname.'.'.$extension;
		$username=Auth::user()->username;
		Input::file('userMedia')->move('Users/'.$username.'/Media/', $name);
		//Set the path in database, allocate IFCs
		$filePath='http://b2.com/Users/'.$username.'/Media/'.$name;
		$media->path=$filePath;
		$media->title=Input::get('mediaTitle');
		$media->type=$extension;
        $media->ispublic = false;
        $media->category = 1;
		$media->save();

        if (Input::get('origin') == 'media')
		    return 'success';
        else
            return $filePath;
	}
        else
            return 'wH@tS!nTheB0x';
    }
    public function uploadPublicMedia()
    {
        if(Auth::check())
        {
        //This is the time to create a user profile
        $media=new Media();
        $media->userid=Auth::user()->id;
        //This is the code for storing the profile Tune
        //$name = Input::file('userMedia')->getClientOriginalName();
        $extension=Input::get('ext');
        $fname=Str::words(Input::get('title'),1,'');
        $dt=new DateTime();
        $stamp=$dt->getTimestamp();
        $name=$stamp.$fname.'.'.$extension;
        $username=Auth::user()->username;
        Input::file('media')->move('Users/'.$username.'/Media/', $name);
        //Set the path in database, allocate IFCs
        $filePath='http://b2.com/Users/'.$username.'/Media/'.$name;
        $media->path=$filePath;
        $media->title=Input::get('title');
        $media->type=$extension;
        $media->trivia = Input::get('description');
        $media->category = Input::get('category');
        $media->ifc = Input::get('ifc');
        $media->ispublic = true;
        $media->save();

        Action::postAction('M new',Auth::user()->id,null,$media->id);
        $subscribers = DB::table('subscriptions')->where('subscribed_to_id','=',Auth::user()->id)->lists('subscriber_id');
        foreach($subscribers as $s)
        {
            MediaController::$email=User::find($s)->email;
            Mail::send('mailers',array('user' => User::find($s),'content' => $media,'type' => 'M','writer' => Auth::user(),'page'=>'readerMailer'),function($message)
            {
                $message->to(MediaController::$email)->subject('New Media Upload');
            });
        }

        //Saving the media cover
        $cover = Input::file('cover');
            if ($cover != null)
            {
                $random_name = str_random(8);
                $destinationPath = "Users/".Auth::user()->username."/Media/";
                $extension = $cover->getClientOriginalExtension();
                $filename=$media->id.'_'.$random_name.'.'.$extension;
                Image::make(Input::file('cover'))->resize(500, 500)->save($destinationPath.$filename);
                $media->cover = $destinationPath.$filename;
                $media->save();
            }




        return 'success';
    }
        else
            return 'wH@tS!nTheB0x';
    }

	public function getMedia()
	{

		return View::make('media');
	}

    public function newPublicMedia()
    {
        $interests = Auth::user()->interestedIn()->get();
        return View::make('newPublicMedia')->with('categories',$interests);
    }

	public  function deleteMedia()
	{
        if(Auth::check())
        {
		$id=Input::get('id');
		$media=Media::find($id);
		File::delete(substr($media->path,14));
		$media->delete();
        Action::delAction(Input::get('id'));
	}
        else
            return 'wH@tS!nTheB0x';
    }

    public function getMediaDetails()
    {
        if(Auth::check())
        {
        $media = Media::find(Input::get('id'));
        $categories = Auth::user()->interestedIn()->get();
        return View::make('editMedia')->with('media',$media)->with('categories',$categories);
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function editPublicMedia()
    {
        if(Auth::check())
        {
        $media = Media::find(Input::get('id'));
        $media->title = Input::get('title');
        $media->trivia = Input::get('description');
        $media->category = Input::get('category');
        $media->ifc = Input::get('ifc');

        if ($cover = Input::file('cover'))
        {
            $random_name = str_random(8);
            $destinationPath = "Users/".Auth::user()->username."/Media/";
            $extension = $cover->getClientOriginalExtension();
            $filename=$media->id.'_'.$random_name.'.'.$extension;
            Input::file('cover')->move($destinationPath, $filename);
            $media->cover = $destinationPath.$filename;
        }

        $media->save();
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getMediaPreview($id)
    {
        $book = Media::find($id);
        if ($book->ispublic)
        {
            $owner = $book->getAuthor;
            $fullname = $owner->first_name.' '.$owner->last_name;

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

            return View::make('mediaPreview')->with('media',$book)->with('author',$fullname)->with('content',$content);
        }
    }

    public function getMediaDummy($id)
    {
        $book = Media::find($id);
        if ($book->ispublic)
        {
            $owner = $book->getAuthor;
            $fullname = $owner->first_name.' '.$owner->last_name;

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

            return View::make('mediaPreview')->with('media',$book)->with('author',$fullname)->with('content',$content);
        }
    }


    public function viewMedia()
    {
        if(Auth::check())
        {
            $media = Media::find(Input::get('id'));
            $ifc = $media->ifc;
            $owner = User::find($media->userid);
            if (Friend::isFriend($owner->id) && $owner->settings->freeforfriends)
                return 'http://b2.com/playMedia/'.Crypt::encrypt($media->id);

            if(Friend::isSubscriber($owner->id) && $owner->settings->discountforfollowers > 0)
            {
                $discount = ($ifc*$owner->settings->discountforfollowers)/100;
                $ifc = $ifc-$discount;
            }

            Auth::user()->profile->ifc -= $ifc;
            Auth::user()->profile->save();

            User::find($media->userid)->profile->ifc += $ifc;
            User::find($media->userid)->profile->save();

            Auth::user()->viewedMedia()->attach($media->id);
            $media->users ++;
            $media->save();

            AjaxController::insertToNotification($media->getAuthor->id,Auth::user()->id,"purchased","purchased your media ".$media->title,'http://b2.com/mediaPreview/'.$media->id);

            TransactionController::insertToManager(Auth::user()->id,"-".$ifc,"Bought media",'http://b2.com/mediaPreview/'.$media->id,$media->title,"content");
            TransactionController::insertToManager(User::find($media->userid)->id,"+".$ifc,"Sold media '".$media->title."' to",'http://b2.com/user/'.Auth::user()->username, Auth::user()->first_name.' '.Auth::user()->last_name,"profile");

            return 'http://b2.com/playMedia/'.Crypt::encrypt($media->id);
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function playMedia($id)
    {
        $id = Crypt::decrypt($id);
        $media = Media::find($id);

        if ($media->isViewer() || $media->getAuthor->id == Auth::user()->id)
            return View::make('playMedia')->with('media',$media);
        else
        {
            $ifc = $media->ifc;
            $owner = User::find($media->userid);
            if (Friend::isFriend($owner->id) && $owner->settings->freeforfriends)
                return View::make('playMedia')->with('media',$media);

            if(Friend::isSubscriber($owner->id) && $owner->settings->discountforfollowers > 0)
            {
                $discount = ($ifc*$owner->settings->discountforfollowers)/100;
                $ifc = $ifc-$discount;
            }

            $uifc = Auth::user()->profile->ifc;
            if ($uifc < $ifc)
            {
                return View::make('ifcDeficit')->with('contentIFC',$ifc)->with('userIFC',Auth::user()->profile->ifc);
            }
            else
            {
                Auth::user()->profile->ifc -= $ifc;
                Auth::user()->profile->save();

                User::find($media->userid)->profile->ifc += $ifc;
                User::find($media->userid)->profile->save();

                Auth::user()->viewedMedia()->attach($media->id);
                $media->users ++;
                $media->save();

                AjaxController::insertToNotification($media->getAuthor->id,Auth::user()->id,"purchased","purchased your media ".$media->title,'http://b2.com/mediaPreview/'.$media->id);

                TransactionController::insertToManager(Auth::user()->id,"-".$ifc,"Bought media",'http://b2.com/mediaPreview/'.$media->id,$media->title,"content");
                TransactionController::insertToManager(User::find($media->userid)->id,"+".$ifc,"Sold media '".$media->title."' to",'http://b2.com/user/'.Auth::user()->username, Auth::user()->first_name.' '.Auth::user()->last_name,"profile");

                return View::make('playMedia')->with('media',$media);
            }

        }
    }
}
