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
            <div class="col-12 col-md-6"><h3 class="card-title">ชิ้นงานหลังทดสอบ</h3></div>           
        </div>       
        <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>
                    <th>สถานะ</th>
                    <th>วันที่</th>
                    <th>เลขที่</th>
                    <th>กำหนดส่ง</th>
                    <th>ลูกค้า</th>
                    <th>ติดต่อ</th>
                    <th>หมายเหตุ</th>
                    <th>ผู้อนุมัติ</th>
                    <th>ผู้รับชิ้นงาน</th>
                    <th>ชิ้นงานก่อนทดสอบ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hd as $item)
                    <tr>
                        <td>
                            @if ($item->ar_requestorder_statuses_id == 6)
                                <span class="bg-warning bg-soft">
                                    {{$item->ar_requestorder_statuses_name}}
                                </span>
                            @else
                                <span class="bg-danger bg-soft">
                                    {{$item->ar_requestorder_statuses_name}}
                                </span>
                            @endif
                        </td>
                        <td>
                            {{$item->ar_requestorder_hds_date}}
                        </td>
                        <td>
                            {{$item->ar_requestorder_hds_docuno}}
                        </td>
                        <td>
                            {{$item->ar_requestorder_hds_duedate}}
                        </td>
                        <td>
                            {{$item->ar_requestorder_hds_customer}}
                        </td>
                        <td>
                            {{$item->ar_requestorder_hds_contact}}
                        </td>
                        <td>
                            {{$item->ar_requestorder_hd_remark}}
                        </td>
                        <td>
                           {{$item->approved_at}}<br>
                           {{\Carbon\Carbon::parse($item->approved_date)->format('d/m/Y') ?? ''}}
                        </td>
                        <td>
                           {{$item->person_at}}<br>
                           {{\Carbon\Carbon::parse($item->receive_test_lists_date)->format('d/m/Y') ?? ''}}<br>
                           มิติชิ้นงานวัดจริง: {{$item->receive_test_lists_dimensions}}<br>
                           น้ำหนักชิ้นงานชั่งจริง: {{$item->receive_test_lists_weight}}
                        </td>
                        <td>
                            <img src="{{asset($item->receive_test_lists_file1)}}" class="img-thumbnail" width="10%">
                            <img src="{{asset($item->receive_test_lists_file2)}}" class="img-thumbnail" width="10%">
                        </td>
                        <td>
                            @if ($item->ar_requestorder_statuses_id == 6)
                            <a href="{{route('receive-test.show',$item->ar_requestorder_hds_id)}}" class="btn btn-sm btn-warning" >
                                    <i class="fas fa-edit"></i>
                                </a> 
                            @endif
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
        "pageLength": 10,
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