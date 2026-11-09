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

    <!-- ส่วนหัวข้อและฟิลเตอร์ค้นหาช่วงวันที่ตามเครื่องจักร/แม่พิมพ์ -->
    <div class="card border-0 shadow-sm mb-4 d-print-none">
        <div class="card-body p-3">
            <div class="row align-items-center">
                <div class="col-12 col-md-4">
                    <h5 class="fw-bold text-primary mb-0">
                        รายงานความหนาแน่นของดิสเบรก: {{ $type == 'แม่พิมพ์' ? 'แม่พิมพ์' : 'เครื่องจักร' }} {{ $id ?? '-' }}
                    </h5>
                </div>
                <div class="col-12 col-md-8">
                    <div class="row g-2 align-items-end justify-content-md-end">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label small mb-1">จากวันที่:</label>
                            <input type="date" id="start_date" class="form-control form-control-sm" value="{{ $startDate ?? now()->startOfMonth()->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label small mb-1">ถึงวันที่:</label>
                            <input type="date" id="end_date" class="form-control form-control-sm" value="{{ $endDate ?? now()->endOfMonth()->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-4">
                            <button type="button" id="btn-filter" class="btn btn-sm btn-primary me-1"><i class="fas fa-search me-1"></i> ค้นหา</button>
                            <button type="button" id="btn-reset" class="btn btn-sm btn-secondary"><i class="fas fa-redo me-1"></i> รีเซ็ต</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- วนลูปแสดงผลใบรายงานทั้งหมดที่ค้นหาได้ -->
    @forelse ($hd as $index => $headerItem)
    <div class="card border-0 shadow-sm print-card mb-4">
        
        <!-- ส่วนหัวการ์ด (สามารถคลิกเพื่อพับ/ขยายได้) -->
        <div class="card-header bg-light d-flex justify-content-between align-items-center py-2" 
             data-bs-toggle="collapse" 
             data-bs-target="#collapseCard-{{ $headerItem->density_workpiece_hds_id }}" 
             aria-expanded="true" 
             aria-controls="collapseCard-{{ $headerItem->density_workpiece_hds_id }}" 
             style="cursor: pointer;">
            <div class="col-8">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="fas fa-chevron-down toggle-icon me-2 transition-icon"></i>
                    ใบรายงานการตรวจสอบความหนาแน่นของดิสเบรก (รายการที่ {{ $index + 1 }})
                </h5>
                <small class="text-muted ms-4">วันที่: {{ $headerItem->density_workpiece_hds_date }} | 
                    Product: {{ $headerItem->product_name }} ({{ $headerItem->product_code }}) | 
                    Machinery: {{ $headerItem->machinery_name }}
                </small>
            </div>
            <div class="col-4 text-end d-print-none" onclick="event.stopPropagation();">
                <a href="{{ route('density-workpiece.edit', $headerItem->density_workpiece_hds_id) }}" class="btn btn-sm btn-warning me-1">
                    <i class="fas fa-edit me-1"></i> แก้ไขรายการนี้
                </a>
                <button type="button" class="btn btn-secondary btn-sm" onclick="window.print()">
                    <i class="mdi mdi-printer me-1"></i> พิมพ์
                </button>
            </div>
        </div>

        <!-- ส่วนเนื้อหาที่สามารถพับได้ -->
        <div id="collapseCard-{{ $headerItem->density_workpiece_hds_id }}" class="collapse show">
            <div class="card-body p-3">
                
                <!-- ข้อมูลทั่วไป (Header Info) -->
                <div class="row g-2 mb-2 bg-light p-2 rounded border small">
                    <div class="col-3 col-md-3">
                        <span class="text-muted">Area:</span> <span class="fw-semibold">{{ $headerItem->mlod_area }} cm²</span>
                    </div>
                    <div class="col-3 col-md-3">
                        <span class="text-muted">Pressure:</span> <span class="fw-semibold">{{ $headerItem->mlod_pressure }}</span>
                    </div>
                    <div class="col-3 col-md-3">
                        <span class="text-muted">Weight:</span> <span class="fw-semibold">{{ $headerItem->chemical_weight }}</span>
                    </div>
                    <div class="col-3 col-md-3">
                        <span class="text-muted">Temp:</span> <span class="fw-semibold">{{ $headerItem->chemical_temp }}</span>
                    </div>

                    <div class="col-3 col-md-3">
                        <span class="text-muted">Formule:</span> <span class="fw-semibold">{{ $headerItem->ms_formule_name }}</span>            
                    </div>
                    <div class="col-3 col-md-3">
                        <span class="text-muted">Number:</span> <span class="fw-semibold">{{ $headerItem->chemistry_hd_name }}</span>
                    </div>
                    <div class="col-3 col-md-3">
                        <span class="text-muted">Target Density:</span> <span class="fw-bold text-primary" id="target-density-{{ $headerItem->density_workpiece_hds_id }}">{{ $headerItem->total_density }}</span>
                    </div>
                    <div class="col-3 col-md-3">
                        <span class="text-muted">Date:</span> <span class="fw-semibold">{{ $headerItem->density_workpiece_hds_date }}</span>
                    </div>

                    <div class="col-3 col-md-3 mt-2">
                        <span class="text-muted">Upper Density:</span> 
                        <span class="fw-bold text-success" id="upper-density-{{ $headerItem->density_workpiece_hds_id }}">{{ isset($headerItem->upper_density) ? number_format($headerItem->upper_density, 4, '.', '') : '' }}</span>
                    </div>
                    <div class="col-3 col-md-3 mt-2">
                        <span class="text-muted">Lower Density:</span> 
                        <span class="fw-bold text-danger" id="lower-density-{{ $headerItem->density_workpiece_hds_id }}">{{ isset($headerItem->lower_density) ? number_format($headerItem->lower_density, 4, '.', '') : '' }}</span>
                    </div>
                    <div class="col-6 col-md-6 mt-2">
                        <span class="text-muted">Note:</span> 
                        <span class="fw-bold">{{ $headerItem->density_workpiece_hds_note ?? '-' }}</span>
                    </div>
                </div>

                @php
                    $dtList = DB::table('density_workpiece_dts')
                        ->where('density_workpiece_hds_id', $headerItem->density_workpiece_hds_id)
                        ->get();
                @endphp

                <!-- ตารางข้อมูลชิ้นงาน (Cavities) -->
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
                                <th colspan="3">Hardness</th>
                            </tr>
                            <tr>
                                <th>น้ำหนัก (g)</th>
                                <th>ความหนา (mm)</th>
                                <th>น้ำหนัก (g)</th>
                                <th>ความหนา (mm)</th>
                                <th>น้ำหนัก (g)</th>
                                <th>ความหนา (mm)</th>
                                <th>1</th>
                                <th>2</th>
                                <th>3</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dtList as $dtItem)
                            <tr class="cavity-row">
                                <td class="fw-bold bg-light">{{ $dtItem->density_workpiece_dts_listno }}</td>
                                <td>{{ number_format($dtItem->weight_1, 2) }}</td>
                                <td>{{ number_format($dtItem->thickness_1, 2) }}</td>
                                <td>{{ number_format($dtItem->weight_2, 2) }}</td>
                                <td>{{ number_format($dtItem->thickness_2, 2) }}</td>
                                <td>{{ number_format($dtItem->weight_3, 2) }}</td>
                                <td>{{ number_format($dtItem->thickness_3, 2) }}</td>
                                <td>{{ number_format($dtItem->weight_chemical, 2) }}</td>
                                <td>{{ number_format($dtItem->thickness_chemical, 2) }}</td>
                                <td>{{ number_format($dtItem->density_workpiece_dts_volume, 2) }}</td>
                                <td class="fw-bold text-primary val-density">{{ number_format($dtItem->density_workpiece_dts_density, 4) }}</td>
                                <td class="val-porosity">{{ number_format($dtItem->density_workpiece_dts_porosity, 2) }}</td>
                                <td class="val-side">{{ $dtItem->product_sides }}</td>
                                <td class="val-h1">{{ number_format($dtItem->hardness_1, 1) }}</td>
                                <td class="val-h2">{{ number_format($dtItem->hardness_2, 1) }}</td>
                                <td class="val-h3">{{ number_format($dtItem->hardness_3, 1) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="16" class="text-muted">ไม่พบข้อมูลรายละเอียดในรายการนี้</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- ส่วนแสดงกราฟ (Chart.js Dashboard) -->
                @if(count($dtList) > 0)
                <div class="row mt-4">
                    <div class="col-12 mb-3">
                        <div class="card border shadow-sm print-chart-card">
                            <div class="card-body">
                                <h6 class="fw-bold text-dark mb-2">กราฟเปรียบเทียบ Density กับ Target, Upper และ Lower</h6>
                                <canvas id="densityChart-{{ $headerItem->density_workpiece_hds_id }}" height="90"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="card border shadow-sm print-chart-card">
                            <div class="card-body">
                                <h6 class="fw-bold text-dark mb-2">กราฟแนวโน้ม %Porosity</h6>
                                <canvas id="porosityChart-{{ $headerItem->density_workpiece_hds_id }}" height="90"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="card border shadow-sm print-chart-card">
                            <div class="card-body">
                                <h6 class="fw-bold text-dark mb-2">กราฟค่าความแข็ง (Hardness Average & Points 1, 2, 3)</h6>
                                <canvas id="hardnessChart-{{ $headerItem->density_workpiece_hds_id }}" height="90"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-warning text-center">ไม่พบข้อมูลความหนาแน่นของดิสเบรกสำหรับข้อมูลนี้ในช่วงวันที่ดังกล่าว</div>
    </div>
    @endforelse
</div>
@endsection

@push('scriptjs')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<style>
    /* เอฟเฟกต์หมุนลูกศรเวลาพับ/กางการ์ด */
    .transition-icon {
        transition: transform 0.3s ease;
    }
    .collapsed .toggle-icon {
        transform: rotate(-90deg);
    }

    @media print {
        @page { size: A4 landscape; margin: 5mm; }
        body { margin: 0; padding: 0; -webkit-print-color-adjust: exact; }
        body * { visibility: hidden; }
        .print-card, .print-card * { visibility: visible; }
        .print-card { position: absolute; left: 0; top: 0; width: 100%; border: none !important; box-shadow: none !important; padding: 0 !important; }
        button, .btn, .alert { display: none !important; }
        
        /* บังคับให้ตอนสั่งพิมพ์ กางเนื้อหาออกทั้งหมดอัตโนมัติ ไม่ให้ถูกพับซ่อน */
        .collapse {
            display: block !important;
            height: auto !important;
            visibility: visible !important;
        }

        table.print-table { font-size: 9px !important; width: 100% !important; border-collapse: collapse !important; }
        table.print-table th, table.print-table td { padding: 2px 3px !important; border: 1px solid #333 !important; }
        .print-chart-card { border: 1px solid #ddd !important; box-shadow: none !important; margin-top: 10px !important; page-break-inside: avoid; }
        .print-chart-card canvas { width: 100% !important; height: auto !important; max-height: 140px !important; }
        .table-responsive { overflow: visible !important; }
        tr { page-break-inside: avoid; page-break-after: auto; }
    }
</style>

<script>
$(document).ready(function() {
    @foreach ($hd as $headerItem)
        @if(DB::table('density_workpiece_dts')->where('density_workpiece_hds_id', $headerItem->density_workpiece_hds_id)->count() > 0)
            renderChartsForCard("{{ $headerItem->density_workpiece_hds_id }}");
        @endif
    @endforeach

    // จัดการสลับคลาส CSS ของลูกศรเวลาพับการ์ด
    $('.card-header').on('click', function() {
        $(this).toggleClass('collapsed');
    });

    // ปุ่มค้นหาช่วงวันที่ (รองรับทั้ง เครื่อง และ แม่พิมพ์)
    $('#btn-filter').click(function() {
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();
        let id = "{{ $id ?? '' }}";
        let type = "{{ $type ?? 'เครื่อง' }}"; 
        
        window.location.href = `{{ url('density-workpiece') }}/${encodeURIComponent(id)}?type=${encodeURIComponent(type)}&start_date=${startDate}&end_date=${endDate}`;
    });

    // ปุ่มรีเซ็ต (รองรับทั้ง เครื่อง และ แม่พิมพ์)
    $('#btn-reset').click(function() {
        let id = "{{ $id ?? '' }}";
        let type = "{{ $type ?? 'เครื่อง' }}"; 
        
        window.location.href = `{{ url('density-workpiece') }}/${encodeURIComponent(id)}?type=${encodeURIComponent(type)}`;
    });
});

function renderChartsForCard(hdsId) {
    let cardElement = document.getElementById(`densityChart-${hdsId}`).closest('.print-card');
    if (!cardElement) return;

    let labels = [];
    let densityData = [];
    let porosityData = [];
    let targetData = [];
    let upperData = [];
    let lowerData = [];
    let sidesData = [];

    let hAvgData = [];
    let h1Data = [];
    let h2Data = [];
    let h3Data = [];

    let targetDensity = parseFloat($(`#target-density-${hdsId}`).text()) || 0;
    let upperVal = parseFloat($(`#upper-density-${hdsId}`).text()) || null;
    let lowerVal = parseFloat($(`#lower-density-${hdsId}`).text()) || null;

    $(cardElement).find('.cavity-row').each(function(index) {
        let rowNum = $(this).find('td:first').text().trim();
        labels.push('C' + rowNum);

        let density = parseFloat($(this).find('.val-density').text()) || 0;
        let porosity = parseFloat($(this).find('.val-porosity').text()) || 0;
        let side = $(this).find('.val-side').text().trim();
        let h1 = parseFloat($(this).find('.val-h1').text()) || 0;
        let h2 = parseFloat($(this).find('.val-h2').text()) || 0;
        let h3 = parseFloat($(this).find('.val-h3').text()) || 0;

        let validH = [h1, h2, h3].filter(v => v > 0);
        let hAvg = validH.length > 0 ? (validH.reduce((a, b) => a + b, 0) / validH.length) : 0;

        densityData.push(density);
        porosityData.push(porosity);
        targetData.push(targetDensity);
        if(upperVal !== null) upperData.push(upperVal);
        if(lowerVal !== null) lowerData.push(lowerVal);
        sidesData.push(side);

        h1Data.push(h1);
        h2Data.push(h2);
        h3Data.push(h3);
        hAvgData.push(hAvg);
    });

    const backgroundColors = sidesData.map(side => {
        if (side === 'ซ้าย') return 'rgba(54, 162, 235, 0.7)';
        if (side === 'ขวา') return 'rgba(255, 159, 64, 0.7)';
        if (side === 'ซ้าย-ขวา') return 'rgba(153, 102, 255, 0.7)';
        return 'rgba(201, 203, 207, 0.7)';
    });

    const borderColors = sidesData.map(side => {
        if (side === 'ซ้าย') return 'rgba(54, 162, 235, 1)';
        if (side === 'ขวา') return 'rgba(255, 159, 64, 1)';
        if (side === 'ซ้าย-ขวา') return 'rgba(153, 102, 255, 1)';
        return 'rgba(201, 203, 207, 1)';
    });

    // 1. กราฟ Density
    const ctxDensity = document.getElementById(`densityChart-${hdsId}`);
    if (ctxDensity) {
        let densityDatasets = [
            { label: 'Actual Density', data: densityData, backgroundColor: backgroundColors, borderColor: borderColors, borderWidth: 1, order: 2 },
            { label: 'Target Density', data: targetData, type: 'line', borderColor: 'rgba(255, 99, 132, 1)', borderWidth: 2, fill: false, pointRadius: 0, order: 1, datalabels: { display: false } }
        ];

        if(upperVal !== null) {
            densityDatasets.push({ label: 'Upper Density', data: upperData, type: 'line', borderColor: 'rgba(40, 167, 69, 1)', borderWidth: 2, borderDash: [5, 5], fill: false, pointRadius: 0, order: 1, datalabels: { display: false } });
        }
        if(lowerVal !== null) {
            densityDatasets.push({ label: 'Lower Density', data: lowerData, type: 'line', borderColor: 'rgba(220, 53, 69, 1)', borderWidth: 2, borderDash: [5, 5], fill: false, pointRadius: 0, order: 1, datalabels: { display: false } });
        }

        new Chart(ctxDensity.getContext('2d'), {
            type: 'bar',
            data: { labels: labels, datasets: densityDatasets },
            options: {
                responsive: true,
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: function(value, context) {
                            if (context.datasetIndex === 0) {
                                let index = context.dataIndex;
                                return (sidesData[index] || '') + '\n' + value.toFixed(4);
                            }
                            return '';
                        },
                        font: { size: 9, weight: 'bold' },
                        color: '#333'
                    }
                },
                scales: { y: { beginAtZero: false, grace: '15%' } }
            },
            plugins: [ChartDataLabels]
        });
    }

    // 2. กราฟ %Porosity
    const ctxPorosity = document.getElementById(`porosityChart-${hdsId}`);
    if (ctxPorosity) {
        let maxLimit = 5.0;
        let limitData = new Array(labels.length).fill(maxLimit);
        let pointColors = porosityData.map(val => val > maxLimit ? 'rgba(220, 53, 69, 1)' : 'rgba(75, 192, 192, 1)');
        let pointRadius = porosityData.map(val => val > maxLimit ? 5 : 3);

        new Chart(ctxPorosity.getContext('2d'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    { label: '%Porosity', data: porosityData, borderColor: 'rgba(75, 192, 192, 1)', backgroundColor: 'rgba(75, 192, 192, 0.2)', pointBackgroundColor: pointColors, pointBorderColor: pointColors, pointRadius: pointRadius, borderWidth: 2, tension: 0.1, fill: true, order: 2 },
                    { label: 'Max Limit (5.0%)', data: limitData, type: 'line', borderColor: 'rgba(255, 99, 132, 1)', borderWidth: 2, borderDash: [5, 5], fill: false, pointRadius: 0, order: 1, datalabels: { display: false } }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    datalabels: {
                        align: 'top',
                        formatter: function(value, context) {
                            if (context.datasetIndex === 0) return value.toFixed(2) + '%';
                            return '';
                        },
                        font: { size: 9, weight: 'bold' },
                        color: '#333'
                    }
                },
                scales: { y: { beginAtZero: true, grace: '15%' } }
            },
            plugins: [ChartDataLabels]
        });
    }

    // 3. กราฟ Hardness
    const ctxHardness = document.getElementById(`hardnessChart-${hdsId}`);
    if (ctxHardness) {
        new Chart(ctxHardness.getContext('2d'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    { label: 'Hardness Avg', data: hAvgData, borderColor: 'rgba(255, 159, 64, 1)', backgroundColor: 'rgba(255, 159, 64, 0.2)', borderWidth: 3, tension: 0.1, order: 1 },
                    { label: 'Hardness 1', data: h1Data, borderColor: 'rgba(54, 162, 235, 0.7)', borderDash: [3, 3], borderWidth: 1.5, pointRadius: 2, order: 2, datalabels: { display: false } },
                    { label: 'Hardness 2', data: h2Data, borderColor: 'rgba(75, 192, 192, 0.7)', borderDash: [3, 3], borderWidth: 1.5, pointRadius: 2, order: 3, datalabels: { display: false } },
                    { label: 'Hardness 3', data: h3Data, borderColor: 'rgba(153, 102, 255, 0.7)', borderDash: [3, 3], borderWidth: 1.5, pointRadius: 2, order: 4, datalabels: { display: false } }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    datalabels: {
                        align: 'top',
                        formatter: function(value, context) {
                            if (context.datasetIndex === 0 && value > 0) return value.toFixed(1);
                            return '';
                        },
                        font: { size: 9, weight: 'bold' },
                        color: '#333'
                    }
                },
                scales: { y: { beginAtZero: false, grace: '15%' } }
            },
            plugins: [ChartDataLabels]
        });
    }
}
</script>
@endpush