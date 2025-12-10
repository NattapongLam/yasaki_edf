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
            <div class="col-12 col-md-6"><h3 class="card-title">ใบเสนอราคา</h3></div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_quotation_hds_date" class="col-form-label">วันที่</label>
                   <input type="date" class="form-control" 
                            name="ar_quotation_hds_date" 
                            id="ar_quotation_hds_date"
                            value="{{ old('ar_quotation_hds_date', now()->format('Y-m-d')) }}" 
                            required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_quotation_hds_docuno" class="col-form-label">เลขที่</label>
                   <input type="text" class="form-control" 
                            name="ar_quotation_hds_docuno" 
                            id="ar_quotation_hds_docuno" 
                            readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="acc_typevats_id" class="col-form-label">ประเภทภาษี</label>
                    <select class="form-select" name="acc_typevats_id" id="acc_typevats_id" required>
                        <option value="">กรุณาเลือก</option>
                        @foreach ($typevats as $item)
                            <option value="{{$item->acc_typevats_id}}">{{$item->acc_typevats_code}}</option>
                        @endforeach
                    </select>
                </div> 
            </div>
             <div class="col-3">
                <div class="form-group">
                    <label for="acc_currencies_id" class="col-form-label">สกุลเงิน</label>
                    <select class="form-select" name="acc_currencies_id" id="acc_currencies_id" required>
                        <option value="">กรุณาเลือก</option>
                        @foreach ($currencys as $item)
                            <option value="{{$item->acc_currencies_id}}">{{$item->acc_currencies_name}}</option>
                        @endforeach
                    </select>
                </div> 
            </div>
        </div> 
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="ar_customer_lists_id" class="col-form-label">รหัสลูกค้า</label>
                    <select class="form-select" name="ar_customer_lists_id" id="ar_customer_lists_id" required>
                        <option value="">กรุณาเลือก</option>
                        @foreach ($customers as $item)
                            <option value="{{$item->ar_customer_lists_id}}"
                                data-code="{{ $item->ar_customer_lists_code }}"
                                data-name="{{ $item->ar_customer_lists_name1 }}"
                                data-address="{{ $item->ar_customer_lists_address1 }}"
                                data-country="{{ $item->other_countries_id }}"
                                data-province="{{ $item->other_provinces_id }}"
                                data-district="{{ $item->other_districts_id }}"
                                data-subdistrict="{{ $item->other_sub_districts_id }}"
                                data-contact="{{ $item->ar_customer_lists_contact }}"
                                data-tel="{{ $item->ar_customer_lists_tel }}"
                                data-email="{{ $item->ar_customer_lists_email }}"
                                data-credit="{{ $item->ar_customer_lists_credit }}"
                                data-taxid="{{ $item->ar_customer_lists_taxid }}">                             
                                {{$item->ar_customer_lists_code}}/{{$item->ar_customer_lists_name1}}
                            </option>
                        @endforeach
                    </select>
                    <input class="form-control" type="hidden" name="ar_customer_lists_code" id="ar_customer_lists_code">
                    <input class="form-control" type="hidden" name="ar_customer_lists_name" id="ar_customer_lists_name">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="ar_customer_lists_address" class="col-form-label">ที่อยู่</label>
                    <input class="form-control" type="text" name="ar_customer_lists_address" id="ar_customer_lists_address">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_contact" class="col-form-label">ผู้ติดต่อ</label>
                    <input class="form-control" type="text" name="ar_customer_lists_contact" id="ar_customer_lists_contact">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_tel" class="col-form-label">เบอร์โทร</label>
                    <input class="form-control" type="text" name="ar_customer_lists_tel" id="ar_customer_lists_tel">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_email" class="col-form-label">Email</label>
                    <input class="form-control" type="text" name="ar_customer_lists_email" id="ar_customer_lists_email">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_credit" class="col-form-label">วันเครดิต</label>
                    <input class="form-control" type="text" name="ar_customer_lists_credit" id="ar_customer_lists_credit">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_customer_lists_taxid" class="col-form-label">เลขประจำตัวผู้เสียภาษี</label>
                    <input class="form-control" type="text" name="ar_customer_lists_taxid" id="ar_customer_lists_taxid">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="acc_discount_id" class="col-form-label">ประเภทส่วนลด</label>
                    <select class="form-select" name="acc_discount_id" id="acc_discount_id">
                        <option value="0">กรุณาเลือก</option>
                        @foreach ($discounts as $item)
                            <option value="{{$item->acc_discount_id}}">{{$item->acc_discount_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="acc_discount_qty" class="col-form-label">ส่วนลดหัวบิล</label>
                    <input class="form-control" type="text" name="acc_discount_qty" id="acc_discount_qty">
                </div>
            </div>
        </div>  
        <div class="row">
            <div class="col-12" style="text-align: right;">
                <a href="javascript:void(0);" class="btn btn-secondary" id="addRowBtn">เพิ่มรายการ</a>
            </div>
            <hr>
            <table class="table table-bordered dt-responsive nowrap w-100 text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>สินค้า</th>
                        <th>จำนวน</th>
                        <th>ราคาต่อหน่วย</th>
                        <th>ส่วนลด</th>
                        <th>ยอดรวม</th>
                        <th>หมายเหตุ</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>       
            </table>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">ฐานภาษี</p>
                        <h4 class="mb-0">$16.2</h4>
                    </div>
                    <div class="flex-shrink-0 align-self-center">
                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                            </span>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">ภาษี</p>
                        <h4 class="mb-0">$16.2</h4>
                    </div>
                    <div class="flex-shrink-0 align-self-center">
                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                            </span>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">ส่วนลด</p>
                        <h4 class="mb-0">$16.2</h4>
                    </div>
                    <div class="flex-shrink-0 align-self-center">
                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                            </span>
                    </div>
                    </div>
                </div>
            </div> 
            <div class="col-3">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">สุทธิ</p>
                        <h4 class="mb-0">$16.2</h4>
                    </div>
                    <div class="flex-shrink-0 align-self-center">
                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                            </span>
                    </div>
                    </div>
                </div>
            </div>                      
        </div>
        <div class="row">
            <div class="col-12">
                <label for="ar_quotation_hds_remark" class="col-form-label">หมายเหตุ</label>
                <textarea class="form-control" name="ar_quotation_hds_remark" id="ar_quotation_hds_remark"></textarea>
            </div>
        </div>                   
    </div>
</div>
</div>
@endsection
@push('scriptjs')
<script>
    function loadDocNo() {
        let docDate = $("#ar_quotation_hds_date").val();

        if (docDate) {
            $.ajax({
                url: "{{ route('quotation.runno') }}",
                type: "GET",
                data: { date: docDate },
                success: function (res) {
                    $("#ar_quotation_hds_docuno").val(res.docno);
                }
            });
        }
    }

    // ✔ ทำงานเมื่อผู้ใช้เปลี่ยนวันที่
    $("#ar_quotation_hds_date").on('change', function () {
        loadDocNo();
    });

    // ✔ ทำงานทันทีเมื่อเปิดฟอร์ม
    $(document).ready(function () {
        loadDocNo();
    });
$("#ar_customer_lists_id").on("change", function () {
        let code = $(this).find(':selected').data('code');
        let name = $(this).find(':selected').data('name');
        let address = $(this).find(":selected").data("address");
        let country = $(this).find(":selected").data("country");
        let province = $(this).find(":selected").data("province");
        let district = $(this).find(":selected").data("district");
        let subdistrict = $(this).find(":selected").data("subdistrict");
        let credit = $(this).find(":selected").data("credit");
        let tel = $(this).find(":selected").data("tel");
        let email = $(this).find(":selected").data("email");
        let contact = $(this).find(":selected").data("contact");
        let taxid = $(this).find(":selected").data("taxid");

        $("#ar_customer_lists_code").val(code);
        $("#ar_customer_lists_name").val(name);
        $("#ar_customer_lists_credit").val(credit);
        $("#ar_customer_lists_tel").val(tel);
        $("#ar_customer_lists_email").val(email);
        $("#ar_customer_lists_contact").val(contact);
        $("#ar_customer_lists_taxid").val(taxid);
        $.ajax({ 
            url: "{{ route('customer.addressText') }}",
            type: "GET",
            data: {
                address_name: address,
                country_id: country,
                province_id: province,
                district_id: district,
                subdistrict_id: subdistrict
            },
            success: function(res) {
                $("#ar_customer_lists_address").val(res.address);
            }
        });
    });
function updateRowNumbers() {
    const rows = document.querySelectorAll('#tableBody tr');
    rows.forEach((row, index) => {
        row.querySelector('.row-number').textContent = index + 1;
        row.querySelector('.row-number-hidden').value = index + 1;
    });
}
document.getElementById('addRowBtn').addEventListener('click', function () {
        const tbody = document.getElementById('tableBody');

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <span class="row-number"></span>
                <input type="hidden" name="machine_checksheet_dt_listno[]" class="row-number-hidden"/>
            </td>
            <td><input type="text" name="machine_checksheet_dt_remark[]" class="form-control"/></td>
            <td><input type="text" name="machine_checksheet_dt_remark[]" class="form-control"/></td>
            <td><input type="text" name="machine_checksheet_dt_remark[]" class="form-control"/></td>
            <td><input type="text" name="machine_checksheet_dt_remark[]" class="form-control"/></td>
            <td><input type="text" name="machine_checksheet_dt_remark[]" class="form-control"/></td>
            <td><input type="text" name="machine_checksheet_dt_remark[]" class="form-control"/></td>
            <td><button type="button" class="btn btn-danger btn-sm deleteRow">ลบ</button></td>
        `;

        tbody.appendChild(newRow);
        updateRowNumbers(); 
});
document.getElementById('tableBody').addEventListener('click', function (e) {
    if (e.target.classList.contains('deleteRow')) {
        e.target.closest('tr').remove();
        updateRowNumbers(); // อัปเดตลำดับหลังจากลบ
    }
});
</script>
@endpush