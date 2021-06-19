@empty($customers)
{!'Không có kết quả nào được tìm thấy!'!}
@endempty
@foreach($customers as $customer)
<div class="row py-2 position-relative">
    <div class="col-5">{!$customer['customer_fullName']!}</div>
    <div class="col-4">{!$customer['customer_phone']!}</div>
    <div class="col-3">{!$customer['consume']!} VNĐ</div>
    <a class="full" href="{!__WEB_ROOT__."/myadmin/customers?cp=".$customer['customer_phone']!}"></a>
</div>
@endforeach