<?php $currentYear = date('Y');
      $currentMonth = date('m');
      $joiningDateTime = new DateTime(Auth::user()->created_at);
      $joiningYear = $joiningDateTime->format('Y');

      $months=array("1"=>"January", "2"=>"February", "3"=>"March", "4"=>"April", "5"=>"May", "6"=>"June", "7"=>"July", "8"=>"August", "9"=>"September", "10"=>"October", "11"=>"November", "12"=>"December");
?>

<input type="hidden" id="viewedMonth" value="{{$currentMonth}}">

<div class="col-lg-12 zero-padding">
    <div class="col-lg-12 zero-padding">
        @for ($i = $joiningYear; $i <= $currentYear; $i++)
            @if ($i == $currentYear)
                <?php $visibility = 'current-year center-align'; ?>
            @else
                <?php $visibility = 'un-current-year center-align'; ?>
            @endif

            @if ($i-1 >= $joiningYear)
                <?php $prev = $i-1; ?>
            @else
                <?php $prev = 0; ?>
            @endif

            @if ($i+1 <= $currentYear)
                <?php $next = $i+1; ?>
            @else
                <?php $next = 0; ?>
            @endif

            <div id="{{$i}}" class="col-lg-12 zero-padding {{$visibility}}">
                <div id="year-{{$i}}" class="col-lg-12 zero-padding year-div">
                    <div class="col-lg-2 hand-over-me" onclick="toggleYear({{$i}},{{$prev}})">
                        <i class="fa fa-arrow-left"></i>
                    </div>

                    <div class="col-lg-8">{{$i}}</div>

                    <div class="col-lg-2 hand-over-me" onclick="toggleYear({{$i}},{{$next}})">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </div>

                <hr class="abnormal-hr">

                <div id="months-{{$i}}" class="col-lg-12 zero-padding">
                    @for ($j = 1; $j <= 12; $j++)
                        @if ($i == $currentYear && $j == $currentMonth)
                            <?php $visibility2 = 'current-month center-align'; ?>
                        @else
                            <?php $visibility2 = 'un-current-month center-align'; ?>
                        @endif

                        @if ($j-1 == 0)
                            <?php $prevMonth = 12; ?>
                        @else
                            <?php $prevMonth = $j-1; ?>
                        @endif

                        @if ($j+1 == 13)
                            <?php $nextMonth = 1; ?>
                        @else
                            <?php $nextMonth = $j+1; ?>
                        @endif

                        <div id="month-{{$i}}-{{$j}}" class="col-lg-12 zero-padding {{$visibility2}}">
                            <div class="col-lg-2 hand-over-me month-div" onclick="toggleMonth({{$i}},{{$j}},{{$prevMonth}})" style="padding-left: 20px">
                                <i class="fa fa-arrow-left"></i>
                            </div>

                            <div class="col-lg-8 month-div">{{$months[$j]}}</div>

                            <div class="col-lg-2 hand-over-me month-div" onclick="toggleMonth({{$i}},{{$j}},{{$nextMonth}})">
                                <i class="fa fa-arrow-right"></i>
                            </div>

                            <hr class="abnormal-hr">

                            @if ($j == 1 || $j == 3 || $j == 5 || $j == 7 || $j == 8 || $j == 10 || $j == 12)
                                <?php $days = 31; ?>
                            @elseif ($j == 4 || $j == 6 || $j == 9 || $j == 11)
                                <?php $days = 30; ?>
                            @else
                                @if (($i%4 == 0 && $i%100 != 0) || $i%400 == 0)
                                    <?php $days = 29; ?>
                                @else
                                    <?php $days = 28; ?>
                                @endif
                            @endif

                            <div class="col-lg-12 center-align zero-padding date-div">
                                @for ($k = 1; $k <= $days; $k++)
                                    <?php $posts = DB::table('diary')->where('userid','=',$userid)->get();
                                    $counttt = 0;
                                        foreach ($posts as $p)
                                        {

                                            $postDate = $p->created_at;
                                            $postDate = new DateTime($postDate);
                                            $date = $postDate->format('m/d/Y');

                                            $s = ''.$i.'-'.$j.'-'.$k.' 18:07:00';
                                            $dt = new DateTime($s);

                                            $date2 = $dt->format('m/d/Y');

                                            if ($date == $date2)
                                                $counttt++;
                                        }
                                    ?>
                                    @if ($counttt == 0)
                                    <div class="col-lg-2">{{$k}}</div>
                                    @else
                                    <div class="col-lg-2 hand-over-me" onclick="retrieveAll({{$k}},{{$j}},{{$i}},{{$userid}})" style="color: green"><b>{{$k}}</b></div>
                                    @endif
                                @endfor
                            </div>

                            <hr class="abnormal-hr">

                        </div>
                    @endfor
                </div>
            </div>
        @endfor
    </div>

</div>