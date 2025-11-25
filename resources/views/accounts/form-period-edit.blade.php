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
            <div class="col-12 col-md-6"><h3 class="card-title">งวดบัญชี</h3></div> 
        </div>
        <div class="row">            
            <div class="col-12">
                <form method="POST" class="form-horizontal" action="{{ route('periods.update',$hd->acc_periods_id) }}" enctype="multipart/form-data">
                @csrf       
                @method('PUT')
                <div class="form-group">
                    <label for="acc_companies_year" class="col-form-label">ปี</label>
                    <input type="text" class="form-control" name="acc_companies_year" id="acc_companies_year" value="{{$hd->acc_companies_year}}" required>
                </div>
                <div class="form-group">
                    <label for="acc_companies_date1" class="col-form-label">วันที่เริ่ม</label>
                    <input type="date" class="form-control" name="acc_companies_date1" id="acc_companies_date1" value="{{$hd->acc_companies_date1}}" required>
                </div>
                <div class="form-group">
                    <label for="acc_companies_date2" class="col-form-label">วันที่จบ</label>
                    <input type="date" class="form-control" name="acc_companies_date2" id="acc_companies_date2" value="{{$hd->acc_companies_date2}}" required>
                </div>
                <div class="col-xl-3 mb-3">
                    <label for="acc_companies_flag" class="form-label">เปิด-ปิดงวดบัญชี</label>
                                <div class="input-group">
                                    <div class="d-flex">
                                        <div class="square-switch">
                                            <input type="checkbox" id="acc_companies_flag" switch="none" name="acc_companies_flag" value="true" checked/>                              
                                            <label for="acc_companies_flag" data-on-label="On" data-off-label="Off"></label>
                                        </div>
                                    </div>
                                </div>
                                @error('acc_companies_flag')
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
</script>
@endpush