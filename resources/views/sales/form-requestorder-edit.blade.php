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
        <form method="POST" class="form-horizontal" action="{{ route('requestorders.update',$hd->ar_requestorder_hds_id) }}" enctype="multipart/form-data">
        @csrf      
        @method('PUT')
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">คำร้องขอใช้บริการ</h3></div>
        </div>
        <div class="row mt-3">
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_requestorder_hds_date" class="col-form-label">วันที่</label>
                    <input type="date" class="form-control" 
                            name="ar_requestorder_hds_date" 
                            id="ar_requestorder_hds_date"
                            value="{{ $hd->ar_requestorder_hds_date }}" 
                            required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_requestorder_hds_docuno" class="col-form-label">เลขที่</label>
                    <input type="text" class="form-control" 
                            name="ar_requestorder_hds_docuno" 
                            id="ar_requestorder_hds_docuno" 
                            value="{{$hd->ar_requestorder_hds_docuno}}"
                            readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="ar_requestorder_hds_customer" class="col-form-label">ชื่อบริษัท</label>
                     <input type="text" class="form-control" 
                            name="ar_requestorder_hds_customer" 
                            id="ar_requestorder_hds_customer"
                            value="{{$hd->ar_requestorder_hds_customer}}"
                            required>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_requestorder_hds_contact" class="col-form-label">ติดต่อ</label>
                    <input type="text" class="form-control" 
                            name="ar_requestorder_hds_contact" 
                            id="ar_requestorder_hds_contact"
                            value="{{$hd->ar_requestorder_hds_contact}}"
                            required>
                </div>
            </div>
            <div class="col-9">
                <div class="form-group">
                    <label for="ar_requestorder_hd_remark" class="col-form-label">หมายเหตุ</label>
                    <input type="text" class="form-control" 
                            name="ar_requestorder_hd_remark" 
                            id="ar_requestorder_hd_remark"
                            value="{{$hd->ar_requestorder_hd_remark}}">
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
                        <th style="width: 20%">สินค้า</th>
                        <th style="width: 10%">จำนวน</th>
                        <th style="width: 60%">รายละเอียด</th>
                        <th style="width: 5%"></th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach ($dt as $item)
                        <tr>
                            <td>
                                <span class="row-number">{{ $loop->iteration }}</span>
                                <input type="hidden"
                                    name="ar_requestorder_dts_listno[]"
                                    class="row-number-hidden"
                                    value="{{ $loop->iteration }}">
                            </td>
                            <td>
                                <input class="form-control" name="ar_requestorder_dts_product[]" value="{{$item->ar_requestorder_dts_product}}">
                            </td>
                            <td>
                                <input class="form-control" name="ar_requestorder_dts_qty[]" type="number" value="{{$item->ar_requestorder_dts_qty}}">
                            </td>
                            <td>
                                <textarea class="form-control" name="ar_requestorder_hds_remark[]">{{$item->ar_requestorder_hds_remark}}</textarea>
                            </td>
                            <td></td>
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
                <input type="hidden" name="ar_requestorder_dts_listno[]" class="row-number-hidden"/>
            </td>
            <td><input type="text" name="ar_requestorder_dts_product[]" class="form-control"/></td>
            <td><input type="number" name="ar_requestorder_dts_qty[]" class="form-control" value="0"/></td>
            <td>
                <textarea class="form-control" name="ar_requestorder_hds_remark[]"></textarea>
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
</script>
@endpush