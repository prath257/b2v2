var scrollDown = null;
var scrollDown2 = null;
var scrollUp = null;
$(document).ready(function()
{
    //this is for getting window height and setting accordingly
    $('#main-body').height($(window).height());
    $('#tour-body').height($(window).height());
    $('#main-tour-body').height($(window).height());
    $('#carousel1').height($(window).height()*0.90);
    $('#carousel2').height($(window).height()*0.90);
    $('#carousel3').height($(window).height()*0.90);
    $('.item').height($('#carousel1').height()*0.90);
    $(".container").fadeIn();

    //Code to show the bbarters description by default.
    $(document).mouseover(function(e){
        if (!$(e.target).is('#headers,#headers *') && !$(e.target).is('#information,#information *')) {
            $('.three').css('fontWeight','normal').css('color','black');
            $('.contentDisplay').hide();
            $('#aboutBBarters').show();
        }
    });

    //Bootstrap validator for Sign up form
    $('#signupForm').bootstrapValidator({
        message: 'This value is not valid',
        fields: {
            username: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'The username is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'The username can only consist of alphabetical, number, dot and underscore'
                    }
                }
            },
            country: {
                validators: {
                    notEmpty: {
                        message: 'The country is required and can\'t be empty'
                    }
                }
            },
            captcha: {
                validators: {
                    notEmpty: {
                        message: 'The letters are Case-Sensitive'
                    }
                }
            },
            acceptTerms: {
                validators: {
                    notEmpty: {
                        message: 'You have to accept the terms and policies'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required and can\'t be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },

            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required and can\'t be empty'
                    },
                    regexp: {
                        regexp: /^\S{6,20}$/,
                        message: 'Min 6 letters, max 20, no whitespaces'
                    }

                }
            },
            cpassword: {
                validators: {
                    notEmpty: {
                        message: 'The confirm password is required and can\'t be empty'
                    },
                    identical: {
                        field: 'password',
                        message: 'The password and its confirm are not the same'
                    }
                }
            },
            firstname: {
                validators: {
                    notEmpty: {
                        message: 'First Name is required.'
                    },
                    stringLength: {
                        min: 2,
                        max: 30,
                        message: 'The first name must be more than 2 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[ a-zA-Z]+$/,
                        message: 'Only alphabets ofcourse'
                    }
                }
            },
            lastname: {
                validators: {
                    regexp: {
                        regexp: /^[a-zA-Z]+$/,
                        message: 'Only alphabets ofcourse'
                    }
                }
            }
        }
    });

    //Bootstrap validator for Login form
    $('#loginForm').bootstrapValidator({
        message: 'This value is not valid',
        fields: {
            uname: {
                validators: {
                    notEmpty: {
                        message: 'The username is required'
                    }
                }
            },
            pwd: {
                validators: {
                    notEmpty: {
                        message: 'The password is required'
                    }
                }
            }

        }
    });

    //Bootstrap validator for Login form (Desktop view)
    $('#loginFormDesktop').bootstrapValidator({
        message: 'This value is not valid',
        fields: {
            unameDesktop: {
                validators: {
                    notEmpty: {
                        message: 'The username is required'
                    }
                }
            },
            pwdDesktop: {
                validators: {
                    notEmpty: {
                        message: 'The password is required'
                    }
                }
            }

        }
    });

    //Bootstrap validator for Forgot password form
    $("#forgotPasswordForm").bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="forgotPasswordSubmit"]',
        message: 'This value is not valid',

        fields:{
            username:{
                validators:{
                    notEmpty:{
                        message: 'This field is required'
                    }
                }
            },
            email:{
                validators:{
                    notEmpty:{
                        message: 'This field is required'
                    },
                    emailAddress:{
                        message: 'This is not a valid Email address'
                    }
                }
            }
        }
    });

    //Bootstrap validator for Reset password form
    $("#rPasswordForm").bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="rPasswordSubmit"]',
        message: 'This value is not valid',

        fields:{
            rPasswordPassword: {
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
            rPasswordCPassword: {
                validators: {
                    notEmpty: {
                        message: 'The confirm password is required and can\'t be empty'
                    },
                    identical: {
                        field: 'rPasswordPassword',
                        message: 'The password and its confirm are not the same'
                    }
                }
            }
        }
    });

    //Prevent normal submission of forms that send data via ajax calls.
    $('#forgotPasswordForm').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
    });

    $('#rPasswordForm').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
    });

    //Style effects on gender in signup form
    $(".btn-group button").click(function ()
    {
        $('.genderError').html('');
        $('#signUpSubmit').prop('disabled',false);
        $('#genderLabel').css('color','#000000');
        $("#gender").val($(this).val());
        var gid=this.id;
        if(gid=="male")
        {
            $('#male').addClass('active');
            $('#female').removeClass('active');
            $('#other').removeClass('active');

        }
        else if(gid=="female")
        {
            $('#female').addClass('active');
            $('#male').removeClass('active');
            $('#other').removeClass('active');
        }
        else
        {
            $('#other').addClass('active');
            $('#female').removeClass('active');
            $('#male').removeClass('active');
        }
    });

    //Initiating the carousel
    $('#carousel2').carousel({
        interval: 7000
    });
    $('#carousel3').carousel({
        interval: 9000
    });

    /*A session value is obtained on page load and stored in a hidden input. The 'value' indicates if the user was redirected from other page
    if he/she wasn't authenticated. The following line opens the login modal on page load */
    var redirected = $("#redirected").val();
    if (redirected == 'true')
        $("#loginModal").modal('show');
    else if (redirected == 'signup')
        $("#signUpModal").modal('show');
});

//Ajax call to check is the username entered by the user already exists (while signing up)
function checkUname()
{
    $('#uerror').text('');
    var uname = $('#username').val();
    if(uname)
    {
        try
        {
            $.post("http://localhost/b2v2/checkUsername",{username: uname},function(data)
            {
                if(data=='wH@tS!nTheB0x')
                    window.location='http://localhost/b2v2/offline';
                if(data=='username already taken')
                {
                    $('#uerror').text(data);
                    $('#username').val('');
                    $('#username').focus();
                }
            });
        }
        catch(error)
        {
            //Do nothing
        }
    }
}

//Function to handle forgot password request
function forgotPassword()
{

    var username = $("#fpusername").val();
    var email = $("#fpemail").val();

    try
    {
        $.ajax({
            type: "POST",
            url:'http://localhost/b2v2/forgotPassword',
            data:{username: username, email: email},
            beforeSend: function()
            {
                $('#forgotPasswordSubmit').prop('disabled', true);
                $("#forgotPasswordSubmit").hide();
                $("#waitingImg").show();

            }
        }).done(function(response)
        {
            if(response=='wH@tS!nTheB0x')
                window.location='http://localhost/b2v2/offline';
            else
            {
                $('#forgotPasswordSubmit').prop('disabled', false);
                $("#forgotPasswordSubmit").show();
                $("#waitingImg").hide();

                if (response == 'Success')
                {

                    $("#forgotPasswordSubmit").html("Submit");
                    $('.fpDivs').hide();
                    $("#secretCode").fadeIn();
                }
                else
                {
                    $("#forgotPasswordSubmit").html("Submit");
                    $('.fpDivs').hide();
                    document.getElementById('foreignUserErrorContent').innerHTML=response;
                    $('#foreignUserError').fadeIn();
                }
            }
        });
    }

    catch(error)
    {
        //Do nothing
    }
}

//Check the code by user (who recently forgor the password) and show the reset password form if it is valid
function showResetPassword()
{
    var enteredLink = $("#sC").val();
	var email = $("#fpemail").val();

    try
    {
        $.post('http://localhost/b2v2/checkFpLink', {link: enteredLink, email: email}, function(verify)
        {
            if(verify=='wH@tS!nTheB0x')
                window.location='http://localhost/b2v2/offline';
            else
            {
                if (verify == 'true')
                {
                    $('.fpDivs').hide();
                    $("#rPassword").fadeIn();
                }
                else
                {
                    $("#SCerror").fadeIn();
                }
            }
        });
    }
    catch(error)
    {
        //Do nothing
    }

}

//Ajax call to save the reset password by the user
function postResetPassword()
{
    var username = $("#fpusername").val();
    var password1 = $("#rPasswordPassword").val();

    try
    {
        $.post('http://localhost/b2v2/postResetPassword', {username: username, password: password1}, function(error)
        {
            if(error=='wH@tS!nTheB0x')
                window.location='http://localhost/b2v2/offline';
            else
                window.location = "http://localhost/b2v2/home";
        });
    }
    catch(error)
    {
        //Do nothing
    }
}

//Ajax call to check is the email entered by the user already exists (while signing up)
function checkEmail()
{
    $('#merror').text('');
    var email = $('#email').val();
    if(email)
    {
        try
        {
            $.post("http://localhost/b2v2/checkEmail",{mail: email},function(data)
            {
                if(data=='wH@tS!nTheB0x')
                    window.location='http://localhost/b2v2/offline';
                if(data=='email already registered')
                {
                    $('#merror').text(data);
                    $('#email').val('');
                    $('#email').focus();
                }
            });
        }
        catch(error)
        {
            //Do nothing
        }
    }
}

//Show login form on clicking 'Regular Login'
function showLoginBlock()
{
    $('#loginLink').hide();
    $('#loginBlock').fadeIn();
}

//Show desc for create once the user hovers over it.
function showCreate()
{
    $('.three').css('fontWeight','normal').css('color','black');
    $('#create').css('fontWeight','bold').css('color','#38b638');
    $('.contentDisplay').hide();
    $('#createData').fadeIn(700);
}

//Show desc for collaborate once the user hovers over it.
function showCollaborate()
{
    $('.three').css('fontWeight','normal').css('color','black');
    $('#collaborate').css('fontWeight','bold').css('color','#38b638');
    $('.contentDisplay').hide();
    $('#collaborateData').fadeIn(700);
}

//Show desc for converge once the user hovers over it.
function showConverge()
{
    $('.three').css('fontWeight','normal').css('color','black');
    $('#converge').css('fontWeight','bold').css('color','#38b638');
    $('.contentDisplay').hide();
    $('#convergeData').fadeIn(700);
}

//Open Resource/Article/Book/Collaboration when a user clicks on an image/heading in carousel
function openResource(id)
{
    window.location='http://localhost/b2v2/resource/'+id;
}

function openArticle(id)
{
    window.location='http://localhost/b2v2/articlePreview/'+id;
}

function openBook(id)
{
    window.location='http://localhost/b2v2/blogBookPreview/'+id;
}

function openCollab(id)
{
    window.location='http://localhost/b2v2/collaborationPreview/'+id;
}

function openMedia(id)
{
    window.location='http://localhost/b2v2/mediaPreview/'+id;
}

//Bootstrap Validator is unable to validate this. Thus..
function checkGender()
{
    var gender = $('#gender').val();
    if (gender == 0)
    {
        $('.genderError').html('Please select a gender.');
        $('#genderLabel').css('color','#a94442');
        $('#signUpSubmit').prop('disabled',true);
    }
}

function initiateTour()
{
    clearInterval(scrollUp);
    $('#tour-body').show();
    $('body,html').animate({ scrollTop: $(window).height()}, 750);
    scrollDown = window.setInterval(function()
    {
        $('#main-body').hide();
        $('#back-image').fadeOut(1000);
        $('#BBarters').fadeIn(1000);
    }, 750);
}

function backtotop()
{
    $('#exitTour').hide();
    $('#takeBBartersQuiz').hide();
    if (scrollDown)
        clearInterval(scrollDown);
    if (scrollDown2)
        clearInterval(scrollDown2);

    $('#main-body').show();
    $('body,html').animate({ scrollTop: $(window).height()}, 0);

    $('body,html').animate({ scrollTop: 0}, 750);
    scrollUp = window.setInterval(function()
    {
        $('.sub-bodies').hide();
    }, 750);
}

function startTour()
{
    $('#main-tour-body').show();
    $('body,html').animate({ scrollTop: $(window).height()}, 750);
    scrollDown2 = window.setInterval(function()
    {
        $('#tour-body').hide();
        $('#exitTour').show();
        $('#takeBBartersQuiz').show();
    }, 750);
}

function showTour(tt)
{
    var tourid=tt.id;
    var srcString='<source src="http://localhost/b2v2/Tour/'+tourid+'.mp4" type="video/mp4">';
    $('#tourVideo').html(srcString);
    var name  = parseInt(tt.name) + 1;
    $('[name='+name+']').removeClass('disabled');
}