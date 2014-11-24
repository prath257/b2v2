<?php $intExistsFlag = false; ?>
@foreach ($interests as $i)
    <?php $exists = false; ?>
    @foreach($top as $t)
        @if ($i->id == $t)
            <?php $exists = true; ?>
        @endif
    @endforeach
    @if (!$exists)
    <b><div id="{{$i->interest_name}}" class="col-lg-12" style="padding: 5px; cursor: pointer" onclick="getIntInInput(this)">{{$i->interest_name}}</div></b>
    @endif
    @if (Str::lower($i->interest) == Str::lower($keywords))
        <?php $intExistsFlag = true; ?>
    @endif
@endforeach @if(!$intExistsFlag)<b><div id="{{Str::title($keywords)}}" class="col-lg-12" style="padding: 5px; cursor: pointer" onclick="getIntInInput(this)">{{Str::title($keywords)}}</div></b>@endif
