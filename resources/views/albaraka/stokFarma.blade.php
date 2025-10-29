<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المخزون</title>
    <link rel="stylesheet" href="{{ asset('style/styleStok.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('../src/مركز البركة.png') }}">
</head>
<body>
<header class="main-header">
    <div class="header-container">
        <div class="logo-section">
            <img src="{{ asset('../src/مركز البركة.png') }}" alt="Logo" class="logo">
            <h1 class="clinic-name">مركز البركة الطبي التخصصي</h1>
        </div>
        <div class="user-section">
            <span class="username"><i class="fa-solid fa-user"></i>{{ Auth::user()->name }}</span>
            <a href="{{ route('logout') }}" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> تسجيل
                الخروج</a>
        </div>
    </div>
</header>

<div class="back-btn-container">
    <a href="{{ route('home') }}" class="back-btn"><i class="fa-solid fa-arrow-right"></i> رجوع</a>
</div>

<main>
    <div class="action-buttons">
        {{--        <a href="{{ route('show-pharmacy-orders') }}" class="add-btn">عمل طلب صرف للصيدلية</a>--}}
        {{--        <a href="{{ route('show-prescription-archive') }}" class="add-btn">ارشيف الروشتات</a>--}}
        {{--        <a href="{{ route('medication-dispensing') }}" class="add-btn">صرف علاج</a>--}}
    </div>

    <table class="stock-table">
        <thead>
        <tr>
            <th>الكود</th>
            <th>الاسم</th>
            <th>المادة الفعالة</th>
            <th>الكمية</th>
            <th>نوع الوحدة</th>
            <th>سعر البيع</th>
            <th>انتهاء الصلاحية</th>
            <th>نوعية الدواء</th>
            <th>تاريخ الاضافة</th>
            <th>سعر الشحنة</th>
        </tr>
        </thead>
        <tbody>
        @foreach($medicines as $medicine)
            <tr>
                <td>{{ $medicine->code }}</td>
                <td>{{ $medicine->name }}</td>
                <td>{{ $medicine->active_ingredient }}</td>
                <td>{{ $medicine->quantity }}</td>
                <td>{{ $medicine->unit_type }}</td>
                <td>{{ $medicine->price }}</td>
                <td>{{ $medicine->expiration_date->format('Y-m-d') ?? '-' }}</td>
                <td>{{ $medicine->treatment_type }}</td>
                <td>{{ $medicine->created_at->format('Y-m-d') }}</td>
                <td>{{ $medicine->shipping_price }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</main>
</body>
</html>
