     <div class="col-xs-12 col-sm-4 col-md-3">

                        <select id="league" class="form-control" name="league" onchange="getNextMatchDay('{{$type}}')">
                             <option value="default">Select League</option>
                                @foreach($leagues as $league)
                                    <option value="{{$league->id}}">{{$league->name}}</option>
                                @endforeach
                        </select>


      </div>
      <div class="col-xs-12 col-sm-1 col-md-1">&nbsp;</div>
      <div class="col-xs-12 col-sm-7 col-md-8" id="matchdayDetails" style="display: none">

      </div>
      <div class="col-xs-12 col-sm-12 col-md-12" id="matchdaySchedule">


      </div>



