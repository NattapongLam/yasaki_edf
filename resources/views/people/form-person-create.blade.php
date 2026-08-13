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
        <form method="POST" class="form-horizontal" action="{{ route('hr.store') }}" enctype="multipart/form-data">
        @csrf 
        <div class="row mb-3">
            <div class="col-12 col-md-6"><h3 class="card-title">ประวัติพนักงาน</h3></div>
        </div>             
        <div class="row mt-2">
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">รหัสพนักงาน</label>
                    <input class="form-control" type="text" name="hr_employees_code" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">ชื่อ - นามสกุล</label>
                    <input class="form-control" type="text" name="hr_employees_fullname" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">แผนก</label>
                    <input class="form-control" type="text" name="hr_employees_department" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">ตำแหน่ง</label>
                    <input class="form-control" type="text" name="hr_employees_position" required>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">เลขบัตรประชาชน</label>
                    <input class="form-control" type="text" name="hr_employees_taxid" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">ชื่อสถาบัน</label>
                    <input class="form-control" type="text" name="hr_employees_institution" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">วุฒิการศึกษา</label>
                    <input class="form-control" type="text" name="hr_employees_educationa" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">สาขา</label>
                    <input class="form-control" type="text" name="hr_employees_branch" required>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">ที่อยู่</label>
                    <input class="form-control" type="text" name="hr_employees_address" required>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm">
                    <i class="mdi mdi-content-save me-1"></i> บันทึกข้อมูล
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
</script>
@endpush