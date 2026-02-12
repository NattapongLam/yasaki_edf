@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">🔍 รายละเอียดแผนซ่อมบำรุง</h4>

    <div class="card">
        <div class="card-body">
            <a href="{{ url('/calibrationplans') }}" class="btn btn-secondary">
                ⬅ กลับ
            </a>
            <hr>
            <table class="table table-bordered">
                <tr>
                    <th width="30%">รหัสเครื่องจักร</th>
                    <td colspan="3">{{ $data->machinery_lists_code }}</td>
                </tr>
                <tr>
                    <th>ชื่อเครื่องจักร</th>
                    <td colspan="3">{{ $data->machinery_lists_name }}</td>
                </tr>
                <tr>
                    <th>สถานะ</th>
                    <td>
                        @if($data->machinery_plans_action == 1)
                            <span class="badge bg-success">ดำเนินการเรียบร้อย</span>
                        @else
                            <span class="badge bg-danger">รอดำเนินการ</span>
                        @endif
                    </td>
                    <th>วันครบกำหนด PM</th>
                    <td>{{ \Carbon\Carbon::parse($data->machinery_plans_date)->format('d/m/Y') }}</td>
                </tr>         
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
                <form method="POST" class="form-horizontal" action="{{ route('machineryplans.store') }}" enctype="multipart/form-data">
                @csrf   
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="machinery_plan_subs_date" class="col-form-label">วันที่</label>
                            <input type="date" class="form-control" name="machinery_plan_subs_date" id="machinery_plan_subs_date" required>
                            <input value="{{$data->machinery_plans_id}}" name="machinery_plans_id" type="hidden">
                            <input value="{{$data->machinery_lists_id}}" name="machinery_lists_id" type="hidden">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="form-group">
                            <label for="machinery_plans_remark" class="col-form-label">หมายเหตุ</label>
                            <input class="form-control" name="machinery_plans_remark">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="machinery_plans_file1" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile01"  name="machinery_plans_file1" onchange="prevFile(this,'machinery_plans_file1')">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="machinery_plans_file2" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile02"  name="machinery_plans_file2" onchange="prevFile(this,'machinery_plans_file2')">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12" style="text-align: right;">
                        <a href="javascript:void(0);" class="btn btn-secondary" id="addRowBtn">เพิ่มรายการ</a>
                    </div>
                    <hr>
                    <table class="table table-bordered dt-responsive nowrap w-100 text-center">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 90%">รายละเอียด</th>
                                <th style="width: 5%"></th>
                            </tr>
                        </thead>
                        <tbody id="tableBody"></tbody>       
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
function prevFile(input, elm) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.' + elm).attr('src', e.target.result);
            file = input.files[0];
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function updateRowNumbers() {
    const rows = document.querySelectorAll('#tableBody tr');
    rows.forEach((row, index) => {
        row.querySelector('.row-number').textContent = index + 1;
        row.querySelector('.row-number-hidden').value = index + 1;
    });
}
document.getElementById('addRowBtn').addEventListener('click', function () {
        const tbody = document.getElementById('tableBody');

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <span class="row-number"></span>
                <input type="hidden" name="machinery_plan_subs_listno[]" class="row-number-hidden"/>
            </td>
            <td><input type="text" name="machinery_plan_subs_remark[]" class="form-control"/></td>
            <td><button type="button" class="btn btn-danger btn-sm deleteRow">ลบ</button></td>
        `;

        tbody.appendChild(newRow);
        updateRowNumbers(); 
});
document.getElementById('tableBody').addEventListener('click', function (e) {
    if (e.target.classList.contains('deleteRow')) {
        e.target.closest('tr').remove();
        updateRowNumbers(); // อัปเดตลำดับหลังจากลบ
    }
});
</script>
@endpush
