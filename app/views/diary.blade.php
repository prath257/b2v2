<!DOCTYPE html>
<html>
<head>
    <title>Diary | BBarters</title>
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet"/>
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/responsive-calendar.css')}}" rel="stylesheet">
    <link href="{{asset('css/summernote.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/diary.css')}}" rel="stylesheet">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
</head>
<body style="font-family: 'Segoe UI', 'Segoe WP', 'Helvetica Neue', 'RobotoRegular', sans-serif">
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=431744100304343&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    @include('navbar')
    <br><br><br>
    <div class="col-lg-12>">
        <div class="col-lg-2">
            <img class="col-lg-12" src="{{asset($user->profile->profilePic)}}" style="margin-bottom: 20px">
            <i><h4 id="diaryTitle" class="col-lg-12 segoe center-align" style="font-size: 25px">{{$user->settings->diaryTitle}}</h4></i>
            @if (Auth::user()->id == $user->id)
            <div class="col-lg-12"><input id="diaryTitleInput" type="text" class="form-control" style="display: none"></div>
            <div class="right-align col-lg-12">
                <a id="editTitle" onclick="editTitle()" style="cursor: pointer">Edit</a>
                <a id="saveTitle" onclick="updateTitle()" style="display: none; cursor: pointer">Save</a>
                <br><br>
            </div>
            @endif
            <input type="hidden" id="userid" value="{{$user->id}}">
            @if (Auth::user()->id == $user->id)
            <div class="col-lg-12">
                <button class="btn btn-success col-lg-12" onclick="newPost()">New Post</button>
            </div>
            @endif
        </div>
        <div class="col-lg-8">
        <?php $currentYear = date('Y');
              $currentMonth = date('M');
              $currentDate = date('d');
              $months=array("1"=>"Jan", "2"=>"Feb", "3"=>"Mar", "4"=>"Apr", "5"=>"May", "6"=>"Jun", "7"=>"Jul", "8"=>"Aug", "9"=>"Sep", "10"=>"Oct", "11"=>"Nov", "12"=>"Dec");
        ?>
        <div class="col-lg-12" id="PostsDate">
        <h2>{{$currentDate}}</h2>
        <h4>{{$currentMonth}}</h4>
        </div>
              <div class="col-lg-12" id="posts">
              <br>
              @if (count($posts) > 0)
                @foreach($posts as $post)
                <div id="readDiary{{$post->id}}">
                    {{$post->text}}
                </div>
                    <div class="right-align">
                        <?php
                            $postDate = $post->created_at;
                            $postDate = new DateTime($postDate);
                            $postHour = $postDate->format('H');
                            if ($postHour > 12)
                            {
                                $postHour = $postHour-12;
                                $ext = 'PM';
                            }
                            else
                                $ext = 'AM';
                            $postDt = $postDate->format('d-m-Y');
                            $postMin = $postDate->format('i');
                         ?>
                        {{$postDt}} {{$postHour}}:{{$postMin}} {{$ext}}
                    </div>
                    @if (Auth::user()->id == $user->id)

                    <div id="summernoteTextarea{{$post->id}}">
                    <textarea style="display:none" class="input-block-level" id="summernote{{$post->id}}" name="summernote" rows="18" onfocus="checkCharacters()"></textarea>
                    <div class="right-align">
                    <br>
                        <a id="btnSave{{$post->id}}" class="hand-over-me btn btn-success" onclick="save({{$post->id}},'edit')" style="display: none">Save</a>

                        <a id="btnEdit{{$post->id}}" class="hand-over-me" onclick="showEdit({{$post->id}})">Edit</a>

                        <a id="btnDelt{{$post->id}}" class="hand-over-me" onclick="showDelt({{$post->id}})">Delete</a>
                    </div>





                    </div>
                    @endif
                   <hr><br>


                <input type="hidden" id="editOrSave{{$post->id}}" value="">

                @endforeach

               @else
                <h3>No posts today!</h3>
               @endif

              </div>


        </div>
        <div class="col-lg-2">
            <div id="calendar" class="col-lg-12 zero-padding">
                <div id="calendarwaiting" class="center-align"><img src="{{asset('Images/icons/waiting.gif')}}">Loading..</div>
                <!-- Responsive calendar - START -->
                    	<div id="newCalendar" class="responsive-calendar" style="display: none">
                        <div class="controls">
                            <a class="pull-left" data-go="prev"><div class="btn btn-default" style="padding-top: 3px; padding-bottom: 3px"><i class="fa fa-arrow-left"></i></div></a>
                            <h4><span data-head-year></span> <span data-head-month></span></h4>
                            <a class="pull-right" data-go="next"><div class="btn btn-default" style="padding-top: 3px; padding-bottom: 3px"><i class="fa fa-arrow-right"></i></div></a>
                        </div><hr/>
                        <div class="day-headers">
                          <div class="day header">Mon</div>
                          <div class="day header">Tue</div>
                          <div class="day header">Wed</div>
                          <div class="day header">Thu</div>
                          <div class="day header">Fri</div>
                          <div class="day header">Sat</div>
                          <div class="day header">Sun</div>
                        </div>
                        <div class="days" data-group="days">

                        </div>
                      </div>
                      <!-- Responsive calendar - END -->
            </div>
            @if (Auth::user()->id == $user->id)
            <div id="access-levels" class="col-lg-12">
                <h3 style="font-family: 'arial'">Access Levels</h3>
                <hr>
                <div>
                    @if(Auth::user()->settings->diaryAccess == 'public')
                    <input id="public" type="radio" name="access" onchange="accessSetting('public')" checked>Public <br>
                    <input id="private" type="radio" name="access" onchange="accessSetting('private')">Private <br>
                    <input id="semi" type="radio" name="access" onchange="accessSetting('semi')">Semi-Public<br>
                    @elseif(Auth::user()->settings->diaryAccess == 'private')
                    <input id="public" type="radio" name="access" onchange="accessSetting('public')" >Public <br>
                    <input id="private" type="radio" name="access" onchange="accessSetting('private')" checked>Private <br>
                    <input id="semi" type="radio" name="access" onchange="accessSetting('semi')">Semi-Public<br>
                    @elseif(Auth::user()->settings->diaryAccess == 'semi')
                    <input id="public" type="radio" name="access" onchange="accessSetting('public')" >Public <br>
                    <input id="private" type="radio" name="access" onchange="accessSetting('private')" >Private <br>
                    <input id="semi" type="radio" name="access" onchange="accessSetting('semi')" checked>Semi-Public<br>
                    @endif

                </div>
                <div id="semidiv">
                <div id="friendList"></div>
                <div id="friendSelect"></div>

                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="newPostModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">New Post</h4>
                </div>
                <div class="modal-body">
                    <fieldset id="summernoteDiv">

                    </fieldset>

                </div>
            </div>
        </div>
    </div>

    <div class="fb-comments col-lg-2 col-lg-offset-2" data-href="http://b2.com/diary/{{$user->username}}" data-width="600" data-numposts="10" data-colorscheme="light"></div>


    <div class="modal fade" id="editPostModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick="cancelEdit()">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Edit Post</h4>
                    </div>
                    <div class="modal-body">
                        <fieldset id="summernoteDiv2">

                        </fieldset>
                    </div>
                </div>
            </div>
        </div>

        <?php
            $currentYear = date('Y');
            $currentMonth = date('m');
            $currentDate = date('d');
        ?>
        <input type="hidden" id="currentYear" value="{{$currentYear}}">
        <input type="hidden" id="currentMonth" value="{{$currentMonth}}">
        <input type="hidden" id="currentDate" value="{{$currentDate}}">

        <input type="hidden" id="currentYear2" value="{{$currentYear}}">
        <input type="hidden" id="currentMonth2" value="{{$currentMonth}}">
        <input type="hidden" id="currentDate2" value="{{$currentDate}}">

        <input type="hidden" id="beingEdited" value="0">

    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script src="{{asset('js/summernote.js')}}"></script>
    <script src="{{asset('js/responsive-calendar.js')}}"></script>
    <script src="{{asset('js/bootbox.js')}}"></script>
    <script src="{{asset('js/pages/diary.js')}}"></script>

    <input type="hidden" id="refreshed" value="no">
    <script src="{{asset('js/reload.js')}}"></script>
</body>
</html>