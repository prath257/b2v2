var oTable=null;
$(document).ready(function()
{
    var cId = $("#collaborationId").val();
    oTable=$('#example').dataTable( {
        "ajax": 'http://localhost/b2v2/getCollaborationChapterData/'+cId,
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
    } );
});

function deleteChapter(bid,dcid)
{
    bootbox.confirm("Are you sure?", function(result) {
        if (result==true)
        {
            $.post('http://localhost/b2v2/deleteCollaborationChapter',{id:dcid},function(error)
            {
                if(error=='wH@tS!nTheB0x')
                    window.location='http://localhost/b2v2/offline';
                else
                {
                    var row = $(bid).closest("tr").get(0);
                    oTable.fnDeleteRow(oTable.fnGetPosition(row));
                }
            })
        }
    });
}