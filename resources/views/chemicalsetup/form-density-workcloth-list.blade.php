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
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">ความหนาแน่นของผ้าชิ้น</h3></div>
            <div class="col-12 col-md-6"><a style="float: right" href="{{route('density-workcloth.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> เพิ่มรายการ</a></div>
        </div>      
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
                    <th>วันที่</th>
                    <th>เครื่อง</th>
                    <th>แม่พิมพ์</th>
                    <th>สินค้า</th>
                    <th>สูตรเคมี</th>
                    <th>หมายเหตุ</th>
                    <th>อัพเดท</th>
                    <th>ยกเลิก</th>
                </tr>
            </thead>
        <tbody>
        @foreach ($hd as $item)
            <tr>
                <!-- วันที่ -->
                <td class="align-middle text-center">
                    <span class="fw-semibold text-secondary">{{ $item->density_workcloth_hds_date }}</span>
                </td>

                <!-- เครื่อง -->
                <td class="align-middle">
                    <div class="d-flex justify-content-between align-items-center bg-light px-2 py-1 rounded border">
                        <span class="text-dark fw-semibold">{{ $item->machinery_name }}</span>
                        <a href="{{ route('density-workcloth.show', ['density_workcloth' => $item->machinery_name, 'type' => 'เครื่อง']) }}" class="btn btn-sm btn-outline-primary py-0 px-2" title="ดูประวัติเครื่องนี้">
                            <i class="fas fa-eye fa-xs"></i>
                        </a>
                    </div>
                </td>

                <!-- แม่พิมพ์ -->
                <td class="align-middle">
                    <div class="d-flex justify-content-between align-items-center bg-light px-2 py-1 rounded border">
                        <div class="text-start">
                            <span class="d-block text-dark fw-semibold" style="font-size: 13px;">{{ $item->mlod_name }}</span>
                            <span class="text-muted" style="font-size: 11px;">({{ $item->mlod_code }})</span>
                        </div>
                        <a href="{{ route('density-workcloth.show', ['density_workcloth' => $item->mlod_code, 'type' => 'แม่พิมพ์']) }}" class="btn btn-sm btn-outline-primary py-0 px-2" title="ดูประวัติแม่พิมพ์นี้">
                            <i class="fas fa-eye fa-xs"></i>
                        </a>
                    </div>
                </td>

                <!-- สินค้า -->
                <td class="align-middle">
                    <div class="d-flex justify-content-between align-items-center bg-light px-2 py-1 rounded border">
                        <div class="text-start">
                            <span class="d-block text-dark fw-semibold" style="font-size: 13px;">{{ $item->product_name }}</span>
                            <span class="text-muted" style="font-size: 11px;">({{ $item->product_code }})</span>
                        </div>
                        <a href="{{ route('density-workcloth.show', ['density_workcloth' => $item->product_code, 'type' => 'สินค้า']) }}" class="btn btn-sm btn-outline-primary py-0 px-2" title="ดูประวัติสินค้านี้">
                            <i class="fas fa-eye fa-xs"></i>
                        </a>
                    </div>
                </td>

                <!-- สูตรเคมี -->
                <td class="align-middle">
                    <div class="d-flex justify-content-between align-items-center bg-light px-2 py-1 rounded border">
                        <div class="text-start">
                            <span class="d-block text-dark fw-semibold" style="font-size: 13px;">{{ $item->ms_formule_name }}</span>
                            <span class="text-muted" style="font-size: 11px;">({{ $item->chemistry_hd_name }})</span>
                        </div>
                        <a href="{{ route('density-workcloth.show', ['density_workcloth' => $item->chemistry_hd_name, 'type' => 'สูตร']) }}" class="btn btn-sm btn-outline-primary py-0 px-2" title="ดูประวัติสูตรนี้">
                            <i class="fas fa-eye fa-xs"></i>
                        </a>
                    </div>
                </td>

                <!-- หมายเหตุ -->
                <td class="align-middle text-start">
                    <span class="text-muted" style="font-size: 13px;">{{ $item->density_workcloth_hds_note ?? '-' }}</span>
                </td>

                <!-- อัพเดท (แก้ไข) -->
                <td class="align-middle text-center">
                    <a href="{{ route('density-workcloth.edit', $item->density_workcloth_hds_id) }}" class="btn btn-sm btn-info text-white" title="แก้ไขรายการ">
                        <i class="fas fa-edit"></i>
                    </a>
                </td>

                <!-- ยกเลิก (ลบ) -->
                <td class="align-middle text-center">
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->density_workcloth_hds_id }}')" title="ลบรายการ">
                        <i class="fas fa-trash"></i>
                    </a> 
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
        "pageLength": 30,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    // ปุ่มค้นหา
    $('#btn-filter').click(function() {
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();
        
        // รีไดเรกต์ไปยังหน้าเดิมพร้อมแนบ Query String วันที่
        window.location.href = `{{ route('density-workcloth.index') }}?start_date=${startDate}&end_date=${endDate}`;
    });

    // ปุ่มรีเซ็ต
    $('#btn-reset').click(function() {
        window.location.href = `{{ route('density-workcloth.index') }}`;
    });
});
confirmDel = (refid) =>{
Swal.fire({
    title: 'คุณแน่ใจหรือไม่ !',
    text: `คุณต้องการลบรายการนี้หรือไม่ ?`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'ยืนยัน',
    cancelButtonText: 'ยกเลิก',
    confirmButtonClass: 'btn btn-success',
    cancelButtonClass: 'btn btn-danger',
    buttonsStyling: false         
}).then(function(result) {
    if (result.value) {
        $.ajax({
            url: `{{ url('/confirmDelDensityWorkcloth') }}`,
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "refid": refid,               
            },           
            dataType: "json",
            success: function(data) {
                // console.log(data);
                if (data.status == true) {
                    Swal.fire({
                        title: 'สำเร็จ',
                        text: 'ยกเลิกเอกสารเรียบร้อยแล้ว',
                        icon: 'success'
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'ยกเลิกเอกสารไม่สำเร็จ',
                        icon: 'error'
                    });
                }
               
            },
            error: function(data) {
                Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'ยกเลิกเอกสารไม่สำเร็จ',
                        icon: 'error'
                    });            }
        });

    } else if ( // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
            title: 'ยกเลิก',
            text: 'โปรดตรวจสอบข้อมูลอีกครั้งเพื่อความถูกต้อง :)',
            icon: 'error'
        });
    }
});
}
</script>
@endpush