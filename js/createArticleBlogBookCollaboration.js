$(document).ready(function()
{
    $('#newArticleForm').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="newArticleSubmit"]',
        message: 'This value is not valid',
        fields: {
            uploadArtCover: {
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
            Artcategory: {
                validators: {
                    notEmpty: {
                        message: 'Please select a category'
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

    $('#newBlogBookForm').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="newBlogBookSubmit"]',
        message: 'This value is not valid',
        fields: {
            uploadBBCover: {
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

    $('#newCollaborationForm').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="newCollaborationSubmit"]',
        message: 'This value is not valid',
        fields: {
            uploadCollabCover: {
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
});

function changeArticleCover()
{
    var previewId = document.getElementById('defaultArtCover');
    previewId.src = '';

    var selectedImg = $('#uploadArtCover')[0].files[0];

    var oReader = new FileReader();
    oReader.onload = function(e)
    {
        previewId.src=e.target.result;
    }
    oReader.readAsDataURL(selectedImg);
}

function openNewArticleModal()
{
    $("#Artcategory option[value='']").remove();
    var interestId = $('#Artcategory').val();
    var interestName = $("#Artcategory option[value='"+interestId+"']").text();
    var device='Mobile';
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

function changeBlogBookCover()
{
    var previewId = document.getElementById('defaultBBCover');
    previewId.src = '';

    var selectedImg = $('#uploadBBCover')[0].files[0];

    var oReader = new FileReader();
    oReader.onload = function(e)
    {
        previewId.src=e.target.result;
    }
    oReader.readAsDataURL(selectedImg);
}

function changeCollaborationCover()
{
    var previewId = document.getElementById('defaultCollabCover');
    previewId.src = '';

    var selectedImg = $('#uploadCollabCover')[0].files[0];

    var oReader = new FileReader();
    oReader.onload = function(e)
    {
        previewId.src=e.target.result;
    }
    oReader.readAsDataURL(selectedImg);
}