<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03"
                aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">Quản lý hãng sản phẩm</a>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <form class="d-flex" id="category_filter">
                <div class="form-group">
                    <input id="search_category" class="form-control" type="search" placeholder="Search"
                           aria-label="Search">
                </div>
                <div class="form-group my-4 mx-4">
                    <select class="form-select form-select-lg" aria-label="Default select example" id="status_category">
                        <option value="all" hidden disabled selected>Tình trạng</option>
                        <option value="all">Tất cả</option>
                        <option value="1">Kinh doanh</option>
                        <option value="0">Chưa kinh doanh</option>
                    </select>
                </div>
            </form>
            <!-- Button trigger modal -->
            <a id="add_category" class="btn btn-primary" href="{!__WEB_ROOT__!}/myadmin/categories?page=add">
                Thêm hãng sản phẩm
            </a>
        </div>
    </div>
</nav>
<div id="list_category">
    {!view('category/list', ['categories'=>$categories])!}
</div>
<script>
    const callAjaxFilterCategory = () => {
        let keyValue = $.e('#search_category').value;
        let activeValue = $.e('#status_category').value;
        $.post('{! __WEB_ROOT__ !}/filter-category', {
            key: keyValue,
            active: activeValue
        }, function (data) {
            $('#list_category').html(data);
        })
    }

    $.e('#category_filter').onsubmit = function (e) {
        e.preventDefault();
        callAjaxFilterCategory();
    }
    $('#search_category').event('input', callAjaxFilterCategory);
    $('#status_category').event('change', callAjaxFilterCategory);
</script>