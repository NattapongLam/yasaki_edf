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
            <div class="col-12 col-md-6"><h3 class="card-title">คำร้องขอใช้บริการ (ISO/IEC 17025)</h3></div>
        </div>
        <div class="row mt-3">
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_requestorder_hds_date" class="col-form-label">วันที่</label>
                    <input type="date" class="form-control" 
                            name="ar_requestorder_hds_date" 
                            id="ar_requestorder_hds_date"
                            value="{{ $hd->ar_requestorder_hds_date }}" 
                            disabled>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_requestorder_hds_docuno" class="col-form-label">เลขที่</label>
                    <input type="text" class="form-control" 
                            name="ar_requestorder_hds_docuno" 
                            id="ar_requestorder_hds_docuno" 
                            value="{{$hd->ar_requestorder_hds_docuno}}"
                            readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="ar_requestorder_hds_customer" class="col-form-label">ชื่อบริษัท</label>
                     <input type="text" class="form-control" 
                            name="ar_requestorder_hds_customer" 
                            id="ar_requestorder_hds_customer"
                            value="{{$hd->ar_requestorder_hds_customer}}"
                            readonly>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_requestorder_hds_trademark" class="col-form-label">เครื่องหมายการค้า</label>
                    <input type="text" class="form-control" 
                            name="ar_requestorder_hds_trademark" 
                            id="ar_requestorder_hds_trademark"
                            value="{{$hd->ar_requestorder_hds_trademark}}"
                            readonly>
                </div>
            </div>
            <div class="col-9">
                <div class="form-group">
                    <label for="ar_requestorder_hd_remark" class="col-form-label">หมายเหตุ</label>
                    <input type="text" class="form-control" 
                            name="ar_requestorder_hd_remark" 
                            id="ar_requestorder_hd_remark"
                            value="{{$hd->ar_requestorder_hd_remark}}"
                            readonly>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <table class="table table-bordered dt-responsive nowrap w-100 text-center">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 20%">สินค้า</th>
                        <th style="width: 20%">มาตรฐานที่อ้างอิง (JIS D 4411)</th>
                        <th style="width: 15%">มิติชิ้นงาน ก×ย×ส (มิลลิเมตร)</th>
                        <th style="width: 15%">น้ำหนัก (กรัม)</th>
                        <th style="width: 8%">จำนวน</th>
                        <th style="width: 27%">รายละเอียดเพิ่มเติม</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dt as $item)
                        <tr>
                            <td>
                                <span class="row-number">{{ $loop->iteration }}</span>
                                <input type="hidden"
                                    class="row-number-hidden"
                                    name="ar_requestorder_dts_listno[]"
                                    value="{{ $loop->iteration }}">
                                    <input type="hidden" name="ar_requestorder_dts_id[]" value="{{$item->ar_requestorder_dts_id}}">
                            </td>
                            <td>
                                <input class="form-control" name="ar_requestorder_dts_product[]" value="{{$item->ar_requestorder_dts_product}}" readonly>
                            </td>
                            <td>
                                <select class="form-control" name="ar_requestorder_dts_jis_class[]" disabled>
                                    @if ($item->ar_requestorder_dts_jis_class == "CLASS_3")
                                        <option value="CLASS_3">JIS D 4411 Class 3 (Heavy Loads)</option>
                                        <option value="CLASS_4">JIS D 4411 Class 4 (Disc Brakes)</option>
                                    @else
                                        <option value="CLASS_4">JIS D 4411 Class 4 (Disc Brakes)</option>
                                        <option value="CLASS_3">JIS D 4411 Class 3 (Heavy Loads)</option>
                                    @endif
                                </select>
                            </td>
                            <td>
                                <input class="form-control" name="ar_requestorder_dts_dimensions[]" value="{{$item->ar_requestorder_dts_dimensions}}" readonly>
                            </td>
                            <td>
                                <input class="form-control" name="ar_requestorder_dts_weight[]" value="{{$item->ar_requestorder_dts_weight}}" readonly>
                            </td>
                            <td>
                                <input class="form-control" name="ar_requestorder_dts_qty[]" type="number" value="{{$item->ar_requestorder_dts_qty}}" readonly>
                            </td>
                            <td>
                                <textarea class="form-control" name="ar_requestorder_hds_remark[]" disabled>{{$item->ar_requestorder_hds_remark}}</textarea>
                            </td>
                        </tr>
                    @endforeach
                </tbody>       
            </table>          
        </div>
        <div class="row mt-3">
            <div class="col-3">
                <label for="approved_at" class="col-form-label">ผู้อนุมัติ</label>
                <input class="form-control" name="approved_at" value="{{$hd->approved_at}}" readonly>
            </div>
            <div class="col-9">
                <label for="approved_remark" class="col-form-label">หมายเหคุ</label>
                <input class="form-control" name="approved_remark" value="{{$hd->approved_remark}}" readonly>
            </div>
        </div>      
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">รับชิ้นงานทดสอบ</h3></div>
        </div>
        <form method="POST" class="form-horizontal" action="{{ route('receive-test.store') }}" enctype="multipart/form-data">
        @csrf  
        <input type="hidden" name="ar_requestorder_hds_id" value="{{$hd->ar_requestorder_hds_id}}">    
        <div class="row mt-3">
             <div class="col-3">
                <div class="form-group">
                    <label for="receive_test_lists_date" class="col-form-label">วันที่รับ</label>
                    <input type="date" class="form-control" 
                            name="receive_test_lists_date" 
                            id="receive_test_lists_date"
                            value=""
                            required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="receive_test_lists_file1" class="col-form-label">แนบรูปชิ้นงาน</label>
                    <input type="file" class="form-control" id="inputGroupFile01"  name="receive_test_lists_file1" onchange="prevFile(this,'receive_test_lists_file1')">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="receive_test_lists_file2" class="col-form-label">แนบรูปชิ้นงาน</label>
                    <input type="file" class="form-control" id="inputGroupFile02"  name="receive_test_lists_file2" onchange="prevFile(this,'receive_test_lists_file2')">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="receive_test_lists_file3" class="col-form-label">แนบไฟล์</label>
                    <input type="file" class="form-control" id="inputGroupFile03"  name="receive_test_lists_file3" onchange="prevFile(this,'receive_test_lists_file3')">
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-3">
                <div class="form-group">
                    <label for="receive_test_lists_dimensions" class="col-form-label">มิติชิ้นงานเฉลี่ย ก×ย×ส (มิลลิเมตร)</label>
                    <input type="text" class="form-control" 
                            name="receive_test_lists_dimensions" 
                            id="receive_test_lists_dimensions"
                            value=""
                            readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="dimensions_id" class="col-form-label">เครื่องวัดชิ้นงานที่1</label>
                    <select class="form-control" name="dimensions_id" required>
                        <option value="">กรุณาเลือกเครื่องวัด</option>
                        @foreach ($cal as $item)
                            <option value="{{$item->calibration_lists_id}}">{{$item->calibration_lists_name1}} ({{$item->calibration_lists_code}})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="dimensions_id1" class="col-form-label">เครื่องวัดชิ้นงานที่2</label>
                    <select class="form-control" name="dimensions_id1" required>
                        <option value="">กรุณาเลือกเครื่องวัด</option>
                        @foreach ($cal as $item)
                            <option value="{{$item->calibration_lists_id}}">{{$item->calibration_lists_name1}} ({{$item->calibration_lists_code}})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="chemistry_hd_id" class="col-form-label">สูตรเคมี</label>
                    <select class="form-control" name="chemistry_hd_id" required>
                        <option value="0">กรุณาเลือกสูตร</option>
                        @foreach ($bom as $item)
                            <option value="{{$item->chemistry_hd_id}}">{{$item->ms_formule_name}} ({{$item->chemistry_hd_name}})</option>
                        @endforeach
                    </select>
                </div>
            </div>                      
        </div>
        <div class="row mt-3">
            <div class="col-3">
                <div class="form-group">
                    <label for="receive_test_lists_weight" class="col-form-label">น้ำหนักชิ้นงานเฉลี่ย(กรัม)</label>
                    <input type="text" class="form-control" 
                            name="receive_test_lists_weight" 
                            id="receive_test_lists_weight"
                            value=""
                            readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="weight_id" class="col-form-label">เครื่องชั่งชิ้นงาน</label>
                    <select class="form-control" name="weight_id" required>
                        <option value="">กรุณาเลือกเครื่องชั่ง</option>
                        @foreach ($cal as $item)
                            <option value="{{$item->calibration_lists_id}}">{{$item->calibration_lists_name1}} ({{$item->calibration_lists_code}})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="" class="col-form-label">สถาพทั่วไป/ความสมบูรณ์ของชิ้นงาน</label>
                    <input class="form-control" name="receive_test_lists_note">
                </div>
            </div>
        </div>
        <br>
        <div class="row">
    <table class="table table-bordered text-center align-middle">
        <thead>
            <tr>
                <th rowspan="2" class="align-middle"></th>
                <th colspan="2">ความกว้าง(มิลลิเมตร)</th>
                <th colspan="2">ความยาว(มิลลิเมตร)</th>
                <th colspan="2">ความสูง(มิลลิเมตร)</th>
                <th colspan="2">น้ำหนัก(กรัม)</th>
            </tr>
            <tr>
                <th>L</th>
                <th>R</th>
                <th>L</th>
                <th>R</th>
                <th>L</th>
                <th>R</th>
                <th>L</th>
                <th>R</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>N1</strong></td>
                <td><input type="text" class="form-control" name="receive_n1_width1" aria-label="ความกว้าง 1 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="receive_n1_width2" aria-label="ความกว้าง 2 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="receive_n1_length1" aria-label="ความยาว 1 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="receive_n1_length2" aria-label="ความยาว 2 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="receive_n1_height1" aria-label="ความสูง 1 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="receive_n1_height2" aria-label="ความสูง 2 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="receive_n1_weight1" aria-label="น้ำหนัก 1 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="receive_n1_weight2" aria-label="น้ำหนัก 2 สำหรับ N1"></td>
            </tr>
            <tr>
                <td><strong>N2</strong></td>
                <td><input type="text" class="form-control" name="receive_n2_width1" aria-label="ความกว้าง 1 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="receive_n2_width2" aria-label="ความกว้าง 2 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="receive_n2_length1" aria-label="ความยาว 1 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="receive_n2_length2" aria-label="ความยาว 2 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="receive_n2_height1" aria-label="ความสูง 1 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="receive_n2_height2" aria-label="ความสูง 2 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="receive_n2_weight1" aria-label="น้ำหนัก 1 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="receive_n2_weight2" aria-label="น้ำหนัก 2 สำหรับ N2"></td>
            </tr>
            <tr>
                <td><strong>N3</strong></td>
                <td><input type="text" class="form-control" name="receive_n3_width1" aria-label="ความกว้าง 1 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="receive_n3_width2" aria-label="ความกว้าง 2 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="receive_n3_length1" aria-label="ความยาว 1 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="receive_n3_length2" aria-label="ความยาว 2 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="receive_n3_height1" aria-label="ความสูง 1 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="receive_n3_height2" aria-label="ความสูง 2 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="receive_n3_weight1" aria-label="น้ำหนัก 1 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="receive_n3_weight2" aria-label="น้ำหนัก 2 สำหรับ N3"></td>
            </tr>
        </tbody>
    </table>
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

// ฟังก์ชันคำนวณค่าเฉลี่ยน้ำหนัก
function calculateAverageWeight() {
    const weightFields = [
        'receive_n1_weight1', 'receive_n1_weight2',
        'receive_n2_weight1', 'receive_n2_weight2',
        'receive_n3_weight1', 'receive_n3_weight2'
    ];

    let sum = 0;
    let count = 0;

    weightFields.forEach(function(fieldName) {
        let val = parseFloat($(`input[name="${fieldName}"]`).val());
        if (!isNaN(val)) {
            sum += val;
            count++;
        }
    });

    if (count > 0) {
        let avg = sum / count;
        $('#receive_test_lists_weight').val(avg.toFixed(2));
    } else {
        $('#receive_test_lists_weight').val('');
    }
}

// ฟังก์ชันคำนวณค่าเฉลี่ย มิติชิ้นงาน (กว้าง x ยาว x สูง)
function calculateAverageDimensions() {
    const widthFields = [
        'receive_n1_width1', 'receive_n1_width2',
        'receive_n2_width1', 'receive_n2_width2',
        'receive_n3_width1', 'receive_n3_width2'
    ];
    const lengthFields = [
        'receive_n1_length1', 'receive_n1_length2',
        'receive_n2_length1', 'receive_n2_length2',
        'receive_n3_length1', 'receive_n3_length2'
    ];
    const heightFields = [
        'receive_n1_height1', 'receive_n1_height2',
        'receive_n2_height1', 'receive_n2_height2',
        'receive_n3_height1', 'receive_n3_height2'
    ];

    // คำนวณค่าเฉลี่ยความกว้าง
    let wSum = 0, wCount = 0;
    widthFields.forEach(function(fieldName) {
        let val = parseFloat($(`input[name="${fieldName}"]`).val());
        if (!isNaN(val)) { wSum += val; wCount++; }
    });
    let avgWidth = wCount > 0 ? (wSum / wCount).toFixed(2) : '';

    // คำนวณค่าเฉลี่ยความยาว
    let lSum = 0, lCount = 0;
    lengthFields.forEach(function(fieldName) {
        let val = parseFloat($(`input[name="${fieldName}"]`).val());
        if (!isNaN(val)) { lSum += val; lCount++; }
    });
    let avgLength = lCount > 0 ? (lSum / lCount).toFixed(2) : '';

    // คำนวณค่าเฉลี่ยความสูง
    let hSum = 0, hCount = 0;
    heightFields.forEach(function(fieldName) {
        let val = parseFloat($(`input[name="${fieldName}"]`).val());
        if (!isNaN(val)) { hSum += val; hCount++; }
    });
    let avgHeight = hCount > 0 ? (hSum / hCount).toFixed(2) : '';

    // นำค่าเฉลี่ยที่ได้มาต่อกันในรูปแบบ ก×ย×ส (ถ้ามีข้อมูลครบ หรือมีบางส่วน ก็จะแสดงเท่าที่มี)
    let dimensionsArr = [];
    if (avgWidth) dimensionsArr.push(avgWidth);
    if (avgLength) dimensionsArr.push(avgLength);
    if (avgHeight) dimensionsArr.push(avgHeight);

    if (dimensionsArr.length === 3) {
        $('#receive_test_lists_dimensions').val(avgWidth + ' × ' + avgLength + ' × ' + avgHeight);
    } else if (dimensionsArr.length > 0) {
        // กรณีพิมพ์ไม่ครบทุกมิติ จะแสดงเฉพาะตัวที่มีค่า หรือเว้นไว้ก่อนก็ได้
        $('#receive_test_lists_dimensions').val(dimensionsArr.join(' × '));
    } else {
        $('#receive_test_lists_dimensions').val('');
    }
}

// ผูก Event ให้ทำงานอัตโนมัติเมื่อมีการกรอกข้อมูลในช่องมิติและน้ำหนัก
$(document).ready(function() {
    const allFields = [
        'receive_n1_width1', 'receive_n1_width2', 'receive_n1_length1', 'receive_n1_length2', 'receive_n1_height1', 'receive_n1_height2', 'receive_n1_weight1', 'receive_n1_weight2',
        'receive_n2_width1', 'receive_n2_width2', 'receive_n2_length1', 'receive_n2_length2', 'receive_n2_height1', 'receive_n2_height2', 'receive_n2_weight1', 'receive_n2_weight2',
        'receive_n3_width1', 'receive_n3_width2', 'receive_n3_length1', 'receive_n3_length2', 'receive_n3_height1', 'receive_n3_height2', 'receive_n3_weight1', 'receive_n3_weight2'
    ];

    allFields.forEach(function(fieldName) {
        $(`input[name="${fieldName}"]`).on('input', function() {
            calculateAverageWeight();
            calculateAverageDimensions();
        });
    });
});
</script>
@endpush