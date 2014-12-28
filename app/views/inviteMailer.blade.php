<h3>Hi, {{$invite->name}}</h3>
<hr>
<p>{{Auth::user()->first_name}} {{Auth::user()->last_name}} has invited you to join BBarters<br>
    Click on the link below to get started on BBarters<br>
    <a href="{{url('signup/'.$invite->link_id)}}">BBarters</a><br><hr><br>
    Regards,<br>
    Team BBarters.
</p>


