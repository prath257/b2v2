/**
 * Created by bbarters on 30-11-2014.
 */
//this function is called when League is selecteed
var submitted=true;
var leagueId=null;
var matchDay=null;
var predictionPercent=null;
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

//these are the variables related to action center
var typeSession= 0;
var noOfInterests = $('#noOfInterests').val();
noOfInterests = parseInt(noOfInterests);
var noOfActions = 6;
/*var focusAction = false;*/
var ajaxOk=true;     // to enable the ajax call when the mouse moves away from the div
var searching=true;
var ajaxOk2=true;   //to enable ajax call when the focus is moved away from input search boc
var tmr=null;
var loggedout = false;

var intCount=[];
intCount[0] = 3;
for (i=1; i<noOfInterests; i++)
{
    intCount[i] = 0;
}

$(document).ready(function()
{
    width = $(window).width();
    if(width <365)
    {
        $('#loadActions').css({"font-size":"13px"});
        if(width < 322)
        {
            $("#headRow").css({"padding":"0px"});
        }
    }
    else if(width >768 )
    {
        $('#sapLogo').hide();
        if(width > 991)
        {
            $('#smallDiv').hide();
        }
    }


    $('#ActionCentre').height($(window).height() * 0.9);
    window.onbeforeunload = function(e) {
        if (submitted == false)
            return 'Any unsaved changes will be lost.';
    };
    //this is for scrolling up and hiding search reasults
    $(document).click(function (e)
    {

        if ($(e.target).is('#searchResult'))
        {
            //do nothing
        }
        else if($(e.target).is('#searchFriend'))
        {
            $('body,html').animate({ scrollTop: 300}, 500);
            $('#searchResult').html('');
            $('#searchResult').hide();

        }
        else if($(e.target).is('#homesearchPlayer,#awaysearchPlayer,#searchPandC'))
        {
            $('#scorerModal').animate({ scrollTop: 300}, 500);
            $('#homesearchResult').html('');
            $('#homesearchResult').hide();
            $('#awaysearchResult').html('');
            $('#awaysearchResult').hide();
        }
        else
        {
            $('#searchResult').html('');
            $('#searchResult').hide();
            $('#homesearchResult').html('');
            $('#homesearchResult').hide();
            $('#awaysearchResult').html('');
            $('#awaysearchResult').hide();
            $('#filterdiv').slideUp(300);
        }
    });
    actionAjax();
    loadActionCenter();
});

function myPredictions(tipo,title)
{
    if(submitted==false)
    {
        bootbox.confirm('Match Predictions not submitted! Are you sure want to proceed?',function(result)
        {
            if(result==true)
            {
                submitted=true;
                $('#statsView').hide();
                $('.barterHeader').html(title);
                $.post('http://b2.com/createSchedule', {type: tipo}, function (data) {
                    $('#mainTask').html(data);
                    $('#mainTask').fadeIn();
                });
            }
        });
    }
    else
    {
        $('#statsView').hide();
        $('.barterHeader').html(title);
        $.post('http://b2.com/createSchedule', {type: tipo}, function (data) {
            $('#mainTask').html(data);
            $('#mainTask').fadeIn();
        });
    }
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
                    $.post('http://b2.com/getMatches', {league: leagueId, matchday: matchDay}, function (data)
                    {
                        closeWaiting();
                        $('#matchdaySchedule').html(data);
                        if($('#nopredict').val()=='no')
                             submitted=true;
                        else
                           submitted=false;
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

    bootbox.confirm('Are you sure want to lock your prediction?',function(result) {
        if (result == true)
        {
                $('#check' + mid).hide();
                $('#done' + mid).fadeIn();
                $('#hg' + mid).attr('disabled', true);
                $('#ag' + mid).attr('disabled', true);
                $('#saveLink' + mid).hide();
                $('#clear'+mid).fadeIn();
        }
    });
}

function clearPrediction(mid)
{
    bootbox.confirm("Are you sure want to redo the prediction?",function(result)
    {
        if(result==true)
        {
            var data=predict.predictions;
            var result = data.filter(function(x){return x.match !== mid; });
            predict.predictions=result;
            $('#done' + mid).hide();
            $('#check' + mid).fadeIn();
            $('#check'+mid).prop('checked', false); // Unchecks it
            $('#hg' + mid).attr('disabled',true);
            $('#ag' + mid).attr('disabled', true);
            $('#hg'+mid).val('0');
            $('#ag'+mid).val('0');
            $('#clear'+mid).hide();
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
        bootbox.confirm('Are you sure want to save your predictions?', function (result) {
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
                $('#clear'+mid).fadeIn();

            }

        });
    }

}

function submitPredictions()
{
    if(predict.predictions.length==0)
    {
        bootbox.alert('No predictions to submit!');
    }
    else
    {
        bootbox.confirm('Are you sure want to submit your predictions? You wont be able to change them later!s', function (result) {
            if (result == true)
            {
                submitted = true;
                $('#submitPredictions').hide();
                $('#savingImg').fadeIn();
                predict.league = leagueId;
                predict.matchday = matchDay;
                showWaiting('Submitting Predictions');
                $.post('http://b2.com/saveMatchPredictions', {predictions: JSON.stringify(predict)}, function (data) {
                    if (data == 'Success') {
                        closeWaiting();
                        window.location = 'http://b2.com/soccerSpace'
                    }
                });
            }

        });
    }
}

//this are the functions for get results use case
function getResults(title)
{
    if(submitted==false)
    {
        bootbox.confirm('Match Predictions not submitted! Are you sure want to proceed?',function(result)
        {
            if(result==true)
            {
                submitted=true;
                $('#statsView').hide();
                $('.barterHeader').html(title);
                showWaiting('Loading Results');
                $.post('http://b2.com/getResultsView', {type: null}, function (data) {
                    $('#mainTask').fadeIn();
                    $('#mainTask').html(data);
                    oTable1 = $('#scoreResults').dataTable({
                        "ajax": 'http://b2.com/getScoreResults',
                        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
                    });
                    oTable2 = $('#scorerResults').dataTable({
                        "ajax": 'http://b2.com/getScorerResults',
                        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
                    });


                });
                closeWaiting();
            }
        });
    }
    else
    {
        $('#statsView').hide();
        $('.barterHeader').html(title);
        showWaiting('Loading Results');
        $.post('http://b2.com/getResultsView', {type: null}, function (data) {
            $('#mainTask').fadeIn();
            $('#mainTask').html(data);
            oTable1 = $('#scoreResults').dataTable({
                "ajax": 'http://b2.com/getScoreResults',
                "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
            });
            oTable2 = $('#scorerResults').dataTable({
                "ajax": 'http://b2.com/getScorerResults',
                "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
            });


        });
        closeWaiting();
    }
}


 function getFriendsPredictions()
 {

         $('#statsView').hide();
         if ($('#matchSelect').val() != 'default') {
             matchId = $('#matchSelect').val();
             showWaiting('Loading Friends Predictions');
             $.post('http://b2.com/getFriendsPredictions', {matchId: matchId, friend: 0}, function (data) {
                 closeWaiting();
                 $('#matchdaySchedule').html(data);

             });
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

function playerCommentsUp(hs,as,side)
{

    playerSearchTimer = setTimeout(function()
    {
        var player = $('#'+side+'searchPlayer').val();
        if(player.length>0)
           searchPlayer(player,hs,as,side);
        else
            $('#'+side+'searchResult').hide();
    }, 500);
}

function searchPlayer(val,hs,as,side)
{
    $('#'+side+'searchResult').html('<div style="text-align: center"><img src="http://b2.com/Images/icons/waiting.gif"></div>');
    $('#'+side+'searchResult').show();

    $.post('http://b2.com/searchScorer', {player: val, homeSide:hs, awaySide:as,type:side}, function(markup)
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
            $('#homeList').append('<div class="col-xs-6 col-sm-6 col-md-6 chosenPlayer" onclick="removeHomePlayer(this,'+pid+')"><div class="col-xs-12"><br></div>'+name+'&nbsp;&nbsp;<i class="fa fa-times-circle" style="cursor: pointer"></i></div>');
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
            $('#awayList').append('<div class="col-xs-6 col-sm-6 col-md-6 chosenPlayer" onclick="removeAwayPlayer(this,'+pid+')"><div class="col-xs-12"><br></div>'+name+'&nbsp;&nbsp;<i class="fa fa-times-circle" style="cursor: pointer"></i></div>');

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
        else
        {
            $('#searchResult').fadeIn();
            $('#searchResult').html(markup);

        }
    });

}

function getUserData(pid)
{
        showWaiting('Loading Predictions');
        $.post('http://b2.com/getFriendsPredictions', {matchId: matchId, friend: pid}, function (data) {
            closeWaiting();
            if (data == 'No')
            {
                $('#empty').fadeIn();
                setTimeout(function () {
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

        });

}


//these are the functions for statistics
//this is the function to get the league stats
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

function getStatsView(title)
{
    if(submitted==false)
    {
        bootbox.confirm('Match Predictions not submitted! Are you sure want to proceed?',function(result)
        {
            if(result==true)
            {
                submitted=true;
                $('.barterHeader').html(title);
                $('#mainTask').hide();
                $('#statsView').fadeIn();
            }
        });
    }
    else
    {
        $('.barterHeader').html(title);
        $('#mainTask').hide();
        $('#statsView').fadeIn();
    }
}

function getPredictStats()
{
    showWaiting('Loading Prediction Stats');
    $.post('http://b2.com/getPredictStats',{type:null},function(data)
    {
        closeWaiting();
        $('#statsMain').html(data);
        predictionPercent=Morris.Donut({
            element: 'predictPercent',
            data: [0,0]
        });
        requestData(5000, predictionPercent,'PredictPercent');

    });

}
function getLeagueStats()
{
    showWaiting('Loading League Stats');
    $.post('http://b2.com/getLeagueStats',{type:null},function(data)
    {
        closeWaiting();
        $('#statsMain').html(data);

    });

}

function getLeaderboard()
{
    showWaiting('Loading Leaderboard');
    $.post('http://b2.com/getLeaderboard',{type:null},function(data)
    {
        closeWaiting();
        $('#statsMain').html(data);
        oTable1=$('#leaderboardTable').dataTable( {
            "ajax": 'http://b2.com/getLeaderboardData',
            "lengthMenu": [[10, 100, 1000, -1], [10, 100, 1000, "All"]]
        } );
        requestData(5000, predictionPercent,'PredictPercent');

    });

}

//these are action center related methods
function loadMoreActions()
{
    $('#loadMoreActions').hide();
    $('#waitforactions').show();
    $.post('http://b2.com/loadMoreActions', {count: noOfActions}, function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#waitforactions').hide();
            $('#ActionContent').append(markup);
            var more = $('#moreActions'+noOfActions).val();
            more = parseInt(more);
            if (more != 0)
                $('#loadMoreActions').show();
            noOfActions += 10;
        }
    });
}

function okToAjax(type,vari)
{

    if(vari==1)
        ajaxOk=type;
    else
    {
        ajaxOk2=type;

        if (type == false)
        {
            $('#filterdiv').slideDown(300);

        }
    }
}

function actionAjax()
{
    $.ajax({
        type: "POST",
        url: "http://b2.com/getActionData",
        data:{type:typeSession},
        beforeSend :function()
        {
            ajaxOk=false;
        }
    }).done(function(data)
    {
        if(data=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {

            ajaxOk=true;
            if(typeSession==0)
            {
                $('#loadActions').html(data);
            }
            else
                $('#loadActions').prepend(data);
            $('.actionImages').height(50);
            noOfActions = 6;
            $('#showMoreAndWaitingActions').fadeIn();
            $('#loadMoreActions').show();
        }
    });
}

function loadActionCenter()
{
    var  timer = window.setInterval( function() {
        if(ajaxOk&&ajaxOk2)
        {
            actionAjax();
        }
    }, 5000);
}

function searchAction()
{
    var keywords=$('#searchPandC').val();
    var IN = $('#IN').val();
    var FILTER = $('#FILTER').val();

    if(keywords.length>0)
    {
        if(tmr!=null)
        {
            clearInterval(tmr);
        }

        tmr = window.setInterval( function() {

            if(searching)
            {
                var constraint = 'all';
                var request = 'home';

                $.ajax({
                    type: "POST",
                    url: "http://b2.com/searchAction",
                    data:{keywords: keywords, constraint: constraint, request: request, IN: IN, FILTER: FILTER},
                    beforeSend :function()
                    {
                        searching=false;
                        /*ajaxOk=false;
                         ajaxOk2=false;*/
                        $('#loadMoreActions').hide();
                        $('#loadActions').html("<div style='text-align:center'><img  src='Images/icons/waiting.gif'> Loading..</div>");
                    },
                    error:function (){
                        $('#loadActions').html('Error occured. Try searching another query.');
                        searching = true;
                        clearInterval(tmr);
                        tmr=null;
                        $.post('http://b2.com/failedSearch',{keywords: keywords},function(error){
                            if(error=='wH@tS!nTheB0x')
                                window.location='http://b2.com/offline';
                        });
                    }
                })
                    .done(function(data)
                    {
                        if(data=='wH@tS!nTheB0x')
                            window.location='http://b2.com/offline';
                        else if (data == 'error_occurred')
                        {
                            $('#loadActions').html('Error occured. Try searching another query.');
                            searching = true;
                            clearInterval(tmr);
                            tmr=null;
                            $.post('http://b2.com/failedSearch',{keywords: keywords},function(error){
                                if(error=='wH@tS!nTheB0x')
                                    window.location='http://b2.com/offline';
                            });
                        }
                        else
                        {
                            searching=true;

                            $('#loadActions').html(data);

                            clearInterval(tmr);
                            tmr=null;
                        }
                    })
            }
        }, 1000);
    }
    else
    {
        /*        ajaxOk=true;
         ajaxOk2=true;*/
        actionAjax();
    }
}

function clearSearchInterval()
{
    clearInterval(tmr);
}




