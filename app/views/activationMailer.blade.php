<!-- Mailer to verify the user who signed up recently -->
<h3>Hi, {{$user->first_name}}</h3>
<hr>
<p></p><p>Thank you for registering.</p><p>
    You need to click on the link below to complete your registration.</p><p><a href="{{url('activate/'.Crypt::encrypt($user->id))}}" style="line-height: 1.42857143; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);">&nbsp;BBarters</a></p><p>
</p><hr>
    Regards,<br>
    Team BBarters.
<p></p>
 