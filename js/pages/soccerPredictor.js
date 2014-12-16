/**
 * Created by bbarters on 30-11-2014.
 */
//this function is called when League is selected
var leagueId=null;
var matchDay=null;

var predict={"league":0,"matchday":0,"predictions":[]};
var family=null;
var width=0;

var oTable1=null;
var oTable2=null;

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
    bootbox.confirm('Are you sure want to save your predictions, you wont be able to change them later!',function(result)
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
         var mid=$('#matchSelect').val();
        showWaiting('Loading Friends Predictions');
         $.post('http://b2.com/getFriendsPredictions',{matchId:mid},function(data)
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


