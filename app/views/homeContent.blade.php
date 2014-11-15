<?php $PIcount = 0;
$colors = array("#555450", "#1c5a5e", "#5fa09d", "#6e2f40", "#989d27", "#403e6f");
    $darkColors = array("#4c4b47","#185256","#559693","#5f2535","#898e21", "#373563");?>
@foreach ($primary as $p)

    <?php
        if ($data == 'articles')
        {
            $content = Article::where('category','=',$p)->orderBy('users')->take(3)->get();
            $ClassicRoutes = 'articlePreview';
            $icon = '<i class="fa fa-file-o"></i>';
        }
        elseif ($data == 'bb')
        {
            $content = BlogBook::where('category','=',$p)->orderBy('users')->take(3)->get();
            $ClassicRoutes = 'blogBookPreview';
            $icon = '<i class="fa fa-book"></i>';
        }
        elseif ($data == 'res')
        {
            $content = Resource::where('category','=',$p)->orderBy('users')->take(3)->get();
            $ClassicRoutes = 'resource';
            $icon = '<i class="fa fa-download"></i>';
        }
        elseif ($data == 'media')
        {
            $content = Media::where('category','=',$p)->where('ispublic','=',true)->orderBy('users')->take(3)->get();
            $ClassicRoutes = 'mediaPreview';
            $icon = '<i class="fa fa-film"></i>';
        }
        elseif ($data == 'quiz')
        {
            $content = Quiz::where('category','=',$p)->orderBy('users')->take(3)->get();
            $ClassicRoutes = 'quizPreview';
            $icon = '<i class="fa fa-bar-chart"></i>';
        }
        elseif ($data == 'poll')
        {
            $content = DB::table('polloptions')->select(DB::raw('sum(responses) as votes, pollid'))->groupBy('pollid')->orderBy('votes','DESC')->lists('pollid');
            //$content = DB::raw('select pollid, sum(responses) as votes from polloptions group by pollid order by votes desc');

            $ClassicRoutes = 'poll';
            $icon = '<i class="fa fa-question"></i>';
        }
        else
        {
            $content = Collaboration::where('category','=',$p)->orderBy('users')->take(3)->get();
            $ClassicRoutes = 'collaborationPreview';
            $icon = '<i class="fa fa-users"></i>';
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
<?php $colorIndex = rand(0, 5); ?>
<div id="carousel{{$data}}{{$PIcount}}" class="carousel slide carousel-fade col-lg-4 well" style="color: white; margin-bottom: 0px; background-color: {{$colors[$colorIndex]}}">
        <h4 class="col-lg-12" style="color: white; padding: 5px">{{Str::limit(Interest::find($p)->interest_name,15)}}</h4><br>

        <div class="carousel-inner">
            <?php $i=0; ?>
            @foreach ($content as $tr)
            @if ($data != 'poll' || (Poll::find($tr)->ispublic == true && Poll::find($tr)->category == $p && $i < 3))
                <?php $i++; ?>
                @if ($i == 1)
            <div class="item active" style="height: 100%">
                @else
                <div class="item" style="height: 100%">
                    @endif
                    <div class="col-lg-12" style="padding: 0px; height: 100%">

                        @if ($data == 'quiz')
                                            <a href="{{route($ClassicRoutes,$tr->id)}}" target="_blank"><img class="col-lg-12" style="padding: 0px" src="{{asset('Images/Quiz.jpg')}}" height="100px"></a>
                                        @elseif($data == 'poll')
                                            <a href="{{route($ClassicRoutes,$tr)}}" target="_blank"><img class="col-lg-12" style="padding: 0px" src="{{asset('Images/Poll.png')}}" height="100px"></a>
                                        @elseif($data == 'res')
                                            <a href="{{route($ClassicRoutes,$tr->id)}}" target="_blank"><img class="col-lg-12" style="padding: 0px" src="{{asset('Images/Resource.jpg')}}" height="100px"></a>
                                        @else
                                            <a href="{{route($ClassicRoutes,$tr->id)}}" target="_blank"><img class="col-lg-12" style="padding: 0px" src="{{asset($tr->cover)}}" height="100px"></a>
                                        @endif
                        <div class="col-lg-12" style="padding: 15px">
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
                                                    <a href="{{route($ClassicRoutes,$id)}}" target="_blank" style="font-size: 16px; color: white"><b>{{Str::limit($title,40)}}</b></a>
                        </div>
                        <div class="col-lg-12 carousel-box-holders" style="padding: 10px; background-color: {{$darkColors[$colorIndex]}}; text-align: center;">
                            <div class="col-lg-6 carousel-bottom-boxes" style="padding: 0px; border-right: solid 2px {{$colors[$colorIndex]}}">
                                <?php
                                 if ($data == 'poll' || $data == 'quiz')
                                 {
                                    if ($data == 'poll')
                                        $iddd = Poll::find($tr)->ownerid;
                                    else
                                        $iddd = $tr->ownerid;
                                 $name = User::find($iddd)->first_name.' '.User::find($iddd)->last_name;
                                 $username = User::find($iddd)->username;

                                 }

                                 else
                                 {
                                 $name = User::find($tr->userid)->first_name.' '.User::find($tr->userid)->last_name;
                                 $username = User::find($tr->userid)->username;
                                 }

                                 if ($data == 'poll')
                                    $ifccc = Poll::find($tr)->ifc;
                                 else
                                    $ifccc = $tr->ifc;
                                     ?>
                                <div class="col-lg-12" style="padding: 0px; padding-right: 5px"><a href="{{route('user',$username)}}" target="_blank" style="color: white"><small>{{Str::limit($name,20)}}</small></a></div>
                            </div>
                            <div class="col-lg-6 carousel-bottom-boxes" style="padding: 0px">
                                <div class="col-lg-6" style="padding: 0px; border-right: solid 2px {{$colors[$colorIndex]}}">
                                    {{$icon}}
                                </div>
                                <div class="col-lg-6" style="padding: 0px">{{$ifccc}} <i>i</i></div>
                            </div>
                        </div>


                    </div>
                </div>
                @endif
                @endforeach
            </div>


    </div>
    @endif
@endforeach

@if ($PIcount == 0)
    <div style="text-align: center; font-size: 20px"> No data to display.</div>
@endif