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
        <form method="POST" class="form-horizontal" action="{{ route('machinerylists.update',$hd->machinery_lists_id) }}" enctype="multipart/form-data">
        @csrf  
        @method('PUT')     
        <div class="row">
            <div class="col-12 col-md-6"><h3 class="card-title">ทะเบียนเครื่องจักร</h3></div>
        </div> 
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="machinery_groups_id" class="col-form-label">กลุ่มเครื่องจักร</label>
                    <select class="form-select" name="machinery_groups_id" id="machinery_groups_id" required>
                        <option value="">กรุณาเลือก</option>
                            @foreach ($gb as $item)
                                <option value="{{$item->machinery_groups_id}}"
                                    {{ $item->machinery_groups_id == $hd->machinery_groups_id ? 'selected' : '' }}>
                                    {{$item->machinery_groups_name}}
                                </option>
                            @endforeach
                    </select>
                </div>               
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="machinery_lists_code" class="col-form-label">รหัสเครื่องจักร</label>
                    <input type="text" class="form-control" name="machinery_lists_code" value="{{$hd->machinery_lists_code}}" required>
                </div>               
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="machinery_lists_name1" class="col-form-label">ชื่อเครื่องจักร (ภาษาไทย)</label>
                    <input type="text" class="form-control" name="machinery_lists_name1" value="{{$hd->machinery_lists_name1}}" required>
                </div>               
            </div>
        </div>  
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="machinery_lists_serialno" class="col-form-label">Serial No</label>
                    <input type="text" class="form-control" name="machinery_lists_serialno" value="{{$hd->machinery_lists_serialno}}">
                </div>               
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="machinery_lists_brand" class="col-form-label">ยี่ห้อ</label>
                    <input type="text" class="form-control" name="machinery_lists_brand" value="{{$hd->machinery_lists_brand}}">
                </div>               
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="machinery_lists_name2" class="col-form-label">ชื่อเครื่องจักร (ภาษาอังกฤษ)</label>
                    <input type="text" class="form-control" name="machinery_lists_name2" value="{{$hd->machinery_lists_name2}}">
                </div>               
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="machinery_lists_date" class="col-form-label">วันที่ซื้อ</label>
                    <input type="date" class="form-control" name="machinery_lists_date" value="{{$hd->machinery_lists_date}}">
                </div>               
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="machinery_lists_expirationdate" class="col-form-label">วันที่หมดประกัน</label>
                    <input type="date" class="form-control" name="machinery_lists_expirationdate" value="{{$hd->machinery_lists_expirationdate}}">
                </div>               
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="machinery_lists_plandate" class="col-form-label">วันที่ PM ล่าสุด</label>
                    <input type="date" class="form-control" name="machinery_lists_plandate" value="{{$hd->machinery_lists_plandate}}">
                </div>               
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="machinery_lists_nextdate" class="col-form-label">วันที่ PM ขั้นต่อไป</label>
                    <input type="date" class="form-control" name="machinery_lists_nextdate" value="{{$hd->machinery_lists_nextdate}}">
                </div>               
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="machinery_lists_day" class="col-form-label">ระยะเวลา PM</label>
                    <input type="number" class="form-control" name="machinery_lists_day" value="{{$hd->machinery_lists_day}}">
                </div>               
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="machinery_lists_location" class="col-form-label">สถานที่ตั้ง</label>
                    <input type="text" class="form-control" name="machinery_lists_location" value="{{$hd->machinery_lists_location}}">
                </div>               
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="machinery_lists_reamrk" class="col-form-label">หมายเหตุ</label>
                    <input type="text" class="form-control" name="machinery_lists_reamrk" value="{{$hd->machinery_lists_reamrk}}">
                </div>               
            </div>
        </div>
        <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="machinery_lists_file1" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile01"  name="machinery_lists_file1" onchange="prevFile(this,'machinery_lists_file1')">
                            @if ($hd->machinery_lists_file1)
                                <a href="{{asset($hd->machinery_lists_file1)}}" target="_blank">
                                    <i class="fas fa-file"></i>
                                </a>
                            @endif
                        </div>                          
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="machinery_lists_file2" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile02"  name="machinery_lists_file2" onchange="prevFile(this,'machinery_lists_file2')">
                            @if ($hd->machinery_lists_file2)
                                <a href="{{asset($hd->machinery_lists_file2)}}" target="_blank">
                                    <i class="fas fa-file"></i>
                                </a>
                            @endif
                        </div>

                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="machinery_lists_file3" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile03"  name="machinery_lists_file3" onchange="prevFile(this,'machinery_lists_file3')">
                            @if ($hd->machinery_lists_file3)
                                <a href="{{asset($hd->machinery_lists_file3)}}" target="_blank">
                                    <i class="fas fa-file"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="machinery_lists_file4" class="col-form-label">แนบไฟล์</label>
                            <input type="file" class="form-control" id="inputGroupFile03"  name="machinery_lists_file4" onchange="prevFile(this,'machinery_lists_file4')">
                            @if ($hd->machinery_lists_file4)
                                <a href="{{asset($hd->machinery_lists_file4)}}" target="_blank">
                                    <i class="fas fa-file"></i>
                                </a>
                            @endif
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