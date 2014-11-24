<!DOCTYPE html>
<html lang="en">
<head>

    <title>Event: {{$event->name}} | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta property="og:title" content="BBarters | '{{$event->name}}' an event hosted by {{$event->getHost->first_name}} {{$event->getHost->last_name}}" />
    <meta property="og:description" content="Venue: {{$event->venue}}. Date & Time: {{$event->datetime}}." />
    <meta property="og:image" content="{{$event->cover}}" />
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.1/css/bootstrapValidator.min.css"/>
    <link href="{{asset('css/pages/events.css')}}" rel="stylesheet">

    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=431744100304343&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<input type="hidden" id="view" value="event">

@include('navbar')

<br>
<br>
<br>
<br>
<div class="col-lg-12">
    <div class="col-lg-4">
        <div class="col-lg-12">
            <img class="thumbnail col-lg-12" src="{{asset($event->cover)}}" height="350px">
        </div>
        <div class="col-lg-12">
            <hr>
            <input type="hidden" id="event-id" value="{{$event->id}}">
            <h3 id="event-title">{{$event->name}}</h3>
            <h4 id="host-name">Hosted by <a href="{{route('user',$event->getHost->username)}}" target="_blank">{{$event->getHost->first_name}} {{$event->getHost->last_name}}</a></h4>
            <hr>
            @if (Auth::check())
                @if ($event->open && $registrations == true)
                    @if (Auth::user()->id != $event->userid)
                        @if (!$event->isAttending())
                            <button id="plus-register" class="col-lg-6 col-lg-offset-3 btn btn-default" onclick="plusRegister()">Register to this event</button>
                            <button id="cancel-register" class="col-lg-6 col-lg-offset-3 btn btn-danger" onclick="cancelRegister()" style="display: none">Cancel Registration</button>
                            @if ($event->getHost->settings->freeforfriends)
                                <br><br><b>Registering to this event is free for all Barters who are friends with {{$event->getHost->first_name}}.</b>
                            @endif
                            @if ($event->getHost->settings->discountforfollowers > 0)
                                <br><br><b>Registering to this event is costed {{$event->getHost->settings->discountforfollowers}}% off for all Barters who are subscribed to {{$event->getHost->first_name}}.</b>
                            @endif
                        @else
                            <button id="plus-register" class="col-lg-6 col-lg-offset-3 btn btn-default" onclick="plusRegister()" style="display: none">Register to this event</button>
                            <button id="cancel-register" class="col-lg-6 col-lg-offset-3 btn btn-danger" onclick="cancelRegister()">Cancel Registration</button>
                        @endif
                            <div class="waiting col-lg-2 col-lg-offset-5" id="waiting-two">
                                <img src="{{asset('Images/icons/waiting.gif')}}">Loading..
                            </div>
                    @else
                        <a href="{{route('attendeeList',$event->id)}}" target="_blank" class="col-lg-6 col-lg-offset-3 btn btn-success">View Guest List</a>
                    @endif
                @else
                    @if (Auth::user()->id != $event->userid)
                        <p id="closed-registrations">Sorry, registrations are closed for this event.</p>
                    @else
                        <p id="closed-registrations">Please note that registrations are closed for this event since it has passed.</p>
                    @endif
                @endif
            @else
                <div style="text-align: center">To register, <a href="{{route('home')}}" target="_blank">sign in</a> and then refresh this page.</div>
            @endif
            <div class="pull-right">
                <div class="fb-share-button" style="padding: 5px" data-href="http://b2.com/event/{{$event->id}}"></div><br>
                <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://b2.com/event/{{$event->id}}" data-text="Check this out" data-count="none" data-hashtags="bbarters" style="margin-top: 2px">Tweet</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
            </div>

        </div>
    </div>
    <div class="col-lg-8">
        <div class="col-lg-12 details-container">
            <div class="col-lg-4 event-details">
                <strong>Category:</strong>
                <p>{{Interest::find($event->category)->interest_name}}</p>
            </div>
            <div class="col-lg-4 event-details">
                <strong>Cost:</strong>
                <p><span id="ifcs">{{$event->ifc}}</span> IFCs</p>
            </div>
            <div class="col-lg-4 event-details">
                <strong>Attendee(s):</strong>
                <p id="attendees">{{$event->users}}</p>
            </div>
        </div>
        <hr id="hr-first" class="col-lg-12">
        <div id="main-info" class="col-lg-12">

            <div class="col-lg-12">
                <strong>Description:</strong>
                <br>
                {{$event->description}}
            </div>

            <div class="col-lg-12">&nbsp;</div>

            <div class="col-lg-12">
                <strong>Prerequesites:</strong>
                <br>
                {{$event->prerequesite}}
            </div>

            <div class="col-lg-12">&nbsp;</div>

            <div class="col-lg-12">
                <strong>Takeaway:</strong>
                <br>
                {{$event->takeaway}}
            </div>

        </div>
        <hr id="hr-second" class="col-lg-12">
        <div class="col-lg-12 details-container">
            <div class="col-lg-6 event-details">
                <strong>Venue:</strong>
                <p>{{$event->venue}}</p>
            </div>
            <div class="col-lg-6 event-details">
                <strong>Date & Time:</strong>
                <p>{{$event->datetime}}</p>
            </div>
        </div>
    </div>
</div>

@if (Auth::check())
<div class="modal fade" id="contact-details-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Contact information</h4>
            </div>
            <div class="modal-body">
                <fieldset>
                    <h4>Please enter your 10-digit contact number to complete registration. This number will not be visible to anyone except the event host.</h4>

                    <form id="contact-no-form" class="col-lg-12">
                        <div class="form-group line">
                            <input id="contact-no" name="contactNo" class="form-control input-box" placeholder="Contact no.">
                        </div>
                        <div class="line">
                            <button type="submit" id="contact-no-submit" class="btn btn-primary" onclick="register()">Submit</button>
                            <div class="waiting" id="waiting-one">
                                <img src="{{asset('Images/icons/waiting.gif')}}">Loading..
                            </div>
                        </div>
                    </form>

                </fieldset>
            </div>
        </div>
    </div>
</div>
@endif


<div class="modal fade" id="ifcPurchasingModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Are you sure want to get this: </h4>
            </div>

            <div class="modal-body" >

              <div id="ifcPurchasingModalBody" >

                <div style="text-align: center"  style="display:none" id="ifcWaiting">

                                             <img src="{{asset('Images/icons/waiting.gif')}}">Loading..
                   </div>


              </div>
                <div style="text-align: center;" id="ifcPurchaseModalButtons">

                    <Button id="purchaseButton" class="btn btn-primary" onclick="checkForPurchase()" data-dismiss="modal">Purchase Content</Button>
                    <a  class="btn btn-warning" data-dismiss="modal">Cancel</a>

                </div>
            </div>
        </div>
    </div>
</div>


    <input type="hidden" id="refreshed" value="no">
    <script src="{{asset('js/reload.js')}}"></script>

    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.1/js/bootstrapValidator.min.js"></script>
    <script src="{{asset('js/bootbox.js')}}"></script>
    <script src="{{asset('js/pages/events.js')}}"></script>

</body>
</html>