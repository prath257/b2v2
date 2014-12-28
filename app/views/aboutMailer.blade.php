<h3>Hello {{$receiver->first_name}},</h3>
<div>
    <hr>
</div>
<img src="{{$user->profile->profilePic}}" height="40px" width="35px">
<h4 style="font-family: 'Segoe UI'; color: rgb(51, 51, 51);">
    <span style="color: inherit; font-family: inherit; line-height: 1.1;">{{$user->first_name}} {{$user->last_name}} just posted something about you on BBarters. Visit your profile to read and approve the post.</span>
</h4>
<h4 style="font-family: 'Segoe UI'; color: rgb(51, 51, 51);">
    <a href="http://b2.com/profile" target="_blank">Visit your profile</a>
</h4>
<div>
    <hr>
</div>
<h4>Regards,<br>
    Team BBarters.
</h4>




<!-- Mailer to notify user when someone posts 'AboutYou' on his profile -->
<!--<!DOCTYPE html>
<html>
<head>
	<title>New 'AboutYou'</title>
</head>
<body>
<p style="font-size: 30px">Hello !</p>
<br>
<p> has written about you on BBarters!</p>
<br>
<p>To read what {{$user->first_name}} {{$user->last_name}} has written and accept/decline please visit your profile on BBarters</p>
<br>
<p>Regards,<br>Team BBarters.</p>
</body>
</html>-->
