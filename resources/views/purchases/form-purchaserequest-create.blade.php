@extends('layouts.main')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container {
    width: 100% !important;
}
.select2-selection--single {
    height: 38px !important;
}
.select2-selection__rendered {
    line-height: 36px !important;
}
</style>
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
        <form method="POST" class="form-horizontal" action="{{ route('purchaserequests.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">ใบขอสั่งซื้อ</h3></div>
        </div>       
        <div class="row mt-3">
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_purchaserequest_hds_date" class="col-form-label">วันที่</label>
                   <input type="date" class="form-control" 
                            name="ap_purchaserequest_hds_date" 
                            id="ap_purchaserequest_hds_date"
                            value="{{ old('ap_purchaserequest_hds_date', now()->format('Y-m-d')) }}" 
                            required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_purchaserequest_hds_docuno" class="col-form-label">เลขที่</label>
                   <input type="text" class="form-control" 
                            name="ap_purchaserequest_hds_docuno" 
                            id="ap_purchaserequest_hds_docuno" 
                            readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="ms_allocate_id" class="col-form-label">จัดสรร</label>
                    <select class="form-control select2" name="ms_allocate_id">
                        <option value="0">กรุณาเลือก</option>
                        @foreach ($allocates as $item)
                            <option value="{{$item->ms_allocate_id}}">{{$item->ms_allocate_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="form-group">
                    <label for="ap_purchaserequest_hds_remark" class="col-form-label">หมายเหตุ</label>
                    <textarea class="form-control" name="ap_purchaserequest_hds_remark"></textarea>
                </div>
            </div>
        </div>
        <div class="row mt-3">
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
                        <th style="width: 10%">วันที่ต้องการ</th>
                        <th style="width: 30%">หมายเหตุ</th>
                        <th style="width: 5%"></th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>       
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    function loadDocNo() {
        let docDate = $("#ap_purchaserequest_hds_date").val();

        if (docDate) {
            $.ajax({
                url: "{{ route('purchaserequest.runno') }}",
                type: "GET",
                data: { date: docDate },
                success: function (res) {
                    $("#ap_purchaserequest_hds_docuno").val(res.docno);
                }
            });
        }
    }

    // ✔ ทำงานเมื่อผู้ใช้เปลี่ยนวันที่
    $("#ap_purchaserequest_hds_date").on('change', function () {
        loadDocNo();
    });

    // ✔ ทำงานทันทีเมื่อเปิดฟอร์ม
    $(document).ready(function () {
        loadDocNo();
        initSelect2();
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
            <input type="hidden" name="ap_purchaserequest_dts_listno[]" class="row-number-hidden"/>
        </td>
        <td>
            <select class="form-control select2-product" name="wh_product_lists_id[]">
                <option value="">เลือกสินค้า</option>
                @foreach ($products as $item)
                    <option value="{{$item->wh_product_lists_id}}">
                        {{$item->wh_product_lists_name1}}
                    </option>
                @endforeach
            </select>
        </td>
        <td><input type="number" name="ap_purchaserequest_dts_qty[]" class="form-control" value="0"/></td>
        <td><input type="date" name="ap_purchaserequest_hds_duedate[]" class="form-control"/></td>
        <td><input type="text" name="ap_purchaserequest_dts_remark[]" class="form-control"/></td>
        <td><button type="button" class="btn btn-danger btn-sm deleteRow">ลบ</button></td>
    `;

    tbody.appendChild(newRow);
    updateRowNumbers();

    // ⭐ init select2 เฉพาะ select ใหม่
    initProductSelect($(newRow).find('.select2-product'));
});
document.getElementById('tableBody').addEventListener('click', function (e) {
    if (e.target.classList.contains('deleteRow')) {
        e.target.closest('tr').remove();
        updateRowNumbers(); // อัปเดตลำดับหลังจากลบ
    }
});
function initSelect2() {
    $('.select2').select2({
        placeholder: 'กรุณาเลือก',
        allowClear: true,
        width: '100'
    });

    $('.select2-product').select2({
        placeholder: 'เลือกสินค้า',
        width: '100'
    });
}
function initProductSelect(el) {
    el.select2({
        theme: 'bootstrap-5',
        placeholder: 'เลือกสินค้า',
        width: '100%',
        dropdownParent: el.closest('td') // ⭐ แก้ปัญหาใน table
    });
}
$(document).ready(function () {
    $('.select2-product').each(function () {
        initProductSelect($(this));
    });
});
</script>
@endpush