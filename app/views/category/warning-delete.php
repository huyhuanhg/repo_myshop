<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cảnh báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{!__WEB_ROOT__!}/categories/delete" method="post">
                <input type="text" name="categoryID" value="{!$categoryID!}" hidden>
                <div class="modal-body">
                    {!$message!}
                </div>
                <div class="modal-footer">
                    <button id="cancel_delete" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy
                    </button>
                    <button type="submit" class="btn btn-primary">Xóa</button>
                </div>
            </form>
        </div>
    </div>
</div>
