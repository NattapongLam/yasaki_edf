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
        <h4 class="card-title">จัดการสิทธิ์ผู้ใช้งาน</h4>
        <form id="frm_sub" method="POST" class="form-horizontal" action="{{ route('profiles.updateRolePermission', $users->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')  
       
        <!-- เพิ่มส่วนเลือก Role -->
        <div class="row mt-3">
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="username" class="col-form-label">รหัสพนักงาน</label>
                    <input type="text" class="form-control" name="username" id="username" value="{{$users->username}}" readonly>
                </div>
            </div> 
           <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="name" class="col-form-label">ชื่อ - นามสกุล</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{$users->name}}" readonly>
                </div>
            </div>    
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="role" class="col-form-label">บทบาท (Role) <span class="text-danger">*</span></label>
                    <select name="role" id="role" class="form-control select2 @error('role') is-invalid @enderror" required>
                        <option value="">-- เลือกบทบาท --</option>
                        @foreach ($roles as $roleItem)
                            <option value="{{ $roleItem->name }}" {{ $users->hasRole($roleItem->name) ? 'selected' : '' }}>
                                {{ $roleItem->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <hr class="my-4">
        <h5 class="font-size-14 mb-3">สิทธิ์การใช้งาน (Permissions)</h5>

        <div class="row">
            @php
                $userPermissions = $users->getPermissionNames()->toArray();
            @endphp
            @foreach ($permissions as $key => $item)
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <div class="form-check form-check-primary mb-3">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                id="formCheckcolor1{{$item->id}}" 
                                value="{{$item->id}}" 
                                name="permission[]" 
                                {{ in_array($item->name, $userPermissions) ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="formCheckcolor1{{$item->id}}">
                                {{ $item->name }}
                            </label>
                        </div>
                    </div>
                </div> 
            @endforeach
        </div>
        <br>
        <div class="row">
            <div class="col-12 col-md-12">
                <button class="btn btn-primary waves-effect waves-light" type="submit">บันทึก</button>
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
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endpush