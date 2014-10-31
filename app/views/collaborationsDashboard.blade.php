<!DOCTYPE html>
<html>
<head>
    <title>Collaborations Dashboard | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <!-- Latest compiled and minified CSS -->
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('dataTables.bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/blogBookDashboard.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/morris.css')}}" rel="stylesheet">
    <!-- Optional theme -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
    <!-- Data tables CDN -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/505bef35b56/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <script src="{{asset('js/raphael.js')}}"></script>
    <script src="{{asset('js/morris.js')}}"></script>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=431744100304343&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

@include('navbar')

<input type="hidden" id="collaborationIdForInvite" value="">
<br>
<br>
<br>
<br>
<div class="container">
    @if(Auth::user()->pset)
    <a data-toggle="modal" data-target="#newCollaborationModal" class="btn btn-success col-lg-2">+ Start New Collaboration</a>
    <br><br><br>
    <div class="panel-group col-lg-10" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            Collaborations Owned
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="table-responsive">
                        <table id="example"  class="table table-condensed table-hover" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Chapters</th>
                                <th>Readers</th>
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
                            Collaborations Contributed
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="table-responsive">
                        <table id="example2"  class="table table-condensed table-hover" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Chapters</th>
                                <th>Readers</th>
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

         <div class="col-lg-2">
             <div id="donut-collaborations" style="height: 250px; width: 280px"></div>
                 <br>
                 <br>
                 <ul id="collaborationsData" class="nav nav-pills ranges col-lg-offset-1">
                      <li id="c7"><a href="#" data-range='7'>7</a></li>
                      <li id="c30"><a href="#" data-range='30'>30</a></li>
                      <li id="c90" class="active"><a href="#" data-range='90'>90</a></li>
                 </ul>
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

<!-- NewCollaboration Modal -->
<div class="modal fade" id="newCollaborationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">New Collaboration</h4>
            </div>
            <div id="inviteBody" class="modal-body">
                {{Form::open(array('route'=>'newCollaboration','id'=>'newCollaborationForm','class'=>'form-horizontal','files'=>true))}}
                <!--<form id="newCollaborationForm" method="post" action="{{route('newCollaboration')}}" enctype="multipart/form-data" class="form-horizontal">-->
                    <fieldset>

                        <div class="col-lg-6 col-lg-offset-3">
                            <h3 style="text-align: center">Collaboration Cover</h3>
                        </div>

                        <img id="defaultCover" class="col-lg-6 col-lg-offset-3" height="150px" src="{{asset('Images/Collaboration.jpg')}}">

                        <div class="col-lg-12">&nbsp;</div>

                        <div class="col-lg-6 col-lg-offset-3 fileUpload btn btn-default">
                            <span>Upload Cover</span>
                            <input type="file" id="uploadCover" class="upload" name="uploadCover" style="width: 100%" onchange="changeCollaborationCover()" />
                        </div>

                        <div class="col-lg-12">&nbsp;</div>

                        <div class="form-group">
                            <label class=" col-lg-3 control-label">Title</label>
                            <div class="col-lg-7">
                                <input type="text" id="title" class="form-control" name="title" placeholder="Project Title" autocomplete="off" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" col-lg-3 control-label">Short Description</label>
                            <div class="col-lg-7">
                                <textarea id="shortDescription" class="form-control" name="shortDescription" rows="3" placeholder="A short and precise description for your new Collaboration."></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Category</label>
                            <div class="col-lg-7">
                                <select id="category" class="form-control" name="category">
                                    <option value="">Select a Category</option>
                                    @foreach($categories as $cat)
                                    <option value="{{$cat->id}}">{{$cat->interest_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Cost</label>
                            <div class="col-lg-7">
                                <div class="input-group">
                                    <input id="ifc" name="ifc" type="text" class="form-control" value="0" autocomplete="off">
                                    <span class="input-group-addon">IFCs</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">&nbsp;</div>
                        <div class="form-group col-lg-offset-1">
                            <div class="col-lg-3" style="text-align: right">
                                <strong>NOTE: </strong>
                            </div>
                            <div class="col-lg-7">
                                You can add more people to your collaboration only when your collaboration contains at least one chapter posted by you.
                            </div>
                        </div>
                        <div class="col-lg-12">&nbsp;</div>

                    </fieldset>
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" id="newCollaborationSubmit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- End of NewCollaboration Modal -->

<!-- Invite Contributors Modal -->
<div class="modal fade" id="inviteContributorsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Invite Contributors</h4>
            </div>
            <div id="inviteBody" class="modal-body">
                <fieldset>
                <button type="button" class="col-lg-4 btn btn-info" onclick="amongFriends()">Invite among Friends</button>
                <button type="button" class="pull-right col-lg-4 btn btn-info" onclick="amongOthers()">Invite among Others</button>

                <div class="col-lg-12">&nbsp;</div>
                <div class="col-lg-12">&nbsp;</div>

                <div id="inviteContributorsContent">
                    <div class="form-group col-lg-offset-1">
                        <div class="col-lg-3" style="text-align: right">
                            <strong>NOTE: </strong>
                        </div>
                        <div class="col-lg-7">
                            You can also invite people who aren't already on BBarters. Enter their E-mail under 'Invite among Others'.
                        </div>
                    </div>
                </div>


                <div class="col-lg-12">&nbsp;</div>
                <div class="col-lg-12">&nbsp;</div>

                <div id="amongFriends" style="display: none">
                    <div class="form-group">
                    <label class="col-lg-3 control-label">Friend</label>
                    <div class="col-lg-5">
                        <select id="friend" class="form-control" name="friend">
                            <?php $i = 0 ?>
                                @foreach($friends as $friend)
                                <?php $i++; ?>
                                <option value="{{$friend->email}}">{{$friend->first_name}} {{$friend->last_name}}</option>
                                @endforeach

                                @if ($i == 0)
                                <option value="">No Friends to display.</option>
                                @endif
                        </select>
                    </div>
                    </div>
                    <div class="col-lg-12">&nbsp;</div>
                    <div class="col-lg-9 col-lg-offset-3">

                        <div id="waitingImg" style="display: none">
                            <img  src="{{asset('Images/icons/waiting.gif')}}" >Loading..
                        </div>

                            <button id="friendInviteButton" type="button" onclick="inviteFriend()" class="btn btn-primary">Submit</button>

                    </div>
                </div>

                <div id="amongOthers" style="display: none">
                    <form id="inviteViaEmail" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email address</label>
                            <div class="col-lg-5">
                                <input id="inviteEmail" type="text" class="form-control" name="email" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
                                <button type="submit" id="inviteViaEmailSubmit" onclick="inviteOthers()" class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="col-lg-12">&nbsp;</div>
                <div id="responseBox" class="well col-lg-6 col-lg-offset-3" style="color: darkred; text-align: center; display: none"></div>
                </fieldset>

            </div>
        </div>
    </div>
</div>
<!-- End of Invite Contributors Modal -->
<!-- Modal to show the sharing of Article -->
<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Share Collaboration</h4>
            </div>
            <div class="modal-body" id="shareCollaboration">

            </div>
        </div>
    </div>
</div>
<a href="https://twitter.com/share" class="sharing" data-url="http://b2.com" data-counturl="http://b2.com" data-lang="en" data-count="vertical" style="display: none">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/pages/collaborationsDashboard.js')}}"></script>
</body>
</html>