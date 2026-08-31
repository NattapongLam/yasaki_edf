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
            <i class="mdi mdi-printer me-1"></i> พิมพ์เอกสาร NCR (1 หน้า A4 แบบทางการ)
        </button>
    </div>
</div>

<form method="POST" class="form-horizontal" action="{{ route('ncr.update',$hd->doc_ncrs_id) }}" enctype="multipart/form-data">
@csrf  
@method('PUT')  

<!-- ================= PAGE 1 & 2 (รวมเป็นหน้าเดียวสำหรับการพิมพ์) ================= -->
<div class="print-page-single">
    <!-- ตารางหัวกระดาษเอกสารควบคุม (ISO Header สำหรับสั่งพิมพ์) -->
    <div class="table-responsive d-none d-print-block mb-1">
        <table class="table table-bordered border-dark mb-0 text-center align-middle" style="font-size: 8pt;">
            <tr>
                <td rowspan="2" style="width: 18%;" class="fw-bold py-1">
                   <img src="{{ URL::asset('assets/images/KK-C.png') }}" alt="Logo" width="70px">
                </td>
                <td rowspan="2" style="width: 52%;" class="fw-bold text-uppercase py-1" style="font-size: 10pt;">
                    ใบรายงานความไม่เป็นไปตามข้อกำหนด<br><span style="font-size: 8pt; font-weight: normal;">NON-CONFORMANCE REPORT (NCR)</span>
                </td>
                <td style="width: 30%; text-align: left; padding-left: 4px;">รหัสเอกสาร: FM-QP-01</td>
            </tr>
            <tr>
                <td style="text-align: left; padding-left: 4px;">แก้ไขครั้งที่: 00 | มีผลบังคับใช้: 01/01/2026</td>
            </tr>
        </table>
    </div>

    <!-- ส่วนหัวหน้าจอ (แสดงเฉพาะตอนไม่พิมพ์) -->
    <div class="card border-dark mb-3 shadow-sm print-card d-print-none">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="text-uppercase fw-bold text-primary mb-1" style="font-size: 1.4rem;">ใบรายงานความไม่เป็นไปตามข้อกำหนด</h2>
                    <p class="text-muted mb-0" style="font-size: 1rem;">Non-Conformance Report (NCR) — ตามมาตรฐาน ISO/IEC 17025</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="badge bg-secondary p-2 fs-6">สถานะ: {{$hd->doc_ncr_statuses_name}}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ส่วนที่ 1: ข้อมูลทั่วไป -->
    <div class="card border-dark mb-3 shadow-sm print-card">
        <div class="card-body py-3">
            <h5 class="text-dark bg-light p-2 rounded mb-3 border-start border-4 border-primary print-header" style="font-size: 1.1rem;">1. ข้อมูลทั่วไป (General Information)</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">วันที่พบปัญหา</label>
                    <input class="form-control" type="date" name="doc_ncrs_date" value="{{$hd->doc_ncrs_date}}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">NCR No.</label>
                    <input class="form-control" type="text" name="doc_ncrs_docuno" value="{{$hd->doc_ncrs_docuno}}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">ผู้ตรวจพบ / ผู้แจ้ง</label>
                    <input class="form-control" type="text" name="doc_ncrs_person" value="{{$hd->doc_ncrs_person}}">
                </div>             
            </div>
            <div class="row g-3 mt-1">
                <h6 class="mb-2 text-dark fw-bold">A.รายละเอียดความไม่สอดคล้องกับข้อกำหนด (รายละเอียดปัญหาที่พบ)</h6>
                <div class="col-md-12">
                    <label class="form-label fw-bold">1.พบอะไร</label>
                    <textarea class="form-control print-textarea" rows="2" name="doc_ncrs_nonconformity">{{$hd->doc_ncrs_nonconformity}}</textarea>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">2.พบที่ไหน/กระบวนการใด</label>
                    <input class="form-control" type="text" name="doc_ncrs_process" value="{{$hd->doc_ncrs_process}}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">3.พบเมื่อไร</label>
                    <input class="form-control" type="date" name="doc_ncrs_duedate" value="{{$hd->doc_ncrs_duedate}}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">4.จำนวนเท่าไหร่</label>
                    <input class="form-control" type="text" name="doc_ncrs_product" value="{{$hd->doc_ncrs_product}}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">5.ไม่ตรงกับข้อกำหนดอะไร</label>
                    <select class="form-control" name="doc_ncrs_type">
                        <option value="{{$hd->doc_ncrs_type}}">{{$hd->doc_ncrs_type}}</option>
                        <option value="Drawing No.">Drawing No.</option>
                        <option value="Specification">Specification</option>
                        <option value="WI">WI</option>
                        <option value="Control Plan">Control Plan</option>
                        <option value="Customer Requirement">Customer Requirement</option>
                        <option value="Procedure">Procedure</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">6.ข้อกำหนด/เอกสารอ้างอิง</label>
                    <input class="form-control" type="text" name="doc_ncrs_project" value="{{$hd->doc_ncrs_project}}">
                </div>
            </div>         
        </div>
    </div>

    <!-- ส่วนที่ 2: การอนุมัติรับทราบ NCR -->
    <div class="card border-dark mb-3 shadow-sm print-card">
        <div class="card-body py-3">
            <h5 class="text-dark bg-light p-2 rounded mb-3 border-start border-4 border-primary print-header" style="font-size: 1.1rem;">2. การตรวจสอบและอนุมัติเปิด NCR</h5>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold">สถานะดำเนินการ</label>
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
                    <label class="form-label fw-bold">ผู้อนุมัติ</label>
                    <input class="form-control bg-light" value="{{$hd->approved_by}}" name="approved_by" readonly>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">วันที่</label>
                    <input class="form-control" type="date" value="{{$hd->approved_date}}" name="approved_date" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">หมายเหตุ</label>
                    <input class="form-control" value="{{$hd->approved_remark}}" name="approved_remark">
                </div>
            </div>
        </div>
    </div>

@if ($hd->doc_ncr_statuses_id == 2)
    <!-- ส่วนที่ 3: การวิเคราะห์สาเหตุและการแก้ไข -->
    <div class="card border-dark mb-3 shadow-sm print-card">
        <div class="card-body py-3">
            <h5 class="text-dark bg-light p-2 rounded mb-3 border-start border-4 border-primary print-header" style="font-size: 1.1rem;">3. การดำเนินการแก้ไข (Correction)</h5>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-bold">B. การควบคุม/จัดการปัญหาที่พบ</label>
                    <textarea class="form-control print-textarea" rows="2" name="doc_ncrs_causes">{{$hd->doc_ncrs_causes}}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">C. การแก้ไขเบื้องต้น / การแก้ไขเฉพาะหน้า (Correction)</label>
                    <textarea class="form-control print-textarea" rows="2" name="doc_ncrs_troubleshooting">{{$hd->doc_ncrs_troubleshooting}}</textarea>
                </div>
                 <div class="col-12">
                    <label class="form-label fw-bold">D. แนวทางการป้องกันเพื่อไม่ให้เกิดซ้ำ (Corrective Action / Preventive Measure)</label>
                    <textarea class="form-control print-textarea" rows="2" name="doc_ncrs_preventive">{{$hd->doc_ncrs_preventive}}</textarea>
                </div>
            </div>
            <div class="row g-3 mt-1">
                <div class="col-md-4">
                    <label class="form-label fw-bold">C การพิจารณาดำเนินการ</label>
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
                    <label class="form-label fw-bold">รายละเอียด</label>
                    <input class="form-control" name="doc_ncrs_actionremark" value="{{$hd->doc_ncrs_actionremark}}" placeholder="กรณีระบุอื่นๆ">
                </div>
            </div>
            <div class="row g-3 mt-1">
                <div class="col-md-4">
                    <label class="form-label fw-bold">ผู้ตรวจติดตาม</label>
                    <input class="form-control bg-light" value="{{$hd->responsible_at}}" name="responsible_at" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">วันที่ตรวจติดตาม</label>
                    <input class="form-control" type="date" value="{{$hd->responsible_date}}" name="responsible_date" required>
                </div>
            </div>            
        </div>
    </div> 

    <!-- ส่วนที่ 4: การติดตามและประเมินผลกระทบ -->
    <div class="card border-dark mb-3 shadow-sm print-card">
        <div class="card-body py-3">
            <h5 class="text-dark bg-light p-2 rounded mb-3 border-start border-4 border-primary print-header" style="font-size: 1.1rem;">4. การติดตามและประเมินผลงาน (Verification & Impact Evaluation)</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">หัวหน้าQA/QC</label>
                    <input class="form-control bg-light" value="{{$hd->recheck_at}}" name="recheck_at" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">วันที่</label>
                    <input class="form-control" type="date" value="{{$hd->recheck_date}}" name="recheck_date" required>
                </div>
            </div>
        </div>
    </div> 

    <!-- ส่วนที่ 5: สรุปและปิดเล่ม CAR/NCR -->
    <div class="card border-dark mb-3 shadow-sm print-card">
        <div class="card-body py-3">
            <h5 class="text-dark bg-light p-2 rounded mb-3 border-start border-4 border-primary print-header" style="font-size: 1.1rem;">5. สรุปและปิดเล่ม (Closure & CAR Consideration)</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">D. ผลการดำเนินการกับ NCR</label>
                    <select class="form-select" name="doc_ncrs_consequencesresult">
                        <option value="-">กรุณาเลือก</option>
                        <option value="เปิด CAR" {{ (old('doc_ncrs_consequencesresult',$hd->doc_ncrs_consequencesresult ) == 'เปิด CAR') ? 'selected' : '' }}>เปิด CAR</option>
                        <option value="ไม่เปิด CAR" {{ (old('doc_ncrs_consequencesresult',$hd->doc_ncrs_consequencesresult ) == 'ไม่เปิด CAR') ? 'selected' : '' }}>ไม่เปิด CAR</option>                    
                    </select>
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">เสนอแนะ</label>
                    <input class="form-control" name="doc_ncrs_consequencesremark" value="{{$hd->doc_ncrs_consequencesremark}}">
                </div>
            </div>
            <div class="row g-3 mt-1">
                <div class="col-md-4">
                    <label class="form-label fw-bold">ผู้สรุปและปิดเอกสาร (Quality Manager)</label>
                    <input class="form-control bg-light" value="{{$hd->close_at}}" name="close_at" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">วันที่ปิดเอกสาร</label>
                    <input class="form-control" type="date" value="{{$hd->close_date}}" name="close_date" required>
                </div>
            </div>
        </div>
    </div>  
@endif

@if ($hd->doc_ncr_statuses_id <> 7)
<!-- ปุ่มบันทึกข้อมูล -->
<div class="row mb-5 d-print-none">
    <div class="col-12">
        <button type="submit" class="btn btn-primary btn-lg shadow-sm px-5">
            <i class="mdi mdi-content-save me-1"></i> บันทึกข้อมูล
        </button>
    </div>
</div>   
@endif
</div> <!-- ปิด print-page-single -->
</form>  
</div>
@endsection

@push('scriptjs')
<style>
/* ตั้งค่าขนาดหน้ากระดาษ A4 และขอบกระดาษให้พอดีหน้าเดียวตอนพิมพ์ */
@page {
    size: A4;
    margin: 4mm 6mm;
}

@media print {
    body {
        background-color: #ffffff !important;
        color: #000000 !important;
        font-family: 'Sarabun', 'TH Sarabun PSK', Arial, sans-serif !important;
        font-size: 8pt;
    }

    .d-print-none {
        display: none !important;
    }

    .print-page-single {
        width: 100%;
    }

    .card.print-card {
        border: 1px solid #333 !important;
        box-shadow: none !important;
        margin-bottom: 3px !important;
        page-break-inside: avoid;
    }

    .card-body {
        padding: 3px 6px !important;
    }

    h5.print-header {
        background-color: #f1f1f1 !important;
        color: #000 !important;
        border-left: 3px solid #000 !important;
        padding: 2px 5px !important;
        font-size: 8.5pt;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        margin-bottom: 2px !important;
    }

    .form-control, .form-select {
        border: none !important;
        border-bottom: 1px dotted #555 !important;
        border-radius: 0 !important;
        padding: 0px 0 !important;
        background-color: transparent !important;
        box-shadow: none !important;
        font-size: 8pt;
        height: 18px !important;
    }

    textarea.print-textarea {
        border: 1px solid #888 !important;
        padding: 2px !important;
        background-color: #fff !important;
        resize: none;
        height: auto !important;
    }

    .badge {
        border: 1px solid #000;
        color: #000 !important;
        background-color: transparent !important;
    }
    
    .form-label {
        font-size: 7.5pt;
        margin-bottom: 0px !important;
        color: #222;
    }
}
</style>
<script>
</script>
@endpush