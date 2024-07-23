<?php

use App\Models\Sms;

$url1 = $_SERVER['REQUEST_URI'];

//header("Refresh: 20; URL=$url1");

?>

@extends('employee.layout.app')

@section('title','SMS')

@push('headerscript')

<link href="{{ asset('theme/plugins/bootstrap-sweetalert/sweet-alert.css') }}" rel="stylesheet" type="text/css">

<link href="{{ asset('theme/plugins/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('theme/plugins/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script src="assets/js/jquery.min.js"></script>

<script src="assets/js/bootstrap.min.js"></script>

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

                        <a href="{{ url('employee/sms/create') }}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Add New</a>

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

                                        <th>Consent Form Status</th>

                                        <th>Resend</th>

                                        <th>First Name</th>

                                        <th>Last Name</th>

                                        <th>Email ID</th>

                                        <th>Message</th>

                                        <th>Work Phone Number</th>

                                        <th>Home Phone Number</th>

                                        <th>Address</th>

                                        <th>Zip</th>

                                        <th>City</th>

                                        <th>State</th>

                                        <th>Created At</th>

                                        <th>Updated_at</th>

                                        <th>Action</th>

                                    </tr>

                                </thead>

                                <?php

                                foreach ($sms as $r) {

                                   if ($r->submition_status == 2 && $r->flag == 0) {

                                        if ($r->ipstatus == 'match') {

                                            $data = SMS::where('wphone', $r->wphone)->update(['flag' => '1']);

                                            echo '<script type="text/javascript">'

                                                . '$( document ).ready(function() {'

                                                . '$("#modal").modal("show");'

                                                . '});'

                                                . '</script>'; ?>

                                            <!---================================== open modal ====================================== ------>

                                            <div class="modal fade bs-example-modal-sm" id="modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">

                                                <div class="modal-dialog modal-sm">

                                                    <div class="modal-content">

                                                        <div class="h" style="background-color: #006fff; padding: 10px;">

                                                            <div class="modal-header">

                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                                                                <h4 class="modal-title" id="mySmallModalLabel" style="color: white;font-family: unset;">Completed And Accepted</h4>

                                                            </div>

                                                        </div>

                                                        <div class="b" style="padding: 10px; background-color: aliceblue;margin: 5px;">

                                                            <div class="modal-body" style="font-family: unset;">

                                                                <?php echo nl2br("Name - " . $r->firstname . " \n Email - " . $r->email . " \r\n Mobile Number - " . $r->wphone . " \r\n Consent Form - IP details matched with submitted details"); ?>

                                                            </div>

                                                        </div>

                                                    </div><!-- /.modal-content -->

                                                </div><!-- /.modal-dialog -->

                                            </div><!-- /.modal -->

                                        <?php

                                        } else {

                                            $data = SMS::where('wphone', $r->wphone)->update(['flag' => '1']);

                                            echo '<script type="text/javascript">'

                                                . '$( document ).ready(function() {'

                                                . '$("#modal").modal("show");'

                                                . '});'

                                                . '</script>'; ?>

                                            <!---================================== open modal ====================================== ------>

                                            <div class="modal fade bs-example-modal-sm" id="modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">

                                                <div class="modal-dialog modal-sm">

                                                    <div class="modal-content">

                                                        <div class="h" style="background-color: #006fff; padding: 10px;">

                                                            <div class="modal-header">

                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                                                                <h4 class="modal-title" id="mySmallModalLabel" style="color: white;font-family: unset;">Completed And Accepted</h4>

                                                            </div>

                                                        </div>

                                                        <div class="b" style="padding: 10px; background-color: aliceblue;margin: 5px;">

                                                            <div class="modal-body" style="font-family: unset;">

                                                                <?php echo nl2br("Name - " . $r->firstname . " \n Email - " . $r->email . " \r\n Mobile Number - " . $r->wphone . " \r\n Consent Form - IP details did not match with submitted details"); ?>

                                                            </div>

                                                        </div>

                                                    </div><!-- /.modal-content -->

                                                </div><!-- /.modal-dialog -->

                                            </div><!-- /.modal -->

                                <?php

                                        }

                                        // session()->flash('success_msg', ''.$r->wphone.' has successfully submitted consentform');

                                    }

                                }

                                ?>

                               @foreach($sms as $r)

                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>

                                        @if($r->submition_status==1)<label class="label label-danger">ConsentForm not Completed</label>

                                        @else <label class="label label-success">ConsentForm Completed</label @endif </td>

                                    <td>

                                        @if($r->submition_status==1)

                                        <form method="post" action={{ url("employee/resend",$r->id) }}>

                                            @csrf

                                            <input type="submit" name="submit" id="sms" class="" value="Send SMS" style="width: 70%; font-size: 10px;"><br><br>

                                            <input type="submit" name="submit" id="email" class="" value="Send Email" style="width: 70%; font-size: 10px;"><br><br>

                                            <input type="submit" name="submit" id="both" class="" value="Send both" style="width: 70%; font-size: 10px;">

                                        </form> @endif

                                    </td>

                                    <td>{{ $r->firstname }}</td>

                                    <td>{{ $r->lastname }}</td>

                                    <td>{{ $r->email }}</td>

                                    <td>{{ $r->message }}</td>

                                    <td>{{ $r->wphone }}</td>

                                    <td>{{ $r->hphone }}</td>

                                    <th>{{ $r->address }}</th>

                                    <td>{{ $r->zipcode }}</td>

                                    <td>{{ $r->city }}</td>

                                    <td>{{ $r->state }}</td>

                                    <td>{{ date('d M Y H:i:s',strtotime($r->created_at)) }}</td>

                                    <td>{{ date('d M Y H:i:s',strtotime($r->updated_at)) }}</td>

                                    @if($r->submition_status==1)

                                    <td><a href="{{route('sms.edit',$r->id)}}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a></td>

                                    @else

                                    <td><label class="label label-success">Editing is not allowed</label></td>

                                    @endif

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
