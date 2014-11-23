<!DOCTYPE html>
<html>
<head>
    <title>Poll Dashboard | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <!-- Latest compiled and minified CSS -->
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('dataTables.bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/pollDashboard.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/search.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap-switch.css')}}" rel="stylesheet">
    <!-- Data tables CDN -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/505bef35b56/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script>

</script>
</head>
<body>

@include('navbar')

<br>
<br>
<br>
<br>
<div class="container">
    @if(Auth::user()->pset)
    <a data-toggle="modal" data-target="#newPollModal" class="btn btn-success col-lg-2">+ Create Poll</a>
    <br><br><br>
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        Polls
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="table-responsive">
                    <table id="publicPolls"  class="table table-condensed table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Poll</th>
                            <th>Category</th>
                            <th>Cost</th>
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
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                        My Polls
                    </a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="table-responsive">
                    <table id="myPolls"  class="table table-condensed table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Poll</th>
                            <th>Category</th>
                            <th>Cost</th>
                            <th>Action</th>
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
            </div>
        </div>
    <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                        Polls by Friends
                    </a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="table-responsive">
                    <table id="friendsPolls"  class="table table-condensed table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Poll</th>
                            <th>Category</th>
                            <th>Cost</th>

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
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                        Polls from Subscriptions
                    </a>
                </h4>
            </div>
            <div id="collapseFour" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="table-responsive">
                    <table id="subscriptionPolls"  class="table table-condensed table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Poll</th>
                            <th>Category</th>
                            <th>Cost</th>

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
            </div>
        </div>

    </div>
    @else
    <div class="alert alert-info alert-dismissable col-lg-6 col-lg-offset-3">
        <strong>Attention! </strong> You can't access this  Dashboard as you haven't completed your profile yet.
        Without a valid profile you won't be able to create any content or interact with anyone. So, build it now and earn yourself upto 300i
        <br>
        <a href="{{route('buildProfile')}}"><h3>Complete Profile</h3></a>
    </div>
    @endif
</div>
<!-- Modal to input initial details of the article -->
<div class="modal fade" id="newPollModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">New Poll</h4>
            </div>
            <div id="inviteBody" class="modal-body">
                {{Form::open(array('route'=>'createPoll','id'=>'newPollForm','class'=>'form-horizontal'))}}
                <!--<form id="newPollForm" class="form-horizontal" method="post" action="{{route('createPoll')}}">-->
                    <fieldset>

                        <div class="form-group">
                            <label class=" col-lg-3 control-label">Poll Question</label>
                            <div class="col-lg-7">
                                <textarea id="question" class="form-control" name="question" rows="3" placeholder="A short and precise poll question."></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" col-lg-3 control-label">Note</label>
                            <div class="col-lg-7">
                                <textarea id="message" class="form-control" name="message" rows="3" placeholder="A short and precise poll guide."></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Category</label>
                            <div class="col-lg-6">
                                <select id="category" class="form-control" name="category">
                                    <option value="">Select a Category</option>
                                    @foreach($categories as $cat)
                                    <option value="{{$cat->id}}">{{$cat->interest_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!--<div class="form-group">
                            <label class="col-lg-3 control-label">Cost</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <input id="ifc" name="ifc" type="text" class="form-control" value="0" autocomplete="off">
                                    <span class="input-group-addon">IFCs</span>
                                </div>
                            </div>
                        </div>-->

                        <div class="form-group">
                        <label class="col-lg-3 control-label">Access</label>
                        <div class="col-lg-6">
                            <div class="bootstrap-switch">

                            <input id="access" type="checkbox" name="access" checked>

                        </div>
                        </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Options</label>
                            <div class="col-lg-6" style="padding: 0px">
                                <div class="col-lg-12" id="optionGroup">
                                    <input id="op1" name="op1" type="text" class="form-control"  autocomplete="off" placeholder="Option 1">
                                    <br>
                                    <input id="op2" name="op2" type="text" class="form-control"  autocomplete="off" placeholder="Option 2">
                                </div>
                            </div>
                            <br>
                            <a href="#" class="col-lg-2 btn btn-success" onclick="addOption()"> Add Option</a>
                            <br><br>
                            <a href="#" class="col-lg-2 btn btn-danger" onclick="removeOption()">Remove</a>
                        </div>
                    <input type="hidden" name="numop" id="numop" value="2">
                    </fieldset>
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" id="newPollSubmit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                {{Form::close()}}

            </div>
            <div class="modal-footer" title="You earn 20 ifcs for a new Poll. Also, you earn bonus ifcs after crossing milestones, say 100 votes on a poll." style="color: darkgreen">
                <b style="cursor: pointer">WHERE are the ifcs?</b>
              </div>
        </div>
    </div>
</div>

<!-- Modal to show the purchase content -->
<div class="modal fade" id="resultModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Poll Result</h4>
            </div>
            <div class="modal-body" id="pollResult">

            </div>
        </div>



    </div>

</div>

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/pages/pollDashboard.js')}}"></script>
<script src="{{asset('js/search.js')}}"></script>
<script src="{{asset('js/bootstrap-switch.js')}}"></script>
</body>

</html>
