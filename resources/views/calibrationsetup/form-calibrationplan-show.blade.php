@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">🔍 รายละเอียดแผนสอบเทียบ</h4>

    <div class="card">
        <div class="card-body">
            <a href="{{ url('/calibrationplans') }}" class="btn btn-secondary">
                ⬅ กลับ
            </a>
            <hr>
            <table class="table table-bordered">
                <tr>
                    <th width="30%">รหัสเครื่องมือ</th>
                    <td colspan="3">{{ $data->calibration_lists_code }}</td>
                </tr>
                <tr>
                    <th>ชื่อเครื่องมือ</th>
                    <td colspan="3">{{ $data->calibration_lists_name }}</td>
                </tr>
                <tr>
                    <th>สถานะ</th>
                    <td>
                        @if($data->calibration_plans_action == 1)
                            <span class="badge bg-success">ดำเนินการเรียบร้อย</span>
                        @else
                            <span class="badge bg-danger">รอดำเนินการ</span>
                        @endif
                    </td>
                    <th>วันครบกำหนดสอบเทียบ</th>
                    <td>{{ \Carbon\Carbon::parse($data->calibration_plans_date)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>ค่าความเที่ยงตรง</th>
                    <td> {{number_format($data->calibration_lists_precision,6)}}</td>
                    <th>ความไม่แน่นอน</th>
                    <td> {{number_format($data->calibration_lists_uncertainty,6)}}</td>
                </tr>
                <tr>
                    <th>ความละเอียด</th>
                    <td> {{number_format($data->calibration_lists_resolution,6)}}</td>
                    <th>เครื่องหมายหรือรูปร่าง</th>
                    <td> {{$data->calibration_lists_markingorshape}}</td>
                </tr>
                <tr>
                    <th>ค่ามาตรฐาน</th>
                    <td>
                        {{number_format($data->calibration_lists_areaofuse,6)}}                        
                    </td>
                    <td>
                        ค่า + {{number_format($data->calibration_lists_areaofuse_add,6)}}
                    </td>
                    <td>
                        ค่า - {{number_format($data->calibration_lists_areaofuse_del,6)}}
                    </td>
                </tr>
                <tr>
                    <th>ย่านการใช้งาน</th>
                    <td>
                        {{number_format($data->calibration_lists_measuringrange,6)}} 
                    </td>
                    <td>
                        ค่า + {{number_format($data->calibration_lists_measuringrange_add,6)}}
                    </td>
                    <td>
                        ค่า - {{number_format($data->calibration_lists_measuringrange_del,6)}}
                    </td>
                </tr>
                <tr>
                    <th>อุณหภูมิ</th>
                    <td>
                        {{number_format($data->calibration_lists_temperature,6)}} 
                    </td>
                    <td>
                        ค่า + {{number_format($data->calibration_lists_temperature_add,6)}}
                    </td>
                    <td>
                        ค่า - {{number_format($data->calibration_lists_temperature_del,6)}}
                    </td>
                </tr>
                <tr>
                    <th>ความชื้น</th>
                    <td>
                        {{number_format($data->calibration_lists_humidity,6)}}         
                    </td>
                    <td>
                        ค่า + {{number_format($data->calibration_lists_humidity_add,6)}}
                    </td>
                    <td>
                        ค่า - {{number_format($data->calibration_lists_humidity_del,6)}}
                    </td>
                </tr>              
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
                <form method="POST" class="form-horizontal" action="{{ route('calibrationplans.store') }}" enctype="multipart/form-data">
                @csrf   
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_plan_subs_date" class="col-form-label">วันที่</label>
                            <input type="date" class="form-control" name="calibration_plan_subs_date" id="calibration_plan_subs_date" required>
                            <input value="{{$data->calibration_plans_id}}" name="calibration_plans_id" type="hidden">
                            <input value="{{$data->calibration_lists_id}}" name="calibration_lists_id" type="hidden">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="form-group">
                            <label for="calibration_plan_subs_remark" class="col-form-label">หมายเหตุ</label>
                            <input type="text" class="form-control" name="calibration_plan_subs_remark" id="calibration_plan_subs_remark">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_plan_subs_areaofuse" class="col-form-label">ค่ามาตรฐาน</label>
                            <input type="text" class="form-control" name="calibration_plan_subs_areaofuse" id="calibration_plan_subs_areaofuse" value="{{old('calibration_plan_subs_areaofuse',0)}}" required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_plan_subs_areaofuse_add" class="col-form-label">ค่ามาตรฐาน (ค่า +)</label>
                            <input type="text" class="form-control" name="calibration_plan_subs_areaofuse_add" id="calibration_plan_subs_areaofuse_add" value="{{old('calibration_plan_subs_areaofuse_add',0)}}" required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_plan_subs_areaofuse_del" class="col-form-label">ค่ามาตรฐาน (ค่า -)</label>
                            <input type="text" class="form-control" name="calibration_plan_subs_areaofuse_del" id="calibration_plan_subs_areaofuse_del" value="{{old('calibration_plan_subs_areaofuse_del',0)}}" required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_plan_subs_precision" class="col-form-label">ค่าความเที่ยงตรง</label>
                            <input type="text" class="form-control" name="calibration_plan_subs_precision" id="calibration_plan_subs_precision" value="{{old('calibration_plan_subs_precision',0)}}" required>
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_plan_subs_measuringrange" class="col-form-label">ย่านการใช้งาน</label>
                            <input type="text" class="form-control" name="calibration_plan_subs_measuringrange" id="calibration_plan_subs_measuringrange" value="{{old('calibration_plan_subs_measuringrange',0)}}" required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_plan_subs_measuringrange_add" class="col-form-label">ย่านการใช้งาน (ค่า +)</label>
                            <input type="text" class="form-control" name="calibration_plan_subs_measuringrange_add" id="calibration_plan_subs_measuringrange_add" value="{{old('calibration_plan_subs_measuringrange_add',0)}}" required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_plan_subs_measuringrange_del" class="col-form-label">ย่านการใช้งาน (ค่า -)</label>
                            <input type="text" class="form-control" name="calibration_plan_subs_measuringrange_del" id="calibration_plan_subs_measuringrange_del" value="{{old('calibration_plan_subs_measuringrange_del',0)}}" required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_plan_subs_resolution" class="col-form-label">ความละเอียด</label>
                            <input type="text" class="form-control" name="calibration_plan_subs_resolution" id="calibration_plan_subs_resolution" value="{{old('calibration_plan_subs_resolution',0)}}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_plan_subs_temperature" class="col-form-label">อุณหภูมิ</label>
                            <input type="text" class="form-control" name="calibration_plan_subs_temperature" id="calibration_plan_subs_temperature" value="{{old('calibration_plan_subs_temperature',0)}}" required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_plan_subs_temperature_add" class="col-form-label">อุณหภูมิ (ค่า +)</label>
                            <input type="text" class="form-control" name="calibration_plan_subs_temperature_add" id="calibration_plan_subs_temperature_add" value="{{old('calibration_plan_subs_temperature_add',0)}}" required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_plan_subs_temperature_del" class="col-form-label">อุณหภูมิ (ค่า -)</label>
                            <input type="text" class="form-control" name="calibration_plan_subs_temperature_del" id="calibration_plan_subs_temperature_del" value="{{old('calibration_plan_subs_temperature_del',0)}}" required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_plan_subs_uncertainty" class="col-form-label">ความไม่แน่นอน</label>
                            <input type="text" class="form-control" name="calibration_plan_subs_uncertainty" id="calibration_plan_subs_uncertainty" value="{{old('calibration_plan_subs_uncertainty',0)}}" required>
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_plan_subs_humidity" class="col-form-label">ความชื้น</label>
                            <input type="text" class="form-control" name="calibration_plan_subs_humidity" id="calibration_plan_subs_humidity" value="{{old('calibration_plan_subs_humidity',0)}}" required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_plan_subs_humidity_add" class="col-form-label">ความชื้น (ค่า +)</label>
                            <input type="text" class="form-control" name="calibration_plan_subs_humidity_add" id="calibration_plan_subs_humidity_add" value="{{old('calibration_plan_subs_humidity_add',0)}}" required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_plan_subs_humidity_del" class="col-form-label">ความชื้น (ค่า -)</label>
                            <input type="text" class="form-control" name="calibration_plan_subs_humidity_del" id="calibration_plan_subs_humidity_del" value="{{old('calibration_plan_subs_humidity_del',0)}}" required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="calibration_plan_subs_markingorshape" class="col-form-label">เครื่องหมายหรือรูปร่าง</label>
                            <input type="text" class="form-control" name="calibration_plan_subs_markingorshape" id="calibration_plan_subs_markingorshape">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="calibration_plan_subs_file1" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile01"  name="calibration_plan_subs_file1" onchange="prevFile(this,'calibration_plan_subs_file1')">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="calibration_plan_subs_file2" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile02"  name="calibration_plan_subs_file2" onchange="prevFile(this,'calibration_plan_subs_file2')">
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
