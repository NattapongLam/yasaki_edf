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
        <form method="POST" class="form-horizontal" action="{{ route('chemicalgroups.update',$hd->chemical_groups_id) }}" enctype="multipart/form-data">
        @csrf   
        @method('PUT')     
        <h3 class="card-title">กลุ่มเคมี</h3>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="chemical_groups_name" class="col-form-label">ชื่อ</label>
                    <input type="text" class="form-control" name="chemical_groups_name" id="chemical_groups_name" value="{{$hd->chemical_groups_name}}" required>
                </div>
            </div> 
        </div>
        <br>
        <div class="row">
            <div class="mb-2">
                <button type="button" class="btn btn-sm btn-success" onclick="addRow()">
                    ➕ เพิ่มฟังชั่น
                </button>
            </div>
                    <table class="table table-bordered table-sm text-center" id="destroyTable">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อฟังชั่น</th>
                                <th>ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hd->Funtions as $item)
                                <tr>
                                    <td>{{$item->chemical_funtions_listno}}</td>
                                    <td>{{$item->chemical_funtions_name}}</td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->chemical_funtions_id }}')"><i class="fas fa-trash"></i></a> 
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tbody>
                            <!-- เริ่มต้นไม่มีแถว หรือคุณจะใส่แถวเริ่มต้น 1 แถวก็ได้ -->
                        </tbody>
                    </table>
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
// ✅ ฟังก์ชันเพิ่มแถว
function addRow() {
    const tableBody = document.querySelector("#destroyTable tbody");
    const rowCount = tableBody.querySelectorAll("tr").length + 1;

    const row = document.createElement("tr");
    row.innerHTML = `
        <td>
            ${rowCount}
            <input type="hidden" name="chemical_funtions_listno[]" value="${rowCount}">            
        </td>
        <td>
            <input type="text" class="form-control" placeholder="รายละเอียด" name="chemical_funtions_name[]">
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">ลบ</button>
        </td>
    `;

    tableBody.appendChild(row);
    updateRowNumbers(); // รีเลขลำดับ
}

// ✅ ฟังก์ชันลบแถว
function removeRow(button) {
    const row = button.closest("tr");
    row.remove();
    updateRowNumbers(); // รีเลขลำดับใหม่หลังลบ
}

function updateRowNumbers() {
    document.querySelectorAll("#destroyTable tbody tr").forEach((row, index) => {
        const number = index + 1;
        row.querySelector(".row-number").textContent = number;
        row.querySelector('input[name="chemical_funtions_listno[]"]').value = number;
    });
}
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
            url: `{{ url('/confirmDelChemicalFuntion') }}`,
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