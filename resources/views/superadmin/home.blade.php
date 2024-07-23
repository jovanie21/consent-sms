@extends('superadmin.layout.app')
@section('title','Welcome SuperAdmin')
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
            <div class="row">
                <div class="col-xs-12">
                    <div class="card-box">
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <a href="{{ route('company.index') }}" target="_blank">
                                    <div class="card-box widget-box-two widget-two-primary">
                                        <i class="fa fa-users widget-two-icon"></i>
                                        <div class="wigdet-two-content">
                                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Statistics">Total Company</p>
                                            <h2><span data-plugin="counterup"></span>{{$company}} </h2>
                                        </div>
                                    </div>
                                </a>
                            </div><!-- end col -->
                            <div class="col-lg-4 col-md-4">
                                <a href="{{ route('superemployee.index') }}" target="_blank">
                                    <div class="card-box widget-box-two widget-two-warning">
                                        <i class="fa fa-user widget-two-icon"></i>
                                        <div class="wigdet-two-content">
                                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User This Month">Total Employees</p>
                                            <h2><span data-plugin="counterup"> </span> {{ $employee }}</h2>
                                        </div>
                                    </div>
                                </a>
                            </div><!-- end col -->
                            <div class="col-lg-4 col-md-4">
                                <a href="{{ url('superadmin/superadminsms') }}" target="_blank">
                                    <div class="card-box widget-box-two widget-two-danger">
                                        <i class="fa fa-user widget-two-icon"></i>
                                        <div class="wigdet-two-content">
                                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User This Month">Total SMS Sent</p>
                                            <h2><span data-plugin="counterup"></span>{{ $sms }}</h2>
                                        </div>
                                    </div>
                                </a>
                            </div><!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                </div>
            </div>
        </div> <!-- container -->
    </div> <!-- content -->
    @endsection