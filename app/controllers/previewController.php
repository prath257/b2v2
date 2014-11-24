<?php
/**
 * Created by PhpStorm.
 * User: sasuke
 * Date: 9/18/2014
 * Time: 5:15 PM
 */

class previewController extends \BaseController
{

    public function getCollaborationPreview($id)
    {
        $type='collaboration';
        $response = previewController::showPreview($type,$id);
        return $response;
    }

    public function getArticlePreview($id)
    {
        $type='article';
        $response = previewController::showPreview($type,$id);
        return $response;
    }

    public function getResourcePreview($id)
    {
        $type='resource';
        $response = previewController::showPreview($type,$id);
        return $response;
    }

    public function getResourceDummyPreview($id)
    {
        $book=Resource::find($id);
        $ia=$book->userid;
        $owner=User::find($ia);
        $fullname=$owner->first_name.' '.$owner->last_name;

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

        return View::make('resource')->with('book',$book)->with('author',$fullname)->with('content',$content);
    }

    public function getBlogBookPreview($id)
    {
        $type='blogBook';
        $response = previewController::showPreview($type,$id);
        return $response;
    }

    public function getQuizPreview($id,$uid=null)
    {
        $type='quiz';
        $response = previewController::showPreview($type,$id,$uid);
        return $response;
    }

    public function showPreview($type,$id,$uid=null)
    {
        $score=null;
        if($type=='blogBook')
        {
            $book=BlogBook::find($id);
        }
        else if($type=='article')
        {
            $book=Article::find($id);
        }
        else if($type=='quiz')
        {
            $book=Quiz::find($id);
            if($uid!=null)
            {
                $score=DB::table('quiztakers')->where('quiz_id','=',$id)->where('user_id','=',$uid)->first();

            }
        }
        else if($type=='collaboration')
        {
            $book=Collaboration::find($id);
        }
        else if($type=='resource')
        {
            $book=Resource::find($id);
        }

        if($type=='quiz')
            $ia=$book->ownerid;
        else
            $ia=$book->userid;

        $owner=User::find($ia);
        $fullname=$owner->first_name.' '.$owner->last_name;

        if($type != 'resource')
            $ext = 'Preview';
        else
            $ext = '';

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

         return View::make($type.$ext)->with('book',$book)->with('author',$fullname)->with('content',$content)->with('score',$score);


    }
} 