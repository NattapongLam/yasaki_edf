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
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">แขวง/ตำบล</h3></div> 
        </div>
        <div class="row">            
            <div class="col-12">
                <form method="POST" class="form-horizontal" action="{{ route('sub-districts.update',$hd->other_sub_districts_id) }}" enctype="multipart/form-data">
                @csrf  
                @method('PUT')
                <div class="form-group">
                    <label for="other_districts_id" class="col-form-label">เขต/อำเภอ</label>
                    <select class="form-select select2" name="other_districts_id" id="other_districts_id">
                        <option value="">กรุณาเลือก</option>
                        @foreach ($district as $item)
                            <option value="{{$item->other_districts_id}}"
                                 {{ $item->other_districts_id == $hd->other_districts_id ? 'selected' : '' }}>
                                {{$item->other_districts_name1}} ({{$item->Province->other_provinces_name1}})
                            </option>
                        @endforeach
                    </select>
                </div>     
                <div class="form-group">
                    <label for="other_sub_districts_name1" class="col-form-label">ชื่อภาษาไทย</label>
                    <input type="text" class="form-control" name="other_sub_districts_name1" id="other_sub_districts_name1" value="{{$hd->other_sub_districts_name1}}" required>
                </div>
                <div class="form-group">
                    <label for="other_sub_districts_name2" class="col-form-label">ชื่อภาษาอังกฤษ</label>
                    <input type="text" class="form-control" name="other_sub_districts_name2" id="other_sub_districts_name2" value="{{$hd->other_sub_districts_name2}}">
                </div>
                <div class="form-group">
                    <label for="other_sub_districts_zipcode" class="col-form-label">รหัสไปรษณีย์</label>
                    <input type="text" class="form-control" name="other_sub_districts_zipcode" id="other_sub_districts_zipcode" value="{{$hd->other_sub_districts_zipcode}}">
                </div>
                 <div class="col-xl-3 mb-3">
                    <label for="other_sub_districts_flag" class="form-label">Status</label>
                                <div class="input-group">
                                    <div class="d-flex">
                                        <div class="square-switch">
                                            <input type="checkbox" id="other_sub_districts_flag" switch="none" name="other_sub_districts_flag" value="true" checked/>                              
                                            <label for="other_sub_districts_flag" data-on-label="On" data-off-label="Off"></label>
                                        </div>
                                    </div>
                                </div>
                                @error('other_sub_districts_flag')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
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
</div>
</div>
@endsection
@push('scriptjs')
<script>
$(document).ready(function() {
    $('#other_districts_id').select2({
        placeholder: "กรุณาเลือกเขต/อำเภอ",
        allowClear: true,
        width: '100%'
    });
});
</script>
@endpush