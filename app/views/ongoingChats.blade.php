<!DOCTYPE html>
<html>
<head>
    <title id="pageTitle">Chats | BBarters</title>
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/ongoingChats.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/search.css')}}" rel="stylesheet">
    <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
</head>
<body style="font-family: Segoe UI">

@include('navbar')

<div class="modal fade" id="notifyModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div id="notificationModal" class="modal-dialog">

        <div class="modal-content">

            <div  class="modal-body">
                <fieldset id="notifyText"></fieldset>
            </div>
        </div>

    </div>
</div>
<br>
<br>
<br>
<div class="container">

<div class="col-lg-2">

    <div id="ongoingChats" style="margin-top: 5%">
        <h3>Ongoing Chats</h3>
        <hr>
        <div id="ongoingChatsList" class="col-lg-12" style="padding: 0px">

        </div>
    </div>
</div>
    <div class="col-lg-6">
    <div id="chatBPopup" class="col-lg-12" style="border-left: solid 1px lightgray; border-right: solid 1px lightgray">
        <!--<div class="col-lg-12" style="padding: 0px">
            <div style="font-size: 18px; background-color: #000000; margin-left: 85%">
                <a href="#" style="text-decoration: none" onclick="minimizeChat(); return false;"><abbr title="Minimize Chat"><strong>-</strong></abbr></a>&nbsp;
                <a href="#" style="text-decoration: none" onclick="closeChat(); return false;"><abbr title="End Chat"><strong>x</strong></abbr></a>
            </div>
        </div>-->
        <div id="chatIframe" class="col-lg-12" style="padding: 0px">
            <div class="container col-lg-12" style="height: 90%; padding: 0px">

                <div class="col-lg-12" style="height: 95%; padding: 0px">
                    <div id="chatNameHolder" class="col-lg-12" style="z-index: 1; height: 10%; padding: 10px">
                        <div id="chatProfilePic" class="col-lg-3">
                        </div>
                        <div id="chatName" class="col-lg-8" style="color: #0088CC; font-size: 20px;; padding: 5px">
                        </div>
                        <div id="isTyping" class="col-lg-12 pull-right">
                            &nbsp;
                        </div>
                        <div class="col-lg-12">&nbsp;</div>
                    </div>
                    <div id="scrollDiv" class="col-md-12" style="height: 90%; overflow: auto; margin-top: 10%">
                        <br>
                        <br>
                        <br>
                        <br>
                        <div id="chatText"><h3 style="text-align: center"><span id="font-awesome-right" class="glyphicon glyphicon-chevron-left"></span> Pick up a name to start chatting</h3></div>
                        <br>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <div id="chatbar" class="col-lg-12 chatbar" style="height: 10%; padding: 0px">
            <div class="col-md-12" style="padding: 10px">
                <form id="messageForm">
                    <div class="form-group" style="margin: 0px">
                        <div class="input-group">
                            <input id="inputText" type="text" class="form-control" autocomplete="off" placeholder="Type here." onkeydown="isTypingTrue()" onblur="isTypingFalse()" onfocus="focusedSet()" disabled>
                        <span class="input-group-btn">
                        <button id="chatTextSubmit" type="submit" class="btn btn-default" onclick="sendMessage()" style="z-index: 1" disabled>Send</button>
                        </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>


    <div class="col-lg-4">
        <a href="#" style="text-decoration: none; font-size: 20px">Search Online Barters</a>
        <div class="col-lg-12">&nbsp;</div>
        <div class="col-lg-12">
            <form id="chatSearchForm" class="col-lg-12" role="search">
                <div class="form-group col-lg-12">
                    <input id="chatSearch" type="text" class="form-control" placeholder="Search" style="width: 100%" autocomplete="off" onfocus="showChatSearchResultBox()" onblur="hideChatSearchResultBox()" onkeyup="keyUpChatSearch(event)" onkeydown="keyDownChatSearch()">

                    <div id="chatSearchText"></div>
                </div>
            </form>
        </div>
        <br>
        <hr>
        <br>
        <div class="col-lg-12">&nbsp;</div>
        <a href="#" style="text-decoration: none; font-size: 20px">Online Friends</a>
        <div class="col-lg-12">&nbsp;</div>
        <div id="friendlist" class="col-lg-12" style="overflow: auto"></div>
    </div>

</div>


    @if ($chat!=null)
        <input id="hiddenChatId" type="hidden" value="{{$chat->id}}">
        <input id="openChat" type="hidden" value="{{$chat->link_id}}">
        @if($chat->user2 == Auth::user()->id)
            <input id="hiddenChatName" type="hidden" value="{{User::find($chat->user1)->first_name}}">
        @else
            <input id="hiddenChatName" type="hidden" value="{{User::find($chat->user2)->first_name}}">
        @endif
    @else
    <input id="hiddenChatId" type="hidden" value="">
    <input id="openChat" type="hidden" value="">
    <input id="hiddenChatName" type="hidden" value="">
    @endif

    <input id="tunePlayed" type="hidden" value="false"/>
    <input id="newMessagesStatus" type="hidden" value="">
    <input id="loggedout" type="hidden" value="false">


    <audio src="{{asset('Audio/sounds-847-office-2.mp3')}}" id="notificationSound"></audio>

    <div class="modal fade" id="newChatModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">New Chat Request</h4>
                </div>
                <div class="modal-body">
                    <img id="profileImage" src="" height="200px" width="200px">
                    <p id="chatcost"></p>
                    <br>
                    <br>
                    <p id="preReasonText"></p>
                    <br>
                    <br>
                    <form id="newChatForm" class="form-horizontal">
                        <fieldset>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <textarea id="newChatReason" type="text" class="form-control" name="newChatReason" placeholder="Reason" style="width: 100%"></textarea>
                                </div>
                            </div>
                            <div id="error-box" style="color: darkred"></div>
                        </fieldset>
                        <div class="form-group">
                            <div class="col-lg-offset-10">
                                <button type="submit" id="newChatSubmit" onclick="submitChatRequest(this)" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- IFC Manager -->
<div class="modal fade" id="earnIFCModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Earn IFC's</h4>
            </div>
            <div class="modal-body">
                You need More IFCs for this!
                <br><br>
                <fieldset>
                    <div class="col-lg-6">
                        The simplest way, you can invite other people to join BBarters. You'll get a link for every person you invite. Share it with them, and if they click on the link and sign up, you earn 300 IFCs.<br>
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
                            <a data-toggle="modal" data-target="#newArticleModal" style="text-decoration: none; cursor: pointer" target="_blank"><b>ARTICLE:</b></a><br>
                            A page long write-up regarding anything that excites you or drives you to write.<br>
                            <hr>
                        </div>

                        <div class="col-lg-6">
                            <a data-toggle="modal" data-target="#newBlogBookModal" style="text-decoration: none; cursor: pointer" target="_blank"><b>BLOGBOOK:</b></a><br>
                            Start witing a book and keep on updating it from time to time by adding more and more chapters to it.<br>
                            <hr>
                        </div>

                        <div class="col-lg-6">
                            <a data-toggle="modal" data-target="#newCollaborationModal" style="text-decoration: none; cursor: pointer" target="_blank"><b>COLLABORATION:</b></a><br>
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

@include('createArticleBlogBookCollaboration')

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
    <script src="{{asset('js/pages/ongoingChats.js')}}"></script>
    <script src="{{asset('js/search.js')}}"></script>
    <script src="{{asset('js/bootbox.js')}}"></script>
    <script src="{{asset('js/createArticleBlogBookCollaboration.js')}}"></script>
</body>
</html>