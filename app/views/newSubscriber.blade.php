<h3>Hello {{$receiver->first_name}}!</h3>
<hr>
<p><a href="http://b2.com/user/{{$user->username}}">{{$user->first_name}} {{$user->last_name}}</a> has subscribed to you on BBarters!</p>
<p>And that increments your IFC count by {{$receiver->settings->subcost}}<i>i</i>!</p>
<hr>
<p>Regards,<br>Team BBarters.</p>