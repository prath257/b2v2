var chatON=false;
var focused = null;
var width;
var loggedout = false;
var searchInterval;

$(document).ready(function()
{
    $('#chatBPopup').height($(window).height()*0.9);
    $('#friendlist').height($(window).height()*0.6);

    width = $(window).width();
    if (width < 1200)
    {
        $('#font-awesome-right').removeClass('glyphicon-chevron-left');
        $('#font-awesome-right').addClass('glyphicon-chevron-top');
    }

    var chatLink = $("#openChat").val();
    if (chatLink!="")
    {
        chatON=true;
        $("#chatText").html('<img src="http://b2.com/Images/icons/waiting.gif" style="margin-left: 45% ">');
        var chatId = $("#hiddenChatId").val();
        $.post('http://b2.com/getChatData',{id: chatId}, function(data)
        {
            if(data=='wH@tS!nTheB0x')
            {
                if (loggedout == false)
                {
                    loggedout = true;
                    window.location='http://b2.com/offline';
                }

            }
            else
            {
                /*window.open('http://b2.com/chatRoom/'+link, '_blank', "height=400,width=270,resizable=false");*/


                /*            var w = window.innerWidth;
                 var h = window.innerHeight;

                 if (w > 1000)
                 {
                 posw = 0.7*w;
                 var iframew = 0.3*w;
                 }
                 else if (w < 500)
                 {
                 posw = 0.1*w;
                 var iframew = 0.85*w;
                 }
                 else
                 {
                 posw = 0.5*w;
                 var iframew = 0.5*w;
                 }

                 document.getElementById('chatNameHolder').style.width = iframew+"px";
                 document.getElementById('chatbar').style.width = iframew+"px";*/
                if (data != 'chat_over')
                {
                    $.post('http://b2.com/getSecondPartyName', {id: chatId}, function(name)
                    {
                        if(name=='wH@tS!nTheB0x')
                        {
                            if (loggedout = false)
                            {
                                loggedout = true;
                                window.location='http://b2.com/offline';
                            }

                        }
                        else
                        {
                            $.post('http://b2.com/getSecondPartyProfilePic', {id: chatId}, function(url)
                            {
                                if(url=='wH@tS!nTheB0x')
                                {
                                    if (loggedout = false)
                                    {
                                        loggedout = true;
                                        window.location='http://b2.com/offline';
                                    }

                                }
                                else
                                {
                                    $("#chatProfilePic").html("<img src='"+url+"' height='40px' width='40px'>");
                                    $("#chatName").html("<i>"+name+"</i>");
                                    $("#chatText").html(data);
                                    $('#inputText').prop('disabled',false);
                                    $('#chatTextSubmit').prop('disabled',false);
                                    /*$('#chatBPopup').bPopup({
                                     *//*content:'iframe', //'ajax', 'iframe' or 'image'*//*
                                 *//* contentContainer: '#chatIframe',*//*
                                 *//*loadUrl:'http://b2.com/chatRoom/'+link+'#inputText', //Uses jQuery.load()*//*
                                 escClose: false,
                                 modalClose: false,
                                 positionStyle: 'fixed',
                                 transition: 'fadeIn',
                                 position: [posw,0]
                                 *//*iframeAttr: 'scrolling:"yes", width="'+iframew+'", height="'+h+'", frameborder="0"'*//*
                                 });*/
                                    $("#scrollDiv").animate({ scrollTop: $('#scrollDiv')[0].scrollHeight}, 1000);
                                }
                            });
                        }
                    });
                }
                else
                {
                    if (width < 1200)
                        var htmlclass = 'glyphicon-chevron-top';
                    else
                        var htmlclass = 'glyphicon-chevron-left';
                }
                $("#chatText").html('<h3 style="text-align: center"><span id="font-awesome-right" class="glyphicon '+htmlclass+'"></span> Pick up a name to start chatting</h3>');
            }
        });
    }

    $("#newChatForm").bootstrapValidator(
        {
            live:'enabled',
            submitButtons: 'button[id="newChatSubmit"]',
            message: 'This value is not valid',
            fields:{
                newChatReason:{
                    validators:{
                        notEmpty:{
                            message: "Sorry dawg, a reason is REQUIRED."
                        },
                        stringLength: {
                            min:10,
                            max:140,
                            message: 'A Min 10 and Max 140 characters is all you got.'
                        }
                    }
                }
            }
        }
    );





    $('ul.ranges a').click(function(e){
        e.preventDefault();

        // Get the number of days from the data attribute
        var el = $(this);
        days = el.attr('data-range');
        var pp=el.closest('li');
        var p=pp[0];
        if(p.id=='c'+days)
        {
            $("#chatData>li.active").removeClass("active");
            pp.addClass('active');
            requestData(days, chartChatAudit,'ChatAudit');
            requestData(days, chartChat,'Chat');


        }
    });

    window.onblur = function()
    {
        document.getElementById('inputText').blur();
        focused = false;
    }



    getChats();

    $('#messageForm').submit(function(event)
    {
        /* stop form from submitting normally */
        event.preventDefault();
    });

    $(document).click(function(e){
        if ($(e.target).is('#chatSearchModal,#chatSearchModal *')) {
            //Do Nothing
        }
        else
        {
            $('#chatSearchModal').fadeOut();
            $('#chatSsearch').val("");
        }
    });

    $('#newChatForm').submit(function(event)
    {
        /* stop form from submitting normally */
        event.preventDefault();
    });
});



function requestData(days, chart, type)
{
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "http://b2.com/get"+type+"ChartData", // This is the URL to the API
        data: { days: days }
    })
        .done(function(data) {
            if(data=='wH@tS!nTheB0x')
            {
                if (loggedout = false)
                {
                    loggedout = true;
                    window.location='http://b2.com/offline';
                }

            }
            else
            {
                // When the response to the AJAX request comes back render the chart with new data
                chart.setData(data);
            }
        })
        .fail(function() {
            // If there is no communication between the server, show an error
            alert( "error occured" );
        });
}


function getChats()
{
    retrieveOngoingChats();
    refreshOnlineFriends();

    checkClosedChats();
    checkNewMessages();

    if (chatON)
    {
        retrieveIsTyping();
        retrieveChatData();
    }
    setTimeout(getChats,3000);
}

function retrieveOngoingChats()
{
    try
    {
        $.post('http://b2.com/retrieveOngoingChats', function(markup)
        {
            if(markup=='wH@tS!nTheB0x')
            {
                if (loggedout = false)
                {
                    loggedout = true;
                    window.location='http://b2.com/offline';
                }

            }
            else
                $('#ongoingChatsList').html(markup);
        });
    }
    catch(error)
    {
        //do nothing
    }
}

function updateNotifications(){
    // Assuming we have #shoutbox\
    var notifyModalContent = $("#notifyText").html();
    if(notifyModalContent=="")
    {
        $.post('http://b2.com/getChatNotifications',function(data)
        {
            if(data)
            {
                if (data != 'TheMonumentsMenGeorgeClooneyMattDamon')
                {
                    $("#notifyText").html(data);
                    $('#notifyModal').modal({
                        keyboard:false,
                        show:true,
                        backdrop:'static'
                    });
                }
            }
        });
    }
}

function checkNewMessages()
{
    var status = $("#newMessagesStatus").val();
    $.post('http://b2.com/checkNewMessages',function(chatid)
    {
        if(chatid=='wH@tS!nTheB0x')
        {
            if (loggedout = false)
            {
                loggedout = true;
                window.location='http://b2.com/offline';
            }

        }
        else
        {
            if (chatid=="TheMonumentsMenGeorgeClooneyMattDamon")
            {
                if (status=="")
                {
                    $(".chats").removeClass('success');
                    $(".chats").addClass('info');
                }
            }
            else if (chatid.length>0)
            {
                $("#newMessagesStatus").val("true");
                $("#Chat"+chatid).removeClass('info');
                $("#Chat"+chatid).addClass('success');
                $("#pageTitle").html("New Message..");
                var tunePlayed = $("#tunePlayed").val();
                if (tunePlayed=="false")
                {
                    var audio=document.getElementById("notificationSound");
                    audio.play();
                    $("#tunePlayed").val("true");
                }
            }
        }
    });
}

function minimizeChat()
{
    $("#tunePlayed").val("false");
    chatON=false;
    var chatId = $("#hiddenChatId").val();
    $("#Chat"+chatId).css("background-color","darkorange");
    $("#chatBPopup").bPopup().close();
    $("#hiddenChatId").val("");
    $("#hiddenChatName").val("");
    getChats();
}

function closeChat()
{
    $("#tunePlayed").val("false");
    /*$("#chatBPopup").bPopup().close();*/

    bootbox.confirm("Are you sure?", function(result) {
        if (result==true)
        {
            chatON=false;

            $('#pageTitle').html("Chats | BBarters");
            $('#inputText').prop('disabled',true);
            $('#chatTextSubmit').prop('disabled',true);
            $("#chatText").html('<img src="http://b2.com/Images/icons/waiting.gif" style="margin-left: 45% ">');
            var chatId = $("#hiddenChatId").val();
            $.post('http://b2.com/completeChat',{chatId: chatId}, function(error)
            {
                if(error=='wH@tS!nTheB0x')
                {
                    if (loggedout = false)
                    {
                        loggedout = true;
                        window.location='http://b2.com/offline';
                    }

                }
                else
                {
                    $("#hiddenChatId").val("");
                    $("#hiddenChatName").val("");
                    $('#chatProfilePic').html("");
                    $('#chatName').html("");
                    $('#isTyping').html("");
                    if (width < 1200)
                        var htmlclass = 'glyphicon-chevron-top';
                    else
                        var htmlclass = 'glyphicon-chevron-left';

                    $('#chatText').html('<h3 style="text-align: center"><span id="font-awesome-right" class="glyphicon '+htmlclass+'"></span> Pick up a name to start chatting</h3>');
                    /*$("#Chat"+chatId).html("");
                     $("#Chat"+chatId).hide();*/
                }
            });
        }
        /*else
        {
            var chId = $("#hiddenChatId").val();
            $.post('http://b2.com/getChatData',{id: chId}, function(data)
            {
                window.open('http://b2.com/chatRoom/'+link, '_blank', "height=400,width=270,resizable=false");
                $("#hiddenChatId").val(ocid);

                var w = window.innerWidth;
                var h = window.innerHeight;
                if (w > 1000)
                {
                    posw = 0.7*w;
                    var iframew = 0.3*w;
                }
                else if (w < 500)
                {
                    posw = 0.1*w;
                    var iframew = 0.85*w;
                }
                else
                {
                    posw = 0.5*w;
                    var iframew = 0.5*w;
                }
                document.getElementById('chatNameHolder').style.width = iframew+"px";
                document.getElementById('chatbar').style.width = iframew+"px";
                $("#chatText").html(data);
                $('#chatBPopup').bPopup({
                    content:'iframe', //'ajax', 'iframe' or 'image'
                    contentContainer: '#chatIframe',
                    loadUrl:'http://b2.com/chatRoom/'+link+'#inputText', //Uses jQuery.load()
                    escClose: false,
                    modalClose: false,
                    positionStyle: 'fixed',
                    transition: 'fadeIn',
                    position: [posw,0]
                    iframeAttr: 'scrolling:"yes", width="'+iframew+'", height="'+h+'", frameborder="0"'
                });
            });
        }*/
    });

    getChats();
}

function openChat(ocid,name)
{
    if ($("#hiddenChatId").val() != ocid)
    {
        $("#chatText").html('<img src="http://b2.com/Images/icons/waiting.gif" style="margin-left: 45% ">');
        $("#pageTitle").html("Chats");
        $("#newMessagesStatus").val("");
        $("#Chat"+ocid).removeClass("success");
        $("#Chat"+ocid).addClass("info");
        $.post('http://b2.com/getChatData',{id: ocid}, function(data)
        {
            if(data=='wH@tS!nTheB0x')
            {
                if (loggedout = false)
                {
                    loggedout = true;
                    window.location='http://b2.com/offline';
                }

            }
            else
            {
                /*window.open('http://b2.com/chatRoom/'+link, '_blank', "height=400,width=270,resizable=false");*/
                $("#hiddenChatId").val(ocid);
                chatON=true;
                $.post('http://b2.com/getSecondPartyName', {id: ocid}, function(name)
                {
                    if(name=='wH@tS!nTheB0x')
                    {
                        if (loggedout = false)
                        {
                            loggedout = true;
                            window.location='http://b2.com/offline';
                        }

                    }
                    else
                    {
                        name = name.split(" ", 1);
                        $("#hiddenChatName").val(name);
                    }
                });

                /*var w = window.innerWidth;
                 var h = window.innerHeight;
                 if (w > 1000)
                 {
                 posw = 0.7*w;
                 var iframew = 0.3*w;
                 }
                 else if (w < 500)
                 {
                 posw = 0.1*w;
                 var iframew = 0.85*w;
                 }
                 else
                 {
                 posw = 0.5*w;
                 var iframew = 0.5*w;
                 }
                 document.getElementById('chatNameHolder').style.width = iframew+"px";
                 document.getElementById('chatbar').style.width = iframew+"px";*/

                $.post('http://b2.com/getSecondPartyProfilePic', {id: ocid}, function(url)
                {
                    if(url=='wH@tS!nTheB0x')
                    {
                        if (loggedout = false)
                        {
                            loggedout = true;
                            window.location='http://b2.com/offline';
                        }

                    }
                    else
                    {
                        $("#chatProfilePic").html("<img src='"+url+"' height='40px' width='40px'>");
                        $("#chatName").html("<i>"+name+"</i>");
                        $("#chatText").html(data);
                        $('#inputText').prop('disabled',false);
                        $('#chatTextSubmit').prop('disabled',false);
                        /*$('#chatBPopup').bPopup({
                         *//*content:'iframe', //'ajax', 'iframe' or 'image'*//*
                     *//* contentContainer: '#chatIframe',*//*
                     *//*loadUrl:'http://b2.com/chatRoom/'+link+'#inputText', //Uses jQuery.load()*//*
                     escClose: false,
                     modalClose: false,
                     positionStyle: 'fixed',
                     transition: 'fadeIn',
                     position: [posw,0]
                     *//*iframeAttr: 'scrolling:"yes", width="'+iframew+'", height="'+h+'", frameborder="0"'*//*
                     });*/
                        $("#scrollDiv").animate({ scrollTop: $('#scrollDiv')[0].scrollHeight}, 1000);
                    }
                });
            }
        });
    }
}
function linkify(inputText) {
    var replacedText, replacePattern1, replacePattern2;

    //URLs starting with http://, https://, OR ftp://
    replacePattern1 = /(\b(http(s)?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
    replacedText = inputText.replace(replacePattern1, '<a href="$1" target="_blank">$1</a>');

    //URLs starting with "www." (without // before it, or it will re-link the ones done above)
    replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
    replacedText = replacedText.replace(replacePattern2, '$1<a href="http://$2" target="_blank">$2</a>');



    return replacedText;
}

function sendMessage()
{
    var chatText = linkify($("#inputText").val());
/*
    chatText=chatText.replace(/(www\..+?)(\s|$)/g, function(text, link) {
        return '<a target="_blank" href="http://'+ link +'">'+ link +'</a>';
    })*/

    var chatId = $("#hiddenChatId").val();

    if(chatText!="")
    {
        $("#inputText").val("");
        $("#chatText").append("<div style='word-wrap: break-word'><b>Me: </b>"+chatText+"</div><div class='col-lg-12'>&nbsp;</div>");
        $.ajax({
            type: "POST",
            url: "http://b2.com/sendMessage",
            data: {id:chatId, text:chatText}
        }).done(function(data)
        {
            if(data=='wH@tS!nTheB0x')
            {
                if (loggedout = false)
                {
                    loggedout = true;
                    window.location='http://b2.com/offline';
                }

            }
            else
            {
                isTypingFalse(chatId);
                $('#inputText').focus();
                $("#scrollDiv").animate({ scrollTop: $('#scrollDiv')[0].scrollHeight}, 1000);
            }
        });
    }
}

function retrieveChatData()
{
    var chatId = $("#hiddenChatId").val();
    {
        $.post('http://b2.com/retrieveChatData',{chatId: chatId},function(text)
        {
            if(text=='wH@tS!nTheB0x')
            {
                if (loggedout = false)
                {
                    loggedout = true;
                    window.location='http://b2.com/offline';
                }

            }
            else
            {
                if(text!='noData')
                {
                    var name = $('#hiddenChatName').val();
                    var div = document.getElementById('chatText');
                    if (text == 'Attention! The chat is over. '+name+' left the chat.')
                    {
                        div.innerHTML = div.innerHTML + '<div style="word-wrap: break-word"><b>'+text+'</b></div><div class="col-lg-12">&nbsp;</div>';
                        $('#inputText').prop('disabled',true);
                        $('#chatTextSubmit').prop('disabled',true);

                    }
                    else
                        div.innerHTML = div.innerHTML + '<div style="word-wrap: break-word"><b>'+name+': </b>'+text+'</div><div class="col-lg-12">&nbsp;</div>';
                        $("#scrollDiv").animate({ scrollTop: $('#scrollDiv')[0].scrollHeight}, 1000);

                    if (focused==false)
                    {
                        var audio=document.getElementById("notificationSound");
                        audio.play();
                    }
                }
            }
        });
    }

    /*}*/
}

function isTypingFalse(chatId)
{
    focused = false;
    $("#tunePlayed").val("false");
    if (chatId==null)
        chatId = $("#hiddenChatId").val();
    $.post('http://b2.com/isTypingFalse',{id: chatId},function(error){
        if(error=='wH@tS!nTheB0x' && loggedout == false)
        {
            loggedout = true;
            window.location='http://b2.com/offline';
        }
    });
}
function isTypingTrue()
{
    var chatId = $("#hiddenChatId").val();
    $.post('http://b2.com/isTypingTrue',{id: chatId},function(error){
        if(error=='wH@tS!nTheB0x')
        {
            if (loggedout = false)
            {
                loggedout = true;
                window.location='http://b2.com/offline';
            }

        }
    });
}


function retrieveIsTyping()
{
    var chatId = $("#hiddenChatId").val();

    $.post('http://b2.com/retrieveIsTyping',{chatId: chatId},function(status)
    {
        if(status=='wH@tS!nTheB0x')
        {
            if (loggedout = false)
            {
                loggedout = true;
                window.location='http://b2.com/offline';
            }

        }
        else
        {
            if(status==true)
            {
                $("#isTyping").html("<b>is typing...</b>");
            }
            else
            {
                $("#isTyping").html("");
            }
        }
    });
}

function focusedSet()
{
    focused = true;
    $('#pageTitle').html('Chats | BBarters');
}

function checkClosedChats()
{
    $.post('http://b2.com/checkClosedChats',function(chatid)
    {
        if(chatid=='wH@tS!nTheB0x')
        {
            if (loggedout = false)
            {
                loggedout = true;
                window.location='http://b2.com/offline';
            }

        }
        else
        {
            if (chatid)
            {
                $("#Chat"+chatid).removeClass('info');
                $("#Chat"+chatid).removeClass('success');
                $("#Chat"+chatid).addClass('danger');
                var tunePlayed = $("#tunePlayed").val();
                if (tunePlayed=="false")
                {
                    var audio=document.getElementById("notificationSound");
                    audio.play();
                    $("#tunePlayed").val("true");
                }
            }
        }
    });
}

function getSuggestions()
{
    var keywords = $("#chatSearch").val();
    var search = 'people';
    var constraint = 'online';
    var request = 'chats';

    if (keywords.length > 2)
    {
        $.post('http://b2.com/getSuggestions', {search: search, keywords: keywords, constraint: constraint, request: request}, function(data)
        {
            if(data=='wH@tS!nTheB0x')
            {
                if (loggedout = false)
                {
                    loggedout = true;
                    window.location='http://b2.com/offline';
                }

            }
            else
            {
                if(data)
                {
                    $("#chatSearchText").html(data);
                    $('#chatSearchModal').fadeIn();
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

function initiateChat(chatcost,profilePic,name,id)
{
    $.post('http://b2.com/getIFCs', function(ifcs)
    {
        if(ifcs=='wH@tS!nTheB0x')
        {
            if (loggedout = false)
            {
                loggedout = true;
                window.location='http://b2.com/offline';
            }

        }
        else
        {
            if (ifcs >= chatcost)
            {

                document.getElementById('profileImage').src=profilePic;
                document.getElementById('chatcost').innerHTML='<strong>Chatting with '+name+' will cost you '+chatcost+' IFCs.</strong>';
                document.getElementById('preReasonText').innerHTML='Please enter your reason for chatting with '+name+' in the below textbox. Remember to wrap it up in 140 characters.';
                document.getElementById('newChatSubmit').name=id;
                $("#newChatModal").modal('show');
            }
            else
                $("#earnIFCModal").modal('show');
        }
    });
}

function submitChatRequest(button)
{
    var reason = $("#newChatReason").val();
    var id = button.name;

    if (reason!="")
    {
        $.ajax({
            type: "POST",
            url: "http://b2.com/submitChatRequest",
            data: {id: id, reason: reason}
        }).done(function(error)
        {
            if(error=='wH@tS!nTheB0x')
            {
                if (loggedout = false)
                {
                    loggedout = true;
                    window.location='http://b2.com/offline';
                }

            }
            else
            {
                if (error)
                {
                    $("#error-box").html('<strong>'+error+'</strong>');
                }
                else
                {
                    $('#newChatModal').modal('hide');
                    $("#newChatReason").val('');
                    bootbox.alert("Request Sent. You'll be notified once the user accepts and initiates the chat.");
                }
            }
        });
    }
}

function initiateChatFriend(profilePic,name,id)
{
/*    $("#availablePeopleBPopup").bPopup().close();*/
    document.getElementById('profileImage').src=profilePic;
    document.getElementById('preReasonText').innerHTML='Please enter your reason for chatting with '+name+' in the below textbox. Remember to wrap it up in 140 characters.';
    document.getElementById('newChatSubmit').name=id;
    $("#newChatModal").modal('show');
}

function refreshOnlineFriends()
{
    $.post('http://b2.com/refreshOnlineFriends', function(data)
    {
        if(data=='wH@tS!nTheB0x')
        {
            if (loggedout = false)
            {
                loggedout = true;
                window.location='http://b2.com/offline';
            }

        }
        else
            document.getElementById('friendlist').innerHTML=data;

    });
}

function acceptChat(acid)
{
    $.ajax({
        type: "POST",
        url: "http://b2.com/acceptChat",
        data: {id:acid}
    }).done(function(error)
    {
        if(error=='wH@tS!nTheB0x')
        {
            if (loggedout = false)
            {
                loggedout = true;
                window.location='http://b2.com/offline';
            }

        }
        else
        {
            if (error)
            {
                $("#notifyText").append(error);
            }
            else
            {
                /*window.open('http://b2.com/chatRoom/'+link, '_blank', "height=400,width=270,resizable=false");*/
                $("#notifyModal").modal('hide');
                $("#notifyText").html("");

                $.post('http://b2.com/getSecondPartyName', {id: acid}, function(name)
                {
                    if(name=='wH@tS!nTheB0x')
                    {
                        if (loggedout = false)
                        {
                            loggedout = true;
                            window.location='http://b2.com/offline';
                        }

                    }
                    else
                        openChat(acid,name);
                });

                /*window.location='http://b2.com/chats/'+link;*/

                /*$.post('http://b2.com/getSecondPartyName',{id: acid}, function(name)
                 {
                 $("#ongoingChats").append("<div id='Chat"+acid+"' class='chats' onclick='openChat("+acid+")'>"+name+"</div><br>");
                 });*/

            }
        }
    });
}

function declineChat(dcid)
{
    bootbox.confirm("Are you sure?", function(result) {
        if (result==true)
        {
            $.ajax({
                type: "POST",
                url: "http://b2.com/declineChat",
                data: {id:dcid}
            }).done(function(error)
            {
                if(error=='wH@tS!nTheB0x')
                {
                    if (loggedout = false)
                    {
                        loggedout = true;
                        window.location='http://b2.com/offline';
                    }

                }
                else
                {
                    $("#notifyModal").modal('hide');
                    $("#notifyText").html("");
                }
            });
        }
    });

}

function startChat(scid)
{

    /*window.open('http://b2.com/chatRoom/'+link, '_blank', "height=400,width=270,resizable=false");*/
    $("#notifyModal").modal('hide');
    $("#notifyText").html("");

    $.post('http://b2.com/getSecondPartyName', {id: scid}, function(name)
    {
        if(name=='wH@tS!nTheB0x')
        {
            if (loggedout = false)
            {
                loggedout = true;
                window.location='http://b2.com/offline';
            }

        }
        else
            openChat(scid,name);
    });
    /*window.location='http://b2.com/chats/'+link;*/

    /*$.post('http://b2.com/getSecondPartyName',{id: scid}, function(name)
     {
     $("#ongoingChats").append("<div id='Chat"+scid+"' class='chats' onclick='openChat("+scid+")'>"+name+"</div><br>");
     });*/

}

//chat search
function showChatSearchResultBox()
{
    $('#chatSearchText').slideDown(300);
}

function hideChatSearchResultBox()
{
    $('#chatSearchText').slideUp(300);
}

function keyDownChatSearch()
{
    clearTimeout(searchInterval);
}

function keyUpChatSearch(e)
{
    if (e.keyCode == 27)
    {
        $('#chatSearch').val("");
        $('#chatSearchText').html('');
    }

    searchInterval = setTimeout(function()
    {
        var keywords = $('#chatSearch').val();
        if (keywords.length > 0)
        {
            $('#chatSearchText').html('<div style="text-align: center"><br><img src="http://b2.com/Images/icons/waiting.gif"></div>');

            $.post('http://b2.com/chatsearch', {keywords: keywords}, function(markup)
            {
                if(markup=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                {
                    $('#chatSearchText').html(markup);
                }
            });
        }
    }, 700);
}