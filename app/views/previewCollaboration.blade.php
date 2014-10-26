<!DOCTYPE html>
<html>
<head>
    <title>{{$collaboration->title}}</title>
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
        <h3>{{$collaboration->title}}</h3>
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
                        <a href="#{{$i}}">Cover</a>
                    </li>
                    <?php
                    $i++;
                    ?>
                    <li><a href="#{{$i}}">Collaborators</a></li>
                    <?php
                    $i++;
                    ?>
                    <li><a href="#{{$i}}">{{$chapter->title}}</a></li>
                <?php
                }
                else
                {
                    if ($i<=4)
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
            $i=1;
            ?>
            <div class="bb-item" id="{{$i}}">
                <div class="content">
                    <div class="scroller" style="word-wrap: break-word">
                        <h2>{{$collaboration->title}}</h2>
                        <img src="{{asset($collaboration->cover)}}" width="100%" style="overflow: hidden">
                    </div>
                </div>
            </div>
            <?php
            $i++;
            ?>
            <div class="bb-item" id="{{$i}}">
                <div class="content">
                    <div class="scroller" style="word-wrap: break-word">
                        <h2>Collaborators</h2>
                        Admin: <br><a href="{{route('user',User::find($collaboration->userid)->username)}}" style="text-decoration: none" target="_blank">{{User::find($collaboration->userid)->first_name}} {{User::find($collaboration->userid)->last_name}}</a>
                        <br>
                        <br>
                        Contributors:<br>
                        @foreach($contributors as $contributor)
                        <a href="{{route('user',$contributor->username)}}" style="text-decoration: none" target="_blank">{{$contributor->first_name}} {{$contributor->last_name}}</a>
                        <br>
                        @endforeach
                    </div>
                </div>
            </div>
            <?php
            $i++;
            while($i<=4)
            {
                ?>




                @if($i<=4)
                <div class="bb-item" id="{{$i}}">
                    <div class="content">
                        <div class="scroller" style="word-wrap: break-word" onmousedown='return false;' onselectstart='return false;'>

                            <h2>{{$chapters[$i-3]->title}}</h2>

                            {{$chapters[$i-3]->text}}
                            <br>
                            <div style="text-align: right">
                                <strong>Written by: {{User::find($chapters[$i-3]->userid)->first_name}} {{User::find($chapters[$i-3]->userid)->last_name}}</strong>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
                @endif
            <?php
                $i++;
            }
            ?>

            @else
                <?php
                $i=1;
                ?>
            <div class="bb-item" id="{{$i}}">
                <div class="content">
                    <div class="scroller" style="word-wrap: break-word">
                        <h2>{{$collaboration->title}}</h2>
                        <img src="{{asset($collaboration->cover)}}" width="100%" style="overflow: hidden">
                    </div>
                </div>
            </div>

            <?php
            $i++;
            ?>
            <div class="bb-item" id="{{$i}}">
                <div class="content">
                    <div class="scroller" style="word-wrap: break-word">
                        <h2>Collaborators</h2>
                        Collaboration Admin: <a href="{{route('user',User::find($collaboration->userid)->username)}}" style="text-decoration: none" target="_blank">{{User::find($collaboration->userid)->first_name}} {{User::find($collaboration->userid)->last_name}}</a>
                        <br>
                        <br>
                        @foreach($contributors as $contributor)
                        <a href="{{route('user',$contributor->username)}}" style="text-decoration: none" target="_blank">{{$contributor->first_name}} {{$contributor->last_name}}</a>
                        <br>
                        @endforeach
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
                                <br>
                                <div style="text-align: right">
                                    <strong>Written by: {{User::find($chapter->userid)->first_name}} {{User::find($chapter->userid)->last_name}}</strong>
                                </div>
                                <br>
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
