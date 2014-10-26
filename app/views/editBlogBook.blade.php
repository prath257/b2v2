<!DOCTYPE html>
<html>
<head>
    <title>Edit '{{$blogBook->title}}' | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
	<!-- Latest compiled and minified CSS -->
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('dataTables.bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/editBlogBook.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
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
<a href="{{route('blogBookDashboard')}}" style="position: absolute; margin-top: 2.5%; margin-left: 2.5%; z-index: 5; text-decoration: none">
<span class="glyphicon glyphicon-arrow-left"></span>
<b>BACK</b>
</a>
<div class="container">
    <div class="col-lg-12 well">
        {{Form::open(array('route'=>'editBlogBook','id'=>'updateBlogBookForm','class'=>'form-horizontal','files'=>true))}}
        <!--<form id="updateBlogBookForm" method="post" action="{{route('editBlogBook')}}" enctype="multipart/form-data" class="form-horizontal">-->
            <fieldset>

                <div class="col-lg-3">
                    <h3 style="text-align: center">BlogBook Cover</h3>
                    <br>
                    <img id="existingCover" class="col-lg-12" height="200px" src="{{asset($blogBook->cover)}}">
                    <div class="col-lg-12">&nbsp;</div>
                    <div class="col-lg-10 col-lg-offset-1 fileUpload btn btn-default">
                        <span>Update Cover</span>
                        <input type="file" id="uploadCover" class="upload" name="uploadCover" style="width: 100%" onchange="updateBlogBookCover()" />
                    </div>
                </div>

                <div class="col-lg-9" style="margin-top: 7.5%">
                    <div class="form-group">
                        <label class=" col-lg-3 control-label">Title</label>
                        <div class="col-lg-7">
                            <input type="text" id="title" class="form-control" name="title" value="{{$blogBook->title}}" autocomplete="off" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class=" col-lg-3 control-label">Short Description</label>
                        <div class="col-lg-7">
                            <textarea id="shortDescription" class="form-control" name="shortDescription" rows="3">{{$blogBook->description}}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Category</label>
                        <div class="col-lg-7">
                            <select id="category" class="form-control" name="category" va>
                                <option value="{{$blogBook->category}}">{{Interest::find($blogBook->category)->interest_name}}</option>
                                @foreach($categories as $cat)
                                @if ($cat->interest_name!=Interest::find($blogBook->category)->interest_name)
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
                                <input id="ifc" name="ifc" type="text" class="form-control" value="{{$blogBook->ifc}}" autocomplete="off">
                                <span class="input-group-addon">IFCs</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">&nbsp;</div>

                <div class="col-lg-12">
                    <div id="messages" class="col-lg-2 col-lg-offset-7" style="color: red"></div>

                    <div class="col-lg-2">
                        <button type="submit" id="updateBlogBookSubmit" class="btn btn-primary" onclick="updateBlogBook({{$blogBook->id}})">Save Changes</button>
                    </div>
                </div>

            </fieldset>
        {{Form::close()}}
    </div>

	<div class="container">
        <h2>Chapters</h2>
		<br>
		<br>
		<table id="example"  class="table table-bordered" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th>Title</th>
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

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<input type="hidden" id="blogBookId" value="{{$blogBook->id}}">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/pages/editBlogBook.js')}}"></script>
<script src="{{asset('js/search.js')}}"></script>
</body>
</html>