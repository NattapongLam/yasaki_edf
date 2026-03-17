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
                    <textarea class="form-control" rows="5">{{$hd->chemistry_hd_note}}</textarea>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <h5 style="color: black">รายละเอียด</h5>
            <table class="table table-bordered">
                <thead style="color: black">
                    <tr>
                        <th>No.</th>
                        <th>Material</th>
                        <th>Density(g/cc)</th>
                        <th>Vol.% adjust</th>
                        <th>W</th>
                        <th>Weght(%)</th>
                        <th>Weght(g)</th>
                    </tr>
                </thead>
                <tbody id="tableBody" style="color: black">
                    @foreach ($dt as $item)
                    <tr style="{{ $item->chemical_groups_color ? 'background-color: '.$item->chemical_groups_color : '' }}">
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
                                        data-density="{{ number_format($product->chemical_lists_density,2,'.','') }}">
                                        {{$product->chemical_lists_refcode}} - {{$product->chemical_lists_name}} ({{$product->chemical_lists_grade}})
                                        สต็อค : {{number_format($product->chemical_lists_stc,2)}}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" step="0.01" name="density[]" class="form-control density" value="{{ number_format($item->density,2) }}"/></td>
                        <td><input type="number" step="0.01" name="adjust[]" class="form-control adjust" value="{{ number_format($item->adjust,2) }}"/></td>
                        <td><input type="number" step="0.01" name="weght[]" class="form-control weght" value="{{ number_format($item->weght,2) }}"/></td>
                        <td><input type="number" step="0.01" name="weghtper[]" class="form-control weghtper" value="{{ number_format($item->weghtper,2) }}"/></td>
                        <td><input type="number" step="0.01" name="weghttotal[]" class="form-control weghttotal" value="{{ number_format($item->weghttotal,2) }}"/></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total</th>
                        <th id="sumAdjust">0</th>
                        <th id="sumWeight">0</th>
                        <th id="sumWeightPer">0</th>
                        <th id="sumWeightTotal">0</th>
                    </tr>
                </tfoot>
            </table>
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
        <hr>
        <div class="row">
            <h5 style="color: black">ผลการทดสอบ</h5>
            <table class="table table-bordered">
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
            <table class="table table-bordered text-center">
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function () {

    $('.select2-product').select2({
        width: '100%',
        placeholder: 'เลือกสินค้า'
    });

    calculateTable(); // คำนวณตอนเปิดหน้า
});


$(document).on('change', '.select2-product', function () {

    let density = $(this).find(':selected').data('density') || 0;
    density = parseFloat(density).toFixed(2);

    let row = $(this).closest('tr');
    row.find('.density').val(density);

    calculateTable();
});


/* ================= DELETE ROW ================= */

const tableBody = document.getElementById('tableBody');

if (tableBody) {
    tableBody.addEventListener('click', function (e) {

        if (e.target.classList.contains('deleteRow')) {
            e.target.closest('tr').remove();
            calculateTable();
        }

    });
}


/* ================= CALCULATE TABLE ================= */

function calculateTable(){

    const mode = $('input[name="chemistry_hd_calculate"]:checked').val();
    const mix = parseFloat($('input[name="chemistry_hd_mix"]').val()) || 0;

    let totalWeight = 0;
    let sumAdjust = 0;
    let sumWeight = 0;
    let sumWeightPer = 0;
    let sumWeightTotal = 0;

    const rows = $('#tableBody tr');

    /* STEP 1 */

    rows.each(function(){

        const row = $(this);

        const density = parseFloat(row.find('.density').val()) || 0;
        const adjust = parseFloat(row.find('.adjust').val()) || 0;
        let weight = parseFloat(row.find('.weght').val()) || 0;
        let weightPer = parseFloat(row.find('.weghtper').val()) || 0;

        if(mode === 'vol')
        {
            weight = density * adjust;
            row.find('.weght').val(weight.toFixed(2));
            totalWeight += weight;
        }

        sumAdjust += adjust;
        sumWeight += weight;
    });


    /* STEP 2 */

    rows.each(function(){

        const row = $(this);

        let weight = parseFloat(row.find('.weght').val()) || 0;
        let weightPer = parseFloat(row.find('.weghtper').val()) || 0;
        let weightTotal = 0;

        if(mode === 'vol')
        {
            if(totalWeight > 0)
            {
                weightPer = (weight / totalWeight) * 100;
                weightTotal = (mix * weightPer) / 100;

                row.find('.weghtper').val(weightPer.toFixed(2));
                row.find('.weghttotal').val(weightTotal.toFixed(2));
            }
        }

        if(mode === 'w')
        {
            weightTotal = (mix * weightPer) / 100;
            row.find('.weghttotal').val(weightTotal.toFixed(2));
        }

        sumWeightPer += weightPer;
        sumWeightTotal += weightTotal;
    });


    /* TOTAL */

    $('input[name="chemistry_hd_qty"]').val(sumWeightTotal.toFixed(2));

    $('#sumAdjust').text(sumAdjust.toFixed(2));
    $('#sumWeight').text(sumWeight.toFixed(2));
    $('#sumWeightPer').text(sumWeightPer.toFixed(2));
    $('#sumWeightTotal').text(sumWeightTotal.toFixed(2));
}


/* ================= EVENT ================= */

$(document).on(
    'keyup change',
    '.adjust,.density,.weghtper,input[name="chemistry_hd_mix"]',
    function(){
        calculateTable();
    }
);

$(document).on('change','input[name="chemistry_hd_calculate"]',function(){
    calculateTable();
});
    /* ===================== RADAR CHART ===================== */

    const avgData = [
        {{ $lap->avg('Hardness') ?? 0 }},
        {{ $lap->avg('Shearing') ?? 0 }},
        {{ $lap->avg('Noise') ?? 0 }},
        {{ $lap->avg('RoadTestAvg') ?? 0 }},
        {{ $lap->avg('Normal_Avg') ?? 0 }},
        {{ $lap->avg('Hot_Avg') ?? 0 }},
        {{ $lap->avg('Wear_Avg') ?? 0 }},
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
                    beginAtZero: true,
                    ticks: {
                        backdropColor: 'transparent'
                    }
                }
            }
        }
    });


    /* ===================== LINE CHART ===================== */

    const labels = [
        @foreach ($lap as $item)
            "{{ \Carbon\Carbon::parse($item->TestDate)->format('d/m/Y') }}",
        @endforeach
    ];

    const hardnessData = [
        @foreach ($lap as $item)
            {{ $item->Hardness ?? 0 }},
        @endforeach
    ];

    const shearingData = [
        @foreach ($lap as $item)
            {{ $item->Shearing ?? 0 }},
        @endforeach
    ];

    const noiseData = [
        @foreach ($lap as $item)
            {{ $item->Noise ?? 0 }},
        @endforeach
    ];

    const roadTestData = [
        @foreach ($lap as $item)
            {{ $item->RoadTestAvg ?? 0 }},
        @endforeach
    ];

    const NormalData = [
        @foreach ($lap as $item)
            {{ $item->Normal_Avg ?? 0 }},
        @endforeach
    ];

    const HotData = [
        @foreach ($lap as $item)
            {{ $item->Hot_Avg ?? 0 }},
        @endforeach
    ];

    const WearData = [
        @foreach ($lap as $item)
            {{ $item->Wear_Avg ?? 0 }},
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
                    beginAtZero: false
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
</script>
@endpush