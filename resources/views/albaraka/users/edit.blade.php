<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل المستخدم</title>
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
            max-width: 600px;
            margin: 60px auto;
            background: #fff;
            padding: 30px 35px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            color: #0b3d91;
            margin-bottom: 30px;
            font-weight: 700;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
        }

        input, select {
            width: 100%;
            padding: 10px 12px;
            margin-top: 6px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-family: inherit;
            font-size: 15px;
        }

        button {
            width: 100%;
            margin-top: 25px;
            background: #007bff;
            color: #fff;
            border: none;
            padding: 12px 0;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            transition: 0.3s;
        }

        button:hover {
            background: #0056b3;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            color: #6c757d;
            text-decoration: none;
            font-weight: 500;
        }

        .back-btn:hover {
            color: #343a40;
        }

        @media (max-width: 500px) {
            .container {
                padding: 20px;
            }

            input, select {
                font-size: 14px;
            }

            button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2><i class="fa-solid fa-pen-to-square"></i> تعديل بيانات المستخدم</h2>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>الاسم</label>
        <input type="text" name="name" value="{{ $user->name }}" required>

        <label>البريد الإلكتروني</label>
        <input type="email" name="email" value="{{ $user->email }}" required>

        <label>الدور</label>
        <select name="role" required>
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>مسؤول</option>
            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>مستخدم</option>
        </select>

        <button type="submit"><i class="fa-solid fa-floppy-disk"></i> حفظ التغييرات</button>
    </form>

    <a href="{{ route('users.index') }}" class="back-btn"><i class="fa-solid fa-arrow-right"></i> رجوع</a>
</div>

</body>
</html>
