<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user ?? null ? 'تحديث مستخدم' : 'إضافة مستخدم' }}</title>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('style/newUser.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('../src/مركز البركة.png') }}">
    <style>
        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 8px;
            direction: rtl;
        }

        .radio-group label {
            font-family: "Cairo", sans-serif;
            font-size: 15px;
            color: #333;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .radio-group input[type="radio"] {
            accent-color: #00897b; /* green highlight color */
            transform: scale(1.2);
            cursor: pointer;
        }

    </style>
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
            <span>{{ Auth::user()->name }}</span>
        </div>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn">
                <i class="fa fa-sign-out-alt"></i> تسجيل الخروج
            </button>
        </form>
    </div>
</header>

<!-- === Main Form === -->
<main>
    <form action="{{ route('store-user') }}" method="POST" class="form">
        @csrf
        <div class="form-group">
            <label>الاسم </label>
            <input type="text" name="name" required placeholder="أدخل الاسم ">
        </div>
        <div class="form-group">
            <label>اسم المستخدم</label>
            <input type="text" name="username" required placeholder="أدخل اسم المستخدم">
        </div>
        <div class="form-group">
            <label>ايميل</label>
            <input type="text" name="email" required placeholder="أدخل اسم الايميل">
        </div>
        <div class="form-group">
            <label>نوع المستخدم</label>
            <div class="radio-group">
                <label>
                    <input type="radio" name="role" value="admin" required>
                    <span>مدير النظام</span>
                </label>
                <label>
                    <input type="radio" name="role" value="user">
                    <span>مستخدم عادي</span>
                </label>
            </div>
        </div>


        <div class="form-group">
            <label>كلمة المرور</label>
            <input type="password" name="password" required placeholder="أدخل كلمة المرور">
        </div>
        <div class="form-group">
            <label>مكان العمل</label>
            <select name="workplace" required>
                <option value="store">مستودع</option>
                <option value="pharmacy">صيدلية</option>
            </select>
        </div>

        <button type="submit" class="btn"><i class="fa fa-user-plus"></i> إضافة مستخدم</button>
        <div class="btn-group">
            <a href="{{ route('home') }}" class="action-btn back-btn" style="width: 100%">
                <i class="fa fa-arrow-right"></i> رجوع
            </a>
        </div>
    </form>

</main>


</body>
</html>
