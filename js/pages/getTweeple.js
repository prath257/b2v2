//This is validation code for fbsignupModal

$(document).ready(function()
{

    $('#twsignUpModal').modal({
        keyboard: false,
        show:true,
        backdrop:false
    });

	$('#twsignupForm').bootstrapValidator({
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

			acceptTerms: {
				validators: {
					notEmpty: {
						message: 'You have to accept the terms and policies'
					}
				}
			}


		}
	});

    $(".btn-group button").click(function ()
    {
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

});

function checkUname()
{
	/* stop form from submitting normally */
	//event.preventDefault();
  	$('#uerror').text('');
	var uname = $('#username').val();
	if(uname)
	{
		//ajax post the form
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

}

function checkEmail()
{
    /* stop form from submitting normally */
    //event.preventDefault();
    $('#merror').text('');
    var email = $('#email').val();
    if(email)
    {
        //ajax post the form
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

}


