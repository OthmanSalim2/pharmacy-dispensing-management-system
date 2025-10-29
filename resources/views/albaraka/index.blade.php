<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>مركز البركة الطبي التخصصي - لوحة التحكم</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700;900&display=swap" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- external CSS -->
    <link rel="stylesheet" href="{{ asset('style/styleAdmin.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('../src/مركز البركة.png') }}">
</head>
<body>

<header class="site-header">
    <div class="head_logo">
        <div id="logo" aria-hidden="true"></div>
        <div id="textAfterLogo">
            <h1>مركز البركة الطبي التخصصي</h1>
        </div>
    </div>

    <div class="user-actions">
    <span class="user-name">
        <i class="fa fa-user"></i> {{ Auth::user()->name }}
    </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn">
                <i class="fa fa-sign-out-alt"></i> تسجيل الخروج
            </button>
        </form>
    </div>

</header>

<main class="main-wrapper">
    <div class="boxes">
        <!-- Box 1: إدارة -->
        @if(auth()->user()->role === 'admin')
            <section class="box">
                <h3>إدارة الحساب</h3>
                <div class="btn-group">
                    <a href="{{ route('admin-settings') }}" class="action-btn"><i class="fa fa-cogs"></i> إعدادات
                        المسؤول</a>
                    <a href="{{ route('add-user') }}" class="action-btn"><i class="fa fa-user-plus"></i> إضافة
                        مستخدم</a>
                    <a href="{{ route('edit-workplace') }}" class="action-btn"><i class="fa-solid fa-user-shield"></i>
                        تعديل
                        صلاحية</a>
                    <a href="{{ route('users.index') }}" class="action-btn"><i class="fa-solid fa-users"></i>
                        كل المستخدمين</a>
                </div>
            </section>
        @endif

        <!-- Box 2: المخزون -->
        <section class="box">
            <h3>المخزون</h3>
            <div class="btn-group">
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'user' && auth()->user()->workplace === 'store')
                    <a href="{{ route('show-workhouse') }}" class="action-btn"><i class="fa fa-eye"></i> الاطلاع على
                        المخزون
                        الرئيسي</a>
                @endif
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'user' || auth()->user()->role && auth()->user()->workplace === 'store' || auth()->user()->workplace === 'pharmacy' )
                    <a href="{{ route('show-main-store-pharmacy') }}" class="action-btn"><i class="fa fa-boxes"></i>
                        تفقد
                        مخزون الصيدلية</a>
                @endif
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'user' || auth()->user()->role && auth()->user()->workplace === 'store' )
                    <a href="{{ route('add-medicine') }}" class="action-btn"><i class="fa fa-plus-circle"></i> إضافة
                        للمخزون
                        الصيدلية</a>
                @endif

            </div>
        </section>

        <!-- Box 3: الصيدلية -->
        <section class="box">
            <h3>الصيدلية</h3>
            <div class="btn-group">
                {{--                <a href="reqwests.html" class="action-btn"><i class="fa fa-file-alt"></i> طلبيات الصيدلية</a>--}}
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'user' || auth()->user()->role && auth()->user()->workplace === 'store' || auth()->user()->workplace === 'pharmacy' )
                    <a href="{{ route('show-pharmacy-orders') }}" class="action-btn"><i
                            class="fa-solid fa-prescription-bottle-medical"></i> عمل طلب
                        صرف للصيدلية</a>
                @endif
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'user' || auth()->user()->role && auth()->user()->workplace === 'store' )
                    <a href="{{ route('show-orders') }}" class="action-btn"><i class="fa fa-receipt"></i> طلبات الصيدلية</a>
                @endif
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'user' || auth()->user()->role && auth()->user()->workplace === 'store' || auth()->user()->workplace === 'pharmacy' )
                    <a href="{{ route('drugsell') }}" class="action-btn"><i class="fa fa-pills"></i> صرف
                        علاج</a>
                @endif
            </div>
        </section>

        <!-- Box 4: الأرشيف -->
        <section class="box">
            <h3>الأرشيف</h3>
            <div class="btn-group">
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'user' || auth()->user()->role && auth()->user()->workplace === 'store' || auth()->user()->workplace === 'pharmacy' )
                    <a href="{{ route('show-prescription-archive') }}" class="action-btn"><i class="fa fa-archive"></i>
                        @endif
                        أرشيف الروشتات</a>
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'user' || auth()->user()->role && auth()->user()->workplace === 'store' )
                        <a href="{{ route('show-pharmacy-order-archive') }}" class="action-btn"><i
                                class="fa fa-clipboard"></i>
                            أرشيف طلبات الصيدلية</a>
                    @endif
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'user' || auth()->user()->role && auth()->user()->workplace === 'store' || auth()->user()->workplace === 'pharmacy' )
                        <a href="{{ route('reports.index') }}" class="action-btn"><i class="fa fa-clipboard"></i>
                            لوحة التقارير</a>
                    @endif
            </div>
        </section>
    </div>
</main>

</body>
</html>
