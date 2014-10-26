<br>
<br>
<br>
<div class="col-lg-10 col-lg-offset-1">

    <div class="col-lg-12 well" style="align-content: center">
        <div class="col-lg-1">
            <img src="{{asset(Auth::user()->profile->profilePic)}}" height="50px" width="50px">
        </div>
        <div class="col-lg-11">
            <p class="col-lg-12" style="font-size: 24px; padding: 0px">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</p>
            <br>
            <div class="col-lg-12" style="padding: 0px">
                <p class="col-lg-2" style="padding: 0px">Subscribers: <b>{{$subscribers}}</b></p>
                <p class="col-lg-2" style="padding: 0px">Subscriptions: <b>{{$subscriptions}}</b><p>
            </div>
        </div>
    </div>

    <div id="allSubscribers" class="col-lg-12">
        <h3>SUBSCRIBERS</h3>
        <hr>
        @if (count($allSubscribers) > 0)
            <?php $i=0; ?>
            <div id="appendSubscribers" class="col-lg-12 noPadding">
                @foreach ($allSubscribers as $aF)
                    @if ($i < 6)

                <?php $i++; ?>

                        <div class="col-lg-2 userDiv" id="allSubscribers{{$aF}}">
                            <img class="col-lg-12 socialImages" src="{{User::find($aF)->profile->profilePic}}" height="50px" style="border-radius: 50%; box-shadow: 0px 0px 10px silver">
                            <div class="col-lg-12">&nbsp;</div>
                            <div class="col-lg-12 noPadding">
                                <p class="col-lg-11 noPadding relationName">{{User::find($aF)->first_name}} {{User::find($aF)->last_name}}</p>
                                <a href="{{route('user',User::find($aF)->username)}}" class="userName"><p class="col-lg-12 noPadding">{{'@'.User::find($aF)->username}}</p></a>

                            </div>
                        </div>



                    @endif
                @endforeach

            </div>
            @if (count($allSubscribers) > 6)
                <button id="loadMoreSubscribers" class="btn btn-default" onclick="loadMoreSubscribers()">Show More</button>
                <br><br>
            @endif
        @else
            <p style="text-align: center">NONE.</p>
        @endif
    </div>

    <div id="allSubscriptions" class="col-lg-12">
        <h3>SUBSCIPTIONS</h3>
        <hr>
        @if (count($allSubscriptions) > 0)
            <?php $i=0; ?>
            <div id="appendSubscriptions" class="col-lg-12 noPadding">
            @foreach ($allSubscriptions as $aF)
                @if ($i < 6)

                <?php $i++; ?>

                    <div class="col-lg-2 userDiv" id="allSubscriptions{{$aF}}">
                        <img class="col-lg-12 socialImages" src="{{User::find($aF)->profile->profilePic}}" height="50px" style="border-radius: 50%; box-shadow: 0px 0px 10px silver">
                        <div class="col-lg-2 col-lg-offset-4 noPadding minuses" title="Unsubscribe" style="text-align: center; cursor: pointer; color: #ffffff; background-color: #222; border-radius: 50%; position: absolute; box-shadow: 0px 0px 10px white"  onclick="deleteSubscription({{$aF}})"><span class="glyphicon glyphicon-minus"></span></div>
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12 noPadding">
                            <p class="col-lg-10 noPadding relationName">{{User::find($aF)->first_name}} {{User::find($aF)->last_name}}</p>
                            <a href="{{route('user',User::find($aF)->username)}}" class="userName"><p class="col-lg-12 noPadding">{{'@'.User::find($aF)->username}}</p></a>

                        </div>
                    </div>



                @endif
            @endforeach

            </div>
            @if (count($allSubscriptions) > 6)
                <button id="loadMoreSubscriptions" class="btn btn-default" onclick="loadMoreSubscriptions()">Show More</button>
                <br><br>
            @endif
        @else
            <p style="text-align: center">NONE.</p>
        @endif
    </div>

</div>