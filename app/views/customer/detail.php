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
    Tình trạng: {!$customer_status !== null?"Tạm khóa":"Hoạt động"!}<br/>

    <a class="btn btn-danger" href="#">Xóa khách hàng</a>
    <a class="btn btn-warning" href="#">{!$customer_status !== null?"Xóa khỏi blacklist":"Thêm vào blacklist"!}</a>
    <a class="btn btn-info" href="#">Xem lịch sử mua hàng</a>
    @else
    <p>Không có khách hàng phù hợp</p>
    @endempty
</div>
