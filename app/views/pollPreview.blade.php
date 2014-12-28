<!DOCTYPE html>
<html>
<head>
    <title>BBarters | Quiz: {{$quiz->title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/search.css')}}" rel="stylesheet">
</head>
<body>

@include('navbar')

<div id="mycounter" style="margin-top: 7.5%; position: absolute; max-width: 250px; display: none" class="col-lg-offset-1">245</div>
<br>
<br>
<br>
<div class="col-lg-6 col-lg-offset-3 well" style="margin-top: 3%; min-height: 500px">
    <h2>{{$quiz->title}}</h2>
    <div class="col-lg-12">&nbsp;</div>
    <div class="col-lg-9">
        <div class="col-lg-12">
            <blockquote>{{{$quiz->description}}}</blockquote>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="col-lg-6" style="padding: 0px">
            <p class="col-lg-3"><strong>Uploader:</strong></p>
            <a href="{{route('user',User::find($quiz->ownerid)->username)}}" class="col-lg-9" style="text-decoration: none; font-size: 18px; color: forestgreen; word-wrap: break-word" target="_blank"> {{User::find($quiz->ownerid)->first_name}} {{User::find($quiz->ownerid)->last_name}}</a>
        </div>
        <p class="col-lg-6"><strong>Category:</strong> {{Interest::find($quiz->category)->interest_name}}</p>
    </div>
    <div class="col-lg-12">
        <p class="col-lg-6"><strong>Cost:</strong> {{$quiz->ifc}} IFCs</p>
    </div>
    <div class="col-lg-12">&nbsp;</div>
    <a href="{{route('quiz',$quiz->id)}}" class="btn btn-success col-lg-3 col-lg-offset-1" style="padding: 10px">Take Quiz</a>
</div>

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/pages/resource.js')}}"></script>
</body>
</html>