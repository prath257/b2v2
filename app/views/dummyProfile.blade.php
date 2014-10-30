<!DOCTYPE html>
<html>
<head>
    <title>{{$user->first_name}}'s Profile | BBarters</title>
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/profile.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('css/metro.blue.css')}}" />
    <link href="{{asset('dataTables.bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/summernote.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.flipcounter.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap-switch.css')}}" rel="stylesheet">

    <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/505bef35b56/integration/bootstrap/3/dataTables.bootstrap.js"></script>
</head>
<body>
<nav id="navbar" class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        </div>
    </div>
</nav>
@if(!$user->pset)
@if($user==Auth::user())
<div class="alert alert-info alert-dismissable col-lg-6 col-lg-offset-3">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Attention! </strong> You haven't completed your profile yet, earn 300 by doing it now.
    <a href="{{route('buildProfile')}}">Complete Profile</a>
</div>
@else
<div class="alert alert-info alert-dismissable col-lg-6 col-lg-offset-3">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Attention! </strong> {{$user->first_name}} hasn't build the profile yet!
</div>
@endif
@else
<input id="profileId" type="hidden" value="{{$user->id}}">

<div class="modal fade" id="notifyModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div id="notificationModal" class="modal-dialog">

        <div class="modal-content">

            <div  class="modal-body">
                <fieldset id="notifyText"></fieldset>
            </div>
        </div>

    </div>
</div>
<div id="bodyDiv" class="col-lg-12 noPadding">
    <div id="profileContainerDiv" class="col-lg-5 noPadding" onmouseover="hideBacktotop()">
        <div id="profileDiv" class="col-lg-12 noPadding blur" style="background: linear-gradient(rgba(3, 23, 34, 0.7), rgba(3, 23, 34, 0.7) ), url('{{$user->profile->profilePic}}'); background-size: 100% 100%;">

        </div>
        <div id="PPPTdiv" class="col-lg-12 noPadding">
            <div class="darkDiv col-lg-10 col-lg-offset-1">
                <div class="col-lg-12 noPadding">
                    <a class="pull-left col-lg-4" href="#" style="padding: 5px">
                        <img id="profilePic" src="{{asset($user->profile->profilePic)}}" width="150px">
                    </a>
                    <div id="usernameProfiletune" class="col-lg-8">
                        <h3 id="name">{{$user->username}}</h3>
                        <a id="PTglyphicon" onclick="playPause()"><span id="ptButton" class="glyphicon glyphicon-music"></span></a>
                        <audio src="{{$user->profile->profileTune}}" type="audio/mpeg" id="pt"></audio>
                    </div>
                </div>

            </div>
        </div>
        <div id="bottomLinks" class="col-lg-12 noPadding btn-group">
            <button type="button" class="btn btn-default bottomButtons col-lg-12 noPadding" onclick="showAboutUser()"><a class="buttonLinks"><span class="glyphicon glyphicon-pencil"></span> About {{$user->first_name}}</a></button>

        </div>
    </div>

    <div id="interestsDiv" class="col-lg-7" onmouseover="hideBacktotop()">
        <h1 id="FullName">{{Str::title($user->first_name)}} {{Str::title($user->last_name)}}</h1>
        <p id="aboutUser">"{{$user->profile->aboutMe}}" <a id="readMore" onclick="showAboutUser()">Read more..</a></p>
        <br>
        <div class="col-lg-12 noPadding">
            <p>Primary Interests:</p>
            <br>
            @foreach ($interests as $interest)
            <?php $type = DB::table('user_interests')->where('user_id',$user->id)->where('interest_id',$interest->id)->first(); ?>
            @if ($type->type == 'primary')
            <?php
            $articles = $user->getArticles()->where('category','=',$interest->id)->orderBy('users','DESC')->get();
            $blogBooks = $user->getBlogBooks()->where('category','=',$interest->id)->orderBy('users','DESC')->get();
            $resources = $user->getResources()->where('category','=',$interest->id)->orderBy('users','DESC')->get();
            $collaborations = $user->getOwnedCollaborations()->where('category','=',$interest->id)->orderBy('users','DESC')->get();
            $contributions = $user->getContributions()->where('category','=',$interest->id)->orderBy('users','DESC')->get();

            $content = $articles->merge($blogBooks);
            $content = $content->merge($resources);
            $content = $content->merge($collaborations);
            $content = $content->merge($contributions);

            $content = $content->sortByDesc('users')->first();
            ?>
            @if (count($content) > 0)
            <div class="col-lg-4">
                <h3 class="interestHeadings">{{Str::limit($interest->interest_name,15)}}</h3>
                <div>
                    @if ($content->path)
                    <img class="Profileimages" src="{{asset('Images/Resource.jpg')}}" height="100px" width="100px">
                    @else
                    <img class="Profileimages" src="{{asset($content->cover)}}" height="100px" width="100px">
                    @endif
                    <div class="caption">
                        <h4 class="contentTitle">{{$content->title}}</h4>
                        @if ($content->text)
                        <p><a href="{{route('articlePreview',$content->id)}}" class="btn btn-primary" target="_blank" role="button">View</a></p>
                        @elseif ($content->review)
                        <p><a href="{{route('blogBookPreview',$content->id)}}" class="btn btn-primary" target="_blank" role="button">View</a></p>
                        @elseif ($content->path)
                        <p><a href="{{route('resource',$content->id)}}" class="btn btn-primary" target="_blank" role="button">View</a></p>
                        @else
                        <p><a href="{{route('collaborationPreview',$content->id)}}" class="btn btn-primary" target="_blank" role="button">View</a></p>
                        @endif
                    </div>
                    <a onclick="showUserContent({{$interest->id}})">Show all..</a>
                </div>
            </div>
            @endif
            @endif
            @endforeach
        </div>
        <div class="col-lg-12">&nbsp;</div>
        <p>Secondary Interests:</p>
        <div class="col-lg-12">
                    <?php $secondaryInterestCount=0; ?>
                    @foreach($interests as $interest)
                    <?php $type = DB::table('user_interests')->where('user_id',$user->id)->where('interest_id',$interest->id)->first(); ?>
                        @if ($type->type == 'secondary')
                            <?php $secondaryInterestCount++; ?>
                            <a class="darkLinks" onclick="showUserContent({{$interest->id}})">{{$interest->interest_name}}</a>
                        @endif
                    @endforeach

                </div>
                    @if ($secondaryInterestCount == 0)
                    <input type="hidden" id="secondaryInterestsStatus" value="false">
                    @else
                    <input type="hidden" id="secondaryInterestsStatus" value="true">
                    @endif
    </div>

    <div id="contentDiv" class="col-lg-12" style="display: none; padding: 0px" onmouseover="showBacktotop()">

    </div>

    <div id="backtotop" style="display: none;">
        <button class="btn btn-default" title="Back to the top" style="color: #000000" onclick="backtotop()">
            <span class="glyphicon glyphicon-chevron-up"></span>
        </button>
    </div>
</div>
@endif
<!-- Friend-UnFriend-CancelRequest-AcceptRequest and Follow-UnFollow modals -->
<div class="modal fade" id="AddFriendModal" tabindex="-1" role="dialog" aria-hidden="true" style="font-family: 'Segoe UI'">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add Friend</h4>
            </div>

            <div class="modal-body">
                <h6  id="myModalLabel">Please provide a short reason to add {{$user->first_name}} {{$user->last_name}} as a friend.</h6>
                <form id="addfriendform">
                    <fieldset>
                        <div class="form-group">
                            <textarea id="friendreason" name="friendreason" class="form-control" style="width: 100%" rows="3"></textarea>
                        </div>

                        <h4>Please NOTE:</h4>
                        <p>You will be charged <b>{{$user->settings->friendcost}}<i>i</i></b> when {{$user->first_name}} accepts your friend request.</p>

                        <button type="submit" id="friendreasonsubmit" onclick="friend({{$user->id}})" class="btn btn-primary" aria-hidden="true">Submit</button>&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    </fieldset>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="UnFriendModal" tabindex="-1" role="dialog" aria-hidden="true" style="font-family: 'Segoe UI'">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">UnFriend</h4>
            </div>

            <div class="modal-body">
                <h6  id="myModalLabel">Are you sure to remove {{$user->first_name}} {{$user->last_name}} from your friend-list?</h6>
                <button type="button" onclick="unfriend({{$user->id}})" class="btn btn-primary" aria-hidden="true">Sure</button>&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Nope</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="CancelRequestModal" tabindex="-1" role="dialog" aria-hidden="true" style="font-family: 'Segoe UI'">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Cancel Request</h4>
            </div>

            <div class="modal-body">
                <h6  id="myModalLabel">Are you sure to remove the friend request you made to {{$user->first_name}} {{$user->last_name}}?</h6>
                <button type="button" onclick="cancelRequest({{$user->id}})" class="btn btn-primary" aria-hidden="true">Sure</button>&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Nope</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="FollowModal" tabindex="-1" role="dialog" aria-hidden="true" style="font-family: 'Segoe UI'">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Follow</h4>
            </div>

            <div class="modal-body">
                <h6  id="myModalLabel">Are you sure to follow {{$user->first_name}} {{$user->last_name}}? This subscription will cost you {{$user->settings->subcost}} IFCs. Okay?</h6>
                <button id="confirmFollowButton" type="button" onclick="follow({{$user->id}})" class="btn btn-primary" aria-hidden="true">Sure</button>&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Nope</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="UnFollowModal" tabindex="-1" role="dialog" aria-hidden="true" style="font-family: 'Segoe UI'">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">UnFollow</h4>
            </div>

            <div class="modal-body">
                <h6  id="myModalLabel">Are you sure to unfollow {{$user->first_name}} {{$user->last_name}}?</h6>
                <button type="button" onclick="unfollow({{$user->id}})" class="btn btn-primary" aria-hidden="true">Sure</button>&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Nope</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="AcceptRequestModal" tabindex="-1" role="dialog" aria-hidden="true" style="font-family: 'Segoe UI'">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Accept Request</h4>
            </div>

            <div class="modal-body">
                <h6  id="myModalLabel">Are you sure to accept the friend request from {{$user->first_name}} {{$user->last_name}}?</h6>
                <button type="button" onclick="acceptRequest({{$user->id}})" class="btn btn-primary" aria-hidden="true">Sure</button>&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Nope</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="DeclineRequestModal" tabindex="-1" role="dialog" aria-hidden="true" style="font-family: 'Segoe UI'">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Decline Request</h4>
            </div>

            <div class="modal-body">
                <h6  id="myModalLabel">Are you sure to decline the friend request from {{$user->first_name}} {{$user->last_name}}?</h6>
                <button type="button" onclick="declineRequest({{$user->id}})" class="btn btn-primary" aria-hidden="true">Sure</button>&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Nope</button>
            </div>

        </div>
    </div>
</div>

<!-- End of Friend-UnFriend-CancelRequest-AcceptRequest and Follow-UnFollow modals -->
<!-- Unsuffucient IFC modal -->
<div class="modal fade" id="unsufficientIFCModal" tabindex="-1" role="dialog" aria-hidden="true" style="font-family: 'Segoe UI'">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Sorry,</h4>
            </div>

            <div class="modal-body">
                <p  id="myModalLabel" style="float: left">You require <p id="unsufficientIFC" style="float: left; margin-left: 2px"></p> IFCs to perform this action. And sadly you dont have these many remaining. Why don't you try earning some IFCs?</p>
                <button type="button" onclick="earnIFC()" class="btn btn-primary" aria-hidden="true">Earn IFCs</button>&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Thanks, I'll check later</button>
            </div>

        </div>
    </div>
</div>
<!-- End of Unsufficient IFC modal -->

<!-- Modal to display that 'about' written by the user is successfully posted -->
<div class="modal fade" id="aboutSuccessfullyPostedModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">About {{$user->first_name}},Sent!</h4>
            </div>
            <div class="modal-body">
                <fieldset>
                    <p>Your opinions have been successfully sent to {{$user->first_name}}.<br> If {{$user->first_name}} agrees to your content, it will appear on
                        @if($user->gender=='male')
                        his
                        @else
                        her
                        @endif
                        profile.</p>
                    <button type="button" class="btn btn-primary pull-right" data-dismiss="modal" aria-hidden="true">Okay</button>
                </fieldset>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="PTheme" value="standard">

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="{{asset('js/pages/profile.js')}}"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/jquery.metro.js')}}"></script>
<script src="{{asset('js/summernote.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/jstween-1.1.min.js')}}"></script>
<script src="{{asset('js/jquery.flipcounter.js')}}"></script>
<script src="{{asset('js/bootstrap-switch.js')}}"></script>
</body>
</html>