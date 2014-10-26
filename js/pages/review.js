$(document).ready(function()
{
    $('#reviewModal').modal({
        keyboard:false,
        show:true,
        backdrop:'static'
    });

    $('#reviewForm').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="reviewSubmit"]',
        message: 'This value is not valid',
        fields: {
            ifc: {
                validators: {
                    notEmpty: {
                        message: 'Please enter a value. Zero at least'
                    },
                    integer:{
                        message:'The value must be an integer'
                    },
                    between: {
                        min: 0,
                        max: 1000,
                        message: 'The transfer amount must be between 0 to 1000i'
                    }
                }
            },
            suggestions: {
                validators: {
                    notEmpty: {
                        message: 'A suggestion! At least a word!'
                    }
                }
            }

        }
    });

    $('#reviewForm').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
    });
});

function postReview()
{
    $('#reviewSubmit').prop('disabled', true);
    /*$("#reviewSubmit").html("Loading.");
     var timer = window.setInterval( function() {
     var text = document.getElementById("reviewSubmit");
     if ( text.innerHTML.length > 9 )
     text.innerHTML = "Loading.";
     else
     text.innerHTML += ".";
     }, 750);*/
    $('#reviewSubmit').hide();
    $('#waitingReview').show();

    var ifc = $("#ifc").val();

    if (ifc == "0")
    {
        bootbox.confirm("Awarding zero IFCs means deleting the BlogBook. Are you sure?", function(result) {
            if (result==true)
            {
                var zero = true;
                var suggestions = $("#suggestions").val();
                var blogBookId = $("#blogBookId").val();
                var reviewId = $("#reviewId").val();

                $.post('http://localhost/b2v2/blogBookReview', {ifc: ifc, suggestions: suggestions, blogBookId: blogBookId, reviewId: reviewId, zero: zero}, function(error)
                {
                    if(error=='wH@tS!nTheB0x')
                        window.location='http://localhost/b2v2/offline';
                    else
                    window.location = "http://localhost/b2v2/home";
                });
            }
            else
            {
                /*clearInterval(timer);
                 $('#reviewSubmit').prop('disabled', false);
                 $("#reviewSubmit").html("Submit");*/
                $('#reviewSubmit').show();
                $('#waitingReview').hide();
            }
        });
    }
    else
    {
        var zero = false;
        var suggestions = $("#suggestions").val();
        var blogBookId = $("#blogBookId").val();
        var reviewId = $("#reviewId").val();

        $.post('http://localhost/b2v2/blogBookReview', {ifc: ifc, suggestions: suggestions, blogBookId: blogBookId, reviewId: reviewId, zero: zero}, function(error)
        {
            if(error=='wH@tS!nTheB0x')
                window.location='http://localhost/b2v2/offline';
            else
            window.location = "http://localhost/b2v2/home";
        });
    }
}