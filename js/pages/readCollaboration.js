/**
 * Created by BBarters on 7/9/14.
 */
var indexShown=false;
var currentIndex=0;
var cid=0;
var collabId=0;
var newUser=false;
var chaptersNos;
var chapterCount=0;
$(document).ready(function()
{
    collabId=$('#collabId').val();
    currentIndex=-1;
    $.post('http://b2.com/getCollaborationContent',{id:-1,colid:collabId},function(data)
    {
        if(data=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#Content').fadeOut(500);

            var timer = window.setInterval( function() {


                $('#Content').html(data);
                $('#Content').fadeIn(500);

                clearInterval(timer);

            }, 500);
        }
    });

    $.post('http://b2.com/getCollabChapterList',{cid:collabId},function(data)
    {
        if(data=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            chaptersNos=data;
            chapterCount=chaptersNos.length;
        }
    });

    //this is the event handler for hiding the IFC counter
    $(document).click(function(e){
        if ($(e.target).is('#mycounter,#mycounter *')) {
            //Do Nothing
        }
        else
        {
            $('#mycounter').fadeOut();
        }
    });

    //this is to show the IFC counter
    newUser = $('#newUser').val();
    if (newUser==true)
    {
        $.post('http://b2.com/getIFCs', function(ifc)
        {
            if(ifc=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                $("#mycounter").fadeIn();
                $("#mycounter").flipCounterInit({'speed': 0.05});
                $("#mycounter").flipCounterUpdate(ifc);
            }
        });
    }
});
function showIndex()
{
    if(indexShown==false)
    {
        $("#bookIndex").css('display','block');
       $("#bookIndex").animate({'width': 150},500);
        $("#relcontent").hide();
        indexShown=true;
    }
    else
    {
        $("#bookIndex").animate({'width': 0},500,function(){
        $("#bookIndex").css('display','none')
        });
        $("#relcontent").show();
        indexShown=false;
    }
}

function showContent(th)
{
    currentIndex=parseInt(th.name);
    cid=chaptersNos[currentIndex];

    $('#Content').html("<img src='http://b2.com/Images/icons/waiting.gif'> Loading...");
    $.post('http://b2.com/getCollaborationContent',{id:cid,colid:collabId},function(data)
    {
        if(data=='wH@tS!nTheB0x')
        {
            bootbox.alert('The Chapter you are trying to read has been removed, reloading the book',function()
            {
                window.location.reload();
            });
        }
        else
        {
            $('#Content').fadeOut(500);

            var timer = window.setInterval(function () {


                $('#Content').html(data);
                $('.embed').bind('contextmenu',function() { return false; });
                $('#Content').fadeIn(500);

                clearInterval(timer);

            }, 500);
        }

    });

}

function showNext()
{
    currentIndex++;
    if(currentIndex==chapterCount)
    {
        bootbox.alert('No More chapters in this Collaboration');
        currentIndex--;
    }
    else
    {
        cid=chaptersNos[currentIndex];
        $('#Content').html("<img src='http://b2.com/Images/icons/waiting.gif'> Loading...");
        $.post('http://b2.com/getCollaborationContent',{id:cid,colid:collabId},function(data)
        {
            if(data=='wH@tS!nTheB0x')
            {
                bootbox.alert('The Chapter you are trying to read has been removed, reloading the book',function()
                {
                    window.location.reload();
                });
            }
            else
            {
                $('#Content').fadeOut(500);

                var timer = window.setInterval(function () {


                    $('#Content').html(data);
                    $('.embed').bind('contextmenu',function() { return false; });
                    $('#Content').fadeIn(500);

                    clearInterval(timer);

                }, 500);
            }

        });
    }

}


function showPrev()
{
    currentIndex--;
    if(currentIndex < -1)
    {
        bootbox.alert('The Collaboration Starts here');
        currentIndex++;
    }
    else
    {
        if(currentIndex==-1)
            cid=-1;
        else
            cid=chaptersNos[currentIndex];
        $('#Content').html("<img src='http://b2.com/Images/icons/waiting.gif'> Loading...");
        $.post('http://b2.com/getCollaborationContent',{id:cid,colid:collabId},function(data)
        {
            if(data=='wH@tS!nTheB0x')
            {
                bootbox.alert('The Chapter you are trying to read has been removed, reloading the book',function()
                {
                    window.location.reload();
                });
            }
            else
            {
                $('#Content').fadeOut(500);

                var timer = window.setInterval(function () {


                    $('#Content').html(data);
                    $('.embed').bind('contextmenu',function() { return false; });
                    $('#Content').fadeIn(500);

                    clearInterval(timer);

                }, 500);
            }

        });
    }

}

function backtotop()
{

    $('body,html').animate({ scrollTop: 0}, 300);
}