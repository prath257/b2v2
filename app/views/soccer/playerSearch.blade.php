@foreach($players as $player)
<div class="col-xs-12 col-sm-12 col-md-12 searchResult" onclick="getPlayerComments('{{$type}}','{{$player->last_name}}',{{$player->id}})">
   <div class="col-xs-12 col-md-12 col-sm-12 ">
       <b>{{$player->first_name}}&nbsp;{{$player->last_name}}</b>

   </div>
   <div class="col-xs-12 col-md-12 col-sm-12 ">&nbsp;</div>
</div>
@endforeach