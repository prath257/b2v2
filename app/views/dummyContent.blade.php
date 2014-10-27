<br>
<br>
<br>
<div id="the-contento-div" class="col-lg-12" style="font-family: 'proxima-nova',proxima-nova,Arial,sans-serif">
    <div class="col-lg-3">
        <h1 style="text-transform: uppercase; font-size: 32px; font-weight: bolder; font-family: 'proxima-nova',proxima-nova,Arial,sans-serif">{{$user->first_name}} {{$user->last_name}}</h1>
        <div style="font-size: 12px; color: #6f6d6a; padding-left: 10px">{{$user->country}}</div>
        <br>
        <img src="{{asset($user->profile->profilePic)}}" style="height: 100px; width: 100px">
        <br><br>
        <h3 style="font-family: 'proxima-nova',proxima-nova,Arial,sans-serif; font-size: 22px; font-weight: 700">{{Str::title($interest->interest_name)}}</h3>
        <br>
        <p style="font-size: 16px; font-family: 'proxima-nova',proxima-nova,Arial,sans-serif">{{$user->profile->aboutMe}}</p>
        <br>
        <div class="col-lg-12" style="color: #000000; padding: 0px">
            <?php
                $articles = $user->getArticles()->where('category','=',$interest->id)->get();
                $books = $user->getBlogBooks()->where('category','=',$interest->id)->get();
                $collab = $user->getOwnedCollaborations()->where('category','=',$interest->id)->get();
                $media = $user->getMedia()->where('ispublic','=',true)->where('category','=',$interest->id)->get();
                $resource = $user->getResources()->where('category','=',$interest->id)->get();
                $event = $user->getHostedEvents()->where('category','=',$interest->id)->get();

                $content = $articles->merge($books);
                $content = $content->merge($collab);
                $content = $content->merge($media);
                $content = $content->merge($resource);
                $content = $content->merge($event);
                $content = $content->sortByDesc('users');

                $colors = array("#555450", "#1c5a5e", "#5fa09d", "#6e2f40", "#989d27");
                $darkColors = array("#4c4b47","#185256","#559693","#5f2535","#898e21");
            ?>
            <div class="col-lg-12 noPadding">
                <a class="col-lg-6" style="color: #000000; padding: 5px" onclick="toggleNewContent('art')"><i class="fa fa-file-o"></i> <b>{{count($articles)}}</b> <span style="font-size: 12px; color: #6f6d6a">Articles</span></a>
                <a class="col-lg-6" style="color: #000000; padding: 5px" onclick="toggleNewContent('bb')"><i class="fa fa-book"></i> <b>{{count($books)}}</b> <span style="font-size: 12px; color: #6f6d6a">BlogBooks</span></a>
            </div>
            <div class="col-lg-12 noPadding">
                <a class="col-lg-6" style="color: #000000; padding: 5px" onclick="toggleNewContent('col')"><i class="fa fa-users"></i> <b>{{count($collab)}}</b> <span style="font-size: 12px; color: #6f6d6a">Collaborations</span></a>
                <a class="col-lg-6" style="color: #000000; padding: 5px" onclick="toggleNewContent('med')"><i class="fa fa-film"></i> <b>{{count($media)}}</b> <span style="font-size: 12px; color: #6f6d6a">Media</span></a>
            </div>
            <div class="col-lg-12 noPadding">
                <a class="col-lg-6" style="color: #000000; padding: 5px" onclick="toggleNewContent('res')"><i class="fa fa-download"></i> <b>{{count($resource)}}</b> <span style="font-size: 12px; color: #6f6d6a">Resources</span></a>
                <a class="col-lg-6" style="color: #000000; padding: 5px" onclick="toggleNewContent('eve')"><i class="fa fa-calendar"></i> <b>{{count($event)}}</b> <span style="font-size: 12px; color: #6f6d6a">Events</span></a>
            </div>


        </div>

    </div>
    <div class="col-lg-9">
    <div id="all-div" class="col-lg-12 allContento">
                <?php
                    $count = count($content);
                    $countPerDiv = round($count/3);
                    if ($count%3 == 1)
                        $countPerDiv++;
                    $contentCount = 0;
                ?>
                <div class="col-lg-4">
                    @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                        <div class="col-lg-12" style="padding: 5px; color: white">
                            <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                                @if ($content[$contentCount]->path && $content[$contentCount]->description)
                                <img src="{{asset('Images/Resource.jpg')}}" class="col-lg-12 noPadding contento-images">
                                @else
                                <img src="{{asset($content[$contentCount]->cover)}}" class="col-lg-12 noPadding contento-images">
                                @endif
                                <div class="col-lg-12">
                                    <?php
                                        if ($content[$contentCount]->trivia)
                                            $routeLink = 'mediaPreview';
                                        elseif ($content[$contentCount]->text)
                                            $routeLink = 'articlePreview';
                                        elseif ($content[$contentCount]->review)
                                            $routeLink = 'blogBookPreview';
                                        elseif ($content[$contentCount]->path)
                                            $routeLink = 'resource';
                                        elseif ($content[$contentCount]->venue)
                                            $routeLink = 'event';
                                        else
                                            $routeLink = 'collaborationPreview';

                                        if ($i == 0)
                                            $ID = 'ifc-reader';
                                        else
                                            $ID = 'null'
                                    ?>
                                    <h4 style="font-weight: bolder"><a href="{{route($routeLink,$content[$contentCount]->id)}}" style="color: white">{{$content[$contentCount]->title}}</a></h4>
                                    @if (!$content[$contentCount]->trivia && !$content[$contentCount]->venue)
                                    <p>{{$content[$contentCount]->description}}</p>
                                    @elseif ($content[$contentCount]->trivia)
                                    <p>{{$content[$contentCount]->trivia}}</p>
                                    @elseif ($content[$contentCount]->venue)
                                    <p>{{$content[$contentCount]->venue}}</p>
                                    <p>{{$content[$contentCount]->datetime}}</p>
                                    @endif
                                </div>
                                <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                    <div id="{{$ID}}" class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                        <div class="col-lg-12 noPadding"><b>{{$content[$contentCount]->ifc}}</b></div>
                                        <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                    </div>
                                    <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                        <div class="col-lg-12 noPadding"><b>{{$content[$contentCount]->users}}</b></div>
                                        @if ($content[$contentCount]->text || $content[$contentCount]->review)
                                        <div class="col-lg-12 noPadding" style="font-size: 12px">Readers</div>
                                        @elseif ($content[$contentCount]->trivia)
                                        <div class="col-lg-12 noPadding" style="font-size: 12px">Views</div>
                                        @elseif ($content[$contentCount]->path)
                                        <div class="col-lg-12 noPadding" style="font-size: 12px">Downloads</div>
                                        @elseif ($content[$contentCount]->venue)
                                        <div class="col-lg-12 noPadding" style="font-size: 12px">Attending</div>
                                        @else
                                        <div class="col-lg-12 noPadding" style="font-size: 12px">Readers</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="col-lg-4">
                    @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                        <div class="col-lg-12" style="padding: 5px; color: white">
                            <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                                @if ($content[$contentCount]->path && $content[$contentCount]->description)
                                <img src="{{asset('Images/Resource.jpg')}}" class="col-lg-12 noPadding contento-images">
                                @else
                                <img src="{{asset($content[$contentCount]->cover)}}" class="col-lg-12 noPadding contento-images">
                                @endif
                                <div class="col-lg-12">
                                    <?php
                                        if ($content[$contentCount]->trivia)
                                            $routeLink = 'mediaPreview';
                                        elseif ($content[$contentCount]->text)
                                            $routeLink = 'articlePreview';
                                        elseif ($content[$contentCount]->review)
                                            $routeLink = 'blogBookPreview';
                                        elseif ($content[$contentCount]->path)
                                            $routeLink = 'resource';
                                        elseif ($content[$contentCount]->venue)
                                            $routeLink = 'event';
                                        else
                                            $routeLink = 'collaborationPreview';
                                    ?>
                                    <h4 style="font-weight: bolder"><a href="{{route($routeLink,$content[$contentCount]->id)}}" style="color: white">{{$content[$contentCount]->title}}</a></h4>
                                    @if (!$content[$contentCount]->trivia && !$content[$contentCount]->venue)
                                    <p>{{$content[$contentCount]->description}}</p>
                                    @elseif ($content[$contentCount]->trivia)
                                    <p>{{$content[$contentCount]->trivia}}</p>
                                    @elseif ($content[$contentCount]->venue)
                                    <p>{{$content[$contentCount]->venue}}</p>
                                    <p>{{$content[$contentCount]->datetime}}</p>
                                    @endif
                                </div>
                                <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                    <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                        <div class="col-lg-12 noPadding"><b>{{$content[$contentCount]->ifc}}</b></div>
                                        <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                    </div>
                                    <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                        <div class="col-lg-12 noPadding"><b>{{$content[$contentCount]->users}}</b></div>
                                        @if ($content[$contentCount]->text || $content[$contentCount]->review)
                                        <div class="col-lg-12 noPadding" style="font-size: 12px">Readers</div>
                                        @elseif ($content[$contentCount]->trivia)
                                        <div class="col-lg-12 noPadding" style="font-size: 12px">Views</div>
                                        @elseif ($content[$contentCount]->path)
                                        <div class="col-lg-12 noPadding" style="font-size: 12px">Downloads</div>
                                        @elseif ($content[$contentCount]->venue)
                                        <div class="col-lg-12 noPadding" style="font-size: 12px">Attending</div>
                                        @else
                                        <div class="col-lg-12 noPadding" style="font-size: 12px">Readers</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="col-lg-4">
                    @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                        <div class="col-lg-12" style="padding: 5px; color: white">
                            <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                                @if ($content[$contentCount]->path && $content[$contentCount]->description)
                                <img src="{{asset('Images/Resource.jpg')}}" class="col-lg-12 noPadding contento-images">
                                @else
                                <img src="{{asset($content[$contentCount]->cover)}}" class="col-lg-12 noPadding contento-images">
                                @endif
                                <div class="col-lg-12">
                                    <?php
                                        if ($content[$contentCount]->trivia)
                                            $routeLink = 'mediaPreview';
                                        elseif ($content[$contentCount]->text)
                                            $routeLink = 'articlePreview';
                                        elseif ($content[$contentCount]->review)
                                            $routeLink = 'blogBookPreview';
                                        elseif ($content[$contentCount]->path)
                                            $routeLink = 'resource';
                                        elseif ($content[$contentCount]->venue)
                                            $routeLink = 'event';
                                        else
                                            $routeLink = 'collaborationPreview';
                                    ?>
                                    <h4 style="font-weight: bolder"><a href="{{route($routeLink,$content[$contentCount]->id)}}" style="color: white">{{$content[$contentCount]->title}}</a></h4>
                                    @if (!$content[$contentCount]->trivia && !$content[$contentCount]->venue)
                                    <p>{{$content[$contentCount]->description}}</p>
                                    @elseif ($content[$contentCount]->trivia)
                                    <p>{{$content[$contentCount]->trivia}}</p>
                                    @elseif ($content[$contentCount]->venue)
                                    <p>{{$content[$contentCount]->venue}}</p>
                                    <p>{{$content[$contentCount]->datetime}}</p>
                                    @endif
                                </div>
                                <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                    <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                        <div class="col-lg-12 noPadding"><b>{{$content[$contentCount]->ifc}}</b></div>
                                        <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                    </div>
                                    <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                        <div class="col-lg-12 noPadding"><b>{{$content[$contentCount]->users}}</b></div>
                                        @if ($content[$contentCount]->text || $content[$contentCount]->review)
                                        <div class="col-lg-12 noPadding" style="font-size: 12px">Readers</div>
                                        @elseif ($content[$contentCount]->trivia)
                                        <div class="col-lg-12 noPadding" style="font-size: 12px">Views</div>
                                        @elseif ($content[$contentCount]->path)
                                        <div class="col-lg-12 noPadding" style="font-size: 12px">Downloads</div>
                                        @elseif ($content[$contentCount]->venue)
                                        <div class="col-lg-12 noPadding" style="font-size: 12px">Attending</div>
                                        @else
                                        <div class="col-lg-12 noPadding" style="font-size: 12px">Readers</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

        <div id="art-div" class="col-lg-12 allContento" style="display: none">
            <?php
                $count = count($articles);
                $countPerDiv = round($count/3);
                if ($count%3 == 1)
                    $countPerDiv++;
                $contentCount = 0;
            ?>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($articles[$contentCount]->cover)}}" class="col-lg-12 noPadding contento-images">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder"><a href="{{route('articlePreview',$articles[$contentCount]->id)}}" style="color: white">{{$articles[$contentCount]->title}}</a></h4>
                                <p>{{$articles[$contentCount]->description}}</p>

                            </div>
                            <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                    <div class="col-lg-12 noPadding"><b>{{$articles[$contentCount]->ifc}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                </div>
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                    <div class="col-lg-12 noPadding"><b>{{$articles[$contentCount]->users}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">Readers</div>


                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($articles[$contentCount]->cover)}}" class="col-lg-12 noPadding contento-images">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder"><a href="{{route('articlePreview',$articles[$contentCount]->id)}}" style="color: white">{{$articles[$contentCount]->title}}</a></h4>
                                <p>{{$articles[$contentCount]->description}}</p>

                            </div>
                            <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                    <div class="col-lg-12 noPadding"><b>{{$articles[$contentCount]->ifc}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                </div>
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                    <div class="col-lg-12 noPadding"><b>{{$articles[$contentCount]->users}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">Readers</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($articles[$contentCount]->cover)}}" class="col-lg-12 noPadding contento-images">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder"><a href="{{route('articlePreview',$articles[$contentCount]->id)}}" style="color: white">{{$articles[$contentCount]->title}}</a></h4>
                                <p>{{$articles[$contentCount]->description}}</p>

                            </div>
                            <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                    <div class="col-lg-12 noPadding"><b>{{$articles[$contentCount]->ifc}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                </div>
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                    <div class="col-lg-12 noPadding"><b>{{$articles[$contentCount]->users}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">Readers</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
        <div id="bb-div" class="col-lg-12 allContento" style="display: none">
            <?php
                $count = count($books);
                $countPerDiv = round($count/3);
                if ($count%3 == 1)
                    $countPerDiv++;
                $contentCount = 0;
            ?>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($books[$contentCount]->cover)}}" class="col-lg-12 noPadding contento-images">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder"><a href="{{route('blogBookPreview',$books[$contentCount]->id)}}" style="color: white">{{$books[$contentCount]->title}}</a></h4>
                                <p>{{$books[$contentCount]->description}}</p>

                            </div>

                            <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                    <div class="col-lg-12 noPadding"><b>{{$books[$contentCount]->ifc}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                </div>
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                    <div class="col-lg-12 noPadding"><b>{{$books[$contentCount]->users}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">Readers</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($books[$contentCount]->cover)}}" class="col-lg-12 noPadding contento-images">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder"><a href="{{route('blogBookPreview',$books[$contentCount]->id)}}" style="color: white">{{$books[$contentCount]->title}}</a></h4>
                                <p>{{$books[$contentCount]->description}}</p>

                            </div>
                            <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                    <div class="col-lg-12 noPadding"><b>{{$books[$contentCount]->ifc}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                </div>
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                    <div class="col-lg-12 noPadding"><b>{{$books[$contentCount]->users}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">Readers</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($books[$contentCount]->cover)}}" class="col-lg-12 noPadding contento-images">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder"><a href="{{route('blogBookPreview',$books[$contentCount]->id)}}" style="color: white">{{$books[$contentCount]->title}}</a></h4>
                                <p>{{$books[$contentCount]->description}}</p>

                            </div>
                            <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                    <div class="col-lg-12 noPadding"><b>{{$books[$contentCount]->ifc}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                </div>
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                    <div class="col-lg-12 noPadding"><b>{{$books[$contentCount]->users}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">Readers</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
        <div id="col-div" class="col-lg-12 allContento" style="display: none">
            <?php
                $count = count($collab);
                $countPerDiv = round($count/3);
                if ($count%3 == 1)
                    $countPerDiv++;
                $contentCount = 0;
            ?>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($collab[$contentCount]->cover)}}" class="col-lg-12 noPadding contento-images">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder"><a href="{{route('collaborationPreview',$collab[$contentCount]->id)}}" style="color: white">{{$collab[$contentCount]->title}}</a></h4>
                                <p>{{$collab[$contentCount]->description}}</p>

                            </div>
                            <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                    <div class="col-lg-12 noPadding"><b>{{$collab[$contentCount]->ifc}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                </div>
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                    <div class="col-lg-12 noPadding"><b>{{$collab[$contentCount]->users}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">Readers</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($collab[$contentCount]->cover)}}" class="col-lg-12 noPadding contento-images">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder"><a href="{{route('collaborationPreview',$collab[$contentCount]->id)}}" style="color: white">{{$collab[$contentCount]->title}}</a></h4>
                                <p>{{$collab[$contentCount]->description}}</p>

                            </div>
                            <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                    <div class="col-lg-12 noPadding"><b>{{$collab[$contentCount]->ifc}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                </div>
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                    <div class="col-lg-12 noPadding"><b>{{$collab[$contentCount]->users}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">Readers</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($collab[$contentCount]->cover)}}" class="col-lg-12 noPadding contento-images">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder"><a href="{{route('collaborationPreview',$collab[$contentCount]->id)}}" style="color: white">{{$collab[$contentCount]->title}}</a></h4>
                                <p>{{$collab[$contentCount]->description}}</p>

                            </div>
                            <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                    <div class="col-lg-12 noPadding"><b>{{$collab[$contentCount]->ifc}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                </div>
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                    <div class="col-lg-12 noPadding"><b>{{$collab[$contentCount]->users}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">Readers</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
        <div id="med-div" class="col-lg-12 allContento" style="display: none">
            <?php
                $count = count($media);
                $countPerDiv = round($count/3);
                if ($count%3 == 1)
                    $countPerDiv++;
                $contentCount = 0;
            ?>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($media[$contentCount]->cover)}}" class="col-lg-12 noPadding contento-images">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder"><a href="{{route('mediaPreview',$media[$contentCount]->id)}}" style="color: white">{{$media[$contentCount]->title}}</a></h4>
                                <p>{{$media[$contentCount]->trivia}}</p>

                            </div>
                            <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                    <div class="col-lg-12 noPadding"><b>{{$media[$contentCount]->ifc}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                </div>
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                    <div class="col-lg-12 noPadding"><b>{{$media[$contentCount]->users}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">Views</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($media[$contentCount]->cover)}}" class="col-lg-12 noPadding contento-images">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder"><a href="{{route('mediaPreview',$media[$contentCount]->id)}}" style="color: white">{{$media[$contentCount]->title}}</a></h4>
                                <p>{{$media[$contentCount]->trivia}}</p>

                            </div>
                            <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                    <div class="col-lg-12 noPadding"><b>{{$media[$contentCount]->ifc}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                </div>
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                    <div class="col-lg-12 noPadding"><b>{{$media[$contentCount]->users}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">Views</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($media[$contentCount]->cover)}}" class="col-lg-12 noPadding contento-images">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder"><a href="{{route('mediaPreview',$media[$contentCount]->id)}}" style="color: white">{{$media[$contentCount]->title}}</a></h4>
                                <p>{{$media[$contentCount]->trivia}}</p>

                            </div>
                            <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                    <div class="col-lg-12 noPadding"><b>{{$media[$contentCount]->ifc}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                </div>
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                    <div class="col-lg-12 noPadding"><b>{{$media[$contentCount]->users}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">Views</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
        <div id="res-div" class="col-lg-12 allContento" style="display: none">
            <?php
                $count = count($resource);
                $countPerDiv = round($count/3);
                if ($count%3 == 1)
                    $countPerDiv++;
                $contentCount = 0;
            ?>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset('Images/Resource.jpg')}}" class="col-lg-12 noPadding contento-images">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder"><a href="{{route('resource',$resource[$contentCount]->id)}}" style="color: white">{{$resource[$contentCount]->title}}</a></h4>
                                <p>{{$resource[$contentCount]->description}}</p>

                            </div>
                            <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                    <div class="col-lg-12 noPadding"><b>{{$resource[$contentCount]->ifc}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                </div>
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                    <div class="col-lg-12 noPadding"><b>{{$resource[$contentCount]->users}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">Downloads</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset('Images/Resource.jpg')}}" class="col-lg-12 noPadding contento-images">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder"><a href="{{route('resource',$resource[$contentCount]->id)}}" style="color: white">{{$resource[$contentCount]->title}}</a></h4>
                                <p>{{$resource[$contentCount]->description}}</p>

                            </div>
                            <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                    <div class="col-lg-12 noPadding"><b>{{$resource[$contentCount]->ifc}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                </div>
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                    <div class="col-lg-12 noPadding"><b>{{$resource[$contentCount]->users}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">Downloads</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset('Images/Resource.jpg')}}" class="col-lg-12 noPadding contento-images">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder"><a href="{{route('resource',$resource[$contentCount]->id)}}" style="color: white">{{$resource[$contentCount]->title}}</a></h4>
                                <p>{{$resource[$contentCount]->description}}</p>

                            </div>
                            <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                    <div class="col-lg-12 noPadding"><b>{{$resource[$contentCount]->ifc}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                </div>
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                    <div class="col-lg-12 noPadding"><b>{{$resource[$contentCount]->users}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">Downloads</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
        <div id="eve-div" class="col-lg-12 allContento" style="display: none">
            <?php
                $count = count($event);
                $countPerDiv = round($count/3);
                if ($count%3 == 1)
                    $countPerDiv++;
                $contentCount = 0;
            ?>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($event[$contentCount]->cover)}}" class="col-lg-12 noPadding contento-images">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder"><a href="{{route('event',$event[$contentCount]->id)}}" style="color: white">{{$event[$contentCount]->title}}</a></h4>
                                <p>{{$event[$contentCount]->venue}}</p>
                                <p>{{$event[$contentCount]->datetime}}</p>

                            </div>
                            <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                    <div class="col-lg-12 noPadding"><b>{{$event[$contentCount]->ifc}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                </div>
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                    <div class="col-lg-12 noPadding"><b>{{$event[$contentCount]->users}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">Attending</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($event[$contentCount]->cover)}}" class="col-lg-12 noPadding contento-images">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder"><a href="{{route('event',$event[$contentCount]->id)}}" style="color: white">{{$event[$contentCount]->title}}</a></h4>
                                <p>{{$event[$contentCount]->venue}}</p>
                                <p>{{$event[$contentCount]->datetime}}</p>

                            </div>
                            <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                    <div class="col-lg-12 noPadding"><b>{{$event[$contentCount]->ifc}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                </div>
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                    <div class="col-lg-12 noPadding"><b>{{$event[$contentCount]->users}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">Attending</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding contento-divs" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($event[$contentCount]->cover)}}" class="col-lg-12 noPadding contento-images">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder"><a href="{{route('event',$event[$contentCount]->id)}}" style="color: white">{{$event[$contentCount]->title}}</a></h4>
                                <p>{{$event[$contentCount]->venue}}</p>
                                <p>{{$event[$contentCount]->datetime}}</p>

                            </div>
                            <div class="col-lg-12 ifc-reader" style="text-align: center; background-color: {{$darkColors[$contentCount%5]}}">
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px; border-right: 2px solid {{$colors[$contentCount%5]}}">
                                    <div class="col-lg-12 noPadding"><b>{{$event[$contentCount]->ifc}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">IFCs</div>
                                </div>
                                <div class="col-lg-6 contento-bottom-boxes" style="padding-top: 15px; padding-left: 15px; padding-right: 15px">
                                    <div class="col-lg-12 noPadding"><b>{{$event[$contentCount]->users}}</b></div>
                                    <div class="col-lg-12 noPadding" style="font-size: 12px">Attending</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>

