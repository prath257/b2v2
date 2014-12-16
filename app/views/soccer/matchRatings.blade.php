<!DOCTYPE html>
<html>
<head>
    <title>{{SoccerTeam::find($match->hometeam)->name}} vs {{SoccerTeam::find($match->awayteam)->name}} Player Ratings</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/fileUpload.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/home.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/notification.css')}}" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

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
                <li id="notificationli" class="navbar-brand" onclick="getNoti()" style="list-style-type: none"><a href="#" style="text-decoration: none">&nbsp;&nbsp;<i class="fa fa-globe" style="color:lightgray"></i>&nbsp;<span id="no_of_notification" class="text-primary" style="background-color: tomato; color: white; padding-left: 5px; padding-right: 5px;  border-radius: 50%; visibility: hidden; font-size: 12px">0</span></a></li>
                <div id="notificationModal2" style="max-height: 350px; overflow-y: auto; overflow-x: auto">
                    <div id="notificationResultsModal">
                        <div  class="modal-body" style="padding-left: 10px; padding-top: 15px; padding-bottom: 15px; padding-right: 10px">
                            <fieldset id="notificationText"></fieldset>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li style="display: none">
                    <form id="searchForm" class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input id="search" type="text" class="form-control" placeholder="Search" autocomplete="off">
                            <!-- Modal to display search results -->
                            <div id="searchModal">
                                <div id="searchResultsModal">
                                    <div  class="modal-body" style="padding-left: 10px; padding-top: 15px; padding-bottom: 15px; padding-right: 10px">
                                        <fieldset id="searchText"></fieldset>
                                    </div>
                                </div>
                                </div>
                        </div>
                    </form>
                    <div class="btn-group btn-group-xs" data-toggle="buttons" style="margin-top: 15px; padding: 0px">
                        <label id="peopleLabel" class="btn btn-default labelButtons" onclick="changeClass('people')">
                            <input type="radio" name="searchOptions" id="people" value="people" checked> Barters
                        </label>
                        <label id="contentLabel" class="btn btn-default labelButtons" onclick="changeClass('content')">
                            <input type="radio" name="searchOptions" id="content" value="content"> Content
                        </label>
                    </div>
                </li>
                <li id="chats"> <a href="{{route('chats')}}" target="_blank" style="cursor: pointer">Chats</a></li>
                <li id="profile"> <a href="{{route('profile')}}" style="cursor: pointer">{{Auth::user()->first_name}}</a></li>
                <li id="home"> <a href="{{route('home')}}" style="cursor: pointer">Home</a></li>
                <li id="logOut"> <a href="{{route('signout')}}" style="cursor: pointer">Log Out</a></li>
            </ul>
        </div>
    </div>
</nav>
<br>
<br>
<br>
<br>
@if(!Auth::user()->pset)
<div class="alert alert-info alert-dismissable col-lg-6" style="margin-left: 5%">
    <strong style="font-size: 24px">Attention! </strong> <a href="{{route('buildProfile')}}" style="font-size: 24px">Complete Profile</a> now and earn yourself upto 300i.
</div>
@endif
<div class="container-fluid">

<div class="col-xs-12 col-sm-12 col-md-12">
      <div class="col-xs-8 col-sm-4 col-md-3">
      <b style="font-size: medium">{{SoccerLeague::find($match->league)->name}}</b>
      </div>
      <div class="col-xs-4 col-sm-4 col-md-4" style="padding: 0px">
             <img src="{{SoccerLeague::find($match->league)->logo}}" id="leagueLogo" width="50px" height="50px">
      </div>
      <div class="col-xs-12" style="font-size: small">
          <i>{{SoccerTeam::find($match->hometeam)->stadium}}</i>
          <br>Kickoff: {{date('d M Y H:i',strtotime($match->kickoff))}}
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12" style="font-size: 12px">Player Ratings By: <a href="{{route('user',$author->username)}}">{{$author->first_name}}&nbsp;{{$author->last_name}}</a></div>
      <div class="col-xs-12 col-sm-12 col-md-12"><hr></div>
      <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="col-xs-5 col-sm-3 col-md-3">
              <img src="{{SoccerTeam::find($match->hometeam)->logo}}" id="homeLogo" width="50px" height="50px">
          </div>
          <div class="col-xs-7 col-sm-7 col-md-7">
              <p style="font-size: large"> {{SoccerTeam::find($match->hometeam)->name}}</p>
          </div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-6 col-xs-offset-5 col-sm-offset-2 col-md-offset-2">
      Vs
      </div>
      <div class="col-xs-12">&nbsp;</div>
      <div class="col-xs-12 col-sm-6 col-md-6">
      <div class="col-xs-5 col-sm-3 col-md-3">
          <img src="{{SoccerTeam::find($match->awayteam)->logo}}" id="awayLogo" width="50px" height="50px">
      </div>
      <div class="col-xs-7 col-sm-7 col-md-7">
          <p style="font-size: large"> {{SoccerTeam::find($match->awayteam)->name}}</p>
      </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12"><hr></div>
      @foreach($ratings as $rating)
      <div class="col-xs-12 col-sm-12 col-md-6" style="padding: 2px;border-bottom: 1px whitesmoke solid;">
      <div class="col-xs-4 col-sm-2 col-md-2">
        <img src="{{SoccerPlayer::find($rating->player_id)->picture}}" width="50px" height="50px">
      </div>
      <div class="col-xs-8 col-sm-10 col-md-10 comment">
      <p><b style="color: #000033">{{SoccerPlayer::find($rating->player_id)->last_name}}</b>:{{$rating->comment}} &nbsp;<b>{{$rating->rating}}/10</b></p>
      </div>
      </div>
      @endforeach


</div>

</div>
<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('js/search.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script>
var width=0;
$(document).ready(function()
{
    width = $(window).width();
    if(width<450)
    {
         $('.comment').css({fontSize: 12});
    }
    else
    {
        $('.comment').css({fontSize: 13});
    }
});

</script>
</body>
</html>