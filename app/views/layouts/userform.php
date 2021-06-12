<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{!$_page_title!}|Smartphone Shop</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
    <script src="https://kit.fontawesome.com/efc0cf8ca8.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{! __WEB_ROOT__ !}/assets/css/root.css">
    <link rel="stylesheet" href="{! __WEB_ROOT__ !}/vendors/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{! __WEB_ROOT__ !}/assets/css/main.css">
    <link rel="stylesheet" href="{! __WEB_ROOT__ !}/assets/css/form-validate.css">
    <script src="{!__WEB_ROOT__ !}/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{! __WEB_ROOT__ !}/assets/js/Validate/Validator.js"></script>
</head>
<body>
<div class="full-height">
    {!view('blocks/header')!}
    <div class="container container-user h-75 user-form-content">
        <div class="row">
            <div class="col-7 position-relative">
                <div class="heading-user-form abs-50">
                    <h1 class="heading-logo fw-bold text-purple mb-1">Sshop</h1>
                    <p class="heading-letter-3 heading-caption mb-3">
                        Điện thoại <span class="text-primary"> chính hãng</span><br/>
                        Giá cả sinh viên!
                    </p>
                    <a class="btn btn-outline-custom">
                        Mua sắm ngay
                    </a>
                </div>
            </div>
            <div class="card col-5 mt-5">
                <div class="card-body">
                    {!raw($viewContent)!}
                </div>
            </div>
        </div>
    </div>
    {!view('blocks/footer',['title'=>"FOOTER"])!}
</div>
<script src="{!__WEB_ROOT__ !}/assets/js/run-validate.js"></script>
</body>
</html>