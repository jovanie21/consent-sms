<?php

namespace App\Http\Controllers\company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\EmployeeDetail;
use App\Models\User;

class EmployeeController extends Controller
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
        })->where('company_id', Auth::user()->company_id)->get();
        return view('company.employee.index', compact('query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.employee.create');
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
        $user->company_id = Auth::user()->company_id;
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
        return redirect()->route('employee.index');
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
        $row = EmployeeDetail::find($id);
        $user = User::where('id', $row->user_id)->first();
        return view('company.employee.edit', compact('row', 'user'));
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'address' => 'required',
            'zip_code' => 'required',
        ]);
        $user = User::find($id);
        $user->company_id = Auth::user()->company_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $employee = EmployeeDetail::where('user_id', $user->id)->first();;
        $employee->phone_no = $request->phone;
        $employee->city = $request->city;
        $employee->state = $request->state;
        $employee->address = $request->address;
        $employee->country = $request->country;
        $employee->zipcode = $request->zip_code;
        $employee->save();
        session()->flash('success_msg', 'Employee has been Updated successfully');
        return redirect()->route('employee.index');
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
