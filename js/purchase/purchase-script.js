$(function () {
    $('#printBtn').click(function () {
        $('#supplierCollapse').collapse('show');
        $('#productCollapse').collapse('show');
        setTimeout(function(){
            window.print();
        }, 500);
    });

});