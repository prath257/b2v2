$(document).ready(function()
{
    var width = $(document).width();
    if (width<=700)
    {
        $(".table").addClass("table-bordered");
    }

	oTable=$('#example').dataTable( {
		"ajax": 'getBookData',
		"lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
	} );

    /*Search*/
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

    //this is the code to show the blogbook stats
    var chartBooks =Morris.Donut({
        element: 'donut-books',
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

    requestData(90, chartBooks,'Books');

    $('ul.ranges a').click(function(e)
    {
        e.preventDefault();

        // Get the number of days from the data attribute
        var el = $(this);
        days = el.attr('data-range');
        var pp=el.closest('li');
        var p=pp[0];
        if (p.id=='b'+days)
        {
            $("#booksData>li.active").removeClass("active");
            pp.addClass('active');
            requestData(days, chartBooks,'Books');

        }


    })



    $('#searchForm').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
        executeSearch();
    });

    $("#peopleLabel").addClass("btn-info");
    document.getElementById('search').placeholder="Search Barters";
});

function deleteBlogBook(bid,dbbid)
{
    bootbox.confirm("Are you sure?", function(result) {
        if (result==true)
        {
            $.post('http://b2.com/deleteBlogBook',{id:dbbid},function(data)
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


function reviewBlogBook(rbbid)
{


    $("#ReviewBlogBook"+rbbid).prop('disabled', true);

    $.ajax({
        type: "POST",
        url: 'http://b2.com/reviewBlogBook',
        data:{id: rbbid},
        beforeSend: function()
        {
            $("#ReviewBlogBook"+rbbid).hide();
            $("#waitingPic"+rbbid).show();

        }
    }).done(function(message)
    {
        if(message=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $("#waitingPic"+rbbid).fadeOut();

            /*
             $("#ReviewBlogBook"+rbbid).html("Submit");
             $("#ReviewBlogBook"+rbbid).fadeOut();*/


            bootbox.alert("Submitted for review successfully!");
        }
    });


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