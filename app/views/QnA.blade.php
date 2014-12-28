@if ($mode == 'get')
    <!DOCTYPE html>
    <html>
    <head>
        <title>QNA | BBarters</title>
            <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

            <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
            <link href="{{asset('css/pages/profile.css')}}" rel="stylesheet">
            <link href="{{asset('css/logo.css')}}" rel="stylesheet">
            <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
            <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
            {{--<link rel="stylesheet" type="text/css" href="{{asset('css/metro.blue.css')}}" />--}}
            <link href="{{asset('dataTables.bootstrap.css')}}" rel="stylesheet">
            <link href="{{asset('css/summernote.css')}}" rel="stylesheet">
            <link href="{{asset('css/jquery.flipcounter.css')}}" rel="stylesheet">
            <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
            <link href="{{asset('css/bootstrap-switch.css')}}" rel="stylesheet">

            <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
            <script src="{{asset('js/jquery.min.js')}}"></script>
            <script src="{{asset('js/jquery.Jcrop.min.js')}}"></script>
            <script src="{{asset('js/bootstrap.js')}}"></script>
            <script src="{{asset('js/docready.js')}}"></script>
            <script type="text/javascript" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
            <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/505bef35b56/integration/bootstrap/3/dataTables.bootstrap.js"></script>

    </head>
    <body>
    <input type="hidden" id="docreadyrequest" value="qna">
    <input type="hidden" id="profileId" value="{{$user->id}}">
    @include('navbar')


@endif

<br>
<br>
<br>
<div class="col-lg-5 col-lg-offset-1">
    <div class="col-lg-12 well" style="align-content: center">
        <div class="col-lg-3">
            <img src="{{$user->profile->profilePic}}" height="50px" width="50px">
        </div>
        <div class="col-lg-9">
            <p class="col-lg-12" style="font-size: 24px; padding: 0px">{{$user->first_name}} {{$user->last_name}}</p>
        </div>
        </div>
    </div>
    <div class="col-lg-6" style="padding: 25px">
    @if (Auth::check())
        @if (Auth::user()->id == $user->id)
        <button class="btn btn-success" data-toggle="modal" data-target="#oldQuestionsModal">View previous questions</button>
        @else
        <button type="button" class="btn btn-primary" onclick="askQuestion()">
            @if ($user->gender == 'male')
            Ask Him
            @elseif ($user->gender == 'female')
            Ask Her
            @else
            Ask {{$user->first_name}}
            @endif
        </button>
        <br>
        <div class="col-lg-11" style="padding-top: 10px">
            @if ($user->gender == 'male')
            <small>&nbsp;* You need {{$user->settings->minqifc}} IFCs to ask him a question.</small>
            @else
            <small>&nbsp;* You need {{$user->settings->minqifc}} IFCs to ask her a question.</small>
            @endif
        </div>
        @endif
    @endif
    </div>

<br>
    @if ($user->id == Auth::user()->id)
        <div class="col-lg-10 col-lg-offset-1">
            <h3 style="color: dodgerblue">New Questions</h3>
            <br>
            <div class="table-responsive">
                <table id="unansweredQuestions"  class="table table-condensed table-hover" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Question</th>
                        <th>Description</th>
                        <th>Offered IFCs</th>
                        <th>Access</th>
                        <th>Asked by</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-10 col-lg-offset-1">
            <h3 style="color: dodgerblue">I Asked..</h3>
            <br>
            <div class="table-responsive">
                <table id="askedQuestions"  class="table table-condensed table-hover" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Question</th>
                        <th>Description</th>
                        <th>Answer</th>
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

        <div class="modal fade" id="oldQuestionsModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Questions and Answers</h4>
                    </div>
                    <div class="modal-body">
                        <fieldset>
                            <div class="table-responsive">
                                        <table id="answeredQuestions"  class="table table-condensed table-hover" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Question</th>
                                                <th>Description</th>
                                                <th>Answer</th>
                                                <th>Asked by</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>

    @else

<div class="col-lg-10 col-lg-offset-1">
            <h3 style="color: dodgerblue">{{$user->first_name}} answered..</h3>
            <br>
    <div class="table-responsive">
        <table id="answeredQuestions"  class="table table-condensed table-hover" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Question</th>
                <th>Description</th>
                <th>Answer</th>
                <th>Asked by</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
    @endif




<!-- Unsuffucient IFC modal -->
<div class="modal fade" id="unsufficientIFCModal" tabindex="-1" role="dialog" aria-hidden="true" style="font-family: 'Segoe UI'">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Sorry,</h4>
            </div>

            <div class="modal-body">
                <p  id="myModalLabel" style="float: left">You require <p id="unsufficientIFC" style="float: left; margin-left: 2px"></p> IFCs to perform this action. And sadly you dont have these many remaining. Why don't you try earning some IFCs?</p>
                <button type="button" onclick="earnIFC()" class="btn btn-primary" aria-hidden="true">Earn IFCs</button>&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Thanks, I'll check later</button>
            </div>

        </div>
    </div>
</div>
<!-- End of Unsufficient IFC modal -->

<!-- Modal to show that the question was successfully posted -->
<div class="modal fade" id="questionSuccessfullyPostedModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Question Sent!</h4>
            </div>
            <div class="modal-body">
                <p>Your question has been successfully sent to {{$user->first_name}}.<br>You'll receive a mail and your question will be visible on his profile once {{$user->first_name}} has answered your question.</p>
                <button type="button" class="btn btn-primary pull-right" data-dismiss="modal" aria-hidden="true">Okay</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal to show that the answer was successfully posted -->

<!-- AskMe Question Modal -->
<div class="modal fade" id="readDescriptionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Description</h4>
            </div>

            <div id="readDescriptionContent" class="modal-body">

            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="readAnswerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Answer</h4>
            </div>

            <div id="readAnswerContent" class="modal-body">

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="answerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Post Answer</h4>
            </div>
            <fieldset>
                <div id="answerContent" class="modal-body"></div>
            </fieldset>
        </div>

    </div>
</div>
</div>

<!-- AskMe Question Modal -->
<div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Ask</h4>
            </div>

            <div class="modal-body">
                <form id="questionForm" class="form-horizontal" style="width: 100%">
                    <fieldset>
                        <div class="form-group">
                            <div class="col-lg-2"><b>Question</b></div>
                            <div class="col-lg-10">
                                <textarea id="question" class="form-control" name="question" rows="3" style="width: 100%"></textarea>
                            </div>
                        </div>
                        <a href="#" onclick="writeDescription()" id="desLink">Add Description</a>
                        <div class="form-group" id="divDes" style="display: none">
                            <div class="col-lg-2"><b>Description</b> (Not required)</div>
                            <div class="col-lg-10">
                                <textarea class="input-block-level" id="summernote" name="summernote" rows="18" onfocus="checkCharacters()">
                                </textarea>
                                <br>
                            </div>
                        </div>

                        <p style="font-family: consolas, monospace">NOTE: The answer to this question will cost you a minimum {{$user->settings->minqifc}} <i>i</i>. You can offer more <i>i</i> to make your question feel more important.</p>
                        <div class="form-group">
                            <div class="col-lg-3" style="float: left">
                                <b>Ask for:</b>
                                <select id="questionIFC" name="questionIFC" class="form-control" style="width: 100%">
                                    <option value="{{$user->settings->minqifc}}">{{$user->settings->minqifc}}</option>
                                    <option value="{{$user->settings->minqifc+50}}">{{$user->settings->minqifc+50}}</option>
                                    <option value="{{$user->settings->minqifc+100}}">{{$user->settings->minqifc+100}}</option>
                                    <option value="{{$user->settings->minqifc+150}}">{{$user->settings->minqifc+150}}</option>
                                    <option value="{{$user->settings->minqifc+200}}">{{$user->settings->minqifc+200}}</option>
                                </select>
                            </div>
                        </div>
                            <div>
                                <b>Access:</b><br>
                                <div class="bootstrap-switch">

                                    <input id="access" type="checkbox" name="access">
                                </div>
                            </div>
                            <div class="col-lg-3 col-lg-offset-9">
                                <button type="submit" id="questionSubmit" onclick="postQuestion({{$user->id}})" class="btn btn-primary">Submit</button>
                                <div id="waitingImg4" style="display: none">
                                <img  src="{{asset('Images/icons/waiting.gif')}}" >Saving..
                                 </div>
                            </div>

                    </fieldset>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Modal to show that the answer was successfully posted -->
<div class="modal fade" id="answerSuccessfullyPostedModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Answer Posted!</h4>
            </div>
            <div class="modal-body">
                <p>Your answer has been successfully posted.<br>IFCs as promised have been credited to your account.</p>
                <button type="button" class="btn btn-primary pull-right" data-dismiss="modal" aria-hidden="true">Okay</button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Input values for Javascript reference -->
<input type="hidden" id="userId" value="{{$user->id}}">
<input type="hidden" id="minqifc" value="{{$user->settings->minqifc}}">
<!-- Hidden Inputs End -->


@if ($mode == 'get')
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/jquery.metro.js')}}"></script>
<script src="{{asset('js/summernote.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/jstween-1.1.min.js')}}"></script>
<script src="{{asset('js/jquery.flipcounter.js')}}"></script>
<script src="{{asset('js/bootstrap-switch.js')}}"></script>
    </body>
    </html>
    @endif