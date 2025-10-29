<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة الروشتات</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('style/roshtaStyle.css') }}">
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


    </style>
</head>
<body>

<!-- ======= HEADER ======= -->
<header>
    <div class="header-container">
        <div class="logo-area">
            <img src="{{ asset('../src/مركز البركة.png') }}" alt="Logo" class="logo">
            <div class="site-title">
                <h1>مركز البركة الطبي التخصصي</h1>
            </div>
        </div>

        <div class="user-area">
            <span class="username"><i class="fa-solid fa-user"></i> {{ Auth::user()->name }}</span>
            <a href="{{ route('logout') }}" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i> تسجيل الخروج
            </a>
        </div>
    </div>
</header>

<!-- ======= BACK BUTTON ======= -->
<div class="back-btn-container">
    <a href="{{ route('home') }}" class="back-btn">
        <i class="fa-solid fa-arrow-right"></i> رجوع
    </a>
</div>

<!-- ======= MAIN CONTENT ======= -->
<main class="container">
    <h2 class="page-title">قائمة الروشتات</h2>

    @foreach($roshitas as $index => $roshta)
        <div class="roshta">
            <div class="roshta-header">
                <p class="roshta-number">{{ $index + 1 }}</p>
                <h3>روشتة رقم {{ $roshta->id }}</h3>
            </div>

            <div class="roshta-info">
                <label>اسم المريض</label>
                <input type="text" value="{{ $roshta->patient_name }}" readonly>

                <label>اسم العلاج</label>
                <input type="text"
                       value="{{ \App\Models\PharmacyStock::where('code', '=', $roshta->medicine_code)->value('name') }}"
                       readonly>

                <div class="two-columns">
                    <div>
                        <label>سعر العلاج</label>
                        <input type="text" value="{{ $roshta->unit_price }}" readonly>
                    </div>
                    <div>
                        <label>عدد الوحدات</label>
                        <input type="text" value="{{ $roshta->quantity }}" readonly>
                    </div>
                </div>


                <div class="two-columns">
                    <div>
                        <label>السعر الكلي</label>
                        <input type="text" value="{{ $roshta->total }}" readonly>
                    </div>
                    <div>
                        <label>هل تم الإعفاء؟</label>
                        <input type="text" value="{{ $roshta->is_exempt ? 'نعم' : 'لا' }}" readonly>
                    </div>
                </div>

                <div class="status-row">
                    <span class="status-tag
                        @if($roshta->status == 'pused') status-pused
                        @elseif($roshta->status == 'صرف') status-sarf
                        @else status-none @endif">
                        {{ $roshta->status ?? 'بدون حالة'  }}
                    </span>

                    <form action="{{ route('roshitas.updateStatus', $roshta->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="status-btn">
                            @if($roshta->status == 'pused')
                                <i class="fa-solid fa-check"></i> صرف
                            @elseif($roshta->status == 'صرف')
                                <i class="fa-solid fa-xmark"></i> إزالة
                            @else
                                <i class="fa-solid fa-pause"></i> إيقاف
                            @endif
                        </button>
                    </form>
                </div>
            </div>


        </div>
    @endforeach

    {{--    @if($roshitas->count() == 0)--}}
    {{--        <p class="no-data">لا توجد أي روشتات حالياً.</p>--}}
    {{--    @endif--}}

    <div class="pagination-links">
        {{ $roshitas->links('pagination::bootstrap-5') }}
    </div>
</main>

</body>
</html>
