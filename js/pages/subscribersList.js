var oTable1=null;
var oTable2=null;
$(document).ready(function()
{
    oTable1=$('#subscribersList').dataTable( {
        "ajax": 'getSubscribersList',
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
    } );
    oTable2=$('#subscriptionsList').dataTable( {
        "ajax": 'getSubscriptionsList',
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
    } );

});

function block_unblock(bid,sid)
{

    bootbox.confirm("Are you sure?", function(result) {
        if (result==true)
        {
            $.ajax({
                type: "POST",
                url: "http://localhost/b2v2/blockUnblockSubscriber",
                data: {id: sid}
            }).done(function(error)
            {
                if(error=='wH@tS!nTheB0x')
                    window.location='http://localhost/b2v2/offline';s
                else
                {
                    var button=$(bid).html();
                    if(button=="Block")
                    {
                        $(bid).html('Unblock');
                    }
                    else
                    {
                        $(bid).html('Block');
                    }
                }
            });
        }
    });
}

function unfollow(rowid,id2)
{
    bootbox.confirm("Are you sure want to cancel the subscription?", function(result)
    {
        if (result==true)
        {
            $.ajax({
                type: "POST",
                url: "http://localhost/b2v2/unSubscribe",
                data: {id: id2}
            }).done(function(error)
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
    });

}

