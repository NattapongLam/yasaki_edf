<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>YSK5-FM-LAB-11 บันทึกค่าการตรวจสอบเครื่องมือก่อนการใช้งาน (Daily Check Form)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            @page {
                size: A4 landscape;
                margin: 10mm;
            }
            .no-print { display: none !important; }
            body, html { 
                height: 100% !important;
                background-color: white !important; 
                padding: 0 !important; 
                margin: 0 !important; 
            }
            .print-container { 
                border: none !important; 
                box-shadow: none !important; 
                padding: 5mm !important; 
                width: 100% !important;
                font-size: 11px !important;
            }
            .table-custom th, .table-custom td { 
                padding: 4px 6px !important; 
                font-size: 11px !important; 
            }
            input.form-control {
                border: none !important;
                background: transparent !important;
                text-align: center;
                padding: 0 !important;
                font-size: 11px !important;
                height: 20px !important;
            }
            .compact-section { margin-bottom: 6px !important; }
        }
        .table-custom th, .table-custom td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            font-size: 13px;
            vertical-align: middle;
            text-align: center;
        }
        .table-custom th { 
            background-color: #f1f5f9; 
            font-weight: 600;
        }
        input.form-control {
            width: 100%;
            text-align: center;
            background-color: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 4px;
            font-size: 13px;
            outline: none;
            height: 32px;
        }
        input.form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }
        input.form-control:read-only {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
        }
    </style>
</head>
<body class="bg-slate-100 p-2">

    @if(session('success'))
        <div class="max-w-[1400px] mx-auto mb-3 p-3 bg-green-100 text-green-700 rounded-lg border border-green-300 text-sm no-print">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-[1400px] mx-auto mb-3 p-3 bg-red-100 text-red-700 rounded-lg border border-red-300 text-sm no-print">
            <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('report.daily-check.store', $testId ?? 1) }}" method="POST">
        @csrf

        <!-- Toolbar (No Print) -->
        <div class="max-w-[1400px] mx-auto mb-3 p-3 bg-white shadow-sm rounded-lg flex justify-between items-center no-print">
            <div>
                <h1 class="font-bold text-slate-700 text-sm">YSK5-FM-LAB-11</h1>
                <p class="text-xs text-slate-500">บันทึกค่าการตรวจสอบเครื่องมือก่อนการใช้งาน (Daily Check Form)</p>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md text-sm hover:bg-green-700 font-medium flex items-center gap-2 shadow-sm transition-colors cursor-pointer">
                    <i class="fas fa-save"></i> บันทึกข้อมูล
                </button>
                <button type="button" onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 font-medium flex items-center gap-2 shadow-sm transition-colors cursor-pointer">
                    <i class="fas fa-print"></i> พิมพ์เอกสาร
                </button>
            </div>
        </div>

        <!-- A4 Landscape Container -->
        <div class="max-w-[1400px] mx-auto bg-white p-4 rounded-lg shadow-md border border-slate-300 print-container space-y-3"> 
            
            <!-- Header -->
            <div class="flex justify-between items-center border-b border-slate-300 pb-2 compact-section">
                <img src="{{ URL::asset('assets/images/KK-C.png') }}" class="h-10 object-contain" alt="Logo">
                <div>
                    <h2 class="text-base font-bold tracking-wide text-slate-800 text-center">บันทึกค่าการตรวจสอบเครื่องมือก่อนการใช้งาน (Daily Check Form)</h2>
                </div> 
                <div class="text-right">
                    <span class="text-xs font-semibold text-slate-600 bg-slate-100 px-2.5 py-1 rounded border border-slate-200">YSK5-FM-LAB-11: Rev.00:01/08/2569</span>
                </div>
            </div>

            <!-- Instrument Info Fields -->
            <div class="grid grid-cols-2 md:grid-cols-2 gap-3 bg-slate-50 p-3 rounded-md border border-slate-200 text-xs">
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-slate-700 w-28 shrink-0">Instrument Name:</span>
                    <input type="text" name="instrument_name" class="form-control" value="{{ $hd->instrument_name ?? $cal->calibration_lists_name2 ?? '' }}">
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-slate-700 w-28 shrink-0">Specification:</span>
                    <input type="text" name="specification" class="form-control" value="{{ $hd->specification ?? '' }}">
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-slate-700 w-28 shrink-0">Model:</span>
                    <input type="text" name="model" class="form-control" value="{{ $hd->model ?? $bom->ms_formule_name ?? '' }}">
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-slate-700 w-28 shrink-0">Serial Number:</span>
                    <input type="text" name="serial_number" class="form-control" value="{{ $hd->serial_number ?? $cal->calibration_lists_serialno ?? '' }}">
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-slate-700 w-28 shrink-0">Cal Date:</span>
                    <input type="date" name="cal_date" class="form-control" value="{{ $hd->cal_date ?? $cal->calibration_lists_nextdate ?? '' }}">
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-slate-700 w-28 shrink-0">Certificate No.:</span>
                    <input type="text" name="certificate_no" class="form-control" value="{{ $hd->certificate_no ?? $cal->calibration_lists_reamrk ?? '' }}">
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-slate-700 w-28 shrink-0">Refer Doc.:</span>
                    <input type="text" name="refer_doc" class="form-control" value="{{ $hd->refer_doc ?? $reqdoc->ar_requestorder_hds_docuno ?? '' }}">
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-slate-700 w-28 shrink-0">Test Range Voltage:</span>
                    <input type="text" name="test_range_voltage" class="form-control" value="{{ $hd->test_range_voltage ?? '' }}">
                </div>
            </div>

            <!-- Table: Daily Check Data (รายครั้งต่อวัน) -->
            <div class="compact-section">
                <div class="overflow-x-auto">
                    <table class="w-full table-custom border-collapse">
                        <thead>
                            <tr>
                                <th rowspan="2" class="w-32">Date</th>
                                <th rowspan="2" class="w-12">No</th>
                                <th colspan="3">Input with mV value</th>
                                <th rowspan="2" class="w-24">X-Bar</th>
                                <th rowspan="2" class="w-24">Min Spec (mV)</th>
                                <th rowspan="2" class="w-24">Max Spec (mV)</th>
                                <th rowspan="2" class="w-28">Pass/Fail</th>
                                <th rowspan="2" class="w-40">Check by / Approve by</th>
                            </tr>
                            <tr>
                                <th class="w-24">X1</th>
                                <th class="w-24">X2</th>
                                <th class="w-24">X3</th>
                            </tr>
                        </thead>
                       <tbody id="table-body">
    @if ($dt && $dt->count() > 0)
        @foreach ($dt as $index => $item)
            @php $i = $index + 1; @endphp
            <tr data-index="{{ $i }}">
                <td>
                    <input type="date" name="check_date[{{ $i }}]" class="form-control" value="{{ $item->check_date ?? date('Y-m-d') }}">
                </td>
                <td class="font-medium bg-slate-50">{{ $i }}</td>
                <td><input type="number" step="any" name="x1[{{ $i }}]" class="form-control x1" value="{{ $item->x1 ?? '0.00' }}"></td>
                <td><input type="number" step="any" name="x2[{{ $i }}]" class="form-control x2" value="{{ $item->x2 ?? '0.00' }}"></td>
                <td><input type="number" step="any" name="x3[{{ $i }}]" class="form-control x3" value="{{ $item->x3 ?? '0.00' }}"></td>
                <td><input type="text" name="x_bar[{{ $i }}]" class="form-control x-bar" value="{{ $item->x_bar ?? '0.00' }}" readonly></td>
                <td><input type="number" step="any" name="min_spec[{{ $i }}]" class="form-control min-spec" value="{{ $item->min_spec ?? '0.00' }}"></td>
                <td><input type="number" step="any" name="max_spec[{{ $i }}]" class="form-control max-spec" value="{{ $item->max_spec ?? '100.00' }}"></td>
                <td>
                    <span class="eval-display font-bold text-sm">{{ $item->pass_fail ?? '-' }}</span>
                    <input type="hidden" name="pass_fail[{{ $i }}]" class="eval-val" value="{{ $item->pass_fail ?? '' }}">
                </td>
                <td>
                    <input type="text" name="checker[{{ $i }}]" class="form-control text-xs" value="{{ $item->checker ?? (Auth::user()->name ?? '') }}">
                </td>
            </tr>
        @endforeach
    @else
        @for($i = 1; $i <= 3; $i++)
            <tr data-index="{{ $i }}">
                <td>
                    <input type="date" name="check_date[{{ $i }}]" class="form-control" value="{{ date('Y-m-d') }}">
                </td>
                <td class="font-medium bg-slate-50">{{ $i }}</td>
                <td><input type="number" step="any" name="x1[{{ $i }}]" class="form-control x1" value="0.00"></td>
                <td><input type="number" step="any" name="x2[{{ $i }}]" class="form-control x2" value="0.00"></td>
                <td><input type="number" step="any" name="x3[{{ $i }}]" class="form-control x3" value="0.00"></td>
                <td><input type="text" name="x_bar[{{ $i }}]" class="form-control x-bar" value="0.00" readonly></td>
                <td><input type="number" step="any" name="min_spec[{{ $i }}]" class="form-control min-spec" value="0.00"></td>
                <td><input type="number" step="any" name="max_spec[{{ $i }}]" class="form-control max-spec" value="100.00"></td>
                <td>
                    <span class="eval-display font-bold text-sm">-</span>
                    <input type="hidden" name="pass_fail[{{ $i }}]" class="eval-val">
                </td>
                <td>
                    <input type="text" name="checker[{{ $i }}]" class="form-control text-xs" value="{{ Auth::user()->name ?? '' }}">
                </td>
            </tr>
        @endfor 
    @endif                        
</tbody>
                    </table>
                </div>
            </div>

        </div>
    </form>

    <!-- Script คำนวณ X-Bar และ Pass/Fail อัตโนมัติ -->
    <script>
        function calculateDailyCheck() {
            const rows = document.querySelectorAll('#table-body tr');
            rows.forEach((row) => {
                let x1 = parseFloat(row.querySelector('.x1').value) || 0;
                let x2 = parseFloat(row.querySelector('.x2').value) || 0;
                let x3 = parseFloat(row.querySelector('.x3').value) || 0;
                
                let minSpec = parseFloat(row.querySelector('.min-spec').value) || 0;
                let maxSpec = parseFloat(row.querySelector('.max-spec').value) || 100;

                let xBar = (x1 + x2 + x3) / 3;
                row.querySelector('.x-bar').value = xBar.toFixed(2);

                let evalDisplay = row.querySelector('.eval-display');
                let evalValInput = row.querySelector('.eval-val');

                if (xBar >= minSpec && xBar <= maxSpec) {
                    evalDisplay.innerHTML = '<span class="text-green-600 bg-green-50 px-2 py-0.5 rounded border border-green-200">Pass</span>';
                    evalValInput.value = "Pass";
                } else {
                    evalDisplay.innerHTML = '<span class="text-red-600 bg-red-50 px-2 py-0.5 rounded border border-red-200">Fail</span>';
                    evalValInput.value = "Fail";
                }
            });
        }

        document.querySelectorAll('#table-body input').forEach(input => {
            input.addEventListener('input', calculateDailyCheck);
        });

        window.onload = calculateDailyCheck;
    </script>
</body>
</html>