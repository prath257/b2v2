<!DOCTYPE html>
<html>
	<head>
	  <title>Media Center | BBarters</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
		<!-- Latest compiled and minified CSS -->
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

        <div class="col-lg-12">
            <div class="col-lg-6" style="border-right: 1px solid black; text-align: right">
                <button class="btn btn-primary" data-toggle="modal" data-target="#newMediaModal">+ Upload Media (Private)</button><br><br>
                Upload media with private access. Only you can view it and use in any of your Articles and BlogBooks and Collaborations.
            </div>
            <div class="col-lg-6">
                <a href="{{route('newPublicMedia')}}" class="btn btn-primary" >+ Upload Media (Public)</a><br><br>
                Upload media with public access. All can view it, and you can use it in your Articles and BlogBooks and Collaborations as well.
            </div>
        </div>

	    <br><br><br><br><br><br>
        <div class="table-responsive">
		<table id="example"  class="table table-condensed table-hover" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th>Title</th>
				<th>Uploaded on</th>
                <th>Access</th>
				<th>Actions</th>
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
    <div class="modal fade" id="newMediaModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Upload Private Media</h4>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" id="newMediaForm">
                        <div class="form-group" >
                            <label class="col-lg-4">Title</label>
                            <input type="text" id="mediaTitle" name="mediaTitle" class="col-lg-7 form-control" required>
                            <br>
                        </div>
                        <div class="form-group">
                            <div class="fileUpload btn btn-primary" id="changePP">
                                <span id="selectFileButton">Select File</span>
                                <input type="file" id="newMedia" name="newMedia" class="upload file" onchange="changeButton()">
                            </div>
                        </div>

                        <div id="mediaProgress" class="progress progress-striped active" style="display: none">
                            <div id="progressBar" class="progress-bar progress-bar-primary"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                <span class="sr-only">45% Complete</span>
                            </div>
                        </div>

                        <br>
                        <h3 id="statusMedia"></h3>

                        <div class="alert alert-success" id="alertTrue" style="display: none">Uploaded Successfully</div>

                        <div class="modal-footer">
                            <button type="submit" id="submitMedia" onclick="uploadNewMedia()" class="btn btn-primary">Upload</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="editMediaModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Edit Media Details</h4>
                </div>

                <div class="modal-body">

                    <form class="form-horizontal" id="editMediaForm">

                        <h3 id="loading" style="text-align: center; font-family: 'Segoe UI Light">Loading...</h3>

                        <fieldset id="fieldset">




                        </fieldset>

                    </form>


                </div>

            </div>
        </div>
    </div>

	<div class="modal fade" id="previewMediaModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel"> Preview</h4>
				</div>

				<div class="modal-body" id="preview">

				</div>

			</div>
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
 