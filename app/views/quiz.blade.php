<!DOCTYPE html>
<html>
<head>
    <title>
        Quiz: {{$quiz->title}} | BBarters
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/waiting.css')}}" rel="stylesheet">

    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
</head>
<body style="font-family: 'Segoe UI'">
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=431744100304343&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

@include('navbar')

<br>
<br>
<br>

<input id="tottime" type="hidden" value="{{$quiz->time}}">

<div class="col-lg-2" style="text-align: center">
    <h5>You Have</h5> <p id="timer" style="color:blue; margin: 10px; font-size: 40px"></p> <h5> Seconds to solve the quiz</h5>
</div>

<div class="col-lg-8">
    <div class="col-lg-8 col-lg-offset-2">
        <input type="hidden" id="quizId" value="{{$quiz->id}}">
        <h3>{{$quiz->title}}</h3>
        <blockquote>{{$quiz->description}}</blockquote>
        <div class="col-lg-3">
            <strong>Category: </strong>
            <p>{{Interest::find($quiz->category)->interest_name}}</p>
        </div>
        <div class="col-lg-6">
            <strong>Created By: </strong>
            <p>{{User::find($quiz->ownerid)->first_name}} {{User::find($quiz->ownerid)->last_name}}</p>
        </div>
    </div>
    <div class="col-lg-12">&nbsp;</div>
    <div class="col-lg-12">&nbsp;</div>
    <div class="col-lg-6 col-lg-offset-3">
        <?php $queCount = 0; ?>
        @foreach($quizOptions as $quizOption)
            <?php $queCount++; ?>
            <h4><strong>Q.</strong> {{$quizOption->question}}</h4>
            @if(($quizOption->correct1 && $quizOption->correct2) || ($quizOption->correct1 && $quizOption->correct3) || ($quizOption->correct1 && $quizOption->correct4) || ($quizOption->correct2 && $quizOption->correct3) || ($quizOption->correct2 && $quizOption->correct4) || ($quizOption->correct3 && $quizOption->correct4))
                <input type="hidden" id="qId{{$queCount}}" value="{{$quizOption->id}}">
                <input type="hidden" id="qType{{$queCount}}" value="maq">
        <div class="col-lg-12">
                <div class="col-lg-6"><input type="checkbox" name="answer{{$queCount}}[]" value="{{$quizOption->option1}}">&nbsp;{{{$quizOption->option1}}}</div>
                <div class="col-lg-6"><input type="checkbox" name="answer{{$queCount}}[]" value="{{$quizOption->option2}}">&nbsp;{{{$quizOption->option2}}}</div>
        </div>
        <div class="col-lg-12">
                <div class="col-lg-6"><input type="checkbox" name="answer{{$queCount}}[]" value="{{$quizOption->option3}}">&nbsp;{{{$quizOption->option3}}}</div>
                <div class="col-lg-6"><input type="checkbox" name="answer{{$queCount}}[]" value="{{$quizOption->option4}}">&nbsp;{{{$quizOption->option4}}}<br></div>
        </div>
            @elseif(($quizOption->correct1 || $quizOption->correct2 || $quizOption->correct3 || $quizOption->correct4)&& (($quizOption->option3!=null)&&($quizOption->option4!=null)))
                <input type="hidden" id="qId{{$queCount}}" value="{{$quizOption->id}}">
                <input type="hidden" id="qType{{$queCount}}" value="saq">
        <div class="col-lg-12">
                <div class="col-lg-6"><input type="radio" name="answer{{$queCount}}" value="{{$quizOption->option1}}">&nbsp;{{{$quizOption->option1}}}</div>
                <div class="col-lg-6"><input type="radio" name="answer{{$queCount}}" value="{{$quizOption->option2}}">&nbsp;{{{$quizOption->option2}}}</div>
            </div>
        <div class="col-lg-12">
                <div class="col-lg-6"><input type="radio" name="answer{{$queCount}}" value="{{$quizOption->option3}}">&nbsp;{{{$quizOption->option3}}}</div>
                <div class="col-lg-6"><input type="radio" name="answer{{$queCount}}" value="{{$quizOption->option4}}">&nbsp;{{{$quizOption->option4}}}<br></div>
        </div>
            @else
                <input type="hidden" id="qId{{$queCount}}" value="{{$quizOption->id}}">
                <input type="hidden" id="qType{{$queCount}}" value="tfq">
        <div class="col-lg-12">
                <div class="col-lg-6"><input type="radio" name="answer{{$queCount}}" value="{{$quizOption->option1}}">&nbsp;{{Str::title($quizOption->option1)}}</div>
                <div class="col-lg-6"><input type="radio" name="answer{{$queCount}}" value="{{$quizOption->option2}}">&nbsp;{{Str::title($quizOption->option2)}}<br></div>
            </div>
            @endif
        <div class="col-lg-12">&nbsp;</div>
        @endforeach
        <input type="hidden" id="queCount" value="{{$queCount}}">
        <button id="quizSubmitButton" type="submit" class="btn btn-success" onclick="submitQuiz()">Submit</button>
        <div class='waiting' id="waitingQuiz" style="margin-left: 0px">
        <img src="{{asset('Images/icons/waiting.gif')}}">Submitting..
            </div>
<div class="col-lg-12">&nbsp;</div>
    </div>
</div>

<!-- Modal to show the purchase content -->
<div class="modal fade" id="purchaseModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Purchase Content</h4>
            </div>
            <div class="modal-body">
                Hi,<h3>{{Auth::user()->first_name}}</h3>
                In order to use <h4 id="type"></h4>: <p id="title"><p>, you need to have <h4 id="ifc"></h4> ifc's.
                <p> Your current account balance is: {{Auth::user()->profile->ifc}}</p>


                <button type="button" class="btn btn-primary" aria-hidden="true" onclick="purchase()">Purchase Content</button>
                <button type="button" class="btn btn-default" aria-hidden="true" onclick="cancelPurchase()">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal to show the purchase content -->
<div class="modal fade" id="resultModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Quiz Result</h4>
            </div>
            <div class="modal-body" id="resultBody">
                <fieldset>
                <br>
                Would you like to send this quiz to your friends?
                   <div class="fb-send" data-href="https://b2.com/quiz/{{$quiz->id}}" data-colorscheme="light"></div>
                <br>
                <br>
                Or would you share this on facebook/twitter?
                <br>
                <div class="col-lg-2">
                <div class="fb-share-button" data-href="http://b2.com/quizPreview/{{$quiz->id}}"></div>
                </div>
                <div class="col-lg-2" style="padding: 3px">
                <a href="https://twitter.com/share" style="padding-top: 5px; margin-top: 5px" class="twitter-share-button" data-url="http://b2.com/quiz/{{$quiz->id}}" data-text="Check this out" data-count="none" data-hashtags="bbarters">Tweet</a>
                </div>



                <br>
                   <a href="http://b2.com/quizDashboard" class="btn btn-primary pull-right">Exit</a>
                </fieldset>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/pages/quiz.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>

</body>
</html>