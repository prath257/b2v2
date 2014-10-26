$(document).ready(function()
{
    var width = $(document).width();
    if (width<=700)
    {
        $(".table").addClass("table-bordered");
    }

	oTable=$('#example').dataTable( {
		"ajax": 'http://localhost/b2v2/getResourceData',
		"lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
	} );

	$('#newResourceForm').bootstrapValidator({
		live:'enabled',
		submitButtons: 'button[id="newResourceSubmit"]',
		message: 'This value is not valid',
		fields: {
			resourceTitle: {
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
			},
			resourceFile: {
				message: 'The Resource File is not valid',
				validators: {
					file: {
						extension:'rar,zip,tar,tar.gz',
						//type:'application/x-tar,application/x-rar-compressed,application/x-gtar,application/zip',
						maxSize: 51200 * 1024,   // 200 MB
						message: 'Upto 50 MB only, chose the correct file '
					},
					notEmpty:{
						message:'Please Select a Resource File'
					}
				}
			}

		}
	});

	$('#newResourceForm').submit(function(event)
	{
		/* stop form from submitting normally */
		event.preventDefault();
	});

});
function deleteResource(bid,rid)
{
	bootbox.confirm("Are you sure?", function(result) {
		if (result==true)
		{
			$.post('http://localhost/b2v2/deleteResource',{id:rid},function(data)
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

function _(el)
{
	return document.getElementById(el);
}

function uploadResource()
{
	var mu = $('#resourceFile').val();

	if(mu)
	{
        $('#styledInput').addClass('disabled');
		var file2 = _("resourceFile").files[0];
		var mt=$('#resourceTitle').val();
        var desc = $("#shortDescription").val();
		var cat=$('#category').val();
		var ifc=$('#ifc').val();
		var formdata = new FormData();
		formdata.append("rFile", file2);
		formdata.append("title", mt);
        formdata.append("description", desc);
		formdata.append("category", cat);
		formdata.append("ifc",ifc);
		var ajax = new XMLHttpRequest();
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		ajax.open("POST", "http://localhost/b2v2/createResource");
		ajax.send(formdata);

	}
}
function completeHandler(event)
{
    var error= this.responseText;
    if(error=='wH@tS!nTheB0x')
        window.location='http://localhost/b2v2/offline';
    else
	window.location.reload();
}
function progressHandler(event){
    var percent = (event.loaded / event.total) * 100;
    $('#uploadController').fadeIn();
    document.getElementById('progressBar').style.width = percent+'%';
}

function errorHandler(event)
{
	_("status").innerHTML = "Upload Failed";
}
function abortHandler(event)
{
	_("status").innerHTML = "Upload Aborted";
}

function changeFileName()
{
    $('#fileName').html($('#resourceFile').val());
}