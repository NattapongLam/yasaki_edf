<?php

namespace App\Http\Controllers;

use App\Models\CalibrationList;
use App\Models\MachineryList;
use App\Models\RepairMachineryDt;
use App\Models\RepairMachineryHd;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MaintenanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hd = RepairMachineryHd::leftjoin('repair_machinery_statuses','repair_machinery_hds.repair_machinery_statuses_id','=','repair_machinery_statuses.repair_machinery_statuses_id')->get();
        return view('machinerysetup.form-maintenances-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = null;
        return view('machinerysetup.form-maintenances-create', compact('hd'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'repair_machinery_hds_date' => ['required'],
            'repair_machinery_hds_docuno' => ['required'],
            'repair_machinery_hds_type' => ['required'],
            'repair_machinery_hds_duedate' => ['required'],
            'repair_id' => ['required'],
            'repair_machinery_dts_listno' => ['required'],
        ]);
        $repair_code = '-';
        $repair_name = '-';
        if($request->repair_machinery_hds_type == "CAL"){
            $cal = CalibrationList::find($request->repair_id);
            $repair_code = $cal->calibration_lists_code;
            $repair_name = $cal->calibration_lists_name1;
        }elseif($request->repair_machinery_hds_type == "MC"){
            $mc = MachineryList::find($request->repair_id);
            $repair_code = $mc->machinery_lists_code;
            $repair_name = $mc->machinery_lists_name1;
        }
        $data = [
            'repair_machinery_hds_date' => $request->repair_machinery_hds_date,
            'repair_machinery_hds_docuno' => $request->repair_machinery_hds_docuno,
            'repair_machinery_hds_number' => 0,
            'repair_machinery_hds_type' => $request->repair_machinery_hds_type,
            'repair_machinery_hds_duedate' => $request->repair_machinery_hds_duedate,
            'repair_id' => $request->repair_id,
            'repair_code' => $repair_code,
            'repair_name' => $repair_name,
            'repair_machinery_statuses_id' => 1,
            'repair_machinery_hds_remark' => $request->repair_machinery_hds_remark,
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ];
        try
        {
            DB::beginTransaction();
            $insertHD = RepairMachineryHd::create($data);    
            foreach ($request->repair_machinery_dts_listno as $key => $value) {
                RepairMachineryDt::insert([
                    'repair_machinery_hds_id' => $insertHD->repair_machinery_hds_id,
                    'repair_machinery_dts_listno' => $value,
                    'repair_machinery_dts_part' => $request->repair_machinery_dts_part[$key],
                    'repair_machinery_dts_remark' => $request->repair_machinery_dts_remark[$key],
                    'repair_machinery_dts_flag' => true,
                    'person_at' => Auth::user()->name,
                    'created_at'=> Carbon::now(),
                    'updated_at'=> Carbon::now(),
                ]);
            }         
            DB::commit();
            return redirect()->route('maintenances.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        }catch(\Exception $e){
            Log::error($e->getMessage());
            dd($e->getMessage());
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hd = RepairMachineryHd::find($id);
        $dt = RepairMachineryDt::where('repair_machinery_hds_id',$id)->where('repair_machinery_dts_flag',true)->get();
        return view('machinerysetup.form-maintenances-edit', compact('hd','dt'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = [
            'repair_machinery_statuses_id' => 2,
            'repair_machinery_hds_result_note' => $request->repair_machinery_hds_result_note,
            'repair_machinery_hds_result_date' => $request->repair_machinery_hds_result_date,
            'repair_machinery_hds_result_person' => $request->repair_machinery_hds_result_person,
        ];
        if ($request->hasFile('repair_machinery_hds_result_file1')) {
            $data['repair_machinery_hds_result_file1'] = $request->file('repair_machinery_hds_result_file1')->storeAs('images/Machinery_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('repair_machinery_hds_result_file1')->extension());
        }
        if ($request->hasFile('repair_machinery_hds_result_file2')) {
            $data['repair_machinery_hds_result_file2'] = $request->file('repair_machinery_hds_result_file2')->storeAs('images/Machinery_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('repair_machinery_hds_result_file2')->extension());
        }
        try
        {
            DB::beginTransaction();
            $insertHD = RepairMachineryHd::where('repair_machinery_hds_id',$id)->update($data);            
            DB::commit();
            return redirect()->route('maintenances.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        }catch(\Exception $e){
            Log::error($e->getMessage());
            dd($e->getMessage());
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getItems(Request $request)
    {
        $type = $request->query('type');
        $items = [];
        if ($type === 'CAL') {
            // ดึงข้อมูลจากตาราง CalibrationList (ปรับชื่อ column ตามจริง เช่น name, code)
            $items = CalibrationList::select('calibration_lists_id as id', 'calibration_lists_name1 as name')
            ->where('calibration_lists_status','<>','ไม่ใช้งาน')
            ->get(); 
        } elseif ($type === 'MC') {
            // ดึงข้อมูลจากตาราง MachineryList
            $items = MachineryList::select('machinery_lists_id as id', 'machinery_lists_name1 as name')
            ->where('machinery_lists_flag',0)
            ->get();
        }
        return response()->json([
            'status' => 'success',
            'items' => $items
        ]);
    }

    public function getDocNo(Request $request)
    {
        $prefix = "REP"; // อักษรนำหน้า (สามารถปรับเปลี่ยนตามต้องการ เช่น INV, REC)
        $date = Carbon::now();
        $yearMonth = $date->format('Ym'); // รูปแบบปีและเดือน เช่น 202606

        // ค้นหาเอกสารล่าสุดของเดือน/ปีปัจจุบัน
        $latestDoc = RepairMachineryHd::where('repair_machinery_hds_docuno', 'LIKE', "{$prefix}-{$yearMonth}-%")
                        ->orderBy('repair_machinery_hds_docuno', 'desc')
                        ->first();

        if ($latestDoc) {
            // ตัดเอาเลขรันด้านหลังมา + 1
            $runningNumber = (int) substr($latestDoc->repair_machinery_hds_docuno, -4) + 1;
        } else {
            $runningNumber = 1;
        }

        // จัดรูปแบบให้เป็น 4 หลัก เช่น REP-202606-0001
        $docNo = sprintf("%s-%s-%04d", $prefix, $yearMonth, $runningNumber);

        return response()->json([
            'status' => 'success',
            'doc_no' => $docNo
        ]);
    }

    public function confirmDelMaintenances(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            RepairMachineryHd::where('repair_machinery_hds_id',$id)->update([
                'repair_machinery_statuses_id' => 3,
                'person_at' => Auth::user()->name,
                'updated_at'=> Carbon::now(),
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'ยกเลิกรายการเรียบร้อยแล้ว'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
