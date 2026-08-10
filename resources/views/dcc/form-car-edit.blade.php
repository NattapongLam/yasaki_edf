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
 <form method="POST" class="form-horizontal" action="{{ route('car.update',$hd->doc_cars_id) }}" enctype="multipart/form-data">
        @csrf 
        @method('PUT') 
<div class="card">
    <div class="card-body">
       
        <div class="row mb-3">
            <div class="col-12 col-md-6"><h3 class="card-title">เอกสาร CAR</h3></div>
        </div>     
        <div class="row mt-2">
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">เกี่ยวข้อง</label>
                    <select class="form-select" name="doc_cars_relevant" required>
                        <option value="-">กรุณาเลือก</option>
                        <option value="การรับเข้าสินค้าจากผู้ผลิต/ผู้จำหน่าย" {{ (old('doc_cars_relevant', $hd->doc_cars_relevant) == 'การรับเข้าสินค้าจากผู้ผลิต/ผู้จำหน่าย') ? 'selected' : '' }}>การรับเข้าสินค้าจากผู้ผลิต/ผู้จำหน่าย</option>
                        <option value="ข้อร้องเรียนจากภายใน/ภายนอก" {{ (old('doc_cars_relevant', $hd->doc_cars_relevant) == 'ข้อร้องเรียนจากภายใน/ภายนอก') ? 'selected' : '' }}>ข้อร้องเรียนจากภายใน/ภายนอก</option>
                        <option value="กระบวนการภายใน/ภายนอก" {{ (old('doc_cars_relevant', $hd->doc_cars_relevant) == 'กระบวนการภายใน/ภายนอก') ? 'selected' : '' }}>กระบวนการภายใน/ภายนอก</option>
                        <option value="อื่นๆ" {{ (old('doc_cars_relevant', $hd->doc_cars_relevant) == 'อื่นๆ') ? 'selected' : '' }}>อื่นๆ</option>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">วันที่รายงาน</label>
                    <input class="form-control" type="date" name="doc_cars_date" value="{{$hd->doc_cars_date}}" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">CAR NO.</label>
                    <input class="form-control" type="text" name="doc_cars_docuno" value="{{$hd->doc_cars_docuno}}" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">ประเภทความรุนแรง</label>
                    <select class="form-select" name="doc_cars_type" required>
                        <option value="-">กรุณาเลือก</option>
                        <option value="Major" {{ (old('doc_cars_type', $hd->doc_cars_type) == 'Major') ? 'selected' : '' }}>Major</option>
                        <option value="Minor" {{ (old('doc_cars_type', $hd->doc_cars_type) == 'Minor') ? 'selected' : '' }}>Minor</option>
                    </select>
                </div>
            </div>
        </div> 
        <div class="row mt-2">
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">แผนก/หน่วยงานที่ออก</label>
                    <input class="form-control" type="text" name="doc_cars_issuingdep" value="{{$hd->doc_cars_issuingdep}}" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">แผนก/หน่วยงานที่เกี่ยวข้อง</label>
                    <input class="form-control" type="text" name="doc_cars_relevantdep" value="{{$hd->doc_cars_relevantdep}}" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">ผู้รายงาน</label>
                    <input class="form-control" type="text" name="doc_cars_person" value="{{$hd->doc_cars_person}}" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">เรื่องที่เกี่ยวข้อง</label>
                    <input class="form-control" type="text" name="doc_cars_topics" value="{{$hd->doc_cars_topics}}" required>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">รายละเอียดข้อบกพร่องที่พบ</label>
                    <textarea class="form-control" name="doc_cars_defects" required>{{$hd->doc_cars_defects}}</textarea>
                </div>
            </div>
        </div>    
        <div class="row mt-2">
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">รายการปัญหา</label>
                    <textarea class="form-control" name="doc_cars_problem" required>{{$hd->doc_cars_problem}}</textarea>
                </div>
            </div>
        </div> 
          
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row mt-2">
            <div class="col-12">
                <div class="form-group">
                        <label class="form-label">สาเหตุของข้อบกพร่อง</label>
                        <textarea class="form-control" name="doc_cars_cause" required>{{$hd->doc_cars_cause}}</textarea>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="form-group">
                        <label class="form-label">การแก้ไขปัญหาเพื่อกำจัดสาเหตุของปัญหา(ขั้นตอนการปฏิบัติ)</label>
                        <textarea class="form-control" name="doc_cars_solving" rows="5" required>{{$hd->doc_cars_solving}}</textarea>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="form-group">
                        <label class="form-label">การป้องกันไม่ให้ปัญหาเกิดซ้ำ</label>
                        <textarea class="form-control" name="doc_cars_preventing" required>{{$hd->doc_cars_preventing}}</textarea>
                </div>
            </div>
        </div>
         <div class="row mt-2">
                <div class="col-4">
                    <div class="form-group">
                    <label class="form-label">ผู้รับผิดชอบ</label>
                    <input class="form-control"  name="responsible_at" readonly>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                    <label class="form-label">วันที่จะแล้วเสร็จ</label>
                    <input class="form-control" type="date" name="responsible_date"  value="{{$hd->responsible_date}}" required>
                    </div>
                </div>
            </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row mt-2">
                <div class="col-4">
                    <div class="form-group">
                        <label class="form-label">ผู้จัดการฝ่าย/หัวหน้างาน</label>
                        <input class="form-control"  name="review_at" readonly>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label class="form-label">วันที่เสร็จเรียบร้อย</label>
                        <input class="form-control" type="date" name="review_date"  value="{{$hd->review_date}}">
                    </div>
                </div>
            </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-12 col-md-6"><h3 class="card-title text-danger">ประเมินการแก้ไขข้อบกพร่อง/สรุปผลการตรวจติดตาม</h3></div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">รายละเอียด</label>
                    <select class="form-control" name="doc_cars_details">
                        <option value="-">กรุณาเลือก</option>
                        <option value="การแก้ไขข้อบกพร่องที่อาจเกิดขึ้น-แล้วเสร็จ" {{ (old('doc_cars_details', $hd->doc_cars_details) == 'การแก้ไขข้อบกพร่องที่อาจเกิดขึ้น-แล้วเสร็จ') ? 'selected' : '' }}>
                            การแก้ไขข้อบกพร่องที่อาจเกิดขึ้น-แล้วเสร็จ
                        </option>
                        <option value="อธิบายประสิทธิผลจากการแก้ไข/สิ่งที่ตรวจพบจากการแก้ไข" {{ (old('doc_cars_details', $hd->doc_cars_details) == 'อธิบายประสิทธิผลจากการแก้ไข/สิ่งที่ตรวจพบจากการแก้ไข') ? 'selected' : '' }}>
                            อธิบายประสิทธิผลจากการแก้ไข/สิ่งที่ตรวจพบจากการแก้ไข
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-9">
                <div class="form-group">
                    <label class="form-label">เพิ่มเติม</label>
                    <input class="form-control" type="text" name="doc_cars_remark" value="{{$hd->doc_cars_remark}}">
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">สรุป</label>
                    <select class="form-control" name="doc_cars_summarize">
                        <option value="-">กรุณาเลือก</option>
                        <option value="แก้ไขแล้วเสร็จ" {{ (old('doc_cars_summarize', $hd->doc_cars_summarize) == 'แก้ไขแล้วเสร็จ') ? 'selected' : '' }}>
                            แก้ไขแล้วเสร็จ
                        </option>
                        <option value="แก้ไขบางส่วน" {{ (old('doc_cars_summarize', $hd->doc_cars_summarize) == 'แก้ไขบางส่วน') ? 'selected' : '' }}>
                            แก้ไขบางส่วน
                        </option>
                        <option value="ไม่สามารถแก้ไขได้ออก CAR ฉบับใหม่" {{ (old('doc_cars_summarize', $hd->doc_cars_summarize) == 'ไม่สามารถแก้ไขได้ออก CAR ฉบับใหม่') ? 'selected' : '' }}>
                            ไม่สามารถแก้ไขได้ออก CAR ฉบับใหม่
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">เลขที่ CAR ฉบับใหม่</label>
                    <input class="form-control" type="text" name="doc_cars_newdocuno" value="{{$hd->doc_cars_newdocuno}}">
                </div>
            </div>
            <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">ติดตามเรื่องโดย</label>
                        <input class="form-control"  name="follow_at" readonly>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">วันที่ติดตาม</label>
                        <input class="form-control" type="date"  name="follow_date" value="{{$hd->follow_date}}">
                    </div>
                </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row mt-2">
                <div class="col-4">
                    <div class="form-group">
                        <label class="form-label">Laed/QMR</label>
                        <input class="form-control"  name="approved_at" readonly>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label class="form-label">วันที่เสร็จเรียบร้อย</label>
                        <input class="form-control" type="date" name="approved_date"  value="{{$hd->approved_date}}" >
                    </div>
                </div>
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
@endsection
@push('scriptjs')
<script>
</script>
@endpush