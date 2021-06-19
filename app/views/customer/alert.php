<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cảnh báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{!__WEB_ROOT__!}/customer/{!$control!}" method="post">
                @isset($current)
                <input type="text" name="customer_status" value="{!$current!}" hidden>
                @endisset
                <input type="text" name="customer_phone" value="{!$sdt!}" hidden>
                <div class="modal-body">
                    {!$message!}
                </div>
                <div class="modal-footer">
                    <button id="cancel" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy
                    </button>
                    <button type="submit" class="btn btn-primary">
                        {! $current !== "LIMITED" && $current !== null? "Thêm" : "Xóa" !}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
