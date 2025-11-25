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
            <div class="col-12 col-md-6"><h3 class="card-title">ชื่อบริษัท</h3></div> 
        </div>
        <div class="row">            
            <div class="col-12">                
                <form method="POST" class="form-horizontal" action="{{ route('companys.update',$hd->acc_companies_id) }}" enctype="multipart/form-data">
                @csrf  
                @method('PUT')  
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="acc_companies_name1" class="col-form-label">ชื่อภาษาไทย</label>
                            <input type="text" class="form-control" name="acc_companies_name1" id="acc_companies_name1" value="{{$hd->acc_companies_name1}}" required>
                        </div>
                    </div>  
                    <div class="col-6">
                        <div class="form-group">
                            <label for="acc_companies_name2" class="col-form-label">ชื่อภาษาอังกฤษ</label>
                            <input type="text" class="form-control" name="acc_companies_name2" id="acc_companies_name2" value="{{$hd->acc_companies_name2}}">
                        </div>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="acc_companies_address1" class="col-form-label">ที่อยู่ภาษาไทย</label>
                            <input type="text" class="form-control" name="acc_companies_address1" id="acc_companies_address1" value="{{$hd->acc_companies_address1}}" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="acc_companies_address2" class="col-form-label">ที่อยู่ภาษาอังกฤษ</label>
                            <input type="text" class="form-control" name="acc_companies_address2" id="acc_companies_address2" value="{{$hd->acc_companies_address2}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="acc_companies_taxid" class="col-form-label">เลขที่ประจำตัวผู้เสียภาษี</label>
                            <input type="text" class="form-control" name="acc_companies_taxid" id="acc_companies_taxid" value="{{$hd->acc_companies_taxid}}" required>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="acc_companies_tel" class="col-form-label">เบอร์โทร</label>
                            <input type="text" class="form-control" name="acc_companies_tel" id="acc_companies_tel" value="{{$hd->acc_companies_tel}}" required>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="acc_companies_email" class="col-form-label">Email</label>
                            <input type="text" class="form-control" name="acc_companies_email" id="acc_companies_email" value="{{$hd->acc_companies_email}}" required>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="acc_companies_line" class="col-form-label">ID LINE</label>
                            <input type="text" class="form-control" name="acc_companies_line" id="acc_companies_line" value="{{$hd->acc_companies_line}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="acc_companies_website" class="col-form-label">Website</label>
                            <input type="text" class="form-control" name="acc_companies_website" id="acc_companies_website"  value="{{$hd->acc_companies_website}}">
                        </div>
                    </div>
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