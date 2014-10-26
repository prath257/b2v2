<!DOCTYPE html>
<html>
<head>
    <title>Settings | '{{$collaboration->title}}' | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('dataTables.bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/editBlogBook.css')}}" rel="stylesheet">
    <!-- Optional theme -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
    <!-- Data tables CDN -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/505bef35b56/integration/bootstrap/3/dataTables.bootstrap.js"></script>

</head>
<body>

@include('navbar')

<br>
<br>
<br>
<a href="{{route('collaborationsDashboard')}}" style="position: absolute; margin-top: 2.5%; margin-left: 2.5%; z-index: 5; text-decoration: none">
    <span class="glyphicon glyphicon-arrow-left"></span>
    <b>BACK</b>
</a>
<div class="container">
    <div class="col-lg-12 well">
        {{Form::open(array('route'=>'editCollaboration','id'=>'updateCollaborationForm','class'=>'form-horizontal','files'=>true))}}
        <!--<form id="updateCollaborationForm" method="post" action="{{route('editCollaboration')}}" enctype="multipart/form-data" class="form-horizontal">-->
            <fieldset>

                <div class="col-lg-3">
                    <h3 style="text-align: center">Collaboration Cover</h3>
                    <br>
                    <img id="existingCover" class="col-lg-12" height="200px" src="{{asset($collaboration->cover)}}">
                    <div class="col-lg-12">&nbsp;</div>
                    <div class="col-lg-10 col-lg-offset-1 fileUpload btn btn-default">
                        <span>Update Cover</span>
                        <input type="file" id="uploadCover" class="upload" name="uploadCover" style="width: 100%" onchange="updateCollaborationCover()" />
                    </div>
                </div>

                <div class="col-lg-9" style="margin-top: 7.5%">
                    <div class="form-group">
                        <label class=" col-lg-3 control-label">Title</label>
                        <div class="col-lg-7">
                            <input type="text" id="title" class="form-control" name="title" value="{{$collaboration->title}}" autocomplete="off" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class=" col-lg-3 control-label">Short Description</label>
                        <div class="col-lg-7">
                            <textarea id="shortDescription" class="form-control" name="shortDescription" rows="3">{{$collaboration->description}}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Category</label>
                        <div class="col-lg-7">
                            <select id="category" class="form-control" name="category" va>
                                <option value="{{$collaboration->category}}">{{Interest::find($collaboration->category)->interest_name}}</option>
                                @foreach($categories as $cat)
                                @if ($cat->interest_name!=Interest::find($collaboration->category)->interest_name)
                                <option value="{{$cat->id}}">{{$cat->interest_name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Cost</label>
                        <div class="col-lg-7">
                            <div class="input-group">
                                <input id="ifc" name="ifc" type="text" class="form-control" value="{{$collaboration->ifc}}" autocomplete="off">
                                <span class="input-group-addon">IFCs</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">&nbsp;</div>

                <div class="col-lg-12">
                    <div id="messages" class="col-lg-2 col-lg-offset-7" style="color: red"></div>

                    <div class="col-lg-2">
                        <button type="submit" id="updateCollaborationSubmit" class="btn btn-primary" onclick="updateCollaboration({{$collaboration->id}})">Save Changes</button>
                    </div>
                </div>

            </fieldset>
        {{Form::close()}}
    </div>
</div>
<div class="container">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            Chapters
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="example"  class="table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Writer</th>
                                    <th>Action</th>
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
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            Contributors
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="example2"  class="table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Contributor</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
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
</div>

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<input type="hidden" id="collaborationId" value="{{$collaboration->id}}">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/pages/collaborationSettings.js')}}"></script>
</body>
</html>