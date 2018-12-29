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
</head>
<body>
<div id="app">
    <div class="container">
        <header class="header p-3 m-4 row">
            <div class="top-side col-md-12">
                <h1 class="text-center header-title">به بستون خوش آمدید!</h1>
                <p class="text-center text-secondary sub-header">به سادگی زندگیت رو مدیریت کن :)</p>
            </div>
            <div class="bottom-right-side p-4 col-md-6">
                <p class="text-justify">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان
                    گرافیک است. چاپگرها
                    و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و
                    کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و
                    آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه
                    ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که
                    تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی
                    دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد. </p>
            </div>
            <div class="bottom-left-side p-4 col-md-6">
                <div class="text-center">
                    <a href="/register" class="btn-getstarted">همین حالا ثبت نام کنید</a>
                    <a href="/login" class="btn btn-outline-primary w-75 mt-3 ml-4 rounded-pill font-weight-bolder">وارد شوید</a>
                </div>
            </div>
        </header>
    </div>
</div>

<footer class="text-center">
    <small> این پروژه به صورت متن باز بوده بوده و هرگونه تغییر در آن مجاز است!</small>
</footer>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
