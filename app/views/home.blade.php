<!DOCTYPE html>
    <html>
<head>
    <title>Home | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/home.css')}}" rel="stylesheet">
    <link href="{{asset('css/morris.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('css/metro.blue.css')}}" />
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
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
                <li id="extra-spaces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                <li id="notificationli" onclick="getNoti()"><a href="#"><span id="no_of_notification" class="text-primary" style="color: white; background-color: tomato; padding-left: 5px; padding-right: 5px;  border-radius: 50%; visibility: hidden">0</span>&nbsp;&nbsp;Notifications <i class="fa fa-sort-desc"></i></a></li>
                                                                    <div id="notificationModal2" style="max-height: 350px; overflow-y: auto; overflow-x: hidden">
                                                                        <div id="notificationResultsModal">
                                                                            <div  class="modal-body" style="padding-left: 10px; padding-top: 15px; padding-bottom: 15px; padding-right: 10px">
                                                                                <div id="notificationText"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                <!--<li id="ifcManager" class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">IFC Manager<b class="caret"></b></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu2">
                        <li><a href="#" data-toggle="modal" data-target="#transferModal">Transfer IFCs</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#earnIFCModal">Earn IFCs</a></li>
                    </ul>
                </li>-->
                <li id="IFCManager"> <a href="{{route('ifcManager')}}" style="cursor: pointer">IFC Manager</a></li>
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
<div class="metro-pivot blue col-lg-9" style="padding-left: 20px">
    <div class="pivot-item">
        <h3>Explore</h3>
        <br>
        <div id="read-and-donut" class="col-lg-3" style="padding-right: 15px; padding-left: 0px">
            <a href="readings" class="btn btn-success" >My Readings</a>
            <div id="donut-example" class="col-lg-12" style="height: 300px; padding-left: 0px; padding-right: 0px;"></div>
        </div>

        <div id="listo" class="col-lg-9" style="padding-top: 5px; padding-bottom: 0px; padding-left: 0px; padding-right: 0px">

        </div>


     </div>
    <div class="pivot-item">
        <h3>Write</h3>
        <p> Manage your content, blogbooks and Collaborations</p>
        <br>
        <div class="col-lg-4">
            <div style="text-align: center">
            <a href="articleDashboard" class="btn btn-success">+ Content</a>
            <br>
            <br>
            <p style="color:black; font-family: arial, helvetica, sans-serif">A single page article about anything that's making rounds of your mind.</p>
            </div>
            <div id="donut-articles" style="height: 250px; width: 270px"></div>
            <br>
            <br>
            <ul id="articlesData" class="nav nav-pills ranges">
                <li style="padding: 10px">Days:</li>
                <li id="a7"><a href="#" data-range='7'>7</a></li>
                <li id="a30"><a href="#" data-range='30'>30</a></li>
                <li id="a60"><a href="#" data-range='60'>60</a></li>
                <li id="a90" class="active"><a href="#" data-range='90'>90</a></li>
            </ul>
            <br>
        </div>

        <div class="col-lg-4">
        <div style="text-align: center">
            <a href="blogBookDashboard" class="btn btn-success">+ BlogBooks</a>
            <br>
            <br>
            <p style="color:black; font-family: arial, helvetica, sans-serif">You can start with a book, have chapters in it and keep updating it time-to-time.</p>
        </div>
            <div id="donut-books" style="height: 250px; width: 270px"></div>
            <br>
            <br>
            <ul id="booksData" class="nav nav-pills ranges">
                <li style="padding: 10px">Days:</li>
                <li id="b7"><a href="#" data-range='7'>7</a></li>
                <li id="b30"><a href="#" data-range='30'>30</a></li>
                <li id="b60"><a href="#" data-range='60'>60</a></li>
                <li id="b90" class="active"><a href="#" data-range='90'>90</a></li>
            </ul>
            <br>
        </div>
        <div class="col-lg-4">
        <div style="text-align: center">
            <a href="{{route('collaborationsDashboard')}}" class="btn btn-success">+ Collaborations</a>
            <br><br>
            <p style="color:black; font-family: arial, helvetica, sans-serif">Similar to a BlogBook, but written my multiple barters acting as contributors.</p>
        </div>
            <div id="donut-collaborations" style="height: 250px; width: 280px"></div>
            <br>
            <br>
            <ul id="collaborationsData" class="nav nav-pills ranges">
                <li style="padding: 10px">Days:</li>
                <li id="c7"><a href="#" data-range='7'>7</a></li>
                <li id="c30"><a href="#" data-range='30'>30</a></li>
                <li id="c60"><a href="#" data-range='60'>60</a></li>
                <li id="c90" class="active"><a href="#" data-range='90'>90</a></li>
            </ul>
        </div>

    </div>

    <div class="pivot-item">
        <h3>Upload</h3>
        <p> Upload useful resources for community or media files for your private use</p>
        <br>
        <div class="col-lg-6">

        </div>
        <div class="col-lg-6">
            <a href="resourceDashboard" class="col-lg-3 btn btn-success">Resources</a>

            <a href="mediaDashboard" class="col-lg-3 col-lg-offset-1 btn btn-warning">Media</a>
         </div>
        <div id="resources-stats-container" style="height:370px;width: 280px;"></div>
        <br>
        <ul id="resourcesData" class="nav nav-pills ranges">
            <li id="r7" ><a href="#" data-range='7'>7 Days</a></li>
            <li id="r30"><a href="#" data-range='30'>30 Days</a></li>
            <li id="r60"><a href="#" data-range='60'>60 Days</a></li>
            <li id="r90" class="active"><a href="#" data-range='90'>90 Days</a></li>
        </ul>

    </div>

    <div class="pivot-item">
        <h3>Polls&Quizes</h3>
        <p> Conduct polls or undertake quizes of your interest to earn quick IFCs</p>

        <div class="col-lg-6">

       </div>
        <div class="col-lg-6">
            <a href="quizDashboard" class="col-lg-3 btn btn-warning">Quizes</a>&nbsp;&nbsp;&nbsp;
            <a href="pollDashboard" class="col-lg-3 col-lg-offset-1 btn btn-success">Polls</a>
         </div>
        <div id="quiz-stats-container"  style="height:370px;width:280px"></div>
        <br>
        <br>
        <ul id="quizData" class="nav nav-pills ranges">
            <li id="q7"><a href="#" data-range='7'>7 Days</a></li>
            <li id="q30"><a href="#" data-range='30'>30 Days</a></li>
            <li id="q60"><a href="#" data-range='60'>60 Days</a></li>
            <li id="q90"  class="active"><a href="#" data-range='90'>90 Days</a></li>
        </ul>

    </div>

    <div class="pivot-item">
        <h3>Events</h3>
        <p>Create, attend and manage your events.</p>
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
                <div class="col-lg-3" style="color: #000000">
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
    <div class="pivot-item">
        <h3>recco</h3>
        <br>
        <div>You can recommend links to fellow Barters from web pages around the world or visit recommendations made by other Barters. Every Barter earns 20<i>i</i> for every recommendation that he/she makes.</div>
        <br>
        <button class="btn btn-warning" data-toggle="modal" data-target="#newRecommendationModal">Make new Recommendation</button>

        <br><br>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
        <input type="hidden" id="recco-tab" value="all">
          <li role="presentation" class="active recco-duo-tabs"><a href="#all-recco" role="tab" data-toggle="tab" onclick="toggleTab('all')">All Recommendations</a></li>
          <li role="presentation" class="recco-duo-tabs"><a href="#my-recco" role="tab" data-toggle="tab" onclick="toggleTab('my')">My Recommendations</a></li>
          <li role="presentation" class="col-lg-4"><input id="searchRecco" type="text" class="form-control" placeholder="Search provider or recommendation." onkeyup="upRecco(event)" onkeydown="downRecco()" onfocus="cacheMarkup()"></li>
          <li role="presentation" class="col-lg-3">
          <div class="col-lg-5" style="padding-left: 0px; padding-right: 5px; padding-top: 5px">
            <small><b>SORT BY: </b></small>
          </div>
          <div class="col-lg-7" style="padding: 0px">
              <select id="RECCO-FILTER" class="form-control" name="RECCO-FILTER" onchange="sortRecco()" style="padding-left: 0px; padding-right: 5px">
                 <option value="created_at">Latest</option>
                 <option value="hits">Popular</option>
              </select>
          </div>
          </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="all-recco">

          </div>
          <div role="tabpanel" class="tab-pane" id="my-recco">

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


<div class="modal fade" id="notifyModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div id="notificationModal" class="modal-dialog">

        <div class="modal-content">

            <div  class="modal-body">
                <fieldset id="notifyText"></fieldset>
            </div>
        </div>

    </div>
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

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/pages/home.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/jquery.bpopup.min.js')}}"></script>
</body>
</html>