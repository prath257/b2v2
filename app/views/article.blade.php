<!DOCTYPE html>
<html>
<head>

	<title>New Article | BBarters</title>
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('dataTables.bootstrap.css')}}" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
	<link href="{{asset('css/summernote.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/article.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/fileUpload.css')}}" rel="stylesheet">
    <link href="{{asset('css/star-rating.min.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/logo.css')}}" rel="stylesheet"/>
    <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>

    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/505bef35b56/integration/bootstrap/3/dataTables.bootstrap.js"></script>

    <script src="{{asset('js/star-rating.min.js')}}" type="text/javascript"></script>
</head>
<body style="font-family: 'Segoe UI'">

@include('navbar')

<br>
<br>
<br>
<div id="preview" class="col-lg-10 col-lg-offset-1">
	<div id="previewHTML" class="col-lg-12">

	</div>
	<div class="pull-right">
		<button type="button" class="btn btn-primary" onclick="saveArticle()">OK! Looks cool</button>
		<button type="button" class="btn btn-primary" onclick="editContent()">No, Let me edit!</button>
	</div>
</div>


<div class="summernote container">
    <div class="col-lg-6">
        <p class="col-lg-12" style="margin-top: 10px; margin-bottom: 0px; font-size: 24px">New {{$type}}:</p>
        <p class="col-lg-12" style="color: blue; font-size: 24px"><i>{{$title}}</i></p>
    </div>

    <div id="uploadController" class="col-lg-6" style="display: none">
        <div id="mediaProgress" class="progress progress-striped active col-lg-12" style="margin-top: 10px; padding: 0px">
            <div id="progressBar" class="progress-bar progress-bar-primary"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                <span class="sr-only">45% Complete</span>
            </div>
        </div>
        <p id="uploadName" class="col-lg-12" style="text-align: right; font-size: 16px">This is me</p>
    </div>
	<div class="col-lg-12">
		<form class="form-horizontal" id="postForm">
			<fieldset>

				<div id="articleFields" class="form-group">
                    <h3 id="loading">Loading...</h3>
				</div>
                <div id="fieldset">

                </div>
			</fieldset>
            @if ($type == 'List')
            <button type="button" id="newItemButton" class="btn btn-success" onclick="addNewListItem()">Add List Item</button>
            <button type="button" id="removeLastItemButton" class="btn btn-danger" onclick="removeLastItem()">Remove Last Item</button>
            @elseif ($type == 'Music Review')
            <button type="button" id="newTrackButton" class="btn btn-success" onclick="addNewTrack()">Add Another Track</button>
            <button type="button" id="removeLastTrackButton" class="btn btn-danger" onclick="removeLastTrack()">Remove Last Track</button>
            @elseif ($type == 'Code Article')
            <button type="button" id="newBlockButton" class="btn btn-success" onclick="addNewBlock()">Add Code-Expl. Block</button>
            <button type="button" id="removeLastBlockButton" class="btn btn-danger" onclick="removeLastBlock()">Remove Last Block</button>
            <button type="button" id="resourceButton" class="btn btn-danger" onclick="addResource()">Add Resource</button>
            @endif
			<button type="button" id="previewButton" class="btn btn-primary" onclick="showPreview()">Preview & Submit</button>

            @if ($type == 'Article')
			<button type="button" id="mediaButton" class="btn btn-success" onclick="uploadMedia()">Upload Media</button>
            <button type="button" id="resourceButton" class="btn btn-danger" onclick="addResource()">Add Resource</button>
            @endif
			<a id="cancel" class="btn btn-default" href="{{route('home')}}">Cancel</a>
			<strong><span id="error-box" style="color: darkred"></span></strong>
            <br>
            <br>
		</form>
	</div>
</div>

<div class="modal fade" id="reviewSubmissionModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" onclick="backToTheEdit()">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Review Submission</h4>
			</div>
			<div class="modal-body">
				<fieldset>
					<h3  id="myModalLabel">There are two ways how you can post your {{$type}} on BBarters.</h3>
					<div class="col-lg-6">
						Click the button below if you wish to directly post your {{$type}}.<br>
						This way, you'll earn IFCs when people read your {{$type}}.
						<button  id="submitreview1" type="button" class="btn btn-block" onclick="submit('passed',this)">Normal Submission</button>

                        <div  id="waitingArtical1"  style="display: none" >
                            <img src="{{asset('Images/icons/waiting.gif')}}" >Saving...
                        </div>

					</div>
					<div class="col-lg-6">
						Click on the button below to first get your {{$type}} reviewed by our team, and then post it.<br>
						If our team reviews your {{$type}} positively, you earn bonus IFCs, and then of course, people who read your {{$type}}, pay for it.
						<button id="submitreview" type="button" class="btn btn-block" onclick="submit('toreview',this)">Submit for Review</button>

                        <div  id="waitingArtical"  style="display: none" >
                            <img src="{{asset('Images/icons/waiting.gif')}}" >Saving...
                        </div>

                    </div>



				</fieldset>
			</div>
		</div>
	</div>
</div>

<!-- Modal to show that the article was posted successfully -->
<div class="modal fade" id="articleSuccessfullyPostedModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Article Posted!</h4>
			</div>
			<div class="modal-body">
				<p>Your article has been successfully posted.</p>
				<button type="button" class="btn btn-primary pull-right" aria-hidden="true" onclick="returnToDashboard()">Okay</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal to show the existing Resources -->
<div class="modal fade" id="getResourceModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add a Resource</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="resourcesTable"  class="table table-condensed table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Uploaded On</th>
                            <th>Use?</th>
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

<!-- Modal to show the upload Media -->
<div class="modal fade" id="uploadMediaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Upload Media</h4>
            </div>
            <div class="modal-body">
                <fieldset>
                    <div class="col-lg-12">
                        <div class="col-lg-8"><b>UPLOAD NEW MEDIA FILES</b><br>
                            Supported Formats:<br><small>.mp4, .webm, .mp3, .wav, .avi, .asf, .wmv, .m4a, .mkv, .flv</small>
                        </div>
                        <button type="button" class="btn btn-primary col-lg-4" aria-hidden="true" onclick="newMedia()">Upload New Media</button>
                    </div>
                    <div class="col-lg-8">&nbsp;</div>
                    <hr>
                    <div class="col-lg-12">
                        <div class="col-lg-8"><b>MAKE USE OF FILES ALREADY UPLOADED</b><br>
                            You can add files under 'Media' on home page.
                        </div>
                        <button type="button" class="btn btn-primary col-lg-4" aria-hidden="true" onclick="getMedia()">Use Existing Media</button>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>

<!-- Modal to show the existing Media -->
<div class="modal fade" id="getMediaModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Select from Existing Media</h4>
			</div>
			<div class="modal-body">
                <div class="table-responsive">
                    <table id="mediaTable"  class="table table-condensed table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Uploaded On</th>
                            <th>Use?</th>
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

<div class="modal fade bs-example-modal-lg" id="newMediaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Upload New Media</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" id="newMediaForm">
                    <div class="form-group">
                        <label class="col-lg-3">Media Title</label>
                        <input type="text" id="mediaTitle" name="mediaTitle" class="form-control col-lg-9" required>
                    </div>



                    <div class="form-group">
                        <div class="fileUpload btn btn-primary" id="changePP">
                            <span id="selectFileButton">Select File</span>
                            <input type="file" id="newMedia" name="newMedia" class="upload file" onchange="changeButton()">
                        </div>
                    </div>

                    <br>
                    <h3 id="statusMedia"></h3>

                    <div class="alert alert-success" id="alertTrue" style="display: none">Uploaded Successfully</div>

                    <div class="modal-footer">
                        <button id="submitMedia" onclick="uploadNewMedia()" class="btn btn-primary">Upload</button>
                    </div>
                </form>

            </div>

        </div>
    </div></div>

<!-- Hidden input fields to store data received from article dashboard about the article -->
<input id="title" name="title" type="hidden" value="{{$title}}">
<input id="extension" name="extension" type="hidden" value="{{$extension}}">
<input id="description" name="description" type="hidden" value="{{$description}}">
<input id="category" name="category" type="hidden" value="{{$category}}">
<input id="ifc" name="ifc" type="hidden" value="{{$ifc}}">
<input id="type" name="type" type="hidden" value="{{$type}}">

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/pages/article.js')}}"></script>
<script src="{{asset('js/summernote.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
</body>
</html>
 