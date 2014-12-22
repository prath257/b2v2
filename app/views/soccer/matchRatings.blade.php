<!DOCTYPE html>
<html>
<head>
    <title>{{SoccerTeam::find($match->hometeam)->name}} vs {{SoccerTeam::find($match->awayteam)->name}} Player Ratings</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <!-- social sharing metadata -->
    <meta property="og:title" content="EPL Player Ratings By {{$author->first_name}} {{$author->last_name}}" />
    <meta property="og:description" content="{{SoccerTeam::find($match->hometeam)->name}} vs {{SoccerTeam::find($match->awayteam)->name}} Player Ratings" />
    <meta property="og:image" content="{{SoccerTeam::find($match->hometeam)->logo}}" />
    <meta property="og:image" content="{{SoccerTeam::find($match->awayteam)->logo}}" />
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/fileUpload.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/home.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/matchRatings.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/notification.css')}}" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=431744100304343&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
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
                 <a href="/soccerSpace" id="sapLogo" style="text-decoration: none; padding-top: 14px" class="navbar-brand"><img src="/Images/icons/soccer.png"></a>
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

            </ul>
        </div>
    </div>
</nav>
<br>
<br>
<br>
<br>
<div class="container-fluid">

<div class="col-xs-12 col-sm-12 col-md-12">
      <div class="col-xs-8 col-sm-4 col-md-3">
      <b style="font-size: medium">{{SoccerLeague::find($match->league)->name}}</b>
      <p>Player Ratings</p>
      </div>
      <div class="col-xs-3 col-sm-3 col-md-2" style="padding: 0px">
              <div class="col-xs-10 col-sm-10 col-md-10">
               <img src="{{SoccerLeague::find($match->league)->logo}}" id="leagueLogo" width="50px" height="50px">
              </div>
              <div class="col-xs-2 col-sm-2 col-md-2">
                  <div class="fb-share-button" style="padding: 5px" data-href="http://b2.com/getMatchRatings/{{$match->id}}/{{$author->id}}"></div><br>
                  <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://b2.com/getMatchRatings/{{$match->id}}/{{$author->id}}" data-text="Check this out" data-count="none" data-hashtags="bbarters" style="margin-top: 2px">Tweet</a>
                  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

              </div>
      </div>
      <div class="col-xs-12" style="font-size: small">
          <i>{{SoccerTeam::find($match->hometeam)->stadium}}</i>
          <br>Kickoff: {{date('d M Y H:i',strtotime($match->kickoff))}}
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12" style="font-size: 12px">
      <div class="col-xs-8 col-sm-4 col-md-3 noPad">Ratings By: <a href="{{route('user',$author->username)}}">{{$author->first_name}}&nbsp;{{$author->last_name}}</a></div>
      <div class="col-xs-4 col-sm-3 col-md-3 noPad"><a class="btn-xs btn-success comBlock" href="{{route('soccerSpace')}}">Give Ratings</a></div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12"><hr></div>
      <div class="col-xs-12 col-sm-6 col-md-6 col-sm-offset-4">
          <div class="col-xs-5 col-sm-3 col-md-3">
              <img src="{{SoccerTeam::find($match->hometeam)->logo}}" id="homeLogo" width="50px" height="50px">
          </div>
          <div class="col-xs-7 col-sm-7 col-md-7">
              <p style="font-size: large"> {{SoccerTeam::find($match->hometeam)->name}}</p>
          </div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-6 col-xs-offset-5 col-sm-offset-6 col-md-offset-6">
      Vs
      </div>
      <div class="col-xs-12">&nbsp;</div>
      <div class="col-xs-12 col-sm-6 col-md-6 col-sm-offset-4">
      <div class="col-xs-5 col-sm-3 col-md-3">
          <img src="{{SoccerTeam::find($match->awayteam)->logo}}" id="awayLogo" width="50px" height="50px">
      </div>
      <div class="col-xs-7 col-sm-7 col-md-7">
          <p style="font-size: large"> {{SoccerTeam::find($match->awayteam)->name}}</p>
      </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12"><hr></div>
      @foreach($ratings as $rating)
      <div class="col-xs-12 col-sm-7 col-md-6 col-md-offset-4 col-sm-offset-4">
      <div class="col-xs-3 col-sm-2 col-md-2">
        <img src="{{SoccerPlayer::find($rating->player_id)->picture}}" width="50px" height="50px">
      </div>
      <div class="col-xs-9 col-sm-10 col-md-10 comment">
      <p><b style="color: #000033">{{SoccerPlayer::find($rating->player_id)->last_name}}</b>:{{$rating->comment}} &nbsp;<b>{{$rating->rating}}/10</b></p>
      </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
      @endforeach


</div>

</div>
<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
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