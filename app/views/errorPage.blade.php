<!DOCTYPE html>
<html>
<head>
    <title>Sorry! | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">-->
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">

</head>
<body style="background-color: #000000">

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="position: fixed">
    <div class="container-fluid">
        <div class="navbar-header">
            <a id="logo" class="navbar-brand logo" href="{{route('index')}}">
                <span class='letter' style="text-shadow: 1px 1px 1px green; color: green">B</span>
                <span class='letter'>B</span>
                <span class='letter'>a</span>
                <span class='letter'>r</span>
                <span class='letter'>t</span>
                <span class='letter'>e</span>
                <span class='letter'>r</span>
                <span class='letter'>s</span>
            </a>
        </div>
    </div>
</nav>
<div class="col-lg-12 col-lg-offset-0" style="height: 100%; width: 100%">
    <img src="{{asset('Images/logout.jpg')}}" height="100%" width="100%" style="float: left; po">

</div>
<div class="col-lg-4" style="margin-top: 22.5%; margin-left: 2.5%; font-size: 20px; color: #ffffff; position: absolute" onmousedown='return false;' onselectstart='return false;'>
    Sorry, {{$error}}<br>
   <a href="{{$link}}">Back</a>

</div>

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

</body>
</html>