@if (count($events) > 0)
<div id="appendEvents{{$interest}}" class="col-lg-12" style="padding: 0px">
    <div class="col-lg-12" style="padding: 0px">
        @foreach ($events as $e)
        <div class="col-lg-3" style="color: #000000">
            <div class="thumbnail">
                <img src="{{$e->cover}}" class="col-lg-12" style="height: 150px">
                <div class="caption" style="padding-bottom: 0px">
                    <p style="text-transform: none; font-size: 20px; padding: 0px">{{$e->name}}</p>
                    <p>
                        Venue: {{$e->venue}}<br>
                        Date & Time: {{$e->datetime}}<br>
                        Hosted by <a href="{{route('user',$e->getHost->username)}}" target="_blank" style="color: #3a5a97">{{$e->getHost->first_name}} {{$e->getHost->last_name}}</a>
                    </p>
                    <a href="{{route('event',$e->id)}}" style="text-decoration: underline; color: #3a5a97">Show Details</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@if ($count > 0)
<button id="loadMoreEvents{{$interest}}" class="btn btn-default" onclick="loadMoreEvents('{{$interest}}',{{$index}})">Load more</button><div id="eventWait{{$interest}}" style="display: none"><img src="{{asset('Images/icons/waiting.gif')}}" >Loading..</div>
<br><br>
@endif
@else
<div style="text-align: center">Looks like people are getting too busy with their work these days. No events!</div>
@endif