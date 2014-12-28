<h3>Hello {{$host->first_name}},</h3>
<div>
    <hr>
</div>
<img src="{{$attendee->profile->profilePic}}" height="40px" width="35px">
<h4 style="font-family: 'Segoe UI'; color: rgb(51, 51, 51);">
    <span style="color: inherit; font-family: inherit; line-height: 1.1;">{{$attendee->first_name}} {{$attendee->last_name}} just registered for your event '{{$event->name}}' on BBarters. His contact number is {{$contact}} and you can mail @if($attendee->gender == 'male') him @else her @endif on {{$attendee->email}}. With that, your guest-list counts to <strong>{{$event->users}}</strong>.</span></h4>
<h4 style="font-family: 'Segoe UI'; color: rgb(51, 51, 51);">Visit @if($attendee->gender == 'male') his @else her @endif profile <a href="{{route('user',$attendee->username)}}">here.</a></h4><div><br></div><div><h4 style="font-family: 'Segoe UI'; color: rgb(51, 51, 51);">You can view the entire list of attendees for this event <a href="{{route('attendeeList',$event->id)}}">here.</a></h4></div>
<div>
    <hr>
</div>
<h4>Regards,<br>
    Team BBarters.
</h4>     