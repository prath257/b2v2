/**
 * Created by bbarters on 30-11-2014.
 */
//this function is called when League is selected
var leagueId=null;
var matchDay=null;

//these are the variables for scores predictions
var matchId=null;
var hgoals=0;
var agoals=0;
var hscorers=[];
var ascorers=[];

var predict={"league":0,"matchday":0,"predictions":[]};
var family=null;
var width=0;

var oTable1=null;
var oTable2=null;
var friendSearchTimer=null;

var playerSearchTimer=null;

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
            if(data=='NoMatch')
            {
                bootbox.alert('Next Matchday Schedule is getting updated, please try after some time.');
            }
            else
            {
                $('#matchdayDetails').html(data);
                if (width < 768) {
                    $('#leagueLogo').hide();
                }
                $('#matchdayDetails').fadeIn();
                matchDay = $('#dayMatch').val();
                predict.league=leagueId;
                predict.matchday=matchDay;
                if (tipo == 'predict')
                {
                    showWaiting('Loading Matchday');
                    $.post('http://b2.com/getMatches', {league: leagueId, matchday: matchDay}, function (data) {

                        closeWaiting();
                        $('#matchdaySchedule').html(data);

                    });

                }

                else
                {

                }
            }

        });
    }
    else
    {
           bootbox.alert('Please select a league to proceed');
    }

}

function saveHomeScoring(mid,score)
{
    //validate the text box value, if greater than zero
    score.value = score.value.replace(/[^0-9\.]/g, '0');
    var hscore=parseInt(score.value);
    if(hscore !=0)
    {
        family = jsonQ(predict);
        var match = family.find('match');
        var index = match.index(mid);
        predict.predictions[index].home=hscore;
        $('#saveLink'+mid).fadeIn();

    }

}

function saveAwayScoring(mid,score)
{
    score.value = score.value.replace(/[^0-9\.]/g, '0');
    var ascore=parseInt(score.value);
    if(ascore !=0)
    {
        family = jsonQ(predict);
        var match = family.find('match');
        var index = match.index(mid);
        predict.predictions[index].away=ascore;
        $('#saveLink'+mid).fadeIn();
    }


}

function matchPrediction(mid, chk)
{
    family = jsonQ(predict);
    var check=chk.checked;
    if(check)
    {
       //to add this match to json
        var newMatch = {
            "match": mid,
            "home": 0,
            "away": 0,
            "homescorers": [],
            "awayscorers": []
        }
        family.find('predictions').append(newMatch);
        //Now enable the text boxes
        $('#hg'+mid).attr('disabled',false);
        $('#ag'+mid).attr('disabled',false);
        $('#saveLink'+mid).fadeIn();
    }
    else
    {
        //This is the code to remove the match from JSON
         family = jsonQ(predict);
         var match = family.find('match');
         var index=match.index(mid);
         predict.predictions.splice(index,1);
        //disable the text-boxes, make them 0-0 also
        $('#hg'+mid).attr('disabled',true);
        $('#ag'+mid).attr('disabled',true);
        $('#hg'+mid).val('0');
        $('#ag'+mid).val('0');
        $('#saveLink'+mid).hide();

    }
}

function showScorerModal(mid)
{
    var hscore=$('#hg'+mid).val();
    var ascore=$('#ag'+mid).val();
    if(hscore > 0 || ascore > 0)
    {
        showWaiting('Loading Players');
        $.post('http://b2.com/scorerSelector', {match: mid, home: hscore, away: ascore}, function (data)
        {
            matchId=mid;
            hgoals=0;
            agoals=0;
            ascorers=[];
            hscorers=[];
            $('#scorerBody').html(data);
            $('#scorePredicted' + mid).html("Your prediction: " + hscore + '-' + ascore);
            closeWaiting();
            $('#scorerModal').modal({
                keyboard: false,
                show: true,
                backdrop: 'static'
            });
        });
    }
    else
        {
            bootbox.alert('Its 0-0 man, you dont need to predict offsides!');
        }
}

function saveScores(mid)
{

    bootbox.confirm('Are you sure want to save your predictions, cant change them again and wont be able to make scorers predictions!',function(result) {
        if (result == true)
        {
                $('#check' + mid).hide();
                $('#done' + mid).fadeIn();
                $('#hg' + mid).attr('disabled', true);
                $('#ag' + mid).attr('disabled', true);
                $('#saveLink' + mid).hide();
        }
    });
}

function savePredictions(mid,hg,ag)
{
    if(hscorers.length < hg || ascorers.length < ag)
    {
       bootbox.alert('Please predict all the goalscorers according to your score prediction');
    }

    else
    {
        bootbox.confirm('Are you sure want to save your predictions, you wont be able to change them later!', function (result) {
            if (result == true)
            {
                var scorerid = null;
                family = jsonQ(predict);
                var match = family.find('match', function () {
                    return this == mid;
                });
                var homeScorers = match.sibling('homescorers');

                for (i = 0; i < hg; i++)
                {
                    scorerid = hscorers[i];
                    var scorer = {"pid": scorerid};
                    homeScorers.append(scorer);
                }
                var awayScorers = match.sibling('awayscorers');
                for (i = 0; i < ag; i++)
                {
                    scorerid = ascorers[i];
                    var scorer = {"pid": scorerid};
                    awayScorers.append(scorer);
                }
                $('#check' + mid).hide();
                $('#done' + mid).fadeIn();
                $('#hg' + mid).attr('disabled', true);
                $('#ag' + mid).attr('disabled', true);
                $('#saveLink' + mid).hide();
                $('#scorerModal').modal('hide');

            }

        });
    }

}

function submitPredictions()
{
    bootbox.confirm('Are you sure want to save your this prediction?',function(result)
    {
        if (result == true)
        {
            $('#submitPredictions').hide();
            $('#savingImg').fadeIn();
            predict.league=leagueId;
            predict.matchday=matchDay;
            showWaiting('Submitting Predictions');
            $.post('http://b2.com/saveMatchPredictions',{predictions:JSON.stringify(predict)},function(data)
            {
                if(data=='Success')
                {
                    closeWaiting();
                    window.location='http://b2.com/soccerSpace'
                }
            });

        }
    });
}

//this are the functions for get results use case
function getResults()
{
    showWaiting('Loading Results');
    $.post('http://b2.com/getResultsView',{type:null},function(data)
    {
        $('#mainTask').html(data);
        oTable1=$('#scoreResults').dataTable( {
            "ajax": 'http://b2.com/getScoreResults',
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
        } );
        oTable2=$('#scorerResults').dataTable( {
            "ajax": 'http://b2.com/getScorerResults',
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
        } );

    });
    closeWaiting();
}

//this is the function to get the league stats
 function getLeagueStats()
 {
     showWaiting('Loading League Stats');
     $.post('http://b2.com/getLeagueStats',{type:null},function(data)
     {
         closeWaiting();
         $('#mainTask').html(data);

     });

 }

 function getFriendsPredictions()
 {
     if($('#matchSelect').val()!='default')
     {
        matchId=$('#matchSelect').val();
        showWaiting('Loading Friends Predictions');
         $.post('http://b2.com/getFriendsPredictions',{matchId:matchId, friend:0},function(data)
         {
             closeWaiting();
             $('#matchdaySchedule').html(data);

         }) ;
     }
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


//this is the functions to search scorers
function playerCommentsDown()
{
    clearTimeout(playerSearchTimer);



}

function playerCommentsUp(tid,side)
{

    playerSearchTimer = setTimeout(function()
    {
        var player = $('#'+side+'searchPlayer').val();
        if(player.length>0)
           searchPlayer(player,tid,side);
        else
            $('#'+side+'searchResult').hide();
    }, 500);
}

function searchPlayer(val,tid,side)
{
    $('#'+side+'searchResult').html('<div style="text-align: center"><img src="http://b2.com/Images/icons/waiting.gif"></div>');
    $('#'+side+'searchResult').show();

    $.post('http://b2.com/searchPlayer', {player: val, team:tid, type:side}, function(markup)
    {
        if (markup == 'wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {

            $('#'+side+'searchResult').html(markup);

        }
    });
}

function getPlayerComments(tipo,name,pid)
{
    var max=0;
    if(tipo=='home')
    {
        hgoals++;
        max=parseInt($('#homeMax').val());
        if(hgoals <= max)
        {
             hscorers.push(pid);
            $('#'+tipo+'searchResult').hide();
            $('#'+tipo+'searchPlayer').val('');
            $('#homeList').append('<div class="col-xs-8 col-sm-8 col-md-8 chosenPlayer" onclick="removeHomePlayer(this,'+pid+')"><div class="col-xs-12"><br></div>'+name+'&nbsp;&nbsp;<i class="fa fa-times-circle" style="cursor: pointer"></i></div>');
        }
        else
        {
            hgoals--;
            $('#'+tipo+'searchResult').hide();
            $('#'+tipo+'searchPlayer').val('');
            bootbox.alert('You have predicted all '+tipo+' scorers');
        }

    }
    else
    {
        agoals++;
        max=parseInt($('#awayMax').val());
        if(agoals<=max)
        {
            ascorers.push(pid);
            $('#'+tipo+'searchResult').hide();
            $('#'+tipo+'searchPlayer').val('');
            $('#awayList').append('<div class="col-xs-8 col-sm-8 col-md-8 chosenPlayer" onclick="removeAwayPlayer(this,'+pid+')"><div class="col-xs-12"><br></div>'+name+'&nbsp;&nbsp;<i class="fa fa-times-circle" style="cursor: pointer"></i></div>');

        }
        else
        {
            agoals--;
            $('#'+tipo+'searchResult').hide();
            $('#'+tipo+'searchPlayer').val('');
            bootbox.alert('You have predicted all '+tipo+' scorers');
        }

    }


}


function removeHomePlayer(tdiv,pid)
{
    var myDiv=tdiv;
    myDiv.hidden=true;
    var index = hscorers.indexOf(pid);
    if (index > -1)
    {
        hscorers.splice(index, 1);
        hgoals--;
    }
}

function removeAwayPlayer(tdiv,pid)
{
    var myDiv=tdiv;
    myDiv.hidden=true;
    var index = ascorers.indexOf(pid);
    if (index > -1)
    {
        ascorers.splice(index, 1);
        agoals--;
    }

}


// these are the functions required for searching a friend

function friendSearchDown()
{
        clearTimeout(friendSearchTimer);
}

function friendSearchUp()
{
     friendSearchTimer = setTimeout(function ()
     {
         var friendName=$('#searchFriend').val();
         if(friendName.length>0)
             searchFriend(friendName);
         else
             $('#searchResult').hide();

     }, 500);

}

function searchFriend(val)
{
    $('#searchResult').html('<div style="text-align: center"><img src="http://b2.com/Images/icons/waiting.gif">Searching...</div>');
    $('#searchResult').show();
    $.post('http://b2.com/searchFriends', {name: val}, function (markup)
    {
        if (markup == 'wH@tS!nTheB0x')
            window.location = 'http://b2.com/offline';
        else {
            $('#searchResult').fadeIn();
            $('#searchResult').html(markup);

        }
    });

}

function getUserData(pid)
{
    showWaiting('Loading Predictions');
    $.post('http://b2.com/getFriendsPredictions',{matchId:matchId,friend:pid},function(data)
    {
        closeWaiting();
        if(data=='No')
        {
            $('#empty').fadeIn();
            setTimeout(function ()
            {
                $('#empty').fadeOut();
            }, 4000);
            $('#searchResult').hide();
            $('#searchFriend').val('');
        }
        else
        {
            $('#searchResult').hide();
            $('#searchFriend').val('');
            $('#matchdaySchedule').html(data);
        }

    }) ;
}





