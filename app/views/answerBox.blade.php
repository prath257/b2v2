<div id='answer{{$id}}' class='col-lg-12'>
    <textarea class='input-block-level' id='summernote{{$id}}' name='summernote' rows='18' onfocus='checkCharactersAnswer({{$id}})'>
    </textarea>
    <br>
    <span id='error-box{{$id}}' style='color: darkred; margin-right: 20px'></span>
    <div>
        <button id='postAnswer{{$id}}' type='submit' class='btn btn-primary col-lg-3' onclick='postAnswer({{$id}})'>Submit</button>&nbsp;&nbsp;&nbsp;
        <div id="waitingImg5" style="display: none"><img src="{{asset('Images/icons/waiting.gif')}}" >Saving..</div>
        <button type='button' class='btn btn-primary' onclick='cancelAnswer()'>Cancel</button>
    </div>
</div>
<div class="col-lg-12">&nbsp;</div>