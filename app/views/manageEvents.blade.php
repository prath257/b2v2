<!DOCTYPE html>
<html lang="en">
<head>

    <title>Manage Events | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link href="{{asset('css/pages/events.css')}}" rel="stylesheet">

    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
</head>
<body>

<input type="hidden" id="view" value="manageEvents">

@include('navbar')

<br>
<br>
<br>
<div class="container">
    <h3>Your hosted events</h3>
    <br>
    @foreach ($events as $e)
    <div id="Event{{$e->id}}" class="col-lg-12">
        <div class="col-lg-2">
            <img src="{{asset($e->cover)}}" class="col-lg-12" height="50px">
        </div>
        <div class="col-lg-10">
            <h3 class="col-lg-12"><a href="{{route('event',$e->id)}}" target="_blank">{{$e->name}}</a></h3>
            <div class="col-lg-12">
                <a href="{{route('updateEvent',$e->id)}}" class="btn btn-primary">Update</a>
                <a href="{{route('attendeeList',$e->id)}}" class="btn btn-success">View Guest List</a>
                @if ($e->open)
                    <button class="btn btn-info" onclick="toggleEvent(this,{{$e->id}})">Close Registrations</button>
                @else
                    <button class="btn btn-info" onclick="toggleEvent(this,{{$e->id}})">Open Registrations</button>
                @endif
                <button class="btn btn-danger" onclick="deleteEvent({{$e->id}})">Delete</button>
            </div>
        </div>
        <hr class="col-lg-12">
    </div>
    @endforeach

    @if (count($events) == 0)
        None.
    @endif
</div>

    <input type="hidden" id="refreshed" value="no">
    <script src="{{asset('js/reload.js')}}"></script>

    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="{{asset('js/bootbox.js')}}"></script>
    <script src="{{asset('js/pages/events.js')}}"></script>

</body>
</html>