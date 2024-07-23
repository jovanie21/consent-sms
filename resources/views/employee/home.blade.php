@extends('employee.layout.app')
@section('title','Welcome Employee')
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
                        <h4 class="page-title">Welcome <span class="text-primary">{{ strToUpper(Auth::user()->name) }}</span> </h4>
                        <div class="clearfix"></div>
                    </div>
				</div>
			</div>
            <!-- end row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="card-box">
                      <div class="row">

                        </div>
                        <!-- end row -->
                    </div>
                </div>
            </div>

        </div> <!-- container -->
    </div> <!-- content -->
    @endsection
