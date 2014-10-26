var oTable1=null;
var oTable2=null;
var oTable3=null;
var oTable4=null;
var nop=2;
$(document).ready(function()
{
    var width = $(document).width();
    if (width<=700)
    {
        $(".table").addClass("table-bordered");
    }

	oTable1=$('#myQuiz').dataTable( {
		"ajax": 'getMyQuizData',
		"lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
	} );

    oTable2=$('#publicQuiz').dataTable( {
        "ajax": 'getPublicQuizData',
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
    } );

    oTable3=$('#friendsQuiz').dataTable( {
        "ajax": 'getFriendsQuizData',
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
    } );

    oTable4=$('#subscriptionQuiz').dataTable( {
        "ajax": 'getSubscriptionQuizData',
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
    } );

    $('#newQuizForm').bootstrapValidator({
		live:'enabled',
		submitButtons: 'button[id="newQuizSubmit"]',
		message: 'This value is not valid',
		fields: {

			title: {
                validators: {
                    notEmpty: {
                        message: 'A short and precise Quiz Title is required'
                    }
                }
            },
            description: {
                validators: {
                    stringLength: {
                        min: 20,
                        max: 250,
                        message: 'Min 20 and Max 250 characters'
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
						max: 500,
						message: 'Cost should be 0-500 IFCs'
					}
				}
			},
            time: {
                validators: {
                    integer: {
                        message: 'Number!'
                    },
                    notEmpty:
                    {
                        message:"This Field is required"
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
    var hm="<label id='lb"+nop+"'>"+nop+"</label> <input id='op"+nop+"' name='op"+nop+"' type='text' class='form-control'  autocomplete='off'>";
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
        alert('Must have atleast 2 options');
    }
}


function deleteQuiz(bid,pid)
{
	bootbox.confirm("Are you sure?", function(result) {
		if (result==true)
		{
			$.post('http://localhost/b2v2/deleteQuiz/'+pid,{data:'none'},function(data)
			{
				var row = $(bid).closest("tr").get(0);
				oTable1.fnDeleteRow(oTable1.fnGetPosition(row));
			})


		}
	});

}


function closeQuiz(bid,pid)
{
    if (bid.innerHTML == 'Open')
        var keyword = 'close';
    else
        var keyword = 'open';

    bootbox.confirm("Are you sure to "+keyword+" the Quiz?", function(result) {
        if (result==true)
        {
            $.post('http://localhost/b2v2/closeQuiz/'+pid,{data:'none'},function(data)
            {
                if(data=='wH@tS!nTheB0x')
                    window.location='http://localhost/b2v2/offline';
                else
               $(bid).html(data);

            })
        }
    });
}

function showStats(pid)
{

            $.post('http://localhost/b2v2/getQuizStats/'+pid,{data:'none'},function(data)
            {
                if(data=='wH@tS!nTheB0x')
                    window.location='http://localhost/b2v2/offline';
                else
                {
                    $('#quizStats').html(data);
                    oTable1=$('#quizTakersData').dataTable( {
                        "ajax": 'getQuizTakersData/'+pid,
                        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
                    } );
                    $('#statModal').modal({
                        keyboard:false,
                        show:true,
                        backdrop:'static'
                    });
                }
            });


}



