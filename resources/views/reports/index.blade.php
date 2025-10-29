<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التقارير اليومية والشهرية</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@500&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('../src/مركز البركة.png') }}">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: #f8fafc;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
        }

        .filters {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .filters form {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        input[type="date"],
        input[type="month"] {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-family: inherit;
        }

        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-family: inherit;
        }

        button:hover {
            background: #0056b3;
        }

        .report-section {
            margin-top: 30px;
        }

        h2 {
            color: #333;
            margin-bottom: 15px;
            border-right: 4px solid #007bff;
            padding-right: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #007bff;
            color: white;
        }

        tr:hover {
            background: #f3f6fa;
        }

        .summary {
            text-align: left;
            margin-top: 15px;
            font-weight: bold;
            color: #007bff;
        }

        .back-btn {
            display: inline-block;
            margin-top: 25px;
            background: #6c757d;
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
            text-decoration: none;
        }

        .back-btn:hover {
            background: #5a6268;
        }

        @media print {
            body {
                background: #fff;
                color: #000;
            }

            .container {
                box-shadow: none;
                margin: 0;
                padding: 0;
                border-radius: 0;
            }

            .filters, .back-btn, button {
                display: none !important;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            .report-section {
                page-break-after: always;
            }
        }

    </style>
</head>
<body>

<div class="container">
    <h1><i class="fa-solid fa-chart-line"></i> التقارير اليومية والشهرية</h1>

    <div class="filters">
        <!-- Daily Report Form -->
        <form action="{{ route('reports.daily') }}" method="GET">
            <label>تقرير يومي:</label>
            <input type="date" name="date" value="{{ request('date') ?? date('Y-m-d') }}">
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i> عرض اليوم</button>
        </form>

        <!-- Monthly Report Form -->
        <form action="{{ route('reports.monthly') }}" method="GET">
            <label>تقرير شهري:</label>
            <input type="month" name="month" value="{{ request('month') ?? date('Y-m') }}">
            <button type="submit"><i class="fa-solid fa-calendar-days"></i> عرض الشهر</button>
        </form>
    </div>

    <!-- Daily Report Section -->
    @isset($dailyReports)
        <div class="report-section">
            <h2><i class="fa-solid fa-sun"></i> التقرير اليومي ({{ $selectedDate }})</h2>

            <table>
                <thead>
                <tr>
                    <th>اسم الدواء</th>
                    <th>الكمية المباعة</th>
                    <th>سعر البيع الكلي</th>
                </tr>
                </thead>
                <tbody>
                @forelse($dailyReports as $report)
                    <tr>
                        <td>{{ $report->name }}</td>
                        <td>{{ $report->sold_quantity }}</td>
                        <td>{{ number_format($report->total_price, 2) }} ₪</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">لا توجد مبيعات في هذا اليوم</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="summary">
                مجموع المبلغ المبيع: <strong>{{ number_format($dailyTotal ?? 0, 2) }} ₪</strong>
            </div>
        </div>
    @endisset

    <!-- Monthly Report Section -->
    @isset($monthlyReports)
        <div class="report-section">
            <h2><i class="fa-solid fa-calendar-week"></i> التقرير الشهري ({{ $selectedMonth }})</h2>

            <table>
                <thead>
                <tr>
                    <th>اليوم</th>
                    <th>عدد الروشتات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($monthlySummary as $day => $count)
                    <tr>
                        <td>{{ $day }}</td>
                        <td>{{ $count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">لا توجد بيانات في هذا الشهر</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <br>

            <table>
                <thead>
                <tr>
                    <th>اسم الدواء</th>
                    <th>الكمية المباعة</th>
                    <th>إجمالي السعر</th>
                </tr>
                </thead>
                <tbody>
                @forelse($monthlyReports as $report)
                    <tr>
                        <td>{{ $report->name }}</td>
                        <td>{{ $report->sold_quantity }}</td>
                        <td>{{ number_format($report->total_price, 2) }} ₪</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">لا توجد مبيعات في هذا الشهر</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="summary">
                مجموع المبلغ المبيع خلال الشهر: <strong>{{ number_format($monthlyTotal ?? 0, 2) }} ₪</strong>
            </div>
        </div>
    @endisset

    <div class="filters" style="margin-top: 20px;">
        <a href="{{ route('home') }}" class="back-btn"><i class="fa-solid fa-arrow-right"></i> رجوع</a>
        <button onclick="window.print();"
                style="background:#28a745;color:#fff;padding:10px 18px;border:none;border-radius:8px;margin-bottom:20px;cursor:pointer;">
            <i class="fa-solid fa-print"></i> طباعة جميع التقارير
        </button>
    </div>


</div>

</body>
</html>
