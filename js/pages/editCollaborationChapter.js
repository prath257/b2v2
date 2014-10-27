var submitted = false;
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

    $('#postForm').bootstrapValidator({
        live:'enabled',
        message: 'This value is not valid',
        fields: {
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
            }
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
                        extension: 'mp4,webm,mp3,wav,avi,asf,wmv,m4a,mkv,flv',
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
    $('#postForm').data('bootstrapValidator').validate();

    if($('#postForm').data('bootstrapValidator').isValid() && title.length > 0)
    {

        if (length>140)
        {
            $('.embed').hide();
            $("#error-box").html("");
            $("#previewHTML").html(sHTML);
            $("#preview").fadeIn(1500);
            $(".summernote").css("opacity","0");
        }
        else
        {
            $('#previewButton').prop('disabled',true);
            $("#error-box").html("The chapter must contain min 140 characters.")
        }
    }
    else
    {
        $('#title').focus();
        $('#previewButton').prop('disabled',true);
    }
}

function editContent()
{
    $("#preview").fadeOut(500);
    $(".summernote").css("opacity","1");
    $("#previewHTML").html("");
    $('.embed').show();
    $('#previewButton').removeAttr('disabled');
}


function checkCharacters()
{
    var sHTML = $('#summernote').code();
    var length = sHTML.length;
    if (length < 140)
    {
        $('#previewButton').prop('disabled',true);
        $("#error-box").html("The chapter must contain min 140 characters.")
    }
    else
    {
        $('#previewButton').prop('disabled',false);
        $("#error-box").html("")
    }
}

function checkTitle()
{
    var title = $('#title').val();
    if (title.length > 0)
        $('#previewButton').prop('disabled',false);
    else
        $('#previewButton').prop('disabled',true);
}

function saveChapter(chapterId,userid)
{
    var title = $("#title").val();
    var content = $('#previewHTML').html();

    $('#cancelEditButton').hide();
    $('#saveEditButton').hide();
    $('#updatingMsg').html("<img src='http://b2.com/Images/icons/waiting.gif'> Updating...");
    $('#updatingMsg').show();
    $.post('http://b2.com/updateCollaborationChapter', {id: chapterId, title: title, content: content, userid: userid}, function(message)
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
    window.location.href = "http://b2.com/collaborationNewChapter/"+acBlogBookId;
}

function returnToDashboard()
{
    $("#chapterSuccessfullyPostedModal").modal('hide');
    window.location.href = "http://b2.com/collaborationsDashboard";
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

	if ((strpath.search('.mp4') > 0) || (strpath.search('.webm') > 0))
	{
		content += "<video class='embed' width='320' height='240' controls><source src='"+path+"'></video>&nbsp;<abbr title='For Internet Explorer, right-click on the play button and select play/pause'>Trouble playing Media?&nbsp;<span class='glyphicon glyphicon-question-sign'></span></abbr><br>";
	}
	else if ((strpath.search('.mp3') > 0) || (strpath.search('.wav') > 0))
	{
		content += "<audio class='embed' controls><source src='"+path+"'></audio>&nbsp;<abbr title='For Internet Explorer, right-click on the play button and select play/pause'>Trouble playing Media?&nbsp;<span class='glyphicon glyphicon-question-sign'></span></abbr><br>";
	}
	else if ((strpath.search('.avi') > 0) || (strpath.search('.asf') > 0) || (strpath.search('.wmv') > 0))
	{
		content += "<embed class='embed' width='320' height='240' src='"+path+"'></embed>&nbsp;<abbr title='For Internet Explorer, right-click on the play button and select play/pause'>Trouble playing Media?&nbsp;<span class='glyphicon glyphicon-question-sign'></span></abbr><br>";
	}
	else if ((strpath.search('.m4a') > 0) || (strpath.search('.mkv') > 0) || (strpath.search('.flv') > 0))
	{
		content += "<a href='"+path+"' target='_blank'>"+title+"</a>&nbsp;<abbr title='For Internet Explorer, right-click on the play button and select play/pause'>Trouble playing Media?&nbsp;<span class='glyphicon glyphicon-question-sign'></span></abbr><br>";
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
        if ((strpath.search('.mp4') > 0) || (strpath.search('.webm') > 0) || (strpath.search('.ogg') > 0))
        {
            content += "<video class='embed' width='320' height='240' controls><source src='"+strpath+"'></video>&nbsp;<abbr title='For Internet Explorer, right-click on the play button and select play/pause'><span class='glyphicon glyphicon-question-sign'></span></abbr><br>";
        }
        else if ((strpath.search('.mp3') > 0) || (strpath.search('.wav') > 0) || (strpath.search('.ogg') > 0))
        {
            content += "<audio class='embed' controls><source src='"+strpath+"'></audio>&nbsp;<abbr title='For Internet Explorer, right-click on the play button and select play/pause'><span class='glyphicon glyphicon-question-sign'></span></abbr><br>";
        }
        else if ((strpath.search('.avi') > 0) || (strpath.search('.asf') > 0) || (strpath.search('.wmv') > 0))
        {
            content += "<embed class='embed' width='320' height='240' src='"+strpath+"'></embed>&nbsp;<abbr title='For Internet Explorer, right-click on the play button and select play/pause'><span class='glyphicon glyphicon-question-sign'></span></abbr><br>";
        }
        else if ((strpath.search('.m4a') > 0) || (strpath.search('.mkv') > 0) || (strpath.search('.flv') > 0))
        {
            content += "<a href='"+strpath+"' target='_blank'>"+$('#mediaTitle').val()+"</a>&nbsp;<abbr title='For Internet Explorer, right-click on the play button and select play/pause'><span class='glyphicon glyphicon-question-sign'></span></abbr><br>";
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

function goToSettings()
{
    var id = $('#chapterId').val();
    id = parseInt(id);
    $.post('http://b2.com/doneEditing', {id: id}, function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            var colId = $('#collaborationId').val();
            colId = parseInt(colId);
            window.location='http://b2.com/collaborationSettings/'+colId;
        }
    });
}

function goToChapters()
{
    var id = $('#chapterId').val();
    id = parseInt(id);
    $.post('http://b2.com/doneEditing', {id: id}, function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            var colId = $('#collaborationId').val();
            colId = parseInt(colId);
            window.location='http://b2.com/editCollaborationChapters/'+colId;
        }
    });
}