var feed=null;
var height=0;
var timer=null;
var tr=-1;
var check=[];
var userSearchTimer=null;
var searchOn=false;
var searchString=null;
var restComment='';

$(document).ready(function()
{

    feed=$('#feedNo').val();
    $.post('http://b2.com/getLiveSoccerData', {feedNo: feed,type:tr}, function (data)
    {
        $('#scrollDiv').html(data);
        getLiveData(feed);
    });
     height= $(window).height();
    $('#liveScoreModal').on('hidden.bs.modal', function (e)
    {
        // do something...
        $('#scorerBody').html('');
    })
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
   $.post('http://b2.com/getLiveSoccerData', {feedNo: feed,type:tr%3}, function (data)
   {
            $('#scrollDiv').prepend(data);

   });
   timer=setTimeout(getLiveData,13000);
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
            $.post('http://b2.com/searchSoccerFriends', {name: val}, function (markup) {
                if (markup == 'wH@tS!nTheB0x')
                    window.location = 'http://b2.com/offline';
                else {
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
    $('#searchResult').hide();
    searchOn=false;
    timer=setTimeout(getLiveData,13000);
}


function postComment()
{
    //this is the code to post the comment

    var comment=$('#commentText').val();
    if(comment.length>2)
    {
        clearTimeout(timer);
        $('#commentSpace').hide();
        $('#commentArea').html("<div style='text-align:center'><img  src='http://b2.com/Images/icons/waiting.gif'>Posting..</div>");
        $.post('http://b2.com/saveUserComment',{feedNo:feed,text:comment},function(data)
        {
            $('#scrollDiv').prepend(data);
            $('#commentText').val('');
            $('#commentSpace').fadeIn();
            $('#commentArea').html('');
            timer=setTimeout(getLiveData,13000);
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
