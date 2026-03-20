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
                    <input type="date" class="form-control" name="chemistry_hd_date" id="chemistry_hd_date" required>
                </div>
            </div>
            <div class="col-3">
                 <div class="form-group">
                    <label for="ms_formule_name" class="col-form-label">ชื่อสูตร</label>
                    <select class="form-select" name="ms_formule_name" required>
                        <option value="">กรุณาเลือก</option>
                        @foreach ($formule as $item)
                            <option value="{{$item->ms_formule_name}}">{{$item->ms_formule_name}}</option>
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
                    <label for="ms_formule_name" class="col-form-label">ประเภท</label>
                    <select class="form-select" name="chemistry_hd_type" required>
                        <option value="">กรุณาเลือก</option>
                        @foreach ($types as $item)
                            <option value="{{$item->chemistry_type_name}}">{{$item->chemistry_type_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="chemistry_hd_mix" class="col-form-label">Mixing  (kg/Batch)</label>
                    <input class="form-control" name="chemistry_hd_mix" value="1000">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="[chemistry_hd_qty" class="col-form-label">Total (W)</label>
                    <input class="form-control" name="chemistry_hd_qty" value="0">
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
                            <input class="form-check-input" type="radio" name="chemistry_hd_calculate" id="formRadios1" value="vol" checked>
                            <label class="form-check-label" for="formRadios1">Vol %</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="chemistry_hd_calculate" id="formRadios2" value="w">
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
                    <textarea class="form-control" rows="5" name="chemistry_hd_note"></textarea>
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
            <table class="table table-bordered dt-responsive nowrap w-100 text-center">
                <thead>
                    <tr>
                        <th style="width: 4%">#</th>
                        <th style="width: 45%">Material</th>
                        <th style="width: 8%">Density (g/cc)</th>
                        <th style="width: 8%">Vol.% adjust</th>
                        <th style="width: 8%">W</th>
                        <th style="width: 8%">W (%)</th>
                        <th style="width: 8%">Weght (g)</th>
                        <th style="width: 4%"></th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>       
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total</th>
                        <th id="sumAdjust">0</th>
                        <th id="sumWeight">0</th>
                        <th id="sumWeightPer">0</th>
                        <th id="sumWeightTotal">0</th>
                        <th></th>
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
        <hr>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <div style="width:500px; height:500px;">
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
$(document).ready(function () {
    $('.select2-product').select2({
        width: '100%',
        placeholder: 'เลือกสินค้า'
    });
});
function showOverLimit(msg) {
    Swal.fire({
        icon: 'warning',
        title: 'เกิน 100%',
        text: msg,
        confirmButtonText: 'ตกลง'
    });
}
function normalizeColor(color) {
    if (!color) return '';

    color = color.toString().trim();

    // ถ้าเป็น rgb(...) ใช้ได้เลย
    if (color.startsWith('rgb')) return color;

    // เติม # ถ้าไม่มี
    if (!color.startsWith('#')) {
        color = '#' + color;
    }

    return color;
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

    // reset ก่อน
    row.find('td').each(function () {
        this.style.backgroundColor = '';
        this.style.borderLeft = '';
    });

    if (color) {
        row.find('td').each(function () {
            this.style.setProperty('background-color', color, 'important');
        });

        row.find('td:first')[0].style.setProperty('border-left', '6px solid ' + color, 'important');
    }

    calculateTable();
    renderPieChart();
});

/* ===================== UPDATE ROW NUMBER ===================== */
function updateRowNumbers() {
    const rows = document.querySelectorAll('#tableBody tr');
    rows.forEach((row, index) => {
        row.querySelector('.row-number').textContent = index + 1;
        row.querySelector('.row-number-hidden').value = index + 1;
    });
}
/* ===================== GLOBAL ===================== */
let pieChart = null;
/* ===================== ADD ROW ===================== */
document.getElementById('addRowBtn').addEventListener('click', function () {
    const tbody = document.getElementById('tableBody');

    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td>
            <span class="row-number"></span>
            <input type="hidden" name="no[]" class="row-number-hidden"/>
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
        </td>
        <td>
            <input type="number" step="0.01" name="density[]" class="form-control density" value="0"/>
            <input type="hidden" name="group[]" class="form-control group" value=""/>
            <input type="hidden" name="color[]" class="form-control color" value=""/>
        </td>
        <td><input type="number" step="0.01" name="adjust[]" class="form-control adjust" value="0" max="100"/></td>
        <td><input type="number" step="0.01" name="weght[]" class="form-control weght" value="0"/></td>
        <td><input type="number" step="0.01" name="weghtper[]" class="form-control weghtper" value="0"/></td>
        <td><input type="number" step="0.01" name="weghttotal[]" class="form-control weghttotal" value="0"/></td>
        <td><button type="button" class="btn btn-danger btn-sm deleteRow">ลบ</button></td>
    `;

    tbody.appendChild(newRow);

    $(newRow).find('.select2-product').select2({
        width: '100%',
        placeholder: 'เลือกสินค้า'
    });

    updateRowNumbers();
    renderPieChart();
});

/* ===================== DELETE ROW ===================== */
document.getElementById('tableBody').addEventListener('click', function (e) {
    if (e.target.classList.contains('deleteRow')) {
        e.target.closest('tr').remove();
        updateRowNumbers();
        calculateTable();
        renderPieChart();
    }
});

/* ===================== LIMIT INPUT (ROW) ===================== */
$(document).on('input', '.adjust', function () {
    let val = parseFloat($(this).val()) || 0;

    if (val > 100) {
        $(this).val(100);
    }
});

/* ===================== CALCULATE ===================== */
function calculateTable(){

    const mode = $('input[name="chemistry_hd_calculate"]:checked').val();
    const mix = parseFloat($('input[name="chemistry_hd_mix"]').val()) || 0;

    let totalWeight = 0;
    let sumAdjust = 0;
    let sumWeight = 0;
    let sumWeightPer = 0;
    let sumWeightTotal = 0;

    const rows = $('#tableBody tr');

    /* ===== STEP 1 ===== */
    rows.each(function(){

        const row = $(this);

        const density = parseFloat(row.find('.density').val()) || 0;
        let adjust = parseFloat(row.find('.adjust').val()) || 0;
        let weight = 0;
        let weightPer = parseFloat(row.find('.weghtper').val()) || 0;

        if(mode === 'vol')
        {
            // จำกัด sum adjust <= 100
            if (sumAdjust + adjust > 100) {
                showOverLimit('Vol.% รวมเกิน 100%');

                adjust = 100 - sumAdjust;
                if (adjust < 0) adjust = 0;
                row.find('.adjust').val(adjust.toFixed(2));
            }

            weight = density * adjust;
            row.find('.weght').val(weight.toFixed(2));

            sumAdjust += adjust;
        }

        if(mode === 'w')
        {
            // จำกัด sum weightPer <= 100
            if (sumWeightPer + weightPer > 100) {
                showOverLimit('W % รวมเกิน 100%');

                weightPer = 100 - sumWeightPer;
                if (weightPer < 0) weightPer = 0;
                row.find('.weghtper').val(weightPer.toFixed(2));
            }

            weight = weightPer; // temp (จะ normalize ด้านล่าง)
            sumWeightPer += weightPer;
        }

        sumWeight += weight;
    });

    /* ===== STEP 2 ===== */
    rows.each(function(){

        const row = $(this);

        const density = parseFloat(row.find('.density').val()) || 0;
        let adjust = parseFloat(row.find('.adjust').val()) || 0;
        let weight = parseFloat(row.find('.weght').val()) || 0;
        let weightPer = parseFloat(row.find('.weghtper').val()) || 0;
        let weightTotal = 0;

        if(mode === 'vol')
        {
            if(sumWeight > 0)
            {
                weightPer = (weight / sumWeight) * 100;
                weightTotal = (mix * weightPer) / 100;

                row.find('.weghtper').val(weightPer.toFixed(2));
                row.find('.weghttotal').val(weightTotal.toFixed(2));
            }
        }

        if(mode === 'w')
        {
            // คำนวณน้ำหนักจริงจาก %
            weight = weightPer;
            row.find('.weght').val(weight.toFixed(2));

            // 🔥 แปลงกลับเป็น Vol.% (adjust)
            if (density > 0 && sumWeightPer > 0)
            {
                // normalize weight ให้เป็นสัดส่วนจริง
                let normWeight = (weightPer / sumWeightPer);

                let totalW = 0;
                rows.each(function(){
                    let wp = parseFloat($(this).find('.weghtper').val()) || 0;
                    totalW += wp;
                });

                // คำนวณ adjust
                let adjustCalc = (weightPer / totalW) * 100 / density;

                row.find('.adjust').val(adjustCalc.toFixed(2));
                sumAdjust += adjustCalc;
            }

            weightTotal = (mix * weightPer) / 100;
            row.find('.weghttotal').val(weightTotal.toFixed(2));
        }

        sumWeightTotal += weightTotal;
    });

    $('input[name="chemistry_hd_qty"]').val(sumWeightTotal.toFixed(2));

    $('#sumAdjust').text(sumAdjust.toFixed(2));
    $('#sumWeight').text(sumWeight.toFixed(2));
    $('#sumWeightPer').text(sumWeightPer.toFixed(2));
    $('#sumWeightTotal').text(sumWeightTotal.toFixed(2));
     // 🔥 ADD THIS
    renderPieChart();
}

/* ===================== TRIGGER ===================== */
$(document).on('keyup change','.adjust,.density,.weghtper,input[name="chemistry_hd_mix"]',function(){
    calculateTable();
});

$(document).on('change','input[name="chemistry_hd_calculate"]',function(){
    calculateTable();
});
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
</script>
@endpush