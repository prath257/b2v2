<h3>GoalKeepers</h3>
@foreach($goalies as $player)
<input type="checkbox" id="{{$player->id}}">
{{$player->first_name}}&nbsp;{{$player->last_name}}
<br>
@endforeach
<hr>
<h3>Defenders</h3>
@foreach($defence as $player)
<input type="checkbox" id="{{$player->id}}">
{{$player->first_name}}&nbsp;{{$player->last_name}}
<br>
@endforeach
<hr>
<h3>Midfielders</h3>
@foreach($midfield as $player)
<input type="checkbox" id="{{$player->id}}">
{{$player->first_name}}&nbsp;{{$player->last_name}}
<br>
@endforeach
<hr>
<h3>Strikers</h3>
@foreach($forwards as $player)
<input type="checkbox" id="{{$player->id}}">
{{$player->first_name}}&nbsp;{{$player->last_name}}
<br>
@endforeach
<hr>
<button class="btn btn-primary" onclick="addPlayers('{{$side}}')">Submit Players</button>