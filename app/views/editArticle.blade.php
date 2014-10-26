<!DOCTYPE html>
<html>
<head>
	<title>Edit Article: {{$article->title}} | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('dataTables.bootstrap.css')}}" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
	<link href="{{asset('css/summernote.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/editArticle.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/fileUpload.css')}}" rel="stylesheet">

    <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/505bef35b56/integration/bootstrap/3/dataTables.bootstrap.js"></script>

</head>
<body style="font-family: Segoe UI">

@include('navbar')

<br>
<br>
<br>
<div id="preview" class="col-lg-10 col-lg-offset-1">
	<div id="previewHTML" class="col-lg-12">

	</div>
	<div class="pull-right">
		<button id="saveEditButton" type="button" class="btn btn-primary" onclick="saveArticle({{$article->id}})">OK! Looks cool</button>
		<button id="cancelEditButton" type="button" class="btn btn-primary" onclick="editContent()">No, Let me edit!</button>
		<div id="updatingMsg" style="display: none"></div>
	</div>
</div>
<div class="summernote col-lg-12">
    <div class="col-lg-3">
        <p style="font-size: 24px">Edit Article:</p>
    </div>

    <div id="uploadController" class="col-lg-9" style="display: none">
        <div id="mediaProgress" class="progress progress-striped active col-lg-7" style="margin-top: 10px; padding: 0px">
            <div id="progressBar" class="progress-bar progress-bar-primary"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                <span class="sr-only">45% Complete</span>
            </div>
        </div>
        <p id="uploadName" class="col-lg-5" style="text-align: center; font-size: 16px">This is me</p>
    </div>
	<div class="col-lg-12" style="padding: 0px">
		<form class="form-horizontal" id="postForm">
			<fieldset>

				<div class="col-lg-3">
					<label class=" col-lg-12">Title</label>
					<div class="col-lg-12">
						<input type="text" id="title" class="form-control" name="title" value="{{$article->title}}" autocomplete="off" onkeyup="checkTitle()" />
					</div>
					<div class="col-lg-12">
                        <br>
						<label class="col-lg-12" style="padding: 0px">Category</label>
						<div class="col-lg-12" style="padding: 0px">
							<select id="category" class="form-control" name="category">
								<option value="{{$article->category}}">{{Interest::find($article->category)->interest_name}}</option>
								@foreach($categories as $cat)
									@if ($cat->interest_name!=Interest::find($article->category)->interest_name)
										<option value="{{$cat->id}}">{{$cat->interest_name}}</option>
									@endif
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-lg-12">
                        <br>
						<label class="col-lg-12" style="padding: 0px">Cost</label>
						<div class="input-group">
							<input id="ifc" name="ifc" type="text" class="form-control" value="{{$article->ifc}}" onkeyup="checkIFCs()">
							<span class="input-group-addon">IFCs</span>
						</div>
					</div>
                    <div class="col-lg-12">
                        <br>
                        <label class="col-lg-12" style="padding: 0px">Description</label>
                        <div class="col-lg-12" style="padding: 0px">
                            <textarea id="description" class="form-control" style="width: 100%" rows="5">{{$article->description}}</textarea>
                        </div>
                    </div>
				</div>

				<div class="col-lg-9">

					<textarea class="input-block-level" id="summernote" name="summernote" rows="18" onfocus="checkCharacters()">
						{{$article->text}}
					</textarea>
                    <br>
                    <button type="button" id="previewButton" class="btn btn-primary" onclick="showPreview()">Preview & Submit</button>
                    <button type="button" id="mediaButton" class="btn btn-success" onclick="uploadMedia()">Upload Media</button>
                    <button type="button" id="resourceButton" class="btn btn-danger" onclick="addResource()">Add Resource</button>
                    <a id="cancel" class="btn btn-default" href="{{route('articleDashboard')}}">Cancel</a>
                    <strong><span id="error-box" style="color: darkred"></span></strong>
				</div>
			</fieldset>

            <br>
            <br>
		</form>
	</div>
</div>
<!-- Modal to show that the article was posted successfully -->
<div class="modal fade" id="articleSuccessfullyPostedModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Article Updated!</h4>
			</div>
			<div class="modal-body">
				<p>Your article has been successfully updated.</p>
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
                            <input type="text" id="mediaTitle" class="form-control col-lg-9" required>
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
    </div>
</div>

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/pages/editArticle.js')}}"></script>
<script src="{{asset('js/summernote.js')}}"></script>

</body>
</html>
 