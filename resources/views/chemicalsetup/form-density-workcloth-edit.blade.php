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
            <form method="POST" class="form-horizontal" action="{{ route('density-workcloth.update', $hd->density_workcloth_hds_id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')  

                <div class="row">
                    <div class="col-12 col-md-6"><h3 class="card-title">ความหนาแน่นของผ้าชิ้น (แก้ไขข้อมูล)</h3></div>
                </div>
                
                <div class="row mt-2">            
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Product</label>
                            <input class="form-control" value="{{ $hd->product_code }}/{{$hd->product_name }}" readonly>
                        </div>            
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Mold</label>
                            <input class="form-control" value="{{ $hd->mlod_code }}/{{$hd->mlod_name }}" readonly>
                        </div>            
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Machinery</label>
                            <input class="form-control" name="machinery_name" value="{{ $hd->machinery_name }}">
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-2">
                        <div class="form-group">
                            <label class="form-label">Area (cm²)</label>
                            <input class="form-control" name="mlod_area" id="mlod_area" value="{{ $hd->mlod_area }}">
                            <input class="form-control" type="hidden" name="mlod_cavity" id="mlod_cavity" value="{{ $hd->mlod_cavity ?? '' }}">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="form-label">Volume (cm3/1Cavity)</label>
                            <input class="form-control" type="text" name="mlod_volume" id="mlod_volume" value="{{ $hd->mlod_volume ?? '' }}">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="form-label">Pressure</label>
                            <input class="form-control" name="mlod_pressure" id="mlod_pressure" value="{{ $hd->mlod_pressure }}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">Weight</label>
                            <input class="form-control" name="chemical_weight" value="{{ $hd->chemical_weight }}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">Temp</label>
                            <input class="form-control" name="chemical_temp" value="{{ $hd->chemical_temp }}">
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">Formule</label>
                            <input class="form-control" value="{{$hd->ms_formule_name}}" readonly>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">Number</label>
                            <input class="form-control" value="{{$hd->chemistry_hd_name}}" readonly>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">Density (Target)</label>
                            <input class="form-control" name="total_density" id="total_density" value="{{ $hd->total_density }}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">Date</label>
                            <input class="form-control" type="date" name="density_workcloth_hds_date" value="{{ $hd->density_workcloth_hds_date }}">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">หมายเหตุ</label>
                            <input class="form-control" name="density_workcloth_hds_note" id="density_workcloth_hds_note" value="{{$hd->density_workcloth_hds_note}}">
                        </div>
                    </div>
                </div>
                <!-- ส่วนรูปภาพเดิม -->
                <div class="row mt-2">
                    @for ($i = 1; $i <= 4; $i++)
                    @php $fileName = "density_workcloth_hds_file{$i}"; @endphp
                    <div class="col-3">
                        <div class="form-group">
                            <label for="{{ $fileName }}" class="col-form-label">รูปภาพที่ {{ $i }}</label>
                            @if(!empty($hd->$fileName))
                                <div class="mb-1">
                                    <a href="{{ asset('storage/' . $hd->$fileName) }}" target="_blank" class="btn btn-sm btn-info">ดูรูปเดิม</a>
                                </div>
                            @endif
                            <input type="file" class="form-control" name="{{ $fileName }}">
                        </div>
                    </div>
                    @endfor
                </div>

                <div class="row mt-3">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th rowspan="2">ลำดับ</th>
                                    <th colspan="1">ผ้าชิ้นก่อนกรอ</th>
                                    <th colspan="6">ความหนาผ้าชิ้นก่อนกรอ (mm)</th>
                                    <th rowspan="2">ความหนาก้อนเคมี (cm)</th>
                                    <th rowspan="2">Volume (cm³)</th>
                                    <th rowspan="2">Density (g/cm³)</th>
                                    <th rowspan="2">%Porosity</th>
                                    <th colspan="3">Hardness</th>
                                </tr>
                                <tr>
                                    <th>น้ำหนัก (g)</th>
                                    <th>จุดที่ 1</th>
                                    <th>จุดที่ 2</th>
                                    <th>จุดที่ 3</th>
                                    <th>จุดที่ 4</th>
                                    <th>จุดที่ 5</th>
                                    <th>จุดที่ 6</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                </tr>
                            </thead>
                            <tbody id="cavity_table_body">
                                @if(isset($dt) && count($dt) > 0)
                                    @foreach($dt as $index =>$item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="text-center"><input type="text" step="any" class="form-control iron-w" name="cavity[{{ $index + 1 }}][weight_1]" value="{{ $item->weight_1 }}"></td>
                                        <td class="text-center"><input type="text" step="any" class="form-control thick-1" name="cavity[{{ $index + 1 }}][thickness_1]" value="{{ $item->thickness_1 }}"></td>
                                        <td class="text-center"><input type="text" step="any" class="form-control thick-2" name="cavity[{{ $index + 1 }}][thickness_2]" value="{{ $item->thickness_2 }}"></td>
                                        <td class="text-center"><input type="text" step="any" class="form-control thick-3" name="cavity[{{ $index + 1 }}][thickness_3]" value="{{ $item->thickness_3 }}"></td>
                                        <td class="text-center"><input type="text" step="any" class="form-control thick-4" name="cavity[{{ $index + 1 }}][thickness_4]" value="{{ $item->thickness_4 }}"></td>
                                        <td class="text-center"><input type="text" step="any" class="form-control thick-5" name="cavity[{{ $index + 1 }}][thickness_5]" value="{{ $item->thickness_5 }}"></td>
                                        <td class="text-center"><input type="text" step="any" class="form-control thick-6" name="cavity[{{ $index + 1 }}][thickness_6]" value="{{ $item->thickness_6 }}"></td>
                                        <td class="text-center"><input type="text" class="form-control calc-thickness-chem bg-light" name="cavity[{{ $index + 1 }}][thickness_chemical]" value="{{ $item->thickness_chemical }}" readonly></td>
                                        <td class="text-center"><input type="text" class="form-control calc-volume bg-light" name="cavity[{{ $index + 1 }}][volume]" value="{{ $item->volume }}" readonly></td>
                                        <td class="text-center"><input type="text" class="form-control calc-density bg-light" name="cavity[{{ $index + 1 }}][density]" value="{{ $item->density }}" readonly></td>
                                        <td class="text-center"><input type="text" class="form-control calc-porosity bg-light" name="cavity[{{ $index + 1 }}][porosity]" value="{{ $item->porosity }}" readonly></td>
                                        <td class="text-center"><input type="text" step="any" class="form-control thick-6" name="cavity[{{ $index + 1 }}][hardness_1]" value="{{ $item->hardness_1 }}"></td>
                                        <td class="text-center"><input type="text" step="any" class="form-control thick-6" name="cavity[{{ $index + 1 }}][hardness_2]" value="{{ $item->hardness_2 }}"></td>
                                        <td class="text-center"><input type="text" step="any" class="form-control thick-6" name="cavity[{{ $index + 1 }}][hardness_3]" value="{{ $item->hardness_3 }}"></td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="15" class="text-center text-muted">กรุณาเลือก Mold ก่อน</td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot id="cavity_table_footer" style="font-weight: bold; background-color: #f8f9fa;">
                                <!-- คำนวณสรุปผลอัตโนมัติ -->
                            </tfoot>
                        </table>
                    </div>
                </div> 

                <!-- ส่วนแสดงกราฟ (Chart.js Dashboard) -->
                <div class="row mt-4">
                    <div class="col-12 mb-3">
                        <div class="card border shadow-sm print-chart-card">
                            <div class="card-body">
                                <h6 class="fw-bold text-dark mb-2">กราฟเปรียบเทียบ Density กับ Target, Upper และ Lower</h6>
                                <canvas id="densityChart" height="90"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="card border shadow-sm print-chart-card">
                            <div class="card-body">
                                <h6 class="fw-bold text-dark mb-2">กราฟแนวโน้ม %Porosity</h6>
                                <canvas id="porosityChart" height="90"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
                    </div>
                </div>
            </form>       
        </div>
    </div>
</div>
@endsection

@push('scriptjs')
<style>
    .select2-results__options {
        max-height: 200px !important;
        overflow-y: auto !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- เพิ่มปลั๊กอินสำหรับแสดงตัวเลขบนกราฟ -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js"></script>

<script>
let densityChartInstance = null;
let porosityChartInstance = null;

$(document).ready(function() {$('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'กรุณาเลือกข้อมูล',
        allowClear: true
    });

    calculateAllRows();
});

// เมื่อเปลี่ยน Formule ในหน้า Edit ให้ดึง Number ใหม่มาแสดง
$('#ms_formule_name').on('change', function() {
    var formuleName = $(this).val();
    var numberSelect = $('#chemistry_hd_name');

    numberSelect.empty().append('<option value="-">กรุณาเลือก</option>').trigger('change');
    $('#total_density').val('');

    if (formuleName && formuleName !== '-') {
        $.ajax({
            url: "{{ route('get.numbers') }}",
            type: 'GET',
            data: { ms_formule_name: formuleName },
            success: function(response) {
                $.each(response, function(index, item) {
                    numberSelect.append('<option value="' + item.chemistry_hd_name + '">' + item.chemistry_hd_name + '</option>');
                });
                numberSelect.trigger('change');
            }
        });
    }
});

// เมื่อเลือก Number
$('#chemistry_hd_name').on('change', function() {
    var numberName = $(this).val();
    var densityInput = $('#total_density');

    if (!numberName || numberName === '-') {
        densityInput.val('');
        return;
    }

    $.ajax({
        url: "{{ route('get.number.details') }}",
        type: 'GET',
        data: { chemistry_hd_name: numberName },
        success: function(response) {
            if (response && response.total_density !== null) {
                densityInput.val(response.total_density);
                calculateAllRows();
            }
        }
    });
});

function calculateRow(rowTr) {
    var weight = parseFloat($(rowTr).find('.iron-w').val()) || 0;
    var t1 = parseFloat($(rowTr).find('.thick-1').val()) || 0;
    var t2 = parseFloat($(rowTr).find('.thick-2').val()) || 0;
    var t3 = parseFloat($(rowTr).find('.thick-3').val()) || 0;
    var t4 = parseFloat($(rowTr).find('.thick-4').val()) || 0;
    var t5 = parseFloat($(rowTr).find('.thick-5').val()) || 0;
    var t6 = parseFloat($(rowTr).find('.thick-6').val()) || 0;

    var validPoints = [t1, t2, t3, t4, t5, t6].filter(val => val > 0);
    var avgThicknessMm = validPoints.length > 0 ? (validPoints.reduce((a, b) => a + b, 0) / validPoints.length) : 0;
    
    // ความหนาก้อนเคมี (cm) = ค่าเฉลี่ย mm หารด้วย 10 ตามสูตร Excel
    var thicknessChem = avgThicknessMm / 10;
    
    // ดึงค่า Volume และ Area และ Target Density
    var moldVolume = parseFloat($('#mlod_volume').val()) || 0;
    var mlodArea = parseFloat($('#mlod_area').val()) || 0;
    var targetDensity = parseFloat($('#total_density').val()) || 0;

    var volume = moldVolume > 0 ? moldVolume : (thicknessChem * mlodArea);
    var density = (volume > 0) ? (weight / volume) : 0;
    var porosity = (targetDensity > 0) ? (((targetDensity - density) / targetDensity) * 100) : 0;

    // ปรับให้แสดงผลเป็นทศนิยม 2 ตำแหน่ง
    $(rowTr).find('.calc-thickness-chem').val(thicknessChem > 0 ? thicknessChem.toFixed(2) : '0.00');
    $(rowTr).find('.calc-volume').val(volume > 0 ? volume.toFixed(2) : '0.00');
    $(rowTr).find('.calc-density').val(density > 0 ? density.toFixed(2) : '0.00');
    $(rowTr).find('.calc-porosity').val(porosity !== 0 ? porosity.toFixed(2) : '0.00');
}

function calculateAllRows() {
    var rows = $('#cavity_table_body tr');
    if (rows.length === 0 || rows.find('td.text-muted').length > 0) {
        $('#cavity_table_footer').hide();
        return;
    }

    let totalData = { 
        count: 0, sumWeight: 0, sumT1: 0, sumT2: 0, sumT3: 0, sumT4: 0, sumT5: 0, sumT6: 0, 
        sumThicknessChem: 0, sumVolume: 0, sumDensity: 0, sumPorosity: 0 
    };

    rows.each(function() {
        calculateRow(this);

        totalData.count++;
        totalData.sumWeight += parseFloat($(this).find('.iron-w').val()) || 0;
        totalData.sumT1 += parseFloat($(this).find('.thick-1').val()) || 0;
        totalData.sumT2 += parseFloat($(this).find('.thick-2').val()) || 0;
        totalData.sumT3 += parseFloat($(this).find('.thick-3').val()) || 0;
        totalData.sumT4 += parseFloat($(this).find('.thick-4').val()) || 0;
        totalData.sumT5 += parseFloat($(this).find('.thick-5').val()) || 0;
        totalData.sumT6 += parseFloat($(this).find('.thick-6').val()) || 0;
        totalData.sumThicknessChem += parseFloat($(this).find('.calc-thickness-chem').val()) || 0;
        totalData.sumVolume += parseFloat($(this).find('.calc-volume').val()) || 0;
        totalData.sumDensity += parseFloat($(this).find('.calc-density').val()) || 0;
        totalData.sumPorosity += parseFloat($(this).find('.calc-porosity').val()) || 0;
    });

    var footerHtml = '';
    if (totalData.count > 0) {
        let allCount = totalData.count;
        footerHtml += `
            <tr class="table-dark text-white">
                <td colspan="15" class="text-start fw-bold">Grand Total / Overall Average</td>
            </tr>
            <tr class="fw-bold bg-light">
                <td>Total</td>
                <td>${totalData.sumWeight.toFixed(2)}</td>
                <td>${totalData.sumT1.toFixed(2)}</td>
                <td>${totalData.sumT2.toFixed(2)}</td>
                <td>${totalData.sumT3.toFixed(2)}</td>
                <td>${totalData.sumT4.toFixed(2)}</td>
                <td>${totalData.sumT5.toFixed(2)}</td>
                <td>${totalData.sumT6.toFixed(2)}</td>
                <td>${totalData.sumThicknessChem.toFixed(2)}</td>
                <td>${totalData.sumVolume.toFixed(2)}</td>
                <td>${totalData.sumDensity.toFixed(2)}</td>
                <td>${totalData.sumPorosity.toFixed(2)}</td>
                <td colspan="3"></td>
            </tr>
            <tr class="fw-bold bg-light">
                <td>Average</td>
                <td>${(totalData.sumWeight / allCount).toFixed(2)}</td>
                <td>${(totalData.sumT1 / allCount).toFixed(2)}</td>
                <td>${(totalData.sumT2 / allCount).toFixed(2)}</td>
                <td>${(totalData.sumT3 / allCount).toFixed(2)}</td>
                <td>${(totalData.sumT4 / allCount).toFixed(2)}</td>
                <td>${(totalData.sumT5 / allCount).toFixed(2)}</td>
                <td>${(totalData.sumT6 / allCount).toFixed(2)}</td>
                <td>${(totalData.sumThicknessChem / allCount).toFixed(2)}</td>
                <td>${(totalData.sumVolume / allCount).toFixed(2)}</td>
                <td>${(totalData.sumDensity / allCount).toFixed(2)}</td>
                <td>${(totalData.sumPorosity / allCount).toFixed(2)}</td>
                <td colspan="3"></td>
            </tr>
        `;
    }

    $('#cavity_table_footer').html(footerHtml).show();

    // อัปเดตกราฟทุกครั้งที่มีการคำนวณใหม่
    initOrUpdateCharts();
}

$(document).on('input', '.iron-w, .thick-1, .thick-2, .thick-3, .thick-4, .thick-5, .thick-6', function() {
    calculateAllRows();
});

$('#mlod_area, #mlod_volume, #total_density').on('change', function() {
    calculateAllRows();
});

function initOrUpdateCharts() {
    if (typeof Chart === 'undefined') {
        console.error('Chart.js library is not loaded!');
        return;
    }

    let labels = [];
    let densityData = [];
    let porosityData = [];
    let targetData = [];
    let upperData = [];
    let lowerData = [];

    let targetDensity = parseFloat($('#total_density').val()) || 0;
    let upperDensity = targetDensity * 1.05;
    let lowerDensity = targetDensity * 0.95;

    $('#cavity_table_body tr').each(function(index) {
        let rowNum = index + 1;
        let density = parseFloat($(this).find('.calc-density').val()) || 0;
        let porosity = parseFloat($(this).find('.calc-porosity').val()) || 0;

        if ($(this).find('td.text-muted').length === 0) {
            labels.push('Cavity ' + rowNum);
            densityData.push(density);
            porosityData.push(porosity);
            targetData.push(targetDensity);
            upperData.push(upperDensity);
            lowerData.push(lowerDensity);
        }
    });

    // --- 1. กราฟ Density ---
    const densityEl = document.getElementById('densityChart');
    if (densityEl) {
        const densityCtx = densityEl.getContext('2d');
        if (densityChartInstance) {
            densityChartInstance.destroy();
        }
        densityChartInstance = new Chart(densityCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Actual Density',
                        data: densityData,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 2,
                        tension: 0.1
                    },
                    {
                        label: 'Target Density',
                        data: targetData,
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderDash: [5, 5],
                        borderWidth: 2,
                        pointRadius: 0
                    },
                    {
                        label: 'Upper Limit (+5%)',
                        data: upperData,
                        borderColor: 'rgba(220, 53, 69, 0.8)',
                        borderDash: [2, 2],
                        borderWidth: 1.5,
                        pointRadius: 0
                    },
                    {
                        label: 'Lower Limit (-5%)',
                        data: lowerData,
                        borderColor: 'rgba(255, 193, 7, 1)',
                        borderDash: [2, 2],
                        borderWidth: 1.5,
                        pointRadius: 0
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    // เปิดใช้งานการแสดงตัวเลขเฉพาะเส้น Actual Density
                    datalabels: {
                        display: function(context) {
                            // ให้แสดงตัวเลขเฉพาะ Dataset แรก (Actual Density) เพื่อไม่ให้ตัวเลขทับกันรกจนเกินไป
                            return context.datasetIndex === 0;
                        },
                        align: 'top',
                        formatter: function(value) {
                            return value > 0 ? value.toFixed(2) : '';
                        },
                        font: {
                            weight: 'bold',
                            size: 11
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: false }
                }
            },
            plugins: [ChartDataLabels] // ลงทะเบียนใช้งานปลั๊กอิน
        });
    }

    // --- 2. กราฟ %Porosity ---
    const porosityEl = document.getElementById('porosityChart');
    if (porosityEl) {
        const porosityCtx = porosityEl.getContext('2d');
        if (porosityChartInstance) {
            porosityChartInstance.destroy();
        }
        
        // สร้างข้อมูลเส้น Max 5% ให้ยาวเท่ากับจำนวน Cavity ที่มี
        let maxLimitData = new Array(labels.length).fill(5);

        porosityChartInstance = new Chart(porosityCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        type: 'bar', // กราฟแท่งแสดงค่า %Porosity จริง
                        label: '%Porosity',
                        data: porosityData,
                        backgroundColor: 'rgba(153, 102, 255, 0.6)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1,
                        order: 2
                    },
                    {
                        type: 'line', // เส้นกราฟตรง (Line) แสดงค่า Max 5%
                        label: 'Max Limit (5%)',
                        data: maxLimitData,
                        borderColor: 'rgba(220, 53, 69, 1)', // สีแดงเตือนภัย
                        borderWidth: 2,
                        borderDash: [5, 5], // เส้นประ
                        pointRadius: 0,     // ไม่แสดงจุดวงกลมบนเส้น
                        order: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    datalabels: {
                        // กำหนดให้แสดงตัวเลขเฉพาะกราฟแท่ง (%Porosity) เพื่อไม่ให้ตัวเลข 5 ทับซ้อนกับเส้น Max
                        display: function(context) {
                            return context.datasetIndex === 0;
                        },
                        anchor: 'end',
                        align: 'top',
                        formatter: function(value) {
                            return value !== 0 ? value.toFixed(2) : '';
                        },
                        font: {
                            weight: 'bold',
                            size: 11
                        }
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        // เผื่อขอบบนของแกน Y เล็กน้อย (เช่น 7) เพื่อให้เส้น Max 5% ที่ชนขอบบนดูสวยงามและไม่ติดขอบกราฟจนเกินไป
                        suggestedMax: 7 
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    }
}
</script>
@endpush