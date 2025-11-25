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
            <div class="col-12 col-md-6"><h3 class="card-title">งวดบัญชี</h3></div> 
        </div>
        <div class="row">            
            <div class="col-6">
                <form method="POST" class="form-horizontal" action="{{ route('periods.store') }}" enctype="multipart/form-data">
                @csrf       
                <div class="form-group">
                    <label for="acc_companies_year" class="col-form-label">ปี</label>
                    <input type="text" class="form-control" name="acc_companies_year" id="acc_companies_year" required>
                </div>
                <div class="form-group">
                    <label for="acc_companies_date1" class="col-form-label">วันที่เริ่ม</label>
                    <input type="date" class="form-control" name="acc_companies_date1" id="acc_companies_date1" required>
                </div>
                <div class="form-group">
                    <label for="acc_companies_date2" class="col-form-label">วันที่จบ</label>
                    <input type="date" class="form-control" name="acc_companies_date2" id="acc_companies_date2" required>
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
                    <th>ปี</th>
                    <th>งวด</th>
                    <th>แก้ไข</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hd as $item)
                    <tr>
                        <td>
                            @if ($item->acc_companies_flag)
                                <span class="bg-success">เปิดงวด</span>
                            @else
                                <span class="bg-danger">ปิดงวด</span>
                            @endif
                        </td>
                        <td>
                            {{$item->acc_companies_year}}
                        </td>
                        <td>
                            {{$item->acc_companies_date1}} -  {{$item->acc_companies_date2}}
                        </td>
                        <td>
                            <a href="{{route('periods.edit',$item->acc_periods_id)}}" class="btn btn-sm btn-warning" >
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