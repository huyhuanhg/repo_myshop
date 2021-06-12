<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{!$_page_title!}</title>
    <link rel="stylesheet" href="{! __WEB_ROOT__ !}/vendors/bootstrap/css/bootstrap.min.css">
    <script src="{!__WEB_ROOT__ !}/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
    <a href="{{__WEB_ROOT__}}/login">Đăng nhập</a><br/>
    <a href="{{__WEB_ROOT__}}/register">Đăng ký</a><br/>
    {!logout()!}
</div>
</body>
</html>