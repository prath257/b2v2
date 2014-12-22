@if(count($feeds)>0)
<div class="col-xs-12 col-sm-12 col-md-12 noPad">
		@foreach($feeds as $tweet)
		    @if($tweet->type=='fan')
		        <p><b>#<a href="/user/{{$tweet->username}}">{{$tweet->username}}</a>: </b>{{Twitter::linkify($tweet->comment)}}</p>
		    @else
		        <p><b>#{{$tweet->username}}: </b>{{Twitter::linkify($tweet->comment)}}</p>
		    @endif
		    @if($tweet->snap!=null)
		        <img src="{{$tweet->snap}}" class="img-responsive">
		    @endif
		    <hr>
		@endforeach
</div>
@endif


