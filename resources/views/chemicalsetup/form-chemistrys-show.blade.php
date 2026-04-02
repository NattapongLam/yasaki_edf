@extends('layouts.main')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
            <div class="col-12 col-md-6"><h3 class="card-title">จัดการเคมี</h3></div>
        </div>
        <form method="POST" class="form-horizontal" action="{{ route('chemistrys.update',$hd->chemistry_hd_id) }}" enctype="multipart/form-data">
        @csrf     
        @method('PUT')     
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="chemistry_hd_date" class="col-form-label">วันที่</label>
                    <input type="date" class="form-control" name="chemistry_hd_date" id="chemistry_hd_date" value="{{$hd->chemistry_hd_date}}" readonly>
                </div>
            </div> 
            <div class="col-3">
                <div class="form-group">
                    <label for="ms_formule_name" class="col-form-label">ชื่อสูตร</label>
                    <input type="text" class="form-control" name="ms_formule_name" id="ms_formule_name" value="{{$hd->ms_formule_name}}" readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="chemistry_hd_name" class="col-form-label">เลขที่สูตร</label>
                    <input type="text" class="form-control" name="chemistry_hd_name" id="chemistry_hd_name" value="{{$hd->chemistry_hd_name}}" readonly>
                </div>
            </div>
             <div class="col-3">
                <div class="form-group">
                    <label for="ms_formule_name" class="col-form-label">ประเภท</label>
                    <select class="form-select" name="chemistry_hd_type" required>
                        <option value="">เลือกประเภท</option>
                        @foreach ($types as $item)
                            <option value="{{ $item->chemistry_type_name }}"
                                {{ $hd->chemistry_hd_type == $item->chemistry_type_name ? 'selected' : '' }}>
                                {{ $item->chemistry_type_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>    
        </div> 
        <div class="row">                    
             <div class="col-3">
                <div class="form-group">
                    <label for="update_at" class="col-form-label">อัพเดทล่าสุด</label>
                    <input type="date"
                    class="form-control"
                    name="update_at"
                    id="update_at"
                    value="{{ \Carbon\Carbon::parse($hd->update_at)->format('Y-m-d') }}"
                    readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="chemistry_hd_mix" class="col-form-label">Mixing (kg/Batch)</label>
                    <input type="number" class="form-control" name="chemistry_hd_mix" id="chemistry_hd_mix" value="{{$hd->chemistry_hd_mix}}" readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="chemistry_hd_qty" class="col-form-label">Total (W)</label>
                    <input type="number" class="form-control" name="chemistry_hd_qty" id="chemistry_hd_qty" value="{{$hd->chemistry_hd_qty}}" readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="col-form-label">ประเภทคำนวณ</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="chemistry_hd_calculate"
                                id="formRadios1"
                                value="vol"
                                {{ $hd->chemistry_hd_calculate == 'vol' ? 'checked' : '' }}>
                            <label class="form-check-label" for="formRadios1">Vol %</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="chemistry_hd_calculate"
                                id="formRadios2"
                                value="w"
                                {{ $hd->chemistry_hd_calculate == 'w' ? 'checked' : '' }}>
                            <label class="form-check-label" for="formRadios2">W %</label>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="chemistry_hd_note" class="col-form-label">หมายเหตุ</label>
                    <textarea class="form-control" rows="5" name="chemistry_hd_note">{{$hd->chemistry_hd_note}}</textarea>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <h5 style="color: black">รายละเอียด</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-sm text-center">
                <thead style="color: black">
                    <tr>
                        <th style="width: 3%">No.</th>
                        <th style="width: 35%">Material</th>
                        <th style="width: 10%">Density(g/cc)</th>
                        <th style="width: 10%">Vol.% adjust</th>
                        <th style="width: 10%">Volume(1kg)</th>
                        <th style="width: 10%">W (%)</th>
                        <th style="width: 10%">Weght(g)</th>
                    </tr>
                </thead>
                <tbody id="tableBody" style="color: black">
                    @foreach ($dt as $item)
                    <tr 
                        style="{{ $item->chemical_groups_color ? 'background-color: '.$item->chemical_groups_color : '' }}"
                        data-group="{{ $item->chemical_groups_name }}"
                        data-color="{{ $item->chemical_groups_color }}"
                    >
                        <td>
                            {{ $item->no }}
                            <input type="hidden" name="chemistry_dt_id[]" value="{{$item->chemistry_dt_id}}">
                        </td>
                        <td>
                            <select class="form-control select2-product" name="code[]">
                                <option value="">เลือกสินค้า</option>
                                @foreach ($products as $product)
                                    <option value="{{$product->chemical_lists_refcode}}"
                                        {{$item->code == $product->chemical_lists_refcode ? 'selected' : '' }}
                                        data-density="{{ number_format($product->chemical_lists_density,2,'.','') }}"
                                        data-group="{{ $item->chemical_groups_name }}"
                                        data-color="{{ $item->chemical_groups_color }}">
                                        {{$product->chemical_lists_refcode}} - {{$product->chemical_lists_name}} ({{$product->chemical_lists_grade}})
                                        สต็อค : {{number_format($product->chemical_lists_stc,2)}}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="group[]" class="form-control group" value=""/>
                            <input type="hidden" name="color[]" class="form-control color" value=""/>
                        </td>
                        <td><input type="number" step="0.01" name="density[]" class="form-control density" value="{{ number_format($item->density,2,'.','') }}"/></td>
                        <td>
                            <input type="number" step="0.01" name="adjust[]" 
                                class="form-control adjust"
                                value="{{ number_format($item->adjust, 2, '.', '') }}">
                        </td>

                        <td>
                            <input type="number" step="0.01" name="weght[]" 
                                class="form-control weght"
                                value="{{ number_format($item->weght, 2, '.', '') }}">
                        </td>

                        <td>
                            <input type="number" step="0.01" name="weghtper[]" 
                                class="form-control weghtper"
                                value="{{ number_format($item->weghtper, 2, '.', '') }}">
                        </td>

                        <td>
                            <input type="number" step="0.01" name="weghttotal[]" 
                                class="form-control weghttotal"
                                value="{{ number_format($item->weghttotal, 2, '.', '') }}">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-end">Total</th>
                        <th id="sumDensity">0</th>
                        <th id="sumAdjust">0</th>
                        <th id="sumWeight">0</th>
                        <th id="sumWeightPer">0</th>
                        <th id="sumWeightTotal">0</th>
                    </tr>
                </tfoot>
            </table>
            </div>           
        </div>
        <br>
            <div class="col-12 col-md-1">
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary">
                        บันทึก
                    </button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-6 d-flex justify-content-center">
                <h5>Adjust (%)</h5>
                <div style="width:500px; height:500px;">
                    <canvas id="donutChart"></canvas>
                </div>
            </div>
            <div class="col-6 d-flex justify-content-center">
                <h5>Weght (g)</h5>
                <div style="width:500px; height:500px;">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>         
        <hr>
        <div class="row">
            <h5 style="color: black">ผลการทดสอบ</h5>
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
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>วันที่</th>
                        <th>Hardness (HRB)</th>
                        <th>Shearing (mm²)</th>
                        <th>Noise (dB)</th>
                        <th>RoadTest</th>
                        <th>Normal (µ)</th>
                        <th>Hot (µ)</th>
                        <th>Wear (10−7cm3/(N⋅m))</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lap as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->TestDate)->format('d/m/Y') }}</td>
                            <td>{{ number_format($item->Hardness,4) }}</td>
                            <td>{{ number_format($item->Shearing,4) }}</td>
                            <td>{{ number_format($item->Noise,4) }}</td>
                            <td>{{ number_format($item->RoadTestAvg,4) }}</td>
                            <td>{{ number_format($item->Normal_Avg,4) }}</td>
                            <td>{{ number_format($item->Hot_Avg,4) }}</td>
                            <td>{{ number_format($item->Wear_Avg,4) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="font-weight:bold; background:#f2f2f2;">
                        <td>AVG</td>
                        <td>{{ number_format($lap->avg('Hardness'),4) }}</td>
                        <td>{{ number_format($lap->avg('Shearing'),4) }}</td>
                        <td>{{ number_format($lap->avg('Noise'),4) }}</td>
                        <td>{{ number_format($lap->avg('RoadTestAvg'),4) }}</td>
                        <td>{{ number_format($lap->avg('Normal_Avg'),4) }}</td>
                        <td>{{ number_format($lap->avg('Hot_Avg'),4) }}</td>
                        <td>{{ number_format($lap->avg('Wear_Avg'),4) }}</td>
                    </tr>
                </tfoot>
            </table>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <canvas id="radarChart"></canvas>
            </div>
            <div class="col-6">
                <canvas id="lineChart" height="300"></canvas>
            </div>
        </div>
        <hr>    
        @php
            $groupedByDateTemp = $test->groupBy(function($item){
                return $item->TestDate;
            });
            $temps = $test->pluck('Temperature')->unique();
            $grouped = $test->groupBy('Temperature');
            $samples = $test->pluck('SampleSet')->unique();
        @endphp

        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered text-center table-sm">
                <thead>
                    <!-- แถว 1 -->
                    <tr>
                        <th rowspan="2">Temperature</th>
                        <th colspan="{{ $samples->count() }}">WearRate</th>
                        <th colspan="{{ $samples->count() }}">T_Inc</th>
                        <th colspan="{{ $samples->count() }}">T_Dec</th>
                    </tr>

                    <!-- แถว 2 -->
                    <tr>
                        @for ($i = 0; $i < 3; $i++)
                            @foreach ($samples as $sample)
                                <th>{{ $sample }}</th>
                            @endforeach
                        @endfor
                    </tr>
                </thead>

                <tbody>
                    @foreach ($grouped as $temp => $rows)
                        <tr>
                            <td>{{ $temp }}</td>

                            {{-- WearRate --}}
                            @foreach ($samples as $sample)
                                @php
                                    $avg = $rows->where('SampleSet', $sample)->avg('WearRate');
                                @endphp
                                <td>{{ $avg !== null ? number_format($avg,4) : '-' }}</td>
                            @endforeach

                            {{-- T_Inc --}}
                            @foreach ($samples as $sample)
                                @php
                                    $avg = $rows->where('SampleSet', $sample)->avg('T_Inc');
                                @endphp
                                <td>{{ $avg !== null ? number_format($avg,4) : '-' }}</td>
                            @endforeach

                            {{-- T_Dec --}}
                            @foreach ($samples as $sample)
                                @php
                                    $avg = $rows->where('SampleSet', $sample)->avg('T_Dec');
                                @endphp
                                <td>{{ $avg !== null ? number_format($avg,4) : '-' }}</td>
                            @endforeach

                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        <div class="row">
            @foreach($temps as $temp)
                <div class="col-4 mb-5">
                    <h5>{{ $temp }}°C</h5>
                    <canvas id="wearChart_{{ $temp }}"></canvas>
                </div>
            @endforeach
        </div>  
        <div class="row">
            @foreach($temps as $temp)
                <div class="col-4 mb-5">
                    <h5>{{ $temp }}°C</h5>
                    <canvas id="incChart_{{ $temp }}"></canvas>
                </div>
            @endforeach
        </div> 
        <div class="row">
            @foreach($temps as $temp)
                <div class="col-4 mb-5">
                    <h5>{{ $temp }}°C</h5>
                    <canvas id="decChart_{{ $temp }}"></canvas>
                </div>
            @endforeach
        </div>       
    </div> 
</div>
</div>
@endsection
@push('scriptjs')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
let pieChart = null;
function showOverLimit(msg) {
    Swal.fire({
        icon: 'warning',
        title: 'เกิน 100%',
        text: msg,
        confirmButtonText: 'ตกลง'
    });
}

/* ===================== INIT ===================== */
$(document).ready(function () {

    $('.select2-product').select2({
        placeholder: 'เลือกสินค้า'
    });

    initRowData();
    calculateTable();
});

/* ===================== INIT ROW ===================== */
function initRowData() {
    $('#tableBody tr').each(function () {
        const row = $(this);

        const group = row.data('group') || '';
        const color = normalizeColor(row.data('color'));

        row.find('.group').val(group);
        row.find('.color').val(color);
    });
}

/* ===================== COLOR ===================== */
function normalizeColor(color) {
    if (!color) return '';
    color = color.toString().trim();

    if (color.startsWith('rgb')) return color;
    if (!color.startsWith('#')) color = '#' + color;

    return color;
}

/* ===================== SELECT PRODUCT ===================== */
$(document).on('change', '.select2-product', function () {

    const selected = $(this).find(':selected');

    const density = selected.attr('data-density') || 0;
    const group = selected.attr('data-group') || '';
    const color = normalizeColor(selected.attr('data-color'));

    const row = $(this).closest('tr');

    row.find('.density').val(parseFloat(density).toFixed(2));
    row.find('.group').val(group);
    row.find('.color').val(color);

    // color row
    row.find('td').css({ backgroundColor: '', borderLeft: '' });

    if (color) {
        row.find('td').css('background-color', color);
        row.find('td:first').css('border-left', '6px solid ' + color);
    }

    calculateTable();
});

/* ===================== EVENT (สำคัญ) ===================== */
/* 🔥 ใช้ blur เท่านั้น → พิมพ์ลื่น */
$(document).on('blur', '.adjust, .density, .weghtper, input[name="chemistry_hd_mix"]', function () {
    calculateTable();
});

/* 🔥 เปลี่ยน mode */
$(document).on('change', 'input[name="chemistry_hd_calculate"]', function () {
    calculateTable();
});

/* ===================== CALCULATE ===================== */
function calculateTable(){

    const mode =
        $('input[name="chemistry_hd_calculate"]:checked').val();

    const mixKg =
        parseFloat(
            $('input[name="chemistry_hd_mix"]').val()
        ) || 0;

    let sumDensity = 0;
    let sumAdjust = 0;
    let sumWeightPer = 0;
    let sumWeightTotal = 0;
    let sumWeight = 0;

    let totalAdjustRaw = 0;

    const rows =
        $('#tableBody tr');


    /* ================= STEP 1 ================= */

    let tmpSumWeight = 0;

    rows.each(function(){

        const row = $(this);

        const density =
            parseFloat(
                row.find('.density').val()
            ) || 0;

        let adjust =
            parseFloat(
                row.find('.adjust').val()
            ) || 0;

        let weightPer =
            parseFloat(
                row.find('.weghtper').val()
            ) || 0;



        /* ===== MODE : VOL % ===== */

        if(mode === 'vol')
        {
            if(sumAdjust + adjust > 100)
            {
                adjust = 100 - sumAdjust;

                if(adjust < 0)
                    adjust = 0;

                row.find('.adjust')
                    .val(adjust.toFixed(2));
            }

            let tmpWeight =
                density * adjust;

            tmpSumWeight += tmpWeight;
            sumAdjust += adjust;

            row.data('tmpWeight', tmpWeight);
        }



        /* ===== MODE : W % ===== */

        if(mode === 'w')
        {
            if(sumWeightPer + weightPer > 100)
            {
                weightPer =
                    100 - sumWeightPer;

                if(weightPer < 0)
                    weightPer = 0;

                row.find('.weghtper')
                    .val(weightPer.toFixed(2));
            }

            sumWeightPer += weightPer;

            let raw =
                density > 0
                ? weightPer / density
                : 0;

            row.data('adjustRaw', raw);

            totalAdjustRaw += raw;
        }

    });



    /* ================= STEP 2 ================= */

    let sumWeightExcel = 0;

    rows.each(function(){

        const row = $(this);

        const density =
            parseFloat(
                row.find('.density').val()
            ) || 0;

        let adjust =
            parseFloat(
                row.find('.adjust').val()
            ) || 0;

        let weightPer =
            parseFloat(
                row.find('.weghtper').val()
            ) || 0;



        /* ===== VOL -> W% ===== */

        if(mode === 'vol')
        {
            let tmpWeight =
                row.data('tmpWeight') || 0;

            if(tmpSumWeight > 0)
            {
                weightPer =
                    (tmpWeight / tmpSumWeight)
                    * 100;

                row.find('.weghtper')
                    .val(weightPer.toFixed(2));

                sumWeightPer += weightPer;
            }
        }



        /* ===== W% -> VOL ===== */

        if(mode === 'w')
        {
            let raw =
                row.data('adjustRaw') || 0;

            if(totalAdjustRaw > 0)
            {
                adjust =
                    (raw / totalAdjustRaw)
                    * 100;

                row.find('.adjust')
                    .val(adjust.toFixed(2));

                sumAdjust += adjust;
            }
        }



        /* ===== W ตาม Excel ===== */

        let weight = 0;

        if(density > 0)
        {
            weight =
                (
                    mixKg
                    /
                    density
                )
                *
                (
                    weightPer
                    / 100
                );
        }

        row.find('.weght')
            .val(weight.toFixed(2));

        sumWeightExcel += weight;



        /* ===== TOTAL kg ===== */

        let weightTotal =
            mixKg
            *
            weightPer
            / 100;

        row.find('.weghttotal')
            .val(weightTotal.toFixed(2));

        sumWeightTotal += weightTotal;

    });



    /* ================= TOTAL ================= */
    sumDensity = mixKg / sumWeightExcel;

    $('#sumDensity')
        .text(sumDensity.toFixed(2));

    $('#sumAdjust')
        .text(sumAdjust.toFixed(2));

    $('#sumWeightPer')
        .text(sumWeightPer.toFixed(2));

    $('#sumWeight')
        .text(sumWeightExcel.toFixed(2));

    $('#sumWeightTotal')
        .text(sumWeightTotal.toFixed(2));


    $('input[name="chemistry_hd_qty"]')
        .val(sumWeightTotal.toFixed(2));



    renderPieChart();
    renderDonutChart();

}

/* ===================== PIE ===================== */
function buildPieData() {

    const rows = document.querySelectorAll('#tableBody tr');

    const groupMap = {};
    const colorMap = {};

    rows.forEach(row => {

        const group = row.querySelector('.group')?.value || 'ไม่ระบุ';
        const value = parseFloat(row.querySelector('.weghttotal')?.value || 0);
        const color = row.querySelector('.color')?.value || '#cccccc';

        if (value <= 0) return;

        if (!groupMap[group]) {
            groupMap[group] = 0;
            colorMap[group] = color;
        }

        groupMap[group] += value;
    });

    const labels = Object.keys(groupMap);
    const data = Object.values(groupMap);
    const total = data.reduce((a, b) => a + b, 0);

    return {
        labels,
        data,
        colors: labels.map(g => colorMap[g]),
        total
    };
}

function renderPieChart() {

    const ctx = document.getElementById('pieChart').getContext('2d');
    const result = buildPieData();

    if (pieChart) {
        pieChart.destroy();
    }

    pieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: result.labels,
            datasets: [{
                data: result.data,
                backgroundColor: result.colors
            }]
        },
        plugins: [ChartDataLabels],
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.raw;
                            const percent = (value / result.total * 100).toFixed(2);
                            return `${context.label}: ${value.toFixed(2)} g (${percent}%)`;
                        }
                    }
                },
                datalabels: {
                    color: '#000',
                    formatter: function(value) {
                        const percent = (value / result.total * 100).toFixed(1);
                        return `${value.toFixed(1)}g\n${percent}%`;
                    }
                }
            }
        }
    });
}
    /* ===================== RADAR CHART ===================== */

    const avgData = [
        {{ $feeavg->avg('HardnesPercent') ?? 0 }},
        {{ $feeavg->avg('ShearingPercent') ?? 0 }},
        {{ $feeavg->avg('NoisePercent') ?? 0 }},
        {{ $feeavg->avg('RoadTestPercent') ?? 0 }},
        {{ $feeavg->avg('NormalPercent') ?? 0 }},
        {{ $feeavg->avg('HotPercent') ?? 0 }},
        {{ $feeavg->avg('WearPercent') ?? 0 }},
    ];

    const radarCtx = document.getElementById('radarChart');

    new Chart(radarCtx, {
        type: 'radar',
        data: {
            labels: ['Hardness', 'Shearing', 'Noise','RoadTest','Normal','Hot','Wear'],
            datasets: [{
                label: 'Average Result',
                data: avgData,
                fill: true,
                backgroundColor: 'rgba(13, 110, 253, 0.2)',
                borderColor: 'rgba(13, 110, 253, 1)',
                borderWidth: 2,
                pointBackgroundColor: 'rgba(13, 110, 253, 1)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                r: {
                    min: 0,
                    max: 100,
                    beginAtZero: true,
                    ticks: {
                        stepSize: 20, // ปรับ interval ได้ เช่น 10, 25
                        backdropColor: 'transparent'
                    }
                }
            }
        }
    });


    /* ===================== LINE CHART ===================== */

    const labels = [
        @foreach ($datefeeavg as $item)
            "{{ \Carbon\Carbon::parse($item->TestDate)->format('d/m/Y') }}",
        @endforeach
    ];

    const hardnessData = [
        @foreach ($datefeeavg as $item)
            {{ $item->HardnesPercent ?? 0 }},
        @endforeach
    ];

    const shearingData = [
        @foreach ($datefeeavg as $item)
            {{ $item->ShearingPercent ?? 0 }},
        @endforeach
    ];

    const noiseData = [
        @foreach ($datefeeavg as $item)
            {{ $item->NoisePercent ?? 0 }},
        @endforeach
    ];

    const roadTestData = [
        @foreach ($datefeeavg as $item)
            {{ $item->RoadTestPercent ?? 0 }},
        @endforeach
    ];

    const NormalData = [
        @foreach ($datefeeavg as $item)
            {{ $item->NormalPercent ?? 0 }},
        @endforeach
    ];

    const HotData = [
        @foreach ($datefeeavg as $item)
            {{ $item->HotPercent ?? 0 }},
        @endforeach
    ];

    const WearData = [
        @foreach ($datefeeavg as $item)
            {{ $item->WearPercent ?? 0 }},
        @endforeach
    ];
    const lineCtx = document.getElementById('lineChart');

    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Hardness',
                    data: hardnessData,
                    borderColor: '#81ecec',
                    backgroundColor: 'transparent',
                    tension: 0.3
                },
                {
                    label: 'Shearing',
                    data: shearingData,
                    borderColor: '#74b9ff',
                    backgroundColor: 'transparent',
                    tension: 0.3
                },
                {
                    label: 'Noise',
                    data: noiseData,
                    borderColor: '#a29bfe',
                    backgroundColor: 'transparent',
                    tension: 0.3
                },
                {
                    label: 'RoadTest',
                    data: roadTestData,
                    borderColor: '#fab1a0',
                    backgroundColor: 'transparent',
                    tension: 0.3
                },
                {
                    label: 'Normal',
                    data: NormalData,
                    borderColor: '#ff7675',
                    backgroundColor: 'transparent',
                    tension: 0.3
                },
                {
                    label: 'Hot',
                    data: HotData,
                    borderColor: '#fd79a8',
                    backgroundColor: 'transparent',
                    tension: 0.3
                },
                {
                    label: 'Wear',
                    data: WearData,
                    borderColor: '#e17055',
                    backgroundColor: 'transparent',
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    min: 0,
                    max: 100,
                    ticks: {
                        stepSize: 20 // ปรับได้ เช่น 10, 25
                    }
                }
            }
        }
    });
@foreach($temps as $temp)

    const labels_{{ $temp }} = [
        @foreach($groupedByDateTemp as $date => $rows)
            "{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}",
        @endforeach
    ];

    // ================= WEAR RATE =================
    new Chart(document.getElementById('wearChart_{{ $temp }}'), {
        type: 'bar',
        data: {
            labels: labels_{{ $temp }},
            datasets: [
                @foreach($samples as $sIndex => $sample)
                {
                    label: "{{ $sample }}",
                    data: [
                        @foreach($groupedByDateTemp as $date => $rows)
                            {{
                                $rows->where('Temperature',$temp)
                                     ->where('SampleSet',$sample)
                                     ->avg('WearRate') ?? 0
                            }},
                        @endforeach
                    ],
                    backgroundColor: "hsl({{ $sIndex * 80 }}, 70%, 55%)",
                    borderColor: "hsl({{ $sIndex * 80 }}, 70%, 55%)",
                    borderWidth: 1
                },
                @endforeach
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: {
                    display: true,
                    text: 'WearRate by Date'
                }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });


    // ================= T_INC =================
    new Chart(document.getElementById('incChart_{{ $temp }}'), {
        type: 'bar',
        data: {
            labels: labels_{{ $temp }},
            datasets: [
                @foreach($samples as $sIndex => $sample)
                {
                    label: "{{ $sample }}",
                    data: [
                        @foreach($groupedByDateTemp as $date => $rows)
                            {{
                                $rows->where('Temperature',$temp)
                                     ->where('SampleSet',$sample)
                                     ->avg('T_Inc') ?? 0
                            }},
                        @endforeach
                    ],
                    backgroundColor: "hsl({{ $sIndex * 80 }}, 70%, 55%)",
                    borderColor: "hsl({{ $sIndex * 80 }}, 70%, 55%)",
                    borderWidth: 1
                },
                @endforeach
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: {
                    display: true,
                    text: 'T_Inc by Date'
                }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
     // ================= T_DEC =================
    new Chart(document.getElementById('decChart_{{ $temp }}'), {
        type: 'bar',
        data: {
            labels: labels_{{ $temp }},
            datasets: [
                @foreach($samples as $sIndex => $sample)
                {
                    label: "{{ $sample }}",
                    data: [
                        @foreach($groupedByDateTemp as $date => $rows)
                            {{
                                $rows->where('Temperature',$temp)
                                     ->where('SampleSet',$sample)
                                     ->avg('T_Dec') ?? 0
                            }},
                        @endforeach
                    ],
                    backgroundColor: "hsl({{ $sIndex * 80 }}, 70%, 55%)",
                    borderColor: "hsl({{ $sIndex * 80 }}, 70%, 55%)",
                    borderWidth: 1
                },
                @endforeach
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: {
                    display: true,
                    text: 'T_Dec by Date'
                }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
@endforeach
/* ===================== BUILD DATA ===================== */
function buildPieData() {
    const rows = document.querySelectorAll('#tableBody tr');

    const groupMap = {};
    const colorMap = {};

    rows.forEach(row => {
        const group = row.querySelector('.group')?.value || 'ไม่ระบุ';
        const value = parseFloat(row.querySelector('.weghttotal')?.value || 0); // 🔥 ใช้น้ำหนักจริง
        const color = row.querySelector('.color')?.value || '#cccccc';

        if (value <= 0) return;

        if (!groupMap[group]) {
            groupMap[group] = 0;
            colorMap[group] = color;
        }

        groupMap[group] += value;
    });

    const labels = Object.keys(groupMap);
    const data = Object.values(groupMap);
    const total = data.reduce((a, b) => a + b, 0);

    return {
        labels,
        data,
        colors: labels.map(g => colorMap[g]),
        total
    };
}

/* ===================== RENDER PIE ===================== */
function renderPieChart() {
    const ctx = document.getElementById('pieChart').getContext('2d');
    const result = buildPieData();

    if (pieChart) {
        pieChart.destroy();
    }

    pieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: result.labels,
            datasets: [{
                data: result.data,
                backgroundColor: result.colors
            }]
        },
        plugins: [ChartDataLabels],
        options: {
            responsive: true,
            maintainAspectRatio: false, 
            plugins: {
                legend: {
                    position: 'right'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.raw;
                            const percent = (value / result.total * 100).toFixed(2);
                            return `${context.label}: ${value.toFixed(2)} g (${percent}%)`;
                        }
                    }
                },
                datalabels: {
                    color: '#000000',
                    formatter: function(value, context) {
                        const percent = (value / result.total * 100).toFixed(1);
                        return `${value.toFixed(1)}g\n${percent}%`;
                    },
                    font: {
                        weight: 'bold',
                        size: 12
                    }
                }
            }
        }
    });
}
/* ===================== INIT ===================== */
$(document).ready(function () {
    renderPieChart();
});
/* =============================
   labels (ใช้แกน X ชุดเดียว)
=============================*/

const frictionLabels = @json($labels);
const frictionLabels1 = @json($labels1);

/* =============================
   DATA จาก Laravel
=============================*/

// 100°C
const frictionUn1_100 = @json($n1u100);
const frictionUn2_100 = @json($n2u100);
const frictionUn3_100 = @json($n3u100);

const frictionCn1_100 = @json($n1c100);
const frictionCn2_100 = @json($n2c100);
const frictionCn3_100 = @json($n3c100);


// 150°C
const frictionUn1_150 = @json($n1u150);
const frictionUn2_150 = @json($n2u150);
const frictionUn3_150 = @json($n3u150);

const frictionCn1_150 = @json($n1c150);
const frictionCn2_150 = @json($n2c150);
const frictionCn3_150 = @json($n3c150);

// 200°C
const frictionUn1_200 = @json($n1u200);
const frictionUn2_200 = @json($n2u200);
const frictionUn3_200 = @json($n3u200);

const frictionCn1_200 = @json($n1c200);
const frictionCn2_200 = @json($n2c200);
const frictionCn3_200 = @json($n3c200);

// 250°C
const frictionUn1_250 = @json($n1u250);
const frictionUn2_250 = @json($n2u250);
const frictionUn3_250 = @json($n3u250);

const frictionCn1_250 = @json($n1c250);
const frictionCn2_250 = @json($n2c250);
const frictionCn3_250 = @json($n3c250);

// 300°C
const frictionUn1_300 = @json($n1u300);
const frictionUn2_300 = @json($n2u300);
const frictionUn3_300 = @json($n3u300);

const frictionCn1_300 = @json($n1c300);
const frictionCn2_300 = @json($n2c300);
const frictionCn3_300 = @json($n3c300);


// 350°C
const frictionUn1_350 = @json($n1u350);
const frictionUn2_350 = @json($n2u350);
const frictionUn3_350 = @json($n3u350);

const frictionCn1_350 = @json($n1c350);
const frictionCn2_350 = @json($n2c350);
const frictionCn3_350 = @json($n3c350);

// FALL°C
const frictionUn1_fall = @json($n1ufall);
const frictionUn2_fall = @json($n2ufall);
const frictionUn3_fall = @json($n3ufall);

const frictionCn1_fall = @json($n1cfall);
const frictionCn2_fall = @json($n2cfall);
const frictionCn3_fall = @json($n3cfall);

/* =============================
   function สร้าง chart
=============================*/

function createChart(canvasId, labels, datasets, yMax)
{

    new Chart(document.getElementById(canvasId),
    {

        type: 'line',

        data:
        {
            labels: labels,

            datasets: datasets
        },

        options:
        {

            responsive: true,

            maintainAspectRatio:false,

            plugins:
            {
                legend:
                {
                    position:'top'
                }
            },

            scales:
            {

                x:
                {
                    type:'linear',   // สำคัญ

                    ticks:
                    {
                        stepSize:50   // <<< แบ่งช่องละ 50
                    }
                },

                y:
                {
                    min:0,
                    max:yMax                 
                }

            }

        }

    });

}



/* =============================
   render charts
=============================*/


/* ---------- 100°C u ---------- */

createChart(

    'chartU100',

    frictionLabels1,

    [

        {
            label:'N1 100°c_(u)',
            data:frictionUn1_100,
            borderColor:'#1f77b4',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N2 100°c_(u)',
            data:frictionUn2_100,
            borderColor:'#2ca02c',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N3 100°c_(u)',
            data:frictionUn3_100,
            borderColor:'#9467bd',
            tension:0.05,
            pointRadius:0
        }

    ],

    1.2

);



/* ---------- 100°C c ---------- */

createChart(

    'chartC100',

    frictionLabels1,

    [

        {
            label:'N1 100°c_(°c)',
            data:frictionCn1_100,
            borderColor:'#d62728',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N2 100°c_(°c)',
            data:frictionCn2_100,
            borderColor:'#ff7f0e',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N3 100°c_(°c)',
            data:frictionCn3_100,
            borderColor:'#8c564b',
            tension:0.05,
            pointRadius:0
        }

    ],

    400

);



/* ---------- 150°C u ---------- */

createChart(

    'chartU150',

    frictionLabels1,

    [

        {
            label:'N1 150°c_(u)',
            data:frictionUn1_150,
            borderColor:'#1f77b4',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N2 150°c_(u)',
            data:frictionUn2_150,
            borderColor:'#2ca02c',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N3 150°c_(u)',
            data:frictionUn3_150,
            borderColor:'#9467bd',
            tension:0.05,
            pointRadius:0
        }

    ],

    1.2

);



/* ---------- 150°C c ---------- */

createChart(

    'chartC150',

    frictionLabels1,

    [

        {
            label:'N1 150°c_(°c)',
            data:frictionCn1_150,
            borderColor:'#d62728',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N2 150°c_(°c)',
            data:frictionCn2_150,
            borderColor:'#ff7f0e',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N3 150°c_(°c)',
            data:frictionCn3_150,
            borderColor:'#8c564b',
            tension:0.05,
            pointRadius:0
        }

    ],

    400

);

/* ---------- 200°C u ---------- */

createChart(

    'chartU200',

    frictionLabels1,

    [

        {
            label:'N1 200°c_(u)',
            data:frictionUn1_200,
            borderColor:'#1f77b4',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N2 200°c_(u)',
            data:frictionUn2_200,
            borderColor:'#2ca02c',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N3 200°c_(u)',
            data:frictionUn3_200,
            borderColor:'#9467bd',
            tension:0.05,
            pointRadius:0
        }

    ],

    1.2

);



/* ---------- 200°C c ---------- */

createChart(

    'chartC200',

    frictionLabels1,

    [

        {
            label:'N1 200°c_(°c)',
            data:frictionCn1_200,
            borderColor:'#d62728',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N2 200°c_(°c)',
            data:frictionCn2_200,
            borderColor:'#ff7f0e',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N3 200°c_(°c)',
            data:frictionCn3_200,
            borderColor:'#8c564b',
            tension:0.05,
            pointRadius:0
        }

    ],

    400

);

/* ---------- 250°C u ---------- */

createChart(

    'chartU250',

    frictionLabels1,

    [

        {
            label:'N1 250°c_(u)',
            data:frictionUn1_250,
            borderColor:'#1f77b4',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N2 250°c_(u)',
            data:frictionUn2_250,
            borderColor:'#2ca02c',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N3 250°c_(u)',
            data:frictionUn3_250,
            borderColor:'#9467bd',
            tension:0.05,
            pointRadius:0
        }

    ],

    1.2

);



/* ---------- 250°C c ---------- */

createChart(

    'chartC250',

    frictionLabels1,

    [

        {
            label:'N1 250°c_(°c)',
            data:frictionCn1_250,
            borderColor:'#d62728',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N2 250°c_(°c)',
            data:frictionCn2_250,
            borderColor:'#ff7f0e',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N3 250°c_(°c)',
            data:frictionCn3_250,
            borderColor:'#8c564b',
            tension:0.05,
            pointRadius:0
        }

    ],

    400

);

/* ---------- 300°C u ---------- */

createChart(

    'chartU300',

    frictionLabels1,

    [

        {
            label:'N1 300°c_(u)',
            data:frictionUn1_300,
            borderColor:'#1f77b4',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N2 300°c_(u)',
            data:frictionUn2_300,
            borderColor:'#2ca02c',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N3 300°c_(u)',
            data:frictionUn3_300,
            borderColor:'#9467bd',
            tension:0.05,
            pointRadius:0
        }

    ],

    1.2

);



/* ---------- 300°C c ---------- */

createChart(

    'chartC300',

    frictionLabels1,

    [

        {
            label:'N1 300°c_(°c)',
            data:frictionCn1_300,
            borderColor:'#d62728',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N2 300°c_(°c)',
            data:frictionCn2_300,
            borderColor:'#ff7f0e',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N3 300°c_(°c)',
            data:frictionCn3_300,
            borderColor:'#8c564b',
            tension:0.05,
            pointRadius:0
        }

    ],

    400

);

/* ---------- 350°C u ---------- */

createChart(

    'chartU350',

    frictionLabels1,

    [

        {
            label:'N1 350°c_(u)',
            data:frictionUn1_350,
            borderColor:'#1f77b4',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N2 350°c_(u)',
            data:frictionUn2_350,
            borderColor:'#2ca02c',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N3 350°c_(u)',
            data:frictionUn3_350,
            borderColor:'#9467bd',
            tension:0.05,
            pointRadius:0
        }

    ],

    1.2

);



/* ---------- 350°C c ---------- */

createChart(

    'chartC350',

    frictionLabels1,

    [

        {
            label:'N1 350°c_(°c)',
            data:frictionCn1_350,
            borderColor:'#d62728',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N2 350°c_(°c)',
            data:frictionCn2_350,
            borderColor:'#ff7f0e',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N3 350°c_(°c)',
            data:frictionCn3_350,
            borderColor:'#8c564b',
            tension:0.05,
            pointRadius:0
        }

    ],

    400

);

/* ---------- FALL°C u ---------- */

createChart(

    'chartUfall',

    frictionLabels,

    [

        {
            label:'N1 FALL°c_(u)',
            data:frictionUn1_fall,
            borderColor:'#1f77b4',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N2 FALL°c_(u)',
            data:frictionUn2_fall,
            borderColor:'#2ca02c',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N3 FALL°c_(u)',
            data:frictionUn3_fall,
            borderColor:'#9467bd',
            tension:0.05,
            pointRadius:0
        }

    ],

    1.2

);



/* ---------- FALL°C c ---------- */

createChart(

    'chartCfall',

    frictionLabels,

    [

        {
            label:'N1 FALL°c_(°c)',
            data:frictionCn1_fall,
            borderColor:'#d62728',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N2 FALL°c_(°c)',
            data:frictionCn2_fall,
            borderColor:'#ff7f0e',
            tension:0.05,
            pointRadius:0
        },

        {
            label:'N3 FALL°c_(°c)',
            data:frictionCn3_fall,
            borderColor:'#8c564b',
            tension:0.05,
            pointRadius:0
        }

    ],

    400

);
let donutChart = null;

function buildDonutData() {

    const rows =
        document.querySelectorAll('#tableBody tr');

    const groupMap = {};
    const colorMap = {};

    rows.forEach(row => {

        const group =
            row.querySelector('.group')?.value || 'ไม่ระบุ';

        const color =
            row.querySelector('.color')?.value || '#cccccc';

        let value =
            parseFloat(
                row.querySelector('.adjust')?.value || 0
            );

        if (value <= 0)
            return;

        // fix float precision
        value =
            parseFloat(
                value.toFixed(2)
            );

        if (!groupMap[group]) {

            groupMap[group] = 0;
            colorMap[group] = color;
        }

        groupMap[group] += value;
    });

    const labels =
        Object.keys(groupMap);

    const data =
        Object.values(groupMap)
            .map(v =>
                parseFloat(v.toFixed(2))
            );

    const total =
        data.reduce(
            (a, b) => a + b,
            0
        );

    return {

        labels,

        data,

        colors:
            labels.map(
                g => colorMap[g]
            ),

        total:
            parseFloat(
                total.toFixed(2)
            )
    };
}


function renderDonutChart() {

    const ctx =
        document
        .getElementById('donutChart')
        .getContext('2d');

    const result =
        buildDonutData();

    if (donutChart)
        donutChart.destroy();

    donutChart =
        new Chart(ctx, {

        type: 'doughnut',

        data: {

            labels:
                result.labels,

            datasets: [{

                data:
                    result.data,

                backgroundColor:
                    result.colors,

                borderWidth: 1
            }]
        },

        plugins: [
            ChartDataLabels
        ],

        options: {

            responsive: true,

            maintainAspectRatio: false,

            cutout: '60%',

            plugins: {

                legend: {

                    position: 'right',

                    labels: {

                        font: {
                            size: 12
                        }
                    }
                },

                tooltip: {

                    callbacks: {

                        label:
                        function(context) {

                            const value =
                                parseFloat(
                                    context.raw.toFixed(2)
                                );

                            const percent =
                                (
                                    value
                                    /
                                    result.total
                                    * 100
                                )
                                .toFixed(2);

                            return
                                `${context.label}: ${value.toFixed(2)}% (${percent}%)`;
                        }
                    }
                },

                datalabels: {

                    color: '#000',

                    formatter:
                    function(value) {

                        const percent =
                            (
                                value
                                /
                                result.total
                                * 100
                            )
                            .toFixed(2);

                        return `${percent}%`;
                    },

                    font: {

                        weight: 'bold',

                        size: 12
                    }
                }
            }
        }
    });
}
</script>
@endpush