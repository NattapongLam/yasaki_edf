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
                <div class="col-12 col-md-6"><h3 class="card-title">ใบแจ้งซ่อม</h3></div>
            </div>      
            <form method="POST" class="form-horizontal" action="{{ route('maintenances.update',$hd->repair_machinery_hds_id) }}" enctype="multipart/form-data">
            @csrf  
            @method('PUT')     
            <div class="row mt-2">
                <div class="col-3">
                    <div class="form-group">
                        <label for="" class="col-form-label">วันที่</label>
                        <input class="form-control" type="date" name="repair_machinery_hds_date" value="{{ $hd->repair_machinery_hds_date }}" readonly>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="repair_machinery_hds_docuno" class="col-form-label">เลขที่</label>
                        <input class="form-control" type="text" name="repair_machinery_hds_docuno" id="repair_machinery_hds_docuno" value="{{$hd->repair_machinery_hds_docuno}}" required readonly>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="repair_type" class="col-form-label">ประเภท</label>
                        <select class="form-control" name="repair_machinery_hds_type" id="repair_type" disabled>
                            @if ($hd->repair_machinery_hds_type == "CAL")
                                <option value="CAL">เครื่องมือวัด</option>
                                <option value="MC">เครื่องจักร</option>
                            @elseif($hd->repair_machinery_hds_type == "MC")                               
                                <option value="MC">เครื่องจักร</option>
                                <option value="CAL">เครื่องมือวัด</option>
                            @endif                           
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="" class="col-form-label">กำหนดเสร็จ</label>
                        <input class="form-control" type="date" name="repair_machinery_hds_duedate" value="{{ $hd->repair_machinery_hds_duedate }}" readonly>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-4">
                    <div class="form-group">
                        <label for="" class="col-form-label">รหัส</label>
                        <input class="form-control" type="text" name="repair_code" value="{{ $hd->repair_code }}" readonly>
                    </div>
                </div>
                <div class="col-8">
                    <div class="form-group">
                        <label for="" class="col-form-label">ชื่อ</label>
                        <input class="form-control" type="text" name="repair_name" value="{{ $hd->repair_name }}" readonly>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="form-group">
                        <label for="" class="col-form-label">หมายเหตุ</label>
                        <textarea class="form-control" rows="3" name="repair_machinery_hds_remark" disabled>{{$hd->repair_machinery_hds_remark}}</textarea>
                    </div>
                </div>               
            </div>
            <br>
            <div class="row mt-2">
                    <table class="table table-bordered dt-responsive nowrap w-100 text-center">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 40%">ชิ้นส่วน</th>
                                <th style="width: 50%">รายละเอียด</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach ($dt as $item)
                                <tr>
                                    <td>{{$item->repair_machinery_dts_listno}}</td>
                                    <td>{{$item->repair_machinery_dts_part}}</td>
                                    <td>{{$item->repair_machinery_dts_remark}}</td>
                                </tr>
                            @endforeach
                        </tbody>       
                    </table>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="form-group">
                        <label for="" class="col-form-label">บันทึกผลการซ่อม</label>
                        <textarea class="form-control" rows="3" name="repair_machinery_hds_result_note" ></textarea>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="" class="col-form-label">วันที่ซ่อมเสร็จ</label>
                        <input class="form-control" type="date" name="repair_machinery_hds_result_date">
                    </div>
                </div> 
                <div class="col-3">
                    <div class="form-group">
                        <label for="" class="col-form-label">ผู้ดำเนินการ</label>
                        <input class="form-control" type="text" name="repair_machinery_hds_result_person">
                    </div>
                </div>
                <div class="col-3">
                        <div class="form-group">
                            <label for="" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile01"  name="repair_machinery_hds_result_file1" onchange="prevFile(this,'repair_machinery_hds_result_file1')">
                        </div>
                    </div>
                <div class="col-3">
                        <div class="form-group">
                            <label for="" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile02"  name="repair_machinery_hds_result_file2" onchange="prevFile(this,'repair_machinery_hds_result_file2')">
                        </div>
                </div>          
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
    </div>
</div>
@endsection
@push('scriptjs')
<script>
function prevFile(input, elm) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.' + elm).attr('src', e.target.result);
            file = input.files[0];
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush