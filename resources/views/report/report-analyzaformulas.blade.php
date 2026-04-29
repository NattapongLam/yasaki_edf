@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Alert Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="mdi mdi-check-all me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="mdi mdi-block-helper me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <h2 class="fw-bold text-primary mb-1">
                วิเคราะห์สูตรเคมี
            </h2>
            <p class="text-muted mb-0">
                เปรียบเทียบสูตรเคมีทั้ง 3 สูตร
            </p>
        </div>

        <div class="card-body pt-4">

            {{-- Select Formula --}}
            <div class="row g-4">

                {{-- Formula 1 --}}
                <div class="col-md-4">
                    <div class="formula-box p-4 rounded-4 border shadow-sm h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="formula-number bg-primary text-white">1</div>
                            <h4 class="mb-0 ms-3 fw-semibold">สูตรที่ 1</h4>
                        </div>

                        <label class="form-label fw-semibold text-muted">
                            เลือกสูตรเคมี
                        </label>

                        <select class="form-control select2" id="formula_1">
                            <option value="">กรุณาเลือก</option>
                            @foreach($hd as $item)
                                <option value="{{ $item->chemistry_hd_name }}">
                                    {{ $item->chemistry_hd_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Formula 2 --}}
                <div class="col-md-4">
                    <div class="formula-box p-4 rounded-4 border shadow-sm h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="formula-number bg-success text-white">2</div>
                            <h4 class="mb-0 ms-3 fw-semibold">สูตรที่ 2</h4>
                        </div>

                        <label class="form-label fw-semibold text-muted">
                            เลือกสูตรเคมี
                        </label>

                        <select class="form-control select2" id="formula_2">
                            <option value="">กรุณาเลือก</option>
                            @foreach($hd as $item)
                                <option value="{{ $item->chemistry_hd_name }}">
                                    {{ $item->chemistry_hd_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Formula 3 --}}
                <div class="col-md-4">
                    <div class="formula-box p-4 rounded-4 border shadow-sm h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="formula-number bg-warning text-white">3</div>
                            <h4 class="mb-0 ms-3 fw-semibold">สูตรที่ 3</h4>
                        </div>

                        <label class="form-label fw-semibold text-muted">
                            เลือกสูตรเคมี
                        </label>

                        <select class="form-control select2" id="formula_3">
                            <option value="">กรุณาเลือก</option>
                            @foreach($hd as $item)
                                <option value="{{ $item->chemistry_hd_name }}">
                                    {{ $item->chemistry_hd_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            {{-- Table Result --}}
            <div class="row mt-5 g-4">

                <div class="col-md-4">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">รายละเอียดสูตรที่ 1</h5>
                        </div>
                        <div class="card-body">
                            <div id="formula-table-area-1">
                                <div class="text-center text-muted py-4">
                                    กรุณาเลือกสูตรที่ 1
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">รายละเอียดสูตรที่ 2</h5>
                        </div>
                        <div class="card-body">
                            <div id="formula-table-area-2">
                                <div class="text-center text-muted py-4">
                                    กรุณาเลือกสูตรที่ 2
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">รายละเอียดสูตรที่ 3</h5>
                        </div>
                        <div class="card-body">
                            <div id="formula-table-area-3">
                                <div class="text-center text-muted py-4">
                                    กรุณาเลือกสูตรที่ 3
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection


@push('scriptjs')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
$(document).ready(function () {

    /*
    |--------------------------------------------------------------------------
    | Global Chart Variable
    |--------------------------------------------------------------------------
    */

    let donutChart = null;
    let pieChart = null;


    /*
    |--------------------------------------------------------------------------
    | Select2
    |--------------------------------------------------------------------------
    */

    $('.select2').select2({
        placeholder: "กรุณาเลือกสูตร",
        allowClear: true,
        width: '100%'
    });


    /*
    |--------------------------------------------------------------------------
    | Render Charts
    |--------------------------------------------------------------------------
    */
function clearCharts() {

    if (donutChart) {
        donutChart.destroy();
        donutChart = null;
    }

    if (pieChart) {
        pieChart.destroy();
        pieChart = null;
    }

    $('#donutChart').parent().html('<canvas id="donutChart"></canvas>');
    $('#pieChart').parent().html('<canvas id="pieChart"></canvas>');
}
function renderCharts(details, formulaId) {

    if (!details || details.length === 0) return;

    let grouped = {};

    $.each(details, function (i, item) {

        let key = item.chemical_groups_name ?? '-';
        let color = item.chemical_groups_color ?? '#ccc';

        let density = parseFloat(item.density ?? 0);
        let weight = parseFloat(item.weghttotal ?? 0);

        if (!grouped[key]) {
            grouped[key] = {
                color: color,
                density: 0,
                weight: 0
            };
        }

        grouped[key].density += density;
        grouped[key].weight += weight;
    });

    let labels = [];
    let colors = [];
    let donutValues = [];
    let pieValues = [];

    $.each(grouped, function (k, v) {
        labels.push(k);
        colors.push(v.color);
        donutValues.push(v.density);
        pieValues.push(v.weight);
    });

    const total = arr => arr.reduce((a,b)=>a+b,0);
    const percent = (arr, v) => total(arr) ? ((v/total(arr))*100).toFixed(2) : 0;

    let donutId = `donutChart-${formulaId}`;
    let pieId = `pieChart-${formulaId}`;

    let donutCtx = document.getElementById(donutId);
    let pieCtx = document.getElementById(pieId);

    if (!donutCtx || !pieCtx) {
        console.log("Canvas not found:", donutId, pieId);
        return;
    }

    // destroy per formula
    if (window[`donut_${formulaId}`]) window[`donut_${formulaId}`].destroy();
    if (window[`pie_${formulaId}`]) window[`pie_${formulaId}`].destroy();

    window[`donut_${formulaId}`] = new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels,
            datasets: [{
                data: donutValues,
                backgroundColor: colors
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' },
                datalabels: {
                    formatter: v => percent(donutValues, v) + '%',
                    color: '#000',
                    font: { weight: 'bold' }
                },
                tooltip: {
                    callbacks: {
                        label: (ctx) => {
                            let v = ctx.raw;
                            return `${ctx.label} : ${v.toFixed(2)} (${percent(donutValues, v)}%)`;
                        }
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    window[`pie_${formulaId}`] = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels,
            datasets: [{
                data: pieValues,
                backgroundColor: colors
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' },
                datalabels: {
                    formatter: v => percent(pieValues, v) + '%',
                    color: '#fff',
                    font: { weight: 'bold' }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
}
function createLineChart(canvasId, labels, datasets, yMax = 1.2) {

const canvas = document.getElementById(canvasId);

if (!canvas) {
    console.log("Canvas not found:", canvasId);
    return;
}
    // destroy chart เก่าก่อน
    if (window[canvasId] instanceof Chart) {
        window[canvasId].destroy();
        window[canvasId] = null;
    }
    datasets.forEach(ds => {
    ds.borderWidth = 0.75;      // ลดจาก 0.5 → 0.3
    ds.pointRadius = 0;        // เอาจุดออกเลย
    ds.pointHoverRadius = 2;   // hover ค่อยแสดง
    ds.pointBorderWidth = 0;
    ds.tension = 0.1;
    ds.fill = false;
});
const ctx = canvas.getContext('2d');

    window[canvasId] = new Chart(ctx,{
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    position: 'top'
                }
            },

            scales: {
                x: {
                    type: 'linear', // << สำคัญมาก
                    min: 0,
                    max: 500,
                    ticks: {
                        stepSize: 50,
                        autoSkip: false
                    }
                },
                y: {
                    min: 0,
                    max: yMax,
                    ticks: {
                        stepSize: 0.4,
                        autoSkip: false
                    }
                }
            }
        }
    });
}
function createLineChartFall(canvasId, labels, datasets, yMax = 1.2) {

    const canvas = document.getElementById(canvasId);

    if (!canvas) {
        console.log("Canvas not found:", canvasId);
        return;
    }

    // destroy chart เก่าก่อน
    if (window[canvasId] instanceof Chart) {
        window[canvasId].destroy();
        window[canvasId] = null;
    }

    datasets.forEach(ds => {
        ds.borderWidth = 0.75;
        ds.pointRadius = 0;
        ds.pointHoverRadius = 2;
        ds.pointBorderWidth = 0;
        ds.tension = 0.1;
        ds.fill = false;
    });

    const ctx = canvas.getContext('2d');

    window[canvasId] = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    position: 'top'
                }
            },

            scales: {
                x: {
                    type: 'linear',
                    min: 0,
                    max: 750, // <<< ตรงนี้สำคัญ
                    ticks: {
                        stepSize: 50,
                        autoSkip: false
                    }
                },

                y: {
                    min: 0,
                    max: yMax,
                    ticks: {
                        stepSize: 0.4,
                        autoSkip: false
                    }
                }
            }
        }
    });
}
function renderFrictionCharts(frictions, formulaId) {

    console.log("frictions =", frictions);

    if (!frictions) return;

    let n1 = frictions.n1 ?? [];
    let n2 = frictions.n2 ?? [];
    let n3 = frictions.n3 ?? [];

    /*
    |--------------------------------------------------------------------------
    | Labels กลาง
    |--------------------------------------------------------------------------
    */

    let labels = [
        ...new Set([
            ...n1.map(x => x.Listno),
            ...n2.map(x => x.Listno),
            ...n3.map(x => x.Listno),
        ])
    ].sort((a, b) => a - b);

    /*
    |--------------------------------------------------------------------------
    | helper function
    |--------------------------------------------------------------------------
    */

    function mapData(source, field) {
    return labels.map(label => {

        let rows = source.filter(x => x.Listno == label);

        if (!rows.length) return null;

        let total = rows.reduce((sum, row) => {
            return sum + parseFloat(row[field] ?? 0);
        }, 0);

        return total / rows.length; // average
    });
}
    /*
    |--------------------------------------------------------------------------
    | 100°C U
    |--------------------------------------------------------------------------
    */

    createLineChart(
        `chartU100-${formulaId}`,
        labels,
        [
            {
                label: 'N1 100°C (u)',
                data: mapData(n1, 'Friction100_u'),
                borderColor: '#1f77b4',
                borderWidth: 0.75,
                pointRadius: 0,
                tension: 0.1,
                fill: false
            },
            {
                label: 'N2 100°C (u)',
                data: mapData(n2, 'Friction100_u'),
                borderColor: '#2ca02c',
                borderWidth: 0.75,
                pointRadius: 0,
                tension: 0.1,
                fill: false
            },
            {
                label: 'N3 100°C (u)',
                data: mapData(n3, 'Friction100_u'),
                borderColor: '#9467bd',
                borderWidth: 0.75,
                pointRadius: 0,
                tension: 0.1,
                fill: false
            },
            {
                label: 'N1 100°c_(°c)',
                data: mapData(n1, 'Friction100_c').map(x => x / 4000),
                borderColor: '#d62728',
                borderWidth: 0.75,
                pointRadius: 0,
                tension: 0.1,
                fill: false
            },
            {
                label: 'N2 100°c_(°c)',
                data: mapData(n2, 'Friction100_c').map(x => x / 4000),
                borderColor: '#ff7f0e',
                borderWidth: 0.75,
                pointRadius: 0,
                tension: 0.1,
                fill: false
            },
            {
                label: 'N3 100°c_(°c)',
                data: mapData(n3, 'Friction100_c').map(x => x / 4000),
                borderColor: '#8c564b',
                borderWidth: 0.75,
                pointRadius: 0,
                tension: 0.1,
                fill: false
            }
        ],
        1.2
    );
    /*
|--------------------------------------------------------------------------
| 150°C U
|--------------------------------------------------------------------------
*/

createLineChart(
    `chartU150-${formulaId}`,
    labels,
    [
        {
            label: 'N1 150°C (u)',
            data: mapData(n1, 'Friction150_u'),
            borderColor: '#1f77b4',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N2 150°C (u)',
            data: mapData(n2, 'Friction150_u'),
            borderColor: '#2ca02c',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N3 150°C (u)',
            data: mapData(n3, 'Friction150_u'),
            borderColor: '#9467bd',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },

        {
            label: 'N1 150°C (°C)',
            data: mapData(n1, 'Friction150_c').map(x => x / 4000),
            borderColor: '#d62728',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N2 150°C (°C)',
            data: mapData(n2, 'Friction150_c').map(x => x / 4000),
            borderColor: '#ff7f0e',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N3 150°C (°C)',
            data: mapData(n3, 'Friction150_c').map(x => x / 4000),
            borderColor: '#8c564b',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        }
    ],
    1.2
);
    /*
|--------------------------------------------------------------------------
| 200°C U
|--------------------------------------------------------------------------
*/

createLineChart(
    `chartU200-${formulaId}`,
    labels,
    [
        {
            label: 'N1 200°C (u)',
            data: mapData(n1, 'Friction200_u'),
            borderColor: '#1f77b4',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N2 200°C (u)',
            data: mapData(n2, 'Friction200_u'),
            borderColor: '#2ca02c',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N3 200°C (u)',
            data: mapData(n3, 'Friction200_u'),
            borderColor: '#9467bd',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },

        {
            label: 'N1 200°C (°C)',
            data: mapData(n1, 'Friction200_c').map(x => x / 4000),
            borderColor: '#d62728',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N2 200°C (°C)',
            data: mapData(n2, 'Friction200_c').map(x => x / 4000),
            borderColor: '#ff7f0e',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N3 200°C (°C)',
            data: mapData(n3, 'Friction200_c').map(x => x / 4000),
            borderColor: '#8c564b',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        }
    ],
    1.2
);
    /*
|--------------------------------------------------------------------------
| 250°C U
|--------------------------------------------------------------------------
*/

createLineChart(
    `chartU250-${formulaId}`,
    labels,
    [
        {
            label: 'N1 250°C (u)',
            data: mapData(n1, 'Friction250_u'),
            borderColor: '#1f77b4',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N2 250°C (u)',
            data: mapData(n2, 'Friction250_u'),
            borderColor: '#2ca02c',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N3 250°C (u)',
            data: mapData(n3, 'Friction250_u'),
            borderColor: '#9467bd',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },

        {
            label: 'N1 250°C (°C)',
            data: mapData(n1, 'Friction250_c').map(x => x / 4000),
            borderColor: '#d62728',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N2 250°C (°C)',
            data: mapData(n2, 'Friction250_c').map(x => x / 4000),
            borderColor: '#ff7f0e',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N3 250°C (°C)',
            data: mapData(n3, 'Friction250_c').map(x => x / 4000),
            borderColor: '#8c564b',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        }
    ],
    1.2
);
    /*
|--------------------------------------------------------------------------
| 300°C U
|--------------------------------------------------------------------------
*/

createLineChart(
    `chartU300-${formulaId}`,
    labels,
    [
        {
            label: 'N1 300°C (u)',
            data: mapData(n1, 'Friction300_u'),
            borderColor: '#1f77b4',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N2 300°C (u)',
            data: mapData(n2, 'Friction300_u'),
            borderColor: '#2ca02c',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N3 300°C (u)',
            data: mapData(n3, 'Friction300_u'),
            borderColor: '#9467bd',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },

        {
            label: 'N1 300°C (°C)',
            data: mapData(n1, 'Friction300_c').map(x => x / 4000),
            borderColor: '#d62728',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N2 300°C (°C)',
            data: mapData(n2, 'Friction300_c').map(x => x / 4000),
            borderColor: '#ff7f0e',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N3 300°C (°C)',
            data: mapData(n3, 'Friction300_c').map(x => x / 4000),
            borderColor: '#8c564b',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        }
    ],
    1.2
);
    /*
|--------------------------------------------------------------------------
| 350°C U
|--------------------------------------------------------------------------
*/

createLineChart(
    `chartU350-${formulaId}`,
    labels,
    [
        {
            label: 'N1 350°C (u)',
            data: mapData(n1, 'Friction350_u'),
            borderColor: '#1f77b4',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N2 350°C (u)',
            data: mapData(n2, 'Friction350_u'),
            borderColor: '#2ca02c',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N3 350°C (u)',
            data: mapData(n3, 'Friction350_u'),
            borderColor: '#9467bd',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },

        {
            label: 'N1 350°C (°C)',
            data: mapData(n1, 'Friction350_c').map(x => x / 4000),
            borderColor: '#d62728',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N2 350°C (°C)',
            data: mapData(n2, 'Friction350_c').map(x => x / 4000),
            borderColor: '#ff7f0e',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N3 350°C (°C)',
            data: mapData(n3, 'Friction350_c').map(x => x / 4000),
            borderColor: '#8c564b',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        }
    ],
    1.2
);
    /*
|--------------------------------------------------------------------------
| Fall°C U
|--------------------------------------------------------------------------
*/

createLineChartFall(
    `chartUfall-${formulaId}`,
    labels,
    [
        {
            label: 'N1 Fall°C (u)',
            data: mapData(n1, 'FrictionFall_u'),
            borderColor: '#1f77b4',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N2 Fall°C (u)',
            data: mapData(n2, 'FrictionFall_u'),
            borderColor: '#2ca02c',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N3 Fall°C (u)',
            data: mapData(n3, 'FrictionFall_u'),
            borderColor: '#9467bd',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },

        {
            label: 'N1 Fall°C (°C)',
            data: mapData(n1, 'FrictionFall_c').map(x => x / 4000),
            borderColor: '#d62728',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N2 Fall°C (°C)',
            data: mapData(n2, 'FrictionFall_c').map(x => x / 4000),
            borderColor: '#ff7f0e',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        },
        {
            label: 'N3 Fall°C (°C)',
            data: mapData(n3, 'FrictionFall_c').map(x => x / 4000),
            borderColor: '#8c564b',
            borderWidth: 0.75,
            pointRadius: 0,
            tension: 0.1,
            fill: false
        }
    ],
    1.2
);
}



    /*
    |--------------------------------------------------------------------------
    | Load Formula Table
    |--------------------------------------------------------------------------
    */
function loadFormulaTable(formulaId, tableAreaId) {

    let formulaName = $('#' + formulaId).val();

    if (formulaName === '') {
        $('#' + tableAreaId).html(`
            <div class="text-center text-muted py-4">
                กรุณาเลือกสูตรเพื่อแสดงข้อมูล
            </div>
        `);
        return;
    }

    $.ajax({
        url: "{{ route('report.get.formula.detail') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            formula_name: formulaName
        },

        success: function (response) {

            let html = '';
             /*
            |--------------------------------------------------------------------------
            | TEST AVERAGE (NEW)
            |--------------------------------------------------------------------------
            */
            if (response.test && response.test.length > 0) {

                let t = response.test[0];

                html += `
                    <div class="mt-4">
                        <div class="card border-0 shadow rounded-4">
                            <div class="card-header bg-dark text-white">
                                <h6 class="mb-0">Test Average Summary  ${response.header?.ms_formule_name ?? '-'}: ${response.header?.chemistry_hd_name ?? '-'}</h6>
                            </div>

                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded-3">
                                            <div class="text-muted">Hardness (HRB)</div>
                                            <div class="fs-5 fw-bold text-primary">
                                                ${parseFloat(t.Hardness ?? 0).toFixed(2)}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded-3">
                                            <div class="text-muted">Shearing (mm²)</div>
                                            <div class="fs-5 fw-bold text-primary">
                                                ${parseFloat(t.Shearing ?? 0).toFixed(2)}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded-3">
                                            <div class="text-muted">Noise (dB)</div>
                                            <div class="fs-5 fw-bold text-primary">
                                                ${parseFloat(t.Noise ?? 0).toFixed(2)}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded-3">
                                            <div class="text-muted">Normal (µ)</div>
                                            <div class="fs-5 fw-bold text-primary">
                                                ${parseFloat(t.Normal_Avg ?? 0).toFixed(2)}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="p-3 border rounded-3">
                                            <div class="text-muted">Hot (µ)</div>
                                            <div class="fs-5 fw-bold text-primary">
                                                ${parseFloat(t.Hot_Avg ?? 0).toFixed(2)}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="p-3 border rounded-3">
                                            <div class="text-muted">Wear (10−7cm3/(N⋅m))</div>
                                            <div class="fs-5 fw-bold text-primary">
                                                ${parseFloat(t.Wear_Avg ?? 0).toFixed(2)}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
              html += `
<div class="mt-4">

    <div class="card border-0 shadow rounded-4">
        <div class="card-header bg-dark text-white">
            <h6 class="mb-0">Friction Analysis ${response.header?.ms_formule_name ?? '-'}: ${response.header?.chemistry_hd_name ?? '-'}</h6>
        </div>

        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-12">
                    <canvas id="chartU100-${formulaId}" height="240"></canvas>
                </div>
                <div class="col-md-12">
                    <canvas id="chartU150-${formulaId}" height="240"></canvas>
                </div>

                <div class="col-md-12">
                    <canvas id="chartU200-${formulaId}" height="240"></canvas>
                </div>

                <div class="col-md-12">
                    <canvas id="chartU250-${formulaId}" height="240"></canvas>
                </div>

                <div class="col-md-12">
                    <canvas id="chartU300-${formulaId}" height="240"></canvas>
                </div>

                <div class="col-md-12">
                    <canvas id="chartU350-${formulaId}" height="240"></canvas>
                </div>


                <!-- FALL -->
                <div class="col-md-12">
                    <canvas id="chartUfall-${formulaId}" height="240"></canvas>
                </div>

            </div>

        </div>
    </div>

</div>
`;
            let sumDensity = 0;
            let sumAdjust = 0;
            let sumWeight = 0;
            let sumWeightPer = 0;
            let sumWeightTotal = 0;

            let mixKg = parseFloat(response.header?.chemistry_hd_mix ?? 0);
            let sumWeightExcel = 0;

            /*
            |--------------------------------------------------------------------------
            | HEADER
            |--------------------------------------------------------------------------
            */
            html += `
                <div class="mb-2">
                    <h6 class="fw-bold mb-2">
                        ${response.header?.ms_formule_name ?? '-'}
                        : ${response.header?.chemistry_hd_name ?? '-'}
                    </h6>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle table-sm-custom">
                        <thead class="table-light">
                            <tr>
                                <th width="40" class="text-center">#</th>
                                <th>Code</th>
                                <th>Material</th>
                                <th>Grade</th>
                                <th class="text-end">Density</th>
                                <th class="text-end">Vol.%</th>
                                <th class="text-end">Volume</th>
                                <th class="text-end">W(%)</th>
                                <th class="text-end">Weight(g)</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            /*
            |--------------------------------------------------------------------------
            | DETAILS
            |--------------------------------------------------------------------------
            */
            if (response.details.length > 0) {

                $.each(response.details, function (index, item) {

                    let density = parseFloat(item.density ?? 0);
                    let adjust = parseFloat(item.adjust ?? 0);
                    let weght = parseFloat(item.weght ?? 0);
                    let weghtper = parseFloat(item.weghtper ?? 0);
                    let weghttotal = parseFloat(item.weghttotal ?? 0);

                    sumAdjust += adjust;
                    sumWeight += weght;
                    sumWeightPer += weghtper;
                    sumWeightTotal += weghttotal;

                    sumWeightExcel += weght;

                    html += `
                        <tr>
                            <td class="text-center">${index + 1}</td>
                            <td>${item.code ?? '-'}</td>
                            <td>${item.material ?? '-'}</td>
                            <td>${item.grade ?? '-'}</td>
                            <td class="text-end">${density.toFixed(2)}</td>
                            <td class="text-end">${adjust.toFixed(2)}</td>
                            <td class="text-end">${weght.toFixed(2)}</td>
                            <td class="text-end">${weghtper.toFixed(2)}</td>
                            <td class="text-end">${weghttotal.toFixed(2)}</td>
                        </tr>
                    `;
                });

                if (sumWeightExcel > 0) {
                    sumDensity = mixKg / sumWeightExcel;
                }

                html += `
                        </tbody>
                        <tfoot>
                            <tr class="table-secondary fw-bold">
                                <td colspan="4" class="text-end">Total</td>
                                <td class="text-end">${sumDensity.toFixed(2)}</td>
                                <td class="text-end">${sumAdjust.toFixed(2)}</td>
                                <td class="text-end">${sumWeight.toFixed(2)}</td>
                                <td class="text-end">${sumWeightPer.toFixed(2)}</td>
                                <td class="text-end">${sumWeightTotal.toFixed(2)}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            `;
            } else {
                html += `
                    <tr>
                        <td colspan="9" class="text-center text-muted">
                            ไม่พบข้อมูล
                        </td>
                    </tr>
                </tbody>
                </table>
                `;
            }

            /*
            |--------------------------------------------------------------------------
            | NOTE
            |--------------------------------------------------------------------------
            */
            html += `
                <div class="mt-3">
                    <h6 class="fw-bold">
                        ${response.header?.chemistry_hd_note ?? '-'}
                    </h6>
                </div>
            `;

           

            /*
            |--------------------------------------------------------------------------
            | CHART AREA
            |--------------------------------------------------------------------------
            */
            html += `
                <div class="row mt-4 g-4">

                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0 fw-bold">Density Analysis ${response.header?.ms_formule_name ?? '-'}: ${response.header?.chemistry_hd_name ?? '-'}</h5>
                            </div>
                            <div class="card-body">
                                <div style="height:300px;">
                                    <canvas id="donutChart-${formulaId}"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0 fw-bold">Weight Total Analysis ${response.header?.ms_formule_name ?? '-'}: ${response.header?.chemistry_hd_name ?? '-'}</h5>
                            </div>
                            <div class="card-body">
                                <div style="height:300px;">
                                    <canvas id="pieChart-${formulaId}"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            `;
          
            /*
            |--------------------------------------------------------------------------
            | RENDER HTML
            |--------------------------------------------------------------------------
            */
            $('#' + tableAreaId).html(html);

            /*
            |--------------------------------------------------------------------------
            | RENDER CHART
            |--------------------------------------------------------------------------
            */
            setTimeout(() => {
                renderCharts(response.details, formulaId);
                renderFrictionCharts(response.frictions, formulaId);
            }, 100);
        },

        error: function (xhr) {
            console.log(xhr.responseText);
            $('#' + tableAreaId).html(`
                <div class="alert alert-danger">
                    เกิดข้อผิดพลาดในการโหลดข้อมูล
                </div>
            `);
        }
    });
}


    /*
    |--------------------------------------------------------------------------
    | Change Event
    |--------------------------------------------------------------------------
    */

    $('#formula_1').on('change', function () {
        loadFormulaTable('formula_1', 'formula-table-area-1');
    });

    $('#formula_2').on('change', function () {
        loadFormulaTable('formula_2', 'formula-table-area-2');
    });

    $('#formula_3').on('change', function () {
        loadFormulaTable('formula_3', 'formula-table-area-3');
    });

});
</script>


<style>
.formula-box {
    background: #ffffff;
    transition: all 0.3s ease;
}

.formula-box:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.formula-number {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
}

.table-sm-custom {
    font-size: 11px;
}

.table-sm-custom th,
.table-sm-custom td {
    padding: 4px 6px !important;
    white-space: nowrap;
    vertical-align: middle;
}
</style>

@endpush