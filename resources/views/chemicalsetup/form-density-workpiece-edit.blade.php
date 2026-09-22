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
            <form method="POST" class="form-horizontal" action="{{ route('density-workpiece.update', $hd->density_workpiece_hds_id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')  
                
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h3 class="card-title">ความหนาแน่นของชิ้นงาน</h3>
                    </div>         
                </div>

                <div class="row mt-2">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Product</label>
                            <input class="form-control" value="{{ $hd->product_name }} ({{$hd->product_code }})" readonly>
                        </div>             
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Mold</label>
                            <input class="form-control" value="{{ $hd->mlod_name }} ({{$hd->mlod_code }})" readonly>
                        </div>             
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">Area (cm²)</label>
                            <input class="form-control" name="mlod_area" id="mlod_area" value="{{ $hd->mlod_area }}" readonly>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">Pressure</label>
                            <input class="form-control" name="mlod_pressure" id="mlod_pressure" value="{{ $hd->mlod_pressure }}" readonly>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">Weight</label>
                            <input class="form-control" name="chemical_weight" value="{{ $hd->chemical_weight }}" readonly>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">Temp</label>
                            <input class="form-control" name="chemical_temp" value="{{ $hd->chemical_temp }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">Formule</label>
                            <input class="form-control" name="ms_formule_name" value="{{ $hd->ms_formule_name }}" readonly>                     
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">Number</label>
                            <input class="form-control" value="{{ $hd->chemistry_hd_name }}" readonly>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">Density (Target)</label>
                            <input class="form-control" name="total_density" id="total_density" value="{{ $hd->total_density }}" readonly>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">Sides</label>
                            <select class="form-control" name="product_sides">
                                <option value="{{ $hd->product_sides }}">{{ $hd->product_sides }}</option>
                            </select>
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
                                @foreach ($dt as $item)
                                <tr>
                                    <td class="text-center">{{ $item->density_workpiece_dts_listno }}</td>
                                    <td>
                                        <input type="number" step="any" class="form-control iron-w" name="cavity[{{ $item->density_workpiece_dts_listno }}][weight_1]" value="{{ $item->weight_1 }}">
                                    </td>
                                    <td>
                                        <input type="number" step="any" class="form-control iron-t" name="cavity[{{ $item->density_workpiece_dts_listno }}][thickness_1]" value="{{ $item->thickness_1 }}">
                                    </td>
                                    <td>
                                        <input type="number" step="any" class="form-control glue-w" name="cavity[{{ $item->density_workpiece_dts_listno }}][weight_2]" value="{{ $item->weight_2 }}">
                                    </td>
                                    <td>
                                        <input type="number" step="any" class="form-control glue-t" name="cavity[{{ $item->density_workpiece_dts_listno }}][thickness_2]" value="{{ $item->thickness_2 }}">
                                    </td>
                                    <td>
                                        <input type="number" step="any" class="form-control chem-w" name="cavity[{{ $item->density_workpiece_dts_listno }}][weight_3]" value="{{ $item->weight_3 }}">
                                    </td>
                                    <td>
                                        <input type="number" step="any" class="form-control chem-t" name="cavity[{{ $item->density_workpiece_dts_listno }}][thickness_3]" value="{{ $item->thickness_3 }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control calc-weight-chem bg-light" name="cavity[{{ $item->density_workpiece_dts_listno }}][weight_chemical]" value="{{ $item->weight_chemical }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control calc-thickness-chem bg-light" name="cavity[{{ $item->density_workpiece_dts_listno }}][thickness_chemical]" value="{{ $item->thickness_chemical }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control calc-volume bg-light" name="cavity[{{ $item->density_workpiece_dts_listno }}][density_workpiece_dts_volume]" value="{{ $item->density_workpiece_dts_volume }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control calc-density bg-light" name="cavity[{{ $item->density_workpiece_dts_listno }}][density_workpiece_dts_density]" value="{{ $item->density_workpiece_dts_density }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control calc-porosity bg-light" name="cavity[{{ $item->density_workpiece_dts_listno }}][density_workpiece_dts_porosity]" value="{{ $item->density_workpiece_dts_porosity }}" readonly>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot id="cavity_table_footer" style="font-weight: bold; background-color: #f8f9fa;">
                                <!-- ผลรวมจะถูกคำนวณผ่าน JavaScript -->
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
$(document).ready(function() {
    calculateAllRows();
});

function calculateRow(rowTr) {
    var ironW = parseFloat($(rowTr).find('.iron-w').val()) || 0;
    var ironT = parseFloat($(rowTr).find('.iron-t').val()) || 0;
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

    $(rowTr).find('.calc-weight-chem').val(weightChem !== 0 ? weightChem.toFixed(4) : '0');
    $(rowTr).find('.calc-thickness-chem').val(thicknessChem !== 0 ? thicknessChem.toFixed(4) : '0');
    $(rowTr).find('.calc-volume').val(volume !== 0 ? volume.toFixed(4) : '0');
    $(rowTr).find('.calc-density').val(density !== 0 ? density.toFixed(4) : '0');
    $(rowTr).find('.calc-porosity').val(porosity !== 0 ? porosity.toFixed(4) : '0');
}

function calculateAllRows() {
    var rows = $('#cavity_table_body tr');
    if (rows.length === 0) {
        $('#cavity_table_footer').hide();
        return;
    }

    let sumIronW = 0, sumIronT = 0;
    let sumGlueW = 0, sumGlueT = 0;
    let sumChemW = 0, sumChemT = 0;
    let sumWeightChem = 0, sumThicknessChem = 0, sumVolume = 0, sumDensity = 0, sumPorosity = 0;
    let count = rows.length;

    rows.each(function() {
        calculateRow(this);

        sumIronW += parseFloat($(this).find('.iron-w').val()) || 0;
        sumIronT += parseFloat($(this).find('.iron-t').val()) || 0;
        sumGlueW += parseFloat($(this).find('.glue-w').val()) || 0;
        sumGlueT += parseFloat($(this).find('.glue-t').val()) || 0;
        sumChemW += parseFloat($(this).find('.chem-w').val()) || 0;
        sumChemT += parseFloat($(this).find('.chem-t').val()) || 0;

        sumWeightChem += parseFloat($(this).find('.calc-weight-chem').val()) || 0;
        sumThicknessChem += parseFloat($(this).find('.calc-thickness-chem').val()) || 0;
        sumVolume += parseFloat($(this).find('.calc-volume').val()) || 0;
        sumDensity += parseFloat($(this).find('.calc-density').val()) || 0;
        sumPorosity += parseFloat($(this).find('.calc-porosity').val()) || 0;
    });

    var footerHtml = `
        <tr>
            <td>Total</td>
            <td>${sumIronW.toFixed(2)}</td>
            <td>${sumIronT.toFixed(2)}</td>
            <td>${sumGlueW.toFixed(2)}</td>
            <td>${sumGlueT.toFixed(2)}</td>
            <td>${sumChemW.toFixed(2)}</td>
            <td>${sumChemT.toFixed(2)}</td>
            <td>${sumWeightChem.toFixed(2)}</td>
            <td>${sumThicknessChem.toFixed(2)}</td>
            <td>${sumVolume.toFixed(2)}</td>
            <td>${sumDensity.toFixed(2)}</td>
            <td>${sumPorosity.toFixed(2)}</td>
        </tr>
        <tr>
            <td>Average</td>
            <td>${(sumIronW / count).toFixed(2)}</td>
            <td>${(sumIronT / count).toFixed(2)}</td>
            <td>${(sumGlueW / count).toFixed(2)}</td>
            <td>${(sumGlueT / count).toFixed(2)}</td>
            <td>${(sumChemW / count).toFixed(2)}</td>
            <td>${(sumChemT / count).toFixed(2)}</td>
            <td>${(sumWeightChem / count).toFixed(2)}</td>
            <td>${(sumThicknessChem / count).toFixed(2)}</td>
            <td>${(sumVolume / count).toFixed(2)}</td>
            <td>${(sumDensity / count).toFixed(2)}</td>
            <td>${(sumPorosity / count).toFixed(2)}</td>
        </tr>
    `;

    $('#cavity_table_footer').html(footerHtml).show();
}

$(document).on('input', '.iron-w, .iron-t, .glue-w, .glue-t, .chem-w, .chem-t', function() {
    calculateAllRows();
});
</script>
@endpush