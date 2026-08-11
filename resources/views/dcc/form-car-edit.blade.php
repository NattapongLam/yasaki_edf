@extends('layouts.main')
@push('styles')
<style>
/* ---------------------------------------------------- */
/* สไตล์ภาพรวมเอกสารสำหรับการแสดงผลบนหน้าจอ              */
/* ---------------------------------------------------- */
.car-container {
    background-color: #f4f6f9;
    padding: 15px 0;
}
.iso-card {
    border: 1.5px solid #64748b;
    border-radius: 4px;
    margin-bottom: 8px;
    background-color: #ffffff;
}
.iso-card-header {
    background-color: #1e293b;
    color: #ffffff;
    padding: 5px 10px;
    font-size: 12px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.iso-card-header.danger-header {
    background-color: #7f1d1d;
}
.iso-card-body {
    padding: 8px 10px;
}
.form-label {
    font-size: 11.5px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 2px;
}
.form-control, .form-select {
    font-size: 12px;
    padding: 5px 8px;
    border-color: #cbd5e1;
    border-radius: 3px;
}

/* หัวเอกสารควบคุม (ISO Header Table) */
.iso-header-table {
    width: 100%;
    border-collapse: collapse;
    border: 2px solid #000;
    margin-bottom: 8px;
    background-color: #fff;
}
.iso-header-table td, .iso-header-table th {
    border: 1px solid #000;
    padding: 5px 8px;
    vertical-align: middle;
}

/* ---------------------------------------------------- */
/* ตั้งค่าการสั่งพิมพ์ (Print Mode: ปรับกระชับเพื่อไม่ให้ตกหน้า) */
/* ---------------------------------------------------- */
@media print {
    @page {
        size: A4 portrait;
        margin: 4mm 6mm; 
    }
    html, body {
        background-color: #ffffff !important;
        color: #000000 !important;
        font-size: 10pt !important;
        margin: 0 !important;
        padding: 0 !important;
        -webkit-print-color-adjust: exact;
    }
    .car-container {
        padding: 0 !important;
        background-color: #ffffff !important;
    }
    .d-print-none {
        display: none !important;
    }

    /* ล็อคขนาดแต่ละหน้าไม่ให้ล้น (Force Exactly 2 Pages) */
    .car-page {
        height: 286mm !important;
        max-height: 286mm !important;
        box-sizing: border-box !important;
        overflow: hidden !important;
        page-break-after: always !important;
        break-after: page !important;
    }
    .car-page:last-child {
        page-break-after: avoid !important;
        break-after: avoid !important;
    }

    /* ปรับระยะห่างและขนาดของการ์ด สำหรับการพิมพ์ */
    .iso-card {
        border: 1px solid #000 !important;
        box-shadow: none !important;
        margin-bottom: 4px !important;
    }
    .iso-card-header {
        background-color: #e2e8f0 !important;
        color: #000 !important;
        border-bottom: 1px solid #000 !important;
        padding: 4px 8px !important;
        font-size: 10pt !important;
        -webkit-print-color-adjust: exact;
    }
    .iso-card-header.danger-header {
        background-color: #fecaca !important;
        color: #000 !important;
    }
    .iso-card-body {
        padding: 5px 8px !important;
    }
    .iso-header-table {
        border: 1.5px solid #000 !important;
        margin-bottom: 4px !important;
    }
    .iso-header-table td, .iso-header-table th {
        border: 1px solid #000 !important;
        padding: 4px 6px !important;
    }
    
    .row {
        --bs-gutter-y: 0.15rem !important;
        --bs-gutter-x: 0.4rem !important;
    }
    .form-label {
        margin-bottom: 1px !important;
        font-size: 9.5pt !important;
    }
    .form-control, .form-select {
        border: none !important;
        border-bottom: 1px dotted #475569 !important;
        border-radius: 0 !important;
        padding: 1px 0 !important;
        height: 21px !important;
        min-height: 21px !important;
        background-color: transparent !important;
        box-shadow: none !important;
        font-size: 10pt !important;
    }
    
    /* ควบคุมขนาด Textarea ขณะพิมพ์ให้พอดี ไม่อ้วนจนดันตกหน้า */
    textarea.form-control {
        border: 1px solid #64748b !important;
        height: 38px !important;
        min-height: 38px !important;
        padding: 3px !important;
        resize: none;
        font-size: 9.5pt !important;
    }
}
</style>
@endpush

@section('content')
<div class="container-fluid car-container">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-print-none py-1 mb-2" role="alert">
        <i class="mdi mdi-check-all me-1"></i> {{ session('success-message') ?? session('success') }}
        <button type="button" class="btn-close py-1" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif(session('error'))
    <div class="alert alert-danger alert-dismissible fade show d-print-none py-1 mb-2" role="alert">
        <i class="mdi mdi-block-helper me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close py-1" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form method="POST" class="form-horizontal" action="{{ route('car.update', $hd->doc_cars_id) }}" enctype="multipart/form-data">
        @csrf 
        @method('PUT') 

        <!-- ปุ่มสั่งพิมพ์ (ซ่อนตอนพิมพ์) -->
        <div class="row mb-3 align-items-center d-print-none">
            <div class="col-6">
                <span class="text-muted fw-bold" style="font-size: 13px;"><i class="mdi mdi-file-document-outline me-1"></i> ระบบควบคุมคุณภาพ ISO/IEC 17025 (หน้า 1 พอดีเป๊ะ)</span>
            </div>
            <div class="col-6 text-end">
                <button type="button" class="btn btn-dark btn-sm shadow-sm py-1.5 px-3" style="font-size: 12px;" onclick="window.print()">
                    <i class="mdi mdi-printer me-1"></i> พิมพ์เอกสาร (2 หน้า A4)
                </button>
            </div>
        </div>

        <!-- =================================================== -->
        <!--                     หน้ากระดาษที่ 1                  -->
        <!-- =================================================== -->
        <div class="car-page">
            <!-- หัวเอกสารควบคุม (ISO Header Table) - หน้า 1 -->
            <table class="iso-header-table">
                <tr>
                    <td rowspan="2" style="width: 18%; text-align: center; background-color: #f8fafc;">
                        <img src="{{ URL::asset('assets/images/KK-C.png') }}" alt="Logo" width="70%">
                    </td>
                    <td style="width: 52%; text-align: center; background-color: #f8fafc;">
                        <span class="fw-bold" style="font-size: 13px;">ใบรายงานการแก้ไขข้อบกพร่อง (CORRECTIVE ACTION REPORT - CAR)</span>
                    </td>
                    <td style="width: 15%; font-size: 10.5px;"><b>รหัสเอกสาร:</b> FM-QA-01</td>
                    <td style="width: 15%; font-size: 10.5px;"><b>แก้ไขครั้งที่:</b> 01</td>
                </tr>
                <tr>
                    <td style="text-align: center; font-size: 10.5px; color: #475569;">
                        ตามข้อกำหนดมาตรฐานระบบบริหารงานห้องปฏิบัติการ ISO/IEC 17025
                    </td>
                    <td style="font-size: 10.5px;"><b>มีผลบังคับใช้:</b> 01/01/2026</td>
                    <td style="font-size: 10.5px;"><b>หน้า:</b> 1 / 2</td>
                </tr>
            </table>

            <!-- ส่วนที่ 1: รายละเอียดข้อบกพร่อง -->
            <div class="iso-card">
                <div class="iso-card-header">
                    <span>ส่วนที่ 1: รายละเอียดข้อบกพร่อง (Description of Nonconformity)</span>
                </div>
                <div class="iso-card-body">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label class="form-label">เกี่ยวข้อง</label>
                            <select class="form-select" name="doc_cars_relevant" required>
                                <option value="-">กรุณาเลือก</option>
                                <option value="การรับเข้าสินค้าจากผู้ผลิต/ผู้จำหน่าย" {{ (old('doc_cars_relevant', $hd->doc_cars_relevant) == 'การรับเข้าสินค้าจากผู้ผลิต/ผู้จำหน่าย') ? 'selected' : '' }}>การรับเข้าสินค้าจากผู้ผลิต/ผู้จำหน่าย</option>
                                <option value="ข้อร้องเรียนจากภายใน/ภายนอก" {{ (old('doc_cars_relevant', $hd->doc_cars_relevant) == 'ข้อร้องเรียนจากภายใน/ภายนอก') ? 'selected' : '' }}>ข้อร้องเรียนจากภายใน/ภายนอก</option>
                                <option value="กระบวนการภายใน/ภายนอก" {{ (old('doc_cars_relevant', $hd->doc_cars_relevant) == 'กระบวนการภายใน/ภายนอก') ? 'selected' : '' }}>กระบวนการภายใน/ภายนอก</option>
                                <option value="อื่นๆ" {{ (old('doc_cars_relevant', $hd->doc_cars_relevant) == 'อื่นๆ') ? 'selected' : '' }}>อื่นๆ</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">วันที่รายงาน</label>
                            <input class="form-control" type="date" name="doc_cars_date" value="{{$hd->doc_cars_date}}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">CAR NO.</label>
                            <input class="form-control fw-bold text-danger" type="text" name="doc_cars_docuno" value="{{$hd->doc_cars_docuno}}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">ประเภทความรุนแรง</label>
                            <select class="form-select" name="doc_cars_type" required>
                                <option value="-">กรุณาเลือก</option>
                                <option value="Major" {{ (old('doc_cars_type', $hd->doc_cars_type) == 'Major') ? 'selected' : '' }}>Major</option>
                                <option value="Minor" {{ (old('doc_cars_type', $hd->doc_cars_type) == 'Minor') ? 'selected' : '' }}>Minor</option>
                            </select>
                        </div>
                    </div> 

                    <div class="row g-2 mt-1">
                        <div class="col-md-3">
                            <label class="form-label">แผนก/หน่วยงานที่ออก</label>
                            <input class="form-control" type="text" name="doc_cars_issuingdep" value="{{$hd->doc_cars_issuingdep}}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">แผนก/หน่วยงานที่เกี่ยวข้อง</label>
                            <input class="form-control" type="text" name="doc_cars_relevantdep" value="{{$hd->doc_cars_relevantdep}}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">ผู้รายงาน</label>
                            <input class="form-control" type="text" name="doc_cars_person" value="{{$hd->doc_cars_person}}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">เรื่องที่เกี่ยวข้อง</label>
                            <input class="form-control" type="text" name="doc_cars_topics" value="{{$hd->doc_cars_topics}}" required>
                        </div>
                    </div>

                    <div class="row g-2 mt-1">
                        <div class="col-12">
                            <label class="form-label">รายละเอียดข้อบกพร่องที่พบ (Description of Nonconformity)</label>
                            <textarea class="form-control" name="doc_cars_defects" rows="2" required>{{$hd->doc_cars_defects}}</textarea>
                        </div>
                    </div>    
                    
                    <div class="row g-2 mt-1">
                        <div class="col-12">
                            <label class="form-label">รายการปัญหา (Problem Statement)</label>
                            <textarea class="form-control" name="doc_cars_problem" rows="2" required>{{$hd->doc_cars_problem}}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ส่วนที่ 2: การวิเคราะห์และแก้ไขปัญหา -->
            <div class="iso-card">
                <div class="iso-card-header">
                    <span>ส่วนที่ 2: การวิเคราะห์สาเหตุและการดำเนินการแก้ไข (Root Cause & Corrective Action)</span>
                </div>
                <div class="iso-card-body">
                    <div class="row g-2">
                        <div class="col-12">
                            <label class="form-label">สาเหตุของข้อบกพร่อง (Root Cause Analysis)</label>
                            <textarea class="form-control" name="doc_cars_cause" rows="2" required>{{$hd->doc_cars_cause}}</textarea>
                        </div>
                    </div>

                    <div class="row g-2 mt-1">
                        <div class="col-12">
                            <label class="form-label">การแก้ไขปัญหาเพื่อกำจัดสาเหตุของปัญหา (Corrective Action / Action Plan)</label>
                            <textarea class="form-control" name="doc_cars_solving" rows="2" required>{{$hd->doc_cars_solving}}</textarea>
                        </div>
                    </div>

                    <div class="row g-2 mt-1">
                        <div class="col-12">
                            <label class="form-label">การป้องกันไม่ให้ปัญหาเกิดซ้ำ (Preventive Action)</label>
                            <textarea class="form-control" name="doc_cars_preventing" rows="2" required>{{$hd->doc_cars_preventing}}</textarea>
                        </div>
                    </div>

                    <div class="row g-2 mt-1">
                        <div class="col-md-6">
                            <label class="form-label">ผู้รับผิดชอบ (Responsible Person)</label>
                            <input class="form-control" name="responsible_at" value="{{ $hd->responsible_at ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">วันที่จะแล้วเสร็จ (Target Completion Date)</label>
                            <input class="form-control" type="date" name="responsible_date" value="{{$hd->responsible_date}}" required>
                        </div>
                    </div>

                    <div class="row g-2 mt-1">
                        <div class="col-md-6">
                            <label class="form-label">ผู้จัดการฝ่าย/หัวหน้างาน (Reviewer)</label>
                            <input class="form-control" name="review_at" value="{{ $hd->review_at ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">วันที่ดำเนินการเสร็จเรียบร้อย</label>
                            <input class="form-control" type="date" name="review_date" value="{{$hd->review_date}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- =================================================== -->
        <!--                     หน้ากระดาษที่ 2                  -->
        <!-- =================================================== -->
        <div class="car-page">
            <!-- หัวเอกสารควบคุม (ISO Header Table) - หน้า 2 -->
            <table class="iso-header-table">
                <tr>
                    <td rowspan="2" style="width: 18%; text-align: center; background-color: #f8fafc;">
                        <img src="{{ URL::asset('assets/images/KK-C.png') }}" alt="Logo" width="70%">
                    </td>
                    <td style="width: 52%; text-align: center; background-color: #f8fafc;">
                        <span class="fw-bold" style="font-size: 13px;">ใบรายงานการแก้ไขข้อบกพร่อง (CORRECTIVE ACTION REPORT - CAR)</span>
                    </td>
                    <td style="width: 15%; font-size: 10.5px;"><b>รหัสเอกสาร:</b> FM-QA-01</td>
                    <td style="width: 15%; font-size: 10.5px;"><b>แก้ไขครั้งที่:</b> 01</td>
                </tr>
                <tr>
                    <td style="text-align: center; font-size: 10.5px; color: #475569;">
                        ตามข้อกำหนดมาตรฐานระบบบริหารงานห้องปฏิบัติการ ISO/IEC 17025
                    </td>
                    <td style="font-size: 10.5px;"><b>มีผลบังคับใช้:</b> 01/01/2026</td>
                    <td style="font-size: 10.5px;"><b>หน้า:</b> 2 / 2</td>
                </tr>
            </table>

            <!-- ส่วนที่ 3: ประเมินการแก้ไขข้อบกพร่อง/สรุปผล -->
            <div class="iso-card">
                <div class="iso-card-header danger-header">
                    <span>ส่วนที่ 3: ประเมินการแก้ไขข้อบกพร่อง / สรุปผลการตรวจติดตาม (Verification & Follow-up)</span>
                </div>
                <div class="iso-card-body">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label">รายละเอียดการประเมิน</label>
                            <select class="form-select" name="doc_cars_details">
                                <option value="-">กรุณาเลือก</option>
                                <option value="การแก้ไขข้อบกพร่องที่อาจเกิดขึ้น-แล้วเสร็จ" {{ (old('doc_cars_details', $hd->doc_cars_details) == 'การแก้ไขข้อบกพร่องที่อาจเกิดขึ้น-แล้วเสร็จ') ? 'selected' : '' }}>การแก้ไขข้อบกพร่องที่อาจเกิดขึ้น-แล้วเสร็จ</option>
                                <option value="อธิบายประสิทธิผลจากการแก้ไข/สิ่งที่ตรวจพบจากการแก้ไข" {{ (old('doc_cars_details', $hd->doc_cars_details) == 'อธิบายประสิทธิผลจากการแก้ไข/สิ่งที่ตรวจพบจากการแก้ไข') ? 'selected' : '' }}>อธิบายประสิทธิผลจากการแก้ไข/สิ่งที่ตรวจพบจากการแก้ไข</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">เพิ่มเติม</label>
                            <input class="form-control" type="text" name="doc_cars_remark" value="{{$hd->doc_cars_remark}}">
                        </div>
                    </div>

                    <div class="row g-2 mt-2">
                        <div class="col-md-3">
                            <label class="form-label">สรุปผล</label>
                            <select class="form-select" name="doc_cars_summarize">
                                <option value="-">กรุณาเลือก</option>
                                <option value="แก้ไขแล้วเสร็จ" {{ (old('doc_cars_summarize', $hd->doc_cars_summarize) == 'แก้ไขแล้วเสร็จ') ? 'selected' : '' }}>แก้ไขแล้วเสร็จ</option>
                                <option value="แก้ไขบางส่วน" {{ (old('doc_cars_summarize', $hd->doc_cars_summarize) == 'แก้ไขบางส่วน') ? 'selected' : '' }}>แก้ไขบางส่วน</option>
                                <option value="ไม่สามารถแก้ไขได้ออก CAR ฉบับใหม่" {{ (old('doc_cars_summarize', $hd->doc_cars_summarize) == 'ไม่สามารถแก้ไขได้ออก CAR ฉบับใหม่') ? 'selected' : '' }}>ไม่สามารถแก้ไขได้ออก CAR ฉบับใหม่</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">เลขที่ CAR ฉบับใหม่</label>
                            <input class="form-control" type="text" name="doc_cars_newdocuno" value="{{$hd->doc_cars_newdocuno}}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">ติดตามเรื่องโดย</label>
                            <input class="form-control" name="follow_at" value="{{ $hd->follow_at ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">วันที่ติดตาม</label>
                            <input class="form-control" type="date" name="follow_date" value="{{$hd->follow_date}}">
                        </div>
                    </div>

                    <div class="row g-2 mt-2">
                        <div class="col-md-6">
                            <label class="form-label">Lead Auditor / QMR</label>
                            <input class="form-control" name="approved_at" value="{{ $hd->approved_at ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">วันที่อนุมัติปิด CAR</label>
                            <input class="form-control" type="date" name="approved_date" value="{{$hd->approved_date}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ปุ่มบันทึก (ซ่อนขณะพิมพ์) -->
        <div class="row mt-3 mb-4 d-print-none">
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-primary w-100 shadow-sm py-2" style="font-size: 14px;">
                    <i class="mdi mdi-content-save me-1"></i> บันทึกข้อมูล
                </button>
            </div>
        </div>
    </form>
</div>
@endsection