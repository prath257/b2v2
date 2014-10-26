function approve(res,id)
{
    $('.verdictButtons').addClass('disabled');
    $.post('http://localhost/b2v2/approveVerdict', {res:res, id: id},function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://localhost/b2v2/offline';
        else
        {
            if(res=='true')
            {
                bootbox.alert("Contribution successfully approved.", function()
                {
                    window.location='http://localhost/b2v2/home';
                });
            }
            else
            {
                bootbox.alert("Contribution has been deleted.", function()
                {
                    window.location='http://localhost/b2v2/home';
                });
            }
        }
    })
}