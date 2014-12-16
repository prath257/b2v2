<div class="com-xs-12 col-sm-12 col-md-12"><h4>{{$team->name}} Player Ratings</h4></div>
@foreach($squad as $player)
<div class="col-xs-12 col-sm-6 com-md-6">
    <br>
    <div class="col-xs-4 col-sm-3 col-md-3" style="padding-bottom: 2px; font-size: 12px">
        <img src="{{$player->picture}}" width="50px" height="50px">
        <p style="font-weight: bold; color: #000033;padding: 0px">{{$player->last_name}}</p>
    </div>
    <div class="col-xs-8 col-sm-9 col-md-9" style="padding-left: 0px">
        <div class="col-xs-12 col-sm-12 col-md-12" style="padding-left: 0px">
            <textarea id="comment{{$player->id}}" class="form-control" rows="2" width="100%" placeholder="Comments upto 250 chars" onkeyup="checkLength(this)"></textarea>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12" style="padding-top: 5px">
        <input id="rating{{$player->id}}" value="5" type="number" class="rating" min=0 max=10 step=0.5 data-stars=10 data-size="xs">
    </div>
</div>
@endforeach
<div class="col-xs-12 col-sm-12 col-md-12"><hr></div>
<div class="col-xs-8 col-sm-4 col-md-4">
    <button id="submitRatings" class="btn btn-primary " onclick="submitRatings('{{$side}}')">Save Ratings</button>
</div>
<div class="col-xs-12 col-sm-12 col-md-12"><hr></div>