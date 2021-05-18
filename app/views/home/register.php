<h1>Đăng ký</h1>
{!msg('<h3>', '</h3>')!}
<form method="post" action="{! __WEB_ROOT__ !}/handle-registry">
    <label>Tài khoản</label><br>
    <input name="account" type="text" placeholder="Nhập tài khoản" value="{! formCurrentValue('account') !}"><br>
    {! formError('account', '<span style="color:red">', '</span>'); !}<br/>
    <label>Mật Khẩu</label><br>
    <input name="password" type="password" placeholder="Mật khẩu"><br>
    {! formError('password', '<span style="color:red">', '</span>'); !}<br/>
    <label>Nhập lại Mật Khẩu</label><br>
    <input name="pass_confonfirm" type="password" placeholder="Nhập lại Mật khẩu"><br>
    {! formError('pass_confonfirm', '<span style="color:red">', '</span>'); !}<br/>
    <button>Đăng ký</button><br/>
    <p><a href="{{ __WEB_ROOT__ }}">Đăng nhập</a></p>
</form>
