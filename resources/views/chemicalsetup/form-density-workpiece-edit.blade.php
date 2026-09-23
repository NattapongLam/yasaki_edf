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

    <div class="card border-0 shadow-sm print-card">
        <div class="card-body p-4">
            <form method="POST" class="form-horizontal" action="{{ route('density-workpiece.update', $hd->density_workpiece_hds_id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')  
                
                <!-- ส่วนหัวเอกสาร -->
                <div class="row border-bottom pb-3 mb-3 align-items-center">
                    <div class="col-8">
                        <h4 class="fw-bold text-dark mb-1">ใบรายงานการตรวจสอบความหนาแน่นของชิ้นงาน</h4>
                        <p class="text-muted mb-0 small">Density Workpiece Inspection Report</p>
                    </div>
                    <div class="col-4 text-end d-print-none">
                        <button type="button" class="btn btn-secondary me-2" onclick="window.print()">
                            <i class="mdi mdi-printer me-1"></i> พิมพ์เอกสาร
                        </button>
                        <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                    </div>
                </div>

                <!-- ข้อมูลทั่วไป (Header Info) -->
                <div class="row g-3 mb-3 bg-light p-3 rounded border">
                    <div class="col-6 col-md-6">
                        <label class="form-label text-muted small mb-1">Product</label>
                        <input class="form-control form-control-sm bg-white fw-bold" value="{{ $hd->product_name }} ({{$hd->product_code }})" readonly>
                    </div>            
                    <div class="col-6 col-md-6">
                        <label class="form-label text-muted small mb-1">Mold</label>
                        <input class="form-control form-control-sm bg-white fw-bold" value="{{ $hd->mlod_name }} ({{$hd->mlod_code }})" readonly>
                    </div>

                    <div class="col-6 col-md-3">
                        <label class="form-label text-muted small mb-1">Area (cm²)</label>
                        <input class="form-control form-control-sm bg-white" name="mlod_area" id="mlod_area" value="{{ $hd->mlod_area }}" readonly>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label text-muted small mb-1">Pressure</label>
                        <input class="form-control form-control-sm bg-white" name="mlod_pressure" id="mlod_pressure" value="{{ $hd->mlod_pressure }}" readonly>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label text-muted small mb-1">Weight</label>
                        <input class="form-control form-control-sm bg-white" name="chemical_weight" value="{{ $hd->chemical_weight }}" readonly>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label text-muted small mb-1">Temp</label>
                        <input class="form-control form-control-sm bg-white" name="chemical_temp" value="{{ $hd->chemical_temp }}" readonly>
                    </div>

                    <div class="col-6 col-md-3">
                        <label class="form-label text-muted small mb-1">Formule</label>
                        <input class="form-control form-control-sm bg-white" name="ms_formule_name" value="{{ $hd->ms_formule_name }}" readonly>                
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label text-muted small mb-1">Number</label>
                        <input class="form-control form-control-sm bg-white" value="{{ $hd->chemistry_hd_name }}" readonly>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label text-muted small mb-1">Density (Target)</label>
                        <input class="form-control form-control-sm bg-white fw-bold text-primary" name="total_density" id="total_density" value="{{ $hd->total_density }}" readonly>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label text-muted small mb-1">Date</label>
                        <input class="form-control form-control-sm bg-white fw-bold" value="{{ $hd->density_workpiece_hds_date}}" readonly>
                    </div>
                </div>

                <!-- ตารางข้อมูลชิ้นงาน -->
                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center align-middle print-table">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2" class="align-middle">ลำดับ</th>
                                <th colspan="2">เหล็ก</th>
                                <th colspan="2">เหล็ก + กาว</th>
                                <th colspan="2">เหล็ก + กาว + เคมี</th>
                                <th rowspan="2" class="align-middle">น้ำหนักเคมี (g)</th>
                                <th rowspan="2" class="align-middle">ความหนาก้อนเคมี (cm)</th>
                                <th rowspan="2" class="align-middle">Volume (cm³)</th>
                                <th rowspan="2" class="align-middle">Density (g/cm³)<br>ρ = mass / Vol</th>
                                <th rowspan="2" class="align-middle">%Porosity</th>
                                <th rowspan="2" class="align-middle">Sides</th>
                            </tr>
                            <tr>
                                <th>น้ำหนัก (g)</th>
                                <th>ความหนา (mm)</th>
                                <th>น้ำหนัก (g)</th>
                                <th>ความหนา (mm)</th>
                                <th>น้ำหนัก (g)</th>
                                <th>ความหนา (mm)</th>
                            </tr>
                        </thead>
                        <!-- ย้ายส่วนสรุปผล (Summary) มาไว้ที่ส่วนหัวของตาราง (thead รอง) หรือแสดงก่อน tbody -->
                        <tbody id="summary_table_section" class="fw-bold bg-light">
                            <!-- ผลรวมสรุปจะถูกแทรกลงตรงนี้ผ่าน JavaScript -->
                        </tbody>
                        <tbody id="cavity_table_body">
                            @foreach ($dt as $item)
                            <tr>
                                <td class="fw-bold bg-light">{{ $item->density_workpiece_dts_listno }}</td>
                                <td><input type="number" step="any" class="form-control form-control-sm text-center iron-w" name="cavity[{{ $item->density_workpiece_dts_listno }}][weight_1]" value="{{ $item->weight_1 }}"></td>
                                <td><input type="number" step="any" class="form-control form-control-sm text-center iron-t" name="cavity[{{ $item->density_workpiece_dts_listno }}][thickness_1]" value="{{ $item->thickness_1 }}"></td>
                                <td><input type="number" step="any" class="form-control form-control-sm text-center glue-w" name="cavity[{{ $item->density_workpiece_dts_listno }}][weight_2]" value="{{ $item->weight_2 }}"></td>
                                <td><input type="number" step="any" class="form-control form-control-sm text-center glue-t" name="cavity[{{ $item->density_workpiece_dts_listno }}][thickness_2]" value="{{ $item->thickness_2 }}"></td>
                                <td><input type="number" step="any" class="form-control form-control-sm text-center chem-w" name="cavity[{{ $item->density_workpiece_dts_listno }}][weight_3]" value="{{ $item->weight_3 }}"></td>
                                <td><input type="number" step="any" class="form-control form-control-sm text-center chem-t" name="cavity[{{ $item->density_workpiece_dts_listno }}][thickness_3]" value="{{ $item->thickness_3 }}"></td>
                                <td><input type="text" class="form-control form-control-sm text-center calc-weight-chem bg-light" name="cavity[{{ $item->density_workpiece_dts_listno }}][weight_chemical]" value="{{ $item->weight_chemical }}" readonly></td>
                                <td><input type="text" class="form-control form-control-sm text-center calc-thickness-chem bg-light" name="cavity[{{ $item->density_workpiece_dts_listno }}][thickness_chemical]" value="{{ $item->thickness_chemical }}" readonly></td>
                                <td><input type="text" class="form-control form-control-sm text-center calc-volume bg-light" name="cavity[{{ $item->density_workpiece_dts_listno }}][density_workpiece_dts_volume]" value="{{ $item->density_workpiece_dts_volume }}" readonly></td>
                                <td><input type="text" class="form-control form-control-sm text-center calc-density bg-light" name="cavity[{{ $item->density_workpiece_dts_listno }}][density_workpiece_dts_density]" value="{{ $item->density_workpiece_dts_density }}" readonly></td>
                                <td><input type="text" class="form-control form-control-sm text-center calc-porosity bg-light" name="cavity[{{ $item->density_workpiece_dts_listno }}][density_workpiece_dts_porosity]" value="{{ $item->density_workpiece_dts_porosity }}" readonly></td>
                                <td>
                                    <select class="form-control form-control-sm text-center" name="cavity[{{ $item->density_workpiece_dts_listno }}][product_sides]">
                                        <option value="{{$item->product_sides}}">{{$item->product_sides}}</option>
                                        <option value="ซ้าย">ซ้าย</option>
                                        <option value="ขวา">ขวา</option>
                                        <option value="ซ้าย-ขวา">ซ้าย-ขวา</option>
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- ปุ่มด้านล่าง (ซ่อนเวลาพิมพ์) -->
                <div class="row mt-3 d-print-none">
                    <div class="col-12 text-end">
                        <button type="button" class="btn btn-secondary me-2" onclick="window.print()">
                            <i class="mdi mdi-printer me-1"></i> พิมพ์เอกสาร
                        </button>
                        <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scriptjs')
<style>
    .select2-results__options {
        max-height: 200px !important;
        overflow-y: auto !important;
    }

    /* ================= สไตล์สำหรับการพิมพ์เอกสาร (Print CSS) ================= */
    @media print {
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        body * {
            visibility: hidden;
        }

        .print-card, .print-card * {
            visibility: visible;
        }

        .print-card {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
        }

        .d-print-none, button, .btn, .alert {
            display: none !important;
        }

        .form-control, select.form-control {
            border: none !important;
            border-bottom: 1px dotted #999 !important;
            background-color: transparent !important;
            box-shadow: none !important;
            padding: 1px 0 !important;
            text-align: center;
            font-size: 11px;
        }

        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .table-responsive {
            overflow: visible !important;
        }

        table.print-table {
            font-size: 11px;
            width: 100% !important;
            border-collapse: collapse !important;
        }

        table.print-table th, 
        table.print-table td {
            padding: 4px 6px !important;
            border: 1px solid #333 !important;
        }
        
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
    }
</style>
<script>
$(document).ready(function() {
    calculateAllRows();
});

function calculateRow(rowTr) {
    var ironW = parseFloat($(rowTr).find('.iron-w').val()) || 0;
    var ironT = parseFloat($(rowTr).find('.iron-t').val()) || 0;
    var glueW = parseFloat($(rowTr).find('.glue-w').val()) || 0;
    var glueT = parseFloat($(rowTr).find('.glue-t').val()) || 0;
    var chemW = parseFloat($(rowTr).find('.chem-w').val()) || 0;
    var chemT = parseFloat($(rowTr).find('.chem-t').val()) || 0;

    var mlodArea = parseFloat($('#mlod_area').val()) || 0;
    var targetDensity = parseFloat($('#total_density').val()) || 0;

    var weightChem = chemW - glueW;
    var thicknessChem = (chemT - glueT) / 10;
    var volume = thicknessChem * mlodArea;
    var density = (volume > 0) ? (weightChem / volume) : 0;
    var porosity = (targetDensity > 0) ? (((targetDensity - density) / targetDensity) * 100) : 0;

    $(rowTr).find('.calc-weight-chem').val(weightChem !== 0 ? weightChem.toFixed(4) : '0');
    $(rowTr).find('.calc-thickness-chem').val(thicknessChem !== 0 ? thicknessChem.toFixed(4) : '0');
    $(rowTr).find('.calc-volume').val(volume !== 0 ? volume.toFixed(4) : '0');
    $(rowTr).find('.calc-density').val(density !== 0 ? density.toFixed(4) : '0');
    $(rowTr).find('.calc-porosity').val(porosity !== 0 ? porosity.toFixed(4) : '0');
}

function calculateAllRows() {
    var rows = $('#cavity_table_body tr');
    if (rows.length === 0) {
        $('#summary_table_section').hide();
        return;
    }

    var sidesList = ['ซ้าย', 'ขวา', 'ซ้าย-ขวา'];
    var sideData = {};

    sidesList.forEach(function(side) {
        sideData[side] = {
            sumIronW: 0, sumIronT: 0,
            sumGlueW: 0, sumGlueT: 0,
            sumChemW: 0, sumChemT: 0,
            sumWeightChem: 0, sumThicknessChem: 0,
            sumVolume: 0, sumDensity: 0, sumPorosity: 0,
            count: 0
        };
    });

    rows.each(function() {
        calculateRow(this);
        var currentSide = $(this).find('select[name*="[product_sides]"]').val();

        if (sideData[currentSide]) {
            sideData[currentSide].count++;
            sideData[currentSide].sumIronW += parseFloat($(this).find('.iron-w').val()) || 0;
            sideData[currentSide].sumIronT += parseFloat($(this).find('.iron-t').val()) || 0;
            sideData[currentSide].sumGlueW += parseFloat($(this).find('.glue-w').val()) || 0;
            sideData[currentSide].sumGlueT += parseFloat($(this).find('.glue-t').val()) || 0;
            sideData[currentSide].sumChemW += parseFloat($(this).find('.chem-w').val()) || 0;
            sideData[currentSide].sumChemT += parseFloat($(this).find('.chem-t').val()) || 0;

            sideData[currentSide].sumWeightChem += parseFloat($(this).find('.calc-weight-chem').val()) || 0;
            sideData[currentSide].sumThicknessChem += parseFloat($(this).find('.calc-thickness-chem').val()) || 0;
            sideData[currentSide].sumVolume += parseFloat($(this).find('.calc-volume').val()) || 0;
            sideData[currentSide].sumDensity += parseFloat($(this).find('.calc-density').val()) || 0;
            sideData[currentSide].sumPorosity += parseFloat($(this).find('.calc-porosity').val()) || 0;
        }
    });

    var summaryHtml = '';

    sidesList.forEach(function(side) {
        var data = sideData[side];
        if (data.count > 0) {
            var count = data.count;
            summaryHtml += `
                <tr class="table-secondary fw-bold text-dark">
                    <td colspan="13" class="text-start ps-3">สรุปผลด้าน: ${side}</td>
                </tr>
                <tr class="table-light">
                    <td class="fw-semibold">Total (${side})</td>
                    <td>${data.sumIronW.toFixed(2)}</td>
                    <td>${data.sumIronT.toFixed(2)}</td>
                    <td>${data.sumGlueW.toFixed(2)}</td>
                    <td>${data.sumGlueT.toFixed(2)}</td>
                    <td>${data.sumChemW.toFixed(2)}</td>
                    <td>${data.sumChemT.toFixed(2)}</td>
                    <td>${data.sumWeightChem.toFixed(2)}</td>
                    <td>${data.sumThicknessChem.toFixed(2)}</td>
                    <td>${data.sumVolume.toFixed(2)}</td>
                    <td>${data.sumDensity.toFixed(2)}</td>
                    <td>${data.sumPorosity.toFixed(2)}</td>
                    <td>-</td>
                </tr>
                <tr class="table-light">
                    <td class="fw-semibold">Average (${side})</td>
                    <td>${(data.sumIronW / count).toFixed(2)}</td>
                    <td>${(data.sumIronT / count).toFixed(2)}</td>
                    <td>${(data.sumGlueW / count).toFixed(2)}</td>
                    <td>${(data.sumGlueT / count).toFixed(2)}</td>
                    <td>${(data.sumChemW / count).toFixed(2)}</td>
                    <td>${(data.sumChemT / count).toFixed(2)}</td>
                    <td>${(data.sumWeightChem / count).toFixed(2)}</td>
                    <td>${(data.sumThicknessChem / count).toFixed(2)}</td>
                    <td>${(data.sumVolume / count).toFixed(2)}</td>
                    <td>${(data.sumDensity / count).toFixed(2)}</td>
                    <td>${(data.sumPorosity / count).toFixed(2)}</td>
                    <td>-</td>
                </tr>
            `;
        }
    });

    if (summaryHtml === '') {
        $('#summary_table_section').hide();
    } else {
        $('#summary_table_section').html(summaryHtml).show();
    }
}

$(document).on('input', '.iron-w, .iron-t, .glue-w, .glue-t, .chem-w, .chem-t', function() {
    calculateAllRows();
});

$(document).on('change', 'select[name*="[product_sides]"]', function() {
    calculateAllRows();
});
</script>
@endpush