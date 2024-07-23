@extends('superadmin.layout.app')
@section('title','Profile')
@section('content')
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Profile </h4>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-border panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Profile Details</h3>
                        </div>
                        <div class="panel-body">
                         <form method="post" action="{{ url('superadmin/profile/update') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group ">
                                        <label >Name*</label>
                                        <input type="text" name="name" value="{{ old('name',Auth::user()->name) }}" class="form-control" required="">
                                        <div class="text-danger">{{ $errors->first('name')}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label >Email</label>
                                        <input type="email" readonly  name="email" value="{{ old('email',Auth::user()->email) }}" class="form-control" required="">
                                        <div class="text-danger">{{ $errors->first('email')}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="reset" name="cancel" class="btn btn-default m-t-10 btn-sm" value="Cancel">&nbsp;
                                        <input type="submit" name="submit" class="btn btn-primary m-t-10 btn-sm" value="Submit">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-border panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Change Password</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{ url('superadmin/profile/updatepassword') }}">
                            @csrf
                            <div class="row">

                                <div class="form-group col-sm-12">
                                    <label >Old Password</label>
                                    <input type="password" name="oldpassword" value="" class="form-control" required="">
                                    <div class="text-danger">{{ $errors->first('oldpassword')}}</div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="form-group col-sm-12">
                                    <label >New Password</label>
                                    <input type="password" name="password" value="" class="form-control" required="">
                                    <div class="text-danger">{{ $errors->first('password')}}</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label >Confirm Password</label>
                                    <input type="password" name="password_confirmation" value="" class="form-control" required="">
                                    <div class="text-danger">{{ $errors->first('password_confirmation')}}</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                 <input type="reset" name="cancel" class="btn btn-default m-t-10 btn-sm" value="Cancel">
                                 <input type="submit" name="submit" class="btn btn-primary m-t-10 btn-sm" value="Submit">
                             </div>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div> <!-- container -->
</div> <!-- content -->
</div>

@endsection
