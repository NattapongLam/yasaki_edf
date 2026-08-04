<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานผลการทดสอบและส่งมอบ - {{ $header->delivered_test_hds_docuno ?? '' }}</title>
    <!-- เรียกใช้งาน Bootstrap CSS และ Google Fonts (Sarabun) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #525659;
            font-family: 'Sarabun', sans-serif;
            color: #000;
        }
        .print-container {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm 20mm;
            margin: 10mm auto;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .table th, .table td {
            vertical-align: middle;
            padding: 6px 10px;
            font-size: 0.9rem;
        }
        .iso-header {
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .signature-section {
            margin-top: 20px;
        }
        @media print {
            body {
                background: none;
            }
            .no-print {
                display: none !important;
            }
            .print-container {
                width: 100%;
                min-height: 100vh;
                padding: 10mm;
                margin: 0;
                box-shadow: none;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="print-container">
        <div>
            <!-- ส่วนหัวเอกสารตามมาตรฐาน ISO/IEC 17025 -->
            <div class="iso-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-0">LABORATORY TEST & DELIVERY REPORT</h5>
                    <p class="text-muted small mb-0">อ้างอิงมาตรฐาน: ISO/IEC 17025 และ JIS D 4411</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-dark">Doc No: {{ $header->delivered_test_hds_docuno ?? '-' }}</span><br>
                    <small class="text-muted">Rev. 01</small>
                </div>
            </div>

            <div class="text-center mb-3">
                <h4 class="fw-bold mb-1">ใบรายงานผลการทดสอบและส่งมอบชิ้นส่วนเบรก</h4>
                <p class="text-muted mb-0 small">ประเภทการทดสอบ: <strong>{{$header->delivered_test_hds_type ?? 'JIS D 4411 Brake Lining/Pad Test'}}</strong></p>
            </div>

            <!-- ข้อมูลรายละเอียดหัวเอกสาร (Metadata) -->
            <div class="row mb-3 border p-2 rounded bg-light small">
                <div class="col-6">
                    <p class="mb-1"><strong>วันที่ออกรายงาน:</strong> {{ $header->delivered_test_hds_date ?? '-' }}</p>
                    <p class="mb-0"><strong>นามลูกค้า/หน่วยงาน:</strong> {{ $header->delivered_test_hds_customer ?? '-' }}</p>
                </div>
                <div class="col-6 text-end">
                    <p class="mb-1"><strong>เลขอ้างอิงคำร้อง (Order Ref):</strong> {{ $header->ar_requestorder_hds_docuno ?? '-' }}</p>
                    <p class="mb-0"><strong>ผู้ทดสอบ/ผู้ติดต่อ:</strong> {{ $header->delivered_test_hds_contact ?? '-' }}</p>
                </div>
            </div>

            <!-- ตารางแสดงรายการทดสอบตามหลัก JIS D 4411 -->
            <div class="mb-2">
                <span class="fw-bold small text-secondary">ผลการตรวจสอบและทดสอบคุณสมบัติ (Test Results per JIS D 4411):</span>
            </div>
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 8%">#</th>
                        <th style="width: 37%" class="text-start ps-2">รายการชิ้นส่วน / รหัสสินค้า (Part Name/Description)</th>
                        <th style="width: 15%">จำนวน (Qty)</th>
                        <th style="width: 20%">สภาพภายนอกตาม JIS D 4411<br><small>(รอยร้าว/ฟองอากาศ)</small></th>
                        <th style="width: 20%">ผลการประเมิน<br><small>(Pass/Fail)</small></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dt as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="text-start ps-2">
                                {{ $item->delivered_test_dts_remark ?? '-' }}
                            </td>
                            <td>{{ $item->delivered_test_dts_qty ?? 0 }}</td>
                            <td><span class="text-dark">{{ $item->delivered_test_dts_type ?? '-' }}</span></td>
                            <td><strong>{{ $item->delivered_test_dts_status ?? '-' }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- ข้อมูลเงื่อนไขสิ่งแวดล้อมและมาตรฐานการทดสอบ (ISO/IEC 17025 Requirement) -->
            <div class="row mb-3 small">
                <div class="col-12">
                    <div class="p-2 border rounded bg-white text-muted">
                        <strong>เงื่อนไขห้องปฏิบัติการ (Environmental Conditions):</strong> อุณหภูมิ 23±2°C, ความชื้นสัมพัทธ์ 50±5% RH<br>
                        <strong>เกณฑ์การตัดสิน (Criteria):</strong> พื้นผิวหน้าสัมผัสต้องไม่มีรอยแตกร้าว (Cracks) ฟองอากาศ (Blisters) หรือความบิดเบี้ยวที่เป็นอันตรายตามข้อกำหนด JIS D 4411
                    </div>
                </div>
            </div>

            <!-- ส่วนหมายเหตุ -->
            @if(!empty($header->delivered_test_hds_remark))
                <div class="row mb-2 small">
                    <div class="col-12">
                        <div class="p-2 border rounded bg-white">
                            <strong>หมายเหตุเพิ่มเติม (Remarks):</strong> {{ $header->delivered_test_hds_remark }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div>
            <!-- ส่วนลงนามตามระบบคุณภาพ ISO 17025 (ผู้ทดสอบ, ผู้ออกรายงาน, ผู้รับมอบ) -->
            <div class="signature-section">
                <div class="row text-center small">
                    <div class="col-4">
                        <div class="p-1 border rounded">
                            <p class="mb-4">ลงชื่อ..................................................<br><strong>(ผู้ทำการทดสอบ / Tester)</strong><br>
                            วันที่ ......./......./.......</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-1 border rounded">
                            <p class="mb-4">ลงชื่อ..................................................<br><strong>(ผู้ตรวจสอบรับรอง / Approver)</strong><br>
                            วันที่ ......./......./.......</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-1 border rounded">
                            <p class="mb-4">ลงชื่อ..................................................<br><strong>(ผู้รับมอบตัวอย่าง / Receiver)</strong><br>
                            วันที่ ......./......./.......</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ปุ่มควบคุมการพิมพ์ -->
            <div class="text-center mt-3 no-print">
                <button onclick="window.print()" class="btn btn-primary btn-sm px-4">พิมพ์เอกสารอีกครั้ง</button>
                <button onclick="window.close()" class="btn btn-secondary btn-sm px-4">ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>

</body>
</html>