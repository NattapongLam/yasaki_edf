@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">🔍 รายละเอียดแผนสอบเทียบ</h4>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">รหัสเครื่องมือ</th>
                    <td>{{ $data->calibration_lists_code }}</td>
                </tr>
                <tr>
                    <th>ชื่อเครื่องมือ</th>
                    <td>{{ $data->calibration_lists_name }}</td>
                </tr>
                <tr>
                    <th>วันครบกำหนดสอบเทียบ</th>
                    <td>{{ \Carbon\Carbon::parse($data->calibration_plans_date)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>สถานะ</th>
                    <td>
                        @if($data->calibration_plans_action == 1)
                            <span class="badge bg-success">ดำเนินการเรียบร้อย</span>
                        @else
                            <span class="badge bg-danger">รอดำเนินการ</span>
                        @endif
                    </td>
                </tr>
            </table>

            <a href="{{ url('/calibrationplans') }}" class="btn btn-secondary">
                ⬅ กลับ
            </a>
        </div>
    </div>
</div>
@endsection
