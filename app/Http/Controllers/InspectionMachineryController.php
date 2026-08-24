<?php

namespace App\Http\Controllers;

use App\Models\InspectionMachineryDt;
use App\Models\InspectionMachineryHd;
use App\Models\MachineryList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class InspectionMachineryController extends Controller
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
        $hd = InspectionMachineryHd::leftjoin('machinery_lists','inspection_machinery_hds.machinery_lists_id','=','machinery_lists.machinery_lists_id')
        ->where('inspection_machinery_hds_flag',true)
        ->get();
        return view('inspection.form-inspectionmachinery-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mtn = MachineryList::where('machinery_lists_flag',true)->get();
        // Gen เลขที่เอกสารรอไว้
        $yearMonth = Carbon::now()->format('Ym');
        $latestDoc = InspectionMachineryHd::where('inspection_machinery_hds_docuno', 'like', "INS-M{$yearMonth}%")
                        ->orderBy('inspection_machinery_hds_docuno', 'desc')
                        ->first();

        $runningNumber = $latestDoc ? intval(substr($latestDoc->inspection_machinery_hds_docuno, -3)) + 1 : 1;
        $autoDocNo = 'INS-M' . $yearMonth . '-' . str_pad($runningNumber, 3, '0', STR_PAD_LEFT);
        return view('inspection.form-inspectionmachinery-create', compact('mtn','autoDocNo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          // 1. ตรวจสอบความถูกต้องของข้อมูล (Validation)
        $request->validate([
            'inspection_machinery_hds_date' => 'required|date',
            'inspection_machinery_hds_docuno' => 'required|string|max:255',
            'machinery_lists_id' => 'required|exists:machinery_lists,machinery_lists_id', // ปรับชื่อตารางตามจริง
            'inspection_machinery_hds_qty' => 'nullable|numeric',
            'inspection_machinery_hds_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // กำหนดประเภทไฟล์และขนาด
            'inspection_machinery_dts_name' => 'required|array',
            'inspection_machinery_dts_name.*' => 'required|string|max:255',
        ]);

        // ใช้ Database Transaction เพื่อความปลอดภัย หากเกิดข้อผิดพลาดจะ Rollback ทั้งหมด
        DB::beginTransaction();

        try {
            // 2. จัดการอัปโหลดไฟล์ (ถ้ามี)
            $filePath = null;
            if ($request->hasFile('inspection_machinery_hds_file')) {
                $file = $request->file('inspection_machinery_hds_file');
                $filename = time() . '_' . $file->getClientOriginalName();
                // บันทึกไฟล์ไว้ที่ storage/app/public/uploads/inspection
                $filePath = $file->storeAs('uploads/inspection', $filename, 'public');
            }

            // 3. บันทึกข้อมูลส่วนหัว (Header)
            $header = InspectionMachineryHd::create([
                'inspection_machinery_hds_date'   => $request->inspection_machinery_hds_date,
                'inspection_machinery_hds_docuno' => $request->inspection_machinery_hds_docuno,
                'machinery_lists_id'              => $request->machinery_lists_id,
                'inspection_machinery_hds_vendor' => $request->inspection_machinery_hds_vendor,
                'inspection_machinery_hds_refdocu'=> $request->inspection_machinery_hds_refdocu,
                'inspection_machinery_hds_qty'    => $request->inspection_machinery_hds_qty,
                'inspection_machinery_hds_file'   => $filePath, // บันทึก Path ไฟล์ลงฐานข้อมูล
                'inspection_machinery_hds_remark' => $request->inspection_machinery_hds_remark,
                'inspection_machinery_hds_flag' => true,
                'person_at' => Auth::user()->name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            // 4. บันทึกข้อมูลส่วนรายละเอียด (Detail) แบบ Loop หลายแถว
            if ($request->has('inspection_machinery_dts_name')) {
                $names     = $request->inspection_machinery_dts_name;
                $listnos   = $request->inspection_machinery_dts_listno;
                $standards = $request->inspection_machinery_dts_standard;
                $results   = $request->inspection_machinery_dts_result;
                $statuses  = $request->inspection_machinery_dts_status;

                foreach ($names as $index => $name) {
                    InspectionMachineryDt::create([
                        // สมมติว่า Foreign Key ที่เชื่อมกับ Header คือ inspection_machinery_hds_id
                        'inspection_machinery_hds_id'     => $header->inspection_machinery_hds_id, 
                        'inspection_machinery_dts_listno' => $listnos[$index] ?? ($index + 1),
                        'inspection_machinery_dts_name'   => $name,
                        'inspection_machinery_dts_standard' => $standards[$index] ?? null,
                        'inspection_machinery_dts_result' => $results[$index] ?? null,
                        'inspection_machinery_dts_status' => $statuses[$index] ?? null,
                        'inspection_machinery_dts_flag' => true,
                        'person_at' => Auth::user()->name,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
            }

            // ยืนยันการทำงานทั้งหมด
            DB::commit();

            return redirect()->back()->with('success', 'บันทึกข้อมูลใบตรวจรับเครื่องมือวัดเรียบร้อยแล้ว');

        } catch (\Exception $e) {
            // หากมีข้อผิดพลาด ให้ยกเลิกการบันทึกทั้งหมด
            DB::rollBack();
            
            // ลบไฟล์ที่อัปโหลดค้างไว้ (ถ้ามี)
            if (isset($filePath) && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $e->getMessage())->withInput();
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
        //
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
        //
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

    public function CancelInspectionMchHd(Request $request)
    {
        $id = $request->refid;
        try {
            DB::beginTransaction();
            InspectionMachineryHd::where('inspection_machinery_hds_id', $id)
            ->update([
                'updated_at' => Carbon::now(),
                'inspection_machinery_hds_flag' => 0,
                'person_at' => Auth::user()->name,
            ]);
            DB::commit();                      
            return response()->json([
                'status' => true,
                'message' => 'ยกเลิกเรียบร้อยแล้ว'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function CancelInspectionMchDt(Request $request)
    {
        $id = $request->refid;
        try {
            DB::beginTransaction();
            InspectionMachineryDt::where('inspection_machinery_dts_id', $id)
            ->update([
                'updated_at' => Carbon::now(),
                'inspection_machinery_dts_flag' => 0,
                'person_at' => Auth::user()->name,
            ]);
            DB::commit();                      
            return response()->json([
                'status' => true,
                'message' => 'ยกเลิกเรียบร้อยแล้ว'
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
