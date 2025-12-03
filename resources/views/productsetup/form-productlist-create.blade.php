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
            <div class="col-12 col-md-6"><h3 class="card-title">สินค้า</h3></div> 
        </div>
        <div class="row">            
            <div class="col-12">
                <form method="POST" class="form-horizontal" action="{{ route('productlists.store') }}" enctype="multipart/form-data">
                @csrf  
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="wh_product_types_id" class="col-form-label">ประเภท</label>
                            <select class="form-select" name="wh_product_types_id" id="wh_product_types_id">
                                <option value="">กรุณาเลือก</option>
                                @foreach ($types as $item)
                                    <option value="{{$item->wh_product_types_id}}" data-code="{{ $item->wh_product_types_code }}">
                                        {{$item->wh_product_types_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="wh_product_groups_id" class="col-form-label">กลุ่ม</label>
                            <select class="form-select" name="wh_product_groups_id" id="wh_product_groups_id">
                                <option value="">กรุณาเลือก</option>
                                @foreach ($groups as $item)
                                    <option value="{{$item->wh_product_groups_id}}" data-code="{{ $item->wh_product_groups_code }}">
                                        {{$item->wh_product_groups_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="wh_product_units_id" class="col-form-label">หน่วยนับ</label>
                            <select class="form-select" name="wh_product_units_id" id="wh_product_units_id">
                                <option value="">กรุณาเลือก</option>
                                @foreach ($units as $item)
                                    <option value="{{$item->wh_product_units_id}}">
                                        {{$item->wh_product_units_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="wh_product_lists_code" class="col-form-label">รหัส</label>
                            <input type="text" class="form-control" name="wh_product_lists_code" id="wh_product_lists_code" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="wh_product_lists_name1" class="col-form-label">ชื่อภาษาไทย</label>
                            <input type="text" class="form-control" name="wh_product_lists_name1" id="wh_product_lists_name1" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="wh_product_lists_name2" class="col-form-label">ชื่ออังกฤษ</label>
                            <input type="text" class="form-control" name="wh_product_lists_name2" id="wh_product_lists_name2">
                        </div>
                    </div>
                </div>                   
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="wh_product_lists_remark" class="col-form-label">รายละเอียด</label>
                            <input type="text" class="form-control" name="wh_product_lists_remark" id="wh_product_lists_remark">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <div class="form-group">
                            <label for="wh_product_lists_cost" class="col-form-label">ต้นทุน</label>
                            <input type="text" class="form-control" name="wh_product_lists_cost" id="wh_product_lists_cost" value="{{old('wh_product_lists_cost',0)}}" required>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="wh_product_lists_price" class="col-form-label">ราคาขาย</label>
                            <input type="text" class="form-control" name="wh_product_lists_price" id="wh_product_lists_price" value="{{old('wh_product_lists_price',0)}}" required>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="wh_product_lists_min" class="col-form-label">จุดสั่งซื้อ</label>
                            <input type="text" class="form-control" name="wh_product_lists_min" id="wh_product_lists_min" value="{{old('wh_product_lists_min',0)}}" required>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="wh_product_lists_max" class="col-form-label">จุดเติมเต็ม</label>
                            <input type="text" class="form-control" name="wh_product_lists_max" id="wh_product_lists_max" value="{{old('wh_product_lists_max',0)}}" required>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="wh_product_lists_moq" class="col-form-label">จำนวนสั่งซื้อขั้นต่ำ</label>
                            <input type="text" class="form-control" name="wh_product_lists_moq" id="wh_product_lists_moq" value="{{old('wh_product_lists_moq',0)}}" required>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="wh_product_lists_timeline" class="col-form-label">ระยะเวลาจัดสั่ง</label>
                            <input type="text" class="form-control" name="wh_product_lists_timeline" id="wh_product_lists_timeline" value="{{old('wh_product_lists_timeline',0)}}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="wh_product_lists_file1" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile01"  name="wh_product_lists_file1" onchange="prevFile(this,'wh_product_lists_file1')">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="wh_product_lists_file2" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile02"  name="wh_product_lists_file2" onchange="prevFile(this,'wh_product_lists_file2')">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="wh_product_lists_file3" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile03"  name="wh_product_lists_file3" onchange="prevFile(this,'wh_product_lists_file3')">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="wh_product_lists_file4" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile03"  name="wh_product_lists_file4" onchange="prevFile(this,'wh_product_lists_file4')">
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
    let grp = String($('#wh_product_types_id option:selected').attr('data-code') || '');
    let typ = String($('#wh_product_groups_id option:selected').attr('data-code') || '');

    console.log("GRP:", grp, "TYP:", typ); // เช็คค่าตรงนี้

    if(grp && typ){
        $.ajax({
            url: "{{ route('product.getLastRunning') }}",
            type: "GET",
            data: {grp, typ },
            success: function(res){
                $('#wh_product_lists_code').val(grp + typ + "-" + res.running);
            }
        });
    }
}
$('#wh_product_types_id').change(generateCode);
$('#wh_product_groups_id').change(generateCode);
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