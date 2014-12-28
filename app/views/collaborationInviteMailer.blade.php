<!DOCTYPE html>
<html>
<head>
</head>
<body>


<h3>Hey There!</h3>
<hr>
{{Auth::user()->first_name}} {{Auth::user()->last_name}} has invited you
to join and contribute for a collaboration called '{{$collaboration->title}}' on BBarters.<div><br></div><div>
    Click On the following link to accept.<br>
    <strong>Link: </strong> http://b2.com/acceptCollaboration/{{$invite->link}}/{{$invite->collaborationid}}
    <br>
    <hr>
    <br>
    Regards,<br>
    Team BBarters.

</div>


</body>
</html>