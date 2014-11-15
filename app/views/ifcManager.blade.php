<html>
<head>
    <title>IFC Manager | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('dataTables.bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.flipcounter.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/ifcManager.css')}}" rel="stylesheet">
    <link href="{{asset('css/morris.css')}}" rel="stylesheet">
    <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script src="{{asset('js/raphael.js')}}"></script>
    <script src="{{asset('js/morris.js')}}"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/505bef35b56/integration/bootstrap/3/dataTables.bootstrap.js"></script>

</head>

<body style="font-family: 'Segoe UI'">
@include('navbar')

<div class="container">

<div class="col-lg-12" style="margin-top: 70px; padding:0px">

 <div id="right" class="col-lg-4">
    <div id="left" class="col-lg-4">
                    <div class="col-lg-12">&nbsp;</div>
                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#transferModal">Transfer IFCs</a>
                    <br><br>
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#earnIFCModal">Earn IFCs</a>
            </div>
       <div id="donut-ee" class="col-lg-8" style="height: 220px; padding-left: 0px; padding-right: 0px;"></div>
    </div>

    <div class="col-lg-3" style="text-align: left">
        <div class="col-lg-12" style="font-size: 30px; font-family: 'Segoe UI'">Current Balance:</div>
        <div id="mycounter" class="col-lg-8" style="margin-top: 30px; padding:0px">0</div>

    </div>


    <div id="right" class="col-lg-5">
        <div id="incomeGraph" style="height:240px;"></div>
    </div>

</div>

<div class="col-lg-12" style="margin-top: 30px">
    <div class="table-responsive">
    	<table id="example"  class="table table-condensed table-bordered table-hover" style="font-size: 13px" cellspacing="0" width="100%">
    		<thead>
    		<tr>
    			<th class="col-lg-3">Date</th>
    			<th class="col-lg-6">Transaction Details</th>
    			<th class="col-lg-3">Amount (ifcs)</th>
    		</tr>
    		</thead>
    		<tbody>
    		<tr>
    			<td class="col-lg-3"></td>
    			<td class="col-lg-6"></td>
    			<td class="col-lg-3"></td>
    		</tr>
    		</tbody>
    	</table>
    </div>
</div>

<div class="modal fade" id="earnIFCModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Earn IFC's</h4>
            </div>
            <div class="modal-body">
                <fieldset>
                    <div class="col-lg-6">
                        The simplest way, you can invite other people to join BBarters. On inviting, a mail is sent. If they click on the link in the mailer and sign up, you earn 300 IFCs.<br>
                        <button type="button" class="btn btn-block" onclick="showInviteModal()">Invite People</button>
                    </div>
                    <div class="col-lg-6">
                        You can create Blogbooks, Articles, Collaborations, Resources, Quizes, Polls and earn IFCs. Start Here!<br><br><br>
                        <button class="btn btn-block" onClick="showContentModal()">Create Content</button>
                    </div>
                    <div class="col-lg-12">&nbsp;</div>
                    <div class="col-lg-12">
                        Saw anything going wrong with our code? Want us to improve something? Write us the issue/suggestion within minimal words/screenshots. If found appropriate, you'll be credited upto 500 IFCs.
                        <a href="{{route('reportBug')}}" class="btn btn-alert col-lg-12">Report Bug/ Suggestion</a>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Transfer IFCs</h4>
            </div>
            <div class="modal-body">

                <form id="transferForm" class="form-horizontal">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">IFCs</label>
                            <div class="col-lg-5">
                                <input id="transferIFC" name="transferIFC" class="form-control" style="width: 200px">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Friend</label>
                            <div class="col-lg-5">
                                <select id="friend" class="form-control" name="friend">
                                    <option value="">-- Select a friend --</option>
                                    @foreach($friends as $friend)
                                    <option value="{{$friend->id}}">{{$friend->first_name}} {{$friend->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3" id="submitTransfer">
                                <button type="submit" id="transferSubmit" onclick="postTransfer()" class="btn btn-primary">Submit</button>
                            </div>

                            <div class="col-lg-3 col-lg-offset-3" id="waiting" style="display: none" >
                            <img src="{{asset('Images/icons/waiting.gif')}}">Saving..
                            </div>

                        </div>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="inviteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="closeInviteModal()" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Invite People & Earn 300 IFCs</h4>
            </div>
            <div id="inviteBody" class="modal-body">
                <h6  id="inviteModalLabel">Please enter the name and the e-mail of the person whom you wish to invite yo generate the invite link.</h6>
                <br>
                <form id="inviteForm" class="form-horizontal">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Name</label>
                            <div class="col-lg-5">
                                <input id="inviteName" type="text" class="form-control" name="name"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email address</label>
                            <div class="col-lg-5">
                                <input id="inviteEmail" type="text" class="form-control" name="email" autocomplete="off" />
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" id="inviteSubmit" onclick="postInvite()" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
                <div class="col-lg-12">&nbsp;</div>
                <div id="inviteLinkAndErrors" class="well" style="display: none"></div>
            </div>
        </div>
    </div>
</div>






<div class="modal fade" id="createContentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Create Content</h4>
            </div>
            <div class="modal-body">
                <fieldset>
                    <div class="col-lg-12">
                        On BBarters you can come up with content and put up a price for it. If anyone wants to read/download it, he/she has to purchase it using IFCs ('InfoCurrency', our very own term for virtual currency.). And then obviously, these IFCs are transferred to your account. Its just like dealing content for IFCs!<br>
                        You can use these IFCs to read what others have posted and have some good time here.
                        <br>
                        <br>

                        <div class="col-lg-6">
                            <a href="{{route('articleDashboard')}}" style="text-decoration: none" target="_blank"><b>ARTICLE:</b></a><br>
                            A page long write-up regarding anything that excites you or drives you to write.<br>
                            <hr>
                        </div>

                        <div class="col-lg-6">
                            <a href="{{route('blogBookDashboard')}}" style="text-decoration: none" target="_blank"><b>BLOGBOOK:</b></a><br>
                            Start witing a book and keep on updating it from time to time by adding more and more chapters to it.<br>
                            <hr>
                        </div>

                        <div class="col-lg-6">
                            <a href="{{route('collaborationsDashboard')}}" style="text-decoration: none" target="_blank"><b>COLLABORATION:</b></a><br>
                            Collaborate with people who could collectively write well about a particular topic.<br>
                            <hr>
                        </div>

                        <div class="col-lg-6">
                            <a href="{{route('resourceDashboard')}}" style="text-decoration: none" target="_blank"><b>RESOURCE:</b></a><br>
                            Upload a zip file containing files that people would find useful and be interested to download.<br>
                            <hr>
                        </div>

                        <div class="col-lg-6">
                            <a href="{{route('quizDashboard')}}" style="text-decoration: none" target="_blank"><b>QUIZ:</b></a><br>
                            Create a quiz that people would like to take. Their earning depends on how they score and how difficult the quiz is!<br>
                        </div>

                        <div class="col-lg-6">
                            <a href="{{route('pollDashboard')}}" style="text-decoration: none" target="_blank"><b>POLL:</b></a><br>
                            Put up a question and have all people have their say on it. Every time anyone votes for his choice, you earn IFCs.<br>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>





</div>
<!-- End of IFC Manager -->
<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>


<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/pages/ifcManager.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/jstween-1.1.min.js')}}"></script>
<script src="{{asset('js/jquery.flipcounter.js')}}"></script>

</body>
</html>