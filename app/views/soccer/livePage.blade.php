@if(count($feeds)>0)
<div class="col-xs-12 col-sm-12 col-md-12 noPad">
		@foreach($feeds as $tweet)
		    <p><b>#{{$tweet->username}}: </b>{{Twitter::linkify($tweet->comment)}}</p>
		    @if($tweet->snap!=null)
		        <img src="{{$tweet->snap}}" class="img-responsive">
		    @endif
		    <hr>
		@endforeach
</div>
@endif

