<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\WhProductList;
use App\Models\WhProductType;
use App\Models\WhProductUnit;
use App\Models\WhProductGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class WhProductListController extends Controller
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
        $hd = WhProductList::get();
        return view('productsetup.form-productlist-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = WhProductGroup::get();
        $types = WhProductType::get();
        $units = WhProductUnit::get();
        return view('productsetup.form-productlist-create', compact('groups','types','units'));
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
            'wh_product_types_id' => ['required'],
            'wh_product_groups_id' => ['required'],
            'wh_product_units_id' => ['required'],
            'wh_product_lists_code' => ['required'],
            'wh_product_lists_name1' => ['required'],
        ]);
        $data = [
            'wh_product_types_id' => $request->wh_product_types_id,
            'wh_product_groups_id' => $request->wh_product_groups_id,
            'wh_product_units_id' => $request->wh_product_units_id,
            'wh_product_lists_code' => $request->wh_product_lists_code,
            'wh_product_lists_name1' => $request->wh_product_lists_name1,
            'wh_product_lists_name2' => $request->wh_product_lists_name2,
            'wh_product_lists_remark' => $request->wh_product_lists_remark,
            'wh_product_lists_cost' => $request->wh_product_lists_cost,
            'wh_product_lists_price' => $request->wh_product_lists_price,
            'wh_product_lists_min' => $request->wh_product_lists_min,
            'wh_product_lists_max' => $request->wh_product_lists_max,
            'wh_product_lists_moq' => $request->wh_product_lists_moq,
            'wh_product_lists_timeline' => $request->wh_product_lists_timeline,
            'wh_product_lists_flag' => 1,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now(), 
        ];
        if ($request->hasFile('wh_product_lists_file1')) {
            $data['wh_product_lists_file1'] = $request->file('wh_product_lists_file1')->storeAs('images/Product_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('wh_product_lists_file1')->extension());
        }
        if ($request->hasFile('wh_product_lists_file2')) {
            $data['wh_product_lists_file2'] = $request->file('wh_product_lists_file2')->storeAs('images/Product_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('wh_product_lists_file2')->extension());
        }
        if ($request->hasFile('wh_product_lists_file3')) {
            $data['wh_product_lists_file3'] = $request->file('wh_product_lists_file3')->storeAs('images/Product_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('wh_product_lists_file3')->extension());
        }
        if ($request->hasFile('wh_product_lists_file4')) {
            $data['wh_product_lists_file4'] = $request->file('wh_product_lists_file4')->storeAs('images/Product_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('wh_product_lists_file4')->extension());
        }
        try
        {
            DB::beginTransaction();
            $insertHD = WhProductList::create($data);               
            DB::commit();
            return redirect()->route('productlists.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = WhProductList::find($id);
        $groups = WhProductGroup::get();
        $types = WhProductType::get();
        $units = WhProductUnit::get();
        return view('productsetup.form-productlist-edit', compact('groups','types','units','hd'));
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
            'wh_product_types_id' => ['required'],
            'wh_product_groups_id' => ['required'],
            'wh_product_units_id' => ['required'],
            'wh_product_lists_name1' => ['required'],
        ]);
        $flag = $request->wh_product_lists_flag;
        if($flag == true){
            $flag = 1;
        }else{
            $flag = 0;
        }
        $data = [
            'wh_product_types_id' => $request->wh_product_types_id,
            'wh_product_groups_id' => $request->wh_product_groups_id,
            'wh_product_units_id' => $request->wh_product_units_id,
            'wh_product_lists_name1' => $request->wh_product_lists_name1,
            'wh_product_lists_name2' => $request->wh_product_lists_name2,
            'wh_product_lists_remark' => $request->wh_product_lists_remark,
            'wh_product_lists_cost' => $request->wh_product_lists_cost,
            'wh_product_lists_price' => $request->wh_product_lists_price,
            'wh_product_lists_min' => $request->wh_product_lists_min,
            'wh_product_lists_max' => $request->wh_product_lists_max,
            'wh_product_lists_moq' => $request->wh_product_lists_moq,
            'wh_product_lists_timeline' => $request->wh_product_lists_timeline,
            'wh_product_lists_flag' => $flag,
            'person_at' => Auth::user()->name,
            'updated_at' => Carbon::now(), 
        ];
        if ($request->hasFile('wh_product_lists_file1')) {
            $data['wh_product_lists_file1'] = $request->file('wh_product_lists_file1')->storeAs('images/Product_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('wh_product_lists_file1')->extension());
        }
        if ($request->hasFile('wh_product_lists_file2')) {
            $data['wh_product_lists_file2'] = $request->file('wh_product_lists_file2')->storeAs('images/Product_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('wh_product_lists_file2')->extension());
        }
        if ($request->hasFile('wh_product_lists_file3')) {
            $data['wh_product_lists_file3'] = $request->file('wh_product_lists_file3')->storeAs('images/Product_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('wh_product_lists_file3')->extension());
        }
        if ($request->hasFile('wh_product_lists_file4')) {
            $data['wh_product_lists_file4'] = $request->file('wh_product_lists_file4')->storeAs('images/Product_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('wh_product_lists_file4')->extension());
        }
        try
        {
            DB::beginTransaction();
            $insertHD = WhProductList::where('wh_product_lists_id',$id)->update($data);               
            DB::commit();
            return redirect()->route('productlists.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $prefix = strval($req->grp) . strval($req->typ);
        $last = DB::table('wh_product_lists')
            ->where('wh_product_lists_code', 'like', $prefix . '%')
            ->orderBy('wh_product_lists_code', 'desc')
            ->first();

        if ($last) {
            $lastRunning = intval(substr($last->wh_product_lists_code, -4)) + 1;
        } else {
            $lastRunning = 001;
        }
        return [
            'running' => str_pad($lastRunning, 3, '0', STR_PAD_LEFT)
        ];
    }
}
