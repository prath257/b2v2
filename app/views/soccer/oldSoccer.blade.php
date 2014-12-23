<!DOCTYPE html>
<html>
<head>
    <title>{{SoccerTeam::find($match->hometeam)->name}} vs {{SoccerTeam::find($match->awayteam)->name}} Live Feed</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/fileUpload.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/home.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/liveSoccer.css')}}" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>

</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="position: fixed;">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a></a>
            <a id="logo" class="navbar-brand" href="{{route('index')}}">
                <span class='letter' style="text-shadow: 1px 1px 1px green; color: green">B</span>
                <span class='letter'>B</span>
                <span class='letter'>a</span>
                <span class='letter'>r</span>
                <span class='letter'>t</span>
                <span class='letter'>e</span>
                <span class='letter'>r</span>
                <span class='letter'>s</span>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li id="chats"> <a href="{{route('chats')}}" target="_blank" style="cursor: pointer">Chats</a></li>
                <li id="profile"> <a href="{{route('profile')}}" style="cursor: pointer">{{Auth::user()->first_name}}</a></li>
                <li id="soccerhome"> <a href="{{route('soccerSpace')}}" style="cursor: pointer">SoccerSpace</a></li>
                <li id="logOut"> <a href="{{route('signout')}}" style="cursor: pointer">Log Out</a></li>
            </ul>
        </div>
    </div>
</nav>
<br>
<br>
<br>
<div class="container-fluid">
<input type="hidden" id="feedNo" value="{{$feedId}}">
<div class="col-xs-12 col-sm-12 col-md-12">
      <div class="col-xs-12 col-sm-12 col-md-12 noPad">
      <b style="font-size: medium">{{SoccerLeague::find($match->league)->name}}</b>
      <p>Matchday {{$match->matchday}}</p>
      </div>
      <div class="col-xs-5 col-sm-3 col-md-2 noPad">
            <div class="col-xs-12 col-sm-12 col-md-12 noPad">
                <img src="{{SoccerTeam::find($match->hometeam)->logo}}" id="homeLogo" width="50px" height="50px">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 noPad">
                <b> {{SoccerTeam::find($match->hometeam)->name}}</b>
            </div>
      </div>
      <div class="col-xs-1 col-sm-1 col-md-1 noPad"><b>V</b></div>
      <div class="col-xs-5 col-sm-3 col-md-2 noPad">
              <div class="col-xs-12 col-sm-12 col-md-12 noPad">
                  <img src="{{SoccerTeam::find($match->awayteam)->logo}}" id="homeLogo" width="50px" height="50px">
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12 noPad">
                  <b> {{SoccerTeam::find($match->awayteam)->name}}</b>
              </div>
      </div>

      <div class="col-xs-12 noPad" style="font-size: small">
          <i>{{SoccerTeam::find($match->hometeam)->stadium}}</i>
          &nbsp;|&nbsp;Start:{{date('H:i',strtotime($match->kickoff))}}&nbsp;|&nbsp;Now:<b id='ct'>{{date('H:i',time())}}</b>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-7 noPad" id="filtersDiv">
      <div class="col-xs-4 col-sm-2 col-md-2 noPad filters">&nbsp;</div>
      <div class="btn-group btn-group-xs pull-right" role="group">
        <button type="button" id="sab" value="all" class="btn btn-default">All</button>
        <button type="button" id="sfb" value="friends" class="btn btn-default">Friends</button>
        <button type="button" id="stb" value="team" class="btn btn-default">{{SoccerTeam::find(Auth::user()->team)->nickname}}</button>
      </div>
      </div>
      <div id="liveFeed" class="col-xs-12 col-sm-8 col-md-6 noPad" style=" height:80%;">
               <div id="chatIframe" class="col-xs-12 col-sm-12 col-md-12" style="padding: 0px;">
                   <div id="scrollDiv" class="col-xs-12 col-sm-12 col-md-12" style="height: 90%; overflow: auto; margin-top: 10%">
                       <div style='text-align:center'><img  src='http://b2.com/Images/icons/waiting.gif'>Loading Content...</div>
                   </div>
              </div>

      </div>

</div>

<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/pages/oldSoccer.js')}}"></script>

</body>
</html>