<div style="word-wrap: break-word">
    Created By:<br> <a href="{{route('user',User::find($collaboration->userid)->username)}}" style="text-decoration: none" target="_blank">{{User::find($collaboration->userid)->first_name}} {{User::find($collaboration->userid)->last_name}}</a>
    <br>
    <br>
    Contributors: <br>
    @foreach($contributors as $contributor)
    <a href="{{route('user',$contributor->username)}}" style="text-decoration: none" target="_blank">{{$contributor->first_name}} {{$contributor->last_name}}</a>
    <br>
    @endforeach
</div>
<img src="{{asset($collaboration->cover)}}" width="100%" style="overflow: hidden">
