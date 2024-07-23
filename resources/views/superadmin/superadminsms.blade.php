@extends('superadmin.layout.app')
@section('title','SMS')
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
                        <h4 class="page-title">SMS</h4>
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
                                        <th>View Consent PDF</th>
                                        <th>Consent form status</th>
                                        <th>Resend</th>
                                        <th>Send By</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email ID</th>
                                        <th>Message</th>
                                        <th>Home Phone Number</th>
                                        <th>Wireless Number</th>
                                        <th>Address</th>
                                        <th>Zip Code</th>
                                        <th>City</th>
                                        <th>Created At</th>
                                        <th>Updated_at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach($sms as $r)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><button onclick="checkreport({{ $r->wphone}},{{ $loop->iteration }})" id="checkreportbutton_{{ $loop->iteration }}" class="btn btn-danger btn-sm"> View Consent form</button></td>
                                    <td>
                                        @if($r->submition_status==1)<label class="label label-danger">Not Submitted</label>
                                        @else <label class="label label-success">Submitted</label>
                                        @endif
                                    </td>
                                    <td>{{ $r->name }}</td>
                                    
                                    <td>
                                    @if($r->submition_status==1)
                                        <form method="post" action={{ url( "superadmin/resendsmsadmin",$r->id) }}>
                                            @csrf
                                            <input type="submit" name="submit" id="sms" class="btn btn-default btn-sm" value="Send Sms" ><br><br>
                                            <input type="submit" name="submit" id="email" class="btn btn-default btn-sm" value="Send Email"><br><br>
                                            <input type="submit" name="submit" id="both" class="btn btn-default btn-sm" value="Send both" >
                                        </form>
                                        @else
                                        <p class="label label-success label-sm">No resend allowed</p>
                                    @endif
                                    </td> 
                                    <td>{{ $r->firstname }}</td>
                                    <td>{{ $r->lastname }}</td>
                                    <td>{{ $r->email }}</td>
                                    <td>{{ $r->message }}</td>
                                    <td>{{ $r->hphone }}</td>
                                    <td>{{ $r->wphone }}</td>
                                    <td>{{ $r->address }}</td>
                                    <td>{{ $r->zipcode }}</td>
                                    <td>{{ $r->city }}</td>
                                    <td>{{ date('d F Y H:iL:s',strtotime($r->created_at)) }}</td>
                                    <td>{{ date('d F Y H:i:s',strtotime($r->updated_at)) }}</td>
                                    <td>
                                        <form method="POST" action="/superadmin/superemployee/deletsms/{{$r->id}}">
                                            {{csrf_field()}}
                                            <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure, you want to delete this sms details?')">
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
<script>
    function checkreport(number, id) {
        $('#checkreportbutton_' + id).text("Please Wait..");
        document.getElementById("checkreportbutton_" + id).disabled = true;

        var settings = {
            "async": true,
	    "crossDomain": true,
            "url": "https://consentform.com/api/consentsms/getdatathroughnumber.php?token=xyz1234&number=" + number,
            "method": "GET"
        }

        $.ajax(settings).done(function(response) {
            downloadURI(response);
            $('#checkreportbutton_' + id).text("View Consent File");
            document.getElementById("checkreportbutton_" + id).disabled = false;
        });
    }

    function downloadURI(uri) {
        var link = document.createElement("a");
        link.href = uri;
        link.target = "_blank";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        delete link;
    }
</script>
@endpush
