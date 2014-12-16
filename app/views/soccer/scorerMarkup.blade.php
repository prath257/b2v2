    <fieldset>
    <div class="col-xs-12 col-sm-12" id="scorePredicted{{$match->id}}">

    </div>

    <div class="col-xs-12 col-sm-12" style="font-size: x-large; font-weight: bold">

      {{SoccerTeam::find($match->hometeam)->name}} Vs {{SoccerTeam::find($match->awayteam)->name}}
      <h5>{{SoccerTeam::find($match->hometeam)->stadium}}</h5>
    </div>

    <div class="col-xs-5 col-sm-5 ">

     <img id="homeLogo"  style="height: 200px" src="{{SoccerTeam::find($match->hometeam)->logo}}">
      <div class="col-xs-12 col-sm-12">&nbsp;</div>
     @for($i=1;$i<=$hg;$i++)
     <select id="homeScorer{{$i}}" class="form-control">
             <option value="0">Own Goal</option>
             @foreach(SoccerTeam::find($match->hometeam)->getPlayers as $player)
             <option value="{{$player->id}}">{{$player->first_name}} {{$player->last_name}}</option>
             @endforeach
     </select>
     @endfor

    </div>
    <div class="col-xs-2 col-sm-2">&nbsp;</div>
    <div class="col-xs-12 col-sm-5 ">
          <img id="homeLogo" style="height: 200px" src="{{SoccerTeam::find($match->awayteam)->logo}}">
          <div class="col-xs col-sm-12">&nbsp;</div>
         @for($j=1;$j<=$ag;$j++)
         <select id="awayScorer{{$j}}" class="form-control">
             <option value="0">Own Goal</option>
             @foreach(SoccerTeam::find($match->awayteam)->getPlayers as $player)
             <option value="{{$player->id}}">{{$player->first_name}} {{$player->last_name}}</option>
             @endforeach
         </select>
         @endfor
    </div>
    <div class="col-xs-12 col-sm-12">&nbsp;</div>
    <div class="col-xs-12 col-sm-12">&nbsp;</div>

    <div class="form-group">
        <div class="col-xs-12 col-sm-12">
            <button type="submit" id="submitPredict" class="btn btn-primary" onclick="savePredictions({{$match->id}},{{$hg}},{{$ag}})">Save</button>
        </div>
    </div>
    </fieldset>