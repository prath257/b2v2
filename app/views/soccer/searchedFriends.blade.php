@foreach($users as $player)
@if($player->pset==true)
<div class="col-xs-12 col-sm-12 col-md-12 searchResult noPad" onclick="getUserData({{$player->id}})">
   <div class="col-xs-2 col-md-2 col-sm-2 noPad">
       <img src="{{$player->profile->profilePic}}" width="45px" height="45px">
   </div>
   <div class="col-xs-10 col-md-10 col-sm-10">
        <div class="col-xs-12 col-sm-12 col-md-12">
           <b>{{$player->first_name}}&nbsp;{{$player->last_name}}</b>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
              <i style="font-size: 10px">{{$player->username}}</i>
        </div>
   </div>
</div>
@endif
@endforeach