var reccod = false;
$(document).ready(function()
{
    var PICOUNT = $("#PICOUNT").val();
    for (i=0; i<PICOUNT; i++)
        $('#carousel'+(i+1)).carousel({
            interval: ((i+1)*1000)+5000
        });

    $('.Profileimages').css('height','175px');

    $(document).click(function(e){
        if ($(e.target).is('#mycounter,#mycounter *')) {
            //Do Nothing
        }
        else
        {
            $('#mycounter').fadeOut();
        }
    });

    /*Search*/
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

    $('#inviteForm').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="inviteSubmit"]',
        message: 'This value is not valid',
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'The name is required'
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

    $('#plusContributeForm').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="plusContributeSubmit"]',
        message: 'This value is not valid',
        fields: {
            contributeReason: {
                validators: {
                    notEmpty: {
                        message: 'This one\'s required.'
                    },
                    stringLength: {
                        min:10,
                        max:300,
                        message: 'Min 10 characters and Max 300 characters long.'
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

    $('#plusContributeForm').submit(function(event)
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

    $("#peopleLabel").addClass("btn-info");
    document.getElementById('search').placeholder="Search Barters";
});

function showPurchase(ifcr)
{

    $('#ifcPurchasingModal').modal('show');

    var type=$('#type').val();
    var cid=$('#cid').val();

    var link;

    if(type=='blogBook')
    {
        link='blogBook/'+cid;
    }
    else if(type=='article')
    {
        link='readArticle/'+cid;
    }
    else if(type=='collaboration')
    {
        link='collaboration/'+cid;
    }
    else if(type=='resource')
    {
        link='sym140Nb971wzb4284/'+cid;
    }

    var content=true;

    $.ajax({
        type: "POST",
        url: 'http://b2.com/ifcModal/'+ifcr,
        data: {link:link,content:content},
        beforeSend: function()
        {
            $("#ifcWaiting").show();
        }
    }).done(function(response)
    {
        if(response=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $("#ifcWaiting").hide();

            $("#ifcPurchasingModalBody").html(response);
        }


    });



    /*  if(ifc>uifc)
     {
     $("#ifcModalContent").prepend("This "+bid.name+" [<i>"+bid.id+"</i>] is costed at <b>"+ifc+"</b><i>i</i>, ");
     $('#cid').val(cid);
     $('#ifcModal').modal('show');
     }
     else
     {
     $("#purchaseModalContent").prepend("This "+bid.name+" [<i>"+bid.id+"</i>] is costed at <b>"+ifc+"</b><i>i</i>, ");
     $('#cid').val(cid);
     $('#purchaseModal').modal('show');
     }
     */


}

function purchase()
{
    var type=$('#type').val();
    var cid=$('#cid').val();
    if(type=='book')
    {
        window.location='http://b2.com/blogBook/'+cid;
    }
    else if(type=='article')
    {
        window.location='http://b2.com/readArticle/'+cid;
    }
    else if(type=='collaboration')
    {
        window.location='http://b2.com/collaboration/'+cid;
    }
    else
    {
        $('#ifcPurchasingModal').modal('hide');
        window.location='http://b2.com/sym140Nb971wzb4284/'+cid;
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
}

function cancelPurchase()
{
    $('#title').val('');
    $('#type').val('');
    $('#ifc').val('');
    $('#purchaseModal').modal('hide');
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

function showBlogBookPreview(bookId)
{
    $("#previewDivContent").html("<iframe id='bbPreview' class='col-lg-12' src='http://b2.com/previewBlogBook/"+bookId+"' style='margin-top: 3%' height='500' frameborder='0'></iframe>");
    $("#blogBookDiv").css("opacity","0");
    $("#previewDiv").fadeIn();
}

function showCollaborationPreview(bookId)
{
    $("#previewDivContent").html("<iframe id='cPreview' class='col-lg-12' src='http://b2.com/previewCollaboration/"+bookId+"' style='margin-top: 3%' height='500' frameborder='0'></iframe>");
    $("#blogBookDiv").css("opacity","0");
    $("#previewDiv").fadeIn();
}

function closePreview()
{
    $("#blogBookDiv").css("opacity","1");
    $("#previewDiv").fadeOut();
}

function plusContribute()
{
    $('#contributionReasonModal').modal('show');
}

function postRequest(id)
{
    $('#plusContributeSubmit').hide();
    $('#waitingPlusContributeSubmit').show();
    var reason = $('#contributeReason').val();
    if (reason.length > 9 && reason.length <301)
    {
        $.post('http://b2.com/request2contribute', {id: id, reason: reason}, function(response)
        {
            if(response=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                $('#plusContributeSubmit').show();
                $('#waitingPlusContributeSubmit').hide();
                if (response == 'success')
                {
                    $('#contributionReasonModal').modal('hide');
                    bootbox.alert("Request sent successfully!");
                    $('#contribute').hide();
                }
            }
        });
    }
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

function viewMedia(id,path)
{
    var ifc = $('#ifc').html();
    ifc = parseInt(ifc);
    $('#viewMedia').prop('disabled',true);
    $('#viewMedia').html('Please Wait..');
    $.post('http://b2.com/getIFCs', function(uifc)
    {
        if(uifc=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#viewMedia').prop('disabled',false);
            $('#viewMedia').html('View Media');
            uifc = parseInt(uifc);
            if (ifc > uifc)
                bootbox.alert("Sorry, looks like you haven\'t got enough IFCs to view this! Visit this <a href='http://b2.com/ifcDeficit' target='_blank'>link</a> to know more about earning IFCs.");
            else
            {
                var message = 'You have '+uifc+' IFCs left with you and viewing this media will cost you '+ifc+' IFCs. Do you want to proceed?';
                bootbox.confirm(message, function(result) {
                    if (result==true)
                    {
                        $.post('http://b2.com/viewMedia', {id: id}, function(success)
                        {
                            if(success=='wH@tS!nTheB0x')
                                window.location='http://b2.com/offline';
                            else
                            {
                                if (success == 'success')
                                {
                                    var content;
                                    if((path.search('.mkv')== -1)||(path.search('.flv')== -1)||(path.search('.m4a')== -1))
                                    {
                                        content="<div onmousedown='return false;' style='text-align: center'><br><object class='mediaFiles' autoplay='false' width='300' height='200' data='"+path+"'><a href='"+path+"'>Click here.</a></object></div>";
                                    }
                                    else
                                    {
                                        content="<div onmousedown='return false;' style='text-align: center'><br><br><embed class='mediaFiles' autoplay='false' width='300' height='200' src='"+path+"'></embed></div>";
                                    }
                                    $('#preview').html(content);
                                    $('#previewMediaModal').modal({
                                        keyboard:false,
                                        show:true,
                                        backdrop:'static'
                                    });
                                    $('#viewMedia').hide();
                                    $('#viewMedia2').show();
                                }
                                else
                                {
                                    bootbox.alert("Sorry, the request could not be completed. Please try again.");
                                }
                            }
                        });
                    }
                });
            }
        }
    });
}

function viewMedia2(path)
{
    var content;
    if((path.search('.mkv')== -1)||(path.search('.flv')== -1)||(path.search('.m4a')== -1))
    {
        content="<div onmousedown='return false;' style='text-align: center'><br><object class='mediaFiles' autoplay='false'width='300' height='200' data='"+path+"'><a href='"+path+"'>Click here.</a></object></div>";
    }
    else
    {
        content="<div onmousedown='return false;' style='text-align: center'><br><br><embed class='mediaFiles' autoplay='false' width='300' height='200' src='"+path+"'></embed></div>";
    }
    $('#preview').html(content);
    $('#previewMediaModal').modal({
        keyboard:false,
        show:true,
        backdrop:'static'
    });
}

function purchaseRes(link)
{
    $('#ifcPurchasingModal').modal('hide');
    $.post('http://b2.com/'+link, function(crypt)
    {
        window.location = 'http://b2.com/downloadResource/'+crypt;
    });
}

function stopPlayingMedia()
{
    $('#preview').html('');
    $('#previewMediaModal').modal('hide');
}

function reccoThis(url,title,description,imageURL)
{
    if (reccod == false)
    {
        $.post('http://b2.com/publish_recco', {url: url, title: title, desc: description, image: imageURL}, function(response)
        {
            if (response == 'wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                bootbox.alert('Recco posted succesfully!');
                reccod = true;
            }
        });
    }
    else
    {
        bootbox.alert('Sorry, you can recommend only once.');
    }
}