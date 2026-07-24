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
            
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="" class="col-form-label">วันที่</label>
                        <input class="form-control" type="date" name="repair_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="" class="col-form-label">เลขที่</label>
                        <input class="form-control" type="text" name="repair_no" value="" required>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="repair_type" class="col-form-label">ประเภท</label>
                        <select class="form-control" name="repair_type" id="repair_type" required>
                            <option value="">กรุณาเลือก</option>
                            <option value="CAL">เครื่องมือวัด</option>
                            <option value="MC">เครื่องจักร</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- ส่วนสำหรับแสดงผลข้อมูลที่ดึงมา (เช่น รายชื่อเครื่องมือ/เครื่องจักร) -->
            <div class="row mt-3" id="result_section" style="display: none;">
                <div class="col-6">
                    <div class="form-group">
                        <label for="item_id" class="col-form-label" id="label_item_name">เลือกรายการ</label>
                        <select class="form-control" name="item_id" id="item_id">
                            <option value="">-- กรุณาเลือกรายการ --</option>
                        </select>
                    </div>
                </div>
            </div>

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
</script>
@endpush