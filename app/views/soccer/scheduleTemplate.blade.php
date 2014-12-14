<h4 class="col-xs-12 col-sm-12 col-md-12"> Add New Match</h4>
<div class="col-xs-12 col-sm-7 col-md-7">
    <div class="row">
         <div class="form-group">
             <div class="col-xs-12 col-sm-7 col-md-7">
                      <input class="form-control" id="kickoff" type="text" value="" placeholder="Kick Off Date/Time" >
             </div>
            <br><br>
             <div class="col-xs-12 col-sm-6 col-md-6">
                     <select id="homeTeam" class="form-control" name="homeTeam" >
                          <option value="">Select Home Team</option>
                          @foreach($teams as $team)
                               <option value="{{$team->id}}">{{$team->name}}</option>
                          @endforeach
                     </select>
             </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                      <select id="awayTeam" class="form-control col-xs-12" name="awayTeam" >
                           <option value="">Select Away Team</option>
                           @foreach($teams as $team)
                                <option value="{{$team->id}}">{{$team->name}}</option>
                           @endforeach
                      </select>
             </div>

         </div>
    </div>
         <br>
         <button class="btn btn-success col-xs-6 col-sm-4 col-md-4 " onclick="addMatch()">+ Add Match</button>
         <button class="btn btn-primary col-xs-6 col-sm-4 col-md-4 col-sm-offset-3 col-md-offset-3" onclick="submitSchedule()">Submit Schedule</button>
         <div class="col-xs-12 col-sm-12 col-md-12"><hr></div>
         <div class="col-xs-12 col-sm-12 col-md-12" id="matchList">
         <h4> Matches Added:</h4>

         </div>
         <div class="col-xs-12 col-sm-12 col-md-12"><hr></div>
</div>

<div src="" class="col-xs-12 col-sm-5 col-md-5" style="height:600px;overflow: scroll">
{{$fixtures}}
</div>