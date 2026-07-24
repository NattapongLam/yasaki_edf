<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ใบรับคำร้องขอใช้บริการ - {{ $hd->ar_requestorder_hds_docuno }}</title>
    <style>
        @page { 
            size: A4; 
            margin: 10mm 15mm 10mm 15mm; 
        }
        body { 
            font-family: "TH Sarabun New", "Angsana New", sans-serif; 
            font-size: 14pt; 
            line-height: 1.35; 
            color: #000; 
            margin: 0;
            padding: 0;
        }
        
        /* Header */
        .header { 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin-bottom: 10px; 
            border-bottom: 2px solid #333; 
            padding-bottom: 8px; 
        }
        .header img { 
            margin-right: 15px; 
            height: 60px;
        }
        .header h2 { 
            margin: 0; 
            font-size: 20pt; 
        }

        /* Info Section */
        .info-section { 
            margin-bottom: 10px; 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 10px; 
        }
        .info-box { 
            border: 1px solid #999; 
            padding: 8px 12px; 
            border-radius: 4px; 
            font-size: 14pt;
        }

        /* Table */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 5px; 
            margin-bottom: 10px;
        }
        th { 
            background-color: #f2f2f2 !important; 
            border: 1px solid #333 !important; 
            padding: 6px; 
            font-size: 14pt;
            text-align: center;
        }
        td { 
            border: 1px solid #333 !important; 
            padding: 6px; 
            vertical-align: top; 
            font-size: 14pt;
        }

        /* ISO Terms & Conditions Section */
        .iso-section {
            border: 1px solid #666;
            padding: 8px 10px;
            border-radius: 4px;
            margin-bottom: 10px;
            background-color: #fafafa;
        }
        .iso-section h4 {
            margin: 0 0 5px 0;
            font-size: 14pt;
            text-decoration: underline;
        }
        .iso-content {
            font-size: 11.5pt;
            line-height: 1.25;
            text-align: justify;
        }
        .iso-content p {
            margin: 0 0 4px 0;
        }

        /* Signature Section */
        .signature-section { 
            margin-top: 15px; 
            display: flex; 
            justify-content: space-around; 
            text-align: center; 
            page-break-inside: avoid;
        }
        .sig-box { 
            width: 40%; 
            font-size: 14pt;
        }
        .sig-line { 
            border-bottom: 1px dotted #000; 
            margin-top: 25px; 
            margin-bottom: 5px;
            padding-bottom: 2px;
        }

        /* Print Settings */
        @media print { 
            .btn-print { display: none; }
            body { -webkit-print-color-adjust: exact; }
            .iso-section { background-color: #fafafa !important; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <img src="{{ URL::asset('assets/images/KK-C.png') }}" alt="Logo">
        <h2>ใบคำร้องขอใช้บริการ</h2>
    </div>
    
    <div class="info-section">
        <div class="info-box">
            <strong>เลขที่เอกสาร:</strong> {{ $hd->ar_requestorder_hds_docuno }}<br>
            <strong>วันที่:</strong> {{ \Carbon\Carbon::parse($hd->ar_requestorder_hds_date)->format('d/m/Y') }}<br>
            <strong>กำหนดส่ง:</strong> {{ \Carbon\Carbon::parse($hd->ar_requestorder_hds_duedate)->format('d/m/Y') }}
        </div>
        <div class="info-box">
            <strong>บริษัท:</strong> {{ $hd->ar_requestorder_hds_customer }}<br>
            <strong>ผู้ติดต่อ:</strong> {{ $hd->ar_requestorder_hds_contact }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 23%;">สินค้า</th>
                <th style="width: 25%;">มาตรฐาน</th>
                <th style="width: 15%;">มิติ (mm)</th>
                <th style="width: 10%;">จำนวน</th>
                <th style="width: 22%;">หมายเหตุ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dt as $item)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td>{{ $item->ar_requestorder_dts_product }}</td>
                <td>{{ $item->ar_requestorder_dts_jis_class == "CLASS_3" ? "JIS D 4411 Class 3" : "JIS D 4411 Class 4" }}</td>
                <td style="text-align: center;">{{ $item->ar_requestorder_dts_dimensions }}</td>
                <td style="text-align: center;">{{ number_format($item->ar_requestorder_dts_qty) }}</td>
                <td>{{ $item->ar_requestorder_hds_remark }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ส่วนเงื่อนไขและข้อจำกัด ISO/IEC 17025 (ปรับให้อยู่ในกรอบและฟอนต์อ่านง่ายพอดีหน้า A4) -->
    <div class="iso-section">
        <h4>เงื่อนไขและข้อจำกัดการทดสอบตามมาตรฐาน ISO/IEC 17025 (JIS D 4411)</h4>
        <div class="iso-content">
            <p>เพื่อให้การสื่อสารชัดเจนและเป็นไปตามหลักเกณฑ์ ISO/IEC 17025 ลูกค้ารับทราบและยอมรับข้อจำกัดความเสี่ยง ดังนี้:</p>
            <p><strong>1. สภาวะการใช้งานจริง:</strong> ขีดจำกัดอุณหภูมิสูงสุด 300°C (Class 3) และ 350°C (Class 4) หากเกินกว่านี้แรงเสียดทาน (μ) และการสึกหรอ (V) จะไม่รับประกัน / การทดสอบเป็นแบบความเร็วคงที่ (6-8 m/s) และแรงกดคงที่ (1±0.02 MPa) ไม่ครอบคลุมการเบรกฉุกเฉินหรือแบบพลวัต</p>
            <p><strong>2. สภาพแวดล้อมและจานเบรก:</strong> อ้างอิงจานทดสอบวัสดุ FC 250 (Pearlite structure) ตาม JIS G 5501 เท่านั้น หากต่างออกไปค่าอาจคลาดเคลื่อน / ควบคุมอุณหภูมิห้อง (25-31°C) ความชื้น (40-60% RH) ไม่ครอบคลุมสภาวะมีน้ำ โคลน เกลือ หรือสภาพอากาศสุดขั้ว</p>
            <p><strong>3. อายุการใช้งานและ NVH:</strong> ทดสอบระยะสั้น 5,000 รอบ/ระดับอุณหภูมิ ไม่ครอบคลุมการเสื่อมสภาพระยะยาว / ตรวจสอบเฉพาะรอยแตก/การบวม ไม่ครอบคลุมเสียงดัง (Squeal) หรือการสั่นสะเทือน (Vibration)</p>
            <p><strong>4. ความไม่แน่นอนของการวัด:</strong> ผลทดสอบมีค่าความไม่แน่นอนขยาย (Expanded Uncertainty) ประมาณ ±0.032μ (ที่ความเชื่อมั่น 95%) ตามเครื่องมือและกระบวนการวัด</p>
        </div>
    </div>

    <div class="signature-section">
        <div class="sig-box">
            <p style="margin: 0;">ผู้ขอใช้บริการ</p>
            <div class="sig-line">( {{ $hd->person_at ?? '............................................' }} )</div>
            <p style="margin: 0;">วันที่: {{ \Carbon\Carbon::parse($hd->ar_requestorder_hds_date)->format('d/m/Y') }}</p>
        </div>
        <div class="sig-box">
            <p style="margin: 0;">ลูกค้ายืนยัน</p>
            <div class="sig-line">( ............................................ )</div>
            <p style="margin: 0;">วันที่: ............................................</p>
        </div>
    </div>
    
    <div class="btn-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 8px 20px; cursor: pointer; font-size: 14pt;">สั่งพิมพ์เอกสาร</button>
    </div>
</body>
</html>