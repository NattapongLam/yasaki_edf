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
            <!-- หัวข้อฟอร์ม + ปุ่มสร้างใหม่ (กรณีเปิดดูข้อมูลเก่าอยู่) -->
            <div class="row mb-3 align-items-center">
                <div class="col-12 col-md-6">
                    <h3 class="card-title" id="form-title">แบบประเมินผู้ขาย / SUPPLIER EVALUATION (บันทึกใหม่)</h3>
                </div> 
                <div class="col-12 col-md-6 text-md-end" id="btn-new-container" style="display: none;">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="resetToCreateMode()">
                        <i class="fas fa-plus me-1"></i> ทำการประเมินใหม่ (Create New)
                    </button>
                </div>
            </div> 

            <form action="{{ route('vendor.evaluation.store') }}" method="POST" id="evaluation-form">
            @csrf
                    
            <!-- Hidden ID สำหรับเชื่อมโยงกับ ap_vendor_lists -->
            <input type="hidden" name="ap_vendor_lists_id" value="{{ $hd->ap_vendor_lists_id }}">

            <!-- ข้อมูลส่วนหัวฟอร์ม -->
            <div class="row mt-2 g-3">
                <div class="col-md-3 col-sm-6">
                    <label class="form-label">ผู้ขาย (Supplier):</label>
                    <input class="form-control" type="text" name="supplier" value="{{ $hd->ap_vendor_lists_name1 ?? '' }}"> 
                </div>
                <div class="col-md-3 col-sm-6">
                    <label class="form-label">วันที่ประเมิน (Date):</label>
                    <input class="form-control" type="date" name="evaluation_date" id="evaluation_date" value="{{ date('Y-m-d') }}"> 
                </div>
                <div class="col-md-3 col-sm-6">
                    <label class="form-label">สินค้า / บริการที่ซื้อ (Goods / services):</label>
                    <input class="form-control" type="text" name="goods_services" id="goods_services" value=""> 
                </div>
                <div class="col-md-3 col-sm-6">
                    <label class="form-label">รอบการประเมิน (Period evaluated):</label>
                    <input class="form-control" type="text" name="period_evaluated" id="period_evaluated" value=""> 
                </div>
            </div>

            <!-- ตารางคะแนนการประเมิน -->
            <div class="row mt-4">
                <div class="col-12">
                    <h6 class="text-muted mb-2">เกณฑ์การให้คะแนน (Scoring): 5 = ดีมาก (Excellent) · 4 = ดี (Good) · 3 = พอใช้ (Acceptable) · 2 = ควรปรับปรุง (Needs improvement) · 1 = ไม่ยอมรับ (Unacceptable)</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 7%;">ลำดับ<br>(No.)</th>
                                    <th style="width: 35%;">เกณฑ์การประเมิน<br>(Criterion)</th>
                                    <th style="width: 10%;">คะแนนเต็ม<br>(Max)</th>
                                    <th style="width: 12%;">คะแนนที่ได้<br>(Score)</th>
                                    <th style="width: 18%;">ดูจาก<br>(Score from)</th>
                                    <th style="width: 18%;">หมายเหตุ<br>(Notes)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 1; $i <= 5; $i++)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td class="text-start">
                                        @if($i == 1) คุณภาพสินค้า ตรงสเปก ของเสียน้อย<br><small class="text-muted">(Quality: meets specification, few rejects)</small>
                                        @elseif($i == 2) การส่งมอบ ตรงเวลาและครบจำนวน<br><small class="text-muted">(Delivery: on time and complete)</small>
                                        @elseif($i == 3) ราคาและเงื่อนไขการค้า<br><small class="text-muted">(Price and commercial terms)</small>
                                        @elseif($i == 4) การบริการและการตอบสนอง<br><small class="text-muted">(Service and responsiveness)</small>
                                        @elseif($i == 5) เอกสารครบถ้วน COA / SDS / ใบรับประกัน<br><small class="text-muted">(Documents: COA / SDS / warranty)</small>
                                        @endif
                                    </td>
                                    <td>5</td>
                                    <td><input type="number" class="form-control text-center eval-score" name="score_{{ $i }}" id="score_{{ $i }}" min="1" max="5" value="0"></td>
                                    <td><input type="text" class="form-control" name="score_from_{{ $i }}" id="score_from_{{ $i }}"></td>
                                    <td><input type="text" class="form-control" name="notes_{{ $i }}" id="notes_{{ $i }}"></td>
                                </tr>
                                @endfor
                            </tbody>
                            <tfoot class="table-light fw-bold">
                                <tr>
                                    <td colspan="2" class="text-end">รวมคะแนนทั้งหมด (Total Score):</td>
                                    <td>25</td>
                                    <td><span id="total-score" class="text-primary fs-5">0</span> / 25</td>
                                    <td colspan="2" class="text-start">
                                        เกรดที่ได้: <span id="total-grade" class="badge bg-secondary fs-6">-</span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ผลการประเมินและการติดตาม (Decision & Follow-up) -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card border shadow-none p-3 bg-light">
                        
                        <!-- เกณฑ์ผล -->
                        <div class="mb-3">
                            <span class="text-muted font-size-13">
                                <i class="mdi mdi-information-outline me-1"></i><strong>เกณฑ์ผล (Grades):</strong> 20 คะแนนขึ้นไป = A คงสถานะ · 15-19 = B มีเงื่อนไข · ต่ำกว่า 15 = C ทบทวน/ระงับ
                            </span>
                        </div>

                        <!-- ผลการประเมิน (Decision) แบบแนวนอน -->
                        <div class="mb-3">
                            <label class="form-label fw-bold mb-2">ผลการประเมิน (Decision):</label>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input" type="radio" name="decision" id="formRadios1" value="keep" checked>
                                    <label class="form-check-label" for="formRadios1">คงสถานะผู้ขายที่อนุมัติ <span class="text-muted">(Keep approved)</span></label>
                                </div>
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input" type="radio" name="decision" id="formRadios2" value="conditional">
                                    <label class="form-check-label" for="formRadios2">อนุมัติแบบมีเงื่อนไข <span class="text-muted">(Conditional)</span></label>
                                </div>
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input" type="radio" name="decision" id="formRadios3" value="suspend">
                                    <label class="form-check-label" for="formRadios3">ระงับ / ถอดจากทะเบียน <span class="text-muted">(Suspend / remove)</span></label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3 text-muted">

                        <!-- สิ่งที่ต้องติดตาม / กำหนดประเมินครั้งถัดไป -->
                        <div class="row align-items-center">
                            <div class="col-md-7 mb-2 mb-md-0">
                                <label class="form-label fw-bold mb-1">สิ่งที่ต้องติดตาม / กำหนดประเมินครั้งถัดไป</label>
                                <div class="text-muted font-size-12">Follow-up / next evaluation due</div>
                            </div>
                            <div class="col-md-5">
                                <input class="form-control" type="date" name="follow_up_date" id="follow_up_date" value="">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
            <br>
            <div class="col-12 col-md-2" id="submit-btn-container">
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary w-100">
                        บันทึกการประเมิน
                    </button>
                </div>
            </div> 
        </form>            
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title mb-3">ประวัติรายการประเมินผู้ขาย (Evaluation History)</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ลำดับ</th>
                            <th>วันที่ประเมิน</th>
                            <th>รอบการประเมิน</th>
                            <th>สินค้า / บริการ</th>
                            <th>คะแนนรวม (25)</th>
                            <th>ผลการตัดสินใจ (Decision)</th>
                            <th>ผู้ประเมิน</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $index => $item)
                            @php
                                $totalHist = ($item->score_1 ?? 0) + ($item->score_2 ?? 0) + ($item->score_3 ?? 0) + ($item->score_4 ?? 0) + ($item->score_5 ?? 0);
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->evaluation_date ? \Carbon\Carbon::parse($item->evaluation_date)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $item->period_evaluated ?? '-' }}</td>
                                <td>{{ $item->goods_services ?? '-' }}</td>
                                <td>
                                    <span class="fw-bold text-primary">{{ $totalHist }}</span> / 25
                                </td>
                                <td>
                                    @if($item->decision == 'keep')
                                        <span class="badge bg-success">คงสถานะผู้ขาย</span>
                                    @elseif($item->decision == 'conditional')
                                        <span class="badge bg-warning text-dark">มีเงื่อนไข</span>
                                    @elseif($item->decision == 'suspend')
                                        <span class="badge bg-danger">ระงับ / ถอดถอน</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $item->decision ?? '-' }}</span>
                                    @endif
                                </td>
                                <td>{{ $item->person_at ?? '-' }}</td>
                                <td>
                                    <!-- ปุ่มดูข้อมูล -->
                                    <button type="button" class="btn btn-info btn-sm" onclick='viewEvaluation(@json($item))' title="ดูข้อมูล">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <!-- ปุ่มลบ -->
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->supplier_evaluations_id }}')" title="ลบ">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted py-3">ยังไม่มีประวัติการประเมินผู้ขายรายนี้</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scriptjs')
<script>
    const scoreInputs = document.querySelectorAll('.eval-score');
    const totalScoreSpan = document.getElementById('total-score');
    const totalGradeSpan = document.getElementById('total-grade');
    
    const radioKeep = document.getElementById('formRadios1');
    const radioConditional = document.getElementById('formRadios2');
    const radioSuspend = document.getElementById('formRadios3');

    let isViewMode = false;

    function calculateTotal() {
        let sum = 0;
        scoreInputs.forEach(input => {
            let val = parseFloat(input.value) || 0;
            if (val > 5) val = 5;
            if (val < 0) val = 0;
            sum += val;
        });

        totalScoreSpan.textContent = sum;

        if (sum >= 20) {
            totalGradeSpan.textContent = 'เกรด A (คงสถานะ)';
            totalGradeSpan.className = 'badge bg-success fs-6';
            if(!isViewMode) radioKeep.checked = true;
        } else if (sum >= 15 && sum <= 19) {
            totalGradeSpan.textContent = 'เกรด B (มีเงื่อนไข ติดตามผล)';
            totalGradeSpan.className = 'badge bg-warning text-dark fs-6';
            if(!isViewMode) radioConditional.checked = true;
        } else {
            totalGradeSpan.textContent = 'เกรด C (ทบทวน/ระงับ)';
            totalGradeSpan.className = 'badge bg-danger fs-6';
            if(!isViewMode) radioSuspend.checked = true;
        }
    }

    scoreInputs.forEach(input => {
        input.addEventListener('input', calculateTotal);
    });

    calculateTotal();

    // ฟังก์ชันสำหรับเปิดดูข้อมูลย้อนหลัง
    function viewEvaluation(item) {
        isViewMode = true;
        document.getElementById('form-title').textContent = 'รายละเอียดการประเมินผู้ขาย (View Mode)';
        document.getElementById('btn-new-container').style.display = 'block';
        document.getElementById('submit-btn-container').style.display = 'none';

        // เติมข้อมูลลงฟอร์มหลัก
        document.getElementById('evaluation_date').value = item.evaluation_date ? item.evaluation_date.split('T')[0] : '';
        document.getElementById('goods_services').value = item.goods_services || '';
        document.getElementById('period_evaluated').value = item.period_evaluated || '';
        document.getElementById('follow_up_date').value = item.follow_up_date ? item.follow_up_date.split('T')[0] : '';

        // เติมคะแนนและข้อมูลช่องย่อย 1-5
        for (let i = 1; i <= 5; i++) {
            const scoreInput = document.getElementById(`score_${i}`);
            const fromInput = document.getElementById(`score_from_${i}`);
            const notesInput = document.getElementById(`notes_${i}`);

            if (scoreInput) scoreInput.value = item[`score_${i}`] || 0;
            if (fromInput) fromInput.value = item[`score_from_${i}`] || '';
            if (notesInput) notesInput.value = item[`notes_${i}`] || '';
            
            // ล็อคอินพุตเป็น readonly
            if (scoreInput) scoreInput.setAttribute('readonly', true);
            if (fromInput) fromInput.setAttribute('readonly', true);
            if (notesInput) notesInput.setAttribute('readonly', true);
        }

        document.getElementById('evaluation_date').setAttribute('readonly', true);
        document.getElementById('goods_services').setAttribute('readonly', true);
        document.getElementById('period_evaluated').setAttribute('readonly', true);
        document.getElementById('follow_up_date').setAttribute('readonly', true);

        // เลือก Radio ตาม Decision
        if(item.decision == 'keep') radioKeep.checked = true;
        else if(item.decision == 'conditional') radioConditional.checked = true;
        else if(item.decision == 'suspend') radioSuspend.checked = true;

        // ปิดการใช้งาน Radio
        document.querySelectorAll('input[name="decision"]').forEach(r => r.setAttribute('disabled', true));

        calculateTotal();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // ฟังก์ชันกลับสู่โหมดสร้างใหม่
    function resetToCreateMode() {
        isViewMode = false;
        document.getElementById('form-title').textContent = 'แบบประเมินผู้ขาย / SUPPLIER EVALUATION (บันทึกใหม่)';
        document.getElementById('btn-new-container').style.display = 'none';
        document.getElementById('submit-btn-container').style.display = 'block';

        document.getElementById('evaluation_date').value = '{{ date("Y-m-d") }}';
        document.getElementById('goods_services').value = '';
        document.getElementById('period_evaluated').value = '';
        document.getElementById('follow_up_date').value = '';

        for (let i = 1; i <= 5; i++) {
            const scoreInput = document.getElementById(`score_${i}`);
            const fromInput = document.getElementById(`score_from_${i}`);
            const notesInput = document.getElementById(`notes_${i}`);

            if (scoreInput) scoreInput.value = 0;
            if (fromInput) fromInput.value = '';
            if (notesInput) notesInput.value = '';
            
            if (scoreInput) scoreInput.removeAttribute('readonly');
            if (fromInput) fromInput.removeAttribute('readonly');
            if (notesInput) notesInput.removeAttribute('readonly');
        }

        document.getElementById('evaluation_date').removeAttribute('readonly');
        document.getElementById('goods_services').removeAttribute('readonly');
        document.getElementById('period_evaluated').removeAttribute('readonly');
        document.getElementById('follow_up_date').removeAttribute('readonly');

        document.querySelectorAll('input[name="decision"]').forEach(r => r.removeAttribute('disabled'));
        radioKeep.checked = true;
        calculateTotal();
    }

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
                    url: `{{ url('/confirmDelVendorEvaluation') }}`,
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
                                text: 'ลบรายการเรียบร้อยแล้ว',
                                icon: 'success'
                            }).then(function() {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'ไม่สำเร็จ',
                                text: 'ลบรายการไม่สำเร็จ',
                                icon: 'error'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'ไม่สำเร็จ',
                            text: 'เกิดข้อผิดพลาดในการเชื่อมต่อ',
                            icon: 'error'
                        });         
                    }
                });
            }
        });
    }
</script>
@endpush