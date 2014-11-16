<!DOCTYPE html>
<html>
<head>
    <title>Sorry! | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">

    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/index.css')}}" rel="stylesheet" type="text/css" >
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="position: fixed; background-color: white; border: hidden">
    <div class="container-fluid">

        <div class="navbar-header">
            <a></a>
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
<br>
<br>
<br>
<br>
<br>
<div class="alert alert-info alert-dismissable col-lg-6 col-lg-offset-3">
    <strong>Attention! Some problem has occured. We are sorry for the your inconvinience. </strong>
    <br>
    <br>
    <div style="display: none">ThisIsNothingButWasteNoOneNeedsToReadThisNoThisAintAGlitch</div>
    <a href="http://b2.com">BBarters Home</a> @if(Auth::check()) | <a href="http://b2.com/reportException" target="_blank" style="cursor: pointer;">Report this</a> @endif
</div>





<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>
</body>
</html>