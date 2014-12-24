@foreach($comments as $rating)
  <div class="col-xs-12 col-sm-12 col-md-12" style="padding: 5px;border-bottom: 1px whitesmoke solid;">
      <div class="col-xs-4 col-sm-2 col-md-2">
        <img src="{{SoccerPlayer::find($rating->player_id)->picture}}" width="50px" height="50px">
      </div>
      <div class="col-xs-8 col-sm-10 col-md-10 comment">
      <p><b style="color: #000033">{{SoccerPlayer::find($rating->player_id)->last_name}}</b>:{{$rating->comment}} &nbsp;<b>{{$rating->rating}}/10</b></p>
      <p style="font-size: 10px">{{SoccerTeam::find(SoccerSchedule::find($rating->match_id)->hometeam)->name}} Vs {{SoccerTeam::find(SoccerSchedule::find($rating->match_id)->awayteam)->name}}&nbsp;<a style="font-size: 10px" href="/user/{{User::find($rating->user_id)->username}}">{{User::find($rating->user_id)->username}}</a></p>

      </div>

  </div>
@endforeach