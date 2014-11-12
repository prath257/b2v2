<?php $PIcount = 0; ?>
@foreach ($primary as $p)

    <?php
        if ($data == 'articles')
        {
            $content = Article::where('category','=',$p)->orderBy('users')->take(3)->get();
            $ClassicRoutes = 'articlePreview';
        }
        elseif ($data == 'bb')
        {
            $content = BlogBook::where('category','=',$p)->orderBy('users')->take(3)->get();
            $ClassicRoutes = 'blogBookPreview';
        }
        elseif ($data == 'res')
        {
            $content = Resource::where('category','=',$p)->orderBy('users')->take(3)->get();
            $ClassicRoutes = 'resource';
        }
        elseif ($data == 'media')
        {
            $content = Media::where('category','=',$p)->where('ispublic','=',true)->orderBy('users')->take(3)->get();
            $ClassicRoutes = 'mediaPreview';
        }
        elseif ($data == 'quiz')
        {
            $content = Quiz::where('category','=',$p)->orderBy('users')->take(3)->get();
            $ClassicRoutes = 'quizPreview';
        }
        elseif ($data == 'poll')
        {
            $content = DB::table('polloptions')->select(DB::raw('sum(responses) as votes, pollid'))->groupBy('pollid')->orderBy('votes','DESC')->lists('pollid');
            //$content = DB::raw('select pollid, sum(responses) as votes from polloptions group by pollid order by votes desc');

            $ClassicRoutes = 'poll';
        }
        else
        {
            $content = Collaboration::where('category','=',$p)->orderBy('users')->take(3)->get();
            $ClassicRoutes = 'collaborationPreview';
        }
        $PIcount++;
    ?>
    <?php $pollCount = 1; ?>
    @if ($data == 'poll')
        <?php $pollCount = 0; ?>
        @foreach($content as $pp)
            @if (Poll::find($pp)->category == $p && Poll::find($pp)->ispublic == true)
                    <?php $pollCount = 1; ?>
            @endif
        @endforeach
    @endif
    @if (count($content) > 0 && $pollCount == 1)

    <div id="carousel{{$data}}{{$PIcount}}" class="carousel slide carousel-fade col-lg-3">
        <h4 class="col-lg-12">{{Str::limit(Interest::find($p)->interest_name,15)}}</h4><br>
        <div class="carousel-inner">
            <?php $i=0; ?>
            @foreach ($content as $tr)
            @if ($data != 'poll' || (Poll::find($tr)->ispublic == true && Poll::find($tr)->category == $p && $i < 3))
                <?php $i++; ?>
                @if ($i == 1)
                    <div class="item active">
                @else
                    <div class="item">
                @endif

                <div class="col-lg-12" style="padding: 0px">
                @if ($data == 'quiz')
                    <a href="{{route($ClassicRoutes,$tr->id)}}" target="_blank"><img class="col-lg-12" src="{{asset('Images/Quiz.jpg')}}" height="100px"></a>
                @elseif($data == 'poll')
                    <a href="{{route($ClassicRoutes,$tr)}}" target="_blank"><img class="col-lg-12" src="{{asset('Images/Poll.png')}}" height="100px"></a>
                @elseif($data == 'res')
                    <a href="{{route($ClassicRoutes,$tr->id)}}" target="_blank"><img class="col-lg-12" src="{{asset('Images/Resource.jpg')}}" height="100px"></a>
                @else
                    <a href="{{route($ClassicRoutes,$tr->id)}}" target="_blank"><img class="col-lg-12" src="{{asset($tr->cover)}}" height="100px"></a>
                @endif

                </div>
                <div class="col-lg-12" style="height: 100px; overflow: auto; padding: 0px">
                    <div>
                        <div>
                            <div class="col-lg-12 noPadding" style="padding-top: 5px">
                            <?php
                                if ($data == 'poll')
                                    $title = Poll::find($tr)->question;
                                else
                                    $title = $tr->title;

                                if ($data == 'poll')
                                    $id = $tr;
                                else
                                    $id = $tr->id;
                            ?>
                            <a href="{{route($ClassicRoutes,$id)}}" target="_blank" class="darkLinks" style="font-size: 16px"><b>{{Str::limit($title,40)}}</b></a>

                                 <?php
                                    if ($data == 'media')
                                        $title = $tr->trivia;
                                    elseif ($data == 'poll')
                                        $title = Poll::find($tr)->message;
                                    else
                                        $title = $tr->description;
                                ?>
                                <div class="description">{{Str::limit($title,75)}}</div>
                            </div>



                        </div>
                    </div>
                </div>
                </div>
                @endif
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
                                                    <li data-target="#carousel{{$data}}{{$PIcount}}" data-slide-to="{{$contentC}}" class="bottom-boxes {{$extraClass}}"></li>
                                                @endfor
                                            </ul>
        </div>
    </div>
    @endif
@endforeach

@if ($PIcount == 0)
    <div style="text-align: center; font-size: 20px"> No data to display.</div>
@endif