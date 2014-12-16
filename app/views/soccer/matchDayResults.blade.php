<input type="hidden" id="matchCount" value="{{count($matches)}}">
<hr>
<div class="col-xs-12 col-sm-12 col-md-12">
@foreach($matches as $match)
          <div class="col-xs-12 col-sm-7 col-md-7" >
                <div class="col-xs-1 col-sm-1 col-md-1">
                <i class="fa fa-check-square" style="display: none" id="done{{$match->id}}"></i>
                <input type="checkbox" id="check{{$match->id}}" style="float: left" onchange="matchPrediction({{$match->id}},this)">
                </div>
                <div class="col-xs-11 col-sm-11 col-md-11">
                <p class="col-xs-12 col-sm-5 col-md-5" style="font-weight: bold">{{SoccerTeam::find($match->hometeam)->name}}</p>
                <p class="col-xs-12 col-sm-1 col-md-1">V</p>
                <p class="col-xs-12 col-sm-5 col-md-5" style="font-weight: bold;">{{SoccerTeam::find($match->awayteam)->name}}</p>
                </div>
          </div>
          <div class="col-xs-12 col-sm-2 col-md-2">
                  <input type="text" id="hg{{$match->id}}" class="col-xs-6 scores"  value="0" maxlength="1"  onchange="saveHomeScoring({{$match->id}},this)" disabled >
                  <input type="text" id="ag{{$match->id}}" class="col-xs-6 scores"  value="0" maxlength="1"  onchange="saveAwayScoring({{$match->id}},this)" disabled>

          </div>
          <div class="col-xs-12 col-sm-3 col-md-3"  id="saveLink{{$match->id}}" style="display: none; padding-top: 15px">
                  <a href="#" class="bbtng" onclick="showScorerModal({{$match->id}})" id="scorersLink{{$match->id}}">Save Scorers</a>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12"><hr></div>

@endforeach
 </div>
  <div class="col-xs-12 col-sm-4 col-md-4">
       <button id="submitPredictions" class="btn btn-success" onclick="submitResults()"> Save Results</button>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-12"><hr></div>
  <div class="row-fluid">
  <iframe src="http://www.bbc.com/sport/football/premier-league/results" height="400px" width="100%" style="overflow: scroll">
  </iframe>
  </div>