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
        <form method="POST" class="form-horizontal" action="{{ route('issuestocks.update',$hd->wh_issuestock_hds_id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">ใบเบิก</h3></div>  
            <input type="hidden" value="Edit" name="checkdoc">         
        </div> 
             <div class="row">
            <div class="col-2">
                <div class="form-group">
                    <label for="wh_issuestock_hds_date" class="col-form-label">วันที่</label>
                   <input type="date" class="form-control" 
                            name="wh_issuestock_hds_date" 
                            id="wh_issuestock_hds_date"
                            value="{{$hd->wh_issuestock_hds_date}}" 
                            required>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="wh_issuestock_hds_docuno" class="col-form-label">เลขที่</label>
                    <input type="text" class="form-control" 
                            name="wh_issuestock_hds_docuno" 
                            id="wh_issuestock_hds_docuno" 
                            value="{{$hd->wh_issuestock_hds_docuno}}"
                            readonly>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="wh_warehouses_id" class="col-form-label">คลังสินค้า</label>
                    <select class="form-select" name="wh_warehouses_id" id="wh_warehouses_id" required>
                        <option value="">กรุณาเลือก</option>
                        @foreach ($warehouses as $item)
                            <option value="{{$item->wh_warehouses_id}}"
                                {{$item->wh_warehouses_id == $hd->wh_warehouses_id ? 'selected' : '' }}>
                                {{$item->wh_warehouses_name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="wh_issuestock_hds_remark" class="col-form-label">หมายเหตุ</label>
                    <input type="text" class="form-control" name="wh_issuestock_hds_remark" value="{{$hd->wh_issuestock_hds_remark}}">
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12" style="text-align: right;">
                <a href="javascript:void(0);" class="btn btn-secondary" id="addRowBtn">เพิ่มรายการ</a>
            </div>
            <hr>
            <table class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th style="width: 5%" class="text-center">#</th>
                        <th style="width: 30%" class="text-center">สินค้า</th>
                        <th style="width: 10%" class="text-center">จำนวนเบิก</th>
                        <th style="width: 5%" class="text-center"></th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach ($dt as $item)
                        <tr>
                            <td class="text-center">
                                <span class="row-number">{{ $loop->iteration }}</span>
                                <input type="hidden"
                                    name="wh_issuestock_dts_listno[]"
                                    class="row-number-hidden"
                                    value="{{ $loop->iteration }}">
                                <input type="hidden" name="wh_issuestock_dts_id[]" value="{{$item->wh_issuestock_dts_id}}">
                            </td>
                            <td>
                                {{$item->wh_product_lists_name}} สต็อค : {{$item->stc_stockcard_qty}} {{$item->wh_product_lists_unit}}
                            </td>
                            <td><input type="text" name="wh_issuestock_dts_qty[]" class="form-control" value="{{$item->wh_issuestock_dts_qty}}"/></td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->wh_issuestock_dts_id }}')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>       
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
let productOptions = '<option value="">กรุณาเลือก</option>';

function loadProducts(warehouseId) {
    if (!warehouseId) {
        productOptions = '<option value="">กรุณาเลือก</option>';
        $('.select2-product').each(function () {
            if ($(this).hasClass("select2-hidden-accessible")) {
                $(this).select2('destroy');
            }
            initSelect2Table($(this));
        });
        return;
    }

    $.ajax({
        url: "{{ route('issuestock.productsByWarehouse') }}",
        type: "GET",
        data: { wh_warehouses_id: warehouseId },
         success: function (res) {
            productOptions = '<option value="">กรุณาเลือก</option>';
            res.forEach(item => {
                productOptions += `<option value="${item.wh_product_lists_id}">
                    ${item.wh_product_lists_name1} สต็อค : ${item.goodqty} ${item.wh_product_units_name}
                </option>`;
            });

            $('.select2-product').each(function () {
                if ($(this).hasClass("select2-hidden-accessible")) {
                    $(this).select2('destroy');
                }
                $(this).html(productOptions);
                initSelect2Table($(this));
            });
        }
    });
}

// 🔹 change warehouse
$('#wh_warehouses_id').on('change', function () {
    loadProducts($(this).val());
});

// 🔹 โหลดตอนเปิดหน้า Edit
$(document).ready(function () {
    const warehouseId = $('#wh_warehouses_id').val();
    if (warehouseId) {
        loadProducts(warehouseId);
    }
});

function updateRowNumbers() {
    $('#tableBody tr').each(function (index) {
        $(this).find('.row-number').text(index + 1);
        $(this).find('.row-number-hidden').val(index + 1);
    });
}

$('#addRowBtn').on('click', function () {
    const newRow = $(`
        <tr>
            <td class="text-center"> 
                <span class="row-number"></span>
                <input type="hidden" name="wh_issuestock_dts_listno[]" class="row-number-hidden">
            </td>
            <td>
                <select class="form-control select2-product" name="wh_product_lists_id[]">
                    ${productOptions}
                </select>
            </td>
            <td>
                <input type="text" name="wh_issuestock_dts_qty[]" class="form-control" value="0">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm deleteRow">ลบ</button>
            </td>
        </tr>
    `);

    $('#tableBody').append(newRow);
    updateRowNumbers();
    initSelect2Table(newRow.find('.select2-product'));
});

$('#tableBody').on('click', '.deleteRow', function () {
    $(this).closest('tr').remove();
    updateRowNumbers();
});
confirmDel = (refid) =>{
Swal.fire({
    title: 'คุณแน่ใจหรือไม่ !',
    text: `คุณต้องการลบรายการนี้หรือไม่ ?`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'ยืนยัน',
    cancelButtonText: 'ยกเลิก',
    confirmButtonClass: 'btn btn-success',
    cancelButtonClass: 'btn btn-danger',
    buttonsStyling: false         
}).then(function(result) {
    if (result.value) {
        $.ajax({
            url: `{{ url('/CancelIssueStockList') }}`,
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "refid": refid,               
            },           
            dataType: "json",
            success: function(data) {
                // console.log(data);
                if (data.status == true) {
                    Swal.fire({
                        title: 'สำเร็จ',
                        text: 'ยกเลิกรายการเรียบร้อยแล้ว',
                        icon: 'success'
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'ยกเลิกรายการไม่สำเร็จ',
                        icon: 'error'
                    });
                }
               
            },
            error: function(data) {
                Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'ยกเลิกรายการไม่สำเร็จ',
                        icon: 'error'
                    });            }
        });

    } else if ( // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
            title: 'ยกเลิก',
            text: 'โปรดตรวจสอบข้อมูลอีกครั้งเพื่อความถูกต้อง :)',
            icon: 'error'
        });
    }
});
}
function initSelect2Table(el) {
    el.select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'กรุณาเลือกสินค้า',
        allowClear: true,
        dropdownParent: el.closest('td') // ⭐ สำคัญมาก (อยู่ใน table)
    });
}
</script>
@endpush