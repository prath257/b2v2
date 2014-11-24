<?php

class BookController extends \BaseController
{
    public static $email=null;

    public function getBlogBookDashboard()
    {
        $blogBooks=Auth::user()->getBlogBooks()->orderBy('updated_at','DESC')->paginate(5);
        $categories=Auth::user()->interestedIn()->get();
        return View::make('blogBookDashboard')->with('blogBooks',$blogBooks)->with('categories',$categories);
    }

    public function postBlogBookDashboard()
    {
        $blogBook = new BlogBook();
        $blogBook->title = Input::get('title');
        $blogBook->description = Input::get('shortDescription');
        $blogBook->category = Input::get('category');
        $blogBook->ifc = Input::get('ifc');
        $blogBook->userid = Auth::user()->id;
        $blogBook->review = 'passed';
        $blogBook->save();

        $cover = Input::file('uploadBBCover');
        if ($cover != null)
        {
            $directory = File::makeDirectory('Users/'.Auth::user()->username."/Books/".$blogBook->id);
            if ($directory)
            {
                $coverDirectory = File::makeDirectory('Users/'.Auth::user()->username."/Books/".$blogBook->id."/Cover");
            }
            $random_name = str_random(8);
            $destinationPath = "Users/".Auth::user()->username."/Books/".$blogBook->id."/Cover/";
            $extension = $cover->getClientOriginalExtension();
            $filename=$random_name.'.'.$extension;
            //Input::file('uploadCover')->move($destinationPath, $filename);
            Image::make(Input::file('uploadBBCover'))->resize(500, 500)->save($destinationPath.$filename);
            $blogBook->cover = $destinationPath.$filename;
            $blogBook->save();
        }



        Action::postAction('BB new',Auth::user()->id,null,$blogBook->id);
        $subscribers = DB::table('subscriptions')->where('subscribed_to_id','=',Auth::user()->id)->lists('subscriber_id');
        foreach($subscribers as $s)
        {
            BookController::$email=User::find($s)->email;
            Mail::send('mailers',array('user' => User::find($s),'content' => $blogBook,'type' => 'B new','writer' => Auth::user(),'page'=>'readerMailer'),function($message)
            {
                $message->to(BookController::$email)->subject('New Blogbook');
            });
        }

        return Redirect::route('newChapter',$blogBook->id);
    }

    public function getNewChapter($blogBookId)
    {
        $blogBook = BlogBook::find($blogBookId);
        if ($blogBook->userid == Auth::user()->id)
        {
            $medias=Auth::user()->getMedia()->orderBy('updated_at','DESC')->paginate(5);
            $resources=Auth::user()->getResources()->orderBy('updated_at','DESC')->paginate(5);
            return View::make('newChapter')->with('blogBook',$blogBook)->with('medias',$medias)->with('resources',$resources);
        }
        else
            return View::make('notSoSmart');
    }

    public function postChapter()
    {
        if(Auth::check())
        {
        $chapter = new Chapter();
        $chapter->title = Input::get('title');
        $chapter->text = Input::get('content');
        $chapter->bookid = Input::get('bookid');
        $chapter->save();

        $date = new DateTime();

        $blogBook = BlogBook::find(Input::get('bookid'));
        $blogBook->chapters += 1;
        $blogBook->updated_at = $date;
        $blogBook->save();

        Action::postAction('BB new chapter',Auth::user()->id,null,$blogBook->id);

        $readers=DB::table('bookreaders')->where('blog_book_id','=',$blogBook->id)->get();
        foreach($readers as $reader)
        {
            $user=User::find($reader->user_id);
            BookController::$email=$user->email;
            /*$data=array('user'=>$user,'content' => $blogBook,'type' => 'B','writer' => Auth::user());*/
            Mail::send('mailers',array('user'=>$user,'content' => $blogBook,'type' => 'B','writer' => Auth::user(),'page'=>'readerMailer'),function($message)
            {
                $message->to(BookController::$email)->subject('New Chapter');
            });
        }

        return "success";
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getBlogBook($bid)
    {
        $book=BlogBook::find($bid);
        $newUser=false;
        $owner = User::find($book->userid);

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

        if($book->userid!=Auth::user()->id)
        {
            if($book->isReader()==false)
            {
                $ifc = $book->ifc;

                if (Friend::isFriend($owner->id) && $owner->settings->freeforfriends)
                {
                    $chapters=$book->getChapters()->get();
                    return View::make('readBlogbook')->with('book',$book)->with('chapters',$chapters)->with('newUser',$newUser)->with('content',$content);
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
                    $book->getAuthor->profile->ifc+=$ifc;
                    $book->getAuthor->profile->save();
                    Auth::user()->readBooks()->attach($book->id);
                    $book->users ++;
                    $book->save();
                    $newUser=true;

                    TransactionController::insertToManager(Auth::user()->id,"-".$ifc,"Bought blogBook:",'http://b2.com/blogBookPreview/'.$book->id,$book->title,"content");

                    TransactionController::insertToManager($book->getAuthor->id,"+".$ifc,"Sold the Blogbook '".$book->title."' to",'http://b2.com/user/'.Auth::user()->username,Auth::user()->first_name.' '.Auth::user()->last_name,"profile");

                    AjaxController::insertToNotification($book->getAuthor->id,Auth::user()->id,"purchased","purchased your blogBook ".$book->title,'http://b2.com/blogBookPreview/'.$book->id);
                }
                else
                {
                    return View::make('ifcDeficit')->with('contentIFC',$ifc)->with('userIFC',Auth::user()->profile->ifc);
                }
            }
        }
        $chapters=$book->getChapters()->get();
        return View::make('readBlogbook')->with('book',$book)->with('chapters',$chapters)->with('newUser',$newUser)->with('content',$content);

    }

    public function getBlogBookPreview($bid)
    {
        $book=BlogBook::find($bid);
        $chapters=$book->getChapters()->get();
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

        return View::make('blogBookPreview')->with('book',$book)->with('chapters',$chapters)->with('author',$owner)->with('content',$content);
    }

    public function deleteBlogBook()
    {
        if(Auth::check())
        {
        $blogBook = BlogBook::find(Input::get('id'));
        File::deleteDirectory('Users/'.Auth::user()->username.'/Books/'.$blogBook->id);
        Action::delAction($blogBook->id);
        $blogBook->delete();
        Review::where('type','=','book')->where('contentid','=',Input::get('id'))->delete();

    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getEditBlogBook($blogBookId)
    {
        if(Auth::check())
        {
        $blogBook = BlogBook::find($blogBookId);
            if ($blogBook->userid == Auth::user()->id)
            {
                $categories=Auth::user()->interestedIn()->get();
                return View::make('editBlogBook')->with('blogBook',$blogBook)->with('categories',$categories);
            }
            else
                return "Sorry, you don't have access to this page";
        }
        else
            return 'wH@tS!nTheB0x';
    }
    public function postEditBlogBook()
    {
        if(Auth::check())
        {
        $blogBook = BlogBook::find(Input::get('id'));
        $blogBook->title = Input::get('title');
        $blogBook->description = Input::get('description');
        $blogBook->category = Input::get('category');
        $blogBook->ifc = Input::get('ifc');
        $blogBook->save();

        if ($cover = Input::file('cover'))
        {
            $random_name = str_random(8);
            $destinationPath = "Users/".Auth::user()->username."/Books/".$blogBook->id."/Cover/";
            $extension = $cover->getClientOriginalExtension();
            $filename=$random_name.'.'.$extension;
            Input::file('cover')->move($destinationPath, $filename);
            $blogBook->cover = $destinationPath.$filename;
            $blogBook->save();
        }
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function deleteChapter()
    {
        if(Auth::check())
        {
        $chapter = Chapter::find(Input::get('id'));
        $blogBook = $chapter->writtenIn;
        $blogBook->chapters -= 1;
        $blogBook->save();
        $chapter->delete();
    }
        else
            return 'wH@tS!nTheB0x';
    }
    public function getEditChapter($chapterId)
    {
        $chapter = Chapter::find($chapterId);
        $blogBook = $chapter->writtenIn;
        $medias=Auth::user()->getMedia()->orderBy('updated_at','DESC')->paginate(5);
        $resources=Auth::user()->getResources()->orderBy('updated_at','DESC')->paginate(5);
        return View::make('editChapter')->with('chapter',$chapter)->with('blogBook',$blogBook)->with('medias',$medias)->with('resources',$resources);
    }

    public function postUpdateChapter()
    {
        if(Auth::check())
        {
        $chapter = Chapter::find(Input::get('id'));
        $chapter->title = Input::get('title');
        $chapter->text = Input::get('content');
        $chapter->save();
        $date = new DateTime();
        $blogBook = $chapter->writtenIn;
        $blogBook->updated_at = $date;
        $blogBook->save();
		return "success";
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getPreviewBlogBook($bid)
    {
        $book=BlogBook::find($bid);
        $chapters=$book->getChapters()->get();
        return View::make('previewBlogBook')->with('book',$book)->with('chapters',$chapters);
    }

    public function getBlogbookContent()
    {
        if(Auth::check())
        {
        $cid=intval(Input::get('id'));
        if($cid==-1)
        {
            $bookId=intval(Input::get('bid'));
            $book = BlogBook::find($bookId);
            return View::make('bookFront')->with('book',$book);
        }
        else
        {
         $chapter=Chapter::find(Input::get('id'));
            if($chapter==null)
                return "wH@tS!nTheB0x";
            else
                return  $chapter->text;
        }
    }
        else
            return 'wH@tS!nTheB0x';
    }
    public function getBookChapterList()
    {
        if(Auth::check())
        {
        $chapterNos=array();
        $bookId=intval(Input::get('bid'));
        $book = BlogBook::find($bookId);
        $chapters=$book->getChapters()->get();
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
}
