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
            <div class="col-12 col-md-4"><h3 class="card-title">ใบแจ้งซ่อม</h3></div>
            <div class="col-12 col-md-8">
                <!-- ฟอร์มเลือกเดือน -->
                <form action="{{ route('maintenances.index') }}" method="GET" class="row g-2 justify-content-end">
                    <div class="col-auto align-self-center">
                        <label for="month" class="col-form-label">เลือกเดือน:</label>
                    </div>
                    <div class="col-auto">
                        <!-- ถ้ายังไม่เลือก ให้ค่าเริ่มต้นเป็นเดือนปัจจุบันในรูปแบบ YYYY-MM -->
                        <input type="month" name="month" value="{{ request('month', \Carbon\Carbon::now()->format('Y-m')) }}" class="form-control">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> ค้นหา</button>
                        <a href="{{ route('maintenances.index') }}" class="btn btn-light">เดือนปัจจุบัน</a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('maintenances.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> เพิ่มรายการ</a>
                    </div>
                </form>
            </div>
        </div>       

        <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>
                    <th>สถานะ</th>
                    <th>วันที่</th>
                    <th>เลขที่</th>
                    <th>กำหนดเสร็จ</th>
                    <th>รายละเอียด</th>
                    <th></th>
                    <th>ยกเลิก</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hd as $item)
                    @php
                        $startDate = \Carbon\Carbon::parse($item->repair_machinery_hds_date);
                        $dueDate = \Carbon\Carbon::parse($item->repair_machinery_hds_duedate);
                        $diffDays = $startDate->diffInDays($dueDate);
                        $now = \Carbon\Carbon::now();
                        $isOverdue = $now->greaterThan($dueDate) && $item->repair_machinery_statuses_name != 'เสร็จสิ้น';
                    @endphp
                    <tr>
                        <td>{{ $item->repair_machinery_statuses_name }}</td>
                        <td>{{ $item->repair_machinery_hds_date }}</td>
                        <td>{{ $item->repair_machinery_hds_docuno }}</td>
                        <td>{{ $item->repair_machinery_hds_duedate }}</td>
                        <td>
                            {{ $item->repair_name }} ({{ $item->repair_code }})<br>
                            @if($isOverdue)
                                <span class="badge bg-danger">เกินกำหนด ({{ $dueDate->diffInDays($now) }} วัน)</span>
                            @else
                                <span class="badge bg-info">กำหนดเวลา: {{ $diffDays }} วัน</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('maintenances.edit', $item->repair_machinery_hds_id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->repair_machinery_hds_id }}')"><i class="fas fa-trash"></i></a>
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
});

function confirmDel(refid) {
    // โค้ด JavaScript สำหรับลบเดิมของคุณ
}
</script>
@endpush