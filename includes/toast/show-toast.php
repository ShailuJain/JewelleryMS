

<?php

function showToast($toastHeading, $toastMessage){
    return <<<TOAST
<div class="toast" data-autohide=false style="position: absolute; top: 10%; left: 50%;">
    <div class="toast-header">
        <strong class="mr-auto">{$toastHeading}</strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
        $toastMessage
    </div>
</div>
TOAST;
}

?>
<script>
    $(document).ready(function(){
        $('.toast').toast('show');
    });
</script>