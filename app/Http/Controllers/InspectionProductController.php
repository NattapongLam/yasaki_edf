<?php

namespace App\Http\Controllers;

use App\Models\InspectionProductDt;
use App\Models\InspectionProductHd;
use App\Models\WhProductList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class InspectionProductController extends Controller
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
        $hd = InspectionProductHd::leftjoin('wh_product_lists','inspection_product_hds.wh_product_lists_id','=','wh_product_lists.wh_product_lists_id')
        ->where('inspection_product_hds_flag',true)
        ->get();
        return view('inspection.form-inspectionproduct-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pd = WhProductList::where('wh_product_lists_flag',true)->get();
        // Gen เลขที่เอกสารรอไว้
        $yearMonth = Carbon::now()->format('Ym');
        $latestDoc = InspectionProductHd::where('inspection_product_hds_docuno', 'like', "INS-P{$yearMonth}%")
                        ->orderBy('inspection_product_hds_docuno', 'desc')
                        ->first();

        $runningNumber = $latestDoc ? intval(substr($latestDoc->inspection_product_hds_docuno, -3)) + 1 : 1;
        $autoDocNo = 'INS-P' . $yearMonth . '-' . str_pad($runningNumber, 3, '0', STR_PAD_LEFT);
        return view('inspection.form-inspectionproduct-create', compact('pd','autoDocNo'));
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
            'inspection_product_hds_date' => 'required|date',
            'inspection_product_hds_docuno' => 'required|string|max:255',
            'wh_product_lists_id' => 'required|exists:wh_product_lists,wh_product_lists_id', // ปรับชื่อตารางตามจริง
            'inspection_product_hds_qty' => 'nullable|numeric',
            'inspection_product_hds_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // กำหนดประเภทไฟล์และขนาด
            'inspection_product_dts_name' => 'required|array',
            'inspection_product_dts_name.*' => 'required|string|max:255',
        ]);

        // ใช้ Database Transaction เพื่อความปลอดภัย หากเกิดข้อผิดพลาดจะ Rollback ทั้งหมด
        DB::beginTransaction();

        try {
            // 2. จัดการอัปโหลดไฟล์ (ถ้ามี)
            $filePath = null;
            if ($request->hasFile('inspection_product_hds_file')) {
                $file = $request->file('inspection_product_hds_file');
                $filename = time() . '_' . $file->getClientOriginalName();
                // บันทึกไฟล์ไว้ที่ storage/app/public/uploads/inspection
                $filePath = $file->storeAs('uploads/inspection', $filename, 'public');
            }

            // 3. บันทึกข้อมูลส่วนหัว (Header)
            $header = InspectionProductHd::create([
                'inspection_product_hds_date'   => $request->inspection_product_hds_date,
                'inspection_product_hds_docuno' => $request->inspection_product_hds_docuno,
                'wh_product_lists_id'              => $request->wh_product_lists_id,
                'inspection_product_hds_vendor' => $request->inspection_product_hds_vendor,
                'inspection_product_hds_refdocu'=> $request->inspection_product_hds_refdocu,
                'inspection_product_hds_qty'    => $request->inspection_product_hds_qty,
                'inspection_product_hds_file'   => $filePath, // บันทึก Path ไฟล์ลงฐานข้อมูล
                'inspection_product_hds_remark' => $request->inspection_product_hds_remark,
                'inspection_product_hds_flag' => true,
                'person_at' => Auth::user()->name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            // 4. บันทึกข้อมูลส่วนรายละเอียด (Detail) แบบ Loop หลายแถว
            if ($request->has('inspection_product_dts_name')) {
                $names     = $request->inspection_product_dts_name;
                $listnos   = $request->inspection_product_dts_listno;
                $standards = $request->inspection_product_dts_standard;
                $results   = $request->inspection_product_dts_result;
                $statuses  = $request->inspection_product_dts_status;

                foreach ($names as $index => $name) {
                    InspectionProductDt::create([
                        // สมมติว่า Foreign Key ที่เชื่อมกับ Header คือ inspection_product_hds_id
                        'inspection_product_hds_id'     => $header->inspection_product_hds_id, 
                        'inspection_product_dts_listno' => $listnos[$index] ?? ($index + 1),
                        'inspection_product_dts_name'   => $name,
                        'inspection_product_dts_standard' => $standards[$index] ?? null,
                        'inspection_product_dts_result' => $results[$index] ?? null,
                        'inspection_product_dts_status' => $statuses[$index] ?? null,
                        'inspection_product_dts_flag' => true,
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
        $hd = InspectionProductHd::find($id);
        $dt = InspectionProductDt::where('inspection_machinery_hds_id',$id)->where('inspection_machinery_dts_flag',true)->get();
        $pd = WhProductList::where('wh_product_lists_flag',true)->get();
        return view('inspection.form-inspectionproduct-edit', compact('pd','hd','dt'));
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
         // ใช้ Database Transaction เพื่อความปลอดภัย (ถ้าเกิด Error จะได้ Rollback กลับได้)
        DB::beginTransaction();

        try {
            // 1. ค้นหาข้อมูล Header เดิม
            $header = InspectionProductHd::findOrFail($id);

            // จัดการอัปโหลดไฟล์ใหม่ (ถ้ามีการแนบไฟล์มา)
            $filePath = $header->inspection_product_hds_file; // ใช้ path เดิมก่อน
            if ($request->hasFile('inspection_product_hds_file')) {
                // (ถ้าต้องการลบไฟล์เก่าทิ้ง สามารถเขียนโค้ดลบตรงนี้ได้)
                
                $file = $request->file('inspection_product_hds_file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/inspection'), $filename);
                $filePath = 'uploads/inspection/' . $filename;
            }

            // 2. อัปเดตข้อมูล Header
            $header->update([
                'inspection_product_hds_date' => $request->inspection_product_hds_date,
                'wh_product_lists_id'            => $request->wh_product_lists_id,
                'inspection_product_hds_vendor' => $request->inspection_product_hds_vendor,
                'inspection_product_hds_refdocu' => $request->inspection_product_hds_refdocu,
                'inspection_product_hds_qty'  => $request->inspection_product_hds_qty,
                'inspection_product_hds_file' => $filePath,
                'inspection_product_hds_remark' => $request->inspection_product_hds_remark,
                'person_at' => Auth::user()->name,
                'updated_at' => Carbon::now()
            ]);

            // 3. จัดการข้อมูล Detail (ตารางรายการย่อย)
            // แนวทางที่ง่ายและนิยม คือ ลบรายการเก่าทั้งหมดของ Header นี้ทิ้ง แล้วบันทึกรายการใหม่ที่ส่งมาจากฟอร์มเข้าไปแทน
            InspectionProductDt::where('inspection_product_hds_id', $id)->delete();

            // ตรวจสอบว่ามีข้อมูลส่งมาจากตารางหรือไม่
            if ($request->has('inspection_product_dts_name')) {
                $names     = $request->inspection_product_dts_name;
                $standards = $request->inspection_product_dts_standard;
                $results   = $request->inspection_product_dts_result;
                $statuses  = $request->inspection_product_dts_status;
                $listnos   = $request->inspection_product_dts_listno;

                foreach ($names as $index => $name) {
                    InspectionProductDt::create([
                        'inspection_product_hds_id'     => $header->inspection_product_hds_id, // หรือใช้ตัวแปร $id
                        'inspection_product_dts_listno' => $listnos[$index] ?? ($index + 1),
                        'inspection_product_dts_name'   => $name,
                        'inspection_product_dts_standard' => $standards[$index] ?? null,
                        'inspection_product_dts_result' => $results[$index] ?? null,
                        'inspection_product_dts_status' => $statuses[$index] ?? null,
                        'inspection_product_dts_flag' => true,
                        'person_at' => Auth::user()->name,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
            }

            // ยืนยันการทำงานทั้งหมด
            DB::commit();

            return redirect()->route('inspection-product.index')
                            ->with('success', 'อัปเดตข้อมูลใบตรวจรับเครื่องมือวัดเรียบร้อยแล้ว');

        } catch (\Exception $e) {
            // หากมีข้อผิดพลาด ยกเลิกการทำงานทั้งหมด
            DB::rollback();

            return redirect()->back()
                            ->with('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $e->getMessage())
                            ->withInput();
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

     public function CancelInspectionMchHd(Request $request)
    {
        $id = $request->refid;
        try {
            DB::beginTransaction();
            InspectionProductHd::where('inspection_product_hds_id', $id)
            ->update([
                'updated_at' => Carbon::now(),
                'inspection_product_hds_flag' => 0,
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
            InspectionProductDt::where('inspection_product_dts_id', $id)
            ->update([
                'updated_at' => Carbon::now(),
                'inspection_product_dts_flag' => 0,
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
