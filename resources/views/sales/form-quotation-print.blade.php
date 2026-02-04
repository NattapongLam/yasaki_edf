<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>ใบเสนอราคา {{ $hd->ar_quotation_hds_docuno }}</title>

    <style>
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            font-family: "TH Sarabun New", sans-serif;
            font-size: 14px;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            text-align: center;
            background: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .no-border td {
            border: none;
            padding: 2px 4px;
        }

        .header-table td {
            border: none;
            vertical-align: top;
        }

        .doc-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0 20px 0;
        }

        .summary-table td {
            padding: 5px 8px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">

<!-- ===== Header ===== -->
<table class="header-table">
    <tr>
        <td width="25%">
            <img src="{{ URL::asset('assets/images/KK-C.png') }}" height="80">            
        </td>
        <td width="50%" class="text-center">
            <div class="doc-title">ใบเสนอราคา (Quotation)</div>
        </td>
        <td width="25%">
            <strong>เลขที่:</strong> {{ $hd->ar_quotation_hds_docuno }}<br>
            <strong>วันที่:</strong> {{ \Carbon\Carbon::parse($hd->ar_quotation_hds_date)->format('d/m/Y') }}<br>
            <strong>เครดิต:</strong> {{ $hd->ar_customer_lists_credit }} วัน
        </td>
    </tr>
</table>

<hr>

<!-- ===== Customer ===== -->
<table class="no-border">
    <tr>
        <td width="60%">
            <strong>ลูกค้า:</strong> {{ $hd->ar_customer_lists_name }}<br>
            <strong>ที่อยู่:</strong> {{ $hd->ar_customer_lists_address }}<br>
            <strong>โทร:</strong> {{ $hd->ar_customer_lists_tel }}<br>
            <strong>Email:</strong> {{ $hd->ar_customer_lists_email }}
        </td>
    </tr>
</table>

<br>

<!-- ===== Detail ===== -->
<table>
    <thead>
        <tr>
            <th width="5%">#</th>
            <th width="40%">รายการ</th>
            <th width="10%">จำนวน</th>
            <th width="15%">ราคา/หน่วย</th>
            <th width="15%">ส่วนลด</th>
            <th width="15%">จำนวนเงิน</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dt as $i => $row)
        <tr>
            <td class="text-center">{{ $i+1 }}</td>
            <td>{{ $row->wh_product_lists_name }}</td>
            <td class="text-right">{{ number_format($row->ar_quotation_dts_qty,2) }}</td>
            <td class="text-right">{{ number_format($row->ar_quotation_dts_price,2) }}</td>
            <td class="text-right">{{ number_format($row->ar_quotation_dts_dis,2) }}</td>
            <td class="text-right">{{ number_format($row->ar_quotation_dts_net,2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>

<!-- ===== Summary ===== -->
<table class="no-border">
    <tr>
        <td width="65%"></td>
        <td width="35%">
            <table class="summary-table">
                <tr>
                    <td>ฐานภาษี</td>
                    <td class="text-right">{{ number_format($hd->ar_quotation_hds_base,2) }}</td>
                </tr>
                <tr>
                    <td>ภาษีมูลค่าเพิ่ม</td>
                    <td class="text-right">{{ number_format($hd->ar_quotation_hds_vat,2) }}</td>
                </tr>
                <tr>
                    <td>ส่วนลด</td>
                    <td class="text-right">{{ number_format($hd->ar_quotation_hds_dis,2) }}</td>
                </tr>
                <tr>
                    <td><strong>ยอดสุทธิ</strong></td>
                    <td class="text-right">
                        <strong>{{ number_format($hd->ar_quotation_hds_net,2) }}</strong>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br>

<!-- ===== Remark ===== -->
<p>
    <strong>หมายเหตุ:</strong><br>
    {{ $hd->ar_quotation_hds_remark }}
</p>

<!-- ===== Print Button ===== -->
<div class="no-print text-center" style="margin-top:20px;">
    <button onclick="window.print()">พิมพ์เอกสาร</button>
</div>

</body>
</html>
