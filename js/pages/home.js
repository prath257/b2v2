var defaults = {
    animationDuration: 350,
    headerOpacity: 0.25,
    fixedHeaders: false,
    headerSelector: function (item) { return item.children("h3").first(); },
    itemSelector: function (item) {  return item.children(".pivot-item"); },
    headerItemTemplate: function () { return $("<span class='header' />"); },
    pivotItemTemplate: function () {  return $("<div class='pivotItem' />"); },
    itemsTemplate: function () { return $("<div class='items' />"); },
    headersTemplate: function () { return $("<div class='headers' />"); },
    controlInitialized: undefined
};

//load content
bbflag = false;
artflag = false;
collabflag = false;
resflag = false;
mediaflag = false;
pollflag = false;
quizflag = false;

var cat=0;

var noOfInterests = $('#noOfInterests').val();
noOfInterests = parseInt(noOfInterests);
var noOfActions = 6;
/*var focusAction = false;*/

var ajaxOk=true;     // to enable the ajax call when the mouse moves away from the div
var searching=true;
var ajaxOk2=true;   //to enable ajax call when the focus is moved away from input search boc
var tmr=null;

var intCount=[];
intCount[0] = 4;
for (i=1; i<noOfInterests; i++)
{
    intCount[i] = 0;
}

//recco
var myReccoCount = 0;
var allReccoCount = 0;
var reccoTimer;
var cachedMarkup;

$(document).ready(function()
{
    defaults.selectedItemChanged=function(item){
        if(item==1)
        {
            writeData();
        }
        if(item==2)
        {
            resData();

        }
        if(item==3)
        {

            quizData();
        }
    };

    $('#ActionCentre').height($(window).height()*0.85);

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
    $(document).click(function(e){
        if ($(e.target).is('#transferSearchModal,#transferSearchModal *')) {
            //Do Nothing
        }
        else
        {
            $('#transferSearchModal').fadeOut();
        }
        if ($(e.target).is('#searchnfilters,#searchnfilters *')) {
            //Do Nothing
        }
        else
        {
            $('#filterdiv').slideUp(300);
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

    $(document).click(function(e){
        if (!$(e.target).is('#searchRecco,#searhRecco *,#RECCO-FILTER,#RECCO-FILTER *,.recco-duo-tabs,.recco-duo-tabs *'))
        {
            var category = $('#recco-tab').val();
            $('#'+category+'-recco').html(cachedMarkup);
            var keywords = $('#searchRecco').val('');
        }
    });

    var width = $(window).width();
    if (width>1200)
    {
        var chartUserData=Morris.Donut({
            element: 'donut-example',
            data: [0,0]
        });
    }
    else
    {
        $('#donut-example').hide();
    }

    $("div.metro-pivot").metroPivot(defaults);

    $('body').fadeIn();

    // Create a function that will handle AJAX requests
    function requestData(days, chart, type)
    {
        try
        {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "http://b2.com/get"+type+"ChartData", // This is the URL to the API
                data: { days: days }
            })
                .done(function( data ) {
                    if(data=='wH@tS!nTheB0x')
                        window.location='http://b2.com/offline';
                    else
                    {
                        // When the response to the AJAX request comes back render the chart with new data
                        chart.setData(data);
                    }
                })
                .fail(function() {
                    // If there is no communication between the server, show an error
                    // alert( "error occured" );
                });
        }
        catch(error)
        {
            //do nothing about the error
        }
    }
    // Request initial data for the past 7 days:
       requestData(7, chartUserData,'User');


    $('#categoryData a').click(function(e)
    {
        e.preventDefault();

        // Get the number of days from the data attribute
        var el = $(this);
        var pp=el.closest('li');
        var p=pp[0];
        $("#categoryData>li.active").removeClass("active");
        pp.addClass('active');
        cat= p.id;
        getCategoryNotifications(cat);
    })


    $('#inviteForm').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="inviteSubmit"]',
        message: 'This value is not valid',
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'The name is required'
                    },
                    stringLength: {
                        min: 2,
                        max: 30,
                        message: 'Not this short'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z]+$/,
                        message: 'Only alphabets ofcourse'
                    }

                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required and can\'t be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            }

        }
    });

    $('#transferForm').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="transferSubmit"]',
        message: 'This value is not valid',
        fields: {
            friend: {
                validators: {
                    notEmpty: {
                        message: 'Please select a friend'
                    }
                }
            },
            transferIFC: {
                validators: {
                    notEmpty: {
                        message: 'Please select an amount to be transferred'
                    },
                    integer:{
                        message:'The value must be an integer'
                    },
                    between: {
                        min: 1,
                        max: 10000,
                        message: 'The transfer amount must be between 1 to 10000i'
                    }
                }
            }

        }
    });

    $('#recco-form').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="recco-submit"]',
        message: 'This value is not valid',
        fields: {
            reccoLink: {
                validators: {
                    notEmpty: {
                        message: 'Please enter a website address.'
                    },
                    uri: {
                        message: 'The website address is not valid.'
                    }
                }
            }
        }
    });

    $('#inviteForm').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
    });

    $('#transferForm').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
    });

    $('#recco-form').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
    });

    $('#searchForm').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
        executeSearch();
    });

    $('#transferSearchForm').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
        getTransferSuggestions()
    });

    $("#peopleLabel").addClass("btn-info");
    document.getElementById('search').placeholder="Search Barters";




    getFriendsContent();
    actionAjax();
    loadActionCenter();
    loadRecco(0,allReccoCount+5,'gibber','increment','created_at');
    loadMyRecco(0,myReccoCount+5,'gibber','increment','created_at');
    //getCategoryNotifications(cat);
    //$('#aboutCollaborations').tooltip();
    //getChats();
    /*$(document).mouseover(function(e){
        if (!$(e.target).is('#ActionCentre,#ActionCentre *'))
            focusAction = false;
        else
            focusAction = true;
    });*/

});

function getFriendsContent()
{
    try
    {
        $('#listo').hide();
        $.post('http://b2.com/getFriendsContentNotification',{days:90},function(data)
        {
            if (data == 'ZeroData')
                $("#listo").hide();
            else
            {
                $('#listo').html(data);
                $('#carousel1').carousel({
                    interval: 5000
                })
                $('#carousel2').carousel({
                    interval: 7000
                })
                $('#carousel3').carousel({
                    interval: 9000
                })
                $('#carousel4').carousel({
                    interval: 5000
                })
                $('#carousel5').carousel({
                    interval: 7000
                })
                $('#carousel6').carousel({
                    interval: 9000
                })

                var width = $(window).width();
                if (width>1200)
                {
                    $('.img1').height(180);
                    $('.img2').height(180);
                    $('.img3').height(150);
                    $('.img4').height(180);
                    $('.img5').height(190);
                    $('.img6').height(180);
                }
                else
                {
                    $('.img1').height(180);
                    $('.img2').height(180);
                    $('.img3').height(180);
                    $('.img4').height(180);
                    $('.img5').height(180);
                    $('.img6').height(180);

                }
                $("#listo").fadeIn();
            }
        });
    }
    catch(error)
    {

        //do ntohing
    }
}

function getCategoryNotifications(cat,type)
{
    try
    {

        $.post('http://b2.com/getCategoryContentNotification/'+cat+'/Latest',{days:7},function(data)
        {
            if(data=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
                $('#catLatest').html(data);

        });

        $.post('http://b2.com/getCategoryContentNotification/'+cat+'/Popular',{days:7},function(data)
        {
            if(data=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
                $('#catPopular').html(data);

        });
    }
    catch(error)
    {
        //do nothing
    }
}
function getChats()
{
    /*loadActionCenter();*/
    updateNotifications();
    setTimeout(getChats,5000);

}

/*function loadActionCenter()
{
    if (focusAction == false)
    {
        $.ajax({
            type: "GET",
            url: "http://b2.com/getActionData"
        })
        .done(function(data)
        {
            $('#loadActions').html(data);
            $('#showMoreAndWaitingActions').fadeIn();
            $('#loadMoreActions').show();
            noOfActions = 6;
        });
    }
}*/

//notifications
//notifications
/*function updateNotifications(){

    try
    {
        var notifyModalContent = $("#notifyText").html();
        if(notifyModalContent=="")
        {
            $.get('http://b2.com/getNotification',function(data)
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
    catch(error)
    {

    }
}*/


function closeAlert(string)
{
    $("#notifyModal").modal('hide');
    $("#notifyText").html("");
}


//Chat
function acceptChat(acid)
{
    $.ajax({
        type: "POST",
        url: "http://b2.com/acceptChat",
        data: {id:acid}
    }).done(function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {

            if (error)
            {
                $("#notifyText").append(error);
            }
            else
            {
                $.post('http://b2.com/getChatLink',{id: acid}, function(link)
                {
                    if(link=='wH@tS!nTheB0x')
                        window.location='http://b2.com/offline';
                    else
                    {
                        /*window.open('http://b2.com/chatRoom/'+link, '_blank', "height=400,width=270,resizable=false");*/
                        $("#notifyModal").modal('hide');
                        $("#notifyText").html("");

                        window.location='http://b2.com/chats/'+link;

                        /*$.post('http://b2.com/getSecondPartyName',{id: acid}, function(name)
                         {
                         $("#ongoingChats").append("<div id='Chat"+acid+"' class='chats' onclick='openChat("+acid+")'>"+name+"</div><br>");
                         });*/
                    }
                });
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
            }).done(function(data)
            {
                if(data=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
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
    $.post('http://b2.com/getChatLink',{id: scid}, function(link)
    {
        if(link=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            /*window.open('http://b2.com/chatRoom/'+link, '_blank', "height=400,width=270,resizable=false");*/
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

//Functions for IFC Manager
function showInviteModal()
{
    $("#earnIFCModal").modal('hide');
    $('#inviteModal').modal({
        keyboard:false,
        show:true,
        backdrop:'static'
    });
}

function postInvite()
{
    var name=$('#inviteName').val();
    var email=$('#inviteEmail').val();

    if(name!="" && email!="")
    {
        $("#inviteLinkAndErrors").hide();
        $("#inviteLinkAndErrors").html("");

        $.ajax({
            type: "POST",
            url: "http://b2.com/invite",
            data: {name:name, email:email}
        }).done(function(msg)
        {
            if(msg=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                $('#inviteLinkAndErrors').html(msg);
                $("#inviteLinkAndErrors").show();
            }
        });
    }
}

function inviteAnother()
{
    $("#inviteLinkAndErrors").hide();
    $("#inviteLinkAndErrors").html("");
    $("#inviteName").val("");
    $("#inviteEmail").val("");
}

function closeInviteModal()
{
    $("#inviteModal").modal('hide');
    $("#inviteLinkAndErrors").hide();
    $("#inviteLinkAndErrors").html("");
    $("#inviteName").val("");
    $("#inviteEmail").val("");
}


function postTransfer()
{
    $('#transferForm').data('bootstrapValidator').validate();

    if($('#transferForm').data('bootstrapValidator').isValid())
    {
        var userid = $("#friend").val();
        userid = parseInt(userid);
        var ifc = $("#transferIFC").val();
        ifc = parseInt(ifc);
        $('#transferSubmit').prop('disabled', true);

        $.ajax({
                type: "POST",
                url: "http://b2.com/transfer",
                data: {userid:userid, ifc:ifc},
                beforeSend: function()
                {

                  //  $("#submitTransfer").html("<img src='http://b2.com/Images/icons/waiting.gif'>");

                  $("#submitTransfer").hide();
                  $("#waiting").show();
                }
            }).done(function(response)
            {
                if(response=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                {
                    $("#submitTransfer").show();
                    $("#waiting").hide();

                    if (response == 'Success')
                    {
                        $("#submitTransfer").html("<button type='submit' id='transferSubmit' onclick='postTransfer()' class='btn btn-primary'>Submit</button>");
                        $('#transferModal').modal('hide');
                        bootbox.alert('IFCs successfully transferred to your friend!');
                        $('#transferSubmit').prop('disabled', false);
                        $("#transferSubmit").html("Submit");
                    }
                    else
                    {
                        $('#transferModal').modal('hide');
                        bootbox.alert("Sorry, you've got only "+response+" IFCs and that's why you cannot perform this transaction!");
                        $('#transferSubmit').prop('disabled', false);
                        $("#transferSubmit").html("Submit");
                    }
                }
            });

    }
}


//this is the function to accept the friend request
function acceptFriends(id1)
{
    $.ajax({
        type: "POST",
        url: "http://b2.com/acceptFriend/"+id1,
        data:{type:'kind'},
        beforeSend: function()
        {
            $("#buttons").hide();
            $("#freqWaiting").show();

        }
    }).done(function(response)
    {
        if(response=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $("#buttons").show();
            $("#freqWaiting").hide();

            $("#notifyModal").modal('hide');
            $('#acceptButton'+id1).prop('disabled', false);
            $('#acceptButton'+id1).html("Submit");
        }
    });
}


//this is the function to decline the friend request
function declineFriends(id2)
{
    bootbox.confirm("Are you sure?", function(result) {
        if (result==true)
        {
            $.post("http://b2.com/declineFriend/"+id2,{type:'kind'},function(error)
            {
                if(error=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                    $("#notifyModal").modal('hide');
            });
        }
    });

}

function changeClass(button)
{
    $(".labelButtons").removeClass("btn-info");
    $("#"+button+"Label").addClass("btn-info");
    if (button == 'people')
        document.getElementById('search').placeholder="Search Barters";
    else
        document.getElementById('search').placeholder="Search Content";
}

function hoverEffect(element)
{
    element.style.backgroundColor="skyblue";
}
function normalEffect(element)
{
    element.style.backgroundColor="white";
}

function showContentModal()
{
    $('#earnIFCModal').modal('hide');
    $("#createContentModal").modal('show');
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
            if(data=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                if(data)
                {
                    $("#searchText").html(data);
                    $('#searchModal').fadeIn();
                }
            }
        });
    }
}

function visitProfile(username)
{
    window.location='http://b2.com/user/'+username;
}

function viewArticle(id)
{
    window.location="http://b2.com/articlePreview/"+id;
}

function viewBlogBook(id)
{
    window.location="http://b2.com/blogBookPreview/"+id;
}

function viewResource(id)
{
    window.location="http://b2.com/resource/"+id;
}

function viewCollaboration(id)
{
    window.location="http://b2.com/collaborationPreview/"+id;
}

function viewQuiz(id)
{
    window.location="http://b2.com/quizPreview/"+id;
}

function viewPoll(id)
{
    window.location="http://b2.com/poll/"+id;
}

function viewMedia(id)
{
    window.location="http://b2.com/mediaPreview/"+id;
}

function loadMoreEvents(interest,index)
{
    $('#loadMoreEvents'+interest).hide();
    $('#eventWait'+interest).fadeIn();
    $.post('http://b2.com/loadMoreEvents', {eventsCount: intCount[index-1], interest:interest}, function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#eventWait'+interest).hide();
            $('#appendEvents'+interest).append(markup);
            $('body,html').animate({ scrollTop: $(document).height()}, 500);
            var remaining = $('#RemainingEvents_'+interest+'_'+intCount[index-1]).val();
            remaining = parseInt(remaining);
            if (remaining > 0)
                $('#loadMoreEvents'+interest).fadeIn();

            intCount[index-1] += 4;
        }
    });
}

function showEvents(button,interest,count)
{
    intCount[count-1] = 0;
    $('.catButtons').removeClass('active');
    $(button).parent().addClass('active');
    $('.catEvents').hide();
    $('#loading').show();
    $.post('http://b2.com/showCategoryEvents', {interest: interest, count: intCount[count-1], index: count}, function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#events'+interest).html(markup);
            $('#loading').hide();
            $('#events'+interest).fadeIn();
            intCount[count-1] += 4;
        }
    });
}

function loadMoreActions()
{
    $('#loadMoreActions').hide();
    $('#waitforactions').show();
    $.post('http://b2.com/loadMoreActions', {count: noOfActions}, function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#waitforactions').hide();
            $('#ActionContent').append(markup);
            var more = $('#moreActions'+noOfActions).val();
            more = parseInt(more);
            if (more != 0)
                $('#loadMoreActions').show();
            noOfActions += 10;
        }
    });
}

function okToAjax(type,vari)
{

    if(vari==1)
        ajaxOk=type;
    else
    {
        ajaxOk2=type;

        if (type == false)
        {
            $('#filterdiv').slideDown(300);

        }
    }

}

function actionAjax()
{

    $.ajax({
        type: "POST",
        url: "http://b2.com/getActionData",
        beforeSend :function()
        {
            ajaxOk=false;
        }
    })
        .done(function(data)
        {
            if(data=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                ajaxOk=true;
                $('#loadActions').html(data);
                $('.actionImages').height(50);
                noOfActions = 6;
                $('#showMoreAndWaitingActions').fadeIn();
                $('#loadMoreActions').show();
            }
        })
}

function loadActionCenter()
{
    var  timer = window.setInterval( function() {

        if(ajaxOk&&ajaxOk2)
        {
            actionAjax();
        }

    }, 5000);

}


function searchAction()
{
    var keywords=$('#searchPandC').val();
    var IN = $('#IN').val();
    var FILTER = $('#FILTER').val();

    if(keywords.length>0)
    {
        if(tmr!=null)
        {
            clearInterval(tmr);
        }

        tmr = window.setInterval( function() {

            if(searching)
            {

                var constraint = 'all';
                var request = 'home';


                    $.ajax({
                        type: "POST",
                        url: "http://b2.com/searchAction",
                        data:{keywords: keywords, constraint: constraint, request: request, IN: IN, FILTER: FILTER},
                        beforeSend :function()
                        {
                            searching=false;
                            /*ajaxOk=false;
                            ajaxOk2=false;*/
                            $('#loadMoreActions').hide();
                            $('#loadActions').html("<div style='text-align:center'><img  src='Images/icons/waiting.gif'> Loading..</div>");
                        },
                        error:function (){
                            $('#loadActions').html('Error occured. Try searching another query.');
                            searching = true;
                            clearInterval(tmr);
                            tmr=null;
                            $.post('http://b2.com/failedSearch',{keywords: keywords},function(error){
                                if(error=='wH@tS!nTheB0x')
                                    window.location='http://b2.com/offline';
                            });
                        }
                    })
                        .done(function(data)
                        {
                            if(data=='wH@tS!nTheB0x')
                                window.location='http://b2.com/offline';
                            else if (data == 'error_occurred')
                            {
                                $('#loadActions').html('Error occured. Try searching another query.');
                                searching = true;
                                clearInterval(tmr);
                                tmr=null;
                                $.post('http://b2.com/failedSearch',{keywords: keywords},function(error){
                                    if(error=='wH@tS!nTheB0x')
                                        window.location='http://b2.com/offline';
                                });
                            }
                            else
                            {
                                searching=true;


                                $('#loadActions').html(data);

                                clearInterval(tmr);
                                tmr=null;
                            }
                        })



            }
        }, 1000);

    }
    else
    {
/*        ajaxOk=true;
        ajaxOk2=true;*/
        actionAjax();
    }
}

function clearSearchInterval()
{
    clearInterval(tmr);
}

//recco

function postRecommendation()
{
    $('#recco-form').data('bootstrapValidator').validate();

    if($('#recco-form').data('bootstrapValidator').isValid())
    {
        $('#recco-data').html('<div style="text-align: center"><br><img src="http://b2.com/Images/icons/waiting.gif"> Loading site data..</div>');
        var url = $('#reccoLink').val();

        $.post('http://b2.com/post_recco', {url: url}, function(response)
        {
            if (response == 'wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else if (response == 'failure')
            {
                $('#newRecommendationModal').modal('hide');
                bootbox.alert('Sorry, the entered link didn\'t yeild any data.');
                $('#recco-data').html('');
                $('#reccoLink').val('');
            }
            else
            {
                $('#recco-data').html(response);
            }
        });
    }
}

function confirmPostRecco(imageURL)
{
    $('#recco-post-button-container').html('<div style="text-align: right"><img src="http://b2.com/Images/icons/waiting.gif"> Saving..</div>');
    var url = $('#reccoLink').val();
    var title = $('#recco-preview-title').html();
    var description = $('#recco-preview-description').html();

    $.post('http://b2.com/publish_recco', {url: url, title: title, desc: description, image: imageURL}, function(response)
    {
        if (response == 'wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            var sort = $('#RECCO-FILTER').val();
            loadRecco(0,allReccoCount,'gibber','none',sort);
            loadMyRecco(0,myReccoCount,'gibber','none',sort);
            $('#newRecommendationModal').modal('hide');
            bootbox.alert('Recco posted succesfully!');
            $('#recco-data').html('');
            $('#reccoLink').val('');
        }
    });
}

function loadRecco(skip,take,id,call,sort)
{
    $('.load-more-recco-all').hide();
    $('#waiting-all-'+id).show();
    if (skip == 0)
        $('#all-recco').html("<div style='text-align: center'><br><img src='http://b2.com/Images/icons/waiting.gif'></div>");
    $.post('http://b2.com/loadRecco', {count: skip, count2: take, sort: sort}, function(markup)
    {
        if (markup == 'wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#waiting-all-'+id).hide();
            $('.recco-wait-all').html('');
            if (skip == 0)
                $('#all-recco').html('<br>'+markup);
            else
                $('#all-recco').append('<br>'+markup);
            $('#load-more-recco-all-'+skip).show();
            if (call == 'increment')
                allReccoCount += 5;
        }
    });
}

function loadMyRecco(skip,take,id,call,sort)
{
    $('.load-more-recco-my').hide();
    $('#waiting-my-'+id).show();
    if (skip == 0)
        $('#my-recco').html("<div style='text-align: center'><br><img src='http://b2.com/Images/icons/waiting.gif'></div>");
    $.post('http://b2.com/loadMyRecco', {count: skip, count2: take, sort: sort}, function(markup)
    {
        if (markup == 'wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#waiting-my-'+id).hide();
            $('.recco-wait-my').html('');
            if (skip == 0)
                $('#my-recco').html('<br>'+markup);
            else
                $('#my-recco').append('<br>'+markup);
            $('#load-more-recco-my-'+skip).show();
            if (call == 'increment')
                myReccoCount += 5;
        }
    });
}

function readMoreRecco(id)
{
    $('#moreRecco'+id).hide();
    var data = $('#original'+id).html();
    data = data.substring(0, 140);
    data += $('#remaining'+id).html();
    $('#original'+id).html(data);
}

function visitRecco(id,url)
{
    $.post('http://b2.com/incrementHits', {id: id});
    window.open(url);
}

function deleteRecco(id)
{
    bootbox.confirm('Are you sure?',function(response)
    {
       if (response == true)
       {
           var sort = $('#RECCO-FILTER').val();
           $('#my-recco').html("<div style='text-align: center'><br><img src='http://b2.com/Images/icons/waiting.gif'></div>");
           $.post('http://b2.com/deleteRecco', {id: id, count: myReccoCount, sort: sort}, function(markup)
           {
               if (markup == 'wH@tS!nTheB0x')
                   window.location='http://b2.com/offline';
               else
               {
                   //loadRecco(0,allReccoCount,'gibber','none',sort);
                   bootbox.alert('Recommendation successfully deleted.');
                   $('#my-recco').html('<br>'+markup);
                   $('#load-more-recco-my-'+myReccoCount).show();
               }
           });
       }
    });
}

function loadMoreReccos(target,cnt)
{
    var sort = $('#RECCO-FILTER').val();
    if (target == 'all')
        loadRecco(allReccoCount,5,cnt,'increment',sort);
    else
        loadMyRecco(myReccoCount,5,cnt,'increment',sort);
}

function sortRecco()
{
    var sort = $('#RECCO-FILTER').val();
    var keywords = $('#searchRecco').val();
    if (keywords.length == 0)
    {
        loadRecco(0,allReccoCount,'gibber','none',sort);
        loadMyRecco(0,myReccoCount,'gibber','none',sort);
    }
    else
        searchRecco(sort);
}

function upRecco(e)
{
    if (e.keyCode == 27)
    {
        var category = $('#recco-tab').val();
        $('#'+category+'-recco').html(cachedMarkup);
        var keywords = $('#searchRecco').val('');
    }
    else if (e.keyCode != 13)
    {
        var sort = $('#RECCO-FILTER').val();
        reccoTimer = setTimeout(function(){searchRecco(sort)}, 700);
    }
}

function downRecco()
{
    clearTimeout(reccoTimer);
}

function searchRecco(sort)
{
    var keywords = $('#searchRecco').val();
    var category = $('#recco-tab').val();
    if (keywords.length > 0)
    {
        $('#'+category+'-recco').html("<div style='text-align: center'><br><img src='http://b2.com/Images/icons/waiting.gif'> Searching..</div>");
        $.post('http://b2.com/searchRecco', {keywords: keywords, sort: sort, category: category}, function(markup)
        {
            if (markup == 'wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else {
                $('#' + category + '-recco').html('<br>' + markup);
            }
        });
    }
    else
    {
        $('#'+category+'-recco').html(cachedMarkup);
    }
}

function toggleTab(tab)
{
    $('#recco-tab').val(tab);
}

function cacheMarkup()
{
    var category = $('#recco-tab').val();
    cachedMarkup = $('#'+category+'-recco').html();
}

function changeToDefault()
{
    document.getElementById("recco-preview-image").src="http://b2.com/Images/recco.jpg";
    $('#change-to-default-link').hide();
}

function writeData()
{
    if (!artflag)
    {
        $.post('http://b2.com/article_write', function(markup)
        {
            if (markup == 'wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else {
                $('#articleDisplay').html(markup);
                artflag = true;
            }
        });
    }
}

function writebb()
{
    if (!bbflag)
    {
        $.post('http://b2.com/bb_write', function (markup) {
            if (markup == 'wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else {
                $('#blogBookDisplay').html(markup);
                bbflag = true;
            }
        });
    }
}

function writecollab()
{
    if (!collabflag)
    {
        $.post('http://b2.com/collab_write', function (markup) {
            if (markup == 'wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else {
                $('#collaborationDisplay').html(markup);
                collabflag = true;
            }
        });
    }
}

function resData()
{
    if (!resflag)
    {
        $.post('http://b2.com/res_write', function (markup) {
            if (markup == 'wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else {
                $('#resDisplay').html(markup);
                resflag = true;
            }
        });
    }
}

function mediaData()
{
    if (!mediaflag)
    {
        $.post('http://b2.com/media_write', function (markup) {
            if (markup == 'wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else {
                $('#mediaDisplay').html(markup);
                mediaflag = true;
            }
        });
    }
}

function quizData()
{
    if (!quizflag)
    {
        $.post('http://b2.com/quiz_write', function (markup) {
            if (markup == 'wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else {
                $('#quizDisplay').html(markup);
                quizflag = true;
            }
        });
    }
}

function pollData()
{
    if (!pollflag)
    {
        $.post('http://b2.com/poll_write', function (markup) {
            if (markup == 'wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else {
                $('#pollDisplay').html(markup);
                pollflag = true;
            }
        });
    }
}