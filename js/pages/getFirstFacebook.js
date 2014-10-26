//This is validation code for fbsignupModal

$(document).ready(function()
{

    $('#fbSignUpModal').modal({
        keyboard: false,
        show:true,
        backdrop:false
    });

	$('#fbSignupForm').bootstrapValidator({
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
			acceptTerms: {
				validators: {
					notEmpty: {
						message: 'You have to accept the terms and policies'
					}
				}
			}


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

