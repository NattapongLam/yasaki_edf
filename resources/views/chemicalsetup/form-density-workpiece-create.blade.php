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
        <form method="POST" class="form-horizontal" action="{{ route('density-workpiece.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12 col-md-6"><h3 class="card-title">ความหนาแน่นของชิ้นงาน</h3></div>          
            </div>
            <div class="row mt-2">             
                <div class="col-6">
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
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Mold</label>
                        <select class="form-control" name="mlod_code" id="mlod_code">
                            <option value="-">กรุณาเลือก</option>
                        </select>
                    </div>              
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">Area (cm²)</label>
                        <input class="form-control" name="mlod_area" id="mlod_area">
                        <input class="form-control" type="hidden" name="mlod_cavity" id="mlod_cavity">
                    </div>
                </div>
                <div class="col-3">
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
                        <input class="form-control" type="date" name="density_workpiece_hds_date" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3">
                    <div class="form-group">
                        <label for="density_workpiece_hds_file1" class="col-form-label">รูปภาพ</label>
                        <input type="file" class="form-control" name="density_workpiece_hds_file1" >
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="density_workpiece_hds_file2" class="col-form-label">รูปภาพ</label>
                        <input type="file" class="form-control" name="density_workpiece_hds_file2" >
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="density_workpiece_hds_file3" class="col-form-label">รูปภาพ</label>
                        <input type="file" class="form-control" name="density_workpiece_hds_file3" >
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="density_workpiece_hds_file4" class="col-form-label">รูปภาพ</label>
                        <input type="file" class="form-control" name="density_workpiece_hds_file4" >
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead>
                            <tr>
                                <th rowspan="2">ลำดับ</th>
                                <th colspan="2">เหล็ก</th>
                                <th colspan="2">เหล็ก + กาว</th>
                                <th colspan="2">เหล็ก + กาว + เคมี</th>
                                <th rowspan="2">น้ำหนักเคมี (g)</th>
                                <th rowspan="2">ความหนาก้อนเคมี (cm)</th>
                                <th rowspan="2">Volume (cm³)</th>
                                <th rowspan="2">Density (g/cm³)<br>ρ = mass / Volume</th>
                                <th rowspan="2">%Porosity</th>
                                <th rowspan="2">Sides</th>
                            </tr>
                            <tr>
                                <th>น้ำหนัก (g)</th>
                                <th>ความหนา (mm)</th>
                                <th>น้ำหนัก (g)</th>
                                <th>ความหนา (mm)</th>
                                <th>น้ำหนัก (g)</th>
                                <th>ความหนา (mm)</th>
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

// เมื่อเลือก Product
$('select[name="product_code"]').on('change', function() {
    var productCode = $(this).val();
    var moldSelect = $('#mlod_code');

    moldSelect.empty().append('<option value="-">กรุณาเลือก</option>').trigger('change');
    $('#mlod_area').val('');  
    $('#mlod_pressure').val('');
    $('#mlod_cavity').val('');
    $('#cavity_table_body').html('<tr><td colspan="12" class="text-center text-muted">กรุณาเลือก Mold ก่อน</td></tr>');
    $('#cavity_table_footer').hide();

    if (productCode && productCode !== '-') {
        $.ajax({
            url: "{{ route('get.molds') }}",
            type: 'GET',
            data: { product_code: productCode },
            success: function(response) {
                $.each(response.molds, function(index, item) {
                    moldSelect.append('<option value="' + item.mlod_code + '">' + item.mlod_code + ' / ' + item.mlod_name + '</option>');
                });
                moldSelect.trigger('change');

                if (response.area) {
                    $('#mlod_area').val(response.area.mlod_area);
                    $('#mlod_pressure').val(response.area.mlod_pressure);
                    $('#mlod_cavity').val(response.area.mlod_cavity);
                }
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

// ฟังก์ชันคำนวณแต่ละแถวตามสูตร
function calculateRow(rowTr) {
    var glueW = parseFloat($(rowTr).find('.glue-w').val()) || 0;
    var glueT = parseFloat($(rowTr).find('.glue-t').val()) || 0;
    var chemW = parseFloat($(rowTr).find('.chem-w').val()) || 0;
    var chemT = parseFloat($(rowTr).find('.chem-t').val()) || 0;

    var mlodArea = parseFloat($('#mlod_area').val()) || 0;
    var targetDensity = parseFloat($('#total_density').val()) || 0;

    var weightChem = chemW - glueW;
    var thicknessChem = (chemT - glueT) / 10;
    var volume = thicknessChem * mlodArea;
    var density = (volume > 0) ? (weightChem / volume) : 0;
    var porosity = (targetDensity > 0) ? (((targetDensity - density) / targetDensity) * 100) : 0;

    $(rowTr).find('.calc-weight-chem').val(weightChem > 0 ? weightChem.toFixed(4) : '0');
    $(rowTr).find('.calc-thickness-chem').val(thicknessChem > 0 ? thicknessChem.toFixed(4) : '0');
    $(rowTr).find('.calc-volume').val(volume > 0 ? volume.toFixed(4) : '0');
    $(rowTr).find('.calc-density').val(density > 0 ? density.toFixed(4) : '0');
    $(rowTr).find('.calc-porosity').val(porosity !== 0 ? porosity.toFixed(4) : '0');
}

// คำนวณตารางทั้งหมดและแยกสรุปผล Total / Average ตาม Sides
function calculateAllRows() {
    var rows = $('#cavity_table_body tr');
    if (rows.length === 0 || rows.find('td.text-muted').length > 0) {
        $('#cavity_table_footer').hide();
        return;
    }

    let groups = {
        'ซ้าย': { count: 0, sumIronW: 0, sumIronT: 0, sumGlueW: 0, sumGlueT: 0, sumChemW: 0, sumChemT: 0, sumWeightChem: 0, sumThicknessChem: 0, sumVolume: 0, sumDensity: 0, sumPorosity: 0 },
        'ขวา': { count: 0, sumIronW: 0, sumIronT: 0, sumGlueW: 0, sumGlueT: 0, sumChemW: 0, sumChemT: 0, sumWeightChem: 0, sumThicknessChem: 0, sumVolume: 0, sumDensity: 0, sumPorosity: 0 },
        'ซ้าย-ขวา': { count: 0, sumIronW: 0, sumIronT: 0, sumGlueW: 0, sumGlueT: 0, sumChemW: 0, sumChemT: 0, sumWeightChem: 0, sumThicknessChem: 0, sumVolume: 0, sumDensity: 0, sumPorosity: 0 }
    };

    let totalData = { count: 0, sumIronW: 0, sumIronT: 0, sumGlueW: 0, sumGlueT: 0, sumChemW: 0, sumChemT: 0, sumWeightChem: 0, sumThicknessChem: 0, sumVolume: 0, sumDensity: 0, sumPorosity: 0 };

    rows.each(function() {
        calculateRow(this);

        var side = $(this).find('select[name*="[product_sides]"]').val();
        
        let ironW = parseFloat($(this).find('.iron-w').val()) || 0;
        let ironT = parseFloat($(this).find('.iron-t').val()) || 0;
        let glueW = parseFloat($(this).find('.glue-w').val()) || 0;
        let glueT = parseFloat($(this).find('.glue-t').val()) || 0;
        let chemW = parseFloat($(this).find('.chem-w').val()) || 0;
        let chemT = parseFloat($(this).find('.chem-t').val()) || 0;

        let weightChem = parseFloat($(this).find('.calc-weight-chem').val()) || 0;
        let thicknessChem = parseFloat($(this).find('.calc-thickness-chem').val()) || 0;
        let volume = parseFloat($(this).find('.calc-volume').val()) || 0;
        let density = parseFloat($(this).find('.calc-density').val()) || 0;
        let porosity = parseFloat($(this).find('.calc-porosity').val()) || 0;

        if (groups[side]) {
            groups[side].count++;
            groups[side].sumIronW += ironW;
            groups[side].sumIronT += ironT;
            groups[side].sumGlueW += glueW;
            groups[side].sumGlueT += glueT;
            groups[side].sumChemW += chemW;
            groups[side].sumChemT += chemT;
            groups[side].sumWeightChem += weightChem;
            groups[side].sumThicknessChem += thicknessChem;
            groups[side].sumVolume += volume;
            groups[side].sumDensity += density;
            groups[side].sumPorosity += porosity;
        }

        totalData.count++;
        totalData.sumIronW += ironW;
        totalData.sumIronT += ironT;
        totalData.sumGlueW += glueW;
        totalData.sumGlueT += glueT;
        totalData.sumChemW += chemW;
        totalData.sumChemT += chemT;
        totalData.sumWeightChem += weightChem;
        totalData.sumThicknessChem += thicknessChem;
        totalData.sumVolume += volume;
        totalData.sumDensity += density;
        totalData.sumPorosity += porosity;
    });

    var footerHtml = '';

    $.each(groups, function(sideName, data) {
        if (data.count > 0) {
            let avgCount = data.count;
            footerHtml += `
                <tr class="table-secondary">
                    <td colspan="12" class="text-start fw-bold">Side: ${sideName}</td>
                </tr>
                <tr>
                    <td>Total (${sideName})</td>
                    <td>${data.sumIronW.toFixed(2)}</td>
                    <td>${data.sumIronT.toFixed(2)}</td>
                    <td>${data.sumGlueW.toFixed(2)}</td>
                    <td>${data.sumGlueT.toFixed(2)}</td>
                    <td>${data.sumChemW.toFixed(2)}</td>
                    <td>${data.sumChemT.toFixed(2)}</td>
                    <td>${data.sumWeightChem.toFixed(2)}</td>
                    <td>${data.sumThicknessChem.toFixed(2)}</td>
                    <td>${data.sumVolume.toFixed(2)}</td>
                    <td>${data.sumDensity.toFixed(2)}</td>
                    <td>${data.sumPorosity.toFixed(2)}</td>
                </tr>
                <tr>
                    <td>Average (${sideName})</td>
                    <td>${(data.sumIronW / avgCount).toFixed(2)}</td>
                    <td>${(data.sumIronT / avgCount).toFixed(2)}</td>
                    <td>${(data.sumGlueW / avgCount).toFixed(2)}</td>
                    <td>${(data.sumGlueT / avgCount).toFixed(2)}</td>
                    <td>${(data.sumChemW / avgCount).toFixed(2)}</td>
                    <td>${(data.sumChemT / avgCount).toFixed(2)}</td>
                    <td>${(data.sumWeightChem / avgCount).toFixed(2)}</td>
                    <td>${(data.sumThicknessChem / avgCount).toFixed(2)}</td>
                    <td>${(data.sumVolume / avgCount).toFixed(2)}</td>
                    <td>${(data.sumDensity / avgCount).toFixed(2)}</td>
                    <td>${(data.sumPorosity / avgCount).toFixed(2)}</td>
                </tr>
            `;
        }
    });

    if (totalData.count > 0) {
        let allCount = totalData.count;
        footerHtml += `
            <tr class="table-dark text-white">
                <td colspan="12" class="text-start fw-bold">Grand Total / Overall Average</td>
            </tr>
            <tr class="fw-bold bg-light">
                <td>Total (All)</td>
                <td>${totalData.sumIronW.toFixed(2)}</td>
                <td>${totalData.sumIronT.toFixed(2)}</td>
                <td>${totalData.sumGlueW.toFixed(2)}</td>
                <td>${totalData.sumGlueT.toFixed(2)}</td>
                <td>${totalData.sumChemW.toFixed(2)}</td>
                <td>${totalData.sumChemT.toFixed(2)}</td>
                <td>${totalData.sumWeightChem.toFixed(2)}</td>
                <td>${totalData.sumThicknessChem.toFixed(2)}</td>
                <td>${totalData.sumVolume.toFixed(2)}</td>
                <td>${totalData.sumDensity.toFixed(2)}</td>
                <td>${totalData.sumPorosity.toFixed(2)}</td>
                <td></td>
            </tr>
            <tr class="fw-bold bg-light">
                <td>Average (All)</td>
                <td>${(totalData.sumIronW / allCount).toFixed(2)}</td>
                <td>${(totalData.sumIronT / allCount).toFixed(2)}</td>
                <td>${(totalData.sumGlueW / allCount).toFixed(2)}</td>
                <td>${(totalData.sumGlueT / allCount).toFixed(2)}</td>
                <td>${(totalData.sumChemW / allCount).toFixed(2)}</td>
                <td>${(totalData.sumChemT / allCount).toFixed(2)}</td>
                <td>${(totalData.sumWeightChem / allCount).toFixed(2)}</td>
                <td>${(totalData.sumThicknessChem / allCount).toFixed(2)}</td>
                <td>${(totalData.sumVolume / allCount).toFixed(2)}</td>
                <td>${(totalData.sumDensity / allCount).toFixed(2)}</td>
                <td>${(totalData.sumPorosity / allCount).toFixed(2)}</td>
                <td></td>
            </tr>
        `;
    }

    $('#cavity_table_footer').html(footerHtml).show();
}

// เมื่อเลือก Mold และสร้างแถวตาม Cavity
$('#mlod_code').on('change', function() {
    var selectedMoldCode = $(this).val();
    var cavityCount = $('#mlod_cavity').val(); 
    var tbody = $('#cavity_table_body');
    tbody.empty();

    if (cavityCount && cavityCount > 0 && selectedMoldCode !== '-') {
        for (var i = 1; i <= cavityCount; i++) {
            var row = `
                <tr>
                    <td class="text-center">${i}</td>
                    <td class="text-center"><input type="number" step="any" class="form-control iron-w" name="cavity[${i}][weight_1]" value="0"></td>
                    <td class="text-center"><input type="number" step="any" class="form-control iron-t" name="cavity[${i}][thickness_1]" value="0"></td>
                    <td class="text-center"><input type="number" step="any" class="form-control glue-w" name="cavity[${i}][weight_2]" value="0"></td>
                    <td class="text-center"><input type="number" step="any" class="form-control glue-t" name="cavity[${i}][thickness_2]" value="0"></td>
                    <td class="text-center"><input type="number" step="any" class="form-control chem-w" name="cavity[${i}][weight_3]" value="0"></td>
                    <td class="text-center"><input type="number" step="any" class="form-control chem-t" name="cavity[${i}][thickness_3]" value="0"></td>
                    <td class="text-center"><input type="text" class="form-control calc-weight-chem bg-light" name="cavity[${i}][weight_chemical]" value="0" readonly></td>
                    <td class="text-center"><input type="text" class="form-control calc-thickness-chem bg-light" name="cavity[${i}][thickness_chemical]" value="0" readonly></td>
                    <td class="text-center"><input type="text" class="form-control calc-volume bg-light" name="cavity[${i}][density_workpiece_dts_volume]" value="0" readonly></td>
                    <td class="text-center"><input type="text" class="form-control calc-density bg-light" name="cavity[${i}][density_workpiece_dts_density]" value="0" readonly></td>
                    <td class="text-center"><input type="text" class="form-control calc-porosity bg-light" name="cavity[${i}][density_workpiece_dts_porosity]" value="0" readonly></td>
                    <td class="text-center">
                        <select class="form-control" name="cavity[${i}][product_sides]">
                            <option value="-">กรุณาเลือก</option>
                            <option value="ซ้าย">ซ้าย</option>
                            <option value="ขวา">ขวา</option>
                            <option value="ซ้าย-ขวา">ซ้าย-ขวา</option>
                        </select>
                    </td>
                </tr>
            `;
            tbody.append(row);
        }
        calculateAllRows();
    } else {
        tbody.append(`<tr><td colspan="12" class="text-center text-muted">กรุณาเลือก Mold ก่อน</td></tr>`);
        $('#cavity_table_footer').hide();
    }
});

// Event เมื่อกรอกตัวเลขในช่องคำนวณ
$(document).on('input', '.iron-w, .iron-t, .glue-w, .glue-t, .chem-w, .chem-t', function() {
    calculateAllRows();
});

// Event เมื่อเปลี่ยนค่า Side ใน Dropdown แถวต่างๆ
$(document).on('change', 'select[name*="[product_sides]"]', function() {
    calculateAllRows();
});

$('#mlod_area').on('change', function() {
    calculateAllRows();
});
</script>
@endpush