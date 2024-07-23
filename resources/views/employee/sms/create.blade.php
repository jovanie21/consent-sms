@extends('employee.layout.app')

@section('title','Create SMS')

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

            <h4 class="page-title">Create SMS</h4>

            <a href="{{ route('sms.index') }}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-backward"></i> Back</a>

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

            <form method="post" action="{{ route('sms.store') }}" class="form-validate-summernote" enctype="multipart/form-data">

              @csrf

              <div class="row form-group">

                <div class="col-sm-6">

                  <label class="">First Name<i class="text-danger ">*</i></label>

                  <input type="text" name="firstname" value="{{ old('name') }}" class="form-control" required="">

                  <div class="text-danger">{{ $errors->first('name') }}</div>

                </div>

                <div class="col-sm-6">

                  <label class="">Last Name<i class="text-danger ">*</i></label>

                  <input type="text" name="lastname" value="{{ old('name') }}" class="form-control" required="">

                  <div class="text-danger">{{ $errors->first('name') }}</div>

                </div>

                </div>

              <div class="row form-group">

                <div class="col-sm-6">

                  <label class="">Email<i class="text-danger ">*</i></label>

                  <input type="email" name="email" id="email" value="" class="form-control" required="">

                  <div class="text-danger">{{ $errors->first('email') }}</div>

                </div>

                <div class="col-sm-6">

                  <label class="">Wireless Number<i class="text-danger ">*</i></label>

                  <input type="text" class="form-control number" name="wphone" required="" minlength="10" maxlength="10" value="{{ old('phone') }}">

                  <div class="text-danger">{{ $errors->first('wphone') }}</div>

                </div>

              </div>

              <div class="row form-group">

              <div class="col-sm-6">

                  <label class="">Home Number<i class="text-danger ">*</i></label>

                  <input type="text" class="form-control number" name="hphone" required="" minlength="10" maxlength="10" value="{{ old('phone') }}">

                  <div class="text-danger">{{ $errors->first('hphone') }}</div>

                </div>



                <div class="col-sm-6">

                  <label class="">Address<i class="text-danger ">*</i></label>

                  <input type="text" name="address" value="{{ old('city') }}" class="form-control" required="">

                  <div class="text-danger">{{ $errors->first('city') }}</div>

                </div>

		</div>

		<div class="row form-group">

                <div class="col-sm-6">

                  <label class="">Zip Code<i class="text-danger ">*</i></label>

                  <input type="text" class="form-control number" name="zipcode" required=""  value="{{ old('phone') }}">

                  <div class="text-danger">{{ $errors->first('zipcode') }}</div>

                </div>



                <div class="col-sm-6">

                  <label class="">City<i class="text-danger ">*</i></label>

                  <input type="text" name="city" value="{{ old('city') }}" class="form-control" required="">

                  <div class="text-danger">{{ $errors->first('city') }}</div>

                </div>

              </div>



	 <div class="row form-group">

                <div class="col-sm-12">

                  <label class="">State<i class="text-danger ">*</i></label>

                  <input type="text" name="state" value="{{ old('state') }}" class="form-control" required="">

                  <div class="text-danger">{{ $errors->first('state') }}</div>

                </div>

        </div>



	<div class="row form-group">

                <div class="col-sm-12">

                  <label class="">Message to be sent Via SMS<i class="text-danger ">*</i></label>

                  <input type="text" name="message" value="Please click here to confirm the information is correct and you give the Consent to Contact" class="form-control" required="">

                  <div class="text-danger">{{ $errors->first('message') }}</div>

                </div>

	</div>

              <div class="row form-group">

                <div class="col-sm-12">

                  <div class="col-sm-10">

                  <input type="submit" name="submit" id="sms" class="btn btn-sm btn-primary" value="Send SMS">

                  <input type="submit" name="submit" id="email" class="btn btn-sm btn-primary" value="Send Email">

                  <input type="submit" name="submit" id="both" class="btn btn-sm btn-primary" value="Send both">

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

  function myFunction() {

    var x = document.getElementById("password");

    if (x.type === "password") {

      x.type = "text";

      $('#eye').hide();

      $('#eye_one').show();

    } else {

      x.type = "password";

      $('#eye_one').hide();

      $('#eye').show();

    }

  }

</script>



<script>

  $('.number').keyup(function(e) {

    if (/\D/g.test(this.value)) {

      this.value = this.value.replace(/\D/g, '');

    }

  });

</script>



@endpush


