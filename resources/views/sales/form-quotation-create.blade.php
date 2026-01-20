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
        <form method="POST" class="form-horizontal" action="{{ route('quotations.store') }}" enctype="multipart/form-data">
        @csrf      
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">ใบเสนอราคา</h3></div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_quotation_hds_date" class="col-form-label">วันที่</label>
                   <input type="date" class="form-control" 
                            name="ar_quotation_hds_date" 
                            id="ar_quotation_hds_date"
                            value="{{ old('ar_quotation_hds_date', now()->format('Y-m-d')) }}" 
                            required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_quotation_hds_docuno" class="col-form-label">เลขที่</label>
                   <input type="text" class="form-control" 
                            name="ar_quotation_hds_docuno" 
                            id="ar_quotation_hds_docuno" 
                            readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="acc_typevats_id" class="col-form-label">ประเภทภาษี</label>
                    <select class="form-select" name="acc_typevats_id" id="acc_typevats_id" required>
                        <option value="">กรุณาเลือก</option>
                        @foreach ($typevats as $item)
                            <option value="{{$item->acc_typevats_id}}">{{$item->acc_typevats_code}}</option>
                        @endforeach
                    </select>
                </div> 
            </div>
             <div class="col-3">
                <div class="form-group">
                    <label for="acc_currencies_id" class="col-form-label">สกุลเงิน</label>
                    <select class="form-select" name="acc_currencies_id" id="acc_currencies_id" required>
                        @foreach ($currencys as $item)
                            <option value="{{$item->acc_currencies_id}}">{{$item->acc_currencies_name}}</option>
                        @endforeach
                    </select>
                </div> 
            </div>
        </div> 
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="ar_customer_lists_id" class="col-form-label">รหัสลูกค้า</label>
                    <select class="form-select" name="ar_customer_lists_id" id="ar_customer_lists_id" required>
                        <option value="">กรุณาเลือก</option>
                        @foreach ($customers as $item)
                            <option value="{{$item->ar_customer_lists_id}}"
                                data-code="{{ $item->ar_customer_lists_code }}"
                                data-name="{{ $item->ar_customer_lists_name1 }}"
                                data-address="{{ $item->ar_customer_lists_address1 }}"
                                data-country="{{ $item->other_countries_id }}"
                                data-province="{{ $item->other_provinces_id }}"
                                data-district="{{ $item->other_districts_id }}"
                                data-subdistrict="{{ $item->other_sub_districts_id }}"
                                data-contact="{{ $item->ar_customer_lists_contact }}"
                                data-tel="{{ $item->ar_customer_lists_tel }}"
                                data-email="{{ $item->ar_customer_lists_email }}"
                                data-credit="{{ $item->ar_customer_lists_credit }}"
                                data-taxid="{{ $item->ar_customer_lists_taxid }}">                             
                                {{$item->ar_customer_lists_code}}/{{$item->ar_customer_lists_name1}}
                            </option>
                        @endforeach
                    </select>
                    <input class="form-control" type="hidden" name="ar_customer_lists_code" id="ar_customer_lists_code">
                    <input class="form-control" type="hidden" name="ar_customer_lists_name" id="ar_customer_lists_name">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_contact" class="col-form-label">ผู้ติดต่อ</label>
                    <input class="form-control" type="text" name="ar_customer_lists_contact" id="ar_customer_lists_contact">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_tel" class="col-form-label">เบอร์โทร</label>
                    <input class="form-control" type="text" name="ar_customer_lists_tel" id="ar_customer_lists_tel">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="ar_customer_lists_address" class="col-form-label">ที่อยู่</label>
                    <input class="form-control" type="text" name="ar_customer_lists_address" id="ar_customer_lists_address">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_email" class="col-form-label">Email</label>
                    <input class="form-control" type="text" name="ar_customer_lists_email" id="ar_customer_lists_email">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_credit" class="col-form-label">วันเครดิต</label>
                    <input class="form-control" type="text" name="ar_customer_lists_credit" id="ar_customer_lists_credit">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_taxid" class="col-form-label">เลขประจำตัวผู้เสียภาษี</label>
                    <input class="form-control" type="text" name="ar_customer_lists_taxid" id="ar_customer_lists_taxid">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="acc_discount_id" class="col-form-label">ประเภทส่วนลด</label>
                    <select class="form-select" name="acc_discount_id" id="acc_discount_id" required>
                        @foreach ($discounts as $item)
                            <option value="{{$item->acc_discount_id}}">{{$item->acc_discount_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>  
        <br>
        <div class="row">
            <div class="col-12" style="text-align: right;">
                <a href="javascript:void(0);" class="btn btn-secondary" id="addRowBtn">เพิ่มรายการ</a>
            </div>
            <hr>
            <table class="table table-bordered dt-responsive nowrap w-100 text-center">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 30%">สินค้า</th>
                        <th style="width: 10%">จำนวน</th>
                        <th style="width: 10%">ราคาต่อหน่วย</th>
                        <th style="width: 10%">ส่วนลด</th>
                        <th style="width: 10%">ยอดรวม</th>
                        <th style="width: 30%">หมายเหตุ</th>
                        <th style="width: 5%"></th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>       
            </table>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">ฐานภาษี</p>
                        <h4 class="mb-0" id="sum-subtotal">0.00</h4>
                        <input id="ar_quotation_hds_base" name="ar_quotation_hds_base" type="hidden">
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
                        <h4 class="mb-0" id="sum-vat">0.00</h4>
                        <input id="ar_quotation_hds_vat" name="ar_quotation_hds_vat" type="hidden">
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
                        <h4 class="mb-0" id="sum-discount">0.00</h4>
                        <input id="ar_quotation_hds_dis" name="ar_quotation_hds_dis" type="hidden">
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
                        <h4 class="mb-0" id="sum-grandtotal">0.00</h4>
                        <input id="ar_quotation_hds_net" name="ar_quotation_hds_net" type="hidden">
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
                <label for="ar_quotation_hds_remark" class="col-form-label">หมายเหตุ</label>
                <textarea class="form-control" name="ar_quotation_hds_remark" id="ar_quotation_hds_remark" ></textarea>
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
    function loadDocNo() {
        let docDate = $("#ar_quotation_hds_date").val();

        if (docDate) {
            $.ajax({
                url: "{{ route('quotation.runno') }}",
                type: "GET",
                data: { date: docDate },
                success: function (res) {
                    $("#ar_quotation_hds_docuno").val(res.docno);
                }
            });
        }
    }

    // ✔ ทำงานเมื่อผู้ใช้เปลี่ยนวันที่
    $("#ar_quotation_hds_date").on('change', function () {
        loadDocNo();
    });

    // ✔ ทำงานทันทีเมื่อเปิดฟอร์ม
    $(document).ready(function () {
        loadDocNo();
    });
$("#ar_customer_lists_id").on("change", function () {
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

        $("#ar_customer_lists_code").val(code);
        $("#ar_customer_lists_name").val(name);
        $("#ar_customer_lists_credit").val(credit);
        $("#ar_customer_lists_tel").val(tel);
        $("#ar_customer_lists_email").val(email);
        $("#ar_customer_lists_contact").val(contact);
        $("#ar_customer_lists_taxid").val(taxid);
        $.ajax({ 
            url: "{{ route('customer.addressText') }}",
            type: "GET",
            data: {
                address_name: address,
                country_id: country,
                province_id: province,
                district_id: district,
                subdistrict_id: subdistrict
            },
            success: function(res) {
                $("#ar_customer_lists_address").val(res.address);
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
                <input type="hidden" name="ar_quotation_dts_listno[]" class="row-number-hidden"/>
            </td>
            <td>
                <select class="form-control" name="wh_product_lists_id[]">
                    <option value="0">กรุณาเลือก</option>
                    @foreach ($products as $item)
                            <option value="{{$item->wh_product_lists_id}}">{{$item->wh_product_lists_name1}}</option>
                    @endforeach
                </select>
               
            </td>
            <td><input type="text" name="ar_quotation_dts_qty[]" class="form-control qty-input" value="0" disabled/></td>
            <td><input type="text" name="ar_quotation_dts_price[]" class="form-control price-input" value="0" disabled/></td>
            <td><input type="text" name="acc_discount_qty[]" class="form-control dis-input" value="0" disabled/></td>
            <td><input type="text" name="ar_quotation_dts_amount[]" class="form-control amount-input"" value="0" readonly/></td>
            <td>
                <input type="text" name="ar_quotation_dts_remark[]" class="form-control"/>
                <input type="hidden" name="ar_quotation_dts_base[]" class="form-control base-input"/>
                <input type="hidden" name="ar_quotation_dts_vat[]" class="form-control vat-input"/>
                <input type="hidden" name="ar_quotation_dts_net[]" class="form-control net-input"/>
                <input type="hidden" name="ar_quotation_dts_dis[]" class="form-control distotal-input"/>
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
    if (!$("#ar_customer_lists_id").val()) {
        Swal.fire('ข้อมูลไม่ครบ', 'กรุณาเลือกลูกค้า', 'warning');
        return false;
    }
    if (!row.find("select[name='wh_product_lists_id[]']").val() ||
        row.find("select[name='wh_product_lists_id[]']").val() == 0) {
        Swal.fire('ข้อมูลไม่ครบ', 'กรุณาเลือกสินค้า', 'warning');
        return false;
    }
    return true;
}

/* ===============================
   คำนวณทั้งหมด
================================ */
function calculateQuotation() {
    let vatRate = $("#acc_typevats_id").val();
    if(vatRate == 1){
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
        $("#ar_quotation_hds_base").val(subBase.toFixed(2));
        $("#ar_quotation_hds_dis").val((rowDiscountTotal).toFixed(2));
        $("#ar_quotation_hds_vat").val(subVat.toFixed(2));
        $("#ar_quotation_hds_net").val(subtotal.toFixed(2));
    }else if(vatRate == 2){
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
    }else if(vatRate == 3){
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
    }
  
}

/* ===============================
   เลือกสินค้า → เปิดช่อง
================================ */
$("#tableBody").on("change", "select[name='wh_product_lists_id[]']", function () {
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