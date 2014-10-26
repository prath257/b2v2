$(document).ready(function()
{
    $("#mycounter").flipCounterInit();
    $(document).click(function(e){
        if ($(e.target).is('#mycounter,#mycounter *')) {
            //Do Nothing
        }
        else
        {
            $('#mycounter').fadeOut();
        }
    });

});


function submitPoll(pid)
{
    var ifc = $("#IFC").val();
    bootbox.confirm("Are you sure? Answering this poll will cost you "+ifc+" IFCs.", function(result) {
        if (result==true)
        {
            var res=$("input[name="+pid+"]:checked").val();
            if(res)
            {
                $.post('http://b2.com/submitPoll',{pollId:pid,response:res},function(data)
                {

                    if(data=='wH@tS!nTheB0x')
                        window.location='http://b2.com/offline';
                    else
                    {
                        $('#pollResult').html(data);
                        $('#pollResult').fadeIn();

                        $.post('http://b2.com/getIFCs', function(ifc)
                        {
                            if(ifc=='wH@tS!nTheB0x')
                                window.location='http://b2.com/offline';
                            else
                            {
                                $('#mycounter').fadeIn();
                                $("#mycounter").flipCounterUpdate(ifc);
                            }
                        });
                    }
                });
            }
        }
    });
}


function getResults(pid)
{
    $.post('http://b2.com/getResult/'+pid,{data:'none'},function(data)
    {
        if(data=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#pollResult').html(data);
            $('#pollResult').fadeIn();
        }
    });

}

//to ask user to login to view the poll
function pleaseLogin()
{
    bootbox.confirm("You need to be logged in to do that. Would you like to log in?",function(result){
        if(result==true)
        {
            window.location='http://b2.com/';
        }
    });
}
