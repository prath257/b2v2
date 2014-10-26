<?php

class ChatController extends \BaseController
{
    public function submitChatRequest()
    {
        if(Auth::check())
        {
        $user2 = User::find(Input::get('id'));
        if(Auth::user()->isOnline && $user2->isOnline)
        {
            DB::table('chats')->where('user1',Auth::user()->id)->where('user2',$user2->id)->update(array('status' => 'completed'));
            DB::table('chats')->where('user2',Auth::user()->id)->where('user1',$user2->id)->update(array('status' => 'completed'));
            $chat = new Chat();
            $chat->user1 = Auth::user()->id;
            $chat->user2 = $user2->id;
            $chat->reason = Input::get('reason');
            $chat->link_id=str_random(10);
            $chat->status = 'pending';
            $chat->save();

            AjaxController::insertToNotification(Input::get('id'),Auth::user()->id,"chat","sent you a chat request '".Input::get('reason')."'",'http://b2.com/user/'.Auth::user()->username);
            AjaxController::insertNid($chat->id,Input::get('id'));
        }
        else
            return "Request Failed. Please try again.";
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function acceptChat()
    {
        if(Auth::check())
        {
            $chat = Chat::find(Input::get('id'));
            $user1 = User::find($chat->user1);
            $user2 = User::find($chat->user2);

            if($user1->isOnline && $user2->isOnline)
            {
                if (!Friend::isFriend($user1->id))
                {
                    $user1->profile->ifc -= $user2->settings->chatcost;
                    $user1->profile->save();
                    $user1->getChataudit->expenditure+=$user2->settings->chatcost;
                    $user1->getChataudit->save();
                    $user2->profile->ifc += $user2->settings->chatcost;
                    $user2->profile->save();
                    $user2->getChataudit->earning+=$user2->settings->chatcost;
                    $user2->getChataudit->save();

                    TransactionController::insertToManager($user1->id,"-".$user2->settings->chatcost,"IFCs spent on chatting with","http://b2.com/user/".$user2->username,$user2->first_name." ".$user2->last_name,"profile");
                    TransactionController::insertToManager($user2->id,"+".$user2->settings->chatcost,"IFCs earned by chatting with","http://b2.com/user/".$user1->username,$user1->first_name." ".$user1->last_name,"profile");

                }
                $chat->status = 'ongoing';
                $chat->save();

                AjaxController::insertToNotification($user1->id,Auth::user()->id,"chatAcc","accepted your chat request",'http://b2.com/user/'.Auth::user()->username);
                AjaxController::insertNidAcc($chat->id,$user1->id);

                 //DB::table('notification')->where('chid','=',Input::get('id'))->update(array('type' =>'chatR'));

                return 'success';
            }
            else
                return "Request Failed. Please try again.";
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function declineChat()
    {
        if(Auth::check())
        {
            $chat = Chat::find(Input::get('id'));

            DB::table('notification')->where('chid','=',Input::get('id'))->update(array('type' =>'chatR'));

            $chat->delete();
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getChatRoom($linkid)
    {
        $chat = Chat::where('link_id','=',$linkid)->first();
        if ($chat->user1 == Auth::user()->id || $chat->user2 == Auth::user()->id)
        {
            if ($chat->status == 'ongoing' || $chat->status == 'pending')
            {
                $chatdata = ChatData::where('chatid','=',$chat->id)->orderBy('created_at')->get();
                foreach ($chatdata as $cd)
                {
                    $cd->seen = true;
                    $cd->save();
                }
                return View::make('chat')->with('chat',$chat)->with('chatdata',$chatdata);
            }
        }
    }

    public function sendMessage()
    {
        if(Auth::check())
        {
            $chatData = new ChatData();
            $chatData->chatid = Input::get('id');
            $chatData->senderid = Auth::user()->id;
            $chatData->text = Input::get('text');
            $chatData->save();
        }
        else
            return 'wH@tS!nTheB0x';
    }



    public function retrieveChatData()
    {
        if(Auth::check())
        {
            try
            {
                $chatid = Input::get('chatId');
                $chat = Chat::find($chatid);
                $chatdata = ChatData::where('chatid','=',$chatid)->where('senderid','!=',Auth::user()->id)->where('seen','=',false)->first();
                $chatdata->seen = true;
                $chatdata->save();
                if ($chatdata)
                    return $chatdata->text;
            }
            catch(Exception $e)
            {
                return "noData";
            }
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getChatData()
    {
        if(Auth::check())
        {
            $chat = Chat::find(Input::get('id'));
            if ($chat->status != 'completed')
            {
                $chatdata = $chat->getChatData()->get();
                foreach ($chatdata as $cd)
                {
                    $cd->seen = true;
                    $cd->save();
                }
                return View::make('chat')->with('chatdata',$chatdata);
            }
            else
                return 'chat_over';
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getChatLink()
    {
        if(Auth::check())
        {
            $chat =Chat::find(Input::get('id'));
            return $chat->link_id;
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function completeChat()
    {
        if(Auth::check())
        {
        $chatId = Input::get('chatId');
        $chat = Chat::find($chatId);
        if ($chat->status=='ongoing')
        {
            $chat->status = 'completed';
            $chat->justclosed = true;
            $chat->save();
            $chatdata = new ChatData();
            $chatdata->chatid = $chat->id;
            $chatdata->senderid = Auth::user()->id;
            $chatdata->text = 'Attention! The chat is over. '.Auth::user()->first_name.' left the chat.';
            $chatdata->save();
        }
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function isTypingTrue()
    {
        if(Auth::check())
        {
            $chat = Chat::find(Input::get('id'));

            if ($chat->user1==Auth::user()->id)
            {
                $chat->user1IsTyping=true;
                $chat->save();
            }
            else if ($chat->user2==Auth::user()->id)
            {
                $chat->user2IsTyping=true;
                $chat->save();
            }
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function isTypingFalse()
    {
        if(Auth::check())
        {
            $chat = Chat::find(Input::get('id'));

            if ($chat->user1==Auth::user()->id)
            {
                $chat->user1IsTyping=false;
                $chat->save();
            }
            else if ($chat->user2==Auth::user()->id)
            {
                $chat->user2IsTyping=false;
                $chat->save();
            }
        }
        else
            return 'wH@tS!nTheB0x';
    }


    public function retrieveIsTyping()
    {
        if(Auth::check())
        {
            $chat = Chat::find(Input::get('chatId'));

            if ($chat->user1==Auth::user()->id)
            {
                return $chat->user2IsTyping;
            }
            else if ($chat->user2==Auth::user()->id)
            {
                return $chat->user1IsTyping;
            }
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getSecondPartyName()
    {
        if(Auth::check())
        {
        $chatid = Input::get('id');
        $chat = Chat::find($chatid);

        if($chat->user1==Auth::user()->id)
        {
            $user = User::find($chat->user2);
            $name = $user->first_name.' '.$user->last_name;
        }
        else if($chat->user2==Auth::user()->id)
        {
            $user = User::find($chat->user1);
            $name = $user->first_name.' '.$user->last_name;
        }

        return $name;
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getSecondPartyProfilePic()
    {
        if(Auth::check())
        {
        $chatid = Input::get('id');
        $chat = Chat::find($chatid);

        if($chat->user1==Auth::user()->id)
        {
            $user = User::find($chat->user2);
            $url = $user->profile->profilePic;
        }
        else if($chat->user2==Auth::user()->id)
        {
            $user = User::find($chat->user1);
            $url = $user->profile->profilePic;
        }

        return $url;
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function checkNewMessages()
    {
        if(Auth::check())
        {
        $chats = Chat::where('status','=','ongoing')->where(function($query)
            {
                $query->where('user1', '=', Auth::user()->id)->orWhere('user2', '=', Auth::user()->id);
            })->get();
        if($chats)
        {
            foreach($chats as $chat)
            {
                $chatdata = ChatData::where('chatid','=',$chat->id)->where('seen','=','false')->where('senderid','!=',Auth::user()->id)->first();
                if($chatdata!=null)
                {
                    return $chat->id;
                }
                else
                {
                    return "TheMonumentsMenGeorgeClooneyMattDamon";
                }
            }
        }
    }
        else
            return 'wH@tS!nTheB0x';
    }

    public function checkClosedChats()
    {
        if(Auth::check())
        {
            $chat = Chat::where('status','=','completed')->where('justclosed','=',true)->where(function($query)
            {
                $query->where('user1', '=', Auth::user()->id)->orWhere('user2', '=', Auth::user()->id);
            })->first();

            if ($chat)
            {
                $chat->justclosed = false;
                $chat->save();

                return $chat->id;
            }
        }
        else
            return 'wH@tS!nTheB0x';
    }

    public function getOnlineContacts()
    {
        if (Auth::check())
        {
            $users=new \Illuminate\Database\Eloquent\Collection();

            $friends1=DB::table('friends')->where('friend1','=',Auth::user()->id)->where('status','=','accepted')->lists('friend2');
            foreach($friends1 as $f1)
            {
                $user = User::find($f1);

                $currentTime = new DateTime();
                $lastSeen = $user->updated_at;
                $form = $currentTime->diff($lastSeen);
                if($form->i>4)
                {
                    $user->isOnline=false;
                    $user->save();
                }

                if ($user->isOnline==true)
                    $users->add($user);
            }
            $friends2=DB::table('friends')->where('friend2','=',Auth::user()->id)->where('status','=','accepted')->lists('friend1');
            foreach($friends2 as $f2)
            {
                $user = User::find($f2);

                $currentTime = new DateTime();
                $lastSeen = $user->updated_at;
                $form = $currentTime->diff($lastSeen);
                if($form->i>4)
                {
                    $user->isOnline=false;
                    $user->save();
                }

                if ($user->isOnline==true)
                    $users->add($user);
            }

            return View::make('onlineFriends')->with('friends',$users);
        }
        else
            return 'wH@tS!nTheB0x';
    }


    public function retrieveOngoingChats()
    {
        if(Auth::check())
        {
        $ongoingChats = Chat::where('status','=','ongoing')
            ->where(function($query)
            {
                $query->where('user1', '=', Auth::user()->id)
                    ->orWhere('user2', '=', Auth::user()->id);
            })->get();

        return View::make('activeChats')->with('ongoingChats',$ongoingChats);
    }
        else
            return 'wH@tS!nTheB0x';
    }
}
