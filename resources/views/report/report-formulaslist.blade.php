@extends('layouts.main')

@section('content')
<div class="container-fluid">

    {{-- Header Title --}}
    <div class="card border-0 shadow-lg rounded-4 mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap g-2">
                <div>
                    <h2 class="fw-bold text-primary mb-1">
                        ตรวจสอบข้อมูลสูตรเคมี: <span class="text-dark">{{ $formulaNumber }}</span>
                    </h2>
                    <p class="text-muted mb-0">
                        แสดงประวัติและกราฟแนวโน้มผลการทดสอบทั้งหมด (พร้อมแสดงตัวเลขบนจุดกราฟ) จากตาราง TestHeaders
                    </p>
                </div>
                <div>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary rounded-3">
                        <i class="mdi mdi-arrow-left me-1"></i> ย้อนกลับ
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body pt-4">
            
            {{-- Charts Section: Group 1 (Hardness, Noise, Shearing) --}}
            <div class="row mb-3">
                <!-- Hardness Chart -->
                <div class="col-xl-4 col-md-12 mb-4">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0 fw-bold"><i class="mdi mdi-chart-line me-1"></i> กราฟ Hardness (HRB)</h6>
                        </div>
                        <div class="card-body">
                            <div style="height: 300px;">
                                <canvas id="hardnessLineChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Noise Chart -->
                <div class="col-xl-4 col-md-12 mb-4">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0 fw-bold"><i class="mdi mdi-chart-line me-1"></i> กราฟ Noise (dB)</h6>
                        </div>
                        <div class="card-body">
                            <div style="height: 300px;">
                                <canvas id="noiseLineChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shearing Chart -->
                <div class="col-xl-4 col-md-12 mb-4">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <div class="card-header bg-warning text-dark">
                            <h6 class="mb-0 fw-bold"><i class="mdi mdi-chart-line me-1"></i> กราฟ Shearing (mm²)</h6>
                        </div>
                        <div class="card-body">
                            <div style="height: 300px;">
                                <canvas id="shearingLineChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts Section: Group 2 (Normal_Avg, Hot_Avg, Wear_Avg) --}}
            <div class="row mb-3">
                <!-- Normal_Avg Chart -->
                <div class="col-xl-4 col-md-12 mb-4">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <div class="card-header bg-info text-dark">
                            <h6 class="mb-0 fw-bold"><i class="mdi mdi-chart-line me-1"></i> กราฟ Normal</h6>
                        </div>
                        <div class="card-body">
                            <div style="height: 300px;">
                                <canvas id="normalAvgLineChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hot_Avg Chart -->
                <div class="col-xl-4 col-md-12 mb-4">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <div class="card-header bg-danger text-white">
                            <h6 class="mb-0 fw-bold"><i class="mdi mdi-chart-line me-1"></i> กราฟ Hot</h6>
                        </div>
                        <div class="card-body">
                            <div style="height: 300px;">
                                <canvas id="hotAvgLineChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wear_Avg Chart -->
                <div class="col-xl-4 col-md-12 mb-4">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0 fw-bold"><i class="mdi mdi-chart-line me-1"></i> กราฟ Wear</h6>
                        </div>
                        <div class="card-body">
                            <div style="height: 300px;">
                                <canvas id="wearAvgLineChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts Section: Group 3 (Monthly Temperature Friction AVG Chart - ปีปัจจุบัน) --}}
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card border-0 shadow rounded-4 h-100">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0 fw-bold"><i class="mdi mdi-chart-timeline-variant me-1"></i> กราฟค่าเฉลี่ย Friction รายเดือน (แกนX: อุณหภูมิ / เส้น: เดือน) ประจำปี 2026</h6>
                        </div>
                        <div class="card-body">
                            <div style="height: 400px;">
                                <canvas id="monthlyTemperatureChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Test Headers Data Table Section --}}
            <div class="card border-0 shadow rounded-4 mt-2">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0 fw-bold">
                        <i class="mdi mdi-table me-2"></i> ประวัติการทดสอบทั้งหมดของสูตร {{ $formulaNumber }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle table-sm-custom text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>วันที่ทดสอบ</th>
                                    <th>Hardness</th>
                                    <th>Noise</th>
                                    <th>Shearing</th>
                                    <th>Normal</th>
                                    <th>Hot</th>
                                    <th>Wear</th>
                                    <th>หมายเหตุ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tests as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->TestDate ? \Carbon\Carbon::parse($item->TestDate)->format('d/m/Y') : '-' }}</td>
                                        <td>{{ number_format((float)($item->Hardness ?? 0), 2) }}</td>
                                        <td>{{ number_format((float)($item->Noise ?? 0), 2) }}</td>
                                        <td>{{ number_format((float)($item->Shearing ?? 0), 2) }}</td>
                                        <td class="fw-bold text-info">{{ $item->Normal_Avg !== null ? number_format((float)$item->Normal_Avg, 4) : '-' }}</td>
                                        <td class="fw-bold text-danger">{{ $item->Hot_Avg !== null ? number_format((float)$item->Hot_Avg, 4) : '-' }}</td>
                                        <td class="fw-bold text-secondary">{{ $item->Wear_Avg !== null ? number_format((float)$item->Wear_Avg, 4) : '-' }}</td>
                                        <td class="text-start">{{ $item->Remarks ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">ไม่พบข้อมูลประวัติการทดสอบสำหรับ FormulaNumber นี้</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- TestFrictions Combined Charts Section (แสดงเฉพาะ TestID ที่มีข้อมูล) --}}
            <div class="card border-0 shadow rounded-4 mt-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0 fw-bold">
                        <i class="mdi mdi-chart-multiline me-2"></i> กราฟรวมค่า Friction (100°C ถึง Fall) แยกตามแต่ละ TestID
                    </h5>
                </div>
                <div class="card-body">
                    @php $hasAnyFrictionChart = false; @endphp

                    @foreach($tests as $index => $item)
                        @php 
                            $cleanId = preg_replace('/[^a-zA-Z0-9]/', '_', $item->TestID); 
                            $testFrictions = $frictionsByTest[$item->TestID] ?? ['n1' => [], 'n2' => [], 'n3' => []];
                            $hasData = !empty($testFrictions['n1']) || !empty($testFrictions['n2']) || !empty($testFrictions['n3']);
                        @endphp

                        @if($hasData)
                            @php $hasAnyFrictionChart = true; @endphp
                            <div class="card border shadow-sm rounded-4 mb-4 p-3">
                                <h5 class="fw-bold text-dark mb-3">
                                    <i class="mdi mdi-identifier text-primary"></i> TestID: {{ $item->TestID }} 
                                    <span class="text-muted fs-6 ms-2">(วันที่: {{ $item->TestDate ? \Carbon\Carbon::parse($item->TestDate)->format('d/m/Y') : '-' }})</span>
                                </h5>

                                <div style="height: 350px;">
                                    <canvas id="chartCombined-{{ $cleanId }}"></canvas>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    @if(!$hasAnyFrictionChart)
                        <div class="text-center text-muted py-4">ไม่พบข้อมูล TestFrictions สำหรับแสดงกราฟในทุก TestID</div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scriptjs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Custom Plugin สำหรับแสดงตัวเลขบนจุดกราฟ (Data Labels)
const valueLabelsPlugin = {
    id: 'valueLabelsPlugin',
    afterDatasetsDraw(chart) {
        const { ctx, data } = chart;
        ctx.save();
        ctx.font = 'bold 10px sans-serif';
        ctx.fillStyle = '#333333';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'bottom';

        chart.data.datasets.forEach((dataset, datasetIndex) => {
            const meta = chart.getDatasetMeta(datasetIndex);
            if (!meta.hidden) {
                meta.data.forEach((element, index) => {
                    let value = dataset.data[index];
                    if (value !== null && value !== undefined) {
                        let text = Number(value).toFixed(2);
                        let position = element.tooltipPosition();
                        ctx.fillText(text, position.x, position.y - 6);
                    }
                });
            }
        });
        ctx.restore();
    }
};

// ฟังก์ชันสร้างกราฟ Friction รวมเฉพาะ N1, N2, N3 พร้อมตั้งค่าสเกล Y (0.15 - 0.55)
function renderCombinedFrictionChart(frictions, cleanId) {
    if (!frictions) return;
    let n1 = frictions.n1 ?? [], n2 = frictions.n2 ?? [], n3 = frictions.n3 ?? [];

    let temperatureLabels = ['100°C', '150°C', '200°C', '250°C', '300°C', '350°C', 'Fall'];
    let fields = ['Friction100_u', 'Friction150_u', 'Friction200_u', 'Friction250_u', 'Friction300_u', 'Friction350_u', 'FrictionFall_u'];

    function getTemperatureData(rows) {
        return fields.map(field => {
            if (!rows || rows.length === 0) return null;
            let sum = rows.reduce((acc, row) => acc + parseFloat(row[field] ?? 0), 0);
            return sum / rows.length;
        });
    }

    let dataN1 = getTemperatureData(n1);
    let dataN2 = getTemperatureData(n2);
    let dataN3 = getTemperatureData(n3);

    let ctx = document.getElementById(`chartCombined-${cleanId}`);
    if (!ctx) return;

    new Chart(ctx.getContext('2d'), {
        type: 'line',
        data: {
            labels: temperatureLabels,
            datasets: [
                { label: 'N1 (u)', data: dataN1, borderColor: '#1f77b4', backgroundColor: 'rgba(31, 119, 180, 0.1)', borderWidth: 1, tension: 0.1 },
                { label: 'N2 (u)', data: dataN2, borderColor: '#2ca02c', backgroundColor: 'rgba(44, 160, 44, 0.1)', borderWidth: 1, tension: 0.1 },
                { label: 'N3 (u)', data: dataN3, borderColor: '#9467bd', backgroundColor: 'rgba(148, 103, 189, 0.1)', borderWidth: 1, tension: 0.1 }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: true, position: 'top' },
                title: { display: true, text: 'แนวโน้มค่า Friction (u) เปรียบเทียบตามอุณหภูมิ' }
            },
            scales: { 
                y: { 
                    min: 0.00,           
                    max: 0.70,           
                    ticks: {
                        stepSize: 0.10,  
                        callback: function(value) {
                            return Number(value).toFixed(2); 
                        }
                    }
                } 
            }
        },
        plugins: [valueLabelsPlugin]
    });
}

document.addEventListener("DOMContentLoaded", function () {
    let testData = @json($tests ?? []);
    let frictionsByTest = @json($frictionsByTest ?? []);

    if (testData && testData.length > 0) {
        let labels = testData.map(item => {
            if (!item.TestDate) return '-';
            let date = new Date(item.TestDate);
            return date.toLocaleDateString('th-TH', { day: '2-digit', month: '2-digit', year: 'numeric' });
        });

        // 1. Hardness Chart
        new Chart(document.getElementById('hardnessLineChart').getContext('2d'), {
            type: 'line',
            data: { labels: labels, datasets: [{ label: 'Hardness (Avg)', data: testData.map(i => parseFloat(i.Hardness || 0)), borderColor: '#0d6efd', backgroundColor: 'rgba(13, 110, 253, 0.1)', borderWidth: 2, tension: 0.1, fill: true }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: true, position: 'top' } }, scales: { y: { beginAtZero: false } } },
            plugins: [valueLabelsPlugin]
        });

        // 2. Noise Chart
        new Chart(document.getElementById('noiseLineChart').getContext('2d'), {
            type: 'line',
            data: { labels: labels, datasets: [{ label: 'Noise (Avg)', data: testData.map(i => parseFloat(i.Noise || 0)), borderColor: '#198754', backgroundColor: 'rgba(25, 135, 84, 0.1)', borderWidth: 2, tension: 0.1, fill: true }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: true, position: 'top' } }, scales: { y: { beginAtZero: false } } },
            plugins: [valueLabelsPlugin]
        });

        // 3. Shearing Chart
        new Chart(document.getElementById('shearingLineChart').getContext('2d'), {
            type: 'line',
            data: { labels: labels, datasets: [{ label: 'Shearing (Avg)', data: testData.map(i => parseFloat(i.Shearing || 0)), borderColor: '#ffc107', backgroundColor: 'rgba(255, 193, 7, 0.1)', borderWidth: 2, tension: 0.1, fill: true }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: true, position: 'top' } }, scales: { y: { beginAtZero: false } } },
            plugins: [valueLabelsPlugin]
        });

        // 4. Normal_Avg Chart
        new Chart(document.getElementById('normalAvgLineChart').getContext('2d'), {
            type: 'line',
            data: { labels: labels, datasets: [{ label: 'Normal (Avg)', data: testData.map(i => parseFloat(i.Normal_Avg || 0)), borderColor: '#0dcaf0', backgroundColor: 'rgba(13, 202, 240, 0.1)', borderWidth: 2, tension: 0.1, fill: true }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: true, position: 'top' } }, scales: { y: { beginAtZero: false } } },
            plugins: [valueLabelsPlugin]
        });

        // 5. Hot_Avg Chart
        new Chart(document.getElementById('hotAvgLineChart').getContext('2d'), {
            type: 'line',
            data: { labels: labels, datasets: [{ label: 'Hot (Avg)', data: testData.map(i => parseFloat(i.Hot_Avg || 0)), borderColor: '#dc3545', backgroundColor: 'rgba(220, 53, 69, 0.1)', borderWidth: 2, tension: 0.1, fill: true }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: true, position: 'top' } }, scales: { y: { beginAtZero: false } } },
            plugins: [valueLabelsPlugin]
        });

        // 6. Wear_Avg Chart
        new Chart(document.getElementById('wearAvgLineChart').getContext('2d'), {
            type: 'line',
            data: { labels: labels, datasets: [{ label: 'Wear (Avg)', data: testData.map(i => parseFloat(i.Wear_Avg || 0)), borderColor: '#6c757d', backgroundColor: 'rgba(108, 117, 125, 0.1)', borderWidth: 2, tension: 0.1, fill: true }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: true, position: 'top' } }, scales: { y: { beginAtZero: false } } },
            plugins: [valueLabelsPlugin]
        });
    }

    // 7. Monthly Temperature Friction AVG Chart (แกน X = อุณหภูมิ, เส้น Dataset = เดือน) ประจำปี 2026
    let temperatureLabels = ['100°C', '150°C', '200°C', '250°C', '300°C', '350°C', 'Fall'];
    let fields = ['Friction100_u', 'Friction150_u', 'Friction200_u', 'Friction250_u', 'Friction300_u', 'Friction350_u', 'FrictionFall_u'];
    let monthNames = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
    let currentYear = new Date().getFullYear();

    let monthTempData = Array.from({ length: 12 }, () => Array.from({ length: fields.length }, () => ({ sum: 0, count: 0 })));

    if (testData && testData.length > 0) {
        testData.forEach(item => {
            if (!item.TestDate) return;
            let date = new Date(item.TestDate);
            if (date.getFullYear() === currentYear) {
                let month = date.getMonth(); // 0-11
                let frictions = frictionsByTest[item.TestID];
                if (frictions) {
                    let allRows = [...(frictions.n1 || []), ...(frictions.n2 || []), ...(frictions.n3 || [])];
                    if (allRows.length > 0) {
                        fields.forEach((field, fIndex) => {
                            allRows.forEach(row => {
                                if (row[field] !== null && row[field] !== undefined) {
                                    monthTempData[month][fIndex].sum += parseFloat(row[field]);
                                    monthTempData[month][fIndex].count++;
                                }
                            });
                        });
                    }
                }
            }
        });
    }

    let monthColors = [
        '#1f77b4', '#aec7e8', '#ff7f0e', '#ffbb78', 
        '#2ca02c', '#98df8a', '#d62728', '#ff9896', 
        '#9467bd', '#c5b0d5', '#8c564b', '#e377c2'
    ];

    let monthlyDatasets = [];
    for (let m = 0; m < 12; m++) {
        let hasDataInMonth = monthTempData[m].some(item => item.count > 0);
        if (hasDataInMonth) {
            let dataPoints = fields.map((f, fIndex) => {
                let cell = monthTempData[m][fIndex];
                return cell.count > 0 ? cell.sum / cell.count : null;
            });

            monthlyDatasets.push({
                label: monthNames[m] + ' ' + currentYear,
                data: dataPoints,
                borderColor: monthColors[m],
                backgroundColor: 'transparent',
                borderWidth: 1, 
                tension: 0.1,
                spanGaps: true
            });
        }
    }

    new Chart(document.getElementById('monthlyTemperatureChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: temperatureLabels,
            datasets: monthlyDatasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: true, position: 'top' },
                title: { display: true, text: 'แนวโน้มค่าเฉลี่ย Friction แยกตามเดือน (แกน X: อุณหภูมิ) ประจำปี ' + currentYear }
            },
            scales: { 
                y: { 
                    min: 0.00,
                    max: 0.70,
                    ticks: {
                        stepSize: 0.10,
                        callback: function(value) {
                            return Number(value).toFixed(2);
                        }
                    }
                } 
            }
        },
        plugins: [valueLabelsPlugin]
    });

    // วนลูปเรนเดอร์กราฟ Friction รวมของแต่ละ TestID ที่มีข้อมูล
    for (let testId in frictionsByTest) {
        let cleanId = testId.replace(/[^a-zA-Z0-9]/g, '_');
        renderCombinedFrictionChart(frictionsByTest[testId], cleanId);
    }
});
</script>

<style>
.table-sm-custom {
    font-size: 12px;
}
.table-sm-custom th, .table-sm-custom td {
    padding: 8px 10px !important;
    vertical-align: middle;
}
</style>
@endpush