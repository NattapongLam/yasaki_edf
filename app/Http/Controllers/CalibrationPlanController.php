<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CalibrationList;
use App\Models\CalibrationPlan;
use App\Models\CalibrationPlanSub;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CalibrationPlanController extends Controller
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
        $hd = CalibrationList::where('calibration_lists_status','ใช้งาน')->get();
        foreach ($hd as $value) {
            $ck = CalibrationPlan::where('calibration_lists_id', $value->calibration_lists_id)
                ->whereDate('calibration_plans_date', $value->calibration_lists_nextdate)
                ->first();
            if ($ck === null) {
                CalibrationPlan::create([
                    'calibration_plans_date'   => $value->calibration_lists_nextdate,
                    'calibration_lists_id'     => $value->calibration_lists_id,
                    'calibration_lists_code'   => $value->calibration_lists_code,
                    'calibration_lists_name'   => $value->calibration_lists_name1,
                    'calibration_plans_plan'   => true,
                    'calibration_plans_action' => false,
                    'person_at'                => Auth::user()->name,
                ]);
            }
        }
        return view('calibrationsetup.form-calibrationplan-calendar');
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
            'calibration_plans_id' => ['required'],
            'calibration_lists_id' => ['required'],
            'calibration_plan_subs_date' => ['required'],
        ]);    
        $data = [
            'calibration_plans_id' => $request->calibration_plans_id,
            'calibration_lists_id' => $request->calibration_lists_id,
            'calibration_plan_subs_date' => $request->calibration_plan_subs_date,
            'calibration_plan_subs_areaofuse' => $request->calibration_plan_subs_areaofuse,
            'calibration_plan_subs_areaofuse_add' => $request->calibration_plan_subs_areaofuse_add,
            'calibration_plan_subs_areaofuse_del' => $request->calibration_plan_subs_areaofuse_del,
            'calibration_plan_subs_precision' => $request->calibration_plan_subs_precision,
            'calibration_plan_subs_measuringrange' => $request->calibration_plan_subs_measuringrange,
            'calibration_plan_subs_measuringrange_add' => $request->calibration_plan_subs_measuringrange_add,
            'calibration_plan_subs_measuringrange_del' => $request->calibration_plan_subs_measuringrange_del,
            'calibration_plan_subs_resolution' => $request->calibration_plan_subs_resolution,
            'calibration_plan_subs_temperature' => $request->calibration_plan_subs_temperature,
            'calibration_plan_subs_temperature_add' => $request->calibration_plan_subs_temperature_add,
            'calibration_plan_subs_temperature_del' => $request->calibration_plan_subs_temperature_del,
            'calibration_plan_subs_uncertainty' => $request->calibration_plan_subs_uncertainty,
            'calibration_plan_subs_humidity' => $request->calibration_plan_subs_humidity,
            'calibration_plan_subs_humidity_add' => $request->calibration_plan_subs_humidity_add,
            'calibration_plan_subs_humidity_del' => $request->calibration_plan_subs_humidity_del,
            'calibration_plan_subs_markingorshape' => $request->calibration_plan_subs_markingorshape,
            'calibration_plan_subs_remark' => $request->calibration_plan_subs_remark,
            'calibration_plan_subs_flag' => true,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now(), 
        ];  
        if ($request->hasFile('calibration_plan_subs_file1')) {
            $data['calibration_plan_subs_file1'] = $request->file('calibration_plan_subs_file1')->storeAs('images/Calibration_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('calibration_plan_subs_file1')->extension());
        }
        if ($request->hasFile('calibration_plan_subs_file2')) {
            $data['calibration_plan_subs_file2'] = $request->file('calibration_plan_subs_file2')->storeAs('images/Calibration_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('calibration_plan_subs_file2')->extension());
        }
        $clb = CalibrationList::find($request->calibration_lists_id);
        try{
            DB::beginTransaction();
            $insertHD = CalibrationPlanSub::create($data);  
            CalibrationPlan::where('calibration_plans_id',$request->calibration_plans_id)->update([
                'calibration_plans_resultdate' => $request->calibration_plan_subs_date,
                'calibration_plans_action' => true,
                'updated_at' => Carbon::now(),
            ]);
            $calibrationDate = Carbon::parse($request->calibration_plan_subs_date);
            $nextDate = $calibrationDate->copy()->addDays($clb->calibration_lists_day);
            CalibrationList::where('calibration_lists_id', $request->calibration_lists_id)->update([
                'calibration_lists_calibrationdate' => $calibrationDate->toDateString(),
                'calibration_lists_nextdate' => $nextDate->toDateString(),
                'calibration_lists_areaofuse' => $request->calibration_plan_subs_areaofuse,
                'calibration_lists_measuringrange' => $request->calibration_plan_subs_measuringrange,
                'calibration_lists_precision' => $request->calibration_plan_subs_precision,
                'calibration_lists_resolution' => $request->calibration_plan_subs_resolution,
                'calibration_lists_areaofuse_add' => $request->calibration_plan_subs_areaofuse_add,
                'calibration_lists_areaofuse_del' => $request->calibration_plan_subs_areaofuse_del,
                'calibration_lists_measuringrange_add' => $request->calibration_plan_subs_measuringrange_add,
                'calibration_lists_measuringrange_del' => $request->calibration_plan_subs_measuringrange_del,
                'calibration_lists_temperature' => $request->calibration_plan_subs_temperature,
                'calibration_lists_temperature_add' => $request->calibration_plan_subs_temperature_add,
                'calibration_lists_temperature_del' => $request->calibration_plan_subs_temperature_del,
                'calibration_lists_humidity' => $request->calibration_plan_subs_humidity,
                'calibration_lists_humidity_add' => $request->calibration_plan_subs_humidity_add,
                'calibration_lists_humidity_del' => $request->calibration_plan_subs_humidity_del,
                'calibration_lists_uncertainty' => $request->calibration_plan_subs_uncertainty,
                'calibration_lists_markingorshape' => $request->calibration_plan_subs_markingorshape,
                'updated_at' => Carbon::now(),
            ]);
            DB::commit();
            return redirect()->route('calibrationplans.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $data = DB::table('calibration_plans')
        ->leftjoin('calibration_lists','calibration_plans.calibration_lists_id','=','calibration_lists.calibration_lists_id')
        ->where('calibration_plans_id', $id)
        ->first();

        if (!$data) {
            abort(404);
        }

        return view('calibrationsetup.form-calibrationplan-show', compact('data'));
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

    public function getCalibrationCalendar(Request $request)
    {
        $query = DB::table('calibration_plans')
            ->whereNotNull('calibration_plans_date');
        $data = $query->select(
            'calibration_plans_id',
            'calibration_lists_code',
            'calibration_lists_name',
            'calibration_plans_date',
            'calibration_plans_action'
        )->get();

        $events = $data->map(function ($row) {
            return [
                'id'     => $row->calibration_plans_id,
                'title'  => $row->calibration_lists_code . ' : ' . $row->calibration_lists_name,
                'start'  => $row->calibration_plans_date,
                'allDay' => true,
                'extendedProps' => [
                    'status' => $row->calibration_plans_action
                ]
            ];
        });

        return response()->json($events->values());
    }
}
