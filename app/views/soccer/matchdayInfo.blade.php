<input type="hidden" id="dayMatch" value="{{$matchday}}">
@if($type=='friends')
 <div class="col-xs-12 col-sm-4 col-md-4">

        <select id="matchSelect" class="form-control" name="matchSelect" onchange="getFriendsPredictions()">
             <option value="default">Select Match</option>
                @foreach($matches as $match)
                    <option value="{{$match->id}}">{{SoccerTeam::find($match->hometeam)->name}} V {{SoccerTeam::find($match->awayteam)->name}}</option>
                @endforeach
        </select>

 </div>
 @elseif($type=='newratings')
  <div class="col-xs-12 col-sm-5 col-md-4">

         <select id="matchSelect" class="form-control" name="matchSelect" onchange="getPlayers()">
              <option value="default">Select Match</option>
                 @foreach($matches as $match)
                     <option value="{{$match->id}}">{{SoccerTeam::find($match->hometeam)->name}} V {{SoccerTeam::find($match->awayteam)->name}}</option>
                 @endforeach
         </select>

  </div>
 @endif
<div class="col-sx-12 col-sm-4 col-md-4">
    <h3>{{$league->name}}</h3>
    <h5>Matchday {{$matchday}}</h5>
</div>
<div class="col-sx-12 col-sm-4 col-md-4">
    <img src="{{$league->logo}}" id="leagueLogo" width="100px" height="100px">
</div>



