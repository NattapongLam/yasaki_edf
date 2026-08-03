<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>พิมพ์เอกสารส่งมอบ - {{ $header->delivered_test_hds_docuno ?? '' }}</title>
    <!-- เรียกใช้งาน Bootstrap CSS และ Google Fonts (Sarabun) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #525659; /* สีพื้นหลังโปรแกรมดูเอกสารเวลาไม่พิมพ์ */
            font-family: 'Sarabun', sans-serif;
            color: #000;
        }
        .print-container {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 10mm auto;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* ดันส่วนลายเซ็นและปุ่มให้กระจายตัวสวยงาม */
        }
        .table th, .table td {
            vertical-align: middle;
            padding: 8px 12px;
        }
        .signature-section {
            margin-top: 40px;
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
        }
    </style>
</head>
<body onload="window.print()">

    <div class="print-container">
        <div>
            <!-- ส่วนหัวเอกสาร -->
            <div class="text-center mb-4">
                <h3 class="fw-bold mb-1">ใบส่งมอบชิ้นงาน / เอกสารส่งมอบ</h3>
                <p class="text-muted mb-0">เลขที่เอกสาร: <strong>{{ $header->delivered_test_hds_docuno ?? '-' }}</strong> <span class="badge bg-secondary">({{$header->delivered_test_hds_type ?? '-'}})</span></p>
            </div>

            <!-- ข้อมูลรายละเอียดหัวเอกสาร -->
            <div class="row mb-3 border p-3 rounded bg-light">
                <div class="col-6">
                    <p class="mb-1"><strong>วันที่:</strong> {{ $header->delivered_test_hds_date ?? '-' }}</p>
                    <p class="mb-0"><strong>ชื่อลูกค้า/บริษัท:</strong> {{ $header->delivered_test_hds_customer ?? '-' }}</p>
                </div>
                <div class="col-6 text-end">
                    <p class="mb-1"><strong>เลขอ้างอิงคำร้อง:</strong> {{ $header->ar_requestorder_hds_docuno ?? '-' }}</p>
                    <p class="mb-0"><strong>ผู้ติดต่อ:</strong> {{ $header->delivered_test_hds_contact ?? '-' }}</p>
                </div>
            </div>

            <!-- ตารางแสดงรายการย่อย -->
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 10%">#</th>
                        <th style="width: 60%" class="text-start ps-3">รายละเอียด</th>
                        <th style="width: 30%">จำนวน</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dt as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="text-start ps-3">{{ $item->delivered_test_dts_remark }}</td>
                            <td>{{ $item->delivered_test_dts_qty }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- ส่วนหมายเหตุ -->
            @if(!empty($header->delivered_test_hds_remark))
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="p-2 border rounded bg-white">
                            <strong>หมายเหตุ :</strong> {{ $header->delivered_test_hds_remark }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div>
            <!-- ส่วนช่องสำหรับเซ็นชื่อ -->
            <div class="signature-section">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="p-3">
                            <p class="mb-5">ลงชื่อ..................................................ผู้ส่งมอบ<br>
                            <span class="text-muted" style="font-size: 0.9rem;">(............................................................)</span><br>
                            วันที่ ......./......./.......</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3">
                            <p class="mb-5">ลงชื่อ..................................................ผู้รับมอบ<br>
                            <span class="text-muted" style="font-size: 0.9rem;">(............................................................)</span><br>
                            วันที่ ......./......./.......</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ปุ่มกดพิมพ์เพิ่มเติม / ปิดหน้าต่าง (จะไม่แสดงเวลาสั่งพิมพ์ออก Printer) -->
            <div class="text-center mt-4 no-print">
                <button onclick="window.print()" class="btn btn-primary px-4">พิมพ์อีกครั้ง</button>
                <button onclick="window.close()" class="btn btn-secondary px-4">ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>

</body>
</html>