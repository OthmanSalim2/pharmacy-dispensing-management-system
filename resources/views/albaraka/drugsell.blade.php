<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>صرف العلاجات</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Your CSS -->
    <link rel="stylesheet" href="{{ asset('style/styleDrugsell.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('../src/مركز البركة.png') }}">

    <style>
        /* Minimal dropdown and list styling */
        #medicine-results {
            list-style: none;
            margin: 6px 0 12px 0;
            padding: 6px;
            background: #fff;
            border: 1px solid #ccc;
            max-height: 180px;
            overflow: auto;
            display: none;
            position: absolute;
            z-index: 999;
            width: 90%;
        }

        #medicine-results.visible {
            display: block;
        }

        #medicine-results li {
            padding: 8px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }

        #medicine-results li:hover {
            background: #f3f7f6;
        }

        #selected-medicines {
            list-style: none;
            padding: 0;
            margin: 8px 0 0 0;
        }

        #selected-medicines li {
            background: #fff;
            border: 1px solid #ddd;
            padding: 8px 10px;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        #selected-medicines li button {
            background: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 4px 8px;
            cursor: pointer;
        }

        table input {
            width: 60px;
        }
    </style>
</head>
<body>

<header class="main-header">
    <div class="header-container">
        <div class="logo-section">
            <img src="{{ asset('../src/مركز البركة.png') }}" alt="Logo" class="logo">
            <h1 class="clinic-name">مركز البركة الطبي التخصصي</h1>
        </div>
        <div class="user-section">
            <span class="username"><i class="fa-solid fa-user"></i> {{ Auth::user()->name }}</span>
            <a href="{{ route('logout') }}" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i> تسجيل الخروج
            </a>
        </div>
    </div>
</header>

<div class="back-btn-container">
    <a href="{{ route('home') }}" class="back-btn">
        <i class="fa-solid fa-arrow-right"></i> رجوع
    </a>
</div>

<div class="bodyArea">

    <!-- SIDEBAR -->
    <aside class="sidebar-container">
        <div class="sidebar-top">
            <a href="{{ route('home') }}">
                <button><i class="fa-solid fa-house"></i> الرئيسية</button>
            </a>
            <a href="{{ route('show-prescription-archive') }}">
                <button><i class="fa-solid fa-box-archive"></i> أرشيف الروشتات</button>
            </a>
            <a href="{{ route('show-pharmacy-orders') }}">
                <button><i class="fa-solid fa-prescription-bottle-medical"></i> طلبات الصيدلية</button>
            </a>
            <a href="{{ route('pharmacy-stock') }}">
                <button><i class="fa-solid fa-warehouse"></i> مخزون الصيدلية</button>
            </a>
        </div>

        <div class="sidebar-bottom">
            <h4>إضافة الأدوية (سريع)</h4>

            <!-- Search input -->
            <div style="position: relative;">
                <input type="text" id="medicine-search" placeholder="ابحث عن دواء (اسم أو كود)..." autocomplete="off"/>
                <ul id="medicine-results" aria-hidden="true"></ul>
            </div>

            <h5 style="margin-top:12px;">قائمة الأدوية المضافة</h5>
            <ul id="selected-medicines">
                @foreach($pharmacyStock as $med)
                    <li data-code="{{ $med->medicine_code }}">
                        <span class="item-label">{{ $med->name ?? $med->medicine_code }}</span>
                        <div>
                            <button type="button" class="remove-btn">×</button>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </aside>

    <!-- ADD MEDICINE + ROSHTA FORM -->
    <form action="{{ route('drugsell.store') }}" method="POST" class="flex-forms">
        @csrf

        <section class="add-medicine">
            <h2><i class="fa-solid fa-pills"></i> إضافة دواء</h2>

            <div class="row">
                <label>الكود</label>
                <input type="text" name="code" id="code-input" required/>
                <label>الاسم</label>
                <input type="text" name="name" id="name-input" disabled/>
            </div>

            <div class="row">
                <label>المادة الفعالة</label>
                <input type="text" name="active_ingredient" id="active-input" disabled/>
                <label>الكمية</label>
                <input type="number" name="quantity" id="quantity-input" min="1" value="1" disabled/>
            </div>

            <div class="row">
                <label>نوع الدواء</label>
                <select name="treatment_type" id="drug-type-select" required>
                    <option>Tablet</option>
                    <option>Syrup</option>
                    <option>Injection</option>
                    <option>Ointment</option>
                    <option>Cream</option>
                    <option>Suppository</option>
                    <option>Drop</option>
                </select>
            </div>

            <div class="row">
                <label>سعر البيع</label>
                <div class="prices">
                    <label>
                        <input type="radio" name="selected_price" value="price"> سعر الجملة
                    </label>
                    <label>
                        <input type="radio" name="selected_price" value="pharmacy_price"> سعر الصيدلية

                    </label>
                    <label>
                        <input type="radio" name="selected_price" value="patient_price" checked> سعر المريض
                    </label>
                </div>

            </div>

            <div class="row">
                <label>الوحدة</label>
                <div class="prices">
                    <label><input type="radio" name="unit_type" value="حبة"> حبة</label>
                    <label><input type="radio" name="unit_type" value="علبة"> علبة</label>
                    <label><input type="radio" name="unit_type" value="شريط" checked> شريط</label>
                </div>
            </div>


            <div class="row">
                <label>سعر الوحدة</label>
                <input type="number" name="unit_price" id="unit-price-input" value="0.0" min="0" step="0.01" disabled/>
                <label>عدد الوحدات</label>
                <input type="number" name="unit_count" id="unit-count-input" min="1" value="1" required/>
            </div>

            <div class="form-footer">
                <div class="form-buttons">
                    <button type="button" id="add-to-roshta" class="add"><i class="fa-solid fa-plus"></i> إضافة</button>
                    <button type="reset" class="cancel"><i class="fa-solid fa-xmark"></i> إلغاء</button>
                </div>
                <div class="total-section">
                    <label>السعر الكلي</label>
                    <input type="text" name="total" id="total-input" placeholder="0.00" disabled/>
                </div>
            </div>
        </section>
    </form>

    <form id="roshta-form" action="{{ route('roshta.store') }}" method="POST" class="flex-forms">
        @csrf

        <section class="roshta">
            <h3><i class="fa-solid fa-prescription-bottle"></i> روشتة</h3>

            <label>اسم المريض</label>
            <input type="text" name="patient_name" placeholder="اسم المريض" required/>

            <table>
                <thead>
                <tr>
                    <th>اسم العلاج</th>
                    <th>الكمية</th>
                    <th>نوع الوحدة</th>
                    <th>سعر العلاج</th>
                    <th>الإعدادات</th>
                </tr>
                </thead>
                <tbody id="roshta-items">
                <tr>
                    <td colspan="5">لا توجد أصناف مضافة بعد.</td>
                </tr>
                </tbody>
            </table>

            <div class="row" style="margin-top:10px;">
                <label>السعر الكلي</label>
                <input type="text" name="roshta_total" id="roshta-total" placeholder="0"/>
            </div>

            <!-- ✅ Hidden input for all roshta items -->
            <input type="hidden" name="roshta_medicines" id="roshta-items-input">
            <input type="hidden" name="is_exempt" id="is-exempt" value="0"> <!-- جديد -->


            <div class="buttons">
                <button type="submit" class="success"><i class="fa-solid fa-check"></i> إعفاء؟</button>
                <button type="button" class="warning"><i class="fa-solid fa-pause"></i> تعليق</button>
                <button type="button" class="danger"><i class="fa-solid fa-trash"></i> إلغاء</button>
                <button id="dispense-btn" type="submit" class="info">صرف</button>
            </div>

            <div class="row" style="margin-top:10px;">
                <label>سبب الإعفاء</label>
                <input id="exemption_reason" type="text" name="exemption_reason" placeholder="أدخل السبب"/>
            </div>
        </section>
    </form>
</div>

<script>
    const searchInput = document.getElementById('medicine-search');
    const resultsList = document.getElementById('medicine-results');
    const selectedList = document.getElementById('selected-medicines');
    const codeInput = document.getElementById('code-input');
    const nameInput = document.getElementById('name-input');
    const activeInput = document.getElementById('active-input');
    const drugTypeSelect = document.getElementById('drug-type-select');
    const unitPriceInput = document.getElementById('unit-price-input');
    const unitCountInput = document.getElementById('unit-count-input');
    const unitTypeRadios = document.querySelectorAll('input[name="unit_type"]');
    const priceTypeRadios = document.querySelectorAll('input[name="selected_price"]');
    const totalInput = document.getElementById('total-input');
    const roshtaBody = document.getElementById('roshta-items');
    const roshtaTotalInput = document.getElementById('roshta-total');
    const addToRoshtaBtn = document.getElementById('add-to-roshta');

    let currentMedicine = null;
    let searchTimer = null;

    // ----------------- Live Search -----------------
    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimer);
        const query = this.value.trim();
        if (!query) return hideResults();
        searchTimer = setTimeout(() => searchMedicine(query), 250);
    });

    async function searchMedicine(query) {
        try {
            const res = await fetch(`/medicine/search?query=${encodeURIComponent(query)}`, {headers: {'X-Requested-With': 'XMLHttpRequest'}});
            if (!res.ok) return hideResults();
            const data = await res.json();
            resultsList.innerHTML = '';
            if (!Array.isArray(data) || !data.length) return hideResults();

            data.forEach(med => {
                if ([...selectedList.children].some(li => li.dataset.code === String(med.code))) return;
                const li = document.createElement('li');
                li.textContent = `${med.name} (${med.code})`;
                li.dataset.code = med.code;
                li.addEventListener('click', () => {
                    addFastMedicine(med);
                    hideResults();
                    searchInput.value = '';
                });
                resultsList.appendChild(li);
            });
            resultsList.classList.add('visible');
        } catch (e) {
            hideResults();
        }
    }

    function hideResults() {
        resultsList.classList.remove('visible');
        resultsList.innerHTML = '';
    }

    // ----------------- Selected Medicines -----------------
    function addToSelectedList(med) {
        if ([...selectedList.children].some(li => li.dataset.code === String(med.code))) return;
        const li = document.createElement('li');
        li.dataset.code = med.code;
        li.dataset.med = JSON.stringify(med);
        li.innerHTML = `<span>${med.name}</span> <button type="button" class="remove-btn">×</button>`;
        li.querySelector('.remove-btn').addEventListener('click', e => {
            e.stopPropagation();
            li.remove();
            saveSelectedMeds();
        });
        li.addEventListener('click', () => fillForm(med));
        selectedList.appendChild(li);
        saveSelectedMeds();
    }

    function saveSelectedMeds() {
        const meds = [...selectedList.children].map(li => JSON.parse(li.dataset.med || '{}'));
        localStorage.setItem('selectedMeds', JSON.stringify(meds));
    }

    document.addEventListener('DOMContentLoaded', () => {
        const saved = JSON.parse(localStorage.getItem('selectedMeds') || '[]');
        saved.forEach(m => addToSelectedList(m));
    });

    // ----------------- Fill Form -----------------
    function fillForm(med) {
        currentMedicine = med;
        codeInput.value = med.code || '';
        nameInput.value = med.name || '';
        activeInput.value = med.active_ingredient || '';
        drugTypeSelect.value = med.treatment_type || '';
        unitCountInput.value = 1;

        unitTypeRadios.forEach(r => r.checked = (r.value === med.unit_type));
        priceTypeRadios.forEach(r => r.checked = (r.value === 'patient_price')); // default

        setTimeout(updateUnitPrice, 0);
    }

    // ----------------- Update Price & Total -----------------
    function updateUnitPrice() {
        if (!currentMedicine) return;
        const priceType = document.querySelector('input[name="selected_price"]:checked')?.value || 'patient_price';
        const unitType = document.querySelector('input[name="unit_type"]:checked')?.value || 'شريط';
        const basePrice = parseFloat(currentMedicine[priceType] || 0);
        const pillsPerStrip = parseFloat(currentMedicine.pills_per_strip || 1);
        const stripsPerBox = parseFloat(currentMedicine.strips_per_box || 1);

        let price = basePrice;
        if (unitType === 'حبة') price = basePrice / pillsPerStrip;
        else if (unitType === 'علبة') price = basePrice * stripsPerBox;

        unitPriceInput.value = price.toFixed(2);
        computeTotal();
    }

    function computeTotal() {
        const price = parseFloat(unitPriceInput.value) || 0;
        const count = parseFloat(unitCountInput.value) || 1;
        totalInput.value = (price * count).toFixed(2);
    }

    unitTypeRadios.forEach(r => r.addEventListener('change', updateUnitPrice));
    priceTypeRadios.forEach(r => r.addEventListener('change', updateUnitPrice));
    unitCountInput.addEventListener('input', computeTotal);

    // ----------------- Add to Roshta -----------------
    addToRoshtaBtn.addEventListener('click', () => {
        if (!currentMedicine) return alert('اختر الدواء أولا');
        addMedicineToRoshta({
            code: codeInput.value,
            name: nameInput.value,
            unit_price: parseFloat(unitPriceInput.value) || 0,
            unit_count: parseInt(unitCountInput.value) || 1,
            unit_type: [...unitTypeRadios].find(r => r.checked)?.value || 'شريط',
            pills_per_strip: currentMedicine.pills_per_strip,
            strips_per_box: currentMedicine.strips_per_box,
            patient_price: currentMedicine.patient_price,
        });
    });

    function addMedicineToRoshta(med) {
        if (roshtaBody.querySelector('tr td[colspan="5"]')) roshtaBody.querySelector('tr td[colspan="5"]').parentElement.remove();

        const tr = document.createElement('tr');
        tr.dataset.med = JSON.stringify(med);
        tr.innerHTML = `
        <td>${med.name}</td>
        <td><input type="number" class="roshta-unit" value="${med.unit_count}" min="1"></td>
        <td>
            <select class="roshta-unit-type">
                <option value="حبة" ${med.unit_type === 'حبة' ? 'selected' : ''}>حبة</option>
                <option value="شريط" ${med.unit_type === 'شريط' ? 'selected' : ''}>شريط</option>
                <option value="علبة" ${med.unit_type === 'علبة' ? 'selected' : ''}>علبة</option>
            </select>
        </td>
        <td class="roshta-price">${med.unit_price.toFixed(2)}</td>
        <td><button type="button" class="remove-roshta">×</button></td>
        <input type="hidden" name="roshta_medicines[][medicine_code]" value="${med.code}">
        <input type="hidden" name="roshta_medicines[][unit_count]" value="${med.unit_count}">
        <input type="hidden" name="roshta_medicines[][unit_price]" value="${med.unit_price}">
        <input type="hidden" name="roshta_medicines[][unit_type]" value="${med.unit_type}">
    `;

        const unitInput = tr.querySelector('.roshta-unit');
        const unitTypeSelect = tr.querySelector('.roshta-unit-type');
        const priceCell = tr.querySelector('.roshta-price');
        const hiddenUnit = tr.querySelector('input[name="roshta_medicines[][unit_count]"]');
        const hiddenPrice = tr.querySelector('input[name="roshta_medicines[][unit_price]"]');
        const hiddenType = tr.querySelector('input[name="roshta_medicines[][unit_type]"]');

        function updateRow() {
            let price = parseFloat(med.patient_price || 0);
            if (unitTypeSelect.value === 'حبة') price /= med.pills_per_strip || 1;
            if (unitTypeSelect.value === 'علبة') price *= med.strips_per_box || 1;

            const count = parseFloat(unitInput.value) || 1;
            priceCell.textContent = (price * count).toFixed(2);
            hiddenUnit.value = count;
            hiddenPrice.value = price.toFixed(2);
            hiddenType.value = unitTypeSelect.value;
            computeRoshtaTotal();
        }

        unitInput.addEventListener('input', updateRow);
        unitTypeSelect.addEventListener('change', updateRow);

        tr.querySelector('.remove-roshta').addEventListener('click', () => {
            tr.remove();
            computeRoshtaTotal();
            if (!roshtaBody.children.length) {
                const trp = document.createElement('tr');
                trp.innerHTML = '<td colspan="5">لا توجد أصناف مضافة بعد.</td>';
                roshtaBody.appendChild(trp);
            }
        });

        roshtaBody.appendChild(tr);
        updateRow();
    }

    function computeRoshtaTotal() {
        let total = 0;
        roshtaBody.querySelectorAll('tr').forEach(tr => {
            total += parseFloat(tr.querySelector('.roshta-price')?.textContent || 0);
        });
        roshtaTotalInput.value = total.toFixed(2);
    }

    // ----------------- Fetch by Code -----------------
    codeInput.addEventListener('change', async () => {
        const code = codeInput.value.trim();
        if (!code) return;
        try {
            const res = await fetch(`/medicine/by-code?code=${encodeURIComponent(code)}`, {headers: {'X-Requested-With': 'XMLHttpRequest'}});
            if (!res.ok) {
                alert('الدواء غير موجود');
                return;
            }
            const med = await res.json();
            fillForm(med);
        } catch (e) {
            console.error(e);
            alert('خطأ في جلب الدواء');
        }
    });

    // ----------------- Add Fast Medicine -----------------
    function addFastMedicine(med) {
        // addToSelectedList(med);
        fillForm(med);
        updateUnitPrice();
    }


</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const roshtaForm = document.getElementById("roshta-form");
        const dispenseBtn = document.getElementById('dispense-btn');
        const exemptBtn = document.querySelector('.success'); // إعفاء؟
        const pauseBtn = document.querySelector('.warning');  // تعليق
        const cancelBtn = document.querySelector('.danger');  // إلغاء
        const roshtaBody = document.getElementById('roshta-items');
        const roshtaTotalInput = document.getElementById('roshta-total');
        const roshtaHiddenInput = document.getElementById('roshta-items-input');

        // جمع بيانات الروشتة
        function collectItems() {
            const items = [];
            roshtaBody.querySelectorAll('tr').forEach(row => {
                if (!row.dataset.med) return; // تجاهل الصفوف الافتراضية
                const med = JSON.parse(row.dataset.med);
                if (!med || !med.code) return; // تجاهل الصفوف غير الصالحة

                const unitCount = parseInt(row.querySelector('.roshta-unit')?.value || 1);
                const unitType = row.querySelector('.roshta-unit-type')?.value || 'شريط';
                const unitPrice = parseFloat(row.querySelector('.roshta-price')?.textContent || 0);

                items.push({
                    medicine_code: med.code,
                    unit_count: unitCount,
                    unit_type: unitType,
                    unit_price: unitPrice,
                    total: (unitPrice * unitCount).toFixed(2)
                });
            });
            return items;
        }


        // تحديث السعر الكلي
        function computeRoshtaTotal() {
            let total = 0;
            roshtaBody.querySelectorAll('tr').forEach(tr => {
                const price = parseFloat(tr.querySelector('.roshta-price')?.textContent || 0);
                total += price;
            });
            roshtaTotalInput.value = total.toFixed(2);
        }

        // ----------------- صرف الروشتة -----------------
        dispenseBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const items = collectItems();
            if (items.length === 0) return alert("لم يتم إضافة أي علاج في الروشتة.");

            roshtaHiddenInput.value = JSON.stringify(items);
            roshtaForm.submit();
        });

        // ----------------- إعفاء -----------------

        exemptBtn.addEventListener('click', async function (e) {
            e.preventDefault();

            const items = collectItems();
            if (items.length === 0) return alert("لم يتم إضافة أي علاج في الروشتة.");

            const validItems = items.filter(item => item.medicine_code);
            if (!validItems.length) return alert("بيانات غير صالحة في أحد الأدوية.");

            // اجعل السعر الإجمالي والجزئي صفر
            validItems.forEach(item => {
                item.unit_price = 0;
                item.total = 0;
            });

            // تحديث القيم في الجدول ليظهر 0
            roshtaBody.querySelectorAll('.roshta-price').forEach(cell => {
                cell.textContent = "0.00";
            });
            roshtaTotalInput.value = "0.00";

            // اطلب من المستخدم سبب الإعفاء (أو يمكن أخذها من input)
            const exemptionReason = document.getElementById('exemption_reason');

            if (!exemptionReason) {
                return alert("يجب إدخال سبب الإعفاء!");
            }

            try {
                const response = await fetch("{{ route('roshta.exempt') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        patient_name: roshtaForm.querySelector('input[name="patient_name"]').value,
                        roshta_medicines: validItems,
                        exemption_reason: exemptionReason.value // ✅ use the value, not the element

                    })
                });

                if (!response.ok) throw new Error('Server Error');

                const data = await response.json();
                if (data.success) {
                    alert("تم إعفاء الروشتة بنجاح!");
                    // إعادة تهيئة النموذج بعد الإعفاء
                    roshtaBody.innerHTML = '<tr><td colspan="5">لا توجد أصناف مضافة بعد.</td></tr>';
                    roshtaHiddenInput.value = "";
                } else {
                    alert("حدث خطأ أثناء إرسال الإعفاء!");
                }

            } catch (err) {
                console.error(err);
                alert("حدث خطأ في الخادم!");
            }
        });


        // ----------------- تعليق -----------------
        pauseBtn.addEventListener('click', async function (e) {
            e.preventDefault();
            const items = collectItems();
            if (items.length === 0) return alert("لم يتم إضافة أي علاج في الروشتة.");

            const validItems = items.filter(item => item.medicine_code);
            if (!validItems.length) return alert("بيانات غير صالحة في أحد الأدوية.");

            try {
                const response = await fetch("{{ route('roshta.pause') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        patient_name: roshtaForm.querySelector('input[name="patient_name"]').value,
                        roshta_medicines: validItems,
                    })
                });

                if (!response.ok) throw new Error('Server Error');

                const data = await response.json();
                if (data.success) {
                    alert("تم تعليق الروشتة بنجاح!");
                    // تفريغ الروشتة بعد التعليق
                    roshtaBody.innerHTML = '<tr><td colspan="5">لا توجد أصناف مضافة بعد.</td></tr>';
                    roshtaTotalInput.value = "0.00";
                    roshtaHiddenInput.value = "";
                } else {
                    alert("حدث خطأ أثناء تعليق الروشتة!");
                }

            } catch (err) {
                console.error(err);
                alert("حدث خطأ في الخادم!");
            }
        });

        // ----------------- إلغاء -----------------
        cancelBtn.addEventListener('click', function (e) {
            e.preventDefault();
            roshtaBody.innerHTML = '<tr><td colspan="5">لا توجد أصناف مضافة بعد.</td></tr>';
            roshtaTotalInput.value = "0.00";
            roshtaHiddenInput.value = "";
        });
    });
</script>


</body>
</html>
