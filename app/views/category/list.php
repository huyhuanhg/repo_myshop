@empty($categories)
{!'Không có kết quả phù hợp!'!}
@endempty

@foreach($categories as $category)
<ul class="category-item">
    <li>ID: {!$category['categoryID']!}</li>
    <li>Tên thể loại: {!$category['category_title']!}</li>
    <li>Tên thể loại không dấu: {!$category['category_not_mark']!}</li>
    <li>Bày bán: {!$category['category_active']==1?'Có':'Không'!}</li>
    <a href="{!__WEB_ROOT__!}/myadmin/categories?page=edit&id={!$category['categoryID']!}">Sửa</a>
    <a class="btn btn-primary delete-category" data-bs-toggle="modal" data-bs-target="#exampleModal"
       dataId="{!$category['categoryID']!}" dataTitle="{!$category['category_title']!}">Xóa</a>
</ul>
@endforeach
<script>
    let deleteItems = $.all('.delete-category');
    deleteItems.forEach((item) => {
        $(item).event('mouseover', function (e) {
            let id = e.target.getAttribute('dataID');
            let title = e.target.getAttribute('dataTitle');
            $.post('{!__WEB_ROOT__!}/delete-warning-category',
                {
                    categoryID: id,
                    category_title: title,
                }, function (data) {
                    $(e.target.parentElement).append(`<div class="warning-modal">${data}</div>`);
                })
        });
        $(item).click(function (e) {
            $.e('.warning-modal').classList.add('active');
            let cancelBtn = document.getElementById('cancel_delete');
            if (cancelBtn !== null) {
                cancelBtn.onclick = function () {
                    $.e('.warning-modal').remove();
                }
            }
        });
        $(item).event('mouseout', function (e) {
            let warningBox = $.e('.warning-modal');
            if (!warningBox.classList.contains('active')) {
                warningBox.remove();
            }
        });
    });
</script>