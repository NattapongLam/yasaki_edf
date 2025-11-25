<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AccCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AccCompanyController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = AccCompany::get();
        return view('accounts.form-company-create', compact('hd'));
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
            'acc_companies_name1' => ['required'],
            'acc_companies_address1' => ['required'],
            'acc_companies_taxid' => ['required'],
            'acc_companies_tel' => ['required'],
            'acc_companies_email' => ['required'],
        ]);
        $data = [
            'acc_companies_name1' => $request->acc_companies_name1,
            'acc_companies_name2' => $request->acc_companies_name2,
            'acc_companies_address1' => $request->acc_companies_address1,
            'acc_companies_address2' => $request->acc_companies_address2,
            'acc_companies_taxid' => $request->acc_companies_taxid,
            'acc_companies_tel' => $request->acc_companies_tel,
            'acc_companies_email' => $request->acc_companies_email,
            'acc_companies_line' => $request->acc_companies_line,
            'acc_companies_website' => $request->acc_companies_website,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        try{
            DB::beginTransaction();
            $insertHD = AccCompany::create($data);               
            DB::commit();
            return redirect()->route('companys.create')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = AccCompany::find($id);
        return view('accounts.form-company-edit', compact('hd'));
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
            'acc_companies_name1' => ['required'],
            'acc_companies_address1' => ['required'],
            'acc_companies_taxid' => ['required'],
            'acc_companies_tel' => ['required'],
            'acc_companies_email' => ['required'],
        ]);
        $data = [
            'acc_companies_name1' => $request->acc_companies_name1,
            'acc_companies_name2' => $request->acc_companies_name2,
            'acc_companies_address1' => $request->acc_companies_address1,
            'acc_companies_address2' => $request->acc_companies_address2,
            'acc_companies_taxid' => $request->acc_companies_taxid,
            'acc_companies_tel' => $request->acc_companies_tel,
            'acc_companies_email' => $request->acc_companies_email,
            'acc_companies_line' => $request->acc_companies_line,
            'acc_companies_website' => $request->acc_companies_website,
            'person_at' => Auth::user()->name,
            'updated_at' => Carbon::now(),
        ];
        try{
            DB::beginTransaction();
            $insertHD = AccCompany::where('acc_companies_id',$id)->update($data);               
            DB::commit();
            return redirect()->route('companys.create')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
