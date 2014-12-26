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
    <link href="{{asset('css/fileUpload.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/home.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/playerRatings.css')}}" rel="stylesheet">
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
                <a href="/soccerSpace" id="sapLogo" style="text-decoration: none;padding-left: 4px; padding-right: 0px; padding-top: 14px" class="navbar-brand"><img src="/Images/icons/soccer.png"></a>
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
                <li id="soccerhome"> <a href="{{route('soccerSpace')}}" style="cursor: pointer">SoccerSpace</a></li>
                <li id="home"> <a href="{{route('home')}}" style="cursor: pointer">Home</a></li>
                <li id="profile"> <a href="{{route('profile')}}" style="cursor: pointer">{{Auth::user()->first_name}}</a></li>
                <li id="logOut"> <a href="{{route('signout')}}" style="cursor: pointer">Log Out</a></li>
            </ul>
        </div>
    </div>
</nav>
<br>
<br>
<br>
<br>
<div class="container-fluid">

   <div class="col-xs-12 col-sm-12 col-md-9 noPad">
      <div class="row" id="headRow" style="padding: 15px">
      <button class="col-xs-6 col-sm-6 col-md-3 bbtn" onclick="myPredictions('newratings','New Player Ratings')">Give Ratings</button>
      <button class="col-xs-6 col-sm-6 col-md-3 bbtnr" onclick="getMyRatings('My Ratings')">My Ratings</button>
      <button class="col-xs-6 col-sm-6 col-md-3 bbtng" onclick="getFriendsRatings('Friend\'s Ratings')">Friends Ratings</button>
      <button class="col-xs-6 col-sm-6 col-md-3 bbtnd" onclick="getClubRatings('Club Ratings')">Club Ratings</button>
      </div>
      <br>
      <p class="barterHeader"></p>
      <hr>
       <div class="row" id="mainTask">
       </div>
       <div class="row" id="ratingsDiv" style="display: none">
           <div class="col-xs-6 col-sm-4 col-md-4" id="addHomePlayers" style="display: none">
                 <button class="bbtn"  onclick="showPlayersModal('Home')">Rate Home XI and Subs</button>
           </div>
           <div class="col-xs-6 col-sm-4 col-md-4" id="addAwayPlayers" style="display: none">
                 <button class="bbtng"  onclick="showPlayersModal('Away')">Rate Away XI and Subs</button>
           </div>
           <div class="col-xs-6 col-sm-4 col-md-4" id="saveFinal" style="display: none">
                 <button class="bbtnd"  onclick="saveRatings()">Submit Match Ratings</button>
           </div>
           <div class="col-xs-12 col-sm-12 col-md-12" id="ratingsStatus">
                 <div class="col-xs-12"><hr></div>
                 <label style="font-size: 12px; color: #003300"></label>
           </div>

       </div>

       <div class="row" id="ratePlayers">

       </div>
   </div>
    <div class="col-xs-12 col-sm-12" id="smallDiv" style="display: none"><hr></div>
      <div class="col-xs-12 col-sm-12 col-md-3 noPad" id="ActionCentre" onmouseover="okToAjax(false,1)" onmouseout="okToAjax(true,1)">
            <div id="searchnfilters" class="col-xs-12 col-sm-12 col-md-12 noPad">
                   <div class="col-xs-12">
                     <input id="searchPandC" class="form-control" style="margin-top: 10px" onkeyup="searchAction()" onkeydown="clearSearchInterval()" onblur="okToAjax(true,2)" onfocus="okToAjax(false,2)" placeholder="Search people/content">
                   </div>
                   <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
                   <?php $intrrr = Interest::all(); ?>
                       <div id="filterdiv" class="col-xs-12 col-sm-12 col-md-12" style="padding: 0px; display: none">

                           <div class="col-xs-5 col-xs-offset-1" style="padding-left: 0px">
                           <select id="IN" class="form-control" name="IN" onchange="searchAction()" style="padding-top: 0px; padding-bottom: 0px; height: 25px">
                                  <option value="0">All</option>
                                  @foreach($intrrr as $int)
                                  <option value="{{$int->id}}">{{$int->interest_name}}</option>
                                  @endforeach
                           </select>
                           </div>
                           <div class="col-xs-4 col-xs-offset-1" style="padding: 0px">
                               <select id="FILTER" class="form-control" name="FILTER" onchange="searchAction()"  style="padding-top: 0px; padding-bottom: 0px; height: 25px">
                                      <option value="latest">Latest</option>
                                      <option value="trending">Trending</option>
                               </select>
                               <br>
                       </div>
                       </div>
                   </div>

             <div id="loadActions" class="col-xs-12 col-sm-12 col-md-12 noPad">

             </div>
             @if ($moreAction > 0)
                 <div id="showMoreAndWaitingActions" class="col-xs-12 col-sm-12 col-md-12" style="text-align: center; display: none">
                     <button id="loadMoreActions" class="btn btn-default" onclick="loadMoreActions()" style="margin-top: 10px">Show more</button>
                     <div id="waitforactions" style="display: none">
                         <img  src="{{asset('Images/icons/waiting.gif')}}">Loading..
                     </div>
                 </div>
             @endif

      </div>

</div>

<!-- Modal to make predictions-->
      <div class="modal fade" id="playersModal" tabindex="-1" role="dialog" aria-hidden="true">
      	<div class="modal-dialog">
      		<div class="modal-content">
      			<div class="modal-header">
      				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      				<h5>Select the playing XI and subs.</h5>
      				<h4 id="matchTitle"></h4>
      			</div>
      			<div id="playerBody" class="modal-body">

    		    </div>
      	</div>
      </div>
      </div>
      <!-- Modal to say saving-->
      <div class="modal fade" id="waitingModal" tabindex="-1" role="dialog" aria-hidden="true">
      	<div class="modal-dialog">
      		<div class="modal-content">
      			<div id="waitingBody" class="modal-body">
                       <div id="waitingMsg"></div>
      		    </div>
      	</div>
      </div>
      </div>


<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('js/star-rating.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/505bef35b56/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script src="{{asset('js/search.js')}}"></script>
<script src="{{asset('js/jsonQ.min.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/raphael.js')}}"></script>
<script src="{{asset('js/morris.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/pages/playerRatings.js')}}"></script>
</body>
</html>