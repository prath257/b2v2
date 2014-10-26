<div class="col-lg-12 noPadding friend-row">
    @foreach ($friends as $friend)
        <div class="col-lg-2 userDiv" id="allFriends{{$friend}}">
            <img class="col-lg-12 socialImages" src="{{User::find($friend)->profile->profilePic}}" height="50px" style="border-radius: 50%; box-shadow: 0px 0px 10px silver">
            <div class="col-lg-2 col-lg-offset-5 noPadding minuses" title="Unfriend" style="text-align: center; cursor: pointer; background-color: #222; border-radius: 50%; color: #ffffff; position: absolute; box-shadow: 0px 0px 10px white"  onclick="deleteFriend({{$friend}})"><span class="glyphicon glyphicon-minus"></span></div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12 noPadding">
                <p class="col-lg-12 noPadding relationName">{{User::find($friend)->first_name}} {{User::find($friend)->last_name}}</p>
                <a href="{{route('user',User::find($friend)->username)}}" class="userName"><p class="col-lg-12 noPadding">{{'@'.User::find($friend)->username}}</p></a>

            </div>
        </div>
    @endforeach
    <input id="RemainingFriends{{$friendsCount}}" type="hidden" value="{{$remaining}}">
</div>