<html>
<head>
    <title>{{$media->title}} | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>

    <script>
        $(document).ready(function()
        {
            $('.embed').bind('contextmenu',function() { return false; });
        });
    </script>
</head>

<body style="font-family: 'Segoe UI'; background-color: #000000">
@include('navbar')
<br><br><br>
<div class="container">
    <div class="col-lg-8 col-lg-offset-2">
        @if ($media->type == 'mp4')
        <video class="embed" width="100%" height="50%" controls>
          <source src="{{$media->path}}" type="video/mp4">
          Your browser does not support the video tag.
        </video>
        @elseif ($media->type == 'mp3')
        <audio class="embed" controls>
          <source src="{{$media->path}}" type="audio/mpeg">
        Your browser does not support the audio element.
        </audio>
        @endif
    </div>
</div>

<div class="container">




</div>
<!-- End of IFC Manager -->
<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>
</body>
</html>