<?php
    $count = 0;
?>
<fieldset id="fieldset">
    <ul style="list-style-type: none; padding: 0px">
        @foreach($searchContent as $srcCont)
            @if($srcCont->text)
                <li>
                    <div class="col-lg-12" style="padding-left: 10px; padding-right: 10px; padding-top: 5px; padding-bottom: 5px" onmouseover="hoverEffect(this)" onmouseout="normalEffect(this)">
                        @if ($count != 0)
                            <hr style="color: #000000; margin-bottom: 10px; margin-top: 0px">
                        @endif
                        <div class="col-lg-3" style="padding: 0px">
                            <img src="{{$srcCont->cover}}" height="40px" width="40px">
                        </div>

                        <div class="col-lg-9" style="padding-left: 5px">
                            <a href="{{route('articlePreview',$srcCont->id)}}" style="text-decoration: none; font-size: 14px">{{$srcCont->title}}</a>
                        </div>

                        <div class="col-lg-12" style="padding-top: 5px; padding-bottom: 5px; padding-left: 0px; padding-right: 0px">
                            <div class="col-lg-6" style="padding: 0px">{{$srcCont->type}}</div>
                            <div class="col-lg-6" style="padding: 0px; text-align: right">{{$srcCont->ifc}} IFCs</div>
                        </div>
                    </div>
                </li>
            @elseif($srcCont->chapters)
                <?php $chapters = $srcCont->getChapters()->get(); ?>
                @if ($chapters[0]->bookid)
                    <li>
                        <div class="col-lg-12" style="padding-left: 10px; padding-right: 10px; padding-top: 5px; padding-bottom: 5px" onmouseover="hoverEffect(this)" onmouseout="normalEffect(this)">
                            @if ($count != 0)
                                <hr style="color: #000000; margin-bottom: 10px; margin-top: 0px">
                            @endif
                            <div class="col-lg-3" style="padding: 0px">
                                <img src="{{asset($srcCont->cover)}}" height="40px" width="40px">
                            </div>

                            <div class="col-lg-9" style="padding-left: 5px">
                                <a href="{{route('blogBookPreview',$srcCont->id)}}" style="text-decoration: none; font-size: 14px">{{$srcCont->title}}</a>
                            </div>

                            <div class="col-lg-12" style="padding-top: 5px; padding-bottom: 5px; padding-left: 0px; padding-right: 0px">
                                <div class="col-lg-6" style="padding: 0px">BlogBook</div>
                                <div class="col-lg-6" style="padding: 0px; text-align: right">{{$srcCont->ifc}} IFCs</div>
                            </div>
                        </div>
                    </li>
                @elseif ($chapters[0]->collaborationid)
                    <li>
                        <div class="col-lg-12" style="padding-left: 10px; padding-right: 10px; padding-top: 5px; padding-bottom: 5px" onmouseover="hoverEffect(this)" onmouseout="normalEffect(this)">
                            @if ($count != 0)
                                <hr style="color: #000000; margin-bottom: 10px; margin-top: 0px">
                            @endif
                            <div class="col-lg-3" style="padding: 0px">
                                <img src="{{asset($srcCont->cover)}}" height="40px" width="40px">
                            </div>

                            <div class="col-lg-9" style="padding-left: 5px">
                                <a href="{{route('collaborationPreview',$srcCont->id)}}" style="text-decoration: none; font-size: 14px">{{$srcCont->title}}</a>
                            </div>

                            <div class="col-lg-12" style="padding-top: 5px; padding-bottom: 5px; padding-left: 0px; padding-right: 0px">
                                <div class="col-lg-6" style="padding: 0px">Collaboration</div>
                                <div class="col-lg-6" style="padding: 0px; text-align: right">{{$srcCont->ifc}} IFCs</div>
                            </div>
                        </div>
                    </li>
                @endif
            @elseif($srcCont->trivia)
            <li>
                <div class="col-lg-12" style="padding-left: 10px; padding-right: 10px; padding-top: 5px; padding-bottom: 5px" onmouseover="hoverEffect(this)" onmouseout="normalEffect(this)">
                    @if ($count != 0)
                    <hr style="color: #000000; margin-bottom: 10px; margin-top: 0px">
                    @endif
                    <div class="col-lg-12" style="padding: 0px">
                        <a href="{{route('mediaPreview',$srcCont->id)}}" style="text-decoration: none; font-size: 14px">{{$srcCont->title}}</a>
                    </div>

                    <div class="col-lg-12" style="padding-top: 5px; padding-bottom: 5px; padding-left: 0px; padding-right: 0px">
                        <div class="col-lg-6" style="padding: 0px">Media</div>
                        <div class="col-lg-6" style="padding: 0px; text-align: right">{{$srcCont->ifc}} IFCs</div>
                    </div>
                </div>
            </li>
            @elseif($srcCont->path)
                <li>
                    <div class="col-lg-12" style="padding-left: 10px; padding-right: 10px; padding-top: 5px; padding-bottom: 5px" onmouseover="hoverEffect(this)" onmouseout="normalEffect(this)">
                        @if ($count != 0)
                            <hr style="color: #000000; margin-bottom: 10px; margin-top: 0px">
                        @endif
                        <div class="col-lg-12" style="padding: 0px">
                            <a href="{{route('resource',$srcCont->id)}}" style="text-decoration: none; font-size: 14px">{{$srcCont->title}}</a>
                        </div>

                        <div class="col-lg-12" style="padding-top: 5px; padding-bottom: 5px; padding-left: 0px; padding-right: 0px">
                            <div class="col-lg-6" style="padding: 0px">Resource</div>
                            <div class="col-lg-6" style="padding: 0px; text-align: right">{{$srcCont->ifc}} IFCs</div>
                        </div>
                    </div>
                </li>
        @elseif ($srcCont->venue)
        <li>
            <div class="col-lg-12" style="padding-left: 10px; padding-right: 10px; padding-top: 5px; padding-bottom: 5px" onmouseover="hoverEffect(this)" onmouseout="normalEffect(this)">
                @if ($count != 0)
                <hr style="color: #000000; margin-bottom: 10px; margin-top: 0px">
                @endif
                <div class="col-lg-3" style="padding: 0px">
                    <img src="{{asset($srcCont->cover)}}" height="40px" width="40px">
                </div>

                <div class="col-lg-9" style="padding-left: 5px">
                    <a href="{{route('event',$srcCont->id)}}" style="text-decoration: none; font-size: 14px">{{$srcCont->name}}</a>
                </div>

                <div class="col-lg-12" style="padding-top: 5px; padding-bottom: 5px; padding-left: 0px; padding-right: 0px">
                    <div class="col-lg-6" style="padding: 0px">Event</div>
                    <div class="col-lg-6" style="padding: 0px; text-align: right">{{$srcCont->ifc}} IFCs</div>
                </div>
            </div>
        </li>
        @elseif ($srcCont->ownerid)
         <li>
            <div class="col-lg-12" style="padding-left: 10px; padding-right: 10px; padding-top: 5px; padding-bottom: 5px" onmouseover="hoverEffect(this)" onmouseout="normalEffect(this)">
                @if ($count != 0)
                <hr style="color: #000000; margin-bottom: 10px; margin-top: 0px">
                @endif
                <div class="col-lg-12" style="padding: 0px">
                    <a href="{{route('quizPreview',$srcCont->id)}}" style="text-decoration: none; font-size: 14px">{{$srcCont->title}}</a>
                </div>

                <div class="col-lg-12" style="padding-top: 5px; padding-bottom: 5px; padding-left: 0px; padding-right: 0px">
                    <div class="col-lg-6" style="padding: 0px">Quiz</div>
                    <div class="col-lg-6" style="padding: 0px; text-align: right">{{$srcCont->ifc}} IFCs</div>
                </div>
            </div>
        </li>    @endif
            <?php
                $count ++;
            ?>
        @endforeach
    </ul>
        @if ($count == 0)
            No search results to display
        @endif
</fieldset>