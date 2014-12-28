@if ($mode == 'get')
    <!DOCTYPE html>
    <html>
    <head>
        <title>Friends | BBarters</title>
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
            <script src="{{asset('js/docready.js')}}"></script>
            <script type="text/javascript" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
            <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/505bef35b56/integration/bootstrap/3/dataTables.bootstrap.js"></script>

    </head>
    <body>
    <input type="hidden" id="docreadyrequest" value="friendlist">
    @include('navbar')


@endif
<br>
<br>
<br>
<div class="col-lg-10 col-lg-offset-1">
    <div class="col-lg-12 well" style="align-content: center">
        <div class="col-lg-1">
            <img src="{{Auth::user()->profile->profilePic}}" height="50px" width="50px">
        </div>
        <div class="col-lg-11">
            <p class="col-lg-12" style="font-size: 24px; padding: 0px">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</p>
            <br>
            <div class="col-lg-12" style="padding: 0px">
                <p class="col-lg-2" style="padding: 0px">Friends: <b>{{$friends}}</b></p>
                <p class="col-lg-3" style="padding: 0px">New Friend Requests: <b>{{$newFriendRequests}}</b></p>
                <p class="col-lg-3" style="padding: 0px">Pending Sent Requests: <b>{{$pendingSentRequests}}</b></p>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-10 col-lg-offset-1">
    <div class="col-lg-10">

        <h4 class="col-lg-5">All Friends</h4>
        <div class="col-lg-4">

            <input type="text" id="searchfriends" class="form-control col-lg-9" placeholder="Search friends" onkeyup="checkKey()" autocomplete="off">


        </div>
        <div style="display: none;" id="loadingImage">
            <img  src="{{asset('Images/icons/waiting.gif')}}" style="height: 35px; width: 35px">Loading..
        </div>



        <hr class="col-lg-12">
        @if (count($allFriends) > 0)
        <?php $i=0; ?>
        <div id="appendFriends" class="col-lg-12 noPadding">
            @foreach ($allFriends as $aF)

                   @if ($i < 12)

                    <?php $i++; ?>

                    @if ($i==1 || $i==7)
                   <div class="col-lg-12 friend-row">
                    @endif

            <div class="col-lg-2 noPadding userDiv" id="allFriends{{$aF}}">
                <img class="col-lg-12 socialImages" src="{{User::find($aF)->profile->profilePic}}" height="50px" style="border-radius: 50%; box-shadow: 0px 0px 10px silver">

                <div class="col-lg-2 col-lg-offset-5 noPadding minuses" title="Unfriend" style="text-align: center; cursor: pointer; background-color: #222; border-radius: 50%; color: #ffffff; position: absolute; box-shadow: 0px 0px 10px white"  onclick="deleteFriend({{$aF}})"><span class="glyphicon glyphicon-minus"></span></div>
                <div class="col-lg-12">&nbsp;</div>
                <div class="col-lg-12 noPadding">
                    <p class="col-lg-12 noPadding relationName">{{User::find($aF)->first_name}} {{User::find($aF)->last_name}}</p>
                    <a href="{{route('user',User::find($aF)->username)}}" class="userName"><p class="col-lg-12 noPadding">{{'@'.User::find($aF)->username}}</p></a>
                </div>
            </div>

                         @if ($i==6 || $i==12)
                        </div>
                        @endif

            @endif
            @endforeach

            @if(count($allFriends) % 6 != 0 && count($allFriends) > 0 && count($allFriends) < 12)
                </div>
            @endif

        </div>

        @if (count($allFriends) > 12)
        <button id="loadMoreFriends" class="btn btn-default col-lg-2" onclick="loadMoreFriends()">Show More</button>

        <br><br>
        @endif
        @else
        <p id="NoFriends" style="text-align: center">NONE.</p>
        @endif
    </div>
    <div class="col-lg-2 noPadding">
        <div class="col-lg-12">
            <h4 style="text-align: center">New Friend Requests</h4>
            <hr>
            @if (count($allRequests) > 0)
                <?php $i=0; ?>
                @foreach ($allRequests as $aR)
                    <?php $i++; ?>
                    @if($i%3==1)
                    <div class="col-lg-12 noPadding">
                    @endif
                    <div class="col-lg-12 userDiv" id="newRequest{{$aR}}">
                        <img class="col-lg-12 socialImages" src="{{User::find($aR)->profile->profilePic}}" height="50px" style="border-radius: 50%; box-shadow: 0px 0px 10px silver">
                        <div class="col-lg-12">&nbsp;</div>
                        <p class="col-lg-12 noPadding relationName">{{User::find($aR)->first_name}} {{User::find($aR)->last_name}}</p>
                        <a href="{{route('user',User::find($aR)->username)}}" class="userName"><p class="col-lg-12 noPadding">{{'@'.User::find($aR)->username}}</p></a>

                        <div class="col-lg-12 noPadding">
                            <div class="col-lg-2 col-lg-offset-4 noPadding ticks" style="text-align: center; cursor: pointer; background-color: green; border-radius: 50%; color: #ffffff; z-index: 100" onclick="acceptNewRequest({{$aR}})"><span class="glyphicon glyphicon-ok"></span></div>
                            <div class="col-lg-2 col-lg-offset-1 noPadding crosses" style="text-align: center; cursor: pointer; background-color: brown; border-radius: 50%; color: #ffffff; z-index: 100" onclick="removeRequest({{$aR}})"><span class="glyphicon glyphicon-remove"></span></div>
                        </div>
                        <div class="col-lg-12" style="z-index: 0">&nbsp;</div>
                    </div>
                    @if($i%3==0)
                    </div>
                    @endif
                @endforeach
                @if(count($allRequests)%3 != 0)
                    </div>
                @endif
            @else
                <p style="text-align: center">NONE.</p>
            @endif
        </div>
        <div class="col-lg-12">

            <h4 style="text-align: center">Pending Friend Requests</h4>
            <hr>
            @if (count($allPendingRequests) > 0)
                <?php $i=0; ?>
                @foreach ($allPendingRequests as $aPR)
                    <?php $i++; ?>
                    @if($i%3==1)
                        <div class="col-lg-12 noPadding">
                    @endif
                    <div class="col-lg-12 userDiv" id="pendingRequest{{$aPR}}">
                        <img class="col-lg-12 socialImages" src="{{User::find($aPR)->profile->profilePic}}" height="50px" style="border-radius: 50%; box-shadow: 0px 0px 10px silver">
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12 noPadding">
                            <p class="col-lg-10 noPadding relationName">{{User::find($aPR)->first_name}} {{User::find($aPR)->last_name}}</p>
                            <a href="{{route('user',User::find($aPR)->username)}}" class="userName"><p class="col-lg-12 noPadding">{{'@'.User::find($aPR)->username}}</p></a>

                            <div class="col-lg-2 noPadding crossesssss" style="text-align: center; cursor: pointer; background-color: brown; border-radius: 50%; color: #ffffff; z-index: 100"  onclick="cancelPendingRequest({{$aPR}})"><span class="glyphicon glyphicon-remove"></span></div>
                        </div>
                        <div class="col-lg-12">&nbsp;</div>
                    </div>
                    @if($i%3==0)
                        </div>
                    @endif
                @endforeach
                @if(count($allPendingRequests)%3 != 0)
                    </div>
                @endif
            @else
            <p style="text-align: center">NONE.</p>
            @endif
        </div>
    </div>
</div>

@if ($mode == 'get')
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/jquery.metro.js')}}"></script>
<script src="{{asset('js/summernote.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/jstween-1.1.min.js')}}"></script>
<script src="{{asset('js/jquery.flipcounter.js')}}"></script>
<script src="{{asset('js/bootstrap-switch.js')}}"></script>
    </body>
    </html>
    @endif