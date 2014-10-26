<ul>
@foreach($blogbooks as $book)
    <li style="list-style-type: none">
        <div>
            <img style="float: left" src="{{asset($book->getAuthor->profile->profilePic)}}" width="30px" height="30px">
            &nbsp;{{$book->getAuthor->first_name}}&nbsp;{{$book->getAuthor->last_name}} has written a new Blogbook
                <a href="{{route('previewBlogBook',$book->id)}}" style="text-decoration: none;color:forestgreen">&nbsp;{{$book->title}}</a>
          </div>
        <br>
    </li>
    @endforeach
    @foreach($articles as $article)
    <li style="list-style-type: none">
        <div>
            <img style="float: left" src="{{asset($article->getAuthor->profile->profilePic)}}" width="30px" height="30px">
            &nbsp;{{$article->getAuthor->first_name}}&nbsp;{{$article->getAuthor->last_name}} has written a new {{$article->type}}
            <a href="{{route('articlePreview',$article->id)}}" style="text-decoration: none;color:forestgreen">&nbsp;{{$article->title}}</a>
        </div>
        <br>
    </li>
    @endforeach
    @foreach($resources as $resource)
        <li style="list-style-type: none">
            <div>
                <img style="float: left" src="{{asset($resource->getAuthor->profile->profilePic)}}" width="30px" height="30px">
                &nbsp;{{$resource->getAuthor->first_name}}&nbsp;{{$resource->getAuthor->last_name}} has created a new resource
                <a href="{{route('resource',$resource->id)}}" style="text-decoration: none;color:forestgreen">&nbsp;{{$resource->title}}</a>
            </div>
            <br>
        </li>
      @endforeach
</ul>


