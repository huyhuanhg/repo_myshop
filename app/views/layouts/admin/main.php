<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{!$_page_title!}</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
    <script src="https://kit.fontawesome.com/efc0cf8ca8.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{! __WEB_ROOT__ !}/assets/css/root.css">
    <link rel="stylesheet" href="{! __WEB_ROOT__ !}/vendors/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{! __WEB_ROOT__ !}/assets/css/main.css">
    <link rel="stylesheet" href="{! __WEB_ROOT__ !}/assets/css/form-validate.css">
    <script src="{!__WEB_ROOT__ !}/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{! __WEB_ROOT__ !}/assets/js/main/main.js"></script>
    <script src="{! __WEB_ROOT__ !}/assets/js/js_library/Validate/Validator.js"></script>
    <script src="{! __WEB_ROOT__ !}/assets/js/js_library/Query/Hquery.js"></script>
    <script src="{! __WEB_ROOT__ !}/assets/js/js_library/Ajax/Ajax.js"></script>
    <script src="{! __WEB_ROOT__ !}/assets/js/js_library/hquery.js"></script>

</head>
<body>

{!view('blocks/admin/header')!}
<div class="container">
    <div class="row">
        <div class="col-lg-3" style="border-right: 1px solid black">
            {!view('blocks/admin/navagation')!}
        </div>
        <div class="col-lg-9">
            {!raw($viewContent, $main)!}
        </div>
    </div>
</div>
{!view('blocks/admin/footer')!}
</body>
</html>