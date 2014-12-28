
<h3>Hey There</h3>
<hr>
{{Auth::user()->first_name}} {{Auth::user()->last_name}} has invited you to join and contribute for a collaboration called '{{$collaboration->title}}' on BBarters.<div><br>
    It seems like you aren't already there on BBarters. No worries, click on the link below and get started! Once you are done, don't forget to come back and click the link at the bottom of this page to accept the collaboration.<br>
    Sign Up here: http://b2.com&nbsp;</div><div><br>
    And here's the link to accept the invitation. Remember, click this only when you've completed all SignUp and ProfileSetup steps, and you got to register with us using THIS E-mail only.<br>
    <strong><br></strong></div><div><strong>Link: </strong> http://b2.com/acceptCollaboration/{{$invite->link}}/{{$invite->collaborationid}}
    <br>
    <hr><br>
    Regards,<br>
    Team BBarters.



</div>