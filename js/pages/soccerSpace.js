
$(document).ready(function()
    {

        getTeamData();

    }
);

function getTeamData()
{
    var tid=$('#teamID').val();
    $.post('http://b2.com/getTeamData',{team:tid},function(data)
    {
        $('#teamData').html(data);
        $('abbr').removeAttr("title");
    });
}


function transfer(pid)
{
    if(pid==1)
    {
        window.location='http://b2.com/playPredictor';
    }
    else if(pid==2)
    {
        window.location='http://b2.com/playerRatings';
    }
    else
    {
        window.location='http://b2.com/getLiveSoccer';
    }


}

function changeTeam()
{
    $('#teamModal').modal({
        keyboard: false,
        show: true,
        backdrop: 'static'
    });
}

//these are the functions for finidng the club for ratings
function findClubDown()
{
    clearTimeout(playerSearchTimer);
}

function findClubUp()
{
    clubSearchTimer = setTimeout(function()
    {
        var club = $('#searchClub').val();
        searchClub(club);
    }, 500);
}

function searchClub(val)
{
    $('#clubSearchResult').html('<div style="text-align: center"><img src="http://b2.com/Images/icons/waiting.gif"></div>');
    $('#clubSearchResult').show();

    $.post('http://b2.com/searchClub', {club: val}, function(markup)
    {
        if (markup == 'wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#clubSearchResult').html(markup);

        }
    });
}

function getClub(cid,cname)
{
    $('#clubSearchResult').html('');
    bootbox.confirm('Are you sure want to set your team as: '+cname,function(result)
    {
        if(result==true)
        {
            $('#teamBody').html("<div style='text-align:center'><img  src='http://b2.com/Images/icons/waiting.gif'>Saving Team...</div>");
            $.post('http://b2.com/changeTeam',{club:cid},function(data)
            {
                if(data=='success')
                {
                    window.location.reload();
                }
            });
        }
    })

}
