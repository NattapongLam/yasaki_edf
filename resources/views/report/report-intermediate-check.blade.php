<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>YSK5-FM-LAB-12 บันทึกค่าการตรวจสอบเครื่องมือระหว่างการใช้งาน (Intermediate Check Form)</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap');
        
        @media print {
            @page {
                size: A4 landscape;
                margin: 4mm; /* ลด Margin หน้ากระดาษเหลือ 4mm เพื่อให้พื้นที่พิมพ์เพิ่มขึ้น */
            }
            .no-print { display: none !important; }
            body { 
                background-color: white !important; 
                padding: 0 !important; 
                margin: 0 !important; 
                -webkit-print-color-adjust: exact; /* บังคับพิมพ์สีพื้นหลัง/ตาราง */
            }
            .container { 
                border: none !important; 
                box-shadow: none !important; 
                padding: 0 !important; 
                width: 100% !important;
                max-width: 100% !important;
            }
        }

        body {
            font-family: 'Sarabun', sans-serif;
            font-size: 9.5px; /* ลดขนาดฟอนต์พื้นฐานลงเล็กน้อย */
            color: #333;
            margin: 0;
            padding: 5px;
            background-color: #f1f5f9;
        }
        .container {
            max-width: 1500px;
            margin: 0 auto;
            background: #fff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .header-table, .info-table, .data-table, .stat-table, .sig-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: middle;
            padding: 2px;
        }
        .info-table {
            margin-top: 4px;
            margin-bottom: 6px;
            border: 1px solid #cbd5e1;
            background-color: #f8fafc;
        }
        .info-table td {
            padding: 3px 6px; /* ลด Padding ในตารางข้อมูล */
            font-size: 9.5px;
            border: 1px solid #e2e8f0;
        }
        .data-table th, .data-table td, 
        .stat-table th, .stat-table td,
        .sig-table td {
            border: 1px solid #cbd5e1;
            padding: 2px 3px; /* กระชับตารางข้อมูลผลทดสอบ */
            font-size: 9px;
            text-align: center;
            vertical-align: middle;
        }
        .data-table th, .stat-table th {
            background-color: #f1f5f9;
            font-weight: 600;
            color: #1e293b;
        }
        input.form-control {
            width: 100%;
            text-align: center;
            background-color: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 3px;
            padding: 2px;
            font-size: 9px;
            outline: none;
            box-sizing: border-box;
            height: 20px; /* ลดความสูงช่องกรอกข้อมูลเล็กน้อย */
        }
        input.form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }
        .section-title {
            font-weight: bold;
            font-size: 10px;
            color: #1e293b;
            margin-top: 6px;
            margin-bottom: 3px;
        }
        .toolbar {
            max-width: 1500px;
            margin: 0 auto 8px auto;
            background: #fff;
            padding: 8px 12px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .btn {
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-success { background-color: #16a34a; }
        .btn-success:hover { background-color: #15803d; }
        .btn-primary { background-color: #2563eb; }
        .btn-primary:hover { background-color: #1d4ed8; }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    @if(session('success'))
        <div style="max-width: 1500px; margin: 0 auto 8px auto; padding: 8px; background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; border-radius: 6px; font-size: 11px;" class="no-print">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="max-width: 1500px; margin: 0 auto 8px auto; padding: 8px; background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; border-radius: 6px; font-size: 11px;" class="no-print">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('report.intermediate-check.store', isset($testId) ? $testId : 1) }}" method="POST" id="checkForm">
        @csrf
        <input type="hidden" name="receive_test_lists_id" value="{{$header->receive_test_lists_id}}">
        <!-- Toolbar (No Print) -->
        <div class="toolbar no-print">
            <div>
                <strong style="color: #334155; font-size: 12px;">YSK5-FM-LAB-12</strong>
                <span style="color: #64748b; font-size: 10px; margin-left: 8px;">บันทึกค่าการตรวจสอบเครื่องมือระหว่างการใช้งาน (Intermediate Check)</span>
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> บันทึกข้อมูล
                </button>
                <button type="button" onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print"></i> พิมพ์เอกสาร
                </button>
            </div>
        </div>

        <div class="container print-container">
            
            <!-- Header -->
            <table class="header-table" style="border-bottom: 2px solid #cbd5e1; padding-bottom: 4px; margin-bottom: 4px;">
                <tr>
                    <td style="width: 20%;">
                        <img src="{{ URL::asset('assets/images/KK-C.png') }}" style="height: 28px; object-fit: contain;" alt="Logo">
                    </td>
                    <td style="width: 60%; text-align: center;">
                        <h2 style="font-size: 12px; font-weight: bold; margin: 0; color: #1e293b;">บันทึกค่าการตรวจสอบเครื่องมือระหว่างการใช้งาน (Intermediate Check)</h2>
                    </td>
                    <td style="width: 20%; text-align: right;">
                        <span style="font-size: 8.5px; font-weight: 600; color: #475569; background-color: #f1f5f9; padding: 2px 5px; border-radius: 4px; border: 1px solid #cbd5e1;">YSK5-FM-LAB-12: Rev.00: 01/08/2569</span>
                    </td>
                </tr>
            </table>

            <!-- Instrument Info Fields -->
            <table class="info-table">
                <tr>
                    <td style="width: 15%; font-weight: bold; color: #334155;">Instrument Name:</td>
                    <td style="width: 35%;"><input type="text" name="instrument_name" class="form-control" value="{{ isset($hd->instrument_name) ? $hd->instrument_name : (isset($cal->calibration_lists_name2) ? $cal->calibration_lists_name2 : '') }}"></td>
                    <td style="width: 15%; font-weight: bold; color: #334155;">Specification:</td>
                    <td style="width: 35%;"><input type="text" name="specification" class="form-control" value="{{ isset($hd->specification) ? $hd->specification : '' }}"></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; color: #334155;">Model:</td>
                    <td><input type="text" name="model" class="form-control" value="{{ isset($hd->model) ? $hd->model : (isset($bom->ms_formule_name) ? $bom->ms_formule_name : '') }}"></td>
                    <td style="font-weight: bold; color: #334155;">Serial Number:</td>
                    <td><input type="text" name="serial_number" class="form-control" value="{{ isset($hd->serial_number) ? $hd->serial_number : (isset($cal->calibration_lists_serialno) ? $cal->calibration_lists_serialno : '') }}"></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; color: #334155;">Cal Date:</td>
                    <td><input type="date" name="cal_date" class="form-control" value="{{ isset($hd->cal_date) ? $hd->cal_date : (isset($cal->calibration_lists_nextdate) ? $cal->calibration_lists_nextdate : '') }}"></td>
                    <td style="font-weight: bold; color: #334155;">Certificate No.:</td>
                    <td><input type="text" name="certificate_no" class="form-control" value="{{ isset($hd->certificate_no) ? $hd->certificate_no : (isset($cal->calibration_lists_reamrk) ? $cal->calibration_lists_reamrk : '') }}"></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; color: #334155;">Refer Doc.:</td>
                    <td><input type="text" name="refer_doc" class="form-control" value="{{ isset($hd->refer_doc) ? $hd->refer_doc : (isset($reqdoc->ar_requestorder_hds_docuno) ? $reqdoc->ar_requestorder_hds_docuno : '') }}"></td>
                    <td style="font-weight: bold; color: #334155;">Test Range Voltage:</td>
                    <td><input type="text" name="test_range_voltage" class="form-control" value="{{ isset($hd->test_range_voltage) ? $hd->test_range_voltage : '' }}"></td>
                </tr>
            </table>

            <!-- Table: Intermediate Check Data (Points: 100, 150, 200, 250, 300, 350) -->
            <table class="data-table">
                <thead>
                    <tr>
                        <th rowspan="3" style="width: 12%;">จุดทดสอบ (Points)</th>
                        <th colspan="6">Before Cal Test Date (Test 1)</th>
                        <th colspan="6">1st Test Date (Test 2)</th>
                    </tr>
                    <tr>
                        <th colspan="2">N1</th>
                        <th colspan="2">N2</th>
                        <th colspan="2">N3</th>
                        <th colspan="2">N1</th>
                        <th colspan="2">N2</th>
                        <th colspan="2">N3</th>
                    </tr>
                    <tr>
                        <th>°C</th><th>%RH</th>
                        <th>°C</th><th>%RH</th>
                        <th>°C</th><th>%RH</th>
                        <th>°C</th><th>%RH</th>
                        <th>°C</th><th>%RH</th>
                        <th>°C</th><th>%RH</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $points = [100, 150, 200, 250, 300, 350]; 
                    @endphp
                    @foreach($points as $index => $point)
                        <tr>
                            <td style="background-color: #f8fafc; font-weight: 600;">
                                {{ $point }}
                                <input type="hidden" name="point[{{ $index }}]" value="{{ $point }}">
                            </td>

                            <td><input type="number" step="any" name="bc_n1_c[{{ $index }}]" class="form-control" value="{{ isset($previousHeader->{'result'.$point.'_n1temp'}) ? $previousHeader->{'result'.$point.'_n1temp'} : '' }}"></td>
                            <td><input type="number" step="any" name="bc_n1_rh[{{ $index }}]" class="form-control" value="{{ isset($previousHeader->{'result'.$point.'_n1moisture'}) ? $previousHeader->{'result'.$point.'_n1moisture'} : '' }}"></td>
                            <td><input type="number" step="any" name="bc_n2_c[{{ $index }}]" class="form-control" value="{{ isset($previousHeader->{'result'.$point.'_n2temp'}) ? $previousHeader->{'result'.$point.'_n2temp'} : '' }}"></td>
                            <td><input type="number" step="any" name="bc_n2_rh[{{ $index }}]" class="form-control" value="{{ isset($previousHeader->{'result'.$point.'_n2moisture'}) ? $previousHeader->{'result'.$point.'_n2moisture'} : '' }}"></td>
                            <td><input type="number" step="any" name="bc_n3_c[{{ $index }}]" class="form-control" value="{{ isset($previousHeader->{'result'.$point.'_n3temp'}) ? $previousHeader->{'result'.$point.'_n3temp'} : '' }}"></td>
                            <td><input type="number" step="any" name="bc_n3_rh[{{ $index }}]" class="form-control" value="{{ isset($previousHeader->{'result'.$point.'_n3moisture'}) ? $previousHeader->{'result'.$point.'_n3moisture'} : '' }}"></td>

                            <td><input type="number" step="any" name="t1_n1_c[{{ $index }}]" class="form-control" value="{{ isset($header->{'result'.$point.'_n1temp'}) ? $header->{'result'.$point.'_n1temp'} : '' }}"></td>
                            <td><input type="number" step="any" name="t1_n1_rh[{{ $index }}]" class="form-control" value="{{ isset($header->{'result'.$point.'_n1moisture'}) ? $header->{'result'.$point.'_n1moisture'} : '' }}"></td>
                            <td><input type="number" step="any" name="t1_n2_c[{{ $index }}]" class="form-control" value="{{ isset($header->{'result'.$point.'_n2temp'}) ? $header->{'result'.$point.'_n2temp'} : '' }}"></td>
                            <td><input type="number" step="any" name="t1_n2_rh[{{ $index }}]" class="form-control" value="{{ isset($header->{'result'.$point.'_n2moisture'}) ? $header->{'result'.$point.'_n2moisture'} : '' }}"></td>
                            <td><input type="number" step="any" name="t1_n3_c[{{ $index }}]" class="form-control" value="{{ isset($header->{'result'.$point.'_n3temp'}) ? $header->{'result'.$point.'_n3temp'} : '' }}"></td>
                            <td><input type="number" step="any" name="t1_n3_rh[{{ $index }}]" class="form-control" value="{{ isset($header->{'result'.$point.'_n3moisture'}) ? $header->{'result'.$point.'_n3moisture'} : '' }}"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Statistical Analysis Section: Temperature (°C) -->
            <div class="section-title">Statistical Analysis & Tests - Temperature (°C)</div>
            <table class="stat-table" style="margin-bottom: 4px;">
                <tr>
                    <th style="width: 25%;">Parameter (°C)</th>
                    <th style="width: 37.5%;">Test 1 (Before Cal)</th>
                    <th style="width: 37.5%;">Test 2 (1st Test Date)</th>
                </tr>
                <tr>
                    <td style="text-align: left; font-weight: 500;">Mean (Ȳ)</td>
                    <td><input type="text" name="stat_c_test1_mean" id="stat_c_test1_mean" class="form-control" value="{{isset($hd->stat_c_test1_mean) ? $hd->stat_c_test1_mean : 0.0000}}" readonly></td>
                    <td><input type="text" name="stat_c_test2_mean" id="stat_c_test2_mean" class="form-control" value="{{isset($hd->stat_c_test2_mean) ? $hd->stat_c_test2_mean : 0.0000}}" readonly></td>
                </tr>
                <tr>
                    <td style="text-align: left; font-weight: 500;">Variances (S²)</td>
                    <td><input type="text" name="stat_c_test1_var" id="stat_c_test1_var" class="form-control" value="{{isset($hd->stat_c_test1_var) ? $hd->stat_c_test1_var : 0.0000}}" readonly></td>
                    <td><input type="text" name="stat_c_test2_var" id="stat_c_test2_var" class="form-control" value="{{isset($hd->stat_c_test2_var) ? $hd->stat_c_test2_var : 0.0000}}" readonly></td>
                </tr>
                <tr>
                    <td style="text-align: left; font-weight: 500;">Observations (N)</td>
                    <td><input type="text" name="stat_c_test1_obs" class="form-control" value="{{ isset($hd->stat_c_test1_obs) ? $hd->stat_c_test1_obs : count($points) }}" readonly></td>
                    <td><input type="text" name="stat_c_test2_obs" class="form-control" value="{{ isset($hd->stat_c_test2_obs) ? $hd->stat_c_test2_obs : count($points) }}" readonly></td>
                </tr>
            </table>

            <!-- Statistical Analysis Section: Relative Humidity (%RH) -->
            <div class="section-title">Statistical Analysis & Tests - Relative Humidity (%RH)</div>
            <table class="stat-table" style="margin-bottom: 4px;">
                <tr>
                    <th style="width: 25%;">Parameter (%RH)</th>
                    <th style="width: 37.5%;">Test 1 (Before Cal)</th>
                    <th style="width: 37.5%;">Test 2 (1st Test Date)</th>
                </tr>
                <tr>
                    <td style="text-align: left; font-weight: 500;">Mean (Ȳ)</td>
                    <td><input type="text" name="stat_rh_test1_mean" id="stat_rh_test1_mean" class="form-control" value="{{isset($hd->stat_rh_test1_mean) ? $hd->stat_rh_test1_mean : 0.0000}}" readonly></td>
                    <td><input type="text" name="stat_rh_test2_mean" id="stat_rh_test2_mean" class="form-control" value="{{isset($hd->stat_rh_test2_mean) ? $hd->stat_rh_test2_mean : 0.0000}}" readonly></td>
                </tr>
                <tr>
                    <td style="text-align: left; font-weight: 500;">Variances (S²)</td>
                    <td><input type="text" name="stat_rh_test1_var" id="stat_rh_test1_var" class="form-control" value="{{isset($hd->stat_rh_test1_var) ? $hd->stat_rh_test1_var : 0.0000}}" readonly></td>
                    <td><input type="text" name="stat_rh_test2_var" id="stat_rh_test2_var" class="form-control" value="{{isset($hd->stat_rh_test2_var) ? $hd->stat_rh_test2_var : 0.0000}}" readonly></td>
                </tr>
                <tr>
                    <td style="text-align: left; font-weight: 500;">Observations (N)</td>
                    <td><input type="text" name="stat_rh_test1_obs" class="form-control" value="{{ isset($hd->stat_rh_test1_obs) ? $hd->stat_rh_test1_obs : count($points) }}" readonly></td>
                    <td><input type="text" name="stat_rh_test2_obs" class="form-control" value="{{ isset($hd->stat_rh_test2_obs) ? $hd->stat_rh_test2_obs : count($points) }}" readonly></td>
                </tr>
            </table>

            <!-- Result & Signatures -->
            <table class="sig-table">
                <tr>
                    <td colspan="4" style="text-align: left; font-weight: bold; background-color: #f8fafc; padding: 4px 6px;">
                        สรุปผลการประเมินสถิติ (F-Test / t-Test): 
                        <input type="text" name="summary_result" id="summary_result" class="form-control" style="display: inline-block; width: 65%; margin-left: 10px;" value="{{ isset($hd->summary_result) ? $hd->summary_result : '' }}">
                    </td>
                </tr>
                <tr>
                    <td style="width: 15%; font-weight: bold; padding: 3px;">จัดทำโดย:</td>
                    <td style="width: 35%; padding: 3px;"><input type="text" name="creator" class="form-control" value="{{ isset($hd->creator) ? $hd->creator : (Auth::check() ? Auth::user()->name : '') }}"></td>
                    <td style="width: 15%; font-weight: bold; padding: 3px;">วันที่:</td>
                    <td style="width: 35%; padding: 3px;"><input type="date" name="created_date" class="form-control" value="{{ isset($hd->created_date) ? $hd->created_date : date('Y-m-d') }}"></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 3px;">ตรวจสอบและรับรองโดย:</td>
                    <td style="padding: 3px;"><input type="text" name="approver" class="form-control" value="{{ isset($hd->approver) ? $hd->approver : '' }}"></td>
                    <td style="font-weight: bold; padding: 3px;">วันที่:</td>
                    <td style="padding: 3px;"><input type="date" name="approved_date" class="form-control" value="{{ isset($hd->approved_date) ? $hd->approved_date : '' }}"></td>
                </tr>
            </table>

        </div>
    </form>

    <!-- Script สำหรับคำนวณค่าทางสถิติแยก °C และ %RH อัตโนมัติ -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const inputs = document.querySelectorAll("#checkForm input");
            const points = [100, 150, 200, 250, 300, 350];

            inputs.forEach(input => {
                input.addEventListener("input", calculateStatistics);
            });

            function calculateStatistics() {
                let N = points.length;
                
                let c_y1 = [], c_y2 = [];
                let rh_y1 = [], rh_y2 = [];

                for (let i = 0; i < N; i++) {
                    let bc_c1 = parseFloat(document.querySelector(`[name="bc_n1_c[${i}]"]`).value) || 0;
                    let bc_c2 = parseFloat(document.querySelector(`[name="bc_n2_c[${i}]"]`).value) || 0;
                    let bc_c3 = parseFloat(document.querySelector(`[name="bc_n3_c[${i}]"]`).value) || 0;

                    let t1_c1 = parseFloat(document.querySelector(`[name="t1_n1_c[${i}]"]`).value) || 0;
                    let t1_c2 = parseFloat(document.querySelector(`[name="t1_n2_c[${i}]"]`).value) || 0;
                    let t1_c3 = parseFloat(document.querySelector(`[name="t1_n3_c[${i}]"]`).value) || 0;

                    c_y1[i] = (bc_c1 + bc_c2 + bc_c3) / 3;
                    c_y2[i] = (t1_c1 + t1_c2 + t1_c3) / 3;

                    let bc_rh1 = parseFloat(document.querySelector(`[name="bc_n1_rh[${i}]"]`).value) || 0;
                    let bc_rh2 = parseFloat(document.querySelector(`[name="bc_n2_rh[${i}]"]`).value) || 0;
                    let bc_rh3 = parseFloat(document.querySelector(`[name="bc_n3_rh[${i}]"]`).value) || 0;

                    let t1_rh1 = parseFloat(document.querySelector(`[name="t1_n1_rh[${i}]"]`).value) || 0;
                    let t1_rh2 = parseFloat(document.querySelector(`[name="t1_n2_rh[${i}]"]`).value) || 0;
                    let t1_rh3 = parseFloat(document.querySelector(`[name="t1_n3_rh[${i}]"]`).value) || 0;

                    rh_y1[i] = (bc_rh1 + bc_rh2 + bc_rh3) / 3;
                    rh_y2[i] = (t1_rh1 + t1_rh2 + t1_rh3) / 3;
                }

                // Temperature (°C) Calculation
                let c_mean1 = c_y1.reduce((a, b) => a + b, 0) / N;
                let c_mean2 = c_y2.reduce((a, b) => a + b, 0) / N;
                let c_var1 = N > 1 ? c_y1.reduce((sum, val) => sum + Math.pow(val - c_mean1, 2), 0) / (N - 1) : 0;
                let c_var2 = N > 1 ? c_y2.reduce((sum, val) => sum + Math.pow(val - c_mean2, 2), 0) / (N - 1) : 0;

                document.getElementById("stat_c_test1_mean").value = c_mean1.toFixed(4);
                document.getElementById("stat_c_test2_mean").value = c_mean2.toFixed(4);
                document.getElementById("stat_c_test1_var").value = c_var1.toFixed(4);
                document.getElementById("stat_c_test2_var").value = c_var2.toFixed(4);

                // Relative Humidity (%RH) Calculation
                let rh_mean1 = rh_y1.reduce((a, b) => a + b, 0) / N;
                let rh_mean2 = rh_y2.reduce((a, b) => a + b, 0) / N;
                let rh_var1 = N > 1 ? rh_y1.reduce((sum, val) => sum + Math.pow(val - rh_mean1, 2), 0) / (N - 1) : 0;
                let rh_var2 = N > 1 ? rh_y2.reduce((sum, val) => sum + Math.pow(val - rh_mean2, 2), 0) / (N - 1) : 0;

                document.getElementById("stat_rh_test1_mean").value = rh_mean1.toFixed(4);
                document.getElementById("stat_rh_test2_mean").value = rh_mean2.toFixed(4);
                document.getElementById("stat_rh_test1_var").value = rh_var1.toFixed(4);
                document.getElementById("stat_rh_test2_var").value = rh_var2.toFixed(4);

                let f_stat = c_var1 >= c_var2 ? (c_var2 === 0 ? 0 : c_var1 / c_var2) : (c_var1 === 0 ? 0 : c_var2 / c_var1);
                let f_critical = 5.0503; 
                let evaluation = f_stat <= f_critical ? "Pass (ความแปรปรวนเสถียรทั้ง °C และ %RH)" : "Fail (ความแปรปรวนเปลี่ยนไป)";
                
                document.getElementById("summary_result").value = evaluation;
            }

            calculateStatistics();
        });
    </script>

</body>
</html>