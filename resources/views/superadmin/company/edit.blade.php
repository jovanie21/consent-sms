@extends('superadmin.layout.app')
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
                        <h4 class="page-title">Edit <span class="text-primary">{{ strToUpper($row->name) }}'s</span> Details</h4>
                        <a href="{{ url('superadmin/company') }}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-backward"></i> Back</a>
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
                        {!! Form::model($row, ['method'=>'patch','files'=>true,'route' => ['company.update', $row->id]]) !!}
                        @csrf
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label class="">Name<i class="text-danger ">*</i></label>
                                <input type="text" name="name" value="{{ old('name',$row->name) }}" class="form-control" required="">
                                <div class="text-danger">{{ $errors->first('name') }}</div>
                            </div>
                            <div class="col-sm-6">
                                <label class="">Mobile Number<i class="text-danger ">*</i></label>
                                <input type="text" class="form-control number" name="phone" required="" minlength="10" maxlength="10" value="{{ old('phone',$company->phone_number) }}">
                                <div class="text-danger">{{ $errors->first('phone') }}</div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label class="">Email<i class="text-danger ">*</i></label>
                                <input type="email" name="email" id="email" class="form-control" required="" value="{{ old('email',$row->email)}}">
                                <div class="text-danger">{{ $errors->first('email') }}</div>
                            </div>
                        </div>
                        <hr>
                        <h4 class="text-primary" style="text-decoration:underline;">Company Details</h4>
                        <br>
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label class="">Company Name<i class="text-danger ">*</i></label>
                                <input type="company_name" name="company_name" id="company_name" value="{{ old('company_name',$company->company_name) }}" class="form-control" required="">
                                <div class="text-danger">{{ $errors->first('company_name') }}</div>
                            </div>
                            <div class="col-sm-6">
                                <label class="">Company Zip<i class="text-danger ">*</i></label>
                                <input type="company_zip" name="company_zip" id="company_zip" value="{{ old('company_zip',$company->company_zip) }}" class="form-control number" required="">
                                <div class="text-danger">{{ $errors->first('company_zip') }}</div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label class="">Dialplan Entry<i class="text-danger ">*</i></label>
                                <textarea class="form-control" name="company_address">{{ old('address',$company->company_address) }}</textarea>
                                <div class="text-danger">{{ $errors->first('company_address') }}</div>
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