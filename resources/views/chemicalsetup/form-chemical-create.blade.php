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
        <form method="POST" class="form-horizontal" action="{{ route('chemicallists.store') }}" enctype="multipart/form-data">
        @csrf       
        <h3 class="card-title">รายชื่อเคมี</h3>        
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="chemical_lists_name" class="col-form-label">วัสดุ (Material)</label>
                    <input type="text" class="form-control" name="chemical_lists_name" id="chemical_lists_name" required>
                </div>
            </div> 
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_lists_refcode" class="col-form-label">รหัสอ้างอิง</label>
                    <input type="text" class="form-control" name="chemical_lists_refcode" id="chemical_lists_refcode">
                </div>
            </div> 
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_lists_grade" class="col-form-label">Grade</label>
                    <input type="text" class="form-control" name="chemical_lists_grade" id="chemical_lists_grade">
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
                        title="กรอกได้เฉพาะตัวเลข หรือเลขทศนิยมเท่านั้น">
                </div>
            </div> 
            <div class="col-6">
                <div class="form-group">
                    <label for="chemical_lists_remark" class="col-form-label">ชื่อเคมี/องค์ประกอบ</label>
                    <input type="text" class="form-control" name="chemical_lists_remark" id="chemical_lists_remark">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_groups_id" class="col-form-label">Group</label>
                    <select id="chemical_groups_id" name="chemical_groups_id" class="form-control" required>
                        <option value="">กรุณาเลือก</option>
                        @foreach ($groups as $item)
                            <option value="{{ $item->chemical_groups_id }}">{{ $item->chemical_groups_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_funtions_id" class="col-form-label">Function</label>
                    <select id="chemical_funtions_id" name="chemical_funtions_id" class="form-control" required>
                        <option value="">กรุณาเลือก</option>
                    </select>
                </div>
            </div>
            <div class="col-9">
                <div class="form-group">
                    <label for="chemical_lists_detail" class="col-form-label">Detail</label>
                    <input type="text" class="form-control" name="chemical_lists_detail" id="chemical_lists_detail">
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
                        required>
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
                        required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="chemical_lists_substitute" class="col-form-label">Substitute</label>
                    <input type="text" class="form-control" name="chemical_lists_substitute" id="chemical_lists_substitute">
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="chemical_lists_academic" class="col-form-label">เหตุผลทางวิชาการ(Academic Rationale)</label>
                    <input type="text" class="form-control" name="chemical_lists_academic" id="chemical_lists_academic">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_lists_file1" class="col-form-label">ไฟล์แนบ(หากมี)</label>
                    <input type="file" class="form-control" name="chemical_lists_file1" >
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_lists_file2" class="col-form-label">ไฟล์แนบ(หากมี)</label>
                    <input type="file" class="form-control" name="chemical_lists_file2" >
                </div>
            </div>  
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_lists_file3" class="col-form-label">Link</label>
                    <input type="text" class="form-control" name="chemical_lists_file3" id="chemical_lists_file3">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="chemical_lists_file4" class="col-form-label">Link</label>
                    <input type="text" class="form-control" name="chemical_lists_file4" id="chemical_lists_file4">
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
                }
            });
        } else {
            $('#chemical_funtions_id').html('<option value="">กรุณาเลือก</option>');
        }
    });
document.querySelectorAll('#chemical_lists_tempstart, #chemical_lists_tempend,#chemical_lists_density')
    .forEach(el => {
        el.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9.]/g, '');     // ลบทุกอย่างที่ไม่ใช่ตัวเลขหรือจุด
            this.value = this.value.replace(/(\..*)\./g, '$1');   // ห้ามมีจุดทศนิยมมากกว่า 1 จุด
        });
    });
</script>
@endpush