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
         <form method="POST" class="form-horizontal" action="{{ route('density-workcloth.store') }}" enctype="multipart/form-data">
            @csrf
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">ความหนาแน่นของผ้าชิ้น</h3></div>
        </div>
        <div class="row mt-2">            
                <div class="col-4">
                    <div class="form-group">
                        <label class="form-label">Product</label>
                        <select class="form-control select2" name="product_code">
                            <option value="-">กรุณาเลือก</option>
                            @foreach ($pd as $product)
                                <option value="{{ $product->product_code }}">{{ $product->product_code }}/{{$product->product_name }}</option>
                            @endforeach
                        </select>
                    </div>            
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label class="form-label">Mold</label>
                        <select class="form-control" name="mlod_code" id="mlod_code">
                            <option value="-">กรุณาเลือก</option>
                        </select>
                    </div>            
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label class="form-label">Machinery</label>
                        <input class="form-control" name="machinery_name">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-2">
                    <div class="form-group">
                        <label class="form-label">Area (cm²)</label>
                        <input class="form-control" name="mlod_area" id="mlod_area" readonly>
                        <input class="form-control" type="hidden" name="mlod_cavity" id="mlod_cavity">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label class="form-label">Volume (cm3/1Cavity)</label>
                        <input class="form-control" name="mlod_volume" id="mlod_volume">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label class="form-label">Pressure</label>
                        <input class="form-control" name="mlod_pressure" id="mlod_pressure">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">Weight</label>
                        <input class="form-control" name="chemical_weight">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">Temp</label>
                        <input class="form-control" name="chemical_temp" value="">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">Formule</label>
                        <select class="form-control" name="ms_formule_name" id="ms_formule_name">
                            <option value="-">กรุณาเลือก</option>
                            @foreach ($formule as $form)
                                <option value="{{ $form->ms_formule_name }}">{{ $form->ms_formule_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">Number</label>
                        <select class="form-control" name="chemistry_hd_name" id="chemistry_hd_name">
                            <option value="-">กรุณาเลือก</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">Density (Target)</label>
                        <input class="form-control" name="total_density" id="total_density">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">Date</label>
                        <input class="form-control" type="date" name="density_workcloth_hds_date" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">หมายเหตุ</label>
                        <input class="form-control" name="density_workcloth_hds_note" id="density_workcloth_hds_note">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3">
                    <div class="form-group">
                        <label for="density_workcloth_hds_file1" class="col-form-label">รูปภาพ</label>
                        <input type="file" class="form-control" name="density_workcloth_hds_file1" >
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="density_workcloth_hds_file2" class="col-form-label">รูปภาพ</label>
                        <input type="file" class="form-control" name="density_workcloth_hds_file2" >
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="density_workcloth_hds_file3" class="col-form-label">รูปภาพ</label>
                        <input type="file" class="form-control" name="density_workcloth_hds_file3" >
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="density_workcloth_hds_file4" class="col-form-label">รูปภาพ</label>
                        <input type="file" class="form-control" name="density_workcloth_hds_file4" >
                    </div>
                </div>
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
                            </tr>
                            <tr>
                                <th>น้ำหนัก (g)</th>
                                <th>จุดที่ 1</th>
                                <th>จุดที่ 2</th>
                                <th>จุดที่ 3</th>
                                <th>จุดที่ 4</th>
                                <th>จุดที่ 5</th>
                                <th>จุดที่ 6</th>
                            </tr>
                        </thead>
                        <tbody id="cavity_table_body">
                            <tr>
                                <td colspan="12" class="text-center text-muted">กรุณาเลือก Mold ก่อน</td>
                            </tr>
                        </tbody>
                        <tfoot id="cavity_table_footer" style="display: none; font-weight: bold; background-color: #f8f9fa;">
                            <!-- สรุปผล Total / Average -->
                        </tfoot>
                    </table>
                </div>
            </div> 
            <div class="row mt-3">
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
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
<script>
$('.select2').select2({
    theme: 'bootstrap-5',
    width: '100%',
    placeholder: 'กรุณาเลือกข้อมูล',
    allowClear: true
});

// ฟังก์ชันสร้างตารางตามจำนวน Cavity ที่กำหนด
function generateTableRows(cavityCount) {
    var tbody = $('#cavity_table_body');
    tbody.empty();

    if (cavityCount && cavityCount > 0) {
        for (var i = 1; i <= cavityCount; i++) {
            var row = `
                <tr>
                    <td class="text-center">${i}</td>
                    <td class="text-center"><input type="text" step="any" class="form-control iron-w" name="cavity[${i}][weight_1]" value="0.00"></td>
                    <td class="text-center"><input type="text" step="any" class="form-control thick-1" name="cavity[${i}][thickness_1]" value="0.00"></td>
                    <td class="text-center"><input type="text" step="any" class="form-control thick-2" name="cavity[${i}][thickness_2]" value="0.00"></td>
                    <td class="text-center"><input type="text" step="any" class="form-control thick-3" name="cavity[${i}][thickness_3]" value="0.00"></td>
                    <td class="text-center"><input type="text" step="any" class="form-control thick-4" name="cavity[${i}][thickness_4]" value="0.00"></td>
                    <td class="text-center"><input type="text" step="any" class="form-control thick-5" name="cavity[${i}][thickness_5]" value="0.00"></td>
                    <td class="text-center"><input type="text" step="any" class="form-control thick-6" name="cavity[${i}][thickness_6]" value="0.00"></td>
                    <td class="text-center"><input type="text" class="form-control calc-thickness-chem bg-light" name="cavity[${i}][thickness_chemical]" value="0.00" readonly></td>
                    <td class="text-center"><input type="text" class="form-control calc-volume bg-light" name="cavity[${i}][volume]" value="0.00" readonly></td>
                    <td class="text-center"><input type="text" class="form-control calc-density bg-light" name="cavity[${i}][density]" value="0.00" readonly></td>
                    <td class="text-center"><input type="text" class="form-control calc-porosity bg-light" name="cavity[${i}][porosity]" value="0.00" readonly></td>
                </tr>
            `;
            tbody.append(row);
        }
        calculateAllRows();
    } else {
        tbody.append(`<tr><td colspan="12" class="text-center text-muted">กรุณาเลือก Mold ก่อน</td></tr>`);
        $('#cavity_table_footer').hide();
    }
}

// เมื่อเลือก Product
$('select[name="product_code"]').on('change', function() {
    var productCode = $(this).val();
    var moldSelect = $('#mlod_code');

    moldSelect.empty().append('<option value="-">กรุณาเลือก</option>').trigger('change');
    $('#mlod_area').val('');  
    $('#mlod_pressure').val('');
    $('#mlod_cavity').val('');
    $('#mlod_volume').val('');
    $('#cavity_table_body').html('<tr><td colspan="12" class="text-center text-muted">กรุณาเลือก Mold ก่อน</td></tr>');
    $('#cavity_table_footer').hide();

    if (productCode && productCode !== '-') {
        $.ajax({
            url: "{{ route('get.molds') }}",
            type: 'GET',
            data: { product_code: productCode },
            success: function(response) {
                if (response.molds) {
                    $.each(response.molds, function(index, item) {
                        moldSelect.append(`
                            <option value="${item.mlod_code}" 
                                    data-area="${item.mlod_area ?? ''}" 
                                    data-pressure="${item.mlod_pressure ?? ''}" 
                                    data-cavity="${item.mlod_cavity ?? 0}"
                                    data-volume="${item.mlod_volume ?? ''}">
                                ${item.mlod_code} / ${item.mlod_name}
                            </option>
                        `);
                    });
                }
                moldSelect.trigger('change');
            }
        });
    }
});

// เมื่อเลือก Formule
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

    densityInput.val('');

    if (numberName && numberName !== '-') {
        $.ajax({
            url: "{{ route('get.number.details') }}",
            type: 'GET',
            data: { chemistry_hd_name: numberName },
            success: function(response) {
                if (response.total_density !== null) {
                    densityInput.val(response.total_density);
                    calculateAllRows();
                }
            }
        });
    }
});

// ฟังก์ชันคำนวณแต่ละแถว
function calculateRow(rowTr) {
    var weight = parseFloat($(rowTr).find('.iron-w').val()) || 0; 
    
    var t1 = parseFloat($(rowTr).find('.thick-1').val()) || 0;
    var t2 = parseFloat($(rowTr).find('.thick-2').val()) || 0;
    var t3 = parseFloat($(rowTr).find('.thick-3').val()) || 0;
    var t4 = parseFloat($(rowTr).find('.thick-4').val()) || 0;
    var t5 = parseFloat($(rowTr).find('.thick-5').val()) || 0;
    var t6 = parseFloat($(rowTr).find('.thick-6').val()) || 0;

    var points = [t1, t2, t3, t4, t5, t6];
    var validPoints = points.filter(val => val > 0);
    var avgThicknessMm = validPoints.length > 0 ? (validPoints.reduce((a, b) => a + b, 0) / validPoints.length) : 0;
    var thicknessChem = avgThicknessMm / 10; 

    var moldVolume = parseFloat($('#mlod_volume').val()) || 0;
    var mlodArea = parseFloat($('#mlod_area').val()) || 0;
    
    var volume = moldVolume > 0 ? moldVolume : (thicknessChem * mlodArea); 
    var density = (volume > 0) ? (weight / volume) : 0; 

    var targetDensity = parseFloat($('#total_density').val()) || 0;
    var porosity = (targetDensity > 0) ? (((targetDensity - density) / targetDensity) * 100) : 0; 

    $(rowTr).find('.calc-thickness-chem').val(thicknessChem > 0 ? thicknessChem.toFixed(2) : '0.00');
    $(rowTr).find('.calc-volume').val(volume > 0 ? volume.toFixed(3) : '0.000');
    $(rowTr).find('.calc-density').val(density > 0 ? density.toFixed(2) : '0.00');
    $(rowTr).find('.calc-porosity').val(porosity !== 0 ? porosity.toFixed(2) : '0.00');
}

// คำนวณตารางทั้งหมดและสรุปผล Total / Average
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

        let weight = parseFloat($(this).find('.iron-w').val()) || 0;
        let t1 = parseFloat($(this).find('.thick-1').val()) || 0;
        let t2 = parseFloat($(this).find('.thick-2').val()) || 0;
        let t3 = parseFloat($(this).find('.thick-3').val()) || 0;
        let t4 = parseFloat($(this).find('.thick-4').val()) || 0;
        let t5 = parseFloat($(this).find('.thick-5').val()) || 0;
        let t6 = parseFloat($(this).find('.thick-6').val()) || 0;

        let thicknessChem = parseFloat($(this).find('.calc-thickness-chem').val()) || 0;
        let volume = parseFloat($(this).find('.calc-volume').val()) || 0;
        let density = parseFloat($(this).find('.calc-density').val()) || 0;
        let porosity = parseFloat($(this).find('.calc-porosity').val()) || 0;

        totalData.count++;
        totalData.sumWeight += weight;
        totalData.sumT1 += t1;
        totalData.sumT2 += t2;
        totalData.sumT3 += t3;
        totalData.sumT4 += t4;
        totalData.sumT5 += t5;
        totalData.sumT6 += t6;
        totalData.sumThicknessChem += thicknessChem;
        totalData.sumVolume += volume;
        totalData.sumDensity += density;
        totalData.sumPorosity += porosity;
    });

    var footerHtml = '';
    if (totalData.count > 0) {
        let allCount = totalData.count;
        footerHtml += `
            <tr class="table-dark text-white">
                <td colspan="12" class="text-start fw-bold">Grand Total / Overall Average</td>
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
            </tr>
        `;
    }

    $('#cavity_table_footer').html(footerHtml).show();
}

// เมื่อเลือก Mold (ใช้ค่า Cavity ตาม Mold เป็นหลัก)
$('#mlod_code').on('change', function() {
    var selectedOption = $(this).find(':selected');
    var selectedMoldCode = selectedOption.val();
    
    var moldArea = selectedOption.data('area') || '';
    var moldPressure = selectedOption.data('pressure') || '';
    var cavityCount = selectedOption.data('cavity') || 0;
    var moldVolume = selectedOption.data('volume') || '';

    $('#mlod_area').val(moldArea);
    $('#mlod_pressure').val(moldPressure);
    $('#mlod_cavity').val(cavityCount);
    $('#mlod_volume').val(moldVolume);

    if (selectedMoldCode !== '-') {
        generateTableRows(cavityCount);
    } else {
        $('#cavity_table_body').html('<tr><td colspan="12" class="text-center text-muted">กรุณาเลือก Mold ก่อน</td></tr>');
        $('#cavity_table_footer').hide();
    }
});

// เมื่อมีการพิมพ์ระบุตัวเลขลงในช่อง Volume ด้านบน ให้บังคับตารางเหลือ 6 แถว (ถ้าช่อง Volume ว่าง ให้กลับไปใช้ Cavity ตาม Mold เดิม)
$(document).on('input change', '#mlod_volume', function() {
    var volumeVal = $(this).val();
    var selectedMoldCode = $('#mlod_code').val();

    if (selectedMoldCode && selectedMoldCode !== '-') {
        var baseCavity = $('#mlod_code').find(':selected').data('cavity') || 0;
        // ถ้ามีการระบุค่าใน Volume ให้บังคับจำนวนแถวเป็น 6 แถว, ถ้ารวมลบจนว่าง ให้กลับไปใช้ค่า Cavity ของ Mold
        var targetCavity = (volumeVal && volumeVal.trim() !== '') ? 6 : baseCavity;
        
        $('#mlod_cavity').val(targetCavity);
        generateTableRows(targetCavity);
    }
});

// Event เมื่อกรอกตัวเลขในช่องคำนวณในตาราง
$(document).on('input', '.iron-w, .thick-1, .thick-2, .thick-3, .thick-4, .thick-5, .thick-6', function() {
    calculateAllRows();
});

$('#mlod_area, #total_density').on('change', function() {
    calculateAllRows();
});
</script>
@endpush