<div class="col-lg-12" style="padding-left: 0px">
    <div class="col-lg-9 zero-padding">
        <select id="friend" class="form-control" name="friend">
            <option value="">Select friend </option>
            @foreach($friends as $friend)

            <option value="{{$friend->id}}">{{$friend->first_name}} {{$friend->last_name}}</option>
            @endforeach
        </select>
    </div>
    <div id="submitSuser" class="col-lg-2">
            <button type="submit" id="suserSubmit"  class="btn btn-success" onclick="addNew()" >+Add</button>
    </div>
</div>
<div class="form-group">

    <div class="col-lg-3 col-lg-offset-3" id="waiting" style="display: none" >
        <img src="{{asset('Images/icons/waiting.gif')}}">Loading..
    </div>

</div>