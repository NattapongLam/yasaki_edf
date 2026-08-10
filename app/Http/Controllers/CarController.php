<?php

namespace App\Http\Controllers;

use App\Models\DocCar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarController extends Controller
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
        $hd = DocCar::leftjoin('doc_statuses','doc_cars.doc_statuses_id','=','doc_statuses.doc_statuses_id')->get();
        return view('dcc.form-car-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = null;
        return view('dcc.form-car-create', compact('hd'));
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
            'doc_cars_relevant' => ['required'],
            'doc_cars_date' => ['required'],
            'doc_cars_docuno' => ['required'],
            'doc_cars_type' => ['required'],
            'doc_cars_issuingdep' => ['required'],
            'doc_cars_relevantdep' => ['required'],
            'doc_cars_person' => ['required'],
            'doc_cars_topics' => ['required'],
            'doc_cars_defects' => ['required'],
            'doc_cars_problem' => ['required'],
        ]);  
        $data = [
            'doc_cars_relevant' => $request->doc_cars_relevant,
            'doc_cars_date' => $request->doc_cars_date,
            'doc_cars_docuno' => $request->doc_cars_docuno,
            'doc_cars_type' => $request->doc_cars_type,
            'doc_cars_issuingdep' => $request->doc_cars_issuingdep,
            'doc_cars_relevantdep' => $request->doc_cars_relevantdep,
            'doc_cars_person' => $request->doc_cars_person,
            'doc_cars_topics' => $request->doc_cars_topics,
            'doc_cars_defects' => $request->doc_cars_defects,
            'doc_cars_problem' => $request->doc_cars_problem,
            'doc_statuses_id' => 1,
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ];
        try{
            DB::beginTransaction();
            $insertHD = DocCar::create($data);               
            DB::commit();
            return redirect()->route('car.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
}
