<fieldset id="fieldset">
@if($notific->ntype=='frequest')

<?php
$sender=DB::table('friends')->where('id',$notific->nid)->pluck('friend1');
$request=User::find($sender);
?>
<button id="closeButton" type="button" class="close closeButton" onclick="closeAlert('frequest')">&times;</button>
<div id="Request{{$request->id}}" class="col-lg-12" style="padding: 0px">
    <div class="col-lg-8">
        <img src="{{$request->profile->profilePic}}" height="50px" width="50px">
        <a href="{{route('user',$request->username)}}" style="text-decoration: none" target="_blank">{{$request->first_name}} {{$request->last_name}}</a>
        <br>
        <p id="extraText">sent you a friend request.</p>
        <?php $reason = DB::table('friends')->where('friend1',$request->id)->where('friend2',Auth::user()->id)->pluck('reason'); ?>
        @if ($reason != null)
        <br>
        <i>"{{$reason}}"</i><br>
        <p>- {{$request->first_name}}</p>
        @endif
    </div>

    <div id="buttons" class="col-lg-4">
        <button id="acceptButton{{$request->id}}" type="button" class="btn btn-success col-lg-12 adbuttons" onclick="acceptFriends({{$request->id}})">Accept</button>
        <button id="declineButton{{$request->id}}" type="button" class="btn btn-danger col-lg-12 adbuttons" onclick="declineFriends({{$request->id}})">Decline</button>
    </div>

    <div id="freqWaiting" class="col-lg-4" style="display:none">
        <img src="{{asset('Images/icons/waiting.gif')}}">Loading..
    </div>

    <div class="col-lg-12">&nbsp;</div>
    <hr>
</div>

@elseif($notific->ntype=='faccepted')

<?php
$sender=DB::table('friends')->where('id',$notific->nid)->pluck('friend2');
$request=User::find($sender);
?>
    <button id="closeButton" type="button" class="close closeButton" onclick="closeAlert('faccepted')">&times;</button>
<div>
    <div id="anotherRequest{{$request->id}}">
        <strong>Hey!</strong>
        <div  style="margin-left: 0px">
            <img style="float: left" src="{{$request->profile->profilePic}}" width="40px" height="40px">
            <div>
                <a href="{{route('user',$request->username)}}" style="text-decoration: none; font-size: 20px">&nbsp;&nbsp;{{$request->first_name}}</a>
            </div>
        </div>
        <div id="extraText" class="col-lg-12 col-lg-offset-1">
            just accepted your friend request.
        </div>

    </div>
</div>

@elseif($notific->ntype=='qasked')

<?php
$question = Question::find($notific->nid);
$user = User::find($question->askedBy_id);
?>
<button id="closeButton" type="button" class="close closeButton" onclick="closeAlert('qasked')">&times;</button>
<div>
    <div>
        <div  style="margin-left: 0px">
            <img style="float: left" src="{{$user->profile->profilePic}}" width="40px" height="40px">
            <div>
                <a href="{{route('user',$user->username)}}" style="text-decoration: none; font-size: 20px">&nbsp;&nbsp;{{$user->first_name}}</a>
            </div>
        </div>
        <div class="col-lg-12 col-lg-offset-1">
            just asked you a new question for {{$question->ifc}}.
        </div>
        <div class="col-lg-12">&nbsp;</div>
        <p>
            Visit 'Answer' under 'Write' to view and answer this question.
        </p>

    </div>
</div>

@elseif($notific->ntype=='qanswered')

<?php
$question = Question::find($notific->nid);
$user = User::find($question->askedTo_id);
?>
<button id="closeButton" type="button" class="close closeButton" onclick="closeAlert('qanswered')">&times;</button>
<div>
    <div>
        <div  style="margin-left: 0px">
            <img style="float: left" src="{{$user->profile->profilePic}}" width="40px" height="40px">
            <div>
                <a href="{{route('user',$user->username)}}" style="text-decoration: none; font-size: 20px">&nbsp;&nbsp;{{$user->first_name}}</a>
            </div>
        </div>
        <div class="col-lg-12 col-lg-offset-1">
            just answered your question.
        </div>
        <div class="col-lg-12">&nbsp;</div>
        <p>Visit his profile and head to 'Ask' under 'Write' to view the answer.</p>
    </div>
</div>

@elseif($notific->ntype=='aboutrequest')

<?php
$about = About::find($notific->nid);
$user = User::find($about->writtenby);
?>
<button id="closeButton" type="button" class="close closeButton" onclick="closeAlert('aboutrequest')">&times;</button>
<div>
    <div>
        <div  style="margin-left: 0px">
            <img style="float: left" src="{{$user->profile->profilePic}}" width="40px" height="40px">
            <div>
                <a href="{{route('user',$user->username)}}" style="text-decoration: none; font-size: 20px">&nbsp;&nbsp;{{$user->first_name}}</a>
            </div>
        </div>
        <div class="col-lg-12 col-lg-offset-1">
            just wrote this about you for {{$about->ifc}} IFCs.
        </div>
        <div class="col-lg-12">&nbsp;</div>
        <p>
            <strong>"{{$about->content}}"</strong>
        </p>
        </div>
</div>

    @elseif($notific->ntype=='aboutaccepted')

    <?php
    $about = About::find($notific->nid);
    $user = User::find($about->writtenfor);
    ?>
    <button id="closeButton" type="button" class="close closeButton" onclick="closeAlert('aboutaccepted')">&times;</button>
    <div>
        <div>
            <div  style="margin-left: 0px">
                <img style="float: left" src="{{$user->profile->profilePic}}" width="40px" height="40px">
                <div>
                    <a href="{{route('user',$user->username)}}" style="text-decoration: none; font-size: 20px">&nbsp;&nbsp;{{$user->first_name}}</a>
                </div>
            </div>
            <div class="col-lg-12 col-lg-offset-1">
                just approved the text that you wrote about
                @if($user->gender=='male')
                    him.
                @else
                    her.
                @endif
            </div>

        </div>
    </div>

    @elseif($notific->ntype=='subscription')

    <?php
    $id = DB::table('subscriptions')->where('id',$notific->nid)->pluck('subscriber_id');
    $user = User::find($id);
    ?>
    <button id="closeButton" type="button" class="close closeButton" onclick="closeAlert('subscription')">&times;</button>
    <div>
        <div>
            <div  style="margin-left: 0px">
                <img style="float: left" src="{{$user->profile->profilePic}}" width="40px" height="40px">
                <div>
                    <a href="{{route('user',$user->username)}}" style="text-decoration: none; font-size: 20px">&nbsp;&nbsp;{{$user->first_name}}</a>
                </div>
            </div>
            <div class="col-lg-12 col-lg-offset-1">
                started following you.
            </div>

        </div>
    </div>

    @elseif($notific->ntype=='chatrequest')

    <?php
    $chat = Chat::find($notific->nid);
    $user = User::find($chat->user1);
    ?>
     <div>
        <div>
            <div  style="margin-left: 0px">
                <img style="float: left" src="{{$user->profile->profilePic}}" width="40px" height="40px">
                <div>
                    <a href="{{route('user',$user->username)}}" style="text-decoration: none; font-size: 20px">&nbsp;&nbsp;{{$user->first_name}}</a>
                </div>
            </div>
            <div class="col-lg-12 col-lg-offset-1">
                has invited you to chat.
            </div>
            <div class="col-lg-12">
                "{{$chat->reason}}"
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div id="buttons" class="pull-right">
                <button id="acceptChatButton" type="button" class="btn btn-primary" onclick="acceptChat({{$chat->id}})">Accept</button>
                &nbsp;&nbsp;
                <button id="declineChatButton" type="button" class="btn btn-primary" onclick="declineChat({{$chat->id}})">Decline</button>
            </div>

        </div>
    </div>

    @elseif($notific->ntype=='chataccepted')

    <?php
    $chat = Chat::find($notific->nid);
    $user = User::find($chat->user2);
    ?>
    <div>
        <div>
            <div  style="margin-left: 0px">
                <img style="float: left" src="{{$user->profile->profilePic}}" width="40px" height="40px">
                <div>
                    <a href="{{route('user',$user->username)}}" style="text-decoration: none; font-size: 20px">&nbsp;&nbsp;{{$user->first_name}}</a>
                </div>
            </div>
            <div class="col-lg-12 col-lg-offset-1">
                accepted your invitation for a chat.
            </div>

            <div class="col-lg-12">&nbsp;</div>
            <div id="buttons" class="pull-right">
                <button id="startChatButton" type="button" class="btn btn-primary" onclick="startChat({{$chat->id}})">Start Chat</button>
            </div>

        </div>
    </div>
@endif
</fieldset>


