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
            <div class="col-12 col-md-6"><h3 class="card-title">ประเภทภาษี</h3></div> 
        </div>
        <div class="row">            
            <div class="col-12">
                <form method="POST" class="form-horizontal" action="{{ route('typevats.update',$hd->acc_typevats_id) }}" enctype="multipart/form-data">
                @csrf       
                @method('PUT')
                <div class="form-group">
                    <label for="acc_typevats_code" class="col-form-label">รหัส</label>
                    <input type="text" class="form-control" name="acc_typevats_code" id="acc_typevats_code" value="{{$hd->acc_typevats_code}}" required>
                </div>
                <div class="form-group">
                    <label for="acc_typevats_rate" class="col-form-label">อัตรา</label>
                    <input type="text" class="form-control" name="acc_typevats_rate" id="acc_typevats_rate" value="{{$hd->acc_typevats_rate}}" required>
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