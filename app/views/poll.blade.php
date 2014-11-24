<!DOCTYPE html>
<html>
<head>
    <title>Poll | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta property="og:title" content="BBarters | {{$poll->question}} By {{User::find($poll->ownerid)->first_name}} {{User::find($poll->ownerid)->last_name}}" />
    <meta property="og:description" content="{{$poll->message}}" />
    <meta property="og:image" content="{{asset('Images/Poll.png')}}" />
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/poll.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.flipcounter.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>

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
<div id="mycounter" style="margin-top:1%; margin-left: 7%; max-width: 250px; position: absolute; display:none" class="col-lg-offset-1">0</div>
<br>
<br>
<br>
<div class="col-lg-6 col-lg-offset-1">
    <div class="col-lg-12" style="border: solid 1px lightgray; padding: 15px; border-radius: 5px">
    <?php
         $recTitle = $poll->question;
         $recDesc = $poll->message;
         $recTitle = str_replace('\'','', $recTitle);
         $recTitle = str_replace('"','', $recTitle);
         $recDesc = str_replace('\'','', $recDesc);
         $recDesc = str_replace('"','', $recDesc);
     ?>
    <h2>{{$poll->question}} @if (Auth::check())<img src="http://b2.com/Images/recco this.PNG" onclick="reccoThis('http://b2.com/poll/{{$poll->id}}','{{$recTitle}}','{{$recDesc}}','http://b2.com/Images/Poll.png')" style="cursor: pointer">@endif </h2>
    <br>
    @foreach($poll->getOptions()->get() as $option)
    <input type="radio" value="{{$option->id}}" name="{{$poll->id}}">{{$option->option}}
    <br><br>
    @endforeach

    @if (Auth::check())
        @if($poll->active && (Auth::user()->id!=$poll->ownerid))
            @if ($poll->active)
                <button class="btn btn-success" onclick="submitPoll('{{$poll->id}}')">Submit</button>
            @else
                <h3> This Poll is now closed for voting!</h3>
                <button class="btn btn-success" onclick="getResults('{{$poll->id}}')"> Show Results</button>
            @endif
        @else
            <br>
            <button class="btn btn-success" onclick="getResults('{{$poll->id}}')"> Show Results</button>
        @endif
    @else
        @if ($poll->active)
            <button class="btn btn-success" onclick="submitPoll('{{$poll->id}}')">Submit</button>
        @else
            <h3> This Poll is now closed for voting!</h3>
        @endif
    @endif

    <div class="col-lg-10 col-lg-offset-2" style="display: none" id="pollResult">

    </div>
    </div>

    <br>
    <br>
    <br>
    <div class="col-lg-12" style="padding: 15px">
     <div class="col-lg-3"> Share this Poll:</div>
    <div class="col-lg-9">
        <div class="fb-share-button" style="padding: 5px" data-href="http://b2.com/poll/{{$poll->id}}"></div>
        <br>
        <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://b2.com/poll/{{$poll->id}}" data-text="Check this out" data-count="none" data-hashtags="bbarters">Tweet</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
        <br>
       <div class="fb-send" data-href="http://b2.com/poll/{{$poll->id}}" data-colorscheme="light"></div>
    </div>
    </div>
<br><br>

    <br><br>
    <p>Comments:</p>
    <div class="fb-comments" data-href="http://b2.com/poll/{{$poll->id}}" data-width="600" data-numposts="10" data-colorscheme="light"></div>
</div>

<div class="col-lg-5">
@if (count($content) > 0)
     <?php $i=0; ?>
     @foreach ($content as $tr)
     <?php $i++; ?>
     @if ($i%3 == 1)
        <div class="col-lg-12">
     @endif
     <div class="col-lg-4">
         <div class="col-lg-12" style="padding: 0px">
             <img class="Profileimages col-lg-12" src="{{asset($tr->cover)}}" style="padding: 0px">
         </div>
         <div class="col-lg-12" style="padding: 0px">
             <div>
                 <div>
                     <div class="caption">
                         @if ($tr->text)
                             <p class="contentTitle" style="font-size: 14px; padding-top: 5px"><a href="{{route('articlePreview',$tr->id)}}" target="_blank">{{Str::limit($tr->title,30)}}</a></p>
                         @elseif ($tr->review)
                             <p class="contentTitle" style="font-size: 14px; padding-top: 5px"><a href="{{route('blogBookPreview',$tr->id)}}" target="_blank">{{Str::limit($tr->title,30)}}</a></p>
                         @else
                             <p class="contentTitle" style="font-size: 14px; padding-top: 5px"><a href="{{route('collaborationPreview',$tr->id)}}" target="_blank">{{Str::limit($tr->title,30)}}</a></p>
                         @endif
                     </div>
                 </div>
             </div>
         </div>
     </div>
     @if ($i%3 == 0)
        </div>
     @endif
     @endforeach
     @if (count($content)%3 != 0)
        </div>
     @endif
@endif
</div>

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>


<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/pages/poll.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/jstween-1.1.min.js')}}"></script>
<script src="{{asset('js/jquery.flipcounter.js')}}"></script>
</body>
</html>
