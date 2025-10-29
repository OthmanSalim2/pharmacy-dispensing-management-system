<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>stok</title>
    <link rel="stylesheet" href="{{ asset('style/styleStok.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('../src/مركز البركة.png') }}">
</head>
<body>

<header>
    <div class="head_logo">
        <div id="logo"></div>
        <div id="textAfterLogo">
            <p>
            <h1>مركز البركة الطبي التخصصي</h1></p>
        </div>
        <div id="place">
            <h2>المستودع</h2>
        </div>
    </div>
</header>


<div class="container">

    <!-- زر العودة -->
    <div class="back-btn"><a href="../indexfile/wirehous1.html">
            ⟳
        </a></div>
    <!-- زر إضافة -->
    <a href="../indexfile/adding.html">
        <button class="add-btn">إضافة</button>
    </a>
    <!-- جدول المخزون -->
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
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
    </table>
</div>


</body>
</html>
