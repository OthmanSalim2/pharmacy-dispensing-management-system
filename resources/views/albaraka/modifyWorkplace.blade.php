<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تحديث مستخدم</title>

    <!-- Font Awesome (optional for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('style/newUser.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('../src/مركز البركة.png') }}">
    <style>
        /* Style Select2 Arabic-friendly */
        .select2-container .select2-selection--single {
            height: 45px;
            border-radius: 10px;
            border: 1px solid #ccc;
            padding: 8px 12px;
            direction: rtl;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 10px;
            right: 10px;
        }

        .select2-results__option {
            direction: rtl;
            text-align: right;
        }

        label {
            font-weight: 600;
            color: #333;
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
    <form action="{{ route('update-workplace') }}" method="POST" class="form">
        @csrf

        <!-- User Selector with Search -->
        <div class="form-group">
            <label>اختر مستخدم موجود</label>
            <select name="user_id" id="userSelect" style="width: 100%;" required></select>
        </div>

        <!-- Workplace Selector -->
        <div class="form-group">
            <label>مكان العمل</label>
            <select name="workplace" id="workplace" style="width: 100%;" required>
                <option value="store">مستودع</option>
                <option value="pharmacy">صيدلية</option>
            </select>
        </div>

        <div class="form-group">
            <label>صلاحية المستخدم</label>
            <select name="role" id="role" style="width: 100%;" required>
                <option value="admin">أدمين</option>
                <option value="user">مستخدم عادي</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="btn-group">
            <button type="submit" class="btn" style="width: 100%">
                <i class="fa fa-briefcase"></i> حفظ التغييرات
            </button>
            <a href="{{ route('home') }}" class="action-btn back-btn" style="width: 100%">
                <i class="fa fa-arrow-right"></i> رجوع
            </a>
        </div>
    </form>
</main>

<!-- === Scripts === -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        // Initialize User Select with AJAX search
        $('#userSelect').select2({
            placeholder: '-- اختر مستخدم --',
            allowClear: true,
            width: '100%',
            ajax: {
                url: '{{ route("users.search") }}', // create this route in web.php
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {q: params.term}; // search term
                },
                processResults: function (data) {
                    return {
                        results: data.map(user => ({
                            id: user.id,
                            text: user.name,
                            workplace: user.workplace
                        }))
                    };
                },
                cache: true
            },
            language: {
                inputTooShort: () => "اكتب على الأقل حرفين للبحث...",
                noResults: () => "لا يوجد نتائج",
                searching: () => "جاري البحث..."
            }
        });

        // Initialize workplace dropdown
        $('#workplace').select2({
            placeholder: "اختر مكان العمل",
            minimumResultsForSearch: Infinity,
            width: '100%'
        });

        // Update workplace automatically when selecting user
        $('#userSelect').on('select2:select', function (e) {
            const user = e.params.data;
            if (user.workplace === 'صيدلية' || user.workplace === 'pharmacy') {
                $('#workplace').val('pharmacy').trigger('change');
            } else {
                $('#workplace').val('store').trigger('change');
            }
        });

        // Clear workplace when user is cleared
        $('#userSelect').on('select2:clear', function () {
            $('#workplace').val('store').trigger('change');
        });
    });
</script>

</body>
</html>
