@extends('layouts.main')

@section('content')
<div class="row">
    <!-- แจ้งเตือนสถานะ -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
        <i class="mdi mdi-check-all me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif(session('error'))
    <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
        <i class="mdi mdi-block-helper me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- ปุ่มสั่งพิมพ์ (ซ่อนตอนพิมพ์) -->
    <div class="col-12 mb-2 text-end d-print-none">
        <button type="button" class="btn btn-dark btn-sm shadow-sm" onclick="window.print()">
            <i class="mdi mdi-printer me-1"></i> พิมพ์เอกสาร / บันทึก PDF (A4 ISO/IEC 17025)
        </button>
    </div>

    <!-- ฟอร์มหลัก -->
    <form method="POST" class="form-horizontal" action="{{ route('complaints.update',$hd->customer_complaints_lists_id) }}">
        @csrf  
        @method('PUT')  

        <div class="card iso-card shadow-sm border-0 mb-4">
            <div class="card-body p-3">
                
                <!-- ส่วนหัวเอกสาร ISO 17025 (Header Control) -->
                <table class="table table-bordered iso-header-table mb-2">
                    <tr>
                        <td class="align-middle text-center bg-light p-1" style="width: 20%;">
                            <div class="py-1">
                                <img src="{{ URL::asset('assets/images/KK-C.png') }}" alt="Logo" width="45%">
                            </div>
                        </td>
                        <td class="align-middle text-center p-2" style="width: 52%;">
                            <h5 class="mb-0 text-uppercase fw-bold text-primary" style="font-size: 16px;">บันทึกข้อร้องเรียนจากลูกค้า</h5>
                            <span class="text-muted" style="font-size: 11px;">CUSTOMER COMPLAINT & CORRECTIVE ACTION RECORD</span>
                        </td>
                        <td style="width: 28%; font-size: 11px; vertical-align: middle;" class="p-2">
                            <div class="mb-0.5"><b>Doc No.:</b> FM-LAB-01</div>
                            <div class="mb-0.5"><b>Revision:</b> 01</div>
                            <div><b>Eff. Date:</b> 01/01/2026</div>
                        </td>
                    </tr>
                </table>

                <!-- ส่วนที่ 1: รายละเอียดข้อร้องเรียนจากลูกค้า -->
                <div class="section-title mb-1">
                    <h6 class="text-uppercase fw-bold text-secondary border-bottom pb-1 mb-2" style="font-size: 13px;">
                        <i class="mdi mdi-information-outline me-1"></i> 1. ข้อมูลข้อร้องเรียน (Customer Details)
                    </h6>
                </div>
                
                <div class="row g-2 mb-2">
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label fw-semibold small mb-1">วันที่รับเรื่อง</label>
                            <input class="form-control" name="customer_complaints_lists_date" type="date" value="{{$hd->customer_complaints_lists_date}}" required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label fw-semibold small mb-1">เลขที่อ้างอิง (Ref. No.)</label>
                            <input class="form-control" name="customer_complaints_lists_refdocuno" type="text" value="{{$hd->customer_complaints_lists_refdocuno}}" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label fw-semibold small mb-1">ลูกค้า</label>
                            <select class="form-select" name="ar_customer_lists_id">
                                <option value="0">กรุณาเลือก</option>
                                @foreach ($cust as $item)
                                    <option value="{{$item->ar_customer_lists_id}}"
                                        {{ $item->ar_customer_lists_id == $hd->ar_customer_lists_id ? 'selected' : '' }}>
                                        {{$item->ar_customer_lists_name1}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div> 

                <div class="row g-2 mb-2">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label fw-semibold small mb-1">รายละเอียดปัญหา / ความต้องการของลูกค้า</label>
                            <textarea class="form-control" rows="5" name="customer_complaints_lists_details" required>{{$hd->customer_complaints_lists_details}}</textarea>
                        </div>
                    </div>
                </div>         

                <!-- ส่วนที่ 2: การตรวจสอบและวิเคราะห์ข้อร้องเรียน -->
                <div class="section-title mb-1">
                    <h6 class="text-uppercase fw-bold text-secondary border-bottom pb-1 mb-2" style="font-size: 13px;">
                        <i class="mdi mdi-clipboard-search-outline me-1"></i> 2. การประเมินและวิเคราะห์ปัญหา (Investigation & Analysis)
                    </h6>
                </div>

                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label fw-semibold small mb-1">ประเภทปัญหา</label>
                            <select class="form-control" name="customer_complaints_lists_type">
                                @if ($hd->customer_complaints_lists_type)
                                <option value="{{$hd->customer_complaints_lists_type}}">{{$hd->customer_complaints_lists_type}}</option>
                                <option value="InComing">InComing</option>
                                <option value="InProcess">InProcess</option>
                                <option value="Uncertainty">Uncertainty</option>
                                <option value="Environmental">Environmental</option>
                                <option value="Pearlite">Pearlite</option>
                                <option value="Defects">Defects</option> 
                                @else
                                <option value="-">กรุณาเลือก</option>
                                <option value="InComing">InComing</option>
                                <option value="InProcess">InProcess</option>
                                <option value="Uncertainty">Uncertainty</option>
                                <option value="Environmental">Environmental</option>
                                <option value="Pearlite">Pearlite</option>
                                <option value="Defects">Defects</option>   
                                @endif
                               
                            </select>
                        </div>
                    </div> 
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label fw-semibold small mb-1">ระดับความรุนแรง</label>
                            <select class="form-control" name="customer_complaints_lists_level">
                                @if ($hd->customer_complaints_lists_level)
                                <option value="{{$hd->customer_complaints_lists_level}}">{{$hd->customer_complaints_lists_level}}</option>
                                <option value="Critical">Critical</option>
                                <option value="Major">Major</option>
                                <option value="Minor">Minor</option>
                                @else
                                <option value="-">กรุณาเลือก</option>
                                <option value="Critical">Critical</option>
                                <option value="Major">Major</option>
                                <option value="Minor">Minor</option>
                                @endif
                                
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row g-2 mb-2">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label fw-semibold small mb-1">สาเหตุของปัญหา (Root Cause Analysis)</label>
                            <textarea class="form-control" rows="5" name="customer_complaints_lists_causes">{{$hd->customer_complaints_lists_causes}}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label fw-semibold small mb-1">วิธีแก้ไขปัญหาเฉพาะหน้า (Correction / Issue Resolution)</label>
                            <textarea class="form-control" rows="5" name="customer_complaints_lists_issue">{{$hd->customer_complaints_lists_issue}}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label fw-semibold small mb-1">การป้องกันไม่ให้เกิดซ้ำ (Corrective Action / Prevention)</label>
                            <textarea class="form-control" rows="5" name="customer_complaints_lists_prevention">{{$hd->customer_complaints_lists_prevention}}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label fw-semibold small mb-1">ข้อเสนอแนะเพิ่มเติม</label>
                            <textarea class="form-control" rows="5" name="customer_complaints_lists_additional">{{$hd->customer_complaints_lists_additional}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row g-2 mb-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label fw-semibold small mb-1">วันที่เริ่มดำเนินการ</label>
                            <input class="form-control" name="customer_complaints_lists_datestart" type="date" value="{{$hd->customer_complaints_lists_duedate}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label fw-semibold small mb-1">กำหนดเสร็จ (Due Date)</label>
                            <input class="form-control" name="customer_complaints_lists_duedate" type="date" value="{{$hd->customer_complaints_lists_duedate}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label fw-semibold small mb-1">ผู้รับผิดชอบ / หน่วยงานที่เกี่ยวข้อง</label>
                            <input class="form-control" name="customer_complaints_lists_responsible" type="text" value="{{$hd->customer_complaints_lists_responsible}}">
                        </div>
                    </div>
                </div>

                <!-- ส่วนที่ 3: ลายมือชื่อผู้เกี่ยวข้อง (เรียง 3 ช่องแนวนอน) -->
                <div class="signature-section mt-2 pt-2 border-top">
                    <div class="sig-container">
                        <!-- ช่องที่ 1 -->
                        <div class="sig-box">
                            <div style="height: 20px;"></div>
                            <p class="mb-0 text-muted" style="font-size: 11px;">___________________________</p>
                            <p class="mb-0 fw-semibold text-dark" style="font-size: 11px;">( ........................................ )</p>
                            <p class="text-muted mb-0 fw-bold" style="font-size: 10px;">ผู้บันทึก / เจ้าหน้าที่รับเรื่อง</p>
                            <p class="text-muted mb-0" style="font-size: 9px;">วันที่: ____/____/________</p>
                        </div>
                        <!-- ช่องที่ 2 -->
                        <div class="sig-box">
                            <div style="height: 20px;"></div>
                            <p class="mb-0 text-muted" style="font-size: 11px;">___________________________</p>
                            <p class="mb-0 fw-semibold text-dark" style="font-size: 11px;">( ........................................ )</p>
                            <p class="text-muted mb-0 fw-bold" style="font-size: 10px;">ผู้ตรวจสอบ / QMR</p>
                            <p class="text-muted mb-0" style="font-size: 9px;">วันที่: ____/____/________</p>
                        </div>
                        <!-- ช่องที่ 3 -->
                        <div class="sig-box">
                            <div style="height: 20px;"></div>
                            <p class="mb-0 text-muted" style="font-size: 11px;">___________________________</p>
                            <p class="mb-0 fw-semibold text-dark" style="font-size: 11px;">( ........................................ )</p>
                            <p class="text-muted mb-0 fw-bold" style="font-size: 10px;">ผู้อนุมัติปิดงาน / Lab Director</p>
                            <p class="text-muted mb-0" style="font-size: 9px;">วันที่: ____/____/________</p>
                        </div>
                    </div>
                </div>

                <!-- ปุ่มบันทึกข้อมูล (ซ่อนตอนพิมพ์) -->
                <div class="row mt-3 d-print-none">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm">
                            <i class="mdi mdi-content-save me-1"></i> บันทึกข้อมูล
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection

@push('scriptjs')
<style>
/* จัดแต่งโครงสร้างลายเซ็นให้เรียง 3 ช่องแนวนอนเสมอ */
.sig-container {
    display: flex;
    justify-content: space-between;
    gap: 8px;
    width: 100%;
}
.sig-box {
    flex: 1;
    text-align: center;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 4px;
    background-color: #fdfdfd;
}

/* ตั้งค่าหน้ากระดาษ A4 ขนาดตัวหนังสือชัดเจนและพอดีแผ่นเดียว */
@media print {
    @page {
        size: A4 portrait;
        margin: 5mm;
    }
    body {
        background-color: #ffffff !important;
        color: #000000 !important;
        font-size: 12px !important;
        -webkit-print-color-adjust: exact;
    }
    .d-print-none {
        display: none !important;
    }
    .card, .iso-card {
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .card-body {
        padding: 0 !important;
    }
    .form-control, .form-select {
        border: none !important;
        border-bottom: 1px dotted #6c757d !important;
        border-radius: 0 !important;
        padding: 2px 0 !important;
        background-color: transparent !important;
        box-shadow: none !important;
        font-size: 12px !important;
    }
    textarea.form-control {
        border: 1px solid #ced4da !important;
        padding: 4px !important;
        font-size: 11px !important;
    }
    .sig-box {
        border: 1px solid #ced4da !important;
        background-color: transparent !important;
    }
}
</style>
@endpush