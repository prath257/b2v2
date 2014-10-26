<!DOCTYPE html>
<html>
<head>
    <title>Review {{$book->title}} | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link rel="stylesheet" type="text/css" href="../../css/jquery.jscrollpane.custom.css"/>
    <link rel="stylesheet" type="text/css" href="../../css/bookblock.css" />
    <link rel="stylesheet" type="text/css" href="../../css/custom.css" />
    <script src="../../js/modernizr.custom.79639.js"></script>

</head>
<body>
@if ($book->review == 'toreview')
<div id="container" class="container">

    <div class="menu-panel">
        <a href="{{route('review',$review->id)}}" style="padding: 20px; background-color: darkorange; position: fixed; color: #ffffff; margin-left: 90%; min-width: 10%">Review</a>
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
                        <a href="#{{$i}}">{{$chapter->title}}</a></li>
                <?php
                }
                else
                {
                    ?>
                    <li><a href="#{{$i}}">{{$chapter->title}}</a></li>
                <?php
                }
            }
            ?>
        </ul>

    </div>

    <div class="bb-custom-wrapper">
        <div id="bb-bookblock" class="bb-bookblock">
            <?php
            $i=0;
            foreach($chapters as $chapter)
            {
                $i++;
                ?>
                <div class="bb-item" id="{{$i}}">
                    <div class="content">
                        <div class="scroller">
                            <h2>{{$chapter->title}}</h2>

                            {{$chapter->text}}

                        </div>
                    </div>
                </div>
            <?php
            }
            ?>

        </div>
        <nav>
            <span id="bb-nav-prev">&larr;</span>
            <span id="bb-nav-next">&rarr;</span>
        </nav>

        <span id="tblcontents" class="menu-button">Table of Contents</span>

    </div>

</div><!-- /container -->

@else
    <p style="font-size: 18px; text-align: center; margin-top: 10%">This BlogBook has already been reviewed.</p>
@endif
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
 