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
            <div class="col-12 col-md-6"><h3 class="card-title">เขต/อำเภอ</h3></div> 
        </div>
        <div class="row">            
            <div class="col-6">
                <form method="POST" class="form-horizontal" action="{{ route('districts.store') }}" enctype="multipart/form-data">
                @csrf  
                <div class="form-group">
                    <label for="other_provinces_id" class="col-form-label">จังหวัด</label>
                    <select class="form-select select2" name="other_provinces_id" id="other_provinces_id">
                        <option value="">กรุณาเลือก</option>
                        @foreach ($province as $item)
                            <option value="{{$item->other_provinces_id}}">{{$item->other_provinces_name1}}</option>
                        @endforeach
                    </select>
                </div>     
                <div class="form-group">
                    <label for="other_districts_name1" class="col-form-label">ชื่อภาษาไทย</label>
                    <input type="text" class="form-control" name="other_districts_name1" id="other_districts_name1" required>
                </div>
                <div class="form-group">
                    <label for="other_districts_name2" class="col-form-label">ชื่อภาษาอังกฤษ</label>
                    <input type="text" class="form-control" name="other_districts_name2" id="other_districts_name2">
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
            <div class="col-6">
            <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>
                    <th>สถานะ</th>
                    <th>จังหวัด</th>
                    <th>เขต/อำเภอ</th>
                    <th>แก้ไข</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hd as $item)
                    <tr>
                        <td>
                            @if ($item->other_districts_flag)
                                <span class="bg-success">ใช้งาน</span>
                            @else
                                <span class="bg-danger">ยกเลิก</span>
                            @endif
                        </td>
                        <td>
                            {{$item->Province->other_provinces_name1}}
                        </td>
                        <td>
                            {{$item->other_districts_name1}}
                            @if ($item->other_districts_name2)
                                <br>
                                ({{$item->other_districts_name2}}) 
                            @endif
                        </td>
                        <td>
                            <a href="{{route('districts.edit',$item->other_districts_id)}}" class="btn btn-sm btn-warning" >
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
    $('#other_provinces_id').select2({
        placeholder: "กรุณาเลือกจังหวัด",
        allowClear: true,
        width: '100%'
    });
});
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