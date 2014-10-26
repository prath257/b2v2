$(document).ready(function()
{
    var width = $(window).width();
    if (width<1200)
    {
        $("#iconsContainer").removeClass("col-lg-2");
        //this is the code to show the content toolbar
        $('#button-right').toolbar({content: '#user-options', position: 'bottom',hideOnClick:true});
        $('#social').toolbar({content: '#social-options', position: 'bottom',hideOnClick:true});
        $('#write').toolbar({content: '#write-options', position: 'bottom',hideOnClick:true});
        $('#emptyDiv').html("");
    }
    else
    {
        //this is the code to show the content toolbar
        $('#button-right').toolbar({content: '#user-options', position: 'right',hideOnClick:true});
        $('#social').toolbar({content: '#social-options', position: 'right',hideOnClick:true});
        $('#write').toolbar({content: '#write-options', position: 'right',hideOnClick:true});
    }

	getChats();

    $('#ptButton').tooltip();
    $('#button-right').tooltip();
    $('#social').tooltip();
    $('#write').tooltip();
});

function getChats()
{
    showTrivia();
    setTimeout(getChats,4000);
}

var count = 1;
function showTrivia()
{
	count = ($(".slideshow :nth-child("+count+")").fadeOut().next().length == 0) ? 1 : count+1;
	$(".slideshow :nth-child("+count+")").fadeIn();
}

function showAbout()
{
    $('#about').bPopup({
        fadeSpeed: 'slow', //can be a string ('slow'/'fast') or int
        followSpeed: 500, //can be a string ('slow'/'fast') or int
        opacity:0.7,
        zIndex:1,
        transition:'slideIn',
        speed:500,
        position:[0,0]
    });
}

function showAsk()
{
    $('#ask').bPopup({
        fadeSpeed: 'slow', //can be a string ('slow'/'fast') or int
        followSpeed: 500, //can be a string ('slow'/'fast') or int
        opacity:0.7,
        zIndex:1,
        transition:'slideIn',
        speed:500,
        position:[0,0]
    });
}

function playPause(btn)
{
    //this is a funciton to alter audio in profile tune
    var audio=document.getElementById("pt");
    var ptButton=document.getElementById("ptButton");
    if(audio.paused == false)
    {

        $('#ptButton').removeClass('glyphicon-pause');
        $('#ptButton').addClass('glyphicon-music');
        audio.pause();
    }
    else
    {
        $('#ptButton').addClass('glyphicon-pause');
        $('#ptButton').removeClass('glyphicon-music');
        audio.play();
    }
}

function showDescription(descrption)
{
    $("#readDescriptionContent").html(descrption);
    $("#readDescriptionModal").modal('show');
}

function showAnswer(aid)
{
    $.post('http://b2.com/getAnswer',{id: aid},function(answer)
    {
        if(answer=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $("#readAnswerContent").html(answer);
            $("#readAnswerModal").modal('show');
        }
    });
}