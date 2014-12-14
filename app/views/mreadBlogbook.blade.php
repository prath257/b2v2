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
<br>
<br>

<div>

    <div style="margin-left: 15%">
        <br>
        <div style="float: left">
            <p style="float:left;font-size: 28px; font-family: 'Segoe UI'">{{$book->title}}</p>

        </div>
        <p style="float:left;font-size: 20px; font-family: 'Segoe UI'">{{$chapter->title}}</p>
        <br><br>
        <div>
            {{$chapter->text}}
            </div>

        </div>

        <hr>

        <hr>
    </div>

</div>


<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
</body>
</html>






