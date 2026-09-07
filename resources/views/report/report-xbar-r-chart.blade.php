<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>YSK5-FM-LAB-13 X-bar & R Control Chart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { font-size: 9px; background-color: white; padding: 0; margin: 0; }
            .print-container { 
                border: none !important; 
                box-shadow: none !important; 
                padding: 2px !important; 
                max-width: 100% !important;
            }
            /* บีบความสูงกราฟตอนพิมพ์ให้พอดีหน้า A4 แนวนอน */
            .print-chart-x { height: 85px !important; }
            .print-chart-r { height: 60px !important; }
            .table-custom th, .table-custom td { padding: 1.5px 2px !important; font-size: 8.5px; }
        }
        .table-custom th, .table-custom td {
            border: 1px solid #cbd5e1;
            padding: 3px 4px;
            text-align: center;
            font-size: 10px;
        }
        .table-custom th { background-color: #f1f5f9; }
    </style>
</head>
<body class="bg-slate-50 p-4">

    <!-- แผงเครื่องมือด้านบน (ซ่อนตอนพิมพ์) -->
    <div class="max-w-[1200px] mx-auto mb-3 p-3 bg-white shadow-sm rounded-lg flex justify-between items-center no-print">
        <div>
            <h1 class="font-bold text-slate-700 text-sm">ฟอร์มควบคุมสถิติ YSK5-FM-LAB-13</h1>
            <p class="text-xs text-slate-500">มาตรฐาน JIS D 4411 (<span class="uppercase font-semibold text-blue-600">{{ $spcData['jis_class'] ?? 'CLASS_4' }}</span>) - แสดงผลข้อมูล 10 ชุดล่าสุด</p>
        </div>
        <div class="flex gap-3 items-center">
            <form method="GET" action="{{ route('report.xbar', $testId) }}" class="flex gap-2 items-center">
                <label class="text-xs font-semibold text-slate-600">อุณหภูมิ:</label>
                <select name="temperature" class="border rounded px-3 py-1 text-xs" onchange="this.form.submit()">
                    @foreach([100, 150, 200, 250, 300, 350] as $tempOption)
                        <option value="{{ $tempOption }}" {{ $spcData['target_temp'] == $tempOption ? 'selected' : '' }}>
                            {{ $tempOption }} °C
                        </option>
                    @endforeach
                </select>
            </form>
            <button onclick="window.print()" class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700 font-medium flex items-center gap-1">
                <i class="fas fa-print"></i> พิมพ์
            </button>
        </div>
    </div>

    <!-- ส่วนฟอร์มรายงาน A4 แนวนอน -->
    <div class="max-w-[1200px] mx-auto bg-white p-4 rounded-lg shadow-md border border-slate-300 print-container">
        
        <!-- Header -->
        <div class="flex justify-between items-start border-b border-slate-400 pb-2 mb-2">
            <div class="flex items-center gap-3">
                <img src="{{ URL::asset('assets/images/KK-C.png') }}" class="h-9 object-contain" alt="Logo">
                <div>
                    <h2 class="text-lg font-bold tracking-wide text-slate-800">X bar and R Control Chart</h2>
                    <p class="text-[10px] text-slate-500">Form: YSK5-FM-LAB-13 | Rev.00 | 01/08/2569 | Standard: JIS D 4411 <span class="uppercase font-bold">{{ $spcData['jis_class'] ?? '' }}</span></p>
                </div>
            </div>
            
            <table class="text-[10px] border border-slate-400">
                <thead>
                    <tr class="bg-slate-100">
                        <th class="border border-slate-400 px-3 py-0.5">Reported</th>
                        <th class="border border-slate-400 px-3 py-0.5">Reviewed</th>
                        <th class="border border-slate-400 px-3 py-0.5">Approved</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-slate-400 px-3 py-2"></td>
                        <td class="border border-slate-400 px-3 py-2"></td>
                        <td class="border border-slate-400 px-3 py-2"></td>
                    </tr>
                    <tr>
                        <td class="border border-slate-400 px-2 py-0 text-slate-400 text-center text-[9px]">Date:.. /.. /..</td>
                        <td class="border border-slate-400 px-2 py-0 text-slate-400 text-center text-[9px]">Date:.. /.. /..</td>
                        <td class="border border-slate-400 px-2 py-0 text-slate-400 text-center text-[9px]">Date:.. /.. /..</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- รายละเอียดข้อมูล & กล่องสถิติ -->
        <div class="grid grid-cols-4 gap-3 text-xs mb-2">
            <div class="col-span-3 grid grid-cols-2 gap-y-1 border border-slate-300 p-2 rounded text-[11px]">
                <div><span class="font-bold text-slate-600">Customer / Area:</span> {{ $header->Area ?? '-' }}</div>
                <div><span class="font-bold text-slate-600">Characteristic:</span> Coefficient of Friction (μ)</div>
                <div><span class="font-bold text-slate-600">Part No:</span> {{ $header->FormulaNumber ?? '-' }} (Temp: {{ $spcData['target_temp'] }}°C)</div>
                <div><span class="font-bold text-slate-600">Spec Range (JIS):</span> {{ $spcData['lsl'] }} - {{ $spcData['usl'] }} (Tol: ±{{ $spcData['tolerance'] }})</div>
                <div><span class="font-bold text-slate-600">Part Name:</span> {{ $header->FormulaName ?? '-' }}</div>
                <div><span class="font-bold text-slate-600">Latest Lot No:</span> {{ $header->Lot ?? '-' }}</div>
            </div>

            <!-- กล่อง Process Performance -->
            <div class="border border-slate-300 p-1.5 rounded bg-slate-50 grid grid-cols-2 gap-0.5 text-[10px]">
                <div class="font-bold text-blue-800 col-span-2 border-b pb-0.5 mb-0.5 text-center">PROCESS PERFORMANCE</div>
                <div>SD (S): <span class="font-bold">{{ $spcData['overall_sd'] }}</span></div>
                <div>SD (R/d2): <span class="font-bold">{{ $spcData['sigma_r'] }}</span></div>
                <div>Cp: <span class="font-bold text-blue-600">{{ $spcData['cp'] }}</span></div>
                <div>Cpk: <span class="font-bold text-blue-600">{{ $spcData['cpk'] }}</span></div>
                <div>Pp: <span class="font-bold text-green-700">{{ $spcData['pp'] }}</span></div>
                <div>Ppk: <span class="font-bold text-green-700">{{ $spcData['ppk'] }}</span></div>
            </div>
        </div>

        <!-- กราฟ X-bar และ R -->
        <div class="grid grid-cols-1 gap-2 mb-2">
            <div class="border border-slate-300 p-1.5 rounded">
                <div class="flex justify-between items-center px-2 bg-slate-100 py-0.5 mb-1 rounded text-xs">
                    <span class="font-bold text-slate-700 text-[11px]">AVERAGES ( X BAR CHART )</span>
                    <span class="text-[9px] text-slate-600 font-mono">X-double-bar = {{ $spcData['grand_x_bar'] }} | UCL = {{ $spcData['ucl_x'] }} | LCL = {{ $spcData['lcl_x'] }}</span>
                </div>
                <div class="h-[105px] print-chart-x"><canvas id="xBarChart"></canvas></div>
            </div>

            <div class="border border-slate-300 p-1.5 rounded">
                <div class="flex justify-between items-center px-2 bg-slate-100 py-0.5 mb-1 rounded text-xs">
                    <span class="font-bold text-slate-700 text-[11px]">RANGES ( R CHART )</span>
                    <span class="text-[9px] text-slate-600 font-mono">R-bar = {{ $spcData['average_r'] }} | UCL = {{ $spcData['ucl_r'] }} | LCL = {{ $spcData['lcl_r'] }}</span>
                </div>
                <div class="h-[75px] print-chart-r"><canvas id="rChart"></canvas></div>
            </div>
        </div>

        <!-- ตารางข้อมูลดิบ (รองรับ 10 ชุด) -->
        <div class="overflow-x-auto">
            <table class="w-full table-custom border-collapse">
                <thead>
                    <tr>
                        <th class="w-16">Set No.</th>
                        <th class="w-28">Lot No.</th>
                        <th class="w-32">Test Date</th>
                        <th>N1</th>
                        <th>N2</th>
                        <th>N3</th>
                        <th class="bg-cyan-50 text-cyan-900 font-bold">X-bar</th>
                        <th class="bg-blue-50 text-blue-900 font-bold">R (Range)</th>
                        <th>UCL (X)</th>
                        <th>LCL (X)</th>
                        <th>UCL (R)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($spcData['subgroups'] as $sg)
                    <tr>
                        <td class="font-mono bg-slate-50 font-bold">{{ $sg['set_no'] }}</td>
                        <td class="font-mono text-xs">{{ $sg['lot'] }}</td>
                        <td class="font-mono text-[10px] text-slate-500">{{ $sg['date'] }}</td>
                        <td class="font-mono">{{ number_format($sg['values'][0] ?? 0, 3) }}</td>
                        <td class="font-mono">{{ number_format($sg['values'][1] ?? 0, 3) }}</td>
                        <td class="font-mono">{{ number_format($sg['values'][2] ?? 0, 3) }}</td>
                        <td class="font-mono bg-cyan-50/50 font-semibold text-cyan-800">{{ number_format($sg['x_bar'], 3) }}</td>
                        <td class="font-mono bg-blue-50/50 font-semibold text-blue-800">{{ number_format($sg['r'], 3) }}</td>
                        <td class="font-mono text-slate-400">{{ $spcData['ucl_x'] }}</td>
                        <td class="font-mono text-slate-400">{{ $spcData['lcl_x'] }}</td>
                        <td class="font-mono text-slate-400">{{ $spcData['ucl_r'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script>
        const subgroupLabels = {!! json_encode(array_column($spcData['subgroups'], 'set_no')) !!};
        const xBarData = {!! json_encode(array_column($spcData['subgroups'], 'x_bar')) !!};
        const rData = {!! json_encode(array_column($spcData['subgroups'], 'r')) !!};

        const uclXArray = Array(subgroupLabels.length).fill({{ $spcData['ucl_x'] }});
        const lclXArray = Array(subgroupLabels.length).fill({{ $spcData['lcl_x'] }});
        const meanXArray = Array(subgroupLabels.length).fill({{ $spcData['grand_x_bar'] }});

        const uclRArray = Array(subgroupLabels.length).fill({{ $spcData['ucl_r'] }});
        const lclRArray = Array(subgroupLabels.length).fill({{ $spcData['lcl_r'] }});
        const meanRArray = Array(subgroupLabels.length).fill({{ $spcData['average_r'] }});

        new Chart(document.getElementById('xBarChart'), {
            type: 'line',
            data: {
                labels: subgroupLabels,
                datasets: [
                    { label: 'X-bar', data: xBarData, borderColor: '#0284c7', borderWidth: 2, pointRadius: 3, tension: 0.1 },
                    { label: 'UCL', data: uclXArray, borderColor: '#ef4444', borderDash: [3], borderWidth: 1, pointRadius: 0 },
                    { label: 'LCL', data: lclXArray, borderColor: '#ef4444', borderDash: [3], borderWidth: 1, pointRadius: 0 },
                    { label: 'Mean', data: meanXArray, borderColor: '#10b981', borderWidth: 1, pointRadius: 0 }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { ticks: { font: { size: 8 } }, grid: { color: '#e2e8f0' } }, x: { ticks: { font: { size: 8 } }, grid: { display: false } } } }
        });

        new Chart(document.getElementById('rChart'), {
            type: 'line',
            data: {
                labels: subgroupLabels,
                datasets: [
                    { label: 'R', data: rData, borderColor: '#1e3a8a', borderWidth: 2, pointRadius: 3, tension: 0.1 },
                    { label: 'UCL R', data: uclRArray, borderColor: '#f43f5e', borderDash: [3], borderWidth: 1, pointRadius: 0 },
                    { label: 'LCL R', data: lclRArray, borderColor: '#f43f5e', borderDash: [3], borderWidth: 1, pointRadius: 0 },
                    { label: 'R-bar', data: meanRArray, borderColor: '#64748b', borderWidth: 1, pointRadius: 0 }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { ticks: { font: { size: 8 } }, grid: { color: '#e2e8f0' } }, x: { ticks: { font: { size: 8 } }, grid: { display: false } } } }
        });
    </script>
</body>
</html>