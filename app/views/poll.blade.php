<!DOCTYPE html>
<html>
<head>
    <title>Poll | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta property="og:title" content="BBarters | {{$poll->question}} By {{User::find($poll->ownerid)->first_name}} {{User::find($poll->ownerid)->last_name}}" />
    <meta property="og:description" content="{{$poll->message}}" />
    <meta property="og:image" content="{{asset('Images/Poll.png')}}" />
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/poll.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.flipcounter.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">

    <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
</head>
<body style="font-family: 'Segoe UI'">
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=431744100304343&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

@include('navbar')

<br>
<br>
<br>
<div id="mycounter" style="margin-top:1%; margin-left: 7%; max-width: 250px; position: absolute; display:none" class="col-lg-offset-1">0</div>
<input type="hidden" id="IFC" value="{{$poll->ifc}}">
<br>
<br>
<br>
<div class="col-lg-6 col-lg-offset-3">
    <div class="col-lg-12" style="border: solid 1px lightgray; padding: 15px; border-radius: 5px">
    <h2>{{$poll->question}}</h2>
    <br>
    @foreach($poll->getOptions()->get() as $option)
    <input type="radio" value="{{$option->id}}" name="{{$poll->id}}">{{$option->option}}</input>
    <br><br>
    @endforeach
    @if(Auth::check())
        @if($poll->active && (Auth::user()->id!=$poll->ownerid))
            @if ($poll->active)
                <button class="btn btn-success" onclick="submitPoll('{{$poll->id}}')">Submit</button>
            @else
                <h3> This Poll is now closed for voting!</h3>
                <button class="btn btn-success" onclick="getResults('{{$poll->id}}')"> Show Results</button>
            @endif
        @else
            <br>
            <button class="btn btn-success" onclick="getResults('{{$poll->id}}')"> Show Results</button>
        @endif
    @else
        <button class="btn btn-success" onclick="pleaseLogin()">Submit</button>
    @endif
    <div class="col-lg-10 col-lg-offset-2" style="display: none" id="pollResult">

    </div>
    </div>

    <br>
    <br>
    <br>
    <div class="col-lg-12" style="padding: 15px">
     <div class="col-lg-3"> Share this Poll:</div>
    <div class="col-lg-9">
        <div class="fb-share-button" style="padding: 5px" data-href="http://localhost/b2v2/poll/{{$poll->id}}"></div>
        <br>
        <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://localhost/b2v2/poll/{{$poll->id}}" data-text="Check this out" data-count="none" data-hashtags="bbarters">Tweet</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
        <br>
       <div class="fb-send" data-href="http://localhost/b2v2/poll/{{$poll->id}}" data-colorscheme="light"></div>
    </div>
    </div>
<br><br>

    <br><br>
    <p>Comments:</p>
    <div class="fb-comments" data-href="http://localhost/b2v2/poll/{{$poll->id}}" data-width="600" data-numposts="10" data-colorscheme="light"></div>
</div>

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/pages/poll.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/jstween-1.1.min.js')}}"></script>
<script src="{{asset('js/jquery.flipcounter.js')}}"></script>
</body>
</html>
