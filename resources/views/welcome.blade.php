<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>بستون</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-page.css') }}">
</head>
<body>
<div id="app">
    <div id="home-body">
        <div class="container">
            <div class="row">
                <div class="col-md-12 home-top-bar mr-4">
                    <h1>بستون</h1>
                    <p>با بستون به سادگی زندگیت رو مدیریت کن :)</p>
                    <a href="/register" class="cta">همین الان شروع کن</a>
                </div>
                <div class="col-md-12 plans">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-4 plan-1">
                            <h3>۱ ماه</h3>
                            <img src="/images/home-page/idea.png" alt="IMG One">
                            <h2>۵۰۰۰۰ ریال</h2>
                            <span>فعالسازی همه امکانات</span>
                            <a href="/plan" class="btn-buy-plan">خرید و فعالسازی</a>
                        </div>
                        <div class="col-md-4 plan-2">
                            <h3>۱ سال</h3>
                            <img src="/images/home-page/molecule.png" alt="IMG One">
                            <h2>3۰۰۰۰ ریال</h2>
                            <span>فعالسازی همه امکانات</span>
                            <a href="/plan" class="btn-buy-plan">خرید و فعالسازی</a>
                        </div>
                        <div class="col-md-4 plan-3">
                            <h3>یک بار برای همیشه</h3>
                            <img src="/images/home-page/atom.png" alt="IMG One">
                            <h2>8۰۰۰۰ ریال</h2>
                            <span>فعالسازی همه امکانات</span>
                            <a href="/plan" class="btn-buy-plan">خرید و فعالسازی</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
