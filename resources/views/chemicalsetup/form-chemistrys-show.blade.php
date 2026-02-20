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
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="chemistry_hd_date" class="col-form-label">วันที่</label>
                    <input type="date" class="form-control" name="chemistry_hd_date" id="chemistry_hd_date" value="{{$hd->chemistry_hd_date}}" readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="chemistry_hd_docuno" class="col-form-label">เลขที่</label>
                    <input type="text" class="form-control" name="chemistry_hd_docuno" id="chemistry_hd_docuno" value="{{$hd->chemistry_hd_docuno}}" readonly>
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
        </div> 
        <div class="row">          
            <div class="col-3">
                <div class="form-group">
                    <label for="chemistry_hd_type" class="col-form-label">ประเภท</label>
                    <input type="text" class="form-control" name="chemistry_hd_type" id="chemistry_hd_type" value="{{$hd->chemistry_hd_type}}" readonly>
                </div>
            </div>
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
        </div> 
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="chemistry_hd_note" class="col-form-label">หมายเหตุ</label>
                    <textarea class="form-control" readonly>{{$hd->chemistry_hd_note}}</textarea>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <table class="table table-bordered">
                <thead style="color: black">
                    <tr>
                        <th>No.</th>
                        <th>Material</th>
                        <th>Group</th>
                        <th>Funtion</th>
                        <th>Grade</th>
                        <th>Density(g/cc)</th>
                        <th>Vol.% adjust</th>
                        <th>Weght(%)</th>
                        <th>Weght(g)</th>
                    </tr>
                </thead>
                <tbody style="color: black">
                    @foreach ($dt as $item)
                        <tr style="{{ $item->chemical_groups_color ? 'background-color: '.$item->chemical_groups_color : '' }}">
                            <td>{{ $item->no }}</td>
                            <td>{{ $item->material }} ({{ $item->code }})</td>
                            <td>{{ $item->chemical_groups_name }}</td>
                            <td>{{ $item->chemical_funtions_name }}</td>
                            <td>{{ $item->grade }}</td>
                            <td>{{ number_format($item->density,2) }}</td>
                            <td>{{ number_format($item->adjust,2) }}</td>
                            <td>{{ number_format($item->weghtper,2) }}</td>
                            <td>{{ number_format($item->weghttotal,2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>            
    </div> 
</div>
</div>
@endsection
@push('scriptjs')
<script>
</script>
@endpush