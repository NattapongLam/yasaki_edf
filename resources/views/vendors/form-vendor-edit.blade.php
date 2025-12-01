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
            <div class="col-12 col-md-6"><h3 class="card-title">ผู้จำหน่าย</h3></div> 
        </div>
        <form method="POST" class="form-horizontal" action="{{ route('vendorlists.update',$hd->ap_vendor_lists_id) }}" enctype="multipart/form-data">
        @csrf  
        @method('PUT')   
        <div class="row">            
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_vendor_lists_code" class="col-form-label">รหัส</label>
                    <input type="text" class="form-control" name="ap_vendor_lists_code" id="ap_vendor_lists_code" value="{{$hd->ap_vendor_lists_code}}" required>
                </div>         
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="acc_companytype_id" class="col-form-label">ประเภท</label>
                    <select class="form-select" name="acc_companytype_id">
                        <option value="">กรุณาเลือก</option>
                        @foreach ($types as $item)
                            <option value="{{$item->acc_companytype_id}}"
                                 {{ $item->acc_companytype_id == $hd->acc_companytype_id ? 'selected' : '' }}>
                                {{$item->acc_companytype_name}}
                            </option>
                        @endforeach
                    </select>
                </div>         
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_vendor_groups_id" class="col-form-label">กลุ่ม</label>
                    <select class="form-select" name="ap_vendor_groups_id">
                        <option value="">กรุณาเลือก</option>
                        @foreach ($groups as $item)
                            <option value="{{$item->ap_vendor_groups_id}}"
                                {{ $item->ap_vendor_groups_id == $hd->ap_vendor_groups_id ? 'selected' : '' }}>
                                {{$item->ap_vendor_groups_name}}
                            </option>
                        @endforeach
                    </select>
                </div>         
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="other_countries_id" class="col-form-label">ประเทศ</label>
                    <select class="form-select" name="other_countries_id">
                        <option value="">กรุณาเลือก</option>
                        @foreach ($countrys as $item)
                            <option value="{{$item->other_countries_id}}"
                                {{ $item->other_countries_id == $hd->other_countries_id ? 'selected' : '' }}>
                                {{$item->other_countries_name1}}
                            </option>
                        @endforeach
                    </select>
                </div>         
            </div>
        </div>
        <div class="row">   
            <div class="col-6">
                <div class="form-group">
                    <label for="ap_vendor_lists_name1" class="col-form-label">ชื่อภาษไทย</label>
                    <input type="text" class="form-control" name="ap_vendor_lists_name1" id="ap_vendor_lists_name1" value="{{$hd->ap_vendor_lists_name1}}" required>
                </div>         
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="ap_vendor_lists_name2" class="col-form-label">ชื่อภาษอังกฤษ</label>
                    <input type="text" class="form-control" name="ap_vendor_lists_name2" id="ap_vendor_lists_name2" value="{{$hd->ap_vendor_lists_name2}}">
                </div>         
            </div>
        </div> 
        <div class="row">   
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_vendor_lists_address1" class="col-form-label">ที่อยู่ออกบิล</label>
                    <input type="text" class="form-control" name="ap_vendor_lists_address1" id="ap_vendor_lists_address1" value="{{$hd->ap_vendor_lists_address1}}" required>
                </div>         
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="other_provinces_id" class="col-form-label">จังหวัด</label>
                    <select class="form-select select2" name="other_provinces_id" id="other_provinces_id">
                        <option value="">กรุณาเลือก</option>
                        @foreach ($provinces as $item)
                            <option value="{{ $item->other_provinces_id }}"
                                {{ $item->other_provinces_id == $hd->other_provinces_id ? 'selected' : '' }}>
                                {{ $item->other_provinces_name1 }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-3">
                <div class="form-group">
                    <label for="other_districts_id" class="col-form-label">เขต/อำเภอ</label>
                    <select class="form-select select2" name="other_districts_id" id="other_districts_id">
                        <option value="">กรุณาเลือกจังหวัดก่อน</option>
                    </select>
                </div>
            </div>

            <div class="col-3">
                <div class="form-group">
                    <label for="other_sub_districts_id" class="col-form-label">แขวง/ตำบล</label>
                    <select class="form-select select2" name="other_sub_districts_id" id="other_sub_districts_id">
                        <option value="">กรุณาเลือกเขต/อำเภอก่อน</option>
                    </select>
                </div>
            </div>
        </div> 
       <div class="row">          
            <div class="col-6">
                <div class="form-group">
                    <label for="ap_vendor_lists_bankname" class="col-form-label">ธนาคร</label>
                    <input type="text" class="form-control" name="ap_vendor_lists_bankname" id="ap_vendor_lists_bankname" value="{{$hd->ap_vendor_lists_bankname}}">
                </div>         
            </div>
             <div class="col-6">
                <div class="form-group">
                    <label for="ap_vendor_lists_banknumber" class="col-form-label">เลขที่บัญชี</label>
                    <input type="text" class="form-control" name="ap_vendor_lists_banknumber" id="ap_vendor_lists_banknumber" value="{{$hd->ap_vendor_lists_banknumber}}">
                </div>         
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="acc_companybranch_id" class="col-form-label">สาขา</label>
                    <select class="form-select" name="acc_companybranch_id">
                        <option value="">กรุณาเลือก</option>
                        @foreach ($branchs as $item)
                            <option value="{{$item->acc_companybranch_id}}"
                                {{ $item->acc_companybranch_id == $hd->acc_companybranch_id ? 'selected' : '' }}>
                                {{$item->acc_companybranch_name}}
                            </option>
                        @endforeach     
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_vendor_lists_branchnumber" class="col-form-label">รหัสสาขา</label>
                    <input type="text" class="form-control" name="ap_vendor_lists_branchnumber" id="ap_vendor_lists_branchnumber" value="{{$hd->ap_vendor_lists_branchnumber}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_vendor_lists_taxid" class="col-form-label">เลขประจำตัวผู้เสียภาษี</label>
                    <input type="text" class="form-control" name="ap_vendor_lists_taxid" id="ap_vendor_lists_taxid" value="{{$hd->ap_vendor_lists_taxid}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_vendor_lists_credit" class="col-form-label">จำนวนวันเครดิต</label>
                    <input type="number" class="form-control" name="ap_vendor_lists_credit" id="ap_vendor_lists_credit" value="{{$hd->ap_vendor_lists_credit}}">
                </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_vendor_lists_contact" class="col-form-label">ผู้ติดต่อ</label>
                    <input type="text" class="form-control" name="ap_vendor_lists_contact" id="ap_vendor_lists_contact" value="{{$hd->ap_vendor_lists_contact}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_vendor_lists_tel" class="col-form-label">เบอร์โทร</label>
                    <input type="text" class="form-control" name="ap_vendor_lists_tel" id="ap_vendor_lists_tel" value="{{$hd->ap_vendor_lists_tel}}" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_vendor_lists_email" class="col-form-label">Email</label>
                    <input type="text" class="form-control" name="ap_vendor_lists_email" id="ap_vendor_lists_email" value="{{$hd->ap_vendor_lists_email}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ap_vendor_lists_lineid" class="col-form-label">Line ID</label>
                    <input type="text" class="form-control" name="ap_vendor_lists_lineid" id="ap_vendor_lists_lineid" value="{{$hd->ap_vendor_lists_lineid}}">
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
        <input type="hidden" id="old_province" value="{{ $hd->other_provinces_id }}">
        <input type="hidden" id="old_district" value="{{ $hd->other_districts_id }}">
        <input type="hidden" id="old_subdistrict" value="{{ $hd->other_sub_districts_id }}">           
    </div>
</div>
</div>
@endsection
@push('scriptjs')
<script>
$(document).ready(function () {
    $('.select2').select2({ width: '100%' });

    let oldProvince = $('#old_province').val();
    let oldDistrict = $('#old_district').val();
    let oldSubdistrict = $('#old_subdistrict').val();

    // ---------- โหลดจังหวัดที่เคยเลือก ----------
    if (oldProvince) {
        $('#other_provinces_id').val(oldProvince).trigger('change');

        // โหลดอำเภอของจังหวัดเดิม
        $.get('/get-districts/' + oldProvince, function (data) {
            $('#other_districts_id').empty().append('<option value="">กรุณาเลือก</option>');

            $.each(data, function (key, item) {
                $('#other_districts_id').append(
                    `<option value="${item.other_districts_id}">${item.other_districts_name1}</option>`
                );
            });

            // ---------- set ค่าอำเภอที่เคยเลือก ----------
            if (oldDistrict) {
                $('#other_districts_id').val(oldDistrict).trigger('change');

                // โหลดตำบลตามอำเภอเดิม
                $.get('/get-subdistricts/' + oldDistrict, function (data) {
                    $('#other_sub_districts_id').empty().append('<option value="">กรุณาเลือก</option>');

                    $.each(data, function (key, item) {
                        $('#other_sub_districts_id').append(
                            `<option value="${item.other_sub_districts_id}">${item.other_sub_districts_name1}</option>`
                        );
                    });

                    // ---------- set ค่าตำบลเดิม ----------
                    if (oldSubdistrict) {
                        $('#other_sub_districts_id').val(oldSubdistrict).trigger('change');
                    }
                });
            }
        });
    }
});
</script>
@endpush