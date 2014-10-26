<!DOCTYPE html>
<html>
<head>
    <title>Review | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/waiting.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/home.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
</head>
<body>

@include('navbar')

<br>
<br>
<br>


<div class="col-lg-10 col-lg-offset-1">
    @if($article->review == 'toreview')
        <h1>{{$article->title}}</h1>
        <p class="pull-right" style="font-size: 16px"><strong>Category:</strong> {{Interest::find($article->category)->interest_name}}</p>
        <br><hr><br><br>
        {{$article->text}}
        <br><br>
        <a href="{{route('user',User::find($article->userid)->username)}}" style="text-decoration: none; font-size: 18px">- {{User::find($article->userid)->first_name}} {{User::find($article->userid)->last_name}}</a>
        <br>
        <button type="button" class="pull-right btn btn-primary" onclick="reviewArticle()">Review</button>
    <br>
    <br>
    @else
        <p style="text-align: center; font-size: 18px">This article has been already reviewed.</p>
    @endif
</div>



<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Review Content</h4>
            </div>
            <div class="modal-body">

                <form id="reviewForm" class="form-horizontal">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">IFCs</label>
                            <div class="col-lg-5">
                                <input id="ifc" name="ifc" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Suggestions</label>
                            <div class="col-lg-5">
                                <textarea id="suggestions" name="suggestions" rows="3" style="width: 100%"></textarea>
                            </div>
                        </div>
                        <input id="reviewId" type="hidden" value="{{$review->id}}">
                        <input id="articleId" type="hidden" value="{{$article->id}}">
                    </fieldset>
                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" id="reviewSubmit" class="btn btn-primary" onclick="postReview()">Submit</button><br>
                            <div class=' waiting' id="waitingReviewArticle">
                            <img src="{{asset('Images/icons/waiting.gif')}}">Loading..
                                </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Review Modal End -->

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('js/pages/reviewArticle.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
</body>
</html>
 