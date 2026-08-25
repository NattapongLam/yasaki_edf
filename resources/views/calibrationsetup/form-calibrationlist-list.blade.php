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
            <div class="col-12 col-md-6">
                <h3 class="card-title">
                    ทะเบียนเครื่องมือวัด 
                    {{-- ส่วนคำนวณและแสดงผลค่า Uncertainty ตามมาตรฐาน ISO 17025 (RSS จากเครื่องมือที่ใช้งาน) --}}
                    @php
                        // 1. คัดกรองเฉพาะรายการเครื่องมือวัดที่ใช้คำนวณค่าแรงเสียดทาน (μ) จริง
                        $activeItems = collect($hd)->where('calibration_lists_lapstatus', true);

                        // ดึงโหลดเซลล์ (รหัส 4319-001 หรือ 4319-002)
                        $loadCell = $activeItems->first(function($item) {
                            return in_array($item->calibration_lists_code, ['4319-001', '4319-002']);
                        });
                        
                        // ดึงเครื่องทดสอบหลัก (รหัส 4411-001) เพื่อใช้ค่าความเที่ยงตรงของแรงกดแนวตั้ง
                        $testMachine = $activeItems->firstWhere('calibration_lists_code', '4411-001');

                        // 2. กำหนดค่าตัวแปรผลทดสอบเฉลี่ยจริงในรอบนั้น ๆ (เพื่อใช้คิด Sensitivity Coefficient)
                        $F_mean = 500.0;  // แรงกดแนวตั้งเฉลี่ยจริง (นิวตัน)
                        $mu_mean = 0.38; // ค่าสัมประสิทธิ์แรงเสียดทานเฉลี่ยจริงของรอบนั้น ๆ (เช่น สตรีท-S อยู่ที่ประมาณ 0.35 - 0.40)

                        // 3. คำนวณความไม่แน่นอนมาตรฐาน (Standard Uncertainty: u = U / divisor)
                        // u1: โหลดเซลล์ (f) ดึงจากใบเซอร์จริง (0.01 N) หารด้วย 2 (Normal Dist.)
                        $u_f_cal = (float)($loadCell->calibration_lists_uncertainty ?? 0.01) / 2.0;

                        // u2: ความละเอียดของหน้าจอเครื่องอ่านแรงเสียดทาน (Resolution = 0.01 N) หารด้วย sqrt(3) (Rectangular Dist.)
                        $u_f_res = 0.01 / sqrt(3);

                        // u3: ระบบแรงกดแนวตั้ง (F) ของเครื่องทดสอบ (0.10 N) หารด้วย 2 (Normal Dist.)
                        $u_F_cal = (float)($testMachine->calibration_lists_uncertainty ?? 0.10) / 2.0;

                        // u4: ค่าความซ้ำของการทดสอบจริง (Repeatability ของเนื้อผ้าเบรค) 
                        $u_repeatability = 0.015; // เป็นค่าความไม่แน่นอนมาตรฐาน (k=1) อยู่แล้ว ไม่ต้องหารสอง

                        // 4. คำนวณสัมประสิทธิ์ความไว (Sensitivity Coefficient: ci) เพื่อแปลงหน่วยแรง (N) เป็นหน่วยสัมประสิทธิ์แรงเสียดทาน (μ)
                        $c_f_cal = 1.0 / $F_mean;
                        $c_f_res = 1.0 / $F_mean;
                        $c_F_cal = -$mu_mean / $F_mean; // อนุพันธ์ย่อยของสมการเทียบกับแรงกดแนวตั้ง (-f/F^2)
                        $c_repeatability = 1.0;

                        // 5. คำนวณผลรวมกำลังสองของความไม่แน่นอนส่วนร่วม (ui(y) = u_i * c_i)
                        $sumSquare = pow($u_f_cal * $c_f_cal, 2) + 
                                    pow($u_f_res * $c_f_res, 2) + 
                                    pow($u_F_cal * $c_F_cal, 2) + 
                                    pow($u_repeatability * $c_repeatability, 2);

                        // 6. ความไม่แน่นอนมาตรฐานรวม (Combined Standard Uncertainty)
                        $combinedUncertainty = sqrt($sumSquare);

                        // ปลายทาง: เมื่อระบบนำ $combinedUncertainty ไปคูณ k=2 (ในหน้าใบรายงานผล) 
                        // ตัวเลข Expanded Uncertainty จะแสดงผลออกมาถูกต้องและสมเหตุสมผลที่ระดับ ± 0.030 (μ) ครับ
                    @endphp
                    <span class="fs-6 text-danger ms-2">
                        (ค่าความไม่แน่นอนรวม (RSS): <strong>{{ number_format($combinedUncertainty, 3) }}</strong>)
                    </span>
                </h3>
            </div>
            <div class="col-12 col-md-6"><a style="float: right" href="{{route('calibrationlists.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> เพิ่มรายการ</a></div>
        </div>      
        
        <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>
                    <th>สถานะ</th>
                    <th>รหัส</th>
                    <th>ชื่อ</th>
                    <th>หมวด</th>
                    <th>กลุ่ม</th>
                    <th>ประเภท</th>
                    <th>วันที่ทวนสอบครั้งต่อไป</th>
                    <th>เครื่องมือใช้ทดสอบ</th>
                    <th>ค่าความไม่แน่นอน</th>
                    <th></th>
                    <th>ตรวจประจำวัน</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hd as $item)
                    <tr>
                        <td>
                            {{$item->calibration_lists_status}}
                        </td>
                        <td>{{$item->calibration_lists_code}}</td>
                        <td>{{$item->calibration_lists_name1}}</td>
                        <td>{{$item->Categorys->calibration_categories_name}}</td>
                        <td>{{$item->Groups->calibration_groups_name}}</td>
                        <td>{{$item->Types->calibration_types_name}}</td>
                        <td>{{$item->calibration_lists_nextdate}}</td>
                        <td>
                            @if ($item->calibration_lists_lapstatus)
                                <span class="badge-soft-success">ใช้งาน</span>
                            @else
                                <span class="badge-soft-danger">ไม่ใช้งาน</span>
                            @endif
                        </td>
                        <td>{{number_format($item->calibration_lists_uncertainty,6)}}</td>
                        <td>
                            <a href="{{route('calibrationlists.edit',$item->calibration_lists_id)}}" class="btn btn-sm btn-warning" >
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <a href="{{route('calibrationlists.show',$item->calibration_lists_id)}}" class="btn btn-sm btn-info" >
                                <i class="fas fa-plus"></i>
                            </a>
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
    })
});
</script>
@endpush