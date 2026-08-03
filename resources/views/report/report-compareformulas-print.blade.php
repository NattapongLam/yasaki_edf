<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

:root{
    --navy:#1c3a5e;
    --navy-dark:#122844;
    --steel:#3d6d99;
    --steel-light:#eaf1f7;
    --hairline:#c7d2dc;
    --ink:#1c1c1c;
    --muted:#5b6b78;
    --alert:#b3261e;
    --band:#f4f7fa;
}

*{
    box-sizing:border-box;
}

body{
    font-family:'Sarabun', Arial, Helvetica, sans-serif;
    font-size:10px;
    margin:0;
    line-height:1.35;
    color:var(--ink);
}

/* A4 */

@page{
    size:A4 portrait;
    margin:6mm;
}

/* ============ HEADER ============ */

.doc-frame{
    border:1.5px solid var(--navy);
}

.accent-bar{
    height:4px;
    background:linear-gradient(90deg, var(--navy) 0%, var(--steel) 100%);
}

.header{
    padding:8px 10px 6px 10px;
    border-bottom:1px solid var(--hairline);
}

.header-top{
    display:flex;
    align-items:center;
    justify-content:space-between;
}

.header-left{
    display:flex;
    align-items:center;
}

.logo{
    width:68px;
}

.company{
    padding-left:8px;
    font-size:9.5px;
    color:var(--muted);
    max-width:330px;
}

.company b{
    display:block;
    font-size:12.5px;
    color:var(--navy-dark);
    letter-spacing:.2px;
    margin-bottom:1px;
}

.accred-badge{
    text-align:right;
    font-size:8.5px;
    color:var(--steel);
    line-height:1.5;
}

.accred-badge .tag{
    display:inline-block;
    border:1px solid var(--steel);
    color:var(--navy);
    font-weight:600;
    font-size:8px;
    letter-spacing:.6px;
    padding:2px 7px;
    border-radius:2px;
    background:var(--steel-light);
}

.report-title{
    text-align:center;
    font-size:15px;
    font-weight:700;
    color:var(--navy-dark);
    margin:8px 0 2px 0;
    letter-spacing:.3px;
}

.report-subtitle{
    text-align:center;
    font-size:9px;
    color:var(--muted);
    margin-bottom:2px;
}

.title-rule{
    width:70px;
    height:2px;
    background:var(--steel);
    margin:4px auto 0 auto;
}

/* ============ BODY WRAP ============ */

.doc-body{
    padding:8px 10px 6px 10px;
}

/* layout */

.grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:8px;
}

/* table */

table{
    width:100%;
    border-collapse:collapse;
}

table,th,td{
    border:1px solid var(--hairline);
}

th{
    text-align:left;
    font-weight:600;
    background:var(--steel-light);
    color:var(--navy-dark);
    width:52%;
}

td{
    text-align:left;
    color:var(--ink);
}

th,td{
    padding:3.5px 6px;
}

tr:nth-child(even) td{
    background:var(--band);
}

/* section */

.section-title{
    display:flex;
    align-items:center;
    gap:8px;
    font-size:12px;
    font-weight:700;
    color:var(--navy-dark);
    margin:10px 0 5px 0;
}

.section-title::before,
.section-title::after{
    content:"";
    flex:1;
    height:1px;
    background:var(--hairline);
}

/* note */

.note{
    margin-top:6px;
    font-size:9.5px;
    color:var(--alert);
    text-align:center;
    font-style:italic;
    background:#fdf2f1;
    border:1px dashed #e3b3af;
    border-radius:2px;
    padding:3px 6px;
}

/* result table */

.result-table{
    table-layout:fixed;
    font-size:9.5px;
}

.result-table th,
.result-table td{
    padding:3px 3px;
    text-align:center;
}

.result-table thead tr:first-child th{
    background:var(--navy);
    color:#fff;
    font-weight:700;
    letter-spacing:.3px;
    border-color:var(--navy-dark);
}

.result-table thead tr:last-child th{
    background:var(--steel-light);
    color:var(--navy-dark);
    font-weight:600;
}

.result-table tbody tr:nth-child(even) td{
    background:var(--band);
}

.result-table tbody td:nth-last-child(-n+2){
    font-weight:700;
    color:var(--navy-dark);
    background:#eef4fa;
}

/* column width */

.col-temp{width:9%}
.col-fr{width:10%}
.col-wr{width:11%}
.col-avg{width:14%}

/* images */

.spec-photo th{
    width:22%;
}

.spec-photo td{
    text-align:center;
    padding:4px;
}

.spec-photo img{
    border:1px solid var(--hairline);
    border-radius:2px;
}

/* ============ EQUIPMENT / CALIBRATION CARDS ============ */

.equip-grid{
    display:grid;
    grid-template-columns:repeat(2, 1fr);
    gap:8px;
}

.equip-card{
    border:1px solid var(--hairline);
    border-radius:3px;
    background:#fff;
    padding:6px 8px 7px 8px;
}

.equip-role{
    font-size:7.5px;
    font-weight:700;
    letter-spacing:.5px;
    text-transform:uppercase;
    color:#fff;
    background:var(--steel);
    display:inline-block;
    padding:1.5px 6px;
    border-radius:2px;
    margin-bottom:4px;
}

.equip-name{
    font-size:10px;
    font-weight:700;
    color:var(--navy-dark);
    margin-bottom:1px;
}

.equip-code{
    font-size:8.5px;
    color:var(--muted);
    margin-bottom:4px;
}

.equip-detail{
    font-size:8.5px;
    color:var(--ink);
    line-height:1.55;
    border-top:1px dashed var(--hairline);
    padding-top:3px;
    margin-top:3px;
}

.equip-detail b{
    color:var(--navy-dark);
    font-weight:600;
}

/* charts */

.chart-box{
    height:155px;
    width:660px;
    margin:6px auto;
    border:1px solid var(--hairline);
    border-radius:3px;
    padding:6px 8px 4px 8px;
    background:#fff;
}

.chart-box canvas{
    height:85px !important;
    width:100% !important;
}

.chart-title{
    text-align:center;
    font-size:9px;
    font-weight:500;
    color:var(--muted);
    margin-top:2px;
}

/* ============ PIE / COMPOSITION BOX ============ */

.pie-box{
    width:480px;
    margin:6px auto;
    border:1px solid var(--hairline);
    border-radius:3px;
    padding:8px 10px 6px 10px;
    background:#fff;
    page-break-inside:avoid;
}

.pie-box-title{
    text-align:center;
    font-size:10.5px;
    font-weight:700;
    color:var(--navy-dark);
    margin-bottom:4px;
}

.pie-canvas-wrap{
    height:150px;
    width:100%;
}

.pie-empty{
    text-align:center;
    font-size:9px;
    color:var(--muted);
    padding:20px 0;
}

/* signature */

.signature{
    border:1.5px solid var(--navy);
    border-radius:3px;
    margin-top:10px;
    padding:8px 10px 6px 10px;
    page-break-inside:avoid;
    background:var(--steel-light);
}

.signature-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:24px;
}

.sign-box{
    text-align:center;
    font-size:11px;
    color:var(--navy-dark);
    font-weight:600;
}

.sign-line{
    margin-top:30px;
    border-top:1px solid var(--navy);
    padding-top:3px;
    font-size:9.5px;
    color:var(--muted);
    font-weight:400;
}

.tester{
    margin-top:8px;
    border-top:1px dashed var(--hairline);
    padding-top:5px;
    font-size:9.5px;
    color:var(--muted);
    text-align:center;
}

/* footer strip */

.doc-footer{
    display:flex;
    justify-content:space-between;
    font-size:7.5px;
    color:var(--muted);
    padding:4px 10px;
    border-top:1px solid var(--hairline);
}

/* prevent cut */

.no-break{
    page-break-inside:avoid;
}

hr{
    border:0;
    border-top:1px solid var(--hairline);
    margin:5px 0;
}
</style>

</head>

<body>

<div class="doc-frame">

<div class="accent-bar"></div>

<div class="header">

<div class="header-top">

<div class="header-left">
<div class="logo">
<img src="{{ URL::asset('assets/images/KK-C.png') }}" height="50">
</div>

<div class="company">
<b>KK&C PARTS CO., LTD.</b>
588/35 M Floor, Sathu Pradit Rd., Bang Phong Phang, Yan Nawa, Bangkok 10120
</div>
</div>

<div class="accred-badge">
<span class="tag">LABORATORY REPORT</span><br>
ISO/IEC 17025
</div>

</div>

<div class="report-title">
Coefficient of Friction Test Report
</div>
<div class="report-subtitle">
Coefficient of Friction Test Report
</div>
<div class="title-rule"></div>

</div>


<div class="doc-body">

<!-- general -->

<div class="grid no-break">

<table>

<tr>
<th>Laboratory No.</th>
<td>XXX-XXXX</td>
</tr>

<tr>
<th>Reference No.</th>
<td>{{$reqhd->ar_requestorder_hds_docuno}}</td>
</tr>

<tr>
<th>Sample Description</th>
<td>{{$reqdt->ar_requestorder_dts_product}}</td>
</tr>

<tr>
<th>Sample No.</th>
<td>{{$reqhd->ar_requestorder_hds_docuno}}</td>
</tr>

<tr>
<th>Date Received</th>
<td>{{ \Carbon\Carbon::parse($rechd->receive_test_lists_date)->format('d/m/Y') }}</td>
</tr>

</table>


<table>

<tr>
<th>Test Date</th>
<td>{{ \Carbon\Carbon::parse($hd->TestDate)->format('d/m/Y') }}</td>
</tr>

<tr>
<th>Issue Date</th>
<td>{{ date('d/m/Y') }} </td>
</tr>

<tr>
<th>Test Standard</th>
<td>
    @if ($reqdt->ar_requestorder_dts_jis_class == "CLASS_3")
        JIS D 4411 Class 3 (Heavy Loads)
    @else
        JIS D 4411 Class 4 (Disc Brakes)
    @endif
</td>
</tr>

<tr>
<th>Test Result</th>
<td>{{$rechd->result_test_lists_test}}</td>
</tr>

</table>

</div>


<!-- condition -->

<div class="section-title">Test Environment & Conditions</div>

<div class="grid no-break">

<table>

<tr>
<th>Room Temp. (25-31 °C)</th>
<td>{{$rechd->result_test_lists_temp}}</td>
</tr>

<tr>
<th>Humidity (40-60% RH)</th>
<td>{{$rechd->result_test_lists_moisture}}</td>
</tr>

<tr>
<th>Test Disc Material</th>
<td>{{$rechd->result_test_lists_plate}}</td>
</tr>

<tr>
<th>Test Type</th>
<td>{{ $hd->TestType }}</td>
</tr>

</table>


<table>

<tr>
<th>Tested Sets</th>
<td>3 Sets</td>
</tr>

<tr>
<th>Test Temperature Range</th>
<td>100-350 °C</td>
</tr>

<tr>
<th>Friction Range</th>
<td>0.00-0.080 (μ) </td>
</tr>

<tr>
<th>Uncertainty (95%)</th>
<td>± 0.032 (μ)</td>
</tr>

</table>

</div>

<div class="note">
Note: The reported uncertainty is based on a standard uncertainty multiplied by a coverage factor k=2, providing a level of confidence of approximately 95%.
</div>



<!-- calibration / equipment -->

<div class="section-title">Measuring & Test Equipment</div>

<div class="equip-grid no-break">

    <div class="equip-card">
        <span class="equip-role">Dimension Measuring Tool</span>
        <div class="equip-name">{{ $caldimensions->calibration_lists_name1 }}</div>
        <div class="equip-code">Code: {{ $caldimensions->calibration_lists_code }}</div>
        <div class="equip-detail">           
            <b>{{ $caldimensions->calibration_lists_reamrk}}  Expire Date {{ \Carbon\Carbon::parse($caldimensions->calibration_lists_nextdate)->format('d/m/Y') }}</b>
        </div>
    </div>
    <div class="equip-card">
        <span class="equip-role">Dimension Measuring Tool</span>
        <div class="equip-name">{{ $caldimensions1->calibration_lists_name1 }}</div>
        <div class="equip-code">Code: {{ $caldimensions1->calibration_lists_code }}</div>
        <div class="equip-detail">           
            <b>{{ $caldimensions1->calibration_lists_reamrk}}  Expire Date {{ \Carbon\Carbon::parse($caldimensions1->calibration_lists_nextdate)->format('d/m/Y') }}</b>
        </div>
    </div>
    <div class="equip-card">
        <span class="equip-role">Weighing Scale</span>
        <div class="equip-name">{{ $calweight->calibration_lists_name1 }}</div>
        <div class="equip-code">Code: {{ $calweight->calibration_lists_code }}</div>
        <div class="equip-detail">     
            <b>{{ $calweight->calibration_lists_reamrk}}  Expire Date {{ \Carbon\Carbon::parse($calweight->calibration_lists_nextdate)->format('d/m/Y') }}</b>
        </div>
    </div>

    @foreach ($cal as $item)
    <div class="equip-card">
        <span class="equip-role">Testing Machine</span>
        <div class="equip-name">{{ $item->calibration_lists_name1 }}</div>
        <div class="equip-code">Code: {{ $item->calibration_lists_code }}</div>
        <div class="equip-detail">      
            <b>{{ $item->calibration_lists_reamrk}}  Expire Date {{ \Carbon\Carbon::parse($item->calibration_lists_nextdate)->format('d/m/Y') }}</b>
        </div>
    </div>
    @endforeach

</div>
<div style="page-break-before: always;"></div>
<!-- sample detail -->

<div class="section-title">Sample Details</div>

<div class="grid no-break">

<table>

<tr>
<th>Trademark</th>
<td>XXX-XXXX</td>
</tr>

<tr>
<th>Formula Name</th>
<td>{{ $hd->FormulaName }}</td>
</tr>

<tr>
<th>Formula No.</th>
<td>{{ $hd->FormulaNumber }}</td>
</tr>

<tr>
<th>Lot No.</th>
<td>{{ $reqdt->ar_requestorder_hds_remark }}</td>
</tr>

<tr>
<th>Manufacturer</th>
<td>{{ $reqhd->ar_requestorder_hds_customer }}</td>
</tr>

</table>


<table>

<tr>
<th>Test Sample Category</th>
<td>Brake Pad / Disc Brake</td>
</tr>

<tr>
<th>Sample Size</th>
<td>Size (mm): {{$reqdt->ar_requestorder_dts_dimensions}}</td>
</tr>

<tr>
<th>Before Test</th>
<td>Size (mm): {{$rechd->receive_test_lists_dimensions}} (Weight (g): {{$rechd->receive_test_lists_weight}})</td>
</tr>

<tr>
<th>After Test</th>
<td>Size (mm): {{$rechd->result_test_lists_dimensions}} (Weight (g): {{$rechd->result_test_lists_weight}})</td>
</tr>

</table>
<table class="spec-photo">
    <tr>
        <th colspan="2">Sample Photo Before Test</th>
        <td class="text-center"><img src="{{asset($rechd->receive_test_lists_file1)}}" class="img-thumbnail" width="35%"></td>
        <td class="text-center"><img src="{{asset($rechd->receive_test_lists_file2)}}" class="img-thumbnail" width="35%"></td>      
    </tr>
</table>
<table class="spec-photo">
    <tr>
        <th colspan="2">Sample Photo After Test</th>
        <td class="text-center"><img src="{{asset($rechd->result_test_lists_file1)}}" class="img-thumbnail" width="35%"></td>
        <td class="text-center"><img src="{{asset($rechd->result_test_lists_file2)}}" class="img-thumbnail" width="35%"></td>
    </tr>
</table>
</div>


<!-- result -->

<div class="section-title">Detailed Test Results</div>

<table class="result-table no-break">

<thead>

<tr>
<th colspan="4">FRICTION (μ)</th>
<th colspan="3">WEAR RATE (10⁻⁷ cm³/N·m)</th>
<th colspan="2">AVERAGE RESULT</th>
</tr>

<tr>

<th class="col-temp">Temp (°C)</th>

<th class="col-fr">N1</th>
<th class="col-fr">N2</th>
<th class="col-fr">N3</th>

<th class="col-wr">N1</th>
<th class="col-wr">N2</th>
<th class="col-wr">N3</th>

<th class="col-avg">Friction</th>
<th class="col-avg">Wear</th>

</tr>

</thead>

<tbody>

@foreach ($dt as $item)

<tr>

<td>{{ $item->Temperature }}</td>

<td>{{ number_format($item->F1,3) }}</td>
<td>{{ number_format($item->F2,3) }}</td>
<td>{{ number_format($item->F3,3) }}</td>

<td>{{ number_format($item->W1,3) }}</td>
<td>{{ number_format($item->W2,3) }}</td>
<td>{{ number_format($item->W3,3) }}</td>

<td>{{ number_format($item->FAvg,3) }}</td>
<td>{{ number_format($item->WAvg,3) }}</td>

</tr>

@endforeach

</tbody>

</table>
<br>

<div class="chart-box no-break">

<canvas id="frictionChart"></canvas>
<div class="chart-title">
Note: Coefficient of Friction (COF) unit is represented as µ
</div>

</div>

<div class="chart-box no-break">

    <canvas id="wearRateChart"></canvas>
     <div class="chart-title">
       Note: Wear Rate unit is represented as ( 10^-7 cm^3/N.m )
    </div>
</div>


<!-- ===================== COMPOSITION PIE CHART ===================== -->

<div class="section-title">Weight Composition</div>

<div class="pie-box no-break">
    <div class="pie-box-title">Weight (g)</div>

    @if(isset($bomdt) && count($bomdt) > 0)
        <div class="pie-canvas-wrap">
            <canvas id="pieChart"></canvas>
        </div>
    @else
        <div class="pie-empty">No BOM (Bill of Materials) data available for this formula.</div>
    @endif
</div>

<!-- signature -->

<div class="signature no-break">

<div class="signature-grid">

<div class="sign-box">
Checked by
<div class="sign-line">
Date ....../....../......
</div>
</div>

<div class="sign-box">
Approved by
<div class="sign-line">
Date ....../....../......
</div>
</div>

</div>

<div class="tester">
Tested by {{ $hd->TesterName }} | Date {{ \Carbon\Carbon::parse($hd->TestDate)->format('d/m/Y') }}
</div>

</div>

</div>

<div class="doc-footer">
<span>KK&C Parts Co., Ltd. — Friction Coefficient Test Report</span>
<span>Document generated {{ date('d/m/Y H:i') }}</span>
</div>

</div>


<div style="page-break-after:always;"></div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>

const temps = @json($temps);

const frictionPoints = @json(array_values($frictionPoints->toArray()));

const safeUpper = @json($safeUpper);
const safeLower = @json($safeLower);

const jisMax = @json($jisMax);
const jisMin = @json($jisMin);

const targetUpper = @json($targetUpper);
const targetLower = @json($targetLower);


new Chart(document.getElementById('frictionChart'),{

type:'line',

data:{

labels:temps,

datasets:[

{
data:safeUpper,
borderWidth:0,
pointRadius:0,
backgroundColor:'rgba(61,109,153,0.10)',
fill:'+1'
},

{
data:safeLower,
borderWidth:0,
pointRadius:0,
fill:false
},

{
data:jisMax,
borderColor:'#b3261e',
borderDash:[6,6],
borderWidth:1,
pointRadius:0
},

{
data:jisMin,
borderColor:'#b3261e',
borderDash:[6,6],
borderWidth:1,
pointRadius:0
},

{
data:targetUpper,
borderColor:'#3d6d99',
borderDash:[2,2],
borderWidth:1,
pointRadius:0
},

{
data:targetLower,
borderColor:'#3d6d99',
borderDash:[2,2],
borderWidth:1,
pointRadius:0
},

{
label:'Friction Avg',
data:frictionPoints,
borderColor:'#122844',
backgroundColor:'#122844',
borderWidth:2,
pointRadius:3,
tension:0.2
}

]

},

options:{

responsive:true,
maintainAspectRatio:false,
animation:false,

plugins:{
legend:{display:false}
},

scales:{

x:{
title:{
display:true,
text:'Temperature (°C)'
}
},

y:{
title:{
display:true,
text:'Friction (μ)'
},

min:0,
max:0.8,

ticks:{
stepSize:0.2
}

}

}

}

});


const wearRatePoints = @json(array_values($wearRatePoints->toArray()));

new Chart(document.getElementById('wearRateChart'),{

type:'line',

data:{

labels:temps,

datasets:[

{
label:'Wear Rate Avg',
data:wearRatePoints,
borderColor:'#122844',
backgroundColor:'#122844',
borderWidth:2,
pointRadius:3,
tension:0.2
}

]

},

options:{

responsive:true,
maintainAspectRatio:false,
animation:false,

plugins:{
legend:{display:false}
},

scales:{

y:{
title:{
display:true,
text:'Wear Rate (10⁻⁷ cm³/N·m)'
},
min:0,
max:1.6,
ticks:{
stepSize:0.2
}
}

}

}

});


let pieChart = null;

function buildPieData(){
    const bomdt = @json($bomdt ?? []);

    const fallbackPalette = [
        '#1c3a5e','#3d6d99','#6f9bc4','#a9c6e0',
        '#b3261e','#e0a458','#4a7c59','#8e7cc3'
    ];

    const groups = {};
    let fallbackIdx = 0;

    bomdt.forEach(function(item){
        const key = item.chemical_groups_name || 'Others';
        const val = parseFloat(item.weghttotal) || 0;

        if(!groups[key]){
            let color = item.chemical_groups_color;
            if(!color){
                color = fallbackPalette[fallbackIdx % fallbackPalette.length];
                fallbackIdx++;
            }
            groups[key] = { total: 0, color: color };
        }

        groups[key].total += val;
    });

    const labels = Object.keys(groups);
    const data = labels.map(function(l){ return groups[l].total; });
    const colors = labels.map(function(l){ return groups[l].color; });
    const total = data.reduce(function(a,b){ return a + b; }, 0);

    return { labels: labels, data: data, colors: colors, total: total };
}

function renderPieChart(){

    const canvas = document.getElementById('pieChart');
    if(!canvas) return;

    const pieCtx = canvas.getContext('2d');
    const pieData = buildPieData();

    if(pieChart) pieChart.destroy();

    pieChart = new Chart(pieCtx, {
        type:'pie',
        data:{
            labels: pieData.labels,
            datasets:[{ data: pieData.data, backgroundColor: pieData.colors }]
        },
        plugins:[ChartDataLabels],
        options:{
            responsive:true,
            maintainAspectRatio:false,
            animation:false,
            plugins:{
                legend:{ position:'right', labels:{ font:{ size:9 } } },
                tooltip:{
                    callbacks:{
                        label:function(ctx){
                            const value = ctx.raw;
                            const percent = (value / pieData.total * 100).toFixed(2);
                            return ctx.label + ': ' + value.toFixed(2) + ' g (' + percent + '%)';
                        }
                    }
                },
                datalabels:{
                    color:'#000',
                    formatter:function(value){
                        const percent = (value / pieData.total * 100).toFixed(1);
                        return value.toFixed(1) + 'g\n' + percent + '%';
                    },
                    font:{ weight:'bold', size:9 }
                }
            }
        }
    });
}

window.onload = function(){
    renderPieChart();
    requestAnimationFrame(function(){
        setTimeout(function(){ window.print(); }, 500);
    });
};
</script>

</body>
</html>