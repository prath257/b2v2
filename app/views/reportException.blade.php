<!DOCTYPE html>
<html>
<head>
    <title>Thank you! | BBarters</title>
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

<div class="container">

<div class="modal fade" id="reportThisModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Report the issue and help us resolve it</h4>
            </div>
            <div class="modal-body">
                <fieldset>
                    <p class="col-lg-12" style="padding-left: 0px; margin-top: 15px">What were you trying to do?</p>
                    <textarea id="past" class="form-control col-lg-12" rows="3"></textarea>

                    <p class="col-lg-12" style="padding-left: 0px; margin-top: 15px">What should have been the result?</p>
                    <textarea id="future" class="form-control col-lg-12" rows="3"></textarea>

                    <p class="col-lg-12" style="padding-left: 0px; margin-top: 15px">Please paste the link that you were trying to access.</p>
                    <input id="present" type="text" class="form-control col-lg-12">
                    <div class="col-lg-12">&nbsp;</div>
                    <button id="submitProblem" class="btn btn-success" onclick="submitProblem()">Submit</button>
                    <div id="waiting" style="display: none">
                    <img src="{{asset('Images/icons/waiting.gif')}}" >Loading..
                        </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
</div>


<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>
<script>

$(document).ready(function()
{
    $('#reportThisModal').modal('show');
});
</script>
</body>
</html>