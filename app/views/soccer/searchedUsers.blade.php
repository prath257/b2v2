@foreach($users as $player)
<div class="col-xs-12 col-sm-8 col-md-8 searchResult" onclick="addUser('{{$player->username}}')">
   <div class="col-xs-3 col-md-3 col-sm-3">
       <img src="{{$player->profile->profilePic}}" width="50px" height="50px">
   </div>
   <div class="col-xs-9 col-md-9 col-sm-9">
        <div class="col-xs-12 col-sm-12 col-md-12">
           <b>{{$player->first_name}}&nbsp;{{$player->last_name}}</b>
        </div>
   </div>
</div>
@endforeach