$(document).ready(function()
{
    var width = $(document).width();
    if (width<=700)
    {
        $(".table").addClass("table-bordered");
    }

    oTable1=$('#example').dataTable( {
        "ajax": 'getCollaborationData',
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
    } );

    oTable2=$('#example2').dataTable( {
        "ajax": 'getContributionData',
        "lengthMenu": [[2, 10, 15, -1], [2, 10, 15, "All"]]
    } );

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

    $('#newCollaborationForm').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="newCollaborationSubmit"]',
        message: 'This value is not valid',
        fields: {
            uploadCover: {
                message: 'The cover pic is not valid',
                validators: {
                    file: {
                        //extension: 'jpeg,png,jpg,gif',
                        type: 'image/jpeg,image/jpg,image/png,image/gif',
                        maxSize: 2048 * 1024,   // 2 MB
                        message: '  Max 2MB, allowed types: JPG,PNG or GIF'
                    },
                    notEmpty: {
                        message: 'Please Select a Book Cover!'
                    }
                }
            },
            title: {
                validators: {
                    notEmpty: {
                        message: 'Please give a Title'
                    },
                    stringLength: {
                        min: 1,
                        max: 255,
                        message: 'The title must be at least a character and less than 255 characters'
                    }
                }
            },
            shortDescription: {
                validators: {
                    notEmpty: {
                        message: 'A short and sweet description is required'
                    },
                    stringLength: {
                        min: 10,
                        max: 300,
                        message: 'Min 10 and Max 300 characters'
                    }
                }
            },
            category: {
                validators: {
                    notEmpty: {
                        message: 'Please select a category'
                    }
                }
            },
            ifc: {
                validators: {
                    integer: {
                        message: 'Number!'
                    },
                    between: {
                        min: 0,
                        max: 10000,
                        message: 'Less than 10000i'
                    }
                }
            }
        }
    });

    $('#inviteViaEmail').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="inviteViaEmailSubmit"]',
        message: 'This value is not valid',
        fields: {
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

    $('#inviteViaEmail').submit(function(event)
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

function changeCollaborationCover()
{
    var previewId = document.getElementById('defaultCover');
    previewId.src = '';

    var selectedImg = $('#uploadCover')[0].files[0];

    var oReader = new FileReader();
    oReader.onload = function(e)
    {
        previewId.src=e.target.result;
    }
    oReader.readAsDataURL(selectedImg);
}

function deleteCollaboration(bid,dcid)
{
    bootbox.confirm("Are you sure?", function(result) {
        if (result==true)
        {
            $.post('http://b2.com/deleteCollaboration',{id:dcid},function(data)
            {
                if(data=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                {
                    var row = $(bid).closest("tr").get(0);
                    oTable1.fnDeleteRow(oTable1.fnGetPosition(row));
                }
            })
        }
    });
}

function inviteContributors(collaborationId)
{
    $("#collaborationIdForInvite").val(collaborationId);
    $("#inviteContributorsModal").modal('show');
}

function amongFriends()
{
    $("#amongOthers").hide();
    $("#amongFriends").fadeIn();
}

function amongOthers()
{
    $("#amongFriends").hide();
    $("#amongOthers").fadeIn();
}

function inviteFriend()
{


    $("#responseBox").fadeOut();
    var userEmail = $("#friend").val();

    if (userEmail!="")
    {

        var colId = $("#collaborationIdForInvite").val();

        $.ajax({
            type: "POST",
            url: 'http://b2.com/inviteContributor',
            data: {email: userEmail, colId: colId},
            beforeSend: function()
            {
                $('#friendInviteButton').prop('disabled', true);
                $("#friendInviteButton").hide();
                $("#waitingImg").show();

            }
        }).done(function(response)
        {
            if(response=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                $("#responseBox").html("<strong>"+response+"</strong>");
                $("#friend").val("");
                $("#responseBox").fadeIn();
                $("#friendInviteButton").html("Submit");
                $('#friendInviteButton').prop('disabled', false);

                $("#friendInviteButton").show();
                $("#waitingImg").hide();
            }

        });


    /*    $.post('http://b2.com/inviteContributor', {email: userEmail, colId: colId}, function(response)
        {
            $("#responseBox").html("<strong>"+response+"</strong>");
            $("#friend").val("");
            $("#responseBox").fadeIn();
            $("#friendInviteButton").html("Submit");
            $('#friendInviteButton').prop('disabled', false);

        });
    */
    }
}

function inviteOthers()
{
    $("#responseBox").fadeOut();
    $('#inviteViaEmailSubmit').prop('disabled', true);
    $("#inviteViaEmailSubmit").html("Loading...");
    var email = $('#inviteEmail').val();
    var colId = $("#collaborationIdForInvite").val();
    $.post('http://b2.com/inviteContributor', {email: email, colId: colId}, function(response)
    {
        if(response=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $("#responseBox").html("<strong>"+response+"</strong>");
            $('#inviteEmail').val("");
            $("#responseBox").fadeIn();
            $("#inviteViaEmailSubmit").html("Submit");
            $('#inviteViaEmailSubmit').prop('disabled', false);
        }
    });
}

function stopContributing(bid,colid)
{
    bootbox.confirm("Are you sure?", function(result) {
        if (result==true)
        {
            $.post('http://b2.com/deleteContribution',{id:colid},function(error)
            {
                if(error=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                {
                    var row = $(bid).closest("tr").get(0);
                    oTable2.fnDeleteRow(oTable2.fnGetPosition(row));
                }
            })
        }
    });
}

function shareCollaboration(pid)
{
    $('#shareCollaboration').html('');
    var lnk='Share the following Link with your friends: <h3> http://b2.com/collaborationPreview/'+pid+'</h3>';
    $('#shareCollaboration').append(lnk);
    // create a clone of the twitter share button template
    var clone = $('.sharing').clone()

// fix up our clone
    clone.removeAttr("style"); // unhide the clone
    clone.attr("data-url", "http://b2.com/collaborationPreview/"+pid);
    clone.attr("class", "twitter-share-button");

// copy cloned button into div that we can clear later
    $('#shareCollaboration').append(clone);
    // reload twitter scripts to force them to run, converting a to iframe
    $.getScript("https://platform.twitter.com/widgets.js");

    var fbclone = '<br><button onclick="fbDialog('+pid+')" style="height:23px;padding:1px;font-size:12px"><img src="http://b2.com/Images/icons/facebook.jpg">&nbsp;<b>Share</b></button>'
    // copy cloned button into div that we can clear later
    $('#shareCollaboration').append(fbclone);

    $('#shareModal').modal({
        keyboard:false,
        show:true,
        backdrop:'static'
    });

}

function fbDialog(pid)
{
    FB.ui({
        method: 'share',
        href: 'http://b2.com/collaborationPreview/'+pid
    }, function(response){});
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