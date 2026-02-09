<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalibrationList;
use App\Models\CalibrationPlan;
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
        //
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
