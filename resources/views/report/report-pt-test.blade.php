<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>YSK5-FM-LAB-14 บันทึกผลการทดสอบความชำนาญของเจ้าหน้าที่ห้องปฏิบัติการ (PT TEST)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            @page {
                size: A4 landscape;
                margin: 4mm;
            }
            .no-print { display: none !important; }
            body, html { 
                height: 100% !important;
                overflow: hidden !important;
                background-color: white !important; 
                padding: 0 !important; 
                margin: 0 !important; 
            }
            .print-container { 
                border: none !important; 
                box-shadow: none !important; 
                padding: 0 !important; 
                width: 100% !important;
                max-height: 198mm !important;
                font-size: 9px !important;
            }
            .table-custom th, .table-custom td { 
                padding: 1px 3px !important; 
                font-size: 8.5px !important; 
            }
            input.form-control {
                border: none !important;
                background: transparent !important;
                text-align: center;
                padding: 0 !important;
                font-size: 8.5px !important;
                height: 14px !important;
            }
            .compact-section { margin-bottom: 2px !important; }
        }
        .table-custom th, .table-custom td {
            border: 1px solid #cbd5e1;
            padding: 2px 4px;
            font-size: 9.5px;
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
            border-radius: 2px;
            padding: 1px;
            font-size: 9.5px;
            outline: none;
            height: 18px;
        }
        input.form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 1px #3b82f6;
        }
        input.form-control:read-only {
            background-color: transparent;
            border: none;
        }
    </style>
</head>
<body class="bg-slate-100 p-1">

    <!-- แสดงข้อความแจ้งเตือน (ถ้ามี) -->
    @if(session('success'))
        <div class="max-w-[1280px] mx-auto mb-2 p-2 bg-green-100 text-green-700 rounded border border-green-300 text-xs no-print">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-[1280px] mx-auto mb-2 p-2 bg-red-100 text-red-700 rounded border border-red-300 text-xs no-print">
            <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('report.pt-test.store', $testId) }}" method="POST">
        @csrf

        <!-- แผงเครื่องมือด้านบน (ซ่อนตอนพิมพ์) -->
        <div class="max-w-[1280px] mx-auto mb-1.5 p-2 bg-white shadow-sm rounded-lg flex justify-between items-center no-print">
            <div>
                <h1 class="font-bold text-slate-700 text-xs">YSK5-FM-LAB-14</h1>
                <p class="text-[10px] text-slate-500">บันทึกผลการทดสอบความชำนาญ (PT TEST)</p>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700 font-medium flex items-center gap-1.5 shadow-sm transition-colors cursor-pointer">
                    <i class="fas fa-save"></i> บันทึกข้อมูล
                </button>
                <button type="button" onclick="window.print()" class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700 font-medium flex items-center gap-1.5 shadow-sm transition-colors cursor-pointer">
                    <i class="fas fa-print"></i> พิมพ์เอกสาร
                </button>
            </div>
        </div>

        <!-- ส่วนฟอร์มรายงาน A4 แนวนอน -->
        <div class="max-w-[1280px] mx-auto bg-white p-2 rounded-md shadow-md border border-slate-300 print-container space-y-1.5"> 
            
            <!-- Header -->
            <div class="flex justify-between items-center border-b border-slate-300 pb-1 compact-section">
                <img src="{{ URL::asset('assets/images/KK-C.png') }}" class="h-9 object-contain" alt="Logo">
                <div>
                    <h2 class="text-xs font-bold tracking-wide text-slate-800 text-center">บันทึกผลการทดสอบความชำนาญของเจ้าหน้าที่ห้องปฏิบัติการ (PT TEST)</h2>
                    <p class="text-[9.5px] text-slate-600 text-center">การเปรียบเทียบผลระหว่างพนักงานห้องปฏิบัติการ โดยใช้ค่า $E_n$ และเปรียบเทียบด้วยสมการ $E_n$ Ratio</p>
                </div> 
                <div class="text-right">
                    <span class="text-[9.5px] font-semibold text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200">YSK5-FM-LAB-14: Rev.00: 01/08/2569</span>
                </div>
            </div>

            <!-- คำชี้แจงและเกณฑ์การประเมินผล & สูตร -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-1.5 bg-slate-50 p-1.5 rounded border border-slate-200 text-slate-700 text-[9.5px] compact-section">
                <div>
                    <p class="font-semibold text-slate-800"><i class="fas fa-info-circle text-blue-500 mr-1"></i> เกณฑ์การประเมินผล:</p>
                    <ul class="list-disc list-inside text-slate-600 leading-tight">
                        <li>$E_n \le 1$ สอดคล้องกับค่าอ้างอิง (<span class="text-green-600 font-semibold">Pass</span>)</li>
                        <li>$E_n > 1$ ไม่สอดคล้องกับค่าอ้างอิง (<span class="text-red-600 font-semibold">Fail</span>)</li>
                    </ul>
                </div>
                <div class="flex flex-col justify-center items-center bg-white p-1 rounded border border-slate-200">
                    <span class="font-semibold text-slate-800 text-[9.5px]">En Ratio Formula:</span>
                    <span class="text-blue-700 font-bold text-[10.5px]">$$En = \frac{|LAB - REF|}{\sqrt{(U_{LAB})^2 + (U_{REF})^2}}$$</span>
                </div>
            </div>

            <!-- Table 1: Reference Standard Data & Uncertainty -->
            <div class="compact-section">
                <h5 class="text-[9.5px] font-bold text-slate-700 mb-0.5"><i class="fas fa-table text-slate-500 mr-1"></i> Table 1: Reference Standard Data & Uncertainty</h5>
                <div class="overflow-x-auto">
                    <table class="w-full table-custom border-collapse">
                        <thead>
                            <tr>
                                <th class="w-8">No.</th>
                                <th>Report Size (µm)</th>
                                <th>Size Uncertainty (µm) [$U_{REF}$]</th>
                                <th>Ref Value (µm) [$REF$]</th>
                            </tr>
                        </thead>
                        <tbody id="table-ref-body">
                            @for($i = 1; $i <= 6; $i++)
                                <tr id="row-ref-{{ $i }}">
                                    <td class="font-medium bg-slate-50">{{ $i }}</td>
                                    <td><input name="ref_rep[{{ $i }}]" class="form-control ref-rep" type="number" step="any" value="7000"></td>
                                    <td><input name="ref_unc[{{ $i }}]" class="form-control ref-unc" type="number" step="any" value="0.30"></td>
                                    <td><input name="ref_val[{{ $i }}]" class="form-control ref-val" type="number" step="any" value="7000"></td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Table 2: Lab Size Measurement (Cal Curves) -->
            <div class="compact-section">
                <h5 class="text-[9.5px] font-bold text-slate-700 mb-0.5"><i class="fas fa-table text-slate-500 mr-1"></i> Table 2: Lab Size Measurement (Cal Curves)</h5>
                <div class="overflow-x-auto">
                    <table class="w-full table-custom border-collapse">
                        <thead>
                            <tr>
                                <th rowspan="2" class="w-8">No.</th>
                                <th rowspan="2">Report Size (µm)</th>
                                <th colspan="4">Size Measurement (µm)</th>
                                <th rowspan="2" class="w-20">Lab Uncertainty ($U_{LAB}$) (µm)</th>
                            </tr>
                            <tr>
                                <th>Cal Curve 1</th>
                                <th>Cal Curve 2</th>
                                <th>Cal Curve 3</th>
                                <th>Cal Curve 4</th>
                            </tr>
                        </thead>
                        <tbody id="table-lab-body">
                            @php
                                $defaultVals = [
                                    ['c1' => 7000.50, 'c2' => 6999.80, 'c3' => 7000.20, 'c4' => 7000.10],
                                    ['c1' => 7000.00, 'c2' => 7000.00, 'c3' => 7000.00, 'c4' => 7000.00],
                                    ['c1' => 7000.00, 'c2' => 7000.00, 'c3' => 7000.00, 'c4' => 7000.00],
                                    ['c1' => 7000.00, 'c2' => 7000.00, 'c3' => 7000.00, 'c4' => 7000.00],
                                    ['c1' => 7000.00, 'c2' => 7000.00, 'c3' => 7000.00, 'c4' => 7000.00],
                                    ['c1' => 7000.00, 'c2' => 7000.00, 'c3' => 7000.00, 'c4' => 7000.00]
                                ];
                            @endphp

                            @for($i = 1; $i <= 6; $i++)
                                <tr data-index="{{ $i }}">
                                    <td class="font-medium bg-slate-50">{{ $i }}</td>
                                    <td><input name="lab_rep[{{ $i }}]" class="form-control lab-rep" type="number" step="any" value="7000"></td>
                                    <td><input name="lab_c1[{{ $i }}]" class="form-control lab-c1" type="number" step="any" value="{{ $defaultVals[$i-1]['c1'] }}"></td>
                                    <td><input name="lab_c2[{{ $i }}]" class="form-control lab-c2" type="number" step="any" value="{{ $defaultVals[$i-1]['c2'] }}"></td>
                                    <td><input name="lab_c3[{{ $i }}]" class="form-control lab-c3" type="number" step="any" value="{{ $defaultVals[$i-1]['c3'] }}"></td>
                                    <td><input name="lab_c4[{{ $i }}]" class="form-control lab-c4" type="number" step="any" value="{{ $defaultVals[$i-1]['c4'] }}"></td>
                                    <td><input name="lab_u[{{ $i }}]" class="form-control lab-u" type="number" step="any" value="0.75"></td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SUMMARY: En Ratio Calculation & Result Evaluation -->
            <div class="compact-section">
                <h5 class="text-[9.5px] font-bold text-slate-700 mb-0.5"><i class="fas fa-table text-slate-500 mr-1"></i> SUMMARY: En Ratio Calculation & Result Evaluation</h5>
                <div class="overflow-x-auto">
                    <table class="w-full table-custom border-collapse">
                        <thead>
                            <tr>
                                <th rowspan="2" class="w-8">No.</th>
                                <th rowspan="2">Size & Name</th>
                                <th colspan="4">En Ratio (Cal Curves)</th>
                                <th rowspan="2" class="w-20">Evaluation $(|En|\le 1)$</th>
                            </tr>
                            <tr>
                                <th>Cal Curve 1</th>
                                <th>Cal Curve 2</th>
                                <th>Cal Curve 3</th>
                                <th>Cal Curve 4</th>
                            </tr>
                        </thead>
                        <tbody id="table-summary-body">
                            @for($i = 1; $i <= 6; $i++)
                                <tr data-summary-index="{{ $i }}">
                                    <td class="font-medium bg-slate-50">{{ $i }}</td>
                                    <td class="text-slate-700 font-medium text-left px-2">
                                        {{$bom->ms_formule_name}} ({{$bom->chemistry_hd_name}})
                                        <input type="hidden" name="sum_name[{{ $i }}]" value="{{$bom->ms_formule_name}} ({{$bom->chemistry_hd_name}})">
                                    </td>
                                    <td><input type="text" name="sum_en1[{{ $i }}]" class="form-control sum-en1" readonly></td>
                                    <td><input type="text" name="sum_en2[{{ $i }}]" class="form-control sum-en2" readonly></td>
                                    <td><input type="text" name="sum_en3[{{ $i }}]" class="form-control sum-en3" readonly></td>
                                    <td><input type="text" name="sum_en4[{{ $i }}]" class="form-control sum-en4" readonly></td>
                                    
                                    <td class="sum-eval-display font-bold text-center">-</td>
                                    <input type="hidden" name="sum_eval[{{ $i }}]" class="sum-eval-val">
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Signatures Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 pt-1 border-t border-slate-200 text-[9.5px]">
                <div class="border border-slate-200 p-1.5 rounded bg-slate-50 flex justify-between items-center">
                    <div><strong class="text-slate-700">จัดทำโดย:</strong> 
                        <input type="text" name="person_at" class="border-b border-slate-400 bg-transparent outline-none px-1 w-32 text-center inline-block" placeholder="ระบุชื่อ" value="{{Auth::user()->name}}">
                    </div>
                    <div><strong class="text-slate-700">วันที่:</strong> 
                        <input type="date" name="results_date" class="border-b border-slate-400 bg-transparent outline-none px-1 text-center inline-block w-28" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="border border-slate-200 p-1.5 rounded bg-slate-50 flex justify-between items-center">
                    <div><strong class="text-slate-700">ตรวจสอบ:</strong> 
                        <input type="text" name="approved_at" class="border-b border-slate-400 bg-transparent outline-none px-1 w-32 text-center inline-block" placeholder="ระบุชื่อ">
                    </div>
                    <div><strong class="text-slate-700">วันที่:</strong> 
                        <input type="date" name="approved_date" class="border-b border-slate-400 bg-transparent outline-none px-1 text-center inline-block w-28">
                    </div>
                </div>
            </div>

        </div>
    </form>

    <!-- Script สำหรับคำนวณอัตโนมัติแบบ Real-time -->
    <script>
        function calculateAll() {
            for (let i = 1; i <= 6; i++) {
                let refRow = document.getElementById(`row-ref-${i}`);
                let refVal = parseFloat(refRow.querySelector('.ref-val').value) || 0;
                let uRef = parseFloat(refRow.querySelector('.ref-unc').value) || 0;

                let labRow = document.querySelector(`#table-lab-body tr[data-index="${i}"]`);
                let c1 = parseFloat(labRow.querySelector('.lab-c1').value);
                let c2 = parseFloat(labRow.querySelector('.lab-c2').value);
                let c3 = parseFloat(labRow.querySelector('.lab-c3').value);
                let c4 = parseFloat(labRow.querySelector('.lab-c4').value);
                let uLab = parseFloat(labRow.querySelector('.lab-u').value) || 0;

                let sumRow = document.querySelector(`#table-summary-body tr[data-summary-index="${i}"]`);
                
                let curves = [c1, c2, c3, c4];
                let allPass = true;
                let hasData = false;

                curves.forEach((val, idx) => {
                    let inputCell = sumRow.querySelector(`.sum-en${idx + 1}`);
                    if (!isNaN(val)) {
                        hasData = true;
                        let denominator = Math.sqrt(Math.pow(uLab, 2) + Math.pow(uRef, 2));
                        let en = denominator !== 0 ? Math.abs(val - refVal) / denominator : 0;
                        
                        inputCell.value = en.toFixed(2);

                        if (en > 1.0) { allPass = false; }
                    } else {
                        inputCell.value = "-";
                        allPass = false;
                    }
                });

                let evalDisplay = sumRow.querySelector('.sum-eval-display');
                let evalValInput = sumRow.querySelector('.sum-eval-val');
                
                if (hasData) {
                    if (allPass) {
                        evalDisplay.innerHTML = '<span class="text-green-600 bg-green-50 px-1 rounded border border-green-200">Pass</span>';
                        evalValInput.value = "Pass";
                    } else {
                        evalDisplay.innerHTML = '<span class="text-red-600 bg-red-50 px-1 rounded border border-red-200">Fail</span>';
                        evalValInput.value = "Fail";
                    }
                } else {
                    evalDisplay.innerText = "-";
                    evalValInput.value = "";
                }
            }
        }

        function initListeners() {
            const inputs = document.querySelectorAll('#table-ref-body input, #table-lab-body input');
            inputs.forEach(input => {
                input.addEventListener('input', calculateAll);
            });
            calculateAll();
        }

        window.onload = initListeners;
    </script>
</body>
</html>