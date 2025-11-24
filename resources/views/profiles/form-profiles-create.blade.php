@extends('layouts.main')
@section('content')
<link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
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
        <h4 class="card-title">ผู้ใช้งาน</h4>
        <form id="frm_sub" method="POST" class="form-horizontal" action="{{ route('profiles.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="username" class="col-form-label">รหัสพนักงาน</label>
                    <input type="text" class="form-control" name="username" id="username">
                </div>
            </div> 
           <div class="col-6">
                    <div class="form-group">
                    <label for="name" class="col-form-label">ชื่อ - นามสกุล</label>
                    <input type="text" class="form-control" name="name" id="name">
                    </div>
            </div>        
        </div>
        <div class="row">
            <div class="col-6" >
                    <div class="form-group">
                    <label for="password" class="col-form-label">รหัสผ่าน</label>
                    <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                    </div>
            </div>
            <div class="col-6">
                    <div class="form-group">
                    <label for="password_confirmation" class="col-form-label">ยืนยันรหัสผ่าน</label>
                    <input id="password_confirmation" class="form-control"type="password"name="password_confirmation" required />
                    </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12 col-md-12">
                <button class="btn btn-primary waves-effect waves-light" type="submit" >บันทึก</button>
            </div>
        </div> 
        </form>
</div>
</div>
@endsection
@push('scriptjs')
<script src="{{ asset('/assets/libs/select2/select2.min.js') }}"></script>
<script src="{{ asset('/assets/js/pages/form-advanced.init.js') }}"></script>
<script>
</script>
@endpush