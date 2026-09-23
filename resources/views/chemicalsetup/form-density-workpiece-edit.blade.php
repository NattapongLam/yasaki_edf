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
        <div class="card-body p-3">
            <form method="POST" class="form-horizontal" action="{{ route('density-workpiece.update', $hd->density_workpiece_hds_id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')  
                
                <!-- ส่วนหัวเอกสาร -->
                <div class="row border-bottom pb-2 mb-2 align-items-center">
                    <div class="col-8">
                        <h5 class="fw-bold text-dark mb-0">ใบรายงานการตรวจสอบความหนาแน่นของชิ้นงาน</h5>
                        <small class="text-muted">Density Workpiece Inspection Report</small>
                    </div>
                    <div class="col-4 text-end d-print-none">
                        <button type="button" class="btn btn-secondary btn-sm me-2" onclick="window.print()">
                            <i class="mdi mdi-printer me-1"></i> พิมพ์เอกสาร
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm">บันทึกข้อมูล</button>
                    </div>
                </div>

                <!-- ข้อมูลทั่วไป (Header Info) -->
                <div class="row g-2 mb-2 bg-light p-2 rounded border small">
                    <div class="col-6 col-md-6">
                        <span class="text-muted">Product:</span> <span class="fw-bold">{{ $hd->product_name }} ({{$hd->product_code }})</span>
                    </div>            
                    <div class="col-6 col-md-6">
                        <span class="text-muted">Mold:</span> <span class="fw-bold">{{ $hd->mlod_name }} ({{$hd->mlod_code }})</span>
                    </div>

                    <div class="col-3 col-md-3">
                        <span class="text-muted">Area:</span> <span class="fw-semibold">{{ $hd->mlod_area }} cm²</span>
                        <input type="hidden" name="mlod_area" id="mlod_area" value="{{ $hd->mlod_area }}">
                    </div>
                    <div class="col-3 col-md-3">
                        <span class="text-muted">Pressure:</span> <span class="fw-semibold">{{ $hd->mlod_pressure }}</span>
                        <input type="hidden" name="mlod_pressure" id="mlod_pressure" value="{{ $hd->mlod_pressure }}">
                    </div>
                    <div class="col-3 col-md-3">
                        <span class="text-muted">Weight:</span> <span class="fw-semibold">{{ $hd->chemical_weight }}</span>
                    </div>
                    <div class="col-3 col-md-3">
                        <span class="text-muted">Temp:</span> <span class="fw-semibold">{{ $hd->chemical_temp }}</span>
                    </div>

                    <div class="col-3 col-md-3">
                        <span class="text-muted">Formule:</span> <span class="fw-semibold">{{ $hd->ms_formule_name }}</span>            
                    </div>
                    <div class="col-3 col-md-3">
                        <span class="text-muted">Number:</span> <span class="fw-semibold">{{ $hd->chemistry_hd_name }}</span>
                    </div>
                    <div class="col-3 col-md-3">
                        <span class="text-muted">Target Density:</span> <span class="fw-bold text-primary" id="target_density_text">{{ $hd->total_density }}</span>
                        <input type="hidden" name="total_density" id="total_density" value="{{ $hd->total_density }}">
                    </div>
                    <div class="col-3 col-md-3">
                        <span class="text-muted">Date:</span> <span class="fw-semibold">{{ $hd->density_workpiece_hds_date }}</span>
                        <input type="hidden" name="product_sides" value="{{ $hd->product_sides }}">
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
                                <th rowspan="2" class="align-middle">ความหนาก้อน (cm)</th>
                                <th rowspan="2" class="align-middle">Volume (cm³)</th>
                                <th rowspan="2" class="align-middle">Density (g/cm³)</th>
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
                        <!-- ส่วนสรุปผลด้านบน -->
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

                <!-- ส่วนแสดงกราฟ (Chart.js Dashboard) - ขยายเต็มหน้า -->
                <div class="row mt-4">
                    <div class="col-12 mb-3">
                        <div class="card border shadow-sm print-chart-card">
                            <div class="card-body">
                                <h6 class="fw-bold text-dark mb-2">กราฟเปรียบเทียบ Density กับ Target</h6>
                                <canvas id="densityChart" height="90"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="card border shadow-sm print-chart-card">
                            <div class="card-body">
                                <h6 class="fw-bold text-dark mb-2">กราฟแนวโน้ม %Porosity</h6>
                                <canvas id="porosityChart" height="90"></canvas>
                            </div>
                        </div>
                    </div>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- เพิ่ม ChartDataLabels plugin เพื่อโชว์ตัวเลขบนกราฟ -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<style>
    .select2-results__options {
        max-height: 200px !important;
        overflow-y: auto !important;
    }

    @media print {
        @page {
            size: A4 landscape;
            margin: 5mm;
        }

        body {
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
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

        button, .btn, .alert {
            display: none !important;
        }

        .print-hide-total {
            display: none !important;
        }

        table.print-table {
            font-size: 9px !important;
            width: 100% !important;
            border-collapse: collapse !important;
        }

        table.print-table th, 
        table.print-table td {
            padding: 2px 3px !important;
            border: 1px solid #333 !important;
        }

        .form-control, select.form-control {
            border: none !important;
            border-bottom: 1px dotted #999 !important;
            background-color: transparent !important;
            box-shadow: none !important;
            padding: 0 !important;
            height: auto !important;
            text-align: center;
            font-size: 9px;
        }

        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

       .print-chart-card {
            border: 1px solid #ddd !important;
            box-shadow: none !important;
            margin-top: 10px !important;
            page-break-inside: avoid;
        }

        .print-chart-card canvas {
            width: 100% !important;
            height: auto !important;
            max-height: 140px !important;
        }

        .table-responsive {
            overflow: visible !important;
        }
        
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
    }
</style>
<script>
let densityChartInstance = null;
let porosityChartInstance = null;

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

    var chartLabels = [];
    var chartActualDensity = [];
    var chartTargetDensity = [];
    var chartPorosity = [];
    var chartSides = [];
    var targetDensityVal = parseFloat($('#total_density').val()) || 0;

    rows.each(function() {
        calculateRow(this);
        var currentSide = $(this).find('select[name*="[product_sides]"]').val();
        var listNo = $(this).find('td:first').text().trim();

        chartLabels.push('Cavity ' + listNo);
        chartActualDensity.push(parseFloat($(this).find('.calc-density').val()) || 0);
        chartTargetDensity.push(targetDensityVal);
        chartPorosity.push(parseFloat($(this).find('.calc-porosity').val()) || 0);
        chartSides.push(currentSide);

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
                <tr class="table-secondary fw-bold text-dark print-hide-total">
                    <td colspan="13" class="text-start ps-2">สรุปผลด้าน: ${side}</td>
                </tr>
                <tr class="table-light print-hide-total">
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

    updateCharts(chartLabels, chartActualDensity, chartTargetDensity, chartPorosity, chartSides);
}

function updateCharts(labels, actualDensity, targetDensity, porosity, sides) {
    const backgroundColors = sides.map(side => {
        if (side === 'ซ้าย') return 'rgba(54, 162, 235, 0.7)';
        if (side === 'ขวา') return 'rgba(255, 159, 64, 0.7)';
        if (side === 'ซ้าย-ขวา') return 'rgba(153, 102, 255, 0.7)';
        return 'rgba(201, 203, 207, 0.7)';
    });

    const borderColors = sides.map(side => {
        if (side === 'ซ้าย') return 'rgba(54, 162, 235, 1)';
        if (side === 'ขวา') return 'rgba(255, 159, 64, 1)';
        if (side === 'ซ้าย-ขวา') return 'rgba(153, 102, 255, 1)';
        return 'rgba(201, 203, 207, 1)';
    });

    // 1. กราฟ Density (พร้อม Datalabels และแสดงค่า Side บนกราฟ)
    const ctxDensity = document.getElementById('densityChart').getContext('2d');
    if (densityChartInstance) {
        densityChartInstance.destroy();
    }
    densityChartInstance = new Chart(ctxDensity, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Actual Density',
                    data: actualDensity,
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
                    borderWidth: 1
                },
                {
                    label: 'Target Density',
                    data: targetDensity,
                    type: 'line',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: false,
                    pointRadius: 0,
                    datalabels: {
                        display: false // ซ่อนตัวเลขของ Target เส้นตรงเพื่อไม่ให้รก
                    }
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            let index = context[0].dataIndex;
                            return context[0].label + ' (' + sides[index] + ')';
                        }
                    }
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    formatter: function(value, context) {
                        if (context.datasetIndex === 0) {
                            let index = context.dataIndex;
                            // แสดงทั้ง Side และค่าตัวเลข เช่น "ซ้าย\n1.0250"
                            return sides[index] + '\n' + value.toFixed(4);
                        }
                        return '';
                    },
                    font: {
                        size: 10,
                        weight: 'bold'
                    },
                    color: '#333'
                }
            },
            scales: { 
                y: { 
                    beginAtZero: false,
                    grace: '15% ' // เผื่อพื้นที่ด้านบนให้ตัวหนังสือไม่ชนขอบกราฟ
                } 
            }
        },
        plugins: [ChartDataLabels]
    });

    // 2. กราฟ %Porosity (พร้อม Datalabels แสดงตัวเลข)
    const ctxPorosity = document.getElementById('porosityChart').getContext('2d');
    if (porosityChartInstance) {
        porosityChartInstance.destroy();
    }
    porosityChartInstance = new Chart(ctxPorosity, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: '%Porosity',
                data: porosity,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2,
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                datalabels: {
                    align: 'top',
                    formatter: function(value) {
                        return value.toFixed(2) + '%';
                    },
                    font: {
                        size: 10,
                        weight: 'bold'
                    },
                    color: '#333'
                }
            },
            scales: { 
                y: { 
                    beginAtZero: true,
                    grace: '15%'
                } 
            }
        },
        plugins: [ChartDataLabels]
    });
}

$(document).on('input', '.iron-w, .iron-t, .glue-w, .glue-t, .chem-w, .chem-t', function() {
    calculateAllRows();
});

$(document).on('change', 'select[name*="[product_sides]"]', function() {
    calculateAllRows();
});
</script>
@endpush