@empty($employees)
{!'Không có nhân viên nào!'!}
@else
<style>
    .full {
    top: 0;
    width: 100%;
    height: 100%;
    position: absolute;
}
    .full:hover{
    background-color: rgba(191, 229, 246, .5);
    }
    .BLOCK{
    background-color: rgba(255,0,0,0.3);
    }
</style>

<div class="employee-list" id="employee_list">
    <div class="row py-3">
        <div class="col-3">Tên nhân viên</div>
        <div class="col-3">Số điện thoại</div>
        <div class="col-3">Giới tính</div>
        <div class="col-3">Chức vụ</div>
    </div>
@foreach($employees as $employee)
    <div class="row py-2 position-relative{!$employee['userStatus']==='BLOCK'?" BLOCK":""!}">
        <div class="col-3">{!$employee['firstName']." ".$employee['lastName']!}</div>
        <div class="col-3">{!$employee['phone']!}</div>
        <div class="col-3">{!$employee['gender'] === '1' ? "Nam" : "Nữ" !}</div>
        <div class="col-3">
            @if($employee['level']==='2')
                {{"Quản lý"}}
            @else
                {{"Nhân viên"}}
            @endif
        </div>
        <a class="full" href="{!__WEB_ROOT__."/myadmin/employees?dt=".$employee['account']!}"></a>
    </div>
@endforeach
</div>
@endempty
