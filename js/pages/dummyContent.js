var oTablea=null;
var oTableb=null;
var oTablec=null;
$(document).ready(function()
{
   var width = $(document).width();
    if (width<=700)
    {
        $(".table").addClass("table-bordered");
    }
    var userId = $("#userId").val();
    var interestId = $("#interestId").val();

	oTablea=$('#articleData').dataTable( {
		"ajax": 'http://b2.com/getHisArticlesData/'+userId+'/'+interestId,
		"lengthMenu": [[2, 10, 15, -1], [2, 10, 15, "All"]]
	} );

	oTableb=$('#bookData').dataTable( {
		"ajax": 'http://b2.com/getHisBooksData/'+userId+'/'+interestId,
		"lengthMenu": [[2, 10, 15, -1], [2, 10, 15, "All"]]
	} );

	oTablec=$('#resourceData').dataTable( {
		"ajax": 'http://b2.com/getHisResourcesData/'+userId+'/'+interestId,
		"lengthMenu": [[2, 10, 15, -1], [2, 10, 15, "All"]]
	} );

    oTabled=$('#collaborationData').dataTable( {
        "ajax": 'http://b2.com/getHisCollaborationData/'+userId+'/'+interestId,
        "lengthMenu": [[2, 10, 15, -1], [2, 10, 15, "All"]]
    } );

    oTablee=$('#contributionData').dataTable( {
        "ajax": 'http://b2.com/getHisContributionData/'+userId+'/'+interestId,
        "lengthMenu": [[2, 10, 15, -1], [2, 10, 15, "All"]]
    } );
});

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