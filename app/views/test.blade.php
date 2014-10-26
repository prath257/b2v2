<html>
<head>

    <style>

        .list li
        {
            background-color:#000000;
            text-align: center;
            color: #ffffff;
            opacity: 0.5;

        }
    </style>


</head>
<body>



<div class="container">


    <div class="row">

        <div class="cbl-lg-12">

            <div class="info" >
                <ul class="list">
                </ul>
            </div>

            <form id="forming" method="post">
                Username:<input type="text" id="username"><br>
                Password:<input type="text" id="password"><br>
                <input type="submit"  value="Login">

            </form>


        </div>

    </div>

</div>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>

<script  >

    $(document).ready(function(){

        var info=$('.info');

        $('#forming').submit(function(e){

            e.preventDefault();

            $.post('/check',{data: 'Hola'},function(data)
            {
                alert(data.success);
                info.hide().find('ul').empty();

                info.find('ul').append('<li>'+'Hello'+'</li>')
                //thinking of animating
                info.slideDown();
            });

        });

    });

</script>


</body>
</html>
