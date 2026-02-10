<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\ApVendorList;
use Illuminate\Http\Request;
use App\Models\CalibrationList;
use App\Models\CalibrationType;
use App\Models\CalibrationGroup;
use Illuminate\Support\Facades\DB;
use App\Models\CalibrationCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CalibrationListController extends Controller
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
        $hd = CalibrationList::get();
        return view('calibrationsetup.form-calibrationlist-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorys = CalibrationCategory::get();
        $groups = CalibrationGroup::get();
        $types = CalibrationType::get();
        $vendors = ApVendorList::get();
        return view('calibrationsetup.form-calibrationlist-create', compact('categorys','groups','types','vendors'));
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
            'calibration_categories_id' => ['required'],
            'calibration_groups_id' => ['required'],
            'calibration_types_id' => ['required'],
            'calibration_lists_code' => ['required'],
            'calibration_lists_name1' => ['required'],
            'calibration_lists_areaofuse' => ['required'],
            'calibration_lists_measuringrange' => ['required'],
            'calibration_lists_precision' => ['required'],
            'calibration_lists_resolution' => ['required'],
        ]);
        $data = [
            'calibration_categories_id' => $request->calibration_categories_id,
            'calibration_groups_id' => $request->calibration_groups_id,
            'calibration_types_id' => $request->calibration_types_id,
            'calibration_lists_code' => $request->calibration_lists_code,
            'calibration_lists_name1' => $request->calibration_lists_name1,
            'calibration_lists_name2' => $request->calibration_lists_name2,
            'calibration_lists_serialno' => $request->calibration_lists_serialno,
            'ap_vendor_lists_id' => $request->ap_vendor_lists_id,
            'calibration_lists_location' => $request->calibration_lists_location,
            'calibration_lists_reamrk' => $request->calibration_lists_reamrk,
            'calibration_lists_date' => $request->calibration_lists_date,
            'calibration_lists_expirationdate' => $request->calibration_lists_expirationdate,
            'calibration_lists_calibrationdate' => $request->calibration_lists_calibrationdate,
            'calibration_lists_nextdate' => $request->calibration_lists_nextdate,
            'calibration_lists_day' => $request->calibration_lists_day,
            'calibration_lists_areaofuse' => $request->calibration_lists_areaofuse,
            'calibration_lists_measuringrange' => $request->calibration_lists_measuringrange,
            'calibration_lists_precision' => $request->calibration_lists_precision,
            'calibration_lists_resolution' => $request->calibration_lists_resolution,
            'calibration_lists_person' => $request->calibration_lists_person,
            'calibration_lists_status' => $request->calibration_lists_status,
            'calibration_lists_verify' => $request->calibration_lists_verify,
            'calibration_lists_areaofuse_add' => $request->calibration_lists_areaofuse_add,
            'calibration_lists_areaofuse_del' => $request->calibration_lists_areaofuse_del,
            'calibration_lists_measuringrange_add' => $request->calibration_lists_measuringrange_add,
            'calibration_lists_measuringrange_del' => $request->calibration_lists_measuringrange_del,
            'calibration_lists_temperature' => $request->calibration_lists_temperature,
            'calibration_lists_temperature_add' => $request->calibration_lists_temperature_add,
            'calibration_lists_temperature_del' => $request->calibration_lists_temperature_del,
            'calibration_lists_humidity' => $request->calibration_lists_humidity,
            'calibration_lists_humidity_add' => $request->calibration_lists_humidity_add,
            'calibration_lists_humidity_del' => $request->calibration_lists_humidity_del,
            'calibration_lists_uncertainty' => $request->calibration_lists_uncertainty,
            'calibration_lists_markingorshape' => $request->calibration_lists_markingorshape,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now(), 
        ];
        if ($request->hasFile('calibration_lists_file1')) {
            $data['calibration_lists_file1'] = $request->file('calibration_lists_file1')->storeAs('images/Calibration_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('calibration_lists_file1')->extension());
        }
        if ($request->hasFile('calibration_lists_file2')) {
            $data['calibration_lists_file2'] = $request->file('calibration_lists_file2')->storeAs('images/Calibration_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('calibration_lists_file2')->extension());
        }
        if ($request->hasFile('calibration_lists_file3')) {
            $data['calibration_lists_file3'] = $request->file('calibration_lists_file3')->storeAs('images/Calibration_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('calibration_lists_file3')->extension());
        }
        if ($request->hasFile('calibration_lists_file4')) {
            $data['calibration_lists_file4'] = $request->file('calibration_lists_file4')->storeAs('images/Calibration_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('calibration_lists_file4')->extension());
        }
        try{
            DB::beginTransaction();
            $insertHD = CalibrationList::create($data);               
            DB::commit();
            return redirect()->route('calibrationlists.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = CalibrationList::find($id);
        $categorys = CalibrationCategory::get();
        $groups = CalibrationGroup::get();
        $types = CalibrationType::get();
        $vendors = ApVendorList::get();
        return view('calibrationsetup.form-calibrationlist-edit', compact('categorys','groups','types','vendors','hd'));
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
        $request->validate([
            'calibration_lists_name1' => ['required'],
            'calibration_lists_areaofuse' => ['required'],
            'calibration_lists_measuringrange' => ['required'],
            'calibration_lists_precision' => ['required'],
            'calibration_lists_resolution' => ['required'],
        ]);
        $data = [
            'calibration_lists_name1' => $request->calibration_lists_name1,
            'calibration_lists_name2' => $request->calibration_lists_name2,
            'calibration_lists_serialno' => $request->calibration_lists_serialno,
            'ap_vendor_lists_id' => $request->ap_vendor_lists_id,
            'calibration_lists_location' => $request->calibration_lists_location,
            'calibration_lists_reamrk' => $request->calibration_lists_reamrk,
            'calibration_lists_date' => $request->calibration_lists_date,
            'calibration_lists_expirationdate' => $request->calibration_lists_expirationdate,
            'calibration_lists_calibrationdate' => $request->calibration_lists_calibrationdate,
            'calibration_lists_nextdate' => $request->calibration_lists_nextdate,
            'calibration_lists_day' => $request->calibration_lists_day,
            'calibration_lists_areaofuse' => $request->calibration_lists_areaofuse,
            'calibration_lists_measuringrange' => $request->calibration_lists_measuringrange,
            'calibration_lists_precision' => $request->calibration_lists_precision,
            'calibration_lists_resolution' => $request->calibration_lists_resolution,
            'calibration_lists_person' => $request->calibration_lists_person,
            'calibration_lists_status' => $request->calibration_lists_status,
            'calibration_lists_verify' => $request->calibration_lists_verify,
            'calibration_lists_areaofuse_add' => $request->calibration_lists_areaofuse_add,
            'calibration_lists_areaofuse_del' => $request->calibration_lists_areaofuse_del,
            'calibration_lists_measuringrange_add' => $request->calibration_lists_measuringrange_add,
            'calibration_lists_measuringrange_del' => $request->calibration_lists_measuringrange_del,
            'calibration_lists_temperature' => $request->calibration_lists_temperature,
            'calibration_lists_temperature_add' => $request->calibration_lists_temperature_add,
            'calibration_lists_temperature_del' => $request->calibration_lists_temperature_del,
            'calibration_lists_humidity' => $request->calibration_lists_humidity,
            'calibration_lists_humidity_add' => $request->calibration_lists_humidity_add,
            'calibration_lists_humidity_del' => $request->calibration_lists_humidity_del,
            'calibration_lists_uncertainty' => $request->calibration_lists_uncertainty,
            'calibration_lists_markingorshape' => $request->calibration_lists_markingorshape,
            'person_at' => Auth::user()->name,
            'updated_at' => Carbon::now(), 
        ];
        if ($request->hasFile('calibration_lists_file1')) {
            $data['calibration_lists_file1'] = $request->file('calibration_lists_file1')->storeAs('images/Calibration_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('calibration_lists_file1')->extension());
        }
        if ($request->hasFile('calibration_lists_file2')) {
            $data['calibration_lists_file2'] = $request->file('calibration_lists_file2')->storeAs('images/Calibration_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('calibration_lists_file2')->extension());
        }
        if ($request->hasFile('calibration_lists_file3')) {
            $data['calibration_lists_file3'] = $request->file('calibration_lists_file3')->storeAs('images/Calibration_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('calibration_lists_file3')->extension());
        }
        if ($request->hasFile('calibration_lists_file4')) {
            $data['calibration_lists_file4'] = $request->file('calibration_lists_file4')->storeAs('images/Calibration_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('calibration_lists_file4')->extension());
        }
        try{
            DB::beginTransaction();
            $insertHD = CalibrationList::where('calibration_lists_id',$id)->update($data);               
            DB::commit();
            return redirect()->route('calibrationlists.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
    public function getLastRunning(Request $req)
    {
       $prefix = strval($req->cat) . strval($req->grp) . strval($req->typ);

        $last = DB::table('calibration_lists')
            ->where('calibration_lists_code', 'like', $prefix . '%')
            ->orderBy('calibration_lists_code', 'desc')
            ->first();

        if ($last) {
            $lastRunning = intval(substr($last->calibration_lists_code, -3)) + 1;
        } else {
            $lastRunning = 001;
        }
        return [
            'running' => str_pad($lastRunning, 3, '0', STR_PAD_LEFT)
        ];
    }
}
