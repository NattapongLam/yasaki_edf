@extends('layouts.main')
@push('styles')
<style>
/* สำคัญมาก */
.custom-table {
    border-collapse: separate !important;
    border-spacing: 0;
    width: 100%;
}

/* Scroll container */
.table-responsive {
    max-height: 600px;
    overflow: auto;
    border: 1px solid #dee2e6;
}

/* เส้นตาราง */
.custom-table th,
.custom-table td {
    border-right: 1px solid #dee2e6;
    border-bottom: 1px solid #dee2e6;
    padding: 3px 1px;
    background: #ffffff;
    font-size: 10px;
    vertical-align: middle;
    text-align: center;
}

/* เส้นซ้ายสุด */
.custom-table tr td:first-child,
.custom-table tr th:first-child {
    border-left: 1px solid #dee2e6;
}

/* เส้นบนสุด */
.custom-table thead tr th {
    border-top: 1px solid #dee2e6;
}

/* Header */
.custom-table thead th {
    position: sticky;
    top: 0;
    background: #2f3e5c;
    color: #fff;
    z-index: 10;
}

/* Sticky คอลัมน์ # */
.custom-table th:first-child,
.custom-table td:first-child {
    position: sticky;
    left: 0;
    background: #f8f9fa;
    z-index: 11;
    min-width: 25px;
}

/* Sticky คอลัมน์ รายละเอียด */
.custom-table th:nth-child(2),
.custom-table td:nth-child(2) {
    position: sticky;
    left: 25px; 
    background: #ffffff;
    z-index: 9;
    min-width: 150px;
    text-align: left;
    padding-left: 4px;
}

/* Hover */
.custom-table tbody tr:hover td {
    background-color: #eef4ff;
}

/* จัดระเบียบช่องกรอกข้อมูลในตาราง */
.cell-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1px;
    min-width: 24px;
}

.day-check {
    width: 12px;
    height: 12px;
    cursor: pointer;
}

.cell-input {
    height: 18px;
    padding: 0px;
    font-size: 9px;
    text-align: center;
}

/* ส่วนสำหรับลายเซ็น */
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

/* ---------------------------------------------------- */
/* ตั้งค่าเฉพาะตอนสั่งพิมพ์ (Print Mode A4 แนวนอน)       */
/* ---------------------------------------------------- */
@media print {
    @page {
        size: A4 landscape;
        margin: 3mm;
    }
    body {
        background-color: #ffffff !important;
        color: #000000 !important;
        font-size: 8.5px !important;
        -webkit-print-color-adjust: exact;
    }
    .d-print-none {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .card-body {
        padding: 0 !important;
    }
    .table-responsive {
        max-height: none !important;
        overflow: visible !important;
        border: none !important;
    }
    .custom-table thead th {
        background: #2f3e5c !important;
        color: #fff !important;
        -webkit-print-color-adjust: exact;
    }
    .custom-table th,
    .custom-table td {
        padding: 2px 0px !important;
        font-size: 8px !important;
    }
    .form-control {
        border: none !important;
        border-bottom: 1px dotted #6c757d !important;
        border-radius: 0 !important;
        padding: 1px 0 !important;
        background-color: transparent !important;
        box-shadow: none !important;
        font-size: 8.5px !important;
    }
    textarea.form-control {
        height: auto !important;
        min-height: 25px !important;
        resize: none;
    }
    .cell-input {
        height: 15px !important;
        font-size: 8px !important;
        border: 1px solid #ced4da !important;
    }
    .sig-box {
        border: 1px solid #ced4da !important;
        background-color: transparent !important;
        padding: 2px !important;
    }
}
</style>
@endpush

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
        <div class="card-body p-2">
            <form method="POST" class="form-horizontal" action="{{ route('machinerychecksheets.update',$hd->machinery_checksheet_hds_id) }}" enctype="multipart/form-data">
                @csrf 
                @method('PUT')
                
                <!-- ส่วนหัวและปุ่มพิมพ์ -->
                <div class="row align-items-center mb-1">
                    <div class="col-6">
                        <h3 class="card-title mb-0 fs-6 fw-bold">ตรวจประจำวันเครื่องจักร</h3>
                    </div>
                    <div class="col-6 text-end d-print-none">
                        <button type="button" class="btn btn-dark btn-sm shadow-sm" onclick="window.print()">
                            <i class="mdi mdi-printer me-1"></i> พิมพ์เอกสาร / PDF (A4 แนวนอน)
                        </button>
                    </div>
                </div>    
                
                <div class="row g-1 mb-1">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="machinery_checksheet_hds_date" class="col-form-label form-label-sm fw-semibold" style="font-size: 11px;">วันที่</label>
                            <input type="date" class="form-control form-control-sm" 
                                name="machinery_checksheet_hds_date" 
                                id="machinery_checksheet_hds_date" 
                                value="{{$hd->machinery_checksheet_hds_date}}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="machinery_lists_code" class="col-form-label form-label-sm fw-semibold" style="font-size: 11px;">รหัสเครื่องจักร</label>
                            <input class="form-control form-control-sm" value="{{$hd->machinery_lists_code}}" name="machinery_lists_code" readonly>
                            <input type="hidden" class="form-control" value="{{$hd->machinery_lists_id}}" name="machinery_lists_id" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="machinery_lists_name" class="col-form-label form-label-sm fw-semibold" style="font-size: 11px;">ชื่อเครื่องจักร</label>
                            <input class="form-control form-control-sm" value="{{$hd->machinery_lists_name}}" name="machinery_lists_name" readonly>
                        </div>
                    </div>
                </div>

                <div class="row g-1 mb-2">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="machinery_checksheet_hds_remark" class="col-form-label form-label-sm fw-semibold" style="font-size: 11px;">หมายเหตุ</label>
                            <input class="form-control form-control-sm" name="machinery_checksheet_hds_remark" value="{{$hd->machinery_checksheet_hds_remark}}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="table-responsive">
                        <table class="table custom-table text-center mb-1">
                            <thead>
                                <tr>
                                    <th style="width:25px;">#</th>
                                    <th style="min-width:150px;">รายละเอียด</th>
                                    @for ($i = 1; $i <= 31; $i++)
                                        <th>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dt as $index => $item)
                                    <tr>
                                        <td>
                                            {{ $item->machinery_checksheet_dts_listno }}
                                            <input type="hidden" name="machinery_checksheet_dts_id[]" value="{{ $item->machinery_checksheet_dts_id }}">
                                        </td>
                                        <td>
                                            <textarea class="form-control" name="machinery_checksheet_dts_remark[]" rows="5">{{ $item->machinery_checksheet_dts_remark }}</textarea>
                                        </td>

                                        @for ($i = 1; $i <= 31; $i++)
                                            @php
                                                $field = 'action_' . str_pad($i, 2, '0', STR_PAD_LEFT);
                                                $standardField = 'standard_' . str_pad($i, 2, '0', STR_PAD_LEFT);
                                            @endphp
                                            <td>
                                                <div class="cell-box">
                                                    <!-- Checkbox สำหรับเลือกสถานะ -->
                                                    <input 
                                                        type="checkbox"
                                                        class="day-check"
                                                        name="action[{{ $index }}][{{ $field }}]"
                                                        value="1"
                                                        {{ isset($item->$field) && $item->$field ? 'checked' : '' }}
                                                        title="สถานะ"
                                                    >
                                                    <!-- Input สำหรับกรอกค่าตัวเลขหรือข้อความ -->
                                                    <input 
                                                        type="text"
                                                        class="form-control cell-input"
                                                        name="standard[{{ $index }}][{{ $field }}]"
                                                        value="{{ $item->$standardField ?? 0 }}"
                                                        title="กรอกค่า"
                                                    >
                                                </div>
                                            </td>
                                        @endfor
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
   
                <!-- ส่วนลายเซ็นท้ายเอกสาร -->
                <div class="signature-section mt-2 pt-1 border-top">
                    <div class="sig-container">
                        <div class="sig-box">
                            <div style="height: 8px;"></div>
                            <p class="mb-0 text-muted" style="font-size: 9px;">___________________________</p>
                            <p class="mb-0 fw-semibold text-dark" style="font-size: 9px;">( นายสมควร วรชินา )</p>
                            <p class="text-muted mb-0 fw-bold" style="font-size: 8px;">ผู้ตรวจสอบ / Operator</p>
                            <p class="text-muted mb-0" style="font-size: 7.5px;">วันที่: ____/____/________</p>
                        </div>
                        <div class="sig-box">
                            <div style="height: 8px;"></div>
                            <p class="mb-0 text-muted" style="font-size: 9px;">___________________________</p>
                            <p class="mb-0 fw-semibold text-dark" style="font-size: 9px;">( นางสาวอรวรรณ ขันติวงค์ )</p>
                            <p class="text-muted mb-0 fw-bold" style="font-size: 8px;">ผู้ทวนสอบ / Supervisor</p>
                            <p class="text-muted mb-0" style="font-size: 7.5px;">วันที่: ____/____/________</p>
                        </div>
                        <div class="sig-box">
                            <div style="height: 8px;"></div>
                            <p class="mb-0 text-muted" style="font-size: 9px;">___________________________</p>
                            <p class="mb-0 fw-semibold text-dark" style="font-size: 9px;">( นายโกสินทร์  เตียเอี่ยมดี )</p>
                            <p class="text-muted mb-0 fw-bold" style="font-size: 8px;">ผู้อนุมัติ / Manager</p>
                            <p class="text-muted mb-0" style="font-size: 7.5px;">วันที่: ____/____/________</p>
                        </div>
                    </div>
                </div>

                <div class="row mt-2 d-print-none">
                    <div class="col-12 col-md-2">
                        <button type="submit" class="btn btn-block btn-primary btn-sm shadow-sm">
                            <i class="mdi mdi-content-save me-1"></i> บันทึกข้อมูล
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
    document.addEventListener('focus', function(e) {
        if (e.target && e.target.classList.contains('cell-input')) {
            e.target.select();
        }
    }, true);
</script>
@endpush