<!DOCTYPE html>
<html>
<head>
    <title>BBarters | Article: {{$article->title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.jpg')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/blogBookPreview.css')}}" rel="stylesheet">
</head>
<body>
<div class="col-lg-6 col-lg-offset-3" style="background-image:url('../Images/articles.jpg'); background-size: cover; color: #ffffff; min-height: 500px">
    <img id="blogBookCover" class="col-lg-5" src="{{asset($article->cover)}}" height="200px" style="margin-top: 10px; box-shadow: 3px 3px 5px silver; min-width: 200px; padding: 0px">
    <div class="col-lg-7" style="padding: 25px">
        <p class="col-lg-12 "><strong>Category:</strong> {{Interest::find($article->category)->interest_name}}</p>
        <p class="col-lg-12"><strong>Cost:</strong> {{$article->ifc}} IFCs</p>
        <p class="col-lg-12"><strong>Readers:</strong> {{$article->users}}</p>
        <p class="col-lg-12"><strong>Writer:</strong> <a href="{{route('user',User::find($article->userid)->username)}}" style="text-decoration: none; font-size: 20px; color: #ffffff"> {{User::find($article->userid)->first_name}} {{User::find($article->userid)->last_name}}</a></p>
    </div>
    <div class="col-lg-12">
        <h2 style="word-wrap: break-word">{{$article->title}}</h2>
        <div class="col-lg-12">&nbsp;</div>
        <div class="col-lg-12">
            <blockquote>{{{$article->description}}}</blockquote>
        </div>

        <div class="col-lg-12">&nbsp;</div>
    </div>
</div>

<!-- Hidden input fields to store data received from article dashboard about the article -->
<input id="cid" name="cid" type="hidden" value="">

<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/pages/resource.js')}}"></script>
</body>
</html>