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
           <div class="col-12 col-md-6"><h3 class="card-title">รายละเอียดการทดสอบ ( Coefficient of Friction Test Form )</h3></div>
            <div class="col-12 col-md-6"><h3 style="float: right"class="card-title">YSK5-FM-LAB-08 : Rev.00 : 01/08/2569</h3></div>
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
            <div class="form-group">
                    <label for="ar_requestorder_hds_address" class="col-form-label">ที่อยู่</label>
                     <input type="text" class="form-control" 
                            name="ar_requestorder_hds_address" 
                            id="ar_requestorder_hds_address"
                            value="{{$cust->ar_customer_lists_address1}} {{$subd->other_sub_districts_name1}} {{$dist->other_districts_name1}} {{$prov->other_provinces_name1}} {{$subd->other_sub_districts_zipcode}}"
                            readonly>
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
        <div class="row mt-2">
             <div class="col-2">
                <div class="form-group">
                    <label for="receive_test_lists_date" class="col-form-label">วันที่รับ</label>
                    <input type="date" class="form-control" 
                            name="receive_test_lists_date" 
                            id="receive_test_lists_date"
                            value="{{$pd->receive_test_lists_date}}"
                            readonly>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="receive_test_lists_dimensions" class="col-form-label">มิติชิ้นงานเฉลี่ย ก×ย×ส (เซนติเมตร)</label>
                    <input type="text" class="form-control" 
                            name="receive_test_lists_dimensions" 
                            id="receive_test_lists_dimensions"
                            value="{{$pd->receive_test_lists_dimensions}}"
                            readonly>
                </div>
            </div>
             <div class="col-2">
                <div class="form-group">
                    <label for="dimensions_id" class="col-form-label">เครื่องวัดชิ้นงาน</label>
                    <select class="form-control" name="dimensions_id" disabled>
                        <option value="">กรุณาเลือกเครื่องวัด</option>
                        @foreach ($cal as $item)
                            <option value="{{$item->calibration_lists_id}}"
                                {{ $item->calibration_lists_id == $pd->dimensions_id ? 'selected' : '' }}>
                                {{$item->calibration_lists_name1}} ({{$item->calibration_lists_code}})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="dimensions_id1" class="col-form-label">เครื่องวัดชิ้นงาน</label>
                    <select class="form-control" name="dimensions_id1" disabled>
                        <option value="">กรุณาเลือกเครื่องวัด</option>
                        @foreach ($cal as $item)
                            <option value="{{$item->calibration_lists_id}}"
                                {{ $item->calibration_lists_id == $pd->dimensions_id1 ? 'selected' : '' }}>
                                {{$item->calibration_lists_name1}} ({{$item->calibration_lists_code}})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="receive_test_lists_weight" class="col-form-label">น้ำหนักชิ้นงานเฉลี่ย(กรัม)</label>
                    <input type="text" class="form-control" 
                            name="receive_test_lists_weight" 
                            id="receive_test_lists_weight"
                            value="{{$pd->receive_test_lists_weight}}"
                            readonly>
                </div>
            </div>
             <div class="col-2">
                <div class="form-group">
                    <label for="weight_id" class="col-form-label">เครื่องชั่งชิ้นงาน</label>
                    <select class="form-control" name="weight_id" disabled>
                        <option value="">กรุณาเลือกเครื่องชั่ง</option>
                        @foreach ($cal as $item)
                            <option value="{{$item->calibration_lists_id}}"
                                {{ $item->calibration_lists_id == $pd->weight_id ? 'selected' : '' }}>
                                {{$item->calibration_lists_name1}} ({{$item->calibration_lists_code}})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div> 
        </div>
        <div class="row mt-2">
            <div class="col-2">
                <div class="form-group">
                    <label for="chemistry_hd_id" class="col-form-label">สูตรเคมี</label>
                    <select class="form-control" name="chemistry_hd_id" disabled>
                        <option value="">กรุณาเลือกสูตร</option>
                        @foreach ($bom as $item)
                            <option value="{{$item->chemistry_hd_id}}"
                                {{ $item->chemistry_hd_id == $pd->chemistry_hd_id ? 'selected' : '' }}>
                                {{$item->ms_formule_name}} ({{$item->chemistry_hd_name}})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-10">
                <div class="form-group">
                    <label for="" class="col-form-label">สถาพทั่วไป/ความสมบูรณ์ของชิ้นงาน</label>
                    <input class="form-control" name="receive_test_lists_note" value="{{$pd->receive_test_lists_note}}" readonly>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-6 text-center">
                <img src="{{asset($pd->receive_test_lists_file1)}}" class="img-thumbnail" width="25%">
            </div>
            <div class="col-6 text-center">
                <img src="{{asset($pd->receive_test_lists_file2)}}" class="img-thumbnail" width="25%">
            </div>
        </div>
        <br>
                <div class="row">
    <table class="table table-bordered text-center align-middle">
        <thead>
            <tr>
                <th rowspan="2" class="align-middle"></th>
                <th colspan="2">ความกว้าง (มิลลิเมตร)</th>
                <th colspan="2">ความยาว (มิลลิเมตร)</th>
                <th colspan="2">ความสูง (มิลลิเมตร)</th>
                <th colspan="2">น้ำหนัก (กรัม)</th>
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
                <td><input type="text" class="form-control" name="receive_n1_width1" value="{{$pd->receive_n1_width1}}" readonly aria-label="ความกว้าง 1 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="receive_n1_width2" value="{{$pd->receive_n1_width2}}" readonly aria-label="ความกว้าง 2 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="receive_n1_length1" value="{{$pd->receive_n1_length1}}" readonly aria-label="ความยาว 1 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="receive_n1_length2" value="{{$pd->receive_n1_length2}}" readonly aria-label="ความยาว 2 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="receive_n1_height1" value="{{$pd->receive_n1_height1}}" readonly aria-label="ความสูง 1 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="receive_n1_height2" value="{{$pd->receive_n1_height2}}" readonly aria-label="ความสูง 2 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="receive_n1_weight1" value="{{$pd->receive_n1_weight1}}" readonly aria-label="น้ำหนัก 1 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="receive_n1_weight2" value="{{$pd->receive_n1_weight2}}" readonly aria-label="น้ำหนัก 2 สำหรับ N1"></td>
            </tr>
            <tr>
                <td><strong>N2</strong></td>
                <td><input type="text" class="form-control" name="receive_n2_width1" value="{{$pd->receive_n2_width1}}" readonly aria-label="ความกว้าง 1 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="receive_n2_width2" value="{{$pd->receive_n2_width2}}" readonly aria-label="ความกว้าง 2 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="receive_n2_length1" value="{{$pd->receive_n2_length1}}" readonly aria-label="ความยาว 1 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="receive_n2_length2" value="{{$pd->receive_n2_length2}}" readonly aria-label="ความยาว 2 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="receive_n2_height1" value="{{$pd->receive_n2_height1}}" readonly aria-label="ความสูง 1 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="receive_n2_height2" value="{{$pd->receive_n2_height2}}" readonly aria-label="ความสูง 2 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="receive_n2_weight1" value="{{$pd->receive_n2_weight1}}" readonly aria-label="น้ำหนัก 1 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="receive_n2_weight2" value="{{$pd->receive_n2_weight2}}" readonly aria-label="น้ำหนัก 2 สำหรับ N2"></td>
            </tr>
            <tr>
                <td><strong>N3</strong></td>
                <td><input type="text" class="form-control" name="receive_n3_width1" value="{{$pd->receive_n3_width1}}" readonly aria-label="ความกว้าง 1 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="receive_n3_width2" value="{{$pd->receive_n3_width2}}" readonly aria-label="ความกว้าง 2 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="receive_n3_length1" value="{{$pd->receive_n3_length1}}" readonly aria-label="ความยาว 1 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="receive_n3_length2" value="{{$pd->receive_n3_length2}}" readonly aria-label="ความยาว 2 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="receive_n3_height1" value="{{$pd->receive_n3_height1}}" readonly aria-label="ความสูง 1 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="receive_n3_height2" value="{{$pd->receive_n3_height2}}" readonly aria-label="ความสูง 2 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="receive_n3_weight1" value="{{$pd->receive_n3_weight1}}" readonly aria-label="น้ำหนัก 1 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="receive_n3_weight2" value="{{$pd->receive_n3_weight2}}" readonly aria-label="น้ำหนัก 2 สำหรับ N3"></td>
            </tr>
        </tbody>
    </table>
</div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form method="POST" class="form-horizontal" action="{{ route('receive-test.update-result', $pd->receive_test_lists_id) }}" enctype="multipart/form-data">
        @csrf      
        @method('PUT')
        <div class="row">
            <div class="col-12 col-md-6">
                <h3 class="card-title">ชิ้นงานหลังทดสอบ</h3>
                 @if ($test)
                    <a href="{{ route('report.compareformulas.print',$test->TestID) }}" target="_blank" class="btn btn-sm btn-warning">
                        <i class="fas fa-print"> รายงาน</i>
                    </a>
                @endif
            </div>
        </div>
        <input type="hidden" name="ar_requestorder_hds_id" value="{{$pd->ar_requestorder_hds_id}}">    
        <input type="hidden" name="receive_test_lists_id" value="{{$pd->receive_test_lists_id}}">    
        <div class="row mt-3">
            <div class="col-3">
                <div class="form-group">
                    <label for="result_test_lists_date" class="col-form-label">วันที่ทดสอบเสร็จ</label>
                    <input type="date" class="form-control" 
                            name="result_test_lists_date" 
                            id="result_test_lists_date"
                            value="{{$pd->result_test_lists_date}}"
                            required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="result_test_lists_dimensions" class="col-form-label">มิติชิ้นงานเฉลี่ย ก×ย×ส (มิลลิเมตร)</label>
                    <input type="text" class="form-control" 
                            name="result_test_lists_dimensions" 
                            id="result_test_lists_dimensions"
                            value="{{$pd->result_test_lists_dimensions}}"
                            readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="result_dimensions_id" class="col-form-label">เครื่องวัดชิ้นงานที่1</label>
                    <select class="form-control" name="result_dimensions_id" required>
                        <option value="">กรุณาเลือกเครื่องวัด</option>
                        @foreach ($cal as $item)
                            <option value="{{$item->calibration_lists_id}}"
                                {{ $item->calibration_lists_id == $pd->result_dimensions_id ? 'selected' : '' }}>
                                {{$item->calibration_lists_name1}} ({{$item->calibration_lists_code}})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="result_dimensions_id1" class="col-form-label">เครื่องวัดชิ้นงานที่2</label>
                    <select class="form-control" name="result_dimensions_id1" required>
                        <option value="">กรุณาเลือกเครื่องวัด</option>
                        @foreach ($cal as $item)
                            <option value="{{$item->calibration_lists_id}}"
                                {{ $item->calibration_lists_id == $pd->result_dimensions_id1 ? 'selected' : '' }}>
                                {{$item->calibration_lists_name1}} ({{$item->calibration_lists_code}})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-2">    
            <div class="col-3">
                <div class="form-group">
                    <label for="result_test_lists_plate" class="col-form-label">วัสดุจานทดสอบ</label>
                    <input type="text" class="form-control" 
                            name="result_test_lists_plate" 
                            id="result_test_lists_plate"
                            value="{{$pd->result_test_lists_plate}}"
                            required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="result_test_lists_weight" class="col-form-label">น้ำหนักชิ้นงานเฉลี่ย(กรัม)</label>
                    <input type="text" class="form-control" 
                            name="result_test_lists_weight" 
                            id="result_test_lists_weight"
                            value="{{$pd->result_test_lists_weight}}"
                            readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="result_weight_id" class="col-form-label">เครื่องชั่งชิ้นงาน</label>
                    <select class="form-control" name="result_weight_id" required>
                        <option value="">กรุณาเลือกเครื่องชั่ง</option>
                        @foreach ($cal as $item)
                            <option value="{{$item->calibration_lists_id}}"
                                {{ $item->calibration_lists_id == $pd->result_weight_id ? 'selected' : '' }}>
                                {{$item->calibration_lists_name1}} ({{$item->calibration_lists_code}})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="result_test_lists_temp" class="col-form-label">อุณหภูมิห้องเฉลี่ย</label>
                    <input type="text" class="form-control" 
                            name="result_test_lists_temp" 
                            id="result_test_lists_temp"
                            value="{{$pd->result_test_lists_temp}}"
                            readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="result_test_lists_moisture" class="col-form-label">ความชื้นเฉลี่ย</label>
                    <input type="text" class="form-control" 
                            name="result_test_lists_moisture" 
                            id="result_test_lists_moisture"
                            value="{{$pd->result_test_lists_moisture}}"
                            readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="result_test_lists_test" class="col-form-label">ผลการทดสอบ</label>
                     <select class="form-control" name="result_test_lists_test" required>
                        <option value="{{$pd->result_test_lists_test}}">{{$pd->result_test_lists_test}}</option>
                        <option value="Pass">Pass</option>
                        <option value="Fail">Fail</option>
                    </select>
                </div>
            </div> 
            <div class="col-3">
                <div class="form-group">
                    <label for="result_n1_rpm" class="col-form-label">รอบเครื่อง N1 (rpm)</label>
                    <input type="number" class="form-control" 
                            name="result_n1_rpm" 
                            id="result_n1_rpm"
                            value="{{$pd->result_n1_rpm}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="result_n2_rpm" class="col-form-label">รอบเครื่อง N2 (rpm)</label>
                    <input type="number" class="form-control" 
                            name="result_n2_rpm" 
                            id="result_n2_rpm"
                            value="{{$pd->result_n2_rpm}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="result_n3_rpm" class="col-form-label">รอบเครื่อง N3 (rpm)</label>
                    <input type="number" class="form-control" 
                            name="result_n3_rpm" 
                            id="result_n3_rpm"
                            value="{{$pd->result_n3_rpm}}">
                </div>
            </div>  
            <div class="col-9">
                <div class="form-group">
                    <label for="result_test_lists_remark" class="col-form-label">สภาพพื้นผิวสัมผัส</label>
                    <input type="text" class="form-control" 
                            name="result_test_lists_remark" 
                            id="result_test_lists_remark"
                            value="{{$pd->result_test_lists_remark}}"
                            required>
                </div>
            </div>        
        </div>
         <div class="row mt-3">
            <div class="col-6 text-center">
                <img src="{{asset($pd->result_test_lists_file1)}}" class="img-thumbnail" width="25%">
            </div>
            <div class="col-6 text-center">
                <img src="{{asset($pd->result_test_lists_file2)}}" class="img-thumbnail" width="25%">
            </div>
        </div>
                <div class="row mt-2">
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
                <td><input type="text" class="form-control" name="result_n1_width1" value="{{$pd->result_n1_width1}}" aria-label="ความกว้าง 1 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="result_n1_width2" value="{{$pd->result_n1_width2}}" aria-label="ความกว้าง 2 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="result_n1_length1" value="{{$pd->result_n1_length1}}" aria-label="ความยาว 1 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="result_n1_length2" value="{{$pd->result_n1_length2}}" aria-label="ความยาว 2 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="result_n1_height1" value="{{$pd->result_n1_height1}}" aria-label="ความสูง 1 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="result_n1_height2" value="{{$pd->result_n1_height2}}" aria-label="ความสูง 2 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="result_n1_weight1" value="{{$pd->result_n1_weight1}}" aria-label="น้ำหนัก 1 สำหรับ N1"></td>
                <td><input type="text" class="form-control" name="result_n1_weight2" value="{{$pd->result_n1_weight2}}" aria-label="น้ำหนัก 2 สำหรับ N1"></td>
            </tr>
            <tr>
                <td><strong>N2</strong></td>
                <td><input type="text" class="form-control" name="result_n2_width1" value="{{$pd->result_n2_width1}}" aria-label="ความกว้าง 1 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="result_n2_width2" value="{{$pd->result_n2_width2}}" aria-label="ความกว้าง 2 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="result_n2_length1" value="{{$pd->result_n2_length1}}" aria-label="ความยาว 1 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="result_n2_length2" value="{{$pd->result_n2_length2}}" aria-label="ความยาว 2 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="result_n2_height1" value="{{$pd->result_n2_height1}}" aria-label="ความสูง 1 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="result_n2_height2" value="{{$pd->result_n2_height2}}" aria-label="ความสูง 2 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="result_n2_weight1" value="{{$pd->result_n2_weight1}}" aria-label="น้ำหนัก 1 สำหรับ N2"></td>
                <td><input type="text" class="form-control" name="result_n2_weight2" value="{{$pd->result_n2_weight2}}" aria-label="น้ำหนัก 2 สำหรับ N2"></td>
            </tr>
            <tr>
                <td><strong>N3</strong></td>
                <td><input type="text" class="form-control" name="result_n3_width1" value="{{$pd->result_n3_width1}}" aria-label="ความกว้าง 1 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="result_n3_width2" value="{{$pd->result_n3_width2}}" aria-label="ความกว้าง 2 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="result_n3_length1" value="{{$pd->result_n3_length1}}" aria-label="ความยาว 1 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="result_n3_length2" value="{{$pd->result_n3_length2}}" aria-label="ความยาว 2 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="result_n3_height1" value="{{$pd->result_n3_height1}}" aria-label="ความสูง 1 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="result_n3_height2" value="{{$pd->result_n3_height2}}" aria-label="ความสูง 2 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="result_n3_weight1" value="{{$pd->result_n3_weight1}}" aria-label="น้ำหนัก 1 สำหรับ N3"></td>
                <td><input type="text" class="form-control" name="result_n3_weight2" value="{{$pd->result_n3_weight2}}" aria-label="น้ำหนัก 2 สำหรับ N3"></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="row mt-2">
    <table class="table table-bordered text-center align-middle">
        <thead>
            <tr>
                <th rowspan="2" class="align-middle">รายละเอียด</th>
                <th colspan="2">N1</th>
                <th colspan="2">N2</th>
                <th colspan="2">N3</th>
            </tr>
            <tr>
                <th>℃</th>
                <th>% RH</th>
                <th>℃</th>
                <th>% RH</th>
                <th>℃</th>
                <th>% RH</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>100</td>
                <td>
                    <input class="form-control" name="result100_n1temp" value="{{$pd->result100_n1temp}}">
                </td>
                <td>
                    <input class="form-control" name="result100_n1moisture" value="{{$pd->result100_n1moisture}}">
                </td>
                <td>
                    <input class="form-control" name="result100_n2temp" value="{{$pd->result100_n2temp}}">
                </td>
                <td>
                    <input class="form-control" name="result100_n2moisture" value="{{$pd->result100_n2moisture}}">
                </td>
                <td>
                    <input class="form-control" name="result100_n3temp" value="{{$pd->result100_n3temp}}">
                </td>
                <td>
                    <input class="form-control" name="result100_n3moisture" value="{{$pd->result100_n3moisture}}">
                </td>
            </tr>
            <tr>
                <td>150</td>
                <td>
                    <input class="form-control" name="result150_n1temp" value="{{$pd->result150_n1temp}}">
                </td>
                <td>
                    <input class="form-control" name="result150_n1moisture" value="{{$pd->result150_n1moisture}}">
                </td>
                <td>
                    <input class="form-control" name="result150_n2temp" value="{{$pd->result150_n2temp}}">
                </td>
                <td>
                    <input class="form-control" name="result150_n2moisture" value="{{$pd->result150_n2moisture}}">
                </td>
                <td>
                    <input class="form-control" name="result150_n3temp" value="{{$pd->result150_n3temp}}">
                </td>
                <td>
                    <input class="form-control" name="result150_n3moisture" value="{{$pd->result150_n3moisture}}">
                </td>
            </tr>
            <tr>
                <td>200</td>
                <td>
                    <input class="form-control" name="result200_n1temp" value="{{$pd->result200_n1temp}}">
                </td>
                <td>
                    <input class="form-control" name="result200_n1moisture" value="{{$pd->result200_n1moisture}}">
                </td>
                <td>
                    <input class="form-control" name="result200_n2temp" value="{{$pd->result200_n2temp}}">
                </td>
                <td>
                    <input class="form-control" name="result200_n2moisture" value="{{$pd->result200_n2moisture}}">
                </td>
                <td>
                    <input class="form-control" name="result200_n3temp" value="{{$pd->result200_n3temp}}">
                </td>
                <td>
                    <input class="form-control" name="result200_n3moisture" value="{{$pd->result200_n3moisture}}">
                </td>
            </tr>
            <tr>
                <td>250</td>
                <td>
                    <input class="form-control" name="result250_n1temp" value="{{$pd->result250_n1temp}}">
                </td>
                <td>
                    <input class="form-control" name="result250_n1moisture" value="{{$pd->result250_n1moisture}}">
                </td>
                <td>
                    <input class="form-control" name="result250_n2temp" value="{{$pd->result250_n2temp}}">
                </td>
                <td>
                    <input class="form-control" name="result250_n2moisture" value="{{$pd->result250_n2moisture}}">
                </td>
                <td>
                    <input class="form-control" name="result250_n3temp" value="{{$pd->result250_n3temp}}">
                </td>
                <td>
                    <input class="form-control" name="result250_n3moisture" value="{{$pd->result250_n3moisture}}">
                </td>
            </tr>
            <tr>
                <td>300</td>
                <td>
                    <input class="form-control" name="result300_n1temp" value="{{$pd->result300_n1temp}}">
                </td>
                <td>
                    <input class="form-control" name="result300_n1moisture" value="{{$pd->result300_n1moisture}}">
                </td>
                <td>
                    <input class="form-control" name="result300_n2temp" value="{{$pd->result300_n2temp}}">
                </td>
                <td>
                    <input class="form-control" name="result300_n2moisture" value="{{$pd->result300_n2moisture}}">
                </td>
                <td>
                    <input class="form-control" name="result300_n3temp" value="{{$pd->result300_n3temp}}">
                </td>
                <td>
                    <input class="form-control" name="result300_n3moisture" value="{{$pd->result300_n3moisture}}">
                </td>
            </tr>
            <tr>
                <td>350</td>
                <td>
                    <input class="form-control" name="result350_n1temp" value="{{$pd->result350_n1temp}}">
                </td>
                <td>
                    <input class="form-control" name="result350_n1moisture" value="{{$pd->result350_n1moisture}}">
                </td>
                <td>
                    <input class="form-control" name="result350_n2temp" value="{{$pd->result350_n2temp}}">
                </td>
                <td>
                    <input class="form-control" name="result350_n2moisture" value="{{$pd->result350_n2moisture}}">
                </td>
                <td>
                    <input class="form-control" name="result350_n3temp" value="{{$pd->result350_n3temp}}">
                </td>
                <td>
                    <input class="form-control" name="result350_n3moisture" value="{{$pd->result350_n3moisture}}">
                </td>
            </tr>
        </tbody>
    </table>
</div>
        <div class="row mt-3">
            <table class="table table-bordered dt-responsive nowrap w-100 text-center">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 30%">เครื่องมือวัด</th>
                        <th style="width: 30%">รายละเอียดเพิ่มเติม</th>
                        <th style="width: 7%">ระยะเวลา(นาที)</th>
                        <th style="width: 7%">ความหนาก่อนทดสอบ</th>
                        <th style="width: 7%">ความหนาหลังทดสอบ</th>
                        <th style="width: 7%">ระยะสึกหรอ</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach ($sub as $item)
                        <tr>
                            <td>
                                {{$item->receive_test_subs_listno}}
                                <input type="hidden" name="receive_test_subs_id[]" value="{{$item->receive_test_subs_id}}">
                            </td>
                            <td>{{$item->calibration_lists_name1}} ({{$item->calibration_lists_code}})</td>
                            <td>
                                <input class="form-control" name="receive_test_subs_note[]" value="{{$item->receive_test_subs_note}}">
                            </td>
                            <td>
                                <input class="form-control" name="receive_test_subs_time[]" value="{{$item->receive_test_subs_time}}">
                            </td>
                            <td>
                                <input class="form-control" name="before_testing[]" value="{{$item->before_testing}}">
                            </td>
                            <td>
                                <input class="form-control" name="after_testing[]" value="{{$item->after_testing}}">
                            </td>
                            <td>
                                <input class="form-control" name="total_testing[]" value="{{$item->total_testing}}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>       
            </table>
        </div>
        <div class="row mt-3">
            <div class="form-group">
                <label for="receive_test_lists_weight" class="col-form-label">สถาพทั่วไป/ความสมบูรณ์ของชิ้นงาน</label>
                <textarea class="form-control" name="result_test_lists_note">{{$pd->result_test_lists_note}}</textarea>
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
function calculateAverageWeight() {
    const weightFields = [
        'result_n1_weight1', 'result_n1_weight2',
        'result_n2_weight1', 'result_n2_weight2',
        'result_n3_weight1', 'result_n3_weight2'
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
        $('#result_test_lists_weight').val(avg.toFixed(2));
    } else {
        $('#result_test_lists_weight').val('');
    }
}

// ฟังก์ชันคำนวณค่าเฉลี่ย มิติชิ้นงาน (กว้าง x ยาว x สูง)
function calculateAverageDimensions() {
    const widthFields = [
        'result_n1_width1', 'result_n1_width2',
        'result_n2_width1', 'result_n2_width2',
        'result_n3_width1', 'result_n3_width2'
    ];
    const lengthFields = [
        'result_n1_length1', 'result_n1_length2',
        'result_n2_length1', 'result_n2_length2',
        'result_n3_length1', 'result_n3_length2'
    ];
    const heightFields = [
        'result_n1_height1', 'result_n1_height2',
        'result_n2_height1', 'result_n2_height2',
        'result_n3_height1', 'result_n3_height2'
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
        $('#result_test_lists_dimensions').val(avgWidth + ' × ' + avgLength + ' × ' + avgHeight);
    } else if (dimensionsArr.length > 0) {
        // กรณีพิมพ์ไม่ครบทุกมิติ จะแสดงเฉพาะตัวที่มีค่า หรือเว้นไว้ก่อนก็ได้
        $('#result_test_lists_dimensions').val(dimensionsArr.join(' × '));
    } else {
        $('#result_test_lists_dimensions').val('');
    }
}

// ผูก Event ให้ทำงานอัตโนมัติเมื่อมีการกรอกข้อมูลในช่องมิติและน้ำหนัก
$(document).ready(function() {
    const allFields = [
        'result_n1_width1', 'result_n1_width2', 'result_n1_length1', 'result_n1_length2', 'result_n1_height1', 'result_n1_height2', 'result_n1_weight1', 'result_n1_weight2',
        'result_n2_width1', 'result_n2_width2', 'result_n2_length1', 'result_n2_length2', 'result_n2_height1', 'result_n2_height2', 'result_n2_weight1', 'result_n2_weight2',
        'result_n3_width1', 'result_n3_width2', 'result_n3_length1', 'result_n3_length2', 'result_n3_height1', 'result_n3_height2', 'result_n3_weight1', 'result_n3_weight2'
    ];

    allFields.forEach(function(fieldName) {
        $(`input[name="${fieldName}"]`).on('input', function() {
            calculateAverageWeight();
            calculateAverageDimensions();
        });
    });
});
// ฟังก์ชันคำนวณค่าเฉลี่ย อุณหภูมิและความชื้นจากตารางผลลัพธ์
function calculateResultAverages() {
    // รายชื่อ input สำหรับอุณหภูมิ (°C) ทั้งหมด
    const tempFields = [
        'result100_n1temp', 'result100_n2temp', 'result100_n3temp',
        'result150_n1temp', 'result150_n2temp', 'result150_n3temp',
        'result200_n1temp', 'result200_n2temp', 'result200_n3temp',
        'result250_n1temp', 'result250_n2temp', 'result250_n3temp',
        'result300_n1temp', 'result300_n2temp', 'result300_n3temp',
        'result350_n1temp', 'result350_n2temp', 'result350_n3temp'
    ];

    // รายชื่อ input สำหรับความชื้น (% RH) ทั้งหมด
    const moistureFields = [
        'result100_n1moisture', 'result100_n2moisture', 'result100_n3moisture',
        'result150_n1moisture', 'result150_n2moisture', 'result150_n3moisture',
        'result200_n1moisture', 'result200_n2moisture', 'result200_n3moisture',
        'result250_n1moisture', 'result250_n2moisture', 'result250_n3moisture',
        'result300_n1moisture', 'result300_n2moisture', 'result300_n3moisture',
        'result350_n1moisture', 'result350_n2moisture', 'result350_n3moisture'
    ];

    // คำนวณค่าเฉลี่ยอุณหภูมิ
    let tempSum = 0, tempCount = 0;
    tempFields.forEach(function(fieldName) {
        let val = parseFloat($(`input[name="${fieldName}"]`).val());
        if (!isNaN(val)) {
            tempSum += val;
            tempCount++;
        }
    });

    if (tempCount > 0) {
        $('#result_test_lists_temp').val((tempSum / tempCount).toFixed(2));
    } else {
        $('#result_test_lists_temp').val('');
    }

    // คำนวณค่าเฉลี่ยความชื้น
    let moistSum = 0, moistCount = 0;
    moistureFields.forEach(function(fieldName) {
        let val = parseFloat($(`input[name="${fieldName}"]`).val());
        if (!isNaN(val)) {
            moistSum += val;
            moistCount++;
        }
    });

    if (moistCount > 0) {
        $('#result_test_lists_moisture').val((moistSum / moistCount).toFixed(2));
    } else {
        $('#result_test_lists_moisture').val('');
    }
}

// ผูก Event ให้ทำงานเมื่อมีการพิมพ์ข้อมูลลงในช่อง input ของตารางนี้
$(document).ready(function() {
    const allTableFields = [
        'result100_n1temp', 'result100_n1moisture', 'result100_n2temp', 'result100_n2moisture', 'result100_n3temp', 'result100_n3moisture',
        'result150_n1temp', 'result150_n1moisture', 'result150_n2temp', 'result150_n2moisture', 'result150_n3temp', 'result150_n3moisture',
        'result200_n1temp', 'result200_n1moisture', 'result200_n2temp', 'result200_n2moisture', 'result200_n3temp', 'result200_n3moisture',
        'result250_n1temp', 'result250_n1moisture', 'result250_n2temp', 'result250_n2moisture', 'result250_n3temp', 'result250_n3moisture',
        'result300_n1temp', 'result300_n1moisture', 'result300_n2temp', 'result300_n2moisture', 'result300_n3temp', 'result300_n3moisture',
        'result350_n1temp', 'result350_n1moisture', 'result350_n2temp', 'result350_n2moisture', 'result350_n3temp', 'result350_n3moisture'
    ];

    allTableFields.forEach(function(fieldName) {
        $(`input[name="${fieldName}"]`).on('input', function() {
            calculateResultAverages();
        });
    });
});
</script>
</script>
@endpush