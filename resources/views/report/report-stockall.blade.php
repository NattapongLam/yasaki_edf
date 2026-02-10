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
            <div class="col-12 col-md-6"><h3 class="card-title">สต็อคคงเหลือ</h3></div>
        </div>
          <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs nav-tabs-custom justify-content-center pt-2" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#all-post" role="tab">
                                              คลังสำนักงาน
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#archive1" role="tab">
                                               เคมีภัณฑ์  
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#archive2" role="tab">
                                               อุปกรณ์/เครื่องมือ/เครื่องจักร
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#archive3" role="tab">
                                               ทั่วไป..
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#archive4" role="tab">
                                               ของเสีย
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content p-4">
                                        <div class="tab-pane active" id="all-post" role="tabpanel">  
                                            <table id="tb_job1" class="table table-bordered dt-responsive nowrap w-100 text-center">   
                                                <thead>
                                                    <tr>
                                                        <th>สินค้า</th>
                                                        <th>จำนวน</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($hd1 as $item)
                                                        <tr>
                                                            <td>{{$item->wh_product_lists_code}}/{{$item->wh_product_lists_name1}} ({{$item->wh_product_units_name}})</td>
                                                            <td>{{number_format($item->goodqty,2)}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>                                  
                                        </div>
                                        <div class="tab-pane" id="archive1" role="tabpanel">
                                            <table id="tb_job2" class="table table-bordered dt-responsive nowrap w-100 text-center">   
                                                <thead>
                                                    <tr>
                                                        <th>สินค้า</th>
                                                        <th>จำนวน</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($hd2 as $item)
                                                        <tr>
                                                            <td>{{$item->wh_product_lists_code}}/{{$item->wh_product_lists_name1}} ({{$item->wh_product_units_name}})</td>
                                                            <td>{{number_format($item->goodqty,2)}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="archive2" role="tabpanel">
                                            <table id="tb_job3" class="table table-bordered dt-responsive nowrap w-100 text-center">   
                                                <thead>
                                                    <tr>
                                                        <th>สินค้า</th>
                                                        <th>จำนวน</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($hd3 as $item)
                                                        <tr>
                                                            <td>{{$item->wh_product_lists_code}}/{{$item->wh_product_lists_name1}} ({{$item->wh_product_units_name}})</td>
                                                            <td>{{number_format($item->goodqty,2)}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="archive3" role="tabpanel">
                                            <table id="tb_job4" class="table table-bordered dt-responsive nowrap w-100 text-center">   
                                                <thead>
                                                    <tr>
                                                        <th>สินค้า</th>
                                                        <th>จำนวน</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($hd4 as $item)
                                                        <tr>
                                                            <td>{{$item->wh_product_lists_code}}/{{$item->wh_product_lists_name1}} ({{$item->wh_product_units_name}})</td>
                                                            <td>{{number_format($item->goodqty,2)}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="archive4" role="tabpanel">
                                            <table id="tb_job5" class="table table-bordered dt-responsive nowrap w-100 text-center">   
                                                <thead>
                                                    <tr>
                                                        <th>สินค้า</th>
                                                        <th>จำนวน</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($hd5 as $item)
                                                        <tr>
                                                            <td>{{$item->wh_product_lists_code}}/{{$item->wh_product_lists_name1}} ({{$item->wh_product_units_name}})</td>
                                                            <td>{{number_format($item->goodqty,2)}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                        </div>       
    </div>
</div>
</div>
@endsection
@push('scriptjs')
<script>
$(document).ready(function() {
    $('#tb_job1').DataTable({
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
$(document).ready(function() {
    $('#tb_job2').DataTable({
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
$(document).ready(function() {
    $('#tb_job3').DataTable({
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
$(document).ready(function() {
    $('#tb_job4').DataTable({
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
$(document).ready(function() {
    $('#tb_job5').DataTable({
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