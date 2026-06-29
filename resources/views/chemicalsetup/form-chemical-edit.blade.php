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
        <form method="POST" class="form-horizontal" action="{{ route('chemicallists.update',$hd->chemical_lists_id) }}" enctype="multipart/form-data">
        @csrf    
        @method('PUT')        
        <h3 class="card-title">รายชื่อเคมี</h3>        
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="chemical_lists_name" class="col-form-label">วัสดุ (Material)</label>
                    <input type="text" class="form-control" name="chemical_lists_name" id="chemical_lists_name" value="{{$hd->chemical_lists_name}}" required>
                </div>
            </div> 
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_lists_refcode" class="col-form-label">รหัสอ้างอิง</label>
                    <input type="text" class="form-control" name="chemical_lists_refcode" id="chemical_lists_refcode" value="{{$hd->chemical_lists_refcode}}">
                </div>
            </div> 
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_lists_grade" class="col-form-label">Grade</label>
                    <input type="text" class="form-control" name="chemical_lists_grade" id="chemical_lists_grade" value="{{$hd->chemical_lists_grade}}">
                </div>
            </div> 
        </div> 
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_lists_density" class="col-form-label">Density(g/cc)</label>
                   <input 
                        type="text" 
                        class="form-control" 
                        name="chemical_lists_density" 
                        id="chemical_lists_density" 
                        pattern="^\d+(\.\d+)?$" 
                        title="กรอกได้เฉพาะตัวเลข หรือเลขทศนิยมเท่านั้น"
                        value="{{$hd->chemical_lists_density}}">
                </div>
            </div> 
            <div class="col-6">
                <div class="form-group">
                    <label for="chemical_lists_remark" class="col-form-label">ชื่อเคมี/องค์ประกอบ</label>
                    <input type="text" class="form-control" name="chemical_lists_remark" id="chemical_lists_remark" value="{{$hd->chemical_lists_remark}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_groups_id" class="col-form-label">Group</label>
                    <select id="chemical_groups_id" name="chemical_groups_id" class="form-control" required>
                        <option value="">กรุณาเลือก</option>
                        @foreach ($groups as $item)
                            <option value="{{ $item->chemical_groups_id }}"
                                {{ $item->chemical_groups_id == $hd->chemical_groups_id ? 'selected' : '' }}>
                                {{ $item->chemical_groups_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_funtions_id" class="col-form-label">Function (หลัก)</label>
                    <select id="chemical_funtions_id" name="chemical_funtions_id" class="form-control" required>
                        <option value="">กรุณาเลือก</option>
                        @foreach ($funtions as $item)
                            <option value="{{ $item->chemical_funtions_id }}"
                                {{ $item->chemical_funtions_id == $hd->chemical_funtions_id ? 'selected' : '' }}>
                                {{ $item->chemical_funtions_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_funtions_id_1" class="col-form-label">Function (รอง)</label>
                    <select id="chemical_funtions_id_1" name="chemical_funtions_id_1" class="form-control">
                        <option value="">กรุณาเลือก</option>
                        @foreach ($funtions as $item)
                            <option value="{{ $item->chemical_funtions_id }}"
                                {{ $item->chemical_funtions_id == $hd->chemical_funtions_id_1 ? 'selected' : '' }}>
                                {{ $item->chemical_funtions_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="chemical_lists_detail" class="col-form-label">Detail</label>
                    <input type="text" class="form-control" name="chemical_lists_detail" id="chemical_lists_detail" value="{{$hd->chemical_lists_detail}}">
                </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_lists_tempstart" class="col-form-label">Temp</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        name="chemical_lists_tempstart" 
                        id="chemical_lists_tempstart" 
                        pattern="^\d+(\.\d+)?$" 
                        title="กรอกได้เฉพาะตัวเลข หรือเลขทศนิยมเท่านั้น" 
                        value="{{$hd->chemical_lists_tempstart}}" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_lists_tempend" class="col-form-label">Temp</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        name="chemical_lists_tempend" 
                        id="chemical_lists_tempend" 
                        pattern="^\d+(\.\d+)?$" 
                        title="กรอกได้เฉพาะตัวเลข หรือเลขทศนิยมเท่านั้น" 
                        value="{{$hd->chemical_lists_tempend}}" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="chemical_lists_substitute" class="col-form-label">Substitute</label>
                    <input type="text" class="form-control" name="chemical_lists_substitute" id="chemical_lists_substitute" value="{{$hd->chemical_lists_substitute}}">
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-9">
                <div class="form-group">
                    <label for="chemical_lists_academic" class="col-form-label">เหตุผลทางวิชาการ(Academic Rationale)</label>
                    <input type="text" class="form-control" name="chemical_lists_academic" id="chemical_lists_academic" value="{{$hd->chemical_lists_academic}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_lists_file1" class="col-form-label">ไฟล์แนบ(SDS)</label>
                    <input type="file" class="form-control" name="chemical_lists_file1" >
                    @if($hd->chemical_lists_file1)
                        <a href="{{asset($hd->chemical_lists_file1)}}" target=”_blank”>
                            <i class="fas fa-file"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">          
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_lists_file2" class="col-form-label">ไฟล์แนบ(หากมี)</label>
                    <input type="file" class="form-control" name="chemical_lists_file2" >
                    @if($hd->chemical_lists_file2)
                        <a href="{{asset($hd->chemical_lists_file2)}}" target=”_blank”>
                            <i class="fas fa-file"></i>
                        </a>
                    @endif
                </div>
            </div>  
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_lists_file3" class="col-form-label">Link</label>
                    <input type="text" class="form-control" name="chemical_lists_file3" id="chemical_lists_file3" value="{{$hd->chemical_lists_file3}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_lists_file4" class="col-form-label">Link</label>
                    <input type="text" class="form-control" name="chemical_lists_file4" id="chemical_lists_file4" value="{{$hd->chemical_lists_file4}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_lists_department" class="col-form-label">แผนก/หน่วยงาน</label>
                    <input type="text" class="form-control" name="chemical_lists_department" id="chemical_lists_department" value="{{$hd->chemical_lists_department}}">
                </div>
            </div>
        </div>
         <div class="row">         
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_lists_substance" class="col-form-label">ชนิดวัตถุอันตราย</label>
                    <input type="text" class="form-control" name="chemical_lists_substance" id="chemical_lists_substance" value="{{$hd->chemical_lists_substance}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_lists_vendor" class="col-form-label">ผู้ผลิต/จำหน่าย</label>
                    <input type="text" class="form-control" name="chemical_lists_vendor" id="chemical_lists_vendor" value="{{$hd->chemical_lists_vendor}}">
                </div>
            </div>
             <div class="col-3">
                <div class="form-group">
                    <label for="chemical_lists_refdocuno" class="col-form-label">เลขทะเบียน SDS</label>
                    <input type="text" class="form-control" name="chemical_lists_refdocuno" id="chemical_lists_refdocuno" value="{{$hd->chemical_lists_refdocuno}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_lists_bom" class="col-form-label">สูตรเคมี</label>
                    <input type="text" class="form-control" name="chemical_lists_bom" id="chemical_lists_bom" value="{{$hd->chemical_lists_bom}}">
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                 <div class="col-12" style="text-align: right;">
                    <a href="javascript:void(0);" class="btn btn-secondary" id="addRowBtn">เพิ่มรายการ</a>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center">
                        <thead>
                            <tr>
                                <th style="width: 5%">No.</th>
                                <th style="width: 38%">ชื่อสาร</th>
                                <th style="width: 15%">เลขทะเบียน CAS</th>
                                <th style="width: 15%">เลขทะเบียน EC</th>
                                <th style="width: 15%">% โดยน้ำหนัก</th>
                                <th style="width: 12%">การกระทำ</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach ($dt as $key => $item)
                                <tr>
                                    <td>
                                        <span class="row-number">{{ $key + 1 }}</span>
                                        <input type="hidden" name="chemical_subs_listno[]" class="row-number-hidden" value="{{ $item->chemical_subs_listno }}"/>
                                    </td>
                                    <td>
                                        <input class="form-control" name="chemical_subs_name[]" value="{{$item->chemical_subs_name}}">
                                    </td>
                                    <td>
                                        <input class="form-control" name="chemical_subs_casno[]" value="{{$item->chemical_subs_casno}}">
                                    </td>
                                    <td>
                                        <input class="form-control" name="chemical_subs_ecno[]" value="{{$item->chemical_subs_ecno}}">
                                    </td>
                                    <td>
                                        <input class="form-control" name="chemical_subs_qty[]" value="{{$item->chemical_subs_qty}}">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm deleteRow">ลบ</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>       
                    </table>
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
 $('#chemical_groups_id').on('change', function () {
        let groupId = $(this).val();

        $('#chemical_funtions_id').html('<option value="">กำลังโหลด...</option>');
        $('#chemical_funtions_id_1').html('<option value="">กำลังโหลด...</option>');
        if(groupId){
            $.ajax({
                url: '/chemical/functions/' + groupId,
                type: 'GET',
                success: function(res){
                    $('#chemical_funtions_id').empty();
                    $('#chemical_funtions_id').append('<option value="">กรุณาเลือก</option>');
                    
                    $.each(res, function(key, item){
                        $('#chemical_funtions_id').append(
                            '<option value="'+item.chemical_funtions_id+'">'+item.chemical_funtions_name+'</option>'
                        );
                    });
                    $('#chemical_funtions_id_1').empty();
                    $('#chemical_funtions_id_1').append('<option value="">กรุณาเลือก</option>');
                    
                    $.each(res, function(key, item){
                        $('#chemical_funtions_id_1').append(
                            '<option value="'+item.chemical_funtions_id+'">'+item.chemical_funtions_name+'</option>'
                        );
                    });
                }
            });
        } else {
            $('#chemical_funtions_id').html('<option value="">กรุณาเลือก</option>');
            $('#chemical_funtions_id_1').html('<option value="">กรุณาเลือก</option>');
        }
    });

document.querySelectorAll('#chemical_lists_tempstart, #chemical_lists_tempend,#chemical_lists_density')
    .forEach(el => {
        el.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9.]/g, '');     // ลบทุกอย่างที่ไม่ใช่ตัวเลขหรือจุด
            this.value = this.value.replace(/(\..*)\./g, '$1');   // ห้ามมีจุดทศนิยมมากกว่า 1 จุด
        });
    });

/* ===================== UPDATE ROW NUMBER ===================== */
function updateRowNumbers() {
    const rows = document.querySelectorAll('#tableBody tr');
    rows.forEach((row, index) => {
        const displayNo = index + 1;
        const numberSpan = row.querySelector('.row-number');
        const hiddenInput = row.querySelector('.row-number-hidden');
        
        if(numberSpan) numberSpan.textContent = displayNo;
        if(hiddenInput) hiddenInput.value = displayNo;
    });
}

/* ===================== GLOBAL ===================== */
let pieChart = null;

/* ===================== ADD ROW ===================== */
document.getElementById('addRowBtn').addEventListener('click', function () {
    const tbody = document.getElementById('tableBody');
    const newRow = document.createElement('tr');
    
    newRow.innerHTML = `
        <td>
            <span class="row-number"></span>
            <input type="hidden" name="chemical_subs_listno[]" class="row-number-hidden"/>
        </td>
        <td><input type="text" name="chemical_subs_name[]" class="form-control"/></td>
        <td><input type="text" name="chemical_subs_casno[]" class="form-control"/></td>
        <td><input type="text" name="chemical_subs_ecno[]" class="form-control"/></td>
        <td><input type="text" name="chemical_subs_qty[]" class="form-control"/></td>
        <td><button type="button" class="btn btn-danger btn-sm deleteRow">ลบ</button></td>
    `;

    tbody.appendChild(newRow);
    updateRowNumbers();
});

/* ===================== DELETE ROW ===================== */
document.getElementById('tableBody').addEventListener('click', function (e) {
    if (e.target.classList.contains('deleteRow')) {
        e.target.closest('tr').remove();
        updateRowNumbers();
    }
});
</script>
@endpush