@foreach($players as $player)
<div class="col-xs-12 col-sm-8 col-md-8 searchResult" onclick="getPlayerComments('{{$type}}',{{$player->id}})">
   <div class="col-xs-3 col-md-3 col-sm-3">
       <img src="{{$player->picture}}" width="50px" height="50px">
   </div>
   <div class="col-xs-9 col-md-9 col-sm-9">
        <div class="col-xs-12 col-sm-12 col-md-12">
           <b>{{$player->first_name}}&nbsp;{{$player->last_name}}</b>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12" style="font-size: 11px">
              {{$player->position}}&nbsp;|&nbsp;{{SoccerTeam::find($player->team)->name}}
        </div>
   </div>
</div>
@endforeach