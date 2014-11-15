<button class="btn btn-warning" onclick="newSuggestion('{{$request}}')">+ New</button>
<hr>
@foreach ($suggestions as $s)
    <a style="font-size: 20px; cursor: pointer" onclick="writeSuggestion('{{$s->type}}','{{$s->text}}','{{$s->category}}')">{{$s->text}}</a>
    <hr>
@endforeach

@if (count($suggestions) == 0)
    <h4>No suggestions found.</h4>
@endif