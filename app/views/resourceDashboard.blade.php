<!DOCTYPE html>
<html>
<head>
	<title>Resource Dashboard | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
	<!-- Latest compiled and minified CSS -->
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('dataTables.bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/fileUpload.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/search.css')}}" rel="stylesheet">
    <link href="{{asset('css/morris.css')}}" rel="stylesheet">
	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
	<!-- Data tables CDN -->
    <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
	<script type="text/javascript" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/505bef35b56/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <script src="{{asset('js/raphael.js')}}"></script>
    <script src="{{asset('js/morris.js')}}"></script>
</head>
<body>

@include('navbar')

<br>
<br>
<br>
<br>
<div class="container">
    @if(Auth::user()->pset)
    <a data-toggle="modal" data-target="#newResourceModal" class="btn btn-success col-lg-2">+ New Resource</a>
	<br>
	<br>
    <br>
    <br>
    <div class="table-responsive col-lg-8">
	<table id="example"  class="table table-condensed table-hover" cellspacing="0" width="100%">
		<thead>
		<tr>
			<th>Title</th>
			<th>Category</th>
			<th>Cost</th>
			<th>Downloads</th>
			<th>Actions</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		</tbody>
	</table>
    </div>
    <div class="col-lg-4">
    <div id="resources-stats-container" style="height:370px;"></div>
            <br>
            <ul id="resourcesData" class="nav nav-pills ranges">
                <li id="r7" ><a href="#" data-range='7'>7 Days</a></li>
                <li id="r30"><a href="#" data-range='30'>30 Days</a></li>
                <li id="r60"><a href="#" data-range='60'>60 Days</a></li>
                <li id="r90" class="active"><a href="#" data-range='90'>90 Days</a></li>
            </ul>
    </div>
    @else
    <div class="alert alert-info alert-dismissable col-lg-6 col-lg-offset-3">
        <strong>Attention! </strong> You can't access this  Dashboard as you haven't completed your profile yet.
        Without a valid profile you won't be able to create any content or interact with anyone. So, build it now and earn yourself upto 300i
        <br>
        <a href="{{route('buildProfile')}}"><h3>Completed Profile</h3></a>
    </div>
    @endif
</div>

<!-- Modal to input initial details of the resource -->
<div class="modal fade" id="newResourceModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">New resource</h4>
			</div>
			<div id="inviteBody" class="modal-body">
				<h6  id="inviteModalLabel">Please enter the title, category and the cost of the resource that you're about to write.</h6>
                {{Form::open(array('route'=>'postResource','id'=>'newResourceForm','class'=>'form-horizontal','files'=>true))}}
				<!--<form id="newResourceForm" class="form-horizontal" method="post" action="{{route('postResource')}}" enctype="multipart/form-data">-->
					<fieldset>

						<div class="form-group">
							<label class=" col-lg-3 control-label">Title</label>
							<div class="col-lg-6">
								<input type="text" id="resourceTitle" class="form-control" name="resourceTitle" placeholder="Resource Title" autocomplete="off" />
							</div>
						</div>

                        <div class="form-group">
                            <label class=" col-lg-3 control-label">Short Description</label>
                            <div class="col-lg-7">
                                <textarea id="shortDescription" class="form-control" name="shortDescription" rows="3" placeholder="A short and precise description for your new Resource."></textarea>
                            </div>
                        </div>

						<div class="form-group">
							<label class="col-lg-3 control-label">Category</label>
							<div class="col-lg-6">
								<select id="category" class="form-control" name="category">
									<option value="">-- Select a Category --</option>
									@foreach($categories as $cat)
									<option value="{{$cat->id}}">{{$cat->interest_name}}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-3 control-label">Cost</label>
							<div class="col-lg-6">
								<div class="input-group">
									<input id="ifc" name="ifc" type="text" class="form-control" value="0" autocomplete="off">
									<span class="input-group-addon">IFCs</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-3 control-label">Resource File ( Only zip/rar)</label>
							<div class="col-lg-6">
                                <div id="styledInput" class="fileUpload btn btn-default col-lg-6">
                                    <span id="fileName">Select file</span>
                                    <input type="file" name="resourceFile" id="resourceFile" class="upload" onchange="changeFileName()">
                                </div>
                                <h3 id="status"></h3>
							</div>
							</div>



					<div class="form-group">
						<div class="col-lg-9 col-lg-offset-3">
							<button type="submit" id="newResourceSubmit" class="btn btn-primary col-lg-2" onclick="uploadResource()">Submit</button>
                            <div id="uploadController" class="col-lg-10" style="display: none">
                                <div id="mediaProgress" class="progress progress-striped active col-lg-12" style="margin-top: 10px; padding: 0px">
                                    <div id="progressBar" class="progress-bar progress-bar-primary"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                        <span class="sr-only">45% Complete</span>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
            </fieldset>
				</form>
            </div>
			</div>
		</div>
	</div>
</div>

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/pages/resourceDashboard.js')}}"></script>
<script src="{{asset('js/search.js')}}"></script>
</body>
</html>
 