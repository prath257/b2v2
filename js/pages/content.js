var defaults = {
    animationDuration: 350,
    headerOpacity: 0.25,
    fixedHeaders: false,
    headerSelector: function (item) { return item.children("h3").first(); },
    itemSelector: function (item) { return item.children(".pivot-item"); },
    headerItemTemplate: function () { return $("<span class='header' />"); },
    pivotItemTemplate: function () { return $("<div class='pivotItem' />"); },
    itemsTemplate: function () { return $("<div class='items' />"); },
    headersTemplate: function () { return $("<div class='headers' />"); },
    controlInitialized: undefined,
    selectedItemChanged: undefined
};

var articleCount = 0;
var bookCount = 0;
var resourceCount = 0;
var pollQuizCount = 0;

var userId = $("#userId").val();
var interestId = $("#interestId").val();

$(document).ready(function()
{
    $("div.metro-pivot").metroPivot(defaults);

    $(document).click(function(e){
        if ($(e.target).is('#mycounter,#mycounter *')) {
            //Do Nothing
        }
        else
        {
            $('#mycounter').fadeOut();
        }
    });

    showMoreArticles();
    showMoreBooks();
    showMoreResources();
    showMorePollsNQuizes();

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

    $('#inviteForm').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
    });


});

function showMoreArticles()
{
    $.post('http://b2.com/getContentArticles', {userId: userId, interestId: interestId, articleCount: articleCount}, function (data)
    {
        if(data=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        if (data)
        {
            if (articleCount == 0)
                $('#articlesContent').html(data);
            else
                $('#articlesContent').append(data);
            $('.images').height(250);
            var remainingArticles = $('#remainingArticles'+articleCount).val();
            remainingArticles = parseInt(remainingArticles);
            if (remainingArticles == 0)
                $('#moreArticles').hide();
            else
                $('#moreArticles').show();
            $('body').animate({ scrollTop: $('body')[0].scrollHeight}, 1000);
            articleCount += 4;
        }
        $('#articlesContent').fadeIn();
    });
}

function showMoreBooks()
{
    $.post('http://b2.com/getContentBooks', {userId: userId, interestId: interestId, bookCount: bookCount}, function (data)
    {
        if(data=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        if (data)
        {
            if (bookCount == 0)
                $('#booksContent').html(data);
            else
                $('#booksContent').append(data);
            $('.images').height(250);
            var remainingBooks = $('#remainingBooks'+bookCount).val();
            remainingBooks = parseInt(remainingBooks);
            if (remainingBooks == 0)
                $('#moreBooks').hide();
            else
                $('#moreBooks').show();
            $('body').animate({ scrollTop: $('body')[0].scrollHeight}, 1000);
            bookCount += 4;
        }
        $('#booksContent').fadeIn();
    });
}

function showMoreResources()
{
    $.post('http://b2.com/getContentResources', {userId: userId, interestId: interestId, resourceCount: resourceCount}, function (data)
    {
        if(data=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        if (data)
        {
            if (resourceCount == 0)
                $('#resourcesContent').html(data);
            else
                $('#resourcesContent').append(data);
            $('.images').height(250);
            var remainingResources = $('#remainingResources'+resourceCount).val();
            remainingResources = parseInt(remainingResources);
            if (remainingResources == 0)
                $('#moreResources').hide();
            else
                $('#moreResources').show();
            $('body').animate({ scrollTop: $('body')[0].scrollHeight}, 1000);
            resourceCount += 4;
        }
        $('#resourcesContent').fadeIn();
    });
}

function showMorePollsNQuizes()
{
    $.post('http://b2.com/getContentPollsNQuizes', {userId: userId, interestId: interestId, pollQuizCount: pollQuizCount}, function (data)
    {
        if(data=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        if (data)
        {
            if (pollQuizCount == 0)
                $('#pollsnquizesContent').html(data);
            else
                $('#pollsnquizesContent').append(data);
            $('.images').height(250);
            var remainingPollsNQuizes = $('#remainingPollsNQuizes'+pollQuizCount).val();
            remainingPollsNQuizes = parseInt(remainingPollsNQuizes);
            if (remainingPollsNQuizes == 0)
                $('#morePollsNQuizes').hide();
            else
                $('#morePollsNQuizes').show();
            $('body').animate({ scrollTop: $('body')[0].scrollHeight}, 1000);
            pollQuizCount += 4;
        }
        $('#pollsnquizesContent').fadeIn();
    });
}

//this is the function that shows the purchase box
function showPurchase(bid,ifc,uifc,cid)
{
    if(ifc>uifc)
    {
        $.post('http://b2.com/getIFCs', function(ifcee)
         {
             if(ifcee=='wH@tS!nTheB0x')
                 window.location='http://b2.com/offline';
                $("#ifcModalContent").html("This "+bid.name+" [<i>"+bid.id+"</i>] is costed at <b>"+ifc+"</b><i>i</i>, and you have got "+ifcee+" <i>i</i> remaining in your account!");
                $('#cid').val(cid);
                $("#ifc").val(ifc);
                $('#ifcModal').modal('show');
         });
        
    }
    else
    {
        $.post('http://b2.com/getIFCs', function(ifcee)
         {
             if(ifcee=='wH@tS!nTheB0x')
                 window.location='http://b2.com/offline';
             $("#purchaseModalContent").html("This "+bid.name+" [<i>"+bid.id+"</i>] is costed at <b>"+ifc+"</b><i>i</i>, and you have got "+ifcee+" <i>i</i> remaining in your account!");
             $("#type").html(bid.name);
             $('#cid').val(cid);
             $("#ifc").val(ifc);
             $('#purchaseModal').modal('show');
         });
    }
}

function purchase()
{
	var type=$('#type').html();
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
        $("#purchaseModal").modal('hide');
        $.post('http://b2.com/getIFCs', function(ifcee)
        {
            if(ifcee=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            var ifccc = $("#ifc").val();
            ifccc = parseInt(ifccc);
            ifcee = parseInt(ifcee);
            $("#mycounter").fadeIn();
            $("#mycounter").flipCounterInit({'speed': 0.05});
            $("#mycounter").flipCounterUpdate(ifcee-ifccc);
            window.location='http://b2.com/sym140Nb971wzb4284/'+cid;
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

function showPreview(blogBookId)
{
    $("#previewDivContent").html("<iframe id='bbPreview' class='col-lg-12' src='http://b2.com/previewBlogBook/"+blogBookId+"' style='margin-top: 3%' height='500' frameborder='0'></iframe>");
    $("#mainContainer").css("opacity","0");
    $("#previewDiv").fadeIn();
}

function showCollaborationPreview(collaborationId)
{
    $("#previewDivContent").html("<iframe id='cPreview' class='col-lg-12' src='http://b2.com/previewCollaboration/"+collaborationId+"' style='margin-top: 3%' height='500' frameborder='0'></iframe>");
    $("#mainContainer").css("opacity","0");
    $("#previewDiv").fadeIn();
}

function closePreview()
{
    $("#mainContainer").css("opacity","1");
    $("#previewDiv").fadeOut();
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
                window.location='http::/bbarters.com/offline';
            $('#inviteLinkAndErrors').html(msg);
            $("#inviteLinkAndErrors").show();
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

function showArticlePreview(id)
{
    $("#previewDivContent").html("<iframe id='cPreview' class='col-lg-12' src='http://b2.com/articlePreviewIframe/"+id+"' style='margin-top: 3%' height='500' frameborder='0'></iframe>");
    $("#mainContainer").css("opacity","0");
    $("#previewDiv").fadeIn();
}

function showResourcePreview(id)
{
    $("#previewDivContent").html("<iframe id='cPreview' class='col-lg-12' src='http://b2.com/resourceIframe/"+id+"' style='margin-top: 3%' height='500' frameborder='0'></iframe>");
    $("#mainContainer").css("opacity","0");
    $("#previewDiv").fadeIn();
}