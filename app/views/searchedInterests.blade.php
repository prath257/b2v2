@foreach ($interests as $i)
    <?php $exists = false; ?>
    @foreach($top as $t)
        @if ($i->id == $t)
            <?php $exists = true; ?>
        @endif
    @endforeach
    @if (!$exists)
    <b><div id="{{$i->interest}}" class="col-lg-12" style="padding: 5px; cursor: pointer" onclick="getIntInInput(this)">{{$i->interest_name}}</div></b>
    @endif
@endforeach
    <b><div id="{{$keywords}}" class="col-lg-12" style="padding: 5px; cursor: pointer" onclick="getIntInInput(this)">{{$keywords}}</div></b>
