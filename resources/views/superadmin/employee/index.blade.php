@extends('superadmin.layout.app')
@section('title','Employee')
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
                        <h4 class="page-title">Employee</h4>
                        <a href="{{ url('superadmin/superemployee/create') }}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Add New</a>
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
                                        <th>Address</th>
                                        <th>city</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>Zip</th>
                                        <th>Created At</th>
                                        <th>Updated_at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach($query as $r)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $r->name }}</td>
                                    <td>{{ $r->email }}</td>
                                    <td>{{ $r->actual_password }}</td>
                                    <td>{{ $r->phone_no }}</td>
                                    <th>{{ $r->address }}</th>
                                    <td>{{ $r->city }}</td>
                                    <td>{{ $r->state }}</td>
                                    <td>{{ $r->country }}</td>
                                    <td>{{ $r->zipcode }}</td>
                                    <td>{{ date('D M Y',strtotime($r->created_at)) }}</td>
                                    <td>{{ date('D M Y',strtotime($r->updated_at)) }}</td>
                                    <td>
                                        <form method="POST" action="{{route('superemployee.destroy',$r->user_id)}}">
                                            {{csrf_field()}}{{method_field('delete')}}
                                            <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure?')">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
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
