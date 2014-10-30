<!DOCTYPE html>
<html>
<head>
    <title>Media: {{$media->title}} | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">

    <!-- social sharing metadata -->
    <meta property="og:title" content="BBarters | {{$media->title}} By {{$author}}" />
    <meta property="og:description" content="{{$media->trivia}}" />
    <meta property="og:image" content="{{asset($media->cover)}}" />
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <link href="{{asset('css/search.css')}}" rel="stylesheet">
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

<div id="mycounter" style="margin-top: 7.5%; position: absolute; max-width: 250px; display: none" class="col-lg-offset-1">245</div>
<br>
<br>
<br>

<div class="col-lg-12">
    <div class="col-lg-12">
        <div class="col-lg-4" style="margin-top: 50px">
            <p style="word-wrap: break-word; font-family: 'Haettenschweiler'; text-transform: uppercase; font-size: 50px">{{Str::limit($media->title,50)}}</p>

            <div>
                <div class="col-lg-12" style="margin-top: 25px; font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif; padding: 0px">
                    <p style="font-size: 22px; margin-bottom: 0px">
                    Media
                    </p>
                    <span id="ifc">{{$media->ifc}}</span> IFCs


                    <p style="margin-top: 10px">{{{$media->trivia}}}</p>
                </div>

            <div class="col-lg-12" style="padding: 0px; margin-top: 25px">

                @if (Auth::check())
                        @if (Auth::user()->id == $media->userid || $media->isViewer())
                    <button id="viewMedia2" class="btn btn-success col-lg-4" onclick="viewMedia2('{{$media->path}}')">View Media</button>
                        @else
                    <button id="viewMedia2" class="btn btn-success col-lg-4" style="display: none" onclick="viewMedia2('{{$media->path}}')">View Media</button>
                            <button id="viewMedia" class="btn btn-success col-lg-4" onclick="viewMedia({{$media->id}},'{{$media->path}}')">View Media</button>
                            @if ($media->getAuthor->settings->freeforfriends)
                            <div class="col-lg-12">&nbsp;</div>
                            <div class="col-lg-12" style="padding-left: 0px">
                                 <b>* This media is free for all Barters who are friends with {{$book->getAuthor->first_name}}.</b>
                             </div>
                             @endif
                             @if ($media->getAuthor->settings->discountforfollowers > 0)
                             <div class="col-lg-12">&nbsp;</div>
                             <div class="col-lg-12" style="padding-left: 0px">
                                 <b>* This media is costed {{$media->getAuthor->settings->discountforfollowers}}% off for all Barters who are subscribed to {{$media->getAuthor->first_name}}.</b>
                             </div>
                             @endif
                        @endif
                    <div class="col-lg-3">
                        <div class="fb-share-button" style="padding: 5px" data-href="http://b2.com/mediaPreview/{{$media->id}}"></div><br>
                        <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://b2.com/mediaPreview/{{$media->id}}" data-text="Check this out" data-count="none" data-hashtags="bbarters" style="margin-top: 2px">Tweet</a>
                        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                    </div>
                @else
                <div style="font-size: 20px"><a href="http://b2.com/media/{{$media->id}}" style="cursor: pointer">Sign in</a> to view this media file.<br/></div>
                    @endif
            </div>
            </div>
        </div>
        <div class="col-lg-3" style="margin-top: 65px; padding-right: 30px">
            <img id="blogBookCover" class="col-lg-12" src="{{asset($media->cover)}}" height="300px" style="box-shadow: 3px 3px 5px silver; min-width: 200px; padding: 0px">
        </div>
        <div class="col-lg-5" style="font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif; margin-top: 65px; border-left: solid 1px lightgray;">
            <?php $owner = User::find($media->userid); ?>
            <div class="col-lg-11 col-lg-offset-1">
            <div class="col-lg-3">
            <img src="{{asset($owner->profile->profilePic)}}" style="border-radius: 50%; height: 75px; width: 75px">
            </div>
            <div class="col-lg-9" style="padding-top: 10px">
                <p style="font-size: 22px">{{$owner->first_name}} {{$owner->last_name}}</p>

                <a href="http://b2.com/user/{{$owner->username}}" target="_blank">Visit Profile</a>
                <div class="col-lg-12" style="padding-top: 20px; padding-left: 0px; height: 125px">
                    {{$owner->profile->aboutMe}}
                </div>
            </div>
            </div>

            <div class="col-lg-12">
            <?php
                $interests = $owner->interestedIn()->get();
                $PIcount=0;
             ?>
             @foreach ($interests as $interest)
                 <?php $Itype = DB::table('user_interests')->where('user_id',$owner->id)->where('interest_id',$interest->id)->first(); ?>
                 @if ($Itype->type == 'primary')
                     <?php

                         $articles = $owner->getArticles()->where('category','=',$interest->id)->orderBy('users','DESC')->get();
                         $blogBooks = $owner->getBlogBooks()->where('category','=',$interest->id)->orderBy('users','DESC')->get();
                         $resources = $owner->getResources()->where('category','=',$interest->id)->orderBy('users','DESC')->get();
                         $collaborations = $owner->getOwnedCollaborations()->where('category','=',$interest->id)->orderBy('users','DESC')->get();
                         $contributions = $owner->getContributions()->where('category','=',$interest->id)->orderBy('users','DESC')->get();

                         $content = $articles->merge($blogBooks);
                         $content = $content->merge($resources);
                         $content = $content->merge($collaborations);
                         $content = $content->merge($contributions);

                         $content = $content->sortByDesc('users')->take(3);
                     ?>
                     @if (count($content) > 0)
                         <?php $PIcount++; ?>

                         <div id="carousel{{$PIcount}}" class="carousel slide carousel-fade col-lg-4" style="padding: 5px">
                                     <div class="carousel-inner">
                                         <?php $i=0; ?>
                                         @foreach ($content as $tr)
                                             <?php $i++; ?>
                                             @if ($i == 1)
                                                 <div class="item active">
                                             @else
                                                 <div class="item">
                                             @endif

                                             <div>
                                                 @if ($tr->path)
                                                     <img class="Profileimages col-lg-12" src="{{asset('Images/Resource.jpg')}}" style="padding: 0px">
                                                 @else
                                                     <img class="Profileimages col-lg-12" src="{{asset($tr->cover)}}" style="padding: 0px">
                                                 @endif
                                             </div>
                                             <div class="col-lg-12" style="padding: 0px">
                                                  <div>
                                                      <div>
                                                          <div class="caption">
                                                              @if ($tr->text)
                                                                  <p class="contentTitle" style="font-size: 14px; padding-top: 5px"><a href="{{route('articlePreview',$tr->id)}}" target="_blank">{{$tr->title}}</a></p>

                                                              @elseif ($tr->review)
                                                                  <p class="contentTitle" style="font-size: 14px; padding-top: 5px"><a href="{{route('blogBookPreview',$tr->id)}}" target="_blank">{{$tr->title}}</a></p>

                                                              @elseif ($tr->path)
                                                                  <p class="contentTitle" style="font-size: 14px; padding-top: 5px"><a href="{{route('resource',$tr->id)}}" target="_blank">{{$tr->title}}</a></p>

                                                              @else
                                                                  <p class="contentTitle" style="font-size: 14px; padding-top: 5px"><a href="{{route('collaborationPreview',$tr->id)}}" target="_blank">{{$tr->title}}</a></p>

                                                              @endif
                                                          </div>



                                                      </div>
                                                  </div>
                                              </div>
                                             </div>
                                         @endforeach
                                     </div>
                                     <div style="height: 5%">
                                         <ul class="carousel-indicators pull-right" style="left: auto; list-style-type: none">
                                             <li data-target="#carousel{{$PIcount}}" data-slide-to="0" class="active bottom-boxes"></li>
                                             <li data-target="#carousel{{$PIcount}}" data-slide-to="1" class="bottom-boxes"></li>
                                             <li data-target="#carousel{{$PIcount}}" data-slide-to="2" class="bottom-boxes"></li>
                                         </ul>
                                     </div>
                                 </div>



                     @endif
                 @endif
             @endforeach
             @if ($PIcount > 0)
             <input type="hidden" id="PICOUNT" value="{{$PIcount}}">
             @endif
            </div>
        </div>
    </div>
</div>


@if (Auth::check())
<div class="modal fade" id="previewMediaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" onclick="stopPlayingMedia()">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Media</h4>
            </div>

            <div class="modal-body" id="preview">

            </div>

        </div>
    </div>
</div>
@endif

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/pages/resource.js')}}"></script>
</body>
</html>