var oTable=null;
$(document).ready(function()
{
    var width = $(document).width();
    if (width<=700)
    {
        $(".table").addClass("table-bordered");
    }

	oTable=$('#example').dataTable( {
		"ajax": 'http://b2.com/getArticleData',
		"lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
	} );

	$('#newArticleForm').bootstrapValidator({
		live:'enabled',
		submitButtons: 'button[id="newArticleSubmit"]',
		message: 'This value is not valid',
		fields: {
            uploadCover: {
                message: 'The cover pic is not valid',
                validators: {
                    file: {
                       // extension: 'jpeg,png,jpg,gif',
                        type: 'image/jpeg,image/jpg,image/png,image/gif',
                        maxSize: 2048 * 1024,   // 2 MB
                        message: '  Max 2MB, allowed types: JPG,PNG or GIF'
                    },
                    notEmpty: {
                        message: 'Please Select an Article Cover!'
                    }
                }
            },
			title: {
				validators: {
					notEmpty: {
						message: 'Please give a Title'
					},
                    stringLength: {
                        min: 1,
                        max: 255,
                        message: 'Min 1 character and Max 255 characters'
                    }
				}
			},
            shortDescription: {
                validators: {
                    notEmpty: {
                        message: 'A short and sweet description is required'
                    },
                    stringLength: {
                        min: 10,
                        max: 300,
                        message: 'Min 10 and Max 300 characters'
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
						max: 10000,
						message: 'Less than 10000i'
					}
				}
			}
		}
	});

    $(document).click(function(e){
        if ($(e.target).is('#searchModal,#searchModal *')) {
            //Do Nothing
        }
        else
        {
            $('#searchModal').fadeOut();
            $('#search').val("");
        }
    });
    $(document).keyup(function(e) {
        if (e.keyCode == 27)
        {
            $('#search').val("");
            $('#searchModal').fadeOut();
            $('#search').blur();
        }
        else if (e.keyCode == 8)
        {
            $('#searchModal').fadeOut();
        }
    });

    $('#searchForm').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
        executeSearch();
    });

    $("#peopleLabel").addClass("btn-info");
    document.getElementById('search').placeholder="Search Barters";

    //this is the code to show the stats
    var chartArticle =Morris.Donut({
        element: 'donut-articles',
        data: [0,0]

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

    requestData(90, chartArticle,'Article');

    $('ul.ranges a').click(function(e){
        e.preventDefault();

        // Get the number of days from the data attribute
        var el = $(this);
        days = el.attr('data-range');
        var pp=el.closest('li');
        var p=pp[0];
        if(p.id=='a'+days)
        {
            $("#articlesData>li.active").removeClass("active");
            pp.addClass('active');
            requestData(days, chartArticle,'Article');

        }


    })

});

function changeArticleCover()
{
    var previewId = document.getElementById('defaultCover');
    previewId.src = '';

    var selectedImg = $('#uploadCover')[0].files[0];

    var oReader = new FileReader();
    oReader.onload = function(e)
    {
        previewId.src=e.target.result;
    }
    oReader.readAsDataURL(selectedImg);
}

function deleteArticle(bid,aid)
{
	bootbox.confirm("Are you sure?", function(result) {
		if (result==true)
		{
			$.post('http://b2.com/deleteArticle/'+aid,{data:'none'},function(data)
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

function openNewArticleModal(interestName,interestId)
{   var device='Mobile';
    var width=$(document).width();
    if (width > 500)
    {
        device='Desktop';
    }

    $.post('http://b2.com/getTypes', {interestName: interestName, device: device}, function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#optionsDiv').html(markup);
            $('.buttons').tooltip();
            $('#newArticleModal').modal('show');
            $('#category').val(interestId);
            $('#articleType').val('Article');

            if (device=='Mobile')
            {
                $('.mobileButton').addClass('mobileButtons');
                $('.buttons').addClass('mobileButtons');
            }
        }
    });
}

function changeArticleType(button,type)
{
    $('#articleType').val(type);
    $('.buttons').removeClass('active');
    $(button).addClass('active');s
}

function changeClass(button)
{
    $(".labelButtons").removeClass("btn-info");
    $("#"+button+"Label").addClass("btn-info");
    if (button == 'people')
        document.getElementById('search').placeholder="Search Barters";
    else
        document.getElementById('search').placeholder="Search Content";
}

function executeSearch()
{
    var keywords = $("#search").val();
    var search = $("input:radio[name=searchOptions]:checked").val();
    var constraint = 'all';
    var request = 'home';

    if (keywords.length > 2)
    {
        $.post('http://b2.com/getSuggestions', {search: search, keywords: keywords, constraint: constraint, request: request}, function(data)
        {
            if(data=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                if(data)
                {
                    $("#searchText").html(data);
                    $('#searchModal').fadeIn();
                }
            }
        });
    }
}

function hoverEffect(element)
{
    element.style.backgroundColor="skyblue";
}
function normalEffect(element)
{
    element.style.backgroundColor="whitesmoke";
}

function visitProfile(username)
{
    window.location='http://b2.com/user/'+username;
}