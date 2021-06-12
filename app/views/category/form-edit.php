<!-- Modal -->
<form method="post" action="{!__WEB_ROOT__!}/categories/edit">
    <h3 id="title" class="modal-title" id="add_label">Sửa hãng sản phẩm</h3>
    <div class="form-group my-4 mx-4">
        <input type="text" value="{!$category['categoryID']!}" name="categoryID" hidden>
        <input type="text" value="{!$category['category_title']!}" name="currentTitle" hidden>
        <input id="category_title" class="form-control form-control-lg" type="text"
               placeholder="Tên hãng sản phẩm" value="{!formCurrentValue('category_title',$category['category_title'])!}"
               name="category_title">
    </div>
    <div class="form-group my-4 mx-4">
        <select class="form-select form-select-lg" aria-label="Default select example" id="active"
                name="category_active">
            <option value="1" {! selected('category_active', 1, $category['category_active']) !}>Đang kinh doanh</option>
            <option value="0" {! selected('category_active', 0, $category['category_active']) !}>Chưa kinh doanh</option>
        </select>
    </div>
    <button name="cancel" type="submit" class="btn btn-secondary">Hủy</button>
    <button name="submit" id="cate_add" type="submit" class="btn btn-primary">Sửa</button>
    <div id="result"></div>
</form>