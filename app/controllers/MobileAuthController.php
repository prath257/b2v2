<?php

class MobileAuthController extends \BaseController {


    public function login()
    {
        try
        {
            $credentials = array('username' => Input::get('uname'),'password' => Input::get('pwd'));

            // Try to authenticate the user, remember me is set to false

            // $user = Sentry::authenticate($credentials, false);

            Auth::attempt($credentials);

            if(Auth::check())
            {
                if(Auth::user()->activated)
                {
                    $user = Auth::user();

                    $arr=Array("ok"=>"true","id"=>$user->id,"first_name"=>$user->first_name,"last_name"=>$user->last_name);

                    return json_encode($arr);


                }
                else
                {
                    $arr=Array("ok"=>"not activated");

                    return json_encode($arr);

                }
            }
            //if everything went okay, we redirect to index route with success message
            else
            {
                $arr=Array("ok"=>"Invalid Username or Password");
                return $arr;
            }
        } catch(Excecption $e)
        {
            $arr=Array("ok"=>$e);
            return json_encode($arr);
        }

    }








    public function fblogin()
    {

        try
        {
            $users = User::all();
            foreach($users as $user)
            {
                if($user->fbid == Input::get('fbid'))
                {

                    $credentials = array('ok'=>'true','id'=>$user->id,'first_name' => $user->first_name,'last_name' => $user->last_name);
                    return json_encode($credentials);
                }
            }

            $credentials = array('ok'=>'invalid username and password');
            return json_encode($credentials);
        }

        catch(Exception $e)
        {
            $arr=Array("ok"=>$e);
            return json_encode($arr);
        }



    }



    public function tlogin()
    {
        $users = User::all();
        foreach($users as $user)
        {
            if($user->twitterid == Input::get('tid'))
            {

                $credentials = array('ok'=>'true','id'=>$user->id,'first_name' => $user->first_name,'last_name' => $user->last_name);
                return json_encode($credentials);
            }
        }
        $credentials = array('ok'=>'Invalid Credentials','id'=>null,'first_name' => null,'last_name' => null);
        return json_encode($credentials);

    }


    public function glogin()
    {
        $users = User::all();
        foreach($users as $user)
        {
            if($user->gid == Input::get('gid'))
            {

                $credentials = array('ok'=>'true','id'=>$user->id,'first_name' => $user->first_name,'last_name' => $user->last_name);
                return json_encode($credentials);
            }
        }
        $credentials = array('ok'=>'Invalid Credentials','id'=>null,'first_name' => null,'last_name' => null);
        return json_encode($credentials);

    }


    /*    public function getActionData()
        {

            $action=DB::table('actions')->orderBy('created_at','DESC')->take(6)->get();

            return json_encode($action);

        }
    */

    public function logout()
    {
        $user = User::find(Input::get('id'));

        if($user->fbid!=null)
        {
            $fauth = new Hybrid_Auth(app_path(). '/config/fb_auth.php');
            $fauth->logoutAllProviders();
        }
        if($user->twitterid!=null)
        {
            $tauth = new Hybrid_Auth(app_path(). '/config/tw_auth.php');
            $tauth->logoutAllProviders();
        }
        if($user->gid!=null)
        {
            $gauth = new Hybrid_Auth(app_path(). '/config/Google_auth.php');
            $gauth->logoutAllProviders();
        }


        return 'success';

    }


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
