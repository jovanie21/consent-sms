@extends('company.layout.app')
@section('title','Edit Company')
@push('headerscript')

<link href="{{ asset('theme/plugins/summernote/summernote.css') }}" rel="stylesheet" />
<style>
    .summernote {
        position: absolute;
        flex: initial;
    }
</style>
@endpush
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
                        <h4 class="page-title">Edit <span class="text-primary">{{ strToUpper($user->name) }}'s</span> Details</h4>
                        <a href="{{ url('company/employee') }}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-backward"></i> Back</a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <h4 class="text-primary" style="text-decoration:underline;">Basic Details</h4>
                        <br>
                        {!! Form::model($row, ['method'=>'patch','files'=>true,'route' => ['employee.update', $user->id]]) !!}
                        @csrf
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label class="">Name<i class="text-danger ">*</i></label>
                                <input type="text" name="name" value="{{ old('name',$user->name) }}" class="form-control" required="">
                                <div class="text-danger">{{ $errors->first('name') }}</div>
                            </div>
                            <div class="col-sm-6">
                                <label class="">Mobile Number<i class="text-danger ">*</i></label>
                                <input type="text" class="form-control number" name="phone" required="" minlength="10" maxlength="10" value="{{ old('phone',$row->phone_no) }}">
                                <div class="text-danger">{{ $errors->first('phone') }}</div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label class="">Email<i class="text-danger ">*</i></label>
                                <input type="email" name="email" id="email" class="form-control" required="" value="{{ old('email',$user->email)}}">
                                <div class="text-danger">{{ $errors->first('email') }}</div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label class="">City<i class="text-danger ">*</i></label>
                                <input type="text" name="city" value="{{ old('city',$row->city)}}" class="form-control" required="">
                                <div class="text-danger">{{ $errors->first('city') }}</div>
                            </div>
                            <div class="col-sm-6">
                                <label class="">State<i class="text-danger ">*</i></label>
                                <input type="text" class="form-control" name="state" required="" value="{{ old('state',$row->state) }}">
                                <div class="text-danger">{{ $errors->first('state') }}</div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label class="">Country<i class="text-danger ">*</i></label>
                                <input type="text" name="country" value="{{ old('country',$row->country) }}" class="form-control" required="">
                                <div class="text-danger">{{ $errors->first('country') }}</div>
                            </div>
                            <div class="col-sm-6">
                                <label class="">Zip code<i class="text-danger ">*</i></label>
                                <input type="text" class="form-control" name="zip_code" required="" value="{{ old('zip_code',$row->zipcode) }}">
                                <div class="text-danger">{{ $errors->first('zip_code') }}</div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label class="">Address<i class="text-danger ">*</i></label>
                                <textarea class="form-control" name="address">{{ old('address',$row->address) }}</textarea>
                                <div class="text-danger">{{ $errors->first('address') }}</div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12">
                                <div class="col-sm-10">
                                    <input type="submit" name="submit" class="btn btn-sm btn-primary" value="Submit">
                                    <input type="reset" name="reset" value="Cancel" class="btn btn-sm btn-default">
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- container -->
    </div> <!-- content -->
</div>
@endsection
@push('footerscript')

<script>
    $('.number').keyup(function(e) {
        if (/\D/g.test(this.value)) {
            this.value = this.value.replace(/\D/g, '');
        }
    });
</script>

@endpush