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
        <div class="row mb-3">
            <div class="col-12 col-md-6"><h3 class="card-title">ประวัติพนักงาน</h3></div>
        </div>             
        <div class="row mt-2">
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">รหัสพนักงาน</label>
                    <input class="form-control" type="text" name="">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">ชื่อ - นามสกุล</label>
                    <input class="form-control" type="text" name="">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">แผนก</label>
                    <input class="form-control" type="text" name="">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">ตำแหน่ง</label>
                    <input class="form-control" type="text" name="">
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scriptjs')
<script>
</script>
@endpush