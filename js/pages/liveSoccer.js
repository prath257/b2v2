var feed=null;
var height=0;
var timer=null;
var tr=-1;
var check=[];
var userSearchTimer=null;
var searchOn=false;
var searchString=null;
var restComment='';
var slogan=true;
var filter='all';

$(document).ready(function()
{

    feed=$('#feedNo').val();
    $.post('http://b2.com/getLiveSoccerData', {feedNo: feed,type:tr,dataFilter:filter}, function (data)
    {
        $('#scrollDiv').html(data);
        getLiveData(feed);
    });
     height= $(window).height();
    $('#liveScoreModal').on('hidden.bs.modal', function (e)
    {
        // do something...
        $('#scorerBody').html('');
    });

    //this is for data filter
    $(".btn-group button").click(function ()
    {
        filter=$(this).val();
        var gid=this.id;
        if(gid=="sab")
        {
            $('#sab').addClass('btn-primary');
            $('#sfb').removeClass('btn-primary');
            $('#stb').removeClass('btn-primary');
            applyFilter();

        }
        else if(gid=="sfb")
        {
            $('#sfb').addClass('btn-primary');
            $('#sab').removeClass('btn-primary');
            $('#stb').removeClass('btn-primary');
            applyFilter();

        }
        else
        {
            $('#stb').addClass('btn-primary');
            $('#sfb').removeClass('btn-primary');
            $('#sab').removeClass('btn-primary');
            applyFilter();

        }
    });

    //this is the code to hide search results upon outside click
    $(document).click(function (e)
    {

        if ($(e.target).is('#searchResult'))
        {
            //do nothing
        }
        else if($(e.target).is('#commentText'))
        {
            $('body,html').animate({ scrollTop: 150}, 500);
            $('#searchResult').html('');
            $('#searchResult').hide();

        }
        else
        {
            $('#searchResult').html('');
            $('#searchResult').hide();
        }
    });

});
function addZero(i)
{
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

function getdate() {
    var d = new Date();
    var x = document.getElementById("demo");
    var h = addZero(d.getUTCHours());
    var m = addZero(d.getUTCMinutes());
    var s = addZero(d.getUTCSeconds());
    $("#ct").html(h+":"+m);
}


function getLiveData()
{
   getdate();
   tr++;
   $.post('http://b2.com/getLiveSoccerData', {feedNo: feed,type:tr%3,dataFilter:filter}, function (data)
   {
            $('#scrollDiv').prepend(data);

   });
   timer=setTimeout(getLiveData,17000);
}

//this is the code to search the other users

function checkSearch(event)
{
    var x = event.which || event.keyCode;
    if(x==64)
    {

        searchOn=true;
    }
    if(searchOn)
    {
       if(x==32)
       {
          searchOn=false;
       }

    }
}
function playerCommentsDown()
{
    if(searchOn)
    {
        clearTimeout(userSearchTimer);
    }
}

function playerCommentsUp()
{
    if(searchOn)
    {
        clearTimeout(timer);
        var userName=$('#commentText').val().split("@");
        searchString=userName[userName.length-1];
        restComment='';
        for(var i=0;i<userName.length-1;i++)
        {
               restComment+=userName[i];
        }

        userSearchTimer = setTimeout(function ()
        {
           searchUser(searchString);
        }, 500);
    }
}

function searchUser(val)
{
    if(val=='')
    {

    }
    else
    {
        if(searchOn)
        {
            $('#searchResult').html('<div style="text-align: center"><img src="http://b2.com/Images/icons/waiting.gif">Searching...</div>');
            $('#searchResult').show();
            $.post('http://b2.com/searchSoccerFriends', {name: val}, function (markup)
            {
                if (markup == 'wH@tS!nTheB0x')
                    window.location = 'http://b2.com/offline';
                else
                {
                    $('#searchResult').fadeIn();
                    $('#searchResult').html(markup);

                }
            });
        }
    }
}

function addUser(uname)
{
    var finalComment=restComment+'~'+uname+' ';
    $('#commentText').val(finalComment);
    $('#searchResult').html('');
    $('#searchResult').hide();
    searchOn=false;
    timer=setTimeout(getLiveData,17000);
}


function postComment()
{
    //this is the code to post the comment

    var comment=$('#commentText').val();
    if(comment.length>2)
    {
        clearTimeout(timer);
        $('#commentText').val('');
        $.post('http://b2.com/saveUserComment',{feedNo:feed,text:comment,tag:slogan,dataFilter:filter},function(data)
        {
            $('#scrollDiv').prepend(data);
            $('#commentArea').html('');
            timer=setTimeout(getLiveData,17000);
        })
    }
}

function showScore()
{
    $.post('http://b2.com/getLiveScore',{type:null},function(data)
    {
       $('#scoreBody').html(data);
        $('#liveScoreModal').modal({
            keyboard: true,
            show: true
        });

    });

}

//functions for filters

function setSlogan(radio)
{
    if(slogan==true)
    {
        slogan=false;
        $('#sloganSet').prop('checked', false);
    }
    else
    {
        slogan=true;
        $('#sloganSet').prop('checked', true);
    }
}

function applyFilter()
{
    clearTimeout(userSearchTimer);
    $('#scrollDiv').html('<div style="text-align: center"><img src="http://b2.com/Images/icons/waiting.gif">Filtering...</div>');
    $.post('http://b2.com/getFilterData',{feedNo:feed,dataFilter:filter},function(data)
    {
        $('#scrollDiv').html(data);
        timer=setTimeout(getLiveData,17000);
    });
}
