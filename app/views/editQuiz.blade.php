<!DOCTYPE html>
<html>
<head>
    <title>Edit Quiz: {{$quiz->title}} | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('dataTables.bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/createQuiz.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('css/metro.blue.css')}}" />
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/505bef35b56/integration/bootstrap/3/dataTables.bootstrap.js"></script>

</head>
<body>

@include('navbar')

<br>
<br>
<br>
<div class="col-lg-7">

    <div class="col-lg-8" style="font-size: 24px">{{$quiz->title}}</div>
    <div class="col-lg-4">
        <button class="col-lg-12 btn btn-warning" onclick="showExistingQuestions()">Edit Existing Questions</button>
    </div>
    <input type="hidden" id="quizid" value="{{$quiz->id}}">
    <br>
    <hr style="margin-top: 22px">
    <h4 style="padding-left: 15px">Add new Questions</h4>
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
                                <p class="col-lg-1"><strong>A</strong></p>
                                <input id="maqOption1" name="maqOption1" type="text" class="col-lg-11 form-control">
                            </div>
                            <div class="col-lg-6">
                                <p class="col-lg-1"><strong>B</strong></p>
                                <input id="maqOption2" name="maqOption2" type="text" class="col-lg-11 form-control">
                            </div>
                            <div class="col-lg-12">&nbsp;</div>
                            <div class="col-lg-6">
                                <p class="col-lg-1"><strong>C</strong></p>
                                <input id="maqOption3" name="maqOption3" type="text" class="col-lg-11 form-control">
                            </div>
                            <div class="col-lg-6">
                                <p class="col-lg-1"><strong>D</strong></p>
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
                                <p class="col-lg-1"><strong>A</strong></p>
                                <input id="saqOption1" name="saqOption1" type="text" class="col-lg-11 form-control">
                            </div>
                            <div class="col-lg-6">
                                <p class="col-lg-1"><strong>B</strong></p>
                                <input id="saqOption2" name="saqOption2" type="text" class="col-lg-11 form-control">
                            </div>
                            <div class="col-lg-12">&nbsp;</div>
                            <div class="col-lg-6">
                                <p class="col-lg-1"><strong>C</strong></p>
                                <input id="saqOption3" name="saqOption3" type="text" class="col-lg-11 form-control">
                            </div>
                            <div class="col-lg-6">
                                <p class="col-lg-1"><strong>D</strong></p>
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

        <p style="text-align: center; font-size: 16px">This is how new questions in the quiz will appear</p>
        <hr>

    </div>
    <button id="quizSubmit" type="button" class="pull-right btn btn-primary col-lg-3 col-lg-offset-1 disabled" onclick="quizSubmit({{$quiz->id}})">Submit</button>
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

<div class="modal fade col-lg-12" id="existingQuestionsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="modal-content col-lg-12">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Manage Existing Questions</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="existingQuestionsTable"  class="table table-condensed table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="col-lg-3" style="padding: 0px">Question</th>
                            <th>Option 1</th>
                            <th>Option 2</th>
                            <th>Option 3</th>
                            <th>Option 4</th>
                            <th class="col-lg-2" style="padding: 0px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="col-lg-3" style="padding: 0px"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="col-lg-2" style="padding: 0px"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="pull-right"><b>* Answers marked bold are the correct answers</b></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editExistingQuestionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Edit Question</h4>
            </div>
            <div id="editExistingQuestionBody" class="modal-body">

            </div>
        </div>
    </div>
</div>

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="{{asset('js/pages/createQuiz.js')}}"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/jquery.bpopup.min.js')}}"></script>
</body>
</html>