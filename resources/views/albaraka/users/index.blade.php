<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المستخدمين</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('../src/مركز البركة.png') }}">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1300px;
            margin: 40px auto;
            padding: 25px 30px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        h1 {
            text-align: center;
            color: #0b3d91;
            margin-bottom: 25px;
            font-weight: 700;
            font-size: 28px;
        }

        .btn-back {
            display: inline-block;
            margin-bottom: 15px;
            background: #6c757d;
            color: #fff;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-back:hover {
            background: #5a6268;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 14px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #0b3d91;
            color: #fff;
            font-weight: 600;
        }

        tr:hover {
            background: #f4f8ff;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: 0.3s;
        }

        .edit-btn {
            background: #17a2b8;
            color: #fff;
        }

        .edit-btn:hover {
            background: #138496;
        }

        .delete-btn {
            background: #dc3545;
            color: #fff;
        }

        .delete-btn:hover {
            background: #c82333;
        }

        .no-data {
            text-align: center;
            color: #777;
            padding: 15px;
        }

        @media (max-width: 768px) {
            table, th, td {
                font-size: 14px;
            }

            .action-btn {
                padding: 5px 10px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1><i class="fa-solid fa-users-gear"></i> إدارة المستخدمين</h1>

    <a href="{{ route('home') }}" class="btn-back"><i class="fa-solid fa-arrow-right"></i> رجوع</a>

    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>الاسم</th>
            <th>البريد الإلكتروني</th>
            <th>الدور</th>
            <th>تاريخ الإنشاء</th>
            <th>الإجراءات</th>
        </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="action-btn edit-btn">
                        <i class="fa-solid fa-pen-to-square"></i> تعديل
                    </a>

                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;"
                          onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete-btn">
                            <i class="fa-solid fa-trash"></i> حذف
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="no-data">لا يوجد مستخدمين في النظام</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

</body>
</html>
