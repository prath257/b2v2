@if (Auth::guest())
<br><br><br>
<div class="col-lg-10 col-lg-offset-1">
    <div class="col-lg-12">
        <div class="col-lg-4" style="margin-top: 50px">
            <p style="word-wrap: break-word; font-family: 'Haettenschweiler'; text-transform: uppercase; font-size: 50px">{{Str::limit($Aboutuser->first_name.' '.$Aboutuser->last_name,50)}}</p>

            <div>
                <div class="col-lg-12" style="margin-top: 25px; font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif; padding: 0px">
                    <p style="font-size: 22px; margin-bottom: 0px">
                        {{$Aboutuser->profile->aboutMe}}
                    </p>
                </div>

            </div>

        </div>
        <div class="col-lg-3" style="margin-top: 65px; padding-right: 30px; text-align: center">
            <div class="slideshow col-lg-12 noPadding" style="margin-bottom: 20px; height: 150px; width: 150px; text-align: center">
                <?php $num=0 ?>
                @foreach($trivia as $dp)
                <img src="{{$dp->oldpic}}" height="150px" width="150px">
                <?php $num=$num+1 ?>
                @endforeach
            </div>
        </div>
        <div id="approvedAbout" class="col-lg-5 noPadding" style="margin-top: 65px">
            @foreach ($approved as $app)
            <div id="App{{$app->id}}">
                <blockquote class="col-lg-12">{{$app->content}}</blockquote>
                <div class="pull-right"><b>Written By: </b><a href="{{route('user',User::find($app->writtenby)->username)}}" style="text-decoration: none">{{User::find($app->writtenby)->first_name}} {{User::find($app->writtenby)->last_name}}</a></div>
                <div class="col-lg-12">
                    <br>
                    <hr>
                </div>
            </div>
            @endforeach
            {{--@if (count($approved) == 0)
            No content to display.
            <br><br>
            @endif--}}
        </div>
    </div>
</div>
@else
<br><br><br>
<div class="col-lg-10 col-lg-offset-1">
    <div class="col-lg-12">
        <div class="col-lg-4" style="margin-top: 50px">
            <p style="word-wrap: break-word; font-family: 'Haettenschweiler'; text-transform: uppercase; font-size: 50px">{{Str::limit($Aboutuser->first_name.' '.$Aboutuser->last_name,50)}}</p>

            <div>
                <div class="col-lg-12" style="margin-top: 25px; font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif; padding: 0px">
                    <p style="font-size: 22px; margin-bottom: 0px">
                        {{$Aboutuser->profile->aboutMe}}
                    </p>
                </div>

                @if (Auth::user()->id != $Aboutuser->id)
                    <div class="col-lg-12">&nbsp;</div>
                    <div class="col-lg-12 noPadding">
                        <input type="hidden" id="newAboutCost" value="{{$Aboutuser->settings->minaboutifc}}">
                        <div>
                            <button id='showAboutUser2' class="btn btn-success" onclick="showAboutUser2()">Write about
                                @if ($Aboutuser->gender=='male') him
                                @else her
                                @endif
                            </button>
                        </div>
                        <form id="newAboutForm" class="col-lg-12 noPadding" style="display:none">
                            <div class="form-group">
                                  <textarea id="newAbout" name="newAbout" style="margin-top: 50px" class="form-control" rows="5" placeholder="Write about {{$Aboutuser->first_name}}."></textarea>
                            </div>
                            <div class="form-group">
                                <button id="newAboutSubmit" class="btn btn-primary pull-right" onclick="submitNewAbout({{$Aboutuser->id}})">Submit</button>
                                <div id="waitingImg3" style="display: none"><img  src="{{asset('Images/icons/waiting.gif')}}" >Saving..</div>
                            </div>
                        </form>
                    </div>
                @endif

            </div>

        </div>
        <div class="col-lg-3" style="margin-top: 65px; padding-right: 30px">
            <div class="slideshow col-lg-12 noPadding" style="margin-bottom: 20px; height: 150px; width: 150px">
                <?php $num=0 ?>
                @foreach($trivia as $dp)
                <img src="{{$dp->oldpic}}" height="150px" width="150px">
                <?php $num=$num+1 ?>
                @endforeach
            </div>
        </div>

        <div class="col-lg-5" style="margin-top: 65px">
    @if (Auth::user()->id == $Aboutuser->id)
        <br>
            <div id="unapprovedAbout" class="col-lg-12 noPadding">
                @foreach ($unapproved as $unapp)
                <div id="Unapp{{$unapp->id}}">
                    <blockquote class="col-lg-12">{{$unapp->content}}</blockquote>
                    <div class="pull-right"><b>Written By: </b><a href="{{route('user',User::find($unapp->writtenby)->username)}}" style="text-decoration: none">{{User::find($unapp->writtenby)->first_name}} {{User::find($unapp->writtenby)->last_name}}</a></div>
                    <div class="col-lg-12">
                        <button id="acceptUnapp{{$unapp->id}}" class="btn btn-success" onclick="acceptAbout({{$unapp->id}})">Accept</button>
                        <button id="declineUnapp{{$unapp->id}}" class="btn btn-danger" onclick="declineAbout({{$unapp->id}})">Decline</button>
                        <br>
                        <hr>
                    </div>
                </div>
                @endforeach
                {{--@if (count($unapproved) == 0)
                No content to display.
                @endif--}}
            </div>

        @endif

            <div id="approvedAbout" class="col-lg-12 noPadding">
                @foreach ($approved as $app)
                <div id="App{{$app->id}}">
                    <blockquote class="col-lg-12">{{$app->content}}</blockquote>
                    <div class="pull-right"><b>Written By: </b><a href="{{route('user',User::find($app->writtenby)->username)}}" style="text-decoration: none">{{User::find($app->writtenby)->first_name}} {{User::find($app->writtenby)->last_name}}</a></div>
                    <div class="col-lg-12">
                        <br>
                        <hr>
                    </div>
                </div>
                @endforeach
                {{--@if (count($approved) == 0)
                No content to display.
                <br><br>
                @endif--}}
            </div>
        </div>


    </div>
</div>
@endif
