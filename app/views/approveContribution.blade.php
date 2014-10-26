<!DOCTYPE html>
<html>
<head>
    <title>{{$collaboration->title}} | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">

    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">

</head>
<body>
<div class="col-lg-12" id="approvalDiv">
    <br>
    <button class="btn btn-success verdictButtons" onclick="approve('true',{{$contribution->id}})">Approve</button>
    <button class="btn btn-danger verdictButtons" onclick="approve('false',{{$contribution->id}})">Decline</button>

</div>
<div id="container" class="container">

    <div class="menu-panel">
        <h3>{{$contribution->title}}</h3>
        <hr>
     </div>

    <div class="bb-custom-wrapper">

        {{$contribution->text}}



    </div>

</div><!-- /container -->
<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>

<script src="{{asset('js/pages/approveContribution.js')}}"></script>
</body>
</html>
