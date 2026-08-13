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

<form method="POST" class="form-horizontal" action="{{ route('hr.update', $hd->hr_employees_id) }}" enctype="multipart/form-data">
    @csrf 
    @method('PUT')

    <!-- Card 1: ข้อมูลส่วนตัวพนักงาน -->
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12 col-md-6"><h3 class="card-title">ประวัติพนักงาน</h3></div>
            </div>            
            <div class="row mt-2">
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">รหัสพนักงาน</label>
                        <input class="form-control" type="text" name="hr_employees_code" value="{{ $hd->hr_employees_code }}" required>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">ชื่อ - นามสกุล</label>
                        <input class="form-control" type="text" name="hr_employees_fullname" value="{{ $hd->hr_employees_fullname }}" required>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">แผนก</label>
                        <input class="form-control" type="text" name="hr_employees_department" value="{{ $hd->hr_employees_department }}" required>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">ตำแหน่ง</label>
                        <input class="form-control" type="text" name="hr_employees_position" value="{{ $hd->hr_employees_position }}" required>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">เลขบัตรประชาชน</label>
                        <input class="form-control" type="text" name="hr_employees_taxid" value="{{ $hd->hr_employees_taxid }}" required>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">ชื่อสถาบัน</label>
                        <input class="form-control" type="text" name="hr_employees_institution" value="{{ $hd->hr_employees_institution }}" required>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">วุฒิการศึกษา</label>
                        <input class="form-control" type="text" name="hr_employees_educationa" value="{{ $hd->hr_employees_educationa }}" required>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">สาขา</label>
                        <input class="form-control" type="text" name="hr_employees_branch" value="{{ $hd->hr_employees_branch }}" required>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">ที่อยู่</label>
                        <input class="form-control" type="text" name="hr_employees_address" value="{{ $hd->hr_employees_address }}" required>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: ประวัติการอบรม -->
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12 col-md-6"><h3 class="card-title">ประวัติการอบรม</h3></div>
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
                            <th style="width: 10%">วันที่อบรม</th>
                            <th style="width: 65%">รายละเอียด</th>
                            <th style="width: 15%">ใบรับรอง</th>
                            <th style="width: 5%"></th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- วนลูปแสดงข้อมูลเดิมที่มีอยู่ -->
                        @if(isset($hd->details) && count($hd->details) > 0)
                            @foreach($hd->details as $key => $train)
                            <tr>
                                <td>
                                    <span class="row-number">{{ $key + 1 }}</span>
                                    <input type="hidden" name="hr_employee_trains_listno[]" class="row-number-hidden" value="{{ $key + 1 }}">
                                    <!-- ส่ง ID เดิมไปด้วยเผื่อใช้ในการอัปเดตข้อมูลตารางลูก (ถ้ามี) -->
                                    <input type="hidden" name="hr_employee_trains_id[]" value="{{ $train->hr_employee_trains_id ?? '' }}">
                                </td>
                                <td>
                                    <input type="date" name="hr_employee_trains_date[]" class="form-control" value="{{ $train->hr_employee_trains_date }}" required>
                                </td>
                                <td>
                                    <input type="text" name="hr_employee_trains_remark[]" class="form-control" value="{{ $train->hr_employee_trains_remark }}" required>
                                </td>
                                <td>
                                    @if(!empty($train->hr_employee_trains_file))
                                        <div class="mb-1">
                                            <!-- ใช้ asset ชี้ไปที่ public/images/Train_File โดยตรง -->
                                            <a href="{{ asset('images/Train_File/' . $train->hr_employee_trains_file) }}" target="_blank" class="btn btn-sm btn-info">ดูไฟล์เดิม</a>
                                        </div>
                                    @endif
                                    <input type="file" name="hr_employee_trains_file[]" class="form-control">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm deleteRow">ลบ</button>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div> 
        </div>
    </div>

    <!-- ปุ่มบันทึก -->
    <div class="row mt-4">
        <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm">
                <i class="mdi mdi-content-save me-1"></i> บันทึกข้อมูล
            </button>
        </div>
    </div>
</form>
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
            <input type="hidden" name="hr_employee_trains_listno[]" class="row-number-hidden">
            <input type="hidden" name="hr_employee_trains_id[]" value="">
        </td>
        <td>
            <input type="date" name="hr_employee_trains_date[]" class="form-control" required>
        </td>
        <td>
            <input type="text" name="hr_employee_trains_remark[]" class="form-control" required>
        </td>
        <td>
            <input type="file" name="hr_employee_trains_file[]" class="form-control" required>
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
</script>
@endpush