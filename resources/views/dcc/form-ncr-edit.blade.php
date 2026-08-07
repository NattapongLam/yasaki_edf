@extends('layouts.main')
@section('content')
<div class="container-fluid px-4">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm d-print-none" role="alert">
        <i class="mdi mdi-check-all me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm d-print-none" role="alert">
        <i class="mdi mdi-block-helper me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

<!-- ปุ่มสำหรับสั่งพิมพ์เอกสาร -->
<div class="row mb-3 d-print-none">
    <div class="col-12 text-end">
        <button type="button" onclick="window.print()" class="btn btn-dark shadow-sm">
            <i class="mdi mdi-printer me-1"></i> พิมพ์เอกสาร NCR (2 หน้า A4 แบบทางการ)
        </button>
    </div>
</div>

<form method="POST" class="form-horizontal" action="{{ route('ncr.update',$hd->doc_ncrs_id) }}" enctype="multipart/form-data">
@csrf  
@method('PUT')  

<!-- ================= PAGE 1 ================= -->
<div class="print-page-1">
    <!-- ตารางหัวกระดาษเอกสารควบคุม (ISO Header สำหรับสั่งพิมพ์) -->
    <div class="table-responsive d-none d-print-block mb-2">
        <table class="table table-bordered border-dark mb-0 text-center align-middle" style="font-size: 9pt;">
            <tr>
                <td rowspan="2" style="width: 20%;" class="fw-bold py-2">
                   <img src="{{ URL::asset('assets/images/KK-C.png') }}" alt="Logo" width="100%">
                </td>
                <td rowspan="2" style="width: 50%;" class="fw-bold text-uppercase py-2" style="font-size: 11pt;">
                    ใบรายงานความไม่เป็นไปตามข้อกำหนด<br><span style="font-size: 9pt; font-weight: normal;">NON-CONFORMANCE REPORT (NCR)</span>
                </td>
                <td style="width: 30%; text-align: left; padding-left: 5px;">รหัสเอกสาร: FM-QP-01</td>
            </tr>
            <tr>
                <td style="text-align: left; padding-left: 5px;">แก้ไขครั้งที่: 00 | มีผลบังคับใช้: 01/01/2026</td>
            </tr>
        </table>
    </div>

    <!-- ส่วนหัวหน้าจอ (แสดงเฉพาะตอนไม่พิมพ์) -->
    <div class="card border-dark mb-2 shadow-sm print-card d-print-none">
        <div class="card-body py-2">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="text-uppercase fw-bold text-primary mb-1" style="font-size: 1.2rem;">ใบรายงานความไม่เป็นไปตามข้อกำหนด</h2>
                    <p class="text-muted mb-0" style="font-size: 9pt;">Non-Conformance Report (NCR) — ตามมาตรฐาน ISO/IEC 17025</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="badge bg-secondary p-1 fs-6">สถานะ: {{$hd->doc_ncr_statuses_name}}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ส่วนที่ 1: ข้อมูลทั่วไป -->
    <div class="card border-dark mb-2 shadow-sm print-card">
        <div class="card-body py-2">
            <h5 class="text-dark bg-light p-1 rounded mb-2 border-start border-4 border-primary print-header" style="font-size: 10pt;">1. ข้อมูลทั่วไป (General Information)</h5>
            <div class="row g-2">
                <div class="col-md-3">
                    <label class="form-label fw-bold mb-0">วันที่พบปัญหา</label>
                    <input class="form-control" type="date" name="doc_ncrs_date" value="{{$hd->doc_ncrs_date}}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold mb-0">NCR No.</label>
                    <input class="form-control" type="text" name="doc_ncrs_docuno" value="{{$hd->doc_ncrs_docuno}}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold mb-0">ผู้ตรวจพบ / ผู้แจ้ง</label>
                    <input class="form-control" type="text" name="doc_ncrs_person" value="{{$hd->doc_ncrs_person}}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold mb-0">ห้องปฏิบัติการ / โครงการ</label>
                    <input class="form-control" type="text" name="doc_ncrs_project" value="{{$hd->doc_ncrs_project}}">
                </div>
            </div>
            <div class="row g-2 mt-1">
                <div class="col-md-3">
                    <label class="form-label fw-bold mb-0">แจ้งถึง</label>
                    <input class="form-control" type="text" name="doc_ncrs_to" value="{{$hd->doc_ncrs_to}}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold mb-0">สำเนาถึง (QMR / ผู้บริหาร)</label>
                    <input class="form-control" type="text" name="doc_ncrs_copy" value="{{$hd->doc_ncrs_copy}}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold mb-0">กระบวนการที่พบ (Process)</label>
                    <input class="form-control" type="text" name="doc_ncrs_process" value="{{$hd->doc_ncrs_process}}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold mb-0">รายการเครื่องมือ / ผลทดสอบ</label>
                    <input class="form-control" type="text" name="doc_ncrs_product" value="{{$hd->doc_ncrs_product}}">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <label class="form-label fw-bold text-danger mb-0">A. ลักษณะความไม่เป็นไปตามข้อกำหนด (Nonconformity Description)</label>
                    <textarea class="form-control print-textarea" rows="3" name="doc_ncrs_nonconformity">{{$hd->doc_ncrs_nonconformity}}</textarea>
                </div>
            </div>         
        </div>
    </div>

    <!-- ส่วนที่ 2: การอนุมัติรับทราบ NCR -->
    <div class="card border-dark mb-2 shadow-sm print-card">
        <div class="card-body py-2">
            <h5 class="text-dark bg-light p-1 rounded mb-2 border-start border-4 border-primary print-header" style="font-size: 10pt;">2. การตรวจสอบและอนุมัติเปิด NCR</h5>
            <div class="row g-2">
                <div class="col-md-3">
                    <label class="form-label fw-bold mb-0">สถานะดำเนินการ</label>
                    <select class="form-select" name="doc_ncr_statuses_id">
                        @foreach ($sta as $item)
                            <option value="{{$item->doc_ncr_statuses_id}}"
                                {{ $item->doc_ncr_statuses_id == $hd->doc_ncr_statuses_id ? 'selected' : '' }}>
                                {{$item->doc_ncr_statuses_name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold mb-0">ผู้อนุมัติ</label>
                    <input class="form-control bg-light" value="{{$hd->approved_by}}" name="approved_by" readonly>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold mb-0">วันที่</label>
                    <input class="form-control" type="date" value="{{$hd->approved_date}}" name="approved_date" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold mb-0">หมายเหตุ</label>
                    <input class="form-control" value="{{$hd->approved_remark}}" name="approved_remark">
                </div>
            </div>
        </div>
    </div>
</div>

@if ($hd->doc_ncr_statuses_id == 2)
<!-- ================= PAGE 2 ================= -->
<div class="print-page-2">
    <!-- ตารางหัวกระดาษเอกสารควบคุม (สำหรับหน้า 2) -->
    <div class="table-responsive d-none d-print-block mb-2">
        <table class="table table-bordered border-dark mb-0 text-center align-middle" style="font-size: 9pt;">
            <tr>
                <td rowspan="2" style="width: 20%;" class="fw-bold py-2">
                    <img src="{{ URL::asset('assets/images/KK-C.png') }}" alt="Logo" width="100%">
                </td>
                <td rowspan="2" style="width: 50%;" class="fw-bold text-uppercase py-2" style="font-size: 11pt;">
                    ใบรายงานความไม่เป็นไปตามข้อกำหนด (ต่อ)<br><span style="font-size: 9pt; font-weight: normal;">NON-CONFORMANCE REPORT (NCR) - Page 2</span>
                </td>
                <td style="width: 30%; text-align: left; padding-left: 5px;">รหัสเอกสาร: FM-QP-01</td>
            </tr>
            <tr>
                <td style="text-align: left; padding-left: 5px;">แก้ไขครั้งที่: 00 | มีผลบังคับใช้: 01/01/2026</td>
            </tr>
        </table>
    </div>

    <!-- ส่วนที่ 3: การวิเคราะห์สาเหตุและการแก้ไข -->
    <div class="card border-dark mb-2 shadow-sm print-card">
        <div class="card-body py-2">
            <h5 class="text-dark bg-light p-1 rounded mb-2 border-start border-4 border-primary print-header" style="font-size: 10pt;">3. การดำเนินการแก้ไขและป้องกัน (Correction & Corrective Action)</h5>
            <div class="row g-2">
                <div class="col-12">
                    <label class="form-label fw-bold mb-0">B. การวิเคราะห์สาเหตุของปัญหา (Root Cause Analysis)</label>
                    <textarea class="form-control print-textarea" rows="2" name="doc_ncrs_causes">{{$hd->doc_ncrs_causes}}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold mb-0">C. การแก้ไขเบื้องต้น / การแก้ไขเฉพาะหน้า (Correction)</label>
                    <textarea class="form-control print-textarea" rows="2" name="doc_ncrs_troubleshooting">{{$hd->doc_ncrs_troubleshooting}}</textarea>
                </div>
                 <div class="col-12">
                    <label class="form-label fw-bold mb-0">D. แนวทางการป้องกันเพื่อไม่ให้เกิดซ้ำ (Corrective Action / Preventive Measure)</label>
                    <textarea class="form-control print-textarea" rows="2" name="doc_ncrs_preventive">{{$hd->doc_ncrs_preventive}}</textarea>
                </div>
            </div>
            <div class="row g-2 mt-1">
                <div class="col-md-4">
                    <label class="form-label fw-bold mb-0">ผู้รับผิดชอบดำเนินการ</label>
                    <input class="form-control bg-light" value="{{$hd->responsible_at}}" name="responsible_at" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold mb-0">วันที่ดำเนินการเสร็จ</label>
                    <input class="form-control" type="date" value="{{$hd->responsible_date}}" name="responsible_date" required>
                </div>
            </div>
        </div>
    </div> 

    <!-- ส่วนที่ 4: การติดตามและประเมินผลกระทบ -->
    <div class="card border-dark mb-2 shadow-sm print-card">
        <div class="card-body py-2">
            <h5 class="text-dark bg-light p-1 rounded mb-2 border-start border-4 border-primary print-header" style="font-size: 10pt;">4. การติดตามและประเมินผลงาน (Verification & Impact Evaluation)</h5>
            <div class="row g-2">
                <div class="col-md-4">
                    <label class="form-label fw-bold mb-0">E. ข้อเสนอแนะการจัดการผลิตภัณฑ์</label>
                    <select class="form-select" name="doc_ncrs_actionresult">
                        <option value="-">กรุณาเลือก</option>
                        <option value="ทำใหม่" {{ (old('doc_ncrs_actionresult', $hd->doc_ncrs_actionresult) == 'ทำใหม่') ? 'selected' : '' }}>ทำใหม่ (Retest/Re-calibrate)</option>
                        <option value="ซ่อม/แก้ไข" {{ (old('doc_ncrs_actionresult', $hd->doc_ncrs_actionresult) == 'ซ่อม/แก้ไข') ? 'selected' : '' }}>ซ่อมแซม / ปรับปรุง</option>
                        <option value="ทิ้ง/ทำลาย" {{ (old('doc_ncrs_actionresult', $hd->doc_ncrs_actionresult) == 'ทิ้ง/ทำลาย') ? 'selected' : '' }}>ทิ้ง / ยกเลิกการใช้งาน</option>
                        <option value="ยอมรับ/ขอใช้งาน" {{ (old('doc_ncrs_actionresult', $hd->doc_ncrs_actionresult) == 'ยอมรับ/ขอใช้งาน') ? 'selected' : '' }}>ยอมรับภายใต้เงื่อนไข</option>
                        <option value="อื่นๆ" {{ (old('doc_ncrs_actionresult', $hd->doc_ncrs_actionresult) == 'อื่นๆ') ? 'selected' : '' }}>อื่นๆ</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold mb-0">รายละเอียด / ผลการประเมินผลกระทบ</label>
                    <input class="form-control" name="doc_ncrs_actionremark" value="{{$hd->doc_ncrs_actionremark}}" placeholder="ระบุว่าต้องเรียกคืนรายงาน (Recall) หรือไม่">
                </div>
            </div>
            <div class="row g-2 mt-1">
                <div class="col-md-4">
                    <label class="form-label fw-bold mb-0">ผู้ตรวจติดตาม (Verifier)</label>
                    <input class="form-control bg-light" value="{{$hd->recheck_at}}" name="recheck_at" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold mb-0">วันที่ตรวจติดตาม</label>
                    <input class="form-control" type="date" value="{{$hd->recheck_date}}" name="recheck_date" required>
                </div>
            </div>        
        </div>
    </div> 

    <!-- ส่วนที่ 5: สรุปและปิดเล่ม CAR/NCR -->
    <div class="card border-dark mb-2 shadow-sm print-card">
        <div class="card-body py-2">
            <h5 class="text-dark bg-light p-1 rounded mb-2 border-start border-4 border-primary print-header" style="font-size: 10pt;">5. สรุปและปิดเล่ม (Closure & CAR Consideration)</h5>
            <div class="row g-2">
                <div class="col-md-4">
                    <label class="form-label fw-bold mb-0">F. การพิจารณาเปิด CAR</label>
                    <select class="form-select" name="doc_ncrs_consequencesresult">
                        <option value="-">กรุณาเลือก</option>
                        <option value="ไม่ต้องเปิด CAR" {{ (old('doc_ncrs_consequencesresult',$hd->doc_ncrs_consequencesresult ) == 'ไม่ต้องเปิด CAR') ? 'selected' : '' }}>ไม่ต้องเปิด CAR (จบใน NCR)</option>
                        <option value="เปิด CAR" {{ (old('doc_ncrs_consequencesresult',$hd->doc_ncrs_consequencesresult ) == 'เปิด CAR') ? 'selected' : '' }}>ต้องเปิด CAR ต่อเนื่อง</option>                     
                    </select>
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold mb-0">ความเห็นเพิ่มเติมจากผู้จัดการระบบคุณภาพ / ผู้บริหาร</label>
                    <input class="form-control" name="doc_ncrs_consequencesremark" value="{{$hd->doc_ncrs_consequencesremark}}">
                </div>
            </div>
            <div class="row g-2 mt-1">
                <div class="col-md-4">
                    <label class="form-label fw-bold mb-0">ผู้สรุปและปิดเอกสาร (Quality Manager)</label>
                    <input class="form-control bg-light" value="{{$hd->close_at}}" name="close_at" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold mb-0">วันที่ปิดเอกสาร</label>
                    <input class="form-control" type="date" value="{{$hd->close_date}}" name="close_date" required>
                </div>
            </div>
        </div>
    </div>  
@endif

<!-- ปุ่มบันทึกข้อมูล -->
<div class="row mb-5 d-print-none">
    <div class="col-12">
        <button type="submit" class="btn btn-primary btn-lg shadow-sm px-5">
            <i class="mdi mdi-content-save me-1"></i> บันทึกข้อมูล
        </button>
    </div>
</div>
</form>  
</div>
@endsection

@push('scriptjs')
<style>
/* ตั้งค่าขนาดหน้ากระดาษ A4 และขอบกระดาษ */
@page {
    size: A4;
    margin: 8mm 10mm;
}

@media print {
    body {
        background-color: #ffffff !important;
        color: #000000 !important;
        font-family: 'Sarabun', 'TH Sarabun PSK', Arial, sans-serif !important;
        font-size: 10pt;
    }

    .d-print-none {
        display: none !important;
    }

    /* บังคับแยกหน้ากระดาษเป็น 2 หน้าพอดี */
    .print-page-1 {
        page-break-after: always;
        break-after: page;
    }

    .print-page-2 {
        page-break-before: always;
        break-before: page;
    }

    .card.print-card {
        border: 1px solid #333 !important;
        box-shadow: none !important;
        margin-bottom: 6px !important;
        page-break-inside: avoid;
    }

    .card-body {
        padding: 6px 12px !important;
    }

    h5.print-header {
        background-color: #f1f1f1 !important;
        color: #000 !important;
        border-left: 4px solid #000 !important;
        padding: 3px 8px !important;
        font-size: 10pt;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        margin-bottom: 4px !important;
    }

    .form-control, .form-select {
        border: none !important;
        border-bottom: 1px dotted #555 !important;
        border-radius: 0 !important;
        padding: 1px 0 !important;
        background-color: transparent !important;
        box-shadow: none !important;
        font-size: 9.5pt;
        height: auto !important;
    }

    textarea.print-textarea {
        border: 1px solid #888 !important;
        padding: 4px !important;
        background-color: #fff !important;
        resize: none;
    }

    .badge {
        border: 1px solid #000;
        color: #000 !important;
        background-color: transparent !important;
    }
    
    .form-label {
        font-size: 9pt;
        margin-bottom: 1px !important;
        color: #222;
    }
}
</style>
<script>
</script>
@endpush