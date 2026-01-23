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
            <div class="col-12 col-md-6"><h3 class="card-title">กลุ่มลูกค้า</h3></div> 
        </div>
        <div class="row">            
            <div class="col-12">
                <form method="POST" class="form-horizontal" action="{{ route('customergroups.update',$hd->ar_customer_groups_id) }}" enctype="multipart/form-data">
                @csrf    
                @method('PUT')   
                <div class="form-group">
                    <label for="ar_customer_groups_code" class="col-form-label">รหัส</label>
                    <input type="text" class="form-control" name="ar_customer_groups_code" id="ar_customer_groups_code" value="{{$hd->ar_customer_groups_code}}" required>
                </div>
                <div class="form-group">
                    <label for="ar_customer_groups_name" class="col-form-label">ชื่อ</label>
                    <input type="text" class="form-control" name="ar_customer_groups_name" id="ar_customer_groups_name" value="{{$hd->ar_customer_groups_name}}" required>
                </div>
                <div class="col-xl-3 mb-3">
                    <label for="ar_customer_groups_flag" class="form-label">Status</label>
                                <div class="input-group">
                                    <div class="d-flex">
                                        <div class="square-switch">
                                            @if($hd->ar_customer_groups_flag == 1)
                                                <input type="checkbox" id="square-switch1" switch="none" name="ar_customer_groups_flag" value="true" checked/>
                                            @else
                                                <input type="checkbox" id="square-switch1" switch="none" name="ar_customer_groups_flag" />
                                            @endif
                                                <label for="square-switch1" data-on-label="On" data-off-label="Off"></label>
                                        </div>
                                    </div>
                                </div>
                                @error('ar_customer_groups_flag')
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