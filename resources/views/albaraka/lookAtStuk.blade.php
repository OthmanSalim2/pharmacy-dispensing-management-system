<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المستودع</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('style/lookAtStuk.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('../src/مركز البركة.png') }}">
</head>

<body>
<!-- === Header === -->
<header class="site-header">
    <div class="head_logo">
        <!-- Logo is clickable to go back -->
        <a href="javascript:history.back()" id="logo-link" title="رجوع للخلف">
            <div id="logo"></div>
        </a>
        <div id="textAfterLogo">
            <h1>مركز البركة الطبي التخصصي</h1>
        </div>
    </div>

    <div class="user-actions">
        <!-- Back Button -->
        <a href="{{ route('home') }}" class="back-btn" title="رجوع">
            <i class="fa fa-arrow-right"></i>
        </a>

        <div id="place" class="user-info">
            <i class="fa fa-user"></i>
            <span>{{ Auth::user()->name ?? 'admin' }}</span>
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn" title="تسجيل الخروج">
                <i class="fa fa-sign-out-alt"></i>
                تسجيل الخروج
            </button>
        </form>
    </div>
</header>

<!-- === Main Section === -->
<main>
    <!-- Sidebar Buttons -->
    <div class="btnBar">
        <a href="{{ route('show-main-stock') }}">
            <button class="minu_btn"><i class="fa-solid fa-boxes-stacked"></i> مخزن المستودع</button>
        </a>

        <a href="{{ route('pharmacy-stock') }}">
            <button class="minu_btn"><i class="fa-solid fa-prescription-bottle-medical"></i> مخزن الصيدلية</button>
        </a>

        <a href="{{ route('buy-medicine-stock') }}">
            <button class="minu_btn"><i class="fa-solid fa-cart-plus"></i>شراء الدواء</button>
        </a>
        <a href="{{ route('sale-medicine-stock') }}">
            <button class="minu_btn"><i class="fa-solid fa-cash-register"></i>بيع الدواء</button>
        </a>
        <a href="{{ route('show-sales') }}">
            <button class="minu_btn"><i class="fa-solid fa-cash-register"></i>تقارير بيع الدواء</button>
        </a>
    </div>
</main>

</body>
</html>
