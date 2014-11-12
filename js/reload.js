

/*onload=function(){
    var e=document.getElementById("refreshed");
    if(e.value=="no")e.value="yes";
    else{e.value="no";location.reload();}
}*/


function submitProblem()
{
    var past = $('#past').val();
    var future = $('#future').val();
    var present = $('#present').val();

    $('#submitProblem').hide();
    $('#waiting').show();
    $.post('http://b2.com/submitProblemOnException', {past: past, future: future, present: present}, function()
    {
        $('#reportThisModal').modal('hide');
        bootbox.alert("Well, we truly appreciate that! Thank you for your time.", function() {
            window.location = 'http://b2.com/home';
        });
    });
}