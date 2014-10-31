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

    //this is the code for handing quiz stats
    var chartQuiz = Morris.Bar({
        // ID of the element in which to draw the chart.
        element: 'quiz-stats-container',
        data: [0, 0], // Set initial data (ideally you would provide an array of default data)
        xkey: 'Quiz', // Set the key for X-axis
        ykeys: ['value'], // Set the key for Y-axis
        labels: ['Earnings']      // Set the label when bar is rolled over

    });

    // Create a function that will handle AJAX requests
    function requestData(days, chart, type)
    {
        try
        {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "http://b2.com/get"+type+"ChartData", // This is the URL to the API
                data: { days: days }
            })
                .done(function( data ) {
                    if(data=='wH@tS!nTheB0x')
                        window.location='http://b2.com/offline';
                    else
                    {
                        // When the response to the AJAX request comes back render the chart with new data
                        chart.setData(data);
                    }
                })
                .fail(function() {
                    // If there is no communication between the server, show an error
                    // alert( "error occured" );
                });
        }
        catch(error)
        {
            //do nothing about the error
        }
    }

    requestData(90, chartQuiz,'Quiz');

    $('ul.ranges a').click(function(e){
        e.preventDefault();

        // Get the number of days from the data attribute
        var el = $(this);
        days = el.attr('data-range');
        var pp=el.closest('li');
        var p=pp[0];

        if (p.id=='q'+days)
        {
            $("#quizData>li.active").removeClass("active");
            pp.addClass('active');
            requestData(days, chartQuiz,'Quiz');

        }

        // Request the data and render the chart using our handy function


    })

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
			$.post('http://b2.com/deleteQuiz/'+pid,{data:'none'},function(data)
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
            $.post('http://b2.com/closeQuiz/'+pid,{data:'none'},function(data)
            {
                if(data=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
               $(bid).html(data);

            })
        }
    });
}

function showStats(pid)
{

            $.post('http://b2.com/getQuizStats/'+pid,{data:'none'},function(data)
            {
                if(data=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
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



