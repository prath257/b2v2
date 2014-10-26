<h1>Interests</h1>

<div class="form-group">
    <label class="col-lg-3 control-label">Add/Remove as you wish</label>
    <div class="col-lg-6">
        <div id="newInterests">
            <h2>Add New:</h2>
            @foreach($newInterests as $newi)
            <p class="col-lg-4">{{$newi->interest_name}}</p><input type="checkbox" class="newinterests" name="newinterests[]" value="{{$newi->interest}}"><br><br>
            @endforeach
            <p class="col-lg-4">Other:</p>
            <div class="col-lg-4" style="padding: 0px"> <input type="text" id="other" class="form-control"></div>
            <br><br>
        </div>
        <h2>Remove Existing:</h2>
        <div id="oldInterests">
            <?php $i=0; ?>
            @foreach($oldInterests as $oldi)
            <?php $i++ ?>
            <p class="col-lg-4">{{$oldi->interest_name}}</p><input type="checkbox" class="oldinterests" name="oldinterests[]" value="{{$oldi->interest}}"><br><br>
            @endforeach
            <input type="hidden" id="noOfOldInterests" value="{{$i}}">
        </div>
        <div class="ierror" style="display: none;"></div>
    </div>
</div>
<div class="col-lg-12">&nbsp;</div>
<button id="mysubmit" onclick="editInterests()" class="btn btn-primary col-lg-2">Update</button>