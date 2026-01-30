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
        <form method="POST" class="form-horizontal" action="{{ route('adjuststocks.update',$hd->wh_adjuststock_hds_id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">อนุมัติใบปรับปรุงสต็อค</h3></div>
            <input type="hidden" value="Approved" name="checkdoc">      
        </div>       
         <div class="row">
            <div class="col-2">
                <div class="form-group">
                    <label for="wh_returnstock_hds_date" class="col-form-label">วันที่</label>
                   <input type="date" class="form-control" 
                            name="wh_adjuststock_hds_date" 
                            id="wh_adjuststock_hds_date"
                            value="{{ $hd->wh_adjuststock_hds_date }}" 
                            readonly>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="wh_adjuststock_hds_docuno" class="col-form-label">เลขที่</label>
                    <input type="text" class="form-control" 
                            name="wh_adjuststock_hds_docuno" 
                            id="wh_adjuststock_hds_docuno" 
                            value="{{$hd->wh_adjuststock_hds_docuno}}"
                            readonly>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="wh_warehouses_id" class="col-form-label">คลังสินค้า</label>
                    <select class="form-select" name="wh_warehouses_id" id="wh_warehouses_id" disabled>
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
                    <label for="wh_adjuststock_hds_remark" class="col-form-label">หมายเหตุ</label>
                    <input type="text" class="form-control" name="wh_adjuststock_hds_remark" value="{{$hd->wh_adjuststock_hds_remark}}" readonly>
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
                        <th style="width: 10%">สต็อค</th>
                        <th style="width: 10%">ประเภท</th>
                        <th style="width: 10%">จำนวนปรับ</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach ($dt as $item)
                        <tr>
                            <td>
                                <span class="row-number">{{ $loop->iteration }}</span>
                                <input type="hidden"
                                    name="wh_adjuststock_dts_listno[]"
                                    class="row-number-hidden"
                                    value="{{ $loop->iteration }}">
                                <input type="hidden" name="wh_adjuststock_dts_id[]" value="{{$item->wh_adjuststock_dts_id}}">
                            </td>
                            <td>{{$item->wh_product_lists_name}}</td>
                            <td>{{$item->stc_stockcard_qty}}</td>
                            <td>
                                @if ($item->stockflag == 1)
                                    เพิ่ม
                                @else
                                    ลด
                                @endif
                            </td>
                            <td>
                                <input class="form-control" name="wh_adjuststock_dts_qty[]" value="{{$item->wh_adjuststock_dts_qty}}" readonly>
                            </td>
                        </tr>
                    @endforeach
                </tbody>       
            </table>
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
                <input type="hidden" name="wh_adjuststock_dts_listno[]" class="row-number-hidden"/>
            </td>
            <td>
                <select class="form-control product-select" name="wh_product_lists_id[]">
                    <option value="0">กรุณาเลือก</option>
                    @foreach ($products as $item)
                        <option value="{{ $item->wh_product_lists_id }}">
                            {{ $item->wh_product_lists_name1 }}
                        </option>
                    @endforeach
                </select>              
            </td>
            <td class="stock-cell">
                0
            </td>
              <td>
                <select class="form-control" name="stockflag[]">
                    <option value="1">เพิ่ม</option>
                    <option value="-1">ลด</option>
                </select>              
            </td>
            <td><input type="text" name="wh_adjuststock_dts_qty[]" class="form-control" value="0"/></td>
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
$(document).on('change', '.product-select', function () {

    let productId   = $(this).val();
    let warehouseId = $('#wh_warehouses_id').val();
    let row         = $(this).closest('tr');
    let stockCell   = row.find('.stock-cell');

    if (!warehouseId) {
        alert('กรุณาเลือกคลังสินค้าก่อน');
        $(this).val('');
        return;
    }

    if (productId) {
        $.ajax({
            url: "{{ route('adjuststock.getstock') }}",
            type: "GET",
            data: {
                wh_warehouses_id: warehouseId,
                wh_product_lists_id: productId
            },
            success: function (res) {
                stockCell.text(res.stock);
            },
            error: function () {
                stockCell.text('0');
            }
        });
    } else {
        stockCell.text('0');
    }
});
</script>
@endpush