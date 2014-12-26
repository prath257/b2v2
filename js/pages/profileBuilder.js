var wizard=null;
var allVals = [];
var i=0;
var isPhone=false;
var timer;
var extension=null;
//Make global variables for selected image for further usage
var selectImgWidth,selectImgHeight,jcrop_api, boundx, boundy,isError=false;

var timerInterestMobile;
var timerInterestDesktop;

$(document).ready(function()
{


   var height=$(window).height();
   var width= $(window).width();
    if(height >500 && width >775)
    {
       $('#wimg1').fadeIn(3000);
       $('#wimg2').fadeIn(3000);
       $('#wimg3').fadeIn(3000);

    }
    else
    {
        isPhone=true;
        $('#welcomeDiv').hide();
        $('#welcomeModal').modal({
            keyboard:false,
            show:true,
            backdrop:'static'
        });
    }

    $('#carousel').carousel({
        interval: 4000
    });
    //this is the code for form validation
    $('#pform').bootstrapValidator({
        live: 'enabled',
        submitButtons: 'button[id="mysubmit"]',
        message: 'This value is not valid',
        fields: {
            profilePic: {
                message: 'The profile pic is not valid',
                validators: {
                    file: {
                        //extension: 'jpeg,png,jpg,gif',
                        type: 'image/jpeg,image/png,image/gif',
                        maxSize: 2048 * 1024,   // 2 MB
                        message: 'Size upto 2MB, types: JPG,PNG or GIF'
                    },
                    notEmpty: {
                        message: 'Please Select a awesome Profile Picture!'
                    }
                }
            }

        }
    });




    $('#aboutForm').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="asubmit"]',
        fields: {
            about: {
                validators: {
                    notEmpty:{
                        message:'This cant be Empty'
                    },
                    stringLength: {
                        max:300,
                        message: 'About you must be less than 300 characters'
                    }
                }
            }
        }
    });



    $('#interestForm').bootstrapValidator({
        live: 'enabled',
        submitButtons: 'button[id="isubmit"]',
        message: 'This value is not valid',
        fields: {
            'interests[]': {
                validators: {
                    choice: {
                        min: 3,
                        message: 'Please choose min 3 fields you are passionate about, you can add one of your choice'
                    }
                }
            }
        }
    });

    //these are for smartphones
    //this is the code for form validation
    $('#pformMobile').bootstrapValidator({
        live: 'enabled',
        submitButtons: 'button[id="mysubmitMobile"]',
        message: 'This value is not valid',
        fields: {
            profilePic: {
                message: 'The profile pic is not valid',
                validators: {
                    file: {
                        extension: 'jpeg,png,jpg,gif',
                        type: 'image/jpeg,image/png,image/gif',
                        maxSize: 2048 * 1024,   // 2 MB
                        message: 'Size upto 2MB, types: JPG,PNG or GIF'
                    },
                    notEmpty: {
                        message: 'Please Select a awesome Profile Picture!'
                    }
                }
            },
            profileTune:
            {
                message: 'The profile Tune is not valid',
                validators: {
                    file: {
                        extension: 'mp3,ogg,m4a,ra',
                        maxSize: 5120 * 1024,   // 5 MB
                        message: 'Size upto 5MB, types: mp3 ogg m4a ra'
                    }
                }
            }

        }
    });
    $('#aboutFormMobile').bootstrapValidator({
        live:'enabled',
        submitButtons: 'button[id="asubmitMobile"]',
        fields: {
            about: {
                validators: {
                    notEmpty:{
                        message:'This cant be Empty'
                    },
                    stringLength: {
                        max: 140,
                        message: 'About you must be less than 140 characters'
                    }
                }
            }
        }
    });



    $('#interestFormMobile').bootstrapValidator({
        live: 'enabled',
        submitButtons: 'button[id="isubmitMobile"]',
        message: 'This value is not valid',
        fields: {
            'interests[]': {
                validators: {
                    choice: {
                        min: 3,
                        message: 'Please choose min 3 fields you are passionate about, you can add one of your choice'
                    }
                }
            }
        }
    });



    $('#pform').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
    });

    $('#aboutForm').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
    });

    $('#interestForm').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
    });
    $('#pformMobile').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
    });

    $('#aboutFormMobile').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
    });

    $('#interestFormMobile').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
    });
    $('#primaryFormMobile').submit(function(event)
    {

        /* stop form from submitting normally */
        event.preventDefault();
    });

    $(".mycounter").flipCounterInit();

    //This is code for cropping the photo profile pic
    $("#profilePic").change(function()
    {

        if($('#pform').data('bootstrapValidator').isValid())
        {
            try
            {
                //this is the old code
                var previewId = document.getElementById('load_img');
                previewId.src = '';
                $('#image_div').hide();
                var flag = 0;

                // Get selected file parameters
                var selectedImg = $('#profilePic')[0].files[0];

                //Check the select file is JPG,PNG or GIF image
                var regex = /^(image\/jpeg|image\/png)$/i;
                if (! regex.test(selectedImg.type)) {
                    //$('.error').html('Please select a valid image file (jpg and png are allowed)').fadeIn(500);
                    flag++;
                    isError = true;
                }

                // Check the size of selected image if it is greater than 250 kb or not
                else if (selectedImg.size > 2048 * 1024) {
                    //$('.error').html('The file you selected is too big. Max file size limit is 2 MB').fadeIn(500);
                    flag++;
                    isError = true;
                }

                if(flag==0){
                    isError=false;
                    $('.error').hide(); //if file is correct then hide the error message


                    // Preview the selected image with object of HTML5 FileReader class
                    // Make the HTML5 FileReader Object
                    var oReader = new FileReader();
                    oReader.onload = function(e)
                    {

                        // e.target.result is the DataURL (temporary source of the image)
                        previewId.src=e.target.result;

                        // FileReader onload event handler
                        previewId.onload = function () {

                            // display the image with fading effect
                            $('#image_div').fadeIn(500);
                            selectImgWidth = previewId.naturalWidth; //set the global image width
                            selectImgHeight =previewId.naturalHeight;//set the global image height

                            // Create variables (in this scope) to hold the Jcrop API and image size

                            // destroy Jcrop if it is already existed
                            if (typeof jcrop_api != 'undefined')
                                jcrop_api.destroy();

                            // initialize Jcrop Plugin on the selected image
                            $('#load_img').Jcrop({
                                minSize: [32, 32], // min crop size
                                // aspectRatio : 1, // keep aspect ratio 1:1
                                bgFade: true, // use fade effect
                                bgOpacity: .3, // fade opacity
                                onChange: showThumbnail,
                                onSelect: showThumbnail,
                                aspectRatio: 16/14,
                                setSelect:   [ 200, 200, 400, 400 ]
                            }, function(){

                                // use the Jcrop API to get the real image size
                                var bounds = this.getBounds();
                                boundx = bounds[0];
                                boundy = bounds[1];

                                // Store the Jcrop API in the jcrop_api variable
                                jcrop_api = this;
                            });
                        };
                    };

                    // read selected file as DataURL
                    oReader.readAsDataURL(selectedImg);
                }
            }
            catch(error)
            {
                alert(error);
            }
            $('#dpSelect').hide();
            $('#mysubmit').show();
            $('#myCancel').show();

        }
    });


    //this is for smartphone
    //This is code for cropping the photo profile pic
    $("#profilePicMobile").change(function()
    {
        var previewId = document.getElementById('load_imgMobile');
        previewId.src = '';
        $('#image_divMobile').hide();
        var flag = 0;

        // Get selected file parameters
        var selectedImg = $('#profilePicMobile')[0].files[0];

        // Preview the selected image with object of HTML5 FileReader class
        // Make the HTML5 FileReader Object
        var oReader = new FileReader();
        oReader.onload = function(e)
        {

            // e.target.result is the DataURL (temporary source of the image)
            previewId.src=e.target.result;

            // FileReader onload event handler
            previewId.onload = function () {

                // display the image with fading effect
                $('#image_divMobile').fadeIn(500);
                selectImgWidth = previewId.naturalWidth; //set the global image width
                selectImgHeight =previewId.naturalHeight;//set the global image height

                // initialize Jcrop Plugin on the selected image

            };
        };

        // read selected file as DataURL
        oReader.readAsDataURL(selectedImg);
    });

    //$("[name='interests[]']").bootstrapSwitch({'onText':'Add', 'offText':'Nope'});
});


function showPicture()
{
    $('#welcomeDiv').hide();
    $('#profileDivs').removeClass('col-lg-5');
    $('#profileDivs').addClass('col-lg-11');
    $('#demoSlides').hide();
    $('#pictureDiv').fadeIn();
}
//these two function are part of crop logic
function showThumbnail(e)
{
    var rx = 155 / e.w; //155 is the width of outer div of your profile pic
    var ry = 190 / e.h; //190 is the height of outer div of your profile pic
    $('#w').val(e.w);
    $('#h').val(e.h);
    $('#w1').val(e.w);
    $('#h1').val(e.h);
    $('#x1').val(e.x);
    $('#y1').val(e.y);
    $('#x2').val(e.x2);
    $('#y2').val(e.y2);

}

function validateForm()
{
    if ($('#profilePic').val()=='')
    {
      //  $('.error').html('Please select an image').fadeIn(500);
        return false;
    }
    else if(isError)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function _(el)
{
    return document.getElementById(el);
}

//this is the ajax code to upload profile tune and pic
function createProfile()
{
    var rn,file1;
    if(isPhone)
    {
        rn = $('#profilePicMobile').val();

    }
    else
    {
        rn = $('#profilePic').val();
    }
    if(rn)
    {


        if(isPhone)
        {
            $('#mysubmitMobile').prop('disabled', true);
            $("#mysubmitMobile").html("Loading.");
            var timer = window.setInterval( function() {
                var text = document.getElementById("mysubmitMobile");
                if ( text.innerHTML.length > 9 )
                    text.innerHTML = "Loading.";
                else
                    text.innerHTML += ".";
            }, 750);
            file1 = _("profilePicMobile").files[0];
            var formdata = new FormData();
            formdata.append("profilePic", file1);
        }
        else
        {
            $('#mysubmit').prop('disabled', true);
            $("#mysubmit").html("Loading.");
            var timer = window.setInterval( function() {
                var text = document.getElementById("mysubmit");
                if ( text.innerHTML.length > 9 )
                    text.innerHTML = "Loading.";
                else
                    text.innerHTML += ".";
            }, 750);
            file1 = _("profilePic").files[0];
            var fname=file1.name;
            extension= fname.substr((~-fname.lastIndexOf(".") >>> 0) + 2);
            var x=$('#x1').val();
            var y=$('#y1').val();
            var w=$('#w').val();
            var h=$('#h').val();
            var formdata = new FormData();
            formdata.append("profilePic", file1);
            formdata.append("x", x);
            formdata.append("y", y);
            formdata.append("w", w);
            formdata.append("h", h);
        }

        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "http://b2.com/createProfile");
        ajax.send(formdata);
        $('#myCancel').hide();
    }
    else
    {

    }
}
function completeHandler(event)
{
var error = this.responseText;
    if(error=='wH@tS!nTheB0x')
        window.location='http://b2.com/offline';
    else
    {
        if(isPhone)
        {
            $('#uploadControllerMobile').fadeOut();
            clearInterval(timer);
            show3();
        }
        else
        {
            $('#uploadController').fadeOut();
            // $('#dpSelect').hide();
            $('#image_div').hide();
            $('#picHead').hide();
            $('#profileDivs').removeClass('col-lg-11');
            $('#profileDivs').addClass('col-lg-5');
            $('#demoSlides').show();
            $('#dpMessage').fadeIn();
            var uname=$('#userName').val();
            $("#profilePicture").attr('src','http://b2.com/Users/'+uname+'/profilePic/'+uname+'.'+extension);
            $('#profilePic').attr('disabled', true);
            $('#mysubmit').hide();
            $('.mycounter').fadeIn();
            $(".mycounter").flipCounterUpdate(100);
            clearInterval(timer);
            $('#wimg4').fadeIn(3000);
            $('#wimg5').fadeIn(3000);
            $('#wimg6').fadeIn(3000);
        }
    }

}
function progressHandler(event){

    if(isPhone)
    {
        var percent = (event.loaded / event.total) * 100;
        $('#uploadControllerMobile').fadeIn();
        document.getElementById('progressBarMobile').style.width = percent+'%';
    }
    else
    {
        var percent = (event.loaded / event.total) * 100;
        $('#uploadController').fadeIn();
        document.getElementById('progressBar').style.width = percent+'%';
    }


}

function errorHandler(event)
{
    _("status").innerHTML = "Upload Failed";
}
function abortHandler(event)
{
    _("status").innerHTML = "Upload Aborted";
}

function cancelPhoto()
{
    $('#mysubmit').hide();
    $('#dpSelect').show();
    $('#myCancel').hide();
    var srcString='<img src="http://b2.com/Images/Anony.jpg" id="load_img" />';
    $('#image_div').html(srcString);
}

//this is the function
function showAbout()
{
    $('#pictureDiv').hide();
    $('#aboutDiv').fadeIn();
    $('.mycounter').hide();
}

function showInt()
{
    $('#aboutDiv').hide();
    $('#intDiv').fadeIn();
}
function show2()
{
    $('#welcomeModal').modal('hide');

    $('#profileModal').modal({
        keyboard:false,
        show:true,
        backdrop:'static'
    });

}

function show3()
{
    $('#profileModal').modal('hide');

    $('#aboutModal').modal({
        keyboard:false,
        show:true,
        backdrop:'static'
    });

}

function show4()
{
    $('#aboutForm').data('bootstrapValidator').validate();

    if($('#aboutForm').data('bootstrapValidator').isValid())
    {
        var about=null;
        if(isPhone)
        {
             about=$('#aboutMobile').val();
        }
        else
        {
            about=$('#about').val();
        }
        $.ajax({
            type: "POST",
            url: "saveAbout",
            data: { about:about}
        }).done(function( msg )
        {
            if(msg=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                if(isPhone)
                {
                    $('#aboutModal').modal('hide');
                    $('#interestsModal').modal({
                        keyboard:false,
                        show:true,
                        backdrop:'static'
                    });
                }
                else
                {

                    $('#aboutPlz').hide();
                    $('#aboutBy').hide();
                    $('#asubmit').hide();
                    $('#finalAbout').html('<br><br>So you are saying_<h4>'+about+'</h4><br>Okayy, thats cool! Lets see what do you like, please click next..');
                    $('#showAbout').fadeIn();
                    $('.mycounter').fadeIn();
                    $(".mycounter").flipCounterUpdate(150);
                    $('#wimg7').fadeIn(3000);
                    $('#wimg8').fadeIn(3000);
                    $('#wimg9').fadeIn(3000);
                }
            }
        });
    }

}

function show5()
{
    var count = 0;
    $('#interestForm').data('bootstrapValidator').validate();

    if($('#interestForm').data('bootstrapValidator').isValid())
    {
        $('#interests :checked').each(function()
        {
            allVals.push($(this).val());

        });

      /*  if(isPhone)
            other=document.getElementById('otherPhone').value;
        else
            other=document.getElementById('other').value;

        if(!other)
            other="None";*/
        $.post("http://b2.com/saveInterests", {interests: allVals},function(data)
        {
            if(data=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            {
                if(isPhone)
                {
                    i=0;
                    $('#interestsModal').modal('hide');
                    for(i=0;i<allVals.length;i++)
                    {
                        $('#priInterests').append('<input type="checkbox" name="primary[]" value="'+allVals[i]+'">'+allVals[i]+'<br>');
                    }
                    $('#primaryModal').modal({
                        keyboard:false,
                        show:true,
                        backdrop:'static'
                    });
                }
                else
                {
                    for(i=0;i<allVals.length;i++)
                    {
                        $('#heading'+i).html('Favorite '+allVals[i]);
                        $('#interest'+i).html($('#'+allVals[i]).html());
                        $('#chosenAreas').append('<input type="checkbox" name="primary[]" value="'+allVals[i]+'">'+allVals[i]+'<br>');
                    }

                    $('#isubmit').hide();
                    $('#hisAreas').hide();
                    $('#pickI').html('Primary Interests');
                    $('#chosen').hide();
                    $('#showPicked').fadeIn();
                    $('.mycounter').fadeIn();
                    $(".mycounter").flipCounterUpdate(310);
                    $('#wimg10').fadeIn(3000);
                    $('#wimg11').fadeIn(3000);
                    $('#wimg12').fadeIn(3000);
                }
            }
        });
    }
}

function profileFinal()
{
    var primary = [];
    $('#chosenAreas :checked').each(function()
    {
        primary.push($(this).val());
    });
    if(primary.length!=3)
    {
          $('#primeError').html('<b>Select exact three of the above as your primary interests</b>')
    }
    else
    {
        $('#primeError').html('');
        $.post("http://b2.com/primaryBuilder", {prime:primary},function(data)
        {
            if(data=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            window.location=data;
        });
    }
}

//following methods are only for smartphones

function mobileFinal()
{
    var primary = [];
    $('#priInterests :checked').each(function()
    {
        primary.push($(this).val());
    });
    if(primary.length!=3)
    {
        $('#primeError').html('<b>Select exact three of the above as your primary interests</b>')
    }
    else
    {
        $('#primeError').html('');
        $.post("http://b2.com/primaryBuilder", {prime:primary},function(data)
        {
            if(data=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
            window.location=data;
        });
    }
}

function interestCounterDesktopDown()
{
    clearTimeout(timerInterestDesktop);
    var other = $('#other').val();
    if (other.length > 0)
        $('.int-search-button').removeClass('disabled');
    else
        $('.int-search-button').addClass('disabled');
}

function interestCounterDesktopUp()
{
    timerInterestDesktop = setTimeout(function()
    {
        var other = $('#other').val();
        searchInterest(other);
    }, 500);
}

function interestCounterMobileDown()
{
    clearTimeout(timerInterestMobile);
    var other = $('#otherPhone').val();
    if (other.length > 0)
        $('.int-search-button').removeClass('disabled');
    else
        $('.int-search-button').addClass('disabled');
}

function interestCounterMobileUp()
{
    timerInterestMobile = setTimeout(function()
    {
        var other = $('#otherPhone').val();
        searchInterest(other);
    }, 500);
}

function searchInterest(val)
{
    $('.interest-search-result').html('<div style="text-align: center"><img src="http://b2.com/Images/icons/waiting.gif"></div>');
    $('.interest-search-result').show();

    $.post('http://b2.com/searchInterests', {val: val, request: 'proBuilder'}, function(markup)
    {
        if (markup == 'wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('.interest-search-result').html(markup);

        }
    });
}

function getIntInInput(int)
{
    $('#interest-search-buffer').val(int.id);
    $('#interest-search-buffer-Name').val(int.innerHTML);
    $('.other').val(int.innerHTML);
    $('.interest-search-result').html('');
    $('.interest-search-result').hide();
}

function allTOList()
{
    var intval = $('#interest-search-buffer').val();
    var intname = $('#interest-search-buffer-Name').val();
    if (intval != 'null' && intname != 'null')
    {
        $('.interests').append('<input type="checkbox" name="interests[]" value="'+intval+'" data-bv-field="interests[]">'+intname+'<br>');
        $('.other').val('');
    }

    $('#interest-search-buffer').val('null');
    $('#interest-search-buffer-Name').val('null');
    $('.int-search-button').addClass('disabled');
}

function hideSearchResults()
{
    $('.interest-search-result').hide();
    $('.interest-search-result').html('');
}
