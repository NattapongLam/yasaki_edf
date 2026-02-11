<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\CalibrationChecksheetDt;
use App\Models\CalibrationChecksheetHd;

class CalibrationChecksheetController extends Controller
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
        $hd = CalibrationChecksheetHd::get();
        return view('calibrationsetup.form-calibrationchecksheet-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'calibration_checksheet_hds_date' => ['required'],
        ]);    
        $data = [
            'calibration_checksheet_hds_date' => $request->calibration_checksheet_hds_date,
            'calibration_lists_id' => $request->calibration_lists_id,
            'calibration_lists_code' => $request->calibration_lists_code,
            'calibration_lists_name' => $request->calibration_lists_name,
            'calibration_checksheet_hds_remark' => $request->calibration_checksheet_hds_remark,
            'calibration_checksheet_hds_flag' => true,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now(), 
        ];
        try
        {
            DB::beginTransaction();
            $insertHD = CalibrationChecksheetHd::create($data);   
            foreach ($request->calibration_checksheet_dts_listno as $key => $value) {
                CalibrationChecksheetDt::insert([
                    'calibration_checksheet_hds_id' => $insertHD->calibration_checksheet_hds_id,
                    'calibration_checksheet_dts_listno' => $request->calibration_checksheet_dts_listno[$key],
                    'calibration_checksheet_dts_remark' => $request->calibration_checksheet_dts_remark[$key],
                    'calibration_checksheet_dts_flag' => true,
                    'person_at' => Auth::user()->name,
                    'created_at'=> Carbon::now(),
                    'updated_at'=> Carbon::now(),
                ]);
            }            
            DB::commit();
            return redirect()->route('calibrationchecksheets.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = CalibrationChecksheetHd::find($id);
        $dt = CalibrationChecksheetDt::where('calibration_checksheet_dts_flag',true)->where('calibration_checksheet_hds_id',$id)->get();
        return view('calibrationsetup.form-calibrationchecksheet-update', compact('hd','dt'));
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
        try
        {
            DB::beginTransaction();
            $detailIds = $request->calibration_checksheet_dts_id ?? [];
            $actions   = $request->action ?? [];
            foreach ($detailIds as $index => $detailId) {
                $updateData = [];
                for ($i = 1; $i <= 31; $i++) {
                    $field = 'action_' . str_pad($i, 2, '0', STR_PAD_LEFT);
                    $updateData[$field] =
                        isset($actions[$index][$field]) ? 1 : 0;
                }
                CalibrationChecksheetDt::where('calibration_checksheet_dts_id', $detailId)->update($updateData);
            }
            DB::commit();
            return redirect()->route('calibrationchecksheets.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
}
