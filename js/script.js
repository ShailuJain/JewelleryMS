$(function(){
    $('#validate-form').submit(function(event){
        event.preventDefault();

        var $form  = $(this),
            url = $form.attr('action');
        // alert($form.serialize());
        var button = $form.find("button[type=submit]");
        var formData = $form.serialize()
            + '&'
            + encodeURI(button.attr('name'))
            + '='
            + encodeURI(button.attr('value'));
        var $posting = $.post(url, formData);
        $posting.done(function(result){
            if(result.success !== undefined){

            }else if(result.error !== undefined){
                
            }
        });
    });
});
