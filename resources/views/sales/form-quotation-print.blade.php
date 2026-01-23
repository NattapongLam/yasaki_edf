<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>ใบเสนอราคา {{ $hd->ar_quotation_hds_docuno }}</title>
    <style>
        body {
            font-family: "TH Sarabun New", sans-serif;
            font-size: 16px;
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
        }
        .text-right {
            text-align: right;
        }
        .no-border td {
            border: none;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">

<h2 style="text-align:center">ใบเสนอราคา (Quotation)</h2>

<table class="no-border">
    <tr>
        <td width="60%">
            <strong>ลูกค้า:</strong> {{ $hd->ar_customer_lists_name }}<br>
            <strong>ที่อยู่:</strong> {{ $hd->ar_customer_lists_address }}<br>
            <strong>โทร:</strong> {{ $hd->ar_customer_lists_tel }}<br>
            <strong>Email:</strong> {{ $hd->ar_customer_lists_email }}
        </td>
        <td width="40%">
            <strong>เลขที่:</strong> {{ $hd->ar_quotation_hds_docuno }}<br>
            <strong>วันที่:</strong> {{ $hd->ar_quotation_hds_date }}<br>
            <strong>เครดิต:</strong> {{ $hd->ar_customer_lists_credit }} วัน
        </td>
    </tr>
</table>

<br>

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
            <td align="center">{{ $i+1 }}</td>
            <td>{{ $row->wh_product_lists_name ?? '' }}</td>
            <td class="text-right">{{ number_format($row->ar_quotation_dts_qty,2) }}</td>
            <td class="text-right">{{ number_format($row->ar_quotation_dts_price,2) }}</td>
            <td class="text-right">{{ number_format($row->ar_quotation_dts_dis,2) }}</td>
            <td class="text-right">{{ number_format($row->ar_quotation_dts_net,2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>

<table class="no-border" width="100%">
    <tr>
        <td width="70%"></td>
        <td width="30%">
            <table>
                <tr>
                    <td>ฐานภาษี</td>
                    <td class="text-right">{{ number_format($hd->ar_quotation_hds_base,2) }}</td>
                </tr>
                <tr>
                    <td>ภาษี</td>
                    <td class="text-right">{{ number_format($hd->ar_quotation_hds_vat,2) }}</td>
                </tr>
                <tr>
                    <td>ส่วนลด</td>
                    <td class="text-right">{{ number_format($hd->ar_quotation_hds_dis,2) }}</td>
                </tr>
                <tr>
                    <td><strong>สุทธิ</strong></td>
                    <td class="text-right">
                        <strong>{{ number_format($hd->ar_quotation_hds_net,2) }}</strong>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br><br>

<p><strong>หมายเหตุ:</strong> {{ $hd->ar_quotation_hds_remark }}</p>

<div class="no-print" style="text-align:center;margin-top:20px;">
    <button onclick="window.print()">พิมพ์อีกครั้ง</button>
</div>

</body>
</html>
