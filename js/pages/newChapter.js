var submitted = false;
var embed = 0;
var res = 0;
var med = 0;
var oTableResource=null;
var oTableMedia=null;
var uploading = false;
$(document).ready(function()
{
    $('#summernote').summernote({
        height:430,
        onkeydown: function(e) {
            checkCharacters();
        }
    });


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
                        extension: 'mp4,mp3',
                        maxSize: 204800 * 1024,   // 200 MB
                        message: 'Upto 200 MB only, file can be either mp3 or mp4.'
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

    $('#postForm').submit(function(event)
     {
        //* stop form from submitting normally *//*
        event.preventDefault();
    });

    window.onbeforeunload = function(e) {
        if (submitted == false)
            return 'Any unsaved changes will be lost.';
    };
});

function showPreview()
{
    var sHTML = $('#summernote').code();
    var length = sHTML.length;
    var title = $('#title').val();
    if(length > 139 && title.length > 0)
    {
            $('.embed').hide();
            $("#error-box").html("");
            $("#previewHTML").html(sHTML);
            $("#preview").fadeIn(1500);
            $(".summernote").css("opacity","0");
    }
    else
    {
        if (length < 140)
        {
            $('#previewButton').prop('disabled',true);
            $("#error-box").html("The chapter must contain min 140 characters.");
        }
        if (title.length == 0)
        {
            $('#previewButton').prop('disabled',true);
            $('#titleError').html("Chapter name is required.");
        }
    }
}

function removeError()
{
    var title = $('#title').val();
    if (title.length > 0)
    {
        $('#titleError').html("");
        $('#previewButton').prop('disabled',false);
    }
    else
    {
        $('#titleError').html("Chapter name is required.");
        $('#previewButton').prop('disabled',true);
    }
}

function editContent()
{

    $("#preview").fadeOut(500);
    $(".summernote").css("opacity","1");
    $("#previewHTML").html("");
    $('.embed').show();
}


function checkCharacters()
{
    var sHTML = $('#summernote').code();
    var length = sHTML.length;
    if (length < 140)
    {
        $("#error-box").html("The chapter must contain min 140 characters.");
        $('#previewButton').prop('disabled', true);
    }
    else
    {
        $('#previewButton').prop('disabled', false);
        $("#error-box").html("");
    }
}

//this is the function to post the Article
function saveChapter(blogBookId)
{
    var title = $("#title").val();
    var content = $('#previewHTML').html();
    $('#cancelEditButton').hide();
    $('#saveEditButton').hide();
    $('#updatingMsg').html("<img src='http://b2.com/Images/icons/waiting.gif'> Saving...");
    $('#updatingMsg').show();
    $.post('http://b2.com/createChapter', {title: title, content: content, bookid: blogBookId}, function(message)
    {
        if(message=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        if (message=="success")
        {
            submitted = true;
            $("#preview").fadeOut(500);
            $("#previewHTML").html("");
            $("#chapterSuccessfullyPostedModal").modal({
                keyboard:false,
                show:true,
                backdrop:'static'
            });
        }
    });
}

function anotherChapter(acBlogBookId)
{
    $("#chapterSuccessfullyPostedModal").modal('hide');
    window.location.href = "http://b2.com/newChapter/"+acBlogBookId;
}

function returnToDashboard()
{
    $("#chapterSuccessfullyPostedModal").modal('hide');
    window.location.href = "http://b2.com/blogBookDashboard";
}

//this is the function to uploadMedia
function uploadMedia()
{
    $('#uploadMediaModal').modal('show');
}

function getMedia()
{
    $('#getMediaModal').modal('show');

    if (med == 0)
    {
        oTableMedia=$('#mediaTable').dataTable( {
            "ajax": 'http://b2.com/getMediaWritingData',
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
        } );
        med++;
    }

}

function newMedia()
{
    if (uploading == false)
        $('#newMediaModal').modal('show');
    else
        bootbox.alert('Please wait for the existing upload to get over.');
}

function useMedia(path,title)
{
    var content = $('#summernote').code();
    var strpath=path;

	if ((strpath.search('.mp4') > 0))
	{
		content += "<video class='embed' width='50%' height='50%' controls><source src='"+path+"'></video>&nbsp;<abbr title='For Internet Explorer, right-click on the play button and select play/pause'>Trouble playing Media?&nbsp;<span class='glyphicon glyphicon-question-sign'></span></abbr><br>";
	}
	else if ((strpath.search('.mp3') > 0))
	{
		content += "<audio class='embed' controls><source src='"+path+"'></audio>&nbsp;<abbr title='For Internet Explorer, right-click on the play button and select play/pause'>Trouble playing Media?&nbsp;<span class='glyphicon glyphicon-question-sign'></span></abbr><br>";
	}

    $('#summernote').code(content);
    $('#getMediaModal').modal('hide');
    $('#uploadMediaModal').modal('hide');
}
/*
 var content = $('#summernote').code();
 content+="<br><embed src='Waving.mp4'></embed>";
 $('#summernote').code(content);
 */

//this is the function of uploading new Media File

function _(el)
{
    return document.getElementById(el);
}

function uploadNewMedia()
{
    $('#newMediaForm').data('bootstrapValidator').validate();

    if($('#newMediaForm').data('bootstrapValidator').isValid())
    {
        var file2 = _("newMedia").files[0];
        var mt=$('#mediaTitle').val();
        var type=file2.type;
        var ext=type.slice(-3);
        var formdata = new FormData();
        formdata.append("userMedia", file2);
        formdata.append("mediaTitle", mt);
        formdata.append("ext", ext);
        formdata.append("origin", "content");
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "http://b2.com/uploadMedia");
        ajax.send(formdata);
        $('#newMediaModal').modal('hide');
        $('#uploadMediaModal').modal('hide');
        $('body,html').animate({ scrollTop: 0}, 0);
    }
}

function completeHandler(event)
{
    var content = $('#summernote').code();
    var strpath=this.responseText;
    if(strpath=='wH@tS!nTheB0x')
        window.location='http://b2.com/offline';
    else
    {
        if ((strpath.search('.mp4') > 0))
        {
            content += "<video class='embed' width='320' height='240' controls><source src='"+strpath+"'></video>&nbsp;<abbr title='For Internet Explorer, right-click on the play button and select play/pause'>Trouble playing Media?&nbsp;<span class='glyphicon glyphicon-question-sign'></span></abbr><br>";
        }
        else if ((strpath.search('.mp3') > 0))
        {
            content += "<audio class='embed' controls><source src='"+strpath+"'></audio>&nbsp;<abbr title='For Internet Explorer, right-click on the play button and select play/pause'>Trouble playing Media?&nbsp;<span class='glyphicon glyphicon-question-sign'></span></abbr><br>";
        }

        $('#summernote').code(content);
        $('#uploadController').fadeOut();
        $("#uploadName").html("");
        $('#newMedia').val("");
        $('#mediaTitle').val("");
        uploading = false;
    }
}
function progressHandler(event){
    var percent = (event.loaded / event.total) * 100;
    $('#uploadController').fadeIn();
    document.getElementById('progressBar').style.width = percent+'%';
    $("#uploadName").html($("#mediaTitle").val());
}

function errorHandler(event)
{
    _("uploadName").innerHTML = "<h4 class='obstruct'>Sorry, upload failed!</h4>";
    $('body,html').animate({ scrollTop: 0}, 0);
    uploading = false;
}
function abortHandler(event)
{
    _("uploadName").innerHTML = "<h4 class='obstruct'>Upload aborted</h4>";
    $('body,html').animate({ scrollTop: 0}, 0);
    uploading = false;
}

//functions for adding resources

function addResource()
{
    $('#getResourceModal').modal('show');
    if (res == 0)
    {
        oTableResource=$('#resourcesTable').dataTable( {
            "ajax": 'http://b2.com/getResourceWritingData',
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
        } );
        res++;
    }

}

function useResource(rid,title)
{
    var content = $('#summernote').code();
    content+="<a href='http://b2.com/resource/"+rid+"' class='btn btn-success'>"+title+"</a>";
    $('#summernote').code(content);
    $('#getResourceModal').modal('hide');
}

function changeButton()
{
    var mediaPath = $('#newMedia').val();
    $('#selectFileButton').html(mediaPath);
}