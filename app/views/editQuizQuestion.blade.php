@if ($question->option3 == null  && $question->option4 == null)
<form id="tfqEditForm" class="form-horizontal">
    <fieldset>
    <div class="form-group">
        <div class="col-lg-2">Question</div>
        <div class="col-lg-10">
            <textarea id="tfqEditQuestion" name="tfqEditQuestion" class="form-control" style="width: 100%" rows="3">{{$question->question}}</textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg-2">Options</div>
        <div class="col-lg-10">
            <div class="col-lg-6">
                <input name="tfqEditOption1" type="text" class="col-lg-12 form-control" value="True" disabled>
            </div>
            <div class="col-lg-6">
                <input name="tfqEditOption2" type="text" class="col-lg-12 form-control" value="False" disabled>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg-2">Answer</div>
        <div id="tfqEditChoice" class="col-lg-10">
            @if ($question->correct1 == true)
                <input type="radio" name="tfqEditChoice" value="A" checked> <strong>True</strong>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="tfqEditChoice" value="B"> <strong>False</strong>
            @else
                <input type="radio" name="tfqEditChoice" value="A"> <strong>True</strong>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="tfqEditChoice" value="B" checked> <strong>False</strong>
            @endif
        </div>
    </div>
    <div class="col-lg-12">&nbsp;</div>
    <div class="form-group">
        <button type="button" id="tfqEditSubmit" class="pull-right btn btn-success col-lg-2" onclick="submitEdit({{$question->id}},'tfq')">Save</button>
    </div>
    </fieldset>
</form>
@elseif (($question->correct1 == true && $question->correct2 == false && $question->correct3 == false && $question->correct4 == false) || ($question->correct1 == false && $question->correct2 == true && $question->correct3 == false && $question->correct4 == false) || ($question->correct1 == false && $question->correct2 == false && $question->correct3 == true && $question->correct4 == false) || ($question->correct1 == false && $question->correct2 == false && $question->correct3 == false && $question->correct4 == true))
<form id="saqEditForm" class="form-horizontal">
    <fieldset>
    <div class="form-group">
        <div class="col-lg-2">Question</div>
        <div class="col-lg-10">
            <textarea id="saqEditQuestion" name="saqEditQuestion" class="form-control" style="width: 100%" rows="3">{{$question->question}}</textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg-2">Options</div>
        <div class="col-lg-10">
            <div class="col-lg-6">
                <p class="col-lg-1"><strong>A.</strong></p>
                <input id="saqEditOption1" name="saqEditOption1" type="text" class="col-lg-11 form-control" value="{{$question->option1}}">
            </div>
            <div class="col-lg-6">
                <p class="col-lg-1"><strong>B.</strong></p>
                <input id="saqEditOption2" name="saqEditOption2" type="text" class="col-lg-11 form-control" value="{{$question->option2}}">
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-6">
                <p class="col-lg-1"><strong>C.</strong></p>
                <input id="saqEditOption3" name="saqEditOption3" type="text" class="col-lg-11 form-control" value="{{$question->option3}}">
            </div>
            <div class="col-lg-6">
                <p class="col-lg-1"><strong>D.</strong></p>
                <input id="saqEditOption4" name="saqEditOption4" type="text" class="col-lg-11 form-control" value="{{$question->option4}}">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg-2">Answer</div>
        <div id="answer" class="col-lg-10">
            @if ($question->correct1 == true)
                <input type="radio" name="saqEditAnswer" value="A" checked> <strong>A</strong>
            @else
                <input type="radio" name="saqEditAnswer" value="A"> <strong>A</strong>
            @endif
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            @if ($question->correct2 == true)
                <input type="radio" name="saqEditAnswer" value="B" checked> <strong>B</strong>
            @else
                <input type="radio" name="saqEditAnswer" value="B"> <strong>B</strong>
            @endif
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            @if ($question->correct3 == true)
                <input type="radio" name="saqEditAnswer" value="C" checked> <strong>C</strong>
            @else
                <input type="radio" name="saqEditAnswer" value="C"> <strong>C</strong>
            @endif
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            @if ($question->correct4 == true)
                <input type="radio" name="saqEditAnswer" value="D" checked> <strong>D</strong>
            @else
                <input type="radio" name="saqEditAnswer" value="D"> <strong>D</strong>
            @endif
        </div>
    </div>
    <div class="col-lg-12">&nbsp;</div>
    <div class="form-group">
        <button type="button" id="saqEditSubmit" class="pull-right btn btn-success col-lg-2" onclick="submitEdit({{$question->id}},'saq')">Save</button>
    </div>
    </fieldset>
</form>
@else
<form id="maqEditForm" class="form-horizontal">
    <fieldset>
    <div class="form-group">
        <div class="col-lg-2">Question</div>
        <div class="col-lg-10">
            <textarea id="maqEditQuestion" name="maqEditQuestion" class="form-control" style="width: 100%" rows="3">{{$question->question}}</textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg-2">Options</div>
        <div class="col-lg-10">
            <div class="col-lg-6">
                <p class="col-lg-1"><strong>A.</strong></p>
                <input id="maqEditOption1" name="maqEditOption1" type="text" class="col-lg-11 form-control" value="{{$question->option1}}">
            </div>
            <div class="col-lg-6">
                <p class="col-lg-1"><strong>B.</strong></p>
                <input id="maqEditOption2" name="maqEditOption2" type="text" class="col-lg-11 form-control" value="{{$question->option2}}">
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-6">
                <p class="col-lg-1"><strong>C.</strong></p>
                <input id="maqEditOption3" name="maqEditOption3" type="text" class="col-lg-11 form-control"  value="{{$question->option3}}">
            </div>
            <div class="col-lg-6">
                <p class="col-lg-1"><strong>D.</strong></p>
                <input id="maqEditOption4" name="maqEditOption4" type="text" class="col-lg-11 form-control"  value="{{$question->option4}}">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg-2">Answers</div>
        <div id="answers" class="col-lg-10">
            @if ($question->correct1 == true)
                <input type="checkbox" name="maqEditAnswers[]" value="A" checked> <strong>A</strong>
            @else
                <input type="checkbox" name="maqEditAnswers[]" value="A"> <strong>A</strong>
            @endif
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            @if ($question->correct2 == true)
                <input type="checkbox" name="maqEditAnswers[]" value="B" checked> <strong>B</strong>
            @else
                <input type="checkbox" name="maqEditAnswers[]" value="B"> <strong>B</strong>
            @endif
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            @if ($question->correct3 == true)
                <input type="checkbox" name="maqEditAnswers[]" value="C" checked> <strong>C</strong>
            @else
                <input type="checkbox" name="maqEditAnswers[]" value="C"> <strong>C</strong>
            @endif
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            @if ($question->correct4 == true)
                <input type="checkbox" name="maqEditAnswers[]" value="D" checked> <strong>D</strong>
            @else
                <input type="checkbox" name="maqEditAnswers[]" value="D"> <strong>D</strong>
            @endif
        </div>
    </div>
    <div class="col-lg-12">&nbsp;</div>
    <div class="form-group">
        <button type="button" id="maqEditSubmit" class="pull-right btn btn-success col-lg-2" onclick="submitEdit({{$question->id}},'maq')">Save</button>
    </div>
    </fieldset>
</form>
@endif