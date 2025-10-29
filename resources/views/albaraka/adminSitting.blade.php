<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>مركز البركة الطبي التخصصي - إعدادات المستخدم</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('style/adminSetting.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('../src/مركز البركة.png') }}">
</head>
<body>

<!-- Header -->
<header class="site-header">
    <div class="head_logo">
        <div id="logo" aria-hidden="true"></div>
        <div id="textAfterLogo">
            <h1>مركز البركة الطبي التخصصي</h1>
        </div>
    </div>

    <div class="user-actions">
        <span class="user-name">
            <i class="fa fa-user"></i> {{ Auth::user()->name }}
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn">
                <i class="fa fa-sign-out-alt"></i> تسجيل الخروج
            </button>
        </form>
    </div>
</header>

<!-- Main Content -->
<main class="main-wrapper">
    <section class="settings-box">
        <h2><i class="fa fa-cogs"></i> إدارة المستخدمين</h2>

        <form action="{{ route('admin-update-settings') }}" method="POST" class="settings-form">
            @csrf
            @method('PUT')

            <!-- Select User -->
            <div class="form-group">
                <label for="user_id">اختر المستخدم</label>
                <select id="user_id" name="user_id" class="select2" required>
                    <option value="" disabled selected>-- اختر المستخدم --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" data-username="{{ $user->username }}">
                            {{ $user->username }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Username -->
            <div class="form-group">
                <label for="username">اسم المستخدم الجديد</label>
                <input type="text" id="username" name="username" placeholder="أدخل اسم المستخدم الجديد" required>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="new_password">كلمة المرور الجديدة</label>
                <input type="password" id="new_password" name="new_password" placeholder="أدخل كلمة المرور الجديدة">
            </div>

            <div class="form-group">
                <label for="new_password_confirmation">تأكيد كلمة المرور</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                       placeholder="أعد إدخال كلمة المرور الجديدة">
            </div>

            <div class="btn-group">
                <button type="submit" class="action-btn save-btn">
                    <i class="fa fa-floppy-disk"></i> حفظ التغييرات
                </button>
                <a href="{{ route('home') }}" class="action-btn back-btn">
                    <i class="fa fa-arrow-right"></i> رجوع
                </a>
            </div>
        </form>
    </section>
</main>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Initialize Select2 & Auto-fill -->
<script>
    $(document).ready(function () {
        // Initialize Select2
        $('.select2').select2({
            placeholder: "-- اختر المستخدم --",
            allowClear: true,
            width: '100%'
        });

        // Auto-fill username input when user selected
        $('#user_id').on('change', function () {
            const username = $(this).find(':selected').data('username');
            $('#username').val(username);
        });
    });
</script>

</body>
</html>
