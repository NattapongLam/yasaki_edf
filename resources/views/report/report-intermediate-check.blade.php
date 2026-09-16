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
                margin: 5mm; /* ตั้งระยะขอบกระดาษพอดีสำหรับการพิมพ์ A4 แนวนอน */
            }
            .no-print { 
                display: none !important; 
            }
            body { 
                background-color: #ffffff !important; 
                padding: 0 !important; 
                margin: 0 !important; 
                -webkit-print-color-adjust: exact !important; 
                print-color-adjust: exact !important; 
            }
            .container { 
                border: none !important; 
                box-shadow: none !important; 
                padding: 2px !important; 
                width: 100% !important;
                max-width: 100% !important;
                background-color: #ffffff !important;
            }
            /* คงสีพื้นหลังตารางและช่องกรอกตอนพิมพ์ */
            .data-table th, .stat-table th, .info-table td.label, td[style*="background-color"] {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            input.form-control, select.form-control, textarea.form-control {
                border: 1px solid #94a3b8 !important;
                background-color: #ffffff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }

        body {
            font-family: 'Sarabun', sans-serif;
            font-size: 10px;
            color: #334155;
            margin: 0;
            padding: 10px;
            background-color: #f8fafc;
        }

        .container {
            max-width: 1500px;
            margin: 0 auto;
            background: #ffffff;
            padding: 16px;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .header-table, .info-table, .data-table, .stat-table, .sig-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: middle;
            padding: 4px;
        }

        .info-table {
            margin-top: 6px;
            margin-bottom: 8px;
            border-radius: 6px;
            overflow: hidden;
            border: 1px solid #cbd5e1;
        }
        .info-table td {
            padding: 4px 6px;
            font-size: 9.5px;
            border: 1px solid #cbd5e1;
            background-color: #ffffff;
        }
        .info-table td.label {
            background-color: #f1f5f9;
            font-weight: 600;
            color: #334155;
            width: 15%;
        }

        .data-table th, .data-table td, 
        .stat-table th, .stat-table td,
        .sig-table td {
            border: 1px solid #cbd5e1;
            padding: 3px 4px;
            font-size: 9px;
            text-align: center;
            vertical-align: middle;
        }

        .data-table th, .stat-table th {
            background-color: #f1f5f9;
            font-weight: 600;
            color: #1e293b;
        }

        input.form-control, select.form-control, textarea.form-control {
            width: 100%;
            text-align: center;
            background-color: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 2px 4px;
            font-size: 9px;
            font-family: 'Sarabun', sans-serif;
            color: #1e293b;
            outline: none;
            box-sizing: border-box;
            height: 22px;
        }

        select.form-control {
            text-align-last: center;
        }

        textarea.form-control {
            height: auto;
            min-height: 26px;
            resize: vertical;
            text-align: left;
        }

        input.form-control:focus, select.form-control:focus, textarea.form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .section-title {
            font-weight: 700;
            font-size: 10px;
            color: #1e293b;
            margin-top: 8px;
            margin-bottom: 3px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .section-title::before {
            content: '';
            display: inline-block;
            width: 3px;
            height: 10px;
            background-color: #2563eb;
            border-radius: 2px;
        }

        .toolbar {
            max-width: 1500px;
            margin: 0 auto 10px auto;
            background: #ffffff;
            padding: 10px 16px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .btn {
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background-color 0.2s;
        }
        .btn-success { background-color: #16a34a; }
        .btn-success:hover { background-color: #15803d; }
        .btn-primary { background-color: #2563eb; }
        .btn-primary:hover { background-color: #1d4ed8; }

        .alert {
            max-width: 1500px; 
            margin: 0 auto 10px auto; 
            padding: 10px 14px; 
            border-radius: 8px; 
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    @if(session('success'))
        <div class="alert alert-success no-print">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger no-print">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('report.intermediate-check.store', isset($testId) ? $testId : 1) }}" method="POST" id="checkForm">
        @csrf
        <input type="hidden" name="receive_test_lists_id" value="{{$header->receive_test_lists_id}}">
        
        <!-- Toolbar (No Print) -->
        <div class="toolbar no-print">
            <div>
                <strong style="color: #1e293b; font-size: 13px;"><i class="fas fa-file-alt text-blue-600"></i> YSK5-FM-LAB-12</strong>
                <span style="color: #64748b; font-size: 11px; margin-left: 8px;">บันทึกค่าการตรวจสอบเครื่องมือระหว่างการใช้งาน (Intermediate Check)</span>
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
            <table class="header-table" style="border-bottom: 2px solid #e2e8f0; padding-bottom: 6px; margin-bottom: 6px;">
                <tr>
                    <td style="width: 20%;">
                        <img src="{{ URL::asset('assets/images/KK-C.png') }}" style="height: 32px; object-fit: contain;" alt="Logo">
                    </td>
                    <td style="width: 60%; text-align: center;">
                        <h2 style="font-size: 13px; font-weight: 700; margin: 0; color: #1e293b;">บันทึกค่าการตรวจสอบเครื่องมือระหว่างการใช้งาน (Intermediate Check)</h2>
                    </td>
                    <td style="width: 20%; text-align: right;">
                        <span style="font-size: 9px; font-weight: 600; color: #475569; background-color: #f1f5f9; padding: 3px 6px; border-radius: 4px; border: 1px solid #cbd5e1;">YSK5-FM-LAB-12: Rev.00: 01/08/2569</span>
                    </td>
                </tr>
            </table>

            <!-- Instrument Info Fields -->
            <table class="info-table">
                <tr>
                    <td class="label">Instrument Name:</td>
                    <td><input type="text" name="instrument_name" class="form-control" value="{{ isset($hd->instrument_name) ? $hd->instrument_name : (isset($cal->calibration_lists_name2) ? $cal->calibration_lists_name2 : '') }}"></td>
                    <td class="label">Specification:</td>
                    <td><input type="text" name="specification" class="form-control" value="{{ isset($hd->specification) ? $hd->specification : '' }}"></td>
                </tr>
                <tr>
                    <td class="label">Model:</td>
                    <td><input type="text" name="model" class="form-control" value="{{ isset($hd->model) ? $hd->model : (isset($bom->ms_formule_name) ? $bom->ms_formule_name : '') }}"></td>
                    <td class="label">Serial Number:</td>
                    <td><input type="text" name="serial_number" class="form-control" value="{{ isset($hd->serial_number) ? $hd->serial_number : (isset($cal->calibration_lists_serialno) ? $cal->calibration_lists_serialno : '') }}"></td>
                </tr>
                <tr>
                    <td class="label">Cal Date:</td>
                    <td><input type="date" name="cal_date" class="form-control" value="{{ isset($hd->cal_date) ? $hd->cal_date : (isset($cal->calibration_lists_nextdate) ? $cal->calibration_lists_nextdate : '') }}"></td>
                    <td class="label">Certificate No.:</td>
                    <td><input type="text" name="certificate_no" class="form-control" value="{{ isset($hd->certificate_no) ? $hd->certificate_no : (isset($cal->calibration_lists_reamrk) ? $cal->calibration_lists_reamrk : '') }}"></td>
                </tr>
                <tr>
                    <td class="label">Refer Doc.:</td>
                    <td><input type="text" name="refer_doc" class="form-control" value="{{ isset($hd->refer_doc) ? $hd->refer_doc : (isset($reqdoc->ar_requestorder_hds_docuno) ? $reqdoc->ar_requestorder_hds_docuno : '') }}"></td>
                    <td class="label">Test Range Voltage:</td>
                    <td><input type="text" name="test_range_voltage" class="form-control" value="{{ isset($hd->test_range_voltage) ? $hd->test_range_voltage : '' }}"></td>
                </tr>
                <tr>
                    <td class="label">Test Status:</td>
                    <td>
                        <select class="form-control" name="test_status">
                            <option value="Normal" {{ (isset($hd->test_status) && $hd->test_status == 'Normal') ? 'selected' : '' }}>Normal (ปกติสมบูรณ์)</option>
                            <option value="Interrupted" {{ (isset($hd->test_status) && $hd->test_status == 'Interrupted') ? 'selected' : '' }}>Interrupted (หยุดชั่วคราวแล้วทดสอบต่อ)</option>
                            <option value="Aborted" {{ (isset($hd->test_status) && $hd->test_status == 'Aborted') ? 'selected' : '' }}>Aborted (ยกเลิกกลางคัน/ต้องทดสอบใหม่)</option>
                        </select>
                    </td>
                    <td class="label">Incident Point:</td>
                    <td><input type="text" name="incident_point" class="form-control" value="{{ isset($hd->incident_point) ? $hd->incident_point : '' }}"></td>
                </tr>
                <tr>
                    <td class="label">Problem Category:</td>
                    <td>
                        <select class="form-control" name="problem_category">
                            <option value="-" {{ (isset($hd->problem_category) && $hd->problem_category == '-') ? 'selected' : '' }}>-</option>
                            <option value="Equipment Drift" {{ (isset($hd->problem_category) && $hd->problem_category == 'Equipment Drift') ? 'selected' : '' }}>Equipment Drift (เซ็นเซอร์/เครื่องมือวัดดริฟต์)</option>
                            <option value="Environment Out" {{ (isset($hd->problem_category) && $hd->problem_category == 'Environment Out') ? 'selected' : '' }}>Environment Out (อุณหภูมิ/ความชื้นห้องแล็บหลุดเกณฑ์)</option>
                            <option value="Power/System Failure" {{ (isset($hd->problem_category) && $hd->problem_category == 'Power/System Failure') ? 'selected' : '' }}>Power/System Failure (ไฟตก/ระบบขัดข้อง)</option>
                            <option value="Mechanical Issue" {{ (isset($hd->problem_category) && $hd->problem_category == 'Mechanical Issue') ? 'selected' : '' }}>Mechanical Issue (เสียงรบกวน/สั่นสะเทือน/รอยรั่ว)</option>
                            <option value="Operator Error" {{ (isset($hd->problem_category) && $hd->problem_category == 'Operator Error') ? 'selected' : '' }}>Operator Error (ข้อผิดพลาดจากการคีย์/เตรียมตัวอย่าง)</option>
                        </select>
                    </td>
                    <td class="label">Data Validity:</td>
                    <td>
                        <select class="form-control" name="data_validity">
                            <option value="Valid" {{ (isset($hd->data_validity) && $hd->data_validity == 'Valid') ? 'selected' : '' }}>Valid (ผลการวัดยังคงน่าเชื่อถือ/ใช้งานได้)</option>
                            <option value="Invalid" {{ (isset($hd->data_validity) && $hd->data_validity == 'Invalid') ? 'selected' : '' }}>Invalid (ผลการวัดใช้ไม่ได้ ต้องทำ Intermediate Check ใหม่)</option>
                        </select>
                    </td>
                </tr>
            </table>

            <!-- Table: Intermediate Check Data -->
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
            <div class="section-title">Statistical Analysis & Tests - Temperature (25 - 31 °C)</div>
            <table class="stat-table" style="margin-bottom: 6px;">
                <tr>
                    <th style="width: 25%;">Parameter (°C)</th>
                    <th style="width: 37.5%;">Test 1 (Before Cal)</th>
                    <th style="width: 37.5%;">Test 2 (1st Test Date)</th>
                </tr>
                <tr>
                    <td style="text-align: left; font-weight: 500; padding-left: 8px;">Mean (Ȳ)</td>
                    <td><input type="text" name="stat_c_test1_mean" id="stat_c_test1_mean" class="form-control" value="{{isset($hd->stat_c_test1_mean) ? $hd->stat_c_test1_mean : '0.0000'}}" readonly></td>
                    <td><input type="text" name="stat_c_test2_mean" id="stat_c_test2_mean" class="form-control" value="{{isset($hd->stat_c_test2_mean) ? $hd->stat_c_test2_mean : '0.0000'}}" readonly></td>
                </tr>
                <tr>
                    <td style="text-align: left; font-weight: 500; padding-left: 8px;">Variances (S²)</td>
                    <td><input type="text" name="stat_c_test1_var" id="stat_c_test1_var" class="form-control" value="{{isset($hd->stat_c_test1_var) ? $hd->stat_c_test1_var : '0.0000'}}" readonly></td>
                    <td><input type="text" name="stat_c_test2_var" id="stat_c_test2_var" class="form-control" value="{{isset($hd->stat_c_test2_var) ? $hd->stat_c_test2_var : '0.0000'}}" readonly></td>
                </tr>
                <tr>
                    <td style="text-align: left; font-weight: 500; padding-left: 8px;">Observations (N)</td>
                    <td><input type="text" name="stat_c_test1_obs" class="form-control" value="{{ isset($hd->stat_c_test1_obs) ? $hd->stat_c_test1_obs : count($points) }}" readonly></td>
                    <td><input type="text" name="stat_c_test2_obs" class="form-control" value="{{ isset($hd->stat_c_test2_obs) ? $hd->stat_c_test2_obs : count($points) }}" readonly></td>
                </tr>
            </table>

            <!-- Statistical Analysis Section: Relative Humidity (%RH) -->
            <div class="section-title">Statistical Analysis & Tests - Relative Humidity (40 - 60 %RH)</div>
            <table class="stat-table" style="margin-bottom: 6px;">
                <tr>
                    <th style="width: 25%;">Parameter (%RH)</th>
                    <th style="width: 37.5%;">Test 1 (Before Cal)</th>
                    <th style="width: 37.5%;">Test 2 (1st Test Date)</th>
                </tr>
                <tr>
                    <td style="text-align: left; font-weight: 500; padding-left: 8px;">Mean (Ȳ)</td>
                    <td><input type="text" name="stat_rh_test1_mean" id="stat_rh_test1_mean" class="form-control" value="{{isset($hd->stat_rh_test1_mean) ? $hd->stat_rh_test1_mean : '0.0000'}}" readonly></td>
                    <td><input type="text" name="stat_rh_test2_mean" id="stat_rh_test2_mean" class="form-control" value="{{isset($hd->stat_rh_test2_mean) ? $hd->stat_rh_test2_mean : '0.0000'}}" readonly></td>
                </tr>
                <tr>
                    <td style="text-align: left; font-weight: 500; padding-left: 8px;">Variances (S²)</td>
                    <td><input type="text" name="stat_rh_test1_var" id="stat_rh_test1_var" class="form-control" value="{{isset($hd->stat_rh_test1_var) ? $hd->stat_rh_test1_var : '0.0000'}}" readonly></td>
                    <td><input type="text" name="stat_rh_test2_var" id="stat_rh_test2_var" class="form-control" value="{{isset($hd->stat_rh_test2_var) ? $hd->stat_rh_test2_var : '0.0000'}}" readonly></td>
                </tr>
                <tr>
                    <td style="text-align: left; font-weight: 500; padding-left: 8px;">Observations (N)</td>
                    <td><input type="text" name="stat_rh_test1_obs" class="form-control" value="{{ isset($hd->stat_rh_test1_obs) ? $hd->stat_rh_test1_obs : count($points) }}" readonly></td>
                    <td><input type="text" name="stat_rh_test2_obs" class="form-control" value="{{ isset($hd->stat_rh_test2_obs) ? $hd->stat_rh_test2_obs : count($points) }}" readonly></td>
                </tr>
            </table>

            <!-- Result & Signatures -->
            <table class="sig-table">
                <tr>
                    <td colspan="3" style="text-align: left; font-weight: 600; background-color: #f8fafc; padding: 6px 8px;">
                        สรุปผลการประเมินสถิติ (F-Test / t-Test): 
                        <input type="text" name="summary_result" id="summary_result" class="form-control" style="display: inline-block; width: 62%; margin-left: 10px;" value="{{ isset($hd->summary_result) ? $hd->summary_result : '' }}">
                    </td>
                    <td style="background-color: #f8fafc; padding: 6px 8px; font-weight: 600;">
                        เลขที่ใบ CAR/NCR:
                        <input type="text" name="result_doc" id="result_doc" class="form-control" style="display: inline-block; width: 55%; margin-left: 6px;" value="{{ isset($hd->result_doc) ? $hd->result_doc : '' }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: left; font-weight: 600; background-color: #f8fafc; padding: 6px 8px;">
                        รายละเอียดปัญหา (Problem Description): 
                        <textarea name="problem_description" id="problem_description" class="form-control" style="display: inline-block; width: 72%; margin-left: 10px; vertical-align: middle;">{{ isset($hd->problem_description) ? trim($hd->problem_description) : '' }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: left; font-weight: 600; background-color: #f8fafc; padding: 6px 8px;">
                        การแก้ไขเบื้องต้น (Action Taken): 
                        <textarea name="action_taken" id="action_taken" class="form-control" style="display: inline-block; width: 72%; margin-left: 10px; vertical-align: middle;">{{ isset($hd->action_taken) ? trim($hd->action_taken) : '' }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td style="width: 15%; font-weight: 600; padding: 5px;">จัดทำโดย:</td>
                    <td style="width: 35%; padding: 5px;"><input type="text" name="creator" class="form-control" value="{{ isset($hd->creator) ? $hd->creator : (Auth::check() ? Auth::user()->name : '') }}"></td>
                    <td style="width: 15%; font-weight: 600; padding: 5px;">วันที่:</td>
                    <td style="width: 35%; padding: 5px;"><input type="date" name="created_date" class="form-control" value="{{ isset($hd->created_date) ? $hd->created_date : date('Y-m-d') }}"></td>
                </tr>
                <tr>
                    <td style="font-weight: 600; padding: 5px;">ตรวจสอบและรับรองโดย:</td>
                    <td style="padding: 5px;"><input type="text" name="approver" class="form-control" value="{{ isset($hd->approver) ? $hd->approver : '' }}"></td>
                    <td style="font-weight: 600; padding: 5px;">วันที่:</td>
                    <td style="padding: 5px;"><input type="date" name="approved_date" class="form-control" value="{{ isset($hd->approved_date) ? $hd->approved_date : '' }}"></td>
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