<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>خرید با موفقیت انجام شد</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container p-3">
    <div class="card col-md-12 shadow">
        <div class="card-body p-3">
            <h2 class="text-center">خرید شما با <span class="text-success">موفقیت</span> انجام شد!</h2>
            <h5 class="text-justify mr-5">شماره فاکتور شما : <strong> {{ $res->factorNumber }}</strong><br>
                شماره تراکنش شما : <strong> {{ $res->transId }}</strong><br>
                شماره کارت پرداختی شما : <strong> {{ $res->cardNumber }}</strong></h5>
            <center>
                <a href="/home" class="btn-getstarted text-center shadow-sm">رفتن به صفحه اپلیکیشن</a>
            </center>
        </div>
    </div>
</div>
</body>
</html>
