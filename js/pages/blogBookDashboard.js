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

    $('#newBlogBookForm').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="newBlogBookSubmit"]',
        message: 'This value is not valid',
        fields: {
            uploadCover: {
                message: 'The cover pic is not valid',
                validators: {
                    file: {
                        //extension: 'jpeg,png,jpg,gif',
                        type: 'image/jpeg,image/jpg,image/png,image/gif',
                        maxSize: 2048 * 1024,   // 2 MB
                        message: '  Max 2MB, allowed types: JPG,PNG or GIF'
                    },
                    notEmpty: {
                        message: 'Please Select a Book Cover!'
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
                        message: 'The title must be at least a character and less than 255 characters'
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
                        max: 10000,
                        message: 'Less than 10000i'
                    }
                }
            }
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
});

function changeBlogBookCover()
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


function deleteBlogBook(bid,dbbid)
{
    bootbox.confirm("Are you sure?", function(result) {
        if (result==true)
        {
            $.post('http://localhost/b2v2/deleteBlogBook',{id:dbbid},function(data)
            {
                if(data=='wH@tS!nTheB0x')
                    window.location='http://localhost/b2v2/offline';
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
        url: 'http://localhost/b2v2/reviewBlogBook',
        data:{id: rbbid},
        beforeSend: function()
        {
            $("#ReviewBlogBook"+rbbid).hide();
            $("#waitingPic"+rbbid).show();

        }
    }).done(function(message)
    {
        if(message=='wH@tS!nTheB0x')
            window.location='http://localhost/b2v2/offline';
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
        $.post('http://localhost/b2v2/getSuggestions', {search: search, keywords: keywords, constraint: constraint, request: request}, function(data)
        {
            if(data=='wH@tS!nTheB0x')
                window.location='http://localhost/b2v2/offline';
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
    window.location='http://localhost/b2v2/user/'+username;
}