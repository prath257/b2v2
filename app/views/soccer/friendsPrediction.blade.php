@if($empty)
<div class="col-xs-12 col-sm-5 col-md-3 noPad">
    <input type="text" id="searchFriend" placeholder="Search All Users" class="col-sm-4 col-md-4 col-xs-12 form-control" onkeydown="friendSearchDown()" onkeyup="friendSearchUp()">
    <label id="empty" style="padding: 5px">No Data found for friends. You can search for all users above.</label>
    <div class="col-xs-12 col-sm-12 col-md-12 noPad" id="searchResult" style="margin-top: 5px; display: none">
          <br>
    </div>

</div>
@else
<div class="col-xs-12 col-sm-5 col-md-3 noPad">
    <input type="text" id="searchFriend" placeholder="Search All Users" class="col-sm-4 col-md-4 col-xs-12 form-control" onkeydown="friendSearchDown()" onkeyup="friendSearchUp()">
    <label id="empty" style="display: none; padding: 5px">No Data found</label>
    <div class="col-xs-12 col-sm-12 col-md-12 noPad" id="searchResult" style="margin-top: 5px; display: none">
          <br>
    </div>

</div>
<div class="col-xs-12 noPad"><hr></div>
@foreach($friendsData->fpredict as $fp)
<div class="col-xs-12 col-sm-4 col-md-4 friendPredict">
   <div class="col-xs-8 col-sm-8 col-md-8">
   {{$home}}&nbsp; <b style="color: darkblue">{{$fp->hgoals}}</b>
   <br>v<br>
   {{$away}}&nbsp; <b style="color: darkblue">{{$fp->agoals}}</b>
   </div>
   <div class="col-xs-4 col-sm-4 col-md-4">
    <img src="{{User::find($fp->fid)->profile->profilePic}}" style="height: 50px; width: 50px">
    <br>
    <a href="/user/{{User::find($fp->fid)->username}}">{{User::find($fp->fid)->first_name}}</a>
   </div>
@if(count($fp->scorers)>0)
    <div class="col-xs-12 col-sm-12 col-md-12" style="background: whitesmoke; ">
       @foreach($fp->scorers as $scorer)
       <i style="font-size: 11px; font-weight: bold; color:#000033">{{SoccerPlayer::find($scorer)->last_name}}</i> &nbsp;
       @endforeach
    </div>
@else
   <div class="col-xs-12 col-sm-12 col-md-12" style="background: whitesmoke; ">&nbsp;</div>
@endif
   <div class="col-xs-12 col-sm-12 col-md-12" >&nbsp;</div>
</div>
@endforeach
@endif

