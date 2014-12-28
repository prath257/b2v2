
<div class="col-lg-10 col-lg-offset-1">
    <h3>
        Hello {{$user->first_name}},
    </h3>
    <hr>
    Your BlogBook, '{{$blogBook->title}}' just got reviewed!
    <br>
    <br>
    This review earned you {{$review->ifc}} IFCs.
    <br>
    <br>
    Our editors have the following suggestions for you:
    <br>
    <br>
    "{{$review->suggestions}}"
    <hr>
    <p>
        Regards,<br>
        BBarters Team
    </p>


</div>
