@extends('layouts.main')
@section('content')
<div class="row">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="mdi mdi-check-all me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="mdi mdi-block-helper me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
<div class="card">
    <div class="card-body">
        <form method="POST" class="form-horizontal" action="{{ route('purchaseorders.update',$hd->ap_purchaseorder_hds_id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">อนุมัติใบสั่งซื้อ</h3></div>
             <input type="hidden" value="Approved" name="checkdoc">
        </div>       
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_purchaseorder_hds_date" class="col-form-label">วันที่</label>
                   <input type="date" class="form-control" 
                            name="ap_purchaseorder_hds_date" 
                            id="ap_purchaseorder_hds_date"
                            value="{{$hd->ap_purchaseorder_hds_date}}" 
                            readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_purchaseorder_hds_docuno" class="col-form-label">เลขที่</label>
                    <input type="text" class="form-control" 
                            name="ap_purchaseorder_hds_docuno" 
                            id="ap_purchaseorder_hds_docuno"
                            value="{{$hd->ap_purchaseorder_hds_docuno}}" 
                            readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="ap_vendor_lists_id" class="col-form-label">ผู้จำหน่าย</label>
                    <select class="form-control" name="ap_vendor_lists_id" id="ap_vendor_lists_id" disabled>
                        <option value="0">กรุณาเลือก</option>
                        @foreach ($vendors as $item)
                            <option value="{{$item->ap_vendor_lists_id}}"
                                data-code="{{ $item->ap_vendor_lists_code }}"
                                data-name="{{ $item->ap_vendor_lists_name1 }}"
                                data-address="{{ $item->ap_vendor_lists_address1 }}"
                                data-country="{{ $item->other_countries_id }}"
                                data-province="{{ $item->other_provinces_id }}"
                                data-district="{{ $item->other_districts_id }}"
                                data-subdistrict="{{ $item->other_sub_districts_id }}"
                                data-taxid="{{ $item->ap_vendor_lists_taxid }}"
                                data-credit="{{ $item->ap_vendor_lists_credit }}"
                                data-contact="{{ $item->ap_vendor_lists_contact }}"
                                data-tel="{{ $item->ap_vendor_lists_tel }}"
                                data-email="{{ $item->ap_vendor_lists_email }}"
                                {{ $item->ap_vendor_lists_id == $hd->ap_vendor_lists_id ? 'selected' : '' }}>
                                {{$item->ap_vendor_lists_name1}}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="ap_vendor_lists_code" id="ap_vendor_lists_code" value="{{$hd->ap_vendor_lists_code}}">
                    <input type="hidden" name="ap_vendor_lists_name" id="ap_vendor_lists_name" value="{{$hd->ap_vendor_lists_name}}">
                </div>
            </div>
        </div>
        <div class="row">    
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_vendor_lists_taxid" class="col-form-label">TAX ID</label>
                    <input class="form-control" name="ap_vendor_lists_taxid" id="ap_vendor_lists_taxid" value="{{$hd->ap_vendor_lists_taxid}}" readonly>
                </div>
            </div> 
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_vendor_lists_email" class="col-form-label">Email</label>
                    <input class="form-control" type="text" name="ap_vendor_lists_email" id="ap_vendor_lists_email" value="{{$hd->ap_vendor_lists_email}}" readonly>                   
                </div>
            </div>       
            <div class="col-6">
                <div class="form-group">
                    <label for="ap_vendor_lists_address" class="col-form-label">ที่อยู่</label>
                    <input class="form-control" name="ap_vendor_lists_address" id="ap_vendor_lists_address" value="{{$hd->ap_vendor_lists_address}}" readonly>
                </div>
            </div>           
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_vendor_lists_contact" class="col-form-label">ผู้ติดต่อ</label>
                    <input class="form-control" type="text" name="ap_vendor_lists_contact" id="ap_vendor_lists_contact" value="{{$hd->ap_vendor_lists_contact}}" readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_vendor_lists_tel" class="col-form-label">เบอร์โทร</label>
                    <input class="form-control" type="text" name="ap_vendor_lists_tel" id="ap_vendor_lists_tel" value="{{$hd->ap_vendor_lists_tel}}" readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_vendor_lists_credit" class="col-form-label">วันเครดิต</label>
                    <input class="form-control" type="text" name="ap_vendor_lists_credit" id="ap_vendor_lists_credit" value="{{$hd->ap_vendor_lists_credit}}" readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="acc_typevats_id" class="col-form-label">ประเภทภาษี</label>
                    <select class="form-select" name="acc_typevats_id" id="acc_typevats_id" disabled>
                        <option value="">กรุณาเลือก</option>
                        @foreach ($typevats as $item)
                            <option value="{{$item->acc_typevats_id}}"
                                {{ $item->acc_typevats_id == $hd->acc_typevats_id ? 'selected' : '' }}>
                                {{$item->acc_typevats_code}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="acc_currencies_id" class="col-form-label">สกุลเงิน</label>
                    <select class="form-select" name="acc_currencies_id" id="acc_currencies_id" disabled>
                        @foreach ($currencys as $item)
                            <option value="{{$item->acc_currencies_id}}"
                                {{ $item->acc_currencies_id == $hd->acc_currencies_id ? 'selected' : '' }}>
                                {{$item->acc_currencies_name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="acc_discount_id" class="col-form-label">ประเภทส่วนลด</label>
                    <select class="form-select" name="acc_discount_id" id="acc_discount_id" disabled>
                        @foreach ($discounts as $item)
                            <option value="{{$item->acc_discount_id}}"
                                {{$item->acc_discount_id == $hd->acc_discount_id ? 'selected' : '' }}>
                                {{$item->acc_discount_name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
             <div class="col-6">
                <div class="form-group">
                    <label for="ap_purchaseorder_hds_remark" class="col-form-label">หมายเหตุ</label>
                    <input class="form-control" type="text" name="ap_purchaseorder_hds_remark" id="ap_purchaseorder_hds_remark" value="{{$hd->ap_purchaseorder_hds_remark}}" readonly>
                </div>
             </div>
        </div>
        <br>
        <div class="row">
            <table class="table table-bordered dt-responsive nowrap w-100 text-center">
                <thead>
                    <tr>
                        <th style="width: 3%">#</th>
                        <th style="width: 30%">สินค้า</th>
                        <th style="width: 9%">จำนวน</th>
                        <th style="width: 9%">ราคาต่อหน่วย</th>
                        <th style="width: 9%">ส่วนลดต่อหน่วย</th>
                        <th style="width: 9%">ยอดรวม</th>
                        <th style="width: 8%">กำหนดส่ง</th>
                        <th style="width: 20%">หมายเหตุ</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach ($dt as $item)
                        <tr>
                            <td>
                                <span class="row-number">{{ $item->ap_purchaseorder_dts_listno }}</span>
                            </td>
                            <td>
                               {{$item->wh_product_lists_name}} ({{$item->ap_purchaserequest_hds_docuno}} จำนวน : {{number_format($item->ap_purchaserequest_dts_qty,2)}})
                            </td>
                            <td>{{number_format($item->ap_purchaseorder_dts_qty,2)}}</td>
                            <td>{{number_format($item->ap_purchaseorder_dts_price,2)}}</td>
                            <td>
                                {{number_format($item->acc_discount_qty,2)}}           
                            </td>
                            <td>{{number_format($item->ap_purchaseorder_dts_amount,2)}}</td>
                            <td>{{$item->ap_purchaseorder_dts_duedate}}</td>
                            <td>
                                {{$item->ap_purchaseorder_dts_remark}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>       
            </table>
        </div>
        <br>
        <div class="row">
            <div class="col-3">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">ฐานภาษี</p>
                        <h4 class="mb-0" id="sum-subtotal">{{number_format($hd->ap_purchaseorder_hds_base,2)}}</h4>
                        <input id="ap_purchaseorder_hds_base" name="ap_purchaseorder_hds_base" type="hidden" value="{{$hd->ap_purchaseorder_hds_base}}">
                    </div>
                    <div class="flex-shrink-0 align-self-center">
                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                            </span>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">ภาษี</p>
                        <h4 class="mb-0" id="sum-vat">{{number_format($hd->ap_purchaseorder_hds_vat,2)}}</h4>
                        <input id="ap_purchaseorder_hds_vat" name="ap_purchaseorder_hds_vat" type="hidden" value="{{$hd->ap_purchaseorder_hds_vat}}">
                    </div>
                    <div class="flex-shrink-0 align-self-center">
                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                            </span>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">ส่วนลด</p>
                        @if ($hd->ap_purchaseorder_hds_dis == 0)
                            <h4 class="mb-0" id="sum-discount">0.00</h4>
                            <input id="ap_purchaseorder_hds_dis" name="ap_purchaseorder_hds_dis" type="hidden" value="0">
                        @else
                            <h4 class="mb-0" id="sum-discount">{{number_format($hd->ap_purchaseorder_hds_dis,2)}}</h4>
                            <input id="ap_purchaseorder_hds_dis" name="ap_purchaseorder_hds_dis" type="hidden" value="{{$hd->ap_purchaseorder_hds_dis}}">
                        @endif                        
                    </div>
                    <div class="flex-shrink-0 align-self-center">
                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                            </span>
                    </div>
                    </div>
                </div>
            </div> 
            <div class="col-3">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">สุทธิ</p>
                        <h4 class="mb-0" id="sum-grandtotal">{{number_format($hd->ap_purchaseorder_hds_net,2)}}</h4>
                        <input id="ap_purchaseorder_hds_net" name="ap_purchaseorder_hds_net" type="hidden" value="{{$hd->ap_purchaseorder_hds_net}}">
                    </div>
                    <div class="flex-shrink-0 align-self-center">
                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                            </span>
                    </div>
                    </div>
                </div>
            </div>                      
        </div>
        <div class="row">
             <div class="col-12">
                <div class="form-group">
                    <label for="approved_remark" class="col-form-label">หมายเหตุอนุมัติ</label>
                    <textarea class="form-control" name="approved_remark">{{$hd->approved_remark}}</textarea>
                </div>
            </div>
        </div>
        <br>
            <div class="col-12 col-md-1">
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary">
                        บันทึก
                    </button>
                </div>
            </div>
        </form> 
    </div>
</div>
</div>
@endsection
@push('scriptjs')
<script>
$("#ap_vendor_lists_id").on("change", function () {
        let code = $(this).find(':selected').data('code');
        let name = $(this).find(':selected').data('name');
        let address = $(this).find(":selected").data("address");
        let country = $(this).find(":selected").data("country");
        let province = $(this).find(":selected").data("province");
        let district = $(this).find(":selected").data("district");
        let subdistrict = $(this).find(":selected").data("subdistrict");
        let credit = $(this).find(":selected").data("credit");
        let tel = $(this).find(":selected").data("tel");
        let email = $(this).find(":selected").data("email");
        let contact = $(this).find(":selected").data("contact");
        let taxid = $(this).find(":selected").data("taxid");

        $("#ap_vendor_lists_code").val(code);
        $("#ap_vendor_lists_name").val(name);
        $("#ap_vendor_lists_credit").val(credit);
        $("#ap_vendor_lists_tel").val(tel);
        $("#ap_vendor_lists_email").val(email);
        $("#ap_vendor_lists_contact").val(contact);
        $("#ap_vendor_lists_taxid").val(taxid);
        $.ajax({ 
            url: "{{ route('vendor.addressText') }}",
            type: "GET",
            data: {
                address_name: address,
                country_id: country,
                province_id: province,
                district_id: district,
                subdistrict_id: subdistrict
            },
            success: function(res) {
                $("#ap_vendor_lists_address").val(res.address);
            }
        });
    });
function updateRowNumbers() {
    const rows = document.querySelectorAll('#tableBody tr');
    rows.forEach((row, index) => {
        row.querySelector('.row-number').textContent = index + 1;
        row.querySelector('.row-number-hidden').value = index + 1;
    });
}
document.getElementById('addRowBtn').addEventListener('click', function () {
        const tbody = document.getElementById('tableBody');

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <span class="row-number"></span>
                <input type="hidden" name="ap_purchaseorder_dts_listno[]" class="row-number-hidden"/>
            </td>
            <td>
                <select class="form-control" name="ap_purchaserequest_dts_id[]">
                    <option value="0">กรุณาเลือก</option>
                    @foreach ($requests as $item)
                            <option value="{{$item->ap_purchaserequest_dts_id}}">{{$item->wh_product_lists_name}} ({{$item->ap_purchaserequest_hds_docuno}} จำนวน : {{$item->pr_total}})</option>
                    @endforeach
                </select>
               
            </td>
            <td><input type="text" name="ap_purchaseorder_dts_qty[]" class="form-control qty-input" value="0" disabled/></td>
            <td><input type="text" name="ap_purchaseorder_dts_price[]" class="form-control price-input" value="0" disabled/></td>
            <td><input type="text" name="acc_discount_qty[]" class="form-control dis-input" value="0" disabled/></td>
            <td><input type="text" name="ap_purchaseorder_dts_amount[]" class="form-control amount-input" value="0" readonly/></td>
            <td><input type="date" name="ap_purchaseorder_dts_duedate[]" class="form-control"/></td>
            <td>
                <input type="text" name="ap_purchaseorder_dts_remark[]" class="form-control"/>
                <input type="hidden" name="ap_purchaseorder_dts_base[]" class="form-control base-input"/>
                <input type="hidden" name="ap_purchaseorder_dts_vat[]" class="form-control vat-input"/>
                <input type="hidden" name="ap_purchaseorder_dts_net[]" class="form-control net-input"/>
                <input type="hidden" name="ap_purchaseorder_dts_dis[]" class="form-control distotal-input"/>
            </td>
            <td><button type="button" class="btn btn-danger btn-sm deleteRow">ลบ</button></td>
        `;

        tbody.appendChild(newRow);
        updateRowNumbers(); 
});
document.getElementById('tableBody').addEventListener('click', function (e) {
    if (e.target.classList.contains('deleteRow')) {
        e.target.closest('tr').remove();
        updateRowNumbers(); // อัปเดตลำดับหลังจากลบ
    }
});
 /* ===============================
   ตรวจสอบก่อนให้แก้ไข
================================ */
function canEditRow(row) {
    if (!$("#acc_typevats_id").val()) {
        Swal.fire('ข้อมูลไม่ครบ', 'กรุณาเลือกประเภทภาษี', 'warning');
        return false;
    }
    if (!$("#acc_currencies_id").val()) {
        Swal.fire('ข้อมูลไม่ครบ', 'กรุณาเลือกสกุลเงิน', 'warning');
        return false;
    }
    if (!$("#ap_vendor_lists_id").val()) {
        Swal.fire('ข้อมูลไม่ครบ', 'กรุณาเลือกผู้จำหน่าย', 'warning');
        return false;
    }
    return true;
}
/* ===============================
   เลือกสินค้า → เปิดช่อง
================================ */
$("#tableBody").on("change", "select[name='ap_purchaserequest_dts_id[]']", function () {
    let row = $(this).closest("tr");

    if (canEditRow(row)) {
        row.find(".qty-input, .price-input, .dis-input")
           .prop("disabled", false);
        calculateQuotation();
    }
});

/* ===============================
   กันคลิกก่อนเลือกครบ
================================ */
$("#tableBody").on("mousedown", ".qty-input, .price-input, .dis-input", function (e) {
    let row = $(this).closest("tr");
    if (!canEditRow(row)) {
        e.preventDefault();
        return false;
    }
});
/* ===============================
   คำนวณทั้งหมด
================================ */
function calculateQuotation() {
    let vatRate = $("#acc_typevats_id").val();
    if(vatRate == 4){
        let subtotal = 0;
        let rowDiscountTotal = 0;
        let subBase = 0;
        let subVat = 0;
        let disRate = $("#acc_discount_id").val();
        $("#tableBody tr").each(function () {
            let qty   = parseFloat($(this).find(".qty-input").val()) || 0;
            let price = parseFloat($(this).find(".price-input").val()) || 0;
            let dis   = parseFloat($(this).find(".dis-input").val()) || 0;
            if(disRate == 1){
                let disTotal =  dis;
                let rowTotal = (qty * price) -  disTotal;
                let rowVat = rowTotal * 0.07;
                let rowAmount = rowTotal + rowVat;
                if (rowAmount < 0) rowAmount = 0;

                // 👉 แสดงสุทธิต่อแถว
                $(this).find(".amount-input").val(rowAmount.toFixed(2));
                $(this).find(".base-input").val(rowTotal.toFixed(2));
                $(this).find(".vat-input").val(rowVat.toFixed(2));
                $(this).find(".net-input").val(rowAmount.toFixed(2));
                $(this).find(".distotal-input").val(disTotal.toFixed(2));
                subBase += rowTotal;
                subVat += rowVat;
                subtotal += rowAmount;
                rowDiscountTotal +=  disTotal;
            }else if(disRate == 2){
                let disTotal = ((qty * price) * dis) / 100
                let rowTotal = (qty * price) - disTotal;
                let rowVat = rowTotal * 0.07;
                let rowAmount = rowTotal + rowVat;
                if (rowAmount < 0) rowAmount = 0;

                // 👉 แสดงสุทธิต่อแถว
                $(this).find(".amount-input").val(rowAmount.toFixed(2));
                $(this).find(".base-input").val(rowTotal.toFixed(2));
                $(this).find(".vat-input").val(rowVat.toFixed(2));
                $(this).find(".net-input").val(rowAmount.toFixed(2));
                $(this).find(".distotal-input").val(disTotal.toFixed(2));
                subBase += rowTotal;
                subVat += rowVat;
                subtotal += rowAmount;
                rowDiscountTotal += disTotal;
            }          
        });
        // 👉 สรุปท้ายบิล
        $("#sum-subtotal").text(subBase.toFixed(2));
        $("#sum-discount").text((rowDiscountTotal).toFixed(2));
        $("#sum-vat").text(subVat.toFixed(2));
        $("#sum-grandtotal").text(subtotal.toFixed(2));
        $("#ap_purchaseorder_hds_base").val(subBase.toFixed(2));
        $("#ap_purchaseorder_hds_dis").val((rowDiscountTotal).toFixed(2));
        $("#ap_purchaseorder_hds_vat").val(subVat.toFixed(2));
        $("#ap_purchaseorder_hds_net").val(subtotal.toFixed(2));
    }else if(vatRate == 5){
        let subtotal = 0;
        let rowDiscountTotal = 0;
        let subBase = 0;
        let subVat = 0;
        let disRate = $("#acc_discount_id").val();
        $("#tableBody tr").each(function () {
            let qty   = parseFloat($(this).find(".qty-input").val()) || 0;
            let price = parseFloat($(this).find(".price-input").val()) || 0;
            let dis   = parseFloat($(this).find(".dis-input").val()) || 0;
            if(disRate == 1){
                let disTotal =  dis;
                let rowAmount= (qty * price) - disTotal;
                let rowVat = rowAmount * 0.07;
                let rowTotal = rowAmount - rowVat;
                if (rowAmount < 0) rowAmount = 0;

                // 👉 แสดงสุทธิต่อแถว
                $(this).find(".amount-input").val(rowAmount.toFixed(2));;
                $(this).find(".base-input").val(rowTotal.toFixed(2));
                $(this).find(".vat-input").val(rowVat.toFixed(2));
                $(this).find(".net-input").val(rowAmount.toFixed(2));
                $(this).find(".distotal-input").val(disTotal.toFixed(2));
                subBase += rowTotal;
                subVat += rowVat;
                subtotal += rowAmount;
                rowDiscountTotal += dis;
            }else if(disRate == 2){
                let disTotal = ((qty * price) * dis) / 100
                let rowAmount = (qty * price) - disTotal;
                let rowVat = rowAmount * 0.07;
                let rowTotal = rowAmount - rowVat;
                if (rowAmount < 0) rowAmount = 0;

                // 👉 แสดงสุทธิต่อแถว
                $(this).find(".amount-input").val(rowAmount.toFixed(2));
                $(this).find(".base-input").val(rowTotal.toFixed(2));
                $(this).find(".vat-input").val(rowVat.toFixed(2));
                $(this).find(".net-input").val(rowAmount.toFixed(2));
                $(this).find(".distotal-input").val(disTotal.toFixed(2));
                subBase += rowTotal;
                subVat += rowVat;
                subtotal += rowAmount;
                rowDiscountTotal += disTotal;
            }          
        });
        // 👉 สรุปท้ายบิล
        $("#sum-subtotal").text(subBase.toFixed(2));
        $("#sum-discount").text((rowDiscountTotal).toFixed(2));
        $("#sum-vat").text(subVat.toFixed(2));
        $("#sum-grandtotal").text(subtotal.toFixed(2));
        $("#ap_purchaseorder_hds_base").val(subBase.toFixed(2));
        $("#ap_purchaseorder_hds_dis").val((rowDiscountTotal).toFixed(2));
        $("#ap_purchaseorder_hds_vat").val(subVat.toFixed(2));
        $("#ap_purchaseorder_hds_net").val(subtotal.toFixed(2));
    }else if(vatRate == 6){
        let subtotal = 0;
        let rowDiscountTotal = 0;
        let subBase = 0;
        let subVat = 0;
        let disRate = $("#acc_discount_id").val();
        $("#tableBody tr").each(function () {
            let qty   = parseFloat($(this).find(".qty-input").val()) || 0;
            let price = parseFloat($(this).find(".price-input").val()) || 0;
            let dis   = parseFloat($(this).find(".dis-input").val()) || 0;
            if(disRate == 1){
                let disTotal =  dis;
                let rowAmount= (qty * price) - disTotal;
                let rowVat = 0;
                let rowTotal = (qty * price) - dis;
                if (rowAmount < 0) rowAmount = 0;

                // 👉 แสดงสุทธิต่อแถว
                $(this).find(".amount-input").val(rowAmount.toFixed(2));
                $(this).find(".base-input").val(rowTotal.toFixed(2));
                $(this).find(".vat-input").val(rowVat.toFixed(2));
                $(this).find(".net-input").val(rowAmount.toFixed(2));
                $(this).find(".distotal-input").val(disTotal.toFixed(2));
                subBase += rowTotal;
                subVat += rowVat;
                subtotal += rowAmount;
                rowDiscountTotal += dis;
            }else if(disRate == 2){
                let disTotal = ((qty * price) * dis) / 100
                let rowAmount = (qty * price) - disTotal;
                let rowVat = 0;
                let rowTotal = (qty * price) - disTotal;
                if (rowAmount < 0) rowAmount = 0;

                // 👉 แสดงสุทธิต่อแถว
                $(this).find(".amount-input").val(rowAmount.toFixed(2));
                $(this).find(".base-input").val(rowTotal.toFixed(2));
                $(this).find(".vat-input").val(rowVat.toFixed(2));
                $(this).find(".net-input").val(rowAmount.toFixed(2));
                $(this).find(".distotal-input").val(disTotal.toFixed(2));
                subBase += rowTotal;
                subVat += rowVat;
                subtotal += rowAmount;
                rowDiscountTotal += disTotal;
            }          
        });
        // 👉 สรุปท้ายบิล
        $("#sum-subtotal").text(subBase.toFixed(2));
        $("#sum-discount").text((rowDiscountTotal).toFixed(2));
        $("#sum-vat").text(subVat.toFixed(2));
        $("#sum-grandtotal").text(subtotal.toFixed(2));
        $("#ap_purchaseorder_hds_base").val(subBase.toFixed(2));
        $("#ap_purchaseorder_hds_dis").val((rowDiscountTotal).toFixed(2));
        $("#ap_purchaseorder_hds_vat").val(subVat.toFixed(2));
        $("#ap_purchaseorder_hds_net").val(subtotal.toFixed(2));
    }
  
}
/* ===============================
   คำนวณเมื่อพิมพ์
================================ */
$("#tableBody").on("input", ".qty-input, .price-input, .dis-input", function () {
    calculateQuotation();
});

$("#acc_discount_qty, #acc_typevats_id").on("change input", function () {
    calculateQuotation();
});

</script>
@endpush