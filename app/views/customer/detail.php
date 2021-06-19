<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <form class="d-flex w-75 mx-auto" id="category_filter">
        <input id="search_customer" class="form-control" type="search" placeholder="Search"
               aria-label="Search">
    </form>
</nav>
<p><a href="{!__WEB_ROOT__!}/myadmin/customers">Khách hàng</a> / {!$customer_fullName!}</p>
<div class="customer-info">
    @!empty($customer_phone)
    Tên: {!$customer_fullName!}<br/>

    Số điện thoại: {!$customer_phone!}<br/>

    Giới tính: {!$customer_gender==1?"Nam":"Nữ"!}<br/>

    Địa chỉ: {!$customer_address!}<br/>

    Ngày sinh: {!$customer_birthday!}<br/>

    @!empty($customer_email)
    Email: {!$customer_email!}<br/>
    @endempty

    Tiêu thụ: {!$consume!} VNĐ<br/>
    Ghi chú: {!$customer_status === "LIMITED"?"Hạn chế":"Tình trạng hoạt động"!}<br/>
    <a id="delete" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Xóa khách hàng</a>
    <a class="btn btn-primary" href="{!__WEB_ROOT__!}/myadmin/customers?page=edit&sdt={!$customer_phone!}">Sửa khách
        hàng</a>
    <a id="blacklist" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
        {!$customer_status === "LIMITED"?"Xóa khỏi blacklist":"Thêm vào blacklist"!}
    </a>
    <a class="btn btn-info" href="#">Xem lịch sử mua hàng</a>
    @else
    <p>Không có khách hàng phù hợp</p>
    @endempty
</div>

<script>
    $('#delete').event('mouseover', function (e) {
        $.post('{!__WEB_ROOT__!}/customer-alert',
            {
                control: 'delete',
                fullName: '{!$customer_fullName!}',
                sdt: '{!$customer_phone!}'
            }, function (data) {
                $(e.target.parentElement).append(`<div class="alert-modal">${data}</div>`);
            })
    });
    $('#delete').event('mouseout', function (e) {
        let warningBox = $.e('.alert-modal');
        if (!warningBox.classList.contains('active')) {
            warningBox.remove();
        }
    });
    $('#delete').click(function (e) {
        $.e('.alert-modal').classList.add('active');
        let cancelBtn = document.getElementById('cancel');
        if (cancelBtn !== null) {
            cancelBtn.onclick = function () {
                $.e('.alert-modal').remove();
            }
        }
    });
    $('#blacklist').event('mouseover', function (e) {
        $.post('{!__WEB_ROOT__!}/customer-alert',
            {
                control: 'blacklist',
                fullName: '{!$customer_fullName!}',
                sdt: '{!$customer_phone!}',
                current:'{!$customer_status!}'
            }, function (data) {
                $(e.target.parentElement).append(`<div class="alert-modal">${data}</div>`);
            })
    });
    $('#blacklist').event('mouseout', function (e) {
        let warningBox = $.e('.alert-modal');
        if (!warningBox.classList.contains('active')) {
            warningBox.remove();
        }
    });
    $('#blacklist').click(function (e) {
        $.e('.alert-modal').classList.add('active');
        let cancelBtn = document.getElementById('cancel');
        if (cancelBtn !== null) {
            cancelBtn.onclick = function () {
                $.e('.alert-modal').remove();
            }
        }
    });
</script>