<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المستودع</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('style/lookAtStuk2.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('../src/مركز البركة.png') }}">
</head>
<body>

<!-- === Header === -->
<header class="site-header">
    <div class="head_logo">
        <div id="logo"></div>
        <div id="textAfterLogo">
            <h1>مركز البركة الطبي التخصصي</h1>
        </div>
    </div>

    <div class="user-actions">
        <div id="place" class="user-info">
            <i class="fa fa-user"></i>
            <span>{{ Auth::user()->name ?? 'admin' }}</span>
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn" title="تسجيل الخروج">
                <i class="fa fa-sign-out-alt"></i> تسجيل الخروج
            </button>
        </form>
    </div>
</header>

<!-- === Main Section === -->
<main>
    <div class="table-container">

        <!-- Back Button -->
        <a href="{{ route('show-workhouse') }}" class="back-btn">
            <i class="fa fa-arrow-right"></i> رجوع
        </a>

        <!-- Search input -->
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="ابحث عن الدواء...">
        </div>

        <!-- Stores Table -->
        <table class="custom-table" id="storeTable">
            <thead>
            <tr>
                <th>الكود</th>
                <th>الاسم</th>
                <th>المادة الفعالة</th>
                <th>الكمية</th>
                <th>نوع الوحدة</th>
                <th>سعر البيع</th>
                <th>تاريخ الانتهاء</th>
                <th>نوع العلاج</th>
                <th>سعر الشحن</th>
                <th>تاريخ الإضافة</th>
            </tr>
            </thead>
            <tbody>
            @foreach($stores as $store)
                <tr>
                    <td>{{ $store->code }}</td>
                    <td>{{ $store->name }}</td>
                    <td>{{ $store->active_ingredient ?? '-' }}</td>
                    <td>{{ $store->quantity }}</td>
                    <td>{{ $store->unit_type }}</td>
                    <td>{{ $store->price }}</td>
                    <td>{{ $store->expiration_date->format('Y-m-d') }}</td>
                    <td>{{ $store->type_of_medication }}</td>
                    <td>{{ $store->shipping_price }}</td>
                    <td>{{ $store->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $stores->links() }}
        </div>
    </div>
</main>

<!-- Search Filter Script -->
<script>
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('storeTable').getElementsByTagName('tbody')[0];

    searchInput.addEventListener('keyup', function () {
        const filter = this.value.toLowerCase();
        Array.from(table.rows).forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>

</body>
</html>
