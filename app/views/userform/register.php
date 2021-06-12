<form action="{! __WEB_ROOT__ !}/handle-register" method="post" id="register" class="needs-validation  px-2"
      novalidate>
    <div class="form-group mt-3 mb-2 {!invalid('account')!}">
        <input type="text" class="form-control form-control-lg" id="account" name="account"
               placeholder="Tài khoản"
               value="{! formCurrentValue('account') !}">
        {!formError(account)!}
    </div>
    <div class="mt-3 mb-2 form-group row {!invalid('firstName|lastName')!}">
        <div class="col">
            <input type="text" class="form-control form-control-lg" id="firstName" name="firstName"
                   placeholder="Họ"
                   value="{! formCurrentValue('firstName') !}">
        </div>
        <div class="col">
            <input type="text" class="form-control form-control-lg" id="lastName" name="lastName"
                   placeholder="Tên"
                   value="{! formCurrentValue('lastName') !}">
        </div>
        {!formError('fistName|lastName')!}
    </div>
    <div class="form-group {!invalid('birthday')!}">
        <input type="date" hidden id="birthday" name="birthday">
        <label>Ngày sinh</label>
        <div class="row">
            <div class="col">
                <select class="form-select form-select-lg" aria-label="Default select example" id="day">
                </select>
            </div>
            <div class="col">
                <select class="form-select form-select-lg" aria-label="Default select example" id="month">
                </select>
            </div>
            <div class="col">
                <select class="form-select form-select-lg" aria-label="Default select example" id="year">
                </select>
            </div>
        </div>
        {!formError('birthday')!}
    </div>
    <div class="form-group {!invalid('gender')!}">
        <label class="form-label">Giới tính:</label>
        <div class="form-check-inline">
            <label class="form-check-label mx-2">
                <input type="radio" value="1" name="gender" class="mx-1 form-check-input">Nam
            </label>
            <label class="form-check-label mx-2">
                <input type="radio" value="0" name="gender" class="mx-1 form-check-input">Nữ
            </label>
            <label class="form-check-label mx-2">
                <input type="radio" value="2" name="gender" class="mx-1 form-check-input">Tùy chỉnh
            </label>
        </div>
        {!formError('gender')!}
    </div>
    <div class="mt-3 mb-2 form-group {!invalid('phone')!}">
        <input type="text" class="form-control form-control-lg" id="phone" name="phone"
               placeholder="Số điên thoại" value="{! formCurrentValue('phone') !}">
        {!formError('phone')!}
    </div>
    <div class="mt-3 mb-2 form-group {!invalid('password')!}">
        <input type="password" class="form-control form-control-lg" id="password" name="password"
               placeholder="Mật khẩu" value="{! formCurrentValue('password') !}">
        {!formError('password')!}
    </div>
    <div class="mt-3 mb-2 form-group {!invalid('confirm_password')!}">
        <input type="password" class="form-control form-control-lg" id="confirm_password"
               name="confirm_password"
               placeholder="Nhập lại mật khẩu">
        {!formError('confirm_password')!}
    </div>
    <div class="form-check mb-4 {!invalid('confirm')!}">
        <label class="form-check-label" for="confirm">
            <input class="form-check-input" type="checkbox" id="confirm" name="confirm">
            Đồng ý với điều khoản của chúng tôi.
        </label>
    </div>
    <div class="text-center mb-4">
        <button id="btn_register" type="submit" class="btn btn-outline-success w-100 fw-bold">Đăng ký</button>
    </div>
    <div class="small text-center mb-4">Đã có tài khoản <a href="{!__WEB_ROOT__!}/login">Đăng nhập</a></div>
</form>
<script>
    function $(id) {
        return document.getElementById(id);
    }

    var optionDay = '<option value="" disabled selected hidden>Ngày</option>'
    for (let i = 1; i <= 31; i++) {
        let day = String(i).padStart(2, '0');
        optionDay += `<option value="${day}">${day}</option>`
    }
    $('day').innerHTML = optionDay;
    var optionMonth = '<option value="" disabled selected hidden>Tháng</option>'
    for (let i = 1; i <= 12; i++) {
        let month = String(i).padStart(2, '0');
        optionMonth += `<option value="${month}">${month}</option>`
    }
    $('month').innerHTML = optionMonth;
    let today = new Date();
    let yearNow = Number(today.getFullYear());
    let optionYear = '<option value="" disabled selected hidden>Năm</option>'
    for (let i = yearNow; i >= (yearNow - 100); i--) {
        optionYear += `<option value="${i}">${i}</option>`
    }
    $('year').innerHTML = optionYear;
    $('day').addEventListener('change', function () {
        let day = $('day').value;
        let month = $('month').value;
        let year = $('year').value;
        if (month != '' && year != '') {
            $('birthday').value = `${year}-${month}-${day}`;
        }
    })
    $('month').addEventListener('change', function () {
        let day = $('day').value;
        let month = $('month').value;
        let year = $('year').value;
        if (day != '' && year != '') {
            $('birthday').value = `${year}-${month}-${day}`;
        }
    })
    $('year').addEventListener('change', function () {
        let day = $('day').value;
        let month = $('month').value;
        let year = $('year').value;
        if (month != '' && day != '') {
            $('birthday').value = `${year}-${month}-${day}`;
        }
    })
</script>
