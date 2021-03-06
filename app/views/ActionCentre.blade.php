@if ($moreActions == null && $count == null)
    <div class="col-xs-12 col-sm-12 col-md-12">

    <div id="ActionContent" style="max-height: 450px; overflow: auto;">
@endif
    @foreach ($actions as $action)
    <?php $user1=User::find($action->user1id);?>
    <div class="col-xs-12 col-sm-12 col-md-12 action-jackson" style="padding-left: 0px; padding-right: 0px; padding-top: 10px; padding-bottom: 10px">
        <a href="{{route('user',$user1->username)}}"><img class="actionImages" style="float:left; width:50px; height: 50px; margin-right: 10px" src="{{$user1->profile->profilePic}}"/></a>
    @if($action->type=='A new')

    <p id="action"><a href="{{route('user',$user1->username)}}">{{$user1->first_name}} {{$user1->last_name}}</a> posted a new {{Article::find($action->contentid)->type}}
            <a href="{{route('articlePreview',Article::find($action->contentid)->id)}}">{{Article::find($action->contentid)->title}}</a> </p>

    @elseif($action->type=='newUser')

            <p id="action"><a href="{{route('user',$user1->username)}}">{{$user1->first_name}} {{$user1->last_name}}</a> has become a barter now.</p>

    @elseif($action->type=='BB new')

    <p id="action"><a href="{{route('user',$user1->username)}}">{{$user1->first_name}} {{$user1->last_name}}</a> posted a new BlogBook
            <a href="{{route('blogBookPreview',BlogBook::find($action->contentid)->id)}}">{{BlogBook::find($action->contentid)->title}}</a> </p>

    @elseif($action->type=='newFeed')

        <p id="action"><a href="{{route('liveSoccer',$action->contentid)}}">{{$action->message}}</a></p>

    @elseif($action->type=='newMatchRating')

            <p id="action"><a href="/getMatchRatings/{{$action->contentid}}/{{$action->user1id}}">{{$action->message}}</a></p>
    @elseif($action->type=='predOn')
            <p id="action"><a href="/playPredictor">{{$action->message}}</a></p>
    @elseif($action->type=='BB new chapter')

    <p id="action"><a href="{{route('user',$user1->username)}}">{{$user1->first_name}} {{$user1->last_name}}</a> posted a new chapter in BlogBook
            <a href="{{route('blogBookPreview',BlogBook::find($action->contentid)->id)}}">{{BlogBook::find($action->contentid)->title}}</a> </p>



    @elseif($action->type=='C new')

    <p id="action"><a href="{{route('user',$user1->username)}}">{{$user1->first_name}} {{$user1->last_name}}</a>
    posted a new Collaboration
    <a href="{{route('collaborationPreview',Collaboration::find($action->contentid)->id)}}">
    {{Collaboration::find($action->contentid)->title}}</a> </p>



    @elseif($action->type=='C new chapter')

    <p id="action"><a href="{{route('user',$user1->username)}}">{{$user1->first_name}} {{$user1->last_name}}</a> posted a new chapter in Collaboration
            <a href="{{route('collaborationPreview',Collaboration::find($action->contentid)->id)}}">{{Collaboration::find($action->contentid)->title}}</a> </p>


    @elseif($action->type=='C req')

    <p id="action"><a href="{{route('user',$user1->username)}}">{{$user1->first_name}} {{$user1->last_name}}</a> is now contributing to Collaboration
            <a href="{{route('collaborationPreview',Collaboration::find($action->contentid)->id)}}">{{Collaboration::find($action->contentid)->title}}</a> </p>



    @elseif($action->type=='M new')

    <p id="action"><a href="{{route('user',$user1->username)}}">{{$user1->first_name}} {{$user1->last_name}}</a> uploaded new Media
            <a href="{{route('mediaPreview',Media::find($action->contentid)->id)}}">{{Media::find($action->contentid)->title}}</a> </p>



    @elseif($action->type=='R new')

    <p id="action"><a href="{{route('user',$user1->username)}}">{{$user1->first_name}} {{$user1->last_name}}</a> uploaded new Resource
            <a href="{{route('resource',Resource::find($action->contentid)->id)}}">{{Resource::find($action->contentid)->title}}</a> </p>



    @elseif($action->type=='E new')
    <p id="action"><a href="{{route('user',$user1->username)}}">{{$user1->first_name}} {{$user1->last_name}}</a> is hosting a new Event
            <a href="{{route('event',BEvent::find($action->contentid)->id)}}">{{BEvent::find($action->contentid)->name}}</a> </p>



    @elseif($action->type=='P new')
    <p id="action"><a href="{{route('user',$user1->username)}}">{{$user1->first_name}} {{$user1->last_name}}</a> posted a new Poll:
            <a href="{{route('poll',Poll::find($action->contentid)->id)}}"><i>{{Str::limit(Poll::find($action->contentid)->question,50)}}</i></a> </p>



    @elseif($action->type=='Q new')
    <p id="action"><a href="{{route('user',$user1->username)}}">{{$user1->first_name}} {{$user1->last_name}}</a> posted a new Quiz
            <a href="{{route('quizPreview',Quiz::find($action->contentid)->id)}}">{{Quiz::find($action->contentid)->title}}</a> </p>

        @elseif($action->type=='Q score')
        <p id="action"><a href="{{route('user',$user1->username)}}">{{$user1->first_name}} {{$user1->last_name}}</a> earned {{$action->user2id}} IFCs by taking the Quiz
            <a href="{{route('quizPreview',Quiz::find($action->contentid)->id)}}">{{Quiz::find($action->contentid)->title}}</a> </p>

@elseif($action->type=='Recco new')
    <p id="action"><a href="{{route('user',$user1->username)}}">{{$user1->first_name}} {{$user1->last_name}}</a> recommends
            <a onclick="visitRecco({{$action->contentid}},'{{Recco::find($action->contentid)->url}}')" style="cursor: pointer">{{Recco::find($action->contentid)->title}}</a> </p>


@elseif($action->type=='Diary new')
    <p id="action"><a href="{{route('user',$user1->username)}}">{{$user1->first_name}} {{$user1->last_name}}</a> made a new post to
    @if($user1->gender=='male')
    his
    @else
    her
    @endif
    <a href="{{route('diary',$user1->username)}}"> diary</a> </p>
@endif
</div>
@endforeach


@if ($count == null && $moreActions == null)
</div>
</div>
@else
<input type="hidden" id="moreActions{{$count}}" value="{{$moreActions}}">
@endif
