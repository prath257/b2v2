var oTable=null;
$(document).ready(function()
{
    var cId = $("#collaborationId").val();
    oTable=$('#example').dataTable( {
        "ajax": 'http://b2.com/getCollaborationChapterData/'+cId,
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
    } );
});

function deleteChapter(bid,dcid)
{
    bootbox.confirm("Are you sure?", function(result) {
        if (result==true)
        {
            $.post('http://b2.com/deleteCollaborationChapter',{id:dcid},function(error)
            {
                if(error=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                {
                    var row = $(bid).closest("tr").get(0);
                    oTable.fnDeleteRow(oTable.fnGetPosition(row));
                }
            })
        }
    });
}