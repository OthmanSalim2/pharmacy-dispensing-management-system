<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلبات الصيدلية</title>
    <link rel="stylesheet" href="{{ asset('style/styleMakeRequest.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('../src/مركز البركة.png') }}">
</head>
<body>

<!-- ===== Header ===== -->
<header class="main-header">
    <div class="header-container">
        <div class="logo-section">
            <img src="{{ asset('../src/مركز البركة.png') }}" alt="Logo" class="logo">
            <h1 class="clinic-name">مركز البركة الطبي التخصصي</h1>
        </div>

        <div class="user-section">
            <span class="username">
                <i class="fa-solid fa-user"></i> {{ Auth::user()->name }}
            </span>
            <a href="{{ route('logout') }}" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i> تسجيل الخروج
            </a>
        </div>
    </div>
</header>

<!-- ===== Body Section ===== -->
<div class="container">

    <div class="back-btn-container">
        <a href="{{ route('home') }}" class="back-btn">
            <i class="fa-solid fa-arrow-right"></i> رجوع
        </a>
    </div>

    <div class="main-content">
        <h2><i class="fa-solid fa-prescription-bottle-medical"></i> طلبات الصيدلية</h2>

        <!-- ✅ Success message -->
        @if(session('success'))
            <div style="color: green; text-align:center; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        <!-- ✅ Form Starts -->
        <form action="{{ route('pharmacy-orders-store') }}" method="POST">
            @csrf

            <table class="request-table">
                <thead>
                <tr>
                    <th>كود العلاج</th>
                    <th>اسم العلاج</th>
                    <th>المادة الفعالة</th>
                    <th>المتبقي منه</th>
                    <th>الكمية المطلوبة</th>
                </tr>
                </thead>
                <tbody id="request-body">
                <tr>
                    <td><input name="code[]" type="text" class="code" placeholder="أدخل الكود"></td>
                    <td><input name="name[]" type="text" class="name" placeholder="اسم العلاج" readonly></td>
                    <td><input name="active_ingredient[]" type="text" class="active_ingredient"
                               placeholder="المادة الفعالة" readonly></td>
                    <td><input name="rest_of_it[]" type="text" class="rest_of_it" placeholder="المتبقي" readonly></td>
                    <td><input name="required_quantity[]" type="number" class="required_quantity"
                               placeholder="الكمية المطلوبة"></td>
                </tr>
                </tbody>
            </table>

            <div class="add-row">
                <button class="plus" type="button"><i class="fa-solid fa-plus"></i> إضافة صف</button>
            </div>

            <div class="notes">
                <label>ملاحظات:</label>
                <textarea name="note" placeholder="أدخل ملاحظات إضافية..."></textarea>
            </div>

            <div class="submit">
                <button type="submit"><i class="fa-solid fa-paper-plane"></i> إرسال الطلب</button>
            </div>
        </form>
        <!-- ✅ Form Ends -->
    </div>
</div>

<!-- ===== JavaScript ===== -->
<script>
    document.addEventListener('DOMContentLoaded', () => {

        // ✅ Add new row dynamically
        document.querySelector('.plus').addEventListener('click', () => {
            const tbody = document.getElementById('request-body');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input name="code[]" type="text" class="code" placeholder="أدخل الكود"></td>
                <td><input name="name[]" type="text" class="name" placeholder="اسم العلاج" readonly></td>
                <td><input name="active_ingredient[]" type="text" class="active_ingredient" placeholder="المادة الفعالة" readonly></td>
                <td><input name="rest_of_it[]" type="text" class="rest_of_it" placeholder="المتبقي" readonly></td>
                <td><input name="required_quantity[]" type="number" class="required_quantity" placeholder="الكمية المطلوبة"></td>
            `;
            tbody.appendChild(newRow);
        });

        // ✅ Auto-fill medicine info by code
        document.addEventListener('input', async (e) => {
            if (e.target.classList.contains('code')) {
                const code = e.target.value.trim();
                const row = e.target.closest('tr');

                if (code.length >= 2) {
                    try {
                        const response = await fetch(`/pharmacy/stock/${code}`);
                        const data = await response.json();

                        if (response.ok && data) {
                            row.querySelector('.name').value = data.name || '';
                            row.querySelector('.active_ingredient').value = data.active_ingredient || '';
                            row.querySelector('.rest_of_it').value = data.rest_of_it || '';
                        } else {
                            row.querySelector('.name').value = 'غير موجود';
                            row.querySelector('.active_ingredient').value = '';
                            row.querySelector('.rest_of_it').value = '';
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                }
            }
        });
    });
</script>

</body>
</html>
