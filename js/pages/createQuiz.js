var que = 0;
var oTableExistingQuestions=null;
var datatable = 0;
$(document).ready(function()
{
    var height = $(window).height();
    $("#questionsDisplay").css("max-height",""+(height-100)+"px");
    $("#questionsContainer").css("min-height",""+(height-100)+"px");


    $('#maqForm').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="maqSubmit"]',
        message: 'This value is not valid',
        fields: {
            maqQuestion: {
                validators: {
                    notEmpty: {
                        message: 'This field cannot be empty.'
                    },
                    stringLength:{
                        min: 10,
                        max: 500,
                        message: 'Min 10 and max 500 characters.'
                    }
                }
            },
            maqOption1: {
                validators: {
                    notEmpty: {
                        message: 'This field cannot be empty.'
                    }
                }
            },
            maqOption2: {
                validators: {
                    notEmpty: {
                        message: 'This field cannot be empty.'
                    }
                }
            },
            maqOption3: {
                validators: {
                    notEmpty: {
                        message: 'This field cannot be empty.'
                    }
                }
            },
            maqOption4: {
                validators: {
                    notEmpty: {
                        message: 'This field cannot be empty.'
                    }
                }
            },
            'answers[]': {
                validators: {
                    choice: {
                        min: 2,
                        max: 3,
                        message: 'Min 2 and max 3 boxes must be ticked.'
                    }
                }
            }
        }
    });

    $('#saqForm').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="saqSubmit"]',
        message: 'This value is not valid',
        fields: {
            saqQuestion: {
                validators: {
                    notEmpty: {
                        message: 'This field cannot be empty.'
                    },
                    stringLength:{
                        min: 10,
                        max: 500,
                        message: 'Min 10 and max 500 characters.'
                    }
                }
            },
            saqOption1: {
                validators: {
                    notEmpty: {
                        message: 'This field cannot be empty.'
                    }
                }
            },
            saqOption2: {
                validators: {
                    notEmpty: {
                        message: 'This field cannot be empty.'
                    }
                }
            },
            saqOption3: {
                validators: {
                    notEmpty: {
                        message: 'This field cannot be empty.'
                    }
                }
            },
            saqOption4: {
                validators: {
                    notEmpty: {
                        message: 'This field cannot be empty.'
                    }
                }
            },
            answer:{
                validators:{
                    notEmpty:{
                        message:'An answer must be specified.'
                    }
                }
            }
        }
    });

    $('#tfqForm').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="tfqSubmit"]',
        message: 'This value is not valid',
        fields: {
            tfqQuestion: {
                validators: {
                    notEmpty: {
                        message: 'This field cannot be empty.'
                    },
                    stringLength:{
                        min: 10,
                        max: 500,
                        message: 'Min 10 and max 500 characters.'
                    }
                }
            },
            choice:{
                validators:{
                    notEmpty:{
                        message:'An answer must be specified.'
                    }
                }
            }
        }
    });

    $('#maqForm').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
    });
    $('#saqForm').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
    });
    $('#tfqForm').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
    });
});

function maq()
{
    $(".questions").hide();
    $("#maqDiv").fadeIn();
}

function saq()
{
    $(".questions").hide();
    $("#saqDiv").fadeIn();
}

function tfq()
{
    $(".questions").hide();
    $("#tfqDiv").fadeIn();
}

function submitMaq()
{
    if($('#maqForm').data('bootstrapValidator').isValid())
    {
        var i;
        var ans = 0;
        var allVals = [];
        var string = "";
        var question = $("#maqQuestion").val();
        var option1 = $("#maqOption1").val();
        var option2 = $("#maqOption2").val();
        var option3 = $("#maqOption3").val();
        var option4 = $("#maqOption4").val();
        $('input[name="answers[]"]:checked').each(function()
        {
            allVals.push($(this).val());
        });
        $("#questionsDisplay").append("<div class='col-lg-9 Question"+(++que)+"'><br><strong>Question:</strong><br><p id='que"+que+"' class='maq'>"+question+"</p><strong>A.</strong><input type='checkbox' id='ans"+que+""+(++ans)+"' value='"+option1+"' disabled>"+option1+"<br><strong>B.</strong><input type='checkbox' id='ans"+que+""+(++ans)+"' value='"+option2+"' disabled>"+option2+"<br><strong>C.</strong><input type='checkbox' id='ans"+que+""+(++ans)+"' value='"+option3+"' disabled>"+option3+"<br><strong>D.</strong><input type='checkbox' id='ans"+que+""+(++ans)+"' value='"+option4+"' disabled>"+option4+"<br><strong>Answers:</strong></div><div class='col-lg-3'><br class='spaces"+que+"'><br class='spaces"+que+"'><br class='spaces"+que+"'><button id='RButton"+que+"' class='btn btn-danger' onclick='removeQue("+que+")'>Remove</button></div>");
        for (i=0; i<allVals.length; i++)
        {
            if (i==0)
                string = string+allVals[i];
            else
                string = string+", "+allVals[i];
        }
        $("#questionsDisplay").append("<div class=' col-lg-9 Question"+que+"'><p id='solution"+que+"'>"+string+"</p><br></div>");

        $("#maqQuestion").val("");
        $("#maqOption1").val("");
        $("#maqOption2").val("");
        $("#maqOption3").val("");
        $("#maqOption4").val("");
        $('input[name="answers[]"]').attr('checked', false);
        $("#maqQuestion").focus();
        $("#questionsDisplay").animate({ scrollTop: $('#questionsDisplay')[0].scrollHeight}, 1000);
        $("#quizSubmit").removeClass("disabled");
    }
}

function submitSaq()
{
    if($('#saqForm').data('bootstrapValidator').isValid())
    {
        var ans = 0;
        var allVals;
        var question = $("#saqQuestion").val();
        var option1 = $("#saqOption1").val();
        var option2 = $("#saqOption2").val();
        var option3 = $("#saqOption3").val();
        var option4 = $("#saqOption4").val();
        var answer = $('input[name="answer"]:checked');
            allVals = answer.val();
        $("#questionsDisplay").append("<div class='col-lg-9 Question"+(++que)+"'><br><strong>Question:</strong><br><p id='que"+que+"' class='saq'>"+question+"</p><strong>A.</strong><input type='radio' id='ans"+que+""+(++ans)+"' value='"+option1+"' disabled>"+option1+"<br><strong>B.</strong><input type='radio' id='ans"+que+""+(++ans)+"' value='"+option2+"' disabled>"+option2+"<br><strong>C.</strong><input type='radio' id='ans"+que+""+(++ans)+"' value='"+option3+"' disabled>"+option3+"<br><strong>D.</strong><input type='radio' id='ans"+que+""+(++ans)+"' value='"+option4+"' disabled>"+option4+"<br><strong>Answer: </strong></div><div class='col-lg-3'><br class='spaces"+que+"'><br class='spaces"+que+"'><br class='spaces"+que+"'><button id='RButton"+que+"' class='btn btn-danger' onclick='removeQue("+que+")'>Remove</button></div>");
        $("#questionsDisplay").append("<div class='col-lg-9 Question"+que+"'><p id='solution"+que+"'>"+allVals+"</p><br></div>");
        $("#saqQuestion").val("");
        $("#saqOption1").val("");
        $("#saqOption2").val("");
        $("#saqOption3").val("");
        $("#saqOption4").val("");
        $('input[name="answer"]').attr('checked', false);
        $("#saqQuestion").focus();
        $("#questionsDisplay").animate({ scrollTop: $('#questionsDisplay')[0].scrollHeight}, 1000);
        $("#quizSubmit").removeClass("disabled");
    }
}

function submitTfq()
{
    if($('#tfqForm').data('bootstrapValidator').isValid())
    {
        var ans = 0;
        var allVals;
        var question = $("#tfqQuestion").val();
        var answer = $('input[name="choice"]:checked');
        allVals = answer.val();
        $("#questionsDisplay").append("<div class='col-lg-9 Question"+(++que)+"'><br><strong>Question:</strong><br><p id='que"+que+"' class='tfq'>"+question+"</p><strong>A.</strong><input type='radio' id='ans"+que+""+(++ans)+"' value='true' disabled>True<br><strong>B.</strong><input type='radio' id='ans"+que+""+(++ans)+"' value='false' disabled>False<br><strong>Choice: </strong><input type='hidden' id='ans"+que+""+(++ans)+"' value='TheMonumentsMenGeorgeClooneyMattDamon'><input type='hidden' id='ans"+que+""+(++ans)+"' value='TheMonumentsMenGeorgeClooneyMattDamon'></div><div class='col-lg-3'><br class='spaces"+que+"'><br class='spaces"+que+"'><br class='spaces"+que+"'><button id='RButton"+que+"' class='btn btn-danger' onclick='removeQue("+que+")'>Remove</button></div>");
        $("#questionsDisplay").append("<div class='col-lg-9 Question"+que+"' <p id='solution"+que+"'>"+allVals+"</p><br></div>");
        $("#tfqQuestion").val("");
        $('input[name="choice"]').attr('checked', false);
        $("#tfqQuestion").focus();
        $("#questionsDisplay").animate({ scrollTop: $('#questionsDisplay')[0].scrollHeight}, 1000);
        $("#quizSubmit").removeClass("disabled");
    }
}

function quizSubmit()
{
    var i;
    var allQuestions = [];
    var option1 = [];
    var option2 = [];
    var option3 = [];
    var option4 = [];
    var correct1 = [];
    var correct2 = [];
    var correct3 = [];
    var correct4 = [];
    var count = 0;
    for (i=1; i<=que; i++)
    {
        var isPresent = $("#que"+i).html();
        if (isPresent)
        {
            count++;
            allQuestions.push($("#que"+i).html());
            option1.push($("#ans"+i+"1").val());
            option2.push($("#ans"+i+"2").val());
            option3.push($("#ans"+i+"3").val());
            option4.push($("#ans"+i+"4").val());
            var solution = $("#solution"+i).html();
            var n = solution.search("A");
            if (n!=-1)
                correct1[count-1]=true;
            else
                correct1[count-1]=false;
            var n = solution.search("B");
            if (n!=-1)
                correct2[count-1]=true;
            else
                correct2[count-1]=false;
            var n = solution.search("C");
            if (n!=-1)
                correct3[count-1]=true;
            else
                correct3[count-1]=false;
            var n = solution.search("D");
            if (n!=-1)
                correct4[count-1]=true;
            else
                correct4[count-1]=false;
        }
    }
    var title = $('#quizTitle').val();
    var description = $('#quizDescription').val();
    var category = $('#quizCategory').val();
    var ifc = $('#quizIFC').val();
    var access = $('#quizAccess').val();
    var time=$('#quizTime').val();

    $.post('http://b2.com/createQuiz',
        {
            count: count,
            questions: allQuestions,
            option1: option1,
            option2: option2,
            option3: option3,
            option4: option4,
            correct1: correct1,
            correct2: correct2,
            correct3: correct3,
            correct4: correct4,
            title: title,
            description: description,
            category: category,
            ifc: ifc,
            access: access,
            time:time
        },function(data)
        {
            if(data=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                bootbox.alert("Done! Check your quiz dashboard for latest stats!", function() {
                    window.location='http://b2.com/quizDashboard';
                });
            }
        });
}

function showExistingQuestions()
{
    $('#existingQuestionsModal').modal('show');
    if (datatable == 0)
    {
        var id = $('#quizid').val();
        oTableExistingQuestions=$('#existingQuestionsTable').dataTable( {
            "ajax": 'http://b2.com/getExistingQuizQuestionsData/'+id,
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
        } );
        datatable++;
    }
}

function removeExistingQuestion(bid,id)
{
    bootbox.confirm("Are you sure?", function(result) {
        if (result == true)
        {
            $.post('http://b2.com/removeExistingQuestion', {id: id}, function(error)
            {
                if(error=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                {
                    var row = $(bid).closest("tr").get(0);
                    oTableExistingQuestions.fnDeleteRow(oTableExistingQuestions.fnGetPosition(row));
                }
            });
        }
    });
}

function editExistingQuestion(id)
{
    $.post('http://b2.com/editExistingQuestion', {id: id}, function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#editExistingQuestionBody').html(markup);
            $('#editExistingQuestionModal').modal('show');

            $('#maqEditForm').bootstrapValidator({
                live:'enabled',
                submitButtons: 'button[id="maqEditSubmit"]',
                message: 'This value is not valid',
                fields: {
                    maqEditQuestion: {
                        validators: {
                            notEmpty: {
                                message: 'This field cannot be empty.'
                            },
                            stringLength:{
                                min: 10,
                                max: 500,
                                message: 'Min 10 and max 500 characters.'
                            }
                        }
                    },
                    maqEditOption1: {
                        validators: {
                            notEmpty: {
                                message: 'This field cannot be empty.'
                            }
                        }
                    },
                    maqEditOption2: {
                        validators: {
                            notEmpty: {
                                message: 'This field cannot be empty.'
                            }
                        }
                    },
                    maqEditOption3: {
                        validators: {
                            notEmpty: {
                                message: 'This field cannot be empty.'
                            }
                        }
                    },
                    maqEditOption4: {
                        validators: {
                            notEmpty: {
                                message: 'This field cannot be empty.'
                            }
                        }
                    },
                    'maqEditAnswers[]': {
                        validators: {
                            choice: {
                                min: 2,
                                max: 3,
                                message: 'Min 2 and max 3 boxes must be ticked.'
                            }
                        }
                    }
                }
            });

            $('#saqEditForm').bootstrapValidator({
                live:'enabled',
                submitButtons: 'button[id="saqEditSubmit"]',
                message: 'This value is not valid',
                fields: {
                    saqEditQuestion: {
                        validators: {
                            notEmpty: {
                                message: 'This field cannot be empty.'
                            },
                            stringLength:{
                                min: 10,
                                max: 500,
                                message: 'Min 10 and max 500 characters.'
                            }
                        }
                    },
                    saqEditOption1: {
                        validators: {
                            notEmpty: {
                                message: 'This field cannot be empty.'
                            }
                        }
                    },
                    saqEditOption2: {
                        validators: {
                            notEmpty: {
                                message: 'This field cannot be empty.'
                            }
                        }
                    },
                    saqEditOption3: {
                        validators: {
                            notEmpty: {
                                message: 'This field cannot be empty.'
                            }
                        }
                    },
                    saqEditOption4: {
                        validators: {
                            notEmpty: {
                                message: 'This field cannot be empty.'
                            }
                        }
                    },
                    saqEditAnswer:{
                        validators:{
                            notEmpty:{
                                message:'An answer must be specified.'
                            }
                        }
                    }
                }
            });

            $('#tfqEditForm').bootstrapValidator({
                live:'enabled',
                submitButtons: 'button[id="tfqEditSubmit"]',
                message: 'This value is not valid',
                fields: {
                    tfqEditQuestion: {
                        validators: {
                            notEmpty: {
                                message: 'This field cannot be empty.'
                            },
                            stringLength:{
                                min: 10,
                                max: 500,
                                message: 'Min 10 and max 500 characters.'
                            }
                        }
                    },
                    tfqEditChoice:{
                        validators:{
                            notEmpty:{
                                message:'An answer must be specified.'
                            }
                        }
                    }
                }
            });
        }
    });
}

function submitEdit(id,type)
{
    if (type == 'saq')
    {
        var question = $('#saqEditQuestion').val();
        var option1 = $('#saqEditOption1').val();
        var option2 = $('#saqEditOption2').val();
        var option3 = $('#saqEditOption3').val();
        var option4 = $('#saqEditOption4').val();
        var answer = $('input[name="saqEditAnswer"]:checked').val();
    }
    else if (type == 'maq')
    {
        var question = $('#maqEditQuestion').val();
        var option1 = $('#maqEditOption1').val();
        var option2 = $('#maqEditOption2').val();
        var option3 = $('#maqEditOption3').val();
        var option4 = $('#maqEditOption4').val();
        var answer = [];
        $('input[name="maqEditAnswers[]"]:checked').each(function()
        {
            answer.push($(this).val());
        });
    }
    else if (type == 'tfq')
    {
        var question = $('#tfqEditQuestion').val();
        var answer = $('input[name="tfqEditChoice"]:checked').val();
        var option1 = null;
        var option2 = null;
        var option3 = null;
        var option4 = null;
    }

    $.post('http://b2.com/updateQuizQuestion', {id: id, question: question, answer: answer, option1: option1, option2: option2, option3: option3, option4: option4}, function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            bootbox.alert("Saved successfully.", function() {
                $('#editExistingQuestionModal').modal('hide');
                oTableExistingQuestions.dataTable().fnDestroy();
                var id = $('#quizid').val();
                oTableExistingQuestions=$('#existingQuestionsTable').dataTable( {
                    "ajax": 'http://b2.com/getExistingQuizQuestionsData/'+id,
                    "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
                } );
            });
        }
    });
}

function removeQue(id)
{
    bootbox.alert('Are you sure?', function(response)
    {
        $('.Question'+id).html('');
        $('#RButton'+id).hide();
        $('.spaces'+id).hide();
    });
}