<!DOCTYPE html>
<html>
<head>
    <title>Home | BBarters</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('dataTables.bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/soccerSpace.css')}}" rel="stylesheet">
    <link href="{{asset('css/fileUpload.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/home.css')}}" rel="stylesheet">
    <link href="{{asset('css/morris.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/notification.css')}}" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{asset('css/star-rating.min.css')}}" media="all" rel="stylesheet" type="text/css"/>

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
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-5 noPadding" style="background: linear-gradient(rgba(3, 23, 34, 0.5), rgba(3, 23, 34, 0.5) ), url('{{SoccerTeam::find($user->team)->cover}}'); background-size: 100% 100%;">
                   <div id="darkDiv" class="col-xs-12 col-sm-12 col-md-12">

                       <div class="col-xs-3 col-sm-3 col-md-3 noPadding">
                       <a class="pull-left" href="#"><img id="profilePic" src="{{asset($user->profile->profilePic)}}" width="100px"></a>
                       </div>

                   </div>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-7 noPadding">
        <div class="col-xs-12 col-sm-12 col-md-12 noPadding">
              <button class="col-xs-6 col-sm-4 col-md-4 bbtng" onclick="transfer(1)">Play Predictor</button>
              <button class="col-xs-6 col-sm-4 col-md-4 bbtn" onclick="transfer(2)">Player Ratings</button>
              <button class="col-xs-12 col-sm-4 col-md-4 bbtnd" onclick="transfer(3)">Live Soccer</button>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
        <hr>
        <div class="col-xs-8 col-md-8 col-sm-8 noPadding">
         My Team
                <p style="font-size: x-large">{{SoccerTeam::find($user->team)->name}}</p>
                <input type="hidden" id="teamID" value="{{SoccerTeam::find($user->team)->id}}">
                <a href="#" onclick="changeTeam()">change team</a>
        </div>
        <div class="col-xs-4 col-md-4 col-sm-4 noPadding">
                <img src="{{SoccerTeam::find($user->team)->logo}}" width="130px" height="130px">
        </div>

        <hr>
        </div>

        <div id="teamData" class="col-xs-12 col-md-12 col-sm-12">
               <div style='text-align:center'><img  src='http://b2.com/Images/icons/waiting.gif'>Loading Content...</div>
        </div>

        </div>
    </div>
</div>

<div class="modal fade" id="teamModal" tabindex="-1" role="dialog" aria-hidden="true">
      	<div class="modal-dialog">
      		<div class="modal-content">
      			<div class="modal-header">
      				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      				<h5>Select your team:</h5>
      		    </div>
      			<div id="teamBody" class="modal-body">
      			<fieldset>
      			<div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <input type="text" class="form-control" placeholder="Search Club for ratings" name="other" id="searchClub" onkeydown="findClubDown()" onkeyup="findClubUp()">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12" id="clubSearchResult" style="margin-top: 5px; display: none">
                    <br>
                    </div>
                </div>
                </fieldset>
                </div>
      	</div>
      </div>
      </div>

<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('js/search.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/pages/soccerSpace.js')}}"></script>
</body>
</html>