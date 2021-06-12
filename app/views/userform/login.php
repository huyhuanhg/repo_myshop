<form action="{! __WEB_ROOT__ !}/handle-login" method="post" id="login" class="needs-validation px-2"
      novalidate>
    <div class="form-group mt-3 mb-2 {!invalid('account')!}">
        <input type="text" class="form-control form-control-lg" id="account" name="account"
               placeholder="Tài khoản"
               value="{! formCurrentValue('account') !}">
        {! formError('account'); !}
        {! msg_login() !}
    </div>
    <div class="mb-2 form-group {!invalid('password')!}">
        <input type="password" class="form-control form-control-lg" id="password" name="password"
               placeholder="Mật khẩu">
        {! formError('password'); !}
    </div>
    <div class="form-check mb-2">
        <input class="form-check-input" type="checkbox" id="remember" name="remember">
        <label class="form-check-label" for="remember">
            Duy trì đăng nhập
        </label>
    </div>
    <button id="btn_login" type="submit" class="btn btn-custom w-100 btn-outline-success fw-bold">Đăng
        nhập
    </button>
    <div class="bt-second mt-3 pt-3">
        <a class="btn btn-primary w-100 fw-bold" href="register">
            Tạo tài khoản
        </a>
        <p class="text-center mt-2">
            <a class="text-decoration-none" href="{!__WEB_ROOT__!}/forgot">Quên mật
                khảu?</a>
        </p>
    </div>
</form>
<script src="{! __WEB_ROOT__ !}/assets/js/validate-login.js"></script>
