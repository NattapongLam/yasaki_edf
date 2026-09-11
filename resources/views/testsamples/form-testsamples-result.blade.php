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
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <h3 class="card-title">รายการการทดสอบ</h3>
                </div>         
            </div>      

            <!-- เพิ่มส่วนสำหรับเลือกช่วงวันที่ -->
            <div class="row mb-4 align-items-end">
                <div class="col-md-3">
                    <label for="start_date" class="form-label">จากวันที่:</label>
                    <input type="date" id="start_date" class="form-control" value="{{ $startDate ?? now()->startOfMonth()->format('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label">ถึงวันที่:</label>
                    <input type="date" id="end_date" class="form-control" value="{{ $endDate ?? now()->endOfMonth()->format('Y-m-d') }}">
                </div>
                <div class="col-md-4">
                    <button type="button" id="btn-filter" class="btn btn-primary me-2"><i class="fas fa-search me-1"></i> ค้นหา</button>
                    <button type="button" id="btn-reset" class="btn btn-secondary"><i class="fas fa-redo me-1"></i> รีเซ็ต</button>
                </div>
            </div>

            <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
                <thead>
                    <tr>
                        <th>สถานะ</th>
                        <th>เลขที่อ้างอิง</th>
                        <th>ลูกค้า</th>
                        <th>ผู้อนุมัติ</th>
                        <th>ผู้รับชิ้นงาน</th>
                        <th>อัพเดท</th>
                        <th>พิมพ์รายงาน</th>
                        <th>เอกสารส่งมอบ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hd as $item)
                        <tr>
                            <td>
                                @if ($item->ar_requestorder_statuses_id == 6)
                                    <span class="bg-warning bg-soft">
                                        {{$item->ar_requestorder_statuses_name}}
                                    </span>
                                @else
                                    <span class="bg-danger bg-soft">
                                        {{$item->ar_requestorder_statuses_name}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                {{$item->ar_requestorder_hds_docuno}}<br>
                                วันที่ : {{$item->ar_requestorder_hds_date}}<br>
                                <a href="{{ route('report.xbar', $item->ar_requestorder_hds_docuno) }}" class="btn btn-sm btn-info" target="_blank" title="เปิดกราฟ X-bar & R">
                                    <i class="fas fa-print"></i>
                                </a>
                            </td>
                            <td>
                                {{$item->ar_requestorder_hds_customer}}<br>
                                ผู้ติดต่อ : {{$item->ar_requestorder_hds_contact}}<br>
                                หมายเหตุ : {{$item->ar_requestorder_hd_remark}}
                            </td>
                            <td>
                                {{$item->approved_at}}<br>
                                {{\Carbon\Carbon::parse($item->approved_date)->format('d/m/Y') ?? ''}}
                            </td>
                            <td>
                                {{$item->person_at}}<br>
                                {{\Carbon\Carbon::parse($item->receive_test_lists_date)->format('d/m/Y') ?? ''}}<br>
                                มิติชิ้นงานวัดจริง: {{$item->receive_test_lists_dimensions}}<br>
                                น้ำหนักชิ้นงานชั่งจริง: {{$item->receive_test_lists_weight}}<br>
                                สูตรเคมี: {{$item->ms_formule_name}} ({{$item->chemistry_hd_name}})
                            </td>
                            <td>
                                <a href="{{ route('receive-result.detail.edit', $item->ar_requestorder_hds_id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                @if ($item->TestID)
                               <a href="{{ route('report.compareformulas.print',$item->TestID) }}" target="_blank" class="btn btn-sm btn-warning">
                                    <i class="fas fa-print"></i>
                                </a>     
                                @endif               
                            </td>
                            <td>
                                <a href="{{ route('delivered.edit',$item->ar_requestorder_hds_id) }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> สร้าง</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scriptjs')
<script>
$(document).ready(function() {
    $('#tb_job').DataTable({
        "pageLength": 10,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    // Event คลิกปุ่มค้นหา ส่งค่าวันที่ผ่าน Query String
    $('#btn-filter').click(function() {
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();
        let currentUrl = "{{ url()->current() }}";
        window.location.href = `${currentUrl}?start_date=${startDate}&end_date=${endDate}`;
    });

    // Event คลิกปุ่มรีเซ็ต ล้างค่ากลับเป็นเดือนปัจจุบัน
    $('#btn-reset').click(function() {
        window.location.href = "{{ url()->current() }}";
    });
});
</script>
@endpush