
$(document).ready(function() {

    var anchors2 = document.getElementsByTagName("button");
    for (var i = 0; i < anchors2.length; i++) {
        anchors2[i].style.display='none';
    }

    var anchors = document.getElementsByTagName("a");
    for (var i = 0; i < anchors.length; i++) {
        anchors[i].style.display='none';
    }

    //

    setTimeout(function(){
        for (var i = 0; i < anchors2.length; i++) {
            anchors2[i].style.display='';
        }

        var anchors = document.getElementsByTagName("a");
        for (var i = 0; i < anchors.length; i++) {
            anchors[i].style.display='';
        }
    }, 2000);

});

