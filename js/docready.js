var height = $(window).height();
var width = $(document).width();
var navbarHeight = $('#navbar').height();
var totalMargin;
var PTheme;
var fcount=0;
var aboutCount = 0;
var oTableUnanswered=null;
var oTableAnswered=null;
var oTableAsked=null;
var qdes=0;
var timer=null;

var defaults = {
    animationDuration: 350,
    headerOpacity: 0.25,
    fixedHeaders: false,
    headerSelector: function (item) { return item.children("h3").first(); },
    itemSelector: function (item) { return item.children(".pivot-item"); },
    headerItemTemplate: function () { return $("<span class='header' />"); },
    pivotItemTemplate: function () { return $("<div class='pivotItem' />"); },
    itemsTemplate: function () { return $("<div class='items' />"); },
    headersTemplate: function () { return $("<div class='headers' />"); },
    controlInitialized: undefined,
    selectedItemChanged: undefined
};

var articleCount = 0;
var bookCount = 0;
var resourceCount = 0;
var pollQuizCount = 0;

var friendsCount = 12;
var subscribersCount = 6;
var subscriptionsCount = 6;

var userId = $("#profileId").val();
var interestId;

var loggedout = false;

var selectImgWidth,selectImgHeight,jcrop_api, boundx, boundy,isError=false;

var appendDiv;
$(document).ready(function()
{
    var request = $('#docreadyrequest').val();

    if (request == 'friendlist')
    {
        appendDiv=$('#appendFriends').html();
    }


    if (request == 'getinterests')
    {
        $("#interestsListOption").addClass("active");
        $("#interests").show();

        $(".newinterests").bootstrapSwitch({'onText':'Add', 'offText':'Nope'});
        $(".oldinterests").bootstrapSwitch({'onText':'Delete', 'offText':'Keep'});

        $(".interestType").bootstrapSwitch({'onText':'Pri.', 'offText':'Sec.'});
    }

    if (request == 'getaccount')
    {

        if ($(window).width() > 500)
        {
            $('#accountSettingsSubmit').css("position","fixed");
        }
        else
        {
            $('#ssformobile').html($('#settingsSaveContent').html());
            $('#settingsSaveContent').html('');
        }




        $("#accountSettingsForm").bootstrapValidator({
            live:'enabled',
            submitButtons:'button[id="accountSettingsSubmit"]',
            fields:{
                friendsIfc: {
                    validators: {
                        notEmpty: {
                            message: 'This field can/t be empty.'
                        }
                    }
                },
                subsIfc: {
                    validators: {
                        notEmpty: {
                            message: 'This field can/t be empty.'
                        }
                    }
                },
                chatIfc: {
                    validators: {
                        notEmpty: {
                            message: 'This field can/t be empty.'
                        }
                    }
                },
                aboutIfc: {
                    validators: {
                        notEmpty: {
                            message: 'This field can/t be empty.'
                        }
                    }
                },
                askIfc: {
                    validators: {
                        notEmpty: {
                            message: 'This field can/t be empty.'
                        }
                    }
                },
                subsDiscount: {
                    validators: {
                        notEmpty: {
                            message: 'This field can/t be empty.'
                        },
                        integer:{
                            message:'The value must be an integer'
                        },
                        between: {
                            min: 0,
                            max: 100,
                            message: 'The transfer amount must be between 0 to 100%'
                        }
                    }
                }
            }
        });

        $("#resetPasswordForm").bootstrapValidator({
            live:'enabled',
            submitButtons:'button[id="resetPasswordSubmit"]',
            fields:{
                existingPassword:{
                    validators:{
                        notEmpty:{
                            message:'This field cannot be empty'
                        }
                    }
                },
                newPassword: {
                    validators: {
                        notEmpty: {
                            message: 'The password is required and can\'t be empty'
                        },
                        regexp: {
                            regexp: /^\S{6,20}$/,
                            message: 'Min 6 letters, max 20, whitespaces not allowed'
                        }

                    }
                },
                retypePassword: {
                    validators: {
                        notEmpty: {
                            message: 'The confirm password is required and can\'t be empty'
                        },
                        identical: {
                            field: 'newPassword',
                            message: 'The password and its confirm are not the same'
                        }
                    }
                }
            }
        });


        $('#accountSettingsForm').submit(function(event)
        {

            /* stop form from submitting normally */
            event.preventDefault();
        });

        $('#resetPasswordForm').submit(function(event)
        {

            /* stop form from submitting normally */
            event.preventDefault();
        });

        $("[name='notification-checkbox']").bootstrapSwitch();
        $("[name='freeforfriends-checkbox']").bootstrapSwitch();


    }

    if (request == 'qna')
    {
        var width = $(document).width();
        if (width<=800)
        {
            $(".table").addClass("table-bordered");
        }

        var userId = document.getElementById('profileId').value;
        oTableAnswered=$('#answeredQuestions').dataTable( {
            "ajax": 'http://b2.com/answeredQuestions/'+userId,
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
        } );

        oTableAsked=$('#askedQuestions').dataTable( {
            "ajax": 'http://b2.com/askedQuestions/'+userId,
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
        } );

        oTableUnanswered=$('#unansweredQuestions').dataTable( {
            "ajax": 'http://b2.com/unansweredQuestions/'+userId,
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
        } );

        $("#questionForm").bootstrapValidator(
            {
                live:'enabled',
                submitButtons: 'button[id="questionSubmit"]',
                message: 'This value is not valid',
                fields:{
                    question:{
                        validators:{
                            notEmpty:{
                                message: "This field cannot be empty"
                            },
                            stringLength: {
                                min:10,
                                max:300,
                                message: 'Min 10 characters, Max 300 characters.'
                            }
                        }
                    }
                }
            }
        );

        $('#questionForm').submit(function(event)
        {

            /* stop form from submitting normally */
            event.preventDefault();
        });
    }
});

//Ask
function askQuestion()
{
    var minqifc = $("#minqifc").val();
    minqifc = parseInt(minqifc);
    $.post('http://b2.com/getIFCs', function(userIFC)
    {
        if(userIFC=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            userIFC = parseInt(userIFC);
            if (minqifc>userIFC)
            {
                $("#unsufficientIFC").html(minqifc);
                $("#unsufficientIFCModal").modal('show');
            }
            else
            {
                $('#summernote').summernote({
                    height:200,
                    toolbar: [
                        //[groupname, [button list]]

                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']]
                    ]
                });
                $("#access").bootstrapSwitch({'onText':'Public', 'offText':'Private'});
                $('#summernote').code('Explain your question here:');
                $("#questionModal").modal('show');
            }
        }
    });
}

function searchFriends(search)
{
    if(search)
    {
        if($('#loadMoreFriends').html())
        {
            $('#loadMoreFriends').hide();
        }

        var searchWord=$('#searchfriends').val();

        /* $.get("http://b2.com/srFriends",{searchWord:searchWord,search:search},function(data)
         {
         $('#appendFriends').html(data);
         });*/

        $.ajax({
            type: "POST",
            url: "http://b2.com/srFriends",
            data: {searchWord:searchWord,search:search},
            beforeSend: function()
            {
                $("#loadingImage").show();
            }
        }).done(function(data)
        {
            if(data=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                $('#appendFriends').html(data);
                $("#loadingImage").hide();
            }
        });

    }
    else
    {
        $('#appendFriends').html(appendDiv);

        if($('#loadMoreFriends').html())
        {
            $('#loadMoreFriends').show();
        }
    }



}




function checkKey()
{
    var searchWord=$('#searchfriends').val();

    if(searchWord.length==0)
    {

        if(timer!=null)
        {
            clearInterval(timer);
            timer=null;
        }

        searchFriends(false);
    }
    else
    {
        if(timer!=null)
        {
            clearInterval(timer);
            timer=null;
        }
        timer = window.setInterval( function() {

            searchFriends(true);

            clearInterval(timer);
            timer=null;

        }, 500);

    }
}

function writeDescription()
{
    if(qdes==0)
    {
        $('#divDes').fadeIn();
        $('#desLink').html('Remove Description');
        qdes=1;
    }
    else
    {
        $('#divDes').fadeOut();
        $('#desLink').html('Add Description');
        qdes=0;
    }
}

function postQuestion(userid)
{
    var question=$('#question').val();
    if(qdes==1)
    {
        var description=$('#summernote').code();
    }
    else
    {
        var description=null;
    }

    var questionIFC=$('#questionIFC').val();

    if ($('#access:checked').val() !== undefined)
        var access='public';
    else
        var access='private';

    if(question.length>9)
    {

        $.ajax({
            type: "POST",
            url: "http://b2.com/postQuestion",
            data: {question:question, description:description, questionIFC:questionIFC, userid:userid, access: access},
            beforeSend: function()
            {
                $('#questionSubmit').prop('disabled', true);
                $("#questionSubmit").hide();

                $("#waitingImg4").show();
            }

        }).done(function(error)
        {
            if(error=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                $("#questionSubmit").show();
                $("#waitingImg4").hide();

                $('#questionSubmit').prop('disabled', false);
                $('#questionModal').modal('hide');

                $('#summernote').code("");
                $('#questionSuccessfullyPostedModal').modal('show');
            }
        });
    }
}

function showDescription(id)
{
    $.post('http://b2.com/getDescription',{id: id},function(description)
    {
        if(description=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $("#readDescriptionContent").html(description);
            $("#readDescriptionModal").modal('show');
        }
    });
}

function showAnswer(id)
{
    $.post('http://b2.com/getAnswer',{id: id},function(answer)
    {
        if(answer=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $("#readAnswerContent").html(answer);
            $("#readAnswerModal").modal('show');
        }
    });
}

function writeAnswer(questionid,question)
{
    $.post('http://b2.com/getAnswerBox',{id: questionid}, function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $("#answerContent").html("<b>Question: </b>"+question+"<br><br>");
            $("#answerContent").append(markup);
            $("#summernote"+questionid).summernote({
                height:250,
                onkeydown: function(e) {
                    checkCharactersAnswer(questionid);
                },
                onpaste: function(e) {
                    checkCharactersAnswer(questionid);
                },
                toolbar: [
                    //[groupname, [button list]]

                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture','video']]
                ]
            });
            $("#answerModal").modal('show');
        }
    });
}

function checkCharactersAnswer(id)
{
    var content = $('#summernote'+id).code();
    if (content.length <= 39)
    {
        $("#error-box"+id).html("<strong>Too Short</strong>");
        $('#postAnswer'+id).prop('disabled', true);
    }
    else
    {
        $("#error-box"+id).html("");
        $('#postAnswer'+id).prop('disabled', false);
    }
}

function cancelAnswer()
{
    $("#answerModal").modal('hide');
}

function postAnswer(answerid)
{
    var answer = $('#summernote'+answerid).code();

    if (answer.length <= 39)
    {
        $("#error-box"+answerid).html("<strong>Too Short</strong>");
        $('#postAnswer'+answerid).prop('disabled', true);
    }
    else
    {
        $("#error-box"+answerid).html("");

        $.ajax({
            type: "POST",
            url: "http://b2.com/postAnswer",
            data: {answer:answer, id:answerid},
            beforeSend: function()
            {
                $('#postAnswer'+answerid).prop('disabled', true);
                $('#postAnswer'+answerid).hide();
                $("#waitingImg5").show();
            }
        }).done(function(userId)
        {
            if(userId=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                $("#answerModal").modal('hide');
                $("#answerSuccessfullyPostedModal").modal('show');

                $('#postAnswer'+answerid).prop('disabled',false);
                $('#postAnswer'+answerid).show();
                $("#waitingImg5").hide();

                var userId = $('#profileId').val();
                userId = parseInt(userId);
                var bid = $('#Button'+answerid);
                var row = $(bid).closest("tr").get(0);
                oTableUnanswered.fnDeleteRow(oTableUnanswered.fnGetPosition(row));
                oTableAnswered.dataTable().fnDestroy();
                oTableAnswered=$('#answeredQuestions').dataTable( {
                    "ajax": 'http://b2.com/answeredQuestions/'+userId,
                    "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
                } );
            }
        });
    }
}

function declineAnswer(bid,declineid)
{
    bootbox.confirm("Sure? This question will be deleted.", function(result) {
        if (result==true)
        {
            $.ajax({
                type: "POST",
                url: "http://b2.com/declineAnswer",
                data: {id:declineid}
            }).done(function(error)
            {
                if(error=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                {
                    var row = $(bid).closest("tr").get(0);
                    oTableUnanswered.fnDeleteRow(oTableUnanswered.fnGetPosition(row));
                }
            });
        }
    });
}

function removeRequest(id)
{
    bootbox.confirm("Are you sure?", function(result) {
        if (result==true)
        {
            $.post("http://b2.com/declineFriend/"+id,{type:'kind'},function(error)
            {
                if(error=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                    $('#newRequest'+id).fadeOut();
            });
        }
    });
}

function cancelPendingRequest(id)
{
    bootbox.confirm("Are you sure?", function(result) {
        if (result==true)
        {
            $.post("http://b2.com/cancelRequest/"+id,{type:'kind'},function(error)
            {
                if(error=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                    $('#pendingRequest'+id).fadeOut();
            });
        }
    });
}

function acceptNewRequest(id)
{
    $.post("http://b2.com/acceptFriend/"+id,{type:'kind'},function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
            $('#newRequest'+id).fadeOut();
    });
}

function deleteFriend(id)
{
    bootbox.confirm("Are you sure?", function(result) {
        if (result==true)
        {
            $.post("http://b2.com/deleteFriend/"+id,{type:'kind'},function(error)
            {
                if(error=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                    $('#allFriends'+id).fadeOut();
            });
        }
    });
}

function loadMoreFriends()
{
    $.post('http://b2.com/loadMoreFriends', {friendsCount: friendsCount}, function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#appendFriends').append(markup);

            var remaining = $('#RemainingFriends'+friendsCount).val();
            remaining = parseInt(remaining);
            if (remaining == 0)
                $('#loadMoreFriends').hide();
            friendsCount += 6;
        }
    });
}

//SubscriberList
function deleteSubscription(id)
{
    bootbox.confirm("Are you sure want to cancel the subscription?", function(result)
    {
        if (result==true)
        {
            $.ajax({
                type: "POST",
                url: "http://b2.com/unSubscribe",
                data: {id: id}
            }).done(function(error)
            {
                if(error=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                    $('#allSubscriptions'+id).fadeOut();
            });
        }
    });
}

function loadMoreSubscribers()
{
    $.post('http://b2.com/loadMoreSubscribers', {subscribersCount: subscribersCount}, function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#appendSubscribers').append(markup);
            var remaining = $('#RemainingSubscribers'+subscribersCount).val();
            remaining = parseInt(remaining);
            if (remaining == 0)
                $('#loadMoreSubscribers').hide();
            $('body,html').animate({ scrollTop: $(document).height()}, 500);
            subscribersCount += 6;
        }
    });
}

function loadMoreSubscriptions()
{
    $.post('http://b2.com/loadMoreSubscriptions', {subscriptionsCount: subscriptionsCount}, function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#appendSubscriptions').append(markup);
            var remaining = $('#RemainingSubscriptions'+subscriptionsCount).val();
            remaining = parseInt(remaining);
            if (remaining == 0)
                $('#loadMoreSubscriptions').hide();
            $('body,html').animate({ scrollTop: $(document).height()}, 500);
            subscriptionsCount += 6;
        }
    });
}

//Settings JS
function showThumbnail(e)
{
    var rx = 155 / e.w; //155 is the width of outer div of your profile pic
    var ry = 190 / e.h; //190 is the height of outer div of your profile pic
    $('#w').val(e.w);
    $('#h').val(e.h);
    $('#w1').val(e.w);
    $('#h1').val(e.h);
    $('#x1').val(e.x);
    $('#y1').val(e.y);
    $('#x2').val(e.x2);
    $('#y2').val(e.y2);

}

function validateForm(){
    if ($('#profilePic').val()=='')
    {
        $('.error').html('<b>Please select an image</b>').fadeIn(500);
        return false;
    }
    else if(isError)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function updateAbout()
{
    $('#aboutForm').data('bootstrapValidator').validate();

    if($('#aboutForm').data('bootstrapValidator').isValid())
    {
        var aboutYou = $("#editAbout").val();
        $.post("http://b2.com/aboutYou",{about:aboutYou},function(data)
        {
            if(data=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
                $('#statusAbout').html(data);
        });
    }
}

function showCredentials()
{
    $(".switch-content").hide();
    $("#credentials").show();
    $("#credentialsListOption").addClass("active");

    $("#profilePictureListOption").removeClass("active");
    $("#profileTuneListOption").removeClass("active");
    $("#aboutYouListOption").removeClass("active");
    $("#interestsListOption").removeClass("active");
    $("#interestsTypeOption").removeClass("active");
}

function showProfilePicture()
{
    $(".switch-content").hide();
    $("#profilePicture").show();
    $("#profilePictureListOption").addClass("active");

    $("#credentialsListOption").removeClass("active");
    $("#profileTuneListOption").removeClass("active");
    $("#aboutYouListOption").removeClass("active");
    $("#interestsListOption").removeClass("active");
    $("#interestsTypeOption").removeClass("active");
};

function showProfileTune()
{
    $(".switch-content").hide();
    $("#profileTuneDiv").show();
    $("#profileTuneListOption").addClass("active");

    $("#credentialsListOption").removeClass("active");
    $("#profilePictureListOption").removeClass("active");
    $("#aboutYouListOption").removeClass("active");
    $("#interestsListOption").removeClass("active");
    $("#interestsTypeOption").removeClass("active");
}

function showAboutYou()
{
    $(".switch-content").hide();
    $("#aboutYou").show();
    $("#aboutYouListOption").addClass("active");

    $("#credentialsListOption").removeClass("active");
    $("#profilePictureListOption").removeClass("active");
    $("#profileTuneListOption").removeClass("active");
    $("#interestsListOption").removeClass("active");
    $("#interestsTypeOption").removeClass("active");
}

function showInterests()
{
    $(".switch-content").hide();
    $("#interests").show();
    $("#interestsListOption").addClass("active");

    $("#credentialsListOption").removeClass("active");
    $("#profilePictureListOption").removeClass("active");
    $("#profileTuneListOption").removeClass("active");
    $("#aboutYouListOption").removeClass("active");
    $("#interestsTypeOption").removeClass("active");
}

function showInterestType()
{
    $(".switch-content").hide();
    $("#interestType").show();
    $("#interestsTypeOption").addClass("active");

    $("#credentialsListOption").removeClass("active");
    $("#profilePictureListOption").removeClass("active");
    $("#profileTuneListOption").removeClass("active");
    $("#aboutYouListOption").removeClass("active");
    $("#interestsListOption").removeClass("active");
}

//These are my ajax calls

function _(el)
{
    return document.getElementById(el);
}
function changeProfilePic()
{

    $('#ppForm').data('bootstrapValidator').validate();

    if($('#ppForm').data('bootstrapValidator').isValid())
    {
        var file1 = _("profilePicChange").files[0];
        var x=$('#x1').val();
        var y=$('#y1').val();
        var w=$('#w').val();
        var h=$('#h').val();
        var formdata = new FormData();
        formdata.append("profilePicChange", file1);
        //formdata.append("profileTune", file2);
        formdata.append("x", x);
        formdata.append("y", y);
        formdata.append("w", w);
        formdata.append("h", h);
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandlerPic, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "http://b2.com/editProfilePic");
        ajax.send(formdata);

    }

}
function completeHandlerPic(event)
{
    var error = this.responseText;
    if(error=='wH@tS!nTheB0x')
        window.location='http://b2.com/offline';
    else
    {
        $('.error').html('Saved successfully.');
        $('.error').fadeIn();
        $('#uploadController').fadeOut();
    }
}

function displayTuneName()
{
    $("#tunename").html($("#profileTune").val());
    $("#changePT").hide();
    $("#ptsubmit").show();
}

function changeProfileTune()
{
    $('#ptForm').data('bootstrapValidator').validate();

    if($('#ptForm').data('bootstrapValidator').isValid())
    {
        var file2 = _("profileTune").files[0];
        var formdata = new FormData();
        formdata.append("profileTune", file2);
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandlerPT, false);
        ajax.addEventListener("load", completeHandlerTune, false);
        ajax.open("POST", "http://b2.com/editProfileTune");
        ajax.send(formdata);

    }

}

function completeHandlerTune(event)
{
    var error = this.responseText;
    if(error=='wH@tS!nTheB0x')
        window.location='http://b2.com/offline';
    else
    {
        $("#mytune").attr("src",this.responseText).trigger("play");
        $('#uploadControllerPT').fadeOut();
        //window.location='/editProfile';
    }
}
function progressHandler(event){
    var percent = (event.loaded / event.total) * 100;
    $('#uploadController').fadeIn();
    document.getElementById('progressBar').style.width = percent+'%';
}

function progressHandlerPT(event){
    var percent = (event.loaded / event.total) * 100;
    $('#uploadControllerPT').fadeIn();
    document.getElementById('progressBarPT').style.width = percent+'%';
}

function errorHandler(event)
{
    _("status").innerHTML = "Upload Failed";
}
function abortHandler(event)
{
    _("status").innerHTML = "Upload Aborted";
}

//this is the function to edit the user interests

function editInterests()
{
    var newVals = [];
    var oldVals=[];
    var i=0;
    var other=null;
    $('#newInterests :checked').each(function()
    {
        newVals.push($(this).val());
    });
    $('#oldInterests :checked').each(function()
    {
        oldVals.push($(this).val());
    });
    other=document.getElementById('other').value;
    if(newVals.length>0 || oldVals.length>0 || other!=null)
    {
        if(!other)
            other="None";
        $.post("http://b2.com/editInterests", {oldInterests: oldVals, newInterests:newVals,otheri:other},function(data)
        {
            if(data=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                if(data.length>0)
                {
                    $("#interests").html(data);
                    $(".newinterests").bootstrapSwitch({'onText':'Add', 'offText':'Nope'});
                    $(".oldinterests").bootstrapSwitch({'onText':'Delete', 'offText':'Keep'});
                    $('.ierror').css('background-color', '').css('background-color', 'green');
                    $('.ierror').html('Changes Saved Successfully').fadeIn(500);
                }
            }
        });
    }
    else
    {
        $('.ierror').html('Nothing to update!').fadeIn(500);
    }

}







function checkUname()
{
    $('#uerror').text('');
    var uname = $('#username').val();
    if(uname)
    {
        //ajax post the form
        $.post("http://b2.com/checkUsername",{username: uname},function(data)
        {
            if(data=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            if(data=='username already taken')
            {
                $('#uerror').text(data);
                $('#username').val('');
                $('#username').focus();
            }
        });
    }
}

function saveNewName()
{
    $('#newNameForm').data('bootstrapValidator').validate();

    if($('#newNameForm').data('bootstrapValidator').isValid())
    {
        var firstname = $("#firstname").val();
        var lastname = $("#lastname").val();
        if (firstname.length > 1 && document.getElementById('confirmNameChange').checked)
        {
            $.post("http://b2.com/saveNewName", {firstname: firstname, lastname: lastname}, function(error)
            {
                if(error=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                    $('#nameUpdatedSuccessfully').show();
            });
        }
    }
}

function saveAccountChanges()
{
    var profileTheme = $("#profileTheme").val();
    var friendcharges = $("#friendsIfc").val();
    var subcharges = $("#subsIfc").val();
    var chatcharges = $("#chatIfc").val();
    if (document.getElementById('notification-checkbox').checked)
        var notifications = 1;
    else
        var notifications = 0;
    var minaboutifc = $("#aboutIfc").val();
    var minqifc = $("#askIfc").val();
    if (document.getElementById('freeforfriends-checkbox').checked)
        var freeforfriends = 1;
    else
        var freeforfriends = 0;
    var discountforfollowers = $("#subsDiscount").val();

    $.post('http://b2.com/saveAccountSettings',
        {
            profileTheme: profileTheme,
            friendcost: friendcharges,
            subcost: subcharges,
            chatcost: chatcharges,
            notifications: notifications,
            minaboutifc: minaboutifc,
            minqifc: minqifc,
            freeforfriends: freeforfriends,
            discountforfollowers: discountforfollowers
        }, function(message)
        {
            if(message=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                bootbox.alert(message);
                /* $("#accountSettingsSubmit").html(message);
                setTimeout(function(){$("#accountSettingsSubmit").html('Save Changes')}, 3000);
                           $("#accountSettingsMessage").show();
                 $("#accountSettingsMessage").html("<strong>"+message+"</strong>");
                 $("#accountSettingsMessage").fadeOut(3000);*/
            }
        });
}

function resetPassword()
{
    var existingPassword = $("#existingPassword").val();
    var newPassword = $("#newPassword").val();
    var retypePassword = $("#retypePassword").val();

    if (newPassword == retypePassword)
    {
        $.post('http://b2.com/resetPassword', {existingPassword: existingPassword, newPassword: newPassword}, function(message)
        {
            if(message=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
                bootbox.alert(message);
            /*            $("#resetPasswordMessage").html("<strong>"+message+"</strong>")*/
        });
    }
}

//Add New Image
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
        $("#newImage").fadeIn();
        $("#newImageButton").hide();
        $("#postImageLoad").fadeIn();
        window.scrollTo(0, document.body.scrollHeight);
    }
}

$("#imgInp").change(function(){
    readURL(this);
});



function manageInterests()
{
    var primary = [];
    $('#manageInterests :checked').each(function()
    {
        primary.push($(this).val());
    });
    if(primary.length!=3)
    {
        $('.typeerror').show();
        $('.typeerror').html('<b>Select exact three of the above as your primary interests</b>');
    }
    else
    {
        $('.typeerror').html('');
        $.post("http://b2.com/manageInterests", {prime:primary},function(data)
        {
            if(data=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                $('.typeerror').show();
                $('.typeerror').html('<b>'+data+'</b>');
            }
        });
    }
}