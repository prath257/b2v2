/**
 * Created by bbarters on 04-12-2014.
 */
/**
 * Created by bbarters on 30-11-2014.
 */
//this function is called when League is selected
var leagueId=null;
var matchDay=null;
var width=0;
var schedule={"league":0,"matchday":0,"matches":[]};
var predict={"league":0,"matchday":0,"predictions":[]};
var family=null;

//these are the variables for scores predictions
var matchId=null;
var hgoals=0;
var agoals=0;
var hscorers=[];
var ascorers=[];

$(document).ready(function()
{
    width = $(window).width();

});

function createSchedule(tipo)
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
        leagueId=$('#league').val();
        if(tipo=='feeds')
        {
              showWaiting('Loading Matches');
              $.post('http://b2.com/getFeedData',{league:leagueId},function(data)
              {
                     closeWaiting();
                     $('#matchdaySchedule').html(data);
              });
        }
        else
        {
            $.post('http://b2.com/getNextMatchDay', {league: leagueId, type: tipo}, function (data) {
                $('#matchdayDetails').html(data);
                if (width < 768) {
                    $('#leagueLogo').hide();
                }
                $('#matchdayDetails').fadeIn();
                matchDay = $('#dayMatch').val();
                if (tipo == 'schedule') {
                    showWaiting('Loading Fixtures');
                    $.post('http://b2.com/getScheduleTemplate', {league: leagueId, md: matchDay}, function (data) {
                        $('#matchdaySchedule').html(data);
                        $('caption').hide();
                        $('thead').hide();
                        $('.js-hide').hide();
                        $("#kickoff").datetimepicker(
                            {
                                startDate: '-3d'
                            }
                        );
                        closeWaiting();
                        $('#submitSchedule').fadeIn();

                    });
                }
                else {
                    showWaiting('Loading Fixtures');
                    $.post('http://b2.com/getResultsTemplate', {league: leagueId, md: matchDay}, function (data) {
                        $('#matchdaySchedule').html(data);
                        closeWaiting();
                        $('#submitSchedule').fadeIn();

                    });
                }
            });
        }
    }
    else
    {

    }
}

function addMatch()
{
    var ht=$('#homeTeam').val();
    var at=$('#awayTeam').val();
    var kf=$('#kickoff').val();
    var hteam=$('#homeTeam option:selected').text();
    var ateam=$('#awayTeam option:selected').text();
    family = jsonQ(schedule);
    if(ht!='' && at!='' && kf!='')
    {

        var newMatch = {
            "hometeam": ht,
            "awayteam": at,
            "kickoff": kf
        }
        family.find('matches').append(newMatch);
        $("#homeTeam option[value="+ht+"]").remove();
        $("#awayTeam option[value="+ht+"]").remove();
        $("#homeTeam option[value="+at+"]").remove();
        $("#awayTeam option[value="+at+"]").remove();
        $('#homeTeam').val('');
        $('#awayTeam').val('');
        $('#kickoff').val('');
        $('#matchList').append('<h5>'+hteam+' Vs '+ateam +'</h5>');

    }

}

function submitSchedule()
{
    bootbox.confirm('Are you sure want to submit schedule, this will be it for this MatchDay!',function(result)
    {
        if (result == true)
        {
            showWaiting('Saving Schedule');
            schedule.league=leagueId;
            schedule.matchday=matchDay;
            $.post('http://b2.com/saveMatchdaySchedule',{schedule:JSON.stringify(schedule)},function(data)
            {
                if(data=='Success')
                {
                    window.location='http://b2.com/soccerAdmin'
                }
                else
                {
                    closeWaiting();
                    bootbox.alert('No Matches Submitted! Do it Again Please!');
                }
            });

        }
    });
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
        $.post('http://b2.com/scorerSelector', {match: mid, home: hscore, away: ascore}, function (data)
        {
            matchId=mid;
            hgoals=0;
            agoals=0;
            ascorers=[];
            hscorers=[];
            $('#scorerBody').html(data);
            $('#scorePredicted' + mid).html("Final Score: " + hscore + '-' + ascore);
            $('#scorerModal').modal({
                keyboard: false,
                show: true,
                backdrop: 'static'
            });
        });
    }
    else
    {
        bootbox.confirm('Are you sure it finished Goalless Draw?',function(result)
        {
            if(result==true)
            {
                $('#check'+mid).hide();
                $('#done'+mid).fadeIn();
                $('#hg'+mid).attr('disabled',true);
                $('#ag'+mid).attr('disabled',true);
                $('#saveLink'+mid).hide();
            }
            else
            {

            }

        })
    }
}

function savePredictions(mid,hg,ag)
{
    if(hscorers.length < hg || ascorers.length < ag)
    {
        bootbox.alert('Please predict all the goalscorers according to your score result');
    }

    else
    {
        bootbox.confirm('Are you sure want to save scores, you wont be able to change them later!', function (result) {
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

function submitResults()
{
    var mcount=$('#matchCount').val();
    if(predict.predictions.length == mcount) {

        bootbox.confirm('Are you sure want to matchday scores, this will be it for this MatchDay!', function (result) {
            if (result == true) {
                showWaiting('Saving Results');
                predict.league = leagueId;
                predict.matchday = matchDay;
                $.post('http://b2.com/saveMatchdayResults', {results: JSON.stringify(predict)}, function (data) {
                    if (data == 'Success') {
                        closeWaiting();
                        window.location = 'http://b2.com/soccerAdmin'
                    }
                });

            }
        });
    }
    else
    {
        bootbox.alert('Dear Admin,please provide results for all matches!');
    }
}


//these are the functions related to feeds

function newFeed()
{
    $('#newFeed').hide();
    $('#createFeedDiv').fadeIn();
}

function createNewFeed()
{
    if($('#matchSelect').val()!='default')
    {
        var matchId = $('#matchSelect').val();
        showWaiting('Creating New Live Feed');
        $.post('http://b2.com/createFeed',{match:matchId},function(data)
        {
            closeWaiting();
            $('#liveFeedsDiv').append(data);
            $('#newFeed').fadeIn();
            $('#createFeedDiv').hide();
        })
    }
    else
    {
        bootbox.alert('Please select a match');
    }
}

function stopFeed(fid)
{
    showWaiting('Stopping Feed');
    $.post('http://b2.com/stopFeed',{feedId:fid},function(data)
    {
             closeWaiting();
             if(data=='Done')
             {
                 $('#feed' + fid).hide();
             }
              else
             {

             }
    });
}

function deleteFeed(fid)
{
    showWaiting('Deleting Feed');
    $.post('http://b2.com/deleteFeed',{feedId:fid},function(data)
    {
        closeWaiting();
        if(data=='Done')
        {
            $('#feed' + fid).hide();
        }
        else
        {

        }
    });
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
