<!DOCTYPE html>
<html>
<head>
    <title>BlogBook Dashboard | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <!-- Latest compiled and minified CSS -->
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('dataTables.bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/blogBookDashboard.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <!-- Optional theme -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
    <!-- Data tables CDN -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/505bef35b56/integration/bootstrap/3/dataTables.bootstrap.js"></script>

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

<br>
<br>
<br>
<br>
<div class="container">
    @if(Auth::user()->pset)
    <a data-toggle="modal" data-target="#newBlogBookModal" class="btn btn-success col-lg-2">+ New BlogBook</a>
    <br>
    <br>
    <br>
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
    @else
    <div class="alert alert-info alert-dismissable col-lg-6 col-lg-offset-3">
        <strong>Attention! </strong> You can't access this  Dashboard as you haven't complete your profile yet.
        Without a valid profile you won't be able to create any content or interact with anyone. So, build it now and earn yourself upto 300i
        <br>
        <a href="{{route('buildProfile')}}"><h3>Complete Profile</h3></a>
    </div>
    @endif
</div>

<!-- NewBlogBook Modal -->
<div class="modal fade" id="newBlogBookModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">New BlogBook</h4>
            </div>
            <div id="inviteBody" class="modal-body">
                {{Form::open(array('route'=>'postBlogBookDashboard','id'=>'newBlogBookForm','class'=>'form-horizontal','files'=>true))}}
                <!--<form id="newBlogBookForm" method="post" action="{{route('postBlogBookDashboard')}}" enctype="multipart/form-data" class="form-horizontal">-->
                    <fieldset>

                        <div class="col-lg-6 col-lg-offset-3">
                            <h3 style="text-align: center">BlogBook Cover</h3>
                        </div>

                        <img id="defaultCover" class="col-lg-6 col-lg-offset-3" height="150px" src="{{asset('Images/BlogBook.jpg')}}">

                        <div class="col-lg-12">&nbsp;</div>

                        <div class="col-lg-6 col-lg-offset-3 fileUpload btn btn-default">
                            <span>Upload Cover</span>
                            <input type="file" id="uploadCover" class="upload" name="uploadCover" style="width: 100%" onchange="changeBlogBookCover()" />
                        </div>

                        <div class="col-lg-12">&nbsp;</div>

                        <div class="form-group">
                            <label class=" col-lg-3 control-label">Title</label>
                            <div class="col-lg-7">
                                <input type="text" id="title" class="form-control" name="title" placeholder="BlogBook Title" autocomplete="off" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" col-lg-3 control-label">Short Description</label>
                            <div class="col-lg-7">
                                <textarea id="shortDescription" class="form-control" name="shortDescription" rows="3" placeholder="A short and precise description for your new BlogBook."></textarea>
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

                    </fieldset>
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" id="newBlogBookSubmit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                {{Form::close()}}

            </div>
        </div>
    </div>
</div>
<!-- End of NewBlogBook Modal -->
<!-- Modal to show the sharing of Article -->
<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Share Article</h4>
            </div>
            <div class="modal-body" id="shareBook">

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
<script src="{{asset('js/pages/blogBookDashboard.js')}}"></script>
</body>
</html>