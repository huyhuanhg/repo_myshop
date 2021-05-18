<h2>add new person</h2>
{! msg('<h3>', '</h3>'); !}
<form method="post" action="{! __WEB_ROOT__ !}/person/handle-add">
    <label>Full Name:</label><br/>
    <input type="text" placeholder="Full name" name="full_name" value="{! formCurrentValue('full_name') !}"><br/>
    {! formError('full_name', '<span style="color:red">', '</span>'); !}<br/>
    <label>Ngay sinh:</label><br/>
    <input type="text" placeholder="YYYY-MM-DD" name="birthday" value="{! formCurrentValue('birthday') !}"><br/>
    {! formError('birthday', '<span style="color:red">', '</span>'); !}<br/>
    <label>Gioi tinh:</label><br/>
    <select name="gender">
        <option value="" hidden selected disabled>Chon gioi tinh</option>
        <option value="1" {! selected('gender', 1) !}>Nam</option>
        <option value="0" {! selected('gender', 0) !}>Nu</option>
    </select><br/>
    {! formError('gender', '<span style="color:red">', '</span>'); !}<br/>
    <label>SDT:</label><br/>
    <input type="text" placeholder="Nhap SDT" name="number_phone" value="{! formCurrentValue('number_phone') !}"><br/>
    {! formError('number_phone', '<span style="color:red">', '</span>'); !}<br/>
    <label>Email:</label><br/>
    <input type="text" placeholder="Nhap Email" name="email" value="{! formCurrentValue('email') !}"><br/>
    {! formError('email', '<span style="color:red">', '</span>'); !}<br/>
    <label>Dia chi:</label><br/>
    <input type="text" placeholder="Nhap Dia Chi" name="address" value="{! formCurrentValue('address') !}"><br/>
    {! formError('address', '<span style="color:red">', '</span>'); !}<br/>
    <button name="add">Them</button>
    <button name="cancel">Huy</button>
</form>
