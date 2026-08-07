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
            <div class="col-12 col-md-6"><h3 class="card-title">ทะเบียนเอกสารควบคุม</h3></div>
            <div class="col-12 col-md-6"><a style="float: right" href="{{route('master-list.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> เพิ่มรายการ</a></div>
        </div>      
        
        <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>วันที่ขึ้นทะเบียน</th>
                    <th>ประเภท</th>
                    <th>เลขที่เอกสาร</th>
                    <th>ชื่อเอกสาร</th>
                    <th>สถานะ</th>
                    <th>แผนก</th>
                    <th>สถานที่จัดเก็บ</th>
                    <th>ไฟล์</th>
                    <th>จัดการ</th>
                    <th>ลบ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hd as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->doc_master_lists_date }}</td>
                    <td>{{ $item->doc_master_lists_type }}</td>
                    <td>{{ $item->doc_master_lists_docuno }}</td>
                    <td>{{ $item->doc_master_lists_docuname }}</td>
                    <td>
                        <span class="badge bg-info">{{ $item->doc_master_lists_status }}</span>
                    </td>
                    <td>{{ $item->doc_master_lists_department }}</td>
                    <td>{{ $item->doc_master_lists_location }}</td>
                    <td>
                        @if ($item->doc_master_lists_file1)
                            <a href="{{asset($item->doc_master_lists_file1)}}" target="_blank">
                                <i class="fas fa-file"></i>
                            </a>
                        @endif
                        @if ($item->doc_master_lists_file2)
                            <a href="{{asset($item->doc_master_lists_file2)}}" target="_blank">
                                <i class="fas fa-file"></i>
                            </a>
                        @endif
                    </td>
                    <td>
                        <!-- ปุ่มจัดการ (แก้ไข / ลบ ตามต้องการ) -->
                        <a href="{{route('master-list.edit',$item->doc_master_lists_id)}}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                    </td>
                    <td>
                         <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->doc_master_lists_id }}')"><i class="fas fa-trash"></i></a>
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
            url: `{{ url('/CancelMasterList') }}`,
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