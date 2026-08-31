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
        <form method="POST" class="form-horizontal" action="{{ route('ncr.store') }}" enctype="multipart/form-data">
                @csrf     
        <div class="row mb-3">
            <div class="col-12 col-md-6"><h3 class="card-title">เอกสาร NCR</h3></div>
        </div> 
        <div class="row mt-2">
            <div class="col-4">
                <div class="form-group">
                    <label class="form-label">วันที่พบปัญหา</label>
                    <input class="form-control" type="date" name="doc_ncrs_date" required>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label class="form-label">NCR No</label>
                    <input class="form-control" type="text" name="doc_ncrs_docuno" required>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label class="form-label">ผู้ตรวจพบ</label>
                    <input class="form-control" type="text" name="doc_ncrs_person" required>
                </div>
            </div>           
        </div>
        <div class="row mt-2">
            <h5>A.รายละเอียดความไม่สอดคล้องกับข้อกำหนด (รายละเอียดปัญหาที่พบ)</h5>
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">1.พบอะไร</label>
                    <textarea class="form-control" type="text" name="doc_ncrs_nonconformity" required></textarea>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label class="form-label">2.พบที่ไหน/กระบวนการใด</label>
                    <input class="form-control" type="text" name="doc_ncrs_process" required>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label class="form-label">3.พบเมื่อไร</label>
                    <input class="form-control" type="date" name="doc_ncrs_duedate" required>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label class="form-label">4.จำนวนเท่าไหร่</label>
                    <input class="form-control" type="text" name="doc_ncrs_product" required>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label class="form-label">5.ไม่ตรงกับข้อกำหนดอะไร</label>
                    <select class="form-control" name="doc_ncrs_type">
                        <option value="-">กรุณาเลือก</option>
                        <option value="Drawing No.">Drawing No.</option>
                        <option value="Specification">Specification</option>
                        <option value="WI">WI</option>
                        <option value="Control Plan">Control Plan</option>
                        <option value="Customer Requirement">Customer Requirement</option>
                        <option value="Procedure">Procedure</option>
                    </select>
                </div>
            </div>
            <div class="col-8">
                <div class="form-group">
                    <label class="form-label">6.ข้อกำหนด/เอกสารอ้างอิง</label>
                    <input class="form-control" type="text" name="doc_ncrs_project" required>
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
@endsection

@push('scriptjs')
<script>
</script>
@endpush