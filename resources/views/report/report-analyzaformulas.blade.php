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
            <div class="d-flex justify-content-between align-items-center flex-wrap g-2">
                <div>
                    <h2 class="fw-bold text-primary mb-1">
                        วิเคราะห์สูตรเคมี
                    </h2>
                    <p class="text-muted mb-0">
                        เปรียบเทียบสูตรเคมีทั้ง 3 สูตร
                    </p>
                </div>
                {{-- แถบปุ่มเปิด/ปิดสูตร เพื่อปรับ Grid (col-12 / col-6 / col-4) --}}
                <div class="mt-2 mt-md-0">
                    <span class="text-muted me-2 fw-semibold small">แสดง/ซ่อนสูตร:</span>
                    <button type="button" class="btn btn-sm btn-outline-primary active me-1 rounded-3 toggle-formula-btn" data-target="1">
                        <i class="mdi mdi-eye me-1"></i> สูตรที่ 1
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-success active me-1 rounded-3 toggle-formula-btn" data-target="2">
                        <i class="mdi mdi-eye me-1"></i> สูตรที่ 2
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-warning active rounded-3 text-dark toggle-formula-btn" data-target="3">
                        <i class="mdi mdi-eye me-1"></i> สูตรที่ 3
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body pt-4">

            {{-- Select Formula Grid --}}
            <div class="row g-4 transition-grid" id="formula-selection-row">

                {{-- Formula 1 --}}
                <div class="formula-card-wrapper" id="wrapper-select-1" data-formula="1">
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
                                <option value="{{ $item->TestID }}">
                                    {{ $item->FormulaNumber }} ({{$item->Remarks}})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Formula 2 --}}
                <div class="formula-card-wrapper" id="wrapper-select-2" data-formula="2">
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
                                <option value="{{ $item->TestID }}">
                                    {{ $item->FormulaNumber }} ({{$item->Remarks}})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Formula 3 --}}
                <div class="formula-card-wrapper" id="wrapper-select-3" data-formula="3">
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
                                <option value="{{ $item->TestID }}">
                                    {{ $item->FormulaNumber }} ({{$item->Remarks}})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            {{-- Table & Graph Result Grid --}}
            <div class="row mt-5 g-4 transition-grid" id="formula-result-row">

                {{-- Result 1 --}}
                <div class="formula-card-wrapper" id="wrapper-result-1" data-formula="1">
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

                {{-- Result 2 --}}
                <div class="formula-card-wrapper" id="wrapper-result-2" data-formula="2">
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

                {{-- Result 3 --}}
                <div class="formula-card-wrapper" id="wrapper-result-3" data-formula="3">
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

    // ตัวแปรเก็บสถานะการเปิด/ปิดของแต่ละสูตร (true = แสดง, false = ซ่อน)
    let formulaStates = {
        1: true,
        2: true,
        3: true
    };

    /*
    |--------------------------------------------------------------------------
    | ฟังก์ชันคำนวณและปรับคลาส Grid (col-12 / col-6 / col-4) ตามจำนวนสูตรที่เหลือ
    |--------------------------------------------------------------------------
    */
    function updateFormulaGrid() {
        // นับจำนวนสูตรที่ถูกเลือกให้ "แสดง" ณ ปัจจุบัน
        let activeCount = Object.values(formulaStates).filter(v => v === true).length;
        
        let gridClass = 'col-4'; // ค่าเริ่มต้นถ้าแสดงครบ 3 สูตร (ใช้ col-4 หรือ col-md-4)
        
        if (activeCount === 2) {
            gridClass = 'col-6';  // กรณี hide 1 สูตร -> สูตรที่เหลือ = class = col-6
        } else if (activeCount === 1) {
            gridClass = 'col-12'; // กรณี hide 2 สูตร -> สูตรที่เหลือ = class = col-12
        }

        // ล้างคลาสเก่าและใส่คลาสใหม่ให้เหมาะสมตามเงื่อนไข
        for (let id in formulaStates) {
            let isVisible = formulaStates[id];
            let selectWrapper = $(`#wrapper-select-${id}`);
            let resultWrapper = $(`#wrapper-result-${id}`);

            if (isVisible) {
                // ล้างคลาส col ทั้งหมดที่เกี่ยวข้องออกก่อน แล้วแทนที่ด้วย gridClass ใหม่
                selectWrapper.removeClass('col-4 col-6 col-12 col-md-4 col-md-6 col-md-12').addClass(gridClass).show();
                resultWrapper.removeClass('col-4 col-6 col-12 col-md-4 col-md-6 col-md-12').addClass(gridClass).show();
            } else {
                // ถ้าโดน Hide ก็สั่งซ่อน Element ไปเลย
                selectWrapper.hide();
                resultWrapper.hide();
            }
        }
    }

    // เรียกทำงานครั้งแรกตอนโหลดหน้าเพจ
    updateFormulaGrid();

    /*
    |--------------------------------------------------------------------------
    | Event คุมปุ่มซ่อน/แสดง
    |--------------------------------------------------------------------------
    */
    $('.toggle-formula-btn').on('click', function () {
        let btn = $(this);
        let targetFormula = btn.data('target');
        
        // สลับสถานะ บันทึกค่าลง Object
        formulaStates[targetFormula] = !formulaStates[targetFormula];

        // เปลี่ยนดีไซน์ของปุ่มกด
        if (formulaStates[targetFormula]) {
            btn.addClass('active');
            btn.find('i').removeClass('mdi-eye-off').addClass('mdi-eye');
        } else {
            btn.removeClass('active');
            btn.find('i').removeClass('mdi-eye').addClass('mdi-eye-off');
        }

        // สั่งประมวลผลคำนวณแบ่งคลาส col ใหม่ทันที
        updateFormulaGrid();
    });


    /*
    |--------------------------------------------------------------------------
    | Global Chart Variable & Functions (คงเดิมตามระบบของคุณ)
    |--------------------------------------------------------------------------
    */
    let donutChart = null;
    let pieChart = null;

    $('.select2').select2({
        placeholder: "กรุณาเลือกสูตร",
        allowClear: true,
        width: '100%'
    });

    function clearCharts() {
        if (donutChart) { donutChart.destroy(); donutChart = null; }
        if (pieChart) { pieChart.destroy(); pieChart = null; }
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
                grouped[key] = { color: color, density: 0, weight: 0 };
            }
            grouped[key].density += density;
            grouped[key].weight += weight;
        });

        let labels = [], colors = [], donutValues = [], pieValues = [];
        $.each(grouped, function (k, v) {
            labels.push(k); colors.push(v.color); donutValues.push(v.density); pieValues.push(v.weight);
        });

        const total = arr => arr.reduce((a,b)=>a+b,0);
        const percent = (arr, v) => total(arr) ? ((v/total(arr))*100).toFixed(2) : 0;

        let donutId = `donutChart-${formulaId}`, pieId = `pieChart-${formulaId}`;
        let donutCtx = document.getElementById(donutId), pieCtx = document.getElementById(pieId);

        if (!donutCtx || !pieCtx) return;

        if (window[`donut_${formulaId}`]) window[`donut_${formulaId}`].destroy();
        if (window[`pie_${formulaId}`]) window[`pie_${formulaId}`].destroy();

        window[`donut_${formulaId}`] = new Chart(donutCtx, {
            type: 'doughnut',
            data: { labels, datasets: [{ data: donutValues, backgroundColor: colors }] },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' },
                    datalabels: { formatter: v => percent(donutValues, v) + '%', color: '#000', font: { weight: 'bold' } },
                    tooltip: { callbacks: { label: (ctx) => { let v = ctx.raw; return `${ctx.label} : ${v.toFixed(2)} (${percent(donutValues, v)}%)`; } } }
                }
            },
            plugins: [ChartDataLabels]
        });

        window[`pie_${formulaId}`] = new Chart(pieCtx, {
            type: 'pie',
            data: { labels, datasets: [{ data: pieValues, backgroundColor: colors }] },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' },
                    datalabels: { formatter: v => percent(pieValues, v) + '%', color: '#fff', font: { weight: 'bold' } }
                }
            },
            plugins: [ChartDataLabels]
        });
    }

    function createLineChart(canvasId, labels, datasets, yMax = 1.2) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return;
        if (window[canvasId] instanceof Chart) { window[canvasId].destroy(); window[canvasId] = null; }
        datasets.forEach(ds => {
            ds.borderWidth = 0.75; ds.pointRadius = 0; ds.pointHoverRadius = 2; ds.pointBorderWidth = 0; ds.tension = 0.1; ds.fill = false;
        });
        window[canvasId] = new Chart(canvas.getContext('2d'), {
            type: 'line',
            data: { labels: labels, datasets: datasets },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { position: 'top' } },
                scales: {
                    x: { type: 'linear', min: 0, max: 500, ticks: { stepSize: 100, autoSkip: false } },
                    y: { min: 0, max: yMax, ticks: { stepSize: 0.4, autoSkip: false } }
                }
            }
        });
    }

    function createLineChartFall(canvasId, labels, datasets, yMax = 1.2) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return;
        if (window[canvasId] instanceof Chart) { window[canvasId].destroy(); window[canvasId] = null; }
        datasets.forEach(ds => {
            ds.borderWidth = 0.75; ds.pointRadius = 0; ds.pointHoverRadius = 2; ds.pointBorderWidth = 0; ds.tension = 0.1; ds.fill = false;
        });
        window[canvasId] = new Chart(canvas.getContext('2d'), {
            type: 'line',
            data: { labels: labels, datasets: datasets },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { position: 'top' } },
                scales: {
                    x: { type: 'linear', min: 0, max: 750, ticks: { stepSize: 100, autoSkip: false } },
                    y: { min: 0, max: yMax, ticks: { stepSize: 0.4, autoSkip: false } }
                }
            }
        });
    }

    function renderFrictionCharts(frictions, formulaId) {
        if (!frictions) return;
        let n1 = frictions.n1 ?? [], n2 = frictions.n2 ?? [], n3 = frictions.n3 ?? [];
        let labels = [...new Set([...n1.map(x => x.Listno), ...n2.map(x => x.Listno), ...n3.map(x => x.Listno)])].sort((a, b) => a - b);

        function mapData(source, field) {
            return labels.map(label => {
                let rows = source.filter(x => x.Listno == label);
                if (!rows.length) return null;
                return rows.reduce((sum, row) => sum + parseFloat(row[field] ?? 0), 0) / rows.length;
            });
        }

        createLineChart(`chartU100-${formulaId}`, labels, [
            { label: 'N1 100°C (u)', data: mapData(n1, 'Friction100_u'), borderColor: '#1f77b4' },
            { label: 'N2 100°C (u)', data: mapData(n2, 'Friction100_u'), borderColor: '#2ca02c' },
            { label: 'N3 100°C (u)', data: mapData(n3, 'Friction100_u'), borderColor: '#9467bd' },
            { label: 'N1 100°c_(°c)', data: mapData(n1, 'Friction100_c').map(x => x / 4000), borderColor: '#d62728' },
            { label: 'N2 100°c_(°c)', data: mapData(n2, 'Friction100_c').map(x => x / 4000), borderColor: '#ff7f0e' },
            { label: 'N3 100°c_(°c)', data: mapData(n3, 'Friction100_c').map(x => x / 4000), borderColor: '#8c564b' }
        ]);
        createLineChart(`chartU150-${formulaId}`, labels, [
            { label: 'N1 150°C (u)', data: mapData(n1, 'Friction150_u'), borderColor: '#1f77b4' },
            { label: 'N2 150°C (u)', data: mapData(n2, 'Friction150_u'), borderColor: '#2ca02c' },
            { label: 'N3 150°C (u)', data: mapData(n3, 'Friction150_u'), borderColor: '#9467bd' },
            { label: 'N1 150°C (°C)', data: mapData(n1, 'Friction150_c').map(x => x / 4000), borderColor: '#d62728' },
            { label: 'N2 150°C (°C)', data: mapData(n2, 'Friction150_c').map(x => x / 4000), borderColor: '#ff7f0e' },
            { label: 'N3 150°C (°C)', data: mapData(n3, 'Friction150_c').map(x => x / 4000), borderColor: '#8c564b' }
        ]);
        createLineChart(`chartU200-${formulaId}`, labels, [
            { label: 'N1 200°C (u)', data: mapData(n1, 'Friction200_u'), borderColor: '#1f77b4' },
            { label: 'N2 200°C (u)', data: mapData(n2, 'Friction200_u'), borderColor: '#2ca02c' },
            { label: 'N3 200°C (u)', data: mapData(n3, 'Friction200_u'), borderColor: '#9467bd' },
            { label: 'N1 200°C (°C)', data: mapData(n1, 'Friction200_c').map(x => x / 4000), borderColor: '#d62728' },
            { label: 'N2 200°C (°C)', data: mapData(n2, 'Friction200_c').map(x => x / 4000), borderColor: '#ff7f0e' },
            { label: 'N3 200°C (°C)', data: mapData(n3, 'Friction200_c').map(x => x / 4000), borderColor: '#8c564b' }
        ]);
        createLineChart(`chartU250-${formulaId}`, labels, [
            { label: 'N1 250°C (u)', data: mapData(n1, 'Friction250_u'), borderColor: '#1f77b4' },
            { label: 'N2 250°C (u)', data: mapData(n2, 'Friction250_u'), borderColor: '#2ca02c' },
            { label: 'N3 250°C (u)', data: mapData(n3, 'Friction250_u'), borderColor: '#9467bd' },
            { label: 'N1 250°C (°C)', data: mapData(n1, 'Friction250_c').map(x => x / 4000), borderColor: '#d62728' },
            { label: 'N2 250°C (°C)', data: mapData(n2, 'Friction250_c').map(x => x / 4000), borderColor: '#ff7f0e' },
            { label: 'N3 250°C (°C)', data: mapData(n3, 'Friction250_c').map(x => x / 4000), borderColor: '#8c564b' }
        ]);
        createLineChart(`chartU300-${formulaId}`, labels, [
            { label: 'N1 300°C (u)', data: mapData(n1, 'Friction300_u'), borderColor: '#1f77b4' },
            { label: 'N2 300°C (u)', data: mapData(n2, 'Friction300_u'), borderColor: '#2ca02c' },
            { label: 'N3 300°C (u)', data: mapData(n3, 'Friction300_u'), borderColor: '#9467bd' },
            { label: 'N1 300°C (°C)', data: mapData(n1, 'Friction300_c').map(x => x / 4000), borderColor: '#d62728' },
            { label: 'N2 300°C (°C)', data: mapData(n2, 'Friction300_c').map(x => x / 4000), borderColor: '#ff7f0e' },
            { label: 'N3 300°C (°C)', data: mapData(n3, 'Friction300_c').map(x => x / 4000), borderColor: '#8c564b' }
        ]);
        createLineChart(`chartU350-${formulaId}`, labels, [
            { label: 'N1 350°C (u)', data: mapData(n1, 'Friction350_u'), borderColor: '#1f77b4' },
            { label: 'N2 350°C (u)', data: mapData(n2, 'Friction350_u'), borderColor: '#2ca02c' },
            { label: 'N3 350°C (u)', data: mapData(n3, 'Friction350_u'), borderColor: '#9467bd' },
            { label: 'N1 350°C (°C)', data: mapData(n1, 'Friction350_c').map(x => x / 4000), borderColor: '#d62728' },
            { label: 'N2 350°C (°C)', data: mapData(n2, 'Friction350_c').map(x => x / 4000), borderColor: '#ff7f0e' },
            { label: 'N3 350°C (°C)', data: mapData(n3, 'Friction350_c').map(x => x / 4000), borderColor: '#8c564b' }
        ]);
        createLineChartFall(`chartUfall-${formulaId}`, labels, [
            { label: 'N1 Fall°C (u)', data: mapData(n1, 'FrictionFall_u'), borderColor: '#1f77b4' },
            { label: 'N2 Fall°C (u)', data: mapData(n2, 'FrictionFall_u'), borderColor: '#2ca02c' },
            { label: 'N3 Fall°C (u)', data: mapData(n3, 'FrictionFall_u'), borderColor: '#9467bd' },
            { label: 'N1 Fall°C (°C)', data: mapData(n1, 'FrictionFall_c').map(x => x / 4000), borderColor: '#d62728' },
            { label: 'N2 Fall°C (°C)', data: mapData(n2, 'FrictionFall_c').map(x => x / 4000), borderColor: '#ff7f0e' },
            { label: 'N3 Fall°C (°C)', data: mapData(n3, 'FrictionFall_c').map(x => x / 4000), borderColor: '#8c564b' }
        ]);
    }

    function renderRadarChart(roadlist, formulaId) {
        if (!roadlist || roadlist.length === 0) return;
        const avg = field => {
            let vals = roadlist.map(x => parseFloat(x[field] || 0));
            return vals.length ? (vals.reduce((a,b)=>a+b,0) / vals.length) : 0;
        };
        let avgData = [avg('LowSpeed1'), avg('LowSpeed4'), avg('LowSpeed5'), avg('HighSpeed1'), avg('HighSpeed2'), avg('HighSpeed3'), avg('HighSpeed4'), avg('HighSpeed5'), avg('Pillion1'), avg('Pillion2')];
        let ctx = document.getElementById(`radarChart-${formulaId}`); if (!ctx) return;
        if (window[`radar_${formulaId}`]) window[`radar_${formulaId}`].destroy();

        window[`radar_${formulaId}`] = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['การรันอินสัมผัสแรก', 'เบรคความเร็วสูง', 'เสียงครืดขณะเบรค', 'การทนความร้อนสะสม', 'การฟื้นตัวหลังเฟด', 'การเบรคขณะเปียก', 'เสียงแหลมจี๊ดรบกวน', 'ฝุ่นจากการเบรค', 'สภาพจาน', 'สภาพผ้าเบรค'],
                datasets: [{ label: 'Average Result', data: avgData, fill: true, backgroundColor: 'rgba(13,110,253,0.2)', borderColor: 'rgba(13,110,253,1)', borderWidth: 2 }]
            },
            options: { responsive: true, maintainAspectRatio: false, scales: { r: { min: 0, max: 10, ticks: { stepSize: 2, backdropColor: 'transparent' } } } }
        });
    }

    function loadFormulaTable(formulaId, tableAreaId) {
        let formulaName = $('#' + formulaId).val();
        if (formulaName === '') {
            $('#' + tableAreaId).html(`<div class="text-center text-muted py-4">กรุณาเลือกสูตรเพื่อแสดงข้อมูล</div>`);
            return;
        }

        $.ajax({
            url: "{{ route('report.get.formula.detail') }}",
            type: "POST",
            data: { _token: "{{ csrf_token() }}", formula_name: formulaName },
            success: function (response) {
                $('#' + tableAreaId).show();
                let html = '';
                if (response.test && response.test.length > 0) {
                let t = response.test[0];
                html += `
                    <div class="mt-4">
                        <div class="card border-0 shadow rounded-4">
                            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Test Average Summary ${response.header?.ms_formule_name ?? '-'}: ${response.header?.chemistry_hd_name ?? '-'}</h6>
                                <button type="button" class="btn-close btn-close-white hide-summary-direct-btn" aria-label="Close"></button>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-6 mb-2"><div class="p-3 border rounded-3"><div class="text-muted small">Hardness (HRB)</div><div class="fs-5 fw-bold text-primary">${parseFloat(t.Hardness ?? 0).toFixed(2)}</div></div></div>
                                    <div class="col-md-6 mb-2"><div class="p-3 border rounded-3"><div class="text-muted small">Shearing (mm²)</div><div class="fs-5 fw-bold text-primary">${parseFloat(t.Shearing ?? 0).toFixed(2)}</div></div></div>
                                    <div class="col-md-6 mb-2"><div class="p-3 border rounded-3"><div class="text-muted small">Noise (dB)</div><div class="fs-5 fw-bold text-primary">${parseFloat(t.Noise ?? 0).toFixed(2)}</div></div></div>
                                    <div class="col-md-6 mb-2"><div class="p-3 border rounded-3"><div class="text-muted small">Normal (µ)</div><div class="fs-5 fw-bold text-primary">${parseFloat(t.Normal_Avg ?? 0).toFixed(2)}</div></div></div>
                                    <div class="col-md-6 mb-2"><div class="p-3 border rounded-3"><div class="text-muted small">Hot (µ)</div><div class="fs-5 fw-bold text-primary">${parseFloat(t.Hot_Avg ?? 0).toFixed(2)}</div></div></div>
                                    <div class="col-md-6 mb-2"><div class="p-3 border rounded-3"><div class="text-muted small">Wear (10⁻⁷cm³/(N·m))</div><div class="fs-5 fw-bold text-primary">${parseFloat(t.Wear_Avg ?? 0).toFixed(2)}</div></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

                html += `
                    <div class="mt-4">
                        <div class="card border-0 shadow rounded-4">
                            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Friction Analysis ${response.header?.ms_formule_name ?? '-'}: ${response.header?.chemistry_hd_name ?? '-'}</h6>
                                <button type="button" class="btn-close btn-close-white hide-formula-direct-btn" data-target="${formulaId.replace('formula_', '')}" aria-label="Close"></button>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-12"><canvas id="chartU100-${formulaId}" height="240"></canvas></div>
                                    <div class="col-md-12"><canvas id="chartU150-${formulaId}" height="240"></canvas></div>
                                    <div class="col-md-12"><canvas id="chartU200-${formulaId}" height="240"></canvas></div>
                                    <div class="col-md-12"><canvas id="chartU250-${formulaId}" height="240"></canvas></div>
                                    <div class="col-md-12"><canvas id="chartU300-${formulaId}" height="240"></canvas></div>
                                    <div class="col-md-12"><canvas id="chartU350-${formulaId}" height="240"></canvas></div>
                                    <div class="col-md-12"><canvas id="chartUfall-${formulaId}" height="240"></canvas></div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                if (response.test_detail && response.test_detail.length > 0) {
                    let grouped = {}; let samplesSet = new Set();
                    response.test_detail.forEach(item => {
                        samplesSet.add(item.SampleSet);
                        if (!grouped[item.Temperature]) grouped[item.Temperature] = [];
                        grouped[item.Temperature].push(item);
                    });
                    let samples = Array.from(samplesSet);

                    html += `
                        <div class="mt-4">
                            <div class="card border-0 shadow rounded-4">
                                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Wear / Temperature Analysis ${response.header?.ms_formule_name ?? '-'}: ${response.header?.chemistry_hd_name ?? '-'}</h6>
                                    <button type="button" class="btn-close btn-close-white hide-wear-direct-btn" aria-label="Close"></button>
                                </div>
                                <div class="card-body"><div class="table-responsive"><table class="table table-bordered text-center table-sm">
                                <thead><tr><th rowspan="2">Temperature</th><th colspan="${samples.length}">WearRate</th><th colspan="${samples.length}">T_Inc</th><th colspan="${samples.length}">T_Dec</th></tr><tr>`;
                    for (let i = 0; i < 3; i++) { samples.forEach(s => { html += `<th>${s}</th>`; }); }
                    html += `</tr></thead><tbody>`;
                    Object.keys(grouped).sort((a,b)=>a-b).forEach(temp => {
                        html += `<tr><td>${temp}</td>`;
                        const avgField = (rows, f, s) => { let fRow = rows.filter(r => r.SampleSet === s); return fRow.length ? (fRow.reduce((sum, r) => sum + parseFloat(r[f] || 0), 0) / fRow.length).toFixed(2) : '-'; };
                        samples.forEach(s => { html += `<td>${avgField(grouped[temp], 'WearRate', s)}</td>`; });
                        samples.forEach(s => { html += `<td>${avgField(grouped[temp], 'T_Inc', s)}</td>`; });
                        samples.forEach(s => { html += `<td>${avgField(grouped[temp], 'T_Dec', s)}</td>`; });
                        html += `</tr>`;
                    });
                    html += `</tbody></table></div></div></div></div>`;
                }

                let sumDensity = 0, sumAdjust = 0, sumWeight = 0, sumWeightPer = 0, sumWeightTotal = 0, sumWeightExcel = 0;
                let mixKg = parseFloat(response.header?.chemistry_hd_mix ?? 0);

                html += `
                    <div class="mb-2">
                        <h6 class="fw-bold mb-2">${response.header?.ms_formule_name ?? '-'} : ${response.header?.chemistry_hd_name ?? '-'} ( ${response.header?.avg_cost ?? '0'} ต่อกิโลกรัม )</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle table-sm-custom">
                            <thead class="table-light">
                                <tr><th width="40" class="text-center">#</th><th>Code</th><th>Material</th><th>Grade</th><th class="text-end">Density</th><th class="text-end">Vol.%</th><th class="text-end">Volume</th><th class="text-end">W(%)</th><th class="text-end">Weight(g)</th></tr>
                            </thead><tbody>
                `;

                if (response.details && response.details.length > 0) {
                    $.each(response.details, function (index, item) {
                        sumAdjust += parseFloat(item.adjust ?? 0); sumWeight += parseFloat(item.weght ?? 0); sumWeightPer += parseFloat(item.weghtper ?? 0); sumWeightTotal += parseFloat(item.weghttotal ?? 0); sumWeightExcel += parseFloat(item.weght ?? 0);
                        html += `<tr><td class="text-center">${index + 1}</td><td>${item.code ?? '-'}</td><td>${item.material ?? '-'}</td><td>${item.grade ?? '-'}</td><td class="text-end">${parseFloat(item.density ?? 0).toFixed(2)}</td><td class="text-end">${parseFloat(item.adjust ?? 0).toFixed(2)}</td><td class="text-end">${parseFloat(item.weght ?? 0).toFixed(2)}</td><td class="text-end">${parseFloat(item.weghtper ?? 0).toFixed(2)}</td><td class="text-end">${parseFloat(item.weghttotal ?? 0).toFixed(2)}</td></tr>`;
                    });
                    if (sumWeightExcel > 0) sumDensity = mixKg / sumWeightExcel;
                    html += `</tbody><tfoot><tr class="table-secondary fw-bold"><td colspan="4" class="text-end">Total</td><td class="text-end">${sumDensity.toFixed(2)}</td><td class="text-end">${sumAdjust.toFixed(2)}</td><td class="text-end">${sumWeight.toFixed(2)}</td><td class="text-end">${sumWeightPer.toFixed(2)}</td><td class="text-end">${sumWeightTotal.toFixed(2)}</td></tr></tfoot></table></div>`;
                } else {
                    html += `<tr><td colspan="9" class="text-center text-muted">ไม่พบข้อมูล</td></tr></tbody></table></div>`;
                }

                html += `<div class="mt-3"><h6 class="fw-bold">${response.header?.chemistry_hd_note ?? '-'}</h6></div>`;
                html += `
                    <div class="row mt-4 g-4">
                        <div class="col-md-12"><div class="card border-0 shadow rounded-4"><div class="card-header bg-white"><h5 class="mb-0 fw-bold">Density Analysis</h5></div><div class="card-body"><div style="height:300px;"><canvas id="donutChart-${formulaId}"></canvas></div></div></div></div>
                        <div class="col-md-12"><div class="card border-0 shadow rounded-4"><div class="card-header bg-white"><h5 class="mb-0 fw-bold">Weight Total Analysis</h5></div><div class="card-body"><div style="height:300px;"><canvas id="pieChart-${formulaId}"></canvas></div></div></div></div>
                    </div>
                    <div class="mt-4">
                        <div class="card border-0 shadow rounded-4">
                            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Performance Radar ${response.header?.ms_formule_name ?? '-'} : ${response.header?.chemistry_hd_name ?? '-'}</h6>
                                <button type="button" class="btn-close btn-close-white hide-radar-direct-btn" aria-label="Close"></button>
                            </div>
                                <div class="card-body">
                                    <div style="height:400px; max-width:600px; margin:auto;">
                                        <canvas id="radarChart-${formulaId}"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                `;

                let htmlRadarTable = `<div class="mt-4"><div class="card border-0 shadow rounded-4"><div class="card-body"><div class="table-responsive"><table class="table table-bordered table-sm text-center align-middle"><thead class="table-light"><tr><th style="width:120px;">คะแนนความพึงพอใจ</th><th>หมายเหตุ</th></tr></thead><tbody>`;
                if (response.roadlist && response.roadlist.length > 0) {
                    response.roadlist.forEach(row => { htmlRadarTable += `<tr><td class="fw-bold text-primary">${parseFloat(row.Avg5 ?? 0).toFixed(2)}</td><td class="text-start">${row.TestRoadName ?? '-'} : ${row.RoadTestRemark ?? '-'}</td></tr>`; });
                } else { htmlRadarTable += `<tr><td colspan="2" class="text-muted text-center">ไม่พบข้อมูล</td></tr>`; }
                htmlRadarTable += `</tbody></table></div></div></div></div>`;
                html += htmlRadarTable;

                $('#' + tableAreaId).html(html);

                setTimeout(() => {
                    renderCharts(response.details, formulaId);
                    renderFrictionCharts(response.frictions, formulaId);
                    renderRadarChart(response.roadlist, formulaId);
                }, 100);
            },
            error: function (xhr) {
                $('#' + tableAreaId).html(`<div class="alert alert-danger">เกิดข้อผิดพลาดในการโหลดข้อมูล</div>`);
            }
        });
    }

    $('#formula_1').on('change', function () { loadFormulaTable('formula_1', 'formula-table-area-1'); });
    $('#formula_2').on('change', function () { loadFormulaTable('formula_2', 'formula-table-area-2'); });
    $('#formula_3').on('change', function () { loadFormulaTable('formula_3', 'formula-table-area-3'); });

});
    $(document).on('click', '.hide-formula-direct-btn', function () {
        // ใช้ .closest() เพื่อวิ่งหา Card ชั้นนอกสุดของ Friction Analysis ตัวนี้แล้วสั่งเฟดซ่อนตัวไป
        $(this).closest('.card').parent().fadeOut(300);
    });
    $(document).on('click', '.hide-summary-direct-btn', function () {
        // วิ่งหา Card ชั้นนอกสุดของ Test Average Summary ตัวนี้แล้วสั่งเฟดซ่อนไป
        $(this).closest('.card').parent().fadeOut(300);
    });
    $(document).on('click', '.hide-wear-direct-btn', function () {
        // ค้นหาตัว Card แล้วสั่งปิดจางหายไปโดยไม่ยุ่งกับส่วนอื่น
        $(this).closest('.card').parent().fadeOut(300);
    });
    $(document).on('click', '.hide-radar-direct-btn', function () {
        $(this).closest('.card').parent().fadeOut(300);
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
.table-sm-custom th, .table-sm-custom td {
    padding: 4px 6px !important;
    white-space: nowrap;
    vertical-align: middle;
}
/* เพิ่มอนิเมชันให้เวลาเปลี่ยนจาก col-4 เป็น col-6 หรือ col-12 มีความสมูท */
.transition-grid .formula-card-wrapper {
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
/* สไตล์ปุ่มตอนกดซ่อนสูตร */
.toggle-formula-btn:not(.active) {
    background-color: #f8f9fa !important;
    color: #6c757d !important;
    border-color: #dee2e6 !important;
    opacity: 0.65;
}
</style>
@endpush