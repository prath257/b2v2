<h3>Hey {{User::find(Collaboration::find($collaborationId)->userid)->first_name}},</h3>
<hr>
{{User::find($userId)->first_name}} {{User::find($userId)->last_name}} just sent you a request to start
contributing for '{{Collaboration::find($collaborationId)->title}}'.<br>
<br>
Here's what he wrote for you:<br>
<i>"{{$reason}}"</i><br>
You can find more about him by visiting his profile <a href="{{route('user',User::find($userId)->username)}}" style="text-decoration: none">HERE</a><br>
<br>
Finally, if you'd like to add him up as a contributor for your collaboration, don't forget to click the below button.<br>
<br>
<a href="{{route('acceptContributionRequest',$link)}}" style="text-decoration: none; padding: 5px; background-color: #003163; color: #ffffff">ACCEPT</a><br>
<br>
<hr>
<br>
Regards,<br>
Team BBarters.

