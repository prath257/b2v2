<!DOCTYPE html>
<html>
<head>
    <title>Edit Chapters | '{{$collaboration->title}}' | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <!-- Latest compiled and minified CSS -->
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('dataTables.bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/search.css')}}" rel="stylesheet">
    <!-- Optional theme -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
    <!-- Data tables CDN -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/505bef35b56/integration/bootstrap/3/dataTables.bootstrap.js"></script>
</head>
<body>

@include('navbar')

<br>
<br>
<br>
<a href="{{route('collaborationsDashboard')}}" style="position: absolute; margin-top: 2.5%; margin-left: 2.5%; z-index: 5; text-decoration: none">
    <span class="glyphicon glyphicon-arrow-left"></span>
    <b>BACK</b>
</a>
<div class="container">

    <h2>Collaboration Title: <i style="color: blue">{{$collaboration->title}}</i></h2>
    <hr>
    <div class="container">
        <br>
        <h3>Chapters</h3>
        <br>
        <br>
        <table id="example"  class="table table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Title</th>
                <th>Writer</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>

    </div>
</div>
<input type="hidden" id="collaborationId" value="{{$collaboration->id}}">

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/pages/editCollaborationChapters.js')}}"></script>
<script src="{{asset('js/search.js')}}"></script>
</body>
</html>