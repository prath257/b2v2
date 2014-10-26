<div class="col-lg-12">
@foreach ($events as $e)
    <input type="hidden" id="RemainingEvents_{{$interest}}_{{$eventsCount}}" value="{{$count}}">
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