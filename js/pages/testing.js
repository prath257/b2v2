
$(document).ready(function()
    {


        $('.picedit_box').picEdit({
            imageUpdated: function(img){
            },
            formSubmitted: function(response)
            {
                bootbox.alert(response.response);
            },
            redirectUrl: false,
            defaultImage: false
        });
    }
);

