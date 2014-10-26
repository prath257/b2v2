<!DOCTYPE html>
<html>
<head>
    <title>BBarters | Resource: {{$resource->title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.jpg')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.flipcounter.css')}}" rel="stylesheet">
</head>
<body>
<div id="mycounter" style="margin-top: 7.5%; position: absolute; max-width: 250px; display: none" class="col-lg-offset-1">245</div>
<div class="col-lg-6 col-lg-offset-3" style="background-image:url('../Images/Resource.jpg'); color: #ffffff; min-height: 500px">
    <h2>{{$resource->title}}</h2>
    <div class="col-lg-12">&nbsp;</div>
    <div class="col-lg-9">
        <div class="col-lg-12">
            <blockquote>{{{$resource->description}}}</blockquote>
        </div>
    </div>
    <div class="col-lg-12">
    <div class="col-lg-6" style="padding: 0px">
        <p class="col-lg-3"><strong>Uploader:</strong></p>
        <a href="{{route('user',User::find($resource->userid)->username)}}" class="col-lg-9" style="text-decoration: none; font-size: 18px; color: forestgreen; word-wrap: break-word" target="_blank"> {{User::find($resource->userid)->first_name}} {{User::find($resource->userid)->last_name}}</a>
    </div>
    <p class="col-lg-6"><strong>Category:</strong> {{Interest::find($resource->category)->interest_name}}</p>
    </div>
    <div class="col-lg-12">
    <p class="col-lg-6"><strong>Cost:</strong> {{$resource->ifc}} IFCs</p>
    <p class="col-lg-6"><strong>Downloads:</strong> {{$resource->users}}</p>
    </div>
    <div class="col-lg-12">&nbsp;</div>
</div>

<!-- Hidden input fields to store data received from article dashboard about the article -->
<input id="cid" name="cid" type="hidden" value="">

<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/pages/resource.js')}}"></script>
<script src="{{asset('js/jstween-1.1.min.js')}}"></script>
<script src="{{asset('js/jquery.flipcounter.js')}}"></script>
</body>
</html>