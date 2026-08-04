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
            </div>      
            <form method="POST" class="form-horizontal" action="{{ route('maintenances.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row mt-2">
                <div class="col-3">
                    <div class="form-group">
                        <label for="" class="col-form-label">วันที่</label>
                        <input class="form-control" type="date" name="repair_machinery_hds_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="repair_machinery_hds_docuno" class="col-form-label">เลขที่</label>
                        <input class="form-control" type="text" name="repair_machinery_hds_docuno" id="repair_machinery_hds_docuno" value="" required readonly>
                        <!-- แนะนำให้เติม readonly เพื่อป้องกันผู้ใช้พิมพ์แก้เลขที่เอกสารซ้ำกัน -->
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="repair_type" class="col-form-label">ประเภท</label>
                        <select class="form-control" name="repair_machinery_hds_type" id="repair_type" required>
                            <option value="">กรุณาเลือก</option>
                            <option value="CAL">เครื่องมือวัด</option>
                            <option value="MC">เครื่องจักร</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="" class="col-form-label">กำหนดเสร็จ</label>
                        <input class="form-control" type="date" name="repair_machinery_hds_duedate" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
            </div>
            <!-- ส่วนสำหรับแสดงผลข้อมูลที่ดึงมา (เช่น รายชื่อเครื่องมือ/เครื่องจักร) -->
            <div class="row mt-2" id="result_section" style="display: none;">
                <div class="col-12">
                    <div class="form-group">
                        <label for="item_id" class="col-form-label" id="label_item_name">เลือกรายการ</label>
                        <select class="form-control" name="repair_id" id="item_id">
                            <option value="">-- กรุณาเลือกรายการ --</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="form-group">
                        <label for="" class="col-form-label">หมายเหตุ</label>
                        <textarea class="form-control" rows="3" name="repair_machinery_hds_remark"></textarea>
                    </div>
                </div>               
            </div>
            <br>
            <div class="row mt-2">
                    <div class="col-12" style="text-align: right;">
                        <a href="javascript:void(0);" class="btn btn-secondary" id="addRowBtn">เพิ่มรายการ</a>
                    </div>
                    <hr>
                    <table class="table table-bordered dt-responsive nowrap w-100 text-center">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 40%">ชิ้นส่วน</th>
                                <th style="width: 50%">รายละเอียด</th>
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
document.getElementById('repair_type').addEventListener('change', function() {
    let type = this.value;
    let resultSection = document.getElementById('result_section');
    let itemSelect = document.getElementById('item_id');
    let labelName = document.getElementById('label_item_name');

    // ล้างค่าข้อมูลเก่าและซ่อนถ้ายังไม่ได้เลือก
    itemSelect.innerHTML = '<option value="">-- กรุณาเลือกรายการ --</option>';
    if (!type) {
        resultSection.style.display = 'none';
        return;
    }

    // เปลี่ยน Label ตามประเภท
    if (type === 'CAL') {
        labelName.innerText = 'เลือกเครื่องมือวัด (Calibration List)';
    } else if (type === 'MC') {
        labelName.innerText = 'เลือกเครื่องจักร (Machinery List)';
    }

    // ส่ง Request ไปยัง Laravel Controller
    fetch(`{{ route('repair.getItems') }}?type=${type}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                resultSection.style.display = 'flex';
                data.items.forEach(item => {
                    let option = document.createElement('option');
                    // ปรับ field id และ name ให้ตรงกับฐานข้อมูลของคุณ (เช่น item.id, item.name)
                    option.value = item.id; 
                    option.textContent = item.name; 
                    itemSelect.appendChild(option);
                });
            }
        })
        .catch(error => console.error('Error:', error));
});
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
                <input type="hidden" name="repair_machinery_dts_listno[]" class="row-number-hidden"/>
            </td>   
            <td>
                 <input type="text" name="repair_machinery_dts_part[]" class="form-control"/>
            </td>        
            <td>
                <textarea class="form-control" name="repair_machinery_dts_remark[]" rows="1" placeholder="เพิ่มเติม"></textarea>
            </td>          
            <td>
                <button type="button" class="btn btn-danger btn-sm deleteRow">ลบ</button>
            </td>
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
document.addEventListener("DOMContentLoaded", function() {
    // ฟังก์ชันสำหรับดึงเลขที่เอกสารอัตโนมัติ
    fetch(`{{ route('repair.getDocNo') }}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('repair_machinery_hds_docuno').value = data.doc_no;
            }
        })
        .catch(error => console.error('Error loading doc no:', error));
});
</script>
@endpush