<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة طلبات الصيدلية</title>
    <link rel="stylesheet" href="{{ asset('style/requests.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('../src/مركز البركة.png') }}">
</head>

<body>

<!-- ====== MAIN HEADER WITH LOGO & USER ====== -->
<header class="main-header">
    <div class="logo-section">
        <img src="{{ asset('src/مركز البركة.png') }}" alt="Logo" class="logo">
        <h1 class="clinic-name">مركز البركة الطبي التخصصي</h1>
    </div>

    <div class="user-actions">
        <div class="user-box">
            <i class="fa fa-user"></i>
            <span>{{ Auth::user()->name ?? 'Admin' }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fa fa-sign-out-alt"></i> تسجيل الخروج
            </button>
        </form>
    </div>
</header>

<!-- ===== SECOND BAR (Back + Date Filter) ===== -->
<div class="top-bar">
    <a href="{{ route('home') }}" class="back-btn">
        <i class="fa-solid fa-arrow-right"></i> رجوع
    </a>

    <form method="GET" action="{{ route('show-orders') }}" class="filter">
        <label>تاريخ اليوم:</label>
        <input type="date" name="date" value="{{ request('date') }}">
        <button type="submit"><i class="fa fa-filter"></i> تصفية</button>

    </form>
</div>

<!-- ===== PAGE CONTENT ===== -->
<div class="page-container">

    <!-- ====== Pending Orders ====== -->
    <div class="container pending">
        <h2><i class="fa-solid fa-clock"></i> الطلبات المنتظرة</h2>
        <table>
            <thead>
            <tr>
                <th>الكود</th>
                <th>اسم العلاج</th>
                <th>المادة الفعالة</th>
                <th>المتبقي</th>
                <th>الكمية المطلوبة</th>
                <th>ملاحظات</th>
                <th>التحكم</th>
            </tr>
            </thead>
            <tbody>
            @forelse($pendingOrders as $order)
                <tr>
                    <td>{{ $order->code }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->active_ingredient }}</td>
                    <td>{{ $order->rest_of_it }}</td>
                    <td>{{ $order->required_quantity }}</td>
                    <td>{{ $order->note ?? '-' }}</td>
                    <td>
                        <form action="{{ route('pharmacy.orders.accept', $order->id) }}" method="POST"
                              style="display:inline-block">
                            @csrf
                            <button class="accept-btn"><i class="fa fa-check"></i> قبول</button>
                        </form>
                        <form action="{{ route('pharmacy.orders.cancel', $order->id) }}" method="POST"
                              style="display:inline-block">
                            @csrf
                            <button class="cancel-btn"><i class="fa fa-times"></i> إلغاء</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">لا توجد طلبات منتظرة.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- ====== Completed Orders ====== -->
    <div class="container completed">
        <h2><i class="fa-solid fa-check-circle"></i> الطلبات المنجزة</h2>
        <table>
            <thead>
            <tr>
                <th>الكود</th>
                <th>اسم العلاج</th>
                <th>المادة الفعالة</th>
                <th>المتبقي</th>
                <th>الكمية المطلوبة</th>
                <th>ملاحظات</th>
            </tr>
            </thead>
            <tbody>
            @forelse($completedOrders as $order)
                <tr>
                    <td>{{ $order->code }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->active_ingredient }}</td>
                    <td>{{ $order->rest_of_it }}</td>
                    <td>{{ $order->required_quantity }}</td>
                    <td>{{ $order->note ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">لا توجد طلبات منجزة.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- ====== Cancelled Orders ====== -->
    <div class="container cancelled">
        <h2><i class="fa-solid fa-ban"></i> الطلبات الملغية</h2>
        <table>
            <thead>
            <tr>
                <th>الكود</th>
                <th>اسم العلاج</th>
                <th>المادة الفعالة</th>
                <th>المتبقي</th>
                <th>الكمية المطلوبة</th>
                <th>ملاحظات</th>
            </tr>
            </thead>
            <tbody>
            @forelse($cancelledOrders as $order)
                <tr>
                    <td>{{ $order->code }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->active_ingredient }}</td>
                    <td>{{ $order->rest_of_it }}</td>
                    <td>{{ $order->required_quantity }}</td>
                    <td>{{ $order->note ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">لا توجد طلبات ملغية.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
