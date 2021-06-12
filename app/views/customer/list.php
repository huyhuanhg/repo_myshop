@empty($customers)
{!'Không có khách hàng nào!'!}
@endempty
<style>
    .full {
        width: 100%;
        height: 100%;
        position: absolute;
    }
    .full:hover{
        background-color: rgba(191, 229, 246, .5);
    }
</style>
<div class="customer-list" id="customer_list">
    <div class="row py-3">
        <div class="col-5">Tên khách hàng</div>
        <div class="col-4">Số điện thoại</div>
        <div class="col-3">Tổng tiêu thụ</div>
    </div>
    @foreach($customers as $customer)
    <div class="row py-2 position-relative">
        <div class="col-5">{!$customer['customer_fullName']!}</div>
        <div class="col-4">{!$customer['customer_phone']!}</div>
        <div class="col-3">{!$customer['consume']!} VNĐ</div>
        <a class="full" href="{!__WEB_ROOT__."/myadmin/customers?cp=".$customer['customer_phone']!}"></a>
    </div>
    @endforeach
</div>