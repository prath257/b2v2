@if ($type == 'articles')
    @if (count($articles) > 0)
        <div class="col-lg-12" style="padding-top: 15px; padding-bottom: 0px; padding-left: 0px; padding-right: 0px">
            @foreach ($articles as $article)
                <div class="col-lg-3">
                    <div class="thumbnail">
                        <img class="images" src="{{asset($article->cover)}}" height="250px" width="250px">
                        <div class="caption">
                            <h4 class="contentTitle">{{$article->title}}</h4>
                            <div style="text-align: right">{{$article->ifc}} IFCs</div>
                            <p><a href="{{route('articlePreview',$article->id)}}" class="btn btn-primary" target="_blank" role="button">View</a></p>
                        </div>
                    </div>
                </div>
            @endforeach
            <input id="remainingArticles{{$articleCount}}" type="hidden" value="{{$remainingArticles}}">
        </div>
    @endif
@elseif ($type == 'books')
    @if (count($books) > 0)
        <div class="col-lg-12" style="padding-top: 15px; padding-bottom: 0px; padding-left: 0px; padding-right: 0px">
            @foreach ($books as $book)
                <div class="col-lg-3">
                    <div class="thumbnail">
                        <img class="images" src="{{asset($book->cover)}}" height="250px" width="250px">
                        <div class="caption">
                            <h4 class="contentTitle">{{$book->title}}</h4>
                            <div style="text-align: right">{{$book->ifc}} IFCs</div>
                            @if ($book->review)
                                <p><a href="{{route('blogBookPreview',$book->id)}}" class="btn btn-primary" target="_blank" role="button">View</a></p>
                            @else
                                <p><a href="{{route('collaborationPreview',$book->id)}}" class="btn btn-primary" target="_blank" role="button">View</a></p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            <input id="remainingBooks{{$bookCount}}" type="hidden" value="{{$remainingBooks}}">
        </div>
    @endif
@elseif ($type == 'resources')
    @if (count($resources) > 0)
        <div class="col-lg-12" style="padding-top: 15px; padding-bottom: 0px; padding-left: 0px; padding-right: 0px">
            @foreach ($resources as $resource)
                <div class="col-lg-3">
                    <div class="thumbnail">
                        <img class="images" src="{{asset('Images/Resource.jpg')}}" height="250px" width="250px">
                        <div class="caption">
                            <h4 class="contentTitle">{{$resource->title}}</h4>
                            <div style="text-align: right">{{$resource->ifc}} IFCs</div>
                            <p><a href="{{route('resource',$resource->id)}}" class="btn btn-primary" target="_blank" role="button">View</a></p>
                        </div>
                    </div>
                </div>
            @endforeach
            <input id="remainingResources{{$resourceCount}}" type="hidden" value="{{$remainingResources}}">
        </div>
    @endif
@elseif ($type == 'pollsNQuizes')
    @if (count($pollsNQuizes) > 0)
        <div class="col-lg-12" style="padding-top: 15px; padding-bottom: 0px; padding-left: 0px; padding-right: 0px">
            @foreach ($pollsNQuizes as $pnq)
                <div class="col-lg-3">
                    <div class="thumbnail">
                        @if ($pnq->title)
                            <img class="images" src="{{asset('Images/Quiz.jpg')}}" height="250px" width="250px">
                            <div class="caption">
                                <h4 class="contentTitle">{{$pnq->title}}</h4>
                                <div style="text-align: right">{{$pnq->ifc}} IFCs</div>
                                <p><a href="{{route('quizPreview',$pnq->id)}}" class="btn btn-primary" target="_blank" role="button">View</a></p>
                        @else
                            <img class="images" src="{{asset('Images/Poll.png')}}" height="250px" width="250px">
                            <div class="caption">
                                <h4 class="contentTitle">{{$pnq->question}}</h4>
                                <div style="text-align: right">{{$pnq->ifc}} IFCs</div>
                                <p><a href="{{route('poll',$pnq->id)}}" class="btn btn-primary" target="_blank" role="button">View</a></p>
                        @endif
                            </div>
                    </div>
                </div>
            @endforeach
            <input id="remainingPollsNQuizes{{$pollQuizCount}}" type="hidden" value="{{$remainingPollsNQuizes}}">
        </div>
    @endif
@endif