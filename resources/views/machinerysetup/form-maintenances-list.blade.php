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
            <div class="col-12 col-md-6"><h3 class="card-title">ใบแจ้งซ่อม</h3></div>
            <div class="col-12 col-md-6"><a style="float: right" href="{{route('maintenances.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> เพิ่มรายการ</a></div>
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
                        // คำนวณหาจำนวนวันที่ใช้ / หรือระยะเวลาระหว่าง วันที่แจ้ง กับ กำหนดเสร็จ
                        $startDate = \Carbon\Carbon::parse($item->repair_machinery_hds_date);
                        $dueDate = \Carbon\Carbon::parse($item->repair_machinery_hds_duedate);
                        
                        // หาผลต่างเป็นจำนวนวัน
                        $diffDays = $startDate->diffInDays($dueDate);
                        
                        // ตรวจสอบว่าเลยกำหนดหรือยัง (ถ้าเทียบกับวันปัจจุบัน)
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
                            <a href="{{route('maintenances.edit',$item->repair_machinery_hds_id)}}" class="btn btn-sm btn-info" >
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
    })
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
            url: `{{ url('/confirmDelMaintenances') }}`,
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
                        text: 'ยกเลิกรายการเรียบร้อยแล้ว',
                        icon: 'success'
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'ยกเลิกรายการไม่สำเร็จ',
                        icon: 'error'
                    });
                }
               
            },
            error: function(data) {
                Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'ยกเลิกรายการไม่สำเร็จ',
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