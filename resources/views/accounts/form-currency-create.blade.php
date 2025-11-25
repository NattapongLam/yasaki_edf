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
            <div class="col-12 col-md-6"><h3 class="card-title">สกุลเงิน</h3></div> 
        </div>
        <div class="row">            
            <div class="col-6">
                <form method="POST" class="form-horizontal" action="{{ route('currencys.store') }}" enctype="multipart/form-data">
                @csrf       
                <div class="form-group">
                    <label for="acc_currencies_code" class="col-form-label">รหัส</label>
                    <input type="text" class="form-control" name="acc_currencies_code" id="acc_currencies_code" required>
                </div>
                <div class="form-group">
                    <label for="acc_currencies_name" class="col-form-label">ชื่อ</label>
                    <input type="text" class="form-control" name="acc_currencies_name" id="acc_currencies_name" required>
                </div>
                <div class="form-group">
                    <label for="acc_currencies_rate" class="col-form-label">อัตราแลกเปลี่ยน</label>
                    <input type="text" class="form-control" name="acc_currencies_rate" id="acc_currencies_rate" required>
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
                    <th>สกุลเงิน</th>
                    <th>อัตราแลกเปลี่ยน</th>
                    <th>แก้ไข</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hd as $item)
                    <tr>
                        <td>
                            @if ($item->acc_currencies_flag)
                                <span class="bg-success">ใช้งาน</span>
                            @else
                                <span class="bg-danger">ยกเลิก</span>
                            @endif
                        </td>
                        <td>
                            {{$item->acc_currencies_name}}<br>
                            ({{$item->acc_currencies_code}})
                        </td>
                        <td>
                            {{number_format($item->acc_currencies_rate,2)}}
                        </td>
                        <td>
                            <a href="{{route('currencys.edit',$item->acc_currencies_id)}}" class="btn btn-sm btn-warning" >
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