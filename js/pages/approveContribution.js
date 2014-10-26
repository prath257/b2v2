function approve(res,id)
{
    $('.verdictButtons').addClass('disabled');
    $.post('http://b2.com/approveVerdict', {res:res, id: id},function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            if(res=='true')
            {
                bootbox.alert("Contribution successfully approved.", function()
                {
                    window.location='http://b2.com/home';
                });
            }
            else
            {
                bootbox.alert("Contribution has been deleted.", function()
                {
                    window.location='http://b2.com/home';
                });
            }
        }
    })
}