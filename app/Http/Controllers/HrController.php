<?php

namespace App\Http\Controllers;

use App\Models\HrEmployee;
use App\Models\HrEmployeeTrain;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class HrController extends Controller
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
        $hd = HrEmployee::where('hr_employees_flag',true)->get();
        return view('people.form-person-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = null;
        return view('people.form-person-create', compact('hd'));
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
            'hr_employees_code' => ['required'],
            'hr_employees_fullname' => ['required'],
            'hr_employees_department' => ['required'],
            'hr_employees_position' => ['required'],
            'hr_employees_taxid' => ['required'],
            'hr_employees_institution' => ['required'],
            'hr_employees_educationa' => ['required'],
            'hr_employees_branch' => ['required'],
            'hr_employees_address' => ['required'],
        ]);  
        $data = [
            'hr_employees_code' => $request->hr_employees_code,
            'hr_employees_fullname' => $request->hr_employees_fullname,
            'hr_employees_department' => $request->hr_employees_department,
            'hr_employees_position' => $request->hr_employees_position,
            'hr_employees_taxid' => $request->hr_employees_taxid,
            'hr_employees_institution' => $request->hr_employees_institution,
            'hr_employees_educationa' => $request->hr_employees_educationa,
            'hr_employees_branch' => $request->hr_employees_branch,
            'hr_employees_address' => $request->hr_employees_address,
            'hr_employees_flag' => true,
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ];
        try{
            DB::beginTransaction();
            $insertHD = HrEmployee::create($data);               
            DB::commit();
            return redirect()->route('hr.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = HrEmployee::find($id);
        return view('people.form-person-edit', compact('hd'));
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
       // 1. Validate ข้อมูลพื้นฐาน
        $request->validate([
            'hr_employees_code' => 'required|string|max:255',
            'hr_employees_fullname' => 'required|string|max:255',
            'hr_employees_department' => 'required|string|max:255',
            'hr_employees_position' => 'required|string|max:255',
            'hr_employees_taxid' => 'required|string|max:255',
            'hr_employees_institution' => 'required|string|max:255',
            'hr_employees_educationa' => 'required|string|max:255',
            'hr_employees_branch' => 'required|string|max:255',
            'hr_employees_address' => 'required|string',
        ]);

        // กำหนดพาทโฟลเดอร์เก็บไฟล์ใน public/images/Train_File
        $folderPath = public_path('images/Train_File');

        // ตรวจสอบและสร้างโฟลเดอร์ถ้ายังไม่มี
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        // ใช้ Database Transaction เพื่อความปลอดภัยของข้อมูล
        DB::beginTransaction();

        try {
            // 2. อัปเดตข้อมูลพนักงาน (Master)
            $employee = HrEmployee::findOrFail($id);
            $employee->update([
                'hr_employees_code' => $request->hr_employees_code,
                'hr_employees_fullname' => $request->hr_employees_fullname,
                'hr_employees_department' => $request->hr_employees_department,
                'hr_employees_position' => $request->hr_employees_position,
                'hr_employees_taxid' => $request->hr_employees_taxid,
                'hr_employees_institution' => $request->hr_employees_institution,
                'hr_employees_educationa' => $request->hr_employees_educationa,
                'hr_employees_branch' => $request->hr_employees_branch,
                'hr_employees_address' => $request->hr_employees_address,
            ]);

            // 3. จัดการข้อมูลประวัติการอบรม (Detail)
            $trainIds = $request->input('hr_employee_trains_id', []);
            $trainDates = $request->input('hr_employee_trains_date', []);
            $trainRemarks = $request->input('hr_employee_trains_remark', []);
            $trainListNos = $request->input('hr_employee_trains_listno', []);
            $trainFiles = $request->file('hr_employee_trains_file', []);

            // ดึง ID เดิมทั้งหมดในฐานข้อมูลเพื่อเช็คว่าแถวไหนถูกลบออกไปบ้าง
            $existingTrainIds = HrEmployeeTrain::where('hr_employees_id', $id)->pluck('hr_employee_trains_id')->toArray();
            $submittedTrainIds = array_filter($trainIds); // กรองเอาเฉพาะ ID ที่ถูกส่งมา

            // หา ID ที่ถูกลบออกจากหน้าจอ แล้วลบข้อมูลพร้อมไฟล์ออกจาก Server
            $idsToDelete = array_diff($existingTrainIds, $submittedTrainIds);
            if (!empty($idsToDelete)) {
                $trainsToDelete = HrEmployeeTrain::whereIn('hr_employee_trains_id', $idsToDelete)->get();
                foreach ($trainsToDelete as $trainOld) {
                    if (!empty($trainOld->hr_employee_trains_file)) {
                        $oldFilePath = public_path('images/Train_File/' . $trainOld->hr_employee_trains_file);
                        if (File::exists($oldFilePath)) {
                            File::delete($oldFilePath);
                        }
                    }
                    $trainOld->delete();
                }
            }

            // วนลูปบันทึกข้อมูลประวัติการอบรม (อัปเดตของเดิม หรือ เพิ่มของใหม่)
            if (!empty($trainDates)) {
                for ($i = 0; $i < count($trainDates); $i++) {
                    $trainId = $trainIds[$i] ?? null;
                    
                    // จัดการไฟล์อัปโหลดในแต่ละแถว
                    $fileName = null;
                    if (isset($trainFiles[$i]) && $trainFiles[$i]->isValid()) {
                        // ตั้งชื่อไฟล์ใหม่ป้องกันชื่อซ้ำ
                        $fileName = time() . '_' . uniqid() . '.' . $trainFiles[$i]->getClientOriginalExtension();
                        // ย้ายไฟล์ไปที่ public/images/Train_File
                        $trainFiles[$i]->move($folderPath, $fileName);
                    }

                    if (!empty($trainId)) {
                        // --- กรณี: อัปเดตรายการเดิม ---
                        $train = HrEmployeeTrain::find($trainId);
                        if ($train) {
                            $updateData = [
                                'hr_employee_trains_listno' => $trainListNos[$i] ?? ($i + 1),
                                'hr_employee_trains_date' => $trainDates[$i],
                                'hr_employee_trains_remark' => $trainRemarks[$i],
                            ];

                            // ถ้ามีการอัปโหลดไฟล์ใหม่ ให้ลบไฟล์เก่าทิ้งแล้วแทนที่ด้วยไฟล์ใหม่
                            if ($fileName) {
                                if (!empty($train->hr_employee_trains_file)) {
                                    $oldFilePath = public_path('images/Train_File/' . $train->hr_employee_trains_file);
                                    if (File::exists($oldFilePath)) {
                                        File::delete($oldFilePath);
                                    }
                                }
                                $updateData['hr_employee_trains_file'] = $fileName;
                            }

                            $train->update($updateData);
                        }
                    } else {
                        // --- กรณี: เพิ่มรายการใหม่ ---
                        HrEmployeeTrain::create([
                            'hr_employees_id' => $employee->hr_employees_id,
                            'hr_employee_trains_listno' => $trainListNos[$i] ?? ($i + 1),
                            'hr_employee_trains_date' => $trainDates[$i],
                            'hr_employee_trains_remark' => $trainRemarks[$i],
                            'hr_employee_trains_file' => $fileName,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('hr.edit', $id)->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $e->getMessage())->withInput();
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
}
