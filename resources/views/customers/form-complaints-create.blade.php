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
        <form method="POST" class="form-horizontal" action="{{ route('complaints.store') }}" enctype="multipart/form-data">
        @csrf  
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">รับข้อร้องเรียนจากลูกค้า</h3></div> 
        </div>
        <div class="row">            
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">วันที่รับเรื่อง</label>
                    <input class="form-control" name="customer_complaints_lists_date" type="date" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">เลขทีอ้างอิง</label>
                    <input class="form-control" name="customer_complaints_lists_refdocuno" type="text" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="form-label">ลูกค้า</label>
                    <select class="form-select" name="ar_customer_lists_id">
                        <option value="0">กรุณาเลือก</option>
                        @foreach ($cust as $item)
                            <option value="{{$item->ar_customer_lists_id}}">{{$item->ar_customer_lists_name1}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">รายละเอียดปัญหา</label>
                    <textarea class="form-control" rows="5" name="customer_complaints_lists_details" required></textarea>
                </div>
            </div>
        </div> 
        <br>
                <div class="col-12 col-md-1">
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">
                            บันทึก
                        </button>
                    </div>
                </div>
                </form>            
    </div>
</div>
</div>
@endsection
@push('scriptjs')
<script>
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
            url: `{{ url('/CancelQuotationsDoc') }}`,
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