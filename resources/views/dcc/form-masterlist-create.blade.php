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
            <form method="POST" class="form-horizontal" action="{{ route('master-list.store') }}" enctype="multipart/form-data">
                @csrf 
                
                <h3 class="card-title mb-3">ทะเบียนเอกสารควบคุม</h3>

                <!-- แถวที่ 1 -->
                <div class="row mt-2"> 
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label class="form-label">วันที่ขึ้นทะเบียน</label>
                            <input class="form-control" type="date" name="doc_master_lists_date" value="{{ old('doc_master_lists_date') }}">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label class="form-label">ประเภท</label>
                            <input class="form-control" type="text" name="doc_master_lists_type" value="{{ old('doc_master_lists_type') }}">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label class="form-label">เลขที่เอกสาร</label>
                            <input class="form-control" type="text" name="doc_master_lists_docuno" value="{{ old('doc_master_lists_docuno') }}">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label class="form-label">สถานะ</label>
                            <select class="form-select" name="doc_master_lists_status">
                                <option value="">กรุณาเลือก</option>
                                <option value="สร้างใหม่" {{ old('doc_master_lists_status') == 'สร้างใหม่' ? 'selected' : '' }}>สร้างใหม่</option>
                                <option value="แก้ไข" {{ old('doc_master_lists_status') == 'แก้ไข' ? 'selected' : '' }}>แก้ไข</option>
                                <option value="ยกเลิก" {{ old('doc_master_lists_status') == 'ยกเลิก' ? 'selected' : '' }}>ยกเลิก</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- แถวที่ 2 -->
                <div class="row mt-2">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="form-label">ชื่อเอกสาร</label>
                            <input class="form-control" type="text" name="doc_master_lists_docuname" value="{{ old('doc_master_lists_docuname') }}">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label class="form-label">แผนก</label>
                            <input class="form-control" type="text" name="doc_master_lists_department" value="{{ old('doc_master_lists_department') }}">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label class="form-label">สถานที่จัดเก็บ</label>
                            <input class="form-control" type="text" name="doc_master_lists_location" value="{{ old('doc_master_lists_location') }}">
                        </div>
                    </div>
                </div>

                <!-- แถวที่ 3 -->
                <div class="row mt-2">
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="doc_master_lists_file1" class="form-label">แนบไฟล์ 1</label>
                            <input type="file" class="form-control" id="inputGroupFile01" name="doc_master_lists_file1">
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="doc_master_lists_file2" class="form-label">แนบไฟล์ 2</label>
                            <input type="file" class="form-control" id="inputGroupFile02" name="doc_master_lists_file2">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="form-label">หมายเหตุ</label>
                            <input class="form-control" type="text" name="doc_master_lists_note" value="{{ old('doc_master_lists_note') }}">
                        </div>
                    </div>
                </div>

                <!-- แถวที่ 4: Checkboxes (00 ถึง 11) -->
                <div class="row mt-3">
                    @foreach(['00','01','02','03','04','05','06','07','08','09','10','11'] as $opt)
                    <div class="col-1">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check-{{ $opt }}" name="doc_master_lists_options[]" value="{{ $opt }}">
                            <label class="form-check-label" for="check-{{ $opt }}">{{ $opt }}</label>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- ปุ่มบันทึก -->
                <div class="row mt-4">
                    <div class="col-12 col-md-2">
                        <button type="submit" class="btn btn-block btn-primary w-100">
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
function prevFile(input, elm) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.' + elm).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush