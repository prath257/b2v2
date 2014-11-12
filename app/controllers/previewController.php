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
        $row=Resource::find($id);
        $ia=$row->userid;
        $author=User::find($ia)->first_name.' '.User::find($ia)->last_name;
        return View::make('resource')->with('book',$row)->with('author',$author);
    }

    public function getBlogBookPreview($id)
    {
        $type='blogBook';
        $response = previewController::showPreview($type,$id);
        return $response;
    }

    public function getQuizPreview($id)
    {
        $type='quiz';
        $response = previewController::showPreview($type,$id);
        return $response;
    }

    public function showPreview($type,$id)
    {
        if($type=='blogBook')
        {
            $row=BlogBook::find($id);
        }
        else if($type=='article')
        {
            $row=Article::find($id);
        }
        else if($type=='quiz')
        {
            $row=Quiz::find($id);
        }
        else if($type=='collaboration')
        {
            $row=Collaboration::find($id);
        }
        else if($type=='resource')
        {
            $row=Resource::find($id);
        }

        if($type=='quiz')
            $ia=$row->ownerid;
        else
            $ia=$row->userid;

        $author=User::find($ia)->first_name.' '.User::find($ia)->last_name;

        if($type != 'resource')
            $ext = 'Preview';
        else
            $ext = '';

        return View::make($type.$ext)->with('book',$row)->with('author',$author);

    }
} 