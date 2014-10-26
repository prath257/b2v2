var oTable=null;
$(document).ready(function()
{
    var cId = $("#collaborationId").val();
    oTable1=$('#example').dataTable( {
        "ajax": 'http://b2.com/getCollaborationChapterData/'+cId,
        "lengthMenu": [[2, 10, 15, -1], [2, 10, 15, "All"]]
    } );

    oTable2=$('#example2').dataTable( {
        "ajax": 'http://b2.com/getCollaborationContributorData/'+cId,
        "lengthMenu": [[2, 10, 15, -1], [2, 10, 15, "All"]]
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

    $('#updateCollaborationForm').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="updateCollaborationSubmit"]',
        message: 'This value is not valid',
        fields: {
            uploadCover: {
                message: 'The cover pic is not valid',
                validators: {
                    file: {
                        extension: 'jpeg,png,jpg,gif',
                        type: 'image/jpeg,image/png,image/gif',
                        maxSize: 2048 * 1024,   // 2 MB
                        message: '  Select an Image with size upto 2MB, allowed types: JPG,PNG or GIF'
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
                        max: 500,
                        message: 'Min 10 and Max 500 characters'
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

    $('#updateCollaborationForm').submit(function(event)
    {
        /* stop form from submitting normally */
        event.preventDefault();
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

function updateCollaborationCover()
{
    var previewId = document.getElementById('existingCover');
    previewId.src = '';

    var selectedImg = $('#uploadCover')[0].files[0];

    var oReader = new FileReader();
    oReader.onload = function(e)
    {
        previewId.src=e.target.result;
    }
    oReader.readAsDataURL(selectedImg);
}

function updateCollaboration(collaborationId)
{
    $("#messages").html("");

    var cover = $('#uploadCover')[0].files[0];
    var title = $("#title").val();
    var description = $("#shortDescription").val();
    var category = $("#category").val();
    var ifc = $("#ifc").val();

    var formdata = new FormData();
    formdata.append("id", collaborationId);
    if (cover)
        formdata.append("cover", cover);
    formdata.append("title", title);
    formdata.append("description", description);
    formdata.append("category", category);
    formdata.append("ifc", ifc);

    var ajax = new XMLHttpRequest();
    ajax.addEventListener("load", completeUpdateHandler, false);
    ajax.open("POST", "http://b2.com/editCollaboration");
    ajax.send(formdata);
}

function completeUpdateHandler()
{
    var error=this.responseText;
    if(error=='wH@tS!nTheB0x')
        window.location='http://b2.com/offline';
    else
        $("#messages").html("<strong>Done!</strong>");
}


function deleteChapter(bid,dcid)
{
    bootbox.confirm("Are you sure?", function(result) {
        if (result==true)
        {
            $.post('http://b2.com/deleteCollaborationChapter',{id:dcid},function(error)
            {
                if(error=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                {
                    var row = $(bid).closest("tr").get(0);
                    oTable1.fnDeleteRow(oTable1.fnGetPosition(row));
                }
            })
        }
    });
}

function deleteUser(bid,uid)
{
    bootbox.confirm("Are you sure?", function(result) {
        if (result==true)
        {
            var cId = $("#collaborationId").val();
            cId = parseInt(cId);
            $.post('http://b2.com/deleteContributor', {cid: cId, uid: uid}, function(error)
            {
                if(error=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                {
                    var row = $(bid).closest("tr").get(0);
                    oTable2.fnDeleteRow(oTable2.fnGetPosition(row));
                }
            });
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