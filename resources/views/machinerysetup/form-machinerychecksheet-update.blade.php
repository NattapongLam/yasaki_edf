@extends('layouts.main')
@push('styles')
<style>
/* สำคัญมาก */
.custom-table {
    border-collapse: separate !important;
    border-spacing: 0;
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
    padding: 6px 4px;
    background: #ffffff;
    font-size: 13px;
    vertical-align: middle;
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
    min-width: 50px;
}

/* Sticky คอลัมน์ รายละเอียด */
.custom-table th:nth-child(2),
.custom-table td:nth-child(2) {
    position: sticky;
    left: 50px; /* ต้องเท่ากับความกว้างคอลัมน์แรก */
    background: #ffffff;
    z-index: 9;
    min-width: 250px;
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
    gap: 4px;
    min-width: 45px;
}

.day-check {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

/* ปรับแต่ง Input ให้เล็กลงและพิมพ์ง่าย */
.cell-input {
    height: 26px;
    padding: 2px 4px;
    font-size: 12px;
    text-align: center;
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
        <div class="card-body">
            <form method="POST" class="form-horizontal" action="{{ route('machinerychecksheets.update',$hd->machinery_checksheet_hds_id) }}" enctype="multipart/form-data">
                @csrf 
                @method('PUT')
                
                <div class="row">
                    <div class="col-12 col-md-6"><h3 class="card-title">ตรวจประจำวัน</h3></div>
                </div>    
                
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="machinery_checksheet_hds_date" class="col-form-label">วันที่</label>
                            <input type="date" class="form-control" 
                                name="machinery_checksheet_hds_date" 
                                id="machinery_checksheet_hds_date" 
                                value="{{$hd->machinery_checksheet_hds_date}}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="machinery_lists_code" class="col-form-label">รหัสเครื่องจักร</label>
                            <input class="form-control" value="{{$hd->machinery_lists_code}}" name="machinery_lists_code" readonly>
                            <input type="hidden" class="form-control" value="{{$hd->machinery_lists_id}}" name="machinery_lists_id" readonly>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="machinery_lists_name" class="col-form-label">ชื่อเครื่องจักร</label>
                            <input class="form-control" value="{{$hd->machinery_lists_name}}" name="machinery_lists_name" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="machinery_checksheet_hds_remark" class="col-form-label">หมายเหตุ</label>
                            <input class="form-control" name="machinery_checksheet_hds_remark" value="{{$hd->machinery_checksheet_hds_remark}}" readonly>
                        </div>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="table-responsive">
                        <table class="table custom-table text-center">
                            <thead>
                                <tr>
                                    <th style="width:50px;">#</th>
                                    <th style="min-width:250px;">รายละเอียด</th>
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
                                            <textarea class="form-control" name="machinery_checksheet_dts_remark[]" rows="3">{{ $item->machinery_checksheet_dts_remark }}</textarea>
                                        </td>

                                        @for ($i = 1; $i <= 31; $i++)
                                            @php
                                                $field = 'action_' . str_pad($i, 2, '0', STR_PAD_LEFT);
                                                // สมมติชื่อฟิลด์เก็บค่ามาตรฐาน/ตัวเลขใน Database เช่น standard_01 เป็นต้น (สามารถปรับเปลี่ยนได้ตามจริง)
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
                                                        {{ $item->$field ? 'checked' : '' }}
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
   
                <br>
                <div class="row">
                    <div class="col-12 col-md-2">
                        <button type="submit" class="btn btn-block btn-primary">
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
    // ช่วยให้เวลาคลิกเข้าไปในช่องกรอกข้อมูล จะเลือกข้อความทั้งหมดให้อัตโนมัติ เพื่อให้พิมพ์ทับได้รวดเร็ว
    document.addEventListener('focus', function(e) {
        if (e.target && e.target.classList.contains('cell-input')) {
            e.target.select();
        }
    }, true);
</script>
@endpush