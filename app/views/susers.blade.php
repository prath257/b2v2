@foreach($susers as $suser)
<div id="suserbtn{{$suser->id}}" class="alert alert-info alert-dismissible" role="alert" style="cursor: pointer; margin-top: 10px; margin-bottom: 10px; padding: 10px">
    <button type="button" class="close" onclick="delSuser({{$suser->id}})"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    {{$suser->first_name}} {{$suser->last_name}}
</div>
@endforeach