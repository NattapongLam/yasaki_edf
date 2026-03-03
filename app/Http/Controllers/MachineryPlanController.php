<?php

namespace App\Http\Controllers;

use App\Models\MachineryList;
use App\Models\MachineryPlan;
use App\Models\MachineryPlanSub;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
            'machinery_lists_id' => ['required'],
            'machinery_plan_subs_listno' => ['required'],
        ]);  
        try{
            DB::beginTransaction();
            foreach ($request->machinery_plan_subs_listno as $key => $value) {
                MachineryPlanSub::insert([
                    'machinery_plans_id' => $request->machinery_plans_id,
                    'machinery_lists_id' => $request->machinery_lists_id,
                    'machinery_plan_subs_date' => Carbon::now(),
                    'machinery_plan_subs_listno' => $value,
                    'machinery_plan_subs_remark' => $request->machinery_plan_subs_remark[$key],
                    'machinery_plan_subs_flag' => true,
                    'person_at' => Auth::user()->name,
                    'created_at'=> Carbon::now(),
                    'updated_at'=> Carbon::now(),
                    'machinery_plan_subs_action' => false
                ]);                
            }
            MachineryPlan::where('machinery_plans_id',$request->machinery_plans_id)->update([
                'machinery_plans_status' => "N",
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
        if($data->machinery_plans_status === null){
            return view('machinerysetup.form-machineryplan-show', compact('data'));
        }elseif($data->machinery_plans_status === "N"){
            $sub = DB::table('machinery_plan_subs')->where('machinery_plans_id', $id)->get();
            return view('machinerysetup.form-machineryplan-update', compact('data','sub'));
        }
        
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
        $request->validate([
            'machinery_plans_id' => ['required'],
            'machinery_lists_id' => ['required'],
            'machinery_plan_subs_listno' => ['required'],
            'machinery_plan_subs_date' =>  ['required'],
        ]); 
        $data = [
            'machinery_plans_remark' => $request->machinery_plans_remark,
            'machinery_plans_date' => $request->machinery_plan_subs_date,
            'updated_at' => Carbon::now(),
        ];
        if ($request->hasFile('machinery_plans_file1')) {
            $data['machinery_plans_file1'] = $request->file('machinery_plans_file1')->storeAs('images/Machinery_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('machinery_plans_file1')->extension());
        }
        if ($request->hasFile('machinery_plans_file2')) {
            $data['machinery_plans_file2'] = $request->file('machinery_plans_file2')->storeAs('images/Machinery_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('machinery_plans_file2')->extension());
        }
        try{
            DB::beginTransaction();
            MachineryPlan::where('machinery_plans_id',$id)->update($data);
            foreach ($request->machinery_plan_subs_remark as $index => $remark) {
                MachineryPlanSub::updateOrCreate(
                    ['machinery_plan_subs_id' => $request->machinery_plan_subs_id[$index] ?? null],
                    [
                        'machinery_plans_id' => $id,
                        'machinery_lists_id' => $request->machinery_lists_id,
                        'machinery_plan_subs_listno' => $request->machinery_plan_subs_listno[$index],
                        'machinery_plan_subs_remark' => $remark,
                        'machinery_plan_subs_action' => $request->machinery_plan_subs_action[$index] ?? 0,
                        'machinery_plan_subs_date' => Carbon::now(),
                        'person_at' => Auth::user()->name,
                        'created_at'=> Carbon::now(),
                        'updated_at'=> Carbon::now(),
                    ]
                );
            }
            DB::commit();
            $dt = MachineryPlanSub::where('machinery_plan_subs_action',0)->where('machinery_plans_id',$id)->first();
            if($dt == null)
            {
                MachineryPlan::where('machinery_plans_id',$id)->update([
                    'machinery_plans_action' => 1,
                ]);
            }
            DB::commit();
            return redirect()->route('machineryplans.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
