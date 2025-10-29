<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مركز البركة الطبي التخصصي</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style/styleIndex.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('../src/مركز البركة.png') }}">
</head>
<body>

<!-- Header with professional background -->
<header class="site-header">
    <div class="head_logo">
        <div id="logo"></div>
        <div id="textAfterLogo">
            <h1>مركز البركة الطبي التخصصي</h1>
        </div>
    </div>
</header>

<!-- Login form -->
<main class="login-wrapper">
    <form action="{{ route('login') }}" method="post" class="login-form">
        @csrf
        <h2>تسجيل الدخول</h2>

        <div class="enterLogin">
            <label for="username">اسم المستخدم</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="enterLogin">
            <label for="password">كلمة المرور</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" id="loginbtn">تسجيل الدخول</button>
    </form>
</main>

</body>
</html>
