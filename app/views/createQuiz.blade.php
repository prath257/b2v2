<!DOCTYPE html>
<html>
<head>
    <title>New Quiz | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/createQuiz.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('css/metro.blue.css')}}" />
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
</head>
<body>

@include('navbar')

<br>
<br>
<br>
<div class="col-lg-7">

    <h2>{{$title}}</h2>
    <input type="hidden" id="quizTitle" value="{{$title}}">
    <input type="hidden" id="quizDescription" value="{{$description}}">
    <input type="hidden" id="quizCategory" value="{{$category}}">
    <input type="hidden" id="quizIFC" value="{{$ifc}}">
    <input type="hidden" id="quizAccess" value="{{$access}}">
    <input type="hidden" id="quizTime" value="{{$time}}">
    <br>
    <div class="col-lg-4">
        <button  class="col-lg-12 btn btn-primary" onclick="maq()">+ Multiple Answer Question</button>
    </div>
    <div class="col-lg-4">
        <button  class="col-lg-12 btn btn-primary" onclick="saq()">+ Single Answer Question</button>
    </div>
    <div class="col-lg-4">
        <button  class="col-lg-12 btn btn-primary" onclick="tfq()">+ True/False Question</button>
    </div>

    <div id="questionandoptions" class="col-lg-12" style="margin-top: 10%">
        <div id="maqDiv" class="col-lg-12 questions" style="display: none">
            <h3>Multiple Answer Question</h3>
            <br>
            <form id="maqForm" class="form-horizontal">
                <fieldset>
                    <div class="form-group">
                        <div class="col-lg-2">Question</div>
                        <div class="col-lg-10">
                            <textarea id="maqQuestion" name="maqQuestion" class="form-control" style="width: 100%" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-2">Options</div>
                        <div class="col-lg-10">
                            <div class="col-lg-6">
                                <p class="col-lg-1"><strong>A.</strong></p>
                                <input id="maqOption1" name="maqOption1" type="text" class="col-lg-11 form-control">
                            </div>
                            <div class="col-lg-6">
                                <p class="col-lg-1"><strong>B.</strong></p>
                                <input id="maqOption2" name="maqOption2" type="text" class="col-lg-11 form-control">
                            </div>
                            <div class="col-lg-12">&nbsp;</div>
                            <div class="col-lg-6">
                                <p class="col-lg-1"><strong>C.</strong></p>
                                <input id="maqOption3" name="maqOption3" type="text" class="col-lg-11 form-control">
                            </div>
                            <div class="col-lg-6">
                                <p class="col-lg-1"><strong>D.</strong></p>
                                <input id="maqOption4" name="maqOption4" type="text" class="col-lg-11 form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-2">Answers</div>
                        <div id="answers" class="col-lg-10">
                            <input type="checkbox" name="answers[]" value="A"> <strong>A</strong>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" name="answers[]" value="B"> <strong>B</strong>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" name="answers[]" value="C"> <strong>C</strong>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" name="answers[]" value="D"> <strong>D</strong>
                        </div>
                    </div>
                    <div class="col-lg-12">&nbsp;</div>
                    <div class="form-group">
                        <button type="submit" id="maqSubmit" class="pull-right btn btn-success col-lg-2" onclick="submitMaq()">Add</button>
                    </div>
                </fieldset>
            </form>
        </div>

        <div id="saqDiv" class="col-lg-12 questions" style="display: none">
            <h3>Single Answer Question</h3>
            <br>
            <form id="saqForm" class="form-horizontal">
                <fieldset>
                    <div class="form-group">
                        <div class="col-lg-2">Question</div>
                        <div class="col-lg-10">
                            <textarea id="saqQuestion" name="saqQuestion" class="form-control" style="width: 100%" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-2">Options</div>
                        <div class="col-lg-10">
                            <div class="col-lg-6">
                                <p class="col-lg-1"><strong>A.</strong></p>
                                <input id="saqOption1" name="saqOption1" type="text" class="col-lg-11 form-control">
                            </div>
                            <div class="col-lg-6">
                                <p class="col-lg-1"><strong>B.</strong></p>
                                <input id="saqOption2" name="saqOption2" type="text" class="col-lg-11 form-control">
                            </div>
                            <div class="col-lg-12">&nbsp;</div>
                            <div class="col-lg-6">
                                <p class="col-lg-1"><strong>C.</strong></p>
                                <input id="saqOption3" name="saqOption3" type="text" class="col-lg-11 form-control">
                            </div>
                            <div class="col-lg-6">
                                <p class="col-lg-1"><strong>D.</strong></p>
                                <input id="saqOption4" name="saqOption4" type="text" class="col-lg-11 form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-2">Answer</div>
                        <div id="answer" class="col-lg-10">
                            <input type="radio" name="answer" value="A"> <strong>A</strong>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="answer" value="B"> <strong>B</strong>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="answer" value="C"> <strong>C</strong>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="answer" value="D"> <strong>D</strong>
                        </div>
                    </div>
                    <div class="col-lg-12">&nbsp;</div>
                    <div class="form-group">
                        <button type="submit" id="saqSubmit" class="pull-right btn btn-success col-lg-2" onclick="submitSaq()">Add</button>
                    </div>
                </fieldset>
            </form>
        </div>

        <div id="tfqDiv" class="col-lg-12 questions" style="display: none">
            <h3>True-False Question</h3>
            <br>
            <form id="tfqForm" class="form-horizontal">
                <fieldset>
                    <div class="form-group">
                        <div class="col-lg-2">Question</div>
                        <div class="col-lg-10">
                            <textarea id="tfqQuestion" name="tfqQuestion" class="form-control" style="width: 100%" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-2">Options</div>
                        <div class="col-lg-10">
                            <div class="col-lg-6">
                                <input name="tfqOption1" type="text" class="col-lg-12 form-control" value="True" disabled>
                            </div>
                            <div class="col-lg-6">
                                <input name="tfqOption2" type="text" class="col-lg-12 form-control" value="False" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-2">Answer</div>
                        <div id="choice" class="col-lg-10">
                            <input type="radio" name="choice" value="A"> <strong>True</strong>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="choice" value="B"> <strong>False</strong>
                        </div>
                    </div>
                    <div class="col-lg-12">&nbsp;</div>
                    <div class="form-group">
                        <button type="submit" id="tfqSubmit" class="pull-right btn btn-success col-lg-2" onclick="submitTfq()">Add</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

</div>

<div id="questionsContainer" class="col-lg-5">
    <div id="questionsDisplay" class="col-lg-12" style="overflow: auto">

        <p style="text-align: center; font-size: 16px">This is how your quiz will look</p>
        <hr>

    </div>
    <button id="quizSubmit" type="button" class="pull-right btn btn-primary col-lg-3 col-lg-offset-1 disabled" onclick="quizSubmit()">Submit</button>
    &nbsp;<a href="{{route('quizDashboard')}}" class="pull-right btn btn-default col-lg-3">Cancel</a>
</div>

<div class="modal fade" id="notifyModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div id="notificationModal" class="modal-dialog">

        <div class="modal-content">

            <div  class="modal-body">
                <fieldset id="notifyText"></fieldset>
            </div>
        </div>

    </div>
</div>

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="{{asset('js/pages/createQuiz.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/jquery.bpopup.min.js')}}"></script>
</body>
</html>