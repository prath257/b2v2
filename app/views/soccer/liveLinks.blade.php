<!DOCTYPE html>
<html>
<head>
    <title>Home | BBarters</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/home.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/liveLinks.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/notification.css')}}" rel="stylesheet">
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
<div class="container">
    <div class="row">
         <div class="col-xs-12 col-sm-6 col-md-6">
          <h2>Live Feeds</h2>
          @foreach($lfeeds as $feed)
              <div class="col-xs-12 col-sm-12 col-md-12 liveFeed">
              <a href="/liveSoccer/{{$feed->id}}">
                  <div class="col-xs-6 col-sm-6 col-md-6">
                       <img src="{{SoccerTeam::find(SoccerSchedule::find($feed->match_id)->hometeam)->logo}}" class="tLogo">
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-6 noPad">
                       <img src="{{SoccerTeam::find(SoccerSchedule::find($feed->match_id)->awayteam)->logo}}" class="tLogo">
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12">
                       <h3>{{SoccerTeam::find(SoccerSchedule::find($feed->match_id)->hometeam)->name}}  v {{SoccerTeam::find(SoccerSchedule::find($feed->match_id)->awayteam)->name}}</h3>
                  </div>
              </a>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12"><hr></div>
          @endforeach
         </div>
        <div class="col-xs-12 col-sm-6 col-md-6 ">
              <h2>Legacy Feeds</h2>
              @foreach($cfeeds as $feed)
                  <div class="col-xs-12 col-sm-12 col-md-12 legacyFeed">
                  <a href="/liveSoccer/{{$feed->id}}">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                             <img src="{{SoccerTeam::find(SoccerSchedule::find($feed->match_id)->hometeam)->logo}}" class="tLogo">
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 noPad">
                             <img src="{{SoccerTeam::find(SoccerSchedule::find($feed->match_id)->awayteam)->logo}}" class="tLogo">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                             <h3>{{SoccerTeam::find(SoccerSchedule::find($feed->match_id)->hometeam)->name}}  v {{SoccerTeam::find(SoccerSchedule::find($feed->match_id)->awayteam)->name}}</h3>
                        </div>
                  </a>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12"><hr></div>
              @endforeach
         </div>

     </div>
</div>

<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
</body>
</html>