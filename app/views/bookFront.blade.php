<div style="word-wrap: break-word">
    Written By:<br> <a href="{{route('user',User::find($book->userid)->username)}}" style="text-decoration: none" target="_blank">{{User::find($book->userid)->first_name}} {{User::find($book->userid)->last_name}}</a>
    <br>
    <br>
</div>
<img src="{{asset($book->cover)}}" width="100%" style="overflow: hidden">