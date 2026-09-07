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
        @page {
            size: A4;
            margin: 8mm 12mm;
        }
        body {
            background-color: #525659;
            font-family: 'Sarabun', sans-serif;
            font-size: 13.5pt;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .print-container {
            width: 210mm;
            min-height: 297mm;
            padding: 10mm 15mm;
            margin: 10mm auto;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .table th, .table td {
            vertical-align: middle;
            padding: 5px 8px;
            font-size: 13pt;
        }
        .iso-header {
            border-bottom: 2px solid #222;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }
        .meta-box {
            background-color: #f9f9f9 !important;
            border: 1px solid #ddd !important;
            border-radius: 4px;
            padding: 8px 12px;
        }
        .info-p {
            margin-bottom: 3px;
        }
        .footer-note {
            background-color: #fcfcfc !important;
            border: 1px solid #e0e0e0 !important;
            font-size: 11.5pt;
            line-height: 1.25;
            padding: 6px 10px;
            border-radius: 4px;
        }
        .signature-box {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px 4px;
            background-color: #fff;
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
                padding: 0;
                margin: 0;
                box-shadow: none;
            }
            .meta-box, .footer-note, .signature-box {
                background-color: #fff !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="print-container">
        <div>
            <!-- ส่วนหัวเอกสารตามมาตรฐาน ISO/IEC 17025 -->
            <div class="iso-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="{{ URL::asset('assets/images/KK-C.png') }}" height="45" class="me-3">
                    <div>
                        <b style="font-size: 15pt;">KK&C PARTS CO., LTD.</b>
                        <p class="text-muted mb-0" style="font-size: 10pt;">588/35 M Floor, Sathu Pradit Rd., Bangkok</p>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge bg-dark" style="font-size: 10pt;">Doc No: {{ $header->delivered_test_hds_docuno ?? '-' }}</span><br>
                    <small class="text-muted" style="font-size: 9.5pt;">YSK5-FM-LAB-18 Rev.00 : 01/08/2569</small>
                </div>
            </div>

            <div class="text-center mb-2">
                <h4 class="fw-bold mb-1" style="font-size: 17pt;">ใบรายงานผลการทดสอบและส่งมอบชิ้นส่วนเบรก</h4>
                <p class="text-muted mb-0" style="font-size: 12pt;">ประเภทการทดสอบ: <strong>{{ $header->delivered_test_hds_type ?? 'JIS D 4411 Brake Lining/Pad Test' }}</strong></p>
            </div>

            <!-- ข้อมูลรายละเอียดหัวเอกสาร (Metadata) -->
            <div class="row mb-2 meta-box small">
                <div class="col-6">
                    <p class="info-p"><strong>วันที่ออกรายงาน:</strong> {{ $header->delivered_test_hds_date ?? '-' }}</p>
                    <p class="info-p"><strong>นามลูกค้า/หน่วยงาน:</strong> {{ $header->delivered_test_hds_customer ?? '-' }}</p>
                    <p class="info-p mb-0"><strong>ช่องทางการส่งมอบ:</strong> {{ $header->delivered_test_hds_channel ?? '-' }}</p>
                </div>
                <div class="col-6 text-end">
                    <p class="info-p"><strong>เลขอ้างอิงคำร้อง:</strong> {{ $header->ar_requestorder_hds_docuno ?? '-' }}</p>
                    <p class="info-p"><strong>ผู้ติดต่อ:</strong> {{ $header->delivered_test_hds_contact ?? '-' }} ({{ $header->contact_channels ?? '-' }})</p>
                    <p class="info-p mb-0"><strong>ที่อยู่จัดส่ง:</strong> {{ $header->shipping_address ?? '-' }}</p>
                </div>
            </div>

            <!-- ตารางแสดงรายการทดสอบตามหลัก JIS D 4411 -->
            <div class="mb-1">
                <span class="fw-bold text-secondary" style="font-size: 12.5pt;">ผลการตรวจสอบและทดสอบคุณสมบัติ (Test Results per JIS D 4411):</span>
            </div>
            <table class="table table-bordered text-center align-middle mb-2">
                <thead class="table-light">
                    <tr>
                        <th style="width: 7%">#</th>
                        <th style="width: 38%" class="text-start ps-3">รายการชิ้นส่วน / รหัสสินค้า (Part Name/Description)</th>
                        <th style="width: 12%">จำนวน</th>
                        <th style="width: 23%">สภาพภายนอกตาม JIS D 4411<br><small style="font-size: 10pt;">(รอยร้าว/ฟองอากาศ)</small></th>
                        <th style="width: 20%">ผลการประเมิน</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dt as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="text-start ps-3">
                                {{ $item->delivered_test_dts_remark ?? '-' }}
                            </td>
                            <td>{{ number_format($item->delivered_test_dts_qty ?? 0) }}</td>
                            <td>{{ $item->delivered_test_dts_type ?? '-' }}</td>
                            <td><strong>{{ $item->delivered_test_dts_status ?? '-' }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- ข้อมูลเงื่อนไขสิ่งแวดล้อมและมาตรฐานการทดสอบ (ISO/IEC 17025 Requirement) -->
            <div class="row mb-2">
                <div class="col-12">
                    <div class="footer-note text-secondary">
                        <strong>เงื่อนไขห้องปฏิบัติการ (Environmental Conditions):</strong> อุณหภูมิ 23±2°C, ความชื้นสัมพัทธ์ 50±5% RH<br>
                        <strong>เกณฑ์การตัดสิน (Criteria):</strong> พื้นผิวหน้าสัมผัสต้องไม่มีรอยแตกร้าว (Cracks) ฟองอากาศ (Blisters) หรือความบิดเบี้ยวที่เป็นอันตรายตามข้อกำหนด JIS D 4411
                    </div>
                </div>
            </div>

            <!-- ส่วนหมายเหตุ -->
            @if(!empty($header->delivered_test_hds_remark))
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="footer-note">
                            <strong>หมายเหตุเพิ่มเติม (Remarks):</strong> {{ $header->delivered_test_hds_remark }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div>
            <!-- ส่วนลงนามตามระบบคุณภาพ ISO 17025 (ผู้ทดสอบ, ผู้ออกรายงาน, ผู้รับมอบ) -->
            <div class="signature-section mb-2">
                <div class="row text-center">
                    <div class="col-4">
                        <div class="signature-box">
                            <p class="mb-4 info-p">ลงชื่อ.........................................<br><strong>(ผู้ทำการทดสอบ)</strong><br>
                            <span style="font-size: 11pt;">วันที่ ......./......./.......</span></p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="signature-box">
                            <p class="mb-4 info-p">ลงชื่อ.........................................<br><strong>(ผู้ตรวจสอบรับรอง)</strong><br>
                            <span style="font-size: 11pt;">วันที่ ......./......./.......</span></p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="signature-box">
                            <p class="mb-4 info-p">ลงชื่อ.........................................<br><strong>(ผู้รับมอบตัวอย่าง)</strong><br>
                            <span style="font-size: 11pt;">วันที่ ......./......./.......</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ปุ่มควบคุมการพิมพ์ -->
            <div class="text-center no-print">
                <button onclick="window.print()" class="btn btn-primary btn-sm px-4">พิมพ์เอกสารอีกครั้ง</button>
                <button onclick="window.close()" class="btn btn-secondary btn-sm px-4 ms-2">ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>

</body>
</html>