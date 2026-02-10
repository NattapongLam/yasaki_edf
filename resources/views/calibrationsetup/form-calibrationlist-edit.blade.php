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
        </div>
        <div class="row">            
            <div class="col-12">
                <form method="POST" class="form-horizontal" action="{{ route('calibrationlists.update',$hd->calibration_lists_id) }}" enctype="multipart/form-data">
                @csrf   
                @method('PUT')
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_categories_id" class="col-form-label">หมวดเครื่องมือวัด</label>
                            <select class="form-select" name="calibration_categories_id" id="calibration_categories_id">
                                <option value="">กรุณาเลือก</option>
                                @foreach ($categorys as $item)
                                    <option value="{{$item->calibration_categories_id}}"
                                        {{ $item->calibration_categories_id == $hd->calibration_categories_id ? 'selected' : '' }}>
                                        {{$item->calibration_categories_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_groups_id" class="col-form-label">กลุ่มเครื่องมือวัด</label>
                            <select class="form-select" name="calibration_groups_id" id="calibration_groups_id">
                                <option value="">กรุณาเลือก</option>
                                @foreach ($groups as $item)
                                    <option value="{{$item->calibration_groups_id}}"
                                        {{ $item->calibration_groups_id == $hd->calibration_groups_id ? 'selected' : '' }}>
                                        {{$item->calibration_groups_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_types_id" class="col-form-label">ประเภทเครื่องมือวัด</label>
                            <select class="form-select" name="calibration_types_id" id="calibration_types_id">
                                <option value="">กรุณาเลือก</option>
                                @foreach ($types as $item)
                                    <option value="{{$item->calibration_types_id}}"
                                        {{ $item->calibration_groups_id == $hd->calibration_groups_id ? 'selected' : '' }}>
                                        {{$item->calibration_types_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_code" class="col-form-label">รหัสเครื่องมือวัด</label>
                            <input class="form-control" name="calibration_lists_code" id="calibration_lists_code" value="{{$hd->calibration_lists_code}}" readonly>
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="calibration_lists_name1" class="col-form-label">ชื่อภาษาไทย</label>
                            <input class="form-control" name="calibration_lists_name1" id="calibration_lists_name1"  value="{{$hd->calibration_lists_name1}}" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="calibration_lists_name2" class="col-form-label">ชื่อภาษาอังกฤษ</label>
                            <input class="form-control" name="calibration_lists_name2" id="calibration_lists_name2" value="{{$hd->calibration_lists_name2}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="calibration_lists_serialno" class="col-form-label">Serial No.</label>
                            <input class="form-control" name="calibration_lists_serialno" id="calibration_lists_serialno" value="{{$hd->calibration_lists_serialno}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="ap_vendor_lists_id" class="col-form-label">ผู้จำหน่าย</label>
                            <select class="form-select" name="ap_vendor_lists_id" id="ap_vendor_lists_id">
                                <option value="">กรุณาเลือก</option>
                                @foreach ($vendors as $item)
                                    <option value="{{$item->ap_vendor_lists_id}}"
                                        {{ $item->ap_vendor_lists_id == $hd->ap_vendor_lists_id ? 'selected' : '' }}>
                                        {{$item->ap_vendor_lists_name1}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="calibration_lists_location" class="col-form-label">สถานที่จัดเก็บ</label>
                            <input class="form-control" name="calibration_lists_location" id="calibration_lists_location" value="{{$hd->calibration_lists_location}}">
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="calibration_lists_reamrk" class="col-form-label">หมายเหตุ</label>
                            <input class="form-control" name="calibration_lists_reamrk" id="calibration_lists_reamrk" value="{{$hd->calibration_lists_reamrk}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_date" class="col-form-label">วันที่ซื้อ</label>
                            <input type="date" class="form-control" name="calibration_lists_date" id="calibration_lists_date" value="{{$hd->calibration_lists_date}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_expirationdate" class="col-form-label">วันที่หมดประกัน</label>
                            <input type="date" class="form-control" name="calibration_lists_expirationdate" id="calibration_lists_expirationdate" value="{{$hd->calibration_lists_expirationdate}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_calibrationdate" class="col-form-label">วันที่ทวนสอบล่าสุด</label>
                            <input type="date" class="form-control" name="calibration_lists_calibrationdate" id="calibration_lists_calibrationdate" value="{{$hd->calibration_lists_calibrationdate}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_nextdate" class="col-form-label">วันที่ทวนสอบครั้งต่อไป</label>
                            <input type="date" class="form-control" name="calibration_lists_nextdate" id="calibration_lists_nextdate"  value="{{$hd->calibration_lists_nextdate}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_day" class="col-form-label">ระยะเวลาการทวนสอบ</label>
                            <input type="number" class="form-control" name="calibration_lists_day" id="calibration_lists_day"  value="{{$hd->calibration_lists_day}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_person" class="col-form-label">ผู้รับผิดชอบ</label>
                            <input type="text" class="form-control" name="calibration_lists_person" id="calibration_lists_person" value="{{$hd->calibration_lists_person}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_verify" class="col-form-label">สอบเทียบ/ทวนสอบ</label>
                            <select class="form-select" name="calibration_lists_verify" id="calibration_lists_verify">
                                <option value="{{$hd->calibration_lists_verify}}">{{$hd->calibration_lists_verify}}</option>
                                <option value="Cal">Cal</option>
                                <option value="No">No</option>
                                <option value="Ver">Ver</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_status" class="col-form-label">สถานะ</label>
                            <select class="form-select" name="calibration_lists_status" id="calibration_lists_status">
                                <option value="{{$hd->calibration_lists_status}}">{{$hd->calibration_lists_status}}</option>
                                <option value="ใช้งาน">ใช้งาน</option>
                                <option value="ไม่ใช้งาน">ไม่ใช้งาน</option>
                                <option value="รอซ่อม">รอซ่อม</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_areaofuse" class="col-form-label">ย่านการใช้งาน</label>
                            <input type="text" class="form-control" name="calibration_lists_areaofuse" id="calibration_lists_areaofuse" value="{{number_format($hd->calibration_lists_areaofuse,6)}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_areaofuse_add" class="col-form-label">ย่านการใช้งาน (ค่า +)</label>
                            <input type="text" class="form-control" name="calibration_lists_areaofuse_add" id="calibration_lists_areaofuse_add" value="{{number_format($hd->calibration_lists_areaofuse_add,6)}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_areaofuse_del" class="col-form-label">ย่านการใช้งาน (ค่า -)</label>
                            <input type="text" class="form-control" name="calibration_lists_areaofuse_del" id="calibration_lists_areaofuse_del" value="{{number_format($hd->calibration_lists_areaofuse_del,6)}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_precision" class="col-form-label">ค่าความเที่ยงตรง</label>
                            <input type="text" class="form-control" name="calibration_lists_precision" id="calibration_lists_precision" value="{{number_format($hd->calibration_lists_precision,6)}}">
                        </div>
                    </div>
                   
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_measuringrange" class="col-form-label">ย่านการวัด</label>
                            <input type="text" class="form-control" name="calibration_lists_measuringrange" id="calibration_lists_measuringrange" value="{{number_format($hd->calibration_lists_measuringrange,6)}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_measuringrange_add" class="col-form-label">ย่านการวัด (ค่า +)</label>
                            <input type="text" class="form-control" name="calibration_lists_measuringrange_add" id="calibration_lists_measuringrange_add" value="{{number_format($hd->calibration_lists_measuringrange_add,6)}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_measuringrange_del" class="col-form-label">ย่านการวัด (ค่า -)</label>
                            <input type="text" class="form-control" name="calibration_lists_measuringrange_del" id="calibration_lists_measuringrange_del" value="{{number_format($hd->calibration_lists_measuringrange_del,6)}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_resolution" class="col-form-label">ความละเอียด</label>
                            <input type="text" class="form-control" name="calibration_lists_resolution" id="calibration_lists_resolution" value="{{number_format($hd->calibration_lists_resolution,6)}}">
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_temperature" class="col-form-label">อุณหภูมิ</label>
                            <input type="text" class="form-control" name="calibration_lists_temperature" id="calibration_lists_temperature" value="{{number_format($hd->calibration_lists_temperature,6)}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_temperature_add" class="col-form-label">อุณหภูมิ (ค่า +)</label>
                            <input type="text" class="form-control" name="calibration_lists_temperature_add" id="calibration_lists_temperature_add" value="{{number_format($hd->calibration_lists_temperature_add,6)}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_temperature_del" class="col-form-label">อุณหภูมิ (ค่า -)</label>
                            <input type="text" class="form-control" name="calibration_lists_temperature_del" id="calibration_lists_temperature_del" value="{{number_format($hd->calibration_lists_temperature_del,6)}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_uncertainty" class="col-form-label">ความไม่แน่นอน</label>
                            <input type="text" class="form-control" name="calibration_lists_uncertainty" id="calibration_lists_uncertainty" value="{{number_format($hd->calibration_lists_uncertainty,6)}}">
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_humidity" class="col-form-label">ความชื้น</label>
                            <input type="text" class="form-control" name="calibration_lists_humidity" id="calibration_lists_humidity" value="{{number_format($hd->calibration_lists_humidity,6)}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_humidity_add" class="col-form-label">ความชื้น (ค่า +)</label>
                            <input type="text" class="form-control" name="calibration_lists_humidity_add" id="calibration_lists_humidity_add" value="{{number_format($hd->calibration_lists_humidity_add,6)}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_humidity_del" class="col-form-label">ความชื้น (ค่า -)</label>
                            <input type="text" class="form-control" name="calibration_lists_humidity_del" id="calibration_lists_humidity_del" value="{{number_format($hd->calibration_lists_humidity_del,6)}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_markingorshape" class="col-form-label">เครื่องหมายหรือรูปร่าง</label>
                            <input type="text" class="form-control" name="calibration_lists_markingorshape" id="calibration_lists_markingorshape" value="{{$hd->calibration_lists_markingorshape}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_file1" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile01"  name="calibration_lists_file1" onchange="prevFile(this,'calibration_lists_file1')">
                            @if ($hd->calibration_lists_file1)
                                <a href="{{asset($hd->calibration_lists_file1)}}" target="_blank">
                                    <i class="fas fa-file"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_file2" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile02"  name="calibration_lists_file2" onchange="prevFile(this,'calibration_lists_file2')">
                            @if ($hd->calibration_lists_file2)
                                <a href="{{asset($hd->calibration_lists_file2)}}" target="_blank">
                                    <i class="fas fa-file"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_file3" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile03"  name="calibration_lists_file3" onchange="prevFile(this,'calibration_lists_file3')">
                            @if ($hd->calibration_lists_file3)
                                <a href="{{asset($hd->calibration_lists_file3)}}" target="_blank">
                                    <i class="fas fa-file"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_file4" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile03"  name="calibration_lists_file4" onchange="prevFile(this,'calibration_lists_file4')">
                            @if ($hd->calibration_lists_file4)
                                <a href="{{asset($hd->calibration_lists_file4)}}" target="_blank">
                                    <i class="fas fa-file"></i>
                                </a>
                            @endif
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