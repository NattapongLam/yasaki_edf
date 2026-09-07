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
            <div class="col-12 col-md-6"><h3 class="card-title">บัญชีรายชื่อสินค้า (YSK5-FM-LAB-07 : Rev.00 : 01/08/2569)</h3></div>
            <div class="col-12 col-md-6"><a style="float: right" href="{{route('productlists.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> เพิ่มรายการ</a></div>
        </div>       
        <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>
                    <th>สถานะ</th>
                    <th>สินค้า</th>
                    <th>วันที่รับล่าสุด</th>
                    <th>ผู้ขาย/ผู้ผลิต</th>
                    <th>Lot No.</th>
                    <th>จำนวน</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hd as $item)
                    <tr>
                        <td>
                            @if ($item->wh_product_lists_flag)
                                <span class="bg-success">ใช้งาน</span>
                            @else
                                <span class="bg-danger">ยกเลิก</span>
                            @endif
                        </td>
                        <td>{{$item->wh_product_lists_name1}} ({{$item->wh_product_lists_code}})</td>
                        <td>
                            @if ($item->ap_purchase_receive_hds_date)
                                {{$item->ap_purchase_receive_hds_date}}<br>
                                ผู้รับ/ผู้อนุมัติ : {{$item->person_at}}
                            @endif
                            
                        </td>
                        <td>{{$item->ap_vendor_lists_name}}</td>
                        <td>{{$item->ap_purchase_receive_hds_docuno}}</td>
                        <td>
                            @if ($item->ap_purchase_receive_dts_qty)
                            {{$item->ap_purchase_receive_dts_qty}} {{$item->Units->wh_product_units_name}}<br>
                            วันหมดอายุ : {{$item->ap_purchase_receive_dts_expiradate}}
                            @endif
                        </td>
                        <td>
                            <a href="{{route('productlists.edit',$item->wh_product_lists_id)}}" class="btn btn-sm btn-warning" >
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
@push('scriptjs')
<script>
$(document).ready(function() {
    $('#tb_job').DataTable({
        "pageLength": 50,
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