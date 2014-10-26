var submitted = false;
var ListItem = 1;
var res = 0;
var med = 0;
var oTableResource=null;
var oTableMedia=null;
var uploading = false;
$(document).ready(function()
{
    var type = $('#type').val();
   // $(".rating-kv").rating();
    $.post('http://localhost/b2v2/getArticleTemplate', {type: type, count: ListItem}, function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://localhost/b2v2/offline';
        else
        {
            if (type == 'Article')
            {
                $('#articleFields').html(markup);
                $('#summernote').summernote({
                    height:430,
                    onkeydown: function(e) {
                        checkCharacters();
                    }
                });
            }
            else if (type == 'List')
            {
                $('#articleFields').html("<div id='ListItem"+ListItem+"'>"+markup+"</div>");
                $('#summ'+ListItem).summernote({
                    height:200,
                    onkeydown: function(e) {
                        checkListCharacters(ListItemsjvbj);
                    }
                });
            }

            else if (type == 'Travel Guide')
            {
                $('#articleFields').html(markup);
                $('#summernote').summernote({
                    height:200,
                    onkeydown: function(e) {
                        checkCharacters();
                    }
                });
            }
            else if (type == 'Film Review')
            {
                $('#articleFields').html(markup);
                $("#rating").rating();
                $('#summernote').summernote({
                    height:430,
                    onkeydown: function(e) {
                        checkCharacters();
                    }
                });
            }
            else if (type == 'Music Review')
            {
                $('#articleFields').html(markup);
                $("#rating"+ListItem).rating();
                $(".rating-kv").rating();
                $('#summ'+ListItem).summernote({
                    height:200,
                    onkeydown: function(e) {
                        checkCharacters();
                    }
                });
            }
            else if (type == 'Recipe')
            {
                $('#articleFields').html(markup);
                $('#summernote').summernote({
                    height:300,
                    onkeydown: function(e) {
                        checkCharacters();
                    }
                });
            }
            else if (type == 'Book Review')
            {
                $('#articleFields').html(markup);
                $('#summernote').summernote({
                    height:330,
                    onkeydown: function(e) {
                        checkCharacters();
                    }
                });
                $("#rating").rating();
            }
            else if (type == 'Code Article')
            {
                $('#articleFields').html("<div id='ListItem"+ListItem+"'>"+markup+"</div>");
                $('#summ'+ListItem).summernote({
                    height:200,
                    onkeydown: function(e) {
                        checkListCharacters(ListItemsjvbj);
                    },
                    toolbar: [
                        ['insert', ['picture', 'link', 'video', 'hr']],
                        ['misc', ['fullscreen', 'undo', 'redo']]
                    ],
                    font: 'courier'
                });
                $('#summm'+ListItem).summernote({
                    height:200,
                    onkeydown: function(e) {
                        checkListCharacters(ListItemsjvbj);
                    },
                    font: 'courier'
                });
                $('#introduction').focus();
            }
            else if (type == 'Game Review')
            {
                $('#articleFields').html(markup);
                $('#summernote').summernote({
                    height:300,
                    onkeydown: function(e) {
                        checkCharacters();
                    }
                });
                $("#rating").rating();
            }
            else if (type == 'Website Review')
            {
                $('#articleFields').html(markup);
                $('#summernote').summernote({
                    height:330,
                    onkeydown: function(e) {
                        checkCharacters();
                    }
                });
                $("#rating").rating();
            }
            else if (type == 'Gadget Review')
            {
                $('#articleFields').html(markup);
                $('#summernote').summernote({
                    height:330,
                    onkeydown: function(e) {
                        checkCharacters();
                    }
                });
                $("#rating").rating();
            }
        }
    });




    $('#newMediaForm').bootstrapValidator({
        live: 'enabled',
        submitButtons: 'button[id="submitMedia"]',
        message: 'This value is not valid',
        fields: {
            newMedia: {
                message: 'The Media File is not valid',
                validators: {
                    file: {
                        extension: 'mp4,webm,mp3,wav,avi,asf,wmv,m4a,mkv,flv',
                        maxSize: 204800 * 1024,   // 200 MB
                        message: 'Upto 200 MB only, chose the correct file '
                    },
                    notEmpty:{
                        message:'Please Select a Media File'
                    }
                }
            }
        }
    });

    $('#newMediaForm').submit(function(event)
    {
        /* stop form from submitting normally */
        event.preventDefault();
    });

    window.onbeforeunload = function(e) {
        if (submitted == false)
            return 'Any unsaved changes will be lost.';
    };
	/*$('#postForm').submit(function(event)
	{
		*//* stop form from submitting normally *//*
		event.preventDefault();
	});*/
});

function showPreview()
{
    var type = $('#type').val();

    if (type == 'Article')
    {
        var sHTML = $('#summernote').code();
            var length = sHTML.length;
            if (length>140)
            {
                $('.embed').hide();
                $("#error-box").html("");
                $("#previewHTML").html(sHTML);
                $("#preview").fadeIn(1500);
                $(".summernote").css("opacity","0");
                $('html, body').animate({scrollTop:0}, 1000);
            }
            else
            {
                $('#previewButton').prop('disabled',true);
                $("#error-box").html("Your article must contain min 140 characters.")
            }
    }
    else if (type == 'List')
    {
        $("#previewHTML").html("");
        var i;
        for (i=1; i<=ListItem; i++)
        {
            var head = $('#ListHeader'+i).val();
            $("#previewHTML").append("<br><h3>"+head+"</h3>");
            var summ = $('#summ'+i).code();
            $("#previewHTML").append("<br><div style='text-indent: 5em;'>"+summ+"</div><br>");
        }
        $("#preview").fadeIn(1500);
        $(".summernote").css("opacity","0");
        $('html, body').animate({scrollTop:0}, 1000);
    }
    else if (type == 'Travel Guide')
    {
        $("#previewHTML").html("");
        var desti=$('#destination').val();
        $("#previewHTML").append("<br><h3>Destination</h3>"+desti);
        var desti=$('#places').val();
        $("#previewHTML").append("<br><h3>Places to Visit</h3>"+desti);
        var desti=$('#transportation').val();
        $("#previewHTML").append("<br><h3>Transportation</h3>"+desti);
        var desti=$('#accomodation').val();
        $("#previewHTML").append("<br><h3>Accomodation</h3>"+desti);
        var summ = $('#summernote').code();
        $("#previewHTML").append("<br><h3>My travel Expirience</h3>"+summ+"<br>");
        var desti=$('#advice').val();
        $("#previewHTML").append("<br><h3>Travel Advice</h3>"+desti);
        $("#preview").fadeIn(1500);
        $(".summernote").css("opacity","0");
        $('html, body').animate({scrollTop:0}, 1000);
    }

    else if (type == 'Film Review')
    {
        $("#previewHTML").html("");
        var desti=$('#year').val();
        $("#previewHTML").append("<br><h3>Released In:</h3>"+desti);
        desti=$('#genre').val();
        $("#previewHTML").append("<br><h3>Genre:</h3>"+desti);
        desti=$('#director').val();
        $("#previewHTML").append("<br><h3>Director:</h3>"+desti);
        desti=$('#cast').val();
        $("#previewHTML").append("<br><h3>Cast:</h3>"+desti);
        desti=$('#plot').val();
        $("#previewHTML").append("<br><h3>Plot Synopsis:</h3>"+desti);
        desti=$('#expectations').val();
        $("#previewHTML").append("<br><h3>Prior Expectations:</h3>"+desti);
        desti=$('#story').val();
        $("#previewHTML").append("<br><h3>Story/Screenplay:</h3>"+desti);
        var summ = $('#summernote').code();
        $("#previewHTML").append("<br><h3> My Review:</h3>"+summ);
        desti=$('#acting').val();
        $("#previewHTML").append("<br><h3>Acting:</h3>"+desti);
        desti=$('#technical').val();
        $("#previewHTML").append("<br><h3>Technical Aspects:</h3>"+desti);
        desti=$('#after').val();
        $("#previewHTML").append("<br><h3>After Feelings:</h3>"+desti);
        desti=$('#rating').val();
        $("#previewHTML").append("<br>My Rating:<input id='prating' class='rating' readonly=true type='number' data-size='sm' value='"+desti+"'>");
        $("#prating").rating();
        $("#preview").fadeIn(1500);
        $(".summernote").css("opacity","0");
        $('html, body').animate({scrollTop:0}, 1000);
    }
    else if (type == 'Music Review')
    {
        $("#previewHTML").html("");
        var desti=$('#year').val();
        $("#previewHTML").append("<br><h3>Released In:</h3>"+desti);
        desti=$('#genre').val();
        $("#previewHTML").append("<br><h3>Genre:</h3>"+desti);
        desti=$('#musicProducer').val();
        $("#previewHTML").append("<br><h3>Music Producer(s):</h3>"+desti);
        desti=$('#lyricist').val();
        $("#previewHTML").append("<br><h3>Lyricist(s):</h3>"+desti);
        desti=$('#priorExpectations').val();
        $("#previewHTML").append("<br><h3>Prior Expectations:</h3>"+desti);
        $("#previewHTML").append("<br><h3>The Review:</h3>");
        var i;
        for (i=1; i<=ListItem; i++)
        {
            var head = $('#trackName'+i).val();
            $("#previewHTML").append("<br><h3>"+head+"</h3>");
            head = $('#summ'+i).code();
            $("#previewHTML").append("<div style='text-indent: 5em;'>"+head+"</div><br>");
            head=$('#rating'+i).val();
            $("#previewHTML").append("<br>My Rating:<input id='prating"+i+"' class='rating' readonly=true type='number' data-size='sm' value='"+head+"'>");
        }
        $(".rating").rating();
        $("#preview").fadeIn(1500);
        $(".summernote").css("opacity","0");
        $('html, body').animate({scrollTop:0}, 1000);
    }
    else if (type == 'Book Review')
    {
        $("#previewHTML").html("");
        var desti=$('#year').val();
        $("#previewHTML").append("<br><h3>Released In:</h3>"+desti);
        desti=$('#genre').val();
        $("#previewHTML").append("<br><h3>Genre:</h3>"+desti);
        desti=$('#author').val();
        $("#previewHTML").append("<br><h3>Author(s):</h3>"+desti);
        desti=$('#publisher').val();
        $("#previewHTML").append("<br><h3>Publisher:</h3>"+desti);
        desti=$('#synopsis').val();
        $("#previewHTML").append("<br><h3>Synopsis:</h3>"+desti);

            head = $('#summernote').code();
            $("#previewHTML").append("<br><h3>Review:</h3>"+head);
            head=$('#rating').val();
            $("#previewHTML").append("<br>My Rating:<input id='prating' class='rating' readonly=true type='number' data-size='sm' value='"+head+"'>");

        $(".rating").rating();
        $("#preview").fadeIn(1500);
        $(".summernote").css("opacity","0");
        $('html, body').animate({scrollTop:0}, 1000);
    }
    else if (type == 'Recipe')
    {
        $("#previewHTML").html("");

        var prepTime = $('#preparationTime').val();
        if (prepTime.length == 0)
            prepTime = 'NULL';
        else
            prepTime += ' mins.';
        var difficulty = $('#difficulty').val();
        if (difficulty.length == 0)
            difficulty = 'NULL';
        var cuisine = $('#cuisine').val();
        if (cuisine.length == 0)
            cuisine = 'NULL';
        var ingredients = $('#ingredients').val();
        if (ingredients.length == 0)
            ingredients = 'NULL';
        var steps = $('#summernote').code();
        if (steps.length <= 10)
            steps = 'NULL';
        var tips = $('#tips').val();
        if (tips.length == 0)
            tips = 'NULL';

        $("#previewHTML").append("<h3>Preparation Time</h3>"+prepTime+"<br><h3>Difficulty</h3>"+difficulty+"<br><h3>Cuisine</h3>"+cuisine+"<br><h3>Ingredients</h3>"+ingredients+"<br><h3>Steps</h3>"+steps+"<br><h3>Tips:</h3>"+tips);

        $("#preview").fadeIn(1500);
        $(".summernote").css("opacity","0");
        $('html, body').animate({scrollTop:0}, 1000);
    }
    else if (type == 'Code Article')
    {
        var intro = $('#introduction').val();
        $("#previewHTML").html(intro+"<br>");
        var i;
        for (i=1; i<=ListItem; i++)
        {
            var code = $('#summ'+i).code();
            $("#previewHTML").append("<br><br><div class='well' style='font-family: \"courier new\"'>"+code+"</div>");
            var expl = $('#summm'+i).code();
            $("#previewHTML").append("<i>"+expl+"</i><br>");
        }
        $("#previewHTML").append($('#fieldset').html()+'<br>');
        $("#preview").fadeIn(1500);
        $(".summernote").css("opacity","0");
        $('html, body').animate({scrollTop:0}, 1000);
    }
    else if (type == 'Game Review')
    {
        $("#previewHTML").html("");
        var desti=$('#title').val();
        $("#previewHTML").append("<br><h2>"+desti+"</h2>");
        desti=$('#year').val();
        $("#previewHTML").append("<br><h3>Released In:</h3>"+desti);
        desti=$('#genre').val();
        $("#previewHTML").append("<br><h3>Genre:</h3>"+desti);
        desti=$('#developer').val();
        $("#previewHTML").append("<br><h3>Developer(s):</h3>"+desti);
        desti=$('#publisher').val();
        $("#previewHTML").append("<br><h3>Publisher(s):</h3>"+desti);
        desti=$('#trailer').val();
        desti = desti.replace("watch?v=", "embed/");
        $("#previewHTML").append("<br><h3>Trailer:</h3><iframe src='"+desti+"' width='640' height='360' frameborder='0'></iframe>");
        desti=$('#priorExpectations').val();
        $("#previewHTML").append("<br><h3>Prior Expectations:</h3>"+desti);

        head = $('#summernote').code();
        $("#previewHTML").append("<br><h3>Review:</h3>"+head);
        head=$('#rating').val();
        $("#previewHTML").append("<br>My Rating:<input id='prating' class='rating' readonly=true type='number' data-size='sm' value='"+head+"'>");

        $(".rating").rating();
        $("#preview").fadeIn(1500);
        $(".summernote").css("opacity","0");
        $('html, body').animate({scrollTop:0}, 1000);
    }

    else if (type == 'Gadget Review')
    {
        $("#previewHTML").html("");
        var desti=$('#pname').val();
        $("#previewHTML").append("<br><h3>Product Name:</h3>"+desti);
        desti=$('#date').val();
        $("#previewHTML").append("<br><h3>Release Date:</h3>"+desti);
        desti=$('#comp').val();
        $("#previewHTML").append("<br><h3>Company:</h3>"+desti);
        desti=$('#expectations').val();
        $("#previewHTML").append("<br><h3>Prior Expectations:</h3>"+desti);
        desti=$('#specifications').val();
        $("#previewHTML").append("<br><h3>Specifications:</h3>"+desti);
        var summ = $('#summernote').code();
        $("#previewHTML").append("<br><h3>My Review:</h3>"+summ);
        desti=$('#rating').val();
        $("#previewHTML").append("<br>My Rating:<input id='prating' class='rating' readonly=true type='number' data-size='sm' value='"+desti+"'>");
        $("#prating").rating();
        $("#preview").fadeIn(1500);
        $(".summernote").css("opacity","0");
        $('html, body').animate({scrollTop:0}, 1000);
    }
    else if (type == 'Website Review')
    {
        $("#previewHTML").html("");
        var desti=$('#wname').val();
        $("#previewHTML").append("<br><h3>Website Name:</h3>"+desti);
        desti=$('#founder').val();
        $("#previewHTML").append("<br><h3>Founder(s)/Developer(s):</h3>"+desti);
        desti=$('#genre').val();
        $("#previewHTML").append("<br><h3>Genre:</h3>"+desti);
        desti=$('#link').val();
        $("#previewHTML").append("<br><h3>Link to website:</h3><a src='"+desti+"'>"+desti+"</a>");

        var summ = $('#summernote').code();
        $("#previewHTML").append("<br><h3>My Review:</h3>"+summ);
        desti=$('#rating').val();
        $("#previewHTML").append("<br>My Rating:<input id='prating' class='rating' readonly=true type='number' data-size='sm' value='"+desti+"'>");
        $("#prating").rating();
        $("#preview").fadeIn(1500);
        $(".summernote").css("opacity","0");
        $('html, body').animate({scrollTop:0}, 1000);
    }
}

function editContent()
{

	$("#preview").fadeOut(500);
	$(".summernote").css("opacity","1");
	$("#previewHTML").html("");
	$('.embed').show();
}


function checkCharacters()
{
	var sHTML = $('#summernote').code();
	var length = sHTML.length;
	if (length < 140)
	{
        $('#previewButton').prop('disabled',true);
		$("#error-box").html("Your article must contain min 140 characters.")
	}
	else
	{
        $('#previewButton').prop('disabled',false);
		$("#error-box").html("")
	}
}

//this is the function to post the Article
function saveArticle()
{
    $("#preview").fadeOut(500);
        $("#previewHTML").html("");
        $("#reviewSubmissionModal").modal({
            keyboard:false,
            show:true,
            backdrop:'static'
        });
        $(".embed").show();
}

function submit(method,button)
{


    var title = $("#title").val();
    var extension = $("#extension").val();
    var description = $("#description").val();
    var category = $("#category").val();
    var ifc = $("#ifc").val();
    var type = $("#type").val();

    if (type == 'Article')
        var content = $('#summernote').code();
    else if (type == 'List')
    {
        var i;
        var content = "";
        for (i=1; i<=ListItem; i++)
        {
            var head = $('#ListHeader'+i).val();
            content += "<br><h3>"+head+"</h3>";
            var summ = $('#summ'+i).code();
            content += "<br><div style='text-indent: 5em;'>"+summ+"</div><br>";
        }
    }
    else if (type == 'Travel Guide')
    {

        var content = "";
        var desti=$('#destination').val();
        content+="<br><h3>Destination</h3>"+desti;
        var desti=$('#places').val();
        content+="<br><h4>Places to Visit</h4>"+desti;
        var desti=$('#transportation').val();
        content+="<br><h4>Transportation</h4>"+desti;
        var desti=$('#accomodation').val();
        content+="<br><h4>Accomodation</h4>"+desti;
        var summ = $('#summernote').code();
        content+="<br><h3> My travel Expirience</h3>"+summ+"<br>";
        var desti=$('#advice').val();
        content+="<br><h3>Travel Advice</h3>"+desti;

    }
    else if (type == 'Film Review')
    {

        var content = "";
        var desti=$('#year').val();
        content+="<br><h3>Released:</h3>"+desti;
        desti=$('#genre').val();
        content+="<br><h3>Genre:</h3>"+desti;
        desti=$('#director').val();
        content+="<br><h3>Director:</h3>"+desti;
        desti=$('#cast').val();
        content+="<br><h3>Cast:</h3>"+desti;
        desti=$('#plot').val();
        content+="<br><h3>Plot Synopsis:</h3>"+desti;
        desti=$('#expectations').val();
        content+="<br><h3>Prior Expectations:</h3>"+desti;
        desti=$('#story').val();
        content+="<br><h3>Story/Screenplay:</h3>"+desti;
        var summ = $('#summernote').code();
        content+="<br><h3>My Review:</h3>"+summ;
        desti=$('#acting').val();
        content+="<br><h3>Acting:</h3>"+desti;
        desti=$('#technical').val();
        content+="<br><h3>Technical Aspects:</h3>"+desti;
        desti=$('#after').val();
        content+="<br><h3>After Feelings:</h3>"+desti;
        desti=$('#rating').val();
        content+="<br>My Rating:<input id='prating' class='rating' readonly=true type='number' data-size='sm' value='"+desti+"'>";
    }
    else if (type == 'Music Review')
    {
        var content = "";
        var desti=$('#year').val();
        content+="<br><h3>Released In:</h3>"+desti;
        desti=$('#genre').val();
        content+="<br><h3>Genre:</h3>"+desti;
        desti=$('#musicProducer').val();
        content+="<br><h3>Music Producer(s):</h3>"+desti;
        desti=$('#lyricist').val();
        content+="<br><h3>Lyricist(s):</h3>"+desti;
        desti=$('#priorExpectations').val();
        content+="<br><h3>Prior Expectations:</h3>"+desti;
        content+="<br><h3>The Review:</h3>";
        var i;
        for (i=1; i<=ListItem; i++)
        {
            var head = $('#trackName'+i).val();
            content+="<br><h3>"+head+"</h3>";
            head = $('#summ'+i).code();
            content+="<div style='text-indent: 5em;'>"+head+"</div><br>";
            head=$('#rating'+i).val();
            content+="<br>My Rating:<input id='prating"+i+"' class='rating' readonly=true type='number' data-size='sm' value='"+head+"'>";
        }
    }
    else if (type == 'Book Review')
    {
        var content = "";
        var desti=$('#year').val();
        content+="<br><h3>Released In:</h3>"+desti;
        desti=$('#genre').val();
        content+="<br><h3>Genre:</h3>"+desti;
        desti=$('#author').val();
        content+="<br><h3>Author(s):</h3>"+desti;
        desti=$('#publisher').val();
        content+="<br><h3>Publisher:</h3>"+desti;
        desti=$('#filmAdaptation').val();
        content+="<br><h3>Film Adaptation:</h3>"+desti;
        desti=$('#synopsis').val();
        content+="<br><h3>Synopsis:</h3>"+desti;

content += "<h3>The Review</h3>";
            head = $('#summernote').code();
            content+="<div style='text-indent: 5em;'>"+head+"</div>";
            head=$('#rating').val();
            content+="<br>My Rating:<input id='prating' class='rating' readonly=true type='number' data-size='sm' value='"+head+"'>";

    }
    else if (type == 'Recipe')
    {
        var content = "";

        var prepTime = $('#preparationTime').val();
        if (prepTime.length == 0)
            prepTime = 'NULL';
        else
            prepTime += ' mins.';
        var difficulty = $('#difficulty').val();
        if (difficulty.length == 0)
            difficulty = 'NULL';
        var cuisine = $('#cuisine').val();
        if (cuisine.length == 0)
            cuisine = 'NULL';
        var ingredients = $('#ingredients').val();
        if (ingredients.length == 0)
            ingredients = 'NULL';
        var steps = $('#summernote').code();
        if (steps.length <= 10)
            steps = 'NULL';
        var tips = $('#tips').val();
        if (tips.length == 0)
            tips = 'NULL';

        content = "<h3>Preparation Time</h3>"+prepTime+" mins.<br><h3>Difficulty</h3>"+difficulty+"<br><h3>Cuisine</h3>"+cuisine+"<br><h3>Ingredients</h3>"+ingredients+"<br><h3>Steps</h3>"+steps+"<br><h3>Tips:</h3>"+tips;
    }
    else if (type == 'Code Article')
    {
        var content = "";
        var intro = $('#introduction').val();
        content += intro+"<br>";
        var i;

        for (i=1; i<=ListItem; i++)
        {
            var code = $('#summ'+i).code();
            content += "<br><br><div class='well' style='font-family: \"courier new\"'>"+code+"</div>";
            var expl = $('#summm'+i).code();
            content += "<i>"+expl+"</i><br>";
        }
        content += $('#fieldset').html();
        content += "<br>";
    }
    else if (type == 'Game Review')
    {
        var content = "";
        var desti=$('#title').val();
        content+="<br><h2>"+desti+"</h2>";
        desti=$('#year').val();
        content+="<br><h3>Released In:</h3>"+desti;
        desti=$('#genre').val();
        content+="<br><h3>Genre:</h3>"+desti;
        desti=$('#developer').val();
        content+="<br><h3>Developer(s):</h3>"+desti;
        desti=$('#publisher').val();
        content+="<br><h3>Publisher(s):</h3>"+desti;
        desti=$('#trailer').val();
        desti = desti.replace("watch?v=", "embed/");
        content+="<br><h3>Trailer:</h3><iframe src='"+desti+"' width='640' height='360' frameborder='0'></iframe>";
        desti=$('#priorExpectations').val();
        content+="<br><h3>Prior Expectations:</h3>"+desti;

        content += "<h3>The Review</h3>";
        head = $('#summernote').code();
        content+="<div style='text-indent: 5em;'>"+head+"</div>";
        head=$('#rating').val();
        content+="<br>My Rating:<input id='prating' class='rating' readonly=true type='number' data-size='sm' value='"+head+"'>";

    }
    else if (type == 'Gadget Review')
    {

        var content = "";
        var desti=$('#pname').val();
        content+="<br><h3>Product Name:</h3>"+desti;
        desti=$('#date').val();
        content+="<br><h3>Released Date:</h3>"+desti;
        desti=$('#comp').val();
        content+="<br><h3>Company:</h3>"+desti;
        desti=$('#expectations').val();
        content+="<br><h3>Prior Expectations:</h3>"+desti;
        desti=$('#specifications').val();
        content+="<br><h3>Specifications:</h3>"+desti;

        var summ = $('#summernote').code();
        content+="<br><h3>My Review:</h3>"+summ;
        desti=$('#rating').val();
        content+="<br>My Rating:<input id='prating' class='rating' readonly=true type='number' data-size='sm' value='"+desti+"'>";
    }
    else if (type == 'Website Review')
    {

        var content = "";
        var desti=$('#wname').val();
        content+="<br><h3>Website Name:</h3>"+desti;
        desti=$('#founder').val();
        content+="<br><h3>Founder(s)/Developer(s):</h3>"+desti;
        desti=$('#genre').val();
        content+="<br><h3>Genre:</h3>"+desti;
        desti=$('#link').val();
        content+="<br><h3>Link to website:</h3><a src='"+desti+"'>"+desti+"</a>";

        var summ = $('#summernote').code();
        content+="<br><h3>My Review:</h3>"+summ;
        desti=$('#rating').val();
        content+="<br>My Rating:<input id='prating' class='rating' readonly=true type='number' data-size='sm' value='"+desti+"'>";
    }


    $.ajax({
        type: "POST",
        url: 'http://localhost/b2v2/createArticle',
        data:{title: title, extension: extension, description:description, category: category, ifc: ifc, type:type, content: content, review: method},
        beforeSend: function()
        {
           if(method=='toreview')
           {

               $("#submitreview").hide();
               $("#waitingArtical").show();
           }
            else
           {

               $("#submitreview1").hide();
               $("#waitingArtical1").show();
           }

        }
    }).done(function(message)
    {
        if(message=='wH@tS!nTheB0x')
            window.location='http://localhost/b2v2/offline';
        else
        {
            if(method=='toreview')
            {
                $("#submitreview").show();
                $("#waitingArtical").hide();

            }
            else
            {
                $("#submitreview1").show();
                $("#waitingArtical1").hide();

            }


            if (message=="success")
            {
                submitted = true;
                $("#reviewSubmissionModal").modal('hide');
                $("#articleSuccessfullyPostedModal").modal({
                    keyboard:false,
                    show:true,
                    backdrop:'static'
                });
                $(button).prop('disabled', false);
                $(button).html("Submit");
            }
        }
    });


    /*
    $.post('http://localhost/b2v2/createArticle', {title: title, extension: extension, description:description, category: category, ifc: ifc, type:type, content: content, review: method}, function(message)
    {
        if (message=="success")
        {
            $("#reviewSubmissionModal").modal('hide');
            $("#articleSuccessfullyPostedModal").modal({
                keyboard:false,
                show:true,
                backdrop:'static'
            });
            $(button).prop('disabled', false);
            $(button).html("Submit");
        }
    });
    */
}





function returnToDashboard()
{
	$("#articleSuccessfullyPostedModal").modal('hide');
	window.location.href = "http://localhost/b2v2/articleDashboard";
}

//this is the function to uploadMedia
function uploadMedia()
{
   $('#uploadMediaModal').modal('show');
}

function getMedia()
{
	$('#getMediaModal').modal('show');

    if (med == 0)
    {
        oTableMedia=$('#mediaTable').dataTable( {
            "ajax": 'http://localhost/b2v2/getMediaWritingData',
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
        } );
        med++;
    }

}

function newMedia()
{
    if (uploading == false)
	    $('#newMediaModal').modal('show');
    else
        bootbox.alert('Please wait for the existing upload to get over.');
}

function useMedia(path,title)
{
	var content = $('#summernote').code();
	var strpath=path;

	if ((strpath.search('.mp4') > 0) || (strpath.search('.webm') > 0))
	{
		content += "<video class='embed' width='320' height='240' controls><source src='"+path+"'></video>&nbsp;<abbr title='For Internet Explorer, right-click on the play button and select play/pause'>Trouble playing Media?&nbsp;<span class='glyphicon glyphicon-question-sign'></span></abbr><br>";
	}
	else if ((strpath.search('.mp3') > 0) || (strpath.search('.wav') > 0))
	{
		content += "<audio class='embed' controls><source src='"+path+"'></audio>&nbsp;<abbr title='For Internet Explorer, right-click on the play button and select play/pause'>Trouble playing Media?&nbsp;<span class='glyphicon glyphicon-question-sign'></span></abbr><br>";
	}
	else if ((strpath.search('.avi') > 0) || (strpath.search('.asf') > 0) || (strpath.search('.wmv') > 0))
	{
		content += "<embed class='embed' width='320' height='240' src='"+path+"'></embed>&nbsp;<abbr title='For Internet Explorer, right-click on the play button and select play/pause'>Trouble playing Media?&nbsp;<span class='glyphicon glyphicon-question-sign'></span></abbr><br>";
	}
	else if ((strpath.search('.m4a') > 0) || (strpath.search('.mkv') > 0) || (strpath.search('.flv') > 0))
	{
		content += "<a href='"+path+"' target='_blank'>"+title+"</a>&nbsp;<abbr title='For Internet Explorer, right-click on the play button and select play/pause'>Trouble playing Media?&nbsp;<span class='glyphicon glyphicon-question-sign'></span></abbr><br>";
	}

	/*if((strpath.search('.mkv')!= -1)||(strpath.search('.flv')!= -1)||(strpath.search('.m4a')!= -1))
	{
		content+="<br><object id='Embed"+embed+"' autoplay='false' width='300' height='200' data='"+path+"'><a href='"+path+"'>"+title+"</a></object>";
	}
	else
	{
		content+="<br><embed id='Embed"+embed+"' autoplay='false' width='300' height='200' src='"+path+"'></embed>";
	}*/

	$('#summernote').code(content);
	$('#getMediaModal').modal('hide');
	$('#uploadMediaModal').modal('hide');
}
/*
 var content = $('#summernote').code();
 content+="<br><embed src='Waving.mp4'></embed>";
 $('#summernote').code(content);
  */

//this is the function of uploading new Media File

function _(el)
{
	return document.getElementById(el);
}

function uploadNewMedia()
{
    $('#newMediaForm').data('bootstrapValidator').validate();

    if($('#newMediaForm').data('bootstrapValidator').isValid())
    {
        uploading = true;
        var file2 = _("newMedia").files[0];
        var mt=$('#mediaTitle').val();
        var formdata = new FormData();
        formdata.append("userMedia", file2);
        formdata.append("mediaTitle", mt);
        formdata.append("origin", "content");
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "http://localhost/b2v2/uploadMedia");
        ajax.send(formdata);
        $('#newMediaModal').modal('hide');
        $('#uploadMediaModal').modal('hide');
        $('body,html').animate({ scrollTop: 0}, 0);
    }
}

function completeHandler(event)
{
	var content = $('#summernote').code();
	var strpath=this.responseText;

    if(strpath=='wH@tS!nTheB0x')
        window.location='http://localhost/b2v2/offline';
    else
    {
        if ((strpath.search('.mp4') > 0) || (strpath.search('.webm') > 0) || (strpath.search('.ogg') > 0))
        {
            content += "<video class='embed' width='320' height='240' controls><source src='"+strpath+"'></video>&nbsp;<abbr title='For Internet Explorer, right-click on the play button and select play/pause'>Trouble playing Media?&nbsp;<span class='glyphicon glyphicon-question-sign'></span></abbr><br>";
        }
        else if ((strpath.search('.mp3') > 0) || (strpath.search('.wav') > 0) || (strpath.search('.ogg') > 0))
        {
            content += "<audio class='embed' controls><source src='"+strpath+"'></audio>&nbsp;<abbr title='For Internet Explorer, right-click on the play button and select play/pause'>Trouble playing Media?&nbsp;<span class='glyphicon glyphicon-question-sign'></span></abbr><br>";
        }
        else if ((strpath.search('.avi') > 0) || (strpath.search('.asf') > 0) || (strpath.search('.wmv') > 0))
        {
            content += "<embed class='embed' width='320' height='240' src='"+strpath+"'></embed>&nbsp;<abbr title='For Internet Explorer, right-click on the play button and select play/pause'>Trouble playing Media?&nbsp;<span class='glyphicon glyphicon-question-sign'></span></abbr><br>";
        }
        else if ((strpath.search('.m4a') > 0) || (strpath.search('.mkv') > 0) || (strpath.search('.flv') > 0))
        {
            content += "<a href='"+strpath+"' target='_blank'>"+$('#mediaTitle').val()+"</a>&nbsp;<abbr title='For Internet Explorer, right-click on the play button and select play/pause'>Trouble playing Media?&nbsp;<span class='glyphicon glyphicon-question-sign'></span></abbr><br>";
        }

        $('#summernote').code(content);
        $('#uploadController').fadeOut();
        $("#uploadName").html("");
        $('#newMedia').val("");
        $('#mediaTitle').val("");
        uploading = false;
    }
}
function progressHandler(event){
	var percent = (event.loaded / event.total) * 100;
    $('#uploadController').fadeIn();
    document.getElementById('progressBar').style.width = percent+'%';
	$("#uploadName").html($("#mediaTitle").val());
}

function errorHandler(event)
{
	_("uploadName").innerHTML = "<h4 class='obstruct'>Sorry, upload failed!</h4>";
    $('body,html').animate({ scrollTop: 0}, 0);
    uploading = false;
}
function abortHandler(event)
{
	_("uploadName").innerHTML = "<h4 class='obstruct'>Upload aborted</h4>";
    $('body,html').animate({ scrollTop: 0}, 0);
    uploading = false;
}

//functions for adding resources

function addResource()
{
    $('#getResourceModal').modal('show');
    if (res == 0)
    {
        oTableResource=$('#resourcesTable').dataTable( {
            "ajax": 'http://localhost/b2v2/getResourceWritingData',
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
        } );
        res++;
    }

}

function useResource(rid,title)
{
    var content = $('#summernote').code();
    content+="<a href='http://localhost/b2v2/resource/"+rid+"' class='btn btn-success'>"+title+"</a>";
    $('#summernote').code(content);
    $('#getResourceModal').modal('hide');
}

function changeButton()
{
    var mediaPath = $('#newMedia').val();
    $('#selectFileButton').html(mediaPath);
}

function addNewListItem()
{
    ListItem++;

    $.post('http://localhost/b2v2/getArticleTemplate', {type: 'List', count: ListItem}, function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://localhost/b2v2/offline';
        else
        {
            $('#articleFields').append("<br>"+markup);
            $('#summ'+ListItem).summernote({
                height:200,
                onkeydown: function(e) {
                    checkListCharacters(ListItem);
                }
            });
            $('html, body').animate({scrollTop:$(document).height()}, 1000);
            $('#ListHeader'+ListItem).focus();
        }
    });
}

function addNewTrack()
{
    ListItem++;

    $.post('http://localhost/b2v2/getArticleTemplate', {type: 'Music Review', count: ListItem}, function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://localhost/b2v2/offline';
        else
        {
            $('#trackList').append("<br>"+markup);
            $('#summ'+ListItem).summernote({
                height:200,
                onkeydown: function(e) {
                    checkListCharacters(ListItem);
                }
            });
            $("#rating"+ListItem).rating();
            $(".rating-kv").rating();
            $('html, body').animate({scrollTop:$(document).height()}, 1000);
            $('#trackName'+ListItem).focus();
        }
    });
}

function addNewBlock()
{
    ListItem++;

    $.post('http://localhost/b2v2/getArticleTemplate', {type: 'Code Article', count: ListItem}, function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://localhost/b2v2/offline';
        else
        {
            $('#articleFields').append("<br>"+markup);
            $('#summ'+ListItem).summernote({
                height:200,
                onkeydown: function(e) {
                    checkListCharacters(ListItemsjvbj);
                },
                toolbar: [
                    ['insert', ['picture', 'link', 'video', 'hr']],
                    ['misc', ['fullscreen', 'undo', 'redo']]
                ],
                font: 'courier'
            });
            $('#summm'+ListItem).summernote({
                height:200,
                onkeydown: function(e) {
                    checkListCharacters(ListItemsjvbj);
                },
                font: 'courier'
            });
            $('html, body').animate({scrollTop:$(document).height()}, 1000);
            $('#summ'+ListItem).focus();
        }
    });
}

function backToTheEdit()
{
    $('#reviewSubmissionModal').modal('hide');
    $(".summernote").css("opacity","1");
}

function removeLastItem()
{
    bootbox.confirm('Are you sure?', function(response)
    {
       if (response == true)
       {
           $('#LIST'+ListItem).html('');
           ListItem--;
       }
    });
}

function removeLastTrack()
{
    bootbox.confirm('Are you sure?', function(response)
    {
        if (response == true)
        {
            $('#TRACK'+ListItem).html('');
            ListItem--;
        }
    });
}

function removeLastBlock()
{
    bootbox.confirm('Are you sure?', function(response)
    {
        if (response == true)
        {
            $('#CABLOCK'+ListItem).html('');
            ListItem--;
        }
    });
}