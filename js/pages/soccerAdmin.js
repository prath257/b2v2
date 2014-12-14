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
    bootbox.confirm('Are you sure want to save final scores, you wont be able to change them later!',function(result)
    {
        if(result==true)
        {
            predict.league=leagueId;
            predict.matchday=matchDay;
            var scorerid=null;
            family = jsonQ(predict);
            var match = family.find('match',function(){
                return this == mid;
            });
            var hscorers = match.sibling('homescorers');
            for(i=1;i<=hg;i++) {
                scorerid=$('#homeScorer'+i).val();
                var scorer = {"pid":scorerid};
                hscorers.append(scorer);
            }
            var ascorers = match.sibling('awayscorers');
            for(i=1;i<=ag;i++) {
                scorerid=$('#awayScorer'+i).val();

                var scorer = {"pid":scorerid};
                ascorers.append(scorer);
            }
            $('#check'+mid).hide();
            $('#done'+mid).fadeIn();
            $('#hg'+mid).attr('disabled',true);
            $('#ag'+mid).attr('disabled',true);
            $('#saveLink'+mid).hide();
            $('#scorerModal').modal('hide');

        }

    });

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

