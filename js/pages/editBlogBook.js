var oTable=null;
$(document).ready(function()
{
    var bbId = $("#blogBookId").val();
    oTable=$('#example').dataTable( {
        "ajax": 'http://localhost/b2v2/getChapterData/'+bbId,
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
    } );

    $('#updateBlogBookForm').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="updateBlogBookSubmit"]',
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

    $('#updateBlogBookForm').submit(function(event)
    {
        /* stop form from submitting normally */
        event.preventDefault();
    });
});

function updateBlogBookCover()
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

function updateBlogBook(blogBookId)
{
    $("#messages").html("");

    var cover = $('#uploadCover')[0].files[0];
    var title = $("#title").val();
    var description = $("#shortDescription").val();
    var category = $("#category").val();
    var ifc = $("#ifc").val();

    var formdata = new FormData();
    formdata.append("id", blogBookId);
    if (cover)
        formdata.append("cover", cover);
    formdata.append("title", title);
    formdata.append("description", description);
    formdata.append("category", category);
    formdata.append("ifc", ifc);

    var ajax = new XMLHttpRequest();
    ajax.addEventListener("load", completeUpdateHandler, false);
    ajax.open("POST", "http://localhost/b2v2/editBlogBook");
    ajax.send(formdata);
}

function completeUpdateHandler()
{
    var error= this.responseText;
    if(error=='wH@tS!nTheB0x')
        window.location='http://localhost/b2v2/offline';
    else
        $("#messages").html("<strong>Done!</strong>");
}


function deleteChapter(bid,dcid)
{
    bootbox.confirm("Are you sure?", function(result) {
        if (result==true)
        {
            $.post('http://localhost/b2v2/deleteChapter',{id:dcid},function(data)
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