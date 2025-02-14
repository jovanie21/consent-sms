@extends('superadmin.layout.app')
@section('title','Companies')
@push('headerscript')
<link href="{{ asset('theme/plugins/bootstrap-sweetalert/sweet-alert.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('theme/plugins/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/plugins/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
    div.dataTables_wrapper div.dataTables_processing {
        top: 0;
        color: red;
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
                        <h4 class="page-title">Companies </h4>
                        <a href="{{ url('superadmin/company/create') }}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Add New</a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">

                <div class="col-xs-12">
                    <div class="card-box">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" id="datatables">
                                <thead>
                                    <tr>
                                        <th>S.NO.</th>
                                        <th>Name</th>
                                        <th>Email ID</th>
                                        <th>Actual Password</th>
                                        <th>Phone Number</th>
                                        <th>Company Name</th>
                                        <th>Company Zip</th>
                                        <th>Created At</th>
                                        <th>Updated_at</th>
					<th>Action</th>
				</tr>
                                </thead>
                                @foreach($company as $r)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $r->name }}</td>
                                    <td>{{ $r->email }}</td>
                                    <td>{{ $r->actual_password }}</td>
                                    <td>{{ $r->phone_number }}</td>
                                    <td>{{ $r->company_name }}</td>
                                    <td>{{ $r->company_zip }}</td>
                                    <td>{{ date('d F Y',strtotime($r->created_at)) }}</td>
                                    <td>{{ date('d F Y',strtotime($r->updated_at)) }} </td>
				                                     <td> @if($r->status == 1)
                                    <a href="{{ url("superadmin/changepdfactive/$r->id") }}" class="btn btn-success btn-sm">Show Pdf to Company</a>
                                   @else
                                  <a href="{{ url("superadmin/changetodeactive/$r->id") }}" class="btn btn-danger btn-sm">Hide Pdf to Company</a> 
                                  @endif 
                                <a href="{{ url("superadmin/companyconsentsms/$r->id") }}" class="btn btn-danger btn-sm">Group Details</a>
                                </td>
				   </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container -->
    </div> <!-- content -->
</div>
@endsection
@push('footerscript')
<script src="{{ asset('theme/plugins/bootstrap-sweetalert/sweet-alert.min.js')}}"></script>
<script src="{{ asset('theme/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('theme/plugins/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('theme/plugins/datatables/dataTables.bootstrap.js')}}"></script>
<script type="text/javascript">
    $(function() {
        $('#datatables').DataTable();
    });
</script>
@endpush
