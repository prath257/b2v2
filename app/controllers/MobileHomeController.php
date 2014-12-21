<?php

class MobileHomeController extends \BaseController {


    public function getActionData()
    {

        try
        {
            $no = Input::get('no');
            $actions=DB::table('actions')->orderBy('created_at','DESC')->skip($no)->take(30)->get();

            $content = new \Illuminate\Database\Eloquent\Collection();
            $author = new \Illuminate\Database\Eloquent\Collection();
            $pic = new \Illuminate\Database\Eloquent\Collection();

            foreach($actions as $action)
            {
                if($action->type == 'A new')
                    $content->add(DB::table('articles')->where('id','=',$action->contentid)->first());

                elseif($action->type == 'BB new')
                    $content->add(DB::table('blogbooks')->where('id','=',$action->contentid)->first());

                elseif($action->type == 'BB new chapter')
                    $content->add( DB::table('blogbooks')->where('id','=',$action->contentid)->first());

                elseif($action->type == 'E new')
                    $content->add( DB::table('events')->where('id','=',$action->contentid)->first());

                elseif($action->type == 'M new')
                    $content->add( DB::table('media')->where('id','=',$action->contentid)->first());

                elseif($action->type == 'R new')
                    $content->add( DB::table('resources')->where('id','=',$action->contentid)->first());

                elseif($action->type == 'C new'||$action->type=='C req'||$action->type=='C new chapter')
                    $content->add( DB::table('collaborations')->where('id','=',$action->contentid)->first());

                elseif($action->type == 'Diary new')
                    $content->add(DB::table('diary')->where('userid','=',$action->user1id)->first());

                elseif($action->type == 'Recco new')
                    $content->add(DB::table('recco')->where('id','=',$action->contentid)->first());

                elseif($action->type == 'P new')
                    $content->add(DB::table('polls')->where('id','=',$action->contentid)->first());

                elseif($action->type == 'Q new')
                    $content->add(DB::table('quiz')->where('id','=',$action->contentid)->first());

                elseif($action->type == 'Q score')
                    $content->add(DB::table('quiz')->where('id','=',$action->contentid)->first());

                else if($action->type== 'newMatchRating')
                     $content->add($action);
                else if($action->type == 'newFeed')
                    $content->add($action);

                $author->add( DB::table('users')->where('id','=',$action->user1id)->first());
                $pic->add (User::find($action->user1id)->profile->profilePic);

            }

            $result = array('ok'=>'true','pic'=>$pic->toJson(),'content'=>$content->toJson(),'action'=>$actions,'author'=>$author->toJson());

            return json_encode($result);

        }
        catch(Exception $e)
        {
            $result=array('ok'=>$e);
            return json_encode($result);
        }

    }

    public function getNotification()
    {


        try
        {

            $number=Input::get('no');

            $sendNotifications = DB::table('notification')->where('userid','=',Input::get('id'))->orderBy('created_at','DESC')->skip($number)->take(20)->get();



//         DB::table('notification')->where('userid','=',Input::get('id'))->where('checked','=',false)->update(array('checked' =>true));


            $picUrl = new \Illuminate\Database\Eloquent\Collection();
            $name = new \Illuminate\Database\Eloquent\Collection();


            foreach($sendNotifications as $notification)
            {
                $user=User::find($notification->cuserid);
                // $user=DB::table('users')->where('id','=',$notification->cuserid);
                $picUrl->add ($user->profile->profilePic);
                $name->add($user->first_name." ".$user->last_name);

            }


            if(count($sendNotifications)!=0)
            {
                $data = array('ok'=>'true',
                    'number'=>count($sendNotifications),
                    'data'=>json_encode($sendNotifications),
                    'pic_url'=>$picUrl->toJson(),
                    'names'=>$name->toJson()
                );

                return json_encode($data);
            }
            else
            {
                $data = array('number'=>0,'ok'=>'true');
                return json_encode($data);
            }
        }
        catch(Exception $e)
        {
            $data = array('ok'=>$e);
            return json_encode($data);
        }

    }







}