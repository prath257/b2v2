<!DOCTYPE html>
<html>
<head>
  <title>{{$book->title}} | BBarters</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
  <link rel="stylesheet" type="text/css" href="../../css/jquery.jscrollpane.custom.css"/>
  <link rel="stylesheet" type="text/css" href="../../css/bookblock.css" />
  <link rel="stylesheet" type="text/css" href="../../css/custom.css" />
   <script src="../../js/modernizr.custom.79639.js"></script>

</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=431744100304343&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<div id="comments" style="display: none; margin-left: 20%">
    <div class="fb-comments" data-href="http://b2.com/blogBookPreview/{{$book->id}}" data-width="600" data-numposts="5" data-colorscheme="light"></div>
</div>
<a href="{{route('blogBookDashboard')}}" style="background-color: darkorange; color: #ffffff;float: left; padding: 5px; border: solid">Back</a>
<a id="fbc" href="#" onclick="showComments()" style="background-color:#002166; color: #ffffff; float: left; padding: 5px; border: solid">Comments</a>

<div class="fb-share-button" style="padding: 5px" data-href="http://b2.com/blogBookPreview/{{$book->id}}"></div><br>
    <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://b2.com/blogBook/{{$book->id}}" data-text="Check this out" data-count="none" data-hashtags="bbarters" style="margin-top: 2px">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

<div id="container" class="container" style="margin-top: 20px">

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
                    <li>
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
			$i=1;
            ?>
            <div class="bb-item" id="{{$i}}">
                <div class="content">
                    <div class="scroller" style="word-wrap: break-word">
                        <h2>{{$book->title}}</h2>
                         <div class="fb-like" data-href="https://b2.com/beta/blogBook/{{$book->id}}" data-layout="standard" data-action="recommend" data-show-faces="false" data-share="false"></div>
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

		</div>
		<nav>
			<span id="bb-nav-prev">&larr;</span>
			<span id="bb-nav-next">&rarr;</span>
		</nav>

		<span id="tblcontents" class="menu-button">Table of Contents</span>

	</div>

</div><!-- /container -->
<br>

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

    function showComments()
    {
        var comSection = document.getElementById('comments');
        if(comSection.style.display=='none')
        {
            comSection.style.display='';
            $('#fbc').html('Hide Comments');
        }
        else
        {
            comSection.style.display='none';
            $('#fbc').html('Comments');
        }
    }
</script>
</body>
</html>
 