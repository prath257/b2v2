<div class="col-lg-12 noPadding">
    @foreach ($subscriptions as $friend)
    <div class="col-lg-2 userDiv" id="allSubscriptions{{$friend}}">
        <img class="col-lg-12 socialImages" src="{{User::find($friend)->profile->profilePic}}" height="50px" style="border-radius: 50%; box-shadow: 0px 0px 10px silver">
        <div class="col-lg-2 col-lg-offset-4 noPadding minuses" title="Unsubscribe" style="text-align: center; cursor: pointer; color: #ffffff; background-color: #222; border-radius: 50%; position: absolute; box-shadow: 0px 0px 10px white"  onclick="deleteSubscription({{$friend}})"><span class="glyphicon glyphicon-minus"></span></div>
        <div class="col-lg-12">&nbsp;</div>
        <div class="col-lg-12 noPadding">
            <p class="col-lg-10 noPadding relationName">{{User::find($friend)->first_name}} {{User::find($friend)->last_name}}</p>
            <a href="{{route('user',User::find($friend)->username)}}" class="userName"><p class="col-lg-12 noPadding">{{'@'.User::find($friend)->username}}</p></a>

        </div>
    </div>
    @endforeach
    <input id="RemainingSubscriptions{{$subscriptionsCount}}" type="hidden" value="{{$remaining}}">
</div>