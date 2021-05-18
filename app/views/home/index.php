<h1>Đăng nhập</h1>

<form method="post" action="{!__WEB_ROOT__!}/handle-login">
    <label>Tài khoản</label><br>
    <input name="acc" type="text" placeholder="tài khoản: admin" value="{! formCurrentValue('acc') !}"><br>
    {! formError('acc', '<span style="color:red">', '</span>'); !}
    {! msg_login('<span style="color: red">', '</span>') !}<br/>
    <label>Mật Khẩu</label><br>
    <input name="pass" type="password" placeholder="Mật khẩu: 1"><br>
    {! formError('pass', '<span style="color:red">', '</span>'); !}<br/>
    <button>Đăng nhập</button><br/>
    <p><a href="{!__WEB_ROOT__!}/signin">Đăng ký</a></p>
</form>
