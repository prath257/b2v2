var feed=null;
var height=0;
var timer=null;
var check=[];
var userSearchTimer=null;
var searchOn=false;
var searchString=null;
var restComment='';
var slogan=true;
var filter='all';

$(document).ready(function()
{

    feed=$('#feedNo').val();
    $.post('http://b2.com/getOldSoccerData', {feedNo: feed}, function (data)
    {
            $('#scrollDiv').html(data);
    });
    height= $(window).height();
    //this is for data filter
    $(".btn-group button").click(function ()
    {
        filter=$(this).val();
        var gid=this.id;
        if(gid=="sab")
        {
            $('#sab').addClass('btn-primary');
            $('#sfb').removeClass('btn-primary');
            $('#stb').removeClass('btn-primary');
            applyFilter();

        }
        else if(gid=="sfb")
        {
            $('#sfb').addClass('btn-primary');
            $('#sab').removeClass('btn-primary');
            $('#stb').removeClass('btn-primary');
            applyFilter();

        }
        else
        {
            $('#stb').addClass('btn-primary');
            $('#sfb').removeClass('btn-primary');
            $('#sab').removeClass('btn-primary');
            applyFilter();

        }
    });

});
function addZero(i)
{
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

function getdate() {
    var d = new Date();
    var x = document.getElementById("demo");
    var h = addZero(d.getUTCHours());
    var m = addZero(d.getUTCMinutes());
    var s = addZero(d.getUTCSeconds());
    $("#ct").html(h+":"+m);
}


function applyFilter()
{
    clearTimeout(userSearchTimer);
    $('#scrollDiv').html('<div style="text-align: center"><img src="http://b2.com/Images/icons/waiting.gif">Filtering...</div>');
    $.post('http://b2.com/getOldFilterData',{feedNo:feed,dataFilter:filter},function(data)
    {

            $('#scrollDiv').html(data);
            timer=setTimeout(getLiveData,17000);


    });
}
