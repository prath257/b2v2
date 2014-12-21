<?php

class MobileDiaryController extends \BaseController {

	public function getDates()
    {
        try
        {
        $userid = Input::get('userid');
        $authid = Input::get('authid');
        $user = User::find($userid);
        $auth = User::find($authid);
        $flag = 0;
        $dates = new \Illuminate\Database\Eloquent\Collection();
        if($user->settings->diaryAccess !='public')
        {
            if($user->settings->diaryAccess == 'semi')
            {
                $susers = Diaryshare::where('duserid',$userid)->get();
                foreach($susers as $suser)
                {
                    if($authid == $suser)
                    {
                        $flag==1;
                        break;
                    }
                }
                if($flag == 0)
                    $message = 'Sorry this user has not shared their diary with you.';
                else
                    $message = 'true';
            }
            else
                    $message = 'Sorry this user has not shared their diary with you.';
        }
        else
                $message = 'true';
        if($message == 'true')
        {
            $posts = Diary::where('userid',$userid)->get();
            foreach($posts as $post)
            {
                $postDateTime = $post->created_at;
                $postDate = $postDateTime->format('Y-m-d');
                $dates->add($postDate);
            }
            $data = array('message'=>$message,'dates'=>$dates->toJson());
            return json_encode($data);
        }
        else
        {
            $data = array('message'=>$message);
            return json_encode($data);
        }
        }
        catch(Exception $e)
        {
            return json_encode(array('message'=>$e.""));
        }

    }






}
