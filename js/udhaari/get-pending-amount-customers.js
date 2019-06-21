$(function () {
    var offset1 = 0, offset2 = 0, limit = 5;
    loadPendingAmountList(limit, offset1,true);
    loadPendingAmountList(limit, offset2, false);
    $('#dueDatePassedLoadMore').click(function(){
        offset1 += limit;
        loadPendingAmountList(limit,offset1,true);
    });
    $('#normalLoadMore').click(function(){
        offset2 += limit;
        loadPendingAmountList(limit, offset2, false);
    });
});

function loadPendingAmountList(limit = 5, offset = 0, dueDatePassed = false) {
    $.post({
        url: "get-pending-customers.php",
        data: {limit: limit, offset: offset, dueDatePassed: dueDatePassed},
        success: function (res) {
            if(dueDatePassed){
                $('#dueDateContainer').append(res);
            }else{
                $('#normalContainer').append(res);
            }
            $('[data-toggle="tooltip"]').tooltip();
        },
        error: function (res) {
            alert("Something went wrong" + res);
        }
    });
}