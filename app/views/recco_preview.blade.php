<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="col-xs-12">
        <br>
        <h3 id="recco-preview-title" style="text-transform: none">{{{$title}}}</h3>
    </div>
    <div class="col-xs-12">
        <div class="col-xs-12">&nbsp;</div>

        <div class="col-xs-12 col-sm-6 col-md-4">
            <img id="recco-preview-image" class="img-responsive" src="{{$image}}">
            <br><br>
            <a id="change-to-default-link" style="cursor: pointer" onclick="changeToDefault()">Change to default</a>
        </div>

        <div id="recco-preview-description" class="col-xs-12 col-sm-6 col-md-8">
            {{{$description}}}
        </div>
    </div>
    <div id="recco-post-button-container" class="col-xs-12" style="padding: 30px">
        <button class="btn btn-success pull-right" onclick="confirmPostRecco('{{$image}}')">Post</button>
    </div>
</div>