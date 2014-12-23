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
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/fileUpload.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/notification.css')}}" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body  style="display: none; ">
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
                <div id="notificationModal2" style="max-height: 350px; overflow-y: scroll; overflow-x: auto">
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
<div class="row">
@if(Session::has('ifcAdded'))
  <div class="col-xs-12 col-sm-12 col-md-12">
    <input type="hidden" id="ifcAdded" value="{{Session::get('ifcAdded')}}">
    {{Session::put('ifcAdded', 'no')}}
   </div>
@endif
@if(!Auth::user()->pset)
<div class="alert alert-info alert-dismissable col-md-7" style="margin-left: 5%">
    <strong style="font-size: 24px">Attention! </strong> <a href="{{route('buildProfile')}}" style="font-size: 24px">Complete Profile</a> now and earn yourself upto 300i.
</div>
@endif
<div class="col-xs-12 col-sm-12 col-md-12">
<!--Here we put the Menu and content area -->
 <div class="col-xs-12 col-sm-8 col-md-9">
    <div class="col-xs-12 col-sm-12 col-md-12 noPad">

      <div class="btn-group col-xs-12 col-sm-12 col-md-12 col-md-offset-3 noPad" id="topMenu" role="group">
          <button type="button" class="btn bbtng" onclick="openPivots('home')"><i class="fa fa-home"></i>&nbsp;</button>
          <button type="button" class="btn bbtn "  onclick="openPivots('explore')">explore</button>
          <button type="button" class="btn bbtng"  onclick="openPivots('writing')">&nbsp;write&nbsp;</button>
          <button type="button" class="btn bbtnd"  onclick="openPivots('upload')">upload</button>
          <button type="button" class="btn bbtnr "  onclick="openPivots('pollsnquizes')">poll/quiz</button>
          <button type="button" class="btn bbtnd"  onclick="openPivots('recco')">recco</button>
      </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 noPad">
      <div id="home-content" class="hidden-content">
            <div class="col-xs-12 col-sm-12 col-md-12 noPad"><hr></div>
            <div class="col-xs-8 col-sm-8 col-md-8 noPad">
                <div class="col-xs-12 col-sm-11 col-md-11 col-sm-offset-1 noPad">
                <div class="col-xs-5 col-sm-4 col-md-2 noPad">
                 <img src="{{asset(Auth::user()->profile->profilePic)}}" style="height: 50px; width:50px">
                </div>
                <div class="col-xs-7 col-sm-8 col-md-10" style="padding-left: 5px;">
                   <p class="headMass">{{Auth::user()->first_name}}</p> <a href="readings">Readings</a>
                </div>
                </div>
                <div class="col-xs-12">&nbsp;</div>
                <div id="donut-example" class="col-xs-12 col-sm-7 col-md-4 noPad" style="height: 200px;"></div>
                <div id="mycounter" class="col-xs-0 col-sm-12 col-md-5 col-md-offset-3 noPad" style="display: none; padding-top:35px;">0</div>

            </div>
            <div class="col-xs-4 col-sm-4 col-md-2 col-md-offset-2">
                    <button class="bbtnd mb" onclick="location='/soccerSpace';">SoccerSpace</button><hr style="margin: 10px">
                    <button class="bbtn mb" onclick="location='/friendList/get'; ">Friends</button><hr style="margin: 10px">
                    <button class="bbtng mb" onclick="location='/subscribersList/get'; "> Subscriptions</button><hr style="margin: 10px">
                    <button class="bbtnd mb" onclick="location='/settings/getaccount'; ">Settings</button><hr style="margin: 10px">
                    <button class="bbtn mb" data-toggle="modal" data-target="#earnIFCModal">Earn IFCs</button><hr style="margin: 10px">
                    <button class="bbtng mb" onclick="location='/ifcManager';">IFC Manager</button><hr style="margin: 10px">
                    {{--<a>Take BBarters Tour</a>--}}
                    <button class="bbtnd mb" onclick="location='/QnA/{{Auth::user()->id}}/get';">QnA</button><hr style="margin: 10px">
                    <button class="bbtn mb" onclick="location='/diary/{{Auth::user()->username}}';">Write Diary</button><hr style="margin: 10px">
                    <button class="bbtng mb" onclick="location='/settings/getinterests';">Interests</button>
            </div>
       </div>
       <!-- here the home UI ends and now starts the explore one-->
           <div id="explore-content" class="hidden-content" style="display: none">
                <div class="col-xs-12 col-sm-12 col-md-12 noPad"><hr></div>
                   <div id="listo" class="col-xs-12 col-sm-12 col-md-12" style="padding-top: 5px; padding-bottom: 0px; padding-left: 0px; padding-right: 0px">

                   </div>
           </div>
           <!--Here we start the write content -->
            <div id="writing-content" class="hidden-content" style="display: none">
                      <div class="col-xs-12 col-sm-12 col-md-12 noPad"><hr></div>
                       <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist" id="myTab">
                           <li id="articlesTab"  class="active" role="presentation"><a href="#articleNew" role="tab" data-toggle="tab">Articles</a></li>
                           <li id="blogbookTab" role="presentation" onclick="writebb()"><a href="#blogbookNew" role="tab" data-toggle="tab">Blogbooks</a></li>
                           <li id="collaborationsTab" role="presentation" onclick="writecollab()"><a href="#collabNew" role="tab" data-toggle="tab">Collab</a></li>
                      </ul>
                       <br>
                       <!-- Tab panes -->
                       <div class="tab-content">
                          @if(Auth::user()->pset)
                          <div role="tabpanel" class="tab-pane active fade in" id="articleNew">

                          <span><a data-toggle="modal" data-target="#newArticleModal" class="bbtng">+New</a></span>
                          <span style="padding: 5px"><a href="{{route('articleDashboard')}}" class="bbtn">Manage</a></span>
                          <span style="padding: 5px"><a class="bbtnr" onclick="showSuggestions('Article')" title="See what other Barters would like to read. Tell others what you'd like to read.">Suggestions</a></span>
                          <span class="col-xs-12 col-sm-12 col-md-12">&nbsp;</span>
                          <div class="col-xs-12 col-sm-12 col-md-12">
                          <p style="color:black">A single page article about anything that's making rounds of your mind,  our templates makes it real easy!</p><br>
                          </div>
                          @if (Auth::user()->pset)
                          <div id="articleDisplay">
                               <div style="text-align: center"><br><img src="{{asset('Images/icons/waiting.gif')}}"></div>
                          </div>
                          @endif
                          </div>

                           <div role="tabpanel" class="tab-pane fade" id="blogbookNew">
                           <span><a data-toggle="modal" data-target="#newBlogBookModal" class="bbtng">+New</a></span>
                           <span style="padding: 5px"><a href="{{route('blogBookDashboard')}}" class="bbtn">Manage</a></span>
                           <span style="padding: 5px"><a class="bbtnr" onclick="showSuggestions('BlogBook')" title="See what other Barters would like to read. Tell others what you'd like to read.">Suggestions</a></span>
                           <span class="col-xs-12 col-sm-12 col-md-12">&nbsp;</span>
                           <span class="col-xs-12 col-sm-12 col-md-12">
                           <p> Book of Blogs, have chapter(s) in it and then keep updating it from time-to-time.</p><br>
                           </span>
                           @if (Auth::user()->pset)
                           <div id="blogBookDisplay"><div style="text-align: center"><br><img src="{{asset('Images/icons/waiting.gif')}}"> </div></div>
                           @endif
                           </div>

                          <div role="tabpanel" class="tab-pane fade" id="collabNew">
                          <span><a data-toggle="modal" data-target="#newCollaborationModal" class="bbtng">+New</a></span>
                          <span style="padding: 5px"><a href="{{route('collaborationsDashboard')}}" class="bbtn">Manage</a></span>
                          <span style="padding: 5px"><a class="bbtnr" onclick="showSuggestions('Collaboration')" title="See what other Barters would like to read. Tell others what you'd like to read.">Suggestions</a></span>
                          <span class="col-xs-12 col-sm-12 col-md-12">&nbsp;</span>
                          <span class="col-xs-12 col-sm-12 col-md-12">
                          <p style="color:black"> Its same as a BlogBook. Now multiple barters can write it simultaneously, together!</p><br>
                          </span>

                          @if (Auth::user()->pset)
                          <div id="collaborationDisplay"><div style="text-align: center"><br><img src="{{asset('Images/icons/waiting.gif')}}"> </div></div>
                          @endif
                          </div>
                          @endif
                       </div>
                   </div>
                    <!--Here we start the upload content -->
                   <div id="upload-content" class="hidden-content" style="display: none">
                      <div class="col-xs-12 col-sm-12 col-md-12 noPad"><hr></div>
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
                                 <span class="col-xs-12 col-sm-6 col-md-4" ><a href="{{route('resourceDashboard')}}" class="bbtn">Upload and Manage Resources</a></span>
                                      <span class="col-xs-12 col-sm-10 col-md-8" style="padding-top: 10px">
                                     <p style="color:black">  Resource, like source code, assignments etc. in compressed format.</p><br>
                                 </span>

                                    @if (Auth::user()->pset)
                                   <div id="resDisplay" class="col-lg-12"><div style="text-align: center"><br><img src="{{asset('Images/icons/waiting.gif')}}"> </div></div>
                                   @endif
                              </div>
                              <div role="tabpanel" class="tab-pane fade" id="mediaNew">
                                 <span class="col-xs-12 col-sm-6 col-md-4" ><a href="{{route('mediaDashboard')}}" class="bbtn">Upload and Manage Media</a></span>
                                     <span class="col-xs-12 col-sm-10 col-md-8" style="padding-top: 10px">
                                       <p style="color:black">  Media, like your guitar song, vocals, video etc. you can make it public also.</p><br>
                                     </span>
                                 @if (Auth::user()->pset)
                                     <div id="mediaDisplay" class="col-lg-12"><div style="text-align: center"><br><img src="{{asset('Images/icons/waiting.gif')}}"> </div></div>
                                 @endif
                              </div>
                            @endif
                      </div>
                   </div>
                   <!--Polls and Quizes  Content --->
                   <div id="pollsnquizes-content" class="hidden-content" style="display: none">
                              <div class="col-xs-12 col-sm-12 col-md-12 noPad"><hr></div>
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
                                      <span class="col-xs-10 col-sm-6 col-md-4" ><a href="{{route('quizDashboard')}}" class="bbtn">Create and Manage Quizes</a></span>
                                     <span class="col-xs-12 col-sm-10 col-md-8" style="padding-top: 10px">
                                           <p style="color:black"> quiz and challenge fellow barters for the same, if they score any less than 100% you earn.</p><br>
                                      </span>
                                     @if (Auth::user()->pset)
                                     <div id="quizDisplay" class="col-lg-12"><div style="text-align: center"><br><img src="{{asset('Images/icons/waiting.gif')}}"> </div></div>
                                     @endif
                                 </div>
                                 <div role="tabpanel" class="tab-pane fade" id="pollNew">
                                     <span class="col-xs-10 col-sm-6 col-md-4" ><a href="{{route('pollDashboard')}}" class="bbtn">Create and Manage Polls</a></span>
                                     <span class="col-xs-12 col-sm-10 col-md-8" style="padding-top: 10px">
                                        <p style="color:black"> poll and see what the fellow barters have voted for.</p><br>
                                     </span>
                                     @if (Auth::user()->pset)
                                       <div id="pollDisplay" class="col-xs-12 col-sm-12 col-md-12"><div style="text-align: center"><br><img src="{{asset('Images/icons/waiting.gif')}}"> </div></div>
                                     @endif
                                 </div>
                                  @endif
                               </div>
                   </div>
                   <!--Now we start the recco section -->
                   <div id="recco-content" class="hidden-content" style="display: none">
                        <div class="col-xs-12 col-sm-12 col-md-12 noPad"><hr></div>
                       <div style="padding: 5px" class="col-xs-6 col-sm-4 col-md-4"><button class="bbtn" data-toggle="modal" data-target="#newRecommendationModal">+ Make New</button></div>
                        <div class="col-xs-12 col-sm-8 col-md-6 noPad" style="padding: 0px">
                         <div class="col-xs-8 col-sm-8 col-md-8 noPad">
                               <input id="searchRecco" type="text" class="form-control" placeholder="Search recco or provider." onkeyup="upRecco(event)" onkeydown="downRecco()" onfocus="cacheMarkup()">
                         </div>
                         <div class="col-xs-4 col-sm-4 col-md-4">
                         <select id="RECCO-FILTER" class="form-control" name="RECCO-FILTER" onchange="sortRecco()" style="padding-left: 0px; padding-right: 5px">
                            <option value="created_at">Latest</option>
                            <option value="hits">Popular</option>
                         </select>
                         </div>
                         </div>
                         <div class="col-xs-12 col-sm-12 col-md-12 noPad"><br></div>       <!-- Nav tabs -->
                               <ul class="nav nav-tabs" role="tablist">
                               <input type="hidden" id="recco-tab" value="all">
                                 <li role="presentation" class="active recco-duo-tabs"><a href="#all-recco" role="tab" data-toggle="tab" onclick="toggleTab('all')">All Recco</a></li>
                                 <li role="presentation" class="recco-duo-tabs"><a href="#my-recco" role="tab" data-toggle="tab" onclick="toggleTab('my')">My Recco</a></li>
                                </ul>

                                 <div class="col-xs-1 col-sm-1 col-md-4" style="padding-left: 0px"></div>





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

   <!-- So this is action center div -->
   <div class="col-xs-12 col-sm-4 col-md-3 noPad" id="ActionCentre" onmouseover="okToAjax(false,1)" onmouseout="okToAjax(true,1)">
       <div id="searchnfilters" class="col-xs-12 col-sm-12 col-md-12">
       <div class="col-xs-12">
                   <input id="searchPandC" class="form-control" style="margin-top: 10px" onkeyup="searchAction()" onkeydown="clearSearchInterval()" onblur="okToAjax(true,2)" onfocus="okToAjax(false,2)" placeholder="Search people/content">
       </div>
       <div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
       <?php $intrrr = Interest::all(); ?>
           <div id="filterdiv" class="col-xs-12 col-sm-12 col-md-12" style="padding: 0px; display: none">
               <div class="col-xs-1" style="padding-top: 2px; padding-left: 0px; word-wrap: normal">In</div>
               <div class="col-xs-5" style="padding-left: 0px">
               <select id="IN" class="form-control" name="IN" onchange="searchAction()" style="padding-top: 0px; padding-bottom: 0px; height: 25px">
                      <option value="0">All</option>
                      @foreach($intrrr as $int)
                      <option value="{{$int->id}}">{{$int->interest_name}}</option>
                      @endforeach
               </select>
               </div>
           <div class="col-xs-2" style="padding-top: 2px; padding-left: 0px">Sort</div>
           <div class="col-xs-4" style="padding: 0px">
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
   <!-- Action Center ended  here -->

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
                    <div class="col-md-6">
                        The simplest way, you can invite other people to join BBarters. You'll get a link for every person you invite. Share it with them, and if they click on the link and sign up, you earn 300 IFCs.<br>
                        <button type="button" class="btn btn-block" onclick="showInviteModal()">Invite People</button>
                    </div>
                    <div class="col-md-6">
                        You can create Blogbooks, Articles, Collaborations, Resources, Quizes, Polls and earn IFCs. Start Here!<br><br><br>
                        <button class="btn btn-block" onClick="showContentModal()">Create Content</button>
                    </div>
                    <div class="col-md-12">&nbsp;</div>
                    <div class="col-md-12">
                        Saw anything going wrong with our code? Want us to improve something? Write us the issue/suggestion within minimal words/screenshots. If found appropriate, you'll be credited upto 500 IFCs.
                        <a href="{{route('reportBug')}}" class="btn btn-alert col-md-12">Report Bug/ Suggestion</a>
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
                        <div class="col-md-10">
                            <input type="text" id="reccoLink" class="form-control" name="reccoLink" placeholder="Paste the link here.">
                        </div>
                        <button type="submit" id="recco-submit" class="col-md-2 btn btn-primary" onclick="postRecommendation()">Go</button>
                    </form>

                    <div id="recco-data" class="col-md-12">

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
                    <div class="col-md-12">
                        On BBarters you can come up with content and put up a price for it. If anyone wants to read/download it, he/she has to purchase it using IFCs ('InfoCurrency', our very own term for virtual currency.). And then obviously, these IFCs are transferred to your account. Its just like dealing content for IFCs!<br>
                        You can use these IFCs to read what others have posted and have some good time here.
                        <br>
                        <br>

                        <div class="col-md-6">
                            <a data-toggle="modal" data-target="#newArticleModal" style="text-decoration: none; cursor: pointer" target="_blank"><b>ARTICLE:</b></a><br>
                            A page long write-up regarding anything that excites you or drives you to write.<br>
                            <hr>
                        </div>

                        <div class="col-md-6">
                            <a data-toggle="modal" data-target="#newBlogBookModal" style="text-decoration: none; cursor: pointer" target="_blank"><b>BLOGBOOK:</b></a><br>
                            Start witing a book and keep on updating it from time to time by adding more and more chapters to it.<br>
                            <hr>
                        </div>

                        <div class="col-md-6">
                            <a data-toggle="modal" data-target="#newCollaborationModal" style="text-decoration: none; cursor: pointer" target="_blank"><b>COLLABORATION:</b></a><br>
                            Collaborate with people who could collectively write well about a particular topic.<br>
                            <hr>
                        </div>

                        <div class="col-md-6">
                            <a href="{{route('resourceDashboard')}}" style="text-decoration: none" target="_blank"><b>RESOURCE:</b></a><br>
                            Upload a zip file containing files that people would find useful and be interested to download.<br>
                            <hr>
                        </div>

                        <div class="col-md-6">
                            <a href="{{route('quizDashboard')}}" style="text-decoration: none" target="_blank"><b>QUIZ:</b></a><br>
                            Create a quiz that people would like to take. Their earning depends on how they score and how difficult the quiz is!<br>
                        </div>

                        <div class="col-md-6">
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
                            <label class="col-md-3 control-label">Name</label>
                            <div class="col-md-5">
                                <input id="inviteName" type="text" class="form-control" name="name"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Email address</label>
                            <div class="col-md-5">
                                <input id="inviteEmail" type="text" class="form-control" name="email" autocomplete="off" />
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" id="inviteSubmit" onclick="postInvite()" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
                <div class="col-md-12">&nbsp;</div>
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
                            <label class="col-md-3 control-label">IFCs</label>
                            <div class="col-md-5">
                                <input id="transferIFC" name="transferIFC" class="form-control" style="width: 200px">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Friend</label>
                            <div class="col-md-5">
                                <select id="friend" class="form-control" name="friend">
                                    <option value="">-- Select a friend --</option>
                                    @foreach($friends as $friend)
                                    <option value="{{$friend->id}}">{{$friend->first_name}} {{$friend->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3" id="submitTransfer">
                                <button type="submit" id="transferSubmit" onclick="postTransfer()" class="btn btn-primary">Submit</button>
                            </div>

                            <div class="col-md-3 col-md-offset-3" id="waiting" style="display: none" >
                            <img src="{{asset('Images/icons/waiting.gif')}}">Saving..
                            </div>

                        </div>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
</div><!-- End of IFC Manager -->

@include('createArticleBlogBookCollaboration')

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
                    <div id="suggetsion-data" class="col-md-12" style="max-height: 350px; overflow: auto">

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
<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('js/jquery.metro.js')}}"></script>
<script src="{{asset('js/raphael.js')}}"></script>
<script src="{{asset('js/morris.js')}}"></script>
<script src="{{asset('js/reload.js')}}"></script>
<script src="{{asset('js/search.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/createArticleBlogBookCollaboration.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/jstween-1.1.min.js')}}"></script>
<script src="{{asset('js/jquery.flipcounter.js')}}"></script>
<script src="{{asset('js/pages/home.js')}}"></script>
{{--<script src="{{asset('js/jquery.bpopup.min.js')}}"></script>--}}
</body>
</html>