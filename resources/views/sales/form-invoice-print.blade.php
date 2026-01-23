<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ใบแจ้งหนี้</title>

    <style>
        @page {
            size: A4;
            margin: 15mm;
        }

        body {
            font-family: "TH Sarabun New", "TH SarabunPSK", sans-serif;
            font-size: 16px;
            color: #000;
        }

        h2, h3 {
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .company {
            text-align: left;
            margin-bottom: 10px;
        }

        .company strong {
            font-size: 20px;
        }

        .doc-info {
            width: 100%;
            margin-bottom: 15px;
        }

        .doc-info td {
            padding: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        table th {
            background-color: #f2f2f2;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            width: 40%;
            float: right;
            margin-top: 15px;
        }

        .summary td {
            border: 1px solid #000;
            padding: 6px;
        }

        .signature {
            margin-top: 70px;
            width: 100%;
        }

        .signature td {
            text-align: center;
            padding-top: 40px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()" onafterprint="window.close()">

    {{-- HEADER --}}
    <div class="header">
        <h2>ใบแจ้งหนี้ (INVOICE)</h2>
    </div>

    {{-- COMPANY INFO --}}
    <div class="company">
        <strong>{{$hd->ar_customer_lists_name}}</strong><br>
        {{$hd->ar_customer_lists_address}}<br>
        โทร: {{$hd->ar_customer_lists_tel}} &nbsp;&nbsp; เลขประจำตัวผู้เสียภาษี: {{$hd->ar_customer_lists_taxid}}
    </div>

    {{-- DOCUMENT INFO --}}
    <table class="doc-info">
        <tr>
            <td width="15%">เลขที่เอกสาร</td>
            <td width="35%">{{ $hd->ar_invoice_hds_docuno }}</td>
            <td width="15%">วันที่</td>
            <td width="35%">
                {{ \Carbon\Carbon::parse($hd->ar_invoice_hds_date)->format('d/m/Y') }}
            </td>
        </tr>
    </table>

    {{-- ITEMS --}}
    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="30%">รายการสินค้า</th>
                <th width="10%">จำนวน</th>
                <th width="15%">ราคาต่อหน่วย</th>
                <th width="10%">ส่วนลด</th>
                <th width="15%">จำนวนเงิน</th>
                <th width="15%">หมายเหตุ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dt as $item)
            <tr>
                <td>{{ $item->ar_invoice_dts_listno }}</td>
                <td class="text-left">{{ $item->wh_product_lists_name }}</td>
                <td>{{ number_format($item->ar_invoice_dts_qty,2) }}</td>
                <td class="text-right">{{ number_format($item->ar_invoice_dts_price,2) }}</td>
                <td class="text-right">{{ number_format($item->ar_invoice_dts_discount,2) }}</td>
                <td class="text-right">{{ number_format($item->ar_invoice_dts_amount,2) }}</td>
                <td class="text-left">{{ $item->ar_invoice_dts_remark }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    {{-- SUMMARY --}}
    <table class="summary">
        <tr>
            <td>ฐานภาษี</td>
            <td class="text-right">{{ number_format($hd->ar_invoice_hds_base,2) }}</td>
        </tr>
        <tr>
            <td>ภาษีมูลค่าเพิ่ม</td>
            <td class="text-right">{{ number_format($hd->ar_invoice_hds_vat,2) }}</td>
        </tr>
        <tr>
            <td><strong>ยอดสุทธิ</strong></td>
            <td class="text-right"><strong>{{ number_format($hd->ar_invoice_hds_net,2) }}</strong></td>
        </tr>
    </table>
    <br><br><br>
    {{-- SIGNATURE --}}
    <table class="signature">
        <tr>
            <td width="50%">
                ....................................................<br>
                ผู้รับเอกสาร
            </td>
            <td width="50%">
                ....................................................<br>
                ผู้มีอำนาจลงนาม
            </td>
        </tr>
    </table>

</body>
</html>
