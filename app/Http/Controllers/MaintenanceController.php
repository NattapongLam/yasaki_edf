<?php

namespace App\Http\Controllers;

use App\Models\CalibrationList;
use App\Models\MachineryList;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
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
        $hd = null;
        return view('machinerysetup.form-maintenances-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = null;
        return view('machinerysetup.form-maintenances-create', compact('hd'));
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
    public function getItems(Request $request)
    {
        $type = $request->query('type');
        $items = [];

        if ($type === 'CAL') {
            // ดึงข้อมูลจากตาราง CalibrationList (ปรับชื่อ column ตามจริง เช่น name, code)
            $items = CalibrationList::select('calibration_lists_id as id', 'calibration_lists_name1 as name')->get(); 
        } elseif ($type === 'MC') {
            // ดึงข้อมูลจากตาราง MachineryList
            $items = MachineryList::select('machinery_lists_id as id', 'machinery_lists_name1 as name')->get();
        }

        return response()->json([
            'status' => 'success',
            'items' => $items
        ]);
    }
}
