<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <form class="d-flex w-75 mx-auto" id="category_filter" method="get">
        <input id="search_customer" class="form-control" type="search" placeholder="Search"
               aria-label="Search" name="k">
    </form>
    <div><a href="{! __WEB_ROOT__ !}/myadmin/customers?page=add">Thêm Khách hàng</a></div>
</nav>
<div>
    <form class="row  align-items-center">
        <div class="col-7">
            <select class="form-select form-select-lg" aria-label="Default select example" id="customerSort_by"
                    name="customerSort_by">
                <option value="" hidden disabled selected>Sắp xếp theo tiêu thụ</option>
                <option value="DESC">Giảm dần</option>
                <option value="ASC">Tăng dần</option>
            </select>
        </div>
        <div class="col-5 form-check">
            <label class="form-check-label"><input type="checkbox" class="form-check-inline" name="blacklist"
                                                   id="blacklist"
                                                   value="1">Danh sách hạn chế</label>
        </div>
    </form>
</div>
{!view('customer/list', ['customers'=>$customers])!}
<script>
    $(document).ready(function () {
        const callAjaxSearchCustomer = (router, data, parent) => {
            $.post(`{! __WEB_ROOT__ !}/${router}`, data, function (data) {
                parent.html(data);
            })
        }

        $('#customerSort_by').event('change', e => {
            let url = new URL(window.location.href);
            let key = url.searchParams.get("k");
            let data = {
                blacklist: $.e('#blacklist').checked,
                sort: e.target.value,
            }
            if (key !== null){
                data.key = key
            }
            callAjaxSearchCustomer('filter-customer', data, $('#customer_list'));
        });

        $('#blacklist').event('change', e => {
            let url = new URL(window.location.href);
            let key = url.searchParams.get("k");
            let data = {
                blacklist: e.target.checked,
                sort: $.e('#customerSort_by').value,
            }
            if (key !== null){
                data.key = key
            }
            callAjaxSearchCustomer('filter-customer', data, $('#customer_list'));
        });

        $('#search_customer').event('keyup', function (e) {
            if (e.target.value.trim() !== '') {
                $.e('#search_box').classList.add("active");
                callAjaxSearchCustomer('search-customer', {
                    key: e.target.value,
                }, $('#search_box'));
            } else {
                $.e('#search_box').classList.remove("active");
                $('#search_box').html('');
            }
        });
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
