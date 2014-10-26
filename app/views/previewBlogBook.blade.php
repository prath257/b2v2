<!DOCTYPE html>
<html>
<head>
    <title>{{$book->title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.jpg')}}">
    <link rel="stylesheet" type="text/css" href="../../css/jquery.jscrollpane.custom.css"/>
    <link rel="stylesheet" type="text/css" href="../../css/bookblock.css" />
    <link rel="stylesheet" type="text/css" href="../../css/custom.css" />

    <script src="../../js/modernizr.custom.79639.js"></script>

</head>
<body>

<div id="container" class="container">

    <div class="menu-panel">
        <h3>{{$book->title}}</h3>
        <ul id="menu-toc" class="menu-toc">
            <?php
            $i=0;
            foreach($chapters as $chapter)
            {
                $i++;
                if($i==1)
                {
                    ?>

                    <li class="menu-toc-current">
                        <a href="#{{$i}}">Cover</a></li>
                    <?php
                    $i++;
                    ?>
                    <li><a href="#{{$i}}">{{$chapter->title}}</a></li>
                <?php
                }
                else
                {
                    if ($i<4)
                    {
                        ?>
                        <li><a href="#{{$i}}">{{$chapter->title}}</a></li>
                    <?php
                    }
                    else
                    {
                        ?>
                        <li><a href="#">{{$chapter->title}}</a></li>
                    <?php
                    }
                }
            }
            ?>
        </ul>

    </div>

    <div class="bb-custom-wrapper">
        <div id="bb-bookblock" class="bb-bookblock">
            @if($i>=4)
            <?php
            $i=0;
            ?>
            <div class="bb-item" id="{{$i}}">
                <div class="content">
                    <div class="scroller" style="word-wrap: break-word">

                        <h2>{{$book->title}}</h2>

                        <img src="{{asset($book->cover)}}" width="100%" style="overflow: hidden">

                    </div>
                </div>
            </div>
            <?php
                $i++;
            for(; $i<=3;)
            {
                $i++;
                ?>
                @if($i<4)
                <div class="bb-item" id="{{$i}}">
                    <div class="content">
                        <div class="scroller" style="word-wrap: break-word" onmousedown='return false;' onselectstart='return false;'>

                            <h2>{{$chapters[$i-2]->title}}</h2>

                            {{$chapters[$i-2]->text}}

                        </div>
                    </div>
                </div>
                @endif
            <?php
            }
            ?>

            @else
                <?php
                $i=1;
                ?>
                <div class="bb-item" id="{{$i}}">
                    <div class="content">
                        <div class="scroller" style="word-wrap: break-word">

                            <h2>{{$book->title}}</h2>

                            <img src="{{asset($book->cover)}}" width="100%" style="overflow: hidden">

                        </div>
                    </div>
                </div>
                <?php
                foreach($chapters as $chapter)
                {
                    $i++;
                    ?>
                    <div class="bb-item" id="{{$i}}">
                        <div class="content">
                            <div class="scroller" style="word-wrap: break-word" onmousedown='return false;' onselectstart='return false;'>
                                <h2>{{$chapter->title}}</h2>

                                {{$chapter->text}}

                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            @endif

        </div>
        <nav>
            <span id="bb-nav-prev">&larr;</span>
            <span id="bb-nav-next">&rarr;</span>
        </nav>

        <span id="tblcontents" class="menu-button">Table of Contents</span>

    </div>

</div><!-- /container -->
<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
<script src="../../js/jquery.mousewheel.js"></script>
<script src="../../js/jquery.jscrollpane.min.js"></script>
<script src="../../js/jquerypp.custom.js"></script>
<script src="../../js/jquery.bookblock.js"></script>
<script src="../../js/page.js"></script>
<script>
    $(function() {
        Page.init();
    });
</script>
</body>
</html>
