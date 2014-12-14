<!DOCTYPE html>
<html>
<head>

    <title>{{$book->title}} | BBarters</title>

  <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- social sharing metadata -->

    <meta property="og:title" content="BBarters | {{$book->title}} By {{$author}}" />
    <meta property="og:description" content="{{$book->description}}" />

    <meta property="og:image" content="{{asset($book->cover)}}" />



    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/blogBookPreview.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
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

@include('navbar')

<div id="previewDiv" class="col-lg-4 col-lg-offset-4">
    <div id="previewDivContent" class="col-lg-12">

    </div>
    <div class="col-lg-12">&nbsp;</div>
    <button class="col-lg-4 btn btn-primary pull-right" onclick="closePreview()">Close Preview</button>
</div>

<br>
<br>
<br>

<?php

    $ttext = 'read this collaboration.';
    $tlink = 'http://b2.com/collaboration/'.$book->id;

?>

<div class="col-lg-12">
    <div class="col-lg-12">
        <div class="col-lg-4" style="margin-top: 50px">
        <?php
             $recTitle = $book->title;
             $recDesc = $book->description;
             $recTitle = str_replace('\'','', $recTitle);
             $recTitle = str_replace('"','', $recTitle);
             $recDesc = str_replace('\'','', $recDesc);
             $recDesc = str_replace('"','', $recDesc);
         ?>

            <p style="word-wrap: break-word; font-family: 'Haettenschweiler'; text-transform: uppercase; font-size: 50px">{{Str::limit($book->title,50)}} <img src="http://b2.com/Images/recco this.PNG" style="cursor: pointer" onclick="reccoThis('http://b2.com/collaborationPreview/{{$book->id}}','{{$recTitle}}','{{$recDesc}}','{{$book->cover}}')"></p>
            <br>
            <div>

            <?php

                                $owner = User::find($book->userid);

                        ?>
                        <div class="col-lg-12" style="padding: 0px">
                        <div class="col-lg-3" style="padding: 0px">
                        <img src="{{asset($owner->profile->profilePic)}}" style="border-radius: 50%; height: 75px; width: 75px">
                        </div>
                        <div class="col-lg-9" style="padding-top: 10px">
                            <p style="font-size: 22px">{{$owner->first_name}} {{$owner->last_name}}</p>

                            <a href="http://b2.com/user/{{$owner->username}}" target="_blank">Visit Profile</a>
                        </div>
                        </div>


                <div class="col-lg-12" style="margin-top: 25px; font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif; padding: 0px">
                    <p style="font-size: 22px; margin-bottom: 0px">

                        Collaboration

                    </p>
                    {{$book->ifc}} IFCs
                    |
                        {{$book->users}} Readers

                    <p style="margin-top: 10px">{{{$book->description}}}</p>
                </div>

                <div class="col-lg-12" style="padding: 0px; margin-top: 25px">

                        <button class="col-lg-4 btn btn-success" onclick="showCollaborationPreview({{$book->id}})">Show Preview</button>
                        <br><br>

                    @if (Auth::check())




                                                    @if(Auth::user()->id == $book->userid || $book->isReader() || $book->isContributor())

                                                        <a href="{{route('collaboration',$book->id)}}" class="col-lg-4 btn btn-success">Read</a>

                                                        @else
<?php
                                                $showPurIFC = $book->ifc;
                                                $owner = User::find($book->userid);
                                                if (Friend::isFriend($owner->id) && $owner->settings->freeforfriends)
                                                    $showPurIFC = 0;
                                                else if(Friend::isSubscriber($owner->id) && $owner->settings->discountforfollowers > 0)
                                                {
                                                    $discount = ($book->ifc*$owner->settings->discountforfollowers)/100;
                                                    $showPurIFC = $book->ifc-$discount;
                                                }
                                            ?>

                                                        <button id="{{$book->title}}" class="col-lg-4 btn btn-success" name="book" onclick="showPurchase({{$showPurIFC}})">Read</button>

                                                        @if ($book->getAdmin->settings->freeforfriends)
                                                        <div class="col-lg-12">&nbsp;</div>
                                                        <div class="col-lg-12" style="padding-left: 0px">
                                                            <b>* This read is free for all Barters who are friends with {{$book->getAdmin->first_name}}.</b>
                                                        </div>
                                                        @endif
                                                        @if ($book->getAdmin->settings->discountforfollowers > 0)
                                                        <div class="col-lg-12">&nbsp;</div>
                                                        <div class="col-lg-12" style="padding-left: 0px">
                                                            <b>* This read is costed {{$book->getAdmin->settings->discountforfollowers}}% off for all Barters who are subscribed to {{$book->getAdmin->first_name}}.</b>
                                                        </div>
                                                        @endif

                                                     @endif
                                                      <div class="col-lg-3">
                                                             <div class="fb-share-button" style="padding: 5px" data-href="http://b2.com/mediaPreview/{{$book->id}}"></div><br>
                                                              <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://b2.com/mdiaPreview/{{$book->id}}" data-text="Check this out" data-count="none" data-hashtags="bbarters" style="margin-top: 2px">Tweet</a>
                                                             <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                                                      </div>


                            @else
                                     <div style="font-size: 15px"><a href="{{$tlink}}" style="cursor: pointer">Sign In <img height="15px" width="15px" src="{{asset('Images/icons/twitter.png')}}"> | <img height="15px" width="15px" src="{{asset('Images/icons/facebook.jpg')}}"> | <img height="15px" width="15px" src="{{asset('Images/icons/gmail.jpg')}}"></a>&nbsp;&nbsp;&nbsp;to {{$ttext}}<br/></div>
                            @endif


                                @if (Auth::check())
                                            <?php $requestAlreadySent = DB::table('requestcontribution')->where('collaboration_id',$book->id)->where('user_id',Auth::user()->id)->first(); ?>
                                            <?php $alreadyInvited = DB::table('invite_contributors')->where('collaborationid',$book->id)->where('useremail',Auth::user()->email)->first(); ?>
                                            @if (!$book->isContributor() && Auth::user()->id != $book->userid && $book->isReader())
                                            <div class="col-lg-12" style="padding: 0px">
                                                @if ($requestAlreadySent == null && $alreadyInvited == null)

                                                <button id="contribute" class="btn btn-success col-lg-4" onclick="plusContribute()" style="margin-top: 5px">+ Contribute</button>
                                                @endif
                                            </div>
                                            @endif

                                @endif


                </div>
                </div>







        </div>
        <div class="col-lg-3" style="margin-top: 65px; padding-right: 30px">

                <img id="blogBookCover" class="col-lg-12" src="{{asset($book->cover)}}" height="300px" style="box-shadow: 3px 3px 5px silver; min-width: 200px; padding: 0px">

        </div>
        <div class="col-lg-5" style="font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif; margin-top: 65px; border-left: solid 1px lightgray;">


            <div class="col-lg-12">

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
    </div>
</div>

@if (Auth::check())

<div class="modal fade" id="ifcPurchasingModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Are you sure want to get this: </h4>
            </div>

            <div class="modal-body" id="ifcPurchasingModalBody">

                <div style="text-align: center; display:none" id="ifcWaiting"  >
                    <img src="{{asset('Images/icons/waiting.gif')}}">Loading..
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="contributionReasonModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Request to contribute.</h4>
            </div>
            <div class="modal-body">
                <p>Please specify a reason for the collaboration admin to add you up as a contributor.</p>
                <form id="plusContributeForm" class="form-horizontal">
                    <fieldset>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <textarea id="contributeReason" name="contributeReason" class="form-control" style="width: 100%" rows="3"></textarea>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group">
                        <div class="pull-right">
                            <button type="submit" id="plusContributeSubmit" onclick="postRequest({{$book->id}})" class="btn btn-primary">Submit</button>
                            <img class='pull-left'id="waitingPlusContributeSubmit" style="display:none"  src="{{asset('Images/icons/waiting.gif')}}">&nbsp;&nbsp;&nbsp;&nbsp;

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal to show the less ifc content -->
@endif

<!-- Hidden input fields to store data received from article dashboard about the article -->

<input id="cid" name="cid" type="hidden" value="{{$book->id}}">
<input id="type" name="type" type="hidden" value="collaboration">

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/jquery.metro.js')}}"></script>
<script src="{{asset('js/pages/resource.js')}}"></script>

</body>
</html>