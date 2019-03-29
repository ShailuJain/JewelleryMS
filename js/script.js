$(function(){
    $('#validate-form').submit(function(event){
        event.preventDefault();

        var $form  = $(this),
            url = $form.attr('action');
        var button = $form.find("button[type=submit]");
        var formData = $form.serialize()
            + '&'
            + encodeURI(button.attr('name'))
            + '='
            + encodeURI(button.attr('value'));
        var $posting = $.post(url, formData);
        $posting.done(function(result){
            if(result.status === "success"){
                iziToast.success({
                    message: result.msg,
                    position: "bottomRight",
                });
                $form.find("input[type=text], textarea, select, input[type=number], input[type=email]").val("");
            }else if(result.status === "error"){
                iziToast.error({
                    message: result.msg,
                    position: "bottomRight",
                });
            }
        });
    });
    $('#tables').DataTable({
        select: {
            style: 'single'
        },
    });
});