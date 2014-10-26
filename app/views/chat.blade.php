@foreach ($chatdata as $cd)
    @if ($cd->senderid==Auth::user()->id)
        <div style='word-wrap: break-word; font-family: "Segoe UI"'><b>Me: </b>{{{$cd->text}}}</div><div class='col-lg-12'>&nbsp;</div>
    @else
        <div style='word-wrap: break-word; font-family: "Segoe UI"'><b>{{User::find($cd->senderid)->first_name}}: </b>{{{$cd->text}}}</div><div class='col-lg-12'>&nbsp;</div>
    @endif
@endforeach

