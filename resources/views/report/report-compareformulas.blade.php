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
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6"><h3 class="card-title">เปรียบเทียบผลทดลอง</h3></div>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table id="tb_job" class="table table-bordered text-center table-sm">
                        <thead>
                            <tr>
                                <th></th>
                                <th>วันที่</th>
                                <th>เลขที่สูตร</th>
                                <th>ชื่อสูตร</th>                               
                                <th>Hardness (HRB)</th>
                                <th>Shearing (mm²)</th>
                                <th>Noise (dB)</th>
                                {{-- <th>RoadTest</th> --}}
                                <th>Normal (µ)</th>
                                <th>Hot (µ)</th>
                                <th>Wear (10−7cm3/(N⋅m))</th>
                                <th>หมายเหตุ</th>
                            </tr>
                        </thead> 
                        <tbody>
                            @foreach ($hd as $item)
                                <tr
                                data-formula="{{$item->FormulaNumber}}"
                                data-hardness="{{$item->Hardness}}"
                                data-shearing="{{$item->Shearing}}"
                                data-noise="{{$item->Noise}}"
                                {{-- data-road="{{$item->RoadTestAvg}}" --}}
                                data-normal="{{$item->Normal_Avg}}"
                                data-hot="{{$item->Hot_Avg}}"
                                data-wear="{{$item->Wear_Avg}}"
                                data-testid="{{$item->TestID}}"
                                >
                                    <td>
                                        <input type="checkbox"
                                        class="chkFormula"
                                        value="{{$item->TestID}}">
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->TestDate)->format('d/m/Y') }}</td>
                                    <td>{{$item->FormulaName}}</td>
                                    <td>{{$item->FormulaNumber}}</td>                                  
                                    <td>{{number_format($item->Hardness,2)}}</td>
                                    <td>{{number_format($item->Shearing,2)}}</td>
                                    <td>{{number_format($item->Noise,2)}}</td>
                                    {{-- <td>{{number_format($item->RoadTestAvg,2)}}</td> --}}
                                    <td>{{number_format($item->Normal_Avg,2)}}</td>
                                    <td>{{number_format($item->Hot_Avg,2)}}</td>
                                    <td>{{number_format($item->Wear_Avg,2)}}</td>
                                    <td>{{$item->Remarks}}</td>
                                </tr>
                            @endforeach
                        </tbody>                      
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5>รายละเอียด</h5>
            <div class="row">
                <div class="col-md-12">
                    <table id="tb_result" class="table table-bordered table-sm text-center">
                        <thead>
                            <tr>
                                <th>Metric</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr data-metric="hardness">
                                <th>Hardness (HRB)</th>
                            </tr>

                            <tr data-metric="shearing">
                                <th>Shearing (mm²)</th>
                            </tr>

                            <tr data-metric="noise">
                                <th>Noise (dB)</th>
                            </tr>

                            {{-- <tr data-metric="road">
                                <th>RoadTest</th>
                            </tr> --}}

                            <tr data-metric="normal">
                                <th>Normal (µ)</th>
                            </tr>

                            <tr data-metric="hot">
                                <th>Hot (µ)</th>
                            </tr>

                            <tr data-metric="wear">
                                <th>Wear (10−7cm3/(N⋅m))</th>
                            </tr>

                        </tbody>
                    </table>
                </div>             
            </div>
            <div class="row">

                <div class="col-md-6">
                    <h5>Hardness (HRB)</h5>
                    <canvas id="chartHardness" height="120">
                </canvas></div>
                <div class="col-md-6">
                    <h5>Shearing (mm²)</h5>
                    <canvas id="chartShearing" height="120"></canvas>
                </div>

                <div class="col-md-6">
                    <h5>Noise (dB)</h5>
                    <canvas id="chartNoise" height="120"></canvas>
                </div>
               

                <div class="col-md-6">
                    <h5>Normal (µ)</h5>
                    <canvas id="chartNormal" height="120"></canvas>
                </div>
                <div class="col-md-6">
                    <h5>Hot (µ)</h5>
                    <canvas id="chartHot" height="120"></canvas>
                </div>

                <div class="col-md-6">
                    <h5>Wear (10−7cm3/(N⋅m))</h5>
                    <canvas id="chartWear" height="120"></canvas>
                </div>
                {{-- <div class="col-md-6">
                    <h5>RoadTest</h5>
                    <canvas id="chartRoad"></canvas>
                </div>              --}}
            </div>
            <div class="row g-1">
                <!-- 100°C u -->
                <div class="col-md-4">
                    <canvas id="chartU100" height="180"></canvas>
                </div>
                 <!-- 150°C u -->
                <div class="col-md-4">
                    <canvas id="chartU150" height="180"></canvas>
                </div>
                   <!-- 200°C u -->
                <div class="col-md-4">
                    <canvas id="chartU200" height="180"></canvas>
                </div>
                <!-- 250°C u -->
                <div class="col-md-4">
                    <canvas id="chartU250" height="180"></canvas>
                </div>
                <!-- 300°C u -->
                <div class="col-md-4">
                    <canvas id="chartU300" height="180"></canvas>
                </div>
                <!-- 350°C u -->
                <div class="col-md-4">
                    <canvas id="chartU350" height="180"></canvas>
                </div>

                <!-- 100°C c -->
                <div class="col-md-4">
                    <canvas id="chartC100" height="180"></canvas>
                </div>
                <!-- 150°C c -->
                <div class="col-md-4">
                    <canvas id="chartC150" height="180"></canvas>
                </div>
                <!-- 200°C c -->
                <div class="col-md-4">
                    <canvas id="chartC200" height="180"></canvas>
                </div>
                <!-- 250°C c -->
                <div class="col-md-4">
                    <canvas id="chartC250" height="180"></canvas>
                </div>
                <!-- 300°C c -->
                <div class="col-md-4">
                    <canvas id="chartC300" height="180"></canvas>
                </div>
                <!-- 350°C c -->
                <div class="col-md-4">
                    <canvas id="chartC350" height="180"></canvas>
                </div>

                <!-- FALL°C u -->
                <div class="col-md-6">
                    <canvas id="chartUfall" height="180"></canvas>
                </div>
                <!-- FALL°C c -->
                <div class="col-md-6">
                    <canvas id="chartCfall" height="180"></canvas>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection
@push('scriptjs')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
$(document).ready(function() {
    $('#tb_job').DataTable({
        "pageLength": 20,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    })
});
const palette = [
    "#4e79a7",
    "#f28e2b",
    "#e15759",
    "#76b7b2",
    "#59a14f",
    "#edc948",
    "#b07aa1",
    "#ff9da7",
    "#9c755f",
    "#bab0ac"
];

let formulaColors = {};

function assignColors(){

    formulaColors = {};

    let i = 0;

    $(".chkFormula:checked").each(function(){

        let formula =
            $(this)
            .closest("tr")
            .data("formula");

        formulaColors[formula] =
            palette[i % palette.length];

        i++;

    });

}

function getColor(formula){

    return formulaColors[formula] ?? "#999";

}
let charts = {};

function buildCharts(){

    let formulas = [];

    $("#tb_result thead th[data-formula]").each(function(){

        formulas.push($(this).text());

    });

  function getMetricDatasets(metric){

    let datasets = [];

    $("#tb_result thead th[data-formula]").each(function(){

        let formula = $(this).text().trim();

        let cell =
            $("#tb_result tbody tr[data-metric='"+metric+"']")
            .find("td[data-formula='"+formula+"']");

        let value = parseFloat(cell.text());

        let color = getColor(formula);

        datasets.push({

            label: formula,
            data: [value],

            backgroundColor: color,
            borderColor: color,
            borderWidth: 1

        });

    });

    return datasets;

}

    createChart("chartHardness","Hardness",["Value"],getMetricDatasets("hardness"));
    createChart("chartShearing","Shearing",["Value"],getMetricDatasets("shearing"));
    createChart("chartNoise","Noise",["Value"],getMetricDatasets("noise"));
    createChart("chartNormal","Normal",["Value"],getMetricDatasets("normal"));
    createChart("chartHot","Hot",["Value"],getMetricDatasets("hot"));
    createChart("chartWear","Wear",["Value"],getMetricDatasets("wear"));

}

function createChart(canvasId, label, labels, datasets) {

    let ctx = document.getElementById(canvasId);

    if (charts[canvasId]) {
        charts[canvasId].destroy();
    }

    charts[canvasId] = new Chart(ctx, {

        type: 'bar',

        data: {

            labels: labels,
            datasets: datasets

        },

        options: {

            responsive: true,

            plugins: {

                legend: {

                    position: 'top'

                },

                datalabels: {

                    anchor: 'end',
                    align: 'top',

                    formatter: function(value) {

                        return value.toFixed(2);

                    },

                    font: {

                        weight: 'bold'

                    }

                }

            },

            scales: {

                y: {

                    beginAtZero: true

                }

            }

        },

        plugins: [ChartDataLabels]

    });

}

function addColumn(formula,data){

    let color = getColor(formula);

    if($("#tb_result thead th[data-formula='"+formula+"']").length===0){

        $("#tb_result thead tr").append(`
            <th data-formula="${formula}"
                style="
                    background:${color};
                    color:white;
                    border:2px solid ${color};
                    font-weight:600">
                ${formula}
            </th>
        `);

    }

    appendCell("hardness", formula, data.hardness);
    appendCell("shearing", formula, data.shearing);
    appendCell("noise", formula, data.noise);
    appendCell("normal", formula, data.normal);
    appendCell("hot", formula, data.hot);
    appendCell("wear", formula, data.wear);

}


function appendCell(metric, formula, value) {

    let row = $("#tb_result tbody tr[data-metric='"+metric+"']");

    if (row.find("td[data-formula='"+formula+"']").length === 0) {

        row.append(`
            <td data-formula="${formula}">
                ${parseFloat(value).toFixed(2)}
            </td>
        `);

    }

}


function removeColumn(formula) {

    $("#tb_result th[data-formula='"+formula+"']").remove();
    $("#tb_result td[data-formula='"+formula+"']").remove();

}

$(document).on("change",".chkFormula",async function(){

    assignColors();   // << เพิ่มตรงนี้

    $("#tb_result thead th[data-formula]").remove();
    $("#tb_result td[data-formula]").remove();

    $(".chkFormula:checked").each(function(){

        let row = $(this).closest("tr");

        let formula = row.data("formula");

        let data = {

            hardness : row.data("hardness"),
            shearing : row.data("shearing"),
            noise : row.data("noise"),
            normal : row.data("normal"),
            hot : row.data("hot"),
            wear : row.data("wear")

        };

        addColumn(formula,data);

    });

    buildCharts();

    await renderFrictionCharts();

});

function getSelectedTestID(){
    let ids = [];

    $('.chkFormula:checked').each(function () {
        ids.push($(this).val());
    });

    return ids;
}
async function loadFrictionChart(){

    let ids = getSelectedTestID();

    if(ids.length===0) return null;

    return await $.ajax({

        url:'/get-friction-chart',
        type:'POST',

        data:{
            _token:'{{ csrf_token() }}',
            testIDs:ids
        }

    });

}

function buildDatasetsByFormula(dataObj,labelSuffix,labels){

    let datasets = [];

    Object.keys(dataObj).forEach(testID=>{

        let formula =
            $("tr[data-testid='"+testID+"']")
            .data("formula");

        let color = getColor(formula);

        datasets.push({

            label: formula + " " + labelSuffix,

            data: dataObj[testID].map((y,i)=>({

                x: labels[i],     // <<< ใช้ค่า X จริง
                y: y

            })),

            borderColor: color,
            backgroundColor: color,

            tension: 0.05,
            borderWidth: 2,
            pointRadius: 0

        });

    });

    return datasets;

}

function createLineChart(canvasId, labels, datasets, yMax, xMax = 500){

    if(charts[canvasId]){
        charts[canvasId].destroy();
    }

    charts[canvasId] = new Chart(
        document.getElementById(canvasId),
        {
            type:'line',

            data:{
                datasets: datasets
            },

            options:{
                responsive:true,
                maintainAspectRatio:false,

                plugins:{
                    legend:{ position:'top' }
                },

                scales:{
                    x:{
                        type:'linear',
                        min:0,
                        max:xMax,        // <<< dynamic
                        ticks:{
                            stepSize:50
                        }
                    },

                    y:{
                        min:0,
                        max:yMax
                    }
                }
            }
        }
    );
}

async function renderFrictionCharts(){

    let res = await loadFrictionChart();
    console.log(res); 
    if(!res) return;

const temps = [
    100,
    150,
    200,
    250,
    300,
    350,
    {key:'Fall', id:'fall'}
];

temps.forEach(t=>{

    let key = typeof t === 'object' ? t.key : t;
    let id  = typeof t === 'object' ? t.id  : t;

    if(!res[key]) return;

    let labels = res[key].labels;

    let xMax = (id === 'fall') ? 750 : 500;

    createLineChart(

        "chartU"+id,
        labels,

        buildDatasetsByFormula(
            res[key].u,
            key+"°C (u)",
            labels
        ),

        0.8,
        xMax
    );

    createLineChart(

        "chartC"+id,
        labels,

        buildDatasetsByFormula(
            res[key].c,
            key+"°C (c)",
            labels
        ),

        400,
        xMax
    );

});
}
</script>
@endpush