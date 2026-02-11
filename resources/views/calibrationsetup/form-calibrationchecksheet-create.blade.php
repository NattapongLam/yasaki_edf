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
        <form method="POST" class="form-horizontal" action="{{ route('calibrationchecksheets.store') }}" enctype="multipart/form-data">
        @csrf 
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">ตรวจประจำวัน</h3></div>
        </div>    
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="calibration_checksheet_hds_date" class="col-form-label">วันที่</label>
                    <input type="date" class="form-control" 
                        name="calibration_checksheet_hds_date" 
                        id="calibration_checksheet_hds_date" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="calibration_lists_code" class="col-form-label">รหัสเครื่องมือวัด</label>
                    <input class="form-control" value="{{$hd->calibration_lists_code}}" name="calibration_lists_code" readonly>
                    <input type="hidden" class="form-control" value="{{$hd->calibration_lists_id}}" name="calibration_lists_id" readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="calibration_lists_name" class="col-form-label">ชื่อเครื่องมือวัด</label>
                    <input class="form-control" value="{{$hd->calibration_lists_name1}}" name="calibration_lists_name" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="calibration_checksheet_hds_remark" class="col-form-label">หมายเหตุ</label>
                    <input class="form-control" name="calibration_checksheet_hds_remark">
                </div>
            </div>
        </div>
        <br>
        <div class="row">
             <div class="col-12" style="text-align: right;">
                <a href="javascript:void(0);" class="btn btn-secondary" id="addRowBtn">เพิ่มรายการ</a>
            </div>
            <hr>
            <table class="table table-bordered dt-responsive nowrap w-100 text-center">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 90%">รายละเอียด</th>
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
<script>
document.getElementById('calibration_checksheet_hds_date').addEventListener('change', function () {
    let selectedDate = new Date(this.value);
    if (selectedDate.getDate() !== 1) {
        alert('กรุณาเลือกเฉพาะวันที่ 1 ของเดือนเท่านั้น');
        this.value = '';
    }
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
                <input type="hidden" name="calibration_checksheet_dts_listno[]" class="row-number-hidden"/>
            </td>
            <td><input type="text" name="calibration_checksheet_dts_remark[]" class="form-control"/></td>
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