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
            <div class="col-12 col-md-6"><h3 class="card-title">จัดการเคมี</h3></div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_groups_name" class="col-form-label">วันที่</label>
                    <input type="text" class="form-control" name="chemical_groups_name" id="chemical_groups_name" required>
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