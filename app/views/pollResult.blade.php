<fieldset>
    @if($total!=0)
    @foreach($responses as $response)
    <div class="col-lg-12" style="padding: 0px">
        <?php
        $rv=round(($response->responses *100)/$total);
        ?>
        <h3>{{$response->option}}</h3>
        <div class="progress col-lg-9" style="padding: 0px">
            <div class="progress-bar" role="progressbar" aria-valuenow="{{$rv}}" aria-valuemin="0" aria-valuemax="100" style="padding: 0px;width:{{$rv}}% ">
                {{$rv}}%
            </div>

        </div>
        <div class="col-lg-3">({{$response->responses}} votes)</div>
    </div>
    @endforeach
    @else
    <h2> No Votes Yet!</h2>
    @endif
</fieldset