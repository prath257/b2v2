var chatON=false;
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

	oTablea=$('#articleData').dataTable( {
		"ajax": 'http://b2.com/getMyArticlesData',
		"lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
	} );

	oTableb=$('#bookData').dataTable( {
		"ajax": 'http://b2.com/getMyBooksData',
		"lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
	} );

    oTablec=$('#collaborationData').dataTable( {
        "ajax": 'http://b2.com/getMyCollaborationsData',
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
    } );



});



//Series of functions that proceed a user's '+ Contribute' click
function plusContribute(colId)
{
    $('#collaborationId').val(colId)
    $('#contributionReasonModal').modal('show');
}

function postRequest()
{
    $('#plusContributeSubmit').hide();
    $('#waitingPlusContributeSubmit').show();
    var id = $('#collaborationId').val();
    var reason = $('#contributeReason').val();

        $.post('http://b2.com/request2contribute', {id: id, reason: reason}, function(response)
        {
            if(error=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                $('#plusContributeSubmit').show();
                $('#waitingPlusContributeSubmit').hide();

                if (response == 'success')
                {
                    $('#contributionReasonModal').modal('hide');
                    bootbox.alert("Request sent successfully!");
                    $('#PlusContribute'+id).hide();
                }
            }
        });
}