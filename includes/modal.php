<?php
function createModal($modalTitle, $modalBody, $modalSubmitBtnText){
    echo<<<MODAL

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">$modalTitle</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">$modalBody</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <form action="" id="form" method="post">
                    <button class="btn btn-danger" type="submit">$modalSubmitBtnText</button>
                </form>
            </div>
        </div>
    </div>
</div>
MODAL;

}
?>