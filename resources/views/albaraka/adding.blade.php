<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة دواء - مستودع الصيدلية</title>
    <link rel="stylesheet" href="{{ asset('style/styleAdding.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('../src/مركز البركة.png') }}">
</head>
<body>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<header class="main-header">
    <div class="header-container">
        <!-- Logo + Clinic Name -->
        <div class="logo-section">
            <img src="{{ asset('../src/مركز البركة.png') }}" alt="Logo" class="logo">
            <h1 class="clinic-name">مركز البركة الطبي التخصصي</h1>
        </div>

        <!-- Page Title -->
        <div class="page-title">
            <h2>مستودع الصيدلية / إضافة دواء</h2>
        </div>

        <!-- User Info -->
        <div class="user-section">
            <span class="username"><i class="fa-solid fa-user"></i> {{ Auth::user()->name ?? 'Admin' }}</span>
            <a href="{{ route('logout') }}" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i> تسجيل الخروج
            </a>
        </div>
    </div>
</header>

<div class="container">

    <!-- Navigation Buttons -->
    <div class="nav-buttons">
        <a href="{{ route('home') }}" class="back-btn">
            <i class="fa-solid fa-arrow-right"></i> رجوع
        </a>
        <a href="{{ route('show-main-store-pharmacy') }}" class="stock-btn">
            <i class="fa-solid fa-boxes-stacked"></i> المخزون
        </a>
    </div>

    <!-- Add Medicine Form -->
    <div class="form-box">
        <h3><i class="fa-solid fa-pills"></i> إضافة دواء جديد</h3>

        <form action="{{ route('add-medicine-pharmacy') }}" method="POST">
            @csrf
            <label>الكود</label>
            <input name="code" type="text" placeholder="أدخل كود الدواء">

            <label>الاسم</label>
            <input name="name" type="text" placeholder="اسم الدواء">

            <label>المادة الفعالة</label>
            <input name="active_ingredient" type="text" placeholder="المادة الفعالة">

            <label>الكمية</label>
            <input name="quantity" type="number" placeholder="أدخل الكمية">

            <label>نوع الدواء</label>
            <select name="treatment_type">
                <option>حبوب</option>
                <option>شراب</option>
                <option>حقنة</option>
                <option>تحميلة</option>
                <option>برهم</option>
                <option>كريم</option>
                <option>قطرة</option>
            </select>

            <label>الوحدة</label>
            <div class="units">
                <label><input type="radio" name="unit_type" value="علبة"> علبة</label>
                <label><input type="radio" name="unit_type" value="شريط" checked> شريط</label>
                <label><input type="radio" name="unit_type" value="حبة"> حبة</label>
            </div>

            <label>أسعار البيع</label>
            <div class="price-row">
                <input type="number" name="price" placeholder="سعر الجملة">
                <input type="number" name="pharmacy_price" placeholder="سعر الصيدلية">
                <input type="number" name="patient_price" placeholder="سعر المريض">
            </div>

            {{--            <label>تاريخ اليوم</label>--}}
            {{--            <input name="date" type="date">--}}

            <label>تاريخ الانتهاء</label>
            <input name="expiration_date" type="date">

            <label>سعر الشحنة</label>
            <input name="shipping_price" type="number" placeholder="سعر الشحنة">

            <div class="form-buttons">
                <button type="submit" class="add-btn">
                    <i class="fa-solid fa-plus"></i> إضافة
                </button>
            </div>
        </form>
    </div>

</div>

</body>
</html>
