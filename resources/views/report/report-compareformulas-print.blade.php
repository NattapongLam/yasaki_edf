<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<style>

body{
    font-family: Arial, Helvetica, sans-serif;
    font-size:10px;
    margin:0;
    line-height:1.25;
}

/* A4 */

@page{
    size:A4 portrait;
    margin:6mm;
}

/* header */

.header{
    margin-bottom:4px;
}

.header-top{
    display:flex;
    align-items:center;
}

.logo{
    width:75px;
}

.company{
    flex:1;
    padding-left:6px;
    font-size:10px;
}

.company b{
    font-size:12px;
}

.report-title{
    text-align:center;
    font-size:14px;
    font-weight:bold;
    margin:4px 0 5px 0;
}

/* layout */

.grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:6px;
}

/* table */

table{
    width:100%;
    border-collapse:collapse;
}

table,th,td{
    border:1px solid #000;
}

th{
    text-align:left;
    font-weight:bold;
    background:#f7f7f7;
    width:55%;
}

td{
    text-align:left;
}

th,td{
    padding:3px 4px;
}

/* section */

.section-title{
    text-align:center;
    font-size:13px;
    font-weight:bold;
    margin:6px 0 4px 0;
}

/* note */

.note{
    margin-top:6px;
    font-size:10px;
    color:#c00000;
    text-align:center;
    font-style:italic;
}

/* result table */

.result-table{
    table-layout:fixed;
    font-size:10px;
}

.result-table th,
.result-table td{
    padding:2px 3px;
    text-align:center;
}

.result-table thead th{
    background:#efefef;
    font-weight:bold;
}

/* column width */

.col-temp{width:9%}
.col-fr{width:10%}
.col-wr{width:11%}
.col-avg{width:14%}

/* signature */

.signature{
    border:1.5px solid #000;
    margin-top:6px;
    padding:6px 8px 5px 8px;
    page-break-inside:avoid;
}

.signature-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.sign-box{
    text-align:center;
    font-size:11px;
}

.sign-line{
    margin-top:28px;
    border-top:1px solid #000;
    padding-top:3px;
    font-size:10px;
}

.tester{
    margin-top:6px;
    border-top:1px dashed #000;
    padding-top:4px;
    font-size:10px;
}

/* prevent cut */

.no-break{
    page-break-inside:avoid;
}

hr{
    border:0;
    border-top:1px solid #000;
    margin:5px 0;
}
.chart-box{
    height:180px;
    width:660px;     /* ไม่เกิน printable width */
    margin:3px auto; /* จัดกลาง */
}

.chart-box canvas{
    height:95px !important;
    width:100% !important;
}

.chart-title{
    text-align:center;
    font-size:10px;
    font-weight:bold;
    margin-bottom:1px;
}
</style>

</head>

<body>


<div class="header">

<div class="header-top">

<div class="logo">
<img src="{{ URL::asset('assets/images/KK-C.png') }}" height="50">
</div>

<div class="company">
<b>บริษัท เคเคแอนด์ซี พาร์ท จำกัด</b><br>
588/35 ชั้น M ถ.สาธุประดิษฐ์ แขวงบางโพงพาง เขตยานนาวา กรุงเทพมหานคร 10120
</div>

</div>

<div class="report-title">
รายงานผลการทดสอบค่าสัมประสิทธิ์แรงเสียดทาน
</div>

</div>


<!-- general -->

<div class="grid no-break">

<table>

<tr>
<th>หมายเลขห้องปฏิบัติการ</th>
<td></td>
</tr>

<tr>
<th>หมายเลขอ้างอิง</th>
<td></td>
</tr>

<tr>
<th>รายละเอียดตัวอย่าง</th>
<td></td>
</tr>

<tr>
<th>หมายเลขตัวอย่าง</th>
<td></td>
</tr>

<tr>
<th>วันที่รับตัวอย่าง</th>
<td></td>
</tr>

</table>


<table>

<tr>
<th>วันที่ทดสอบ</th>
<td>{{ $hd->TestDate }}</td>
</tr>

<tr>
<th>วันที่ออกรายงาน</th>
<td></td>
</tr>

<tr>
<th>มาตรฐานทดสอบ</th>
<td>XXX-XXXX</td>
</tr>

<tr>
<th>ผลการทดสอบ</th>
<td>XXX-XXXX</td>
</tr>

</table>

</div>


<!-- condition -->

<div class="section-title">
ค่าควบคุมการทดสอบ
</div>

<div class="grid no-break">

<table>

<tr>
<th>อุณหภูมิห้อง 25-31 °C</th>
<td>XXX-XXXX</td>
</tr>

<tr>
<th>ความชื้น 40-60% RH</th>
<td>XXX-XXXX</td>
</tr>

<tr>
<th>วัสดุจานทดสอบ</th>
<td>XXX-XXXX</td>
</tr>

<tr>
<th>ประเภทการทดสอบ</th>
<td>{{ $hd->TestType }}</td>
</tr>

</table>


<table>

<tr>
<th>จำนวนชุดที่ทดสอบ</th>
<td>3 ชุด</td>
</tr>

<tr>
<th>ช่วงอุณหภูมิที่ทดสอบได้</th>
<td>100-350 °C</td>
</tr>

<tr>
<th>ช่วงค่าแรงเสียดทาน</th>
<td>0.00-0.080 (μ) </td>
</tr>

<tr>
<th>Uncertainty (95%)</th>
<td>± 0.032 (μ)</td>
</tr>

</table>

</div>

<div class="note">
หมายเหตุ: Uncertainty ที่รายงาน มีระดับความเชื่อมั่น 95% (k=2)
</div>


<!-- sample detail -->

<div class="section-title">
รายละเอียดงานตัวอย่างทดสอบ
</div>

<div class="grid no-break">

<table>

<tr>
<th>เครื่องหมายการค้า</th>
<td>XXX-XXXX</td>
</tr>

<tr>
<th>ชื่อสูตร</th>
<td>{{ $hd->FormulaName }}</td>
</tr>

<tr>
<th>รหัสสูตร</th>
<td>{{ $hd->FormulaNumber }}</td>
</tr>

<tr>
<th>ล๊อตผลิต</th>
<td>XXX-XXXX</td>
</tr>

<tr>
<th>โรงงานผลิต</th>
<td>บริษัท สื่ออินดัสเทรียล จำกัด</td>
</tr>

</table>


<table>

<tr>
<th>ประเภทงานทดสอบ</th>
<td>ผ้าเบรก/ดิสเบรค</td>
</tr>

<tr>
<th>ขนาดตัวอย่าง</th>
<td>25X25X7 มม. (ความหนา ± 0.2 มม.)</td>
</tr>

<tr>
<th>ก่อนทดสอบ</th>
<td>ไม่แตก/ไม่หัก/ไม่ร้าว</td>
</tr>

<tr>
<th>หลังทดสอบ</th>
<td>ไม่แตก/ไม่หัก/ไม่ร้าว</td>
</tr>

</table>

</div>


<br>


<!-- result -->

<table class="result-table no-break">

<thead>

<tr>
<th colspan="4">FRICTION (μ)</th>
<th colspan="3">WEAR RATE (10⁻⁷ cm³/N·m)</th>
<th colspan="2">AVERAGE RESULT</th>
</tr>

<tr>

<th class="col-temp">Temp °C</th>

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
หมายเหตุ: หน่วยของสัมประสิทธิ์แรงเสียดทาน (Coefficient of Friction - COF) ใช้เป็น µ
</div>

</div>

<div class="chart-box no-break">
   
    <canvas id="wearRateChart"></canvas>
     <div class="chart-title">
       หมายเหตุ: ค่าอัตราการสึกหรอ Wear Rate ใช้หน่วยเป็น( 10^-7 cm^3/N.m )
    </div>
</div>

<!-- signature -->

<div class="signature no-break">

<div class="signature-grid">

<div class="sign-box">
ผู้ตรวจสอบ
<div class="sign-line">
วันที่ ....../....../......
</div>
</div>

<div class="sign-box">
ผู้รับรอง
<div class="sign-line">
วันที่ ....../....../......
</div>
</div>

</div>

<div class="tester">
ผู้ทดสอบ {{ $hd->TesterName }} | วันที่ {{ $hd->TestDate }}
</div>

</div>


<div style="page-break-after:always;"></div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

window.onload=function(){
    window.print();
}

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

/*
|--------------------------------------------------------------------------
| SAFE ZONE (background)
|--------------------------------------------------------------------------
*/

{
data:safeUpper,
borderWidth:0,
pointRadius:0,
fill:'+1'
},

{
data:safeLower,
borderWidth:0,
pointRadius:0,
fill:false
},

/*
|--------------------------------------------------------------------------
| JIS LIMIT
|--------------------------------------------------------------------------
*/

{
data:jisMax,
borderDash:[6,6],
borderWidth:1,
pointRadius:0
},

{
data:jisMin,
borderDash:[6,6],
borderWidth:1,
pointRadius:0
},

/*
|--------------------------------------------------------------------------
| TARGET LIMIT
|--------------------------------------------------------------------------
*/

{
data:targetUpper,
borderDash:[2,2],
borderWidth:1,
pointRadius:0
},

{
data:targetLower,
borderDash:[2,2],
borderWidth:1,
pointRadius:0
},

/*
|--------------------------------------------------------------------------
| ACTUAL LINE
|--------------------------------------------------------------------------
*/

{
label:'Friction Avg',
data:frictionPoints,
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
text:'Temperature °C'
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
// document.addEventListener("DOMContentLoaded", function () {

//     const points = @json($frictionPoints ?? []);

//     const labels = Object.keys(points);
//     const values = Object.values(points);

//     const chart = new Chart(document.getElementById('frictionChart'), {

//         type: 'line',

//         data: {

//             labels: labels,

//             datasets: [

//                 {
//                     label: 'Friction Avg',
//                     data: values,
//                     borderWidth: 2,
//                     pointRadius: 3,
//                     tension: 0.2
//                 },

//                 {
//                     label: 'Limit Min',
//                     data: labels.map(() => 0.35),
//                     borderDash: [4,4],
//                     borderWidth: 1,
//                     pointRadius: 0
//                 },

//                 {
//                     label: 'Limit Max',
//                     data: labels.map(() => 0.55),
//                     borderDash: [4,4],
//                     borderWidth: 1,
//                     pointRadius: 0
//                 }

//             ]

//         },

//         options: {

//             responsive: true,
//             maintainAspectRatio: false,

//             animation:false, // สำคัญสำหรับ print
//             layout:{
//                 padding:0
//                 },
//             plugins:{
//                 legend:{ display:false }
//             },

//             scales: {

//                 x: {
//                     title:{
//                         display:true,
//                         text:'Temperature °C'
//                     }
//                 },

//                 y: {

//                     title:{
//                         display:true,
//                         text:'Friction (μ)'
//                     },

//                     min:0,
//                     max:0.8,

//                     ticks:{
//                         stepSize:0.2,
//                         callback:(v)=>v.toFixed(1)
//                     }

//                 }

//             }

//         }

//     });

//     // รอ render เสร็จแล้วค่อย print
//     setTimeout(()=>window.print(),500);

// });
// document.addEventListener("DOMContentLoaded", function () {

//     const points = @json($wearRatePoints ?? []);

//     const labels = Object.keys(points);
//     const values = Object.values(points);

//     const chart = new Chart(document.getElementById('wearRateChart'), {

//         type: 'line',

//         data: {

//             labels: labels,

//             datasets: [

//                 {
//                     label: 'Wear Rate Avg',
//                     data: values,
//                     borderWidth: 2,
//                     pointRadius: 3,
//                     tension: 0.2
//                 },

//                 {
//                     label: 'Limit Min',
//                     data: labels.map(() => 0.35),
//                     borderDash: [4,4],
//                     borderWidth: 1,
//                     pointRadius: 0
//                 },

//                 {
//                     label: 'Limit Max',
//                     data: labels.map(() => 0.55),
//                     borderDash: [4,4],
//                     borderWidth: 1,
//                     pointRadius: 0
//                 }

//             ]

//         },

//         options: {

//             responsive: true,
//             maintainAspectRatio: false,

//             animation:false, // สำคัญสำหรับ print
//             layout:{
//                 padding:0
//                 },
//             plugins:{
//                 legend:{ display:false }
//             },

//             scales: {

//                 x: {
//                     title:{
//                         display:true,
//                         text:'Temperature °C'
//                     }
//                 },

//                 y: {

//                     title:{
//                         display:true,
//                         text:'"WEAR RATE (10⁻⁷ cm³/N·m)'
//                     },

//                     min:0,
//                     max:1.6,

//                     ticks:{
//                         stepSize:0.2,
//                         callback:(v)=>v.toFixed(1)
//                     }

//                 }

//             }

//         }

//     });

//     // รอ render เสร็จแล้วค่อย print
//     setTimeout(()=>window.print(),500);

// });
</script>

</body>
</html>