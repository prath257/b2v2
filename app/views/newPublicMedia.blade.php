<!DOCTYPE html>
<html>
	<head>
	  <title>New Public Media | BBarters</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">

        <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
        <link href="{{asset('css/logo.css')}}" rel="stylesheet">
        <link href="{{asset('dataTables.bootstrap.css')}}" rel="stylesheet">
        <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
        <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
        <link href="{{asset('css/fileUpload.css')}}" rel="stylesheet">
        <link href="{{asset('css/search.css')}}" rel="stylesheet">
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

	<br><br><br><br>

	<div class="container">
        <div class="col-lg-8 col-lg-offset-2">
<form class="form-horizontal" id="newPublicMediaForm">


                        <div class="col-lg-6 col-lg-offset-3">
                            <h3 style="text-align: center">Media Cover</h3>
                        </div>

                        <img id="defaultCover" class="col-lg-5 col-lg-offset-4" height="150px" src="{{asset('Images/Media.jpg')}}">

                        <div class="col-lg-12">&nbsp;</div>

                        <div class="col-lg-5 col-lg-offset-4 fileUpload btn btn-default">
                            <span>Change media cover</span>
                            <input type="file" id="uploadCover" class="upload" name="uploadCover" style="width: 100%" onchange="changeMediaCover()" />
                        </div>

                        <div class="col-lg-12">&nbsp;</div>

                        <div class="form-group">
                            <label class=" col-lg-3 control-label">Title</label>
                            <div class="col-lg-7">
                                <input type="text" id="title" class="form-control" name="title" placeholder="Media Title" autocomplete="off" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" col-lg-3 control-label">Short Description</label>
                            <div class="col-lg-7">
                                <textarea id="shortDescription" class="form-control" name="shortDescription" rows="3" placeholder="A short and precise description for your new Media."></textarea>
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

                        <div class="form-group" style="text-align: center">
                            <br>
                            <p>Finally, upload your media file here.</p>
                            <div class="fileUpload btn btn-primary" id="changePP2">
                                <span id="selectFileButton2">Select File</span>
                                <input type="file" id="newMedia2" name="newMedia2" class="upload file" onchange="changeButton2()">
                            </div>
                        </div>

                        <div id="mediaProgress2" class="progress progress-striped active" style="display: none">
                            <div id="progressBar2" class="progress-bar progress-bar-primary"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                <span class="sr-only">45% Complete</span>
                            </div>
                        </div>

                        <br>
                        <h3 id="statusMedia2"></h3>

                        <div class="alert alert-success" id="alertTrue2" style="display: none">Uploaded Successfully</div>

                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" id="newPublicMediaUpload" class="btn btn-primary" onclick="uploadNewMedia2()">Upload</button>
                        </div>
                    </div>
                    </form>

        </div>
    </div>


    <input type="hidden" id="refreshed" value="no">
    <script src="{{asset('js/reload.js')}}"></script>

	<script src="{{asset('js/bootstrap.js')}}"></script>
	<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
	<script src="{{asset('js/bootbox.js')}}"></script>
	<script src="{{asset('js/pages/media.js')}}"></script>
    <script src="{{asset('js/search.js')}}"></script>
	</body>
</html>
