@foreach($clubs as $club)
<div class="col-xs-12 col-sm-8 col-md-8 searchResult" onclick="getClub({{$club->id}},'{{$club->name}}')">
   <div class="col-xs-3 col-md-3 col-sm-3">
       <img src="{{$club->logo}}" width="50px" height="50px">
   </div>
   <div class="col-xs-9 col-md-9 col-sm-9">
        <div class="col-xs-12 col-sm-12 col-md-12">
           <b>{{$club->name}}</b>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12" style="font-size: 11px">
              {{SoccerLeague::find($club->league)->name}}
        </div>
   </div>
</div>
@endforeach