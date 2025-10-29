<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سجل المبيعات</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('../src/مركز البركة.png') }}">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: #eef5f9;
            direction: rtl;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 25px 30px;
        }

        h2 {
            text-align: center;
            color: #0b3d91;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            background: #0b3d91;
            color: #fff;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
            margin-bottom: 20px;
        }

        .btn-back i {
            margin-left: 8px;
        }

        .btn-back:hover {
            background: #082b6b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
        }

        th {
            background: #0b3d91;
            color: #fff;
            font-weight: 600;
            padding: 14px;
            text-align: center;
        }

        td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            color: #333;
        }

        tr:hover {
            background-color: #f4f9ff;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            font-size: 16px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="{{ route('show-workhouse') }}" class="btn-back">
        <i class="fa-solid fa-arrow-right"></i> رجوع
    </a>

    <h2><i class="fa-solid fa-receipt"></i> سجل المبيعات</h2>

    <table>
        <thead>
        <tr>
            <th>الكود</th>
            <th>الاسم</th>
            <th>الكمية</th>
            <th>الوحدة</th>
            <th>السعر</th>
            <th>الإجمالي</th>
            <th>التاريخ</th>
            <th>ملاحظات</th>
        </tr>
        </thead>
        <tbody>
        @forelse($sales as $sale)
            <tr>
                <td>{{ $sale->code }}</td>
                <td>{{ $sale->name }}</td>
                <td>{{ $sale->quantity }}</td>
                <td>{{ $sale->unit_type }}</td>
                <td>{{ number_format($sale->price, 2) }}</td>
                <td>{{ number_format($sale->total, 2) }}</td>
                <td>{{ $sale->date }}</td>
                <td>{{ $sale->note ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="no-data">لا توجد مبيعات حالياً</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

</body>
</html>
