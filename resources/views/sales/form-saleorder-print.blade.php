<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>พิมพ์บิลขาย</title>

<style>
@page {
    size: A4;
    margin: 15mm;
}

body {
    font-family: "TH Sarabun New", sans-serif;
    font-size: 16px;
    color: #000;
}

h2 {
    margin: 0;
    font-size: 26px;
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
    background: #f2f2f2;
    font-weight: bold;
}

.text-left { text-align: left; }
.text-right { text-align: right; }
.text-center { text-align: center; }

.no-border td {
    border: none;
    padding: 3px;
}

.header-table td {
    border: none;
}

.summary {
    width: 45%;
    float: right;
    margin-top: 10px;
}

.signature td {
    border: none;
    text-align: center;
    padding-top: 40px;
}

</style>
</head>

<body onload="window.print()">

{{-- HEADER --}}
<table class="header-table">
<tr>
    <td width="20%">
        <img src="{{ URL::asset('assets/images/KK-C.png') }}" height="70">
    </td>
    <td width="80%" class="text-right">
        <h2>บิลขาย (SALE ORDER)</h2>
    </td>
</tr>
</table>

<hr>

{{-- CUSTOMER INFO --}}
<table class="no-border">
<tr>
    <td width="60%" class="text-left">
        <strong>{{ $hd->ar_customer_lists_name }}</strong><br>
        {{ $hd->ar_customer_lists_address }}<br>
        โทร: {{ $hd->ar_customer_lists_tel }}<br>
        เลขประจำตัวผู้เสียภาษี: {{ $hd->ar_customer_lists_taxid }}
    </td>
    <td width="40%">
        <table>
            <tr>
                <td>เลขที่เอกสาร</td>
                <td>{{ $hd->ar_saleorder_hds_docuno }}</td>
            </tr>
            <tr>
                <td>วันที่</td>
                <td>{{ \Carbon\Carbon::parse($hd->ar_saleorder_hds_date)->format('d/m/Y') }}</td>
            </tr>
        </table>
    </td>
</tr>
</table>

<br>

{{-- ITEMS --}}
<table>
<thead>
<tr>
    <th width="5%">#</th>
    <th width="35%">รายการสินค้า</th>
    <th width="10%">จำนวน</th>
    <th width="15%">ราคาต่อหน่วย</th>
    <th width="10%">ส่วนลด</th>
    <th width="15%">จำนวนเงิน</th>
</tr>
</thead>
<tbody>
@foreach($dt as $item)
<tr>
    <td class="text-center">{{ $item->ar_saleorder_dts_listno }}</td>
    <td class="text-left">{{ $item->wh_product_lists_name }}</td>
    <td class="text-right">{{ number_format($item->ar_saleorder_dts_qty,2) }}</td>
    <td class="text-right">{{ number_format($item->ar_saleorder_dts_price,2) }}</td>
    <td class="text-right">{{ number_format($item->ar_saleorder_dts_dis,2) }}</td>
    <td class="text-right">{{ number_format($item->ar_saleorder_dts_amount,2) }}</td>
</tr>
@endforeach
</tbody>
</table>

{{-- SUMMARY --}}
<table class="summary">
<tr>
    <td>รวมเป็นเงิน</td>
    <td class="text-right">{{ number_format($hd->ar_saleorder_hds_base,2) }}</td>
</tr>
<tr>
    <td>ภาษีมูลค่าเพิ่ม</td>
    <td class="text-right">{{ number_format($hd->ar_saleorder_hds_vat,2) }}</td>
</tr>
<tr>
    <td><strong>ยอดสุทธิ</strong></td>
    <td class="text-right"><strong>{{ number_format($hd->ar_saleorder_hds_net,2) }}</strong></td>
</tr>
</table>

<div style="clear:both"></div>

<br><br>

{{-- SIGNATURE --}}
<table class="signature">
<tr>
    <td width="50%">
        ....................................................<br>
        ผู้รับสินค้า
    </td>
    <td width="50%">
        ....................................................<br>
        ผู้มีอำนาจลงนาม
    </td>
</tr>
</table>

</body>
</html>
