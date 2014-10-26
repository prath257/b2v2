var height = $(window).height();
var width = $(document).width();
var navbarHeight = $('#navbar').height();
var totalMargin;
var PTheme;
var fcount=0;
var aboutCount = 0;
var oTableUnanswered=null;
var oTableAnswered=null;
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

var selectImgWidth,selectImgHeight,jcrop_api, boundx, boundy,isError=false;

var appendDiv;

$(document).ready(function()
{
    PTheme = $('#PTheme').val();

    $('#profileContainerDiv').height(height);

    if (PTheme == 'standard')
    {
        $('#profileDiv').height(height-45);
        if (width > 1200)
        {
            document.getElementById('PPPTdiv').style.marginTop = (height*0.3)+'px';
            $('#PPPTdiv').height(height-45-(height*0.3));
        }
        else
        {
            document.getElementById('PPPTdiv').style.marginTop = -(height*0.8)+'px';
            $('#PPPTdiv').height(height-45-(height*0.7));
            $('.socialButtons').addClass('col-lg-12');
            $('.socialButtons').removeClass('col-lg-4');
            $('.socialButtons').removeClass('col-lg-6');
            $('.socialButtons').removeClass('col-lg-offset-2');
            $('.newLine').show();
        }
    }
    else
    {
        if (width > 1200)
        {

        }
        else
        {
            $('.socialButtons').addClass('col-lg-12');
            $('.socialButtons').removeClass('col-lg-4');
            $('.socialButtons').removeClass('col-lg-6');
            $('.newLine').show();
        }
    }

    $('#interestsDiv').height(height-navbarHeight);
    document.getElementById('interestsDiv').style.marginTop = navbarHeight+'px';
    $('.Profileimages').width(250);
    $('.Profileimages').height(175);



    var secInt = $('#secondaryInterestsStatus').val();
    if (secInt == 'false')
        $('#secondaryInterestsHeader').hide();

    $('#bodyDiv').fadeIn();

    var PICOUNT = $("#PICOUNT").val();
    for (i=0; i<PICOUNT; i++)
        $('#carousel'+(i+1)).carousel({
            interval: ((i+1)*1000)+5000
        });

    var minHeight = $('#ifc-readerr').height();
    $('.ifc-readerr').height(minHeight+15);

    $(document).click(function(e){
        if ($(e.target).is('#foreignusercounter,#foreignusercounter *')) {
            //Do Nothing
        }
        else
        {
            $('#foreignusercounter').fadeOut();
        }
    });

    $(document).click(function(e){
        if ($(e.target).is('#mycounter,#mycounter *')) {
            //Do Nothing
        }
        else
        {
            $('#mycounter').fadeOut();
        }
    });


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

    $("#answerForm").bootstrapValidator(
        {
            live:'enabled',
            submitButtons: 'button[class="answerSubmit"]',
            message: 'This value is not valid',
            fields:{
                answer:{
                    validators:{
                        notEmpty:{
                            message: "A meaningful answer is required"
                        },
                        stringLength: {
                            min:2,
                            max:500,
                            message: 'The answer must be more than 2 and less than 500 characters long'
                        }
                    }
                }
            }
        }
    );

    $('#aboutForm').submit(function(event)
    {
        /* stop form from submitting normally */
        event.preventDefault();
    });

    $('#questionForm').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
    });

    $("#mycounter").flipCounterInit({'speed': 0.05});

    getChats();

    getIFCs();



    $(document).keyup(function(e) {
        if (e.keyCode == 27)
        {
            $('#searchfriends').val("");
              searchFriends(false);
        }

    });


});

//Function to play-pause the Profile tune
function playPause(btn)
{
    var audio=document.getElementById("pt");
    var ptButton=document.getElementById("ptButton");
    if(audio.paused == false)
    {

        $('#ptButton').removeClass('glyphicon-pause');
        $('#ptButton').addClass('glyphicon-music');
        audio.pause();
    }
    else
    {
        $('#ptButton').addClass('glyphicon-pause');
        $('#ptButton').removeClass('glyphicon-music');
        audio.play();
    }
}

function getChats()
{

    updateNotifications();
    getIFCs();
    getStatus();
    setTimeout(getChats,4000);

}
//notifications
/*function updateNotifications(){

    var notifyModalContent = $("#notifyText").html();
    if(notifyModalContent=="")
    {
        $.get('http://b2.com/getNotification',function(data)
        {
            if(data)
            {
                if (data != 'TheMonumentsMenGeorgeClooneyMattDamon')
                {
                    $("#notifyText").html(data);
                    $('#notifyModal').modal({
                        keyboard:false,
                        show:true,
                        backdrop:'static'
                    });
                }
            }
        });
    }
}*/

function getIFCs()
{
    $.post('http://b2.com/getIFCs', function(ifcs)
    {
        if(ifcs=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        $("#mycounter").flipCounterUpdate(ifcs);
    });
}


function closeAlert(string)
{
    if(string=='frequest')
    {
        $("#notifyModal").modal('hide');
        $("#extraText").hide();
        $(".adbuttons").removeClass("col-lg-12");
        $(".adbuttons:first-child").addClass("col-lg-5");
        $(".adbuttons:nth-child(2)").addClass("col-lg-6 col-lg-offset-1");
        $("#closeButton").hide();
        document.getElementById('newFriendRequestsContent').innerHTML += $("#fieldset").html();
        $("#notifyText").html("");
    }
    else if (string=='faccepted' || string=='qasked' || string=='qanswered' || string=='aboutrequest' || string=='aboutaccepted' || string=='subscription' || string=='chatrequest' || string=='chataccepted')
    {
        $("#notifyModal").modal('hide');
        $("#notifyText").html("");
    }
}

//Chat
function acceptChat(acid)
{
    $.ajax({
        type: "POST",
        url: "http://b2.com/acceptChat",
        data: {id:acid}
    }).done(function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            if (error)
            {
                $("#notifyText").append(error);
            }
            else
            {
                $.post('http://b2.com/getChatLink',{id: acid}, function(link)
                {
                    if(link=='wH@tS!nTheB0x')
                        window.location='http://b2.com/offline';
                    else
                    {
                        /*window.open('http://b2.com/chatRoom/'+link, '_blank', "height=400,width=270,resizable=false");*/
                        $("#notifyModal").modal('hide');
                        $("#notifyText").html("");
                        window.location='http://b2.com/chats/'+link;
                    }
                });
            }
        }
    });
}

function declineChat(dcid)
{
    bootbox.confirm("Are you sure?", function(result) {
        if (result==true)
        {
            $.ajax({
                type: "POST",
                url: "http://b2.com/declineChat",
                data: {id:dcid}
            }).done(function(error)
            {
                if(error=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                {
                    $("#notifyModal").modal('hide');
                    $("#notifyText").html("");
                }
            });
        }
    });

}

function startChat(scid)
{

    $.post('http://b2.com/getChatLink',{id: scid}, function(link)
    {
        if(link=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $("#notifyModal").modal('hide');
            $("#notifyText").html("");
            window.location='http://b2.com/chats/'+link;
        }
    });
}

var count = 1;
function showTrivia()
{

    if(($("#countImage").val())!=1)
    {
        count = ($(".slideshow :nth-child("+count+")").fadeOut().next().length == 0) ? 1 : count+1;
        $(".slideshow :nth-child("+count+")").fadeIn();
        setTimeout(showTrivia,4000);
    }
}

/*Follow-UnFollow / Friend-UnFriend functions*/
function follow(id1)
{

    $.ajax({
        type: "POST",
        url: "http://b2.com/addSubscribe",
        data: {id: id1},
        beforeSend: function()
        {
            $('#disableButton').prop('disabled', true);

            $('#confirmFollowButton').prop('disabled', true);
            $("#confirmFollowButton").hide();
            $("#waitingImg").show();

        }
    }).done(function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#disableButton').prop('disabled', false);

            $('#confirmFollowButton').prop('disabled', false);
            $("#confirmFollowButton").show();
            $("#waitingImg").hide();

            $('#FollowModal').modal('hide');

            $('#confirmFollowButton').prop('disabled', false);
            $("#confirmFollowButton").html("Sure");
            $('.follow').html('<span class="glyphicon glyphicon-minus-sign"></span> UnFollow');
            $('.follow').attr('id','UnFollow');
            $.post('http://b2.com/getIFCs', function(ifc)
            {
                if(ifcs=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                {
                    $("#foreignusercounter").fadeIn();
                    $("#foreignusercounter").flipCounterInit({'speed': 0.05});
                    $("#foreignusercounter").flipCounterUpdate(ifc);
                }
            });
        }
    });

}

function unfollow(id2)
{
    $.ajax({
        type: "POST",
        url: "http://b2.com/unSubscribe",
        data: {id: id2}
    }).done(function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#UnFollowModal').modal('hide');
            $('.follow').html('<span class="glyphicon glyphicon-pushpin"></span> Follow');
            $('.follow').attr('id','Follow');
            $('#subscription'+id2).slideUp();
        }
    });

}

function friend(id3)
{
    var reason = $("#friendreason").val();



    $.ajax({
        type: "POST",
        url: "http://b2.com/addFriend/"+id3,
        data: {reason:reason},
        beforeSend: function()
        {
            $('#disableButton2').prop('disabled', true);

            $('#friendreasonsubmit').prop('disabled', true);
            $("#friendreasonsubmit").hide();
            $("#waitingImg2").show();

        }
    }).done(function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#AddFriendModal').modal('hide');
            $(".friends").html('<span class="glyphicon glyphicon-remove"></span> CancelRequest');
            $('.friends').attr('id','CancelRequest');
            $('#friendreasonsubmit').prop('disabled', false);
            $("#friendreasonsubmit").html("Submit");

            $('#disableButton2').prop('disabled', false);

            $("#waitingImg2").hide();
            $("#friendreasonsubmit").show();
        }
    });


    /*$.post("http://b2.com/addFriend/"+id3,{reason:reason},function()
    {
        $('#AddFriendModal').modal('hide');
        $(".friends").html('<span class="glyphicon glyphicon-remove"></span> CancelRequest');
        $('.friends').attr('id','CancelRequest');

        $('#friendreasonsubmit').prop('disabled', false);
        $("#friendreasonsubmit").html("Submit");
    });

    */
}

function unfriend(id4)
{
    $.post("http://b2.com/deleteFriend/"+id4,{type:'kind'},function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#UnFriendModal').modal('hide');
            $(".friends").html('<span class="glyphicon glyphicon-plus-sign"></span> AddFriend');
            $(".friends").attr('id','AddFriend');
        }
    });

}

function cancelRequest(id5)
{

    $.post("http://b2.com/cancelRequest/"+id5,{type:'kind'},function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#CancelRequestModal').modal('hide');
            $(".friends").html("<span class='glyphicon glyphicon-plus-sign'></span> AddFriend");
            $('.friends').attr("id","AddFriend");
        }
    });

}

function acceptRequest(id6)
{
    $('#waitingSureButton').show();
    $('#sureButton').hide();
    $('#nopeButton').hide();
    $.post("http://b2.com/acceptFriend/"+id6,{type:'kind'},function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#waitingSureButton').hide();
            $('#sureButton').show();
            $('#nopeButton').show();
            $('#AcceptRequestModal').modal('hide');
            $(".friends:first-child").hide();
            $(".friends").html('<span class="glyphicon glyphicon-minus-sign"></span> UnFriend');
            $('.friends').attr('id','UnFriend');
            $('.friends').removeClass('col-lg-4');
            $('.follow').removeClass('col-lg-4');
            $('.friends').addClass('col-lg-6');
            $('.follow').addClass('col-lg-6');
        }
    });
}


function declineRequest(id7)
{

    $.post("http://b2.com/declineFriend/"+id7,{type:'kind'},function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#DeclineRequestModal').modal('hide');
            $(".friends:first-child").hide();
            $("#toHideLine").hide();
            $(".friends").html('<span class="glyphicon glyphicon-plus-sign"></span> AddFriend');
            $(".friends").attr('id','AddFriend');
            $('.friends').removeClass('col-lg-4');
            $('.follow').removeClass('col-lg-4');
            $('.friends').addClass('col-lg-6');
            $('.follow').addClass('col-lg-6');
        }
    });

}

/*Follow-UnFollow / Friend-UnFriend functions end*/

/*Functions for opening addFriend/unfirend/follow/unfollow modals as per request*/
function openModal(button)
{
    if (button.id=='Follow')
    {
        var subcost = $("#subcost").val();
        subcost = parseInt(subcost);
        $.post('http://b2.com/getIFCs', function(userIFC)
        {
            if(userIFC=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                if (subcost>userIFC)
                {
                    $("#unsufficientIFC").html(subcost);
                    $("#unsufficientIFCModal").modal('show');
                }
                else
                {
                    $("#"+button.id+"Modal").modal('show');
                }
            }
        });
    }
    else if (button.id=='AddFriend')
    {
        var friendcost = $("#friendcost").val();
        friendcost = parseInt(friendcost);
        $.post('http://b2.com/getIFCs', function(userIFC)
        {
            if(userIFC=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                if (friendcost>userIFC)
                {
                    $("#unsufficientIFC").html(friendcost);
                    $("#unsufficientIFCModal").modal('show');
                }
                else
                {
                    $("#"+button.id+"Modal").modal('show');
                }
            }
        });
    }
    else
    {
        $("#"+button.id+"Modal").modal('show');
    }


}
/*End of functions for opening addFriend/unfirend/follow/unfollow modals as per request*/

function earnIFC()
{
    window.location = "http://b2.com/ifcDeficit";
}


//this is the function to update user status
/*function getStatus()
{
    var uid=$('#profileId').val();
    $.post('http://b2.com/getStatus',{id:uid},function(data)
    {
        if (data=="yesBwoy")
        {
            $("#chatStatus").html("<figure id='online' class='circle'></figure>");
        }
        else if (data=="nopeBwoy")
        {
            $("#chatStatus").html("<figure id='offline' class='circle'></figure>");
        }
    });
}*/

function showSettings()
{
    scrollDown();
    $('.bottomButtons').css({"backgroundColor":"#222","borderColor":"#222"});


    $.post('http://b2.com/settings', function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#interestsDiv').hide();
            $('#profileContainerDiv').hide();
            $('body,html').animate({ scrollTop: 0}, 0);

            $('#contentDiv').html(markup);
            document.getElementById('contentDiv').style.marginTop = '0px';

            $("#myTab a:first").tab('show');
            $("#credentialsListOption").addClass("active");
            $("#credentials").show();

            if ($(window).width() > 500)
            {
                $('#accountSettingsSubmit').css("position","fixed");
            }
            else
            {
                $('#ssformobile').html($('#settingsSaveContent').html());
                $('#settingsSaveContent').html('');
            }


            /*Hover Functions*/
            $("#home").hover(function()
                {
                    $("#home").addClass("active");
                },
                function()
                {
                    $("#home").removeClass("active");
                });

            $("#logOut").hover(function()
                {
                    $("#logOut").addClass("active");
                },
                function()
                {
                    $("#logOut").removeClass("active");
                });

            //This is code for cropping the photo profile pic
            $("#profilePicChange").change(function()
            {
                //this is the new code
                try
                {

                    //this is the old code
                    var previewId = document.getElementById('load_img');
                    previewId.src = '';
                    $('#image_div').hide();


                    // Get selected file parameters
                    var selectedImg = $('#profilePicChange')[0].files[0];
                    // Preview the selected image with object of HTML5 FileReader class
                    // Make the HTML5 FileReader Object
                    var oReader = new FileReader();
                    oReader.onload = function(e)
                    {
                        // e.target.result is the DataURL (temporary source of the image)
                        previewId.src=e.target.result;

                        // FileReader onload event handler
                        previewId.onload = function () {

                            // display the image with fading effect
                            $('#image_div').fadeIn(500);
                            selectImgWidth = previewId.naturalWidth; //set the global image width
                            selectImgHeight =previewId.naturalHeight;//set the global image height

                            // Create variables (in this scope) to hold the Jcrop API and image size

                            // destroy Jcrop if it is already existed
                            if (typeof jcrop_api != 'undefined')
                                jcrop_api.destroy();

                            // initialize Jcrop Plugin on the selected image
                            $('#load_img').Jcrop({
                                minSize: [32, 32], // min crop size
                                // aspectRatio : 1, // keep aspect ratio 1:1
                                bgFade: true, // use fade effect
                                bgOpacity: .3, // fade opacity
                                onChange: showThumbnail,
                                onSelect: showThumbnail,
                                aspectRatio: 16/14,
                                setSelect:   [ 200, 200, 400, 400 ]
                            }, function(){

                                // use the Jcrop API to get the real image size
                                var bounds = this.getBounds();
                                boundx = bounds[0];
                                boundy = bounds[1];

                                // Store the Jcrop API in the jcrop_api variable
                                jcrop_api = this;
                            });
                        };
                    };

                    // read selected file as DataURL
                    oReader.readAsDataURL(selectedImg);
                    $("#changePP").hide();
                    $("#ppsubmit").show();
                }

                catch(error)
                {
                    alert(error);
                }

            });

            //This is code for cropping Wall Pic #1
            $("#wpChange").change(function()
            {

            });

            //disable all form submits

            $('#ppForm').submit(function(event)
            {

                /* stop form from submitting normally */
                event.preventDefault();
            });

            $('#aboutForm').submit(function(event)
            {

                /* stop form from submitting normally */
                event.preventDefault();
            });

            $('#ptForm').submit(function(event)
            {

                /* stop form from submitting normally */
                event.preventDefault();
            });



            //this is the code for form validation

            $('#ppForm').bootstrapValidator({
                live: 'enabled',
                submitButtons: 'button[id="ppsubmit"]',
                message: 'This value is not valid',
                fields: {
                    profilePic: {
                        message: 'The profile pic is not valid',
                        validators: {
                            file: {
                                extension: 'jpeg,png,jpg,gif',
                                type: 'image/jpeg,image/png,image/gif',
                                maxSize: 2048 * 1024,   // 2 MB
                                message: '  Select an Image with size upto 2MB, allowed types: JPG,PNG or GIF'
                            },
                            notEmpty: {
                                message: 'Please Select a Awesome new Profile Picture!'
                            }
                        }
                    }
                }
            });

            $('#ptForm').bootstrapValidator({
                live: 'enabled',
                submitButtons: 'button[id="ptsubmit"]',
                message: 'This value is not valid',
                fields: {
                    profileTune:
                    {
                        message: 'The profile Tune is not valid',
                        validators: {
                            file: {
                                extension: 'mp3,ogg,m4a,ra',
                                maxSize: 8144 * 1024,   // 7 MB
                                message: ' Select a file in size upto 7MB, allowed types: mp3 ogg m4a ra'
                            },
                            notEmpty: {
                                message: 'Please Select a awesome Profile Tune!'
                            }
                        }
                    }

                }
            });

            $('#aboutForm').bootstrapValidator({
                live:'enabled',
                submitButtons:'button[id="aboutsubmit"]',
                fields: {
                    editAbout: {
                        validators: {
                            notEmpty:{
                                message:' This cant be Empty'
                            },
                            stringLength: {
                                max: 300,
                                message: 'About you must be less than 300 characters'
                            }
                        }
                    }
                }
            });

            $("#newNameForm").bootstrapValidator({
                live:'enabled',
                submitButtons:'button[id="newNameSubmit"]',
                fields:{
                    firstname: {
                        validators: {
                            notEmpty: {
                                message: 'First Name is required.'
                            },
                            regexp: {
                                regexp: /^[ a-zA-Z]+$/,
                                message: 'Only alphabets, first one capital'
                            }
                        }
                    },
                    lastname: {
                        validators: {
                            regexp: {
                                regexp: /^[A-Z][a-z]{0,30}$/,
                                message: 'Only alphabets, first one capital'
                            }
                        }
                    },
                    confirmNameChange: {
                        validators: {
                            notEmpty: {
                                message: 'You got to check this box'
                            }
                        }
                    }
                }
            });

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

            $('#newNameForm').submit(function(event)
            {

                /* stop form from submitting normally */
                event.preventDefault();
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

            $(".newinterests").bootstrapSwitch({'onText':'Add', 'offText':'Nope'});
            $(".oldinterests").bootstrapSwitch({'onText':'Delete', 'offText':'Keep'});

            $(".interestType").bootstrapSwitch({'onText':'Pri.', 'offText':'Sec.'});
        }
    });
}

function showQuestions()
{
    oTableAnswered = null;
    oTableUnanswered = null;
    scrollDown();
    $('.bottomButtons').css({"backgroundColor":"#222","borderColor":"#222"});
    var id = $('#profileId').val();
    id = parseInt(id);
    $.post('http://b2.com/QnA/'+id, function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#interestsDiv').hide();
            $('#profileContainerDiv').hide();
            $('body,html').animate({ scrollTop: 0}, 0);

            $('#contentDiv').html(markup);
            document.getElementById('contentDiv').style.marginTop = '0px';

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
}

function getSubscriberList()
{
    scrollDown();
    $.post('http://b2.com/subscribersList', function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#interestsDiv').hide();
            $('#profileContainerDiv').hide();
            $('body,html').animate({ scrollTop: 0}, 0);

            $('#contentDiv').html(markup);
            document.getElementById('contentDiv').style.marginTop = '0px';
        }
    });
}

function getFriendList()
{
    scrollDown();
    $.post('http://b2.com/friendList', function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#interestsDiv').hide();
            $('#profileContainerDiv').hide();
            $('body,html').animate({ scrollTop: 0}, 0);
            $('#contentDiv').html(markup);
            document.getElementById('contentDiv').style.marginTop = '0px';
            appendDiv=$('#appendFriends').html();
        }
    });
}

function showUserContent(interest)
{
    scrollDown();
    var id = $('#profileId').val();
    id = parseInt(id);
    articleCount = 0;
    bookCount = 0;
    resourceCount = 0;
    pollQuizCount = 0;
    $.post('http://b2.com/showContent/'+interest+'/'+id, function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#interestsDiv').hide();
            $('#profileContainerDiv').hide();
            $('body,html').animate({ scrollTop: 0}, 0);

            $('#contentDiv').html(markup);
            document.getElementById('contentDiv').style.marginTop = '0px';

            interestId = $('#interestId').val();
            interestId = parseInt(interestId);

            $("div.metro-pivot").metroPivot(defaults);

            $(document).click(function(e){
                if ($(e.target).is('#mycounter,#mycounter *')) {
                    //Do Nothing
                }
                else
                {
                    $('#mycounter').fadeOut();
                }
            });

            /*showMoreArticles();
             showMoreBooks();
             showMoreResources();
             showMorePollsNQuizes();*/

            var minHeight = $('#ifc-reader').height();
            $('.ifc-reader').height(minHeight+15);
        }
    });
}

function toggleNewContent(type)
{
    $('.allContento').hide();
    $('#'+type+'-div').fadeIn();
}

function showAboutUser()
{
    scrollDown();
    $('.bottomButtons').css({"backgroundColor":"#222","borderColor":"#222"});
    var id = $('#profileId').val();
    id = parseInt(id);
    $.post('http://b2.com/about/'+id, function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#interestsDiv').hide();
            $('#profileContainerDiv').hide();
            $('body,html').animate({ scrollTop: 0}, 0);

            $('#contentDiv').html(markup);
            document.getElementById('contentDiv').style.marginTop = '0px';

            $('#newAboutForm').bootstrapValidator({
                live:'enabled',
                submitButtons: 'button[id="newAboutSubmit"]',
                message: 'This value is not valid',
                fields: {
                    newAbout: {
                        validators:{
                            notEmpty:{
                                message: "This field cannot be empty."
                            },
                            stringLength: {
                                min:30,
                                max:140,
                                message: 'You need to wrap it up between 30-140 characters.'
                            }
                        }
                    }
                }
            });
            $('#newAbout').blur();
            showTrivia();
        }
    });
}

function scrollDown()
{
    if (width > 1200)
    {
        $('#contentDiv').height(height);
    }
    else
    {
        var profileContainerDiv = $('#profileContainerDiv').height();
        var interestsContainer = $('#interestsContainer').height();
        var bodyDivHeight = $('#bodyDiv').height();
        totalMargin = navbarHeight+profileContainerDiv+interestsContainer-bodyDivHeight;
        document.getElementById('contentDiv').style.marginTop = (totalMargin)+'px';
        var winHeight = $(window).height();
        $('#contentDiv').height(winHeight);
    }
    $('#contentDiv').html('<br><br><br><h3 style="text-align: center">Loading...</h3>');
    $('#contentDiv').show();

    if (width > 1200)
    {
        $('body,html').animate({ scrollTop: height}, 750);
    }
    else
    {
        var totalScroll = bodyDivHeight+totalMargin;
        $('body,html').animate({ scrollTop: totalScroll}, 750);


    }
    $('#backtotop').show();
}

function backtotop()
{
    $('#interestsDiv').show();
    $('#profileContainerDiv').show();
    if (width > 1200)
    {
        $('body,html').animate({ scrollTop: height}, 0);
    }
    else
    {
        document.getElementById('contentDiv').style.marginTop = (totalMargin)+'px';
        $('body,html').animate({ scrollTop: height+totalMargin}, 0);

    }


    $('body,html').animate({ scrollTop: 0}, 750);
    $('#backtotop').hide();
    setTimeout(function()
    {
        $('#contentDiv').hide();
    }, 1000);
    $('.modal-backdrop').hide();
}

//About
function submitNewAbout(userid)
{
    $('#newAboutForm').data('bootstrapValidator').validate();

    if($('#newAboutForm').data('bootstrapValidator').isValid())
    {


        var aboutContent =$('#newAbout').val();
        var aboutIFC=$('#newAboutCost').val();


        $.ajax({
            type: "POST",
            url: "http://b2.com/postAboutText",
            data: {aboutText:aboutContent, aboutIFC:aboutIFC, wfor:userid},
            beforeSend: function()
            {
                $('#newAboutSubmit').prop('disabled', true);
                $("#newAboutSubmit").hide();
                $("#waitingImg3").show();

            }

        }).done(function(error)
        {
            if(error=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                $('#newAbout').val('');
                $('#aboutSuccessfullyPostedModal').modal('show');

                $('#newAboutSubmit').prop('disabled', false);
                $("#newAboutSubmit").show();
                $("#waitingImg3").hide();
            }

        });
    }
}

function acceptAbout(id)
{
    $.post('http://b2.com/acceptAbout', {aid:id}, function(data)
    {
        if(data=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#acceptUnapp'+id).hide();
            $('#declineUnapp'+id).hide();
            var unapp = $('#Unapp'+id).html();
            $('#Unapp'+id).fadeOut();
            $('#approvedAbout').append("<div>"+unapp+"</div>");
        }
    });

}

function declineAbout(id)
{
    $.post('http://b2.com/declineAbout', {aid: id}, function(data)
    {
        if(data=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        $('#Unapp'+id).fadeOut();
    });
}

function showAboutUser2()
{
    $('#newAboutForm').slideDown('slow');
    $('#showAboutUser2').slideUp('slow');
}

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

//Content
function showMoreArticles()
{
    $.post('http://b2.com/getContentArticles', {userId: userId, interestId: interestId, articleCount: articleCount}, function (data)
    {
        if(data=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            if (data)
            {
                if (articleCount == 0)
                    $('#articlesContent').html(data);
                else
                    $('#articlesContent').append(data);
                $('.images').height(250);
                var remainingArticles = $('#remainingArticles'+articleCount).val();
                remainingArticles = parseInt(remainingArticles);
                if (remainingArticles == 0)
                    $('#moreArticles').hide();
                else
                    $('#moreArticles').show();
                $('body').animate({ scrollTop: $('body')[0].scrollHeight}, 1000);
                articleCount += 4;
            }
            $('#articlesContent').fadeIn();
        }
    });
}

function showMoreBooks()
{
    $.post('http://b2.com/getContentBooks', {userId: userId, interestId: interestId, bookCount: bookCount}, function (data)
    {
        if(data=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            if (data)
            {
                if (bookCount == 0)
                    $('#booksContent').html(data);
                else
                    $('#booksContent').append(data);
                $('.images').height(250);
                var remainingBooks = $('#remainingBooks'+bookCount).val();
                remainingBooks = parseInt(remainingBooks);
                if (remainingBooks == 0)
                    $('#moreBooks').hide();
                else
                    $('#moreBooks').show();
                $('body').animate({ scrollTop: $('body')[0].scrollHeight}, 1000);
                bookCount += 4;
            }
            $('#booksContent').fadeIn();
        }
    });
}

function showMoreResources()
{
    $.post('http://b2.com/getContentResources', {userId: userId, interestId: interestId, resourceCount: resourceCount}, function (data)
    {
        if(data=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            if (data)
            {
                if (resourceCount == 0)
                    $('#resourcesContent').html(data);
                else
                    $('#resourcesContent').append(data);
                $('.images').height(250);
                var remainingResources = $('#remainingResources'+resourceCount).val();
                remainingResources = parseInt(remainingResources);
                if (remainingResources == 0)
                    $('#moreResources').hide();
                else
                    $('#moreResources').show();
                $('body').animate({ scrollTop: $('body')[0].scrollHeight}, 1000);
                resourceCount += 4;
            }
            $('#resourcesContent').fadeIn();
        }
    });
}

function showMorePollsNQuizes()
{
    $.post('http://b2.com/getContentPollsNQuizes', {userId: userId, interestId: interestId, pollQuizCount: pollQuizCount}, function (data)
    {
        if(data=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            if (data)
            {
                if (pollQuizCount == 0)
                    $('#pollsnquizesContent').html(data);
                else
                    $('#pollsnquizesContent').append(data);
                $('.images').height(250);
                var remainingPollsNQuizes = $('#remainingPollsNQuizes'+pollQuizCount).val();
                remainingPollsNQuizes = parseInt(remainingPollsNQuizes);
                if (remainingPollsNQuizes == 0)
                    $('#morePollsNQuizes').hide();
                else
                    $('#morePollsNQuizes').show();
                $('body').animate({ scrollTop: $('body')[0].scrollHeight}, 1000);
                pollQuizCount += 4;
            }
            $('#pollsnquizesContent').fadeIn();
        }
    });
}

//FriendList
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
                $("#accountSettingsSubmit").html(message);
                setTimeout(function(){$("#accountSettingsSubmit").html('Save Changes')}, 3000);
                /*            $("#accountSettingsMessage").show();
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
            $("#resetPasswordMessage").html("<strong>"+message+"</strong>")
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