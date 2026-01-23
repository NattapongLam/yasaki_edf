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
            <div class="col-12 col-md-6"><h3 class="card-title">คำร้องขอใช้บริการ</h3></div>
            <div class="col-12 col-md-6"><a style="float: right" href="{{route('requestorders.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> เพิ่มรายการ</a></div>
        </div>       
        <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>
                    <th>สถานะ</th>
                    <th>วันที่</th>
                    <th>เลขที่</th>
                    <th>ลูกค้า</th>
                    <th>ติดต่อ</th>
                    <th>หมายเหตุ</th>
                    <th>แก้ไข</th>
                    <th>ยกเลิก</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hd as $item)
                    <tr>
                        <td>
                             @if ($item->ar_requestorder_statuses_id == 1)
                                <span class="bg-warning bg-soft">
                                    {{$item->ar_requestorder_statuses_name}}
                                </span>
                            @elseif($item->ar_requestorder_statuses_id == 2)
                                <span class="bg-success bg-soft">
                                    {{$item->ar_requestorder_statuses_name}}
                                </span>
                            @elseif($item->ar_requestorder_statuses_id == 3)
                                <span class="bg-danger bg-soft">
                                    {{$item->ar_requestorder_statuses_name}}
                                </span>
                            @endif
                        </td>
                        <td>
                            {{$item->ar_requestorder_hds_date}}
                        </td>
                        <td>
                            {{$item->ar_requestorder_hds_docuno}}
                        </td>
                        <td>
                            {{$item->ar_requestorder_hds_customer}}
                        </td>
                        <td>
                            {{$item->ar_requestorder_hds_contact}}
                        </td>
                        <td>
                            {{$item->ar_requestorder_hd_remark}}
                        </td>
                        <td>
                            @if ($item->ar_requestorder_statuses_id == 1)
                                <a href="{{route('requestorders.edit',$item->ar_requestorder_hds_id)}}" class="btn btn-sm btn-warning" >
                                    <i class="fas fa-edit"></i>
                                </a> 
                            @endif
                        </td>
                        <td>
                            @if ($item->ar_requestorder_statuses_id == 1)
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->ar_requestorder_hds_id }}')"><i class="fas fa-trash"></i></a>
                            @endif
                        </td>
                        <td></td>
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
            url: `{{ url('/CancelRequestOrderDoc') }}`,
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