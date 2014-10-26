<!DOCTYPE html>
<html lang="en">
<head>

    <title>Update Event | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.1/css/bootstrapValidator.min.css"/>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{asset('css/summernote.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/events.css')}}" rel="stylesheet">

</head>
<body>

<input type="hidden" id="view" value="updateEvent">

@include('navbar')

<br>
<br>
<br>
<div class="container">
    {{Form::open(array('route'=>'postUpdateEvent','id'=>'updateEventForm','class'=>'form-horizontal','files'=>true))}}
    <h3>Update Event</h3>
    <hr>
    <br>
    <div class="col-lg-12">
        <div class="col-lg-4">
            <img id="defaultCover" class="col-lg-12 thumbnail" height="250px" src="{{asset($event->cover)}}">

            <div class="col-lg-12">&nbsp;</div>

            <div class="col-lg-12">
                <div class="fileUpload btn btn-default pull-right">
                    <span>Update event cover</span>
                    <input type="file" id="uploadCover" class="upload" name="uploadCover" style="width: 100%" onchange="changeEventCover()" />
                </div>
            </div>

            <div class="col-lg-12">&nbsp;</div>

            <div class="col-lg-12 line">
                <input type="hidden" name="event-id" value="{{$event->id}}">
                <input class="form-control col-lg-12 input-box" name="title" autofocus="" value="{{$event->name}}">
            </div>

            <div class="col-lg-12 line">
                <textarea class="form-control col-lg-12" rows="3" name="prerequesite">{{$event->prerequesite}}</textarea>
            </div>

            <div class="col-lg-12 line">
                <textarea class="form-control col-lg-12" rows="3" name="takeaway">{{$event->takeaway}}</textarea>
            </div>

            <div class="col-lg-12">&nbsp;</div>

        </div>
        <div class="col-lg-8">

            <div id="venueContainer" class="col-lg-12 line">
                <input class="form-control col-lg-12 input-box" name="venue" value="{{$event->venue}}">
            </div>

            <div class="col-lg-5 line">
                <select class="form-control input-box" name="category">
                    <option value="{{$event->category}}">{{Interest::find($event->category)->interest_name}}</option>
                    @foreach($categories as $cat)
                        @if ($cat->id != $event->category)
                            <option value="{{$cat->id}}">{{$cat->interest_name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div id="ifcContainer" class="col-lg-3 line">
                <div class="input-group">
                    <input class="form-control input-box" name="ifc" type="text" autocomplete="off" value="{{$event->ifc}}">
                    <span class="input-group-addon">IFCs</span>
                </div>
            </div>

            <div class="col-lg-4 line">
                <input id="datetimepicker" type="text" class="form-control input-box" name="datetime" value="{{$event->datetime}}">
            </div>

            <div id="summernote-line" class="col-lg-12">
                <textarea id="summernote" class="form-control" name="description">{{$event->description}}</textarea>
            </div>

            <div class="col-lg-12 line">
                <button type="submit" id="updateEventSubmit" class="btn btn-success">Save Changes</button>
            </div>

        </div>
    </div>
    {{Form::close()}}
</div>

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.1/js/bootstrapValidator.min.js"></script>
<script src="{{asset('js/pages/events.js')}}"></script>
<script src="{{asset('js/summernote.min.js')}}"></script>

</body>
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery.datetimepicker.css')}}"/ >
<script src="{{asset('js/jquery.datetimepicker.js')}}"></script>
</html>