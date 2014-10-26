var oTable1=null;
var oTable2=null;
var oTable3=null;
$(document).ready(function()
{
    oTable1=$('#friendList').dataTable( {
        "ajax": 'getFriendList',
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
    } );

    oTable2=$('#requestList').dataTable( {
        "ajax": 'getRequestList',
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
    } );

    oTable3=$('#pendingList').dataTable( {
        "ajax": 'getPendingList',
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
    } );


});

function friendsModalUnfriend(rowid,id9)
{
    bootbox.confirm("Are you sure?", function(result) {
        if (result==true)
        {
             $.ajax({
                type: "POST",
                url: "http://localhost/b2v2/deleteFriend/"+id9,
                data: {type:'kind'}
            }).done(function(data)
            {   if(data=='wH@tS!nTheB0x')
                    window.location='http://localhost/b2v2/offline';
                else
                {
                    var row = $(rowid).closest("tr").get(0);
                    oTable1.fnDeleteRow(oTable1.fnGetPosition(row));
                }
            });
        }
    });
}

function cancelRequest(rowid,id5)
{
    bootbox.confirm("Are you sure want to cancel the request?", function(result)
    {
        if (result==true)
        {
            $.post("http://localhost/b2v2/cancelRequest/"+id5,{type:'kind'},function(error)
            {
                if(error=='wH@tS!nTheB0x')
                    window.location='http://localhost/b2v2/offline';
                else
                {
                    var row = $(rowid).closest("tr").get(0);
                    oTable3.fnDeleteRow(oTable3.fnGetPosition(row));
                }
            });
        }
    });

}

function acceptRequest(rowid,id6)
{
    $.post("http://localhost/b2v2/acceptFriend/"+id6,{type:'kind'},function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://localhost/b2v2/offline';
        else
        {
            var row = $(rowid).closest("tr").get(0);
            oTable2.fnDeleteRow(oTable2.fnGetPosition(row));
            oTable1.dataTable().fnDestroy();
            oTable1=$('#friendList').dataTable( {
                "ajax": 'getFriendList',
                "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
            } );
        }
    });
}

function declineRequest(rowid,id7)
{

    $.post("http://localhost/b2v2/declineFriend/"+id7,{type:'kind'},function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://localhost/b2v2/offline';
        else
        {
            var row = $(rowid).closest("tr").get(0);
            oTable2.fnDeleteRow(oTable2.fnGetPosition(row));
        }
    });

}



