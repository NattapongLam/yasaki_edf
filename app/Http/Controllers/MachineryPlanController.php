<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MachineryList;
use App\Models\MachineryPlan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MachineryPlanController extends Controller
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
        $hd = MachineryList::where('machinery_lists_flag',true)->get();
        foreach ($hd as $value) {
            $ck = MachineryPlan::where('machinery_lists_id', $value->machinery_lists_id)
                ->whereDate('machinery_plans_date', $value->machinery_lists_nextdate)
                ->first();
            if ($ck === null) {
                MachineryPlan::create([
                    'machinery_plans_date'   => $value->machinery_lists_nextdate,
                    'machinery_lists_id'     => $value->machinery_lists_id,
                    'machinery_lists_code'   => $value->machinery_lists_code,
                    'machinery_lists_name'   => $value->machinery_lists_name1,
                    'machinery_plans_plan'   => true,
                    'machinery_plans_action' => false,
                    'person_at'                => Auth::user()->name,
                ]);
            }
        }
        return view('machinerysetup.form-machineryplan-calendar');
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
            'machinery_plans_id' => ['required'],
            'calibration_lists_id' => ['required'],
            'machinery_lists_id' => ['required'],
            'machinery_plan_subs_listno' => ['required'],
        ]);  
        try{
            DB::beginTransaction();
            foreach ($request->machinery_plan_subs_listno as $key => $value) {
                MachineryPlanSub::insert([
                    'machinery_plans_id' => $request->machinery_plans_id,
                    'machinery_lists_id' => $request->machinery_lists_id,
                    'machinery_plan_subs_date' => $request->machinery_plan_subs_date,
                    'machinery_plan_subs_listno' => $value,
                    'machinery_plan_subs_remark' => $request->machinery_plan_subs_remark[$key],
                    'machinery_plan_subs_flag' => true,
                    'person_at' => Auth::user()->name,
                    'created_at'=> Carbon::now(),
                    'updated_at'=> Carbon::now(),
                ]);                
            }
            MachineryPlan::where('machinery_plans_id',$request->machinery_plans_id)->update([
                'machinery_plans_resultdate' => $request->machinery_plan_subs_date,
                'machinery_plans_action' => true,
                'updated_at' => Carbon::now(),
            ]);
            $mc = MachineryList::find($request->machinery_lists_id);
            $machineryDate = Carbon::parse($request->machinery_plan_subs_date);
            $nextDate = $machineryDate->copy()->addDays($mc->machinery_lists_day);
                MachineryList::where('machinery_lists_id', $request->machinery_lists_id)->update([
                    'machinery_lists_plandate' => $machineryDate->toDateString(),
                    'machinery_lists_nextdate' => $nextDate->toDateString(),
                    'updated_at' => Carbon::now(),
                ]);
            DB::commit();
            return redirect()->route('machineryplans.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $data = DB::table('machinery_plans')
        ->where('machinery_plans_id', $id)
        ->first();

        if (!$data) {
            abort(404);
        }

        return view('machinerysetup.form-machineryplan-show', compact('data'));
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

    public function getMachineryCalendar(Request $request)
    {
        $query = DB::table('machinery_plans')
            ->whereNotNull('machinery_plans_date');
        $data = $query->select(
            'machinery_plans_id',
            'machinery_lists_code',
            'machinery_lists_name',
            'machinery_plans_date',
            'machinery_plans_action'
        )->get();

        $events = $data->map(function ($row) {
            return [
                'id'     => $row->machinery_plans_id,
                'title'  => $row->machinery_lists_code . ' : ' . $row->machinery_lists_name,
                'start'  => $row->machinery_plans_date,
                'allDay' => true,
                'extendedProps' => [
                    'status' => $row->machinery_plans_action
                ]
            ];
        });

        return response()->json($events->values());
    }
}
