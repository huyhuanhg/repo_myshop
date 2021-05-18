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
<ul class="nav tabs"></ul>
<ul class="navnav-tabs"></ul>
<div class="container">

    <div>
        <h1>Client layout</h1>
        {!logout()!}
    </div>
    <div style="clear: right"></div>
    {! view('blocks/header', ['title'=>'header'])!}
    {! raw($viewContent, $dataContent) !}
    {! view('blocks/footer', ['title'=>'footer'])!}

</div>
</body>
</html>