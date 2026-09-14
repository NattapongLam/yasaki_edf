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
            <div class="col-12 col-md-3"><h3 class="card-title">รับข้อร้องเรียนจากลูกค้า</h3></div> 
            <div class="col-12 col-md-9">
                <!-- ฟอร์มเลือกช่วงวันที่ -->
                <form action="{{ route('complaints.index') }}" method="GET" class="row g-2 justify-content-end">
                    <div class="col-auto align-self-center">
                        <label class="col-form-label">จากวันที่:</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" name="from_date" value="{{ request('from_date', \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d')) }}" class="form-control">
                    </div>
                    <div class="col-auto align-self-center">
                        <label class="col-form-label">ถึง:</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" name="to_date" value="{{ request('to_date', \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d')) }}" class="form-control">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> ค้นหา</button>
                        <a href="{{ route('complaints.index') }}" class="btn btn-light">เดือนนี้</a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('complaints.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> เพิ่มรายการ</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">            
            <div class="col-12">
            <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>
                    <th>วันที่รับเรื่อง</th>
                    <th>เลขที่อ้างอิง</th>
                    <th>ลูกค้า</th>
                    <th>รายละเอียดปัญหา</th>
                    <th>อัพเดท</th>
                    <th>ยกเลิก</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hd as $item)
                    <tr>
                        <td>{{ $item->customer_complaints_lists_date }}</td>
                        <td>{{ $item->customer_complaints_lists_refdocuno }}</td>
                        <td>{{ $item->ar_customer_lists_name1 }}</td>
                        <td>{{ $item->customer_complaints_lists_details }}</td>
                        <td>
                            <a href="{{ route('complaints.edit', $item->customer_complaints_lists_id) }}" class="btn btn-sm btn-warning" >
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->customer_complaints_lists_id }}')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
            </div>
        </div>      
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
                url: `{{ url('/CancelComplaints') }}`, // ปรับเปลี่ยน URL ตาม Route จริงของระบบท่านหากจำเป็น
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "refid": refid,               
                },         
                dataType: "json",
                success: function(data) {
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
                    });           
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
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