<br>
<br>
<br>
<div class="col-lg-12" style="padding-left: 50px; padding-right: 50px; font-family: 'proxima-nova',proxima-nova,Arial,sans-serif">
    <div class="col-lg-3">
        <h1 style="text-transform: uppercase; font-size: 30px; font-weight: bolder">{{$user->first_name}} {{$user->last_name}}</h1>
        <br>
        <br>
        <h3 style="font-weight: bolder; font-size: 22px; text-transform: uppercase">{{Str::title($interest->interest_name)}}</h3>
        <br>
        <p style="font-size: 18px">{{$user->profile->aboutMe}}</p>
        <br>
        <div class="col-lg-12" style="color: #000000; padding: 0px">
            <?php
                $articles = $user->getArticles()->where('category','=',$interest->id)->get();
                $books = $user->getBlogBooks()->where('category','=',$interest->id)->get();
                $collab = $user->getOwnedCollaborations()->where('category','=',$interest->id)->get();
                $media = $user->getMedia()->where('ispublic','=',true)->where('category','=',$interest->id)->get();
                $resource = $user->getResources()->where('category','=',$interest->id)->get();
                $event = $user->getHostedEvents()->where('category','=',$interest->id)->get();

                $colors = array("#555450", "#1c5a5e", "#5fa09d", "#6e2f40", "#989d27");
            ?>
            <a class="col-lg-6" style="color: #000000; padding: 5px" onclick="toggleNewContent('art')"><b>{{count($articles)}}</b> Articles</a>
            <a class="col-lg-6" style="color: #000000; padding: 5px" onclick="toggleNewContent('bb')"><b>{{count($books)}}</b> BlogBooks</a>
            <a class="col-lg-6" style="color: #000000; padding: 5px" onclick="toggleNewContent('col')"><b>{{count($collab)}}</b> Collaborations</a>
            <a class="col-lg-6" style="color: #000000; padding: 5px" onclick="toggleNewContent('med')"><b>{{count($media)}}</b> Media</a>
            <a class="col-lg-6" style="color: #000000; padding: 5px" onclick="toggleNewContent('res')"><b>{{count($resource)}}</b> Resources</a>
            <a class="col-lg-6" style="color: #000000; padding: 5px" onclick="toggleNewContent('eve')"><b>{{count($event)}}</b> Events</a>
        </div>

    </div>
    <div class="col-lg-9">
        <div id="art-div" class="col-lg-12 allContento">
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
                        <div class="col-lg-12 noPadding" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($articles[$contentCount]->cover)}}" class="col-lg-12 noPadding">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder">{{$articles[$contentCount]->title}}</h4>
                                <p>{{$articles[$contentCount]->description}}</p>
                                <a href="{{route('articlePreview',$articles[$contentCount]->id)}}" class="btn btn-default">View</a>
                            </div>
                            <div class="col-lg-12" style="text-align: center">
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$articles[$contentCount]->ifc}} <i>i</i>
                                </div>
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$articles[$contentCount]->users}} Readers
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($articles[$contentCount]->cover)}}" class="col-lg-12 noPadding">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder">{{$articles[$contentCount]->title}}</h4>
                                <p>{{$articles[$contentCount]->description}}</p>
                                <a href="{{route('articlePreview',$articles[$contentCount]->id)}}" class="btn btn-default">View</a>
                            </div>
                            <div class="col-lg-12" style="text-align: center">
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$articles[$contentCount]->ifc}} <i>i</i>
                                </div>
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$articles[$contentCount]->users}} Readers
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($articles[$contentCount]->cover)}}" class="col-lg-12 noPadding">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder">{{$articles[$contentCount]->title}}</h4>
                                <p>{{$articles[$contentCount]->description}}</p>
                                <a href="{{route('articlePreview',$articles[$contentCount]->id)}}" class="btn btn-default">View</a>
                            </div>
                            <div class="col-lg-12" style="text-align: center">
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$articles[$contentCount]->ifc}} <i>i</i>
                                </div>
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$articles[$contentCount]->users}} Readers
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
                        <div class="col-lg-12 noPadding" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($books[$contentCount]->cover)}}" class="col-lg-12 noPadding">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder">{{$books[$contentCount]->title}}</h4>
                                <p>{{$books[$contentCount]->description}}</p>
                                <a href="{{route('blogBookPreview',$books[$contentCount]->id)}}" class="btn btn-default">View</a>
                            </div>
                            <div class="col-lg-12" style="text-align: center">
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$books[$contentCount]->ifc}} <i>i</i>
                                </div>
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$books[$contentCount]->users}} Readers
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($books[$contentCount]->cover)}}" class="col-lg-12 noPadding">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder">{{$books[$contentCount]->title}}</h4>
                                <p>{{$books[$contentCount]->description}}</p>
                                <a href="{{route('blogBookPreview',$books[$contentCount]->id)}}" class="btn btn-default">View</a>
                            </div>
                            <div class="col-lg-12" style="text-align: center">
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$books[$contentCount]->ifc}} <i>i</i>
                                </div>
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$books[$contentCount]->users}} Readers
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($books[$contentCount]->cover)}}" class="col-lg-12 noPadding">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder">{{$books[$contentCount]->title}}</h4>
                                <p>{{$books[$contentCount]->description}}</p>
                                <a href="{{route('blogBookPreview',$books[$contentCount]->id)}}" class="btn btn-default">View</a>
                            </div>
                            <div class="col-lg-12" style="text-align: center">
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$books[$contentCount]->ifc}} <i>i</i>
                                </div>
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$books[$contentCount]->users}} Readers
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
                        <div class="col-lg-12 noPadding" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($collab[$contentCount]->cover)}}" class="col-lg-12 noPadding">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder">{{$collab[$contentCount]->title}}</h4>
                                <p>{{$collab[$contentCount]->description}}</p>
                                <a href="{{route('collaborationPreview',$collab[$contentCount]->id)}}" class="btn btn-default">View</a>
                            </div>
                            <div class="col-lg-12" style="text-align: center">
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$collab[$contentCount]->ifc}} <i>i</i>
                                </div>
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$collab[$contentCount]->users}} Readers
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($collab[$contentCount]->cover)}}" class="col-lg-12 noPadding">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder">{{$collab[$contentCount]->title}}</h4>
                                <p>{{$collab[$contentCount]->description}}</p>
                                <a href="{{route('collaborationPreview',$collab[$contentCount]->id)}}" class="btn btn-default">View</a>
                            </div>
                            <div class="col-lg-12" style="text-align: center">
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$collab[$contentCount]->ifc}} <i>i</i>
                                </div>
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$collab[$contentCount]->users}} Readers
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($collab[$contentCount]->cover)}}" class="col-lg-12 noPadding">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder">{{$collab[$contentCount]->title}}</h4>
                                <p>{{$collab[$contentCount]->description}}</p>
                                <a href="{{route('collaborationPreview',$collab[$contentCount]->id)}}" class="btn btn-default">View</a>
                            </div>
                            <div class="col-lg-12" style="text-align: center">
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$collab[$contentCount]->ifc}} <i>i</i>
                                </div>
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$collab[$contentCount]->users}} Readers
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
                        <div class="col-lg-12 noPadding" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($media[$contentCount]->cover)}}" class="col-lg-12 noPadding">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder">{{$media[$contentCount]->title}}</h4>
                                <p>{{$media[$contentCount]->trivia}}</p>
                                <a href="{{route('mediaPreview',$media[$contentCount]->id)}}" class="btn btn-default">View</a>
                            </div>
                            <div class="col-lg-12" style="text-align: center">
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$media[$contentCount]->ifc}} <i>i</i>
                                </div>
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$media[$contentCount]->users}} Views
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($media[$contentCount]->cover)}}" class="col-lg-12 noPadding">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder">{{$media[$contentCount]->title}}</h4>
                                <p>{{$media[$contentCount]->trivia}}</p>
                                <a href="{{route('mediaPreview',$media[$contentCount]->id)}}" class="btn btn-default">View</a>
                            </div>
                            <div class="col-lg-12" style="text-align: center">
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$media[$contentCount]->ifc}} <i>i</i>
                                </div>
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$media[$contentCount]->users}} Views
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($media[$contentCount]->cover)}}" class="col-lg-12 noPadding">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder">{{$media[$contentCount]->title}}</h4>
                                <p>{{$media[$contentCount]->trivia}}</p>
                                <a href="{{route('mediaPreview',$media[$contentCount]->id)}}" class="btn btn-default">View</a>
                            </div>
                            <div class="col-lg-12" style="text-align: center">
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$media[$contentCount]->ifc}} <i>i</i>
                                </div>
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$media[$contentCount]->users}} Views
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
                        <div class="col-lg-12 noPadding" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset('Images/Resource.jpg')}}" class="col-lg-12 noPadding">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder">{{$resource[$contentCount]->title}}</h4>
                                <p>{{$resource[$contentCount]->description}}</p>
                                <a href="{{route('resource',$resource[$contentCount]->id)}}" class="btn btn-default">View</a>
                            </div>
                            <div class="col-lg-12" style="text-align: center">
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$resource[$contentCount]->ifc}} <i>i</i>
                                </div>
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$resource[$contentCount]->users}} Downloads
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset('Images/Resource.jpg')}}" class="col-lg-12 noPadding">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder">{{$resource[$contentCount]->title}}</h4>
                                <p>{{$resource[$contentCount]->description}}</p>
                                <a href="{{route('resource',$resource[$contentCount]->id)}}" class="btn btn-default">View</a>
                            </div>
                            <div class="col-lg-12" style="text-align: center">
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$resource[$contentCount]->ifc}} <i>i</i>
                                </div>
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$resource[$contentCount]->users}} Downloads
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset('Images/Resource.jpg')}}" class="col-lg-12 noPadding">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder">{{$resource[$contentCount]->title}}</h4>
                                <p>{{$resource[$contentCount]->description}}</p>
                                <a href="{{route('resource',$resource[$contentCount]->id)}}" class="btn btn-default">View</a>
                            </div>
                            <div class="col-lg-12" style="text-align: center">
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$resource[$contentCount]->ifc}} <i>i</i>
                                </div>
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$resource[$contentCount]->users}} Downloads
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
                        <div class="col-lg-12 noPadding" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($event[$contentCount]->cover)}}" class="col-lg-12 noPadding">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder">{{$event[$contentCount]->title}}</h4>
                                <p>{{$event[$contentCount]->venue}}</p>
                                <p>{{$event[$contentCount]->datetime}}</p>
                                <a href="{{route('event',$event[$contentCount]->id)}}" class="btn btn-default">View</a>
                            </div>
                            <div class="col-lg-12" style="text-align: center">
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$event[$contentCount]->ifc}} <i>i</i>
                                </div>
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$event[$contentCount]->users}} Attending
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($event[$contentCount]->cover)}}" class="col-lg-12 noPadding">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder">{{$event[$contentCount]->title}}</h4>
                                <p>{{$event[$contentCount]->venue}}</p>
                                <p>{{$event[$contentCount]->datetime}}</p>
                                <a href="{{route('event',$event[$contentCount]->id)}}" class="btn btn-default">View</a>
                            </div>
                            <div class="col-lg-12" style="text-align: center">
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$event[$contentCount]->ifc}} <i>i</i>
                                </div>
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$event[$contentCount]->users}} Attending
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-lg-4">
                @for ($i=0; $i < $countPerDiv && $contentCount < $count; $i++, $contentCount++)
                    <div class="col-lg-12" style="padding: 5px; color: white">
                        <div class="col-lg-12 noPadding" style="background-color: {{$colors[$contentCount%5]}}; border-radius: 4px">
                            <img src="{{asset($event[$contentCount]->cover)}}" class="col-lg-12 noPadding">
                            <div class="col-lg-12">
                                <h4 style="font-weight: bolder">{{$event[$contentCount]->title}}</h4>
                                <p>{{$event[$contentCount]->venue}}</p>
                                <p>{{$event[$contentCount]->datetime}}</p>
                                <a href="{{route('event',$event[$contentCount]->id)}}" class="btn btn-default">View</a>
                            </div>
                            <div class="col-lg-12" style="text-align: center">
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$event[$contentCount]->ifc}} <i>i</i>
                                </div>
                                <div class="col-lg-6" style="padding: 15px">
                                    {{$event[$contentCount]->users}} Attending
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>

