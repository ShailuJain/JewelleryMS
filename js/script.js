$(function(){
    $('a.ajax-link').click(function(event){
        page = $(event.currentTarget).attr('data-path');
        $.ajax({
            url: "http://localhost/JewelleryMS/php/ajax-handler.php?src="+ page,
            success: function(result){
                $("#include").html(result);
            }
        });
    });
});