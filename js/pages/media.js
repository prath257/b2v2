var oTable=null;
$(document).ready(function()
{
    var width = $(document).width();
    if (width<=700)
    {
        $(".table").addClass("table-bordered");
    }

	oTable=$('#example').dataTable( {
		"ajax": 'http://localhost/b2v2/getMediaData',
		"lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
	} );

    $('#newMediaForm').bootstrapValidator({
        live: 'enabled',
        submitButtons: 'button[id="submitMedia"]',
        message: 'This value is not valid',
        fields: {
            mediaTitle: {
                validators: {
                    notEmpty: {
                        message: 'This field is required'
                    }
                }
            },
            newMedia: {
                message: 'The Media File is not valid',
                validators: {
                    file: {
                        extension: 'mp3,mp4,avi,mkv,flv,asf,m4a,wav,wmv',
                        maxSize: 204800 * 1024,   // 200 MB
                        message: 'Upto 200 MB only, chose the correct file '
                    },
                    notEmpty:{
                        message:'Please Select a Media File'
                    }
                }
            }
        }
    });

    $('#newPublicMediaForm').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="newPublicMediaUpload"]',
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
                        message: 'Please Select a Cover!'
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
                    },
                    notEmpty: {
                        message: 'This field cannot be empty.'
                    }
                }
            },
            newMedia2: {
                message: 'The Media File is not valid',
                validators: {
                    file: {
                        extension: 'mp3,mp4,avi,mkv,flv,asf,m4a,wav,wmv',
                        maxSize: 204800 * 1024,   // 200 MB
                        message: 'Upto 200 MB only, chose the correct file '
                    },
                    notEmpty:{
                        message:'Please Select a Media File'
                    }
                }
            }
        }
    });

    $('#newMediaForm').submit(function(event)
    {
        /* stop form from submitting normally */
        event.preventDefault();
    });

    $('#newPublicMediaForm').submit(function(event)
    {
        /* stop form from submitting normally */
        event.preventDefault();
    });
});
function _(el)
{
	return document.getElementById(el);
}

function changeMediaCover()
{
    var selectedImg = $('#uploadCover')[0].files[0];

    if (selectedImg)
    {
        var previewId = document.getElementById('defaultCover');
        previewId.src = '';

        var oReader = new FileReader();
        oReader.onload = function(e)
        {
            previewId.src=e.target.result;
        }
        oReader.readAsDataURL(selectedImg);
    }
}

function changeEditMediaCover()
{
    var selectedImg = $('#uploadCover2')[0].files[0];

    if (selectedImg)
    {
        var previewId = document.getElementById('defaultCover2');
        previewId.src = '';

        var oReader = new FileReader();
        oReader.onload = function(e)
        {
            previewId.src=e.target.result;
        }
        oReader.readAsDataURL(selectedImg);
    }
}

function uploadNewMedia()
{
    $('#newMediaForm').data('bootstrapValidator').validate();

    if($('#newMediaForm').data('bootstrapValidator').isValid())
    {
        $('#changePP').addClass('disabled');
		var file2 = _("newMedia").files[0];
        var type=file2.type;
        var ext=type.slice(-3);
		var mt=$('#mediaTitle').val();
		var formdata = new FormData();
		formdata.append("userMedia", file2);
		formdata.append("mediaTitle", mt);
        formdata.append("ext", ext);
        formdata.append("origin", "media");
		var ajax = new XMLHttpRequest();
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		ajax.open("POST", "http://localhost/b2v2/uploadMedia");
		ajax.send(formdata);
	}
}

function completeHandler(event)
{
    var response = this.responseText;
    if(response=='wH@tS!nTheB0x')
        window.location='http://localhost/b2v2/offline';
    else
    {
        if (response == 'success')
        {
            bootbox.alert("Upload Successfull!", function() {
                $('#uploadMedia').val(null);
                $('#mediaTitle').val('');
                $('#newMediaModal').modal('hide');
                window.location.reload();
            });
        }
        else
        {
            bootbox.alert(response);
        }
    }
}
function progressHandler(event)
{
	var percent = (event.loaded / event.total) * 100;
	$('#mediaProgress').fadeIn();
    document.getElementById('progressBar').style.width = percent+'%';
}

function errorHandler(event)
{
	_("statusMedia").innerHTML = "Upload Failed";
}
function abortHandler(event)
{
	_("statusMedia").innerHTML = "Upload Aborted";
}

//Upload functions for Public Media
function uploadNewMedia2()
{
    $('#newPublicMediaForm').data('bootstrapValidator').validate();

    if($('#newPublicMediaForm').data('bootstrapValidator').isValid())
    {
        $('#changePP2').addClass('disabled');
        var file2 = _("newMedia2").files[0];
        var title=$('#title').val();
        var description=$('#shortDescription').val();
        var category=$('#category').val();
        var ifc=$('#ifc').val();
        var cover = _("uploadCover").files[0];
        var type=file2.type;
        var ext=type.slice(-3);
        var formdata = new FormData();
        formdata.append("media", file2);
        formdata.append("title", title);
        formdata.append("description", description);
        formdata.append("category", category);
        formdata.append("ifc", ifc);
        formdata.append("cover", cover);
        formdata.append("ext", ext);
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler2, false);
        ajax.addEventListener("load", completeHandler2, false);
        ajax.addEventListener("error", errorHandler2, false);
        ajax.addEventListener("abort", abortHandler2, false);
        ajax.open("POST", "http://localhost/b2v2/uploadPublicMedia");
        ajax.send(formdata);
    }
}

function completeHandler2(event)
{

    var response = this.responseText;
    if(response=='wH@tS!nTheB0x')
        window.location='http://localhost/b2v2/offline';
    else
    {
        if (response == 'success')
        {
            bootbox.alert("Upload Successfull!", function() {

                window.location = 'http://localhost/b2v2/mediaDashboard';
            });
        }
        else
        {
            bootbox.alert(response);
        }
    }
}
function progressHandler2(event)
{
    var percent = (event.loaded / event.total) * 100;
    $('#mediaProgress2').fadeIn();
    document.getElementById('progressBar2').style.width = percent+'%';
}

function errorHandler2(event)
{
    _("statusMedia2").innerHTML = "Upload Failed";
}
function abortHandler2(event)
{
    _("statusMedia2").innerHTML = "Upload Aborted";
}

function previewMedia(bid)
{

	var path=bid.id;
	var title = bid.name;
	var content;
	var strpath=path;
	if((strpath.search('.mkv')== -1)||(strpath.search('.flv')== -1)||(strpath.search('.m4a')== -1))
	{
		content="<div style='text-align: center'><h2>"+title+"</h2><br><br><object autoplay='false'width='300' height='200' data='"+path+"'><a href='"+path+"'>"+title+"</a></object></div>";
	}
	else
	{
		content="<div style='text-align: center'><h2>"+title+"</h2><br><br><br><embed  autoplay='false' width='300' height='200' src='"+path+"'></embed></div>";
	}
    $('#preview').html(content);
	$('#previewMediaModal').modal('show');

}


function deleteMedia(bid,mid)
{
	bootbox.confirm("Are you sure?", function(result) {
		if (result==true)
		{
			$.post('http://localhost/b2v2/deleteMedia',{id:mid},function(data)
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

function changeButton()
{
    var mediaPath = $('#newMedia').val();
    $('#selectFileButton').html(mediaPath);
}

function changeButton2()
{
    var mediaPath = $('#newMedia2').val();
    $('#selectFileButton2').html(mediaPath);
}

function editDetails(id)
{
    $('#loading').show();
    $('#fieldset').html('');
    $('#editMediaModal').modal('show');
    $.post('http://localhost/b2v2/getMediaDetails', {id: id}, function(markup)
    {
        if(markup=='wH@tS!nTheB0x')
            window.location='http://localhost/b2v2/offline';
        else
        {
            $('#loading').hide();
            $('#fieldset').html(markup);

            $('#editMediaForm').bootstrapValidator({
                live:'enabled',
                submitButtons: 'button[id="editMediaUpload"]',
                message: 'This value is not valid',
                fields: {
                    uploadCover2: {
                        message: 'The cover pic is not valid',
                        validators: {
                            file: {
                                //extension: 'jpeg,png,jpg,gif',
                                type: 'image/jpeg,image/jpg,image/png,image/gif',
                                maxSize: 2048 * 1024,   // 2 MB
                                message: '  Max 2MB, allowed types: JPG,PNG or GIF'
                            }
                        }
                    },
                    title2: {
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
                    shortDescription2: {
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
                    category2: {
                        validators: {
                            notEmpty: {
                                message: 'Please select a category'
                            }
                        }
                    },
                    ifc2: {
                        validators: {
                            integer: {
                                message: 'Number!'
                            },
                            between: {
                                min: 0,
                                max: 10000,
                                message: 'Less than 10000i'
                            },
                            notEmpty: {
                                message: 'This field cannot be empty.'
                            }
                        }
                    }
                }
            });

            $('#editMediaForm').submit(function(event)
            {
                /* stop form from submitting normally */
                event.preventDefault();
            });
        }
    });
}

function editMedia(id)
{
    $('#editMediaUpload').hide();
    $('#waiting').fadeIn();
    var title=$('#title2').val();
    var description=$('#shortDescription2').val();
    var category=$('#category2').val();
    var ifc=$('#ifc2').val();
    var cover = _("uploadCover2").files[0];
    var formdata = new FormData();
    formdata.append("id", id);
    formdata.append("title", title);
    formdata.append("description", description);
    formdata.append("category", category);
    formdata.append("ifc", ifc);
    if (cover)
        formdata.append("cover", cover);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener("load", completeHandler3, false);
    ajax.open("POST", "http://localhost/b2v2/editPublicMedia");
    ajax.send(formdata);
}

function completeHandler3(event)
{
    var error = this.responseText;
    if(error=='wH@tS!nTheB0x')
        window.location='http://localhost/b2v2/offline';
    else
    {
        $('#waiting').hide();
        $('#editMediaModal').modal('hide');
        window.location.reload();
    }
}