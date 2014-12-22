<div class="col-xs-12 col-md-12 col-sm-12" >

       <h3>{{$club->name}} - Club Ratings</h3>
       <button class="btn btn-primary" onclick="getClubPlayers({{$club->id}})">Best Players</button>
       <button class="btn btn-success" onclick="getClubComments({{$club->id}})">Player Comments</button>

</div>
 <div class="col-xs-12 col-sm-12 col-md-12" id="bestPlayersDiv" style="display: none">
        <div id="clubBestPlayers" class="col-xs-12 col-sm-12 col-md-12" style="height:400px;"></div>
  </div>

 <div class="col-xs-12 col-md-12 col-sm-12 noPad" id="commentsDiv" style="display: none">
        <br><br>
        <div class="col-xs-12 col-sm-8 col-md-8">
            <input type="text" class="form-control" placeholder="Search Player for Comments" name="other" id="searchPlayer" onkeydown="playerCommentsDown()" onkeyup="playerCommentsUp('{{$club->id}}')">
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12" id="searchResult" style="margin-top: 5px; display: none">
        <br>
        </div>
  </div>