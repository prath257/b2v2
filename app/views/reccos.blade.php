@foreach($reccos as $recco)
    <div class="thumbnail col-lg-12 reccos" style="color: #000000; padding-top: 15px">
        <div class="col-lg-10">
            <div class="col-lg-12" style="padding: 0px; margin-bottom: 10px">
                <h4 style="text-transform: none"><b>{{{$recco->title}}}</b></h4>
                <small>- Recommended by <a href="{{route('user',$recco->user->username)}}" target="_blank">{{$recco->user->first_name}} {{$recco->user->last_name}}</a></small>
            </div>
            <div class="col-lg-12" style="padding: 0px">
                <p id="original{{$recco->id}}">{{{Str::limit($recco->description,140)}}}
                @if (Str::length($recco->description) > 140)
                    <a id="moreRecco{{$recco->id}}" onclick="readMoreRecco({{$recco->id}})" style="cursor: pointer"> Read more</a>
                </p>
                    <?php $remaining = substr($recco->description,140); ?>
                    <p id="remaining{{$recco->id}}" style="display: none">{{{$remaining}}}</p>
                @else
                    </p>
                @endif
                <button class="btn btn-primary" onclick="visitRecco({{$recco->id}},'{{$recco->url}}')">Visit Link</button>
                @if ($recco->userid == Auth::user()->id)
                    <button class="btn btn-danger" onclick="deleteRecco({{$recco->id}})">Delete Recommendation</button>
                @endif
            </div>
        </div>
        <div class="col-lg-2">
            <img class="col-lg-12" src="{{$recco->image}}" style="height: 100px; padding: 0px">
            <p class="col-lg-12" style="text-align: center"><b>{{$recco->hits}}</b> HITS</p>
        </div>
    </div>
@endforeach

@if ($moreReccos > 0)
    <div id="recco-wait-{{$target}}-{{$count}}" class="recco-wait-{{$target}}" style="text-align: center"><button id="load-more-recco-{{$target}}-{{$count}}" class="btn btn-default load-more-recco-{{$target}}" style="display: none" onclick="loadMoreReccos('{{$target}}',{{$count}})">Load more</button><div id="waiting-{{$target}}-{{$count}}" style="display: none"><img src="{{asset('Images/icons/waiting.gif')}}"> Loading..</div><br><br></div>
@endif

@if (count($reccos) == 0)
    <div style="text-align: center; font-family: 'Segoe UI Light', 'Helvetica Neue', 'RobotoLight', 'Segoe UI', 'Segoe WP', sans-serif; font-size: 20px"> <br>No recommendations found.</div>
@endif