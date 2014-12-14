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
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    {{--<link rel="stylesheet" type="text/css" href="{{asset('css/metro.blue.css')}}" />--}}
    <link href="{{asset('dataTables.bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/summernote.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.flipcounter.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap-switch.css')}}" rel="stylesheet">

    <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery.Jcrop.min.js')}}"></script>
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
            <ul class="nav navbar-nav navbar-right">
                <li id="home"> <a href="{{route('home')}}" style="cursor: pointer">Home</a></li>
                @if ($user->id != Auth::user()->id)
                <li id="profile"> <a href="{{route('profile')}}" style="cursor: pointer">{{Auth::user()->first_name}}</a></li>
                @endif
                <li id="logOut"> <a href="{{route('signout')}}" style="cursor: pointer">Log Out</a></li>
            </ul>
        </div>
    </div>

</nav>

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
<div id="bodyDiv" class="col-lg-12 noPadding" style="display: none">
    @if ($user->settings->profileTheme == 'standard')
    <input type="hidden" id="PTheme" value="standard">
    <div id="profileContainerDiv" class="col-lg-5 noPadding">
        <div id="profileDiv" class="col-lg-12 noPadding" style="background: linear-gradient(rgba(3, 23, 34, 0.7), rgba(3, 23, 34, 0.7) ), url('{{$user->profile->coverPic}}'); background-size: 100% 100%;">

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
                @if($user->pset)
                <div class="col-lg-12 noPadding">

                    @if($user->id==Auth::user()->id)
                    <a href="#" class="socialButtons col-lg-4 col-lg-offset-2 noPadding" onclick="getFriendList(); return false;"><span class="glyphicon glyphicon-user"></span> Friends <br class="breaks"><span class="count"><b>{{$fCount}}</b></span></a>
                    <div class="col-lg-12 newLine">&nbsp;</div>
                        <a href="#" class="socialButtons col-lg-4 noPadding" onclick="getSubscriberList(); return false;"><span class="glyphicon glyphicon-star"></span> Subscriptions <br class="breaks"><span class="count"><b>{{$sCount}} - {{$scCount}}</b></span></a>
                    @else
                        @if(Friend::isFriend($user->id))
                            <a id="UnFriend" href="#" class="socialButtons friends col-lg-4 col-lg-offset-2 noPadding" onclick="openModal(this); return false;"><span class="glyphicon glyphicon-minus-sign"></span> UnFriend</a>
                        @elseif(Friend::requestSent($user->id))
                            <a id="CancelRequest" href="#" class="socialButtons friends col-lg-4 col-lg-offset-2 noPadding" onclick="openModal(this); return false;"><span class="glyphicon glyphicon-remove"></span> CancelRequest</a>
                        @elseif(Friend::requestNotYetAccepted($user->id))
                            <a id="AcceptRequest" href="#" class="socialButtons friends col-lg-4 noPadding" onclick="openModal(this); return false;"><span class="glyphicon glyphicon-ok"></span> AcceptRequest</a>
                    <div class="col-lg-12 newLine">&nbsp;</div>
                        <a id="DeclineRequest" href="#" class="socialButtons friends col-lg-4 noPadding" onclick="openModal(this); return false;"><span class="glyphicon glyphicon-remove"></span> DeclineRequest</a>
                        @else
                            <a id="AddFriend" href="#" class="socialButtons friends col-lg-4 col-lg-offset-2 noPadding" onclick="openModal(this); return false;"><span class="glyphicon glyphicon-plus-sign"></span> AddFriend</a>
                        @endif
                    <div class="col-lg-12 newLine">&nbsp;</div>
                        <!-- Buttons related to Followers -->
                        <input type="hidden" id="subcost" value="{{$user->settings->subcost}}">
                        @if($follower)
                                <a id="UnFollow" href="#" class="socialButtons follow col-lg-4 noPadding" onclick="openModal(this); return false;"><span class="glyphicon glyphicon-minus-sign"></span> UnFollow</a>
                        @else
                                <a id="Follow" href="#" class="socialButtons follow col-lg-4 noPadding" onclick="openModal(this); return false;"><span class="glyphicon glyphicon-pushpin"></span> Follow</a>
                        @endif
                    @endif
                </div>
                @endif
            </div>
        </div>
        <div id="bottomLinks" class="col-lg-12 noPadding btn-group">
            @if($user->pset)
            @if (Auth::user()->id != $user->id)
            <button type="button" class="btn btn-default bottomButtons col-lg-6 noPadding bb" onclick="showAboutUser()"><a class="buttonLinks"><span class="glyphicon glyphicon-pencil"></span> About {{$user->first_name}}</a></button>
            <button type="button" class="btn btn-default bottomButtons col-lg-6 noPadding bb" onclick="showQuestions()"><a class="buttonLinks"><span class="glyphicon glyphicon-question-sign"></span> Ask {{$user->first_name}}</a></button>
            @else
            <button type="button" class="btn btn-default bottomButtons col-lg-4 noPadding bbAuth" onclick="showAboutUser()"><a class="buttonLinks"><span class="glyphicon glyphicon-pencil"></span> About me</a></button>
            <button type="button" class="btn btn-default bottomButtons col-lg-4 noPadding bbAuth" onclick="showQuestions()"><a class="buttonLinks"><span class="glyphicon glyphicon-question-sign"></span> Questions</a></button>
            <button type="button" class="btn btn-default bottomButtons col-lg-4 noPadding bbAuth" onclick="showSettings()"><a class="buttonLinks"><span class="glyphicon glyphicon-cog"></span> Settings</a></button>
            @endif
            @endif
        </div>
    </div>

    <div id="interestsDiv" class="col-lg-7">
        <div id="interestsContainer">
        <h1 id="FullName">{{Str::title($user->first_name)}} {{Str::title($user->last_name)}}</h1>
        @if(!Auth::user()->pset)
            <div class="alert alert-info alert-dismissable col-lg-6">
                <strong>Attention! </strong> Without a valid profile you won't be able to create any content or interact with anyone. So, complete it now and earn yourself upto 300i
                <br>
                <a href="{{route('buildProfile')}}"><h3>Complete Profile</h3></a>
            </div>
        @else
        <p id="aboutUser">{{$user->profile->aboutMe}} <a id="readMore" class="darkLinks" onclick="showAboutUser()">Read more..</a></p>
        @if (Auth::user()->id == $user->id)
        <p><a href="http://b2.com/diary/{{$user->username}}">Read Diary</a></p>
        @else
            <?php $susers=Diaryshare::where('duserid','=',$user->id)->where('suserid','=',Auth::user()->id)->first(); ?>
            @if ((count($susers) >0 && $user->settings->diaryAccess == 'semi') || $user->settings->diaryAccess == 'public')
            <p><a href="http://b2.com/diary/{{$user->username}}" class="darkLinks">Read Diary</a></p>
            @endif
        @endif
        <br>
        <div class="col-lg-12 noPadding">

            <?php $PIcount=0; ?>
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

                        $content = $content->sortByDesc('users')->take(3);
                    ?>
                    <div class="col-lg-4">
                        <a class="darkLinks col-lg-12" style="padding: 0px" onclick="showUserContent({{$interest->id}})"><h4>{{Str::limit($interest->interest_name,15)}}</h4></a>
                        @if (count($content) > 0)
                            <?php $PIcount++; ?>

                        <div id="carousel{{$PIcount}}" class="carousel slide carousel-fade col-lg-12" style="padding: 0px">

                            <div class="carousel-inner">
                                <?php $i=0; ?>
                                @foreach ($content as $tr)
                                    <?php $i++; ?>
                                    @if ($i == 1)
                                        <div class="item active">
                                    @else
                                        <div class="item">
                                    @endif

                                            <div>

                                                <?php
                                                    if ($tr->text)
                                                        $ClassicRoutes = 'articlePreview';
                                                    elseif ($tr->review)
                                                        $ClassicRoutes = 'blogBookPreview';
                                                    elseif ($tr->path)
                                                        $ClassicRoutes = 'resource';
                                                    else
                                                        $ClassicRoutes = 'collaborationPreview';
                                                ?>

                                                @if ($tr->path)
                                                    <a href="{{route($ClassicRoutes,$tr->id)}}" target="_blank"><img class="Profileimages" src="{{asset('Images/Resource.jpg')}}" height="100px" width="100px"></a>
                                                @else
                                                    <a href="{{route($ClassicRoutes,$tr->id)}}" target="_blank"><img class="Profileimages" src="{{asset($tr->cover)}}" height="100px" width="100px"></a>
                                                @endif
                                            </div>
                                            <div style="overflow: auto">
                                                <div>
                                                    <div>
                                                        <div class="caption col-lg-12 noPadding" style="padding-top: 5px">
                                                            <a href="{{route($ClassicRoutes,$tr->id)}}" target="_blank" class="darkLinks" style="font-size: 16px">{{$tr->title}}</a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                @endforeach
                            </div>
                            <div style="height: 5%">
                                <ul class="carousel-indicators pull-right" style="left: auto; list-style-type: none">
                                    @for ($contentC = 0; $contentC < $i; $contentC++)
                                        <?php
                                            if ($contentC == 0)
                                                $extraClass = 'active';
                                            else
                                                $extraClass = '';
                                         ?>
                                        <li data-target="#carousel{{$PIcount}}" data-slide-to="{{$contentC}}" class="bottom-boxes {{$extraClass}}"></li>
                                    @endfor
                                </ul>
                            </div>
                        </div>

                        @else
                        <div class="col-lg-12" style="padding: 0px">
                            <div class="col-lg-12" style="padding: 0px; color: white">
                                <div class="col-lg-12 noPadding contento-divs" style="background-color: #1c5a5e; border-radius: 4px">
                                    <img src="{{asset('Images/no-content.jpg')}}" class="col-lg-12 noPadding contento-images" style="height: 150px">
                                    <div class="col-lg-12">
                                        <h4 style="font-weight: bolder"><a style="color: white">No work yet.</a></h4>
                                        <p>It seems like {{$user->first_name}} hasn't got any work up there. Rest assured it will be up there soon.</p>
                                    </div>
                                    <!--<div class="col-lg-12 ifc-readerr" style="text-align: center; background-color: #185256">
                                        <div id="ifc-readerr" class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid #1c5a5e">
                                            <div class="col-lg-12 noPadding"><b>None</b></div>
                                            <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                        </div>
                                        <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                            <div class="col-lg-12 noPadding"><b>Many</b></div>
                                            <div class="col-lg-12 noPadding" style="font-size: 12px">Readers <i class="fa fa-clock-o"></i></div>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                    @endif
</div>
                @endif

            @endforeach
                <input type="hidden" id="PICOUNT" value="{{$PIcount}}">
</div>
        <div class="col-lg-12">&nbsp;</div>
        <div class="col-lg-12">&nbsp;</div>
        <h4 style="padding-left:15px ">Secondary Interests:</h4>
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

        @endif
    </div>
    </div>
    @else
    <input type="hidden" id="PTheme" value="classic">
    <div id="profileContainerDiv" class="col-lg-3 noPadding col-lg-offset-1">
    <br><br><br>
        <h3 style="font-family: 'Segoe UI', 'Segoe WP', 'Helvetica Neue', 'RobotoRegular', sans-serif; text-transform: none; padding-left: 15px">{{$user->first_name}} {{$user->last_name}}</h3>
            <div class="col-lg-12">
                @if($user->pset)
                    @if (Auth::user()->id != $user->id)
                    <a onclick="showAboutUser()" class="classicLinks"> About {{$user->first_name}}</a> |
                    <a onclick="showQuestions()" class="classicLinks"> Ask {{$user->first_name}}</a>
                    @else
                    <a onclick="showAboutUser()" class="classicLinks"> About</a> |
                    <a onclick="showQuestions()" class="classicLinks"> Questions</a> |
                    <a onclick="showSettings()" class="classicLinks"> Settings</a>
                    @endif
                @endif
            </div>
            <br><br>
            <div class="col-lg-6 picnusername">
                <img src="{{$user->profile->profilePic}}" height="150" width="150">
            </div>
            <div id="username-profiletune" class="col-lg-6 picnusername noPadding">
                <h4 style="word-wrap: break-word; text-transform: none">{{$user->username}}</h4>

                <a id="PTglyphicon" onclick="playPause()" style="color: #000000"><span id="ptButton" class="glyphicon glyphicon-music"></span></a>
                <audio src="{{$user->profile->profileTune}}" type="audio/mpeg" id="pt"></audio>
            </div>
            <div class="col-lg-12">
            @if($user->pset)
                <div class="col-lg-12">&nbsp;</div>
                <div class="col-lg-12 noPadding">

                    @if($user->id==Auth::user()->id)
                    <a href="#" class="socialButtons2 wannabeInexed col-lg-4 noPadding" onclick="getFriendList(); return false;"><span class="glyphicon glyphicon-user"></span> Friends <br class="breaks"><span class="count"><b>{{$fCount}}</b></span></a>
                    <div class="col-lg-12 newLine">&nbsp;</div>
                        <a href="#" class="socialButtons2 wannabeInexed col-lg-4 noPadding" onclick="getSubscriberList(); return false;"><span class="glyphicon glyphicon-star"></span> Subscriptions <br class="breaks"><span class="count"><b>{{$sCount}} - {{$scCount}}</b></span></a>
                    @else
                        @if(Friend::isFriend($user->id))
                            <a id="UnFriend" href="#" class="socialButtons2 wannabeInexed friends col-lg-4 noPadding" onclick="openModal(this); return false;"><span class="glyphicon glyphicon-minus-sign"></span> UnFriend</a>
                        @elseif(Friend::requestSent($user->id))
                            <a id="CancelRequest" href="#" class="socialButtons2 wannabeInexed friends col-lg-4 noPadding" onclick="openModal(this); return false;"><span class="glyphicon glyphicon-remove"></span> CancelRequest</a>
                        @elseif(Friend::requestNotYetAccepted($user->id))
                            <a id="AcceptRequest" href="#" class="socialButtons2 wannabeInexed friends col-lg-4 noPadding" onclick="openModal(this); return false;"><span class="glyphicon glyphicon-ok"></span> AcceptRequest</a>
                    <div class="col-lg-12 newLine">&nbsp;</div>
                        <a id="DeclineRequest" href="#" class="socialButtons2 wannabeInexed friends col-lg-4 noPadding" onclick="openModal(this); return false;"><span class="glyphicon glyphicon-remove"></span> DeclineRequest</a>
                        @else
                            <a id="AddFriend" href="#" class="socialButtons2 wannabeInexed friends col-lg-4 noPadding" onclick="openModal(this); return false;"><span class="glyphicon glyphicon-plus-sign"></span> AddFriend</a>
                        @endif
                    <div class="col-lg-12 newLine">&nbsp;</div>
                        <!-- Buttons related to Followers -->
                        <input type="hidden" id="subcost" value="{{$user->settings->subcost}}">
                        @if($follower)
                                <a id="UnFollow" href="#" class="socialButtons2 wannabeInexed follow col-lg-4 noPadding" onclick="openModal(this); return false;"><span class="glyphicon glyphicon-minus-sign"></span> UnFollow</a>
                        @else
                                <a id="Follow" href="#" class="socialButtons2 wannabeInexed follow col-lg-4 noPadding" onclick="openModal(this); return false;"><span class="glyphicon glyphicon-pushpin"></span> Follow</a>
                        @endif
                    @endif
                </div>
            @endif
            </div>
            <div class="col-lg-12">
            <br><br>
                <p id="aboutUser">{{$user->profile->aboutMe}} <a id="readMore" class="darkLinks" onclick="showAboutUser()">Read more..</a></p>
                    @if (Auth::user()->id == $user->id)
                    <p><a class="darkLinks" href="http://b2.com/diary/{{$user->username}}">Read Diary</a></p>
                    @else
                        <?php $susers=Diaryshare::where('duserid','=',$user->id)->where('suserid','=',Auth::user()->id)->first(); ?>
                        @if ((count($susers) >0 && $user->settings->diaryAccess == 'semi') || $user->settings->diaryAccess == 'public')
                        <p><a class="darkLinks" href="http://b2.com/diary/{{$user->username}}">Read Diary</a></p>
                        @endif
                    @endif
            </div>
            <div class="col-lg-12 noPadding">
            <br>
            <h4 style="padding-left:15px ">Secondary Interests:</h4>
                <div class="col-lg-12">
                    <?php $secondaryInterestCount=0; ?>
                    @foreach($interests as $interest)
                    <?php $type = DB::table('user_interests')->where('user_id',$user->id)->where('interest_id',$interest->id)->first(); ?>
                        @if ($type->type == 'secondary')
                            <?php $secondaryInterestCount++; ?>
                            <a class="darkLinks" style="text-decoration: underline" onclick="showUserContent({{$interest->id}})">{{$interest->interest_name}}</a>
                        @endif
                    @endforeach

                </div>
                @if ($secondaryInterestCount == 0)
                <input type="hidden" id="secondaryInterestsStatus" value="false">
                @else
                <input type="hidden" id="secondaryInterestsStatus" value="true">
                @endif
            </div>
        </div>

        <div id="interestsDiv" class="col-lg-7">
            <div id="interestsContainer">
            @if(!Auth::user()->pset)
                <div class="alert alert-info alert-dismissable col-lg-6">
                    <strong>Attention! </strong> Without a valid profile you won't be able to create any content or interact with anyone. So, complete it now and earn yourself upto 300i
                    <br>
                    <a href="{{route('buildProfile')}}"><h3>Complete Profile</h3></a>
                </div>
            @else

            <br>
            <div class="col-lg-12 noPadding">

                <?php $PIcount=0; ?>
                <br><br><br>
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

                            $content = $content->sortByDesc('users')->take(3);
                        ?>
                        <div class="col-lg-4">
                            <a class="darkLinks col-lg-12" style="padding: 0px" onclick="showUserContent({{$interest->id}})"><h4>{{Str::limit($interest->interest_name,15)}}</h4></a>
                        @if (count($content) > 0)
                            <?php $PIcount++; ?>

                            <div id="carousel{{$PIcount}}" class="carousel slide carousel-fade col-lg-12" style="padding: 0px">

                                        <div class="carousel-inner">
                                            <?php $i=0; ?>
                                            @foreach ($content as $tr)
                                                <?php $i++; ?>
                                                @if ($i == 1)
                                                    <div class="item active">
                                                @else
                                                    <div class="item">
                                                @endif

                                                <div>

                                                <?php
                                                if ($tr->text)
                                                    $ClassicRoutes = 'articlePreview';
                                                elseif ($tr->review)
                                                    $ClassicRoutes = 'blogBookPreview';
                                                elseif ($tr->path)
                                                    $ClassicRoutes = 'resource';
                                                else
                                                    $ClassicRoutes = 'collaborationPreview';
                                                ?>

                                                    @if ($tr->path)
                                                        <a href="{{route($ClassicRoutes,$tr->id)}}" target="_blank"><img class="Profileimages" src="{{asset('Images/Resource.jpg')}}" height="100px" width="100px"></a>
                                                    @else
                                                        <a href="{{route($ClassicRoutes,$tr->id)}}" target="_blank"><img class="Profileimages" src="{{asset($tr->cover)}}" height="100px" width="100px"></a>
                                                    @endif
                                                </div>
                                                <div style="height: 200px; overflow: auto">
                                                    <div>
                                                        <div>
                                                            <div class="caption col-lg-12 noPadding" style="padding-top: 5px">
                                                                <a href="{{route($ClassicRoutes,$tr->id)}}" target="_blank" class="darkLinks" style="font-size: 16px">{{$tr->title}}</a>
                                                                <div class="description">{{Str::limit($tr->description,140)}}</div>
                                                            </div>



                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div style="height: 5%">

                                            <ul class="carousel-indicators pull-right" style="left: auto; list-style-type: none">
                                                @for ($contentC = 0; $contentC < $i; $contentC++)
                                                    <?php
                                                        if ($contentC == 0)
                                                            $extraClass = 'active';
                                                       else
                                                            $extraClass = '';
                                                     ?>
                                                    <li data-target="#carousel{{$PIcount}}" data-slide-to="{{$contentC}}" class="bottom-boxes {{$extraClass}}"></li>
                                                @endfor
                                            </ul>
                                        </div>
                                    </div>

                        @else
                        <div class="col-lg-12" style="padding: 0px">
                        <div class="col-lg-12" style="padding: 0px; color: white">
                            <div class="col-lg-12 noPadding contento-divs" style="background-color: #1c5a5e; border-radius: 4px">
                                <img src="{{asset('Images/no-content.jpg')}}" class="col-lg-12 noPadding contento-images" style="height: 225px">
                                <div class="col-lg-12">
                                    <h4 style="font-weight: bolder"><a style="color: white">No work yet.</a></h4>
                                    <p>It seems like {{$user->first_name}} hasn't got any work up there. Rest assured it will be up there soon.</p>
                                </div>
                                <!--<div class="col-lg-12 ifc-readerr" style="text-align: center; background-color: #185256">
                                    <div id="ifc-readerr" class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid #1c5a5e">
                                        <div class="col-lg-12 noPadding"><b>None</b></div>
                                        <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                    </div>
                                    <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                        <div class="col-lg-12 noPadding"><b>Many</b></div>
                                        <div class="col-lg-12 noPadding" style="font-size: 12px">Readers <i class="fa fa-clock-o"></i></div>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                    </div>
                        @endif
                        </div>
                    @endif
                @endforeach

            </div>
            @endif
        </div>
        </div>
    @endif




</div>


<!--Cached views-->
<div id="cachedSettings" class="cache"></div>
<div id="cachedAbout" class="cache"></div>
<div id="cachedQuestions" class="cache"></div>
<div id="cachedContent" class="cache"></div>
<div id="cachedFriendList" class="cache"></div>
<div id="cachedSubscriberList" class="cache"></div>

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