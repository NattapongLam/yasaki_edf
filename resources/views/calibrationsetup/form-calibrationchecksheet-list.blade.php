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
            <div class="col-12 col-md-6"><h3 class="card-title">ตรวจเช็คประจำวันเครื่องมือวัด</h3></div>
        </div> 
        <!-- ฟอร์มเลือกช่วงวันที่ (แสดงค่าเดือนปัจจุบันเป็นค่าเริ่มต้น) -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="start_date" class="form-label">จากวันที่:</label>
                <input type="date" id="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">ถึงวันที่:</label>
                <input type="date" id="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="button" id="btn-filter" class="btn btn-primary me-2"><i class="fas fa-search"></i> ค้นหา</button>
                <button type="button" id="btn-reset" class="btn btn-secondary"><i class="fas fa-redo"></i> รีเซ็ต</button>
            </div>
        </div>
        <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>
                    <th>เดือน - ปี</th>
                    <th>เครื่องมือวัด</th>
                    <th>หมายเหตุ</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hd as $item)
                    <tr>
                        <td>{{\Carbon\Carbon::parse($item->calibration_checksheet_hds_date)->format('m/Y')}}</td>
                        <td>{{$item->calibration_lists_code}}/{{$item->calibration_lists_name}}</td>
                        <td>{{$item->calibration_checksheet_hds_remark}}</td>
                        <td>
                            <a href="{{route('calibrationchecksheets.edit',$item->calibration_checksheet_hds_id)}}" class="btn btn-sm btn-warning" >
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->calibration_checksheet_hds_id }}')"><i class="fas fa-trash"></i></a> 
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
    // ตั้งค่า DataTable ปกติ
    $('#tb_job').DataTable({
        "pageLength": 50,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    // Event เมื่อคลิกปุ่มค้นหา
    $('#btn-filter').click(function() {
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();

        // ส่งค่าผ่าน Query String ไปยัง Controller (เปลี่ยนเส้นทาง URL ปัจจุบันพร้อมพารามิเตอร์)
        let currentUrl = "{{ url()->current() }}";
        window.location.href = `${currentUrl}?start_date=${startDate}&end_date=${endDate}`;
    });

    // Event เมื่อคลิกปุ่มรีเซ็ต
    $('#btn-reset').click(function() {
        window.location.href = "{{ url()->current() }}";
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
            url: `{{ url('/confirmDelCalibrationChecksheets') }}`,
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