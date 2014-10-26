$(document).ready(function()
{
    $(".rating").rating();
    $(document).click(function(e){
        if ($(e.target).is('#mycounter,#mycounter *')) {
            //Do Nothing
        }
        else
        {
            $('#mycounter').fadeOut();
        }
    });

    var newUser = document.getElementById('newUser').value;
    if (newUser=='true')
    {
        $.post('http://b2.com/getIFCs', function(ifc)
        {
            if(ifc=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                $("#mycounter").fadeIn();
                $("#mycounter").flipCounterInit({'speed': 0.05});
                $("#mycounter").flipCounterUpdate(ifc);
            }
        });
    }
});