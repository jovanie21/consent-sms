<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\user;
use DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = User::join('companies', 'users.company_id', 'companies.id')->select([
    DB::raw('companies.id as id'),
     'users.name',
     'users.email',
     'users.actual_password',
     'companies.phone_number',
     'companies.company_name',
     'companies.company_zip',
     'companies.created_at',
     'companies.updated_at',
     'companies.status',
     ])->whereHas('roles', function ($q) {
            $q->where('name', 'company');
        })->get();
        return view('superadmin.company.index',compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superadmin.company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|unique:users',
            'phone'=>'required',
            'company_name'=>'required',
            'company_zip'=>'required',
            'company_address'=>'required',
            'password'=>'required',
        ]);
        $company=new Company;
        $company->phone_number=$request->phone;
        $company->company_name=$request->company_name;
        $company->company_zip=$request->company_zip;
        $company->company_address=$request->company_address;
        $company->save();


        $user=new User;
        $user->company_id=$company->id;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->actual_password=$request->password;
        $user->password=bcrypt($request->password);
        $user->assignRole('company');
        $user->save();

        session()->flash('success_msg','company has been Added successfully');
        return redirect()->route('company.index');
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
        $row=User::find($id);
        $company=Company::where('id',$row->company_id)->first();

        return view('superadmin.company.edit',compact('row','company'));
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
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'company_name'=>'required',
            'company_zip'=>'required',
            'company_address'=>'required',
        ]);
           $user=User::find($id);
           $user->name=$request->name;
           $user->email=$request->email;
           $user->save();
           $company=Company::where('id',$user->company_id)->first();
           $company->phone_number=$request->phone;
           $company->company_name=$request->company_name;
           $company->company_zip=$request->company_zip;
           $company->company_address=$request->company_address;
           $company->save();
           session()->flash('success_msg','Company has been updated successfully');
           return redirect()->route('company.index');
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
