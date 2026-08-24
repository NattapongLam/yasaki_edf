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
        <form method="POST" class="form-horizontal" action="{{ route('inspection-machinery.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">ใบตรวจรับเครื่องจักร</h3></div>           
        </div> 
        <div class="row mt-2">
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">วันที่</label>
                    <input class="form-control" type="date" name="inspection_machinery_hds_date" value="{{old('inspection_machinery_hds_date',now()->format('Y-m-d'))}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">เลขที่</label>
                    <input class="form-control" type="text" name="inspection_machinery_hds_docuno" value="{{ $autoDocNo }}" readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="form-label">เครื่องจักร</label>
                    <select class="form-control" name="machinery_lists_id">
                        <option value="0">กรุณาเลือก</option>
                        @foreach ($mtn as $item)
                            <option value="{{$item->machinery_lists_id}}">{{$item->machinery_lists_name1}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div> 
        <div class="row mt-2">
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">ชื่อผู้ผลิต/ผู้ส่งมอบ</label>
                    <input class="form-control" type="text" name="inspection_machinery_hds_vendor">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">หมายเลขงาน/ใบเซอร์</label>
                    <input class="form-control" type="text" name="inspection_machinery_hds_refdocu">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">จำนวน</label>
                    <input class="form-control" type="text" name="inspection_machinery_hds_qty">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">เอกสารแนบ</label>
                    <input class="form-control" type="file" name="inspection_machinery_hds_file">
                </div>
            </div>
        </div> 
        <div class="row mt-2">
            <div class="col-12">
                 <div class="form-group">
                    <label class="form-label">หมายเหตุ</label>
                    <textarea class="form-control" name="inspection_machinery_hds_remark"></textarea>
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
            <input type="hidden"
                   name="inspection_machinery_dts_listno[]"
                   class="row-number-hidden">
        </td>

        <td>
            <input type="text"
                   name="inspection_machinery_dts_name[]"
                   class="form-control" required>
        </td>
           <td>
            <input type="text"
                   name="inspection_machinery_dts_standard[]"
                   class="form-control" required>
        </td>
        <td>
            <input type="text"
                   name="inspection_machinery_dts_result[]"
                   class="form-control" required>
        </td>
        <td>
            <input type="text"
                   name="inspection_machinery_dts_status[]"
                   class="form-control" required>
        </td>
        <td>
            <button type="button"
                    class="btn btn-danger btn-sm deleteRow">
                    ลบ
            </button>
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
</script>
@endpush