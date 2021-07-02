@empty($employees)
{!'Không có kết quả nào được tìm thấy!'!}
@endempty
@foreach($employees as $employee)
<div class="row py-2 position-relative{!$employee['userStatus']==='BLOCK'?" BLOCK":""!}">
<div class="col-3">{!$employee['firstName']." ".$employee['lastName']!}</div>
<div class="col-3">{!$employee['phone']!}</div>
<a class="full" href="{!__WEB_ROOT__."/myadmin/employees?dt=".$employee['account']!}"></a>
</div>
@endforeach
