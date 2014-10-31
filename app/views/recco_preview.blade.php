<div class="col-lg-12">
    <div class="col-lg-12">
        <br>
        <h3 id="recco-preview-title" style="text-transform: none">{{{$title}}}</h3>
    </div>
    <div class="col-lg-12">
        <div class="col-lg-12">&nbsp;</div>

        <div class="col-lg-4">
            <img class="col-lg-12" src="{{$image}}" style="padding: 0px">
        </div>

        <div id="recco-preview-description" class="col-lg-8">
            {{{$description}}}
        </div>
    </div>
    <div id="recco-post-button-container" class="col-lg-12" style="padding: 30px">
        <button class="btn btn-success pull-right" onclick="confirmPostRecco('{{$image}}')">Post</button>
    </div>
</div>