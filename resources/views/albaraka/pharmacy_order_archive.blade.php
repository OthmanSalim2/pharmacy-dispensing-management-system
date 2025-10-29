<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أرشيف طلبات الصيدلية</title>
    <link rel="stylesheet" href="{{ asset('style/pharmacy_order_archive.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('../src/مركز البركة.png') }}">
    <style>
        /* ======== PAGINATION ======== */
        .pagination-container {
            display: flex;
            justify-content: center; /* centers pagination */
            margin-top: 30px;
            font-family: "Cairo", sans-serif;
            direction: rtl; /* ensure RTL alignment */
        }

        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            gap: 8px;
        }

        .pagination li {
            display: inline-block;
        }

        .pagination li a,
        .pagination li span {
            display: block;
            padding: 8px 14px;
            border-radius: 12px;
            border: 1px solid #00897b;
            color: #00897b;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s;
        }

        .pagination li a:hover {
            background-color: #00897b;
            color: #fff;
        }

        .pagination .active span {
            background-color: #00897b;
            color: #fff;
            border-color: #00897b;
        }

        .pagination .disabled span {
            color: #aaa;
            border-color: #ccc;
            cursor: not-allowed;
        }

        .status.pending {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #856404;
        }

    </style>
</head>
<body>

<!-- ======= Header ======= -->
<header>
    <div class="head_logo">
        <div id="logo"></div>
        <div id="textAfterLogo">
            <h1>مركز البركة الطبي - أرشيف الطلبات</h1>
        </div>
    </div>

    <div class="top-bar">
        <div class="left-side">
            <a href="{{ route('home') }}" class="back-btn">
                <i class="fa-solid fa-arrow-right"></i> رجوع
            </a>
        </div>

        <div class="right-side">
            <div class="user-box">
                <i class="fa-solid fa-user"></i>
                <span>{{ Auth::user()->name }}</span>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i> تسجيل الخروج
                </button>
            </form>
        </div>
    </div>
</header>

<!-- ======= Main Container ======= -->
<div class="container">

    <div class="search-bar">
        <form action="{{ route('orders.archive') }}" method="GET">
            <input type="text" style="width: 300px" name="search" placeholder="ابحث عن الطلب..."
                   value="{{ request('search') }}">
            <button type="submit" class="search-btn">
                <i class="fa-solid fa-magnifying-glass"></i> بحث
            </button>
        </form>
    </div>


    <h3>قائمة الطلبات المؤرشفة</h3>

    <table>
        <thead>
        <tr>
            <th>رقم الطلب</th>
            <th>اسم الدواء</th>
            <th>الكمية</th>
            <th>نوع العلاج</th>
            <th>المادة الفعالة</th>
            <th>تاريخ الطلب</th>
            <th>الحالة</th>
        </tr>
        </thead>
        <tbody id="ordersTable">
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->code }}</td>
                <td>{{ $order->name }}</td>
                <td>{{ $order->required_quantity }}</td>
                <td>{{ $order->unit_type }}</td>
                <td>{{ $order->active_ingredient }}</td>
                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                <td>
                    @if ($order->status === 'completed')
                        <span class="status done">مكتمل</span>
                    @elseif ($order->status === 'pending')
                        <span class="status pending">قيد التنفيذ</span>
                    @elseif ($order->status === 'cancelled')
                        <span class="status cancelled">ملغى</span>
                    @endif
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <div class="pagination-links">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
</div>

</body>
</html>
