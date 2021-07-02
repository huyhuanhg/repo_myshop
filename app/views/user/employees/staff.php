<nav class="navbar navbar-expand-lg navbar-light bg-light" id="nav_employees">
    <form class="d-flex w-75 mx-auto" id="customer_filter" method="get">
        <input id="search_employees" class="form-control" type="search" placeholder="Search"
               aria-label="Search" name="k">
    </form>
    <a id="alert_add" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Thêm nhân viên</a>

</nav>
<div>
    <form class="row  align-items-center">
        <div class="col-5 form-check">
            <label class="form-check-label"><input type="checkbox" class="form-check-inline" name="blacklist"
                                                   id="blacklist"
                                                   value="1">Tạm khóa</label>
        </div>
    </form>
</div>

{!view('user/employees/staff-list', ['employees'=>$employees])!}

<script>
    $(document).ready(function () {
        $('#alert_add').event('mouseover', function (e) {
            $.post('{!__WEB_ROOT__!}/employees-alert', function (data) {
                $(e.target.parentElement).append(`<div class="alert-modal">${data}</div>`)
            })
        });

        $('#alert_add').event('mouseout', function () {
            let warningBox = $.e('.alert-modal');
            if (!warningBox.classList.contains('active')) {
                warningBox.remove();
            }
        });
        $('#alert_add').click(function (e) {
            $.e('.alert-modal').classList.add('active');
            let cancelBtn = document.getElementById('cancel');
            if (cancelBtn !== null) {
                cancelBtn.onclick = function () {
                    $.e('.alert-modal').remove();
                }
            }
        });
            $('#search_employees').event('keyup', function (e) {
                if (e.target.value.trim() !== '') {
                    $.e('#search_box').classList.add("active");
                    $.post("{!__WEB_ROOT__!}/search-employees",{
                        key: e.target.value,
                    }, function (data) {
                        $('#search_box').html(data);
                    });
                } else {
                    $.e('#search_box').classList.remove("active");
                    $('#search_box').html('');
                }
            });
            $('#search_employees').event('focus', function (e) {
                $(e.target).after("<div id='search_box'></div>");
            })
            $('#search_employees').event('blur', function (e) {
                let searchBox = $.e('#search_box');
                if (!searchBox.classList.contains('active')) {
                    searchBox.remove();
                }
            })

            $('#blacklist').event('change', e => {
                let url = new URL(window.location.href);
                let key = url.searchParams.get("k");
                let data = {
                    blacklist: e.target.checked,
                }
                if (key !== null) {
                    data.key = key
                }
                $.post("{!__WEB_ROOT__!}/filter-employees", data, function (dt) {
                    $('#employee_list').html(dt);
                });
            });

    });
</script>