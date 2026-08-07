<?php

namespace App\Http\Controllers;

use App\Models\DocMasterList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MasterListController extends Controller
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
        $hd = DocMasterList::where('doc_master_lists_flag',true)->get();
        return view('dcc.form-masterlist-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = null;
        return view('dcc.form-masterlist-create', compact('hd'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // 1. Validate ข้อมูลที่ส่งมาจากฟอร์ม
        $validated = $request->validate([
            'doc_master_lists_date' => 'required|date',
            'doc_master_lists_type' => 'required|string|max:255',
            'doc_master_lists_docuno' => 'required|string|max:255',
            'doc_master_lists_docuname' => 'required|string|max:255',
            'doc_master_lists_status' => 'required|string|max:255',
            'doc_master_lists_department' => 'required|string|max:255',
            'doc_master_lists_location' => 'required|string|max:255',
            
            // ตรวจสอบข้อมูล Checkbox (รับค่าเป็น Array และแต่ละค่าต้องเป็น string)
            'doc_master_lists_options' => 'nullable|array',
            'doc_master_lists_options.*' => 'string', 

            // ตรวจสอบไฟล์ (ตัวอย่างกำหนดให้เป็นไฟล์เอกสาร/รูปภาพ และไม่เกิน 2MB)
            'doc_master_lists_file1' => 'nullable|file|max:5120',
            'doc_master_lists_file2' => 'nullable|file|max:5120',
            
            'doc_master_lists_note' => 'nullable|string',
        ]);

        try {
            // 2. จัดการอัปโหลดไฟล์ที่ 1 (ถ้ามี)
            $file1Path = null;
            if ($request->hasFile('doc_master_lists_file1')) {
                $file1Path = $request->file('doc_master_lists_file1')->storeAs(
                    'images/Masterlist_File', 
                    "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('doc_master_lists_file1')->extension()
                );
            }

            // 3. จัดการอัปโหลดไฟล์ที่ 2 (ถ้ามี)
            $file2Path = null;
            if ($request->hasFile('doc_master_lists_file2')) {
                $file2Path = $request->file('doc_master_lists_file2')->storeAs(
                    'images/Masterlist_File', 
                    "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('doc_master_lists_file2')->extension()
                );
            }
            // 4. บันทึกข้อมูลลงฐานข้อมูล
            DocMasterList::create([
                'doc_master_lists_date' => $request->doc_master_lists_date,
                'doc_master_lists_type' => $request->doc_master_lists_type,
                'doc_master_lists_docuno' => $request->doc_master_lists_docuno,
                'doc_master_lists_docuname' => $request->doc_master_lists_docuname,
                'doc_master_lists_status' => $request->doc_master_lists_status,
                'doc_master_lists_department' => $request->doc_master_lists_department,
                'doc_master_lists_location' => $request->doc_master_lists_location,
                
                // บันทึกค่า Checkbox เป็น Array (Laravel จะแปลงเป็น JSON ให้อัตโนมัติถ้าใส่ $casts ไว้ใน Model)
                'doc_master_lists_options' => $request->doc_master_lists_options, 

                'doc_master_lists_file1' => $file1Path,
                'doc_master_lists_file2' => $file2Path,
                'doc_master_lists_note' => $request->doc_master_lists_note,
                'person_at' => Auth::user()->name ?? 'System', // ป้องกัน Error กรณีไม่ได้ Login
                'doc_master_lists_flag' => true
            ]);

            // 5. ส่งกลับไปหน้าเดิมพร้อมข้อความแจ้งเตือนความสำเร็จ
            return redirect()->route('master-list.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');

        } catch (\Exception $e) {
            // หากเกิดข้อผิดพลาด ระบบจะหยุดและแสดงข้อความ Error ออกมาทันทีเพื่อให้อ่านง่าย
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
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
        $data = DocMasterList::findOrFail($id);
        return view('dcc.form-masterlist-edit', compact('data'));
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
        // 1. Validate ข้อมูล
        $validated = $request->validate([
            'doc_master_lists_date' => 'required|date',
            'doc_master_lists_type' => 'required|string|max:255',
            'doc_master_lists_docuno' => 'required|string|max:255',
            'doc_master_lists_docuname' => 'required|string|max:255',
            'doc_master_lists_status' => 'required|string|max:255',
            'doc_master_lists_department' => 'required|string|max:255',
            'doc_master_lists_location' => 'required|string|max:255',
            
            'doc_master_lists_options' => 'nullable|array',
            'doc_master_lists_options.*' => 'string', 

            'doc_master_lists_file1' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',
            'doc_master_lists_file2' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',
            
            'doc_master_lists_note' => 'nullable|string',
        ]);

        $item = DocMasterList::findOrFail($id);

        // 2. จัดการไฟล์ที่ 1 (ถ้ามีการอัปโหลดไฟล์ใหม่มาทับ)
        $file1Path = $item->doc_master_lists_file1; // ใช้ค่าเดิมไว้ก่อน
        if ($request->hasFile('doc_master_lists_file1')) {
            $file1Path = $request->file('doc_master_lists_file1')->storeAs(
                'images/Masterlist_File', 
                "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('doc_master_lists_file1')->extension()
            );
        }

        // 3. จัดการไฟล์ที่ 2 (ถ้ามีการอัปโหลดไฟล์ใหม่มาทับ)
        $file2Path = $item->doc_master_lists_file2; // ใช้ค่าเดิมไว้ก่อน
        if ($request->hasFile('doc_master_lists_file2')) {
            $file2Path = $request->file('doc_master_lists_file2')->storeAs(
                'images/Masterlist_File', 
                "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('doc_master_lists_file2')->extension()
            );
        }

        // 4. อัปเดตข้อมูล
        $item->update([
            'doc_master_lists_date' => $request->doc_master_lists_date,
            'doc_master_lists_type' => $request->doc_master_lists_type,
            'doc_master_lists_docuno' => $request->doc_master_lists_docuno,
            'doc_master_lists_docuname' => $request->doc_master_lists_docuname,
            'doc_master_lists_status' => $request->doc_master_lists_status,
            'doc_master_lists_department' => $request->doc_master_lists_department,
            'doc_master_lists_location' => $request->doc_master_lists_location,
            'doc_master_lists_options' => $request->doc_master_lists_options, 
            'doc_master_lists_file1' => $file1Path,
            'doc_master_lists_file2' => $file2Path,
            'doc_master_lists_note' => $request->doc_master_lists_note,
        ]);

        return redirect()->route('master-list.index')->with('success', 'แก้ไขข้อมูลสำเร็จเรียบร้อยแล้ว!');
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

    public function CancelMasterList(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            DocMasterList::where('doc_master_lists_id',$id)->update([
                'doc_master_lists_flag' => false,
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
