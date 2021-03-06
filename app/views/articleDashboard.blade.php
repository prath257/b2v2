<!DOCTYPE html>
<html>
<head>
    <title>Article Dashboard | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
	<!-- Latest compiled and minified CSS -->
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('dataTables.bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/articleDashboard.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/morris.css')}}" rel="stylesheet">
	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
	<!-- Data tables CDN -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
	<script type="text/javascript" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/505bef35b56/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <script src="{{asset('js/raphael.js')}}"></script>
    <script src="{{asset('js/morris.js')}}"></script>
</head>
<body style="font-family: 'Segoe UI'">
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=431744100304343&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

@include('navbar')

<br>
<br>
<br>
<div class="container">
    @if(Auth::user()->pset)


    <br>
    <br>
   <div class="table-responsive col-lg-8">
   	<table id="example"  class="table table-condensed table-hover" cellspacing="0" width="100%">
   		<thead>
   		<tr>
   			<th>Title</th>
   			<th>Category</th>
   			<th>Cost</th>
   			<th>Readers</th>
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
   		</tr>
   		</tbody>
   	</table>
       </div>
       <div class="col-lg-4">
            <div id="donut-articles" style="height: 250px;"></div>
             <br>
             <br>
             <ul id="articlesData" class="nav nav-pills ranges col-lg-offset-3">
                            <li style="padding: 10px">Days:</li>
                            <li id="a7"><a href="#" data-range='7'>7</a></li>
                            <li id="a30"><a href="#" data-range='30'>30</a></li>
                            <li id="a60"><a href="#" data-range='60'>60</a></li>
                            <li id="a90" class="active"><a href="#" data-range='90'>90</a></li>
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

<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Share Article</h4>
            </div>
            <div class="modal-body" id="shareArticle">

            </div>
        </div>
    </div>
</div>

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<a href="https://twitter.com/share" class="sharing" data-url="http://b2.com" data-counturl="http://b2.com" data-lang="en" data-count="vertical" style="display: none">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/pages/articleDashboard.js')}}"></script>
</body>

</html>
 