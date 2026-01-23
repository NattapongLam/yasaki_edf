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
        <form method="POST" class="form-horizontal" action="{{ route('invoices.update',$hd->ar_invoice_hds_id) }}" enctype="multipart/form-data">
        @csrf 
        @method('PUT')
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">ใบแจ้งหนี้</h3></div>          
        </div>       
        <div class="row mt-3">
             <div class="col-3">
                <div class="form-group">
                    <label for="ar_invoice_hds_date" class="col-form-label">วันที่</label>
                   <input type="date" class="form-control" 
                            name="ar_invoice_hds_date" 
                            id="ar_invoice_hds_date"
                            value="{{$hd->ar_invoice_hds_date}}" 
                            required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_invoice_hds_docuno" class="col-form-label">เลขที่</label>
                   <input type="text" class="form-control" 
                            name="ar_invoice_hds_docuno" 
                            id="ar_invoice_hds_docuno" 
                            value="{{$hd->ar_invoice_hds_docuno}}"
                            readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="ar_quotation_hds_id" class="col-form-label">ใบเสนอราคา</label>
                    <select class="form-control" name="ar_quotation_hds_id" id="ar_quotation_hds_id" required>
                        <option value="0">กรุณาเลือก</option>
                        @foreach ($quotation as $item)
                            <option value="{{$item->ar_quotation_hds_id}}" {{ $item->ar_quotation_hds_id == $hd->ar_quotation_hds_id ? 'selected' : '' }}>
                                {{$item->ar_quotation_hds_docuno}} ลูกค้า : {{$item->ar_customer_lists_name}} ยอดเงิน : {{number_format($item->ar_quotation_hds_amount,2)}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_invoice_hds_percent" class="col-form-label">เปอร์เซ็นออกใบแจ้งหนี้</label>
                    <input type="number" class="form-control" name="ar_invoice_hds_percent" id="ar_invoice_hds_percent" value="{{$hd->ar_invoice_hds_percent}}" required>
                </div>
            </div>
            <div class="col-9">
                <div class="form-group">
                    <label for="ar_invoice_hds_remark" class="col-form-label">หมายเหตุ</label>
                    <input type="text" class="form-control" name="ar_invoice_hds_remark" id="ar_invoice_hds_remark" value="{{$hd->ar_invoice_hds_remark}}">
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <table class="table table-bordered dt-responsive nowrap w-100 text-center">
                <thead>
                    <tr>
                        <th style="width: 3%">#</th>
                        <th style="width: 20%">สินค้า</th>
                        <th style="width: 8%">จำนวน</th>
                        <th style="width: 10%">ราคาต่อหน่วย</th>
                        <th style="width: 10%">ส่วนลด</th>
                        <th style="width: 10%">ยอดรวม</th>
                        <th style="width: 30%">หมายเหตุ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dt as $item)
                        <tr>
                            <td>{{$item->ar_invoice_dts_listno}}</td>
                            <td>{{$item->wh_product_lists_name}}</td>
                            <td>{{number_format($item->ar_invoice_dts_qty,2)}}</td>
                            <td>{{number_format($item->ar_invoice_dts_price,2)}}</td>
                            <td>{{number_format($item->ar_invoice_dts_discount,2)}}</td>
                            <td>{{number_format($item->ar_invoice_dts_amount,2)}}</td>
                            <td>
                                <textarea class="form-control" name="ar_invoice_dts_remark[]">{{$item->ar_invoice_dts_remark}}</textarea>
                                <input type="hidden" name="ar_invoice_dts_id[]" value="{{$item->ar_invoice_dts_id}}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row mt-3">
            <div class="col-4">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">ฐานภาษี</p>
                        <h4 class="mb-0" id="sum-subtotal">{{number_format($hd->ar_invoice_hds_base,2)}}</h4>
                        <input id="ar_invoice_hds_base" name="ar_invoice_hds_base" type="hidden" value="{{$hd->ar_invoice_hds_base}}">
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
            <div class="col-4">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">ภาษี</p>
                        <h4 class="mb-0" id="sum-vat">{{number_format($hd->ar_invoice_hds_vat,2)}}</h4>
                        <input id="ar_invoice_hds_vat" name="ar_invoice_hds_vat" type="hidden" value="{{$hd->ar_invoice_hds_vat}}">
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
            <div class="col-4">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">สุทธิ</p>
                        <h4 class="mb-0" id="sum-grandtotal">{{number_format($hd->ar_invoice_hds_net,2)}}</h4>
                        <input id="ar_invoice_hds_net" name="ar_invoice_hds_net" type="hidden" value="{{$hd->ar_invoice_hds_net}}">
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
let quotationฺBase = 0;
let quotationฺVat = 0;
let quotationฺNet = 0;
// เลือกใบเสนอราคา
$('#ar_quotation_hds_id').change(function () {
    let quotationId = $(this).val();
    $('#quotation-items').html('');

    if (quotationId == 0) return;

    $.ajax({
        url: "{{ route('quotation.items') }}",
        type: "GET",
        data: { id: quotationId },
        success: function (res) {
            let rows = '';
            quotationฺBase = 0;
            quotationฺVat = 0;
            quotationฺNet = 0;
            $.each(res, function (index, item) {
                quotationฺBase += parseFloat(item.ar_quotation_dts_base);
                quotationฺVat += parseFloat(item.ar_quotation_dts_vat);
                quotationฺNet += parseFloat(item.ar_quotation_dts_net);
                rows += `
                    <tr>
                        <td>${item.ar_quotation_dts_listno}</td>
                        <td>${item.wh_product_lists_name}</td>
                        <td>${item.ar_quotation_dts_qty}</td>
                        <td>${parseFloat(item.ar_quotation_dts_price).toFixed(2)}</td>
                        <td>${parseFloat(item.ar_quotation_dts_dis).toFixed(2)}</td>
                        <td>${parseFloat(item.ar_quotation_dts_amount).toFixed(2)}</td>
                        <td>
                            <textarea class="form-control" name="ar_invoice_dts_remark[]"></textarea>
                            <input type="hidden" name="ar_quotation_dts_listno[]" value="${item.ar_quotation_dts_listno}">
                            <input type="hidden" name="wh_product_lists_id[]" value="${item.wh_product_lists_id}">
                            <input type="hidden" name="wh_product_lists_code[]" value="${item.wh_product_lists_code}">
                            <input type="hidden" name="wh_product_lists_name[]" value="${item.wh_product_lists_name}">
                            <input type="hidden" name="wh_product_lists_unit[]" value="${item.wh_product_lists_unit}">
                        </td>
                      
                    </tr>
                `;
            });

            $('#quotation-items').html(rows);
            calculateInvoice(); 
        }
    });
});

function calculateInvoice() {
    let percent = parseFloat($('#ar_invoice_hds_percent').val()) || 0;

    let base = quotationฺBase * (percent / 100);
    let vat = quotationฺVat * (percent / 100);
    let net = quotationฺNet * (percent / 100);

    $('#sum-subtotal').text(base.toFixed(2));
    $('#sum-vat').text(vat.toFixed(2));
    $('#sum-grandtotal').text(net.toFixed(2));

    $('#ar_invoice_hds_base').val(base.toFixed(2));
    $('#ar_invoice_hds_vat').val(vat.toFixed(2));
    $('#ar_invoice_hds_net').val(net.toFixed(2));
}
$('#ar_invoice_hds_percent').on('input', function () {
    calculateInvoice();
});
</script>
@endpush