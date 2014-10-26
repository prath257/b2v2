<?php
$i = 0;
?>
@foreach($friends as $friend)
<?php
$i++;
?>
<div class="col-lg-12">
    <div class="col-lg-2">
        <img src="{{asset($friend->profile->profilePic)}}" height="35px" width="35px">
    </div>
    <div class="col-lg-10">
        <a href="#" style="text-decoration: none;font-size: 16px" onclick="initiateChatFriend('{{$friend->profile->profilePic}}','{{$friend->first_name}}',{{$friend->id}})">{{$friend->first_name}} {{$friend->last_name}}</a>
    </div>
</div>
<div class="col-lg-12">&nbsp;</div>
@endforeach
@if ($i==0)
No one among your friends is online at the moment.
@endif