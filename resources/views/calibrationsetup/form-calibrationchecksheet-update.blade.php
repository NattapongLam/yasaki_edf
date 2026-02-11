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
    padding: 8px 6px;
    background: #ffffff;
    font-size: 14px;
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
    min-width: 60px;
}

/* Sticky คอลัมน์ รายละเอียด */
.custom-table th:nth-child(2),
.custom-table td:nth-child(2) {
    position: sticky;
    left: 60px; /* ต้องเท่ากับความกว้างคอลัมน์แรก */
    background: #ffffff;
    z-index: 9;
    min-width: 250px;
}

/* Hover */
.custom-table tbody tr:hover td {
    background-color: #eef4ff;
}

/* Checkbox */
.day-check {
    width: 20px;
    height: 20px;
    cursor: pointer;
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
        <form method="POST" class="form-horizontal" action="{{ route('calibrationchecksheets.update',$hd->calibration_checksheet_hds_id) }}" enctype="multipart/form-data">
        @csrf 
        @method('PUT')
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">ตรวจประจำวัน</h3></div>
        </div>    
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="calibration_checksheet_hds_date" class="col-form-label">วันที่</label>
                    <input type="date" class="form-control" 
                        name="calibration_checksheet_hds_date" 
                        id="calibration_checksheet_hds_date" 
                        value="{{$hd->calibration_checksheet_hds_date}}"
                        readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="calibration_lists_code" class="col-form-label">รหัสเครื่องมือวัด</label>
                    <input class="form-control" value="{{$hd->calibration_lists_code}}" name="calibration_lists_code" readonly>
                    <input type="hidden" class="form-control" value="{{$hd->calibration_lists_id}}" name="calibration_lists_id" readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="calibration_lists_name" class="col-form-label">ชื่อเครื่องมือวัด</label>
                    <input class="form-control" value="{{$hd->calibration_lists_name}}" name="calibration_lists_name" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="calibration_checksheet_hds_remark" class="col-form-label">หมายเหตุ</label>
                    <input class="form-control" name="calibration_checksheet_hds_remark" value="{{$hd->calibration_checksheet_hds_remark}}" readonly>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
    <div class="table-responsive">
        <table class="table custom-table text-center">
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th style="min-width:250px;">รายละเอียด</th>

                    @for ($i = 1; $i <= 31; $i++)
                        <th>
                            {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                        </th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach ($dt as $index => $item)
                    <tr>
                        <td>
                            {{ $item->calibration_checksheet_dts_listno }}
                            <input type="hidden" name="calibration_checksheet_dts_id[]" value="{{ $item->calibration_checksheet_dts_id }}">
                        </td>

                        <td>
                            {{ $item->calibration_checksheet_dts_remark }}
                        </td>

                        @for ($i = 1; $i <= 31; $i++)
                            @php
                                $field = 'action_' . str_pad($i, 2, '0', STR_PAD_LEFT);
                            @endphp
                            <td>
                                <input 
                                    type="checkbox"
                                    class="day-check"
                                    name="action[{{ $index }}][{{ $field }}]"
                                    value="1"
                                    {{ $item->$field ? 'checked' : '' }}
                                >
                            </td>
                        @endfor

                    </tr>
                @endforeach
            </tbody>
        </table>
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