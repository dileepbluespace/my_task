<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DataTables;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $query = Customer::query();
            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('sr_number', function($row){
                    $sr = $row->id;
                    return $sr;
                })
                ->addColumn('status', function($row){
                    $id = $row->id;
                    $url = route('customer.status', $row->id);
                    $btn = '';
                    if($row->status == 0){
                        $btn = ' <a href="javascript:void('.$row->id.');" class="changestatus" data-url="'.$url.'" data-status="'.$row->status.'"><span class="badge rounded-pill bg-success">Active</span></a>';
                    }else{
                        $btn = ' <a href="javascript:void('.$row->id.');" class="changestatus" data-url="'.$url.'" data-status="'.$row->status.'"><span class="badge rounded-pill bg-danger">Inactive</span></a>';
                    }
                    return $btn;
                })
                ->addColumn('action', function($row){
                    $editurl = Route('customer.edit',$row->id);
                    $updateUrl = Route('customer.update',$row->id);
                    $delurl = Route('customer.delete',$row->id);
                    $edit = ' <a href="javascript:void('.$row->id.');" class="edit" data-edit="'.$editurl.'" data-update="'.$updateUrl.'"><span class="badge rounded-pill bg-info"><i class="fa-regular fa-pen-to-square"></i></span></a>';
                    $delete = ' <a href="javascript:void('.$row->id.');" class="delete" data-url="'.$delurl.'" ><span class="badge rounded-pill bg-danger"><i class="fa-solid fa-trash"></i></span></a>';
                  
                    $btns = $edit . $delete;
                    return $btns;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.customer.customer');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request, $id)
    {
        $customer = Customer::where('id', $id)->first();
        if ($request->status == 0) {
            $customer = Customer::where('id', $id)->first();
            if ($customer) {
                $customer->update(['status' => 1]);
                return response()->json(['success' => 'Customer is now inactive']);
            } else {
                return response()->json(['error' => 'Customer not found'], 404);
            }
        } else {
            $customer = Customer::where('id', $id)->first();
            if ($customer) {
                $customer->update(['status' => 0]);
                return response()->json(['success' => 'Customer is now active']);
            } else {
                return response()->json(['error' => 'Customer not found'], 404);
            }
        }
       
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'age' => 'required',
            'salary' => 'required',
            'phone' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }

        $customer = new Customer;
        $customer->name = $request->name;
        $customer->age = $request->age;
        $customer->salary = $request->salary;
        $customer->phone = $request->phone;
        $customer->save();

        return response()->json(['success' => 'customer added successfuly']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        return response()->json($customer, 200);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'age' => 'required',
            'salary' => 'required',
            'phone' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()]);
        }

        $customer =Customer::find($id);
        $customer->name = $request->name;
        $customer->age = $request->age;
        $customer->salary = $request->salary;
        $customer->phone = $request->phone;
        $customer->save();

        return response()->json(['update' => 'customer updated successfuly']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,)
    {
      Customer::find($id)->delete();
      return  response()->json(['success' => 'Customer deleted successfuly!']);
    }
}
