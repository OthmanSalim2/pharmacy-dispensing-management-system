<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بيع دواء</title>
    <link rel="stylesheet" href="{{ asset('style/saleMedicine.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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

<div style="margin: 10px">
    <a href="{{ route('show-workhouse') }}" class="back-btn"><i class="fa-solid fa-arrow-right"></i> رجوع</a>
</div>

<div class="form-container">
    <form action="{{ route('sale-medicine') }}" method="POST">
        @csrf
        <h2><i class="fa-solid fa-cash-register"></i> بيع دواء</h2>

        <!-- Medicine Code -->
        <div class="form-group">
            <label>الكود</label>
            <input id="medicine_code" name="code" type="text" placeholder="أدخل كود الدواء" required>
        </div>

        <!-- Auto-filled Fields -->
        <div class="form-group">
            <label>الاسم</label>
            <input id="medicine_name" name="name" type="text" placeholder="أدخل اسم الدواء" required readonly>
        </div>

        <div class="form-group">
            <label>المادة الفعالة</label>
            <input id="medicine_active" name="active_ingredient" type="text" placeholder="أدخل المادة الفعالة" readonly>
        </div>

        <div class="form-group">
            <label>نوع الدواء</label>
            <select id="medicine_type" name="type_of_medication" required>
                <option>حبوب</option>
                <option>شراب</option>
                <option>حقنة</option>
                <option>تحميلة</option>
                <option>برهم</option>
                <option>كريم</option>
                <option>قطرة</option>
            </select>
        </div>

        <div class="form-group">
            <label>الوحدة</label>
            <div class="units">
                <label class="unit-option"><input type="radio" name="unit_type" value="علبة"> علبة</label>
                <label class="unit-option"><input type="radio" name="unit_type" value="شريط" checked> شريط</label>
                <label class="unit-option"><input type="radio" name="unit_type" value="حبة"> حبة</label>
            </div>
        </div>

        <div class="form-group">
            <div class="form-group">
                <label>عدد الحبات في الشريط</label>
                <input id="pills_per_strip" name="pills_per_strip" type="number" placeholder=" عدد الحبات في الشريط"
                       disabled>
            </div>

            <div class="form-group">
                <label>عدد الأشرطة في العلبة</label>
                <input id="strips_per_box" name="strips_per_box" type="number" placeholder=" عدد الأشرطة في العلبة"
                       disabled>
            </div>
        </div>

        <!-- Quantity to Sell -->
        <div class="form-group">
            <label>الكمية</label>
            <input id="medicine_quantity" name="quantity" type="number" min="1" placeholder="أدخل الكمية" required>
            <small id="stock_info" style="color: #007bff;"></small>
        </div>

        <div class="form-group">
            <label>سعر البيع</label>
            <input id="medicine_price" name="price" type="number" min="0" placeholder="أدخل سعر البيع" required>
        </div>

        <div class="form-group">
            <label>تاريخ اليوم</label>
            <input name="date" type="date" value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="form-group">
            <label>سعر الشحنة</label>
            <input name="shipping_price" type="number" min="0" placeholder="أدخل سعر الشحنة">
        </div>

        <div class="form-group">
            <label>ملاحظات</label>
            <textarea name="note" placeholder="أدخل أي ملاحظات إضافية"></textarea>
        </div>

        <button type="submit" class="submit-btn"><i class="fa-solid fa-check"></i> بيع</button>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#medicine_code').on('blur', function () {
            let code = $(this).val();
            if (!code) return;

            $.ajax({
                url: '/medicine-info/' + code,
                type: 'GET',
                success: function (data) {
                    $('#medicine_name').val(data.name);
                    $('#medicine_active').val(data.active_ingredient);
                    $('#medicine_type').val(data.type_of_medication);
                    $('input[name="unit_type"][value="' + data.unit_type + '"]').prop('checked', true);
                    $('#medicine_quantity').attr('max', data.quantity);
                    $('#medicine_price').val(data.price);
                    $('#strips_per_box').val(data.strips_per_box);
                    $('#pills_per_strip').val(data.pills_per_strip);
                    $('#stock_info').text('الكمية المتوفرة في المخزن: ' + data.quantity);
                },
                error: function () {
                    alert('الدواء غير موجود في المخزن');
                    $('#medicine_name, #medicine_active, #medicine_type, #medicine_price').val('');
                    $('#medicine_quantity').val('').removeAttr('max');
                    $('#stock_info').text('');
                }
            });
        });

        $('#medicine_quantity').on('input', function () {
            let max = $(this).attr('max');
            if (max && $(this).val() > max) {
                alert('الكمية المدخلة أكبر من الكمية المتوفرة في المخزن');
                $(this).val(max);
            }
        });
    });
</script>
</body>
</html>
