<h1>
    {!$control === 'add' ? "Thêm khách hàng" : "Sửa khách hàng"!}
</h1>
<form id="form" action="{!__WEB_ROOT__!}/myadmin/customers/handle-{!$control!}" method="post">
    @if($control === 'edit')
    <input name="curent_sdt" value="{!$_GET['sdt']!}" hidden>
    @endif
    <div class="form-group">
        <input type="text" name="customer_fullName" id="customer_fullName"
               placeholder="Tên đầy đủ">
    </div>
    <div class="form-group">
        <select name="customer_gender" id="customer_gender">
            <option value="" hidden disabled selected>Giới tính</option>
            <option value="1">Nam</option>
            <option value="0">Nữ</option>
        </select>
    </div>
    <div class="form-group">
        <label>Ngày sinh:</label>
        <input type="date" name="customer_birthday" id="customer_birthday">
    </div>
    <div class="form-group">
        <input type="text" name="customer_phone" id="customer_phone" placeholder="Số điện thoại">
    </div>
    <div class="form-group">
        <input type="text" name="customer_address" id="customer_address" placeholder="Địa chỉ">
    </div>
    <div class="form-group">
        <input type="text" name="customer_email" id="customer_email" placeholder="Email">
    </div>
    <div class="form-group">
        <input type="text" name="customer_status" id="customer_status" placeholder="Ghi chú">
    </div>
    <button name="submit" value="{!$control!}">{!$control === 'add' ? "Thêm" : "Sửa"!}</button>
    <button name="cancel" value="{!$control!}">Hủy</button>
</form>
<script>
    @!empty($customer)
    var customer = {!$customer!};
    if (customer.customer_gender !== null){
        $.e(`#customer_gender>option[value="${customer.customer_gender}"]`).selected = true;
    }
    $.e('#customer_fullName').value = customer.customer_fullName;
    $.e('#customer_birthday').value = customer.customer_birthday;
    $.e('#customer_phone').value = customer.customer_phone;
    $.e('#customer_address').value = customer.customer_address;
    $.e('#customer_email').value = customer.customer_email;
    $.e('#customer_status').value = customer.customer_status;
    @endempty

    let msgErrors = {!loadMsgError()!};
    if (msgErrors !== null){
        for (const key in msgErrors) {
            $(`#${key}`).after(`<div class="invalid-feedback">${msgErrors[key]}</div>`)
        }
    }

</script>