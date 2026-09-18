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
            <form action="{{ route('vendor.evaluation.store') }}" method="POST">
            @csrf
                        
            <!-- Hidden ID สำหรับเชื่อมโยงกับ ap_vendor_lists -->
            <input type="hidden" name="ap_vendor_lists_id" value="{{ $hd->ap_vendor_lists_id }}">
            <!-- หัวข้อหลัก -->
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <h3 class="card-title">แบบประเมินผู้ขาย / SUPPLIER EVALUATION</h3>
                </div> 
            </div> 

            <!-- ข้อมูลส่วนหัวฟอร์ม -->
            <div class="row mt-2 g-3">
                <div class="col-md-3 col-sm-6">
                    <label class="form-label">ผู้ขาย (Supplier):</label>
                    <input class="form-control" type="text" name="supplier" value="{{ $hd->ap_vendor_lists_name1 ?? '' }}"> 
                </div>
                <div class="col-md-3 col-sm-6">
                    <label class="form-label">วันที่ประเมิน (Date):</label>
                    <input class="form-control" type="date" name="evaluation_date" value=""> 
                </div>
                <div class="col-md-3 col-sm-6">
                    <label class="form-label">สินค้า / บริการที่ซื้อ (Goods / services):</label>
                    <input class="form-control" type="text" name="goods_services" value=""> 
                </div>
                <div class="col-md-3 col-sm-6">
                    <label class="form-label">รอบการประเมิน (Period evaluated):</label>
                    <input class="form-control" type="text" name="period_evaluated" value=""> 
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
                                <tr>
                                    <td>1</td>
                                    <td class="text-start">คุณภาพสินค้า ตรงสเปก ของเสียน้อย<br><small class="text-muted">(Quality: meets specification, few rejects)</small></td>
                                    <td>5</td>
                                    <td><input type="number" class="form-control text-center eval-score" name="score_1" min="1" max="5" value="0"></td>
                                    <td><input type="text" class="form-control" name="score_from_1"></td>
                                    <td><input type="text" class="form-control" name="notes_1"></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td class="text-start">การส่งมอบ ตรงเวลาและครบจำนวน<br><small class="text-muted">(Delivery: on time and complete)</small></td>
                                    <td>5</td>
                                    <td><input type="number" class="form-control text-center eval-score" name="score_2" min="1" max="5" value="0"></td>
                                    <td><input type="text" class="form-control" name="score_from_2"></td>
                                    <td><input type="text" class="form-control" name="notes_2"></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td class="text-start">ราคาและเงื่อนไขการค้า<br><small class="text-muted">(Price and commercial terms)</small></td>
                                    <td>5</td>
                                    <td><input type="number" class="form-control text-center eval-score" name="score_3" min="1" max="5" value="0"></td>
                                    <td><input type="text" class="form-control" name="score_from_3"></td>
                                    <td><input type="text" class="form-control" name="notes_3"></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td class="text-start">การบริการและการตอบสนอง<br><small class="text-muted">(Service and responsiveness)</small></td>
                                    <td>5</td>
                                    <td><input type="number" class="form-control text-center eval-score" name="score_4" min="1" max="5" value="0"></td>
                                    <td><input type="text" class="form-control" name="score_from_4"></td>
                                    <td><input type="text" class="form-control" name="notes_4"></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td class="text-start">เอกสารครบถ้วน COA / SDS / ใบรับประกัน<br><small class="text-muted">(Documents: COA / SDS / warranty)</small></td>
                                    <td>5</td>
                                    <td><input type="number" class="form-control text-center eval-score" name="score_5" min="1" max="5" value="0"></td>
                                    <td><input type="text" class="form-control" name="score_from_5"></td>
                                    <td><input type="text" class="form-control" name="notes_5"></td>
                                </tr>
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
                                <i class="mdi mdi-information-outline me-1"></i><strong>เกณฑ์ผล (Grades):</strong> 20 คะแนนขึ้นไป = A คงสถานะ · 15-19 = B มีเงื่อนไข · ต่ำกว่า 15 = C ทบทวน/ระงับ <span class="text-muted font-size-11">(ปรับเกณฑ์ได้ตามนโยบายบริษัท)</span>
                            </span>
                        </div>

                        <!-- ผลการประเมิน (Decision) แบบแนวนอน -->
                        <div class="mb-3">
                            <label class="form-label fw-bold mb-2">ผลการประเมิน (Decision):</label>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input" type="radio" name="decision" id="formRadios1" value="keep" checked>
                                    <label class="form-check-label" for="formRadios1">
                                        คงสถานะผู้ขายที่อนุมัติ <span class="text-muted">(Keep approved)</span>
                                    </label>
                                </div>
                                
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input" type="radio" name="decision" id="formRadios2" value="conditional">
                                    <label class="form-check-label" for="formRadios2">
                                        อนุมัติแบบมีเงื่อนไข <span class="text-muted">(Conditional)</span>
                                    </label>
                                </div>
                                
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input" type="radio" name="decision" id="formRadios3" value="suspend">
                                    <label class="form-check-label" for="formRadios3">
                                        ระงับ / ถอดจากทะเบียน <span class="text-muted">(Suspend / remove)</span>
                                    </label>
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
                                <input class="form-control" type="date" name="follow_up_date" value="">
                            </div>
                        </div>

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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->evaluation_date ? \Carbon\Carbon::parse($item->evaluation_date)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $item->period_evaluated ?? '-' }}</td>
                                <td>{{ $item->goods_services ?? '-' }}</td>
                                <td>
                                    @php
                                        $total = ($item->score_1 ?? 0) + ($item->score_2 ?? 0) + ($item->score_3 ?? 0) + ($item->score_4 ?? 0) + ($item->score_5 ?? 0);
                                    @endphp
                                    <span class="fw-bold text-primary">{{ $total }}</span> / 25
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
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->supplier_evaluations_id }}')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted py-3">ยังไม่มีประวัติการประเมินผู้ขายรายนี้</td>
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
    document.addEventListener('DOMContentLoaded', function () {
        const scoreInputs = document.querySelectorAll('.eval-score');
        const totalScoreSpan = document.getElementById('total-score');
        const totalGradeSpan = document.getElementById('total-grade');
        
        // Radio buttons สำหรับเชื่อมโยงเกรดกับ Decision อัตโนมัติ (ถ้าต้องการ)
        const radioKeep = document.getElementById('formRadios1');
        const radioConditional = document.getElementById('formRadios2');
        const radioSuspend = document.getElementById('formRadios3');

        function calculateTotal() {
            let sum = 0;
            scoreInputs.forEach(input => {
                let val = parseFloat(input.value) || 0;
                // จำกัดค่าไม่ให้เกิน 5 หรือต่ำกว่า 1
                if (val > 5) val = 5;
                if (val < 0) val = 0;
                sum += val;
            });

            totalScoreSpan.textContent = sum;

            // กำหนดเกรดและปรับเปลี่ยน Radio อัตโนมัติตามเกณฑ์ที่คุณให้มา
            if (sum >= 20) {
                totalGradeSpan.textContent = 'เกรด A (คงสถานะ)';
                totalGradeSpan.className = 'badge bg-success fs-6';
                radioKeep.checked = true; // เลือก "คงสถานะผู้ขายที่อนุมัติ" ให้เอง
            } else if (sum >= 15 && sum <= 19) {
                totalGradeSpan.textContent = 'เกรด B (มีเงื่อนไข ติดตามผล)';
                totalGradeSpan.className = 'badge bg-warning text-dark fs-6';
                radioConditional.checked = true; // เลือก "อนุมัติแบบมีเงื่อนไข" ให้เอง
            } else {
                totalGradeSpan.textContent = 'เกรด C (ทบทวน/ระงับ)';
                totalGradeSpan.className = 'badge bg-danger fs-6';
                radioSuspend.checked = true; // เลือก "ระงับ / ถอดจากทะเบียน" ให้เอง
            }
        }

        // ดักจับการพิมพ์คะแนน
        scoreInputs.forEach(input => {
            input.addEventListener('input', calculateTotal);
        });

        // คำนวณครั้งแรกตอนโหลดหน้าเว็บ
        calculateTotal();
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
                url: `{{ url('/confirmDelVendorEvaluation') }}`, // ปรับเปลี่ยน URL ตาม Route จริงของระบบท่านหากจำเป็น
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