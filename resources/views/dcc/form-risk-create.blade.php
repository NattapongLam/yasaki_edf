@extends('layouts.main')
@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-12">
            
            {{-- Alert Messages --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="mdi mdi-check-all me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @elseif(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="mdi mdi-block-helper me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <form method="POST" class="form-horizontal" action="{{ route('car.store') }}" enctype="multipart/form-data">
                        @csrf 
                        
                        <div class="row mb-4 align-items-center">
                            <div class="col-12">
                                <h3 class="card-title text-primary fw-bold mb-0">
                                    <i class="mdi mdi-shield-search me-2"></i>การประเมินความเสี่ยงและโอกาส
                                </h3>
                                <hr class="text-muted">
                            </div>
                        </div>

                        {{-- ส่วนหัวข้อเอกสาร --}}
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">ประเภท <span class="text-danger">*</span></label>
                                    <select class="form-select" name="doc_risk_hds_type" required>
                                        <option value="" disabled selected>กรุณาเลือก</option>
                                        <option value="ปัจจัยภายใน/ภายนอก">ปัจจัยภายใน/ภายนอก</option>
                                        <option value="ผู้มีส่วนได้/ส่วนเสีย">ผู้มีส่วนได้/ส่วนเสีย</option>
                                        <option value="ในกระบวนการ">ในกระบวนการ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">หน่วยงาน/กระบวนการ</label>
                                    <input class="form-control" type="text" name="doc_risk_hds_agency" placeholder="ระบุหน่วยงาน" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">ผู้รับผิดชอบ</label>
                                    <input class="form-control" type="text" name="doc_risk_hds_person" placeholder="ชื่อผู้รับผิดชอบ" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label fw-semibold">วัน/เดือน/ปี</label>
                                    <input class="form-control" type="date" name="doc_risk_hds_date" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>

                        {{-- ตารางรายการประเมินความเสี่ยง --}}
                        <div class="row mt-2">
                            <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold text-secondary mb-0">รายการประเมิน</h5>
                                <button type="button" class="btn btn-success btn-sm px-3" id="addRowBtn">
                                    <i class="mdi mdi-plus me-1"></i> เพิ่มรายการ
                                </button>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle text-center w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th rowspan="2" class="align-middle" style="width: 50px;">#</th>
                                            <th rowspan="2" class="align-middle" style="width: 18%;">ประเด็นความเสี่ยง/โอกาส</th>
                                            <th rowspan="2" class="align-middle" style="width: 18%;">ผลกระทบ/ลักษณะความเสี่ยง</th>
                                            <th rowspan="2" class="align-middle" style="width: 15%;">การควบคุมปัจจุบัน</th>
                                            <th colspan="2" class="align-middle">ความเสี่ยงก่อนจัดการ</th>
                                            <th rowspan="2" class="align-middle" style="width: 5%;">รวมคะแนน<br>(L x I)</th>
                                            <th rowspan="2" class="align-middle" style="width: 5%;">ระดับความรุนแรง</th>
                                            <th colspan="3" class="align-middle">การบริหารความเสี่ยง</th>
                                            <th rowspan="2" class="align-middle" style="width: 70px;">จัดการ</th>
                                        </tr>
                                        <tr>
                                            <th class="align-middle" style="width: 5%;">โอกาส (L)</th>
                                            <th class="align-middle" style="width: 5%;">ผลกระทบ (I)</th>
                                            <th class="align-middle" style="width: 12%;">โอกาสในการปรับปรุง</th>
                                            <th class="align-middle" style="width: 7%;">ระยะเวลา</th>
                                            <th class="align-middle" style="width: 12%;">ผู้รับผิดชอบ</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        {{-- แถวข้อมูลจะถูกเพิ่มด้วย JavaScript --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <hr class="my-4"> 

                        {{-- เกณฑ์มาตรฐานต่างๆ และส่วนลงนาม --}}
                        <div class="row g-4 mt-2">
                            {{-- เกณฑ์ L --}}
                            <div class="col-md-4">
                                <div class="card border h-100 bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold text-dark mb-3">เกณฑ์ระดับโอกาส (Likelihood : L)</h6>
                                        <table class="table table-sm table-bordered bg-white text-center mb-0">
                                            <thead class="table-secondary">
                                                <tr><th>ระดับ</th><th>โอกาส</th><th>ความถี่</th></tr>
                                            </thead>
                                            <tbody>
                                                <tr><td>5</td><td>สูงมาก</td><td>ทุกสัปดาห์</td></tr>
                                                <tr><td>4</td><td>สูง</td><td>ทุกเดือน</td></tr>
                                                <tr><td>3</td><td>ปานกลาง</td><td>ทุกไตรมาส</td></tr>
                                                <tr><td>2</td><td>น้อย</td><td>ทุกปี</td></tr>
                                                <tr><td>1</td><td>น้อยมาก</td><td>> 1 ปี</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- เกณฑ์ I --}}
                            <div class="col-md-4">
                                <div class="card border h-100 bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold text-dark mb-3">เกณฑ์ระดับความรุนแรง (Impact : I)</h6>
                                        <table class="table table-sm table-bordered bg-white text-center mb-0">
                                            <thead class="table-secondary">
                                                <tr><th>ระดับ</th><th>ผลกระทบ</th><th>คำอธิบาย</th></tr>
                                            </thead>
                                            <tbody>
                                                <tr><td>5</td><td>รุนแรงที่สุด</td><td>สูงมาก ควบคุมไม่ได้</td></tr>
                                                <tr><td>4</td><td>ค่อนข้างรุนแรง</td><td>สูง ควบคุมยาก</td></tr>
                                                <tr><td>3</td><td>ปานกลาง</td><td>ปานกลาง ควบคุมได้</td></tr>
                                                <tr><td>2</td><td>น้อย</td><td>น้อย ควบคุมง่าย</td></tr>
                                                <tr><td>1</td><td>น้อยมาก</td><td>น้อยมาก/ไม่ส่งผล</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- เกณฑ์ประเมินและผู้จัดทำ --}}
                            <div class="col-md-4">
                                <div class="card border h-100 bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold text-dark mb-3">หมายเหตุ : ระดับความเสี่ยง (L x I)</h6>
                                        <table class="table table-sm table-bordered bg-white text-center mb-3">
                                            <thead class="table-secondary">
                                                <tr><th>ระดับ</th><th>คะแนน</th><th>การจัดการ</th></tr>
                                            </thead>
                                            <tbody>
                                                <tr><td class="text-danger fw-bold">สูง (H)</td><td>>= 16</td><td>Action Control</td></tr>
                                                <tr><td class="text-warning fw-bold">ปานกลาง (M)</td><td>9 - 15</td><td>Monitoring</td></tr>
                                                <tr><td class="text-success fw-bold">ต่ำ (L)</td><td><= 8</td><td>Accept risk</td></tr>
                                            </tbody>
                                        </table>

                                        {{-- ส่วนผู้จัดทำและผู้ทบทวน --}}
                                        <div class="table-responsive">
                                            <table class="table table-sm table-borderless align-middle mb-0">
                                                <tr>
                                                    <td class="fw-semibold text-now5rap" style="width: 30%;">ผู้จัดทำ</td>
                                                    <td><input class="form-control form-control-sm" type="text" name="prepared_by" value="{{Auth::user()->name}}" placeholder="ชื่อผู้จัดทำ" readonly></td>
                                                    <td><input class="form-control form-control-sm" type="date" name="prepared_date" value="{{ date('Y-m-d') }}"></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold text-nowrap">ผู้ทบทวน</td>
                                                    <td><input class="form-control form-control-sm" type="text" name="approved_by" placeholder="ชื่อผู้ทบทวน" readonly></td>
                                                    <td><input class="form-control form-control-sm" type="date" name="approved_date" readonly></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <div class="row mt-4">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm">
                                    <i class="mdi mdi-content-save me-1"></i> บันทึกข้อมูล
                                </button>
                            </div>
                        </div>
                    </form>        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scriptjs')
<script>
// ฟังก์ชันคำนวณคะแนนและระดับความรุนแรงอัตโนมัติ
function calculateRow(row) {
    const likelihoodSelect = row.querySelector('.likelihood-select');
    const impactSelect = row.querySelector('.impact-select');
    const scoreInput = row.querySelector('.score-input');
    const violenceDisplay = row.querySelector('.violence-display');
    const violenceInput = row.querySelector('.violence-input');

    const l = parseFloat(likelihoodSelect.value) || 0;
    const i = parseFloat(impactSelect.value) || 0;
    const score = l * i;

    scoreInput.value = score > 0 ? score : '';

    if (score > 0) {
        let textVal = '';
        if (score >= 16) {
            textVal = 'H';
            violenceDisplay.className = 'form-control form-control-sm text-center fw-bold text-danger bg-light-danger violence-display';
        } else if (score >= 9) {
            textVal = 'M';
            violenceDisplay.className = 'form-control form-control-sm text-center fw-bold text-warning bg-light-warning violence-display';
        } else {
            textVal = 'L';
            violenceDisplay.className = 'form-control form-control-sm text-center fw-bold text-success bg-light-success violence-display';
        }
        violenceDisplay.value = textVal;
        violenceInput.value = textVal; // กำหนดค่าให้ Input ที่จะส่งไปบันทึกฐานข้อมูล
    } else {
        violenceDisplay.value = '';
        violenceInput.value = '';
        violenceDisplay.className = 'form-control form-control-sm text-center violence-display';
    }
}
function updateRowNumbers() {
    const rows = document.querySelectorAll('#tableBody tr');
    rows.forEach((row, index) => {
        const numCell = row.querySelector('.row-number');
        if (numCell) {
            numCell.textContent = index + 1;
        }
    });
}

document.getElementById('addRowBtn').addEventListener('click', function () {
    const tbody = document.getElementById('tableBody'); // ใช้ id เดิมตามโค้ดหลักของคุณ
    const newRow = document.createElement('tr');

    newRow.innerHTML = `
        <td class="row-number fw-semibold"></td>
        <td><textarea name="doc_risk_hds_issue[]" class="form-control form-control-sm" rows="2" placeholder="ระบุประเด็น..." required></textarea></td>
        <td><textarea name="doc_risk_hds_effect[]" class="form-control form-control-sm" rows="2" placeholder="ระบุผลกระทบ..."></textarea></td>
        <td><textarea name="doc_risk_hds_control[]" class="form-control form-control-sm" rows="2" placeholder="การควบคุม..."></textarea></td>
        <td>
            <select name="doc_risk_dts_likelihood[]" class="form-select form-select-sm likelihood-select text-center" required>
                <option value="" selected>-</option>
                <option value="5">5</option>
                <option value="4">4</option>
                <option value="3">3</option>
                <option value="2">2</option>
                <option value="1">1</option>
            </select>
        </td>
        <td>
            <select name="doc_risk_dts_impact[]" class="form-select form-select-sm impact-select text-center" required>
                <option value="" selected>-</option>
                <option value="5">5</option>
                <option value="4">4</option>
                <option value="3">3</option>
                <option value="2">2</option>
                <option value="1">1</option>
            </select>
        </td>
        <td><input type="text" name="doc_risk_dts_score[]" class="form-control form-control-sm text-center score-input fw-bold" readonly></td>
        <td>
            <!-- ช่องแสดงผลระดับความรุนแรงให้ผู้ใช้เห็น และส่งค่าไปบันทึก -->
            <input type="text" class="form-control form-control-sm text-center violence-display fw-bold" readonly placeholder="-">
            <input type="hidden" name="doc_risk_dts_violence[]" class="violence-input">
        </td>
        <td><textarea type="text" name="doc_risk_dts_chance[]" class="form-control form-control-sm" placeholder="แนวทางปรับปรุง"></textarea></td>
        <td><input type="date" name="doc_risk_dts_period[]" class="form-control form-control-sm"></td>
        <td><input type="text" name="doc_risk_dts_responsible[]" class="form-control form-control-sm" placeholder="ผู้รับผิดชอบ"></td>
        <td>
            <button type="button" class="btn btn-danger btn-sm deleteRow px-2 py-1">
                <i class="mdi mdi-delete"></i>
            </button>
        </td>
    `;

    tbody.appendChild(newRow);
    updateRowNumbers();

    // ผูก Event คำนวณเมื่อเปลี่ยนค่า
    const lSelect = newRow.querySelector('.likelihood-select');
    const iSelect = newRow.querySelector('.impact-select');

    lSelect.addEventListener('change', () => calculateRow(newRow));
    iSelect.addEventListener('change', () => calculateRow(newRow));
});

document.getElementById('tableBody').addEventListener('click', function (e) {
    if (e.target.classList.contains('deleteRow') || e.target.closest('.deleteRow')) {
        e.target.closest('tr').remove();
        updateRowNumbers();
    }
});

// เพิ่มแถวแรกเริ่มต้นอัตโนมัติเมื่อโหลดหน้าเว็บ
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('addRowBtn').click();
});
</script>
@endpush