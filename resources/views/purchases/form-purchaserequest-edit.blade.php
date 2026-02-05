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
        <form method="POST" class="form-horizontal" action="{{ route('purchaserequests.update',$hd->ap_purchaserequest_hds_id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">ใบขอสั่งซื้อ</h3></div>
            <input type="hidden" value="Edit" name="checkdoc">
        </div>       
        <div class="row mt-3">
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_purchaserequest_hds_date" class="col-form-label">วันที่</label>
                   <input type="date" class="form-control" 
                            name="ap_purchaserequest_hds_date" 
                            id="ap_purchaserequest_hds_date"
                            value="{{ $hd->ap_purchaserequest_hds_date }}" 
                            required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_purchaserequest_hds_docuno" class="col-form-label">เลขที่</label>
                   <input type="text" class="form-control" 
                            name="ap_purchaserequest_hds_docuno" 
                            id="ap_purchaserequest_hds_docuno" 
                            value="{{ $hd->ap_purchaserequest_hds_docuno }}"
                            readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="ms_allocate_id" class="col-form-label">จัดสรร</label>
                    <select class="form-control" name="ms_allocate_id">
                        <option value="0">กรุณาเลือก</option>
                        @foreach ($allocates as $item)
                            <option value="{{$item->ms_allocate_id}}"
                                {{ $item->ms_allocate_id == $hd->ms_allocate_id ? 'selected' : '' }}>
                                {{$item->ms_allocate_name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="form-group">
                    <label for="ms_allocate_id" class="col-form-label">หมายเหตุ</label>
                    <textarea class="form-control" name="ap_purchaserequest_hds_remark">{{$hd->ap_purchaserequest_hds_remark}}</textarea>
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
                <tbody id="tableBody">
                    @foreach ($dt as $item)
                        <tr>
                            <td>
                                <span class="row-number">{{ $loop->iteration }}</span>
                                <input type="hidden"
                                    name="ap_purchaserequest_dts_listno[]"
                                    class="row-number-hidden"
                                    value="{{ $loop->iteration }}">
                                <input type="hidden" name="ap_purchaserequest_dts_id[]" value="{{$item->ap_purchaserequest_dts_id}}">
                            </td>
                            <td>
                                <select class="form-control" name="wh_product_lists_id[]">
                                    <option value="0">กรุณาเลือก</option>
                                    @foreach ($products as $product)
                                            <option value="{{$product->wh_product_lists_id}}"
                                                {{$product->wh_product_lists_id == $item->wh_product_lists_id ? 'selected' : '' }}>
                                                {{$product->wh_product_lists_name1}}
                                            </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input name="ap_purchaserequest_dts_qty[]" class="form-control" value="{{$item->ap_purchaserequest_dts_qty}}">
                            </td>
                            <td>
                                <input name="ap_purchaserequest_hds_duedate[]" class="form-control" type="date" value="{{$item->ap_purchaserequest_hds_duedate}}" required>
                            </td>
                            <td>
                                <input name="ap_purchaserequest_dts_remark[]" class="form-control" value="{{$item->ap_purchaserequest_dts_remark}}">
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->ap_purchaserequest_dts_id }}')"><i class="fas fa-trash"></i></a>
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
                <input type="hidden" name="ap_purchaserequest_dts_listno[]" class="row-number-hidden"/>
            </td>
            <td>
                <select class="form-control" name="wh_product_lists_id[]">
                    <option value="0">กรุณาเลือก</option>
                    @foreach ($products as $item)
                            <option value="{{$item->wh_product_lists_id}}">{{$item->wh_product_lists_name1}}</option>
                    @endforeach
                </select>
               
            </td>
            <td><input type="text" name="ap_purchaserequest_dts_qty[]" class="form-control qty-input" value="0"/></td>
            <td><input type="date" name="ap_purchaserequest_hds_duedate[]" class="form-control" required/></td>
            <td>
                <input type="text" name="ap_purchaserequest_dts_remark[]" class="form-control"/>
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
            url: `{{ url('/CancelPurchaseRequestDoc') }}`,
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
</script>
@endpush