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
                <form method="POST" class="form-horizontal" action="{{ route('calibrationlists.store') }}" enctype="multipart/form-data">
                @csrf   
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_categories_id" class="col-form-label">หมวดเครื่องมือวัด</label>
                            <select class="form-select" name="calibration_categories_id" id="calibration_categories_id">
                                <option value="">กรุณาเลือก</option>
                                @foreach ($categorys as $item)
                                    <option value="{{$item->calibration_categories_id}}" data-code="{{ $item->calibration_categories_code }}">
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
                                    <option value="{{$item->calibration_groups_id}}" data-code="{{ $item->calibration_groups_code }}">
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
                                    <option value="{{$item->calibration_types_id}}" data-code="{{ $item->calibration_types_code }}">
                                        {{$item->calibration_types_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_code" class="col-form-label">รหัสเครื่องมือวัด</label>
                            <input class="form-control" name="calibration_lists_code" id="calibration_lists_code" readonly>
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="calibration_lists_name1" class="col-form-label">ชื่อภาษาไทย</label>
                            <input class="form-control" name="calibration_lists_name1" id="calibration_lists_name1" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="calibration_lists_name2" class="col-form-label">ชื่อภาษาอังกฤษ</label>
                            <input class="form-control" name="calibration_lists_name2" id="calibration_lists_name2">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="calibration_lists_serialno" class="col-form-label">Serial No.</label>
                            <input class="form-control" name="calibration_lists_serialno" id="calibration_lists_serialno">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="ap_vendor_lists_id" class="col-form-label">ผู้จำหน่าย</label>
                            <select class="form-select" name="ap_vendor_lists_id" id="ap_vendor_lists_id">
                                <option value="">กรุณาเลือก</option>
                                @foreach ($vendors as $item)
                                    <option value="{{$item->ap_vendor_lists_id}}">{{$item->ap_vendor_lists_name1}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="calibration_lists_location" class="col-form-label">สถานที่จัดเก็บ</label>
                            <input class="form-control" name="calibration_lists_location" id="calibration_lists_location">
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="calibration_lists_reamrk" class="col-form-label">หมายเหตุ</label>
                            <input class="form-control" name="calibration_lists_reamrk" id="calibration_lists_reamrk">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_date" class="col-form-label">วันที่ซื้อ</label>
                            <input type="date" class="form-control" name="calibration_lists_date" id="calibration_lists_date">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_expirationdate" class="col-form-label">วันที่หมดประกัน</label>
                            <input type="date" class="form-control" name="calibration_lists_expirationdate" id="calibration_lists_expirationdate">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_calibrationdate" class="col-form-label">วันที่ทวนสอบล่าสุด</label>
                            <input type="date" class="form-control" name="calibration_lists_calibrationdate" id="calibration_lists_calibrationdate">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_nextdate" class="col-form-label">วันที่ทวนสอบครั้งต่อไป</label>
                            <input type="date" class="form-control" name="calibration_lists_nextdate" id="calibration_lists_nextdate">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_day" class="col-form-label">ระยะเวลาการทวนสอบ</label>
                            <input type="number" class="form-control" name="calibration_lists_day" id="calibration_lists_day">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_person" class="col-form-label">ผู้รับผิดชอบ</label>
                            <input type="text" class="form-control" name="calibration_lists_person" id="calibration_lists_person">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_verify" class="col-form-label">สอบเทียบ/ทวนสอบ</label>
                            <select class="form-select" name="calibration_lists_verify" id="calibration_lists_verify">
                                <option value="">กรุณาเลือก</option>
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
                                <option value="">กรุณาเลือก</option>
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
                            <input type="text" class="form-control" name="calibration_lists_areaofuse" id="calibration_lists_areaofuse" value="{{old('calibration_lists_areaofuse',0)}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_measuringrange" class="col-form-label">ย่านการวัด</label>
                            <input type="text" class="form-control" name="calibration_lists_measuringrange" id="calibration_lists_measuringrange" value="{{old('calibration_lists_measuringrange',0)}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_precision" class="col-form-label">ค่าความเที่ยงตรง</label>
                            <input type="text" class="form-control" name="calibration_lists_precision" id="calibration_lists_precision" value="{{old('calibration_lists_precision',0)}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_resolution" class="col-form-label">ความละเอียด</label>
                            <input type="text" class="form-control" name="calibration_lists_resolution" id="calibration_lists_resolution" value="{{old('calibration_lists_resolution',0)}}">
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_file1" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile01"  name="calibration_lists_file1" onchange="prevFile(this,'calibration_lists_file1')">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_file2" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile02"  name="calibration_lists_file2" onchange="prevFile(this,'calibration_lists_file2')">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_file3" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile03"  name="calibration_lists_file3" onchange="prevFile(this,'calibration_lists_file3')">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_lists_file4" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile03"  name="calibration_lists_file4" onchange="prevFile(this,'calibration_lists_file4')">
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
function generateCode() {
    let cat = String($('#calibration_categories_id option:selected').attr('data-code') || '');
    let grp = String($('#calibration_groups_id option:selected').attr('data-code') || '');
    let typ = String($('#calibration_types_id option:selected').attr('data-code') || '');

    console.log("CAT:", cat, "GRP:", grp, "TYP:", typ); // เช็คค่าตรงนี้

    if(cat && grp && typ){
        $.ajax({
            url: "{{ route('calibration.getLastRunning') }}",
            type: "GET",
            data: { cat, grp, typ },
            success: function(res){
                $('#calibration_lists_code').val(cat + grp + typ + "-" + res.running);
            }
        });
    }
}

$('#calibration_categories_id').change(generateCode);
$('#calibration_groups_id').change(generateCode);
$('#calibration_types_id').change(generateCode);
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