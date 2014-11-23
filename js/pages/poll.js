var reccod = false;
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

    $('.Profileimages').css('height','175px');
});


function submitPoll(pid)
{
    bootbox.confirm("Sure about that choice?", function(result) {
        if (result==true)
        {
            var res=$("input[name="+pid+"]:checked").val();
            if(res)
            {
                $.post('http://b2.com/submitPoll',{pollId:pid,response:res},function(data)
                {

                    $('#pollResult').html(data);
                    $('#pollResult').fadeIn();
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