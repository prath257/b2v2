function approve(res,id)
{
    $('#approvalDiv').html('<img src="http://b2.com/Images/icons/waiting.gif">');
    $.post('http://b2.com/approveVerdict', {res:res, id: id},function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#approvalDiv').html('');
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