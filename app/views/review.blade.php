<!DOCTYPE html>
<html>
<head>
    <title>Review | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/waiting.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
</head>
<body>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Review Content</h4>
            </div>
            <div class="modal-body">
                @if ($blogBook->review == 'toreview')
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
                        <input id="blogBookId" type="hidden" value="{{$blogBook->id}}">
                    </fieldset>

                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" id="reviewSubmit" class="btn btn-primary" onclick="postReview()">Submit</button><br>
                            <span class="waiting " id="waitingReview" >
                                <div class='pull-left' id="waitingReview" >
                                <img src="{{asset('Images/icons/waiting.gif')}}">Loading..
                                    </div>
                            </span>
                        </div>

                    </div>
                </form>
                @else
                <div style="text-align: center; font-size: 18px">This BlogBook has already been reviewed</div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Review Modal End -->

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/pages/review.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
</body>
</html>