/**
 * Created by BBarters on 7/9/14.
 */
var indexShown=false;
var currentIndex=0;
var bookId=0;
var newUser=0;
var cid=0;
var chaptersNos;
var chapterCount=0;
$(document).ready(function()
{
    bookId=$('#bookId').val();
    currentIndex=-1;
    $.post('http://localhost/b2v2/getBlogbookContent',{id:-1,bid:bookId},function(data)
    {
        $('#Content').fadeOut(500);

        var timer = window.setInterval( function() {


            $('#Content').html(data);
            $('#Content').fadeIn(500);

            clearInterval(timer);

        }, 500);

    });

    $.post('http://localhost/b2v2/getBookChapterList',{bid:bookId},function(data)
    {
        if(data=='wH@tS!nTheB0x')
            window.location='http://localhost/b2v2/offline';
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
        $.post('http://localhost/b2v2/getIFCs', function(ifc)
        {
            if(ifc=='wH@tS!nTheB0x')
                window.location='http://localhost/b2v2/offline';
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
        $("#bookIndex").animate({'width': 240},500);
        indexShown=true;
    }
    else
    {
        $("#bookIndex").animate({'width': 0},500,function(){
        $("#bookIndex").css('display','none')
        });
        indexShown=false;
    }
}

function showContent(th)
{
    currentIndex=parseInt(th.name);
    cid=chaptersNos[currentIndex];

    $('#Content').html("<img src='http://localhost/b2v2/Images/icons/waiting.gif'> Loading...");
     $.post('http://localhost/b2v2/getBlogbookContent',{id:cid,bid:bookId},function(data)
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
        bootbox.alert('No More chapters in this book');
        currentIndex--;
    }
    else
    {
        cid=chaptersNos[currentIndex];

        $('#Content').html("<img src='http://localhost/b2v2/Images/icons/waiting.gif'> Loading...");
        $.post('http://localhost/b2v2/getBlogbookContent',{id:cid,bid:bookId},function(data)
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

                var timer = window.setInterval( function() {


                    $('#Content').html(data);
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
        bootbox.alert('The Book starts here');
        currentIndex++;
    }
    else
    {
        if(currentIndex==-1)
            cid=-1;
        else
            cid=chaptersNos[currentIndex];

        $('#Content').html("<img src='http://localhost/b2v2/Images/icons/waiting.gif'> Loading...");
        $.post('http://localhost/b2v2/getBlogbookContent',{id:cid,bid:bookId},function(data)
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
                    $('#Content').fadeIn(500);

                    clearInterval(timer);

                }, 500);
            }
        });
    }

}