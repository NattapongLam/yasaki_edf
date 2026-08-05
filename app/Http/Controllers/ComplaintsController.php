<?php

namespace App\Http\Controllers;

use App\Models\ArCustomerList;
use App\Models\CustomerComplaintsList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ComplaintsController extends Controller
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
        $hd = CustomerComplaintsList::leftjoin('ar_customer_lists','customer_complaints_lists.ar_customer_lists_id','=','ar_customer_lists.ar_customer_lists_id')
        ->where('customer_complaints_lists_flag',true)
        ->get();
        return view('customers.form-complaints-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cust = ArCustomerList::where('ar_customer_lists_flag',true)->get();
        return view('customers.form-complaints-create', compact('cust'));
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
            'customer_complaints_lists_date' => ['required'],
            'customer_complaints_lists_refdocuno' => ['required'],
            'ar_customer_lists_id' => ['required'],
            'customer_complaints_lists_details' => ['required'],
        ]); 
        $data = [
            'customer_complaints_lists_date' => $request->customer_complaints_lists_date,
            'customer_complaints_lists_refdocuno' => $request->customer_complaints_lists_refdocuno,
            'ar_customer_lists_id' => $request->ar_customer_lists_id,
            'customer_complaints_lists_details' => $request->customer_complaints_lists_details,
            'customer_complaints_lists_flag' => true,
            'person_at' => Auth::user()->name,
            'created_at' =>  Carbon::now(),
            'updated_at' =>  Carbon::now(),
        ];
        try{
            DB::beginTransaction();
            $insertHD = CustomerComplaintsList::create($data);                  
            DB::commit();
            return redirect()->route('complaints.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = CustomerComplaintsList::find($id);
        $cust = ArCustomerList::where('ar_customer_lists_flag',true)->get();
        return view('customers.form-complaints-edit', compact('cust','hd'));
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
        if($request->checkdoc == "Edit"){
            $data = [
                'customer_complaints_lists_type' => $request->customer_complaints_lists_type,
                'customer_complaints_lists_level' => $request->customer_complaints_lists_level,
                'customer_complaints_lists_causes' => $request->customer_complaints_lists_causes,
                'customer_complaints_lists_issue' => $request->customer_complaints_lists_issue,
                'customer_complaints_lists_prevention' => $request->customer_complaints_lists_prevention,
                'customer_complaints_lists_additional' => $request->customer_complaints_lists_additional,
                'customer_complaints_lists_datestart' => $request->customer_complaints_lists_datestart,
                'customer_complaints_lists_duedate' => $request->customer_complaints_lists_duedate,
                'customer_complaints_lists_responsible' => $request->customer_complaints_lists_responsible
            ];
            try{
                DB::beginTransaction();
                $insertHD = CustomerComplaintsList::where('customer_complaints_lists_id',$id)->update($data);                  
                DB::commit();
                return redirect()->route('complaints.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            }catch(\Exception $e){
                Log::error($e->getMessage());
                dd($e->getMessage());
                return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
            }  
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

    public function CancelComplaints(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            CustomerComplaintsList::where('customer_complaints_lists_id',$id)->update([
                'customer_complaints_lists_flag' => 0,
                'person_at' => Auth::user()->name,
                'updated_at'=> Carbon::now(),
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'ยกเลิกรายการเรียบร้อยแล้ว'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
