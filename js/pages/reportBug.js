$(document).ready(function() {
    $('#summernote').summernote({
        height:430,
        onkeydown: function(e) {
            checkCharacters();
        },
        onpaste: function(e) {
            checkCharacters();
        }
    });
});

function submitBug()
{
    $("#error-box").html("");
    var content = $('#summernote').code();
    if (content.length > 99)
    {
        $('#submitBugButton').prop('disabled', true);
        $("#submitBugButton").html("Please Wait...");
        $.post('http://b2.com/reportBug', {content: content}, function(text)
        {
            if(text=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                bootbox.alert("Posted! Thank you on behalf of TeamBBarters. Keep an eye on your mail to check the Admin's response to your post.", function() {
                    window.location="http://b2.com/home";
                });
            }
        });
    }
    else
    {
        $("#error-box").html("<strong>Too Short</strong>");
        $('#submitBugButton').prop('disabled', true);
    }
}

function checkCharacters()
{
    var content = $('#summernote').code();
    if (content.length <= 99)
    {
        $("#error-box").html("<strong>Too Short</strong>");
        $('#submitBugButton').prop('disabled', true);
    }
    else
    {
        $("#error-box").html("");
        $('#submitBugButton').prop('disabled', false);
    }
}