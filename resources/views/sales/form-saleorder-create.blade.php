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
        <form method="POST" class="form-horizontal" action="{{ route('saleorders.store') }}" enctype="multipart/form-data">
        @csrf   
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">บิลขาย</h3></div>
        </div>    
         <div class="row mt-3">
             <div class="col-3">
                <div class="form-group">
                    <label for="ar_saleorder_hds_date" class="col-form-label">วันที่</label>
                   <input type="date" class="form-control" 
                            name="ar_saleorder_hds_date" 
                            id="ar_saleorder_hds_date"
                            value="{{ old('ar_saleorder_hds_date', now()->format('Y-m-d')) }}" 
                            required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_saleorder_hds_docuno" class="col-form-label">เลขที่</label>
                   <input type="text" class="form-control" 
                            name="ar_saleorder_hds_docuno" 
                            id="ar_saleorder_hds_docuno" 
                            readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_quotation_hds_id" class="col-form-label">ใบเสนอราคา</label>
                    <select class="form-control" name="ar_quotation_hds_id" id="ar_quotation_hds_id" required>
                        <option value="0">กรุณาเลือก</option>
                        @foreach ($quotation as $item)
                            <option value="{{$item->ar_quotation_hds_id}}"
                                data-code="{{ $item->ar_customer_lists_code }}"
                                data-name="{{ $item->ar_customer_lists_name }}"
                                data-address="{{ $item->ar_customer_lists_address }}"
                                data-credit="{{ $item->ar_customer_lists_credit }}"
                                data-tel="{{ $item->ar_customer_lists_tel }}"
                                data-email="{{ $item->ar_customer_lists_email }}"
                                data-contact="{{ $item->ar_customer_lists_contact }}"
                                data-taxid="{{ $item->ar_customer_lists_taxid }}"
                                data-vat="{{ $item->acc_typevats_id }}"
                                data-discount="{{ $item->acc_discount_id }}"
                                data-currencie="{{$item->acc_currencies_id}}">
                                {{$item->ar_quotation_hds_docuno}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="acc_typevats_id" class="col-form-label">ประเภทภาษี</label>
                    <select class="form-select" name="acc_typevats_id" id="acc_typevats_id" disabled>
                        <option value="">กรุณาเลือก</option>
                        @foreach ($typevats as $item)
                            <option value="{{$item->acc_typevats_id}}">{{$item->acc_typevats_code}}</option>
                        @endforeach
                    </select>
                </div> 
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-3">
                <div class="form-group">
                    <label for="acc_currencies_id" class="col-form-label">สกุลเงิน</label>
                    <select class="form-select" name="acc_currencies_id" id="acc_currencies_id" disabled>
                        @foreach ($currencys as $item)
                            <option value="{{$item->acc_currencies_id}}">{{$item->acc_currencies_name}}</option>
                        @endforeach
                    </select>
                </div> 
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="acc_discount_id" class="col-form-label">ประเภทส่วนลด</label>
                    <select class="form-select" name="acc_discount_id" id="acc_discount_id" disabled>
                        @foreach ($discounts as $item)
                            <option value="{{$item->acc_discount_id}}">{{$item->acc_discount_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="ar_customer_lists_name" class="col-form-label">ลูกค้า</label>
                    <input class="form-control" name="ar_customer_lists_name" id="ar_customer_lists_name" readonly>
                    <input class="form-control" name="ar_customer_lists_code" id="ar_customer_lists_code" type="hidden" readonly>
                </div>
            </div>
        </div> 
        <div class="row mt-3">
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_contact" class="col-form-label">ผู้ติดต่อ</label>
                    <input class="form-control" type="text" name="ar_customer_lists_contact" id="ar_customer_lists_contact" readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_tel" class="col-form-label">เบอร์โทร</label>
                    <input class="form-control" type="text" name="ar_customer_lists_tel" id="ar_customer_lists_tel" readonly>
                </div>
            </div>
              <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_email" class="col-form-label">Email</label>
                    <input class="form-control" type="text" name="ar_customer_lists_email" id="ar_customer_lists_email" readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_credit" class="col-form-label">วันเครดิต</label>
                    <input class="form-control" type="text" name="ar_customer_lists_credit" id="ar_customer_lists_credit" readonly>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_taxid" class="col-form-label">เลขประจำตัวผู้เสียภาษี</label>
                    <input class="form-control" type="text" name="ar_customer_lists_taxid" id="ar_customer_lists_taxid" readonly>
                </div> 
            </div>
            <div class="col-9">
                <div class="form-group">
                    <label for="ar_customer_lists_address" class="col-form-label">ที่อยู่</label>
                    <input class="form-control" type="text" name="ar_customer_lists_address" id="ar_customer_lists_address" readonly>
                </div>
            </div>
        </div>
        <div class="row mt-3">
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
                <tbody></tbody>       
            </table>
        </div>
        <div class="row mt-3">
            <div class="col-3">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">ฐานภาษี</p>
                        <h4 class="mb-0" id="sum-subtotal">0.00</h4>
                        <input id="ar_saleorder_hds_base" name="ar_saleorder_hds_base" type="hidden">
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
                        <input id="ar_saleorder_hds_vat" name="ar_saleorder_hds_vat" type="hidden">
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
                        <input id="ar_saleorder_hds_dis" name="ar_saleorder_hds_dis" type="hidden">
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
                        <input id="ar_saleorder_hds_net" name="ar_saleorder_hds_net" type="hidden">
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
        <div class="row mt-3">
            <div class="col-12">
                <label for="ar_saleorder_hds_remark" class="col-form-label">หมายเหตุ</label>
                <textarea class="form-control" name="ar_saleorder_hds_remark" id="ar_saleorder_hds_remark" ></textarea>
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
    let docDate = $("#ar_saleorder_hds_date").val();

    if (docDate) {
        $.ajax({
            url: "{{ route('saleorder.runno') }}",
            type: "GET",
            data: { date: docDate },
            success: function (res) {
                $("#ar_saleorder_hds_docuno").val(res.docno);
            }
        });
    }
}

// เปลี่ยนวันที่
$("#ar_saleorder_hds_date").on('change', function () {
    loadDocNo();
});

// โหลดตอนเปิดฟอร์ม
$(document).ready(function () {
    loadDocNo();
});
$("#ar_quotation_hds_id").on("change", function () {
        let code = $(this).find(':selected').data('code');
        let name = $(this).find(':selected').data('name');
        let address = $(this).find(":selected").data("address");
        let credit = $(this).find(":selected").data("credit");
        let tel = $(this).find(":selected").data("tel");
        let email = $(this).find(":selected").data("email");
        let contact = $(this).find(":selected").data("contact");
        let taxid = $(this).find(":selected").data("taxid");
        let vatId = $(this).find("option:selected").data("vat");
        let discountId = $(this).find("option:selected").data("discount");
        let currencieId = $(this).find("option:selected").data("currencie");
        $("#ar_customer_lists_code").val(code);
        $("#ar_customer_lists_name").val(name);
        $("#ar_customer_lists_credit").val(credit);
        $("#ar_customer_lists_tel").val(tel);
        $("#ar_customer_lists_email").val(email);
        $("#ar_customer_lists_contact").val(contact);
        $("#ar_customer_lists_taxid").val(taxid);
        $("#ar_customer_lists_address").val(address);
        if(vatId) {
            $("#acc_typevats_id").val(vatId).trigger("change");
        }else{
            $("#acc_typevats_id").val('');
        }
        if(discountId){
            $("#acc_discount_id").val(discountId).trigger("change");
        }else{
            $("#acc_discount_id").val('');
        }
        if(currencieId){
            $("#acc_currencies_id").val(currencieId).trigger("change");
        }else{
            $("#acc_currencies_id").val('');
        }
    });
</script>
@endpush