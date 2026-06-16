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
        <form method="POST" class="form-horizontal" action="{{ route('chemistrys.store') }}" enctype="multipart/form-data">
        @csrf     
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="chemistry_hd_date" class="col-form-label">วันที่</label>
                    <input type="date" class="form-control" name="chemistry_hd_date" id="chemistry_hd_date" value="{{$hd->chemistry_hd_date}}" required>
                </div>
            </div>
            <div class="col-3">
                 <div class="form-group">
                    <label for="ms_formule_name" class="col-form-label">ชื่อสูตร</label>
                    <select class="form-select" name="ms_formule_name" required>
                        <option value="">กรุณาเลือก</option>
                        @foreach ($formule as $item)
                            <option value="{{$item->ms_formule_name}}"
                                {{ $item->ms_formule_name == $hd->ms_formule_name ? 'selected' : '' }}>
                                {{$item->ms_formule_name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="chemistry_hd_name" class="col-form-label">เลขที่สูตร</label>
                    <input type="text" class="form-control" name="chemistry_hd_name" id="chemistry_hd_name" required>
                </div>
            </div> 
            <div class="col-3">
                 <div class="form-group">
                    <label for="chemistry_hd_type" class="col-form-label">ประเภท</label>
                    <select class="form-select" name="chemistry_hd_type" required>
                        <option value="">กรุณาเลือก</option>
                        @foreach ($types as $item)
                            <option value="{{$item->chemistry_type_name}}"
                                {{ $item->chemistry_type_name == $hd->chemistry_hd_type ? 'selected' : '' }}>
                                {{$item->chemistry_type_name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="chemistry_hd_mix" class="col-form-label">Mixing  (kg/Batch)</label>
                    <input class="form-control" name="chemistry_hd_mix" id="chemistry_hd_mix" value="{{$hd->chemistry_hd_mix}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="chemistry_hd_qty" class="col-form-label">Total (W)</label>
                    <input class="form-control" name="chemistry_hd_qty" value="{{$hd->chemistry_hd_qty}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="chemistry_hd_save" class="col-form-label">ผู้บันทึก</label>
                    <input class="form-control" name="chemistry_hd_save" value="{{Auth::user()->name}}">
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
         <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="chemistry_hd_file1" class="col-form-label">ไฟล์แนบ(หากมี)</label>
                    <input type="file" class="form-control" name="chemistry_hd_file1" >
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="chemistry_hd_file2" class="col-form-label">ไฟล์แนบ(หากมี)</label>
                    <input type="file" class="form-control" name="chemistry_hd_file2" >
                </div>
            </div> 
            <div class="col-3">
                <div class="form-group">
                    <label for="chemistry_hd_file3" class="col-form-label">ไฟล์แนบ(หากมี)</label>
                    <input type="file" class="form-control" name="chemistry_hd_file3" >
                </div>
            </div>  
            <div class="col-3">
                <div class="form-group">
                    <label for="chemistry_hd_file4" class="col-form-label">ไฟล์แนบ(หากมี)</label>
                    <input type="file" class="form-control" name="chemistry_hd_file4" >
                </div>
            </div> 
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                 <div class="col-12" style="text-align: right;">
                    <a href="javascript:void(0);" class="btn btn-secondary" id="addRowBtn">เพิ่มรายการ</a>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center">
                        <thead>
                            <tr>
                                <th style="width: 3%">No.</th>
                                <th style="width: 40%">Material</th>
                                <th style="width: 10%">Density (g/cc)</th>
                                <th style="width: 10%">Vol.% adjust</th>
                                <th style="width: 10%">Volume(1kg)</th>
                                <th style="width: 10%">W (%)</th>
                                <th style="width: 10%">Weight (kg)</th>
                                <th style="width: 3%"></th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach ($dt as $index => $item)
                                <tr 
                                    style="{{ $item->chemical_groups_color ? 'background-color: '.$item->chemical_groups_color : '' }}"
                                    data-group="{{ $item->chemical_groups_name }}"
                                    data-color="{{ $item->chemical_groups_color }}"
                                >
                                    <td>
                                        <span class="row-number">{{ $index + 1 }}</span>
                                        <input type="hidden" name="chemistry_dt_id[]" value="{{$item->chemistry_dt_id}}">
                                        <input type="hidden" name="no[]" class="row-number-hidden" value="{{ $index + 1 }}">
                                    </td>
                                    <td>
                                        <select class="form-control select2-product" name="code[]">
                                            <option value="">เลือกสินค้า</option>
                                            @foreach ($products as $product)
                                                <option value="{{$product->chemical_lists_id}}"
                                                    {{$item->chemical_lists_id == $product->chemical_lists_id ? 'selected' : '' }}
                                                    data-density="{{ number_format($product->chemical_lists_density,2,'.','') }}"
                                                    data-group="{{ $product->chemical_groups_name }}"
                                                    data-color="{{ $product->chemical_groups_color }}">
                                                    {{$product->chemical_lists_refcode}} - {{$product->chemical_lists_name}} ({{$product->chemical_lists_grade}})
                                                    สต็อค : {{number_format($product->chemical_lists_stc,2)}}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="group[]" class="form-control group" value="{{ $item->chemical_groups_name }}"/>
                                        <input type="hidden" name="color[]" class="form-control color" value="{{ $item->chemical_groups_color }}"/>
                                    </td>
                                    <td><input type="number" step="0.01" name="density[]" class="form-control density" value="{{ number_format($item->density,2,'.','') }}"/></td>
                                    <td><input type="number" step="0.01" name="adjust[]" class="form-control adjust" value="{{ number_format($item->adjust, 2, '.', '') }}"></td>
                                    <td><input type="number" step="0.01" name="weght[]" class="form-control weght" value="{{ number_format($item->weght, 2, '.', '') }}"></td>
                                    <td><input type="number" step="0.01" name="weghtper[]" class="form-control weghtper" value="{{ number_format($item->weghtper, 2, '.', '') }}"></td>
                                    <td><input type="number" step="0.01" name="weghttotal[]" class="form-control weghttotal" value="{{ number_format($item->weghttotal, 2, '.', '') }}"></td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->chemistry_dt_id }}')"><i class="fas fa-trash"></i></a> 
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>       
                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-end">Total</th>
                                <th><input class="form-control" id="sumDensity" name="total_density" value="0" readonly></th>
                                <th><input class="form-control" id="sumAdjust" name="total_adjust" value="0" readonly></th>
                                <th><input class="form-control" id="sumWeight" name="total_volume" value="0" readonly></th>
                                <th><input class="form-control" id="sumWeightPer" name="total_wper" value="0" readonly></th>
                                <th><input class="form-control" id="sumWeightTotal" name="total_weght" value="0" readonly></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>          
            </div>
        </div>       
        <br>
        <div class="col-12 col-md-1">
            <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary">บันทึก</button>
            </div>
        </div>
        </form> 
        <hr>
        <div class="row">
            <div class="col-6 d-flex flex-column align-items-center">
                <h5>Adjust (%)</h5>
                <div style="width:100%; max-width:400px; height:400px;">
                    <canvas id="donutChart"></canvas>
                </div>
            </div>
            <div class="col-6 d-flex flex-column align-items-center">
                <h5>Weight (g)</h5>
                <div style="width:100%; max-width:400px; height:400px;">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
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
let donutChart = null;

$(document).ready(function () {
    initSelect2($('.select2-product'));
    calculateTable();
});

function initSelect2(element) {
    element.select2({
        placeholder: 'เลือกสินค้า'
    });
}

function normalizeColor(color) {
    if (!color) return '';
    color = color.toString().trim();
    if (color.startsWith('rgb')) return color;
    if (!color.startsWith('#')) color = '#' + color;
    return color;
}

function applyRowColor(row, color) {
    row.find('td').each(function () {
        this.style.setProperty('background-color', color, 'important');
    });
    if (color) {
        row.find('td:first')[0].style.setProperty('border-left', '6px solid ' + color, 'important');
    } else {
        row.find('td:first')[0].style.borderLeft = '';
    }
}

/* ===================== SELECT PRODUCT ===================== */
$(document).on('change', '.select2-product', function () {
    let selected = $(this).find(':selected');
    let density = selected.attr('data-density') || 0;
    let group = selected.attr('data-group') || '';
    let color = normalizeColor(selected.attr('data-color'));
    let row = $(this).closest('tr');

    row.find('.density').val(parseFloat(density).toFixed(2));
    row.find('.group').val(group);
    row.find('.color').val(color);

    applyRowColor(row, color);
    calculateTable();
});

/* ===================== UPDATE ROW NUMBER ===================== */
function updateRowNumbers() {
    $('#tableBody tr').each(function(index) {
        let rowNumEl = $(this).find('.row-number');
        let rowNumHiddenEl = $(this).find('.row-number-hidden');
        if(rowNumEl.length) rowNumEl.text(index + 1);
        if(rowNumHiddenEl.length) rowNumHiddenEl.val(index + 1);
    });
}

/* ===================== ADD ROW ===================== */
document.getElementById('addRowBtn').addEventListener('click', function () {
    const tbody = document.getElementById('tableBody');
    const nextIndex = $('#tableBody tr').length + 1;
    const newRow = document.createElement('tr');
    
    newRow.innerHTML = `
        <td>
            <span class="row-number">${nextIndex}</span>
            <input type="hidden" name="no[]" class="row-number-hidden" value="${nextIndex}"/>
        </td>
        <td>
            <select class="form-control select2-product" name="code[]">
                <option value="">เลือกสินค้า</option>
                @foreach ($products as $item)
                   <option value="{{$item->chemical_lists_id}}"
                        data-density="{{ number_format($item->chemical_lists_density,2,'.','') }}"
                        data-group="{{ $item->chemical_groups_name }}"
                        data-color="{{ $item->chemical_groups_color }}">
                        {{$item->chemical_lists_refcode}} - {{$item->chemical_lists_name}} ({{$item->chemical_groups_name}}) สต็อค : {{number_format($item->chemical_lists_stc,2)}}
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="group[]" class="form-control group" value=""/>
            <input type="hidden" name="color[]" class="form-control color" value=""/>
        </td>
        <td><input type="number" step="0.01" name="density[]" class="form-control density" value="0"/></td>
        <td><input type="number" step="0.01" name="adjust[]" class="form-control adjust" value="0" max="100"/></td>
        <td><input type="number" step="0.01" name="weght[]" class="form-control weght" value="0"/></td>
        <td><input type="number" step="0.01" name="weghtper[]" class="form-control weghtper" value="0"/></td>
        <td><input type="number" step="0.01" name="weghttotal[]" class="form-control weghttotal" value="0"/></td>
        <td><button type="button" class="btn btn-danger btn-sm deleteRow">ลบ</button></td>
    `;

    tbody.appendChild(newRow);
    initSelect2($(newRow).find('.select2-product'));

    updateRowNumbers();
    calculateTable();
});

/* ===================== DELETE ROW ===================== */
$(document).on('click', '.deleteRow', function () {
    $(this).closest('tr').remove();
    updateRowNumbers();
    calculateTable();
});

/* ===================== EVENT DELEGATION FOR CALCULATION ===================== */
$(document).on('keyup change', '.adjust, .density, .weghtper, input[name="chemistry_hd_mix"], input[name="chemistry_hd_calculate"]', function(){
    calculateTable();
});

$(document).on('blur', '.adjust, .weghtper', function () {
    let val = parseFloat($(this).val()) || 0;
    if (val > 100) {
        $(this).val(100);
        calculateTable();
    }
});

/* ===================== CALCULATION CORE ===================== */
function calculateTable(){
    const mode = $('input[name="chemistry_hd_calculate"]:checked').val();
    const mixKg = parseFloat($('input[name="chemistry_hd_mix"]').val()) || 0;

    let sumAdjust = 0;
    let sumWeightPer = 0;
    let sumWeightTotal = 0;
    let sumWeightExcel = 0;
    let totalAdjustRaw = 0;
    let tmpSumWeight = 0;

    const rows = $('#tableBody tr');
    const activeElement = document.activeElement;

    /* ================= STEP 1 ================= */
    rows.each(function(){
        const row = $(this);
        const density = parseFloat(row.find('.density').val()) || 0;
        let adjust = parseFloat(row.find('.adjust').val()) || 0;
        let weightPer = parseFloat(row.find('.weghtper').val()) || 0;

        if(mode === 'vol') {
            if(sumAdjust + adjust > 100) {
                adjust = 100 - sumAdjust;
                if(adjust < 0) adjust = 0;
                if (activeElement !== row.find('.adjust')[0]) {
                    row.find('.adjust').val(adjust.toFixed(2));
                }
            }
            let tmpWeight = density * adjust;
            tmpSumWeight += tmpWeight;
            sumAdjust += adjust;
            row.data('tmpWeight', tmpWeight);
        }

        if(mode === 'w') {
            if(sumWeightPer + weightPer > 100) {
                weightPer = 100 - sumWeightPer;
                if(weightPer < 0) weightPer = 0;
                if (activeElement !== row.find('.weghtper')[0]) {
                    row.find('.weghtper').val(weightPer.toFixed(2));
                }
            }
            sumWeightPer += weightPer;
            let raw = density > 0 ? weightPer / density : 0;
            row.data('adjustRaw', raw);
            totalAdjustRaw += raw;
        }
    });

    /* ================= STEP 2 ================= */
    rows.each(function(){
        const row = $(this);
        const density = parseFloat(row.find('.density').val()) || 0;
        let adjust = parseFloat(row.find('.adjust').val()) || 0;
        let weightPer = parseFloat(row.find('.weghtper').val()) || 0;

        if(mode === 'vol') {
            let tmpWeight = row.data('tmpWeight') || 0;
            if(tmpSumWeight > 0) {
                weightPer = (tmpWeight / tmpSumWeight) * 100;
                if (activeElement !== row.find('.weghtper')[0]) {
                    row.find('.weghtper').val(weightPer.toFixed(2));
                }
                sumWeightPer += weightPer;
            }
        }

        if(mode === 'w') {
            let raw = row.data('adjustRaw') || 0;
            if(totalAdjustRaw > 0) {
                adjust = (raw / totalAdjustRaw) * 100;

                // ✅ เพิ่ม: cap ไม่ให้ sumAdjust เกิน 100
                if(sumAdjust + adjust > 100) {
                    adjust = 100 - sumAdjust;
                    if(adjust < 0) adjust = 0;
                }

                if (activeElement !== row.find('.adjust')[0]) {
                    row.find('.adjust').val(adjust.toFixed(2));
                }
                sumAdjust += adjust;
            }
        }

        let weight = 0;
        if(density > 0) {
            weight = (mixKg / density) * (weightPer / 100);
        }
        row.find('.weght').val(weight.toFixed(2));
        sumWeightExcel += weight;

        let weightTotal = mixKg * weightPer / 100;
        row.find('.weghttotal').val(weightTotal.toFixed(2));
        sumWeightTotal += weightTotal;
    });

    /* ================= TOTALS ================= */
    let sumDensity = sumWeightExcel > 0 ? mixKg / sumWeightExcel : 0;

    $('#sumDensity').val(sumDensity.toFixed(2));
    $('#sumAdjust').val(sumAdjust.toFixed(2));
    $('#sumWeightPer').val(sumWeightPer.toFixed(2));
    $('#sumWeight').val(sumWeightExcel.toFixed(2));
    $('#sumWeightTotal').val(sumWeightTotal.toFixed(2));
    $('input[name="chemistry_hd_qty"]').val(sumWeightTotal.toFixed(2));

    renderPieChart();
    renderDonutChart();
}

/* ===================== CHART DATA BUILDERS ===================== */
function buildChartData(elementClassName) {
    const groupMap = {};
    const colorMap = {};

    $('#tableBody tr').each(function() {
        const group = $(this).find('.group').val() || 'ไม่ระบุ';
        const value = parseFloat($(this).find('.' + elementClassName).val()) || 0;
        const color = $(this).find('.color').val() || '#cccccc';

        if (value <= 0) return;

        if (!groupMap[group]) {
            groupMap[group] = 0;
            colorMap[group] = color;
        }
        groupMap[group] += value;
    });

    const labels = Object.keys(groupMap);
    const data = Object.values(groupMap).map(v => parseFloat(v.toFixed(2)));
    const total = data.reduce((a, b) => a + b, 0);

    return { labels, data, colors: labels.map(g => colorMap[g]), total: parseFloat(total.toFixed(2)) };
}

/* ===================== RENDER CHARTS ===================== */
function renderPieChart() {
    const canvas = document.getElementById('pieChart');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    const result = buildChartData('weghttotal');

    if (pieChart) pieChart.destroy();

    pieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: result.labels,
            datasets: [{ data: result.data, backgroundColor: result.colors }]
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
                            const percent = result.total > 0 ? (value / result.total * 100).toFixed(2) : 0;
                            return `${context.label}: ${value.toFixed(2)} g (${percent}%)`;
                        }
                    }
                },
                datalabels: {
                    color: '#000000',
                    formatter: function(value) {
                        const percent = result.total > 0 ? (value / result.total * 100).toFixed(1) : 0;
                        return `${value.toFixed(1)}g\n${percent}%`;
                    },
                    font: { weight: 'bold', size: 11 }
                }
            }
        }
    });
}

function renderDonutChart() {
    const canvas = document.getElementById('donutChart');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    const result = buildChartData('adjust');

    if (donutChart) donutChart.destroy();

    donutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: result.labels,
            datasets: [{ data: result.data, backgroundColor: result.colors, borderWidth: 1 }]
        },
        plugins: [ChartDataLabels],
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: { position: 'right' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.raw;
                            const percent = result.total > 0 ? (value / result.total * 100).toFixed(2) : 0;
                            return `${context.label}: ${value.toFixed(2)}% (${percent}%)`;
                        }
                    }
                },
                datalabels: {
                    color: '#000',
                    formatter: function(value) {
                        const percent = result.total > 0 ? (value / result.total * 100).toFixed(1) : 0;
                        return `${percent}%`;
                    },
                    font: { weight: 'bold', size: 11 }
                }
            }
        }
    });
}

/* ===================== DELETE CONFIRMATION ===================== */
confirmDel = (refid) => {
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่ !',
        text: `คุณต้องการลบรายการนี้หรือไม่ ?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false         
    }).then(function(result) {
        if (result.value) {
            $.ajax({
                url: `{{ url('/confirmDelChemistryDt') }}`,
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "refid": refid,               
                },           
                dataType: "json",
                success: function(data) {
                    if (data.status == true) {
                        Swal.fire({
                            title: 'สำเร็จ',
                            text: 'ลบรายการเรียบร้อยแล้ว',
                            icon: 'success'
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'ไม่สำเร็จ',
                            text: 'ลบรายการไม่สำเร็จ',
                            icon: 'error'
                        });
                    }
                },
                error: function(data) {
                    Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'เกิดข้อผิดพลาดในระบบ',
                        icon: 'error'
                    });
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
                title: 'ยกเลิก',
                text: 'โปรดตรวจสอบข้อมูลอีกครั้งเพื่อความถูกต้อง :)',
                icon: 'error'
            });
        }
    });
}
</script>
@endpush