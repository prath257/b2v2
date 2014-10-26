<?php
    $count = 0;

?>

    <ul style="list-style-type: none; padding: 0px">
    @foreach($searchUsers as $searchUser)
        @if(Auth::check())
        @if ($searchUser->id != Auth::user()->id)
            <li>
            @if ($request=='home')
                <div class="col-lg-12" style="padding-left: 10px; padding-right: 10px; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="visitProfile('{{$searchUser->username}}')" onmouseover="hoverEffect(this)" onmouseout="normalEffect(this)">
            @elseif ($request=='chats')
                @if (Friend::isFriend($searchUser->id))
                <div class="col-lg-12" style="padding-left: 10px; padding-right: 10px; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="initiateChatFriend('{{$searchUser->profile->profilePic}}','{{$searchUser->first_name}}',{{$searchUser->id}})" onmouseover="hoverEffect(this)" onmouseout="normalEffect(this)">
                @else
                <div class="col-lg-12" style="padding-left: 10px; padding-right: 10px; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="initiateChat({{$searchUser->settings->chatcost}},'{{$searchUser->profile->profilePic}}','{{$searchUser->first_name}}',{{$searchUser->id}})" onmouseover="hoverEffect(this)" onmouseout="normalEffect(this)">
                @endif
            @endif

                <div class="col-lg-3" style="padding: 0px">
                    <img src="{{$searchUser->profile->profilePic}}" height="40px" width="40px">
                </div>
                <div class="col-lg-9" style="padding: 5px">
                    @if ($request=='home')
                    <a href="{{route('user',$searchUser->username)}}" style="text-decoration: none; font-size: 16px">{{$searchUser->first_name}} {{$searchUser->last_name}}</a>
                    @elseif ($request=='chats')
                        @if (Friend::isFriend($searchUser->id))
                            <a href="#" style="text-decoration: none; font-size: 16px" onclick="initiateChatFriend('{{$searchUser->profile->profilePic}}','{{$searchUser->first_name}}',{{$searchUser->id}})">{{$searchUser->first_name}} {{$searchUser->last_name}}</a>
                        @else
                            <a href="#" style="text-decoration: none; font-size: 16px" onclick="initiateChat({{$searchUser->settings->chatcost}},'{{$searchUser->profile->profilePic}}','{{$searchUser->first_name}}',{{$searchUser->id}})">{{$searchUser->first_name}} {{$searchUser->last_name}}</a>
                        @endif
                    @endif
                </div>
            </div>
            </li>
        @endif
         @else
        <li>
            @if ($request=='home')
            <div class="col-lg-12" style="padding-left: 10px; padding-right: 10px; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="visitProfile('{{$searchUser->username}}')" onmouseover="hoverEffect(this)" onmouseout="normalEffect(this)">
                @elseif ($request=='chats')
                @if (Friend::isFriend($searchUser->id))
                <div class="col-lg-12" style="padding-left: 10px; padding-right: 10px; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="initiateChatFriend('{{$searchUser->profile->profilePic}}','{{$searchUser->first_name}}',{{$searchUser->id}})" onmouseover="hoverEffect(this)" onmouseout="normalEffect(this)">
                    @else
                    <div class="col-lg-12" style="padding-left: 10px; padding-right: 10px; padding-top: 5px; padding-bottom: 5px; cursor: pointer" onclick="initiateChat({{$searchUser->settings->chatcost}},'{{$searchUser->profile->profilePic}}','{{$searchUser->first_name}}',{{$searchUser->id}})" onmouseover="hoverEffect(this)" onmouseout="normalEffect(this)">
                        @endif
                        @endif

                        <div class="col-lg-3" style="padding: 0px">
                            <img src="{{$searchUser->profile->profilePic}}" height="40px" width="40px">
                        </div>
                        <div class="col-lg-9" style="padding: 5px">
                            @if ($request=='home')
                            <a href="{{route('user',$searchUser->username)}}" style="text-decoration: none; font-size: 16px">{{$searchUser->first_name}} {{$searchUser->last_name}}</a>
                            @elseif ($request=='chats')
                            @if (Friend::isFriend($searchUser->id))
                            <a href="#" style="text-decoration: none; font-size: 16px" onclick="initiateChatFriend('{{$searchUser->profile->profilePic}}','{{$searchUser->first_name}}',{{$searchUser->id}})">{{$searchUser->first_name}} {{$searchUser->last_name}}</a>
                            @else
                            <a href="#" style="text-decoration: none; font-size: 16px" onclick="initiateChat({{$searchUser->settings->chatcost}},'{{$searchUser->profile->profilePic}}','{{$searchUser->first_name}}',{{$searchUser->id}})">{{$searchUser->first_name}} {{$searchUser->last_name}}</a>
                            @endif
                            @endif
                        </div>
                    </div>
        </li>

        @endif
    <?php
        $count ++;
    ?>
    @endforeach
    </ul>
    @if ($count == 0)
        No results to display.
    @endif