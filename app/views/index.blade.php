<!DOCTYPE html>
<html>
<head>
  	<title>BBarters</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!--css includes.-->
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrapIndex.css')}}" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{asset('css/bootstrap-social.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
	<link href="{{asset('css/pages/index.css')}}" rel="stylesheet" type="text/css" >
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <!--css includes end here.-->

</head>
<!--on hovering anywhere on the page, the default text 'Be-Barters is a social shaing website...' is shown.-->
<body onmouseover="showAbout()">
<div id="main-body">
    @if(Session::has('redirected'))
        <!--session to know whether the page is redirected by 'before'=>'auth'. javascript handles the condition by opening login modal.-->
        <input id="redirected" type="hidden" value="{{Session::get('redirected')}}">
    @endif

    <!--navbar - visible only in mobile view-->
    <nav id="navbar" class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a></a>
                <a id="logo" class="navbar-brand logo" href="#">
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
                @if(Auth::guest())
                    <ul class="nav navbar-nav navbar-right">
                        <li> <a data-toggle="modal" data-target="#loginModal" style="cursor: pointer">Sign In | <img height="15px" width="15px" src="{{asset('Images/icons/twitter.png')}}"> | <img height="15px" width="15px" src="{{asset('Images/icons/facebook.jpg')}}"> | <img height="15px" width="15px" src="{{asset('Images/icons/gmail.jpg')}}"></a></li>
                        <li> <a data-toggle="modal" data-target="#signUpModal" style="cursor: pointer">Sign Up</a></li>
                    </ul>
                @else
                    <ul class="nav navbar-nav navbar-right">
                        <li id="home"> <a href="{{route('home')}}" style="cursor: pointer">Home</a></li>
                        <li id="profile"> <a href="{{route('profile')}}" style="cursor: pointer">{{Auth::user()->first_name}}</a></li>
                        <li id="logOut"> <a href="{{route('signout')}}"style="cursor: pointer">Log Out</a></li>
                    </ul>
                @endif
            </div>
        </div>
    </nav>

    <br>
    <br>
    <br>

    <div class="container" style="display: none">
        @if(Session::has('error'))
            <label class=" col-lg-3"></label>
            <div class="alert alert-info alert-dismissable col-lg-6 sessions">
                <!--session brings back errors, if any during login/signup.-->
                <strong>Attention! </strong> {{Session::get('error')}}.
            </div>
        @endif
        <div id="carousel1" class="carousel slide carousel-fade col-lg-4">
            <div class="carousel-inner">
                <a id="logo2" class="navbar-brand logo">
                    <span class='letter2'>B</span>
                    <span class='letter2'>B</span>
                    <span class='letter2'>a</span>
                    <span class='letter2'>r</span>
                    <span class='letter2'>t</span>
                    <span class='letter2'>e</span>
                    <span class='letter2'>r</span>
                    <span class='letter2'>s</span>
                </a>
                <div class="col-lg-12 tagline"><small><i>Don't be users, be barters.</i></small></div>
                <div class="col-lg-12">&nbsp;</div>

                <br>

                <div class="col-lg-8 col-lg-offset-1">
                    @if (Auth::guest())
                        <a class="btn btn-block btn-social btn-facebook" href='fbauth'>
                            <i class="fa fa-facebook"></i>
                            Sign in with Facebook
                        </a>

                        <a class="btn btn-block btn-social btn-twitter" href='twauth'>
                            <i class="fa fa-twitter"></i>
                            Sign in with Twitter
                        </a>

                        <a class="btn btn-block btn-social btn-google-plus" href='gauth'>
                            <i class="fa fa-google"></i>
                                Sign in with Google
                        </a>

                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12">&nbsp;</div>

                        <a class="entryLinks" data-toggle="modal" data-target="#loginModalDesktop">
                            Sign In
                        </a>
                        |
                        <a class="entryLinks" data-toggle="modal" data-target="#signUpModal">
                            Sign Up
                        </a>
                    @else

                        <h3>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h3>
                        <div class="col-lg-12 noPadding">
                            <a href="{{route('home')}}" class="navLinks"> Home </a>
                            <a href="{{route('profile')}}" class="navLinks lastNavLinks"> Profile </a>
                            <a href="{{route('signout')}}" class="navLinks lastNavLinks"> Logout </a>
                        </div>
                        <br><br>
                        <span>
                            <img src="{{Auth::user()->profile->profilePic}}" height="100" width="100">
                        </span>
                        <br><br>
                    @endif
                </div>

                <div id="tab-info-container" class="col-lg-12" style="padding: 30px">
                    <div role="tabpanel">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist" id="myTab">
                            <li role="presentation"><a href="#create" aria-controls="create" role="tab" data-toggle="tab" onmouseover="showCreate()">Create</a></li>
                            <li role="presentation"><a href="#collaborate" aria-controls="collaborate" role="tab" data-toggle="tab" onmouseover="showCollaborate()">Collaborate</a></li>
                            <li role="presentation"><a href="#converge" aria-controls="converge" role="tab" data-toggle="tab" onmouseover="showConverge()">Converge</a></li>
                            <li role="presentation"><a id="hiddenTabDefault" href="#aboutB2" aria-controls="aboutB2" data-toggle="tab" style="border: none; cursor: context-menu"></a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="aboutB2">
                                <br>
                                Be-Barters is a social sharing platform where information trading is done by means of  <u id="ifc" title="'InfoCurrency' - Our very own term for virtual currency">IFCs</u>
                                <br><br>
                                Everything is free here yet you won't get anything for free!
                            </div>
                            <div role="tabpanel" class="tab-pane" id="create">
                                <br>
                                <span class="glyphicon glyphicon-book"></span> &nbsp;  Create your content with our easy to use templates, maintain a blogbook, or then
                                quiz/poll people.
                                <br><br>
                                <span class="glyphicon glyphicon-transfer"></span> &nbsp;  Many ways to give back to the internet.
                            </div>
                            <div role="tabpanel" class="tab-pane" id="collaborate">
                                <br>
                                <span class="glyphicon glyphicon-pencil"></span>&nbsp;  Create collaborations or contribute into.
                                <br><br>
                                <span class="glyphicon glyphicon-question-sign"></span>&nbsp;  Ask questions, get Answers, opinions.
                                <br><br>
                                <span class="glyphicon glyphicon-usd"></span>&nbsp;  Lend IFCs, subscribe or find your friends. Get social for sharing!
                                </div>
                            <div role="tabpanel" class="tab-pane" id="converge">
                                <br>
                                <ul id="converge-list">
                                    <li class="lists">Content from all genres and domains all at one place.</li>
                                    <br>
                                    <li class="lists">Your own webspace,search and share alike.</li>
                                    <br>
                                    <li class="lists">All your information needs served under one roof.</li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!--<span id="take-a-tour" class=" col-lg-11 col-lg-offset-1" onclick="initiateTour()">
                Take a tour  <i class="fa fa-plane"></i>
            </span>-->

        </div>

        <div id="carousel2" class="carousel slide carousel-fade col-lg-4">
            <div class="carousel-inner">
                <?php $i=0; ?>
                @foreach ($trending as $tr)
                    <?php $i++; ?>
                    @if ($i == 1)
                        <div class="item active">
                    @else
                        <div class="item">
                    @endif

                    <div style="height: 52.5%">
                        @if ($tr->trivia)
                            <img class="col-lg-12 carousel2Image" src="{{asset($tr->cover)}}" onclick="openMedia({{$tr->id}})" style="height: 100%; padding: 0px; cursor: pointer">
                        @elseif ($tr->path)
                            <img class="col-lg-12 carousel2Image" src="{{asset('Images/Resource.jpg')}}" onclick="openResource({{$tr->id}})" style="height: 100%; padding: 0px; cursor: pointer">
                        @elseif ($tr->text)
                            <img class="col-lg-12 carousel2Image" src="{{asset($tr->cover)}}" onclick="openArticle({{$tr->id}})" style="height: 100%; padding: 0px; cursor: pointer">
                        @elseif ($tr->review)
                            <img class="col-lg-12 carousel2Image" src="{{asset($tr->cover)}}" onclick="openBook({{$tr->id}})" style="height: 100%; padding: 0px; cursor: pointer">
                        @else
                            <img class="col-lg-12 carousel2Image" src="{{asset($tr->cover)}}" onclick="openCollab({{$tr->id}})" style="height: 100%; padding: 0px; cursor: pointer">
                        @endif
                    </div>
                    <div style="min-height: 47.5%;">
                        <div class="slidePara noOverflow">
                            <div style="overflow: hidden; position: absolute">
                                @if ($tr->trivia)
                                    <h2 class="noOverflow" onclick="openMedia({{$tr->id}})" style="cursor: pointer">{{$tr->title}}</h2>
                                @elseif ($tr->text)
                                    <h2 class="noOverflow" onclick="openArticle({{$tr->id}})" style="cursor: pointer">{{$tr->title}}</h2>
                                @elseif ($tr->review)
                                    <h2 class="noOverflow" onclick="openBook({{$tr->id}})" style="cursor: pointer">{{$tr->title}}</h2>
                                @elseif ($tr->path)
                                    <h2 class="noOverflow" onclick="openResource({{$tr->id}})" style="cursor: pointer">{{$tr->title}}</h2>
                                @else
                                    <h2 class="noOverflow" onclick="openCollab({{$tr->id}})" style="cursor: pointer">{{$tr->title}}</h2>
                                @endif

                                @if ($tr->trivia)
                                    <div class="description">{{{$tr->trivia}}}</div>
                                @else
                                    <div class="description">{{{$tr->description}}}</div>
                                @endif
                            </div>
                            <div style="position: absolute; bottom: 0px; background-color: #ffffff; width: 100%">
                            <a href="{{route('user',User::find($tr->userid)->username)}}" style="text-decoration: none; color: #002166" target="_blank"><i>- {{Str::upper(User::find($tr->userid)->first_name)}} {{Str::upper(User::find($tr->userid)->last_name)}}</i></a>
                            @if ($tr->trivia)
                                <p>{{$tr->users}} Views | {{$tr->ifc}} IFCs</p>
                                <a class="links" href="{{route('mediaPreview',$tr->id)}}">Watch Media <img src="{{asset('Images/icons/media.png')}}"></a>
                            @elseif ($tr->path)
                                <p>{{$tr->users}} Downloads | {{$tr->ifc}} IFCs</p>
                                <a class="links" href="{{route('resource',$tr->id)}}">Download Resource <img src="{{asset('Images/icons/download.png')}}"></a>
                            @else
                                <p>{{$tr->users}} Readers | {{$tr->ifc}} IFCs</p>
                                @if ($tr->text)
                                    <a class="links" href="{{route('articlePreview',$tr->id)}}">Read {{$tr->type}} <img src="{{asset('Images/icons/article.png')}}"></a>
                                @elseif ($chapters = $tr->getChapters()->get())
                                    @if ($chapters[0]->bookid)
                                    <a class="links" href="{{route('blogBookPreview',$tr->id)}}">Read Book <img src="{{asset('Images/icons/book.png')}}"></a>
                                    @elseif ($chapters[0]->collaborationid)
                                    <a class="links" href="{{route('collaborationPreview',$tr->id)}}">Read Collaboration <img src="{{asset('Images/icons/book.png')}}"></a>
                                    @endif
                                @endif
                            @endif
                            </div>
                        </div>
                    </div>
                    </div>
                @endforeach
            </div>
            <div style="height: 5%">
                <ul class="carousel-indicators pull-right" style="left: auto; list-style-type: none">
                    @for ($contentC = 0; $contentC < $i; $contentC++)
                        <?php
                            if ($contentC == 0)
                                $extraClass = 'active';
                           else
                                $extraClass = '';
                         ?>
                        <li data-target="#carousel2" data-slide-to="{{$contentC}}" class="bottom-boxes {{$extraClass}}"></li>
                    @endfor
                </ul>
            </div>
        </div>

        <div id="carousel3" class="carousel slide carousel-fade col-lg-4">
            <div class="carousel-inner">
                <?php $i=0; ?>
                @foreach ($recommended as $rc)
                    <?php $i++; ?>
                    @if ($i == 1)
                        <div class="item active">
                    @else
                        <div class="item">
                    @endif
                    <div style="height: 52.5%;">
                        @if ($rc->path)
                        <img class="col-lg-12 carousel3Image" onclick="openResource({{$rc->id}})" src="{{asset('Images/Resource.jpg')}}" style="height: 100%; padding: 0px; cursor: pointer">
                        @elseif ($rc->text)
                        <img class="col-lg-12 carousel3Image" onclick="openArticle({{$rc->id}})" src="{{asset($rc->cover)}}" style="height: 100%; padding: 0px; cursor: pointer">
                        @elseif ($rc->review)
                        <img class="col-lg-12 carousel3Image" onclick="openBook({{$rc->id}})" src="{{asset($rc->cover)}}" style="height: 100%; padding: 0px; cursor: pointer">
                        @else
                        <img class="col-lg-12 carousel3Image" onclick="openCollab({{$rc->id}})" src="{{asset($rc->cover)}}" style="height: 100%; padding: 0px; cursor: pointer">
                        @endif
                    </div>
                    <div style="min-height: 47.5%;">
                        <div class="slidePara noOverflow">
                            <div style="overflow: hidden; position: absolute">
                                @if ($rc->path)
                                <h2 class="noOverflow" onclick="openResource({{$rc->id}})" style="cursor: pointer">{{$rc->title}}</h2>
                                @elseif ($rc->text)
                                <h2 class="noOverflow" onclick="openArticle({{$rc->id}})" style="cursor: pointer">{{$rc->title}}</h2>
                                @elseif ($rc->review)
                                <h2 class="noOverflow" onclick="openBook({{$rc->id}})" style="cursor: pointer">{{$rc->title}}</h2>
                                @else
                                <h2 class="noOverflow" onclick="openCollab({{$rc->id}})" style="cursor: pointer">{{$rc->title}}</h2>
                                @endif
                                <div class="description">{{{$rc->description}}}</div>
                            </div>
                            <div style="position: absolute; bottom: 0px; background-color: #ffffff; width: 100%">
                                <a href="{{route('user',User::find($rc->userid)->username)}}" style="text-decoration: none; color: #002166" target="_blank"><i>- {{Str::upper(User::find($rc->userid)->first_name)}} {{Str::upper(User::find($rc->userid)->last_name)}}</i></a>
                                <p>{{$rc->users}} Readers | {{$rc->ifc}} IFCs</p>
                                @if ($rc->text)
                                    <a class="links" href="{{route('articlePreview',$rc->id)}}">Read {{$rc->type}} <img src="{{asset('Images/icons/article.png')}}"></a>
                                @elseif ($rc->chapters)
                                    <a class="links" href="{{route('blogBookPreview',$rc->id)}}">Read Book <img src="{{asset('Images/icons/book.png')}}"></a>
                                @endif
                            </div>
                        </div>
                    </div>
                    </div>
                @endforeach
            </div>
            <div style="height: 5%">
                <ul class="carousel-indicators pull-right" style="left: auto; list-style-type: none">
                    @for ($contentC = 0; $contentC < $i; $contentC++)
                        <?php
                            if ($contentC == 0)
                                $extraClass = 'active';
                           else
                                $extraClass = '';
                         ?>
                        <li data-target="#carousel3" data-slide-to="{{$contentC}}" class="bottom-boxes {{$extraClass}}"></li>
                    @endfor
                </ul>
            </div>
        </div>
    </div>

    <!--modals-->
	<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Sign In</h4>
				</div>

				<div class="modal-body">
					{{Form::open(array('route'=>'login','id'=>'loginForm','class'=>'form-horizontal'))}}

                    <fieldset>
						<div class="form-group">
							<label class="col-lg-3 control-label"></label>
							<div class="col-lg-5">

                                <a class="btn btn-block btn-social btn-facebook" href='fbauth'>
                                    <i class="fa fa-facebook"></i>
                                    Sign in with Facebook
                                </a>

                                <a class="btn btn-block btn-social btn-twitter" href='twauth'>
                                    <i class="fa fa-twitter"></i>
                                    Sign in with Twitter
                                </a>

                                <a class="btn btn-block btn-social btn-google-plus" href='gauth'>
                                    <i class="fa fa-google"></i>
                                    Sign in with Google
                                </a>
                                <hr>
							</div>
						</div>

                    <div id="loginLink" class="col-lg-12">
                        <p id="regular-login" class=" col-lg-5 col-lg-offset-3" onclick="showLoginBlock()">Regular Login</p>
                    </div>
                </fieldset>

                <fieldset id="loginBlock" style="display: none">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Username</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="uname"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Password</label>
                        <div class="col-lg-5">
                            <input type="password" class="form-control" name="pwd" />
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0px">
                        <label class="col-lg-3 control-label"></label>
                        <div class="col-lg-5">
                            <div class="col-lg-5" style="padding: 0px">
                                <button type="submit" class="btn btn-success">Login</button>
                            </div>
                            <div class="col-lg-7" style="padding: 0px">
                                <a data-toggle="modal" data-target="#forgotPasswordModal" style="text-decoration: none; cursor: pointer; padding: 6px" class="pull-right">Forgot Password</a>
                            </div>
                        </div>
                    </div>
                </fieldset>
			    {{Form::close()}}

				</div>

			</div>
		</div>
	</div>

    <div class="modal fade" id="loginModalDesktop" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Sign In</h4>
                </div>

                <div class="modal-body">
                    {{Form::open(array('route'=>'login','id'=>'loginFormDesktop','class'=>'form-horizontal'))}}

                    <fieldset id="loginBlock"">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Username</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="uname"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Password</label>
                            <div class="col-lg-5">
                                <input type="password" class="form-control" name="pwd" />
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 0px">
                            <label class="col-lg-3 control-label"></label>
                            <div class="col-lg-5">
                                <div class="col-lg-5" style="padding: 0px">
                                    <button type="submit" class="btn btn-success">Login</button>
                                </div>
                                <div class="col-lg-7" style="padding: 0px">
                                    <a data-toggle="modal" data-target="#forgotPasswordModal" style="text-decoration: none; cursor: pointer; padding: 6px" class="pull-right">Forgot Password</a>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    {{Form::close()}}

                </div>

            </div>
        </div>
    </div>

	<div class="modal fade" id="signUpModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4>Sign Up</h4>

				</div>

				<div class="modal-body">

				{{Form::open(array('route'=>'signup','id'=>'signupForm','class'=>'form-horizontal'))}}
						<fieldset>

                        <div class="col-lg-12 socialLogin">
                            <div class="col-lg-5 col-lg-offset-1">
                                <a class="btn btn-block btn-social btn-facebook" href='fbauth'>
                                    <i class="fa fa-facebook"></i>
                                    Sign in with Facebook
                                </a>
                            </div>
                            <div class="col-lg-5">
                                <a class="btn btn-block btn-social btn-twitter" href='twauth'>
                                    <i class="fa fa-twitter"></i>
                                    Sign in with Twitter
                                </a>
                            </div>
                            <div class="col-lg-5">
                                <a class="btn btn-block btn-social btn-google-plus" href='gauth'>
                                    <i class="fa fa-google"></i>
                                    Sign in with Google
                                </a>
                            </div>
                            <br>
                            <hr>
                        </div>

							<div class="form-group">
								<label class="col-lg-3 control-label">Username</label>
								<div class="col-lg-5">
									<input type="text" class="form-control" name="username" id="username" onblur="checkUname()" />

								</div>
								<label class="col-lg-4 control-label" id="uerror"></label>

							</div>

							<div class="form-group">
								<label class="col-lg-3 control-label">Fullname</label>
								<div class="col-lg-5">
									<input type="text" class="form-control" name="firstname" placeholder="First Name" />
							</div>
								<div class="col-lg-4">
									<input type="text" class="form-control" name="lastname" placeholder="Last Name" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">Country</label>
								<div class="col-lg-5">
									<select class="form-control" name="country">
										<option value="">-- Select a country --</option>
										<option value="Afganistan">Afghanistan</option>
										<option value="Albania">Albania</option>
										<option value="Algeria">Algeria</option>
										<option value="American Samoa">American Samoa</option>
										<option value="Andorra">Andorra</option>
										<option value="Angola">Angola</option>
										<option value="Anguilla">Anguilla</option>
										<option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
										<option value="Argentina">Argentina</option>
										<option value="Armenia">Armenia</option>
										<option value="Aruba">Aruba</option>
										<option value="Australia">Australia</option>
										<option value="Austria">Austria</option>
										<option value="Azerbaijan">Azerbaijan</option>
										<option value="Bahamas">Bahamas</option>
										<option value="Bahrain">Bahrain</option>
										<option value="Bangladesh">Bangladesh</option>
										<option value="Barbados">Barbados</option>
										<option value="Belarus">Belarus</option>
										<option value="Belgium">Belgium</option>
										<option value="Belize">Belize</option>
										<option value="Benin">Benin</option>
										<option value="Bermuda">Bermuda</option>
										<option value="Bhutan">Bhutan</option>
										<option value="Bolivia">Bolivia</option>
										<option value="Bonaire">Bonaire</option>
										<option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
										<option value="Botswana">Botswana</option>
										<option value="Brazil">Brazil</option>
										<option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
										<option value="Brunei">Brunei</option>
										<option value="Bulgaria">Bulgaria</option>
										<option value="Burkina Faso">Burkina Faso</option>
										<option value="Burundi">Burundi</option>
										<option value="Cambodia">Cambodia</option>
										<option value="Cameroon">Cameroon</option>
										<option value="Canada">Canada</option>
										<option value="Canary Islands">Canary Islands</option>
										<option value="Cape Verde">Cape Verde</option>
										<option value="Cayman Islands">Cayman Islands</option>
										<option value="Central African Republic">Central African Republic</option>
										<option value="Chad">Chad</option>
										<option value="Channel Islands">Channel Islands</option>
										<option value="Chile">Chile</option>
										<option value="China">China</option>
										<option value="Christmas Island">Christmas Island</option>
										<option value="Cocos Island">Cocos Island</option>
										<option value="Colombia">Colombia</option>
										<option value="Comoros">Comoros</option>
										<option value="Congo">Congo</option>
										<option value="Cook Islands">Cook Islands</option>
										<option value="Costa Rica">Costa Rica</option>
										<option value="Cote DIvoire">Cote D'Ivoire</option>
										<option value="Croatia">Croatia</option>
										<option value="Cuba">Cuba</option>
										<option value="Curaco">Curacao</option>
										<option value="Cyprus">Cyprus</option>
										<option value="Czech Republic">Czech Republic</option>
										<option value="Denmark">Denmark</option>
										<option value="Djibouti">Djibouti</option>
										<option value="Dominica">Dominica</option>
										<option value="Dominican Republic">Dominican Republic</option>
										<option value="East Timor">East Timor</option>
										<option value="Ecuador">Ecuador</option>
										<option value="Egypt">Egypt</option>
										<option value="El Salvador">El Salvador</option>
										<option value="Equatorial Guinea">Equatorial Guinea</option>
										<option value="Eritrea">Eritrea</option>
										<option value="Estonia">Estonia</option>
										<option value="Ethiopia">Ethiopia</option>
										<option value="Falkland Islands">Falkland Islands</option>
										<option value="Faroe Islands">Faroe Islands</option>
										<option value="Fiji">Fiji</option>
										<option value="Finland">Finland</option>
										<option value="France">France</option>
										<option value="French Guiana">French Guiana</option>
										<option value="French Polynesia">French Polynesia</option>
										<option value="French Southern Ter">French Southern Ter</option>
										<option value="Gabon">Gabon</option>
										<option value="Gambia">Gambia</option>
										<option value="Georgia">Georgia</option>
										<option value="Germany">Germany</option>
										<option value="Ghana">Ghana</option>
										<option value="Gibraltar">Gibraltar</option>
										<option value="Great Britain">Great Britain</option>
										<option value="Greece">Greece</option>
										<option value="Greenland">Greenland</option>
										<option value="Grenada">Grenada</option>
										<option value="Guadeloupe">Guadeloupe</option>
										<option value="Guam">Guam</option>
										<option value="Guatemala">Guatemala</option>
										<option value="Guinea">Guinea</option>
										<option value="Guyana">Guyana</option>
										<option value="Haiti">Haiti</option>
										<option value="Hawaii">Hawaii</option>
										<option value="Honduras">Honduras</option>
										<option value="Hong Kong">Hong Kong</option>
										<option value="Hungary">Hungary</option>
										<option value="Iceland">Iceland</option>
										<option value="India">India</option>
										<option value="Indonesia">Indonesia</option>
										<option value="Iran">Iran</option>
										<option value="Iraq">Iraq</option>
										<option value="Ireland">Ireland</option>
										<option value="Isle of Man">Isle of Man</option>
										<option value="Israel">Israel</option>
										<option value="Italy">Italy</option>
										<option value="Jamaica">Jamaica</option>
										<option value="Japan">Japan</option>
										<option value="Jordan">Jordan</option>
										<option value="Kazakhstan">Kazakhstan</option>
										<option value="Kenya">Kenya</option>
										<option value="Kiribati">Kiribati</option>
										<option value="Korea North">Korea North</option>
										<option value="Korea Sout">Korea South</option>
										<option value="Kuwait">Kuwait</option>
										<option value="Kyrgyzstan">Kyrgyzstan</option>
										<option value="Laos">Laos</option>
										<option value="Latvia">Latvia</option>
										<option value="Lebanon">Lebanon</option>
										<option value="Lesotho">Lesotho</option>
										<option value="Liberia">Liberia</option>
										<option value="Libya">Libya</option>
										<option value="Liechtenstein">Liechtenstein</option>
										<option value="Lithuania">Lithuania</option>
										<option value="Luxembourg">Luxembourg</option>
										<option value="Macau">Macau</option>
										<option value="Macedonia">Macedonia</option>
										<option value="Madagascar">Madagascar</option>
										<option value="Malaysia">Malaysia</option>
										<option value="Malawi">Malawi</option>
										<option value="Maldives">Maldives</option>
										<option value="Mali">Mali</option>
										<option value="Malta">Malta</option>
										<option value="Marshall Islands">Marshall Islands</option>
										<option value="Martinique">Martinique</option>
										<option value="Mauritania">Mauritania</option>
										<option value="Mauritius">Mauritius</option>
										<option value="Mayotte">Mayotte</option>
										<option value="Mexico">Mexico</option>
										<option value="Midway Islands">Midway Islands</option>
										<option value="Moldova">Moldova</option>
										<option value="Monaco">Monaco</option>
										<option value="Mongolia">Mongolia</option>
										<option value="Montserrat">Montserrat</option>
										<option value="Morocco">Morocco</option>
										<option value="Mozambique">Mozambique</option>
										<option value="Myanmar">Myanmar</option>
										<option value="Nambia">Nambia</option>
										<option value="Nauru">Nauru</option>
										<option value="Nepal">Nepal</option>
										<option value="Netherland Antilles">Netherland Antilles</option>
										<option value="Netherlands">Netherlands (Holland, Europe)</option>
										<option value="Nevis">Nevis</option>
										<option value="New Caledonia">New Caledonia</option>
										<option value="New Zealand">New Zealand</option>
										<option value="Nicaragua">Nicaragua</option>
										<option value="Niger">Niger</option>
										<option value="Nigeria">Nigeria</option>
										<option value="Niue">Niue</option>
										<option value="Norfolk Island">Norfolk Island</option>
										<option value="Norway">Norway</option>
										<option value="Oman">Oman</option>
										<option value="Pakistan">Pakistan</option>
										<option value="Palau Island">Palau Island</option>
										<option value="Palestine">Palestine</option>
										<option value="Panama">Panama</option>
										<option value="Papua New Guinea">Papua New Guinea</option>
										<option value="Paraguay">Paraguay</option>
										<option value="Peru">Peru</option>
										<option value="Phillipines">Philippines</option>
										<option value="Pitcairn Island">Pitcairn Island</option>
										<option value="Poland">Poland</option>
										<option value="Portugal">Portugal</option>
										<option value="Puerto Rico">Puerto Rico</option>
										<option value="Qatar">Qatar</option>
										<option value="Republic of Montenegro">Republic of Montenegro</option>
										<option value="Republic of Serbia">Republic of Serbia</option>
										<option value="Reunion">Reunion</option>
										<option value="Romania">Romania</option>
										<option value="Russia">Russia</option>
										<option value="Rwanda">Rwanda</option>
										<option value="St Barthelemy">St Barthelemy</option>
										<option value="St Eustatius">St Eustatius</option>
										<option value="St Helena">St Helena</option>
										<option value="St Kitts-Nevis">St Kitts-Nevis</option>
										<option value="St Lucia">St Lucia</option>
										<option value="St Maarten">St Maarten</option>
										<option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
										<option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
										<option value="Saipan">Saipan</option>
										<option value="Samoa">Samoa</option>
										<option value="Samoa American">Samoa American</option>
										<option value="San Marino">San Marino</option>
										<option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
										<option value="Saudi Arabia">Saudi Arabia</option>
										<option value="Senegal">Senegal</option>
										<option value="Serbia">Serbia</option>
										<option value="Seychelles">Seychelles</option>
										<option value="Sierra Leone">Sierra Leone</option>
										<option value="Singapore">Singapore</option>
										<option value="Slovakia">Slovakia</option>
										<option value="Slovenia">Slovenia</option>
										<option value="Solomon Islands">Solomon Islands</option>
										<option value="Somalia">Somalia</option>
										<option value="South Africa">South Africa</option>
										<option value="Spain">Spain</option>
										<option value="Sri Lanka">Sri Lanka</option>
										<option value="Sudan">Sudan</option>
										<option value="Suriname">Suriname</option>
										<option value="Swaziland">Swaziland</option>
										<option value="Sweden">Sweden</option>
										<option value="Switzerland">Switzerland</option>
										<option value="Syria">Syria</option>
										<option value="Tahiti">Tahiti</option>
										<option value="Taiwan">Taiwan</option>
										<option value="Tajikistan">Tajikistan</option>
										<option value="Tanzania">Tanzania</option>
										<option value="Thailand">Thailand</option>
										<option value="Togo">Togo</option>
										<option value="Tokelau">Tokelau</option>
										<option value="Tonga">Tonga</option>
										<option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
										<option value="Tunisia">Tunisia</option>
										<option value="Turkey">Turkey</option>
										<option value="Turkmenistan">Turkmenistan</option>
										<option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
										<option value="Tuvalu">Tuvalu</option>
										<option value="Uganda">Uganda</option>
										<option value="Ukraine">Ukraine</option>
										<option value="United Arab Erimates">United Arab Emirates</option>
										<option value="United Kingdom">United Kingdom</option>
										<option value="United States of America">United States of America</option>
										<option value="Uraguay">Uruguay</option>
										<option value="Uzbekistan">Uzbekistan</option>
										<option value="Vanuatu">Vanuatu</option>
										<option value="Vatican City State">Vatican City State</option>
										<option value="Venezuela">Venezuela</option>
										<option value="Vietnam">Vietnam</option>
										<option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
										<option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
										<option value="Wake Island">Wake Island</option>
										<option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
										<option value="Yemen">Yemen</option>
										<option value="Zaire">Zaire</option>
										<option value="Zambia">Zambia</option>
										<option value="Zimbabwe">Zimbabwe</option>
									</select>
								</div>
							</div>


                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email address</label>
                            <div class="col-lg-5">
                                <input type="text" id="email" class="form-control" name="email" autocomplete="off" onblur="checkEmail()" />
                            </div>
                            <label class="col-lg-4 control-label" id="merror"></label>
                        </div>

							<div class="form-group">
								<label class="col-lg-3 control-label">Password</label>
								<div class="col-lg-5">
									<input type="password" class="form-control" name="password" autocomplete="off" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-3 control-label">Retype password</label>
								<div class="col-lg-5">
									<input type="password" class="form-control" name="cpassword" />
								</div>
							</div>

							<div class="form-group">
								<label id="genderLabel" class="col-lg-3 control-label">Gender</label>

								<div class="btn-group col-lg-5" data-toggle-name="gender" data-toggle="buttons-radio">
									<button type="button" value="male" id="male" class="btn btn-primary" data-toggle="button">Male</button>
									<button type="button" value="female" id="female" class="btn btn-primary" data-toggle="button">Female</button>
									<button type="button" value="other" id="other" class="btn btn-primary" data-toggle="button">Other</button>
								</div>

                                <small class="genderError col-lg-4"></small>

								<input type="hidden" id="gender" name="gender" value="0" />
							</div>

							<div class="form-group">
								<label class="col-lg-3 control-label">Type Captcha</label>
								<div class="col-lg-5">
									<input type="text" class="form-control" name="captcha" onfocus="checkGender()"/>
								</div>
								<div class="col-lg-4">
									<img src="{{$cap}}">
								</div>

							</div>

							<div class="form-group">
								<div class="col-lg-5 col-lg-offset-3">
									<div class="checkbox">
										<input type="checkbox" name="acceptTerms" /> Accept the <a href="#" style="text-decoration: none" data-toggle="modal" data-target="#termsAndConditions">Terms and Policies</a>
									</div>
								</div>
							</div>

						</fieldset>

						<div class="form-group">
							<div class="col-lg-9 col-lg-offset-3">
								<button id="signUpSubmit" type="submit" class="btn btn-primary" >Submit</button>
							</div>
						</div>

					{{Form::close()}}

				</div>

			</div>
		</div>
	</div>

    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog col-lg-6 col-lg-offset-3" style="min-height: 50%; margin-left: 30%">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Forgot Password</h4>
                </div>

                <div class="modal-body">
                    {{Form::open(array('id'=>'forgotPasswordForm','class'=>'form-horizontal'))}}
                    <fieldset id="fpbody">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Username</label>
                            <div class="col-lg-5">
                                <input type="text" id="fpusername" class="form-control" name="username"/>
                            </div>
                            <div class="col-lg-4">
                                <a data-toggle="modal" data-target="#forgotUsernameModal" style="cursor: pointer">Forgot username?</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email address</label>
                            <div class="col-lg-5">
                                <input type="text" id="fpemail" class="form-control" name="email" autocomplete="off" />
                            </div>
                        </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label"></label>
                        <div class="col-lg-5">
                            <button id="forgotPasswordSubmit" type="submit" class="btn btn-primary" onclick="forgotPassword()" style="height:27px; margin-top: 0px;padding-top: 3px">Submit</button>
                            <div id="waitingImg" style="display: none">
                            <img src="{{asset('Images/icons/waiting.gif')}}">Loading..
                             </div>
                        </div>
                    </div>

                    {{Form::close()}}

                        <div id="secretCode" class="col-lg-6 col-lg-offset-3 well fpDivs" style="display: none">
                            <div id="secretCodeContent">

                                    <div class="col-lg-12">&nbsp;</div>
                                    Please enter the 8-digit code that has been sent to your email.
                                    <div class="col-lg-12">&nbsp;</div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Code</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="sC" class="form-control" name="sC"/>
                                        </div>
										<div id="SCerror" class="col-lg-9" style="color: darkred; text-align: center; display: none">
											<strong>The code didn't match</strong>
										</div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-5">
                                            <button id="resetPassword" type="button" class="btn btn-primary" onclick="showResetPassword()" style="height:27px; margin-top: 0px; padding-top: 3px">Proceed</button>
                                        </div>
                                    </div>

                            </div>
                        </div>

                    <div id="rPassword" class="col-lg-12 fpDivs" style="display: none">
                        <div id="rPasswordContent">

                                <div class="col-lg-12">&nbsp;</div>
                                Code Checked! Reset your password.
                                <div class="col-lg-12">&nbsp;</div>

                                <form id="rPasswordForm" class="form-horizontal">

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Password</label>
                                        <div class="col-lg-5">
                                            <input id="rPasswordPassword" type="password" class="form-control" name="rPasswordPassword" autocomplete="off" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Retype password</label>
                                        <div class="col-lg-5">
                                            <input id="rPasswordCPassword" type="password" class="form-control" name="rPasswordCPassword" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-5">
                                            <button id="rPasswordSubmit" type="submit" class="btn btn-primary" onclick="postResetPassword()" style="height:27px; margin-top: 0px;padding-top: 3px">Reset Password</button>
                                        </div>
                                    </div>

                                </form>

                        </div>
                    </div>

            <div id="foreignUserError" class="col-lg-6 col-lg-offset-3 well fpDivs" style="display: none">
                <div id="foreignUserErrorContent">

                </div>
            </div>

                    </fieldset>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="termsAndConditions" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">TERMS AND CONDITIONS</h4>
                </div>
                <div class="modal-body">
                    <fieldset>
                        <p>
                            These are standard rules about posting content on b2.com, through it on facebook,twitter and other social networking sites.
                            They are designed to ensure users feel safe, keen to take part again and keep to its focus.

                        <h4>General Rules</h4>
                        Debate should be lively but also constructive and respectful.
                        Don't incite hatred on the basis of race, religion, gender, nationality or sexuality or other personal characteristic.
                        Don't swear, use hate-speech or make obscene or vulgar comments.
                        Don't break the law. This includes libel, condoning illegal activity and contempt of court (comments which might affect the outcome of an approaching court case).
                        Don't engage in 'spamming'. Don’t advertise products or services.
                        Don't impersonate or falsely claim to represent a person or organisation.
                        Protect your privacy and that of others. Please don’t post private addresses, phone numbers, email addresses or other online contact details.
                        Stay on-topic. Please don't post messages that are unrelated to the topic.
                        Comments/Content/Views on b2.com are moderated before going live. If a comment contravenes the safety rules it will not be published or will be removed from the site.

                        <h3>Content disclaimer</h3>

                        Views expressed by users are theirs alone and do not represent the views of b2.com.

                        <h3>Copyright and neighbouring rights</h3>

                        You own the copyright in your postings, articles and pictures, but you also agree to grant b2.com a perpetual, royalty-free, non-exclusive, sublicenseable right and license to use, reproduce, modify, adapt, publish, translate, create derivative works from, distribute, perform, play, and exercise all copyright and publicity rights with respect to any such work worldwide and/or to incorporate it in other works in any media now known or later developed for the full term of any rights that may exist in such content.
                        If you do not wish to grant such rights to the b2.com, it is suggested that you do not submit your comment to this site.

                        You should remember that you are legally responsible for what you write. By submitting any content you undertake to indemnify the b2.com against any liability arising from breach of confidentiality or copyright, or any obscene, defamatory, seditious, blasphemous or other actionable statement you may make.
                        The copying and use of the b2.com logo and other b2.com-related logos is not permitted without prior approval of the b2.com.

                        <h3>Virus protection</h3>

                        The site operators make every effort to check and test material at all stages of production. It is always wise for users to run an anti virus program on all material downloaded from the internet.
                        b2.com cannot accept any responsibility for any loss, disruption or damage to your data or your computer system which may occur whilst using material from the b2.com website.

                        <h3>Your privacy</h3>

                        Cookies are pieces of data that are often created when you visit a website and are stored in the cookie directory of your own computer.
                        Cookies are used to store a session ID which allows you to log-in and make comments. No personal information is stored in the Cookie.
                        Other websites linked from this site are not covered by this privacy policy.
                        b2.com does require a user to enter a name and working email address in order to post a comment on this blog. This information is securely stored and will not be passed on to any third parties.

                        <h3>Links to and from other websites</h3>

                        b2.com is not responsible for the contents or reliability of the external websites and does not necessarily endorse the views expressed within them.
                        Links to external sites should not be taken as endorsement of any kind. We cannot guarantee that these links will work all of the time and we have no control over the availability of the linked pages.
                        b2.com encourages users to establish hypertext links to the site. You do not have to ask permission to link directly to pages hosted on the website. We do not object to you linking directly to our information, but you should obtain permission if you intend to use our logo.
                        </p>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>

        <div class="modal fade col-lg-12" id="forgotUsernameModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="margin-left: 35%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Forgot username</h4>
                    </div>
                    <div class="modal-body">
                        <fieldset>
                            <form id="forgotUsernameForm">
                                <div class="form-group">
                                    <input id="forgotUsernameEmail" name="forgotUsernameEmail" class="form-control" placeholder="Enter your E-mail ID">
                                </div>
                                <br>
                                Your username will be mailed to your mailbox.
                                <br><br>
                                <button type="submit" id="forgotUsernameSubmit" class="btn btn-primary" onclick="submitForgotUsername()">Submit</button>
                            </form>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>

    <input type="hidden" id="refreshed" value="no">
    <script src="{{asset('js/reload.js')}}"></script>

	<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
	<script src="{{asset('js/bootstrap.js')}}"></script>
	<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
	<script src="{{asset('js/bootbox.js')}}"></script>
	<script src="{{asset('js/pages/indexPage.js')}}"></script>

</div>
<div id="tour-body" class="sub-bodies">
    <img id="back-image" src="{{asset('Images/3.jpg')}}">
    <div id="BBarters">
        <a id="logo3" class="navbar-brand logo">
            <span class='letter3'>B</span>
            <span class='letter3'>B</span>
            <span class='letter3'>a</span>
            <span class='letter3'>r</span>
            <span class='letter3'>t</span>
            <span class='letter3'>e</span>
            <span class='letter3'>r</span>
            <span class='letter3'>s</span>
        </a>
        <br><br>
        <div><small><i>Don't be users, be barters.</i></small></div>
        <br>
        <button class="btn-success col-lg-12" onclick="startTour()">Start Tour</button>
        <br><br>
        <button class="btn-danger col-lg-12" onclick="backtotop()">Take me home</button>
    </div>
</div>
<div id="main-tour-body" class="sub-bodies">
    <div class="col-lg-12" style="margin-top: 5%">
        <div class="col-lg-2 sideBars">
            <div class="col-lg-12">
                <button class="col-lg-12 btn navbar-btn" name="1">Add Friend</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                <button class="col-lg-12 btn btn-primary disabled" name="2">Subscribe</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                <button class="col-lg-12 btn navbar-btn disabled" name="3">Transfer IFCs</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                <button class="col-lg-12 btn btn-primary disabled" name="4">Invite People</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                <button class="col-lg-12 btn navbar-btn disabled" name="5">Chat</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                <button class="col-lg-12 btn btn-primary disabled" name="6">Notifications</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                <button class="col-lg-12 btn navbar-btn disabled" name="7">Search</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                <button class="col-lg-12 btn btn-primary disabled" name="8">Social Share</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                <button class="col-lg-12 btn navbar-btn disabled" name="9">Settings</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                <button class="col-lg-12 btn btn-primary disabled" name="10">Block/Unfriend</button>
            </div>
        </div>
        <div class="col-lg-8">
            <video id="tourVideo" controls width="100%" height="550px">

            </video>
        </div>
        <div class="col-lg-2 pull-right">
            <div class="col-lg-12">
                <button class="col-lg-12 btn navbar-btn" id="1" name="11" onclick="showTour(this)">Basic Intro</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                <button class="col-lg-12 btn btn-primary disabled" id="2" name="12" onclick="showTour(this)">Getting In</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                <button class="col-lg-12 btn navbar-btn disabled" id="3" name="13" onclick="showTour(this)">Homepage</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                <button class="col-lg-12 btn btn-primary disabled" id="4" name="14" onclick="showTour(this)">Write</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                <button class="col-lg-12 btn navbar-btn disabled" id="5" name="15" onclick="showTour(this)">My Reads</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                <button class="col-lg-12 btn btn-primary disabled" id="6" name="16" onclick="showTour(this)">Polls/Quiz</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                <button class="col-lg-12 btn navbar-btn disabled" id="7" name="17" onclick="showTour(this)">Downloads</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                <button class="col-lg-12 btn btn-primary disabled" name="18">Media</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                <button class="col-lg-12 btn navbar-btn disabled" name="19">Templates</button>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                <button class="col-lg-12 btn btn-primary disabled" name="20">Interests</button>
            </div>
        </div>
        <div id="exitTour" class="btn btn-default col-lg-1" onclick="backtotop()"><span class="glyphicon glyphicon-chevron-up"></span> Exit Tour</div>
        <div id="takeBBartersQuiz" class="btn btn-default col-lg-2"> Take BBarters Quiz</div>
    </div>
</div>
</body>
</html>