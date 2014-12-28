@if ($mode == 'getaccount' || $mode == 'getinterests')
    <!DOCTYPE html>
    <html>
    <head>
        <title>Settings | BBarters</title>
            <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

            <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
            <link href="{{asset('css/pages/profile.css')}}" rel="stylesheet">
            <link href="{{asset('css/logo.css')}}" rel="stylesheet">
            <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
            <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
            {{--<link rel="stylesheet" type="text/css" href="{{asset('css/metro.blue.css')}}" />--}}
            <link href="{{asset('dataTables.bootstrap.css')}}" rel="stylesheet">
            <link href="{{asset('css/summernote.css')}}" rel="stylesheet">
            <link href="{{asset('css/jquery.flipcounter.css')}}" rel="stylesheet">
            <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
            <link href="{{asset('css/bootstrap-switch.css')}}" rel="stylesheet">

            <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
            <script src="{{asset('js/jquery.min.js')}}"></script>
            <script src="{{asset('js/jquery.Jcrop.min.js')}}"></script>
            <script src="{{asset('js/bootstrap.js')}}"></script>
            <script src="{{asset('js/docready.js')}}"></script>
            <script type="text/javascript" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
            <script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/505bef35b56/integration/bootstrap/3/dataTables.bootstrap.js"></script>

    </head>
    <body>
    <input type="hidden" id="docreadyrequest" value="{{$mode}}">
    @include('navbar')


@endif

<br>
<br>
<br>

@if ($mode == 'getaccount')
<div class="col-lg-6 col-lg-offset-3">
                <fieldset>
                    <br>
                    <form id="accountSettingsForm" class="form-horizontal">

                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Profile Theme</label>
                            <div class="col-lg-5">
                                <select id="profileTheme" class="form-control" name="profileTheme">
                                    @if ($settings->profileTheme=='standard')
                                        <option value="standard">Standard</option>
                                        <option value="classic">Classic</option>
                                    @else
                                        <option value="classic">Classic</option>
                                        <option value="standard">Standard</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-lg-12">&nbsp;</div>
                            <small class="col-lg-12" style="text-align: center">Select a layout for your profile page that suits you.</small>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Friend Charges</label>
                            <div class="col-lg-5">
                                <input type="text" id="friendsIfc" class="form-control" name="friendsIfc" value="{{$settings->friendcost}}">
                            </div>
                            <div class="col-lg-12">&nbsp;</div>
                            <small class="col-lg-12" style="text-align: center">People have to pay these many IFCs when you accept a friend request sent by them.</small>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Subscription Charges</label>
                            <div class="col-lg-5">
                                <input type="text" id="subsIfc" class="form-control" name="subsIfc" value="{{$settings->subcost}}">
                            </div>
                            <div class="col-lg-12">&nbsp;</div>
                            <small class="col-lg-12" style="text-align: center">You can set a price for your followers. People have to pay these many IFCs to you when they decide to follow you.</small>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Chat Charges</label>
                            <div class="col-lg-5">
                                <input type="text" id="chatIfc" class="form-control" name="chatIfc" value="{{$settings->chatcost}}">
                            </div>
                            <div class="col-lg-12">&nbsp;</div>
                            <small class="col-lg-12" style="text-align: center">People pay you IFCs if you approve chat request sent by them.</small>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Email Notifications</label>
                            <div class="col-lg-5">
                                <div class="bootstrap-switch">
                                    @if ($settings->notifications == '1')
                                    <input id="notification-checkbox" type="checkbox" name="notification-checkbox" checked>
                                    @else
                                    <input id="notification-checkbox" type="checkbox" name="notification-checkbox">
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">&nbsp;</div>
                            <small class="col-lg-12" style="text-align: center">This doesn't turn off every mailer, just the less important ones.</small>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Min IFC (About)</label>
                            <div class="col-lg-5">
                                <input type="text" id="aboutIfc" class="form-control" name="aboutIfc" value="{{$settings->minaboutifc}}">
                            </div>
                            <div class="col-lg-12">&nbsp;</div>
                            <small class="col-lg-12" style="text-align: center">Min IFC to be charged if anyone posts something 'About you' on your profile page.</small>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Min IFC (Ask Me)</label>
                            <div class="col-lg-5">
                                <input type="text" id="askIfc" class="form-control" name="askIfc" value="{{$settings->minqifc}}">
                            </div>
                            <div class="col-lg-12">&nbsp;</div>
                            <small class="col-lg-12" style="text-align: center">Min IFC to be charged if anyone asks you anything on your profile page.</small>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Free For Friends</label>
                            <div class="col-lg-5">
                                <div class="bootstrap-switch">
                                    @if ($settings->freeforfriends == '1')
                                    <input id="freeforfriends-checkbox" type="checkbox" name="freeforfriends-checkbox" checked>
                                    @else
                                    <input id="freeforfriends-checkbox" type="checkbox" name="freeforfriends-checkbox">
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">&nbsp;</div>
                            <small class="col-lg-12" style="text-align: center">Should your content be free for your friends?</small>
                            <small class="col-lg-12" style="text-align: right"><b>(Articles, BlogBooks, Collaborations, Public Media, Resources and Events)</b></small>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Discount for Followers</label>
                            <div class="col-lg-5">
                                <input type="text" id="subsDiscount" class="form-control" name="subsDiscount" value="{{$settings->discountforfollowers}}">
                            </div>
                            <div class="col-lg-1"><b>%</b></div>
                            <div class="col-lg-12">&nbsp;</div>
                            <small class="col-lg-12" style="text-align: center">This is where you decide if your followers stand for any discount while purchasing any of your content.</small>
                            <small class="col-lg-12" style="text-align: right"><b>(Articles, BlogBooks, Collaborations, Public Media, Resources and Events)</b></small>
                        </div>
                        <div id="ssformobile" class="col-lg-6 col-lg-offset-6">

                        </div>

                    </form>
                        <br>
                        <br>
                        <hr>

                    @if ($user->fbid == null && $user->twitterid == null && $user->gid == null)
                    <form id="resetPasswordForm" class="form-horizontal">

                            <h3>Reset Password</h3>
                            <br>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Existing Password</label>
                            <div class="col-lg-5">
                                <input type="password" id="existingPassword" class="form-control" name="existingPassword">
                            </div>
                        </div>
                            <div class="col-lg-12"></div>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">New Password</label>
                            <div class="col-lg-5">
                                <input type="password" id="newPassword" class="form-control" name="newPassword">
                            </div>
                        </div>
                            <div class="col-lg-12"></div>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Retype Password</label>
                            <div class="col-lg-5">
                                <input type="password" id="retypePassword" class="form-control" name="retypePassword">
                            </div>
                        </div>

                            <div class="col-lg-10">
                                <br>
                                <div id="resetPasswordMessage" class="col-lg-8" style="text-align: right; color: darkred"></div>
                                <button id="resetPasswordSubmit" type="submit" class="btn btn-success pull-right" onclick="resetPassword()">Reset Password</button>
                                <br>
                            </div>
                        <div class="col-lg-12">&nbsp;</div>

                    </form>
                    @endif
                </fieldset>
            </div>
              <div id="settingsSaveContent" class="col-lg-1">
                <br>
                  <button type="submit" id="accountSettingsSubmit" class="btn btn-success pull-right" onclick="saveAccountChanges()">Save Changes</button>
              <br><br>
              <div id="accountSettingsMessage" class="col-lg-8" style="text-align: right; color: darkred"></div>

              </div>
@elseif($mode == 'getinterests')
<div class="col-lg-12 container-fluid">
                <div class="col-lg-3">
                    <div class="list-group col-lg-12">
                        <a id="interestsListOption" href="#" onclick="showInterests(); return false;" class="list-group-item">Interests</a>
                        <a id="interestsTypeOption" href="#" onclick="showInterestType(); return false;" class="list-group-item">Manage Interests</a>
                    </div>
                </div>

                <div id="content" class="col-lg-9">



                    <div id="interests" class="col-lg-12 well switch-content" style="display: none">
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
                                    <br><br>
                                </div>
                                <h2>Remove Existing:</h2>
                                <br>
                                <div id="oldInterests">
                                    <?php $i=0; ?>
                                    @foreach($oldInterests as $oldi)
                                    <?php $i++ ?>
                                    <p class="col-lg-4">{{$oldi->interest_name}}</p>
                                    <?php $type = DB::table('user_interests')->where('interest_id',$oldi->id)->where('user_id',Auth::user()->id)->first(); ?>
                                    @if ($type->type == 'secondary')
                                    <input type="checkbox" class="oldinterests" name="oldinterests[]" value="{{$oldi->interest_name}}">
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
                    </div>

                    <div id="interestType" class="col-lg-12 well switch-content" style="display: none">
                        <h1>Manage Interests</h1>
                        <br><br>
                        Manage your primary and secondary interests. Remember that primary interests ought to be three!<br><br>
                        <div class="form-group">
                            <div class="col-lg-6">
                                <div id="manageInterests">
                                    @foreach($oldInterests as $oI)
                                    <p class="col-lg-4">{{$oI->interest_name}}</p>
                                    <?php $type = DB::table('user_interests')->where('interest_id',$oI->id)->where('user_id',Auth::user()->id)->first(); ?>
                                    @if ($type->type == 'primary')
                                    <input type="checkbox" class="interestType" name="interestType[]" value="{{$oI->id}}" checked>
                                    @else
                                    <input type="checkbox" class="interestType" name="interestType[]" value="{{$oI->id}}">
                                    @endif
                                    <br><br>
                                    @endforeach

                                </div>
                                <div class="typeerror" style="display: none"></div>
                            </div>
                        </div>
                        <div class="col-lg-12">&nbsp;</div>
                        <button id="myTYPEsubmit" onclick="manageInterests()" class="btn btn-primary col-lg-2">Save Changes</button>
                    </div>

                </div>
            </div>
@else
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li id="editProfileTab"><a href="#editProfile" role="tab" data-toggle="tab">Edit Profile</a></li>
        <li id="accountSettingsTab"><a href="#accountSettings" role="tab" data-toggle="tab">Account Settings</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
    @if($user->pset)
        <div class="tab-pane fade in" id="editProfile">
            <br>
            <div class="col-lg-12 container-fluid">
                <div class="col-lg-3">
                    <div class="list-group col-lg-12">
                        <a id="credentialsListOption" href="#" onclick="showCredentials(); return false;" class="list-group-item">Profile Credentials</a>
                        <a id="profilePictureListOption" href="#" onclick="showProfilePicture(); return false;" class="list-group-item">Profile Picture</a>
                        <a id="profileTuneListOption" href="#" onclick="showProfileTune(); return false;" class="list-group-item">Profile Tune</a>
                        <a id="aboutYouListOption" href="#" onclick="showAboutYou(); return false;" class="list-group-item">About You</a>
                        <a id="interestsListOption" href="#" onclick="showInterests(); return false;" class="list-group-item">Interests</a>
                        <a id="interestsTypeOption" href="#" onclick="showInterestType(); return false;" class="list-group-item">Manage Interests</a>
                    </div>
                </div>

                <div id="content" class="col-lg-9">
                    <div id="credentials" class="col-lg-12 well switch-content" style="display: none">

                        <h3>Change Name</h3>
                        <br>
                        <br>
                        {{Form::open(array('id'=>'newNameForm','class'=>'form-horizontal'))}}
                        <fieldset>
                        <div class="col-lg-6 col-lg-offset-3">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Fullname</label>
                                <div class="col-lg-5">
                                    <input id="firstname" type="text" class="form-control" name="firstname" placeholder="First Name" />
                                </div>
                                <div class="col-lg-4">
                                    <input id="lastname" type="text" class="form-control" name="lastname" placeholder="Last Name" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-5 col-lg-offset-3">
                                    <div class="checkbox">
                                        <input id="confirmNameChange" type="checkbox" name="confirmNameChange" /> Confirm Change
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-9 col-lg-offset-3">
                                    <button id="newUsernameSubmit" type="submit" class="btn btn-primary" onclick="saveNewName()">Save</button>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-5 col-lg-offset-3">
                                    <div id="nameUpdatedSuccessfully" style="display: none">
                                        Name updated successfully
                                    </div>
                                </div>
                            </div>
                        </div>
                        </fieldset>
                        {{Form::close()}}
                    </div>

                    <div id="profilePicture" class="col-lg-12 well switch-content" style="display: none">
                        <div>
                            <h2>Change Profile Picture</h2>
                            <br>
                            {{Form::open(array('id'=>'ppForm','class'=>'form-horizontal'))}}
                            <input type="hidden" id="w" name="w" />
                            <input type="hidden" id="h" name="h" />
                            <input type="hidden" id="x1" name="x1" />
                            <input type="hidden" id="y1" name="y1" />
                            <input type="hidden" id="x2" name="x2" />
                            <input type="hidden" id="y2" name="y2" />
                            <div id="image_div" style="alignment-adjust:central; padding-left: 20px;overflow: scroll">
                                <img src="{{$user->profile->profilePic}}" id="load_img" />
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <div class="fileUpload btn btn-primary" id="changePP">
                                    <span>Change</span>
                                    <input type="file" id="profilePicChange" name="profilePicChange" class="upload">
                                </div>

                                <div class="error" style="display: none;"></div>

                                <h3 id="status"></h3>
                                <button id="ppsubmit" onclick="changeProfilePic()" style="display: none" class="btn btn-primary col-lg-2">Set</button>
                                <br>
                                <div id="uploadController" class="col-lg-12" style="display: none">
                                    <div id="mediaProgress" class="progress progress-striped active col-lg-12" style="margin-top: 10px; padding: 0px">
                                        <div id="progressBar" class="progress-bar progress-bar-primary"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                            <span class="sr-only">45% Complete</span>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                            {{Form::close()}}
                        </div>
                    </div>

                    <div id="profileTuneDiv" class="col-lg-12 well switch-content" style="display: none">
                        <div class="form-group">

                            <h2>Current Profile Tune</h2>
                            <audio controls style="width:100%" id="mytune">
                                <source src="{{asset($user->profile->profileTune)}}" type="audio/mpeg">
                            </audio>
                            <br>
                            <br>

                            {{Form::open(array('id'=>'ptForm','class'=>'form-horizontal'))}}
                            <div class="form-group col-lg-5 col-lg-offset-3">
                                <div class="fileUpload btn btn-primary" id="changePP">
                                    <span>Select a New Profile Tune</span>
                                    <input type="file" name="profileTune" id="profileTune" accept="audio/*" class="upload" onchange="displayTuneName()">
                                </div>
                                <div id="tunename"></div>
                                <progress id="progressBar" value="0" max="100" style="width:300px; visibility:collapse;"></progress>
                                <h3 id="status"></h3>
                                <button id="ptsubmit" onclick="changeProfileTune()" class="btn btn-primary col-lg-2" style="display: non">Set</button>
                                <br>
                                <div id="uploadControllerPT" class="col-lg-12" style="display: none">
                                    <div id="mediaProgressPT" class="progress progress-striped active col-lg-12" style="margin-top: 10px; padding: 0px">
                                        <div id="progressBarPT" class="progress-bar progress-bar-primary"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                            <span class="sr-only">45% Complete</span>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                            {{Form::close()}}
                        </div>

                    </div>

                    <div id="aboutYou" class="col-lg-12 well switch-content" style="display: none">
                        <div class="form-group">
                            <h2>Please write something about you.</h2>
                            {{Form::open(array('id'=>'aboutForm','class'=>'form-horizontal'))}}
                            <textarea id="editAbout" name="editAbout" class="form-control" style="width: 100%" rows="5" required>{{$user->profile->aboutMe}}</textarea>
                            <button id="aboutsubmit" onclick="updateAbout()" class="btn btn-primary col-lg-2">Update</button>
                        </div>
                        {{Form::close()}}
                        <label id="statusAbout" class="col-lg-3 control-label"></label>
                    </div>

                    <div id="interests" class="col-lg-12 well switch-content" style="display: none">
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
                                    <br><br>
                                </div>
                                <h2>Remove Existing:</h2>
                                <br>
                                <div id="oldInterests">
                                    <?php $i=0; ?>
                                    @foreach($oldInterests as $oldi)
                                    <?php $i++ ?>
                                    <p class="col-lg-4">{{$oldi->interest_name}}</p>
                                    <?php $type = DB::table('user_interests')->where('interest_id',$oldi->id)->where('user_id',Auth::user()->id)->first(); ?>
                                    @if ($type->type == 'secondary')
                                    <input type="checkbox" class="oldinterests" name="oldinterests[]" value="{{$oldi->interest_name}}">
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
                    </div>

                    <div id="interestType" class="col-lg-12 well switch-content" style="display: none">
                        <h1>Manage Interests</h1>
                        <br><br>
                        Manage your primary and secondary interests. Remember that primary interests ought to be three!<br><br>
                        <div class="form-group">
                            <div class="col-lg-6">
                                <div id="manageInterests">
                                    @foreach($oldInterests as $oI)
                                    <p class="col-lg-4">{{$oI->interest_name}}</p>
                                    <?php $type = DB::table('user_interests')->where('interest_id',$oI->id)->where('user_id',Auth::user()->id)->first(); ?>
                                    @if ($type->type == 'primary')
                                    <input type="checkbox" class="interestType" name="interestType[]" value="{{$oI->id}}" checked>
                                    @else
                                    <input type="checkbox" class="interestType" name="interestType[]" value="{{$oI->id}}">
                                    @endif
                                    <br><br>
                                    @endforeach

                                </div>
                                <div class="typeerror" style="display: none"></div>
                            </div>
                        </div>
                        <div class="col-lg-12">&nbsp;</div>
                        <button id="myTYPEsubmit" onclick="manageInterests()" class="btn btn-primary col-lg-2">Save Changes</button>
                    </div>

                </div>
            </div>
        </div>
    @endif
        <div class="tab-pane fade" id="accountSettings">
            <div class="col-lg-6 col-lg-offset-3">
                <fieldset>
                    <br>
                    <form id="accountSettingsForm" class="form-horizontal">

                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Profile Theme</label>
                            <div class="col-lg-5">
                                <select id="profileTheme" class="form-control" name="profileTheme">
                                    @if ($settings->profileTheme=='standard')
                                        <option value="standard">Standard</option>
                                        <option value="classic">Classic</option>
                                    @else
                                        <option value="classic">Classic</option>
                                        <option value="standard">Standard</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-lg-12">&nbsp;</div>
                            <small class="col-lg-12" style="text-align: center">Select a layout for your profile page that suits you.</small>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Friend Charges</label>
                            <div class="col-lg-5">
                                <input type="text" id="friendsIfc" class="form-control" name="friendsIfc" value="{{$settings->friendcost}}">
                            </div>
                            <div class="col-lg-12">&nbsp;</div>
                            <small class="col-lg-12" style="text-align: center">People have to pay these many IFCs when you accept a friend request sent by them.</small>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Subscription Charges</label>
                            <div class="col-lg-5">
                                <input type="text" id="subsIfc" class="form-control" name="subsIfc" value="{{$settings->subcost}}">
                            </div>
                            <div class="col-lg-12">&nbsp;</div>
                            <small class="col-lg-12" style="text-align: center">You can set a price for your followers. People have to pay these many IFCs to you when they decide to follow you.</small>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Chat Charges</label>
                            <div class="col-lg-5">
                                <input type="text" id="chatIfc" class="form-control" name="chatIfc" value="{{$settings->chatcost}}">
                            </div>
                            <div class="col-lg-12">&nbsp;</div>
                            <small class="col-lg-12" style="text-align: center">People pay you IFCs if you approve chat request sent by them.</small>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Email Notifications</label>
                            <div class="col-lg-5">
                                <div class="bootstrap-switch">
                                    @if ($settings->notifications == '1')
                                    <input id="notification-checkbox" type="checkbox" name="notification-checkbox" checked>
                                    @else
                                    <input id="notification-checkbox" type="checkbox" name="notification-checkbox">
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">&nbsp;</div>
                            <small class="col-lg-12" style="text-align: center">This doesn't turn off every mailer, just the less important ones.</small>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Min IFC (About)</label>
                            <div class="col-lg-5">
                                <input type="text" id="aboutIfc" class="form-control" name="aboutIfc" value="{{$settings->minaboutifc}}">
                            </div>
                            <div class="col-lg-12">&nbsp;</div>
                            <small class="col-lg-12" style="text-align: center">Min IFC to be charged if anyone posts something 'About you' on your profile page.</small>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Min IFC (Ask Me)</label>
                            <div class="col-lg-5">
                                <input type="text" id="askIfc" class="form-control" name="askIfc" value="{{$settings->minqifc}}">
                            </div>
                            <div class="col-lg-12">&nbsp;</div>
                            <small class="col-lg-12" style="text-align: center">Min IFC to be charged if anyone asks you anything on your profile page.</small>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Free For Friends</label>
                            <div class="col-lg-5">
                                <div class="bootstrap-switch">
                                    @if ($settings->freeforfriends == '1')
                                    <input id="freeforfriends-checkbox" type="checkbox" name="freeforfriends-checkbox" checked>
                                    @else
                                    <input id="freeforfriends-checkbox" type="checkbox" name="freeforfriends-checkbox">
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">&nbsp;</div>
                            <small class="col-lg-12" style="text-align: center">Should your content be free for your friends?</small>
                            <small class="col-lg-12" style="text-align: right"><b>(Articles, BlogBooks, Collaborations, Public Media, Resources and Events)</b></small>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Discount for Followers</label>
                            <div class="col-lg-5">
                                <input type="text" id="subsDiscount" class="form-control" name="subsDiscount" value="{{$settings->discountforfollowers}}">
                            </div>
                            <div class="col-lg-1"><b>%</b></div>
                            <div class="col-lg-12">&nbsp;</div>
                            <small class="col-lg-12" style="text-align: center">This is where you decide if your followers stand for any discount while purchasing any of your content.</small>
                            <small class="col-lg-12" style="text-align: right"><b>(Articles, BlogBooks, Collaborations, Public Media, Resources and Events)</b></small>
                        </div>
                        <div id="ssformobile" class="col-lg-6 col-lg-offset-6">

                        </div>

                    </form>
                        <br>
                        <br>
                        <hr>

                    @if ($user->fbid == null && $user->twitterid == null && $user->gid == null)
                    <form id="resetPasswordForm" class="form-horizontal">

                            <h3>Reset Password</h3>
                            <br>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Existing Password</label>
                            <div class="col-lg-5">
                                <input type="password" id="existingPassword" class="form-control" name="existingPassword">
                            </div>
                        </div>
                            <div class="col-lg-12"></div>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">New Password</label>
                            <div class="col-lg-5">
                                <input type="password" id="newPassword" class="form-control" name="newPassword">
                            </div>
                        </div>
                            <div class="col-lg-12"></div>
                        <div class="form-group">
                            <label class="col-lg-3 col-lg-offset-1 control-label">Retype Password</label>
                            <div class="col-lg-5">
                                <input type="password" id="retypePassword" class="form-control" name="retypePassword">
                            </div>
                        </div>

                            <div class="col-lg-10">
                                <br>
                                <div id="resetPasswordMessage" class="col-lg-8" style="text-align: right; color: darkred"></div>
                                <button id="resetPasswordSubmit" type="submit" class="btn btn-success pull-right" onclick="resetPassword()">Reset Password</button>
                                <br>
                            </div>
                        <div class="col-lg-12">&nbsp;</div>

                    </form>
                    @endif
                </fieldset>
            </div>
              <div id="settingsSaveContent" class="col-lg-1">
                <br>
                  <button type="submit" id="accountSettingsSubmit" class="btn btn-success pull-right" onclick="saveAccountChanges()">Save Changes</button>
              <br><br>
              <div id="accountSettingsMessage" class="col-lg-8" style="text-align: right; color: darkred"></div>

              </div>
        </div>
    </div>
@endif

@if ($mode == 'getaccount' || $mode == 'getinterests')
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/jquery.metro.js')}}"></script>
<script src="{{asset('js/summernote.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/jstween-1.1.min.js')}}"></script>
<script src="{{asset('js/jquery.flipcounter.js')}}"></script>
<script src="{{asset('js/bootstrap-switch.js')}}"></script>
    </body>
    </html>
    @endif

    <input type="hidden" id="interest-search-buffer" value="null">
    <input type="hidden" id="interest-search-buffer-Name" value="null">