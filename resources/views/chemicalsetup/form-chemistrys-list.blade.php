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
             <div class="col-12 col-md-6"><a style="float: right" href="{{route('chemistrys.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> เพิ่มรายการ</a></div>
        </div>       
        <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>
                    <th>วันที่</th>
                    <th>ประเภท</th>                   
                    <th>เลขที่สูตร</th>
                    <th>ชื่อสูตร</th>
                    <th>หมายเหตุ</th>
                    <th>ผู้บันทึก</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hd as $item)
                   <tr>
                        <td>{{$item->chemistry_hd_date}}</td>
                        <td>{{$item->chemistry_hd_type}}</td>
                        <td>{{$item->chemistry_hd_name}}</td>
                        <td>{{$item->ms_formule_name}}</td>
                        <td>{{$item->chemistry_hd_note}}</td>
                        <td>{{$item->chemistry_hd_save}}</td>
                        <td>
                            <a href="{{route('chemistrys.show',$item->chemistry_hd_id)}}" class="btn btn-sm btn-info" >
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
        "pageLength": 30,
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