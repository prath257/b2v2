    <fieldset>
    <div class="col-xs-12 col-sm-12" id="scorePredicted{{$match->id}}">

    </div>

    <div class="col-xs-12 col-sm-12" style="font-size: x-large; font-weight: bold">

      {{SoccerTeam::find($match->hometeam)->name}} Vs {{SoccerTeam::find($match->awayteam)->name}}
      <h5>{{SoccerTeam::find($match->hometeam)->stadium}}</h5>
    </div>

    <div class="col-xs-12 col-sm-5" id="homeList">

     <img id="homeLogo"  style="height: 200px" src="{{SoccerTeam::find($match->hometeam)->logo}}">
      <div class="col-xs-12 col-sm-12">&nbsp;</div>
      <input type="hidden" id="homeMax" value="{{$hg}}">
      <div class="col-xs-12 col-sm-12 col-md-12 noPad">
           <input type="text" class="form-control" placeholder="Search Player for Comments" name="other" id="homesearchPlayer" onkeydown="playerCommentsDown()" onkeyup="playerCommentsUp({{SoccerTeam::find($match->hometeam)->id}},'home')">
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 noPad" id="homesearchResult" style="margin-top: 5px; display: none">
      <br>
      </div>



    </div>
    <div class="col-xs-2 col-sm-2">&nbsp;</div>
    <div class="col-xs-12 col-sm-5" id="awayList">
           <img id="homeLogo" style="height: 200px" src="{{SoccerTeam::find($match->awayteam)->logo}}">
           <div class="col-xs col-sm-12">&nbsp;</div>
           <input type="hidden" id="awayMax" value="{{$ag}}">
           <div class="col-xs-12 col-sm-12 col-md-12 noPad">
                 <input type="text" class="form-control" placeholder="Search Player for Comments" name="other" id="awaysearchPlayer" onkeydown="playerCommentsDown()" onkeyup="playerCommentsUp({{SoccerTeam::find($match->awayteam)->id}},'away')">
           </div>
           <div class="col-xs-12 col-sm-12 col-md-12 noPad" id="awaysearchResult" style="margin-top: 5px; display: none">
           <br>
           </div>
    </div>
    <div class="col-xs-12 col-sm-12">&nbsp;</div>
    <div class="col-xs-12 col-sm-12">&nbsp;</div>

    <div class="form-group">
        <div class="col-xs-12 col-sm-12">
            <button type="submit" id="submitPredict" class="btn btn-primary" onclick="savePredictions({{$match->id}},{{$hg}},{{$ag}})">Save</button>
        </div>
    </div>
    </fieldset>