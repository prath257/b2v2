<!DOCTYPE html>
<html>
<head>
    <title>Insufficient IFCs BBarters</title>
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/search.css')}}" rel="stylesheet">
</head>
<body style="font-family: Segoe UI">

@include('navbar')

<br>
<br>
<br>

<div class="container">
    @if ($contentIFC!=null && $userIFC!=null)
    <h4 style="text-align: center">Hey, looks like you don't have sufficient IFCs to perform this task. You fell short by <b>{{$contentIFC-$userIFC}} IFCs.</b></h4>
    <h4 style="text-align: center">Well there's no reason to have that amazed expression on your face, you can easily earn some quick IFCs.</h4>
    @endif
    <br><br>

    <div class="col-lg-6 col-lg-offset-3">
        The simplest way, you can invite other people to join BBarters. You'll get a link for every person you invite. Share it with them, and if they click on the link and sign up, you earn 300 IFCs.<br><br>
        <button type="button" class="btn btn-block" onclick="showInviteModal()">Invite People</button>
        <hr><br>
    </div>
    <div class="col-lg-6 col-lg-offset-3">
        Create and contribute content. You can set a fixed price to your products. When people wish to read/use your content, they got to pay the price.<br><br>
        <button class="btn btn-block" onClick="showContentModal()">Learn more about creating content</button>
        <hr><br>
    </div>
    <div class="col-lg-6 col-lg-offset-3">
        Saw anything going wrong with our code? Want us to improve something? Write us the issue/suggestion within minimal words/screenshots. If found appropriate, you'll be credited upto 500 IFCs.
        <a href="{{route('reportBug')}}" class="btn btn-alert col-lg-12">Report Bug/ Suggestion</a>
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

                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" id="inviteSubmit" onclick="postInvite()" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
                <div class="col-lg-12">&nbsp;</div>
                <div id="inviteLinkAndErrors" class="well" style="display: none"></div>
                </fieldset>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/pages/ifcDeficit.js')}}"></script>
<script src="{{asset('js/search.js')}}"></script>
</body>
</html>