<!DOCTYPE html>
<html>
<head>
    <title>{{$book->title}} Blogbook</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.flipcounter.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('css/metro.blue2.css')}}" />
    <link href="{{asset('css/pages/readBook.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
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

<input type="hidden" id="bookId" value="{{$book->id}}">
<input type="hidden" id="newUser" value="{{$newUser}}">

<br>
<br>
<br>

<div id="bookIndex" style="float:left;">
    <p style="font-size: 30px">&nbsp;Contents</p>
    <br>
    <hr>
    <?php   $count=0; ?>
    @foreach($chapters as $chapter)
    <a href="#" style="margin-left: 5%" id="{{$chapter->id}}" name="{{$count}}" onclick="showContent(this)"> {{$chapter->title}}</a>
    <?php
        $count++;
    ?>
    <br><br><br>
    @endforeach

</div>
<div style="width: 100%">
    <button id="indexButton" onclick="showIndex()" class="btn btn-success glyphicon glyphicon-list" style="float: left"></button>
    <button id="prevButton" onclick="showPrev()" class="btn btn-success glyphicon glyphicon-backward " style="float: left"></button>
    <button id="nextButton" onclick="showNext()" class="btn btn-success glyphicon glyphicon-forward"></button>
    <div id="mycounter" style="margin-top: 5%; margin-left:0%; position: absolute; display:none;max-width: 250px">0</div>
    <div style="margin-left: 20%">
    <br>
        <div style="float: left">
            <p style="float:left;font-size: 28px; font-family: 'Segoe UI'">{{$book->title}}</p>

        </div>
    &nbsp;<div class="fb-share-button" data-href="http://b2.com/blogBookPreview/{{$book->id}}"></div>
        <br><br>
    <div class="social" style="padding-top: 3%">
	<div style="float: left">
        <div class="fb-send" data-href="http://b2.com/blogBookPreview/{{$book->id}}" data-colorscheme="light"></div>
        &nbsp;
    </div>
	<div>
        <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://b2.com/blogBookPreview/{{$book->id}}" data-text="Check this out" data-count="none" data-hashtags="bbarters">Tweet</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    </div>
    </div>

    <hr>
    <div id="Content" onmousedown='return false;' onselectstart='return false;'>


    </div>
        <br><a href="{{route('user',User::find($book->userid)->username)}}" style="text-decoration: none; font-size: 12px;">- By {{User::find($book->userid)->first_name}} {{User::find($book->userid)->last_name}}</a>
        <hr>
        <div>
            <p>Comments:</p>

            <div class="fb-comments" data-href="http://b2.com/blogBookPreview/{{$book->id}}" data-width="600" data-numposts="10" data-colorscheme="light"></div>
        </div>
    </div>

</div>

<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<script src="{{asset('js/pages/readBlogBook.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/jstween-1.1.min.js')}}"></script>
<script src="{{asset('js/jquery.flipcounter.js')}}"></script>
</body>
</html>






