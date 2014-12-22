<p class="barterHeader">GoalKeepers</p>
@foreach($goalies as $player)
<div class="col-xs-12">
  <input type="checkbox" id="{{$player->id}}" class="form-control" style="width: 40px; height: 25px; float: left"><b>{{$player->first_name}}&nbsp;{{$player->last_name}}</b>
</div>
@endforeach
<hr>
<p class="barterHeader">Defenders</p>
@foreach($defence as $player)
<div class="col-xs-12">
  <input type="checkbox" id="{{$player->id}}" class="form-control" style="width: 40px; height: 25px; float: left"><b>{{$player->first_name}}&nbsp;{{$player->last_name}}</b>
</div>
@endforeach
<hr>
<p class="barterHeader">Midfielders</p>
@foreach($midfield as $player)
<div class="col-xs-12">
  <input type="checkbox" id="{{$player->id}}" class="form-control" style="width: 40px; height: 25px; float: left"><b>{{$player->first_name}}&nbsp;{{$player->last_name}}</b>
</div>
@endforeach
<hr>
<p class="barterHeader">Strikers</p>
@foreach($forwards as $player)
<div class="col-xs-12">
  <input type="checkbox" id="{{$player->id}}" class="form-control" style="width: 40px; height: 25px; float: left"><b>{{$player->first_name}}&nbsp;{{$player->last_name}}</b>
</div>
@endforeach
<div class="col-xs-12"><hr></div>
<button class="btn btn-primary center-block"  onclick="addPlayers('{{$side}}')">Submit Players</button>