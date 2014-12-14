
 <div class="col-xs-12 col-md-12 col-sm-12">
  <button class="btn btn-primary" id="mrButton" onclick="toggleLinks('mr')">All Match Ratings</button>
  <button class="btn btn-success" id="cmButton" onclick="toggleLinks('cm')">All Player Comments</button>
  <button class="btn btn-danger" id="grButton" onclick="toggleLinks('gr')" style="display: none">Best Rated Players</button>
  <hr>
 </div>

 <div class="table-responsive col-xs-12 col-sm-6 col-md-6" style="display: none" id="matchRatingsDiv">
   	<table id="myRatingsTable"  class="table table-condensed table-hover" cellspacing="0" width="100%" >
   		<thead>
   		<tr>
   			<th>League</th>
   			<th>Ratings</th>
   		</tr>
   		</thead>
   		<tbody>
   		<tr>
   			<td></td>
   			<td></td>
   	    </tr>
   		</tbody>
   	</table>
 </div>

  <div class="col-xs-12 col-sm-6 col-md-6" id="bestPlayersDiv">
          <div class="col-xs-12 col-sm-6 col-md-6">My Best Rated Players:</div>
          <div id="myBestPlayers" class="col-xs-12 col-sm-12 col-md-12" style="height:400px;"></div>
  </div>

  <div class="col-xs-12 col-md-6 col-sm-6" id="commentsDiv" style="display: none">

        <div class="col-xs-8 col-sm-8 col-md-8">
            <input type="text" class="form-control" placeholder="Search Player for Comments" name="other" id="searchPlayer" onkeydown="playerCommentsDown()" onkeyup="playerCommentsUp('my')">
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12" id="searchResult" style="margin-top: 5px; display: none">
        <br>
        </div>
  </div>



