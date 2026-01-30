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
        <form method="POST" class="form-horizontal" action="{{ route('issuestocks.update',$hd->wh_issuestock_hds_id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">อนุมัติใบเบิก</h3></div>  
            <input type="hidden" value="Approved" name="checkdoc">         
        </div> 
             <div class="row">
            <div class="col-2">
                <div class="form-group">
                    <label for="wh_issuestock_hds_date" class="col-form-label">วันที่</label>
                   <input type="date" class="form-control" 
                            name="wh_issuestock_hds_date" 
                            id="wh_issuestock_hds_date"
                            value="{{$hd->wh_issuestock_hds_date}}" 
                            readonly>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="wh_issuestock_hds_docuno" class="col-form-label">เลขที่</label>
                    <input type="text" class="form-control" 
                            name="wh_issuestock_hds_docuno" 
                            id="wh_issuestock_hds_docuno" 
                            value="{{$hd->wh_issuestock_hds_docuno}}"
                            readonly>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="wh_warehouses_id" class="col-form-label">คลังสินค้า</label>
                    <select class="form-select" name="wh_warehouses_id" id="wh_warehouses_id" disabled>
                        <option value="">กรุณาเลือก</option>
                        @foreach ($warehouses as $item)
                            <option value="{{$item->wh_warehouses_id}}"
                                {{$item->wh_warehouses_id == $hd->wh_warehouses_id ? 'selected' : '' }}>
                                {{$item->wh_warehouses_name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="wh_issuestock_hds_remark" class="col-form-label">หมายเหตุ</label>
                    <input type="text" class="form-control" name="wh_issuestock_hds_remark" value="{{$hd->wh_issuestock_hds_remark}}" readonly>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <table class="table table-bordered dt-responsive nowrap w-100 text-center">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 30%">สินค้า</th>
                        <th style="width: 10%">จำนวนเบิก</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach ($dt as $item)
                        <tr>
                            <td>
                                <span class="row-number">{{ $loop->iteration }}</span>
                                <input type="hidden"
                                    name="wh_issuestock_dts_listno[]"
                                    class="row-number-hidden"
                                    value="{{ $loop->iteration }}">
                                <input type="hidden" name="wh_issuestock_dts_id[]" value="{{$item->wh_issuestock_dts_id}}">
                            </td>
                            <td>
                                {{$item->wh_product_lists_name}} สต็อค : {{$item->stc_stockcard_qty}} {{$item->wh_product_lists_unit}}
                            </td>
                            <td><input type="text" name="wh_issuestock_dts_qty[]" class="form-control" value="{{$item->wh_issuestock_dts_qty}}"/></td>
                        </tr>
                    @endforeach
                </tbody>       
            </table>
        </div>
        <div class="row">
             <div class="col-12">
                <div class="form-group">
                    <label for="approved_remark" class="col-form-label">หมายเหตุอนุมัติ</label>
                    <textarea class="form-control" name="approved_remark">{{$hd->approved_remark}}</textarea>
                </div>
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
    </div>
</div>
</div>
@endsection
@push('scriptjs')
<script>
</script>
@endpush