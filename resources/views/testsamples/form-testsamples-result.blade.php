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
                    <th>ลูกค้า</th>
                    <th>ติดต่อ</th>
                    <th>หมายเหตุ</th>
                    <th>ผู้อนุมัติ</th>
                    <th>ผู้รับชิ้นงาน</th>
                    <th>รูปชิ้นงาน</th>
                    <th>อัพเดท</th>
                    <th>พิมพ์รายงาน</th>
                    <th>เอกสารส่งมอบ</th>
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
                           น้ำหนักชิ้นงานชั่งจริง: {{$item->receive_test_lists_weight}}<br>
                           สูตรเคมี: {{$item->ms_formule_name}} ({{$item->chemistry_hd_name}})
                        </td>
                        <td>
                            <img src="{{asset($item->receive_test_lists_file1)}}" class="img-thumbnail" width="25%">
                            <img src="{{asset($item->receive_test_lists_file2)}}" class="img-thumbnail" width="25%">
                            <img src="{{asset($item->result_test_lists_file1)}}" class="img-thumbnail" width="25%">
                            <img src="{{asset($item->result_test_lists_file2)}}" class="img-thumbnail" width="25%">
                        </td>
                        <td>
                            <a href="{{ route('receive-result.detail.edit', $item->ar_requestorder_hds_id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            @if ($item->TestID)
                             <a href="{{ route('report.compareformulas.print',$item->TestID) }}" target="_blank" class="btn btn-sm btn-warning">
                                <i class="fas fa-print"></i>
                            </a>    
                            @endif                           
                        </td>
                        <td>
                            <a href="{{ route('delivered.edit',$item->ar_requestorder_hds_id) }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> สร้าง</a>
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