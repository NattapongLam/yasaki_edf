<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ใบสั่งซื้อ {{ $hd->ap_purchaseorder_hds_docuno }}</title>

<style>
@page {
    size: A4;
    margin: 20mm;
}

body {
    font-family: "TH Sarabun New", sans-serif;
    font-size: 15px;
    color: #000;
}

.header {
    display: flex;
    align-items: center;
    border-bottom: 2px solid #000;
    padding-bottom: 8px;
    margin-bottom: 15px;
}

.logo {
    width: 110px;
}

.company {
    margin-left: 15px;
    line-height: 1.4;
}

h2 {
    text-align: center;
    margin: 15px 0;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
}

th, td {
    border: 1px solid #000;
    padding: 6px;
}

th {
    background: #f2f2f2;
    text-align: center;
}

tr { page-break-inside: avoid; }

.text-right { text-align: right; }
.text-center { text-align: center; }

.summary {
    width: 40%;
    margin-left: auto;
}

.summary td {
    border: 1px solid #000;
    padding: 5px;
}

.remark {
    border: 1px solid #000;
    padding: 8px;
    margin-top: 10px;
}

.signature td {
    border: none;
    text-align: center;
    padding-top: 50px;
}

.no-print {
    text-align: right;
    margin-bottom: 10px;
}

@media print {
    .no-print { display: none; }
}
</style>
</head>
<body>

<div class="no-print">
    <button onclick="window.print()">🖨 พิมพ์</button>
</div>

<!-- ===== Header ===== -->
<div class="header">
    <img src="{{ URL::asset('assets/images/KK-C.png') }}" class="logo">
    <div class="company">
        <b>{{$comp->acc_companies_name1}}</b><br>
        เลขประจำตัวผู้เสียภาษี {{$comp->acc_companies_taxid}}<br>
        {{$comp->acc_companies_address1}}<br>
        โทร. {{$comp->acc_companies_tel}} | {{$comp->acc_companies_email}}
    </div>
</div>

<h2>ใบสั่งซื้อ (PURCHASE ORDER)</h2>

<!-- ===== PO INFO ===== -->
<table>
<tr>
    <td width="15%"><b>เลขที่</b></td>
    <td width="35%">{{ $hd->ap_purchaseorder_hds_docuno }}</td>
    <td width="15%"><b>วันที่</b></td>
    <td width="35%">{{ \Carbon\Carbon::parse($hd->ap_purchaseorder_hds_date)->format('d/m/Y') }}</td>
</tr>
<tr>
    <td><b>ผู้จำหน่าย</b></td>
    <td colspan="3">{{ $hd->ap_vendor_lists_name }}</td>
</tr>
<tr>
    <td><b>ที่อยู่</b></td>
    <td colspan="3">{{ $hd->ap_vendor_lists_address }}</td>
</tr>
<tr>
    <td><b>โทร</b></td>
    <td>{{ $hd->ap_vendor_lists_tel }}</td>
    <td><b>Email</b></td>
    <td>{{ $hd->ap_vendor_lists_email }}</td>
</tr>
</table>

<!-- ===== DETAIL ===== -->
<table>
<thead>
<tr>
    <th width="5%">#</th>
    <th>สินค้า</th>
    <th width="10%">จำนวน</th>
    <th width="12%">ราคา</th>
    <th width="12%">ส่วนลด</th>
    <th width="15%">จำนวนเงิน</th>
</tr>
</thead>
<tbody>
@foreach ($dt as $i => $item)
<tr>
    <td class="text-center">{{ $i+1 }}</td>
    <td>{{ $item->wh_product_lists_name }}</td>
    <td class="text-right">{{ number_format($item->ap_purchaseorder_dts_qty,2) }}</td>
    <td class="text-right">{{ number_format($item->ap_purchaseorder_dts_price,2) }}</td>
    <td class="text-right">{{ number_format($item->ap_purchaseorder_dts_dis,2) }}</td>
    <td class="text-right">{{ number_format($item->ap_purchaseorder_dts_amount,2) }}</td>
</tr>
@endforeach
</tbody>
</table>

<!-- ===== SUMMARY ===== -->
<table class="summary">
<tr>
    <td><b>ฐานภาษี</b></td>
    <td class="text-right">{{ number_format($hd->ap_purchaseorder_hds_base,2) }}</td>
</tr>
<tr>
    <td><b>ภาษี</b></td>
    <td class="text-right">{{ number_format($hd->ap_purchaseorder_hds_vat,2) }}</td>
</tr>
<tr>
    <td><b>ส่วนลด</b></td>
    <td class="text-right">{{ number_format($hd->ap_purchaseorder_hds_dis,2) }}</td>
</tr>
<tr>
    <td><b>สุทธิ</b></td>
    <td class="text-right"><b>{{ number_format($hd->ap_purchaseorder_hds_net,2) }}</b></td>
</tr>
</table>

<!-- ===== REMARK ===== -->
<div class="remark">
<b>หมายเหตุ :</b> {{ $hd->ap_purchaseorder_hds_remark }}
</div>

<!-- ===== SIGNATURE ===== -->
<table class="signature" width="100%">
<tr>
    <td width="50%">
        {{ $hd->person_at }}<br>
        ผู้สั่งซื้อ
    </td>
    <td width="50%">
        @if ($hd->approved_by)
            {{ $hd->approved_by }}<br>
            วันที่ {{ \Carbon\Carbon::parse($hd->approved_date)->format('d/m/Y') }}
        @endif
        <br>ผู้อนุมัติ
    </td>
</tr>
</table>

</body>
</html>
