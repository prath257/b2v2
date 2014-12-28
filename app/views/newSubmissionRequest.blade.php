

<div class="col-lg-10 col-lg-offset-1">

    <h3> Hey There,</h3>
    <hr>

    <p>
        <a href="{{route('user',$user->username)}}" style="text-decoration: none">{{$user->first_name}} {{$user->last_name}}</a> just submitted
        @if ($review->type == 'article')
        an article for review.
        <br>
        <a href="{{route('reviewArticle',$content->id)}}" style="text-decoration: none" target="_blank">{{$content->title}}</a>
        @elseif ($review->type == 'book')
        a blogbook for review.
        <br>
        <a href="{{url('reviewBlogBook/'.$content->id)}}" style="text-decoration: none" target="_blank">{{$content->title}}</a>
        @endif
    </p>
    <hr>
    <p>Regards,<br>BBarters Team</p>
</div>

