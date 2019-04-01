$(function(){
    $('#form').submit(function(event){
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
            }else if(result.status === "deleted"){
                var url = window.location.href;
                $('#deleteModal').modal('hide');
                $('#deleteModal').on('hidden.bs.modal', function (e) {
                    $('#include').load(url+" #include>*","");
                    iziToast.success({
                        message: result.msg,
                        position: "bottomRight",
                    });
                });
            }
        });
    });
    $(".delete").click(function () {
        let $delete_path = $(this).data('delete');
        $('#form').attr('action', $delete_path);
    });
    $('#tables').DataTable({
        select: {
            style: 'single'
        },
    });
});