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
            <div class="col-12 col-md-6"><h3 class="card-title">ใบสั่งซื้อ</h3></div>
            <div class="col-12 col-md-6"><a style="float: right" href="{{route('purchaseorders.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> เพิ่มรายการ</a></div>
        </div>       
        <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>
                    <th>สถานะ</th>
                    <th>วันที่</th>
                    <th>เลขที่</th>
                    <th>ผู้จำหน่าย</th>
                    <th>ยอดเงิน</th>
                    <th>ผู้อนุมัติ</th>                   
                    <th>แก้ไข</th>
                    <th>ยกเลิก</th>
                    <td></td>  
                </tr>
            </thead>
            <tbody>
                @foreach ($hd as $item)
                    <tr>
                        <td>
                            @if ($item->ap_purchaseorder_statuses_id == 1)
                                <span class="bg-warning bg-soft">
                                    {{$item->ap_purchaseorder_statuses_name}}
                                </span>
                            @elseif($item->ap_purchaseorder_statuses_id == 2)
                                <span class="bg-danger bg-soft">
                                    {{$item->ap_purchaseorder_statuses_name}}
                                </span>
                            @elseif($item->ap_purchaseorder_statuses_id == 3)
                                <span class="bg-success bg-soft">
                                    {{$item->ap_purchaseorder_statuses_name}}
                                </span>
                            @endif
                        </td>    
                        <td>
                            {{$item->ap_purchaseorder_hds_date}}
                        </td>   
                        <td>
                            {{$item->ap_purchaseorder_hds_docuno}}
                        </td>  
                        <td>
                            {{$item->ap_vendor_lists_name}}
                        </td> 
                        <td>
                            {{number_format($item->ap_purchaseorder_hds_amount,2)}}
                        </td>   
                        <td>
                            @if ($item->approved_by)
                                {{$item->approved_by}}
                                (วันที่ : {{$item->approved_date}} )
                            @else
                                @if ($item->ap_purchaseorder_statuses_id == 1)
                                    <a href="{{route('purchaseorders.show',$item->ap_purchaseorder_hds_id)}}" class="btn btn-sm btn-primary" >
                                        <i class="fas fa-edit"></i>
                                    </a> 
                                @endif
                            @endif
                        </td>  
                        <td>
                            @if ($item->ap_purchaseorder_statuses_id == 1)
                                <a href="{{route('purchaseorders.edit',$item->ap_purchaseorder_hds_id)}}" class="btn btn-sm btn-warning" >
                                    <i class="fas fa-edit"></i>
                                </a> 
                            @endif
                        </td>  
                        <td>
                             @if ($item->ap_purchaseorder_statuses_id == 1)
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->ap_purchaseorder_hds_id }}')"><i class="fas fa-trash"></i></a>
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
            url: `{{ url('/CancelPurchaseOrderDoc') }}`,
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