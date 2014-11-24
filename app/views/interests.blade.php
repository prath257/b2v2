<h1>Interests</h1>

<div class="form-group">
    <label class="col-lg-3 control-label">Add/Remove as you wish</label>
    <div class="col-lg-6">
        <div id="newInterests">
            <h2>Add New:</h2>
             <div id="add-new-switches">

            </div>

            <div class="col-lg-4" style="padding: 0px"> <input type="text" id="other" class="form-control other col-lg-12" placeholder="Other"  onkeydown="interestCounterDesktopDown()" onkeyup="interestCounterDesktopUp()">

                                                <div class="col-lg-12 interest-search-result" style="margin-top: 5px; border: solid 1px; display: none"></div>
                                                </div>
                                                 <div class="col-lg-2" style="padding: 0px">
                                                                                        <button class="btn btn-default disabled int-search-button" type="button" onclick="allTOList()">Add</button>

                                                                                    </div>
        </div>
        <h2>Remove Existing:</h2>
        <div id="oldInterests">
            <?php $i=0; ?>
            @foreach($oldInterests as $oldi)
                                                <?php $i++ ?>
                                                <p class="col-lg-4">{{$oldi->interest_name}}</p>
                                                <?php $type = DB::table('user_interests')->where('interest_id',$oldi->id)->where('user_id',Auth::user()->id)->first(); ?>
                                                @if ($type->type == 'secondary')
                                                <input type="checkbox" class="oldinterests" name="oldinterests[]" value="{{$oldi->interest}}">
                                                @endif
                                                <br><br>
                                                @endforeach
                                                <input type="hidden" id="noOfOldInterests" value="{{$i}}">
                                                <h4 style="font-family: 'Segoe UI'; text-transform: none; color: darkred">You can delete secondary interests only.</h4>
        </div>
        <div class="ierror" style="display: none;"></div>
    </div>
</div>
<div class="col-lg-12">&nbsp;</div>
<button id="mysubmit" onclick="editInterests()" class="btn btn-primary col-lg-2">Update</button>