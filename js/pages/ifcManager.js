var oTable=null;

$(document).ready(function()
{
    $("#mycounter").flipCounterInit({'speed': 0.05});
    $.post('http://localhost/b2v2/getIFCs', function(ifcs)
    {
        if(ifcs=='wH@tS!nTheB0x')
            window.location='http://localhost/b2v2/offline';
        else
            $("#mycounter").flipCounterUpdate(ifcs);
    });

    var width = $(document).width();
    if (width<=700)
    {
        $(".table").addClass("table-bordered");
    }

    oTable=$('#example').dataTable( {
        "ajax": 'http://localhost/b2v2/getIFCManagerData',
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]],
        "order": [[0, "desc" ]]
    } );

    $('#inviteForm').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="inviteSubmit"]',
        message: 'This value is not valid',
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'The name is required'
                    },
                    stringLength: {
                        min: 2,
                        max: 30,
                        message: 'Not this short'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z]+$/,
                        message: 'Only alphabets ofcourse'
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
            }

        }
    });

        $('#transferForm').bootstrapValidator({
            live:'enabled',
            submitButtons: 'button[id="transferSubmit"]',
            message: 'This value is not valid',
            fields: {
                friend: {
                    validators: {
                        notEmpty: {
                            message: 'Please select a friend'
                        }
                    }
                },
                transferIFC: {
                    validators: {
                        notEmpty: {
                            message: 'Please select an amount to be transferred'
                        },
                        integer:{
                            message:'The value must be an integer'
                        },
                        between: {
                            min: 1,
                            max: 10000,
                            message: 'The transfer amount must be between 1 to 10000i'
                        }
                    }
                }

            }
        });

    $('#inviteForm').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
    });

    $('#transferForm').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
    });

});

function showInviteModal()
{
    $("#earnIFCModal").modal('hide');
    $('#inviteModal').modal({
        keyboard:false,
        show:true,
        backdrop:'static'
    });
}


function showContentModal()
{
    $('#earnIFCModal').modal('hide');
    $("#createContentModal").modal('show');
}



function postTransfer()
{
    $('#transferForm').data('bootstrapValidator').validate();

    if($('#transferForm').data('bootstrapValidator').isValid())
    {
        var userid = $("#friend").val();
        userid = parseInt(userid);
        var ifc = $("#transferIFC").val();
        ifc = parseInt(ifc);
        $('#transferSubmit').prop('disabled', true);

        $.ajax({
            type: "POST",
            url: "http://localhost/b2v2/transfer",
            data: {userid:userid, ifc:ifc},
            beforeSend: function()
            {

                //  $("#submitTransfer").html("<img src='http://localhost/b2v2/Images/icons/waiting.gif'>");

                $("#submitTransfer").hide();
                $("#waiting").show();
            }
        }).done(function(response)
        {
            if(response=='wH@tS!nTheB0x')
                window.loaction='http://localhost/b2v2/offline';
            else
            {
                $("#submitTransfer").show();
                $("#waiting").hide();

                if (response == 'Success')
                {
                    $("#submitTransfer").html("<button type='submit' id='transferSubmit' onclick='postTransfer()' class='btn btn-primary'>Submit</button>");
                    $('#transferModal').modal('hide');
                    bootbox.alert('IFCs successfully transferred to your friend!');
                    $('#transferSubmit').prop('disabled', false);
                    $("#transferSubmit").html("Submit");
                }
                else
                {
                    $('#transferModal').modal('hide');
                    bootbox.alert("Sorry, you've got only "+response+" IFCs and that's why you cannot perform this transaction!");
                    $('#transferSubmit').prop('disabled', false);
                    $("#transferSubmit").html("Submit");
                }
            }
        });

    }
}



function postInvite()
{
    var name=$('#inviteName').val();
    var email=$('#inviteEmail').val();

    if(name!="" && email!="")
    {
        $("#inviteLinkAndErrors").hide();
        $("#inviteLinkAndErrors").html("");

        $.ajax({
            type: "POST",
            url: "http://localhost/b2v2/invite",
            data: {name:name, email:email}
        }).done(function(msg)
        {
            if(msg=='wH@tS!nTheB0x')
                window.location='http://localhost/b2v2/offline';
            else
            {
                $('#inviteLinkAndErrors').html(msg);
                $("#inviteLinkAndErrors").show();
            }
        });
    }
}

function inviteAnother()
{
    $("#inviteLinkAndErrors").hide();
    $("#inviteLinkAndErrors").html("");
    $("#inviteName").val("");
    $("#inviteEmail").val("");
}

function closeInviteModal()
{
    $("#inviteModal").modal('hide');
    $("#inviteLinkAndErrors").hide();
    $("#inviteLinkAndErrors").html("");
    $("#inviteName").val("");
    $("#inviteEmail").val("");
}