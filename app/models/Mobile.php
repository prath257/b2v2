<?php
/**
 * Created by PhpStorm.
 * User: Utkarsh
 * Date: 11/17/14
 * Time: 4:43 PM
 */

class Mobile extends Eloquent{


    public static function getContent($id,$type)
    {
        if($type == 'blogbook')
        {
            $content = BlogBook::find($id);

        }
        else if($type == 'article')
        {
            $content = Article::find($id);
        }
        else if($type == 'collaboration')
        {
            $content = Collaboration::find($id);

        }

        else if($type == 'media')
        {
            $content = Media::find($id);

        }
        else if($type == 'quiz')
        {
            $content = Quiz::find($id);

        }

        else if($type == 'event')
        {
            $content = BEvent::find($id);
        }

        else if($type == 'resource')
        {
            $content = Resource::find($id);
        }

        else if($type == 'poll')
        {
            $content = Poll::find($id);
        }

        else if($type == 'recco')
        {
            $content = Recco::find($id);
        }

        else if($type == 'diary')
        {
            $content = Diary::find($id);
        }

        else if($type == 'notification')
        {
            $content = Notification::find($id);
        }

        return $content;
    }

} 