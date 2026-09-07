<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ใบรับคำร้องขอใช้บริการ - {{ $hd->ar_requestorder_hds_docuno }}</title>
    <style>
        @page { 
            size: A4; 
            margin: 8mm 12mm 8mm 12mm; 
        }
        body { 
            font-family: "TH Sarabun New", "Angsana New", sans-serif; 
            font-size: 14pt; 
            line-height: 1.3; 
            color: #111; 
            margin: 0;
            padding: 0;
        }
        
        /* Header */
        .header { 
            width: 100%;
            border-bottom: 2px solid #222; 
            padding-bottom: 6px; 
            margin-bottom: 8px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }
        .header-table td {
            border: none !important;
            padding: 0;
            vertical-align: middle;
        }
        .header img { 
            height: 55px;
        }
        .header h2 { 
            margin: 0; 
            font-size: 18pt; 
            color: #000;
        }
        .company {
            font-size: 12pt;
            color: #333;
        }

        /* Info Section (Using Table for PDF engine compatibility) */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            border: none;
        }
        .info-table td {
            width: 50%;
            vertical-align: top;
            border: none !important;
            padding: 0;
        }
        .info-box { 
            border: 1px solid #777; 
            padding: 6px 10px; 
            border-radius: 4px; 
            font-size: 13.5pt;
            background-color: #fff;
            min-height: 80px;
        }
        .info-box.left { margin-right: 4px; }
        .info-box.right { margin-left: 4px; }
        .info-box strong {
            color: #222;
        }

        /* Main Data Table */
        table.data-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 8px;
        }
        table.data-table th { 
            background-color: #e9ecef !important; 
            border: 1px solid #444 !important; 
            padding: 5px 4px; 
            font-size: 13.5pt;
            text-align: center;
            color: #000;
        }
        table.data-table td { 
            border: 1px solid #444 !important; 
            padding: 5px 6px; 
            vertical-align: middle; 
            font-size: 13.5pt;
        }

        /* ISO Terms & Conditions Section */
        .iso-section {
            border: 1px solid #555;
            padding: 6px 10px;
            border-radius: 4px;
            margin-bottom: 8px;
            background-color: #fcfcfc;
        }
        .iso-section h4 {
            margin: 0 0 4px 0;
            font-size: 13.5pt;
            text-decoration: underline;
            color: #000;
        }
        .iso-content {
            font-size: 11pt;
            line-height: 1.2;
            text-align: justify;
        }
        .iso-content p {
            margin: 0 0 3px 0;
        }

        /* Signature Section */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border: none;
            page-break-inside: avoid;
        }
        .signature-table td {
            width: 50%;
            border: none !important;
            text-align: center;
            padding: 0 20px;
            font-size: 13.5pt;
        }
        .sig-line { 
            border-bottom: 1px dotted #333; 
            margin-top: 20px; 
            margin-bottom: 4px;
            padding-bottom: 2px;
        }

        /* Print Settings */
        @media print { 
            .btn-print { display: none; }
            body { -webkit-print-color-adjust: exact; }
            .iso-section { background-color: #fcfcfc !important; }
            table.data-table th { background-color: #e9ecef !important; }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- ส่วนหัว (Header) -->
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="width: 15%;">
                    <img src="{{ URL::asset('assets/images/KK-C.png') }}" alt="Logo">
                </td>
                <td style="width: 55%; text-align: left; padding-left: 10px;">
                    <h2>ใบรับคำร้องขอใช้บริการ</h2>
                    YSK5-FM-LAB-17 Rev.00 : 01/08/2569
                </td>
                <td style="width: 30%; text-align: right;">
                    <div class="company">
                        <strong>KK&C PARTS CO., LTD.</strong><br>
                        <span style="font-size: 9.5pt; color: #555;">588/35 M Floor, Sathu Pradit Rd., Bangkok</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    
    <!-- ข้อมูลเอกสารและลูกค้า (Info Section ใช้ตารางควบคุมโครงสร้างเพื่อกัน PDF หลุดบรรทัด) -->
    <table class="info-table">
        <tr>
            <td>
                <div class="info-box left">
                    <strong>เลขที่เอกสาร:</strong> {{ $hd->ar_requestorder_hds_docuno }}<br>
                    <strong>วันที่:</strong> {{ \Carbon\Carbon::parse($hd->ar_requestorder_hds_date)->format('d/m/Y') }}<br>
                    <strong>กำหนดส่ง:</strong> {{ \Carbon\Carbon::parse($hd->ar_requestorder_hds_duedate)->format('d/m/Y') }}<br>
                    <strong>หมายเหตุ:</strong> {{ $hd->ar_requestorder_hd_remark ?: '-' }}
                </div>
            </td>
            <td>
                <div class="info-box right">
                    <strong>บริษัท:</strong> {{ $hd->ar_requestorder_hds_customer }}<br>
                    <strong>ผู้ติดต่อ:</strong> {{ $hd->ar_requestorder_hds_contact }} | <strong>เบอร์:</strong> {{ $hd->ar_requestorder_hds_tel }} | <strong>อีเมล:</strong> {{ $cust->ar_customer_lists_email }}<br>
                    <strong>ที่อยู่:</strong> {{ $cust->ar_customer_lists_address1 }} {{$subd->other_sub_districts_name1}} {{$dist->other_districts_name1}} {{$prov->other_provinces_name1}} {{$subd->other_sub_districts_zipcode}}
                </div>
            </td>
        </tr>
    </table>

    <!-- ตารางรายการสินค้า -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 23%;">สินค้า</th>
                <th style="width: 22%;">มาตรฐาน</th>
                <th style="width: 15%;">มิติ (มม.)</th>
                <th style="width: 13%;">น้ำหนัก (ก.)</th>
                <th style="width: 8%;">จำนวน</th>
                <th style="width: 14%;">หมายเหตุ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dt as $item)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td>{{ $item->ar_requestorder_dts_product }}</td>
                <td>{{ $item->ar_requestorder_dts_jis_class == "CLASS_3" ? "JIS D 4411 Class 3" : "JIS D 4411 Class 4" }}</td>
                <td style="text-align: center;">{{ $item->ar_requestorder_dts_dimensions }}</td>
                <td style="text-align: center;">{{ $item->ar_requestorder_dts_weight }}</td>
                <td style="text-align: center;">{{ number_format($item->ar_requestorder_dts_qty) }}</td>
                <td>{{ $item->ar_requestorder_hds_remark ?: '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ส่วนเงื่อนไขและข้อจำกัด ISO/IEC 17025 -->
    <div class="iso-section">
        <h4>เงื่อนไขและข้อจำกัดการทดสอบตามมาตรฐาน ISO/IEC 17025 (JIS D 4411)</h4>
        <div class="iso-content">
            <p><strong>เพื่อให้การสื่อสารชัดเจนและเป็นไปตามหลักเกณฑ์ ISO/IEC 17025 ลูกค้ารับทราบและยอมรับข้อจำกัดความเสี่ยง ดังนี้:</strong></p>
            <p><strong>1. สภาวะการใช้งานจริง:</strong> ขีดจำกัดอุณหภูมิสูงสุด 300°C (Class 3) และ 350°C (Class 4) หากเกินกว่านี้แรงเสียดทาน (μ) และการสึกหรอ (V) จะไม่รับประกัน / การทดสอบเป็นแบบความเร็วคงที่ (6-8 m/s) และแรงกดคงที่ (1±0.02 MPa) ไม่ครอบคลุมการเบรกฉุกเฉินหรือแบบพลวัต</p>
            <p><strong>2. สภาพแวดล้อมและจานเบรก:</strong> อ้างอิงจานทดสอบวัสดุ FC 250 (Pearlite structure) ตาม JIS G 5501 เท่านั้น หากต่างออกไปค่าอาจคลาดเคลื่อน / ควบคุมอุณหภูมิห้อง (25-31°C) ความชื้น (40-60% RH) ไม่ครอบคลุมสภาวะมีน้ำ โคลน เกลือ หรือสภาพอากาศสุดขั้ว</p>
            <p><strong>3. อายุการใช้งานและ NVH:</strong> ทดสอบระยะสั้น 5,000 รอบ/ระดับอุณหภูมิ ไม่ครอบคลุมการเสื่อมสภาพระยะยาว / ตรวจสอบเฉพาะรอยแตก/การบวม ไม่ครอบคลุมเสียงดัง (Squeal) หรือการสั่นสะเทือน (Vibration)</p>
            <p><strong>4. ความไม่แน่นอนของการวัด:</strong> ผลทดสอบมีค่าความไม่แน่นอนขยาย (Expanded Uncertainty) ประมาณ ±0.032μ (ที่ความเชื่อมั่น 95%) ตามเครื่องมือและกระบวนการวัด</p>
        </div>
    </div>

    <!-- ส่วนลายเซ็น -->
    <table class="signature-table">
        <tr>
            <td>
                <p style="margin: 0;">ผู้ขอใช้บริการ</p>
                <div class="sig-line">( {{ $hd->person_at ?? '............................................................' }} )</div>
                <p style="margin: 0; font-size: 12pt;">วันที่: {{ \Carbon\Carbon::parse($hd->ar_requestorder_hds_date)->format('d/m/Y') }}</p>
            </td>
            <td>
                <p style="margin: 0;">ลูกค้ายืนยัน</p>
                <div class="sig-line">( ............................................................ )</div>
                <p style="margin: 0; font-size: 12pt;">วันที่: ............................................................</p>
            </td>
        </tr>
    </table>
    
    <!-- ปุ่มสั่งพิมพ์ (ซ่อนอัตโนมัติเมื่อกดพิมพ์) -->
    <div class="btn-print" style="margin-top: 15px; text-align: center;">
        <button onclick="window.print()" style="padding: 6px 20px; cursor: pointer; font-size: 13pt; background: #007bff; color: #fff; border: none; border-radius: 4px;">สั่งพิมพ์เอกสาร</button>
    </div>
</body>
</html>