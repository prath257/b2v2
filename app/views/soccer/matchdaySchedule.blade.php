  <br>
  @if(count($matches)>0)
  <div class="col-xs-12 col-sm-12 col-md-12">
  @foreach($matches as $match)
          <div class="col-xs-12 col-sm-6 col-md-6" >
                <div class="col-xs-1 col-sm-1 col-md-1">
                <i class="fa fa-check-square" style="display: none" id="done{{$match->id}}"></i>
                <input type="checkbox" id="check{{$match->id}}" style="float: left" onchange="matchPrediction({{$match->id}},this)">
                </div>
                <div class="col-xs-11 col-sm-11 col-md-11">
                <p class="col-xs-12 col-sm-5 col-md-5" style="font-weight: bold">{{SoccerTeam::find($match->hometeam)->name}}</p>
                <p class="col-xs-12 col-sm-1 col-md-1">V</p>
                <p class="col-xs-12 col-sm-5 col-md-5" style="font-weight: bold; padding-left: 3px">{{SoccerTeam::find($match->awayteam)->name}}</p>
                </div>
          </div>
          <div class="col-xs-12 col-sm-2 col-md-2">
                  <input type="text" id="hg{{$match->id}}" class="col-xs-6 scores"  value="0" maxlength="1"  onchange="saveHomeScoring({{$match->id}},this)" disabled >
                  <input type="text" id="ag{{$match->id}}" class="col-xs-6 scores"  value="0" maxlength="1"  onchange="saveAwayScoring({{$match->id}},this)" disabled>

          </div>
          <div class="col-xs-12 col-sm-4 col-md-4"  id="saveLink{{$match->id}}" style="display: none; padding-top: 15px">
                  <a href="#" class="bbtn"  onclick="saveScores({{$match->id}})">Lock</a>
                  <a href="#" class="bbtng" onclick="showScorerModal({{$match->id}})" id="scorersLink{{$match->id}}">Predict Scorers</a>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4" id="clear{{$match->id}}" style="display: none">
                <button class="btn btn-warning" onclick="clearPrediction({{$match->id}})">Redo Prediction</button>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12"><hr></div>
  @endforeach
   </div>
   <div class="col-xs-12 col-sm-4 col-md-4">
          <button id="submitPredictions" class="btn btn-success" onclick="submitPredictions()"> Submit Predictions</button>
   </div>
  @else
    <div class="com-xs-12 col-sm-12 com-md-12" style="font-family: "Segoe UI", "Segoe WP", "Helvetica Neue", 'RobotoRegular', sans-serif">
    <input type="hidden" id="nopredict" value="no">
     <h3>No matches found.</h3>
             <ul>
             <li>Either you have already made the predictions for this matchday</li>
             <li>Or the prediction time is up for all matches for this matchday</li>
             <li>Predictions are only allowed upto an hour before kickoff.</li>
             <li>Next Matchday predictions will be open,after this matchday results are out.</li>
             </ul>
    </div>
  @endif


