<!DOCTYPE html>
<html lang="en">
<head>

    <title>Guest List | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link href="{{asset('css/pages/events.css')}}" rel="stylesheet">

    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
</head>
<body>

<input type="hidden" id="view" value="attendeeList">

@include('navbar')

<br>
<br>
<br>
<div class="container">
    <h3 class="col-lg-8">Guest List for '{{$event->name}}'</h3>
    <div class="col-lg-4 event-details">
        <br>
        <button id="mail-me" class="btn btn-primary" onclick="mailMe({{$event->id}})">Mail list to inbox</button><div class="waiting"><img  src="{{asset('Images/icons/waiting.gif')}}">Sending..</div>
        <br>
        <br>
    </div>
    <br>
    @if (count($attendees) > 0)
    <div class="table-responsive">
        <table id="example"  class="table table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>E-mail</th>
                <th>Contact No.</th>
            </tr>
            </thead>
            <tbody>
            @foreach($attendees as $a)
                <tr>
                    <td>{{$a->first_name}} {{$a->last_name}}</td>
                    <td>{{$a->email}}</td>
                    <?php $number = DB::table('guest_list')->where('event_id',$event->id)->where('user_id',$a->id)->pluck('contact_no'); ?>
                    <td>{{$number}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
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