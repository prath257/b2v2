<div class="col-xs-12 col-sm-12 col-md-6 teamSchedule">
<h2 class="title">Schedule</h2>
{{$schedule}}
</div>
<div class="col-xs-12 col-sm-12 col-md-6 noPadding">
  <h3 class="title">Headlines</h3>
  @foreach($newsLinks as $link)
  <?php $tags=get_meta_tags($link);?>
  <a href="{{$link}}" target="_blank">
  <div class="col-xs-12 col-sm-12 col-md-12 newsLink">
  <div class="col-xs-4 col-sm-4 col-md-4"><img src="{{$tags['thumbnail_url']}}"></div>
  <div class="col-xs-8 col-sm-8 col-md-8"> <p>{{$tags['description']}}</p></div>
    </div>

  </a>

  @endforeach
</div>