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
        <form method="POST" class="form-horizontal" action="{{ route('delivered.store') }}" enctype="multipart/form-data">
        @csrf   
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">ใบส่งมอบผลทดสอบ/ชิ้นงาน (ISO/IEC 17025)</h3></div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                <div class="form-group">
                     <label for="delivered_test_hds_date" class="col-form-label">วันที่ส่งมอบ</label>
                    <input type="date" class="form-control" 
                            name="delivered_test_hds_date" 
                            id="delivered_test_hds_date"
                            value=""
                            required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                     <label for="delivered_test_hds_docuno" class="col-form-label">เลขที่</label>
                    <input type="text" class="form-control" 
                            name="delivered_test_hds_docuno" 
                            id="delivered_test_hds_docuno"
                            value="{{ $newDocNo ?? '' }}"
                            readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_requestorder_hds_docuno" class="col-form-label">เลขที่อ้างอิง</label>
                    <input type="text" class="form-control" 
                            name="ar_requestorder_hds_docuno" 
                            id="ar_requestorder_hds_docuno" 
                            value="{{$hd->ar_requestorder_hds_docuno}}"
                            readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="delivered_test_hds_contact" class="col-form-label">ผู้ติดต่อ</label>
                    <input type="text" class="form-control" 
                            name="delivered_test_hds_contact" 
                            id="delivered_test_hds_contact"
                            value="{{$hd->ar_requestorder_hds_contact}}"
                            readonly>
                </div>
            </div>
        </div>
        <div class="row mt-2">               
            <div class="col-3">
                <div class="form-group">
                    <label for="delivered_test_hds_customer" class="col-form-label">ชื่อบริษัท</label>
                     <input type="text" class="form-control" 
                            name="delivered_test_hds_customer" 
                            id="delivered_test_hds_customer"
                            value="{{$hd->ar_requestorder_hds_customer}}"
                            readonly>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ar_requestorder_statuses_id" class="col-form-label">ประเภทการส่งมอบ</label>
                    <select class="form-control" name="ar_requestorder_statuses_id">
                        <option value="0">กรุณาเลือก</option>
                        <option value="8">ส่งมอบผลทดสอบเรียบร้อย</option>
                        <option value="9">ส่งคืนชิ้นงานไม่ตรงสเปค</option>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="delivered_test_hds_channel" class="col-form-label">ช่องทางการส่งมอบ</label>
                    <input type="text" class="form-control" 
                            name="delivered_test_hds_channel" 
                            id="delivered_test_hds_channel"
                            value="">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="contact_channels" class="col-form-label">ช่องทางการติดต่อ</label>
                    <input type="text" class="form-control" 
                            name="contact_channels" 
                            id="contact_channels"
                            value="">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="shipping_address" class="col-form-label">ที่อยู่จัดส่ง</label>
                    <input type="text" class="form-control" 
                            name="shipping_address" 
                            id="shipping_address"
                            value="">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="delivered_test_hds_remark" class="col-form-label">หมายเหตุ</label>
                    <input type="text" class="form-control" 
                            name="delivered_test_hds_remark" 
                            id="delivered_test_hds_remark"
                            value="">
                </div>
            </div>
        </div>
        <br>
        <div class="row mt-2">
            <div class="col-12" style="text-align: right;">
                <a href="javascript:void(0);" class="btn btn-secondary" id="addRowBtn">เพิ่มรายการ</a>
            </div>
            <hr>
            <table class="table table-bordered dt-responsive nowrap w-100 text-center">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 50%">รายละเอียดเพิ่มเติม</th>
                        <th style="width: 10%">จำนวน</th>
                        <th style="width: 10%">สภาพภายนอก</th>
                        <th style="width: 10%">ผลการประเมิน</th>
                        <th style="width: 5%"></th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>       
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
<div class="card">
    <div class="card-body">
        <h3 class="card-title">เอกสารส่งมอบ</h3>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th>วันที่</th>
                        <th>เลขที่</th>
                        <th>รายละเอียด</th>
                        <th>จำนวน</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dehd as $item)
                        <tr>
                            <td>{{$item->delivered_test_hds_date}}</td>
                            <td>{{$item->delivered_test_hds_docuno}}</td>
                            <td>{{$item->delivered_test_dts_remark}}</td>
                            <td>{{$item->delivered_test_dts_qty}}</td>
                            <td>
                                <a href="{{ route('delivered-test.print', $item->delivered_test_hds_id) }}" target="_blank" class="btn btn-success">
                                    <i class="mdi mdi-printer me-1"></i> พิมพ์เอกสาร
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection
@push('scriptjs')
<script>
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
                <input type="hidden" name="delivered_test_dts_listno[]" class="row-number-hidden"/>
            </td>           
            <td>
                <textarea class="form-control" name="delivered_test_dts_remark[]" rows="1" placeholder="เพิ่มเติม"></textarea>
            </td>
            <td>
                 <input type="text" name="delivered_test_dts_qty[]" class="form-control"/>
            </td>
            <td>
                <select class="form-control" name="delivered_test_dts_type[]">
                    <option value="ปกติ (No Defects)">ปกติ (No Defects)</option>
                    <option value="ไม่ปกติ (Defects)">ไม่ปกติ (Defects)</option>
                </select>
            </td>
             <td>
                <select class="form-control" name="delivered_test_dts_status[]">
                    <option value="ผ่าน (Pass)">ผ่าน (Pass)</option>
                    <option value="ไม่ผ่าน (Fail)">ไม่ผ่าน (Fail)</option>
                </select>
            </td>           
            <td>
                <button type="button" class="btn btn-danger btn-sm deleteRow">ลบ</button>
            </td>
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