@extends('layouts.main')
@section('content')
<div class="row">
<div class="card">
    <div class="card-body">
        <form method="POST" class="form-horizontal" action="{{ route('master-list.update', $data->doc_master_lists_id) }}" enctype="multipart/form-data">
            @csrf 
            @method('PUT') <!-- สำคัญสำหรับการ Update ข้อมูลใน Laravel -->
            
            <h3 class="card-title mb-3">แก้ไขทะเบียนเอกสารควบคุม</h3>

            <!-- แถวที่ 1 -->
            <div class="row mt-2"> 
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">วันที่ขึ้นทะเบียน</label>
                        <input class="form-control" type="date" name="doc_master_lists_date" value="{{ old('doc_master_lists_date', $data->doc_master_lists_date) }}">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">ประเภท</label>
                        <input class="form-control" type="text" name="doc_master_lists_type" value="{{ old('doc_master_lists_type', $data->doc_master_lists_type) }}">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">เลขที่เอกสาร</label>
                        <input class="form-control" type="text" name="doc_master_lists_docuno" value="{{ old('doc_master_lists_docuno', $data->doc_master_lists_docuno) }}">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">สถานะ</label>
                        <select class="form-select" name="doc_master_lists_status">
                            <option value="">กรุณาเลือก</option>
                            <option value="สร้างใหม่" {{ (old('doc_master_lists_status', $data->doc_master_lists_status) == 'สร้างใหม่') ? 'selected' : '' }}>สร้างใหม่</option>
                            <option value="แก้ไข" {{ (old('doc_master_lists_status', $data->doc_master_lists_status) == 'แก้ไข') ? 'selected' : '' }}>แก้ไข</option>
                            <option value="ยกเลิก" {{ (old('doc_master_lists_status', $data->doc_master_lists_status) == 'ยกเลิก') ? 'selected' : '' }}>ยกเลิก</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- แถวที่ 2 -->
            <div class="row mt-2">
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label class="form-label">ชื่อเอกสาร</label>
                        <input class="form-control" type="text" name="doc_master_lists_docuname" value="{{ old('doc_master_lists_docuname', $data->doc_master_lists_docuname) }}">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">แผนก</label>
                        <input class="form-control" type="text" name="doc_master_lists_department" value="{{ old('doc_master_lists_department', $data->doc_master_lists_department) }}">
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label class="form-label">สถานที่จัดเก็บ</label>
                        <input class="form-control" type="text" name="doc_master_lists_location" value="{{ old('doc_master_lists_location', $data->doc_master_lists_location) }}">
                    </div>
                </div>
            </div>

            <!-- แถวที่ 3: ไฟล์แนบ -->
            <div class="row mt-2">
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="doc_master_lists_file1" class="form-label">แนบไฟล์ 1 (เปลี่ยนใหม่)</label>
                        <input type="file" class="form-control" name="doc_master_lists_file1">
                        @if($data->doc_master_lists_file1)
                            <small class="text-muted">ไฟล์เดิม: <a href="{{ asset('storage/' . $data->doc_master_lists_file1) }}" target="_blank">1</a></small>
                        @endif
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="doc_master_lists_file2" class="form-label">แนบไฟล์ 2 (เปลี่ยนใหม่)</label>
                        <input type="file" class="form-control" name="doc_master_lists_file2">
                        @if($data->doc_master_lists_file2)
                            <small class="text-muted">ไฟล์เดิม: <a href="{{ asset('storage/' . $data->doc_master_lists_file2) }}" target="_blank">2</a></small>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label class="form-label">หมายเหตุ</label>
                        <input class="form-control" type="text" name="doc_master_lists_note" value="{{ old('doc_master_lists_note', $data->doc_master_lists_note) }}">
                    </div>
                </div>
            </div>

            <!-- แถวที่ 4: Checkboxes (00 ถึง 11) - เช็คค่าเดิมที่เคยเลือกไว้ -->
            <div class="row mt-3">
                @php
                    // ดึงค่า array เดิมจากฐานข้อมูล (เนื่องจากเรา cast ไว้เป็น array แล้ว)
                    $selectedOptions = old('doc_master_lists_options', $data->doc_master_lists_options ?? []);
                @endphp
                @foreach(['00','01','02','03','04','05','06','07','08','09','10','11'] as $opt)
                <div class="col-1">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="check-{{ $opt }}" name="doc_master_lists_options[]" value="{{ $opt }}"
                            {{ in_array($opt, $selectedOptions) ? 'checked' : '' }}>
                        <label class="form-check-label" for="check-{{ $opt }}">{{ $opt }}</label>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- ปุ่มบันทึกการแก้ไข -->
            <div class="row mt-4">
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-block btn-success w-100">
                        บันทึกการแก้ไข
                    </button>
                </div>
                <div class="col-12 col-md-2">
                    <a href="{{ route('master-list.index') }}" class="btn btn-secondary w-100">ย้อนกลับ</a>
                </div>
            </div>

        </form> 
    </div>
</div>
</div>
@endsection