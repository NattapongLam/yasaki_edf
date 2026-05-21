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
            <div class="col-12 col-md-6"><h3 class="card-title">จัดการเคมี</h3></div>
             <div class="col-12 col-md-6"><a style="float: right" href="{{route('chemistrys.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> เพิ่มรายการ</a></div>
        </div>   
        <div class="table-responsive">
              <table id="tb_job" class="table table-bordered table-sm nowrap w-100 text-center">
            <thead>
                <tr>
                    <th></th>                   
                    <th>วันที่</th>
                    <th>พิมพ์</th>
                    <th>ประเภท</th>                   
                    <th>เลขที่สูตร</th>
                    <th>ชื่อสูตร</th>
                    <th>หมายเหตุ</th>
                    <th>ผู้บันทึก</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hd as $item)
                   <tr>
                        <td>
                            <a href="{{route('chemistrys.show',$item->chemistry_hd_id)}}" class="btn btn-sm btn-info" >
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>                        
                        <td>{{$item->chemistry_hd_date}}</td>
                        <td>
                            <a href="{{ route('chemistrys.print',$item->chemistry_hd_id) }}"
                                target="_blank"
                                class="btn btn-sm btn-warning">
                                <i class="fas fa-print"></i>
                            </a>
                        </td>
                        <td>{{$item->chemistry_hd_type}}</td>
                        <td>{{$item->chemistry_hd_name}}</td>
                        <td>{{$item->ms_formule_name}}</td>
                        <td>{{$item->chemistry_hd_note}}</td>
                        <td>{{$item->chemistry_hd_save}}</td>
                       <td>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->chemistry_hd_id }}')"><i class="fas fa-trash"></i></a> 
                       </td>
                   </tr>
                @endforeach
            </tbody>
        </table>
        </div>    
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
            order: [[1, 'desc']],
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
            url: `{{ url('/confirmDelChemistryHd') }}`,
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