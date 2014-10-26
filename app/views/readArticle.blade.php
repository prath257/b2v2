<!DOCTYPE html>
<html>
<head>
	<title>{{$article->title}} | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
	<link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
	<link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.flipcounter.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('css/metro.blue2.css')}}" />
	<link href="{{asset('css/pages/home.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/star-rating.min.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
    <script src="{{asset('js/star-rating.min.js')}}" type="text/javascript"></script>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=431744100304343&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

@include('navbar')

<input type="hidden" id="newUser" value="{{$newUser}}">
<div id="mycounter" style="margin-top: 5%; margin-left: 0%; position: absolute; display: none; max-width: 250px" class="col-lg-offset-1">0</div>
<br>
<br>
<br>


<div class="col-lg-10 col-lg-offset-1" onmousedown='return false;' onselectstart='return false;'>
	<h1>{{$article->title}}</h1>
	<p class="pull-right" style="font-size: 16px"><strong>Category:</strong> {{Interest::find($article->category)->interest_name}}</p>
	<br><hr><br>
    <div class="col-lg-12">
    @if ($article->type == 'Recipe' || $article->type == 'Film Review' || $article->type == 'Music Review' || $article->type == 'Book Review' || $article->type == 'Travel Guide')
    <div class="col-lg-6">
        <img src="{{asset($article->cover)}}" width="100%">
        <br>
    </div>
    @endif
    <br>

        <br>
	    {{$article->text}}
	    <br><br>
	    <a href="{{route('user',User::find($article->userid)->username)}}" style="text-decoration: none; font-size: 18px">- {{User::find($article->userid)->first_name}} {{User::find($article->userid)->last_name}}</a>

    <br><br>
    </div>
    <div class="col-lg-12">
    <div class="col-lg-1" style="padding: 0px">
        <br>
    Share this article:
    </div>
    <div class="col-lg-10" style="padding: 0px">
        <br>
        <div class="fb-share-button" style="padding-bottom:7px" data-href="http://b2.com/articlePreview/{{$article->id}}"></div><br>
    <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://b2.com/readArticle/{{$article->id}}" data-text="Check this out" data-count="none" data-hashtags="bbarters">Tweet</a><br>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
   <div class="fb-send" data-href="http://b2.com/readArticle/{{$article->id}}" data-colorscheme="light"></div>
        <br>
    </div>
    <br><br><br><br><br>
    <p>Comments:</p>

    <div class="fb-comments" data-href="http://b2.com/articlePreview/{{$article->id}}" data-width="600" data-numposts="10" data-colorscheme="light"></div>
    </div>
</div>

<script src="{{asset('js/pages/newUser.js')}}"></script>
<script src="{{asset('js/jstween-1.1.min.js')}}"></script>
<script src="{{asset('js/jquery.flipcounter.js')}}"></script>
</body>
</html>
 