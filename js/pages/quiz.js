var correctAnswers = 0;
var i =1;
var time;
var timer;

$(document).ready(function(){

    time=$('#tottime').val();

    timer = window.setInterval( function() {

        time--;
        var text = document.getElementById("timer");
        if(time<10)
        {
            text.style.color="red";
        }

        if(time==0)
        {
            submitQuiz();

        }

        text.innerHTML = ""+time;

    }, 1000);
});

function submitQuiz()
{
    clearInterval(timer);

    $('#quizSubmitButton').prop('disabled', true);
    /*  $("#quizSubmitButton").html("Loading.");*/
    /* timer = window.setInterval( function()
     {
     var text = document.getElementById("quizSubmitButton");*/
    /* if ( text.innerHTML.length > 9 )
     text.innerHTML = "Loading.";
     else
     text.innerHTML += ".";
     }, 750);*/

    $('#quizSubmitButton').hide();
    $('#waitingQuiz').show();
    checkAnswers();

}

function checkAnswers()
{

    var queCount = $("#queCount").val();
    queCount = parseInt(queCount);

    if (i<=queCount)
    {
        var qType = $("#qType"+i).val();
        var qId = $("#qId"+i).val();
        qId = parseInt(qId);
        if (qType=='maq')
        {
            var answer = [];
            $('input[name="answer'+i+'[]"]:checked').each(function()
            {
                answer.push($(this).val());
            });
        }
        else
            var answer = $('input[name="answer'+i+'"]:checked').val();
        $.post('http://b2.com/checkAns', {id: qId, answer: answer, type: qType}, function(correct)
        {
            if(correct=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                if (correct=='true')
                    correctAnswers++;
                i++;
                checkAnswers();
            }
        });
    }
    else
    {
        var quizId = $("#quizId").val();
        quizId = parseInt(quizId);
        $.post('http://b2.com/postQuizResults', {id: quizId, correct: correctAnswers}, function(data)
        {
            if(ifc=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                $('#resultBody').prepend(data);
                $('#resultModal').modal({
                    keyboard:false,
                    show:true,
                    backdrop:'static'
                });
                endTimer();
            }


        });
    }
}

function endTimer()
{
    /*clearInterval(timer);
     $('#quizSubmitButton').prop('disabled', false);
     $("#quizSubmitButton").html("Submit");*/
    $('#quizSubmitButton').show();
    $('#waitingQuiz').hide();
}