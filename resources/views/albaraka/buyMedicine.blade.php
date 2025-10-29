<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>شراء دواء</title>
    <link rel="stylesheet" href="{{ asset('style/buyMedicine.css') }}">
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
            <a href="{{ route('logout') }}" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i>
                تسجيل الخروج</a>
        </div>
    </div>
</header>

<main>
    <a href="{{ route('show-workhouse') }}" class="back-btn"><i class="fa-solid fa-arrow-right"></i> رجوع</a>

    <div class="form-container">
        <form action="{{ route('store-medicine') }}" method="POST">
            @csrf
            <h2><i class="fa-solid fa-cart-plus"></i> شراء دواء</h2>

            <div class="form-group">
                <label>الكود</label>
                <input name="code" type="text" placeholder="أدخل كود الدواء">
            </div>

            <div class="form-group">
                <label>الاسم</label>
                <input name="name" type="text" placeholder="أدخل اسم الدواء">
            </div>

            <div class="form-group">
                <label>المادة الفعالة</label>
                <input name="active_ingredient" type="text" placeholder="أدخل المادة الفعالة">
            </div>

            <div class="form-group">
                <label>الكمية</label>
                <input name="quantity" type="number" placeholder="أدخل الكمية">
            </div>

            <div class="form-group">
                <label>نوع الدواء</label>
                <select name="type_of_medication">
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
                    <label class="unit-option">
                        <input type="radio" name="unit_type" value="علبة"> علبة
                    </label>
                    <label class="unit-option">
                        <input type="radio" name="unit_type" value="شريط" checked> شريط
                    </label>
                    <label class="unit-option">
                        <input type="radio" name="unit_type" value="حبة"> حبة
                    </label>
                </div>
            </div>

            <!-- ✅ New Inputs for pills_per_strip and strips_per_box -->
            <div class="form-group">
                <label>عدد الحبات في الشريط</label>
                <input name="pills_per_strip" type="number" placeholder="أدخل عدد الحبات في الشريط">
            </div>

            <div class="form-group">
                <label>عدد الأشرطة في العلبة</label>
                <input name="strips_per_box" type="number" placeholder="أدخل عدد الأشرطة في العلبة">
            </div>
            <!-- ✅ End of New Inputs -->

            <div class="form-group">
                <label>سعر البيع</label>
                <div class="multi-input">
                    <input name="price" type="number" placeholder="سعر الجملة">
                    <input name="pharmacy_price" type="number" placeholder="سعر الصيدلية">
                    <input name="patient_price" type="number" placeholder="سعر المريض">
                </div>
            </div>

            <div class="form-group">
                <label>تاريخ اليوم</label>
                <input name="date" type="date">
            </div>

            <div class="form-group">
                <label>تاريخ الانتهاء</label>
                <input name="expiration_date" type="date">
            </div>

            <div class="form-group">
                <label>سعر الشحنة</label>
                <input name="shipping_price" type="number" placeholder="أدخل سعر الشحنة">
            </div>

            <div class="form-group">
                <label>ملاحظات</label>
                <textarea name="note" placeholder="أدخل أي ملاحظات إضافية"></textarea>
            </div>

            <button type="submit" class="submit-btn"><i class="fa-solid fa-check"></i> شراء</button>
        </form>
    </div>
</main>
</body>
</html>
