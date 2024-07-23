<?php

namespace App\Http\Controllers\company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
class ProfileController extends Controller
{
    //
    public function index()
    {
        $user=Auth::user();
        // dd($user);
       return view('company.profile.index',compact('user'));
    }

    public function update(request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required',
        ]);
        $data=Auth::user();
        $data->name=$request->name;
        $data->email=$request->email;
        $data->save();
         session()->flash('success_msg','profile has been Updated');
       return redirect('company/profile');
    }

    public function updatepassword(Request $request){
        $this->validate($request, [
            'oldpassword'=>'required',
            'password'=>'required|min:6|confirmed',
        ]);
        $user=Auth::user();
        $oldpassword=$user->password;
        if(Hash::check($request->oldpassword,$oldpassword)){
            $user->fill([
                'password'=>bcrypt($request->password), 
                'actual_password'=>$request->password
            ])->save();
            session()->flash('success_msg','Password has been Updated');
            return back();
        }
        else{
            session()->flash('success_msg','Something went wrong');
             return back();
        }

    }

}
