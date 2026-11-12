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

    <!-- ส่วนหัวข้อและฟิลเตอร์ค้นหาช่วงวันที่ตามรหัสสูตร -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-12 col-md-4">
                    <h3 class="card-title text-primary mb-0">ความหนาแน่นของผ้าชิ้น: รหัสสูตร {{ $id ?? '-' }}</h3>
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

    <!-- วนลูปแสดงผลแต่ละรายการ $hd ออกมาเป็นบล็อกการ์ด (Cards) พร้อมกราฟ -->
    @forelse($hd as $index => $item)
    <div class="col-12 mb-4">
        <div class="card border shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                <h5 class="mb-0 text-dark font-weight-bold">
                    <i class="fas fa-file-alt text-primary me-2"></i> รายการที่ {{ $index + 1 }} 
                    <span class="badge bg-info text-dark ms-2">วันที่: {{ $item->density_workcloth_hds_date }}</span>
                </h5>
                <div>
                    <a href="{{ route('density-workcloth.edit', $item->density_workcloth_hds_id) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit me-1"></i> ไปหน้าแก้ไขเดี่ยว
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- ข้อมูลสรุปส่วนหัวของแต่ละบล็อก -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>แม่พิมพ์:</strong> {{ $item->mlod_code }} / {{ $item->mlod_name }}
                    </div>
                    <div class="col-md-4">
                        <strong>สินค้า:</strong> {{ $item->product_code }} / {{ $item->product_name }}
                    </div>
                    <div class="col-md-4">
                        <strong>หมายเหตุ:</strong> {{ $item->density_workcloth_hds_note ?? '-' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <strong>เครื่อง:</strong> {{ $item->machinery_name }}
                    </div>
                    <div class="col-md-3">
                        <strong>Formule:</strong> {{ $item->ms_formule_name }} ({{ $item->chemistry_hd_name }})
                    </div>
                    <div class="col-md-3">
                        <strong>Target Density:</strong> <span id="target-density-{{ $item->density_workcloth_hds_id }}">{{ $item->total_density }}</span>
                    </div>
                    <div class="col-md-3">
                        <strong>Pressure:</strong> {{ $item->mlod_pressure ?? '-' }}
                    </div>
                </div>

                <!-- ดึงรายละเอียด cavity ของแต่ละ header แยกตาม id -->
                @php
                    $dtList = DB::table('density_workcloth_dts')
                    ->where('density_workcloth_hds_id', $item->density_workcloth_hds_id)
                    ->where('weight_2','>',0)
                    ->where('weight_2','<>',null)
                    ->get();
                @endphp

                <!-- ตารางแสดงรายละเอียด (Cavity details) -->
                <div class="table-responsive mt-3">
                    <table class="table table-bordered text-center align-middle table-sm">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2">ลำดับ</th>
                                <th colspan="2">ผ้าชิ้นก่อนกรอ</th>
                                <th colspan="3">ความหนาผ้าชิ้นก่อนกรอ (mm)</th>
                                <th rowspan="2">ความหนาก้อนเคมี (cm)</th>
                                <th rowspan="2">CAD volume</th>
                                <th rowspan="2">Density (g/cm³)</th>
                                <th rowspan="2">%Porosity</th>
                                <th colspan="3">Hardness</th>
                            </tr>
                            <tr>
                                <th>น้ำหนักปกติ (g)</th>
                                <th>น้ำหนักเปียก (g)</th>
                                <th>จุดที่ 1</th>
                                <th>จุดที่ 2</th>
                                <th>จุดที่ 3</th>
                                <th>1</th>
                                <th>2</th>
                                <th>3</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dtList as $dtIndex => $dtItem)
                            <tr class="cavity-row">
                                <td>{{ $dtIndex + 1 }}</td>
                                <td>{{ number_format($dtItem->weight_1, 2) }}</td>
                                <td>{{ number_format($dtItem->weight_2, 2) }}</td>
                                <td>{{ number_format($dtItem->thickness_1, 2) }}</td>
                                <td>{{ number_format($dtItem->thickness_2, 2) }}</td>
                                <td>{{ number_format($dtItem->thickness_3, 2) }}</td>
                                <td>{{ number_format($dtItem->thickness_chemical, 2) }}</td>
                                <td>{{ number_format($dtItem->volume, 2) }}</td>
                                <td class="val-density">{{  number_format($dtItem->density, 2) }}</td>
                                <td class="val-porosity">{{  number_format($dtItem->porosity, 2) }}</td>
                                <td class="val-h1">{{  number_format($dtItem->hardness_1, 2) }}</td>
                                <td class="val-h2">{{  number_format($dtItem->hardness_2, 2) }}</td>
                                <td class="val-h3">{{  number_format($dtItem->hardness_3, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="13" class="text-muted">ไม่พบข้อมูลรายละเอียด (Detail) ในรายการนี้</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- ส่วนแสดงกราฟแยกตามแต่ละรายการ (Card ID Unique) -->
                @if(count($dtList) > 0)
                <div class="row mt-4">
                    <div class="col-12 col-md-4 mb-3">
                        <div class="card border shadow-sm p-2">
                            <h6 class="fw-bold text-dark text-center mb-2" style="font-size: 13px;">Density vs Target/Limits</h6>
                            <canvas id="densityChart-{{ $item->density_workcloth_hds_id }}" height="160"></canvas>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <div class="card border shadow-sm p-2">
                            <h6 class="fw-bold text-dark text-center mb-2" style="font-size: 13px;">%Porosity Trend (Avg Limit)</h6>
                            <canvas id="porosityChart-{{ $item->density_workcloth_hds_id }}" height="160"></canvas>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <div class="card border shadow-sm p-2">
                            <h6 class="fw-bold text-dark text-center mb-2" style="font-size: 13px;">Hardness Points & Avg</h6>
                            <canvas id="hardnessChart-{{ $item->density_workcloth_hds_id }}" height="160"></canvas>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-warning text-center">ไม่พบข้อมูลความหนาแน่นของผ้าชิ้นตามเงื่อนไขช่วงวันที่ดังกล่าว</div>
    </div>
    @endforelse
</div>
@endsection

@push('scriptjs')
<!-- โหลด Chart.js และ Plugin Datalabels -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js"></script>

<script>
$(document).ready(function() {
    // วนลูปเรนเดอร์กราฟให้ครบทุก Card ที่มีข้อมูล
    @foreach($hd as $item)
        @php
            $dtList = DB::table('density_workcloth_dts')
            ->where('density_workcloth_hds_id', $item->density_workcloth_hds_id)
            ->where('weight_2','>',0)
            ->where('weight_2','<>',null)
            ->get();
        @endphp

        @if(count($dtList) > 0)
            renderChartsForCard("{{ $item->density_workcloth_hds_id }}", {{ $item->total_density ?? 0 }});
        @endif
    @endforeach

    // ปุ่มค้นหาช่วงวันที่ (เปลี่ยน type เป็น สูตร)
    $('#btn-filter').click(function() {
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();
        let formulaId = "{{ $id ?? '' }}";
        
        window.location.href = `{{ url('density-workcloth') }}/${encodeURIComponent(formulaId)}?type=สูตร&start_date=${startDate}&end_date=${endDate}`;
    });

    // ปุ่มรีเซ็ต (เปลี่ยน type เป็น สูตร)
    $('#btn-reset').click(function() {
        let formulaId = "{{ $id ?? '' }}";
        window.location.href = `{{ url('density-workcloth') }}/${encodeURIComponent(formulaId)}?type=สูตร`;
    });
});

function renderChartsForCard(hdsId, targetDensity) {
    let cardElement = $(`#densityChart-${hdsId}`).closest('.card-body');
    let labels = [];
    let densityData = [];
    let porosityData = [];
    let targetData = [];
    let upperData = [];
    let lowerData = [];

    let hAvgData = [];
    let h1Data = [];
    let h2Data = [];
    let h3Data = [];

    // แก้ไข: ใส่เครื่องหมายคูณ (*) ให้ถูกต้อง
    let upperLimit = targetDensity * 1.05;
    let lowerLimit = targetDensity * 0.95;

    cardElement.find('.cavity-row').each(function(index) {
        let rowNum = index + 1;
        labels.push('C' + rowNum);

        let density = parseFloat($(this).find('.val-density').text()) || 0;
        let porosity = parseFloat($(this).find('.val-porosity').text()) || 0;
        let h1 = parseFloat($(this).find('.val-h1').text()) || 0;
        let h2 = parseFloat($(this).find('.val-h2').text()) || 0;
        let h3 = parseFloat($(this).find('.val-h3').text()) || 0;

        let validH = [h1, h2, h3].filter(v => v > 0);
        let hAvg = validH.length > 0 ? (validH.reduce((a, b) => a + b, 0) / validH.length) : 0;

        densityData.push(density);
        porosityData.push(porosity);
        targetData.push(targetDensity);
        upperData.push(upperLimit);
        lowerData.push(lowerLimit);

        h1Data.push(h1);
        h2Data.push(h2);
        h3Data.push(h3);
        hAvgData.push(hAvg);
    });

    // 1. กราฟ Density
    const ctxDensity = document.getElementById(`densityChart-${hdsId}`);
    if (ctxDensity) {
        new Chart(ctxDensity.getContext('2d'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    { label: 'Actual', data: densityData, borderColor: 'rgba(54, 162, 235, 1)', backgroundColor: 'rgba(54, 162, 235, 0.2)', borderWidth: 2, tension: 0.1 },
                    { label: 'Target', data: targetData, borderColor: 'rgba(40, 167, 69, 1)', borderDash: [4, 4], borderWidth: 1.5, pointRadius: 0 },
                    { label: 'Upper', data: upperData, borderColor: 'rgba(220, 53, 69, 0.8)', borderDash: [2, 2], borderWidth: 1, pointRadius: 0 },
                    { label: 'Lower', data: lowerData, borderColor: 'rgba(255, 193, 7, 1)', borderDash: [2, 2], borderWidth: 1, pointRadius: 0 }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        display: function(context) {
                            return context.datasetIndex === 0;
                        },
                        align: 'top',
                        formatter: function(value) {
                            return value > 0 ? value.toFixed(2) : '';
                        },
                        font: { size: 10, weight: 'bold' },
                        color: '#333'
                    }
                },
                scales: { y: { beginAtZero: false } }
            },
            plugins: [ChartDataLabels]
        });
    }

    // 2. กราฟ %Porosity (คำนวณเส้น Max Limit เป็นค่าเฉลี่ยของแต่ละการ์ดอัตโนมัติ)
    const ctxPorosity = document.getElementById(`porosityChart-${hdsId}`);
    if (ctxPorosity) {
        const avgPorosity = porosityData.length > 0 
            ? porosityData.reduce((sum, val) => sum + Number(val || 0), 0) / porosityData.length 
            : 0;

        let maxPorosityLimit = new Array(labels.length).fill(avgPorosity);

        new Chart(ctxPorosity.getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    { type: 'bar', label: '%Porosity', data: porosityData, backgroundColor: 'rgba(153, 102, 255, 0.6)', borderColor: 'rgba(153, 102, 255, 1)', borderWidth: 1, order: 2 },
                    { type: 'line', label: `Average (${avgPorosity.toFixed(2)}%)`, data: maxPorosityLimit, borderColor: 'rgba(220, 53, 69, 1)', borderDash: [4, 4], borderWidth: 1.5, pointRadius: 0, order: 1 }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        display: function(context) {
                            return context.datasetIndex === 0;
                        },
                        anchor: 'end',
                        align: 'top',
                        formatter: function(value) {
                            return value > 0 ? value.toFixed(2) : '';
                        },
                        font: { size: 10, weight: 'bold' },
                        color: '#333'
                    }
                },
                scales: { 
                    y: { 
                        beginAtZero: true, 
                        suggestedMax: Math.max(...porosityData, avgPorosity) * 1.2 || 7 
                    } 
                }
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
                    { label: 'Avg', data: hAvgData, borderColor: 'rgba(255, 159, 64, 1)', borderWidth: 2, tension: 0.1 },
                    { label: 'H1', data: h1Data, borderColor: 'rgba(54, 162, 235, 0.5)', borderDash: [2, 2], borderWidth: 1, pointRadius: 1 },
                    { label: 'H2', data: h2Data, borderColor: 'rgba(75, 192, 192, 0.5)', borderDash: [2, 2], borderWidth: 1, pointRadius: 1 },
                    { label: 'H3', data: h3Data, borderColor: 'rgba(153, 102, 255, 0.5)', borderDash: [2, 2], borderWidth: 1, pointRadius: 1 }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        display: function(context) {
                            return context.datasetIndex === 0;
                        },
                        align: 'top',
                        formatter: function(value) {
                            return value > 0 ? value.toFixed(1) : '';
                        },
                        font: { size: 10, weight: 'bold' },
                        color: '#333'
                    }
                },
                scales: { y: { beginAtZero: false } }
            },
            plugins: [ChartDataLabels]
        });
    }
}
</script>
@endpush