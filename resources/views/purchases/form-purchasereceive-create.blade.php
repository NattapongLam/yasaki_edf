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
        <form method="POST" class="form-horizontal" action="{{ route('purchasereceives.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">รับสินค้า</h3></div>
        </div>  
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_purchase_receive_hds_date" class="col-form-label">วันที่</label>
                   <input type="date" class="form-control" 
                            name="ap_purchase_receive_hds_date" 
                            id="ap_purchase_receive_hds_date"
                            value="{{ old('ap_purchase_receive_hds_date', now()->format('Y-m-d')) }}" 
                            required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_purchase_receive_hds_docuno" class="col-form-label">เลขที่</label>
                    <input type="text" class="form-control" 
                            name="ap_purchase_receive_hds_docuno" 
                            id="ap_purchase_receive_hds_docuno" 
                            readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="ap_purchaseorder_hds_id" class="col-form-label">เลขที่ PO</label>
                    <select class="form-control" name="ap_purchaseorder_hds_id" id="ap_purchaseorder_hds_id">
                        <option value="0">กรุณาเลือก</option>
                        @foreach ($purchaseorders as $item)
                            <option value="{{$item->ap_purchaseorder_hds_id}}"
                                data-vat="{{ $item->acc_typevats_id }}"
                                data-dis="{{ $item->acc_discount_id }}">
                                {{$item->ap_purchaseorder_hds_docuno}} (ผู้จำหน่าย : {{$item->ap_vendor_lists_name}})
                            </option>
                        @endforeach
                    </select>
                    <input name="acc_typevats_id" id="acc_typevats_id" type="hidden">
                    <input name="acc_discount_id" id="acc_discount_id" type="hidden">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="wh_warehouses_id" class="col-form-label">คลังสินค้า</label>
                    <select class="form-select" name="wh_warehouses_id" id="wh_warehouses_id" required>
                        <option value="">กรุณาเลือก</option>
                        @foreach ($warehouses as $item)
                            <option value="{{$item->wh_warehouses_id}}">{{$item->wh_warehouses_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-9">
                <div class="form-group">
                    <label for="ap_purchase_receive_hds_remark" class="col-form-label">หมายเหตุ</label>
                    <input class="form-control" name="ap_purchase_receive_hds_remark">
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <table class="table table-bordered dt-responsive nowrap w-100 text-center">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 30%">สินค้า</th>
                        <th style="width: 8%">จำนวนสั่งซื้อ</th>
                        <th style="width: 10%">ราคาต่อหน่วย</th>
                        <th style="width: 8%">ส่วนลดต่อหน่วย</th>
                        <th style="width: 8%">จำนวนรับ</th>
                        <th style="width: 10%">ยอดรวม</th>
                        <th style="width: 20%">หมายเหตุ</th>
                        <th style="width: 5%"></th>
                    </tr>
                </thead>
                <tbody id="purchase-items"></tbody>
            </table>
        </div> 
        <br>
        <div class="row">
            <div class="col-3">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">ฐานภาษี</p>
                        <h4 class="mb-0" id="sum-subtotal">0.00</h4>
                        <input id="ap_purchase_receive_hds_base" name="ap_purchase_receive_hds_base" type="hidden">
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
                        <input id="ap_purchase_receive_hds_vat" name="ap_purchase_receive_hds_vat" type="hidden">
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
                        <input id="ap_purchase_receive_hds_dis" name="ap_purchase_receive_hds_dis" type="hidden">
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
                        <input id="ap_purchase_receive_hds_net" name="ap_purchase_receive_hds_net" type="hidden">
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
    let docDate = $("#ap_purchase_receive_hds_date").val();
        if (docDate) {
            $.ajax({
                url: "{{ route('purchasereceive.runno') }}",
                type: "GET",
                data: { date: docDate },
                success: function (res) {
                    $("#ap_purchase_receive_hds_docuno").val(res.docno);
                }
            });
        }
    }
    // ✔ ทำงานเมื่อผู้ใช้เปลี่ยนวันที่
    $("#ap_purchase_receive_hds_date").on('change', function () {
        loadDocNo();
    });
    // ✔ ทำงานทันทีเมื่อเปิดฟอร์ม
    $(document).ready(function () {
        loadDocNo();
});
$('#ap_purchaseorder_hds_id').change(function () {
    let purchaseId = $(this).val();
    $('#purchase-items').html('');

    if (purchaseId == 0) return;

    $.ajax({
        url: "{{ route('purchase.items') }}",
        type: "GET",
        data: { id: purchaseId },
        success: function (res) {
            let rows = '';

            $.each(res, function (index, item) {
                rows += `
                    <tr>
                        <td>
                            ${item.ap_purchaseorder_dts_listno}
                            <input type="hidden" name="ap_purchaseorder_dts_id[]" value="${item.ap_purchaseorder_dts_id}"/>
                            <input type="hidden" name="ap_purchase_receive_dts_listno[]" value="${item.ap_purchaseorder_dts_listno}"/>
                        </td>
                        <td>
                            ${item.wh_product_lists_name}
                            <input type="hidden" name="wh_product_lists_id[]" value="${item.wh_product_lists_id}"/>
                            <input type="hidden" name="wh_product_lists_code[]" value="${item.wh_product_lists_code}"/>
                            <input type="hidden" name="wh_product_lists_name[]" value="${item.wh_product_lists_name}"/>
                            <input type="hidden" name="wh_product_lists_unit[]" value="${item.wh_product_lists_unit}"/>
                        </td>
                        <td>
                            ${item.ap_purchaseorder_dts_qty}
                            <input type="hidden" name="ms_allocate_id[]" value="${item.ms_allocate_id}"/>
                            <input type="hidden" name="ap_purchaseorder_hds_docuno[]" value="${item.ap_purchaseorder_hds_docuno}"/>
                            <input type="hidden" name="ap_purchaseorder_dts_qty[]" value="${item.ap_purchaseorder_dts_qty}"/>
                        </td>
                        <td>                          
                            <input class="form-control price-input" name="ap_purchase_receive_dts_price[]" id="ap_purchase_receive_dts_price" value=" ${parseFloat(item.ap_purchaseorder_dts_price).toFixed(2)}" readonly>
                        </td>
                        <td>
                            <input class="form-control dis-input" name="acc_discount_qty[]" id="acc_discount_qty" value="${parseFloat(item.acc_discount_qty).toFixed(2)}" readonly>
                        </td>
                        <td>
                            <input class="form-control qty-input" name="ap_purchase_receive_dts_qty[]" id="ap_purchase_receive_dts_qty">
                        </td>
                        <td>
                            <input class="form-control amount-input" name="ap_purchase_receive_dts_amount[]" id="ap_purchase_receive_dts_amount" readonly>
                            <input type="hidden" name="ap_purchase_receive_dts_base[]" class="form-control base-input"/>
                            <input type="hidden" name="ap_purchase_receive_dts_vat[]" class="form-control vat-input"/>
                            <input type="hidden" name="ap_purchase_receive_dts_net[]" class="form-control net-input"/>
                            <input type="hidden" name="ap_purchase_receive_dts_dis[]" class="form-control distotal-input"/>
                        </td>
                        <td>
                            <input class="form-control" name="ap_purchase_receive_dts_remark[]" id="ap_purchase_receive_dts_remark">
                        </td>
                        <td class="text-center">
                            <button type="button" 
                                class="btn btn-sm btn-danger btn-remove-row">
                                ลบ
                            </button>
                        </td>
                    </tr>
                `;
            });

            // ⭐ ตรงนี้สำคัญ
            $('#purchase-items').html(rows);
        }
    });
});
$(document).on('click', '.btn-remove-row', function () {
    if (!confirm('ต้องการลบรายการนี้ใช่หรือไม่ ?')) return;

    $(this).closest('tr').remove();
});
$("#ap_purchaseorder_hds_id").on("change", function () {
    let vat = $(this).find(':selected').data('vat');
    let dis = $(this).find(':selected').data('dis');

    $("#acc_typevats_id").val(vat);
    $("#acc_discount_id").val(dis);
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
        $("#purchase-items tr").each(function () {
            let qty   = parseFloat($(this).find(".qty-input").val()) || 0;
            let price = parseFloat($(this).find(".price-input").val()) || 0;
            let dis   = parseFloat($(this).find(".dis-input").val()) || 0;
            if(disRate == 1){
                let disTotal =  dis;
                let disTotal1 =  qty * disTotal;
                let rowTotal = (qty * (price - disTotal));
                let rowVat = rowTotal * 0.07;
                let rowAmount = rowTotal + rowVat;
                if (rowAmount < 0) rowAmount = 0;

                // 👉 แสดงสุทธิต่อแถว
                $(this).find(".amount-input").val(rowAmount.toFixed(2));
                $(this).find(".base-input").val(rowTotal.toFixed(2));
                $(this).find(".vat-input").val(rowVat.toFixed(2));
                $(this).find(".net-input").val(rowAmount.toFixed(2));
                $(this).find(".distotal-input").val(disTotal1.toFixed(2));
                subBase += rowTotal;
                subVat += rowVat;
                subtotal += rowAmount;
                rowDiscountTotal +=  disTotal1;
            }else if(disRate == 2){
                let disTotal = (price * dis) / 100
                let disTotal1 =  qty * disTotal;
                let rowTotal = (qty * (price - disTotal));
                let rowVat = rowTotal * 0.07;
                let rowAmount = rowTotal + rowVat;
                if (rowAmount < 0) rowAmount = 0;

                // 👉 แสดงสุทธิต่อแถว
                $(this).find(".amount-input").val(rowAmount.toFixed(2));
                $(this).find(".base-input").val(rowTotal.toFixed(2));
                $(this).find(".vat-input").val(rowVat.toFixed(2));
                $(this).find(".net-input").val(rowAmount.toFixed(2));
                $(this).find(".distotal-input").val(disTotal1.toFixed(2));
                subBase += rowTotal;
                subVat += rowVat;
                subtotal += rowAmount;
                rowDiscountTotal += disTotal1;
            }          
        });
        // 👉 สรุปท้ายบิล
        $("#sum-subtotal").text(subBase.toFixed(2));
        $("#sum-discount").text((rowDiscountTotal).toFixed(2));
        $("#sum-vat").text(subVat.toFixed(2));
        $("#sum-grandtotal").text(subtotal.toFixed(2));
        $("#ap_purchase_receive_hds_base").val(subBase.toFixed(2));
        $("#ap_purchase_receive_hds_dis").val((rowDiscountTotal).toFixed(2));
        $("#ap_purchase_receive_hds_vat").val(subVat.toFixed(2));
        $("#ap_purchase_receive_hds_net").val(subtotal.toFixed(2));
    }else if(vatRate == 5){
        let subtotal = 0;
        let rowDiscountTotal = 0;
        let subBase = 0;
        let subVat = 0;
        let disRate = $("#acc_discount_id").val();
        $("#purchase-items tr").each(function () {
            let qty   = parseFloat($(this).find(".qty-input").val()) || 0;
            let price = parseFloat($(this).find(".price-input").val()) || 0;
            let dis   = parseFloat($(this).find(".dis-input").val()) || 0;
            if(disRate == 1){
                let disTotal =  dis;
                let disTotal1 =  qty * disTotal;
                let rowAmount= (qty * (price - disTotal));
                let rowVat = rowAmount * 0.07;
                let rowTotal = rowAmount - rowVat;
                if (rowAmount < 0) rowAmount = 0;

                // 👉 แสดงสุทธิต่อแถว
                $(this).find(".amount-input").val(rowAmount.toFixed(2));;
                $(this).find(".base-input").val(rowTotal.toFixed(2));
                $(this).find(".vat-input").val(rowVat.toFixed(2));
                $(this).find(".net-input").val(rowAmount.toFixed(2));
                $(this).find(".distotal-input").val(disTotal1.toFixed(2));
                subBase += rowTotal;
                subVat += rowVat;
                subtotal += rowAmount;
                rowDiscountTotal += disTotal1;
            }else if(disRate == 2){
                let disTotal = (price * dis) / 100
                let disTotal1 =  qty * disTotal;
                let rowAmount = (qty * (price - disTotal));
                let rowVat = rowAmount * 0.07;
                let rowTotal = rowAmount - rowVat;
                if (rowAmount < 0) rowAmount = 0;

                // 👉 แสดงสุทธิต่อแถว
                $(this).find(".amount-input").val(rowAmount.toFixed(2));
                $(this).find(".base-input").val(rowTotal.toFixed(2));
                $(this).find(".vat-input").val(rowVat.toFixed(2));
                $(this).find(".net-input").val(rowAmount.toFixed(2));
                $(this).find(".distotal-input").val(disTotal1.toFixed(2));
                subBase += rowTotal;
                subVat += rowVat;
                subtotal += rowAmount;
                rowDiscountTotal += disTotal1;
            }          
        });
        // 👉 สรุปท้ายบิล
        $("#sum-subtotal").text(subBase.toFixed(2));
        $("#sum-discount").text((rowDiscountTotal).toFixed(2));
        $("#sum-vat").text(subVat.toFixed(2));
        $("#sum-grandtotal").text(subtotal.toFixed(2));
        $("#ap_purchase_receive_hds_base").val(subBase.toFixed(2));
        $("#ap_purchase_receive_hds_dis").val((rowDiscountTotal).toFixed(2));
        $("#ap_purchase_receive_hds_vat").val(subVat.toFixed(2));
        $("#ap_purchase_receive_hds_net").val(subtotal.toFixed(2));
    }else if(vatRate == 6){
        let subtotal = 0;
        let rowDiscountTotal = 0;
        let subBase = 0;
        let subVat = 0;
        let disRate = $("#acc_discount_id").val();
        $("#purchase-items tr").each(function () {
            let qty   = parseFloat($(this).find(".qty-input").val()) || 0;
            let price = parseFloat($(this).find(".price-input").val()) || 0;
            let dis   = parseFloat($(this).find(".dis-input").val()) || 0;
            if(disRate == 1){
                let disTotal =  dis;
                let disTotal1 =  qty * disTotal;
                let rowAmount= (qty * (price - disTotal));
                let rowVat = 0;
                let rowTotal = (qty * price) - dis;
                if (rowAmount < 0) rowAmount = 0;

                // 👉 แสดงสุทธิต่อแถว
                $(this).find(".amount-input").val(rowAmount.toFixed(2));
                $(this).find(".base-input").val(rowTotal.toFixed(2));
                $(this).find(".vat-input").val(rowVat.toFixed(2));
                $(this).find(".net-input").val(rowAmount.toFixed(2));
                $(this).find(".distotal-input").val(disTotal1.toFixed(2));
                subBase += rowTotal;
                subVat += rowVat;
                subtotal += rowAmount;
                rowDiscountTotal += disTotal1;
            }else if(disRate == 2){
                let disTotal = (price * dis) / 100
                let disTotal1 =  qty * disTotal;
                let rowAmount = (qty * (price - disTotal));
                let rowVat = 0;
                let rowTotal = (qty * price) - disTotal;
                if (rowAmount < 0) rowAmount = 0;

                // 👉 แสดงสุทธิต่อแถว
                $(this).find(".amount-input").val(rowAmount.toFixed(2));
                $(this).find(".base-input").val(rowTotal.toFixed(2));
                $(this).find(".vat-input").val(rowVat.toFixed(2));
                $(this).find(".net-input").val(rowAmount.toFixed(2));
                $(this).find(".distotal-input").val(disTotal1.toFixed(2));
                subBase += rowTotal;
                subVat += rowVat;
                subtotal += rowAmount;
                rowDiscountTotal += disTotal1;
            }          
        });
        // 👉 สรุปท้ายบิล
        $("#sum-subtotal").text(subBase.toFixed(2));
        $("#sum-discount").text((rowDiscountTotal).toFixed(2));
        $("#sum-vat").text(subVat.toFixed(2));
        $("#sum-grandtotal").text(subtotal.toFixed(2));
        $("#ap_purchase_receive_hds_base").val(subBase.toFixed(2));
        $("#ap_purchase_receive_hds_dis").val((rowDiscountTotal).toFixed(2));
        $("#ap_purchase_receive_hds_vat").val(subVat.toFixed(2));
        $("#ap_purchase_receive_hds_net").val(subtotal.toFixed(2));
    }
  
}
/* ===============================
   คำนวณเมื่อพิมพ์
================================ */
$("#purchase-items").on("input", ".qty-input, .price-input, .dis-input", function () {
    calculateQuotation();
});
</script>
@endpush