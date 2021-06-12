<!-- Modal -->
<form method="post" action="{!__WEB_ROOT__!}/categories/add">
    <h3 id="title" class="modal-title" id="add_label">Thêm hãng sản phẩm mới</h3>
    <div class="form-group my-4 mx-4">
        <input id="category_title" class="form-control form-control-lg" type="text"
               placeholder="Tên hãng sản phẩm"
               name="category_title">
    </div>
    <div class="form-group my-4 mx-4">
        <select class="form-select form-select-lg" aria-label="Default select example" id="active"
                name="category_active">
            <option hidden disabled selected>Tình trạng</option>
            <option value="1">Đang kinh doanh</option>
            <option value="0">Chưa kinh doanh</option>
        </select>
    </div>
    <button name="cancel" type="submit" class="btn btn-secondary">Hủy</button>
    <button name="submit" id="cate_add" type="submit" class="btn btn-primary">Thêm</button>
    <div id="result"></div>
</form>