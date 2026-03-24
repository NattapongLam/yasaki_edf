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
                                <th>RoadTest</th>
                                <th>Normal (µ)</th>
                                <th>Hot (µ)</th>
                                <th>Wear (10−7cm3/(N⋅m))</th>
                                <th>หมายเหตุ</th>
                            </tr>
                        </thead> 
                        <tbody>
                            @foreach ($hd as $item)
                                <tr>
                                    <td>
                                        <input type="checkbox"
                                        class="chkFormula"
                                        value="{{$item->FormulaNumber}}">
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->TestDate)->format('d/m/Y') }}</td>
                                    <td>{{$item->FormulaName}}</td>
                                    <td>{{$item->FormulaNumber}}</td>                                  
                                    <td>{{number_format($item->HardnessQty,2)}}</td>
                                    <td>{{number_format($item->ShearingQty,2)}}</td>
                                    <td>{{number_format($item->NoiseQty,2)}}</td>
                                    <td>{{number_format($item->RoadTestQty,2)}}</td>
                                    <td>{{number_format($item->NormalQty,2)}}</td>
                                    <td>{{number_format($item->HotQty,2)}}</td>
                                    <td>{{number_format($item->WearQty,2)}}</td>
                                    <td>{{$item->Remarks}}</td>
                                </tr>
                            @endforeach
                        </tbody>                      
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scriptjs')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
</script>
@endpush