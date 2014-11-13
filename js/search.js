var whenready=true;
var flag=0;
var loggedout = false;

$(document).ready(function()
{

    var timer = window.setInterval( function() {
             if(whenready)
             {
                 $.ajax({
                     type: "POST",
                     url: 'http://b2.com/numberOfNotifications',
                     beforeSend: function()
                     {
                         whenready=false;
                     }
                 }).done(function(data)
                 {
                     if(data=='wH@tS!nTheB0x' && !loggedout)
                     {
                         loggedout = true;
                         window.location = "http://b2.com/offline";
                     }
                     else
                     {
                         $('#no_of_notification').html(data);

                         data = parseInt(data);
                         if (data == 0)
                             $('#no_of_notification').css({visibility: 'hidden'});
                         else
                             $('#no_of_notification').css({visibility: 'visible'});

                         whenready=true;
                     }
                 });

             }

    }, 5000);

    $(document).click(function(e){
        if ($(e.target).is('#searchModal,#searchModal *')) {
            //Do Nothing
        }
        else
        {
            $('#searchModal').fadeOut();
            $('#search').val("");
        }
    });
    $(document).keyup(function(e) {
        if (e.keyCode == 27)
        {
            $('#search').val("");
            $('#searchModal').fadeOut();
            $('#search').blur();
        }
        else if (e.keyCode == 8)
        {
            $('#searchModal').fadeOut();
        }
    });


    $('#searchForm').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
        executeSearch();
    });

    $("#peopleLabel").addClass("btn-info");
    document.getElementById('search').placeholder="Search Barters";


    $('#notificationForm').submit(function(event)
    {
        event.preventDefault();
        getNoti();
    });


    $(document).click(function(e){
        if ($(e.target).is('#notificationModal2,#notificationModal2 *'))
        {

            //Do Nothing
        }
        else
        {

            if(!$(e.target).is('#notificationli,#notificationli *'))
            {
                $('#notificationModal2').slideUp(500);
                flag=0;
            }


        }
    });

    $(document).keyup(function(e) {
        if (e.keyCode == 27)
        {
            $('#notificationText').html('');
            $('#notificationModal2').fadeOut();
            $('#notification').blur();
        }
        else if (e.keyCode == 8)
        {
            $('#notificationModal2').fadeOut();
        }
    });

    window.onbeforeunload = function()
    {
        $.post('http://b2.com/removeIsOnline',function(error){
            if(error=='wH@tS!nTheB0x' && loggedout == false)
            {
                loggedout = true;
                window.location='http://b2.com/offline';
            }
        });
    }

});




function changeClass(button)
{
    $(".labelButtons").removeClass("btn-info");
    $("#"+button+"Label").addClass("btn-info");
    if (button == 'people')
        document.getElementById('search').placeholder="Search Barters";
    else
        document.getElementById('search').placeholder="Search Content";
}

function executeSearch()
{
    var keywords = $("#search").val();
    var search = $("input:radio[name=searchOptions]:checked").val();
    var constraint = 'all';
    var request = 'home';

    if (keywords.length > 2)
    {
        $.post('http://b2.com/getSuggestions', {search: search, keywords: keywords, constraint: constraint, request: request}, function(data)
        {
            if(data)
            {
                if(data=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                {
                    $("#searchText").html(data);
                    $('#searchModal').fadeIn();
                }
            }
        });
    }
}


function hoverEffect(element)
{
    element.style.backgroundColor="skyblue";
}
function normalEffect(element)
{
    element.style.backgroundColor="whitesmoke";
}

function visitProfile(username)
{
    window.location='http://b2.com/user/'+username;
}

function getNoti()
{
    var d="none";

    if(flag==0)
    {

        $.ajax({

            type: "POST",
            url: 'http://b2.com/notificationList',
            data:{d:d},
            beforeSend: function()
            {
                $("#notificationText").html(" <div class='col-lg-12' style='text-align: center'> <img src='Images/icons/waiting.gif'> </div>");
                $('#notificationModal2').slideDown(300);
            }
        }).done(function(data)
        {

            if(data)
            {
                if(data=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                    $("#notificationText").html(data);
            }
        });
        flag=1;
    }
    else
    {
        $('#notificationModal2').slideUp(200);
        flag=0;
    }
}


function acceptFriendR(notiid,cuserid)
{

    $.ajax({

        type: "POST",
        url: "http://b2.com/acceptFriend/"+cuserid,
        data:{type:'kind'},
        beforeSend: function()
        {
            $('#btns'+notiid).html("");

        }
    }).done(function(response)
    {
        if(response=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';

    });

}

function declineFriendR(notiid,cuserid)
{
    $('#btns'+notiid).html("");

    $.post("http://b2.com/declineFriend/"+cuserid,{type:'kind'},function(data)
    {
        if(data=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';

    });
}


/*

function acceptAboutR(notiid,id)
{
    $('#btns'+notiid).html("");

    $.post('http://b2.com/acceptAbout', {aid:id}, function(data)
    {

    });

}

function declineAboutR(notiid,id)
{

    $('#btns'+notiid).html("");

    $.post('http://b2.com/declineAbout', {aid: id}, function(data)
    {

    });
}*/



//Chat

function acceptChatR(notiid,acid)
{
    $('#btns'+notiid).html('');

    $.ajax({
        type: "POST",
        url: "http://b2.com/acceptChat",
        data: {id:acid}
    }).done(function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        if (error!="success")
        {

        }
        else
        {
            $.post('http://b2.com/getChatLink',{id: acid}, function(link)
            {
                if(link=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                // /*window.open('http://b2.com/chatRoom/'+link, '_blank', "height=400,width=270,resizable=false");*//*
                else
                    window.location='http://b2.com/chats/'+link;

                /*
                * *$.post('http://b2.com/getSecondPartyName',{id: acid}, function(name)
                 {
                 $("#ongoingChats").append("<div id='Chat"+acid+"' class='chats' onclick='openChat("+acid+")'>"+name+"</div><br>");
                 });

                */
            });
        }
    });

}

function declineChatR(notiid,dcid)
{
    $('#btns'+notiid).html("");

            $.ajax({
                type: "POST",
                url: "http://b2.com/declineChat",
                data: {id:dcid}
            }).done(function(data)
            {
                if(data=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';

            });

}

function startChatR(scid)
{
    $.post('http://b2.com/getChatLink',{id: scid}, function(link)
    {
        if(link=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        /*window.open('http://b2.com/chatRoom/'+link, '_blank', "height=400,width=270,resizable=false");*/
        else
        {
            $("#notifyModal").modal('hide');
            $("#notifyText").html("");


            window.location='http://b2.com/chats/'+link;


            /*$.post('http://b2.com/getSecondPartyName',{id: scid}, function(name)
             {
             $("#ongoingChats").append("<div id='Chat"+scid+"' class='chats' onclick='openChat("+scid+")'>"+name+"</div><br>");
             });*/
        }
    });
}
