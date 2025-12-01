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
            <div class="col-12 col-md-6"><h3 class="card-title">ประเภทครื่องมือวัด</h3></div> 
        </div>
        <div class="row">            
            <div class="col-12">
                <form method="POST" class="form-horizontal" action="{{ route('calibrationtypes.update',$hd->calibration_types_id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')       
                <div class="form-group">
                    <label for="calibration_types_code" class="col-form-label">รหัส</label>
                    <input type="text" class="form-control" name="calibration_types_code" id="calibration_types_code" value="{{$hd->calibration_types_code}}" readonly>
                </div>
                <div class="form-group">
                    <label for="calibration_types_name" class="col-form-label">ชื่อ</label>
                    <input type="text" class="form-control" name="calibration_types_name" id="calibration_types_name" value="{{$hd->calibration_types_name}}" required>
                </div>
                  <div class="col-xl-3 mb-3">
                    <label for="calibration_types_flag" class="form-label">Status</label>
                                <div class="input-group">
                                    <div class="d-flex">
                                        <div class="square-switch">
                                            <input type="checkbox" id="calibration_types_flag" switch="none" name="calibration_types_flag" value="true" checked/>                              
                                            <label for="calibration_types_flag" data-on-label="On" data-off-label="Off"></label>
                                        </div>
                                    </div>
                                </div>
                                @error('calibration_types_flag')
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
    $('#tb_job').DataTable({
        "pageLength": 10,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    })
});
</script>
@endpush