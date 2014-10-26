$(document).ready(function()
{

    showRespond();


});

function showRespond()
{
    $('#respondToBugModal').modal({
        keyboard:false,
        show:true,
        backdrop:'static'
    });
}


function postResponse()
{
    $('#postButton').prop('disabled', true);
    $("#postButton").html("Please Wait...");
    var id = $("#bugId").val();
    var ifc = $("#ifc").val();
    var response = $("#response").val();

    $.post('http://b2.com/respondToBug', {id: id, ifc: ifc, response: response}, function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        window.close();
    });


}

function postResponseProblem(id)
{
    $('#postButton').prop('disabled', true);
    $("#postButton").html("Please Wait...");

    var ifc = $("#ifc").val();
    var response = $("#response").val();

    $.post('http://b2.com/respondToProblem', {id: id, ifc: ifc, response: response}, function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        window.close();
    });


}


