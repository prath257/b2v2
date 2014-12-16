@if(count($feeds)>0)
<div class="col-xs-12 col-sm-12 col-md-12 noPad">
		@foreach($feeds as $tweet)
		    <p><b>#{{$tweet->username}}: </b>{{Twitter::linkify($tweet->comment)}}</p>
		    @if($tweet->snap!=null)
		        <img src="{{$tweet->snap}}" width="275px" height="250px">
		    @endif
		    <hr>
		@endforeach
</div>
@endif

