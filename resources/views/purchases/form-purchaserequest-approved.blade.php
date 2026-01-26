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
        <form method="POST" class="form-horizontal" action="{{ route('purchaserequests.update',$hd->ap_purchaserequest_hds_id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">อนุมัติใบขอสั่งซื้อ</h3></div>
            <input type="hidden" value="Approved" name="checkdoc">
        </div>       
        <div class="row mt-3">
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_purchaserequest_hds_date" class="col-form-label">วันที่</label>
                   <input type="date" class="form-control" 
                            name="ap_purchaserequest_hds_date" 
                            id="ap_purchaserequest_hds_date"
                            value="{{ $hd->ap_purchaserequest_hds_date }}" 
                            readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_purchaserequest_hds_docuno" class="col-form-label">เลขที่</label>
                   <input type="text" class="form-control" 
                            name="ap_purchaserequest_hds_docuno" 
                            id="ap_purchaserequest_hds_docuno" 
                            value="{{ $hd->ap_purchaserequest_hds_docuno }}"
                            readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="ms_allocate_id" class="col-form-label">จัดสรร</label>
                    <select class="form-control" name="ms_allocate_id" disabled>
                        <option value="0">กรุณาเลือก</option>
                        @foreach ($allocates as $item)
                            <option value="{{$item->ms_allocate_id}}"
                                {{ $item->ms_allocate_id == $hd->ms_allocate_id ? 'selected' : '' }}>
                                {{$item->ms_allocate_name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="form-group">
                    <label for="ap_purchaserequest_hds_remark" class="col-form-label">หมายเหตุ</label>
                    <textarea class="form-control" name="ap_purchaserequest_hds_remark" disabled>{{$hd->ap_purchaserequest_hds_remark}}</textarea>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <table class="table table-bordered dt-responsive nowrap w-100 text-center">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 30%">สินค้า</th>
                        <th style="width: 10%">จำนวน</th>
                        <th style="width: 10%">วันที่ต้องการ</th>
                        <th style="width: 30%">หมายเหตุ</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach ($dt as $item)
                        <tr>
                            <td>
                                <span class="row-number">{{ $loop->iteration }}</span>
                                <input type="hidden"
                                    name="ap_purchaserequest_dts_listno[]"
                                    class="row-number-hidden"
                                    value="{{ $loop->iteration }}">
                                <input type="hidden" name="ap_purchaserequest_dts_id[]" value="{{$item->ap_purchaserequest_dts_id}}">
                            </td>
                            <td>
                                <select class="form-control" name="wh_product_lists_id[]" disabled>
                                    <option value="0">กรุณาเลือก</option>
                                    @foreach ($products as $product)
                                            <option value="{{$product->wh_product_lists_id}}"
                                                {{$product->wh_product_lists_id == $item->wh_product_lists_id ? 'selected' : '' }}>
                                                {{$product->wh_product_lists_name1}}
                                            </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input name="ap_purchaserequest_dts_qty[]" class="form-control" value="{{$item->ap_purchaserequest_dts_qty}}" readonly>
                            </td>
                            <td>
                                <input name="ap_purchaserequest_hds_duedate[]" class="form-control" type="date" value="{{$item->ap_purchaserequest_hds_duedate}}" readonly>
                            </td>
                            <td>
                                <input name="ap_purchaserequest_dts_remark[]" class="form-control" value="{{$item->ap_purchaserequest_dts_remark}}" readonly>
                            </td>
                        </tr> 
                    @endforeach
                </tbody>       
            </table>
        </div>
        <div class="row mt-3">
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
</script>
@endpush