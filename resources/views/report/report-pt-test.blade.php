<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>YSK5-FM-LAB-14 บันทึกผลการทดสอบความชำนาญของเจ้าหน้าที่ห้องปฏิบัติการ (PT TEST)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            @page {
                size: A4 landscape;
                margin: 10mm;
            }
            .no-print { display: none !important; }
            body { 
                font-size: 10px; 
                background-color: white !important; 
                padding: 0 !important; 
                margin: 0 !important; 
            }
            .print-container { 
                border: none !important; 
                box-shadow: none !important; 
                padding: 0 !important; 
                max-width: 100% !important;
                width: 100% !important;
            }
            .table-custom th, .table-custom td { 
                padding: 4px 6px !important; 
                font-size: 9.5px; 
            }
        }
        .table-custom th, .table-custom td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            font-size: 11px;
        }
        .table-custom th { 
            background-color: #f1f5f9; 
        }
    </style>
</head>
<body class="bg-slate-100 p-4">

    <!-- แผงเครื่องมือด้านบน (ซ่อนตอนพิมพ์) -->
    <div class="max-w-[1200px] mx-auto mb-4 p-4 bg-white shadow-sm rounded-lg flex justify-between items-center no-print">
        <div>
            <h1 class="font-bold text-slate-700 text-base">YSK5-FM-LAB-14</h1>
            <p class="text-xs text-slate-500">บันทึกผลการทดสอบความชำนาญของเจ้าหน้าที่ห้องปฏิบัติการ (PT TEST)</p>
        </div>
        <div>         
            <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded-md text-xs hover:bg-blue-700 font-medium flex items-center gap-1.5 shadow-sm transition-colors">
                <i class="fas fa-print"></i> พิมพ์เอกสาร
            </button>
        </div>
    </div>

    <!-- ส่วนฟอร์มรายงาน A4 แนวนอน -->
    <div class="max-w-[1200px] mx-auto bg-white p-6 rounded-lg shadow-md border border-slate-300 print-container"> 
        
        <!-- Header -->
        <div class="flex justify-between items-center border-b border-slate-300 pb-3 mb-4">
            <div class="flex items-center gap-4">
                <img src="{{ URL::asset('assets/images/KK-C.png') }}" class="h-10 object-contain" alt="Logo">
                <div>
                    <h2 class="text-xl font-bold tracking-wide text-slate-800">บันทึกผลการทดสอบความชำนาญของเจ้าหน้าที่ห้องปฏิบัติการ (PT TEST)</h2>
                    <p class="text-xs text-slate-500 mt-0.5">การเปรียบเทียบผลระหว่างพนักงานห้องปฏิบัติการ โดยใช้ค่า $E_n$ และเปรียบเทียบด้วยสมการ $E_n$ Ratio</p>
                </div>
            </div> 
            <div class="text-right">
                <span class="text-xs font-semibold text-slate-600 bg-slate-100 px-2.5 py-1 rounded border border-slate-200">Form: YSK5-FM-LAB-14 | Rev.00</span>
                <p class="text-[10px] text-slate-400 mt-1">มีผลบังคับใช้: 01/08/2569</p>
            </div>
        </div>

        <!-- คำชี้แจงและเงื่อนไข -->
        <div class="mb-4 bg-slate-50 p-3.5 rounded-lg border border-slate-200 text-slate-700 text-xs">
            <p class="font-semibold mb-1 text-slate-800"><i class="fas fa-info-circle text-blue-500 mr-1"></i> เกณฑ์การประเมินผล:</p>
            <ul class="list-disc list-inside space-y-1 ml-1 text-slate-600">
                <li>เมื่อขนาดของสัดส่วน $E_n$ มีค่าน้อยกว่าหรือเท่ากับ 1 หมายความว่าผลการวัดนั้นสอดคล้องกับค่าอ้างอิง (<span class="text-green-600 font-semibold">Pass</span>)</li>
                <li>ถ้าขนาดสัดส่วน $E_n$ มากกว่า 1 แสดงว่าผลการวัดนั้นไม่สอดคล้องกับค่าอ้างอิง (<span class="text-red-600 font-semibold">Fail</span>)</li>
            </ul>
        </div>

        <!-- ตารางคำอธิบายสัญลักษณ์ -->
        <div class="overflow-x-auto">
            <table class="w-full table-custom border-collapse">
                <thead>
                    <tr>
                        <th class="w-1/6 align-middle bg-slate-100 p-2">
                            <img src="{{ URL::asset('assets/images/YSK5-FM-LAB-14.jpg') }}" class="h-10 mx-auto object-contain" alt="Symbol Logo">
                        </th>
                        <th class="text-left font-normal text-slate-700">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 p-1">
                                <div><strong class="text-slate-900">LAB:</strong> ผลการวัดของผู้ที่เข้าร่วมเปรียบเทียบผลการวัด</div>
                                <div><strong class="text-slate-900">REF:</strong> ผลการวัดอ้างอิงที่ใช้ในการเปรียบเทียบผลการวัด</div>
                                <div><strong class="text-slate-900">U<sub>LAB</sub>:</strong> ค่าความไม่แน่นอนของการวัดผลของผู้ที่เข้าร่วมเปรียบเทียบ</div>
                                <div><strong class="text-slate-900">U<sub>REF</sub>:</strong> ค่าความไม่แน่นอนของผลการวัดอ้างอิงที่ใช้ในการเปรียบเทียบ</div>
                            </div>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="overflow-x-auto">
            <h5>Table 1: Reference Standard Data & Uncertainty</h5>
            <table class="w-full table-custom border-collapse">
                <thead>
                    <tr>
                        <th rowspan="2">Set.</th>
                        <th colspan="2">Report Size (µm)</th>
                        <th colspan="2">Size Uncertainty (µm)</th>
                        <th colspan="2">Ref Value (µm)</th>
                    </tr>
                    <tr>
                        <th>L</th>
                        <th>R</th>
                        <th>L</th>
                        <th>R</th>
                        <th>L</th>
                        <th>R</th>
                    </tr>
                </thead>
                <tbody class="text-center">                  
                    <tr>
                        @if ($header->receive_n1_width1 && $header->receive_n1_width2)
                            <td>N1</td>
                            <td>7000</td>
                            <td>7000</td>
                            <td>0.30</td>
                            <td>0.30</td>
                            <td>7000</td>
                            <td>7000</td>
                        @endif                       
                    </tr>
                    <tr>
                        @if ($header->receive_n2_width1 && $header->receive_n2_width2)
                            <td>N2</td>
                            <td>7000</td>
                            <td>7000</td>
                            <td>0.30</td>
                            <td>0.30</td>
                            <td>7000</td>
                            <td>7000</td>
                        @endif
                    </tr>
                    <tr>
                        @if ($header->receive_n2_width1 && $header->receive_n2_width2)
                            <td>N3</td>
                            <td>7000</td>
                            <td>7000</td>
                            <td>0.30</td>
                            <td>0.30</td>
                            <td>7000</td>
                            <td>7000</td>
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="overflow-x-auto">
            <h5>Table 2: Lab Size Measurement (Cal Curves)</h5>
            <table class="w-full table-custom border-collapse">
            </table>
        </div>
    </div>
</body>
</html>