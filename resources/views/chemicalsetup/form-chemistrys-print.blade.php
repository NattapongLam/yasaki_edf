<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Print Chemistry with Charts</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<style>
body { font-size:10px; }
.table td, .table th { padding:4px; }
tfoot th { font-weight:bold; background:#f8f9fa; }

@media print {
    .no-print { display:none; }
    canvas { page-break-inside: avoid; }
}
canvas { width:100% !important; height:200px !important; } /* ชัดเจนเรื่องขนาด */
</style>
</head>

<body>

<div class="container-fluid">

    <!-- ข้อมูลเอกสาร -->
    <table class="table table-bordered">
        <tr>
            <th width="150">ชื่อสูตร</th>
            <td>{{ $hd->ms_formule_name }}</td>

            <th width="150">วันที่</th>
            <td>{{ $hd->chemistry_hd_date }}</td>
        </tr>
        <tr>
            <th>ประเภท</th>
            <td>{{ $hd->chemistry_hd_type }}</td>

            <th>เลขที่สูตร</th>
            <td>{{ $hd->chemistry_hd_name }}</td>
        </tr>
        <tr>
            <th>Mixing (kg/Batch)</th>
            <td>{{ number_format($hd->chemistry_hd_mix,2) }}</td>

            <th>Total (W)</th>
            <td>{{ number_format($hd->chemistry_hd_qty,2) }}</td>
        </tr>
        <tr>
            <th>หมายเหตุ</th>
            <td colspan="3">{{ $hd->chemistry_hd_note }}</td>
        </tr>
    </table>

    <!-- ตารางข้อมูลหลัก -->
    <table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th width="60">No</th>
                <th>Code</th>
                <th>Material</th>
                <th>Grade</th>
                <th>Density</th>
                <th>Vol.%</th>
                <th>Volume</th>
                <th>W (%)</th>
                <th>Weight (g)</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @foreach($dt as $r)
            <tr>
                <td class="text-center">{{ $r->no }}</td>
                <td>{{ $r->code }}</td>
                <td>{{ $r->material }}</td>
                <td>{{ $r->grade }}</td>
                <td class="text-end"><input type="hidden" class="density" value="{{ $r->density }}">{{ number_format($r->density,2) }}</td>
                <td class="text-end"><input type="hidden" class="adjust" value="{{ $r->adjust }}">{{ number_format($r->adjust,2) }}</td>
                <td class="text-end"><input type="hidden" class="weght" value="{{ $r->weght }}">{{ number_format($r->weght,2) }}</td>
                <td class="text-end"><input type="hidden" class="weghtper" value="{{ $r->weghtper }}">{{ number_format($r->weghtper,2) }}</td>
                <td class="text-end"><input type="hidden" class="weghttotal" value="{{ $r->weghttotal }}">{{ number_format($r->weghttotal,2) }}</td>
                <input type="hidden" class="group" value="{{ $r->group_name ?? 'ไม่ระบุ' }}">
                <input type="hidden" class="color" value="{{ $r->group_color ?? '#cccccc' }}">
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            @php
            $sumAdjust = $dt->sum('adjust');
            $sumWeight = $dt->sum('weght');
            $sumWeightPer = $dt->sum('weghtper');
            $sumWeightTotal = $dt->sum('weghttotal');
            $mixKg = $hd->chemistry_hd_mix ?? 0;
            $sumDensity = $sumWeight>0 ? $mixKg/$sumWeight : 0;
            @endphp
            <tr class="text-end">
                <th colspan="4">Total</th>
                <th>{{ number_format($sumDensity,2) }}</th>
                <th>{{ number_format($sumAdjust,2) }}</th>
                <th>{{ number_format($sumWeight,2) }}</th>
                <th>{{ number_format($sumWeightPer,2) }}</th>
                <th>{{ number_format($sumWeightTotal,2) }}</th>
            </tr>
        </tfoot>
    </table>

    <!-- แสดง Chart -->
    <div class="row">
        <div class="col-6 d-flex justify-content-center flex-column align-items-center">
            <h6>Adjust (%)</h6>
            <canvas id="donutChart"></canvas>
        </div>
        <div class="col-6 d-flex justify-content-center flex-column align-items-center">
            <h6>Weight (g)</h6>
            <canvas id="pieChart"></canvas>
        </div>
    </div>

</div>

<script>
let pieChart = null;
let donutChart = null;

function buildPieData() {
    const rows = document.querySelectorAll('#tableBody tr');
    const groupMap = {}, colorMap = {};
    rows.forEach(row=>{
        const group = row.querySelector('.group')?.value || 'ไม่ระบุ';
        const value = parseFloat(row.querySelector('.weghttotal')?.value || 0);
        const color = row.querySelector('.color')?.value || '#cccccc';
        if(value<=0) return;
        if(!groupMap[group]) { groupMap[group]=0; colorMap[group]=color; }
        groupMap[group]+=value;
    });
    const labels = Object.keys(groupMap);
    const data = Object.values(groupMap);
    const total = data.reduce((a,b)=>a+b,0);
    return {labels,data,colors:labels.map(g=>colorMap[g]),total};
}

function buildDonutData() {
    const rows = document.querySelectorAll('#tableBody tr');
    const groupMap = {}, colorMap = {};
    rows.forEach(row=>{
        const group = row.querySelector('.group')?.value || 'ไม่ระบุ';
        let value = parseFloat(row.querySelector('.adjust')?.value || 0);
        const color = row.querySelector('.color')?.value || '#cccccc';
        if(value<=0) return;
        value = parseFloat(value.toFixed(2));
        if(!groupMap[group]) { groupMap[group]=0; colorMap[group]=color; }
        groupMap[group]+=value;
    });
    const labels = Object.keys(groupMap);
    const data = Object.values(groupMap).map(v=>parseFloat(v.toFixed(2)));
    const total = data.reduce((a,b)=>a+b,0);
    return {labels,data,colors:labels.map(g=>colorMap[g]),total};
}

function renderCharts() {
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    const donutCtx = document.getElementById('donutChart').getContext('2d');
    const pieData = buildPieData();
    const donutData = buildDonutData();

    if(pieChart) pieChart.destroy();
    if(donutChart) donutChart.destroy();

    pieChart = new Chart(pieCtx, {
        type:'pie',
        data:{ labels: pieData.labels, datasets:[{ data: pieData.data, backgroundColor: pieData.colors }] },
        plugins:[ChartDataLabels],
        options:{
            responsive:true, maintainAspectRatio:false,
            plugins:{
                legend:{ position:'right' },
                tooltip:{ callbacks:{ label:function(ctx){
                    const value=ctx.raw;
                    const percent=(value/pieData.total*100).toFixed(2);
                    return `${ctx.label}: ${value.toFixed(2)} g (${percent}%)`;
                }}},
                datalabels:{ color:'#000', formatter:function(value){ 
                    const percent=(value/pieData.total*100).toFixed(1);
                    return `${value.toFixed(1)}g\n${percent}%`; }, font:{weight:'bold',size:12} }
            }
        }
    });

    donutChart = new Chart(donutCtx, {
        type:'doughnut',
        data:{ labels: donutData.labels, datasets:[{ data: donutData.data, backgroundColor: donutData.colors, borderWidth:1 }] },
        plugins:[ChartDataLabels],
        options:{
            responsive:true, maintainAspectRatio:false, cutout:'60%',
            plugins:{
                legend:{ position:'right', labels:{ font:{size:12} } },
                tooltip:{ callbacks:{ label:function(ctx){
                    const value=parseFloat(ctx.raw.toFixed(2));
                    const percent=(value/donutData.total*100).toFixed(2);
                    return `${ctx.label}: ${value.toFixed(2)}% (${percent}%)`;
                }}},
                datalabels:{ color:'#000', formatter:function(value){
                    const percent=(value/donutData.total*100).toFixed(2);
                    return `${percent}%`; }, font:{weight:'bold', size:12} }
            }
        }
    });

    // รอ render เสร็จแล้วค่อย print
    requestAnimationFrame(()=>{
        setTimeout(()=>window.print(), 500);
    });
}

document.addEventListener('DOMContentLoaded', renderCharts);
</script>

</body>
</html>