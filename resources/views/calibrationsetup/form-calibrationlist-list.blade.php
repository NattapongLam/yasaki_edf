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
            <div class="col-12 col-md-6"><h3 class="card-title">ทะเบียนครื่องมือวัด</h3></div>
            <div class="col-12 col-md-6"><a style="float: right" href="{{route('calibrationlists.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> เพิ่มรายการ</a></div>
        </div>       
        <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>
                    <th>สถานะ</th>
                    <th>รหัส</th>
                    <th>ชื่อ</th>
                    <th>หมวด</th>
                    <th>กลุ่ม</th>
                    <th>ประเภท</th>
                    <th>วันที่ทวนสอบครั้งต่อไป</th>
                    <th></th>
                    <th>ตรวจประจำวัน</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hd as $item)
                    <tr>
                        <td>
                            {{$item->calibration_lists_status}}
                        </td>
                        <td>{{$item->calibration_lists_code}}</td>
                        <td>{{$item->calibration_lists_name1}}</td>
                        <td>{{$item->Categorys->calibration_categories_name}}</td>
                        <td>{{$item->Groups->calibration_groups_name}}</td>
                        <td>{{$item->Types->calibration_types_name}}</td>
                        <td>{{$item->calibration_lists_nextdate}}</td>
                        <td>
                            <a href="{{route('calibrationlists.edit',$item->calibration_lists_id)}}" class="btn btn-sm btn-warning" >
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <a href="{{route('calibrationlists.show',$item->calibration_lists_id)}}" class="btn btn-sm btn-info" >
                                <i class="fas fa-plus"></i>
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