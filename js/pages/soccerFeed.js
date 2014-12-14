/**
 * Created by bbarters on 29-11-2014.
 */
//This is validation code for fbsignupModal

$(document).ready(function()
{
       getLiveFeeds();
});


function getLiveFeeds()
{
    var  timer = window.setInterval( function()
    {

        $( "#liveText" ).load( "http://www.bbc.com/sport/0/football/30156606" );
        }, 10000);
}


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

function checkEmail()
{
    /* stop form from submitting normally */
    //event.preventDefault();
    $('#merror').text('');
    var email = $('#email').val();
    if(email)
    {
        //ajax post the form
        $.post("http://b2.com/checkEmail",{mail: email},function(data)
        {
            if(data=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            if(data=='email already registered')
            {
                $('#merror').text(data);
                $('#email').val('');
                $('#email').focus();
            }

        });

    }

}


