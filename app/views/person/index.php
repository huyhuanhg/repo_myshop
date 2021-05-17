
<?= msg('<h3>', '</h3>') ?>
<div>
    <h2>Thong tin Person</h2>
    <div style="background-color: yellow; width: fit-content; padding: 5px; float: right; margin-right: 2vw;"><a
                href="<?= __WEB_ROOT__ ?>/person/add">Add
            person</a></div>
</div>
<p style="clear: right;">

    <?php
    foreach ($person

    as $key => $info):
    ?>
    <h4>Person <?= $key + 1 ?></h4>
    <b>Ho ten:</b> <?= $info->full_name ?><br/>
    <b>Ngay sinh:</b> <?= $info->birthday ?><br/>
    <b>Gioi tinh:</b> <?= gender($info->gender) ?><br/>
    <b>So dien thoai:</b> <?= $info->number_phone ?><br/>
    <b>Email:</b> <?= $info->email ?><br/>
    <b>Dia chi:</b> <?= $info->address ?><br/>
    <div>
        <a href="<?= __WEB_ROOT__ ?>/person/edit?id=<?= $info->person_ID ?>" style="display: inline-block; padding: 5px; margin-right: 20px; font-weight: bold; font-size: 20px">Sửa</a>
        <a href="<?= __WEB_ROOT__ ?>/person/delete?id=<?= $info->person_ID ?>"
           style="display: inline-block; padding: 5px; font-weight: bold; font-size: 20px">Xóa</a>
    </div>
<br/>
<hr/>

<?php
endforeach;
?>
</p>
