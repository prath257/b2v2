var focused = null;
var datesJson;
var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
$(document).ready(function()
{
    var userid = $('#userid').val();
    var d= new Date();
    var y= d.getFullYear();
    var m= d.getMonth()+1;
    getDates(y,m,userid);

    $(document).mouseover(function(e){
        if (!$(e.target).is('#access-levels,#access-levels *'))
            focused = false;
        else
            focused = true;
    });

    var  timer = window.setInterval( function() {

        if(document.getElementById('semi').checked && focused == false)
        {
            getUsers();
        }
        getSusers();

    }, 3000);
});

function toggleYear(currentYear,toggleYear)
{
    if (toggleYear != 0)
    {
        var month = $('#viewedMonth').val();
        month = parseInt(month);
        $('#'+currentYear).removeClass('current-year');
        $('#'+currentYear).addClass('un-current-year');
        $('#'+toggleYear).removeClass('un-current-year');
        $('#'+toggleYear).addClass('current-year');

        $('#month-'+currentYear+'-'+month).removeClass('current-month');
        $('#month-'+currentYear+'-'+month).addClass('un-current-month');
        $('#month-'+toggleYear+'-'+month).removeClass('un-current-month');
        $('#month-'+toggleYear+'-'+month).addClass('current-month');
    }
}

function toggleMonth(year,currMonth,toggleMonth)
{
    $('#month-'+year+'-'+currMonth).removeClass('current-month');
    $('#month-'+year+'-'+currMonth).addClass('un-current-month');
    $('#month-'+year+'-'+toggleMonth).removeClass('un-current-month');
    $('#month-'+year+'-'+toggleMonth).addClass('current-month');

    $('#viewedMonth').val(toggleMonth);
}

function accessSetting(type)
{
    if(type=='public')
    {
        $('#private').prop('disabled',true);
        $('#semi').prop('disabled',true);
        $.ajax({
            type: "POST",
            url: "http://b2.com/delSuser",
            data:{type : 'all'}
        }).done(function(data){
                if(data=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
            });
        $.ajax({
            type: "POST",
            url: "http://b2.com/setDiaryAccess",
            data: {type:'public'}// This is the URL to the API
        })
            .done(function(data) {
                if(data=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                {
                    $('#private').prop('disabled',false);
                    $('#semi').prop('disabled',false);
                    $('#semidiv').fadeOut();
                }
            })
            .error(function() {
                // If there is no communication between the server, show an error
                // alert( "error occured" );
            });
    }
    else if(type=='private')
    {
        $('#public').prop('disabled',true);
        $('#semi').prop('disabled',true);
        $.ajax({
            type: "POST",
            url: "http://b2.com/delSuser",
            data:{type : 'all'}
        })
            .done(function(data){
                if(data=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
            });
        $.ajax({
            type: "POST",
            url: "http://b2.com/setDiaryAccess",
            data: {type:'private'}// This is the URL to the API
        })
            .done(function( data ) {
                if(data=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                {
                    $('#public').prop('disabled',false);
                    $('#semi').prop('disabled',false);
                    $('#semidiv').fadeOut();
                }
            })
            .error(function() {
                // If there is no communication between the server, show an error
                // alert( "error occured" );
            });
    }
    else if(type=='semi')
    {

        $('#private').prop('disabled',true);
        $('#public').prop('disabled',true);
        $.ajax({
            type: "POST",
            url: "http://b2.com/setDiaryAccess",
            data: {type:'semi'}// This is the URL to the API
        })

            .done(function( data ) {
                if(data=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                {
                    $('#private').prop('disabled',false);
                    $('#public').prop('disabled',false);
                }
            })
            .error(function() {
                // If there is no communication between the server, show an error
                // alert( "error occured" );
            });
        getUsers();
    }
}

function getUsers()
{
    $('#semidiv').fadeIn();
    $.ajax({
        type:'POST',
        url:'http://b2.com/getUsers'
    })
        .done(function(data)
        {
            if(data=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
                $('#friendSelect').html(data);
        });
}

function getSusers()
{
    $.ajax({
        type:'POST',
        url:'http://b2.com/getSusers'
    })
        .done(function(markup)
        {
            if(markup=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
                $('#friendList').html(markup);
        });
}

function addNew()
{
    var suserid=$('#friend').val();
    $.ajax({
        type: 'POST',
        url: 'http://b2.com/addSuser',
        data: {suserid: suserid}
    })
        .done(function(data)
        {
            if(data=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
                $('#friendList').append(data);

        });

}

function delSuser(id)
{
    $.ajax({
        type: 'POST',
        url: 'http://b2.com/delSuser',
        data: {id: id}
    })
        .done(function(data)
        {
            if(data=='wH@tS!nTheB0x')
                window.location='http://b2.com/offline';
            else
                $('#suserbtn'+data).fadeOut();

        });
}

function showEdit(id)
{
    $('#editOrSave').val('edit');

    var data=$('#readDiary'+id).html();
    var summernote = $('#summernoteTextarea'+id).html();
    $('#summernoteTextarea'+id).html("");
    $('#summernoteDiv2').html(summernote);

    $('#summernote'+id).show();


    /*$('#summernote'+id).html(data);*/

    $('#summernote'+id).summernote({
        height:300
    });
    $('#summernote'+id).code(data);

    $('#editPostModal').modal({
        keyboard:false,
        show:true,
        backdrop:'static'
    });

    $('#btnEdit'+id).hide();
    $('#btnDelt'+id).hide();
    $('#btnAccess'+id).show();
    $(".access").bootstrapSwitch({'onText':'Public', 'offText':'Private'});
    $('#btnSave'+id).show();

    $('#beingEdited').val(id);
}

function save(id,type)
{
    var message=$('#summernote'+id).code();

    if (document.getElementById('access'+id).checked)
        var access='public';
    else
        var access='private';

    $('.saveNedit'+id).html("<img src='http://b2.com/Images/icons/waiting.gif'> Saving..");

   /* $('#summernote'+id).hide();
   $('#readDiary'+id).show();
    $('#readDiary'+id).html(message);

    $('#btnEdit'+id).show();
    $('#btnSave'+id).hide();

    if($('#editOrSave').val()=='edit')
    {
        var type="edit";
        $('#editOrSave').val('');

    }
    else
    {
        var type="save";
    }*/


    $.ajax({
        type: "POST",
        url: "http://b2.com/saveDiary",
        data: {message:message,type:type,id:id,access:access}
    }).done(function(data)
    {
        if(data=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#newPostModal').modal('hide');
            $('#editPostModal').modal('hide');

            bootbox.alert('Posted successfully!');

            var userid = $('#userid').val();
            var d= new Date();
            var y= d.getFullYear();
            var m= d.getMonth()+1;
            var diaryDates = '{';
            $.post('http://b2.com/getMonthlyDates', {year: y, month: m, userid: userid}, function (data) {
                if(data=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                {
                    datesJson = data;
                    for (i in datesJson) {
                        if (i == 0)
                            diaryDates += '"' + datesJson[0] + '":{}';
                        diaryDates += ',"' + datesJson[i] + '":{}';
                    }
                    diaryDates += '}';
                    datesJson = JSON.parse(diaryDates);
                    $(".responsive-calendar").responsiveCalendar('edit', datesJson);
                }
            });

            if (type == save)
            {
                var currentYear = $("#currentYear").val();
                var currentMonth = $("#currentMonth").val();
                var currentDate = $("#currentDate").val();
            }
            else
            {
                var currentYear = $("#currentYear2").val();
                var currentMonth = $("#currentMonth2").val();
                var currentDate = $("#currentDate2").val();
            }
            retrieveAll(currentDate,currentMonth,currentYear,userid);
        }
    });
}

function createSingle()
{
    var type="single";
    var date=""; //not required for single

    $.ajax({
        type: "POST",
        url: "http://b2.com/createDiary",
        data: {type:type}
    }).done(function(data)
    {
        if(data=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#summernoteDiv').html(data);  // append div after the div
            $(".access").bootstrapSwitch({'onText':'Public', 'offText':'Private'});
            $('.summernote').summernote({
                height:300
            });
        }
    });

}

function newPost()
{
    $('#summernoteDiv').html('<div class="center-align"><img src="http://b2.com/Images/icons/waiting.gif"></div>');
    
    $('#newPostModal').modal({
        keyboard:false,
        show:true,
        backdrop:'static'
    });
    createSingle();
}

function showDelt(id)
{
    bootbox.confirm("Quite sure about that?", function(result) {
        if (result==true)
        {
            $.post("http://b2.com/deleteDiaryPost",{id:id},function(error)
            {
                if(error=='wH@tS!nTheB0x')
                    window.location='http://b2.com/offline';
                else
                {
                    var userid = $('#userid').val();
                    var currentYear = $("#currentYear2").val();
                    var currentMonth = $("#currentMonth2").val();
                    var currentDate = $("#currentDate2").val();

                    var d= new Date();
                    var y= d.getFullYear();
                    var m= d.getMonth()+1;
                    var diaryDates = '{';
                    $.post('http://b2.com/getMonthlyDates', {year: y, month: m, userid: userid}, function (data) {
                        if(data=='wH@tS!nTheB0x')
                            window.location='http://b2.com/offline';
                        else
                        {
                            datesJson = data;
                            for (i in datesJson) {
                                if (i == 0)
                                    diaryDates += '"' + datesJson[0] + '":{}';
                                diaryDates += ',"' + datesJson[i] + '":{}';
                            }
                            diaryDates += '}';
                            datesJson = JSON.parse(diaryDates);
                            $(".responsive-calendar").responsiveCalendar('clearAll');
                            $(".responsive-calendar").responsiveCalendar('edit', datesJson);
                        }
                    });

                    retrieveAll(currentDate,currentMonth,currentYear,userid);


                }
            });
        }
    });
}

function cancelEdit()
{
    var userid = $('#userid').val();
    var currentYear = $("#currentYear2").val();
    var currentMonth = $("#currentMonth2").val();
    var currentDate = $("#currentDate2").val();

    retrieveAll(currentDate,currentMonth,currentYear,userid);
    $('#editPostModal').modal('hide');
}

function editTitle()
{
    var title = $('#diaryTitle').html();
    $('#diaryTitle').hide();
    $('#diaryTitleInput').val(title);
    $('#diaryTitleInput').show();
    $('#editTitle').hide();
    $('#saveTitle').show();
}

function updateTitle()
{
    var title = $('#diaryTitleInput').val();

    $.post('http://b2.com/updateDiaryTitle',{title: title}, function(error)
    {
        if(error=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#diaryTitleInput').val('');
            $('#diaryTitleInput').hide();
            $('#editTitle').show();
            $('#saveTitle').hide();
            $('#diaryTitle').html(title);
            $('#diaryTitle').show();
        }
    });
}

function getDates(year,month,id) {

    var diaryDates = '{';

    $.post('http://b2.com/getMonthlyDates', {year: year, month: month, userid: id}, function (data) {
        if(data=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            datesJson = data;
            for (i in datesJson) {
                if (i == 0)
                    diaryDates += '"' + datesJson[0] + '":{}';
                diaryDates += ',"' + datesJson[i] + '":{}';
            }
            diaryDates += '}';
            datesJson = JSON.parse(diaryDates);

            var ds = '' + year + '-' + month;
            //this is the code to reinitialize the calender

            $('#calendarwaiting').hide();

            $(".responsive-calendar").responsiveCalendar({
                time: ds,
                events: datesJson,
                onDayClick: function (events)
                {
                    var d = $(this).data('day');
                    var m = $(this).data('month');
                    var y = $(this).data('year');
                    retrieveAll(d, m, y,id);
                    $('#PostsDate').html('<h2>'+d+'</h2><h4>'+months[m-1].substring(0,3)+'</h4>');

                },
                onMonthChange: function () {
                    var year = $(this)[0].currentYear;
                    var month = $(this)[0].currentMonth;
                    var userid = $('#userid').val();
                    month+=1;
                    var diaryDates = '{';
                    $.post('http://b2.com/getMonthlyDates', {year: year, month: month, userid: userid}, function (data) {
                        if(data=='wH@tS!nTheB0x')
                            window.location='http://b2.com/offline';
                        else
                        {
                            datesJson = data;
                            for (i in datesJson) {
                                if (i == 0)
                                    diaryDates += '"' + datesJson[0] + '":{}';
                                diaryDates += ',"' + datesJson[i] + '":{}';
                            }
                            diaryDates += '}';
                            datesJson = JSON.parse(diaryDates);
                            $(".responsive-calendar").responsiveCalendar('edit', datesJson);
                        }
                    });
                }


            });

            $('#newCalendar').show();
        }
    });
}

function retrieveAll(d,m,y,userid)
{
    $('#posts').html('<div class="center-align"><img src="http://b2.com/Images/icons/waiting.gif"> Loading..</div>');
    var type="all";
    var date=""+y+"-"+m+"-"+d+" 18:07:00";
    //the date to retrive from the database

    $.ajax({
        type: "POST",
        url: "http://b2.com/createDiary",
        data: {type:type,date:date,userid:userid}
    }).done(function(data)
    {
        if(data=='wH@tS!nTheB0x')
            window.location='http://b2.com/offline';
        else
        {
            $('#posts').html(data);  // append div after the div

            $('#currentYear2').val(y);
            $('#currentMonth2').val(m);
            $('#currentDate2').val(d);
        }
    });

}

