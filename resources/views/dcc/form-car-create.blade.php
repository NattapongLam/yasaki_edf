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
        <form method="POST" class="form-horizontal" action="{{ route('car.store') }}" enctype="multipart/form-data">
        @csrf 
        <div class="row mb-3">
            <div class="col-12 col-md-6"><h3 class="card-title">เอกสาร CAR</h3></div>
        </div>     
        <div class="row mt-2">
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">เกี่ยวข้อง</label>
                    <select class="form-select" name="doc_cars_relevant" required>
                        <option value="-">กรุณาเลือก</option>
                        <option value="การรับเข้าสินค้าจากผู้ผลิต/ผู้จำหน่าย">การรับเข้าสินค้าจากผู้ผลิต/ผู้จำหน่าย</option>
                        <option value="ข้อร้องเรียนจากภายใน/ภายนอก">ข้อร้องเรียนจากภายใน/ภายนอก</option>
                        <option value="กระบวนการภายใน/ภายนอก">กระบวนการภายใน/ภายนอก</option>
                        <option value="อื่นๆ">อื่นๆ</option>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">วันที่รายงาน</label>
                    <input class="form-control" type="date" name="doc_cars_date" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">CAR NO.</label>
                    <input class="form-control" type="text" name="doc_cars_docuno" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">ประเภทความรุนแรง</label>
                    <select class="form-select" name="doc_cars_type" required>
                        <option value="-">กรุณาเลือก</option>
                        <option value="Major">Major</option>
                        <option value="Minor">Minor</option>
                    </select>
                </div>
            </div>
        </div> 
        <div class="row mt-2">
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">แผนก/หน่วยงานที่ออก</label>
                    <input class="form-control" type="text" name="doc_cars_issuingdep" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">แผนก/หน่วยงานที่เกี่ยวข้อง</label>
                    <input class="form-control" type="text" name="doc_cars_relevantdep" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">ผู้รายงาน</label>
                    <input class="form-control" type="text" name="doc_cars_person" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">เรื่องที่เกี่ยวข้อง</label>
                    <input class="form-control" type="text" name="doc_cars_topics" required>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">รายละเอียดข้อบกพร่องที่พบ</label>
                    <textarea class="form-control" name="doc_cars_defects" required></textarea>
                </div>
            </div>
        </div>    
        <div class="row mt-2">
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">รายการปัญหา</label>
                    <textarea class="form-control" name="doc_cars_problem" required></textarea>
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