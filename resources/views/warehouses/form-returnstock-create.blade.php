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
        <form method="POST" class="form-horizontal" action="{{ route('returnstocks.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">ใบรับคืน</h3></div>
        </div>       
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="wh_returnstock_hds_date" class="col-form-label">วันที่</label>
                   <input type="date" class="form-control" 
                            name="wh_returnstock_hds_date" 
                            id="wh_returnstock_hds_date"
                            value="{{ old('wh_returnstock_hds_date', now()->format('Y-m-d')) }}" 
                            required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="wh_returnstock_hds_docuno" class="col-form-label">เลขที่</label>
                    <input type="text" class="form-control" 
                            name="wh_returnstock_hds_docuno" 
                            id="wh_returnstock_hds_docuno" 
                            readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="wh_issuestock_hds_remark" class="col-form-label">ใบเบิก</label>
                    <select class="form-select" name="wh_issuestock_hds_id" id="wh_issuestock_hds_id" required>
                        <option value="">กรุณาเลือก</option>
                        @foreach ($issuestocks as $item)
                            <option value="{{$item->wh_issuestock_hds_id}}">{{$item->wh_issuestock_hds_docuno}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
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
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="wh_returnstock_hds_remark" class="col-form-label">หมายเหตุ</label>
                    <input class="form-control" name="wh_returnstock_hds_remark">
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
                        <th style="width: 10%">จำนวนเบิก</th>
                        <th style="width: 10%">จำนวนรับคืน</th>
                        <th style="width: 5%"></th>
                    </tr>
                </thead>
                <tbody id="issuestock-items"></tbody>
            </table>
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
    let docDate = $("#wh_returnstock_hds_date").val();

    if (docDate) {
        $.ajax({
            url: "{{ route('returnstock.runno') }}",
            type: "GET",
            data: { date: docDate },
            success: function (res) {
                $("#wh_returnstock_hds_docuno").val(res.docno);
            }
        });
    }
}

// เปลี่ยนวันที่
$("#wh_returnstock_hds_date").on('change', function () {
    loadDocNo();
});

// โหลดตอนเปิดฟอร์ม
$(document).ready(function () {
    loadDocNo();
});
$('#wh_issuestock_hds_id').change(function () {
    let issuestockId = $(this).val();
    $('#issuestock-items').html('');

    if (issuestockId == 0) return;

    $.ajax({
        url: "{{ route('returnstock.items') }}",
        type: "GET",
        data: { id: issuestockId },
        success: function (res) {
            let rows = '';
            $.each(res, function (index, item) {
                rows += `
                    <tr>
                        <td>${item.wh_issuestock_dts_listno}</td>
                        <td>${item.wh_product_lists_name}</td>
                        <td>${item.wh_issuestock_dts_qty}</td>
                        <td>
                            <input class="form-control" name="wh_returnstock_dts_listno[]" value="${item.wh_issuestock_dts_listno}" type="hidden">
                            <input class="form-control" name="wh_returnstock_dts_cost[]" value="${item.wh_issuestock_dts_cost}" type="hidden">
                            <input class="form-control" name="wh_issuestock_dts_id[]" value="${item.wh_issuestock_dts_id}" type="hidden">
                            <input class="form-control" name="wh_issuestock_dts_qty[]" value="${item.wh_issuestock_dts_qty}" type="hidden">
                            <input class="form-control" name="wh_product_lists_id[]" value="${item.wh_product_lists_id}" type="hidden">
                            <input class="form-control" name="wh_product_lists_code[]" value="${item.wh_product_lists_code}" type="hidden">
                            <input class="form-control" name="wh_product_lists_name[]" value="${item.wh_product_lists_name}" type="hidden">
                            <input class="form-control" name="wh_product_lists_unit[]" value="${item.wh_product_lists_unit}" type="hidden">
                            <input class="form-control" name="wh_returnstock_dts_qty[]" value="0">
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

            $('#issuestock-items').html(rows);
        }
    });
});
$(document).on('click', '.btn-remove-row', function () {
    if (!confirm('ต้องการลบรายการนี้ใช่หรือไม่ ?')) return;

    $(this).closest('tr').remove();
});
</script>
@endpush