<!DOCTYPE html>
    <html>
<head>
    <title>Home | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.flipcounter.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/home.css')}}" rel="stylesheet">
    <link href="{{asset('css/morris.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('css/metro.blue.css')}}" />
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/fileUpload.css')}}" rel="stylesheet">
    <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
    <script src="{{asset('js/jquery.metro.js')}}"></script>
    <script src="{{asset('js/raphael.js')}}"></script>
    <script src="{{asset('js/morris.js')}}"></script>

    <link href="{{asset('css/pages/notification.css')}}" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="{{asset('js/search.js')}}"></script>


</head>
<body style="display: none">
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
                <li id="logOut"> <a href="{{route('signout')}}" style="cursor: pointer">Log Out</a></li>
            </ul>
        </div>
    </div>
</nav>
<br>
<br>
<br>
@if(!Auth::user()->pset)
<div class="alert alert-info alert-dismissable col-lg-6" style="margin-left: 5%">
    <strong style="font-size: 24px">Attention! </strong> <a href="{{route('buildProfile')}}" style="font-size: 24px">Complete Profile</a> now and earn yourself upto 300i.
</div>
@endif

<div class="col-lg-9">
    <div class="col-lg-3" style="padding: 0px">
        <div id="menu-group" class="list-group">
            <a id="pivot-home" href="#" class="list-group-item active" onclick="openPivots('home')">
                <h4 class="list-group-item-heading">home</h4>
                <p class="list-group-item-text">BBarters Home.</p>
            </a>
            <a id="pivot-explore" href="#" class="list-group-item" onclick="openPivots('explore')">
                <h4 class="list-group-item-heading">explore</h4>
                <p class="list-group-item-text">Explore all the content on BBarters.</p>
            </a>
            <a id="pivot-writing" href="#" class="list-group-item" onclick="openPivots('writing')">
                <h4 class="list-group-item-heading">writing</h4>
                <p class="list-group-item-text">Write an Article, BlogBook or start a Collaboration.</p>
            </a>
            <a id="pivot-upload" href="#" class="list-group-item" onclick="openPivots('upload')">
                <h4 class="list-group-item-heading">upload</h4>
                <p class="list-group-item-text">Upload and manage your Resources and Media.</p>
            </a>
            <a id="pivot-pollsnquizes" href="#" class="list-group-item" onclick="openPivots('pollsnquizes')">
                <h4 class="list-group-item-heading">polls&quizes</h4>
                <p class="list-group-item-text">Post and take polls and quizes on BBarters.</p>
            </a>
            <a id="pivot-events" href="#" class="list-group-item" onclick="openPivots('events')">
                <h4 class="list-group-item-heading">events</h4>
                <p class="list-group-item-text">Host, attend and manage your Events.</p>
            </a>
            <a id="pivot-recco" href="#" class="list-group-item" onclick="openPivots('recco')">
                <h4 class="list-group-item-heading">recco</h4>
                <p class="list-group-item-text">Recommend links from all over the web to fellow Barters.</p>
            </a>
        </div>
    </div>

    <div class="col-lg-9">

        <input type="hidden" id="current-content" value="home">
        <div id="active-content" class="col-lg-12" style="padding: 0px">

        </div>

        <div id="home-content" class="hidden-content">
        <div class="col-lg-12">
            <div id="read-and-donut" class="col-lg-4" style="padding-right: 15px; padding-left: 0px">
                <img src="{{asset(Auth::user()->profile->profilePic)}}" style="height: 75px; width: 75px">
                <a href="readings" class="btn btn-success"  style="margin-left: 25px">My Readings</a>
                <div id="donut-example" class="col-lg-12" style="height: 300px; padding-left: 0px; padding-right: 0px;"></div>
            </div>
            <div class="col-lg-8" style="text-align: center">
                    <div class="col-lg-12" style="font-size: 30px; font-family: 'Segoe UI'; margin-top: 100px; text-align: center">Balance</div>
                    <div class="col-lg-12">&nbsp;</div>
                    <div id="mycounter" class="col-lg-12">0</div>

            </div>
        </div>
        <div id="promotional-links" class="col-lg-12">
            <div class="col-lg-4" style="text-align: center">
                <a href="{{route('friendList','get')}}">Friends</a><hr style="margin: 5px">
                <a href="{{route('subscribersList','get')}}">Subscriptions</a><hr style="margin: 5px">
                <a href="{{route('settings','getaccount')}}">Account Settings</a>
            </div>
            <div class="col-lg-4" style="text-align: center">
                <a href="{{route('ifcManager')}}">IFC Manager</a><hr style="margin: 5px">
                <a style="cursor: pointer" data-toggle="modal" data-target="#earnIFCModal">Earn IFCs</a>{{--<hr style="margin: 5px">--}}
                {{--<a>Take BBarters Tour</a>--}}
            </div>
            <div class="col-lg-4" style="text-align: center">
                <a href="{{route('diary',Auth::user()->username)}}">Manage Diary</a><hr style="margin: 5px">
                <a href="{{route('QnA',array(Auth::user()->id,'get'))}}">QnA</a><hr style="margin: 5px">
                <a href="{{route('settings','getinterests')}}">Manage Interests</a>
            </div>
        </div>
        </div>

        <div id="explore-content" class="hidden-content">
            <div id="listo" class="col-lg-12" style="padding-top: 5px; padding-bottom: 0px; padding-left: 0px; padding-right: 0px">

            </div>
        </div>

        <div id="writing-content" class="hidden-content">
            <!-- Nav tabs -->
           <ul class="nav nav-tabs" role="tablist" id="myTab">
                <li id="articlesTab"  class="active" role="presentation"><a href="#articleNew" role="tab" data-toggle="tab">Articles</a></li>
                <li id="blogbookTab" role="presentation" onclick="writebb()"><a href="#blogbookNew" role="tab" data-toggle="tab">Blogbooks</a></li>
                <li id="collaborationsTab" role="presentation" onclick="writecollab()"><a href="#collabNew" role="tab" data-toggle="tab">Collaborations</a></li>
           </ul>
            <br>
            <!-- Tab panes -->
            <div class="tab-content">
               @if(Auth::user()->pset)
               <div role="tabpanel" class="tab-pane active fade in" id="articleNew">

               <span style="padding: 15px"><a data-toggle="modal" data-target="#newArticleModal" class="btn btn-success">Write New</a></span>
               <span style="padding: 15px"><a href="{{route('articleDashboard')}}" class="btn btn-success">Manage Articles</a></span>
               <span style="padding: 15px"><a class="btn btn-success" onclick="showSuggestions('Article')" title="See what other Barters would like to read. Tell others what you'd like to read.">Suggestions</a></span>
               <span class="col-lg-12">&nbsp;</span>
               <span class="col-lg-12">
               <p style="color:black">A single page article about anything that's making rounds of your mind,  our templates makes it real easy!</p><br>
               </span>
               @if (Auth::user()->pset)
               <div id="articleDisplay"><div style="text-align: center"><br><img src="{{asset('Images/icons/waiting.gif')}}"> </div> </div>
               @endif
                </div>

                <div role="tabpanel" class="tab-pane fade" id="blogbookNew">
                <span style="padding: 15px"><a data-toggle="modal" data-target="#newBlogBookModal" class="btn btn-success">Write New</a></span>
                <span style="padding: 15px"><a href="{{route('blogBookDashboard')}}" class="btn btn-success">Manage BlogBooks</a></span>
                <span style="padding: 15px"><a class="btn btn-success" onclick="showSuggestions('BlogBook')" title="See what other Barters would like to read. Tell others what you'd like to read.">Suggestions</a></span>
<span class="col-lg-12">&nbsp;</span>
                <span class="col-lg-12">
                <p style="color:black"> Book, have chapter(s) in it and then keep updating it from time-to-time.</p><br>
                </span>
                @if (Auth::user()->pset)
                <div id="blogBookDisplay"><div style="text-align: center"><br><img src="{{asset('Images/icons/waiting.gif')}}"> </div></div>
                @endif
                </div>

               <div role="tabpanel" class="tab-pane fade" id="collabNew">
               <span style="padding: 15px"><a data-toggle="modal" data-target="#newCollaborationModal" class="btn btn-success">Start New</a></span>
               <span style="padding: 15px"><a href="{{route('collaborationsDashboard')}}" class="btn btn-success">Manage Collaborations</a></span>
               <span style="padding: 15px"><a class="btn btn-success" onclick="showSuggestions('Collaboration')" title="See what other Barters would like to read. Tell others what you'd like to read.">Suggestions</a></span>
<span class="col-lg-12">&nbsp;</span>
               <span class="col-lg-12">
               <p style="color:black"> Its same as a BlogBook. Now multiple barters can write it simultaneously, together!</p><br>
               </span>

               @if (Auth::user()->pset)
               <div id="collaborationDisplay"><div style="text-align: center"><br><img src="{{asset('Images/icons/waiting.gif')}}"> </div></div>
               @endif
               </div>
               @endif
            </div>
        </div>

        <div id="upload-content" class="hidden-content">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist" id="myTab">
                <li id="resourceTab" class="active" role="presentation"><a href="#resourceNew" role="tab" data-toggle="tab">Resource</a></li>
                <li id="mediaTab" role="presentation" onclick="mediaData()"><a href="#mediaNew" role="tab" data-toggle="tab">Media</a></li>
            </ul>
             <br>
            <!-- Tab panes -->
            <div class="tab-content">
            @if(Auth::user()->pset)
              <div role="tabpanel" class="tab-pane active fade in" id="resourceNew">
                 <span class="col-lg-2" ><a href="{{route('resourceDashboard')}}" class="btn btn-success">Upload New</a></span>
                     <span class="col-lg-10" style="padding-top: 10px">
                     <p style="color:black">  Resource, like source code, assignments etc. in compressed format.</p><br>
                 </span>

                    @if (Auth::user()->pset)
                   <div id="resDisplay" class="col-lg-12"><div style="text-align: center"><br><img src="{{asset('Images/icons/waiting.gif')}}"> </div></div>
                   @endif
              </div>
              <div role="tabpanel" class="tab-pane fade" id="mediaNew">
                 <span class="col-lg-2" ><a href="{{route('mediaDashboard')}}" class="btn btn-success">Upload New</a></span>
                     <span class="col-lg-10" style="padding-top: 10px">
                       <p style="color:black">  Media, like your guitar song, vocals, video etc. you can make it public also.</p><br>
                     </span>
                 @if (Auth::user()->pset)
                     <div id="mediaDisplay" class="col-lg-12"><div style="text-align: center"><br><img src="{{asset('Images/icons/waiting.gif')}}"> </div></div>
                 @endif
              </div>
            @endif
            </div>
        </div>

        <div id="pollsnquizes-content" class="hidden-content">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist" id="myTab">
                    <li id="quizTab"  class="active" role="presentation"><a href="#quizNew" role="tab" data-toggle="tab">Quiz</a></li>
                    <li id="pollTab" role="presentation" onclick="pollData()"><a href="#pollNew" role="tab" data-toggle="tab">Poll</a></li>
            </ul>
            <br>
            <!-- Tab panes -->
            <div class="tab-content">
            @if(Auth::user()->pset)
              <div role="tabpanel" class="tab-pane active fade in" id="quizNew">
                   <span class="col-lg-2" ><a href="{{route('quizDashboard')}}" class="btn btn-success">Create New</a></span>
                   <span class="col-lg-10" style="padding-top: 10px">
                        <p style="color:black"> quiz and challenge fellow barters for the same, if they score any less than 100% you earn.</p><br>
                   </span>
                  @if (Auth::user()->pset)
                  <div id="quizDisplay" class="col-lg-12"><div style="text-align: center"><br><img src="{{asset('Images/icons/waiting.gif')}}"> </div></div>
                  @endif
              </div>
              <div role="tabpanel" class="tab-pane fade" id="pollNew">
                  <span class="col-lg-2" ><a href="{{route('pollDashboard')}}" class="btn btn-success">Create New</a></span>
                  <span class="col-lg-10" style="padding-top: 10px">
                     <p style="color:black"> poll and see what the fellow barters have voted for.</p><br>
                  </span>
                  @if (Auth::user()->pset)
                    <div id="pollDisplay" class="col-lg-12"><div style="text-align: center"><br><img src="{{asset('Images/icons/waiting.gif')}}"> </div></div>
                  @endif
              </div>
               @endif
            </div>
        </div>

        <div id="events-content" class="hidden-content">
            <div class="col-lg-12">
                    <a href="{{route('createEvent')}}" class="btn btn-success col-lg-2">Create Event</a>

                    <a href="{{route('manageEvents')}}" class="btn btn-success col-lg-2 col-lg-offset-3">Manage Events</a>

                    <a href="{{route('myEvents')}}" class="btn btn-success col-lg-2 col-lg-offset-3">Attending</a>

            </div>
            <div class="col-lg-12">&nbsp;</div>

            <div class="col-lg-12" style="text-align: center">

                <hr style="margin: 0px">

                <ul class="nav nav-pills" style="margin: 10px">
                    <?php $i=1; ?>
                    <li class="catButtons active"><a href="#" onclick="showEvents(this,'all',{{$i}})">All</a></li>
                    <div id="waitingall" style="display: none">
                    <img  src="{{asset('Images/icons/waiting.gif')}}" height="35px" width="35px" >Loading..
                    </div>
                    @foreach ($interests as $int)
                    <?php $i++; ?>
                    <li class="catButtons"><a href="#" onclick="showEvents(this,{{$int->id}},{{$i}}); return false;">{{$int->interest_name}}</a></li>
                    @endforeach

                </ul>

                <input type="hidden" id="noOfInterests" value="{{$i}}">

                <h4 id="loading" style="font-family: 'Segoe UI Light', 'Helvetica Neue', 'RobotoLight', 'Segoe UI', 'Segoe WP', sans-serif; text-align: center; display: none">loading...</h4>
            <div id="eventsall" class="catEvents">
            @if (count($events) > 0)
                <div id="appendEventsall" class="col-lg-12" style="padding: 0px">
                <div class="col-lg-12" style="padding: 0px">
                @foreach ($events as $e)
                    <div class="col-lg-4" style="color: #000000">
                        <div class="thumbnail">
                            <img src="{{$e->cover}}" class="col-lg-12" style="height: 150px">
                            <div class="caption" style="padding-bottom: 0px">
                                <p style="text-transform: none; font-size: 20px; padding: 0px">{{$e->name}}</p>
                                <p>
                                    Venue: {{$e->venue}}<br>
                                    Date & Time: {{$e->datetime}}<br>
                                    Hosted by <a href="{{route('user',$e->getHost->username)}}" target="_blank" style="color: #3a5a97">{{$e->getHost->first_name}} {{$e->getHost->last_name}}</a>
                                </p>
                                <a href="{{route('event',$e->id)}}" style="text-decoration: underline; color: #3a5a97">Show Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>

                </div>
                @if ($count > 0)
                <button id="loadMoreEventsall" class="btn btn-default" onclick="loadMoreEvents('all',1)">Load more</button><div id="eventWaitall" style="display: none"><img src="{{asset('Images/icons/waiting.gif')}}">Loading..</div>
                <br><br>
                @endif
            @else
                <div style="text-align: center">Looks like people are getting too busy with their work these days. No events!</div>
            @endif
            </div>

            @foreach($interests as $int)
                    <div id="events{{$int->id}}" class="catEvents"></div>
            @endforeach

            </div>
        </div>

        <div id="recco-content" class="hidden-content">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
            <input type="hidden" id="recco-tab" value="all">
              <li role="presentation" class="active recco-duo-tabs"><a href="#all-recco" role="tab" data-toggle="tab" onclick="toggleTab('all')">All Recommendations</a></li>
              <li role="presentation" class="recco-duo-tabs"><a href="#my-recco" role="tab" data-toggle="tab" onclick="toggleTab('my')">My Recommendations</a></li>
              <li role="presentation" class="col-lg-3"><input id="searchRecco" type="text" class="form-control" placeholder="Search recco or provider." onkeyup="upRecco(event)" onkeydown="downRecco()" onfocus="cacheMarkup()"></li>
              <li role="presentation" class="col-lg-3" style="padding-left: 0px">
              <div class="col-lg-4" style="padding-left: 0px; padding-right: 5px; padding-top: 5px">
                <small><b>SORT BY: </b></small>
              </div>
              <div class="col-lg-8" style="padding: 0px">
                  <select id="RECCO-FILTER" class="form-control" name="RECCO-FILTER" onchange="sortRecco()" style="padding-left: 0px; padding-right: 5px">
                     <option value="created_at">Latest</option>
                     <option value="hits">Popular</option>
                  </select>
              </div>
              </li>
            </ul>

        <div style="padding: 5px" class="pull-right"><button class="btn btn-warning" data-toggle="modal" data-target="#newRecommendationModal">+ New</button></div>
            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="all-recco">

              </div>
              <div role="tabpanel" class="tab-pane" id="my-recco">

              </div>
            </div>
        </div>
    </div>

</div>

<div class="col-lg-3" id="ActionCentre" style="padding-right: 0px" onmouseover="okToAjax(false,1)" onmouseout="okToAjax(true,1)">
<div id="searchnfilters" class="col-lg-12">

<input id="searchPandC" class="col-lg-9 form-control" style="margin-top: 15px" onkeyup="searchAction()" onkeydown="clearSearchInterval()" onblur="okToAjax(true,2)" onfocus="okToAjax(false,2)" placeholder="Search people and content.">
<br><br><br id="removethis">
<?php $intrrr = Interest::all(); ?>
<div id="filterdiv" class="col-lg-12" style="padding: 0px; display: none">
<div class="col-lg-1" style="padding-top: 2px; padding-left: 0px; word-wrap: normal">In</div>
<div class="col-lg-5" style="padding-left: 0px">
<select id="IN" class="form-control" name="IN" onchange="searchAction()" style="padding-top: 0px; padding-bottom: 0px; height: 25px">
       <option value="0">All</option>
       @foreach($intrrr as $int)
       <option value="{{$int->id}}">{{$int->interest_name}}</option>
       @endforeach
</select>
</div>
<div class="col-lg-2" style="padding-top: 2px; padding-left: 0px">Sort</div>
<div class="col-lg-4" style="padding: 0px">
<select id="FILTER" class="form-control" name="FILTER" onchange="searchAction()"  style="padding-top: 0px; padding-bottom: 0px; height: 25px">
       <option value="latest">Latest</option>
       <option value="trending">Trending</option>
</select>
<br>
</div>
</div>
</div>

    <div id="loadActions"></div>
    @if ($moreAction > 0)
        <div id="showMoreAndWaitingActions" style="text-align: center; display: none">

        <button id="loadMoreActions" class="btn btn-default" onclick="loadMoreActions()" style="margin-top: 10px">Show more</button>
        <div id="waitforactions" style="display: none">
            <img  src="{{asset('Images/icons/waiting.gif')}}">Loading..
            </div>
        </div>
    @endif
</div>

<!-- IFC Manager -->
<div class="modal fade" id="earnIFCModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Earn IFC's</h4>
            </div>
            <div class="modal-body">
                <fieldset>
                    <div class="col-lg-6">
                        The simplest way, you can invite other people to join BBarters. You'll get a link for every person you invite. Share it with them, and if they click on the link and sign up, you earn 300 IFCs.<br>
                        <button type="button" class="btn btn-block" onclick="showInviteModal()">Invite People</button>
                    </div>
                    <div class="col-lg-6">
                        You can create Blogbooks, Articles, Collaborations, Resources, Quizes, Polls and earn IFCs. Start Here!<br><br><br>
                        <button class="btn btn-block" onClick="showContentModal()">Create Content</button>
                    </div>
                    <div class="col-lg-12">&nbsp;</div>
                    <div class="col-lg-12">
                        Saw anything going wrong with our code? Want us to improve something? Write us the issue/suggestion within minimal words/screenshots. If found appropriate, you'll be credited upto 500 IFCs.
                        <a href="{{route('reportBug')}}" class="btn btn-alert col-lg-12">Report Bug/ Suggestion</a>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newRecommendationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">New Recommendation</h4>
            </div>
            <div class="modal-body">
                <fieldset style="min-height: 200px">
                    <form id="recco-form">
                        <div class="col-lg-10">
                            <input type="text" id="reccoLink" class="form-control" name="reccoLink" placeholder="Paste the link here.">
                        </div>
                        <button type="submit" id="recco-submit" class="col-lg-2 btn btn-primary" onclick="postRecommendation()">Go</button>
                    </form>

                    <div id="recco-data" class="col-lg-12">

                    </div>

                </fieldset>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createContentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Create Content</h4>
            </div>
            <div class="modal-body">
                <fieldset>
                    <div class="col-lg-12">
                        On BBarters you can come up with content and put up a price for it. If anyone wants to read/download it, he/she has to purchase it using IFCs ('InfoCurrency', our very own term for virtual currency.). And then obviously, these IFCs are transferred to your account. Its just like dealing content for IFCs!<br>
                        You can use these IFCs to read what others have posted and have some good time here.
                        <br>
                        <br>

                        <div class="col-lg-6">
                            <a href="{{route('articleDashboard')}}" style="text-decoration: none" target="_blank"><b>ARTICLE:</b></a><br>
                            A page long write-up regarding anything that excites you or drives you to write.<br>
                            <hr>
                        </div>

                        <div class="col-lg-6">
                            <a href="{{route('blogBookDashboard')}}" style="text-decoration: none" target="_blank"><b>BLOGBOOK:</b></a><br>
                            Start witing a book and keep on updating it from time to time by adding more and more chapters to it.<br>
                            <hr>
                        </div>

                        <div class="col-lg-6">
                            <a href="{{route('collaborationsDashboard')}}" style="text-decoration: none" target="_blank"><b>COLLABORATION:</b></a><br>
                            Collaborate with people who could collectively write well about a particular topic.<br>
                            <hr>
                        </div>

                        <div class="col-lg-6">
                            <a href="{{route('resourceDashboard')}}" style="text-decoration: none" target="_blank"><b>RESOURCE:</b></a><br>
                            Upload a zip file containing files that people would find useful and be interested to download.<br>
                            <hr>
                        </div>

                        <div class="col-lg-6">
                            <a href="{{route('quizDashboard')}}" style="text-decoration: none" target="_blank"><b>QUIZ:</b></a><br>
                            Create a quiz that people would like to take. Their earning depends on how they score and how difficult the quiz is!<br>
                        </div>

                        <div class="col-lg-6">
                            <a href="{{route('pollDashboard')}}" style="text-decoration: none" target="_blank"><b>POLL:</b></a><br>
                            Put up a question and have all people have their say on it. Every time anyone votes for his choice, you earn IFCs.<br>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="inviteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="closeInviteModal()" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Invite People & Earn 300 IFCs</h4>
            </div>
            <div id="inviteBody" class="modal-body">
                <h6  id="inviteModalLabel">Please enter the name and the e-mail of the person whom you wish to invite yo generate the invite link.</h6>
                <br>
                <form id="inviteForm" class="form-horizontal">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Name</label>
                            <div class="col-lg-5">
                                <input id="inviteName" type="text" class="form-control" name="name"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email address</label>
                            <div class="col-lg-5">
                                <input id="inviteEmail" type="text" class="form-control" name="email" autocomplete="off" />
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" id="inviteSubmit" onclick="postInvite()" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
                <div class="col-lg-12">&nbsp;</div>
                <div id="inviteLinkAndErrors" class="well" style="display: none"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Transfer IFCs</h4>
            </div>
            <div class="modal-body">

                <form id="transferForm" class="form-horizontal">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">IFCs</label>
                            <div class="col-lg-5">
                                <input id="transferIFC" name="transferIFC" class="form-control" style="width: 200px">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Friend</label>
                            <div class="col-lg-5">
                                <select id="friend" class="form-control" name="friend">
                                    <option value="">-- Select a friend --</option>
                                    @foreach($friends as $friend)
                                    <option value="{{$friend->id}}">{{$friend->first_name}} {{$friend->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3" id="submitTransfer">
                                <button type="submit" id="transferSubmit" onclick="postTransfer()" class="btn btn-primary">Submit</button>
                            </div>

                            <div class="col-lg-3 col-lg-offset-3" id="waiting" style="display: none" >
                            <img src="{{asset('Images/icons/waiting.gif')}}">Saving..
                            </div>

                        </div>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
</div><!-- End of IFC Manager -->

<!-- NewCollaboration Modal -->
<div class="modal fade" id="newCollaborationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">New Collaboration</h4>
            </div>
            <div id="inviteBody" class="modal-body">
                {{Form::open(array('route'=>'newCollaboration','id'=>'newCollaborationForm','class'=>'form-horizontal','files'=>true))}}
                <!--<form id="newCollaborationForm" method="post" action="{{route('newCollaboration')}}" enctype="multipart/form-data" class="form-horizontal">-->
                    <fieldset>

                        <img id="defaultCollabCover" class="col-lg-6 col-lg-offset-3" style="height: 200px" src="{{asset('Images/Collaboration.jpg')}}">

                        <div class="col-lg-12">&nbsp;</div>

                        <div class="col-lg-6 col-lg-offset-3 fileUpload btn btn-default">
                            <span>Upload Collaboration Cover</span>
                            <input type="file" id="uploadCollabCover" class="upload" name="uploadCollabCover" style="width: 100%" onchange="changeCollaborationCover()" />
                        </div>

                        <div class="col-lg-12">&nbsp;</div>

                        <div class="form-group">
                            <label class=" col-lg-3 control-label">Title</label>
                            <div class="col-lg-7">
                                <input type="text" id="title" class="form-control" name="title" placeholder="Project Title" autocomplete="off" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" col-lg-3 control-label">Short Description</label>
                            <div class="col-lg-7">
                                <textarea id="shortDescription" class="form-control" name="shortDescription" rows="3" placeholder="A short and precise description for your new Collaboration."></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Category</label>
                            <div class="col-lg-7">
                                <select id="category" class="form-control" name="category">
                                    <option value="">Select a Category</option>
                                    @foreach($categories as $cat)
                                    <option value="{{$cat->id}}">{{$cat->interest_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Cost</label>
                            <div class="col-lg-7">
                                <div class="input-group">
                                    <input id="ifc" name="ifc" type="text" class="form-control" value="0" autocomplete="off">
                                    <span class="input-group-addon">IFCs</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">&nbsp;</div>
                        <div class="form-group col-lg-offset-1">
                            <div class="col-lg-3" style="text-align: right">
                                <strong>NOTE: </strong>
                            </div>
                            <div class="col-lg-7">
                                You can add more people to your collaboration only when your collaboration contains at least one chapter posted by you.
                            </div>
                        </div>
                        <div class="col-lg-12">&nbsp;</div>

                    </fieldset>
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" id="newCollaborationSubmit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- End of NewCollaboration Modal -->

<!-- NewBlogBook Modal -->
<div class="modal fade" id="newBlogBookModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">New BlogBook</h4>
            </div>
            <div id="inviteBody" class="modal-body">
                {{Form::open(array('route'=>'postBlogBookDashboard','id'=>'newBlogBookForm','class'=>'form-horizontal','files'=>true))}}
                <!--<form id="newBlogBookForm" method="post" action="{{route('postBlogBookDashboard')}}" enctype="multipart/form-data" class="form-horizontal">-->
                    <fieldset>

                        <img id="defaultBBCover" class="col-lg-6 col-lg-offset-3" style="height: 200px" src="{{asset('Images/BlogBook.jpg')}}">

                        <div class="col-lg-12">&nbsp;</div>

                        <div class="col-lg-6 col-lg-offset-3 fileUpload btn btn-default">
                            <span>Upload BlogBook Cover</span>
                            <input type="file" id="uploadBBCover" class="upload" name="uploadBBCover" style="width: 100%; padding: 0px" onchange="changeBlogBookCover()" />
                        </div>

                        <div class="col-lg-12">&nbsp;</div>

                        <div class="form-group">
                            <label class=" col-lg-3 control-label">Title</label>
                            <div class="col-lg-7">
                                <input type="text" id="title" class="form-control" name="title" placeholder="BlogBook Title" autocomplete="off" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" col-lg-3 control-label">Short Description</label>
                            <div class="col-lg-7">
                                <textarea id="shortDescription" class="form-control" name="shortDescription" rows="3" placeholder="A short and precise description for your new BlogBook."></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Category</label>
                            <div class="col-lg-7">
                                <select id="category" class="form-control" name="category">
                                    <option value="">Select a Category</option>
                                    @foreach($categories as $cat)
                                    <option value="{{$cat->id}}">{{$cat->interest_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Cost</label>
                            <div class="col-lg-7">
                                <div class="input-group">
                                    <input id="ifc" name="ifc" type="text" class="form-control" value="0" autocomplete="off">
                                    <span class="input-group-addon">IFCs</span>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" id="newBlogBookSubmit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                {{Form::close()}}

            </div>
        </div>
    </div>
</div>
<!-- End of NewBlogBook Modal -->

<!-- Modal to input initial details of the article -->
<div class="modal fade" id="newArticleModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">New Article</h4>
			</div>
			<div id="inviteBody" class="modal-body">

                {{Form::open(array('route'=>'postArticleDashboard','id'=>'newArticleForm','class'=>'form-horizontal','files'=>true))}}
				<!--<form id="newArticleForm" class="form-horizontal" method="post" action="{{route('postArticleDashboard')}}" enctype="multipart/form-data">-->
					<fieldset>

                        <div class="form-group">
							<label class=" col-lg-3 control-label">Select a category:</label>
							<div class="col-lg-6">
								<select id="Artcategory" class="form-control" name="Artcategory" onchange="openNewArticleModal()">
                                    <option value="">Select from list</option>
                                    @foreach($categories as $cat)
                                    <option value="{{$cat->id}}">{{$cat->interest_name}}</option>
                                    @endforeach
                                </select>
							</div>
						</div>
                        {{--@foreach ($categories as $cat)
                            <a href="#" onclick="openNewArticleModal('{{$cat->interest_name}}',{{$cat->id}})" class="btn btn-success">+ {{$cat->interest_name}}</a>
                        @endforeach--}}
                        <div id="optionsDiv" class="col-lg-12">

                        </div>

                        <input type="hidden" id="articleType" name="articleType" value="Article">


                        <div class="col-lg-12">&nbsp;</div>

                        <img id="defaultArtCover" class="col-lg-6 col-lg-offset-3" style="height: 200px" src="{{asset('Images/Article.png')}}">

                        <div class="col-lg-12">&nbsp;</div>

                        <div class="col-lg-6 col-lg-offset-3 fileUpload btn btn-default">
                            <span>Upload Article Cover</span>
                            <input type="file" id="uploadArtCover" class="upload" name="uploadArtCover" style="width: 100%" onchange="changeArticleCover()" />
                        </div>

                        <div class="col-lg-12">&nbsp;</div>

						<div class="form-group">
							<label class=" col-lg-3 control-label">Title</label>
							<div class="col-lg-6">
								<input type="text" id="title" class="form-control" name="title" placeholder="Article Title" autocomplete="off" />
							</div>
						</div>

                        <div class="form-group">
                            <label class=" col-lg-3 control-label">Short Description</label>
                            <div class="col-lg-7">
                                <textarea id="shortDescription" class="form-control" name="shortDescription" rows="3" placeholder="A short and precise description."></textarea>
                            </div>
                        </div>

						<div class="form-group">
							<label class="col-lg-3 control-label">Cost</label>
							<div class="col-lg-6">
								<div class="input-group">
									<input id="ifc" name="ifc" type="text" class="form-control" value="0" autocomplete="off">
									<span class="input-group-addon">IFCs</span>
								</div>
							</div>
						</div>

					</fieldset>
					<div class="form-group">
						<div class="col-lg-9 col-lg-offset-3">
							<button type="submit" id="newArticleSubmit" class="btn btn-primary">Submit</button>
						</div>
					</div>
                {{Form::close()}}

			</div>
		</div>
	</div>
</div>

<!-- Modal to show the sharing of Article -->

<div class="modal fade" id="suggestionsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="suggestion-label"></h4>
            </div>
            <div class="modal-body">
                <fieldset>
                    <div id="suggetsion-data" class="col-lg-12" style="max-height: 350px; overflow: auto">

                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="current-suggestion-type" value="null">

<div class="modal fade" id="newSuggestionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">New Suggestion</h4>
            </div>
            <div class="modal-body">
                <fieldset>
                <form id="newSuggestionForm">
                    <div class="form-group">
                        <textarea id="suggestionText" name="suggestionText" class="form-control" rows="3" placeholder="Tell us about what you'd like others to write."></textarea>
                    </div>
                    <div class="form-group">
                    <label>Category</label>
                        <select id="suggestionCategory" class="form-control" name="suggestionCategory">
                               <option value="">Select a category</option>
                               @foreach($categories as $cat)
                               <option value="{{$cat->id}}">{{$cat->interest_name}}</option>
                               @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button id="suggestionSubmit" type="submit" class="btn btn-default" onclick="submitSuggestion()">Submit</button>
                    </div>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/pages/home.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/jstween-1.1.min.js')}}"></script>
<script src="{{asset('js/jquery.flipcounter.js')}}"></script>
{{--<script src="{{asset('js/jquery.bpopup.min.js')}}"></script>--}}
</body>
</html>