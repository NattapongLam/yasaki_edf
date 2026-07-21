<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ใบคำร้องขอใช้บริการ - {{ $hd->ar_requestorder_hds_docuno }}</title>
    <style>
        @page { size: A4; margin: 15mm; }
        body { font-family: "TH Sarabun New", "Angsana New", sans-serif; font-size: 16pt; line-height: 1.5; color: #000; }
        
        .header { display: flex; align-items: center; justify-content: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header img { margin-right: 20px; }
        .header h2 { margin: 0; font-size: 24pt; }

        .info-section { margin-bottom: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .info-box { border: 1px solid #ccc; padding: 10px; border-radius: 5px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #f2f2f2 !important; border: 1px solid #333 !important; padding: 8px; }
        td { border: 1px solid #333 !important; padding: 8px; vertical-align: top; }

        .signature-section { margin-top: 50px; display: flex; justify-content: space-around; text-align: center; }
        .sig-box { width: 40%; }
        .sig-line { border-bottom: 1px solid #000; margin-top: 40px; }

        @media print { 
            .btn-print { display: none; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <img src="{{ URL::asset('assets/images/KK-C.png') }}" height="80">
        <h2>ใบคำร้องขอใช้บริการ</h2>
    </div>
    
    <div class="info-section">
        <div class="info-box">
            <strong>เลขที่เอกสาร:</strong> {{ $hd->ar_requestorder_hds_docuno }}<br>
            <strong>วันที่:</strong> {{ \Carbon\Carbon::parse($hd->ar_requestorder_hds_date)->format('d/m/Y') }}
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
                <th style="width: 25%;">สินค้า</th>
                <th style="width: 25%;">มาตรฐาน</th>
                <th style="width: 15%;">มิติ (mm)</th>
                <th style="width: 10%;">จำนวน</th>
                <th style="width: 20%;">หมายเหตุ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dt as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->ar_requestorder_dts_product }}</td>
                <td>{{ $item->ar_requestorder_dts_jis_class == "CLASS_3" ? "JIS D 4411 Class 3" : "JIS D 4411 Class 4" }}</td>
                <td>{{ $item->ar_requestorder_dts_dimensions }}</td>
                <td>{{ number_format($item->ar_requestorder_dts_qty) }}</td>
                <td>{{ $item->ar_requestorder_hds_remark }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature-section">
        <div class="sig-box">
            <p>ผู้ขอใช้บริการ</p>
            <div class="sig-line">( {{ $hd->person_at }} )</div>
            <p>วันที่: {{ \Carbon\Carbon::parse($hd->ar_requestorder_hds_date)->format('d/m/Y') }}</p>
        </div>
        <div class="sig-box">
            <p>สถานะ: {{$sta->ar_requestorder_statuses_name}}</p>
            <div class="sig-line">( {{ $hd->approved_at ?? '............................' }} )</div>
            <p>วันที่: {{  \Carbon\Carbon::parse($hd->approved_date)->format('d/m/Y')  ?? '............................' }}</p>
        </div>
    </div>
    
    <div class="btn-print" style="margin-top:50px; text-align:center;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">สั่งพิมพ์เอกสาร</button>
    </div>
</body>
</html>