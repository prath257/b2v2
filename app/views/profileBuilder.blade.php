<!DOCTYPE html>
<html>
<head>
    <title>Profile Builder | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- Latest compiled and minified CSS -->
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/profileBuilder.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap-switch.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.flipcounter.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.Jcrop.min.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('css/fileUpload.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/responsive-slider.css')}}" rel="stylesheet">
    <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery.Jcrop.min.js')}}"></script>

</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="position: fixed">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a></a>
            <a id="logo" class="navbar-brand logo" href="{{route('index')}}">
                <span class='letter' style="text-shadow: 1px 1px 1px green; color: green">B</span>
                <span class='letter'>B</span>
                <span class='letter'>a</span>
                <span class='letter'>r</span>
                <span class='letter'>t</span>
                <span class='letter'>e</span>
                <span class='letter'>r</span>
                <span class='letter'>s</span>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <label class=" col-lg-3"></label>
            <div id="message-box" class="alert alert-info alert-dismissable col-lg-5" style="display: none">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Attention! </strong> <p id="message"></p>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li id="home"> <a href="{{route('home')}}" style="cursor: pointer">Home</a></li>
                <li id="profile"> <a href="{{route('profile')}}" style="cursor: pointer">{{Auth::user()->first_name}}</a></li>
                <li id="logOut"> <a href="{{route('signout')}}" style="cursor: pointer">Log Out</a></li>
                <li><a></a> </li>
                <li><a></a> </li>
            </ul>
        </div>
    </div>
</nav>
<br>
<br>
<br>
<input type="hidden" id="userName" value="{{Auth::user()->username}}">
<div class="container">

<div class="col-lg-5" id="profileDivs">

        <div id="welcomeDiv">
            <div>
            <h3>Bienvenidos</h3>

                <p>Hola! <h1>Welcome to BBarters!</h1>
                <br>
                You're now an owner of a personal space on BBarters.
                <br>
                Your current balance is 0 <abbr title="IFCs: Infocurrency.
    At BBarters we use virtual currency to share information around. Nothing is free but it wont cost you any money.">IFCs.</abbr>
                </p>
                <ul>
                    <li>Set your Profile Picture.</li>
                    <li>Tell us a bit about yourself.</li>
                    <li>Choose your interests.</li>
                    <li>Mark your primary interests.</li>
                    <li>Earn yourself 310 IFCs.</li>
                </ul>
                <br>
                <br>

         <button class="btn btn-success" onclick="showPicture()">Start</button>
                <br>
                <br>

         </div>

        </div>

        <div id="pictureDiv" style="display: none">

            <h3 id="picHead">Set Your Profile Pic<!-- and Tune--></h3>
            {{Form::open(array('id'=>'pform','class'=>'form-horizontal'))}}

            <div class="form-group">
                <input type="hidden" id="w" name="w" />
                <input type="hidden" id="h" name="h" />
                <input type="hidden" id="x1" name="x1" />
                <input type="hidden" id="y1" name="y1" />
                <input type="hidden" id="x2" name="x2" />
                <input type="hidden" id="y2" name="y2" />
                <div id="image_div" class="col-lg-6" style="width:100%;alignment-adjust:central; padding-left: 20px; height: 480px; overflow-y: scroll">
                    <img src="{{asset('Images/Anony.jpg')}}" id="load_img" />
                </div>

                <div class="col-lg-12">&nbsp;</div>

                <div class="col-lg-2" id="dpSelect">
                    <div class="fileUpload btn btn-primary" id="changePP">
                        <span id="profilePicName">Select Picture</span>
                        <input type="file" id="profilePic" name="profilePic" class="upload" >
                    </div>
                    <div class="error" style="display: none;"></div>
                </div>
                <button id="mysubmit" onclick="createProfile()" class="btn btn-primary col-lg-1" style="margin-right: 50px; display: none">Set</button>
                {{Form::close()}}
                <button id="myCancel" onclick="cancelPhoto()" class="btn btn-primary col-lg-1" style="margin-right: 50px; display: none">Cancel</button>
                <div id="uploadController" class="col-lg-6" style="display: none;">
                    <div id="mediaProgress" class="progress progress-striped active col-lg-12" style="margin-top: 5px; padding: 0px">
                        <div id="progressBar" class="progress-bar progress-bar-primary"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                            <span class="sr-only">45% Complete</span>
                        </div>
                    </div>
                </div>

                <div id="dpMessage" style="display:none;font-family: "Segoe UI Light", "Helvetica Neue", 'RobotoLight', "Segoe UI", "Segoe WP", sans-serif">
                <div>
                <h3>Hey, nice picture this..we like you already!</h3><h5>Please click next for us to know you more...can't wait </h5>
                <a class="pull-left col-lg-4" href="#" style="padding: 5px">
                    <img id="profilePicture"  width="150px">

                </a>
                <button class="btn btn-success" onclick="showAbout()" style="margin-top: 35%;">Next</button>
                    <div class="mycounter" style="opacity: 0.5; position: absolute; margin-top: 10%; display:none">13</div>
                </div>




              </div>

        </div>


 </div>

        <div id="aboutDiv" style="display: none">
            <h3 id="aboutPlz">Something about you..</h3>

            <div class="wizard-input-section" id="aboutBy">
                <form id="aboutForm" class="form-horizontal">
                    <div class="form-group">

                        <div class="col-lg-7">
                            <textarea rows="5" class="form-control" style="width: 70%; resize: none" name="about" id="about">I am...</textarea>
                            <br>
                            <br>
                            <button id="asubmit" onclick="show4()" type="submit" class="btn btn-primary">That's Me</button>

                        </div>
                    </div>

                </form>
            </div>
            <div id="showAbout" style="display:none">
            <div id="finalAbout">

            </div>
            <br>
            <button id="setInt" class="btn btn-success" onclick="showInt()">Next</button>
            <div class="mycounter" style="opacity: 0.5; position: absolute; margin-top: 15%; display: none">111</div>
            </div>

        </div>

        <div id="intDiv" style="display: none">
            <h2 id="pickI">Pick Interests</h2>
            <div id="chosen">
                <h4>These will be your work areas on BBarters</h4>
                <h5>And you can edit/add/delete them later in settings.</h5>
            </div>

            <div class="wizard-input-section" id="hisAreas">

                <form id="interestForm" class="form-horizontal">
                    <div class="form-group">

                        <div class="col-lg-8">
                            <div id="interests" style="margin-left:10%; text-align:left">
                                <input type="checkbox" name="interests[]" value="music">&nbsp;Music<br>
                                <input type="checkbox" name="interests[]" value="literature">&nbsp;Literature<br>
                                <input type="checkbox" name="interests[]" value="sports">&nbsp;Sports<br>
                                <input type="checkbox" name="interests[]" value="fashion">&nbsp;Fashion<br>
                                <input type="checkbox" name="interests[]" value="technology">&nbsp;Technology<br>
                                <input type="checkbox" name="interests[]" value="cooking">&nbsp;Cooking<br>
                                <input type="checkbox" name="interests[]" value="politics">&nbsp;Politics<br>
                                <input type="checkbox" name="interests[]" value="moviesTelevision">&nbsp;Movies & Television<br>
                                <input type="checkbox" name="interests[]" value="gaming">&nbsp;Gaming<br>
                                <input type="checkbox" name="interests[]" value="automobile">&nbsp;Automobiles<br>
                                <input type="checkbox" name="interests[]" value="travel">&nbsp;Travel<br>

                                Other: <input type="text" name="other" id="other">
                                <br><br>
                                <button onclick="show5()" type="submit" id="isubmit" class="btn btn-primary">Next</button>
                            </div>
                        </div>
                    </div>
                </form>

        </div>

            <div id="showPicked" style="float: left; display: none;">
            <div id="chosenAreas">
                <h4>Pick any three of these as your Primary Interests:</h4>
                <h6>Primary Interests are showcased with emphasis on your profile. To increase visibility of your primary work.<br>
                You can always change any of your secondary interests into primary and vice-versa via settings.  </h6>
                <br><br>

            </div>
            <br>
            <button id="setFinal" class="btn btn-success" onclick="profileFinal()">Submit</button>
            <p id="primeError" style="color: darkred;"></p>
            <div class="mycounter" style="opacity: 0.5; position: absolute; margin-top: 7%; display: none">150</div>
            </div>


    </div>
</div>
<div class="col-lg-7" id="demoSlides" >
    <div id="carousel" class="carousel slide carousel-fade col-lg-12">
        <div class="carousel-inner">

            <div class="item active">
                <img src="../../Images/1.jpg" style="height: 400px">
                <div class="carousel-caption">
                    <h3>Write Content</h3>
                    <p>article | blogbooks | collaborations</p>
                  </div>
            </div>
            <div class="item">
                <img src="../../Images/2.jpg" style="height: 400px">
                 <div class="carousel-caption">
                                    <h3>Write Content</h3>
                                    <p>article | blogbooks | collaborations</p>
                 </div>
            </div>
            <div class="item">
                <img src="../../Images/3.jpg" style="height: 400px">
                 <div class="carousel-caption">
                     <h3>Write Content</h3>
                     <p>article |blogbooks | collaborations</p>
                 </div>
            </div>
            <div class="item">
                            <img src="../../Images/Resource.jpg" style="height: 400px">
                             <div class="carousel-caption">
                                 <h3>Upload or Download</h3>
                                 <p>code | boooks |media</p>
                             </div>
            </div>
        </div>

        <div>
        <br>
            <ul class="carousel-indicators pull-right" style="left: auto; list-style-type: none">
                <li data-target="#carousel" data-slide-to="0" class="active bottom-boxes"></li>
                <li data-target="#carousel" data-slide-to="1" class="bottom-boxes"></li>
                <li data-target="#carousel" data-slide-to="2" class="bottom-boxes"></li>
                <li data-target="#carousel" data-slide-to="3" class="bottom-boxes"></li>
            </ul>
        </div>
    </div>
</div>
</div>



<!--Here goes my smartphone content-->
<div class="modal fade" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Bienvenidos</h4>
            </div>
            <div class="modal-body">
                <p>Hola! <h1>Welcome to BBarters!</h1>
                <br>
                You're now an owner of a personal space on BBarters.
                <br>
                Your current balance is 0 <abbr title="IFCs: Infocurrency.
    At BBarters we use virtual currency to share information around. Nothing is free but it wont cost you any money.">IFCs.</abbr>
                Build your profile and earn some <abbr title="IFCs: Infocurrency.
    At BBarters we use virtual currency to share information around. Nothing is free but it wont cost you any money.">IFCs.</abbr><br>
                </p>
            </div>
            <div class="modal-footer">
                <button onclick="show2()" type="button" class="btn btn-primary">Start</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Set Profile Pic<!-- and Tune--></h4>
            </div>
            <div class="modal-body">
                {{Form::open(array('id'=>'pformMobile','class'=>'form-horizontal'))}}

                <div class="form-group">
                    <div id="image_divMobile" style="alignment-adjust:central">
                        <img src="{{asset('Images/Anony.jpg')}}" id="load_imgMobile" width="220px" height="200px"/>
                    </div>
                    <br>
                    <input type="file" style="width:220px;" id="profilePicMobile" name="profilePic">
                    <div class="error" style="display: none;"></div>
                </div>
                <div class="form-group">
                    <!--<h2>Please Select a Profile Tune</h2>
                    <input type="file" name="profileTune" id="profileTuneMobile"/>-->
                    <progress id="progressBarMobile" value="0" max="100" style="width:300px; visibility:collapse;"></progress>
                    <h3 id="status"></h3>
                </div>
                <div class="modal-footer">
                    <button id="mysubmitMobile" onclick="createProfile()" class="btn btn-primary">Set</button>
                    {{Form::close()}}
                </div>

            </div>


        </div>
    </div>
</div>



<div class="modal fade" id="aboutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">About You</h4>
            </div>
            <div class="modal-body">
                <form id="aboutFormMobile" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Tell us</label>
                        <div class="col-lg-6">
                            <textarea rows="5" class="form-control" style="width: 100%; resize: none" name="about" id="aboutMobile"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button id="asubmitMobile" onclick="show4()" type="button" class="btn btn-primary">Next</button>
                </form>
            </div>

        </div>

    </div>
</div>
</div>

<div class="modal fade" id="interestsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Interests</h4>
            </div>
            <div class="modal-body">
                <p>Let us know some of your interests. Your profile will be decorated accordingly.</p>
                <form id="interestFormMobile" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Pick Please</label>
                        <div class="col-lg-6">
                            <div id="interests" style="margin:10%; text-align:left">
                                <input type="checkbox" name="interests[]" value="music">Music<br>
                                <input type="checkbox" name="interests[]" value="literature">Literature<br>
                                <input type="checkbox" name="interests[]" value="sports">Sports<br>
                                <input type="checkbox" name="interests[]" value="fashion">Fashion<br>
                                <input type="checkbox" name="interests[]" value="technology">Technology<br>
                                <input type="checkbox" name="interests[]" value="politics">Politics<br>
                                <input type="checkbox" name="interests[]" value="moviesTelevision">Movies & Television<br>
                                <input type="checkbox" name="interests[]" value="gaming">Gaming<br>
                                <input type="checkbox" name="interests[]" value="automobile">Automobiles<br>
                                <input type="checkbox" name="interests[]" value="travel">Travel<br>
                                <input type="checkbox" name="interests[]" value="cooking">&nbsp;Cooking<br>
                                Other: <input type="text" name="other" id="otherPhone"><br>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button onclick="show5()" type="submit" id="isubmitMobile" class="btn btn-primary">Start</button>
                </form>
            </div>
        </div>

    </div>
</div>
</div>

<div class="modal fade" id="primaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Pick Primary Interests</h4>
            </div>
            <div class="modal-body">
                <p>Let us know some of your interests. Your profile will be decorated accordingly.</p>
                <form id="primaryFormMobile" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Pick Please</label>
                        <div class="col-lg-6">
                            <div id="priInterests" style="margin:10%; text-align:left">

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button onclick="mobileFinal()" type="submit" id="isubmitMobile" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

    </div>
</div>
</div>


<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="../../js/responsive-slider.js"></script>
<script src="{{asset('js/reload.js')}}"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/bootstrap-switch.js')}}"></script>
<script src="{{asset('js/pages/profileBuilder.js')}}"></script>
<script src="{{asset('js/jstween-1.1.min.js')}}"></script>
<script src="{{asset('js/jquery.flipcounter.js')}}"></script>
</body>
</html>