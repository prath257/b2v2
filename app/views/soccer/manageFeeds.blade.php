<hr>
<div class="col-xs-12 col-md-12 col-sm-12">
    <div class="col-xs-3 col-md-3 col-sm-3">
         <button class="btn btn-success" onclick="newFeed()" id="newFeed"> +New Feed</button>
    </div>
    <div class="col-xs-9 col-md-9 col-sm-9" id="createFeedDiv" style="display: none">
         <div class="col-xs-7 col-md-7 col-sm-7">
             <select id="matchSelect" class="form-control" name="matchSelect" onchange="getFriendsPredictions()" >
                     <option value="default">Select Match</option>
                     @foreach($matches as $match)
                         <option value="{{$match->id}}">{{SoccerTeam::find($match->hometeam)->name}} V {{SoccerTeam::find($match->awayteam)->name}}</option>
                     @endforeach
             </select>
         </div>
         <div class="col-xs-5 col-md-5 col-sm-5">
            <button class="btn btn-primary" onclick="createNewFeed()"> Create Feed</button>
         </div>
    </div>
</div>
<div class="col-xs-12"><hr></div>
<h3>Current Active Feeds:</h3>
<div class="col-xs-12 col-md-6 col-sm-6" id="liveFeedsDiv">
@if(count($feeds)==0)
   <p>No live feeds currently.</p>
@else
    @foreach($feeds as $feed)
    <div class="col-xs-12 col-sm-12 col-md-12" id="feed{{$feed->id}}">
       <a href="/liveSoccer/{{$feed->id}}">{{SoccerTeam::find(SoccerSchedule::find($feed->match_id)->hometeam)->name}} V {{SoccerTeam::find(SoccerSchedule::find($feed->match_id)->awayteam)->name}}</a>
       <button class="btn btn-default" onclick="stopFeed({{$feed->id}})"> Stop Feed</button>
       <hr>
    </div>

    @endforeach
    @endif
</div>
