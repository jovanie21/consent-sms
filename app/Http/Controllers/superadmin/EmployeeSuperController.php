<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sms;
use Auth;
use App\Models\EmployeeDetail;
use App\Models\Company;
class EmployeeSuperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = User::join('employee_details', 'users.id', 'employee_details.user_id')->whereHas('roles', function ($q) {
            $q->where('name', 'employee');
        })->get();
        return view('superadmin.employee.index',compact('query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = Company::pluck('company_name', 'id')->toArray();
        return view('superadmin.employee.create',compact('company'));
    }

     public function deletesms($id)
    {
        $sms = Sms::find($id);       
        $sms->delete();
        session()->flash('success_msg', 'Sms has been deleted successfully');
        return redirect('/superadmin/superadminsms');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'address' => 'required',
            'zip_code' => 'required',
            'password' => 'required',
        ]);
        $user = new User;
        $user->company_id = $request->company;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->actual_password = $request->password;
        $user->password = bcrypt($request->password);
        $user->assignRole('employee');
        $user->save();

        $employee = new EmployeeDetail;
        $employee->user_id = $user->id;
        $employee->created_by = Auth::user()->id;
        $employee->phone_no = $request->phone;
        $employee->city = $request->city;
        $employee->state = $request->state;
        $employee->address = $request->address;
        $employee->country = $request->country;
        $employee->zipcode = $request->zip_code;
        $employee->save();

        session()->flash('success_msg', 'Employee has been Added successfully');
        return redirect()->route('superemployee.index');
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
        $user = User::find($id);
        $employee = EmployeeDetail::where('user_id',$id)->first();
        $employee->delete(); 
        $user->delete();         
        return redirect('/superadmin/superemployee');
    }
}
