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
        <form method="POST" class="form-horizontal" action="{{ route('inspection-product.update',$hd->inspection_product_hds_id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">ใบตรวจรับเครื่องจักร</h3></div>           
        </div> 
        <div class="row mt-2">
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">วันที่</label>
                    <input class="form-control" type="date" name="inspection_product_hds_date" value="{{$hd->inspection_product_hds_date}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">เลขที่</label>
                    <input class="form-control" type="text" name="inspection_product_hds_docuno" value="{{ $hd->inspection_product_hds_docuno }}" readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="form-label">เครื่องมือวัด</label>
                    <select class="form-control" name="wh_product_lists_id">
                        <option value="0">กรุณาเลือก</option>
                        @foreach ($pd as $item)
                            <option value="{{$item->wh_product_lists_id}}"
                                {{ $item->wh_product_lists_id == $hd->wh_product_lists_id ? 'selected' : '' }}>
                                {{$item->wh_product_lists_name1}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div> 
        <div class="row mt-2">
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">ชื่อผู้ผลิต/ผู้ส่งมอบ</label>
                    <input class="form-control" type="text" name="inspection_product_hds_vendor" value="{{$hd->inspection_product_hds_vendor}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">หมายเลขงาน/ใบเซอร์</label>
                    <input class="form-control" type="text" name="inspection_product_hds_refdocu" value="{{$hd->inspection_product_hds_refdocu}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">จำนวน</label>
                    <input class="form-control" type="text" name="inspection_product_hds_qty" value="{{$hd->inspection_product_hds_qty}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">เอกสารแนบ</label>
                    <input class="form-control" type="file" name="inspection_product_hds_file">
                    @if ($hd->inspection_product_hds_file)
                        <a href="{{asset($hd->inspection_product_hds_file)}}" target="_blank">
                            <i class="fas fa-file"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div> 
        <div class="row mt-2">
            <div class="col-12">
                 <div class="form-group">
                    <label class="form-label">หมายเหตุ</label>
                    <textarea class="form-control" name="inspection_product_hds_remark">{{$hd->inspection_product_hds_remark}}</textarea>
                </div>
            </div>
        </div>
        <div class="row mt-2">
             <div class="col-12" style="text-align: right;">
                <a href="javascript:void(0);" class="btn btn-secondary" id="addRowBtn">เพิ่มรายการ</a>
            </div>
            <hr>
            <table class="table table-bordered dt-responsive nowrap w-100 text-center">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 45%">รายละเอียด</th>
                        <th style="width: 15%">มาตรฐาน</th>
                        <th style="width: 15%">ผลการวิเคราะห์</th>
                        <th style="width: 15%">สรุป</th>
                        <th style="width: 5%"></th>
                    </tr>
                </thead>
                <tbody id="tableBody"> 
                    @foreach ($dt as $item)
                        <tr>
                            <!-- ปรับตรงนี้ให้รองรับการรันเลขเหมือนแถวใหม่ -->
                            <td>
                                <span class="row-number"></span>
                                <input type="hidden" name="inspection_product_dts_listno[]" class="row-number-hidden" value="{{$item->inspection_product_dts_listno}}">
                            </td>
                            <td>
                                <input class="form-control" name="inspection_product_dts_name[]" value="{{$item->inspection_product_dts_name}}">
                            </td>
                            <td>
                                <input class="form-control" name="inspection_product_dts_standard[]" value="{{$item->inspection_product_dts_standard}}">
                            </td>
                            <td>
                                <input class="form-control" name="inspection_product_dts_result[]" value="{{$item->inspection_product_dts_result}}">
                            </td>
                            <td>
                                <input class="form-control" name="inspection_product_dts_status[]" value="{{$item->inspection_product_dts_status}}">
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->inspection_product_dts_id }}')"><i class="fas fa-trash"></i></a>
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
        const rowNumSpan = row.querySelector('.row-number');
        const rowNumHidden = row.querySelector('.row-number-hidden');

        if (rowNumSpan) {
            rowNumSpan.textContent = index + 1;
        }
        if (rowNumHidden) {
            rowNumHidden.value = index + 1;
        }
    });
}

document.getElementById('addRowBtn').addEventListener('click', function () {
    const tbody = document.getElementById('tableBody');
    const newRow = document.createElement('tr');

    newRow.innerHTML = `
        <td>
            <span class="row-number"></span>
            <input type="hidden" name="inspection_product_dts_listno[]" class="row-number-hidden">
        </td>
        <td>
            <input type="text" name="inspection_product_dts_name[]" class="form-control" required>
        </td>
        <td>
            <input type="text" name="inspection_product_dts_standard[]" class="form-control" required>
        </td>
        <td>
            <input type="text" name="inspection_product_dts_result[]" class="form-control" required>
        </td>
        <td>
            <input type="text" name="inspection_product_dts_status[]" class="form-control" required>
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm deleteRow">ลบ</button>
        </td>
    `;

    tbody.appendChild(newRow);
    updateRowNumbers();
});

document.getElementById('tableBody').addEventListener('click', function (e) {
    if (e.target.classList.contains('deleteRow')) {
        e.target.closest('tr').remove();
        updateRowNumbers();
    }
});

document.addEventListener('DOMContentLoaded', function () {
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
            url: `{{ url('/CancelInspectionPdDt') }}`,
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
                        text: 'ยกเลิกเอกสารเรียบร้อยแล้ว',
                        icon: 'success'
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'ยกเลิกเอกสารไม่สำเร็จ',
                        icon: 'error'
                    });
                }
               
            },
            error: function(data) {
                Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'ยกเลิกเอกสารไม่สำเร็จ',
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