var match=null;
var players=null;
var family=null;
var comContent=null;
var playerSearchTimer=null;
var clubSearchTimer=null;
var matchRatings={matchid:0,ratings:[]};
$(document).ready(function()
{
    width = $(window).width();

});

function myPredictions(tipo)
{
    $.post('http://b2.com/createSchedule',{type:tipo},function(data)
    {
        $('#mainTask').html(data);
    });
}

function getNextMatchDay(tipo)
{
    if($('#league').val()!='default')
    {
        leagueId = $('#league').val();
        $.post('http://b2.com/getNextMatchDay', {league: leagueId, type: tipo}, function (data)
        {
            if(data=='NoResult')
            {
                bootbox.alert('No MatchDay Results available, please try later');
            }
            else
            {
                $('#matchdayDetails').html(data);
                if (width < 768) {
                    $('#leagueLogo').hide();
                }
                $('#matchdayDetails').fadeIn();
                matchDay = $('#dayMatch').val();

            }

        });
    }
    else
    {
        bootbox.alert('Please select a league to proceed');
    }

}

function getPlayers()
{
    match=$('#matchSelect').val();
    if(match!='default')
    {
        $.post('http://b2.com/checkMatchRatings',{mid:match},function(data)
        {
            if(data=='New')
            {
                matchRatings.matchid=match;
                $('#addHomePlayers').fadeIn();
                $('#addAwayPlayers').fadeIn();
                $('#ratingsStatus').html('');
            }
            else
            {
                $('#ratingsStatus').append('You have already given match ratings for this: <a href="/getMatchRatings/'+match+ '" target="_blank"> see here</a');
            }
        })

    }
    else
    {
        bootbox.alert('Please select a match to proceed');
    }
}

function showPlayersModal(side)
{
    var markup=null;
    showWaiting('Loading Squad');
    if(side=='Home')
    {
        $.post('http://b2.com/getSquad',{mid:match,side:side},function(data)
        {
            markup=data;
            closeWaiting();
            $('#playerBody').html(markup);
            $('#playersModal').modal({
                keyboard: false,
                show: true,
                backdrop: 'static'
            });

        });

    }
    else
    {
        $.post('http://b2.com/getSquad',{mid:match,side:side},function(data)
        {
            markup=data;
            closeWaiting();
            $('#playerBody').html(markup);
            $('#playersModal').modal({
                keyboard: false,
                show: true,
                backdrop: 'static'
            });

        });

    }


}

function addPlayers(side)
{

    var selectedPlayers = [];
    $('#playerBody input:checked').each(function()
    {
        selectedPlayers.push($(this).attr('id'));
    });
    if(selectedPlayers.length < 11 || selectedPlayers.length >14)
    {
        bootbox.alert('Please select minimum 11 and maximum 14 players');
    }
    else
    {
        players=selectedPlayers;
        $('#playersModal').modal('hide');
        showWaiting('Loading Template');
        $.post('http://b2.com/getRatingsTemplate',{players:selectedPlayers, side:side},function(data)
        {
            var x;
            closeWaiting();
            $('#ratePlayers').html(data);
            $('.rating').rating();

        });
    }
}

function submitRatings(side)
{
    var p;
    family = jsonQ(matchRatings);
    for(p in players)
    {
        var newRating =
        {
            "pid": players[p],
            "comment": $('#comment'+players[p]).val(),
            "score": $("#rating"+players[p]).val()
        }

       family.find('ratings').append(newRating);
     }

    $('#ratePlayers').html('');
    $('#add'+side+'Players').fadeOut();
    $('#saveFinal').fadeIn();
    $('#ratingsStatus').append(side+' side ratings saved!<br>');
}

function saveRatings()
{
    bootbox.confirm('Are you sure want to save your match ratings, you wont be able to do it again for this match',function(result)
    {
        if(result==true)
        {
            $.post('http://b2.com/saveMatchRatings',{matchid:match,matchratings:JSON.stringify(matchRatings)},function(data)
            {
                if(data=='Success')
                {
                    window.location='http://b2.com/soccerSpace';
                }
            });
        }
        else
        {

        }

    })
}

function checkLength(comment)
{
    if(comment.textLength > 254)
    {
        comment.value(comContent);
    }
    else
    {
        comContent = comment.value();
    }


}
//these are the functions for getting myratings

function getMyRatings()
{
    showWaiting('Fetching your ratings');
    $.post('http://b2.com/getMyRatings',{para:null},function(data)
    {
        closeWaiting();
        $('#mainTask').html(data);
        oTable1=$('#myRatingsTable').dataTable( {
            "ajax": 'http://b2.com/getMyRatingsTable',
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
        } );
        //this is for generating the graph
        var myBestRatings = Morris.Bar({
            // ID of the element in which to draw the chart.
            element: 'myBestPlayers',
            data: [0,0], // Set initial data (ideally you would provide an array of default data)
            xkey: 'player', // Set the key for X-axis
            ykeys: ['avg_rating'], // Set the key for Y-axis
            labels: ['Avg Rating'],
            barColors:['#000033'],
            axes:true,
            grid:false,
            hideHover:false
        });
        //make a call to get the data
        requestData(5000, myBestRatings,'MyBestRatings');
    });
}


function getFriendsRatings()
{
    showWaiting('Fetching Friends ratings');
    $.post('http://b2.com/getFriendsRatings',{para:null},function(data)
    {
        closeWaiting();
        $('#mainTask').html(data);
        oTable1=$('#friendsRatingsTable').dataTable( {
            "ajax": 'http://b2.com/getFriendsRatingsTable',
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
        } );

        var friendsBestRatings = Morris.Bar({
            // ID of the element in which to draw the chart.
            element: 'friendsBestPlayers',
            data: [0,0], // Set initial data (ideally you would provide an array of default data)
            xkey: 'player', // Set the key for X-axis
            ykeys: ['avg_rating'], // Set the key for Y-axis
            labels: ['Avg Rating'],
            barColors:['#000033'],
            axes:true,
            grid:false,
            hideHover:false
        });
        //make a call to get the data
        requestData(5000, friendsBestRatings,'FriendsBestRatings');
    });
}

function requestData(days, chart, type)
{
    try
    {
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "http://b2.com/get"+type, // This is the URL to the API
            data: { days: days }
        })
            .done(function( data ) {
                if(data=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                {
                    // When the response to the AJAX request comes back render the chart with new data
                    chart.setData(data);
                }
            })
            .fail(function() {
                // If there is no communication between the server, show an error
                // alert( "error occured" );
            });
    }
    catch(error)
    {
        //do nothing about the error
    }
}

//these are the functions related to fetching the player comments
function toggleLinks(type)
{
    if(type=='mr')
    {
        $('#bestPlayersDiv').hide();
        $('#commentsDiv').hide();
        $('#matchRatingsDiv').fadeIn();
        $('#mrButton').hide();
        $('#grButton').show();
        $('#cmButton').show();
    }
    if(type=='gr')
    {
        $('#commentsDiv').hide();
        $('#matchRatingsDiv').hide();
        $('#bestPlayersDiv').fadeIn();
        $('#grButton').hide();
        $('#mrButton').show();
        $('#cmButton').show();

    }
    if(type=='cm')
    {
        $('#matchRatingsDiv').hide();
        $('#bestPlayersDiv').hide();
        $('#commentsDiv').fadeIn();
        $('#cmButton').hide();
        $('#grButton').show();
        $('#mrButton').show();
    }
}
function playerCommentsDown()
{
    clearTimeout(playerSearchTimer);
    var player = $('#searchPlayer').val();

}

function playerCommentsUp(tipo)
{
    playerSearchTimer = setTimeout(function()
    {
        var player = $('#searchPlayer').val();
        searchPlayer(player,tipo);
    }, 500);
}

function searchPlayer(val,tipo)
{
    $('#searchResult').html('<div style="text-align: center"><img src="http://b2.com/Images/icons/waiting.gif"></div>');
    $('#searchResult').show();

    $.post('http://b2.com/searchPlayerComments', {player: val, type: tipo}, function(markup)
    {
        if (markup == 'wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#searchResult').html(markup);

        }
    });
}

function getPlayerComments(tipo,pid)
{
    showWaiting('Fetching Comments');
    $.post('http://b2.com/getPlayerComments',{type:tipo,player:pid},function(data)
    {
        if (data == 'wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            closeWaiting();
            $('#searchResult').html(data);
            $('#searchPlayer').val('');
        }

    }) ;

}

function getClubRatings()
{
    $.post('http://b2.com/getClubRatingsView',{type:null},function(data)
    {
        $('#mainTask').html(data);
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
    showWaiting('Fetching Club Stats for '+cname);
    $.post('http://b2.com/fetchClubRatings',{club:cid},function(data)
    {
        closeWaiting();
        $('#clubSearchResult').html(data);
    }) ;
}

function getClubPlayers(cid)
{
    $('#commentsDiv').hide();
    $('#clubBestPlayers').html('');
    $('#bestPlayersDiv').fadeIn();
    var clubBestRatings = Morris.Bar({
        // ID of the element in which to draw the chart.
        element: 'clubBestPlayers',
        data: [0,0], // Set initial data (ideally you would provide an array of default data)
        xkey: 'player', // Set the key for X-axis
        ykeys: ['avg_rating'], // Set the key for Y-axis
        labels: ['Avg Rating'],
        barColors:['#000033'],
        axes:true,
        grid:false,
        hideHover:false
    });
    //make a call to get the data
    requestData(cid, clubBestRatings,'clubBestRatings');



}

function getClubComments(cid)
{
    $('#bestPlayersDiv').hide();
    $('#commentsDiv').fadeIn();
}


function showWaiting(msg)
{
    var waitMarkup='<img  src="http://b2.com/Images/icons/waiting.gif">'+msg+'...';
    $('#waitingMsg').html(waitMarkup);
    $('#waitingModal').modal({
        keyboard: false,
        show: true,
        backdrop: 'static'
    });

}

function closeWaiting()
{
    $('#waitingModal').modal('hide');
}



