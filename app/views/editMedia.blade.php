<form class="form-horizontal" id="editMediaForm">

<div class="col-lg-6 col-lg-offset-3">
    <h3 style="text-align: center">Media Cover</h3>
</div>

<img id="defaultCover2" class="col-lg-6 col-lg-offset-3" height="150px" src="{{asset($media->cover)}}">

<div class="col-lg-12">&nbsp;</div>

<div class="col-lg-6 col-lg-offset-3 fileUpload btn btn-default">
    <span>Change Cover</span>
    <input type="file" id="uploadCover2" class="upload" name="uploadCover2" style="width: 100%" onchange="changeEditMediaCover()" />
</div>

<div class="col-lg-12">&nbsp;</div>

<div class="form-group">
    <label class=" col-lg-3 control-label">Title</label>
    <div class="col-lg-7">
        <input type="text" id="title2" class="form-control" name="title2" autocomplete="off" value="{{$media->title}}"/>
    </div>
</div>

<div class="form-group">
    <label class=" col-lg-3 control-label">Short Description</label>
    <div class="col-lg-7">
        <textarea id="shortDescription2" class="form-control" name="shortDescription2" rows="3">{{$media->trivia}}</textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label">Category</label>
    <div class="col-lg-7">
        <select id="category2" class="form-control" name="category2">
            <option value="{{$media->category}}">{{Interest::find($media->category)->interest_name}}</option>
            @foreach($categories as $cat)
            @if ($cat->id != $media->category)
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
            <input id="ifc2" name="ifc2" type="text" class="form-control" value="{{$media->ifc}}" autocomplete="off">
            <span class="input-group-addon">IFCs</span>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-lg-9 col-lg-offset-3">
        <button type="submit" id="editMediaUpload" class="btn btn-primary" onclick="editMedia({{$media->id}})">Update</button>
        <div id="waiting" style="display: none">
            <img  src="{{asset('Images/icons/waiting.gif')}}" >Loading..
        </div>
    </div>
</div>

</form>