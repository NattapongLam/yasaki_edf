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
        <form action="{{ route('customers.storeSurvey') }}" method="POST">
        @csrf
        {{-- ส่ง ID ของลูกค้าไปกับฟอร์ม --}}
        <input type="hidden" name="ar_customer_lists_id" value="{{ $hd->ar_customer_lists_id ?? '' }}">
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">แบบประเมินความพึงพอใจลูกค้า</h3></div> 
        </div> 
        <div class="row mt-2">
            <h6>
                <strong>
                    ส่วนที่ 1: ข้อมูลทั่วไปของลูกค้า (General Information)
                </strong>               
            </h6>
            <div class="col-3">
                <label class="form-label">ชื่อบริษัท/หน่วยงานลูกค้า</label>
                <input class="form-control" name="ar_customer_lists_name" value="{{$hd->ar_customer_lists_name1}}">
            </div>
            <div class="col-3">
                <label class="form-label">ชื่อผู้ประเมิน</label>
                <input class="form-control" name="ar_customer_lists_contact" value="{{$hd->ar_customer_lists_contact}}">
            </div>
            <div class="col-3">
                <label class="form-label">เบอร์โทรศัพท์ติดต่อ</label>
                <input class="form-control" name="ar_customer_lists_tel" value="{{$hd->ar_customer_lists_tel}}">
            </div>
            <div class="col-3">
                <label class="form-label">วันที่ประเมิน</label>
                <input class="form-control" type="date" name="customer_satisfaction_surveys_date" value="">
            </div>
        </div>     
        <div class="row mt-2">
            <h6>
                <strong>
                ส่วนที่ 2: รายการประเมินความพึงพอใจ (ประเมิน 5 ระดับ: 5 = มากที่สุด, 4 = มาก, 3 = ปานกลาง, 2 = น้อย, 1 = ต้องปรับปรุง)
                </strong>               
            </h6>
        </div>
        <div class="row mt-2">
            <h6>
                <strong>
                1.ด้านคุณภาพสินค้า / บริการ / รายงานผล (Quality of Service & Results)
                </strong>               
            </h6>
            <div class="col-4">
                <label class="form-label">ความถูกต้อง แม่นยำ และความน่าเชื่อถือของผลการทดสอบ/ผลงาน</label>
                <select class="form-select" name="quality_1">
                    <option value="5">มากที่สุด</option>
                    <option value="4">มาก</option>
                    <option value="3">ปานกลาง</option>
                    <option value="2">น้อย</option>
                    <option value="1">ต้องปรับปรุง</option>
                </select>
            </div>
            <div class="col-4">
                <label class="form-label">ความสมบูรณ์ ชัดเจน ของรายงานผลและเอกสารประกอบ</label>
                <select class="form-select" name="quality_2">
                    <option value="5">มากที่สุด</option>
                    <option value="4">มาก</option>
                    <option value="3">ปานกลาง</option>
                    <option value="2">น้อย</option>
                    <option value="1">ต้องปรับปรุง</option>
                </select>
            </div>
            <div class="col-4">
                <label class="form-label">การรักษาความลับและข้อมูลสิทธิประโยชน์ของลูกค้า (การปฏิบัติตามมาตรฐาน ISO/IEC 17025)</label>
                <select class="form-select" name="quality_3">
                    <option value="5">มากที่สุด</option>
                    <option value="4">มาก</option>
                    <option value="3">ปานกลาง</option>
                    <option value="2">น้อย</option>
                    <option value="1">ต้องปรับปรุง</option>
                </select>
            </div>
        </div>
        <div class="row mt-2">
            <h6>
                <strong>
                2.ด้านการส่งมอบงานและการตรงต่อเวลา (Delivery & Timeliness)
                </strong>               
            </h6>
            <div class="col-4">
                <label class="form-label">การส่งมอบงาน/รายงานผลตรงตามกำหนดเวลาที่นัดหมาย</label>
                <select class="form-select" name="delivery_1">
                    <option value="5">มากที่สุด</option>
                    <option value="4">มาก</option>
                    <option value="3">ปานกลาง</option>
                    <option value="2">น้อย</option>
                    <option value="1">ต้องปรับปรุง</option>
                </select>
            </div>
            <div class="col-4">
                <label class="form-label">การแจ้งความคืบหน้าของงานกรณีเกิดเหตุล่าช้าหรือเหตุขัดข้อง</label>
                <select class="form-select" name="delivery_2">
                    <option value="5">มากที่สุด</option>
                    <option value="4">มาก</option>
                    <option value="3">ปานกลาง</option>
                    <option value="2">น้อย</option>
                    <option value="1">ต้องปรับปรุง</option>
                </select>
            </div>
            <div class="col-4">
                <label class="form-label">สภาพความสมบูรณ์ของสินค้า/ชิ้นงาน/บรรจุภัณฑ์เมื่อส่งมอบ</label>
                <select class="form-select" name="delivery_3">
                    <option value="5">มากที่สุด</option>
                    <option value="4">มาก</option>
                    <option value="3">ปานกลาง</option>
                    <option value="2">น้อย</option>
                    <option value="1">ต้องปรับปรุง</option>
                </select>
            </div>
        </div>
        <div class="row mt-2">
            <h6>
                <strong>
                3.ด้านบุคลากรและเจ้าหน้าที่ผู้ให้บริการ (Personnel & Service Staff)
                </strong>               
            </h6>
            <div class="col-4">
                <label class="form-label">ความรู้ ความชำนาญ และความสามารถในการตอบข้อซักถามทางเทคนิค</label>
                <select class="form-select" name="personnel_1">
                    <option value="5">มากที่สุด</option>
                    <option value="4">มาก</option>
                    <option value="3">ปานกลาง</option>
                    <option value="2">น้อย</option>
                    <option value="1">ต้องปรับปรุง</option>
                </select>
            </div>
            <div class="col-4">
                <label class="form-label">ความสุภาพ อ่อนน้อม และความพร้อมในการให้บริการ</label>
                <select class="form-select" name="personnel_2">
                    <option value="5">มากที่สุด</option>
                    <option value="4">มาก</option>
                    <option value="3">ปานกลาง</option>
                    <option value="2">น้อย</option>
                    <option value="1">ต้องปรับปรุง</option>
                </select>
            </div>
            <div class="col-4">
                <label class="form-label">ความตรงต่อเวลาและการปฏิบัติตามข้อตกลงที่ให้ไว้กับลูกค้า</label>
                <select class="form-select" name="personnel_3">
                    <option value="5">มากที่สุด</option>
                    <option value="4">มาก</option>
                    <option value="3">ปานกลาง</option>
                    <option value="2">น้อย</option>
                    <option value="1">ต้องปรับปรุง</option>
                </select>
            </div>
        </div> 
        <div class="row mt-2">
            <h6>
                <strong>
                4.ด้านการประสานงานและการแก้ไขปัญหา (Communication & Complaint Handling)
                </strong>               
            </h6>
            <div class="col-4">
                <label class="form-label">ความสะดวกและรวดเร็วในการติดต่อสื่อสาร (โทรศัพท์/อีเมล/Line)</label>
                <select class="form-select" name="communication_1">
                    <option value="5">มากที่สุด</option>
                    <option value="4">มาก</option>
                    <option value="3">ปานกลาง</option>
                    <option value="2">น้อย</option>
                    <option value="1">ต้องปรับปรุง</option>
                </select>
            </div>
            <div class="col-4">
                <label class="form-label">ความรวดเร็วและความเหมาะสมในการแก้ไขปัญหาหรือข้อร้องเรียน</label>
                <select class="form-select" name="communication_2">
                    <option value="5">มากที่สุด</option>
                    <option value="4">มาก</option>
                    <option value="3">ปานกลาง</option>
                    <option value="2">น้อย</option>
                    <option value="1">ต้องปรับปรุง</option>
                </select>
            </div>
            <div class="col-4">
                <label class="form-label">การให้ข้อมูลราคาและเงื่อนไขการให้บริการอย่างโปร่งใส</label>
                <select class="form-select" name="communication_3">
                    <option value="5">มากที่สุด</option>
                    <option value="4">มาก</option>
                    <option value="3">ปานกลาง</option>
                    <option value="2">น้อย</option>
                    <option value="1">ต้องปรับปรุง</option>
                </select>
            </div>
        </div>
        <div class="row mt-2">
            <h6>
                <strong>
                ส่วนที่ 3: ข้อเสนอแนะเพื่อการปรับปรุง (Suggestions for Continual Improvement)
                </strong>               
            </h6>
            <div class="col-12">
                <label class="form-label">ข้อคิดเห็นเพิ่มเติมเกี่ยวกับการพัฒนาคุณภาพการให้บริการ</label>
                <textarea class="form-control" name="suggestions_1"></textarea>
            </div>
            <div class="col-12">
                <label class="form-label">หัวข้อที่ลูกค้าต้องการให้ปรับปรุงมากที่สุด</label>
                <textarea class="form-control" name="suggestions_2"></textarea>
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
<div class="card">
    <div class="card-body">
        <h5>รายการประเมิน</h5>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>วันที่ประเมิน</th>
                    <th>1.ด้านคุณภาพสินค้า / บริการ / รายงานผล<br> (Quality of Service & Results)</th>
                    <th>2.ด้านการส่งมอบงานและการตรงต่อเวลา<br> (Delivery & Timeliness)</th>
                    <th>3.ด้านบุคลากรและเจ้าหน้าที่ผู้ให้บริการ<br> (Personnel & Service Staff)</th>
                    <th>4.ด้านการประสานงานและการแก้ไขปัญหา<br> (Communication & Complaint Handling)</th>
                    <th>ข้อคิดเห็นเพิ่มเติมเกี่ยวกับการพัฒนาคุณภาพการให้บริการ</th>
                    <th>หัวข้อที่ลูกค้าต้องการให้ปรับปรุงมากที่สุด</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $item)
                    <tr>
                        <td>{{$item->customer_satisfaction_surveys_date}}</td>
                        <td>
                            {{(($item->quality_1 + $item->quality_2 + $item->quality_3) / 15) * 100}}
                        </td>
                        <td>
                            {{(($item->delivery_1 + $item->delivery_2 + $item->delivery_3) / 15) * 100}}
                        </td>
                        <td>
                            {{(($item->personnel_1 + $item->personnel_2 + $item->personnel_3) / 15) * 100}}
                        </td>
                        <td>
                            {{(($item->communication_1 + $item->communication_2 + $item->communication_3) / 15) * 100}}
                        </td>
                        <td>{{$item->suggestions_1}}</td>
                        <td>{{$item->suggestions_2}}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->customer_satisfaction_surveys_id }}')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
@push('scriptjs')
<script>
function confirmDel(refid) {
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่ !',
        text: `คุณต้องการลบรายการนี้หรือไม่ ?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false         
    }).then(function(result) {
        if (result.value) {
            $.ajax({
                url: `{{ url('/confirmDelCustomerSurvey') }}`, // ปรับเปลี่ยน URL ตาม Route จริงของระบบท่านหากจำเป็น
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "refid": refid,               
                },         
                dataType: "json",
                success: function(data) {
                    if (data.status == true) {
                        Swal.fire({
                            title: 'สำเร็จ',
                            text: 'ยกเลิกเอกสารเรียบร้อยแล้ว',
                            icon: 'success'
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'ไม่สำเร็จ',
                            text: 'ยกเลิกเอกสารไม่สำเร็จ',
                            icon: 'error'
                        });
                    }
                },
                error: function(data) {
                    Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'ยกเลิกเอกสารไม่สำเร็จ',
                        icon: 'error'
                    });           
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
                title: 'ยกเลิก',
                text: 'โปรดตรวจสอบข้อมูลอีกครั้งเพื่อความถูกต้อง :)',
                icon: 'error'
            });
        }
    });
}
</script>
@endpush