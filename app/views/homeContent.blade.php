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
        else
        {
            $content = Collaboration::where('category','=',$p)->orderBy('users')->take(3)->get();
            $ClassicRoutes = 'collaborationPreview';
        }
        $PIcount++;
    ?>
    @if (count($content) > 0)
    <div id="carouselwrite{{$PIcount}}" class="carousel slide carousel-fade col-lg-3">
        <h4 class="col-lg-12">{{Str::limit(Interest::find($p)->interest_name,15)}}</h4><br>
        <div class="carousel-inner">
            <?php $i=0; ?>
            @foreach ($content as $tr)
                <?php $i++; ?>
                @if ($i == 1)
                    <div class="item active">
                @else
                    <div class="item">
                @endif

                <div class="col-lg-12" style="padding: 0px">
                        <a href="{{route($ClassicRoutes,$tr->id)}}" target="_blank"><img class="col-lg-12" src="{{asset($tr->cover)}}" height="100px"></a>

                </div>
                <div class="col-lg-12" style="height: 100px; overflow: auto; padding: 0px">
                    <div>
                        <div>
                            <div class="col-lg-12 noPadding" style="padding-top: 5px">
                                <a href="{{route($ClassicRoutes,$tr->id)}}" target="_blank" class="darkLinks" style="font-size: 16px"><b>{{$tr->title}}</b></a>
                                <div class="description">{{Str::limit($tr->description,140)}}</div>
                            </div>



                        </div>
                    </div>
                </div>
                </div>
            @endforeach
        </div>
        <div style="height: 5%">
            <ul class="carousel-indicators pull-right" style="left: auto; list-style-type: none">
                <li data-target="#carouselwrite{{$PIcount}}" data-slide-to="0" class="active bottom-boxes"></li>
                <li data-target="#carouselwrite{{$PIcount}}" data-slide-to="1" class="bottom-boxes"></li>
                <li data-target="#carouselwrite{{$PIcount}}" data-slide-to="2" class="bottom-boxes"></li>
            </ul>
        </div>
    </div>
    @endif
@endforeach