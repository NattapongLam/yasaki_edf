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
            <div class="col-12 col-md-6"><h3 class="card-title">ลูกค้า</h3></div> 
        </div>
        <form method="POST" class="form-horizontal" action="{{ route('customerlists.store') }}" enctype="multipart/form-data">
        @csrf  
        <div class="row">            
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_code" class="col-form-label">รหัส</label>
                    <input type="text" class="form-control" name="ar_customer_lists_code" id="ar_customer_lists_code" required>
                </div>         
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="acc_companytype_id" class="col-form-label">ประเภท</label>
                    <select class="form-select" name="acc_companytype_id">
                        <option value="">กรุณาเลือก</option>
                        @foreach ($types as $item)
                            <option value="{{$item->acc_companytype_id}}">{{$item->acc_companytype_name}}</option>
                        @endforeach
                    </select>
                </div>         
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_groups_id" class="col-form-label">กลุ่ม</label>
                    <select class="form-select" name="ar_customer_groups_id">
                        <option value="">กรุณาเลือก</option>
                        @foreach ($groups as $item)
                            <option value="{{$item->ar_customer_groups_id}}">{{$item->ar_customer_groups_name}}</option>
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
                            <option value="{{$item->other_countries_id}}">{{$item->other_countries_name1}}</option>
                        @endforeach
                    </select>
                </div>         
            </div>
        </div>
        <div class="row">   
            <div class="col-6">
                <div class="form-group">
                    <label for="ar_customer_lists_name1" class="col-form-label">ชื่อภาษไทย</label>
                    <input type="text" class="form-control" name="ar_customer_lists_name1" id="ar_customer_lists_name1" required>
                </div>         
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="ar_customer_lists_name2" class="col-form-label">ชื่อภาษไทย</label>
                    <input type="text" class="form-control" name="ar_customer_lists_name2" id="ar_customer_lists_name2">
                </div>         
            </div>
        </div> 
        <div class="row">   
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_address1" class="col-form-label">ที่อยู่ออกบิล</label>
                    <input type="text" class="form-control" name="ar_customer_lists_address1" id="ar_customer_lists_address1" required>
                </div>         
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="other_provinces_id" class="col-form-label">จังหวัด</label>
                    <select class="form-select select2" name="other_provinces_id" id="other_provinces_id">
                        <option value="">กรุณาเลือก</option>
                        @foreach ($provinces as $item)
                            <option value="{{ $item->other_provinces_id }}">
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
             <div class="col-12">
                <div class="form-group">
                    <label for="ar_customer_lists_address2" class="col-form-label">ที่อยู่จัดส่ง</label>
                    <input type="text" class="form-control" name="ar_customer_lists_address2" id="ar_customer_lists_address2">
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
                            <option value="{{$item->acc_companybranch_id}}">{{$item->acc_companybranch_name}}</option>
                        @endforeach     
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_branchnumber" class="col-form-label">รหัสสาขา</label>
                    <input type="text" class="form-control" name="ar_customer_lists_branchnumber" id="ar_customer_lists_branchnumber">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_taxid" class="col-form-label">เลขประจำตัวผู้เสียภาษี</label>
                    <input type="text" class="form-control" name="ar_customer_lists_taxid" id="ar_customer_lists_taxid">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_credit" class="col-form-label">จำนวนวันเครดิต</label>
                    <input type="number" class="form-control" name="ar_customer_lists_credit" id="ar_customer_lists_credit">
                </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_contact" class="col-form-label">ผู้ติดต่อ</label>
                    <input type="text" class="form-control" name="ar_customer_lists_contact" id="ar_customer_lists_contact">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_tel" class="col-form-label">เบอร์โทร</label>
                    <input type="text" class="form-control" name="ar_customer_lists_tel" id="ar_customer_lists_tel" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_email" class="col-form-label">Email</label>
                    <input type="text" class="form-control" name="ar_customer_lists_email" id="ar_customer_lists_email">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_lineid" class="col-form-label">Line ID</label>
                    <input type="text" class="form-control" name="ar_customer_lists_lineid" id="ar_customer_lists_lineid">
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
$(document).ready(function() {

    $('.select2').select2({ width: '100%' });

    // ----- โหลดอำเภอเมื่อเลือกจังหวัด -----
    $('#other_provinces_id').on('change', function() {
        let province_id = $(this).val();

        $('#other_districts_id').html('<option value="">กำลังโหลด...</option>');
        $('#other_sub_districts_id').html('<option value="">กรุณาเลือกเขต/อำเภอก่อน</option>');

        if (province_id) {
            $.get('/get-districts/' + province_id, function(data) {
                $('#other_districts_id').empty().append('<option value="">กรุณาเลือก</option>');

                $.each(data, function(key, item) {
                    $('#other_districts_id').append(
                        `<option value="${item.other_districts_id}">
                            ${item.other_districts_name1}
                        </option>`
                    );
                });
            });
        }
    });

    // ----- โหลดตำบลเมื่อเลือกอำเภอ -----
    $('#other_districts_id').on('change', function() {
        let district_id = $(this).val();

        $('#other_sub_districts_id').html('<option value="">กำลังโหลด...</option>');

        if (district_id) {
            $.get('/get-subdistricts/' + district_id, function(data) {
                $('#other_sub_districts_id').empty().append('<option value="">กรุณาเลือก</option>');

                $.each(data, function(key, item) {
                    $('#other_sub_districts_id').append(
                        `<option value="${item.other_sub_districts_id}">
                            ${item.other_sub_districts_name1}
                        </option>`
                    );
                });
            });
        }
    });

});
</script>
@endpush