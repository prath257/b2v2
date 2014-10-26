var oTable=null;
var nop=2;
$(document).ready(function()
{
    var width = $(document).width();
    if (width<=700)
    {
        $(".table").addClass("table-bordered");
    }

	oTable=$('#myPolls').dataTable( {
		"ajax": 'getMyPollsData',
		"lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
	} );

    oTable=$('#publicPolls').dataTable( {
        "ajax": 'getPublicPollsData',
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
    } );

    oTable=$('#friendsPolls').dataTable( {
        "ajax": 'getFriendsPollsData',
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
    } );

    oTable=$('#subscriptionPolls').dataTable( {
        "ajax": 'getSubscriptionPollsData',
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
    } );

    $('#newPollForm').bootstrapValidator({
		live:'enabled',
		submitButtons: 'button[id="newPollSubmit"]',
		message: 'This value is not valid',
		fields: {

			question: {
                validators: {
                    notEmpty: {
                        message: 'A short and precise question is required'
                    },
                    stringLength: {
                        min: 10,
                        max: 200,
                        message: 'Min 10 and Max 200 characters'
                    }
                }
            },
            message: {
                validators: {
                    stringLength: {
                        min: 10,
                        max: 140,
                        message: 'Min 10 and Max 140 characters'
                    }
                }
            },
			category: {
				validators: {
					notEmpty: {
						message: 'Please select a category'
					}
				}
			},
			ifc: {
				validators: {
					integer: {
						message: 'Number!'
					},
					between: {
						min: 0,
						max: 50,
						message: 'Cost should be 0-50 IFCs'
					}
				}
			},
            op1: {
                validators: {
                    notEmpty: {
                        message: 'Please give a first option'
                    },
                    stringLength: {
                        min: 1,
                        max: 255,
                        message: 'Min 1 character and Max 255 characters'
                    }
                }
            },
            op2: {
                validators: {
                    notEmpty: {
                        message: 'Please give a second option'
                    },
                    stringLength: {
                        min: 1,
                        max: 255,
                        message: 'Min 1 character and Max 255 characters'
                    }
                }
            }

		}
	});

    $("#access").bootstrapSwitch({'onText':'Public', 'offText':'Private'});
});


function addOption()
{
    nop++;
    var hm="<br id='lb"+nop+"'><input id='op"+nop+"' name='op"+nop+"' type='text' class='form-control'  autocomplete='off' placeholder='Option "+nop+"'>";
    $('#optionGroup').append(hm);
    $('#numop').val(nop);
}

function removeOption()
{
    if(nop>2)
    {
        $('#lb'+nop).remove();
        $('#op'+nop).remove();
        nop--;
        $('#numop').val(nop);
    }
    else
    {
        bootbox.alert('Must have atleast 2 options');
    }
}


function deletePoll(bid,pid)
{
	bootbox.confirm("Are you sure?", function(result) {
		if (result==true)
		{
			$.post('http://b2.com/deletePoll/'+pid,{data:'none'},function(data)
			{
                if(data=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
				else
                {
                    var row = $(bid).closest("tr").get(0);
                    oTable.fnDeleteRow(oTable.fnGetPosition(row));
                }
			})


		}
	});

}


function closePoll(bid,pid)
{
    var action = $(bid).html();
    action = action.toLowerCase();
    bootbox.confirm("Are you sure to "+action+" the Polling?", function(result) {
        if (result==true)
        {
            $.post('http://b2.com/closePoll/'+pid,{data:'none'},function(data)
            {
                if(data=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                   $(bid).html(data);

            })


        }
    });

}

function showResult(pid)
{

            $.post('http://b2.com/getResult/'+pid,{data:'none'},function(data)
            {
                if(data=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                {
                    $('#pollResult').html(data);
                    $('#resultModal').modal({
                        keyboard:false,
                        show:true,
                        backdrop:'static'
                    });
                }
            });


}


