<?php
    $i=0;
    $colors = array("#555450", "#1c5a5e", "#5fa09d", "#6e2f40", "#989d27", "#403e6f");
    $darkColors = array("#4c4b47","#185256","#559693","#5f2535","#898e21", "#373563");
?>

<div id="bbarticles" class="col-lg-4" style="padding-left: 5px; padding-right: 5px; padding-bottom: 5px">
<?php if (count($articles) > 0)
{
    $colorIndex = rand(0, 5); ?>
    <?php $j=0; ?>
    @foreach($articles as $article)
        <?php $j++; ?>
<div id="carousel2" class="carousel slide carousel-fade col-lg-12 well" style="color: white; background-color: {{$colors[$colorIndex]}}">
<div class="carousel-inner">


    <div class="item active" style="height: 100%">
            <div class="col-lg-12" style="padding: 0px; height: 100%">

                <img class="col-lg-12 img1" src="{{asset($article->cover)}}" onclick="viewArticle({{$article->id}})" style="max-height: 300px; padding: 0px; cursor: pointer">
                <div class="col-lg-12" style="padding: 15px">
                <a class="col-lg-12" href="{{route('articlePreview',$article->id)}}" style="text-decoration: none; padding: 0px; color: white; font-size: 15px"><b>{{Str::title($article->title)}}</b></a>
                </div>
                <div class="col-lg-12 carousel-box-holders" style="padding: 10px; background-color: {{$darkColors[$colorIndex]}}; text-align: center;">
                    <div class="col-lg-6 carousel-bottom-boxes" style="padding: 0px; border-right: solid 2px {{$colors[$colorIndex]}}">
                        <?php $name = $article->getAuthor->first_name.' '.$article->getAuthor->last_name; ?>
                        <?php $username = $article->getAuthor->username; ?>
                        <div class="col-lg-12" style="padding: 0px; padding-right: 5px"><a href="{{route('user',$username)}}" target="_blank" style="color: white"><small>{{Str::limit($name,20)}}</small></a></div>
                    </div>
                    <div class="col-lg-6 carousel-bottom-boxes" style="padding: 0px">
                        <div class="col-lg-6" style="padding: 0px; border-right: solid 2px {{$colors[$colorIndex]}}"><i class="fa fa-file-o"></i></div>
                        <div class="col-lg-6" style="padding: 0px">{{$article->ifc}} <i>i</i></div>
                    </div>
                </div>


            </div>
        </div>

    </div>
</div>
@endforeach
<?php
}
?>
<?php if (count($blogbooks) > 0)
{
        $colorIndex = rand(0, 5); ?>
        <?php $j=0; ?>
                @foreach($blogbooks as $book)
                <?php $j++; ?>
    <div id="carousel1" class="carousel slide carousel-fade col-lg-12 well" style="color: white; margin-bottom: 0px; background-color: {{$colors[$colorIndex]}}">
    <div class="carousel-inner">

        <div class="item active">
                <div class="col-lg-12" style="padding: 0px">

                    <img class="col-lg-12 img2" src="{{asset($book->cover)}}" onclick="viewBlogBook({{$book->id}})" style="max-height: 300px; padding: 0px; cursor: pointer">
                    <div class="col-lg-12" style="padding: 15px">
                        <a class="col-lg-12" href="{{route('blogBookPreview',$book->id)}}" style="text-decoration: none; padding: 0px; color: white; font-size: 15px"><b>{{Str::title($book->title)}}</b></a>
                    </div>
                <div class="col-lg-12 carousel-box-holders" style="padding: 10px; background-color: {{$darkColors[$colorIndex]}}; text-align: center">
                    <div class="col-lg-6 carousel-bottom-boxes" style="padding: 0px; border-right: solid 2px {{$colors[$colorIndex]}}">
                        <?php $name = $book->getAuthor->first_name.' '.$book->getAuthor->last_name; ?>
                        <?php $username = $book->getAuthor->username; ?>
                        <div class="col-lg-12" style="padding: 0px; padding-right: 5px"><a href="{{route('user',$username)}}" target="_blank" style="color: white"><small>{{Str::limit($name,20)}}</small></a></div>

                    </div>
                    <div class="col-lg-6 carousel-bottom-boxes" style="padding: 0px">
                    <div class="col-lg-6" style="padding: 0px; border-right: solid 2px {{$colors[$colorIndex]}}"><i class="fa fa-book"></i></div>
                        <div class="col-lg-6" style="padding: 0px">{{$book->ifc}} <i>i</i></div>

                    </div>
                </div>

                </div>
            </div>

        </div>
    </div>
@endforeach
<?php
}
?>
    </div>

    <div class="col-lg-4" style="padding-left: 5px; padding-right: 5px; padding-bottom: 5px">
<?php if (count($resources) > 0)
{
    $colorIndex = rand(0, 5); ?>
    <?php $j=0; ?>
        @foreach($resources as $resource)
        <?php $j++; ?>
<div id="carousel3" class="carousel slide carousel-fade col-lg-12 well" style="color: white; background-color: {{$colors[$colorIndex]}}">
<div class="carousel-inner">

    <div class="item active">
            <div class="col-lg-12" style="padding: 0px">

                <img class="col-lg-12 img3" src="{{asset('Images/Resource.jpg')}}" onclick="viewResource({{$resource->id}})" style="max-height: 300px; padding: 0px; cursor: pointer">
                <div class="col-lg-12" style="padding: 15px">
                    <a class="col-lg-12" href="{{route('resource',$resource->id)}}" style="text-decoration: none; padding: 0px; color: white; font-size: 15px"><b>{{Str::title($resource->title)}}</b></a>
                </div>
                <div class="col-lg-12 carousel-box-holders" style="padding: 10px; background-color: {{$darkColors[$colorIndex]}}; text-align: center">
                    <div class="col-lg-6 carousel-bottom-boxes" style="padding: 0px; border-right: solid 2px {{$colors[$colorIndex]}}">
                        <?php $name = $resource->getAuthor->first_name.' '.$resource->getAuthor->last_name; ?>
                        <?php $username = $resource->getAuthor->username; ?>
                        <div class="col-lg-12" style="padding: 0px; padding-right: 5px"><a href="{{route('user',$username)}}" target="_blank" style="color: white"><small>{{Str::limit($name,20)}}</small></a></div>

                    </div>
                    <div class="col-lg-6 carousel-bottom-boxes" style="padding: 0px">
                        <div class="col-lg-6" style="padding: 0px; border-right: solid 2px {{$colors[$colorIndex]}}"><i class="fa fa-download"></i></div>
                        <div class="col-lg-6" style="padding: 0px">{{$resource->ifc}} <i>i</i></div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
 @endforeach
<?php
}
?>

<?php if (count($collaborations) > 0 || count($contributions) > 0)
{
    $colorIndex = rand(0, 5); ?>
    <?php $j=0; ?>
        @foreach($collaborations as $collab)
            <?php $j++; ?>
<div id="carousel4" class="carousel slide carousel-fade col-lg-12 well" style="color: white; margin-bottom: 0px; background-color: {{$colors[$colorIndex]}}">
<div class="carousel-inner">

            <div class="item active">
                <div class="col-lg-12" style="padding: 0px">

                    <img class="col-lg-12 img4" src="{{asset($collab->cover)}}" onclick="viewCollaboration({{$collab->id}})" style="max-height: 300px; padding: 0px; cursor: pointer">
                    <div class="col-lg-12" style="padding: 15px">
                        <a class="col-lg-12" href="{{route('collaborationPreview',$collab->id)}}" style="text-decoration: none; padding: 0px; color: white; font-size: 15px"><b>{{Str::title($collab->title)}}</b></a>
                    </div>
                <div class="col-lg-12 carousel-box-holders" style="padding: 10px; background-color: {{$darkColors[$colorIndex]}}; text-align: center">
                    <div class="col-lg-6 carousel-bottom-boxes" style="padding: 0px; border-right: solid 2px {{$colors[$colorIndex]}}">
                    <?php $name = $collab->getAdmin->first_name.' '.$collab->getAdmin->last_name; ?>
                    <?php $username = $collab->getAdmin->username; ?>
                    <div class="col-lg-12" style="padding: 0px; padding-right: 5px"><a href="{{route('user',$username)}}" target="_blank" style="color: white"><small>{{Str::limit($name,20)}}</small></a></div>

                    </div>
                    <div class="col-lg-6 carousel-bottom-boxes" style="padding: 0px">
                    <div class="col-lg-6" style="padding: 0px; border-right: solid 2px {{$colors[$colorIndex]}}"><i class="fa fa-users"></i></div>
                        <div class="col-lg-6" style="padding: 0px">{{$collab->ifc}} <i>i</i></div>
                    </div>
                </div>


                </div>
            </div>
            </div>
            </div>
    @endforeach

    @foreach($contributions as $collab)
    <?php $j++; ?>
    <div id="carousel4" class="carousel slide carousel-fade col-lg-12 well" style="color: white; margin-bottom: 0px; background-color: {{$colors[$colorIndex]}}">
    <div class="carousel-inner">
    <div class="item active">
            <div class="col-lg-12" style="padding: 0px">

                <img class="col-lg-12 img5" src="{{asset($collab->cover)}}" onclick="viewCollaboration({{$collab->id}})" style="max-height: 300px; padding: 0px; cursor: pointer">
                <div class="col-lg-12" style="padding: 15px">
                    <a class="col-lg-12" href="{{route('collaborationPreview',$collab->id)}}" style="text-decoration: none; padding: 0px; color: white; font-size: 15px"><b>{{Str::title($collab->title)}}</b></a>
                </div>
                <div class="col-lg-12 carousel-box-holders" style="padding: 10px; background-color: {{$darkColors[$colorIndex]}}; text-align: center">
                    <div class="col-lg-6 carousel-bottom-boxes" style="padding: 0px; border-right: solid 2px {{$colors[$colorIndex]}}">
                    <?php $name = $collab->getAdmin->first_name.' '.$collab->getAdmin->last_name; ?>
                    <?php $username = $collab->getAdmin->username; ?>
                                        <div class="col-lg-12" style="padding: 0px; padding-right: 5px"><a href="{{route('user',$username)}}" target="_blank" style="color: white"><small>{{Str::limit($name,20)}}</small></a></div>

                    </div>
                    <div class="col-lg-6 carousel-bottom-boxes" style="padding: 0px">
                        <div class="col-lg-6" style="padding: 0px; border-right: solid 2px {{$colors[$colorIndex]}}"><i class="fa fa-users"></i></div>
                        <div class="col-lg-6" style="padding: 0px">{{$collab->ifc}} <i>i</i></div>
                    </div>
                </div>
            </div>
        </div>
        <?php $i++; ?>


    </div>
</div>
@endforeach
<?php
}
?>
    </div>

    <div class="col-lg-4" style="padding-left: 5px; padding-right: 5px; padding-bottom: 5px">
<?php if (count($media) > 0)
{
    $colorIndex = rand(0, 5); ?>
    <?php $j=0; ?>
        @foreach($media as $med)
        <?php $j++; ?>
<div id="carousel5" class="carousel slide carousel-fade col-lg-12 well" style="color: white; background-color: {{$colors[$colorIndex]}}">
<div class="carousel-inner">

    <div class="item active">
            <div class="col-lg-12" style="padding: 0px">

                <img class="col-lg-12 img5" src="{{asset($med->cover)}}" onclick="viewMedia({{$med->id}})" style="max-height: 300px; padding: 0px; cursor: pointer">
                <div class="col-lg-12" style="padding: 15px">
                    <a class="col-lg-12" href="{{route('mediaPreview',$med->id)}}" style="text-decoration: none; padding: 0px; color: white; font-size: 15px"><b>{{Str::title($med->title)}}</b></a>
                </div>
                <div class="col-lg-12 carousel-box-holders" style="padding: 10px; background-color: {{$darkColors[$colorIndex]}}; text-align: center">
                    <div class="col-lg-6 carousel-bottom-boxes" style="padding: 0px; border-right: solid 2px {{$colors[$colorIndex]}}">
                    <?php $name = $med->getAuthor->first_name.' '.$med->getAuthor->last_name; ?>
                    <?php $username = $med->getAuthor->username; ?>
                    <div class="col-lg-12" style="padding: 0px; padding-right: 5px"><a href="{{route('user',$username)}}" target="_blank" style="color: white"><small>{{Str::limit($name,20)}}</small></a></div>

                    </div>
                    <div class="col-lg-6 carousel-bottom-boxes" style="padding: 0px">
                    <div class="col-lg-6" style="padding: 0px; border-right: solid 2px {{$colors[$colorIndex]}}"><i class="fa fa-film"></i></div>
                        <div class="col-lg-6" style="padding: 0px">{{$med->ifc}} <i>i</i></div>
                    </div>
                </div>

            </div>
        </div>
        <?php $i++; ?>

    </div>
</div>
@endforeach
<?php
}
?>

<?php if (count($pollsnquizes) > 0)
{
    $colorIndex = rand(0, 5); ?>
    <?php $j=0; ?>
        @foreach($pollsnquizes as $pnq)
        <?php $j++; ?>
<div id="carousel6" class="carousel slide carousel-fade col-lg-12 well" style="color: white; margin-bottom: 0px; background-color: {{$colors[$colorIndex]}}">
<div class="carousel-inner">

    <div class="item active">
            <div class="col-lg-12" style="padding: 0px">
                @if ($pnq->title)

                <img class="col-lg-12 img6" src="{{asset('Images/Quiz.jpg')}}" onclick="viewQuiz({{$pnq->id}})" style="max-height: 300px; padding: 0px; cursor: pointer">
                <div class="col-lg-12" style="padding: 15px">
                    <a class="col-lg-12" href="{{route('quizPreview',$pnq->id)}}" style="text-decoration: none; padding: 0px; color: white; font-size: 15px"><b>{{Str::title($pnq->title)}}</b></a>
                </div>
                <div class="col-lg-12 carousel-box-holders" style="padding: 10px; background-color: {{$darkColors[$colorIndex]}}; text-align: center">
                    <div class="col-lg-6 carousel-bottom-boxes" style="padding: 0px; border-right: solid 2px {{$colors[$colorIndex]}}">
                    <?php $name = User::find($pnq->ownerid)->first_name.' '.User::find($pnq->ownerid)->last_name; ?>
                    <?php $username = User::find($pnq->ownerid)->username; ?>
                                        <div class="col-lg-12" style="padding: 0px; padding-right: 5px"><a href="{{route('user',$username)}}" target="_blank" style="color: white"><small>{{Str::limit($name,20)}}</small></a></div>

                    </div>
                    <div class="col-lg-6 carousel-bottom-boxes" style="padding: 0px">
                    <div class="col-lg-6" style="padding: 0px; border-right: solid 2px {{$colors[$colorIndex]}}"><i class="fa fa-question"></i></div>
                        <div class="col-lg-6" style="padding: 0px">{{$pnq->ifc}} <i>i</i></div>
                    </div>
                </div>
                @else

                <img class="col-lg-12 img6" src="{{asset('Images/Poll.png')}}" onclick="viewPoll({{$pnq->id}})" style="max-height: 300px; padding: 0px; cursor: pointer">
                <div class="col-lg-12" style="padding: 15px">
                    <a class="col-lg-12" href="{{route('poll',$pnq->id)}}" style="text-decoration: none; padding: 0px; color: white; font-size: 15px"><b>{{Str::title($pnq->question)}}</b></a>
                </div>
                <div class="col-lg-12 carousel-box-holders" style="padding: 10px; background-color: {{$darkColors[$colorIndex]}}; text-align: center">
                    <div class="col-lg-6 carousel-bottom-boxes" style="padding: 0px; border-right: solid 2px {{$colors[$colorIndex]}}">
                    <?php $name = User::find($pnq->ownerid)->first_name.' '.User::find($pnq->ownerid)->last_name; ?>
                    <?php $username = User::find($pnq->ownerid)->username; ?>
                                        <div class="col-lg-12" style="padding: 0px; padding-right: 5px"><a href="{{route('user',$username)}}" target="_blank" style="color: white"><small>{{Str::limit($name,20)}}</small></a></div>

                    </div>
                    <div class="col-lg-6 carousel-bottom-boxes" style="padding: 0px">
                    <div class="col-lg-6" style="padding: 0px; border-right: solid 2px {{$colors[$colorIndex]}}"><i class="fa fa-bar-chart"></i></div>
                        <div class="col-lg-6" style="padding: 0px">{{$pnq->ifc}} <i>i</i></div>
                    </div>
                </div>
                @endif

            </div>
        </div>
        <?php $i++; ?>

    </div>
</div>
@endforeach
<?php
}
?>
    </div>
