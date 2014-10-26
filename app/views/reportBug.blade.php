<!DOCTYPE html>
<html>
<head>
    <title>Report Bug/Suggestion | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/summernote.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
</head>
<body style="font-family: Segoe UI">

@include('navbar')

<br>
<br>
<br>


<div class="summernote container">
    <h3>Report Bug/ Make suggestion</h3>

    <div class="row">
        <form class="form-horizontal" id="postForm">
            <fieldset>
                <div class="form-group">
                    <textarea class="input-block-level" id="summernote" name="summernote" rows="18" onfocus="checkCharacters()">
                    </textarea>
                </div>

            </fieldset>
            <button type="button" id="submitBugButton" class="col-lg-2 pull-right btn btn-success" onclick="submitBug()">Submit</button>
            <span id="error-box" class="pull-right" style="color: darkred; margin-right: 20px"></span>
            <br>
            <br>
        </form>
    </div>
</div>

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/summernote.js')}}"></script>
<script src="{{asset('js/pages/reportBug.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
</body>
</html>