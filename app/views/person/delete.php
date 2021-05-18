<div style="padding: 50px; width: 50%; margin: 0 auto; text-align: center;">
    Bạn chắc chắn xóa person: {! reset($person_name)->full_name !}
    <form method="post" action="{! __WEB_ROOT__ !}/person/handle-delete" style="padding-top: 20px">
        <input type="number" value="{!$_GET['id']!}" hidden name="id">
        <button name="delete">Xóa</button>
        <button name="cancel">Hủy</button>
    </form>
</div>
