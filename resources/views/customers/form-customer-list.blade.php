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
            <div class="col-12 col-md-6"><h3 class="card-title">ลูกค้า</h3></div> 
            <div class="col-12 col-md-6"><a style="float: right" href="{{route('customerlists.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> เพิ่มลูกค้า</a></div>
        </div>
        <div class="row">            
            <div class="col-12">
            <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>
                    <th>สถานะ</th>
                    <th>รหัสลูกค้า</th>
                    <th>ชื่อลูกค้า</th>
                    <th>กลุ่มลูกค้า</th>
                    <th>ผู้ติดต่อ</th>
                    <th>เบอร์โทร</th>
                    <th>แก้ไข</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hd as $item)
                    <tr>
                        <td>
                            @if ($item->ar_customer_lists_flag)
                                <span class="bg-success">ใช้งาน</span>
                            @else
                                <span class="bg-danger">ยกเลิก</span>
                            @endif
                        </td>
                        <td>
                            {{$item->ar_customer_lists_code}}
                        </td>
                        <td>
                            {{$item->ar_customer_lists_name1}}
                        </td>
                        <td>
                            {{$item->Groups->ar_customer_groups_name}}
                        </td>
                        <td>
                            {{$item->ar_customer_lists_contact}}
                        </td>
                        <td>
                            {{$item->ar_customer_lists_tel}}
                        </td>
                        <td>
                            <a href="{{route('customerlists.edit',$item->ar_customer_lists_id)}}" class="btn btn-sm btn-warning" >
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