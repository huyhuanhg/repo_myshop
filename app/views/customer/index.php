<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <form class="d-flex w-75 mx-auto" id="category_filter">
        <input id="search_customer" class="form-control" type="search" placeholder="Search"
               aria-label="Search">
    </form>
</nav>
<div>
    <form class="row  align-items-center">
        <div class="col-7">
            <select class="form-select form-select-lg" aria-label="Default select example" id="status_category">
                <option value="all" hidden disabled selected>Sắp xếp theo tiêu thụ</option>
                <option value="0">Giảm dần</option>
                <option value="1">Tăng dần</option>
            </select>
        </div>
        <div class="col-5 form-check">
            <label class="form-check-label"><input type="checkbox" class="form-check-inline" name="blacklist" id="blacklist"
                                             value="1">Danh sách hạn chế</label>
        </div>
    </form>
</div>
{!view('customer/list', ['customers'=>$customers])!}
<script>
    $(document).ready(function () {
        const callAjaxSearchCustomer = (value, parent) => {
            $.post('{! __WEB_ROOT__ !}/search-customer', {
                key: value,
            }, function (data) {
                parent.html(data);
            })
        }
        $('#search_customer').event('input', function (e) {
            if (e.target.value.trim() !== '') {
                $.e('#search_box').classList.add("active");
                callAjaxSearchCustomer(e.target.value, $('#search_box'));
            } else {
                $.e('#search_box').classList.remove("active");
            }
        });
        $('#category_filter').event('submit', function (e) {
            e.preventDefault();
            callAjaxSearchCustomer($.e('#search_customer').value, $('#customer_list'));
            $.e('#search_box').remove();
            $.e('#search_customer').blur();
        })
        $('#search_customer').event('focus', function (e) {
            $(e.target).after("<div id='search_box'></div>");
        })
        $('#search_customer').event('blur', function (e) {
            let searchBox = $.e('#search_box');
            if (!searchBox.classList.contains('active')) {
                searchBox.remove();
            }
        })
    })
</script>