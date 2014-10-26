<!DOCTYPE html>
<html>
<head>
    <title>Verify Mail! | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">-->
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/logo.css')}}" rel="stylesheet">

    <style>
    @font-face {
      font-family: 'Open Sans';
      font-style: normal;
      font-weight: 300;
      src: local('Open Sans Light'), local('OpenSans-Light'), url(//fonts.gstatic.com/s/opensans/v10/DXI1ORHCpsQm3Vp6mXoaTegdm0LZdjqr5-oayXSOefg.woff2) format('woff2'), url(//fonts.gstatic.com/s/opensans/v10/DXI1ORHCpsQm3Vp6mXoaTXhCUOGz7vYGh680lGh-uXM.woff) format('woff');
    }
    @font-face {
      font-family: 'Open Sans';
      font-style: normal;
      font-weight: 400;
      src: local('Open Sans'), local('OpenSans'), url(//fonts.gstatic.com/s/opensans/v10/cJZKeOuBrn4kERxqtaUH3VtXRa8TVwTICgirnJhmVJw.woff2) format('woff2'), url(//fonts.gstatic.com/s/opensans/v10/cJZKeOuBrn4kERxqtaUH3T8E0i7KZn-EPnyo3HZu7kw.woff) format('woff');
    }
    </style>

</head>
<body style="background-color: #000000; font-family: 'Open Sans', arial">

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="position: fixed">
    <div class="container-fluid">
        <div class="navbar-header">
            <a id="logo" class="navbar-brand logo" href="{{route('index')}}">
                <span class='letter' style="text-shadow: 1px 1px 1px green; color: green">B</span>
                <span class='letter'>B</span>
                <span class='letter'>a</span>
                <span class='letter'>r</span>
                <span class='letter'>t</span>
                <span class='letter'>e</span>
                <span class='letter'>r</span>
                <span class='letter'>s</span>
            </a>
        </div>
    </div>
</nav>
<div class="col-lg-12 col-lg-offset-0" style="height: 100%; width: 100%">
    <img src="{{asset('Images/logout.jpg')}}" height="100%" width="100%" style="float: left;">

</div>
<div class="col-lg-4" style="margin-top: 22.5%; margin-left: 2.5%; font-size: 20px; color: #ffffff; position: absolute" onmousedown='return false;' onselectstart='return false;'>
    It's time to check if all the info you provided was real. Please check yor mail and click on the activation link.
</div>

</body>
</html>