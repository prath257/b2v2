<!DOCTYPE html>
<html>
<head>
    <title>Respond to Problem | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
</head>
<body>


<div class="container">


<div class="modal fade" id="respondToBugModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Respond To Problem</h4>
            </div>
            <div class="modal-body">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">IFCs</label>
                            <div class="col-lg-5">
                                <input id="ifc" name="ifc" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Response</label>
                            <div class="col-lg-5">
                                <textarea id="response" name="response" rows="3" style="width: 100%"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
                                <button id="postButton" type="button" class="btn btn-primary" onclick="postResponseProblem({{$userid}})">Submit</button>
                            </div>
                        </div>

                    </fieldset>
            </div>
        </div>
    </div>
</div>


    <div class="form-group" style="margin-top: 30px; text-align: center;" >
        <button class="btn-success" onclick="showRespond()">Give Respnose</button>
           <br>
           <br>
           <br>

    </div>


    <input type="hidden" id="refreshed" value="no">
</div>



<script src="{{asset('js/reload.js')}}"></script>

<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/pages/respondToBug.js')}}"></script>
</body>
</html>