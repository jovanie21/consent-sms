@extends('company.layout.app')
@section('title','Welcome')
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
                        <h4 class="page-title">Welcome {{ strToUpper(Auth::user()->name) }} </h4>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
                      </div>
                </div>
            </div>
        </div> <!-- container -->
    </div> <!-- content -->
    @endsection
